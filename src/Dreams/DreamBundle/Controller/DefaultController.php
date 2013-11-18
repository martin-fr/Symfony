<?php

namespace Dreams\DreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DreamsDreamBundle:Default:index.html.twig', array('name' => $name));
    }
}
