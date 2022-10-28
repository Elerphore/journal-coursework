<?php

namespace App\Controller\Cms;

use App\Entity\Instructor;
use App\Form\Cms\InstructorType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/instructor", name="app_cms_instructor_")
 */
class InstructorController extends AbstractController
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
        return $this->render('cms/instructor/list.html.twig', [
            'instructors' => $this->entityManager->getRepository(Instructor::class)
                ->createQueryBuilder('i')
                ->orderBy('i.surname', 'ASC')
                ->addOrderBy('i.name', 'ASC')
                ->addOrderBy('i.patronymic', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(InstructorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Instructor::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_instructor_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{instructor}/update", name="update")
     */
    public function update(Request $request, Instructor $instructor): Response
    {
        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_instructor_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{instructor}/delete", name="delete")
     */
    public function delete(Request $request, Instructor $instructor): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Instructor::class)->remove($instructor, true);
            }

            return $this->redirectToRoute('app_cms_instructor_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
