<?php

namespace Tests\Unit\Domain\Domains\DomainService\Event;

use Domain\Domains\DomainService\Event\EventService;
use Domain\Domains\Entities\Event\Event;
use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Exceptions\NotFoundEntityException;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    private EventService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(EventService::class);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findEvent_存在するイベントの取得(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        $event = $this->service->findEvent(1, $user->getId());
        $this->assertInstanceOf(Event::class, $event);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function findEvent_存在しないイベントの取得時にNotFoundEntityExceptionが投げられる(): void
    {
        /** @var User $user */
        $user = $this->app->make(UserRepositoryInterface::class)->findById(1);
        $this->expectException(NotFoundEntityException::class);
        $this->service->findEvent(100, $user->getId());
    }
}
