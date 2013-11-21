<?php

namespace Dreams\CommentBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dreams\CommentBundle\Entity\Comment;
use Dreams\CommentBundle\Entity\Thread;

class CommentController extends ContainerAware {

    public function showAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        //$comments = $em->getRepository('DreamsCommentBundle:Dream')->findAll();

        return $this->container->get('templating')->renderResponse(

            'DreamsCommentBundle:Comment:show.html.twig'

            );
    }

} 