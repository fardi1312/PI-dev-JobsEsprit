<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $descreption = null;

    #[ORM\Column(length: 255)]
    private ?string $typeStage = null;

    #[ORM\Column(length: 255)]
    private ?string $secteurs = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;
    
 
        #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Userentreprise $entrepriseid = null;

        #[ORM\Column(length: 255)]
        private ?string $image = null;

 
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescreption(): ?string
    {
        return $this->descreption;
    }

    public function setDescreption(string $descreption): static
    {
        $this->descreption = $descreption;

        return $this;
    }

    public function getTypeStage(): ?string
    {
        return $this->typeStage;
    }

    public function setTypeStage(string $typeStage): static
    {
        $this->typeStage = $typeStage;

        return $this;
    }

    public function getSecteurs(): ?string
    {
        return $this->secteurs;
    }

    public function setSecteurs(string $secteurs): static
    {
        $this->secteurs = $secteurs;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }



    public function getEntrepriseid(): ?Userentreprise
    {
        return $this->entrepriseid;
    }

    public function setEntrepriseid(?Userentreprise $entrepriseid): static
    {
        $this->entrepriseid = $entrepriseid;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

   

    

   

    
}
