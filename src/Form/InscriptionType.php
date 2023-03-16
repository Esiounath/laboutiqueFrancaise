<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public $password;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrez votre adresse mail ?'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i",
                        'message' => 'Invalid email format.'
                        ])
                ]
            ])
            ->add('password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique !',
                'label' => 'Mot de Passe',
                'first_options'  => ['label' => 'Password',
            'attr'=>[
                'placeholder' => 'Entrez votre mot de passe ?'
            ]
            ],
                'second_options' => ['label' => 'Repeat Password',  'attr'=>[
                    'placeholder' => 'Confirmer votre mot de passe ?'
                ]
            ],
                'required' => true,
            ])
            ->add('Prenom', TextType::class,[
                'label' => 'Votre Prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 50,
                    'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
                ])
            ])
            ->add('Nom',TextType::class,[
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 50,
                    'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
                ])
            ])
            ->add('submit',SubmitType::class,[
                'label' => "S'inscrire",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
             'constraints' => [
                new UniqueEntity([
                    'fields' => 'email',
                    'message' => 'Cette adresse mail existe déja !',
                ]),
                
                
            ],
        ]);
    }
}
