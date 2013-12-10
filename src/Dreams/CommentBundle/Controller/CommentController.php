<?php

namespace Dreams\CommentBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Dreams\CommentBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dreams\CommentBundle\Form\CommentForm;

class CommentController extends ContainerAware {

    public function showAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $comments = $em->getRepository('DreamsCommentBundle:Comment')->findAll();
        return $this->container->get('templating')->renderResponse('DreamsCommentBundle:Comment:show.html.twig',
            array(
                'comments' => $comments
            ));
        //return $this->container->get('templating')->renderResponse(

            //'DreamsCommentBundle:Comment:show.html.twig'

            //);
    }

    public function createAction()
    {
        $message = 'ceci est le message';
        $comment = new Comment();
        $form = $this->container->get('form.factory')->create(new CommentForm(), $comment);
        $request = $this->container->get('request');
        //appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getEntityManager();
                $em->getRepository('DreamsCommentBundle:Comment')->createComment($comment, $user);
                $message='Commentaire ajouté avec succès !';
            }
        }
        return $this->container->get('templating')->renderResponse(
            'DreamsCommentBundle:Comment:create.html.twig',
        array(
            'form' => $form->createView(),
            'message' => $message,
        ));
    }

    public function editAction($id)
    {
        return $this->container->get('templating')->renderResponse(
            'DreamsCommentBundle:Comment:edit.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->container->get('templating')->renderResponse(
            'DreamsCommentBundle:Comment:delete.html.twig');
    }
} 