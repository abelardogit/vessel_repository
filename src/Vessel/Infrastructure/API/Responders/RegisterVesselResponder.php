<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Infrastructure\API\Responders;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterVesselResponder
{
    /** @var string[] */
    private array $errors = [];

    public function __construct() {}

    public function response(string $aMessage, int $aCode) : JsonResponse
    {
        if (! empty($this->errors)) {
            return new JsonResponse(
                json_encode($this->errors),
                Response::HTTP_BAD_REQUEST,
            );
        }

        return $this->loadNonEmptyJsonResponse($aMessage, $aCode);
    }

    private function loadNonEmptyJsonResponse(string $aMessage, int $aCode): JsonResponse
    {
        return new JsonResponse($aMessage,$aCode);
    }
}