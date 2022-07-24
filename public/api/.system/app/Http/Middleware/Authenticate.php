<?php

namespace App\Http\Middleware;

use App\Presenters\Error\ErrorJsonPresenter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|ErrorJsonPresenter
     */
    public function handle(Request $request, \Closure $next)
    {
        if (config('auth.defaults.guard') === 'mock' && $request->path() === 'v1/user/switch') {
            // TODO #1 LINE組み込み時に削除
            return $next($request);
        }

        if (auth()->guest()) {
            return new ErrorJsonPresenter("ユーザー認証に失敗しました。\n右上のユーザーアイコンからユーザーを変更してください。", Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
