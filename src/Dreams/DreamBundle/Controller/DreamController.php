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
        $dream = new Dream();
        $form = $this->container->get('form.factory')->create(new DreamForm(), $dream);

        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:create.html.twig',
            array(
                'form' => $form->createView(),
                'message' => ''
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