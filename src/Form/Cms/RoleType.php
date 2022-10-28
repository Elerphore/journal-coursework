<?php

namespace App\Form\Cms;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class RoleType extends AbstractType
{
    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
            ])
            ->add('login', TextType::class, [
                'label' => 'Логин',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли должны совпадать.',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => ['label' => 'Пароль'],
                'second_options' => ['label' => 'Повтор пароля'],
                'mapped' => false,
                'required' => !isset($options['data']),
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Роль',
                'choices' => array_flip(Role::ROLE_NAMES),
                'disabled' => !$this->security->isGranted('ROLES_EDIT_ROLE', $options['data'] ?? null),
                'placeholder' => isset($options['data']) ? null : 'Выберите значение',
            ])
            ->add('submit', SubmitType::class, [
                'label' => isset($options['data']) ? 'Обновить' : 'Добавить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
