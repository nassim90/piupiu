<?php

namespace PiupiuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PiupiuBundle:Default:index.html.twig');
    }
}
