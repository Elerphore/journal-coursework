<?php

namespace App\Security\Voter;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupVoter extends Voter
{
    public const VIEW = 'GROUP_VIEW';

    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private Security $security;

    /**
     * @var \App\Repository\GroupRepository
     */
    private GroupRepository $groupRepository;

    public function __construct(Security $security, GroupRepository $groupRepository)
    {
        $this->security = $security;
        $this->groupRepository = $groupRepository;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::VIEW]) && $subject instanceof Group;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($this->security->isGranted('ROLE_INSTRUCTOR')) {
            return $this->groupRepository->find(2) === $subject;
        }

        return false;
    }
}
