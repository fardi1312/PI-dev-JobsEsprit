<?php

namespace App\Form;

use App\Entity\UserEtudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;



class UserEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ nom ne doit pas être vide',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ prenom ne doit pas être vide',
                    ]),
                ],
            ])
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ username ne doit pas être vide',
                    ]),
                    new Length(['min' => 3]), // Exemple: un minimum de 3 caractères pour le nom d'utilisateur
                ],
            ])
            ->add('age', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ age ne doit pas être vide',
                    ]),
                ],
            ])
            ->add('role', TextType::class, [
                'data' => 'etudiant', // Valeur par défaut pour le rôle
                'constraints' => [
                    new NotBlank([
                    'message' => 'Le champ ne doit pas être vide',
                ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                    'message' => 'Le champ email ne doit pas être vide',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide.',
                    ]),
                ],
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank([
                    'message' => 'Le champ téléphone ne doit pas être vide',
                ]),
                    new Regex(['pattern' => '/^\d{8}$/']), // Contrainte pour un numéro de téléphone de 8 chiffres
                ],
            ])
            ->add('motDePasse', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                    'message' => 'Le champ mot de passe  ne doit pas être vide',
                ]),
                ],
            ])

           
                
            


            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserEtudiant::class,
        ]);
    }
}
