<?php

namespace App\Security;

use App\Entity\Utilisateur as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {

        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->isVerified()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Votre compte n\'est pas encore actif. Merci de cliquer sur le lien d\'activation dans le mail que vous avez reçu lors de votre inscription.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {

        if (!$user instanceof AppUser) {
            return;
        }
        // dd("jjjj");
        // user account is expired, the user may be notified
        if (!$user->isVerified()) {
            throw new AccountExpiredException('...');
        }
    }
}