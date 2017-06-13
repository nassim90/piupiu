<?php

namespace PiupiuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $gapi = $this->container->getParameter('google_api');
        return $this->render('PiupiuBundle:Default:index.html.twig', [
            'api_key' => $gapi,
        ]);
    }

    public function currentLocationAction()
    {
        $gapi = $this->container->getParameter('google_api');
        return $this->render('PiupiuBundle:Default:current_location.html.twig', [
            'api_key' => $gapi,
        ]);
    }
}
