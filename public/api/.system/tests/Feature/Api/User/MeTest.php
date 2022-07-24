<?php

namespace Tests\Feature\Api\User;

use Domain\Domains\Entities\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Factory;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MeTest extends TestCase
{
    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function Me_ログイン中は正常にユーザー情報が取得可能(): void
    {
        $user = app(UserRepositoryInterface::class)->findById(1);
        $this->app->make(Factory::class)->guard()->setUser($user);

        $response = $this->get('/v1/user/me');
        $response->assertStatus(200)
            ->assertJson([
                'user' => ['lineId' => 'user1']
            ]);
    }

    /**
     * @test
     * @noinspection NonAsciiCharacters
     */
    public function Me_未ログイン時はForbiddenを返す(): void
    {
        $response = $this->get('/v1/user/me');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
