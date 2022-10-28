<?php

namespace App\Controller;

use App\Form\CmsChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use function Symfony\Component\String\u;

class CmsController extends AbstractController
{
    /**
     * @Route("/cms", name="app_cms_index")
     */
    public function index(): Response
    {
        return $this->render("cms/index.html.twig");
    }

    public function tables(RequestStack $requestStack): Response
    {
        $attributes = $requestStack->getMainRequest()->attributes;

        $path = null;
        try {
            $path = $this->generateUrl(u($attributes->get('_route'))->beforeLast('_')->append('_index')->toString());
        } catch (RouteNotFoundException $exception) {
        }

        return $this->render('cms/_tables.html.twig', [
            'tables' => $this->createForm(CmsChoiceType::class, $path)->createView(),
        ]);
    }
}
