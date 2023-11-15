<?php

namespace App\Form;

use App\Entity\UserEntreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Callback;

class UserEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ téléphone ne doit pas être vide']),
                    new Regex(['pattern' => '/^\d{8}$/', 'message' => 'Le téléphone doit être composé de 8 chiffres']),
                ],
            ])
            ->add('role', TextType::class, [
                'data' => 'entreprise', // Valeur par défaut pour le rôle
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne doit pas être vide']),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ email ne doit pas être vide']),
                    new Email(['message' => 'Veuillez saisir une adresse email valide.']),
                ],
            ])
            ->add('motDePasse', PasswordType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ mot de passe ne doit pas être vide']),
                ],
            ])

            
            ->add('nomEntreprise', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ nom de l\'entreprise ne doit pas être vide']),
                ],
            ])
            ->add('localisation', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ localisation ne doit pas être vide']),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserEntreprise::class,
        ]);
    }
}
