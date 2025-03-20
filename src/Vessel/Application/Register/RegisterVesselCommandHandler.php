<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Application\Register;

use Syntelix\Common\Domain\Bus\Command\CommandHandler;
use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Vessel\Domain\Entity\Vessel;
use Syntelix\Vessel\Domain\Repository\VesselRepository;

 class RegisterVesselCommandHandler implements CommandHandler
{
    public function __construct(private VesselRepository $repository){}

    /**
     * @throws SyntelixExceptions
     */
    public function __invoke(RegisterVesselCommand $command): void
    {
        $aVessel = Vessel::fromCreate(
            imoNumber: $command->imoNumber(),
            name: $command->name()
        );

        $this->repository->save($aVessel);
    }
}