<?php

declare(strict_types=1);

namespace Syntelix\Vessel\Domain\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

use Syntelix\Common\Domain\Exceptions\SyntelixExceptions;
use Syntelix\Common\Domain\Validators\SanitizeValidator;
use Syntelix\Common\Domain\VO\NonEmptyString;
use Syntelix\Vessel\Domain\Validators\IMOValidator;
use Syntelix\Vessel\Domain\VO\IMONumber;

#[ORM\Entity]
class Vessel
{
    #[ORM\Id, ORM\Column]
    private string $id;
    #[ORM\Column(unique: true)]
    private IMONumber $imoNumber;
    #[ORM\Column]
    private NonEmptyString $name;

    /**
     * @throws SyntelixExceptions
     */
    private function __construct(string $anIMONumber, string $aName)
    {
        $this->id = Uuid::v7()->toString();
        $this->setImo($anIMONumber);
        $this->setName($aName);
    }

    /**
     * @throws SyntelixExceptions
     */
    public static function fromCreate(string $imoNumber, string $name): Vessel
    {
        return new Vessel($imoNumber, $name);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function imo(): string
    {
        return $this->imoNumber->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }


    /**
     * @throws SyntelixExceptions
     */
    private function setImo(string $anIMONumber): void {
        IMOValidator::checkIMOValidOrFail($anIMONumber);
        $this->imoNumber = IMONumber::fromCreate($anIMONumber);
    }

    /**
     * @throws SyntelixExceptions
     */
    private function setName(string $aName): void {
        $this->checkNameIsNonEmptyValidOrFail($aName);
        $this->name = NonEmptyString::fromCreate($aName);
    }

    /**
     * @throws SyntelixExceptions
     */
    private function checkNameIsNonEmptyValidOrFail(string $aName): void
    {
        if (SanitizeValidator::isEmptyString($aName)) {
            throw SyntelixExceptions::fromMalFormedData();
        }
    }
}