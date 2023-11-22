<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ConfirmCovoiturage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $usernameEtud = null;

    #[ORM\Column(length: 255)]
    private ?string $usernameConducteur = null;

    #[ORM\Column(length: 255)]
    private ?string $firstNameEtud = null;

    #[ORM\Column(length: 255)]
    private ?string $lastNameEtud = null;

    #[ORM\Column(length: 255)]
    private ?string $firstNameConducteur = null;

    #[ORM\Column(length: 255)]
    private ?string $lastNameConducteur = null;

    #[ORM\Column(type: 'integer')]
    private ?int $phoneEtud = null;

    #[ORM\Column(type: 'integer')]
    private ?int $phoneConducteur = null;

    #[ORM\Column(length: 255)]
    private ?string $emailEtud = null;

    #[ORM\Column(length: 255)]
    private ?string $emailConducteur = null;

    #[ORM\Column(length: 255)]
    private ?string $heureDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuArrivee = null;

    #[ORM\Column(type:'integer')]
    private ?int $prixTotalePlacesReserve = null;

    #[ORM\Column(type: 'integer')]
    private ?int $nombrePlacesReserve = null;

    #[ORM\ManyToOne(targetEntity: Covoiturage::class)]
    #[ORM\JoinColumn(name: 'covoiturage_id', referencedColumnName: 'id')]
    private ?Covoiturage $id_Covoiturage = null;

    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsernameEtud(): ?string
    {
        return $this->usernameEtud;
    }

    public function getUsernameConducteur(): ?string
    {
        return $this->usernameConducteur;
    }

    public function getFirstNameEtud(): ?string
    {
        return $this->firstNameEtud;
    }

    public function getLastNameEtud(): ?string
    {
        return $this->lastNameEtud;
    }

    public function getFirstNameConducteur(): ?string
    {
        return $this->firstNameConducteur;
    }

    public function getLastNameConducteur(): ?string
    {
        return $this->lastNameConducteur;
    }

    public function getPhoneEtud(): ?int
    {
        return $this->phoneEtud;
    }

    public function getPhoneConducteur(): ?int
    {
        return $this->phoneConducteur;
    }

    public function getEmailEtud(): ?string
    {
        return $this->emailEtud;
    }

    public function getEmailConducteur(): ?string
    {
        return $this->emailConducteur;
    }

    public function getHeureDepart(): ?string
    {
        return $this->heureDepart;
    }

    public function getLieuDepart(): ?string
    {
        return $this->lieuDepart;
    }

    public function getLieuArrivee(): ?string
    {
        return $this->lieuArrivee;
    }

    public function getPrixTotalePlacesReserve(): ?int
    {
        return $this->prixTotalePlacesReserve;
    }

    public function getNombrePlacesReserve(): ?int
    {
        return $this->nombrePlacesReserve;
    }

    // Setters

    public function setUsernameEtud(?string $usernameEtud): void
    {
        $this->usernameEtud = $usernameEtud;
    }

    public function setUsernameConducteur(?string $usernameConducteur): void
    {
        $this->usernameConducteur = $usernameConducteur;
    }

    public function setFirstNameEtud(?string $firstNameEtud): void
    {
        $this->firstNameEtud = $firstNameEtud;
    }

    public function setLastNameEtud(?string $lastNameEtud): void
    {
        $this->lastNameEtud = $lastNameEtud;
    }

    public function setFirstNameConducteur(?string $firstNameConducteur): void
    {
        $this->firstNameConducteur = $firstNameConducteur;
    }

    public function setLastNameConducteur(?string $lastNameConducteur): void
    {
        $this->lastNameConducteur = $lastNameConducteur;
    }

    public function setPhoneEtud(?int $phoneEtud): void
    {
        $this->phoneEtud = $phoneEtud;
    }

    public function setPhoneConducteur(?int $phoneConducteur): void
    {
        $this->phoneConducteur = $phoneConducteur;
    }

    public function setEmailEtud(?string $emailEtud): void
    {
        $this->emailEtud = $emailEtud;
    }

    public function setEmailConducteur(?string $emailConducteur): void
    {
        $this->emailConducteur = $emailConducteur;
    }

    public function setHeureDepart(?string $heureDepart): void
    {
        $this->heureDepart = $heureDepart;
    }

    public function setLieuDepart(?string $lieuDepart): void
    {
        $this->lieuDepart = $lieuDepart;
    }

    public function setLieuArrivee(?string $lieuArrivee): void
    {
        $this->lieuArrivee = $lieuArrivee;
    }

    public function setPrixTotalePlacesReserve(?int $prixTotalePlacesReserve): void
    {
        $this->prixTotalePlacesReserve = $prixTotalePlacesReserve;
    }

    public function setNombrePlacesReserve(?int $nombrePlacesReserve): void
    {
        $this->nombrePlacesReserve = $nombrePlacesReserve;
    }

    public function getIdCovoiturage(): ?Covoiturage
    {
        return $this->id_Covoiturage;
    }

    public function setIdCovoiturage(?Covoiturage $id_Covoiturage): static
    {
        $this->id_Covoiturage = $id_Covoiturage;

        return $this;
    }
}
