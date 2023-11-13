<?php

namespace App\Entity;

use App\Repository\CovoiturageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CovoiturageRepository::class)]
class Covoiturage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $heuredepart = null;

    #[ORM\Column(length: 150)]
    private ?string $lieudepart = null;

    #[ORM\Column(length: 150)]
    private ?string $lieuarrivee = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $heurednombreplacesdisponiblesepart = null;

    #[ORM\Column(length: 150)]
    private ?string $image = null;

    #[ORM\Column(length: 150)]
    private ?string $username = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getHeuredepart(): ?string
    {
        return $this->heuredepart;
    }

    public function setHeuredepart(?string $heuredepart): void
    {
        $this->heuredepart = $heuredepart;
    }

    public function getLieudepart(): ?string
    {
        return $this->lieudepart;
    }

    public function setLieudepart(?string $lieudepart): void
    {
        $this->lieudepart = $lieudepart;
    }

    public function getLieuarrivee(): ?string
    {
        return $this->lieuarrivee;
    }

    public function setLieuarrivee(?string $lieuarrivee): void
    {
        $this->lieuarrivee = $lieuarrivee;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): void
    {
        $this->prix = $prix;
    }

    public function getHeurednombreplacesdisponiblesepart(): ?int
    {
        return $this->heurednombreplacesdisponiblesepart;
    }

    public function setHeurednombreplacesdisponiblesepart(?int $heurednombreplacesdisponiblesepart): void
    {
        $this->heurednombreplacesdisponiblesepart = $heurednombreplacesdisponiblesepart;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }
}