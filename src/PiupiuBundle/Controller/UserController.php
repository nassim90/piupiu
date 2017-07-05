<?php

namespace PiupiuBundle\Controller;

use PiupiuBundle\Form\ChangeProfilType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function profilAction(Request $request) {
        $em         = $this->getDoctrine()->getManager();
        $flashbag   = $request->getSession()->getFlashBag();
        $cur_user   = $this->get('security.token_storage')->getToken()->getUser();
        // redirect if trying to go onto another users profil
        $form       = $this->createForm(ChangeProfilType::class, $cur_user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($cur_user);
            $em->flush();
            $flashbag->add('toast', 'Your account information have been updated.');
        }


        return $this->render('PiupiuBundle:User:profil.html.twig', [
            'user'      => $cur_user,
            'form'      => $form->createView(),
        ]);
    }
}