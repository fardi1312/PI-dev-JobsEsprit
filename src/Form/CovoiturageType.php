<?php

// src/Form/CovoiturageType.php
// src/Form/CovoiturageType.php
// src/Form/CovoiturageType.php

namespace App\Form;

use App\Entity\Covoiturage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\FileToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class CovoiturageType extends AbstractType
{
    private $fileToStringTransformer;

    public function __construct(FileToStringTransformer $fileToStringTransformer)
    {
        $this->fileToStringTransformer = $fileToStringTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heureDepart', TextType::class, [
                'label' => 'Date et Heure de Départ',
                'attr' => ['class' => 'datetime-picker'],
            ])
            ->add('lieudepart', TextType::class, [
                'label' => 'Lieu de départ',
            ])
            ->add('lieuarrivee', TextType::class, [
                'label' => 'Lieu d\'arrivée',
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix',
            ])
            ->add('nombreplacesdisponible', IntegerType::class, [
                'label' => 'Nombre de places disponibles',
                'constraints' => [
                    new NotBlank(['message' => 'Ce champ ne peut pas être vide.']),
                    new Range([
                        'min' => 1,
                        'max' => 4,
                        'minMessage' => 'Le nombre de places doit être au moins {{ limit }}.',
                        'maxMessage' => 'Le nombre de places ne peut pas dépasser {{ limit }}.',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image',
            ])

            
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'mapped' => false,
                'data' => $options['username'] ?? null,
                'attr' => [
                    'readonly' => true,
                    'style' => 'display:none;', // Hide the field
                ],
                'empty_data' => '', // Set empty data to avoid validation errors
            ]);

        $builder->get('image')->addModelTransformer($this->fileToStringTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Covoiturage::class,
            'username' => null, // Set the default value for the username field
        ]);
    }
}
