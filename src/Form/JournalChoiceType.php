<?php

namespace App\Form;

use App\Entity\Branch;
use App\Entity\Group;
use App\Repository\BranchRepository;
use App\Repository\GroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class JournalChoiceType extends AbstractType
{
    /**
     * @var \Symfony\Component\DependencyInjection\ServiceLocator
     */
    private ServiceLocator $formDataContainer;

    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private Security $security;

    public function __construct(ServiceLocator $formDataContainer, Security $security)
    {
        $this->formDataContainer = $formDataContainer;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder
                ->add('branch', EntityType::class, [
                    'label' => 'Отделение',
                    'class' => Branch::class,
                    'query_builder' => function (BranchRepository $repository) {
                        return $repository->createQueryBuilder('b')
                            ->orderBy('b.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'placeholder' => 'Выберите отделение',
                ])
                ->add('group', EntityType::class, [
                    'label' => 'Группа',
                    'attr' => [
                        'hidden' => true,
                    ],
                    'class' => Group::class,
                    'query_builder' => function (GroupRepository $repository) {
                        return $repository->createQueryBuilder('g')
                            ->orderBy('g.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'placeholder' => 'Выберите группу',
                ])
                ->add('group_search', TextType::class, [
                    'label' => 'Группа',
                ]);
        } else {
            $builder
                ->add('group', HiddenType::class, [
                    'label' => 'Группа',
                ]);
        }

        $builder
            ->add('form', ChoiceType::class, [
                'label' => 'Форма',
                'choice_loader' => new CallbackChoiceLoader(function () {
                    return $this->formDataContainer->getProvidedServices();
                }),
                'choice_label' => function (?string $class) {
                    if ($class === null) {
                        return '';
                    }

                    /** @var \App\FormData\FormDataInterface $class */

                    return $class::getFormName();
                },
                'choice_value' => function (?string $class) {
                    if ($class === null) {
                        return '';
                    }

                    /** @var \App\FormData\FormDataInterface $class */

                    return $class::getFormId();
                },
                'placeholder' => 'Выберите форму',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Показать',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (!isset($view->children['group_search'])) {
            return;
        }

        $groupSearch = $view->children['group_search'];
        if ($groupSearch->vars['value'] === null) {
            $groupSearch->vars['attr']['disabled'] = true;
        }
    }
}
