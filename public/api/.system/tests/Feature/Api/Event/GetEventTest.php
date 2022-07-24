<?php

namespace Tests\Feature\Api\Event;

use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Tests\TestCase;

class GetEventTest extends TestCase
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
    public function GetEvent_IDを指定してイベントを取得(): void
    {
        $query = http_build_query(['id' => 1]);
        $response = $this->get("/v1/event/get-event?{$query}");
        $response->assertStatus(200)
            ->assertJson([
                'event' => ['title' => '定期演奏会']
            ]);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function GetEvent_存在しないイベントIDの場合、中身がnullになる(): void
    {
        $query = http_build_query(['id' => 100]);
        $response = $this->get("/v1/event/get-event?{$query}");
        $response->assertStatus(200)
            ->assertJson([
                'event' => null
            ]);
    }
}
