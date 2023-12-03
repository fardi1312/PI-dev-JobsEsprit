<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Useretudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;


class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('heure', ChoiceType::class, [
            'choices' => [
                '9' => '9',
                '10' => '10',
                '11' => '11',
            ],
            'constraints' => [
                new NotBlank(),
            ],
        ])
        
       
     /*    ->add('etudiant', EntityType::class, [
            'class' => Useretudiant::class,
            'choice_label' => function (Useretudiant $useretudiant) {
                // Display both username and email in the dropdown
                return $useretudiant->getUsername() . ' - ' . $useretudiant->getEmail();
            },
            'placeholder' => 'Select an Etudiant', // Optional, adds an empty option at the top
            'required' => true, // Set to true if the etudiant selection is mandatory
        ]) */

        ->add('date', DateType::class, [
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
      

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}