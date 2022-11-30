<?php

namespace App\Controller\Cms;

use App\Entity\Student;
use App\Form\Cms\StudentType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/student", name="app_cms_student_")
 */
class StudentController extends AbstractController
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {

        $auth_checker = $this->get('security.authorization_checker');

        $groupId = null;
        $userId = null;

        if($this->getUser()->getSelectedGroup() == null && !$auth_checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_group_selection');
        } else if($auth_checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_index', ['group' => 2]);
        }

        if($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $userId = null;
            $groupId = null;
        }
        else
        {
            $userId = $this->getUser()->getId();
            $groupId = $this->getUser()->getSelectedGroup()->getId();
        }


        return $this->render('cms/student/list.html.twig', [
            'students' => $this->entityManager->getRepository(Student::class)
                ->createQueryBuilder('s')
                ->select('s, g, hg, a, st')
                ->innerJoin('s.group', 'g')
                ->innerJoin('s.healthgroup', 'hg')
                ->innerJoin('s.active', 'a')
                ->innerJoin('s.status', 'st')
                ->orderBy('s.surname', 'ASC')
                ->addOrderBy('s.name', 'ASC')
                ->addOrderBy('s.patronymic', 'ASC')
                ->where('g.roles = :roles or :roles is null')
                ->andWhere('g.id = :userActiveGroup or :userActiveGroup is null')
                ->setParameter('roles', $userId)
                ->setParameter('userActiveGroup', $groupId)
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/filter", name="filter")
     */
    public function filter(Request $request): Response
    {
        $students = $this->entityManager->getRepository(Student::class)
            ->createQueryBuilder('s')
            ->select('s, g, hg, a, st')
            ->innerJoin('s.group', 'g')
            ->innerJoin('s.healthgroup', 'hg')
            ->innerJoin('s.active', 'a')
            ->innerJoin('s.status', 'st')
            ->orderBy('s.surname', 'ASC')
            ->addOrderBy('s.name', 'ASC')
            ->addOrderBy('s.patronymic', 'ASC')
            ->where('g.roles = :roles')
            ->andWhere('(s.name like :name and :name is not null) or :name is null')
            ->andWhere('(s.surname like :surname and :surname is not null) or :surname is null')
            ->andWhere('(s.patronymic like :patronymic and :patronymic is not null) or :patronymic is null')
            ->setParameters(
                [
                    'name' => '%'.$request->query->get('name').'%',
                    'surname' => '%'.$request->query->get('surname').'%',
                    'patronymic' => '%'.$request->query->get('patronymic').'%',
                    'roles' => $this->getUser()->getId()
                ]
            )
            ->getQuery()
            ->getResult();

        return $this->render('cms/student/list.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(StudentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Student::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_student_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{student}/update", name="update")
     */
    public function update(Request $request, Student $student): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_student_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{student}/delete", name="delete")
     */
    public function delete(Request $request, Student $student): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Student::class)->remove($student, true);
            }

            return $this->redirectToRoute('app_cms_student_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
