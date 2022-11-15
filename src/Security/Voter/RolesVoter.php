<?php

namespace App\Security\Voter;

use App\Entity\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class RolesVoter extends Voter
{
    public const EDIT_ROLE = 'ROLES_EDIT_ROLE';
    public const DELETE    = 'ROLES_DELETE';

    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT_ROLE, self::DELETE], true) && ($subject === null || $subject instanceof Role);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Действия доступны только админу
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT_ROLE:
            case self::DELETE:
                // Запрещаем пользователю изменить свою роль
                return $subject !== $user;
        }

        return false;
    }
}
