<?php

namespace App\Controller\Cms;

use App\Entity\Classhour;
use App\Form\Cms\ClasshourType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/classhour", name="app_cms_classhour_")
 */
class ClasshourController extends AbstractController
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
        return $this->render('cms/classhour/list.html.twig', [
            'classhours' => $this->entityManager->getRepository(Classhour::class)
                ->createQueryBuilder('c')
                ->select('c, g, ay')
                ->innerJoin('c.group', 'g')
                ->innerJoin('c.academicYear', 'ay')
                ->orderBy('c.date', 'DESC')
                ->addOrderBy('g.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(ClasshourType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Classhour::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_classhour_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{classhour}/update", name="update")
     */
    public function update(Request $request, Classhour $classhour): Response
    {
        $form = $this->createForm(ClasshourType::class, $classhour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_classhour_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{classhour}/delete", name="delete")
     */
    public function delete(Request $request, Classhour $classhour): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Classhour::class)->remove($classhour, true);
            }

            return $this->redirectToRoute('app_cms_classhour_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
