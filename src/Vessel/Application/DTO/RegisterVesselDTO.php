<?php

declare(strict_types=1);


namespace Syntelix\Vessel\Application\DTO;
use Symfony\Component\Validator\Constraints as Assert;

readonly class RegisterVesselDTO
{
    public function __construct(
        #[Assert\NotBlank]
        private string $name,
        #[Assert\NotBlank]
        #[Assert\Length(min: 11, max: 11)]
        private string $imoNumber
    ){}

    public function name(): string
    {
        return $this->name;
    }

    public function imoNumber(): string
    {
        return $this->imoNumber;
    }

}