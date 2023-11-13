<?php

namespace App\Entity;

use App\Repository\CalendaractivityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendaractivityRepository::class)]
class Calendaractivity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $heure = null;

    #[ORM\ManyToOne(inversedBy: 'calendaractivities')]
    private ?Useretudiant $etudiant_id = null;

   

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

    public function getEtudiantId(): ?Useretudiant
    {
        return $this->etudiant_id;
    }

    public function setEtudiantId(?Useretudiant $etudiant_id): static
    {
        $this->etudiant_id = $etudiant_id;

        return $this;
    }

   

   
}
