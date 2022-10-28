<?php

namespace App\Controller\Cms;

use App\Entity\AcademicYear;
use App\Form\Cms\AcademicYearType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/academic_year", name="app_cms_academic_year_")
 */
class AcademicYearController extends AbstractController
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
        return $this->render('cms/academic_year/list.html.twig', [
            'academicYears' => $this->entityManager->getRepository(AcademicYear::class)
                ->createQueryBuilder('ay')
                ->orderBy('ay.id', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(AcademicYearType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->getRepository(AcademicYear::class)->add($form->getData(), true);

            return $this->redirectToRoute('app_cms_academic_year_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{academicYear}/update", name="update")
     */
    public function update(Request $request, AcademicYear $academicYear): Response
    {
        $form = $this->createForm(AcademicYearType::class, $academicYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_academic_year_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{academicYear}/delete", name="delete")
     */
    public function delete(Request $request, AcademicYear $academicYear): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(AcademicYear::class)->remove($academicYear, true);
            }

            return $this->redirectToRoute('app_cms_academic_year_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
