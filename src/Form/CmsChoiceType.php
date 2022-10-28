<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CmsChoiceType extends AbstractType
{
    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => $this->getChoices(),
            'placeholder' => 'Выберите таблицу',
        ]);
    }

    protected function getChoices(): array
    {
        return [
            'Академический год' => $this->urlGenerator->generate('app_cms_academic_year_index'),
            'Актив' => $this->urlGenerator->generate('app_cms_active_index'),
            'Отделение' => $this->urlGenerator->generate('app_cms_branch_index'),
            'Классный час' => $this->urlGenerator->generate('app_cms_classhour_index'),
            'Беседа' => $this->urlGenerator->generate('app_cms_conversation_index'),
            'Мероприятие' => $this->urlGenerator->generate('app_cms_event_index'),
            'Участие в мероприятиях' => $this->urlGenerator->generate('app_cms_event_participation_index'),
            'Группа' => $this->urlGenerator->generate('app_cms_group_index'),
            'Группа здоровья' => $this->urlGenerator->generate('app_cms_healthgroup_index'),
            'Общежитие' => $this->urlGenerator->generate('app_cms_hostel_schedule_index'),
            'Преподаватель' => $this->urlGenerator->generate('app_cms_instructor_index'),
            'Родитель' => $this->urlGenerator->generate('app_cms_parents_index'),
            'Родительское собрание' => $this->urlGenerator->generate('app_cms_parents_meeting_index'),
            'Тип родителя' => $this->urlGenerator->generate('app_cms_parent_type_index'),
            'Роли' => $this->urlGenerator->generate('app_cms_role_index'),
            'Специальность' => $this->urlGenerator->generate('app_cms_specialty_index'),
            'Статус' => $this->urlGenerator->generate('app_cms_status_index'),
            'Студент' => $this->urlGenerator->generate('app_cms_student_index'),
            'Студент_родитель_тип родителя' => $this->urlGenerator->generate('app_cms_student_parent_index'),
            'Студент_нарушение' => $this->urlGenerator->generate('app_cms_student_violation_index'),
            'Тип мероприятия' => $this->urlGenerator->generate('app_cms_type_of_event_index'),
            'Тип нарушения' => $this->urlGenerator->generate('app_cms_type_of_violation_index'),
            'Нарушение' => $this->urlGenerator->generate('app_cms_violation_index'),
        ];
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
