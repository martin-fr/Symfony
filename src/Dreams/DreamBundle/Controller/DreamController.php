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
        $error = 0; // passera a 1 s'il y a eu une erreur lors de la creation du reve
        $message = ''; // message apres modification du reve
        $error_security = 0; // passera a 1 si l'utilisateur qui tente de modifier le reve n'en est pas le createur

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        $em = $this->container->get('doctrine')->getEntityManager();
        $dream = $em->getRepository('DreamsDreamBundle:Dream')->findOneBy(array('id' => $id));

        if (!$dream) {
            $message = "Aucun rêve n'a été trouvé.";
        }
        elseif ($user != $dream->getUser()) {
            $message = "Vous n'êtes pas autorisé à modifier ce rêve.";
            $error_security = 1;
        }

        // generation du formulaire a partir de la classe DreamForm
        $form = $this->container->get('form.factory')->create(new DreamForm(), $dream);

        $request = $this->container->get('request');

        // si le formulaire de modification a ete utilise
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            // si le formulaire est valide on modifie le reve et on affiche le message de succes
            if ($form->isValid())
            {
                $em->getRepository('DreamsDreamBundle:Dream')->editDream($dream);

                $message = 'Rêve modifié avec succès ! :-)';
            }
            // sinon on affiche le message d'echec et on indique qu'il y a une erreur
            else {
                $message = 'La modification de votre rêve a échoué ! :-(';
                $error = 1;
            }
        }

        // affichage du template edit.html.twig avec le formulaire, le message et l'indication d'erreur en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:edit.html.twig',
            array(
                'form' => $form->createView(),
                'message' => $message,
                'error' => $error,
                'error_security' => $error_security,
                'dream' => $dream
            ));
    }

    public function deleteAction($id)
    {
        $error = 0; // passera a 1 s'il y a eu une erreur lors de la suppression du reve
        $message = ''; // message apres suppression du reve

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        $em = $this->container->get('doctrine')->getEntityManager();
        $dream = $em->getRepository('DreamsDreamBundle:Dream')->findOneBy(array('id' => $id));

        if (!$dream) {
            $message = "Aucun rêve n'a été trouvé.";
            $error = 1;
        }
        elseif ($user != $dream->getUser()) {
            $message = "Vous n'êtes pas autorisé à supprimer ce rêve.";
            $error = 1;
        }
        else {
            $em->getRepository('DreamsDreamBundle:Dream')->deleteDream($dream);

            $message = 'Rêve supprimé avec succès ! :-)';
        }

        // recuperation uniquement des reves du user connecte
        $dreams = $em->getRepository('DreamsDreamBundle:Dream')->getUserDreams($user);

        // affichage du template mylist.html.twig avec les reves en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:mylist.html.twig',
            array(
                'dreams' => $dreams,
                'message' => $message,
                'error' => $error
            ));
    }

} 