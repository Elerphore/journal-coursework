<?php

namespace App\Form\Cms;

use App\Entity\AcademicYear;
use App\Entity\TypeOfViolation;
use App\Entity\Violation;
use App\Repository\AcademicYearRepository;
use App\Repository\TypeOfViolationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViolationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
            ])
            ->add('date', DateType::class, [
                'label' => 'Дата',
                'years' => range((int) date('Y'), 1900, -1),
            ])
            ->add('measuresTaken', TextareaType::class, [
                'label' => 'Принятые меры',
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Примечание',
            ])
            ->add('typeOfViolation', EntityType::class, [
                'label' => 'id_typeOfViolation',
                'class' => TypeOfViolation::class,
                'query_builder' => function (TypeOfViolationRepository $repository) {
                    return $repository->createQueryBuilder('tov')
                        ->orderBy('tov.name', 'ASC');
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
            'data_class' => Violation::class,
        ]);
    }
}
