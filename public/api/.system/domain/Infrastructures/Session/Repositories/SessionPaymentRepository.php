<?php

namespace Domain\Infrastructures\Session\Repositories;

use Domain\Infrastructures\Mock\Repositories\MockPaymentRepository;
use Domain\Infrastructures\Session\Utilities\SaveSession;

class SessionPaymentRepository extends MockPaymentRepository
{
    use SaveSession;
}
