<?php

declare(strict_types=1);


namespace Syntelix\Common\Domain\VO;

use Syntelix\Common\Domain\Errors\SyntelixResponse;
use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Common\Domain\Validators\SanitizeValidator;

class NonEmptyString
{
    private string $value;

    /**
     * @throws SyntelixExceptions
     */
    private function __construct(string $aValue)
    {
        $this->checkStringNoEmptyOrFail($aValue);
        $this->value = $aValue;
    }

    /**
     * @throws SyntelixExceptions
     */
    public static function fromCreate(string $aString): NonEmptyString
    {
        return new self($aString);
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws SyntelixExceptions
     */
    private function checkStringNoEmptyOrFail(string $aValue): void
    {
        if (SanitizeValidator::isEmptyString($aValue)) {
            throw SyntelixExceptions::fromMalFormedData();
        }
    }
}