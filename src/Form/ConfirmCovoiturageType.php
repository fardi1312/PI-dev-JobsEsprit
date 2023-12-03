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
use Symfony\Component\Form\CallbackTransformer;

class ConfirmCovoiturageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder           
        


        ->add('usernameConducteur', TextType::class, [

            'attr' => ['readonly' => true],
        ])
        ->add('firstNameEtud', TextType::class, [
            'label' => '  ',

            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])

        ->add('heureDepart', TextType::class, [
            'label' => 'departure Time  ',

            'attr' => ['readonly' => true],
        ])
        ->add('lieuDepart', TextType::class, [
            'label' => 'departure Location  ',

            'attr' => ['readonly' => true],
        ])
        ->add('lieuArrivee', TextType::class, [
            'label' => 'arrival Location   ',

            'attr' => ['readonly' => true],
        ])
        ->add('nombrePlacesReserve', IntegerType::class, [
            'label' => 'Number of Available Seats  ',
            'attr' => [
                'min' => 1,
                'max' => $options['nbrDespo'],
            ],
        ])

        ->add('prixTotalePlacesReserve', IntegerType::class, [
            'label' => 'Total Price for Reserved Seats',
            'attr' => [
                'min' => 0,
                'readonly' => true,
            ],
        ])


        ->add('usernameEtud', TextType::class, [
            'label' => '  ',
  
                    'attr' => [
            'readonly' => true,
            'style' => 'display:none;',
        ],
        ])



        ->add('lastNameEtud', TextType::class, [
            'label' => '  ',

            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])
        ->add('firstNameConducteur', TextType::class, [
            'label' => '  ',
            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])
        ->add('lastNameConducteur', TextType::class, [
            'label' => '  ',

            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])
        ->add('phoneEtud', TextType::class, [
            'label' => '  ',

            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])
        ->add('phoneConducteur', TextType::class, [
            'label' => '  ',
            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])
        ->add('emailEtud', TextType::class, [
            'label' => '  ',

            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])
        ->add('emailConducteur', TextType::class, [
            'label' => '  ',
            'attr' => [
                'readonly' => true,
                'style' => 'display:none;',
            ],
        ])


        ->add('id_Covoiturage', null, [
            'label' => '  ',

            'attr' => [
                'style' => 'display:none;', // Hides the field
            ],
        ])
        ->add('Confirmed', null, [
            'label' => '  ',

            'attr' => [
                'style' => 'display:none;', // Hides the field
            ],
        ]);
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
