<?php

namespace App\Form\Cms;

use App\Entity\Event;
use App\Entity\EventParticipation;
use App\Entity\Student;
use App\Repository\EventRepository;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('result', TextType::class, [
                'label' => 'Result',
            ])
            ->add('event', EntityType::class, [
                'label' => 'id_event',
                'class' => Event::class,
                'query_builder' => function (EventRepository $repository) {
                    return $repository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
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
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventParticipation::class,
        ]);
    }
}
