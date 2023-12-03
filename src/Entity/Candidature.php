<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB)]
    private $cv = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?Useretudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?Offre $offre = null;


    #[ORM\Column]
    private ?bool $isTreated = null;

    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEtudiant(): ?Useretudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Useretudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    public function isIsTreated(): ?bool
    {
        return $this->isTreated;
    }

    public function setIsTreated(bool $isTreated): static
    {
        $this->isTreated = $isTreated;

        return $this;
    }

  

 
}
