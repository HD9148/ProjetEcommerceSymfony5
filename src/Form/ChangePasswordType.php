<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled'=>true,
                'label'=> 'Mon adresse email'
            ])
            ->add('firstName', TextType::class, [
                'disabled'=>true,
                'label'=> 'Mon prénom'
            ])
            ->add('lastName', TextType::class, [
                    'disabled'=>true,
                    'label'=> 'Mon nom'
            ])
            ->add('old_password', PasswordType::class, [
                'mapped'=>false,
                'label'=> 'Mon mot de passe actuel',
                'attr'=> [
                    'placeholder'=>'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'mapped'=>false,
                'type'=> PasswordType::class,
                'invalid_message'=>'Le mot de passe et la confirmation doivent être identique.',
                'label' =>'Nouveau mot de passe',
                'required'=>true,
                "first_options"=>[
                    "label"=>"Nouveau mot de passe",
                    'attr'=>[
                        'placeholder'=> 'Merci de saisir nouveau votre mot de passe.'
                    ]
                    ],
                    "second_options"=>[
                        "label"=>"Confirmez votre nouveau mot de passe",
                        'attr'=>[
                            'placeholder'=> 'Merci de confirmer nouveau votre mot de passe.'
                        ]
                    ]
            ])
            
            ->add('submit', SubmitType::class, [
                'label'=>"Mise à jour"
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
