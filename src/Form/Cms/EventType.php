<?php

namespace App\Form\Cms;

use App\Entity\AcademicYear;
use App\Entity\Event;
use App\Entity\TypeOfEvent;
use App\Form\MonthChoiceType;
use App\Repository\AcademicYearRepository;
use App\Repository\TypeOfEventRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
            ])
            ->add('month', MonthChoiceType::class, [
                'label' => 'Месяц',
            ])
            ->add('date', DateType::class, [
                'label' => 'Дата',
                'years' => range((int) date('Y'), 1900, -1),
            ])
            ->add('typeOfEvent', EntityType::class, [
                'label' => 'id_typeofevent',
                'class' => TypeOfEvent::class,
                'query_builder' => function (TypeOfEventRepository $repository) {
                    return $repository->createQueryBuilder('toe')
                        ->orderBy('toe.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('academicYear', EntityType::class, [
                'label' => 'id_academicYear',
                'class' => AcademicYear::class,
                'query_builder' => function (AcademicYearRepository $repository) {
                    return $repository->createQueryBuilder('ay')
                        ->orderBy('ay.id', 'DESC');
                },
                'choice_label' => 'id',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
