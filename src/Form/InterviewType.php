<?php

namespace App\Form;

use App\Entity\Calendaractivity;
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

class InterviewType extends AbstractType
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
        
            ->add('etudiant_id', EntityType::class, [
                'class' => Useretudiant::class,
                'choice_label' => function (Useretudiant $useretudiant) {
                    return sprintf('%s (%s)', $useretudiant->getUsername(), $useretudiant->getEmail());
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.username', 'ASC');
                },
                'required' => false, // Adjust this based on your validation requirements
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
            'data_class' => Calendaractivity::class,
        ]);
    }
}
