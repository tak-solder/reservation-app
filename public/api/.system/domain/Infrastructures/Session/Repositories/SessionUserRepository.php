<?php

namespace Domain\Infrastructures\Session\Repositories;

use Domain\Infrastructures\Mock\Repositories\MockUserRepository;
use Domain\Infrastructures\Session\Utilities\SaveSession;

class SessionUserRepository extends MockUserRepository
{
    use SaveSession;
}
