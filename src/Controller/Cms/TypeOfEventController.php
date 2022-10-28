<?php

namespace App\Controller\Cms;

use App\Entity\TypeOfEvent;
use App\Form\Cms\TypeOfEventType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/type_of_event", name="app_cms_type_of_event_")
 */
class TypeOfEventController extends AbstractController
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
        return $this->render('cms/type_of_event/list.html.twig', [
            'typesOfEvent' => $this->entityManager->getRepository(TypeOfEvent::class)
                ->createQueryBuilder('toe')
                ->orderBy('toe.name', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(TypeOfEventType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(TypeOfEvent::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_type_of_event_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{typeOfEvent}/update", name="update")
     */
    public function update(Request $request, TypeOfEvent $typeOfEvent): Response
    {
        $form = $this->createForm(TypeOfEventType::class, $typeOfEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_type_of_event_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{typeOfEvent}/delete", name="delete")
     */
    public function delete(Request $request, TypeOfEvent $typeOfEvent): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(TypeOfEvent::class)->remove($typeOfEvent, true);
            }

            return $this->redirectToRoute('app_cms_type_of_event_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
