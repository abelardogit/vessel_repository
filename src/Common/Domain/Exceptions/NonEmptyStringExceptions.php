<?php

declare(strict_types=1);


namespace Syntelix\Common\Domain\Exceptions;

use Symfony\Component\Config\Definition\Exception\Exception;

class NonEmptyStringExceptions extends Exception
{

    const string EMPTY_STRING = "String is empty";

    /**
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        parent::__construct($msg);
    }

    public static function fromEmptyString(): NonEmptyStringExceptions
    {
        throw new NonEmptyStringExceptions(NonEmptyStringExceptions::EMPTY_STRING);
    }
}