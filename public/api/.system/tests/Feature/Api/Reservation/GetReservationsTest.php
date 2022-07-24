<?php

namespace Tests\Feature\Api\Reservation;

use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Domains\ValueObject\Reservation\ReservationStatus;
use Illuminate\Contracts\Auth\Factory;
use Tests\TestCase;

class GetReservationsTest extends TestCase
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
    public function GetEvents_予約中のイベントのみ取得（該当なし）(): void
    {
        $query = http_build_query(['status' => ReservationStatus::APPLIED()->getValue()]);
        $response = $this->get("/v1/reservation/get-reservations?{$query}");
        $response->assertStatus(200)
            ->assertJsonCount(0, 'reservations');
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function GetReservations_開催済みのイベントのみ取得(): void
    {
        $query = http_build_query(['status' => ReservationStatus::FINISHED()->getValue()]);
        $response = $this->get("/v1/reservation/get-reservations?{$query}");
        $response->assertStatus(200)
            ->assertJsonCount(1, 'reservations');
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function GetReservations_キャンセル済みのイベントのみ取得(): void
    {
        $query = http_build_query(['status' => ReservationStatus::CANCELED()->getValue()]);
        $response = $this->get("/v1/reservation/get-reservations?{$query}");
        $response->assertStatus(200)
            ->assertJsonCount(1, 'reservations');
    }
}
