<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
#[Vich\Uploadable]
/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 3,
    )]
    private ?string $nationality = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 5,
    )]
    #[Assert\Regex(
        pattern: '/^([0-9]{5})$/',
        match: true,
    )]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 255,
    )]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
    )]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $hobby = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aboutMe = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
    )]
    #[Assert\Url()]
    private ?string $github = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
    )]
    #[Assert\Url()]
    private ?string $linkedin = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
    )]
    #[Assert\Url()]
    private ?string $portfolio = null;

    #[ORM\OneToOne(inversedBy: 'candidate', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: Education::class, cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(["startDate" => "DESC"])]
    private Collection $education;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: Experience::class, cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(["startDate" => "DESC"])]
    private Collection $experiences;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $curriculumVitae = null;

    #[Vich\UploadableField(mapping: 'cv_file', fileNameProperty: 'curriculumVitae')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ],
    )]
    private ?File $cvFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DatetimeInterface $updatedAt = null;

    #[ORM\OneToMany(
        mappedBy: 'candidate',
        targetEntity: Application::class,
        fetch: 'EAGER',
        cascade: ['persist', 'remove']
    )]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'candidates', cascade: ['persist', 'remove'])]
    private Collection $favorite;

    #[ORM\ManyToMany(
        targetEntity: Skill::class,
        inversedBy: 'candidates',
        fetch: 'EAGER',
        cascade: ['persist', 'remove']
    )]
    private Collection $skills;

    public function __construct()
    {
        $this->education = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->favorite = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getHobby(): ?string
    {
        return $this->hobby;
    }

    public function setHobby(?string $hobby): self
    {
        $this->hobby = $hobby;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
    }

    public function setAboutMe(?string $aboutMe): self
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getPortfolio(): ?string
    {
        return $this->portfolio;
    }

    public function setPortfolio(?string $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of postalCode
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     *
     * @return  self
     */
    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->education->contains($education)) {
            $this->education->add($education);
            $education->setCandidate($this);
        }
        return $this;
    }
    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setCandidate($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->education->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getCandidate() === $this) {
                $education->setCandidate(null);
            }
        }

        return $this;
    }


    public function removeExperience(Experience $experience): self
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getCandidate() === $this) {
                $experience->setCandidate(null);
            }
        }

        return $this;
    }

    public function getCurriculumVitae(): ?string
    {
        return $this->curriculumVitae;
    }

    public function setCurriculumVitae(?string $curriculumVitae): self
    {
        $this->curriculumVitae = $curriculumVitae;

        return $this;
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function setCvFile(File $cvFile): self
    {
        $this->cvFile = $cvFile;

        if (null !== $cvFile) {
            $this->updatedAt = new DateTimeImmutable('now');
        }

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setCandidate($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getCandidate() === $this) {
                $application->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getFavorite(): Collection
    {
        return $this->favorite;
    }

    public function addFavorite(Offer $favorite): self
    {
        if (!$this->favorite->contains($favorite)) {
            $this->favorite->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(Offer $favorite): self
    {
        $this->favorite->removeElement($favorite);

        return $this;
    }

    public function isInFavorite(Offer $offer): bool
    {
        return $this->favorite->contains($offer);
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }
}
