<?php

namespace Domain\Infrastructures\Session\Repositories;

use Domain\Infrastructures\Mock\Repositories\MockPaymentItemRepository;
use Domain\Infrastructures\Session\Utilities\SaveSession;

class SessionPaymentItemRepository extends MockPaymentItemRepository
{
    use SaveSession;
}
