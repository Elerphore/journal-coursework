<?php

namespace App\Form\Cms;

use App\Entity\Parents;
use App\Entity\ParentType;
use App\Entity\Student;
use App\Entity\StudentParent;
use App\Repository\ParentsRepository;
use App\Repository\ParentTypeRepository;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentParentType extends AbstractType
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
            ->add('parent', EntityType::class, [
                'label' => 'id_parent',
                'class' => Parents::class,
                'query_builder' => function (ParentsRepository $repository) {
                    return $repository->createQueryBuilder('p')
                        ->orderBy('p.surname', 'ASC')
                        ->addOrderBy('p.name', 'ASC')
                        ->addOrderBy('p.patronymic', 'ASC');
                },
                'choice_label' => 'fio',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('parentType', EntityType::class, [
                'label' => 'id_typeofparent',
                'class' => ParentType::class,
                'query_builder' => function (ParentTypeRepository $repository) {
                    return $repository->createQueryBuilder('pt')
                        ->orderBy('pt.name', 'ASC');
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
            'data_class' => StudentParent::class,
        ]);
    }
}
