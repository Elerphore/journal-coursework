<?php

namespace App\Form\Cms;

use App\Entity\Active;
use App\Entity\Group;
use App\Entity\Healthgroup;
use App\Entity\Status;
use App\Entity\Student;
use App\Repository\ActiveRepository;
use App\Repository\GroupRepository;
use App\Repository\HealthgroupRepository;
use App\Repository\StatusRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
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
            ->add('birthday', BirthdayType::class, [
                'label' => 'День рождения',
                'years' => range((int) date('Y'), 1900, -1),
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Адрес',
            ])
            ->add('actualAddress', TextareaType::class, [
                'label' => 'Актуальный адрес',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Номер телефона',
            ])
            ->add('hostel', TextType::class, [
                'label' => 'Общежитие',
            ])
            ->add('group', EntityType::class, [
                'label' => 'id_group',
                'class' => Group::class,
                'query_builder' => function (GroupRepository $repository) {
                    return $repository->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('healthgroup', EntityType::class, [
                'label' => 'id_healthGroup',
                'class' => Healthgroup::class,
                'query_builder' => function (HealthgroupRepository $repository) {
                    return $repository->createQueryBuilder('hg')
                        ->orderBy('hg.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('active', EntityType::class, [
                'label' => 'id_actives',
                'class' => Active::class,
                'query_builder' => function (ActiveRepository $repository) {
                    return $repository->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('status', EntityType::class, [
                'label' => 'id_status',
                'class' => Status::class,
                'query_builder' => function (StatusRepository $repository) {
                    return $repository->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
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
            'data_class' => Student::class,
        ]);
    }
}
