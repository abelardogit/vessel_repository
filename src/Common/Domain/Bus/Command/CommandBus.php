<?php

declare(strict_types=1);

namespace Syntelix\Common\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}