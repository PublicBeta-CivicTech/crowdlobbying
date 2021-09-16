<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignEntryRepository")
 */
class CampaignEntry
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $optInInformation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $optInInformationPartner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="campaignEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campaign", inversedBy="campaignEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Politician")
     * @ORM\JoinColumn(nullable=false)
     */
    private $politician;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @var Argument|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Argument")
     * @ORM\JoinColumn(nullable=true)
     */
    private $argument;

    /**
     * @var PersonArgument|null
     * @ORM\ManyToOne(targetEntity="App\Entity\PersonArgument", inversedBy="campaignEntry")
     * @ORM\JoinColumn(nullable=true)
     */
    private $personArgument;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $confirmed = false;

    public function __toString(): string
    {
        if (null !== $this->argument) {
            return (string) $this->argument->getArgument();
        }

        if (null !== $this->personArgument) {
            return (string) $this->personArgument->getArgument();
        }

        return '';
    }

    public function getRandomColor(): string
    {
        $colors = [
            '#e33935',
            '#d71a60',
            '#8e24aa',
            '#5e34b1',
            '#3949aa',
            '#1d88e5',
            '#039be5',
            '#00acc0',
            '#01887b',
            '#43a047',
            '#e24b26',
        ];
        shuffle($colors);

        return array_pop($colors);
    }

    public function getColor(): ?string
    {
        $color = $this->color;
        if (!$color) {
            $color = $this->getRandomColor();
            $this->setColor($color);
        }

        return $color;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOptInInformation(): ?bool
    {
        return $this->optInInformation;
    }

    public function setOptInInformation(bool $optInInformation): self
    {
        $this->optInInformation = $optInInformation;

        return $this;
    }

    public function getOptInInformationPartner(): ?bool
    {
        return $this->optInInformationPartner;
    }

    public function setOptInInformationPartner(bool $optInInformationPartner): self
    {
        $this->optInInformationPartner = $optInInformationPartner;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getPolitician(): ?Politician
    {
        return $this->politician;
    }

    public function setPolitician(?Politician $politician): self
    {
        $this->politician = $politician;

        return $this;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getArgument(): ?Argument
    {
        return $this->argument;
    }

    public function setArgument(?Argument $argument): self
    {
        $this->argument = $argument;

        return $this;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getPersonArgument(): ?PersonArgument
    {
        return $this->personArgument;
    }

    public function setPersonArgument(?PersonArgument $personArgument): self
    {
        $this->personArgument = $personArgument;

        return $this;
    }
}
