<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19/11/13
 * Time: 14:49
 */

namespace Dreams\DreamBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dreams\DreamBundle\Entity\Dream;
use Dreams\DreamBundle\Form\DreamForm;

class DreamController extends ContainerAware {

    public function showAction()
    {
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:show.html.twig');
    }

    public function createAction()
    {
        $error = 0;
        $message = '';
        $dream = new Dream();
        $form = $this->container->get('form.factory')->create(new DreamForm(), $dream);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
/*
            echo "<pre>";
            echo print_r($form->getErrors());
            echo "</pre>";exit;
*/
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getEntityManager();
                $em->persist($dream);
                $em->flush();
                $message = 'Rêve ajouté avec succès ! :-)';
            }
            else {
                $message = 'L\'ajout de votre rêve a échoué ! :-(';
                $error = 1;
            }
        }

        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:create.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
                'error' => $error
            ));
    }

    public function editAction($id)
    {
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:edit.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:delete.html.twig');
    }

} 