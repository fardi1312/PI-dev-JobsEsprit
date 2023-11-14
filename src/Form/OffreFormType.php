<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Import ChoiceType here
use App\Validator\Constraints\TodayOrFutureDate;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class OffreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Le champ ne doit pas être vide',
                ]),
                new Assert\Length([
                    'min' => 3,
                    'max' => 20,
                    'minMessage' => 'Le champ doit contenir au moins {{ limit }} caractères',
                    'maxMessage' => 'Le champ doit contenir au maximum {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('descreption', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Le champ ne doit pas être vide',
                ]),
                new Assert\Length([
                    'min' => 3,
                    'max' => 20,
                    'minMessage' => 'Le champ doit contenir au moins {{ limit }} caractères',
                    'maxMessage' => 'Le champ doit contenir au maximum {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('typeStage', ChoiceType::class, [
            'choices' => [
                'STAGE_INGENIEUR' => 'STAGE_INGENIEUR',
                'IMMERSION_EN_ENTREPRISE' => 'IMMERSION_EN_ENTREPRISE',
                'Stage_PFe' => 'Stage_PFe',
            ],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez choisir un type de stage',
                    'groups' => ['Default'],
                ]),
            ],
            'placeholder' => 'Choisissez un type de stage', // Optional placeholder text
            'attr' => [
                'class' => 'formbold-form-input',
            ],
        ])
           
        ->add('secteurs', ChoiceType::class, [
            'choices' => [
                'Finance' => 'Finance',
                'Banques' => 'Banques',
                'Informatique' => 'Informatique',
                'Architecture' => 'Architecture',
                'Entreprises Restauration' => 'Entreprises Restauration',
                'Industrie' => 'Industrie',
                'Logistique' => 'Logistique',
            ],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez choisir un secteur.',
                    'groups' => ['Default'],
                ]),
            ],
            'placeholder' => 'Choisissez un secteur', // Optional placeholder text
            'attr' => [
                'class' => 'formbold-form-input',
            ],
        ])
        
        ->add('fonction', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Le champ ne doit pas être vide.',
                ]),
            ],
            'attr' => [
                'class' => 'formbold-form-input', // Add any additional classes if needed
            ],
        ])
           
          
            
            ->add('dateInscription', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne doit pas être vide',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 'today', // La date d'aujourd'hui
                        'message' => 'La date doit être aujourd\'hui ou ultérieure.',
                    ]),
                ],
            ])
          /*   ->add('images', FileType::class, [
                'label' => 'Votre image de loffre(fichier image uniquement)',
            
                // unmapped means that this field is not associated with any entity property
                'mapped' => false,
            
                // Make it optional so you don't have to re-upload the image file every time you edit
                'required' => false,
            
                // Unmapped fields can't define their validation using annotations in the associated entity
                // So you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document image valide',
                        'notFoundMessage' => 'Le fichier ne peut pas être vide',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Le champ ne doit pas être vide',
                    ]),
                ],
            ]) */

            ->add('image', FileType::class, [
                'label' => ' Votre image  (fichier image uniquement)',

               'mapped' => false,

               
                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document image valide',
                        'notFoundMessage' => 'Le fichier ne peut pas être vide',

                    ]),
                    new Assert\NotBlank([
                        'message' => 'Le champ ne doit pas être vide',
                    ])

                ],
            ])

;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
