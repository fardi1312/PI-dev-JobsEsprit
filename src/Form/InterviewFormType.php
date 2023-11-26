<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Useretudiant;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

class InterviewFormType extends AbstractType
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
        
        ->add('etudiant', EntityType::class, [
            'class' => Useretudiant::class,
            'choice_label' => 'username', // Replace with the actual property you want to display
        ])

         
          
         

           
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
