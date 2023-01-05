<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OfferRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Assert\Length(max: 5)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $city = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTime $targetDate = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: Types::INTEGER)]
    #[Assert\Positive]
    private ?int $annualWage = null;

    #[ORM\Column]
    #[Assert\Type(type: Types::BOOLEAN)]
    private ?bool $isImportant = false;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: Candidate::class, mappedBy: 'offers')]
    private Collection $candidates;

    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable('now'));
        $this->candidates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTargetDate(): ?DateTime
    {
        return $this->targetDate;
    }

    public function setTargetDate(?DateTime $targetDate): self
    {
        $this->targetDate = $targetDate;

        return $this;
    }

    public function getAnnualWage(): ?int
    {
        return $this->annualWage;
    }

    public function setAnnualWage(?int $annualWage): self
    {
        $this->annualWage = $annualWage;

        return $this;
    }

    public function getIsImportant(): ?bool
    {
        return $this->isImportant;
    }

    public function setIsImportant(bool $isImportant): self
    {
        $this->isImportant = $isImportant;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getCandidates(): Collection
    {
        return $this->candidates;
    }

    public function addCandidate(Candidate $candidate): self
    {
        if (!$this->candidates->contains($candidate)) {
            $this->candidates->add($candidate);
            $candidate->addOffer($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        if ($this->candidates->removeElement($candidate)) {
            $candidate->removeOffer($this);
        }

        return $this;
    }
}
