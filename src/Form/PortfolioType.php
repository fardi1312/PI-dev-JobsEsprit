<?php

namespace App\Form;

use App\Entity\Portfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use App\Validator\Constraints\TodayOrFutureDate;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class PortfolioType extends AbstractType
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
            ->add('description', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ ne doit pas être vide',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'Le champ doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le champ doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])

               
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'Art' => 'Art',
                    'Sport' => 'Sport',
                    'Informatique' => 'Informatique',
                    'Divertissement' => 'Divertissement',
                    'Logistique' => 'Logistique',
                    'Design' => 'Design',
                    'Tourisme' => 'Tourisme',
                    'Culture' => 'Culture',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez choisir un secteur.',
                        'groups' => ['Default'],
                    ]),
                ],
                'placeholder' => 'Choisissez un secteur ', // Optional placeholder text
                'attr' => [
                    'class' => 'formbold-form-input',
                ],
            ])
        
               
              
                
                ->add('date', DateType::class, [
                    'widget' => 'single_text',
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Le champ ne doit pas être vide',
                        ]),

                    ],
                ])


                
                ->add('image', FileType::class, [
                    'label' => 'Ajouter une image pour votre portfolio :  ',
                
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
                ]) ;
         
    
        }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portfolio::class,
        ]);
    }
}
