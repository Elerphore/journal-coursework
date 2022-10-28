<?php

namespace App\Form\Cms;

use App\Entity\AcademicYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcademicYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', IntegerType::class, [
                'label' => 'Год',
            ])
            ->add('mode', ChoiceType::class, [
                'label' => 'Режим',
                'choices' => [
                    AcademicYear::MODE_OPENED => AcademicYear::MODE_OPENED,
                    AcademicYear::MODE_CLOSED => AcademicYear::MODE_CLOSED,
                ],
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AcademicYear::class,
        ]);
    }
}
