<?php

declare(strict_types=1);

namespace Syntelix\Vessel\Application\Register;

use Syntelix\Common\Domain\Bus\Command\Command;
use Syntelix\Common\Domain\VO\NonEmptyString;
use Syntelix\Vessel\Domain\VO\IMONumber;

readonly class RegisterVesselCommand implements Command
{
    public function __construct(
        private IMONumber      $imoNumber,
        private NonEmptyString $name
    )
    {}

    public static function fromCreate(IMONumber $imoNumber, NonEmptyString $name): RegisterVesselCommand
    {
        return new self($imoNumber, $name);
    }

    public function imoNumber(): string
    {
        return $this->imoNumber->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }
}