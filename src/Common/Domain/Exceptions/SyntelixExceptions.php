<?php

declare(strict_types=1);


namespace Syntelix\Common\Domain\Exceptions;

use Exception;

class SyntelixExceptions extends Exception
{

    private const string DATA_MALFORMED = "Data malformed. Missing 'msg' or 'isOk' fields.";
    private function __construct(string $msg)
    {
        parent::__construct($msg);
    }

    /**
     * @throws SyntelixExceptions
     */
    public static function fromCreate(string $msg): self
    {
        throw new self($msg);
    }

    /**
     * @throws SyntelixExceptions
     */
    public static function fromMalFormedData(): self
    {
        throw new self(SyntelixExceptions::DATA_MALFORMED);
    }
}