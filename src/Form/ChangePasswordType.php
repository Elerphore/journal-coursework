<?php

namespace App\Form;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', EntityType::class, [
                'label' => 'Логин',
                'class' => Role::class,
                'query_builder' => function (RoleRepository $repository) {
                    return $repository->createQueryBuilder('r')
                        ->orderBy('r.login', 'ASC');
                },
                'choice_label' => 'login',
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
                'mapped' => false,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли должны совпадать.',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options' => ['label' => 'Пароль'],
                'second_options' => ['label' => 'Повтор пароля'],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Изменить пароль',
            ]);
    }
}
