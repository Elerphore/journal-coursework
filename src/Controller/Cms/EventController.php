<?php

namespace App\Controller\Cms;

use App\Entity\Event;
use App\Form\Cms\EventType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/event", name="app_cms_event_")
 */
class EventController extends AbstractController
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
        return $this->render('cms/event/list.html.twig', [
            'events' => $this->entityManager->getRepository(Event::class)
                ->createQueryBuilder('e')
                ->select('e, ay, toe')
                ->innerJoin('e.academicYear', 'ay')
                ->innerJoin('e.typeOfEvent', 'toe')
                ->orderBy('e.date', 'DESC')
                ->addOrderBy('e.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Event::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_event_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{event}/update", name="update")
     */
    public function update(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_event_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{event}/delete", name="delete")
     */
    public function delete(Request $request, Event $event): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Event::class)->remove($event, true);
            }

            return $this->redirectToRoute('app_cms_event_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
