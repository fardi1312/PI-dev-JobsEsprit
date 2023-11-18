<?php

namespace App\Form;

use App\Entity\ConfirmCovoiturage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\FormEvent; // Add this line
use Symfony\Component\Form\FormEvents; // Add this line

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
            ->add('nombrePlacesReserve', IntegerType::class, [
                'label' => 'Number of Available Seats',
                'attr' => [
                    'min' => 1,
                    'max' => $options['nbrDespo'],
                ],
            ])
   
            ->add('prixTotalePlacesReserve', IntegerType::class, [
                'label' => 'Total Price for Reserved Seats',
                'mapped' => false,
                'attr' => [
                    'readonly' => true,
                ],
                'data' => 5* $options['prix'], // Set the default value here
            ])




            ->add('id_Covoiturage');
        
    }

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => ConfirmCovoiturage::class,
        'nbrDespo' => null, // Default value for the variable
        'prix' => null,
    ]);
}
}
