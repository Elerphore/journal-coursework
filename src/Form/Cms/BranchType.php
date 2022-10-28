<?php

namespace App\Form\Cms;

use App\Entity\Branch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BranchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Название'])
            ->add('number', IntegerType::class, ['label' => 'Номер'])
            ->add('supervisor', TextType::class, ['label' => 'Заведующий отделением'])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Branch::class,
        ]);
    }
}
