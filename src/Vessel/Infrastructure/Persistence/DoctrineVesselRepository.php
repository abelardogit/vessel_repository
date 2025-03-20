<?php

declare(strict_types=1);

namespace Syntelix\Vessel\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;

use Syntelix\Vessel\Domain\DTO\RegisterVesselDto;
use Syntelix\Vessel\Domain\Entity\Vessel;
use Syntelix\Vessel\Domain\Repository\VesselRepository;
use Syntelix\Vessel\Domain\VO\IMONumber;

class DoctrineVesselRepository implements VesselRepository
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function save(Vessel $aVessel): void
    {
        $this->em->persist($aVessel);
        $this->em->flush();
    }

    public function findById(IMONumber $IMONumber): RegisterVesselDto|null
    {
        /** @var Vessel $vessel */
        $vessel = $this->em->getRepository(Vessel::class)->find($IMONumber);

        if ($vessel === null) {
            return null;
        }

        return new RegisterVesselDto(
            id: $vessel->id(),
            imoNumber: $vessel->imo(),
            name: $vessel->name()
        );
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $vessels = $this->em->getRepository(Vessel::class)->findAll();

        $emailsDto = [];

        foreach ($vessels as $vessel) {
            $vesselsDto[] = new RegisterVesselDto(
                id: $vessel->id(),
                imoNumber: $vessel->imo(),
                name: $vessel->addressee()->toString(),
            );
        }

        return $vesselsDto;
    }
}