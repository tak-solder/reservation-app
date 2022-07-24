<?php

use Domain\Domains\ValueObject\Payment\Item\PaymentItemType;

if (env('APP_ENV') === 'production') {
    // TODO プロダクション用のproductsを用意する
    throw new \Exception("本番用の設定ファイルが準備されていません");
} else {
    return [
        'stripe' => [
            'products' => [
                PaymentItemType::ENTRY()->getKey() => 'prod_LgfQn9x5khlCLn',
                PaymentItemType::EXTRA_TIME()->getKey() => 'prod_LshyQ9aIlmhlfP',
            ]
        ]
    ];

}
