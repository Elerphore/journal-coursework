<?php

namespace App\Controller\Cms;

use App\Entity\StudentParent;
use App\Form\Cms\StudentParentType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/student_parent", name="app_cms_student_parent_")
 */
class StudentParentController extends AbstractController
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
        return $this->render('cms/student_parent/list.html.twig', [
            'studentsParents' => $this->entityManager->getRepository(StudentParent::class)
                ->createQueryBuilder('sp')
                ->select('sp, s, p, pt')
                ->innerJoin('sp.student', 's')
                ->innerJoin('sp.parent', 'p')
                ->innerJoin('sp.parentType', 'pt')
                ->orderBy('s.surname', 'ASC')
                ->addOrderBy('s.name', 'ASC')
                ->addOrderBy('s.patronymic', 'ASC')
                ->addOrderBy('p.surname', 'ASC')
                ->addOrderBy('p.name', 'ASC')
                ->addOrderBy('p.patronymic', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(StudentParentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(StudentParent::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_student_parent_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{studentParent}/update", name="update")
     */
    public function update(Request $request, StudentParent $studentParent): Response
    {
        $form = $this->createForm(StudentParentType::class, $studentParent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_student_parent_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{studentParent}/delete", name="delete")
     */
    public function delete(Request $request, StudentParent $studentParent): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(StudentParent::class)->remove($studentParent, true);
            }

            return $this->redirectToRoute('app_cms_student_parent_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
