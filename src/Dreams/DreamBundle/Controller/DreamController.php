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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dreams\DreamBundle\Entity\Dream;
use Dreams\DreamBundle\Form\DreamForm;

class DreamController extends ContainerAware {

    public function showAction() {

        // appel du gestionnaire d'entites permettant de manipuler nos objets (persistance, etc.)
        $em = $this->container->get('doctrine')->getEntityManager();

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        // recuperation de tous les reves
        $dreams = $em->getRepository('DreamsDreamBundle:Dream')->findAll();

        // recuperation de tous les reves pour lesquels l'utilisateur connecte a deja vote
        $dreamsVoted = $em->getRepository('DreamsDreamBundle:VoteDream')->getUserDreamsVoted($user);

        // recuperation de tous les votes de reves
        $voteDreams = $em->getRepository('DreamsDreamBundle:VoteDream')->findAll();

        $paginator = $this->container->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dreams,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        // affichage du template show.html.twig avec les reves en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:show.html.twig',
            array(
                'pagination' => $pagination,
                'dreamsVoted' => $dreamsVoted,
                'voteDreams' => $voteDreams
            ));
    }

    public function createAction() {

        $error = 0; // passera a 1 s'il y a eu une erreur lors de la creation du reve
        $message = ''; // message apres ajout d'un reve
        $dream = new Dream();

        // generation du formulaire a partir de la classe DreamForm
        $form = $this->container->get('form.factory')->create(new DreamForm(), $dream);

        $request = $this->container->get('request');

        // si le formulaire d'ajout a ete utilise
        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
            $userManager = $this->container->get('fos_user.user_manager');
            // recuperation du user connecte
            $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

            // si le formulaire est valide on ajoute le reve et on affiche le message de succes
            if ($form->isValid()) {

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

    public function mylistAction() {

        // appel du gestionnaire d'entites permettant de manipuler nos objets (persistance, etc.)
        $em = $this->container->get('doctrine')->getEntityManager();

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        // recuperation de tous les votes de reves
        $voteDreams = $em->getRepository('DreamsDreamBundle:VoteDream')->findAll();

        // recuperation uniquement des reves du user connecte
        $dreams = $em->getRepository('DreamsDreamBundle:Dream')->getUserDreams($user);

        $paginator = $this->container->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dreams,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        // affichage du template mylist.html.twig avec les reves du user connecte en parametres
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:mylist.html.twig',
            array(
                'pagination' => $pagination,
                'voteDreams' => $voteDreams
            ));
    }

    public function editAction($id) {

        $error = 0; // passera a 1 s'il y a eu une erreur lors de la creation du reve
        $message = ''; // message apres modification du reve
        $error_security = 0; // passera a 1 si l'utilisateur qui tente de modifier le reve n'en est pas le createur

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        $em = $this->container->get('doctrine')->getEntityManager();
        // recuperation du reve correspondant a l'id
        $dream = $em->getRepository('DreamsDreamBundle:Dream')->findOneBy(array('id' => $id));

        // s'il n'y a pas de reve correspondant a l'id on affiche un message d'erreur
        if (!$dream) {
            $message = "Aucun rêve n'a été trouvé.";
            $error = 1;
        }
        // si l'utilisateur connecte n'est pas le createur du reve on affiche egalement un message d'erreur
        elseif ($user != $dream->getUser()) {
            $message = "Vous n'êtes pas autorisé à modifier ce rêve.";
            $error_security = 1;
        }

        // generation du formulaire a partir de la classe DreamForm
        $form = $this->container->get('form.factory')->create(new DreamForm(), $dream);

        $request = $this->container->get('request');

        // si le formulaire de modification a ete utilise
        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            // si le formulaire est valide on modifie le reve et on affiche le message de succes
            if ($form->isValid()) {

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

    public function deleteAction($id) {

        $error = 0; // passera a 1 s'il y a eu une erreur lors de la suppression du reve
        $message = ''; // message apres suppression du reve

        // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
        $userManager = $this->container->get('fos_user.user_manager');
        // recuperation du user connecte
        $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

        $em = $this->container->get('doctrine')->getEntityManager();
        // recuperation du reve correspondant a l'id
        $dream = $em->getRepository('DreamsDreamBundle:Dream')->findOneBy(array('id' => $id));

        // s'il n'y a pas de reve correspondant a l'id on affiche un message d'erreur
        if (!$dream) {
            $message = "Aucun rêve n'a été trouvé.";
            $error = 1;
        }
        // si l'utilisateur connecte n'est pas le createur du reve on affiche egalement un message d'erreur
        elseif ($user != $dream->getUser()) {
            $message = "Vous n'êtes pas autorisé à supprimer ce rêve.";
            $error = 1;
        }
        // sinon on supprimer le reve et on affiche un message de succes
        else {
            $em->getRepository('DreamsDreamBundle:Dream')->deleteDream($dream);

            $message = 'Rêve supprimé avec succès ! :-)';
        }

        // recuperation uniquement des reves du user connecte
        $dreams = $em->getRepository('DreamsDreamBundle:Dream')->getUserDreams($user);

        $paginator = $this->container->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dreams,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        // affichage du template mylist.html.twig avec les reves de l'utilisateur connecte, le message et l'indicateur d'erreur
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:mylist.html.twig',
            array(
                'pagination' => $pagination,
                'message' => $message,
                'error' => $error
            ));
    }

    public function searchAction() {

        $request = $this->container->get('request');

        // si le formulaire de recherche a ete utilise
        if ($request->getMethod() == 'GET') {

            // recuperation des mots cles que l'utilisateur souhaite rechercher
            $search = $request->query->get('search');

            $em = $this->container->get('doctrine')->getEntityManager();

            // recuperation des reves correspondant aux mots cles
            $dreams = $em->getRepository('DreamsDreamBundle:Dream')->searchDreams($search);
        }

        // recuperation de tous les votes de reves
        $voteDreams = $em->getRepository('DreamsDreamBundle:VoteDream')->findAll();

        $nbResultats = count($dreams);

        $paginator = $this->container->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dreams,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        // affichage du template search.html.twig avec les reves correspondant a la recherche et les mots cles utilises
        return $this->container->get('templating')->renderResponse(
            'DreamsDreamBundle:Dream:search.html.twig',
            array(
                'pagination' => $pagination,
                'voteDreams' => $voteDreams,
                'search' => $search,
                'nbResultats' => $nbResultats
            ));
    }

    public function voteAction() {

        $request = $this->container->get('request');
        $em = $this->container->get('doctrine')->getEntityManager();

        // si le formulaire de vote a ete utilise
        if($request->getMethod() == 'POST') {

            // recuperation de l'id du reve et du vote
            $id = $request->request->get('id');
            $vote = $request->request->get('vote');

            // recuperation du reve correspondant a l'id
            $dream = $em->getRepository('DreamsDreamBundle:Dream')->findOneBy(array('id' => $id));

            // appel du gestionnaire d'entites de FOSUserBundle permettant de manipuler nos objets (persistance, etc.)
            $userManager = $this->container->get('fos_user.user_manager');
            // recuperation du user connecte
            $user = $userManager->findUserByUsername($this->container->get('security.context')->getToken()->getUser());

            // vote pour le reve
            $em->getRepository('DreamsDreamBundle:VoteDream')->createVoteDream($dream, $user, $vote);

            return new Response("<small style='margin-left: 3%;'><strong>Vote enregistré !</strong></small>");
        }
        else {
            return new Response("error");
        }

    }

} 