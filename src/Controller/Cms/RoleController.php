<?php

namespace App\Controller\Cms;

use App\Entity\Role;
use App\Form\Cms\RoleType;
use App\Form\DeleteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/role", name="app_cms_role_")
 */
class RoleController extends AbstractController
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
        return $this->render('cms/role/list.html.twig', [
            'roles' => $this->entityManager->getRepository(Role::class)
                ->createQueryBuilder('r')
                ->orderBy('r.login', 'ASC')
                ->getQuery()
                ->getResult(),
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(RoleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Role $role */
            $role = $form->getData();
            $role->setPassword($passwordHasher->hashPassword($role, $form->get('password')->getData()));

            $this->entityManager->getRepository(Role::class)->add($role, true);

            return $this->redirectToRoute('app_cms_role_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{role}/update", name="update")
     */
    public function update(Request $request, Role $role, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get('password')->isEmpty()) {
                $role->setPassword($passwordHasher->hashPassword($role, $form->get('password')->getData()));
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('app_cms_role_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{role}/delete", name="delete")
     * @IsGranted("ROLES_DELETE", subject="role")
     */
    public function delete(Request $request, Role $role): Response
    {
        $form = $this->createForm(DeleteConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirm')) {
                $this->entityManager->getRepository(Role::class)->remove($role, true);
            }

            return $this->redirectToRoute('app_cms_role_index');
        }

        return $this->render('cms/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
