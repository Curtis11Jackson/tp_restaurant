<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AddOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $name = $options['add_order_content'];
        $price = $options['add_order_totalPrice'];

        $builder
            ->add('content', TextType::class,['attr' => ['class' => 'form-control',
            'placeholder' => 'Menu'],
            'disabled' => true,
            ])

            ->add('totalPrice', TextType::class,['attr' => ['class' => 'form-control ',
            'placeholder' => 'Price'],
            'disabled' => true,
            ])

            ->add('Order', SubmitType::class,['attr' => ['class' => 'btn btn-success mt-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            "add_order_content" => null,
            "add_order_totalPrice" => null,
        ]);
    }
}
