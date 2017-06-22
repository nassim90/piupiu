<?php

namespace PiupiuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function loginAction()
    {
        //todo: create form
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('piupiu_homepage');
        }

        $helper = $this->get('security.authentication_utils');
        return $this->render('PiupiuBundle:Default:login.html.twig', [
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    public function pwdForgotAction(Request $request) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('piupiu_homepage');
        }

        //todo: create form
        $form  = $this->createForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            dump('got it'); die();
        }

        return $this->render('PiupiuBundle:Default:pwd_forgot.html.twig');
    }
}
