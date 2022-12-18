<?php

namespace App\Controller;

use App\Entity\AcademicYear;
use App\Entity\Branch;
use App\Entity\Classhour;
use App\Entity\EventParticipation;
use App\Entity\Group;
use App\Entity\ParentsMeeting;
use App\Entity\Role;
use App\Entity\Student;
use App\Form\JournalChoiceType;
use App\FormData\AchievementsForm1Data;
use App\Repository\GroupRepository;
use App\Service\FormExportService;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route("/journal", name="app_journal_")
 * @IsGranted("ROLE_INSTRUCTOR")
 */
class JournalController extends AbstractController
{

    /**
     * @Route("/add_meeting_template", name="add_meeting_template")
     * */
    public function add_meeting_template(Request $request): Response
    {
        return $this->render('/teacher/add_meeting.html.twig');
    }

    /**
     * @Route("/add_classhour_template", name="add_classhour_template")
     * */
    public function add_classhour_template(Request $request): Response
    {
        return $this->render('/teacher/add_classhour.html.twig');
    }

    /**
     * @Route("/add_classhour", name="add_classhour")
     * */
    public function add_classhour(ManagerRegistry $doctrine, Request $request): Response
    {
        $date = $request->query->get('date');
        $form_date = \DateTime::createFromFormat("Y-d-m", $date);
        if (!$form_date)
        {
            throw new \UnexpectedValueException("Could not parse the date: $date");
        }

        $entityManager = $doctrine->getManager();

        $year = $entityManager->getRepository(AcademicYear::class)
            ->find($form_date->format('Y'));

        $group = $entityManager->getRepository(Group::class)
            ->find($this->getUser()->getSelectedGroup()->getId());

        $classHour = new Classhour();
        $classHour->setDate($form_date);
        $classHour->setAcademicYear($year);
        $classHour->setMonth($form_date->format('m'));
        $classHour->setGroup($group);
        $classHour->setSubject($request->query->get('theme'));
        $classHour->setQty($request->query->get('count'));

        $entityManager->persist($classHour);
        $entityManager->flush();

        return $this->redirectToRoute('app_journal_main');
    }

    /**
     * @Route("/add_meeting", name="add_meeting")
     * */
    public function add_meeting(ManagerRegistry $doctrine, Request $request): Response
    {
        $date = $request->query->get('date');
        $form_date = \DateTime::createFromFormat("Y-d-m", $date);
        if (!$form_date)
        {
            throw new \UnexpectedValueException("Could not parse the date: $date");
        }

        $entityManager = $doctrine->getManager();

        $year = $entityManager->getRepository(AcademicYear::class)
            ->find($form_date->format('Y'));

        $group = $entityManager->getRepository(Group::class)
            ->find($this->getUser()->getSelectedGroup()->getId());

        $meeting = new ParentsMeeting();
        $meeting->setDate($form_date);
        $meeting->setQty($request->query->get('count'));
        $meeting->setSubject($request->query->get('theme'));
        $meeting->setGroup($group);
        $meeting->setMonth($form_date->format('m'));
        $meeting->setAcademicYear($year);

        $entityManager->persist($meeting);
        $entityManager->flush();

        return $this->redirectToRoute('app_journal_main');
    }

    /**
     * @Route("/main", name="main")
     */
    public function main(ManagerRegistry $doctrine, Request $request) {
        $auth_checker = $this->get('security.authorization_checker');

        if($this->getUser()->getSelectedGroup() == null && !$auth_checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_group_selection');
        } else if($auth_checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_index', ['group' => 2]);
        }

        $entityManager = $doctrine->getManager();

        $students = $entityManager->getRepository(Student::class)
            ->createQueryBuilder('s')
            ->where('s.group = :groupId')
            ->setParameter('groupId', $this->getUser()->getSelectedGroup()->getId())
            ->getQuery()
            ->getResult();

        $selectedStudentId = $request->request->get('_selected_student');

        $student = null;
        if($selectedStudentId != null) {
            $student = $entityManager->getRepository(Student::class)->find($selectedStudentId);
        }

        $activeGroup = $entityManager->getRepository(Group::class)->find($this->getUser()->getSelectedGroup()->getId());

        $sql =
            '
            select
                pe.result as result,
                e.name as eventName,
                s.name as studentName,
                s.surname as studentSurname,
                g.name as groupName
            from
                participationevents pe
            left join event e on e.id = pe.id_event
            left join student s on s.id = pe.id_student
            left join `group` g on g.id = s.id_group
            group by g.id
            having g.id = :activeGroupId';

        $achivements = $entityManager->getConnection()
                        ->prepare($sql)
                        ->executeQuery(['activeGroupId' => $this->getUser()->getSelectedGroup()->getId()])
                        ->fetchAllAssociative();

        return $this->render('main.html.twig', array_merge_recursive([
            'activeStudent' => $student,
            'students' => $students,
            'activeGroup' => $activeGroup,
            'groupAchivements' => $achivements
        ]));
    }

