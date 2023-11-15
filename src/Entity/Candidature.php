<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreRepository;
use App\Repository\UseretudiantRepository;


#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(type: Types::BLOB)]
    private $cv = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?Useretudiant $idEtudiant = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?Offre $idOffre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getIdEtudiant(): ?Useretudiant
    {
        return $this->idEtudiant;
    }

    public function setIdEtudiant(?Useretudiant $idEtudiant): static
    {
        $this->idEtudiant = $idEtudiant;

        return $this;
    }

    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    public function setIdOffre(?Offre $idOffre): static
    {
        $this->idOffre = $idOffre;

        return $this;
    }
}
