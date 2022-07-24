<?php

namespace Domain\Infrastructures\Session\Repositories;

use Domain\Infrastructures\Mock\Repositories\MockEventRepository;
use Domain\Infrastructures\Session\Utilities\SaveSession;

class SessionEventRepository extends MockEventRepository
{
    use SaveSession;
}
