<?php

namespace App\Form\Cms;

use App\Entity\Conversation;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConversationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Дата',
                'years' => range((int) date('Y'), 1900, -1),
            ])
            ->add('reason', TextType::class, [
                'label' => 'Причина',
            ])
            ->add('note', TextType::class, [
                'label' => 'Примечание',
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
            'data_class' => Conversation::class,
        ]);
    }
}
