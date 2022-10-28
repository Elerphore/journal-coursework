<?php

namespace App\Controller\Cms;

use App\Entity\HostelSchedule;
use App\Form\Cms\HostelScheduleType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/hostel_schedule", name="app_cms_hostel_schedule_")
 */
class HostelScheduleController extends AbstractController
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
        return $this->render('cms/hostel_schedule/list.html.twig', [
            'hostelSchedules' => $this->entityManager->getRepository(HostelSchedule::class)
                ->createQueryBuilder('hs')
                ->select('hs, s, ay')
                ->innerJoin('hs.student', 's')
                ->innerJoin('hs.academicYear', 'ay')
                ->orderBy('hs.date', 'DESC')
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
        $form = $this->createForm(HostelScheduleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(HostelSchedule::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_hostel_schedule_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{hostelSchedule}/update", name="update")
     */
    public function update(Request $request, HostelSchedule $hostelSchedule): Response
    {
        $form = $this->createForm(HostelScheduleType::class, $hostelSchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_hostel_schedule_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{hostelSchedule}/delete", name="delete")
     */
    public function delete(Request $request, HostelSchedule $hostelSchedule): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(HostelSchedule::class)->remove($hostelSchedule, true);
            }

            return $this->redirectToRoute('app_cms_hostel_schedule_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
