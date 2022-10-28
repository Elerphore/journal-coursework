<?php

namespace App\Form\Cms;

use App\Entity\Parents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'label' => 'Фамилия',
            ])
            ->add('name', TextType::class, [
                'label' => 'Имя',
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'Отчество',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Номер телефона',
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
            ])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parents::class,
        ]);
    }
}
