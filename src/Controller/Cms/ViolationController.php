<?php

namespace App\Controller\Cms;

use App\Entity\Violation;
use App\Form\Cms\ViolationType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/violation", name="app_cms_violation_")
 */
class ViolationController extends AbstractController
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
        return $this->render('cms/violation/list.html.twig', [
            'violations' => $this->entityManager->getRepository(Violation::class)
                ->createQueryBuilder('v')
                ->select('v, tov, ay')
                ->innerJoin('v.typeOfViolation', 'tov')
                ->innerJoin('v.academicYear', 'ay')
                ->orderBy('v.date', 'DESC')
                ->addOrderBy('ay.id', 'DESC')
                ->addOrderBy('tov.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(ViolationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Violation::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{violation}/update", name="update")
     */
    public function update(Request $request, Violation $violation): Response
    {
        $form = $this->createForm(ViolationType::class, $violation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{violation}/delete", name="delete")
     */
    public function delete(Request $request, Violation $violation): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Violation::class)->remove($violation, true);
            }

            return $this->redirectToRoute('app_cms_violation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
