<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Domain\Validators;

use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Common\Domain\Utils\StringUtils;
use Syntelix\Vessel\Domain\Exceptions\VesselExceptions;

class IMOValidator
{
    private const  PREFIX = "IMO";
    private const  SEPARATOR = ' ';
    private const  NUMBER_OF_DIGITS = 7;

    public const  IMO_NUMBER_NOT_VALID = "IMO number is not valid";

    /**
     * @throws SyntelixExceptions
     */
    public static function checkIMOValidOrFail(string $anIMO): bool
    {
        IMOValidator::ensureIMOFormatIsValidOrFail($anIMO);

        $digits = self::getIMONumberDigits($anIMO);

        return IMOValidator::checkIMONumberIntegrity($digits);
    }

    private static function ensureIMOFormatIsValidOrFail(string $anIMO): void
    {
        IMOValidator::checkIMOLenOrFail($anIMO);

        IMOValidator::checkStartsWithOrFail($anIMO, IMOValidator::PREFIX);

        IMOValidator::checkSeparatorOrFail($anIMO, IMOValidator::PREFIX);

        IMOValidator::checkDigitsOrFail($anIMO);
    }

    /**
     * @param string $anIMO
     * @return void
     */
    private static function checkIMOLenOrFail(string $anIMO): void
    {
        $IMO_LEN = strlen(IMOValidator::PREFIX)
            + strlen(IMOValidator::SEPARATOR)
            + IMOValidator::NUMBER_OF_DIGITS;

        $thisIMOLen = strlen($anIMO);

        $validIMOLen = ($IMO_LEN === $thisIMOLen);

        if (!$validIMOLen) {
            throw VesselExceptions::fromIMOInvalid($anIMO);
        }
    }

    private static function checkStartsWithOrFail(string $anIMO, string $preffix): void
    {
        $startsWithPrefix = str_starts_with($anIMO, $preffix);
        if (!$startsWithPrefix) {
            throw VesselExceptions::fromIMOInvalid($anIMO);
        }
    }

    /**
     * @param string $anIMO
     * @param string $prefix
     * @return void
     */
    private static function checkSeparatorOrFail(string $anIMO, string $prefix): void
    {
        $separator = $anIMO[strlen($prefix)];
        if (IMOValidator::SEPARATOR !== $separator) {
            throw VesselExceptions::fromIMOInvalid($anIMO);
        }
    }

    /**
     * @param string $anIMO
     * @return void
     */
    private static function checkDigitsOrFail(string $anIMO): void
    {
        $digits = self::getIMONumberDigits($anIMO);
        $wrongNumberOfDigits = (IMOValidator::NUMBER_OF_DIGITS !== strlen($digits));
        $wrongDigits = !ctype_digit($digits);

        if ($wrongNumberOfDigits || $wrongDigits) {
            throw VesselExceptions::fromIMOInvalid($anIMO);
        }
    }

    private static function getIMONumberDigits(string $anIMO): string
    {
        return substr($anIMO, strlen(self::PREFIX) + strlen(IMOValidator::SEPARATOR));
    }

    /**
     * @throws SyntelixExceptions
     */
    private static function checkIMONumberIntegrity(string $imoDigits): bool
    {
        $checkDigit = StringUtils::getNDigitFromANumberStringized($imoDigits);

        $value = 0;
        $end = strlen($imoDigits)-2;
        $weight = self::NUMBER_OF_DIGITS;
        for($i = 0; $i <= $end ; $i++, $weight--) {
            $currentDigit = $imoDigits[$i];
            $value += (int)($currentDigit) * $weight;
        }
        $checkDigitFromValue = StringUtils::getNDigitFromANumberStringized((string)$value);

        return ($checkDigit === $checkDigitFromValue);
    }
}