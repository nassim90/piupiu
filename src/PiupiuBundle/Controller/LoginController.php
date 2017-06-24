<?php

namespace PiupiuBundle\Controller;

use PiupiuBundle\Form\ChangePasswordFormType;
use PiupiuBundle\Form\LoginFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PiupiuBundle\Form\PasswordForgottenFormType;
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
        return $this->render('PiupiuBundle:Authentication:login.html.twig', [
            'last_username' => $helper->getLastUsername(),
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
        }

        return $this->render('PiupiuBundle:Authentication:pwd_forgot.html.twig', [
            'form'  => $form->createView(),
            'toast' => $toast
        ]);
    }

    public function changePwdAction() {
        //todo: change pwd on first login (model and func)
        $form = $this->createForm(ChangePasswordFormType::class);

        return $this->render('PiupiuBundle:Authentication:change_password.html.twig', [
            'form'  => $form->createView(),
        ]);
    }}
