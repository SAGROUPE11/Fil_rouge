<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class GrpcompetencesVoter extends Voter
{
    private $security =null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['GRPCOMPETENCES_EDIT', 'GRPCOMPETENCES_VIEW'])
            && $subject instanceof \App\Entity\BlogPost;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'GRPCOMPETENCES_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'GRPCOMPETENCES_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                if($this->security->isGranted('ROLE_ADMIN') || $subject === $user)
                {
                    return true;
                }
        }

        return false;
    }
}
