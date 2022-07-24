<?php

namespace Tests\Feature\Api\Event;

use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Tests\TestCase;

class GetEventsTest extends TestCase
{
    private User $loginUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginUser = app(UserRepositoryInterface::class)->findById(1);
        $this->app->make(Factory::class)->guard()->setUser($this->loginUser);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function GetEvents_イベント全件を取得(): void
    {
        $response = $this->get("/v1/event/get-events");
        $response->assertStatus(200)
            ->assertJsonCount(13, 'events');
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function GetEvents_開始時刻が現在以降のイベント一覧を取得(): void
    {
        $query = http_build_query(['fromDate' => now()->format('Y-m-d H:i:s')]);
        $response = $this->get("/v1/event/get-events?{$query}");
        $response->assertStatus(200)
            ->assertJsonCount(11, 'events');
    }
}
