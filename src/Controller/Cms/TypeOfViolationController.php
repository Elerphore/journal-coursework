<?php

namespace App\Controller\Cms;

use App\Entity\TypeOfViolation;
use App\Form\Cms\TypeOfViolationType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/type_of_violation", name="app_cms_type_of_violation_")
 */
class TypeOfViolationController extends AbstractController
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
        return $this->render('cms/type_of_violation/list.html.twig', [
            'typesOfViolation' => $this->entityManager->getRepository(TypeOfViolation::class)
                ->createQueryBuilder('tov')
                ->orderBy('tov.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(TypeOfViolationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(TypeOfViolation::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_type_of_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{typeOfViolation}/update", name="update")
     */
    public function update(Request $request, TypeOfViolation $typeOfViolation): Response
    {
        $form = $this->createForm(TypeOfViolationType::class, $typeOfViolation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_type_of_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{typeOfViolation}/delete", name="delete")
     */
    public function delete(Request $request, TypeOfViolation $typeOfViolation): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(TypeOfViolation::class)->remove($typeOfViolation, true);
            }

            return $this->redirectToRoute('app_cms_type_of_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
