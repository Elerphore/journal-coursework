<?php

namespace App\Controller;

use App\Entity\Group;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $auth_checker = $this->get('security.authorization_checker');

        if($auth_checker->isGranted('IS_AUTHENTICATED_FULLY') && $this->getUser()->getSelectedGroup() == null && !$auth_checker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('app_journal_group_selection');
        }
        else if($auth_checker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('app_journal_index', ['group' => 2]);
        }

        return $this->redirectToRoute('app_journal_main');
    }
}
