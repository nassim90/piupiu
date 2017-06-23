<?php

namespace PiupiuBundle\Controller;

use Doctrine\ORM\EntityManager;
use PiupiuBundle\Form\LoginFormType;
use PiupiuBundle\Form\PasswordForgottenFormType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function loginAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('piupiu_homepage');
        }

        $form = $this->createForm(LoginFormType::class);

        $helper = $this->get('security.authentication_utils');
        return $this->render('PiupiuBundle:Default:login.html.twig', [
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error'         => $helper->getLastAuthenticationError(),
            'form'          => $form->createView()
        ]);
    }

    public function pwdForgotAction(Request $request) {
        $toast = Null;
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('piupiu_homepage');
        }

        $form  = $this->createForm(PasswordForgottenFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email  = $form->getData();
            $em     = $this->getDoctrine()->getManager();
            $user   = $em->getRepository('PiupiuBundle:User')->findOneBy(['email' => $email]);
            $pwdService = $this->get('piupiu.password_forgotten');
            if ($user != Null) {
                $newpwd = $pwdService->generateNewPassword($user);
                if ($newpwd != False) {
                    $pwdService->sendNewPwdMail($user, $newpwd);
                    return $this->redirectToRoute('security_login');
                }
            }
            //todo: change pwd on first login (model and func)
        }

        return $this->render('PiupiuBundle:Default:pwd_forgot.html.twig', [
            'form'  => $form->createView(),
            'toast' => $toast
        ]);
    }
}
