<?php

namespace Domain\Infrastructures\Session\Repositories;

use Domain\Infrastructures\Mock\Repositories\MockReservationRepository;
use Domain\Infrastructures\Session\Utilities\SaveSession;

class SessionReservationRepository extends MockReservationRepository
{
    use SaveSession;
}
