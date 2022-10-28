<?php

namespace App\Controller\Cms;

use App\Entity\Specialty;
use App\Form\Cms\SpecialtyType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/specialty", name="app_cms_specialty_")
 */
class SpecialtyController extends AbstractController
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
        return $this->render('cms/specialty/list.html.twig', [
            'specialties' => $this->entityManager->getRepository(Specialty::class)
                ->createQueryBuilder('s')
                ->orderBy('s.cipher', 'ASC')
                ->addOrderBy('s.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(SpecialtyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Specialty::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_specialty_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{specialty}/update", name="update")
     */
    public function update(Request $request, Specialty $specialty): Response
    {
        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_specialty_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{specialty}/delete", name="delete")
     */
    public function delete(Request $request, Specialty $specialty): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Specialty::class)->remove($specialty, true);
            }

            return $this->redirectToRoute('app_cms_specialty_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
