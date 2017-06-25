<?php

namespace PiupiuBundle\Controller;

use PiupiuBundle\Form\LoginFormType;
use Symfony\Component\HttpFoundation\Request;
use PiupiuBundle\Form\ChangePasswordFormType;
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
                    $request->getSession()->getFlashBag()->add('toast', 'An email has been send to you.');
                    return $this->redirectToRoute('piupiu_homepage');
                }
            }
        }

        return $this->render('PiupiuBundle:Authentication:pwd_forgot.html.twig', [
            'form'  => $form->createView(),
        ]);
    }

    public function changePwdAction(Request $request) {
        //todo: change pwd on first login (model and func)
        $flashBag   = $request->getSession()->getFlashBag();
        $encoder    = $this->container->get('security.password_encoder');
        $em         = $this->getDoctrine()->getManager();
        $user       = $this->get('security.token_storage')->getToken()->getUser();
        $firslogin  = $user->getFirstLogin();

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if (!$encoder->isPasswordValid($user, $data['old_password'])) {
                $flashBag->add('toast', 'Old password is incorrect');
            } else {
                if ($data['old_password'] != $data['new_password']) {
                $password = $encoder->encodePassword($user, $data['new_password']);
                $user->setPassword($password);
                $user->setFirstLogin(False);
                $em->persist($user);
                $em->flush();
                $flashBag->add('toast', 'Your password has been changed');
                return $this->redirectToRoute('piupiu_homepage');
                } else {
                    $flashBag->add('toast', 'Your old and new password cannot be identical');
                }
            }
        }

        return $this->render('PiupiuBundle:Authentication:change_password.html.twig', [
            'form'          => $form->createView(),
            'first_login'   => $firslogin
        ]);
    }}
