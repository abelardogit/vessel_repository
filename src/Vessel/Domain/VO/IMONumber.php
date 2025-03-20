<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Domain\VO;

use Syntelix\Common\Domain\Errors\SyntelixResponse;
use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Common\Domain\VO\NonEmptyString;
use Syntelix\Vessel\Domain\Validators\IMOValidator;
use Syntelix\Vessel\Infrastructure\API\Responders\RegisterVesselResponder;

class IMONumber
{
    private string $value;
    private function __construct(string $anIMONumber)
    {
        $this->value = $anIMONumber;
    }

    /**
     * @throws SyntelixExceptions
     */
    public static function fromCreate(string $anIMONumber): self
    {
        $isAnIMONumberValid = IMOValidator::checkIMOValidOrFail($anIMONumber);
        if (!$isAnIMONumberValid) {
            throw SyntelixExceptions::fromMalFormedData();
        }
        return new self($anIMONumber);
    }

    public function value(): string
    {
        return $this->value;
    }
}