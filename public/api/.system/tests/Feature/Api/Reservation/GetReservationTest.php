<?php

namespace Tests\Feature\Api\Reservation;

use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Tests\TestCase;

class GetReservationTest extends TestCase
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
    public function GetReservation_IDを指定してイベントを取得(): void
    {
        $query = http_build_query(['id' => 1]);
        $response = $this->get("/v1/reservation/get-reservation?{$query}");
        $response->assertStatus(200)
            ->assertJson(['reservation' => ['event' => ['id' => 9]]]);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function GetReservation_他の人の予約IDを指定すると、404エラーになる(): void
    {
        $query = http_build_query(['id' => 3]);
        $response = $this->get("/v1/reservation/get-reservation?{$query}");
        $response->assertStatus(404);
    }
}
