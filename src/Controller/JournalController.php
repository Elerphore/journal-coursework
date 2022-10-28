<?php

namespace App\Controller;

use App\Entity\Branch;
use App\Entity\Group;
use App\Form\JournalChoiceType;
use App\FormData\AchievementsForm1Data;
use App\Repository\GroupRepository;
use App\Service\FormExportService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route("/journal", name="app_journal_")
 * @IsGranted("ROLE_INSTRUCTOR")
 */
class JournalController extends AbstractController
{
    /**
     * @Route("/{group}/{form}", name="index")
     */
    public function index(ServiceLocator $formDataContainer, ?Group $group = null, string $form = ''): Response
    {
        if ($group !== null) {
            $this->denyAccessUnlessGranted('GROUP_VIEW', $group);
        }

        if ($group === null && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_journal_index', ['group' => 2]);
        }

        $choiceForm = $this->createForm(JournalChoiceType::class);
        $choiceForm->submit([
            'branch' => $group !== null ? $group->getSpecialty()->getBranch()->getId() : null,
            'group_search' => $group !== null ? $group->getName() : null,
            'group' => $group !== null ? $group->getId() : null,
            'form' => $form,
        ]);

        $formData = [];

        if ($group !== null && $formDataContainer->has($form)) {
            /** @var \App\FormData\FormDataInterface $formDataService */
            $formDataService = $formDataContainer->get($form);

            $formData = $formDataService->getData($group);

            $template = $form;
        } else {
            $template = 'index';
        }

        $template = "journal/form/{$template}.html.twig";

        return $this->render($template, array_merge([
            'choices' => $choiceForm->createView(),
            'group' => $group,
            'currentFormId' => $form,
        ], $formData));
    }

    /**
     * @Route("/groups/{branch}", name="groups", priority="1")
     * @IsGranted("ROLE_ADMIN")
     */
    public function groups(Branch $branch, GroupRepository $groupRepository): Response
    {
        return $this->json(
            [
                'groups' => $groupRepository->findByBranch($branch),
            ],
            200,
            [],
            [AbstractNormalizer::GROUPS => 'group_search']
        );
    }

    /**
     * @Route("/{group}/{form}/export", name="export")
     * @IsGranted("ROLE_INSTRUCTOR")
     */
    public function export(
        ServiceLocator $formDataContainer,
        Group $group,
        string $form,
        FormExportService $formExportService
    ): Response {
        $this->denyAccessUnlessGranted('GROUP_VIEW', $group);

        if (!$formDataContainer->has($form)) {
            throw $this->createNotFoundException();
        }

        /** @var \App\FormData\FormDataInterface $formDataService */
        $formDataService = $formDataContainer->get($form);

        $formData = $formDataService->getData($group);

        $template = "journal/form/{$form}.html.twig";

        $html = $this->render($template, array_merge([
            'group' => $group,
            'currentFormId' => $form,
            'export' => true,
        ], $formData))->getContent();

        $landscapeOrientationForms = [
            AchievementsForm1Data::getFormId(),
        ];

        $pageOrientation = in_array($form, $landscapeOrientationForms, true) ? 'L' : 'P';
        $formTitle = $formDataService::getFormName();

        $file = $formExportService->exportToPdf($pageOrientation, $formTitle, $html);

        return $this->file($file, $formTitle . '.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
