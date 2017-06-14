<?php

namespace PiupiuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function loginAction()
    {
        $error = $this->get('security.authentication_utils')
            ->getLastAuthenticationError();
        return $this->render('PiupiuBundle:Default:login.html.twig', [
            'error' => $error
        ]);
    }
}
