<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendarRepository::class)]
class Calendar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $heure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;


/* 
    #[ORM\ManyToOne(inversedBy: 'calendars')]
    private ?Useretudiant $etudiant = null; */

    #[ORM\ManyToOne(inversedBy: 'calendars')]
    private ?Userentreprise $entreprise = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:"candidature_id", referencedColumnName:"id", onDelete:"SET NULL")]

    private ?Candidature $Condidature = null;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

public function getEntreprise(): ?Userentreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Userentreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getCondidature(): ?Candidature
    {
        return $this->Condidature;
    }

    public function setCondidature(?Candidature $Condidature): static
    {
        $this->Condidature = $Condidature;

        return $this;
    }

 

 
}
