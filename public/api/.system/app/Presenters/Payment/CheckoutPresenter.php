<?php

namespace App\Presenters\Payment;

use App\Presenters\JsonPresenter;
use Domain\UseCases\Outputs\OutputInterface;
use Domain\UseCases\Outputs\Payment\CheckoutOutput;

class CheckoutPresenter extends JsonPresenter
{
    /**
     * @var CheckoutOutput
     */
    protected OutputInterface $output;

    public function __construct(CheckoutOutput $output)
    {
        parent::__construct($output);
    }

    public function getResponseData(): array
    {
        return [
            'url' => $this->output->getCheckoutData()->getCheckoutUrl(),
        ];
    }
}
