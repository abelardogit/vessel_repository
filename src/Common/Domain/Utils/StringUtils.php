<?php

declare(strict_types=1);


namespace Syntelix\Common\Domain\Utils;

class StringUtils
{

    /**
     * @param string $aString
     * @param int $posFromEnd default to 1
     * @return int
     */
    public static function getNDigitFromANumberStringized(string $aString, int $posFromEnd = 1): int
    {
        return (int) $aString[strlen($aString) - $posFromEnd];
    }
}