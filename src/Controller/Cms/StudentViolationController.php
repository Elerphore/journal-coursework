<?php

namespace App\Controller\Cms;

use App\Entity\StudentViolation;
use App\Form\Cms\StudentViolationType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/student_violation", name="app_cms_student_violation_")
 */
class StudentViolationController extends AbstractController
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
        return $this->render('cms/student_violation/list.html.twig', [
            'studentsViolations' => $this->entityManager->getRepository(StudentViolation::class)
                ->createQueryBuilder('sv')
                ->select('sv, s, v')
                ->innerJoin('sv.student', 's')
                ->innerJoin('sv.violation', 'v')
                ->orderBy('v.date', 'DESC')
                ->addOrderBy('s.surname', 'ASC')
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
        $form = $this->createForm(StudentViolationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(StudentViolation::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_student_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{studentViolation}/update", name="update")
     */
    public function update(Request $request, StudentViolation $studentViolation): Response
    {
        $form = $this->createForm(StudentViolationType::class, $studentViolation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_student_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{studentViolation}/delete", name="delete")
     */
    public function delete(Request $request, StudentViolation $studentViolation): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(StudentViolation::class)->remove($studentViolation, true);
            }

            return $this->redirectToRoute('app_cms_student_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
