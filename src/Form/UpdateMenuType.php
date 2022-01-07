<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdateMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // $name = $options['name'];
        // $price = $options['price'];
        // $stock = $options['stock'];


        $builder
        ->add('name', TextType::class,['attr' => ['class' => 'form-control',
        'placeholder' => 'Name']
        // , 'data' => $name
        ])

        ->add('price', TextType::class,['attr' => ['class' => 'form-control',
        'placeholder' => 'Price']
        // , 'data' => $price
        ])

        ->add('stock', TextType::class,['attr' => ['class' => 'form-control',
        'placeholder' => 'Quantity'], 
        // 'data' => $stock
        ])

        ->add('Add', SubmitType::class,['attr' => ['class' => 'btn btn-success mt-2']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
