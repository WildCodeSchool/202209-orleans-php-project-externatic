<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExperienceRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $company = null;

    #[Assert\Expression(
        "( !this.getEndDate() or this.isIsCurrentPosition() )?: this.getEndDate() > this.getStartDate()",
        message: 'La date de début doit être inférieure à la date de fin.',
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    private ?DateTimeInterface $startDate = null;

    #[Assert\LessThan('tomorrow')]
    #[Assert\Expression(
        "this.getEndDate() ?: this.isIsCurrentPosition()",
        message: 'Vous devez choisir une date de fin ou cocher la case \'Poste actuel\'.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endDate = null;

    #[ORM\Column]
    #[Assert\Expression("!this.isIsCurrentPosition() ?: this.setEndDate(null)")]
    private ?bool $isCurrentPosition = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $jobTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $jobDescription = null;

    #[ORM\ManyToOne(inversedBy: 'experiences')]
    private ?Candidate $candidate = null;

    #[ORM\ManyToOne]
    private ?Contract $contract = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function isIsCurrentPosition(): ?bool
    {
        return $this->isCurrentPosition;
    }

    public function setIsCurrentPosition(bool $isCurrentPosition): self
    {
        $this->isCurrentPosition = $isCurrentPosition;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(?string $jobDescription): self
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
