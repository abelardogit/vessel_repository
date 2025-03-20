<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Domain\Repository;

use Syntelix\Vessel\Domain\DTO\RegisterVesselDto;
use Syntelix\Vessel\Domain\Entity\Vessel;
use Syntelix\Vessel\Domain\VO\IMONumber;

interface VesselRepository
{
    public function save(Vessel $aVessel) : void;
    public function findById(IMONumber $IMONumber) : RegisterVesselDto|null;
    /**
     * @return RegisterVesselDto[]
     */
    public function findAll() : array;
}