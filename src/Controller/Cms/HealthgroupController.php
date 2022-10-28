<?php

namespace App\Controller\Cms;

use App\Entity\Healthgroup;
use App\Form\Cms\HealthgroupType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/healthgroup", name="app_cms_healthgroup_")
 */
class HealthgroupController extends AbstractController
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
        return $this->render('cms/healthgroup/list.html.twig', [
            'healthgroups' => $this->entityManager->getRepository(Healthgroup::class)
                ->createQueryBuilder('hg')
                ->orderBy('hg.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(HealthgroupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Healthgroup::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_healthgroup_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{healthgroup}/update", name="update")
     */
    public function update(Request $request, Healthgroup $healthgroup): Response
    {
        $form = $this->createForm(HealthgroupType::class, $healthgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_healthgroup_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{healthgroup}/delete", name="delete")
     */
    public function delete(Request $request, Healthgroup $healthgroup): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Healthgroup::class)->remove($healthgroup, true);
            }

            return $this->redirectToRoute('app_cms_healthgroup_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
