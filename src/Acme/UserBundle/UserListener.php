<?php

namespace Acme\UserBundle;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent,
Symfony\Component\HttpKernel\Event\GetResponseEvent,
Symfony\Component\HttpKernel\HttpKernelInterface;


class UserListener
{
     /**
     * security.interactive_login event. If a user chose a locale in preferences, it would be set,
     * if not, a locale that was set by setLocaleForUnauthenticatedUser remains.
     *
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function setLocaleForAuthenticatedUser(InteractiveLoginEvent $event)
    {

        $user = $event->getAuthenticationToken()->getUser();

        if ($user->getLanguage()->getIso2()) {
            $session = $event->getRequest()->getSession();
            $session->setLocale(strtolower($user->getLanguage()->getIso2()));
            $event->getRequest()->setSession($session);
        }
    }
}