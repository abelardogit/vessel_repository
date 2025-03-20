<?php

declare(strict_types=1);


namespace Syntelix\Common\Domain\Validators;

class SanitizeValidator
{

    public static function isEmptyString(string $data): bool
    {
        return !filter_var($data, FILTER_FLAG_EMPTY_STRING_NULL);
    }
}