<?php

namespace App\Form;


use App\Entity\Chuong; // Add this import
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Truyen;


class ChuongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tenchuong', TextType::class)
            ->add('noidung', TextareaType::class)
            ->add('truyen', EntityType::class, [
                'class' => Truyen::class,
                'choice_label' => 'tentruyen', // Use the "tentruyen" property as the label
                'placeholder' => 'Choose a Truyen',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chuong::class,
        ]);
    }
}
