<?php

namespace Dreams\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DreamsCommentBundle:Default:index.html.twig', array('name' => $name));
    }
}
