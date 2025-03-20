<?php

namespace Syntelix\Vessel\Application;

use Syntelix\Vessel\Application\Register\RegisterVesselCommand;

interface CommandHandlerInterface
{
    public function execute(RegisterVesselCommand $command);
}