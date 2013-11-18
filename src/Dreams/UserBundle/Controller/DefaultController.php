<?php

namespace Dreams\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DreamsUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
