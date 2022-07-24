<?php

namespace Tests\Feature\Api\Payment;

use Domain\Domains\Entities\User\User;
use Domain\Domains\Entities\User\UserRepositoryInterface;
use Domain\Domains\ValueObject\EventOption\OptionKey;
use Domain\Domains\ValueObject\Payment\PaymentProvider;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    private User $loginUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginUser = app(UserRepositoryInterface::class)->findById(1);
        $this->app->make(Factory::class)->guard()->setUser($this->loginUser);
    }

      // 外部APIを実行するため、普段はコメントアウト
//    /**
//     * @test
//     * @noinspection NonAsciiCharacters
//     */
//    public function Checkout_正しいリクエストで決済URL発行可能(): void
//    {
//        $postData = [
//            'provider' => PaymentProvider::STRIPE()->getValue(),
//            'order' => [
//                'eventId' => 1,
//                'optionValues' => [
//                    OptionKey::EXTRA_TIME()->getValue() => 2,
//                    OptionKey::MUSIC_STAND()->getValue() => true,
//                ]
//            ]
//        ];
//        $response = $this->post("/v1/payment/checkout", $postData);
//        $response->assertStatus(200)
//            ->assertJson(fn (AssertableJson $json) => $json->has('url'));
//    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function Checkout_予約できないイベントの予約で409エラー(): void
    {
        $postData = [
            'provider' => PaymentProvider::STRIPE()->getValue(),
            'order' => [
                'eventId' => 2,
                'optionValues' => []
            ]
        ];
        $response = $this->post("/v1/payment/checkout", $postData);
        $response->assertStatus(409);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function Checkout_GETメソッドでアクセスしたらMethodNotAllowedになる(): void
    {
        $response = $this->get("/v1/payment/checkout");
        $response->assertStatus(405);
    }
}
