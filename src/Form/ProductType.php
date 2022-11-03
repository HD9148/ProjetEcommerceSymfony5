<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array('label' => 'Nom'))
            // ->add('slug')
            ->add('subtitle',TextType::class, array('label' => 'Subtitle'))
            // ->add('illustration' , FileType::class, array('label' => 'Image du produit'))
            ->add('imageFile' , VichImageType::class, array('label' => 'Image du produit'))
            ->add('description',CKEditorType::class, array('label' => 'Description'))
            ->add('price',MoneyType::class, array('label' => 'Price'))
            ->add('category' , EntityType::class, array('label' => 'Categorie', 'class' => Category::class , 'choice_label' => 'name',))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