    /**
     * @Route("/group/selection", name="group_selection")
     */
    public function groupSelection(ManagerRegistry $doctrine) {
        $entityManager = $doctrine->getManager();

        $groups = $entityManager->getRepository(Group::class)
            ->createQueryBuilder('g')
            ->where('g.roles = :roles')
            ->setParameter('roles', $this->getUser()->getId())
            ->getQuery()
            ->getResult();

        return $this->render('instructors/group_selection.html.twig', array_merge([
            'groups' => $groups,
            'current_id' => $this->getUser()->getId()
        ]));
    }

    /**
     * @Route("/group/setactive", name="set_active_group")
     * */
    public function setActiveGroup(ManagerRegistry $doctrine, Request $request) {
        $entityManager = $doctrine->getManager();

        $selectedGroupId = $request->request->get('_selected_group');

        $selectedGroup = $entityManager->getRepository(Group::class)->find($selectedGroupId);

        $user = $entityManager->getRepository(Role::class)->find($this->getUser()->getId());

        $user->setSelectedGroup($selectedGroup);

        $entityManager->persist($user);
        $entityManager->flush();


        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/{group}/{form}", name="index")
     */
    public function index(ServiceLocator $formDataContainer, ?Group $group = null, string $form = ''): Response
    {
        $auth_checker = $this->get('security.authorization_checker');

        if($this->getUser()->getSelectedGroup() == null && !$auth_checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_group_selection');
        }

        if ($group !== null) {
            $this->denyAccessUnlessGranted('GROUP_VIEW', $group);
        }

        if ($group === null && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_index', ['group' => 2]);
        }

        $choiceForm = $this->createForm(JournalChoiceType::class);
        $choiceForm->submit([
            'branch' => $group !== null ? $group->getSpecialty()->getBranch()->getId() : null,
            'group_search' => $group !== null ? $group->getName() : null,
            'group' => $group !== null ? $group->getId() : null,
            'form' => $form,
        ]);

        $formData = [];

        if ($group !== null && $formDataContainer->has($form)) {
            /** @var \App\FormData\FormDataInterface $formDataService */
            $formDataService = $formDataContainer->get($form);

            $formData = $formDataService->getData($group);

            $template = $form;
        } else {
            $template = 'index';
        }

        $template = "journal/form/{$template}.html.twig";

        return $this->render($template, array_merge([
            'choices' => $choiceForm->createView(),
            'group' => $group,
            'currentFormId' => $form,
        ], $formData));
    }

    /**
     * @Route("/groups/{branch}", name="groups", priority="1")
     * @IsGranted("ROLE_ADMIN")
     */
    public function groups(Branch $branch, GroupRepository $groupRepository): Response
    {
        return $this->json(
            [
                'groups' => $groupRepository->findByBranch($branch),
            ],
            200,
            [],
            [AbstractNormalizer::GROUPS => 'group_search']
        );
    }

    /**
     * @Route("/{group}/{form}/export", name="export")
     * @IsGranted("ROLE_INSTRUCTOR")
     */
    public function export(
        ServiceLocator $formDataContainer,
        Group $group,
        string $form,
        FormExportService $formExportService
    ): Response {
        $this->denyAccessUnlessGranted('GROUP_VIEW', $group);

        if (!$formDataContainer->has($form)) {
            throw $this->createNotFoundException();
        }

        /** @var \App\FormData\FormDataInterface $formDataService */
        $formDataService = $formDataContainer->get($form);

        $formData = $formDataService->getData($group);

        $template = "journal/form/export/{$form}.html.twig";

        $html = $this->render($template, array_merge([
            'group' => $group,
            'currentFormId' => $form,
            'export' => true,
        ], $formData))->getContent();

        $landscapeOrientationForms = [
            AchievementsForm1Data::getFormId(),
        ];

        $pageOrientation = in_array($form, $landscapeOrientationForms, true) ? 'L' : 'P';
        $formTitle = $formDataService::getFormName();

        $file = $formExportService->exportToPdf($pageOrientation, $formTitle, $html);

        return $this->file($file, $formTitle . '.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
