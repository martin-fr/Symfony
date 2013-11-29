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
        // appel du gestionnaire d'entites permettant de manipuler nos objets (persistance, etc.)
        $em = $this->container->get('doctrine')->getEntityManager();

        // recuperation de tous les reves
        $dreams = $em->getRepository('DreamsDreamBundle:Dream')->findAll();

        // affichage du template show.html.twig avec les reves en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:show.html.twig',
            array(
                'dreams' => $dreams
            ));
    }

    public function createAction()
    {
        $error = 0; // passera a 1 s'il y a eu une erreur lors de la creation du reve
        $message = ''; // message apres ajout d'un reve
        $dream = new Dream();

        // generation du formulaire a partir de la classe DreamForm
        $form = $this->container->get('form.factory')->create(new DreamForm(), $dream);

        $request = $this->container->get('request');

        // si le formulaire d'ajout a ete utilise
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
            $userManager = $this->container->get('fos_user.user_manager');
            // recuperation du user connecte
            $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

            // si le formulaire est valide on ajoute le reve et on affiche le message de succes
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getEntityManager();
                $em->getRepository('DreamsDreamBundle:Dream')->createDream($dream, $user);

                $message = 'Rêve ajouté avec succès ! :-)';
            }
            // sinon on affiche le message d'echec et on indique qu'il y a une erreur
            else {
                $message = 'L\'ajout de votre rêve a échoué ! :-(';
                $error = 1;
            }
        }

        // affichage du template create.html.twig avec le formulaire, le message et l'indication d'erreur en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:create.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
                'error' => $error
            ));
    }

    public function mylistAction()
    {
        // appel du gestionnaire d'entites permettant de manipuler nos objets (persistance, etc.)
        $em = $this->container->get('doctrine')->getEntityManager();

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        // recuperation uniquement des reves du user connecte
        $dreams = $em->getRepository('DreamsDreamBundle:Dream')->getUserDreams($user);

        // affichage du template mylist.html.twig avec les reves du user connecte en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:mylist.html.twig',
            array(
                'dreams' => $dreams
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