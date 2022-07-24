<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Presenters\User\MePresenter;

class MeController extends ApiController
{
    public function __invoke(): MePresenter
    {
        $user = auth()->user();
        return new MePresenter($user);
    }
}
