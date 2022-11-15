<?php

namespace App\Form\Cms;

use App\Entity\Group;
use App\Entity\Instructor;
use App\Entity\Specialty;
use App\Repository\InstructorRepository;
use App\Repository\SpecialtyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Год',
            ])
            ->add('specialty', EntityType::class, [
                'label' => 'id_specialty',
                'class' => Specialty::class,
                'query_builder' => function (SpecialtyRepository $repository) {
                    return $repository->createQueryBuilder('s')
                        ->orderBy('s.cipher', 'ASC')
                        ->addOrderBy('s.name', 'ASC');
                },
                'choice_label' => function (Specialty $specialty) {
                    return $specialty->getCipher() . ' ' . $specialty->getName();
                },
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
//            ->add('instructor', EntityType::class, [
//                'label' => 'id_instructor',
//                'class' => Instructor::class,
//                'query_builder' => function (InstructorRepository $repository) {
//                    return $repository->createQueryBuilder('i')
//                        ->orderBy('i.surname', 'ASC')
//                        ->addOrderBy('i.name', 'ASC')
//                        ->addOrderBy('i.patronymic', 'ASC');
//                },
//                'choice_label' => 'fio',
//                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
//            ])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
