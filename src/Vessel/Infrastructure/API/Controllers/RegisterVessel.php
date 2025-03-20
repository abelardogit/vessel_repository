<?php

declare(strict_types=1);

namespace Syntelix\Vessel\Infrastructure\API\Controllers;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

use Syntelix\Common\Domain\Bus\Command\CommandBus;
use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Common\Domain\VO\NonEmptyString;
use Syntelix\Vessel\Application\DTO\RegisterVesselDTO;
use Syntelix\Vessel\Application\Register\RegisterVesselCommand;
use Syntelix\Vessel\Domain\VO\IMONumber;
use Syntelix\Vessel\Infrastructure\API\Responders\RegisterVesselResponder;

class RegisterVessel extends AbstractController
{
    public function __construct(
        private readonly RegisterVesselResponder $responder,
        private readonly CommandBus $commandBus,
    ){}

    public function register(#[MapRequestPayload] RegisterVesselDTO $registerVesselDTO):  JsonResponse
    {
        try {
            $registerVesselCommand = RegisterVesselCommand::fromCreate(
                imoNumber: IMONumber::fromCreate($registerVesselDTO->imoNumber()),
                name: NonEmptyString::fromCreate($registerVesselDTO->name())
            );

            $this->commandBus->dispatch($registerVesselCommand);
        } catch (SyntelixExceptions $exception) {
            return $this->responder->response(
                $exception->getMessage(),
                $exception->getCode()
            );
        }

        return $this->responder->response('Vessel registered', 201);
    }
}