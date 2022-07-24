<?php

namespace Domain\Infrastructures\Mock\Repositories;

use Carbon\CarbonImmutable;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\Event\EventRepositoryInterface;
use Domain\Domains\Entities\Event\Location\EventLocation;
use Domain\Domains\Entities\EventOption\ExtraTimeOption;
use Domain\Domains\Entities\EventOption\ItemOption;
use Domain\Domains\Entities\Reservation\ReservationRepositoryInterface;
use Domain\Domains\ValueObject\Event\ApplicationStatus;
use Domain\Domains\ValueObject\Event\EventStatus;
use Domain\Domains\ValueObject\Event\LocationType;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Domain\Exceptions\InconsistencyException;
use Domain\Infrastructures\Mock\Utilities\CollectionQueries;
use Illuminate\Support\Collection;

class MockEventRepository implements EventRepositoryInterface
{
    use CollectionQueries;

    public function __construct()
    {
        $today = CarbonImmutable::today();
        if ($this->load()) {
            return;
        }

        $this->collection = new Collection([
            new Event(
                1,
                '定期演奏会',
                '月1恒例の定期演奏会です。一人14分の演奏時間があります。',
                $today->addDays()->setHours(14),
                $today->addDays()->setHours(15)->setMinutes(30),
                new EventLocation(
                    LocationType::REAL(),
                    '練習室（文京区)',
                    '個人宅内の練習室です。お申し込み後に表示される住所までお越しください。',
                    true,
                    '東京都文京区後楽',
                    '東京都文京区後楽1-3-61',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                4,
                1650,
                2,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 0]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 2]),
                ]),
            ),
            new Event(
                2,
                '定期演奏会',
                '月1恒例の定期演奏会です。一人14分の演奏時間があります。',
                $today->addDays()->setHours(16),
                $today->addDays()->setHours(17)->setMinutes(30),
                new EventLocation(
                    LocationType::REAL(),
                    '練習室（文京区）',
                    '個人宅内の練習室です。お申し込み後に表示される住所までお越しください。',
                    true,
                    '東京都文京区後楽',
                    '東京都文京区後楽1-3-61',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                0,
                1650,
                6,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 0]),
                ]),
            ),
            new Event(
                3,
                '定期演奏会',
                '月1恒例の定期演奏会です。一人14分の演奏時間があります。',
                $today->addDays()->setHours(18),
                $today->addDays()->setHours(19)->setMinutes(30),
                new EventLocation(
                    LocationType::REAL(),
                    '練習室（文京区）',
                    '個人宅内の練習室です。お申し込み後に表示される住所までお越しください。',
                    true,
                    '東京都文京区後楽',
                    '東京都文京区後楽1-3-61',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                1,
                1650,
                5,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 1]),
                ]),
            ),
            new Event(
                4,
                '定期演奏会',
                '月1恒例の定期演奏会です。一人14分の演奏時間があります。',
                $today->addDays()->setHours(20),
                $today->addDays()->setHours(21)->setMinutes(30),
                new EventLocation(
                    LocationType::REAL(),
                    '練習室（文京区）',
                    '個人宅内の練習室です。お申し込み後に表示される住所までお越しください。',
                    true,
                    '東京都文京区後楽',
                    '東京都文京区後楽1-3-61',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                1,
                1650,
                6,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 0]),
                ]),
            ),
            new Event(
                5,
                '定期オンライン演奏会',
                '月1恒例の定期演奏会です。Zoomを繋いでご自宅などから演奏することができます。',
                $today->addDays(2)->setHours(14),
                $today->addDays(2)->setHours(15)->setMinutes(30),
                new EventLocation(
                    LocationType::ONLINE(),
                    'オンライン（Zoom）',
                    'お申し込み後に表示されるZoomのURLから、イベント開始5分前にご入室ください。',
                    true,
                    null,
                    'https://zoom.us/example1',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                4,
                1650,
                2,
                new Collection(),
            ),
            new Event(
                6,
                '定期オンライン演奏会',
                '月1恒例の定期演奏会です。Zoomを繋いでご自宅などから演奏することができます。',
                $today->addDays(2)->setHours(16),
                $today->addDays(2)->setHours(17)->setMinutes(30),
                new EventLocation(
                    LocationType::ONLINE(),
                    'オンライン（Zoom）',
                    'お申し込み後に表示されるZoomのURLから、イベント開始5分前にご入室ください。',
                    true,
                    null,
                    'https://zoom.us/example2',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                0,
                1650,
                6,
                new Collection([]),
            ),
            new Event(
                7,
                '定期オンライン演奏会',
                '月1恒例の定期演奏会です。Zoomを繋いでご自宅などから演奏することができます。',
                $today->addDays(2)->setHours(18),
                $today->addDays(2)->setHours(19)->setMinutes(30),
                new EventLocation(
                    LocationType::ONLINE(),
                    'オンライン（Zoom）',
                    'お申し込み後に表示されるZoomのURLから、イベント開始5分前にご入室ください。',
                    true,
                    null,
                    'https://zoom.us/example3',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                1,
                1650,
                5,
                new Collection([]),
            ),
            new Event(
                8,
                '定期オンライン演奏会',
                '月1恒例の定期演奏会です。Zoomを繋いでご自宅などから演奏することができます。',
                $today->addDays(2)->setHours(20),
                $today->addDays(2)->setHours(21)->setMinutes(30),
                new EventLocation(
                    LocationType::ONLINE(),
                    'オンライン（Zoom）',
                    'お申し込み後に表示されるZoomのURLから、イベント開始5分前にご入室ください。',
                    true,
                    null,
                    'https://zoom.us/example4',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                1,
                1650,
                6,
                new Collection([]),
            ),
            new Event(
                9,
                '定期オンライン演奏会',
                '月1恒例の定期演奏会です。Zoomを繋いでご自宅などから演奏することができます。',
                $today->subDays()->setHours(20),
                $today->subDays()->setHours(21)->setMinutes(30),
                new EventLocation(
                    LocationType::ONLINE(),
                    'オンライン（Zoom）',
                    'お申し込み後に表示されるZoomのURLから、イベント開始5分前にご入室ください。',
                    true,
                    null,
                    'https://zoom.us/example5',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                0,
                1650,
                6,
                new Collection([]),
            ),
            new Event(
                10,
                '定期演奏会',
                '月1恒例の定期演奏会です。一人14分の演奏時間があります。',
                $today->subDays(2)->setHours(20),
                $today->subDays(2)->setHours(21)->setMinutes(30),
                new EventLocation(
                    LocationType::REAL(),
                    '練習室（文京区）',
                    '個人宅内の練習室です。お申し込み後に表示される住所までお越しください。',
                    true,
                    '東京都文京区後楽',
                    '東京都文京区後楽1-3-61',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                1,
                1650,
                6,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 0]),
                ]),
            ),
            new Event(
                11,
                'ハロウィーン演奏会',
                "コース料理・飲み放題付き。\n一人10分の演奏時間とフリータイムがあります。",
                $today->setMonths(10)->setDay(30)->setHours(19),
                $today->setMonths(10)->setDay(30)->setHours(21),
                new EventLocation(
                    LocationType::REAL(),
                    '東京ディズニーランド',
                    '舞浜駅から歩いてすぐ。シンデレラ城前に集合です。',
                    false,
                    '千葉県浦安市舞浜1-1',
                    null,
                    'https://www.tokyodisneyresort.jp/tdl/'
                ),
                EventStatus::SCHEDULED(),
                5,
                4,
                5500,
                2,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 2]),
                ]),
            ),
            new Event(
                12,
                'キャンセル全額返金テスト用',
                '月1恒例の定期演奏会です。一人14分の演奏時間があります。',
                $today->addDays(10)->setHours(14),
                $today->addDays(10)->setHours(15)->setMinutes(30),
                new EventLocation(
                    LocationType::REAL(),
                    '練習室（文京区）',
                    '個人宅内の練習室です。お申し込み後に表示される住所までお越しください。',
                    true,
                    '東京都文京区後楽',
                    '東京都文京区後楽1-3-61',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                4,
                1650,
                2,
                new Collection([
                    new ItemOption(['key' => 'musicStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'duetChair', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'mic', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'micStand', 'cost' => 110, 'quantity' => 1]),
                    new ItemOption(['key' => 'videoData', 'cost' => 110, 'quantity' => 1]),
                    new ExtraTimeOption(['minutes' => 7, 'cost' => 825, 'quantity' => 2]),
                ]),
            ),
            new Event(
                13,
                'キャンセル一部返金テスト用',
                '月1恒例の定期演奏会です。Zoomを繋いでご自宅などから演奏することができます。',
                $today->addDays(5)->setHours(14),
                $today->addDays(5)->setHours(15)->setMinutes(30),
                new EventLocation(
                    LocationType::ONLINE(),
                    'オンライン（Zoom）',
                    'お申し込み後に表示されるZoomのURLから、イベント開始5分前にご入室ください。',
                    true,
                    null,
                    'https://zoom.us/example7',
                    null
                ),
                EventStatus::SCHEDULED(),
                5,
                3,
                1650,
                6,
                new Collection([]),
            ),
        ]);
    }

    /**
     * @param int $id
     * @return Event|null
     */
    public function findById(int $id, ?int $userId = null): ?Event
    {
        $event = $this->find(fn(Event $event) => $event->getId() === $id);
        if (!$event) {
            return null;
        }
        if (!$userId) {
            return clone $event;
        }

        return $this->setApplicationStatuses(new Collection([$event]), $userId)->first();
    }

    public function getEvents(
        ?CarbonImmutable $fromDate,
        ?CarbonImmutable $toDate,
        ?EventStatus $status,
        ?int $userId = null
    ): Collection {
        return $this->setApplicationStatuses(
            $this->filter(function (Event $event) use ($fromDate, $toDate, $status) {
                if ($fromDate && $event->getStartDate()->lt($fromDate)) {
                    return false;
                }
                if ($toDate && $event->getEndDate()->gt($toDate)) {
                    return false;
                }
                if ($status && $event->getStatus()->getValue() !== $status->getValue()) {
                    return false;
                }

                return true;
            }, 'startDate'),
            $userId
        );
    }

    public function updateReservationStatus(Event $event): void
    {
        $original = $this->findById($event->getId());
        if (!$original || $original->getRevision() !== $event->getRevision()) {
            throw new InconsistencyException("予約状況に変更がありました");
        }

        $event->setRevision($event->getRevision() + 1);
        $original->setRevision($event->getRevision());
        $original->setRemain($event->getRemain());
        $original->setOptions($event->getOptions());
        $this->replaceEntity($original->getId(), $original);
        $this->persistence();
    }

    private function setApplicationStatuses(Collection $events, ?int $userId): Collection
    {
        /**
         * @var ReservationRepositoryInterface $reservationRepository
         */
        $reservationRepository = app(ReservationRepositoryInterface::class);

        return $events->map(function (Event $event) use ($reservationRepository, $userId) {
            $clone = clone $event;
            if ($userId) {
                $reservation = $reservationRepository->findAvailableReservation($userId, $clone->getId());
                if (
                    $reservation
                    && ($reservation->getStatus()->equals(ReservationStatus::APPLIED()) || $reservation->getStatus()->equals(ReservationStatus::FINISHED()))
                ) {
                    $clone->setApplicationStatus(ApplicationStatus::APPLIED());
                } elseif ($clone->getStartDate()->isFuture() && $clone->getRemain() > 0) {
                    $clone->setApplicationStatus(ApplicationStatus::AVAILABLE());
                } else {
                    $clone->setApplicationStatus(ApplicationStatus::UNAVAILABLE());
                }
            } else {
                $clone->setApplicationStatus(null);
            }
            return $clone;
        })->values();
    }
}
