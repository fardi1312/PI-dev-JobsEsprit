<?php
namespace App\Form\DataTransformer;


use App\Entity\Covoiturage;
use App\Entity\ConfirmCovoiturage;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManagerInterface;

class CovoiturageToConfirmCovoiturageTransformer implements DataTransformerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($value): string
    {
        // Transform Covoiturage entity to string (id)
        if (null === $value) {
            return '';
        }

        return $value->getId();
    }

    public function reverseTransform($value): ?ConfirmCovoiturage
    {
        // Reverse transform string (id) to Covoiturage entity
        if (!$value) {
            return null;
        }

        $covoiturage = $this->entityManager
            ->getRepository(Covoiturage::class)
            ->find($value);

        if (null === $covoiturage) {
            throw new TransformationFailedException(sprintf(
                'Covoiturage with id "%s" does not exist!',
                $value
            ));
        }

        // Create or fetch ConfirmCovoiturage entity and set properties based on Covoiturage
        $confirmCovoiturage = new ConfirmCovoiturage();
        $confirmCovoiturage->setUsernameConducteur($covoiturage->getUsername());
        $confirmCovoiturage->setHeureDepart($covoiturage->getHeuredepart());
        $confirmCovoiturage->setLieuDepart($covoiturage->getLieudepart());
        $confirmCovoiturage->setLieuArrivee($covoiturage->getLieuarrivee());
        $confirmCovoiturage->setNombrePlacesReserve($covoiturage->getnombreplacesdisponible());

        return $confirmCovoiturage;
    }
}
