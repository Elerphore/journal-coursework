<?php

namespace App\Form\Cms;

use App\Entity\Student;
use App\Entity\StudentViolation;
use App\Entity\Violation;
use App\Repository\StudentRepository;
use App\Repository\ViolationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentViolationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntityType::class, [
                'label' => 'id_student',
                'class' => Student::class,
                'query_builder' => function (StudentRepository $repository) {
                    return $repository->createQueryBuilder('s')
                        ->orderBy('s.surname', 'ASC')
                        ->addOrderBy('s.name', 'ASC')
                        ->addOrderBy('s.patronymic', 'ASC');
                },
                'choice_label' => 'fio',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('violation', EntityType::class, [
                'label' => 'id_violation',
                'class' => Violation::class,
                'query_builder' => function (ViolationRepository $repository) {
                    return $repository->createQueryBuilder('v')
                        ->orderBy('v.date', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentViolation::class,
        ]);
    }
}
