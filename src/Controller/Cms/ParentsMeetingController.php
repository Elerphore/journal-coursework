<?php

namespace App\Controller\Cms;

use App\Entity\ParentsMeeting;
use App\Form\Cms\ParentsMeetingType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/parents_meeting", name="app_cms_parents_meeting_")
 */
class ParentsMeetingController extends AbstractController
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
        return $this->render('cms/parents_meeting/list.html.twig', [
            'parentsMeetings' => $this->entityManager->getRepository(ParentsMeeting::class)
                ->createQueryBuilder('pm')
                ->select('pm, g, ay')
                ->innerJoin('pm.group', 'g')
                ->innerJoin('pm.academicYear', 'ay')
                ->orderBy('pm.date', 'DESC')
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
        $form = $this->createForm(ParentsMeetingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(ParentsMeeting::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_parents_meeting_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{parentsMeeting}/update", name="update")
     */
    public function update(Request $request, ParentsMeeting $parentsMeeting): Response
    {
        $form = $this->createForm(ParentsMeetingType::class, $parentsMeeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_parents_meeting_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{parentsMeeting}/delete", name="delete")
     */
    public function delete(Request $request, ParentsMeeting $parentsMeeting): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(ParentsMeeting::class)->remove($parentsMeeting, true);
            }

            return $this->redirectToRoute('app_cms_parents_meeting_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
