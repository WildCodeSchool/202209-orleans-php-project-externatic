<?php

namespace App\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SponsorRepository;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[Vich\UploadableField(mapping: 'logo_file', fileNameProperty: 'logo')]
    private ?File $logoFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }
    public function setLogoFile(?File $logoFile): self
    {
        $this->logoFile = $logoFile;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
