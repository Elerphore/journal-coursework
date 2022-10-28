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
                ->getQuery()
                ->getResult(),
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
