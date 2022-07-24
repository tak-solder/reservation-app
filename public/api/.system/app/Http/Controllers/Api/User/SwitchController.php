<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * TODO #1 LINE組み込み時に削除
 * @deprecated
 */
class SwitchController extends ApiController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $userId = filter_var($request->query->get('userId'), FILTER_VALIDATE_INT);
        if ($userId) {
            $request->session()->put('userId', $userId);
        } else {
            $request->session()->forget('userId');
        }

        return redirect(config('app.url'));
    }
}
