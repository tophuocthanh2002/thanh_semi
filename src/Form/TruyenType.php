<?php

namespace App\Form;

use App\Entity\Tacgia;
use App\Entity\Theloai;
use App\Entity\Truyen;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Chuong;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TruyenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tentruyen', TextType::class)
            ->add('hinhanh', FileType::class, [
                'required' => false,])

            ->add('tacgia', EntityType::class, [
                'class' => Tacgia::class,
                'choice_label' => 'tentacgia',
            ])
            ->add('theloai', EntityType::class, [
                'class' => Theloai::class,
                'choice_label' => 'ten_the_loai',
            ])

            ->add('mota', TextType::class)
            ->add('ngaydang', TextType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Truyen::class,
        ]);
    }
}
