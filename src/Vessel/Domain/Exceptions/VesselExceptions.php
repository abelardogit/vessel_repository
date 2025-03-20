<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Domain\Exceptions;

use Symfony\Component\Config\Definition\Exception\Exception;

class VesselExceptions extends Exception
{

    const IMO_NOT_VALID_PLACEHOLDER = "IMO is not valid (provided: {IMO_USER})";
    const  NAME_NOT_VALID = "Name is not valid";
    const  BAD_FORMAT_REQUEST = 400;

    /**
     * @param string $msg
     */
    public function __construct(string $msg, int $code)
    {
        parent::__construct($msg, $code);
    }

    public static function fromIMOInvalid(string $anIMO): VesselExceptions
    {
        $msg = str_replace("{IMO_USER}",
            $anIMO,
            VesselExceptions::IMO_NOT_VALID_PLACEHOLDER
        );
        throw new VesselExceptions($msg, self::BAD_FORMAT_REQUEST);
    }

    public static function fromNameEmpty(): VesselExceptions
    {
        throw new VesselExceptions(
            VesselExceptions::NAME_NOT_VALID,
            self::BAD_FORMAT_REQUEST
        );
    }
}