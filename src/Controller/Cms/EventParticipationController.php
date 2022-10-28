<?php

namespace App\Controller\Cms;

use App\Entity\EventParticipation;
use App\Form\Cms\EventParticipationType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/event_participation", name="app_cms_event_participation_")
 */
class EventParticipationController extends AbstractController
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
        return $this->render('cms/event_participation/list.html.twig', [
            'eventParticipations' => $this->entityManager->getRepository(EventParticipation::class)
                ->createQueryBuilder('ep')
                ->select('ep, e, s')
                ->innerJoin('ep.event', 'e')
                ->innerJoin('ep.student', 's')
                ->orderBy('e.date', 'DESC')
                ->addOrderBy('s.surname', 'ASC')
                ->addOrderBy('s.name', 'ASC')
                ->addOrderBy('s.patronymic', 'ASC')
                ->addOrderBy('ep.result', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(EventParticipationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(EventParticipation::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_event_participation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{eventParticipation}/update", name="update")
     */
    public function update(Request $request, EventParticipation $eventParticipation): Response
    {
        $form = $this->createForm(EventParticipationType::class, $eventParticipation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_event_participation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{eventParticipation}/delete", name="delete")
     */
    public function delete(Request $request, EventParticipation $eventParticipation): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(EventParticipation::class)->remove($eventParticipation, true);
            }

            return $this->redirectToRoute('app_cms_event_participation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
