<?php

declare(strict_types=1);


namespace Syntelix\Common\Domain\Errors;

use Exception;
use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Common\Domain\VO\NonEmptyString;

class SyntelixResponse
{
    private mixed $data;
    private bool $isOK;
    private NonEmptyString $message;

    private int $code;

    public const int OK = 200;
    public const int BAD_REQUEST = 400;
    public const string MALFORMED_DATA = "Formato incorrecto";

    /**
     * @param array $data
     * @param bool $isOK
     * @param NonEmptyString $message
     * @param int $code
     */
    private function __construct(array $data, bool $isOK, NonEmptyString $message, int $code)
    {
        $this->setData($data);
        $this->isOK = $isOK;
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return SyntelixResponse
     * @throws SyntelixExceptions
     */
    public static function fromOK(mixed $data): self
    {
        return new self($data, true, NonEmptyString::fromCreate("Ok"), self::OK);
    }

    /**
     * @param   array $data
     * @param   NonEmptyString $message
     * @param   int $code
     * @return SyntelixResponse
     */
    public static function fromKO(mixed $data, NonEmptyString $message, int $code): self
    {
        return new self($data, false, $message, $code);
    }


    public static function fromCreate(mixed $data, NonEmptyString $message, bool $isOK, int $code = 400): self
    {
        return new self($data, $isOK, $message, $code);
    }

    /**
     * @param Exception $anException
     * @return SyntelixResponse
     */
    public static function fromException(Exception $anException): self
    {
        $message = $anException->getMessage();
        $nonEmptyMessage = NonEmptyString::fromCreate($message);
        $code = $anException->getCode();
        $data = ["line" => $anException->getLine(), "class" => $anException->getFile()];

        return SyntelixResponse::fromKO($data, $nonEmptyMessage, $code);
    }

    public function data(): mixed
    {
        return $this->data;
    }
    public function isOK(): bool
    {
        return $this->isOK;
    }

    public function message(): NonEmptyString
    {
        return $this->message;
    }

    public function code(): int
    {
        return $this->code;
    }

    /**
     * @param array $data
     */
    private function setData(array $data): void
    {
        $this->data = $data;
    }
}