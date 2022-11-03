<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($options);
        $user = $options['user'];
        
        $builder
            ->add('adresses', EntityType::class, [
                'label'=> false,
                'required'=> true,
                'class'=> Adress::class,
                'multiple'=> false,
                //Récuperer uniquement les adresses du compte $user
                'choices'=> $user->getAdresses(),
                'expanded'=> true,

            ])
            ->add('carrieres', EntityType::class, [
                'label'=> false,
                'required'=> true,
                'class'=> Carrier::class,
                'multiple'=> false,
                'expanded'=> true,
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Valider ma commande ',
                'attr' => [
                    'class'=> 'btn btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
