<?php

// src/Form/CovoiturageType.php

namespace App\Form;

use App\Entity\Covoiturage;
use App\Entity\UserEtudiant;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
                'label' => 'Date and Time of Departure',
                'attr' => ['class' => 'datetime-picker'],
                'constraints' => [
                    new NotBlank(['message' => 'This field cannot be empty.']),
                ],
            ])
            ->add('lieudepart', TextType::class, [
                'label' => 'Departure Location',
                'constraints' => [
                    new NotBlank(['message' => 'This field cannot be empty.']),
                ],
            ])
            ->add('lieuarrivee', TextType::class, [
                'label' => 'Arrival Location',
                'constraints' => [
                    new NotBlank(['message' => 'This field cannot be empty.']),
                ],
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Price',
                'constraints' => [
                    new NotBlank(['message' => 'This field cannot be empty.']),
                ],
            ])
            ->add('nombreplacesdisponible', IntegerType::class, [
                'label' => 'Number of Available Seats',
                'constraints' => [
                    new NotBlank(['message' => 'This field cannot be empty.']),
                    new Range([
                        'min' => 1,
                        'max' => 4,
                        'minMessage' => 'The number of seats must be at least {{ limit }}.',
                        'maxMessage' => 'The number of seats cannot exceed {{ limit }}.',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image',
            ])

            ->add('username', TextType::class, [
                'label' => 'Username',
                'mapped' => false,
                'data' => $options['username'] ?? null,
                'attr' => [
                    'readonly' => true,
                ],
                'empty_data' => '',
            ])
            ->add('id_userEtudiant', EntityType::class, [
                'class' => UserEtudiant::class,
                'choice_label' => 'username', 
                'label' => '  ',
                'attr' => [
                    'readonly' => true,
                    'style' => 'display:none;',
                ],
                'data' => $options['username'],
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