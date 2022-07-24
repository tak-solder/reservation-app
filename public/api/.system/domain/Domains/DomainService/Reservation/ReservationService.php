<?php

namespace Domain\Domains\DomainService\Reservation;

use Carbon\CarbonImmutable;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Domains\Entities\EventOption\EventOption;
use Domain\Domains\Entities\EventOption\Utils\QuantityOptionInterface;
use Domain\Domains\Entities\Payment\Order\Order;
use Domain\Domains\Entities\Payment\Payment;
use Domain\Domains\Entities\Reservation\Cancel\CancelQuotation;
use Domain\Domains\Entities\Reservation\Options\ReservationOption;
use Domain\Domains\Entities\Reservation\Reservation;
use Domain\Domains\Entities\Reservation\ReservationRepositoryInterface;
use Domain\Domains\Entities\User\User;
use Domain\Domains\ValueObject\Event\EventStatus;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\Exceptions\InconsistencyException;
use Domain\Exceptions\NotFoundEntityException;
use Illuminate\Support\Collection;

class ReservationService
{
    private EventRepositoryInterface $eventRepository;
    private ReservationRepositoryInterface $reservationRepository;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        ReservationRepositoryInterface $reservationRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @param User $user
     * @param Event $event
     * @return Reservation
     * @throws NotFoundEntityException
     */
    public function findAvailableReservation(User $user, Event $event): Reservation
    {
        $userId = $user->getId();
        $eventId = $event->getId();
        $reservation = $this->reservationRepository->findAvailableReservation($userId, $eventId);
        if (!$reservation) {
            throw new NotFoundEntityException(Reservation::class, compact('userId', 'eventId'));
        }

        return $reservation;
    }

    /**
     * @param User $user
     * @param int $reservationId
     * @return Reservation
     * @throws NotFoundEntityException
     */
    public function findByReservationId(User $user, int $reservationId): Reservation
    {
        $reservation = $this->reservationRepository->findById($reservationId);
        $userId = $user->getId();
        if (!$reservation || $reservation->getUserId() !== $userId) {
            throw new NotFoundEntityException(Reservation::class, compact('reservationId', 'userId'));
        }

        return $reservation;
    }

    public function getReservations(
        User $user,
        ?ReservationStatus $status,
        int $limit,
        int $offset
    ): Collection {
        return $this->reservationRepository->getReservations(
            $user->getId(),
            $status,
            $limit,
            $offset
        );
    }

    /**
     * @param User $user
     * @param int $paymentId
     * @return Reservation
     * @throws NotFoundEntityException
     */
    public function findByPayment(User $user, int $paymentId): Reservation
    {
        $reservations = $this->reservationRepository->getByPaymentId($paymentId);
        if ($reservations->isEmpty()) {
            throw new NotFoundEntityException(Reservation::class, compact('paymentId'));
        }
        if ($reservations->count() > 1) {
            $prev = new \Exception("userId: {$user->getId()}, paymentId: {$paymentId}");
            throw new \UnexpectedValueException("1決済で複数の予約がある場合は処理できません", 0, $prev);
        }
        /** @var Reservation $reservation */
        $reservation = $reservations->first();

        $userId = $user->getId();
        if ($reservation->getUserId() !== $userId) {
            throw new NotFoundEntityException(Reservation::class, compact('paymentId', 'userId'));
        }

        return $reservation;
    }

    /**
     * @param User $user
     * @param Payment $payment
     * @param Event $event
     * @param Collection $reservationOptions
     * @return Reservation
     * @throws InconsistencyException
     * @throws \Domain\Exceptions\InvalidValueException
     */
    public function reserve(User $user, Payment $payment, Event $event, Collection $reservationOptions): Reservation
    {
        if (!$this->canReserve($user, $event)) {
            throw new InconsistencyException("このイベントは予約できません");
        }

        $options = $event->getOptions()->map(function (EventOption $option) use ($reservationOptions) {
            $reservationOption = $reservationOptions->get($option->getKey());
            if (!($reservationOption instanceof ReservationOption)) {
                return $option;
            }

            if ($option instanceof QuantityOptionInterface) {
                $optionValue = intval($reservationOption->getValue());

                if ($option->getQuantity() < $optionValue) {
                    throw new InconsistencyException("{$option->getName()}の購入数が上限を超えています");
                }
                $option->setQuantity($option->getQuantity() - $optionValue);

                return $option;
            }

            return $option;
        });
        $event->setOptions($options);
        $event->setRemain($event->getRemain() - 1);

        $this->eventRepository->updateReservationStatus($event);

        /** @var Order $order */
        $order = $payment->getOrders()->first(fn(Order $order) => $order->getEventId() === $event->getId());
        $amount = $order->getAmount();

        return $this->reservationRepository->createReservation($event, $user->getId(), $payment->getId(), $amount, ReservationStatus::APPLIED(), $reservationOptions);
    }

    /**
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function canReserve(User $user, Event $event): bool
    {
        if (!$event->getStatus()->equals(EventStatus::SCHEDULED())) {
            return false;
        }
        if ($event->getRemain() < 1) {
            return false;
        }
        if ($event->getStartDate()->lt(CarbonImmutable::now()->subHours())) {
            return false;
        }

        try {
            $this->findAvailableReservation($user, $event);
        } catch (NotFoundEntityException $e) {
            // "NotFoundEntityException＝予約がない"のでtrue
            return true;
        }

        return false;
    }

    /**
     * @param Reservation $reservation
     * @param CancelQuotation $cancelQuotation
     * @return void
     * @throws InconsistencyException
     * @throws \Domain\Exceptions\InvalidValueException
     */
    public function cancel(Reservation $reservation, CancelQuotation $cancelQuotation): void
    {
        $event = $reservation->getEvent();
        if (
            !$reservation->getStatus()->equals(ReservationStatus::APPLIED())
            || $event->getStartDate()->isPast()
        ) {
            throw new InconsistencyException('そのイベントはキャンセルできません');
        }

        // 予約枠の解放
        $event = $reservation->getEvent();
        $reservationOptions = $reservation->getReservationOptions();
        $options = $event->getOptions()->map(function (EventOption $option) use ($reservationOptions) {
            if (!($option instanceof QuantityOptionInterface)) {
                return $option;
            }

            $reservationOption = $reservationOptions->get($option->getKey());
            if (!($reservationOption instanceof ReservationOption)) {
                return $option;
            }
            $optionValue = intval($reservationOption->getValue());
            $option->setQuantity($option->getQuantity() + $optionValue);

            return $option;
        });

        $event->setOptions($options);
        $event->setRemain($event->getRemain() + 1);
        $this->eventRepository->updateReservationStatus($event);

        // 予約状態の変更
        $reservation->setStatus(ReservationStatus::CANCELED());
        $reservation->setRefund($cancelQuotation->getCancelRefund());
        $this->reservationRepository->saveReservation($reservation);
    }
}
