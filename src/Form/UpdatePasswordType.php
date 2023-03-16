<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'disabled' => true,
                'label' => 'Mon adresse mail'
            ])
            ->add('old_password',PasswordType::class,[
                'label' => 'Mot de Passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrez votre mot de passe actuel ?'
                ]
            ])
            ->add('new_password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique !',
                'label' => 'Mot de Passe',
                'mapped'=> false,
                'required' => true,
                'first_options'  => ['label' => 'Nouveau',
            'attr'=>[
                'placeholder' => 'Entrez votre nouveau mot de passe ?'
            ]
            ],
                'second_options' => ['label' => 'Confirmer',  'attr'=>[
                    'placeholder' => 'Confirmer votre nouveau mot de passe ?'
                ]
            ],
                'required' => true,
            ])
            ->add('Prenom',TextType::class,[
                'disabled' => true
            ])
            ->add('Nom',TextType::class,[
                'disabled' => true
            ])
            ->add('submit',SubmitType::class,[
                'label' => "Modififez",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
