<?php

namespace App\Presenters\Payment;

use Domain\UseCases\Outputs\Payment\CallbackOutput;
use Illuminate\Contracts\Support\Responsable;

class CallbackPresenter implements Responsable
{
    protected CallbackOutput $output;

    public function __construct(CallbackOutput $output)
    {
        $this->output = $output;
    }

    public function toResponse($request)
    {
        return redirect(app_url('/reservation/complete'))
            ->with('paymentId', $this->output->getPayment()->getId());
    }
}
