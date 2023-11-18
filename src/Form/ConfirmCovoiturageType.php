<?php

namespace App\Form;

use App\Entity\ConfirmCovoiturage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConfirmCovoiturageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usernameEtud', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('usernameConducteur', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('firstNameEtud', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('lastNameEtud', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('firstNameConducteur', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('lastNameConducteur', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('phoneEtud', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('phoneConducteur', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('emailEtud', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('emailConducteur', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('heureDepart', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('lieuDepart', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('lieuArrivee', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('prixTotalePlacesReserve')
            ->add('nombrePlacesReserve')
            ->add('id_Covoiturage');
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConfirmCovoiturage::class,
        ]);
    }
}
