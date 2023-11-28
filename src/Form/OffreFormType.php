<?php

namespace App\Form;

use App\Entity\Offre;
use App\EventListener\BadWord;
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\EventListener\BadWordsListener;
use Symfony\Component\Validator\Constraints\NotBlank;

class OffreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'This field cannot be empty.']),

                new Assert\Length([
                    'min' => 3,
                    'max' => 20,
                    'minMessage' => 'This value should have at least {{ limit }} characters.',
                    'maxMessage' => 'This value should have at most {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('descreption', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'This field cannot be empty.']),

                new Assert\Length([
                    'min' => 3,
                    'max' => 20,
                    'minMessage' => 'This value should have at least {{ limit }} characters',
                    'maxMessage' => 'This value should have at least {{ limit }} characters',
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
                    'message' => 'Please choose a stage type.',
                    'groups' => ['Default'],
                ]),
            ],
            'placeholder' => 'Choose a stage type', // Optional placeholder text
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
                    'message' => 'Please choose a sector.',
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
                    'message' => 'This value should not be blank',
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
                        'message' => 'This value should not be blank',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 'today', // La date d'aujourd'hui
                        'message' => 'The date must be today or later',
                    ]),
                ],
            ])
            
         

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

$builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
    $badWordsListener = new BadWordsListener();
    $badWordsListener->onFormSubmit($event);
});


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
