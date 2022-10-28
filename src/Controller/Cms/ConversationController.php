<?php

namespace App\Controller\Cms;

use App\Entity\Conversation;
use App\Form\Cms\ConversationType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/conversation", name="app_cms_conversation_")
 */
class ConversationController extends AbstractController
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
        return $this->render('cms/conversation/list.html.twig', [
            'conversations' => $this->entityManager->getRepository(Conversation::class)
                ->createQueryBuilder('c')
                ->select('c, s')
                ->innerJoin('c.student', 's')
                ->orderBy('c.date', 'DESC')
                ->addOrderBy('s.surname', 'ASC')
                ->addOrderBy('s.name', 'ASC')
                ->addOrderBy('s.patronymic', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(ConversationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(Conversation::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_conversation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{conversation}/update", name="update")
     */
    public function update(Request $request, Conversation $conversation): Response
    {
        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_conversation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{conversation}/delete", name="delete")
     */
    public function delete(Request $request, Conversation $conversation): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Conversation::class)->remove($conversation, true);
            }

            return $this->redirectToRoute('app_cms_conversation_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
