<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=> 'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr' => [
                    'placeholder'=>' Nommez votre adresse'
                ]
            ])
            ->add('firstName', TextType::class,[
                'label'=> 'Votre prénom',
                'attr' => [
                    'placeholder'=>'Entrez votre prénom'
                ]
            ])
            ->add('lastName', TextType::class,[
                'label'=> 'Votre nom',
                'attr' => [
                    'placeholder'=>' Entrez votre nom'
                ]
            ])
            ->add('company', TextType::class,[
                'label'=> 'Votre société',
                'required'=> false,
                'attr' => [
                    'placeholder'=>' Entrez votre société (facultatif)'
                ]
            ])
            ->add('adress', TextType::class,[
                'label'=> 'Votre adresse',
                'attr' => [
                    'placeholder'=>'10 rue des acacias...'
                ]
            ])
            ->add('codePostal', TextType::class,[
                'label'=> 'Votre code postal',
                'attr' => [
                    'placeholder'=>' Entrez votre code postal '
                ]
            ])
            ->add('city', TextType::class,[
                'label'=> 'Votre ville',
                'attr' => [
                    'placeholder'=>'Paris'
                ]
            ])
            ->add('pays', CountryType::class,[
                'label'=> 'Votre pays',
                
            ])
            ->add('phone', TelType::class,[
                'label'=> 'Votre numéro de téléphone ',
                'attr' => [
                    'placeholder'=>' Entrez votre numéro de téléphone '
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Valider',
                'attr'=>[
                    'class'=> 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
