<?php

namespace Tests\Unit\Domain\Domains\DomainService\Reservation;

use Domain\Domains\DomainService\Reservation\ReservationService;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Domains\Entities\Reservation\Reservation;
use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\Exceptions\NotFoundEntityException;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ReservationServiceTest extends TestCase
{
    private ReservationService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ReservationService::class);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findAvailableReservation_有効な予約を取得する(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        /** @var Event $event */
        $event = $this->app->make(EventRepositoryInterface::class)->findById(9);

        $reservation = $this->service->findAvailableReservation($user, $event);
        $this->assertInstanceOf(Reservation::class, $reservation);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findAvailableReservation_キャンセル済みの予約は取得せず、NotFoundEntityExceptionになる(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        /** @var Event $event */
        $event = $this->app->make(EventRepositoryInterface::class)->findById(10);

        $this->expectException(NotFoundEntityException::class);
        $this->service->findAvailableReservation($user, $event);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findByReservationId_予約IDから予約データを取得する(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);

        $reservation = $this->service->findByReservationId($user, 1);
        $this->assertInstanceOf(Reservation::class, $reservation);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findByReservationId_他のユーザーが予約IDから予約データを取得すると、NotFoundEntityExceptionが投げられる(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(2);

        $this->expectException(NotFoundEntityException::class);
        $this->service->findByReservationId($user, 1);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function getReservations_予約一覧を取得する(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);

        $reservations = $this->service->getReservations($user, null, 10, 0);
        $this->assertInstanceOf(Collection::class, $reservations);
        $this->assertEquals(2, $reservations->count());
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function getReservations_予約状態を指定して予約一覧を取得する(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);

        $reservations = $this->service->getReservations($user, ReservationStatus::FINISHED(), 10, 0);
        $this->assertInstanceOf(Collection::class, $reservations);
        $this->assertEquals(1, $reservations->count());
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findByPayment_決済IDから予約データを取得する(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);

        $reservation = $this->service->findByPayment($user, 3);
        $this->assertInstanceOf(Reservation::class, $reservation);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function canReserve_予約可能なイベントはtrueを返す(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        /** @var Event $event */
        $event = $this->app->make(EventRepositoryInterface::class)->findById(1);

        $result = $this->service->canReserve($user, $event);
        $this->assertTrue($result);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function canReserve_予約枠が定員のイベントはfalseを返す(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        /** @var Event $event */
        $event = $this->app->make(EventRepositoryInterface::class)->findById(2);

        $result = $this->service->canReserve($user, $event);
        $this->assertFalse($result);
    }
}
