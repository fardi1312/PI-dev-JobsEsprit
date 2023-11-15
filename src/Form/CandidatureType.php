<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use App\Validator\Constraints\TodayOrFutureDate;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
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

        ->add('cv', FileType::class, [
            'label' => 'CV (PDF file)',
            'mapped' => false, // Set to false because we handle file upload manually
            'required' => true,
            // You can customize additional options based on your needs
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
