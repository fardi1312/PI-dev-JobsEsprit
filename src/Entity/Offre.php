<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $typeStage = null;

    #[ORM\Column(length: 255)]
    private ?string $secteurs = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\Column(length: 255)]
    private ?string $dateInscription = null;

    #[ORM\Column(length: 255)]
    private ?string $images = null;

    #[ORM\OneToMany(mappedBy: 'idOffre', targetEntity: Candidature::class)]
    private Collection $candidatures;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?UserEntreprise $idEntreprise = null;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getDateInscription(): ?string
    {
        return $this->dateInscription;
    }

    public function setDateInscription(string $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): static
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): static
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setIdOffre($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): static
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getIdOffre() === $this) {
                $candidature->setIdOffre(null);
            }
        }

        return $this;
    }

    public function getIdEntreprise(): ?UserEntreprise
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(?UserEntreprise $idEntreprise): static
    {
        $this->idEntreprise = $idEntreprise;

        return $this;
    }
}
