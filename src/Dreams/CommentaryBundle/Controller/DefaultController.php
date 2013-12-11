<?php

namespace Dreams\CommentaryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DreamsCommentaryBundle:Default:index.html.twig', array('name' => $name));
    }
}
