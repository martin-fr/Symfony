<?php

namespace Dreams\DreamBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Dreams\UserBundle\Entity\User;

/**
 * DreamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DreamRepository extends EntityRepository {

    // DreamRepository facilite l'acces aux objets Dream recuperes depuis la BDD

    public function createDream(Dream $dream, User $user = null) {

        $dream->setUser($user); // on affecte le user au reve passe en parametre

        // on ajoute le reve en BDD
        $em = $this->getEntityManager();

        $em->persist($dream);
        $em->flush();
    }

    public function editDream(Dream $dream) {

        // on modifie la dateUpdate
        $dream->setDateUpdate(new \DateTime('now'));

        // on modifie le reve en BDD
        $em = $this->getEntityManager();

        $em->persist($dream);
        $em->flush();
    }

    public function deleteDream(Dream $dream) {

        // on supprime le reve en BDD
        $em = $this->getEntityManager();

        $em->remove($dream);
        $em->flush();
    }

    public function editNoteDream(Dream $dream, $vote) {

        $em = $this->getEntityManager();

        // si le reve n'a pas encore de note on lui attribue le montant du vote comme note
        if ($dream->getNote() == 0) {
            $dream->setNote($vote);
        }
        else {
            // recuperation du nombre de votes du reve
            $nbVoteDream = $em->getRepository('DreamsDreamBundle:VoteDream')->getNbVoteDream($dream);
            // recuperation du montant total des votes du reve
            $totalVoteDream = $em->getRepository('DreamsDreamBundle:VoteDream')->getTotalVoteDream($dream);

            // actualisation de la note
            $dream->setNote($totalVoteDream / $nbVoteDream);
        }

        // on modifie le reve en BDD pour que la note soit actualisee

        $em->persist($dream);
        $em->flush();
    }

    public function searchDreams($search) {

        // separation des mots cles s'il y en a plusieurs pour les tester individuellement
        $keyWords = explode(' ', $search);

        $em = $this->getEntityManager();

        // on recupere tous les reves dont le titre ou la description correspond aux mots cles
        $qb = $em->createQueryBuilder();
        $qb->select('d')
            ->from('DreamsDreamBundle:Dream', 'd');
        foreach ($keyWords as $keyWord) {
            $qb->orWhere("d.title LIKE :keyWord")
                ->setParameter('keyWord','%'.$keyWord.'%');
            $qb->orWhere("d.description LIKE :keyWord")
                ->setParameter('keyWord','%'.$keyWord.'%');
        }
        $qb->orderBy('d.dateCreate', 'DESC');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function getUserDreams(User $user) {

        $em = $this->getEntityManager();

        // on recupere tous les reves dont le user est celui passe en parametre, trie par dateCreate les plus recentes
        $qb = $em->createQueryBuilder();
        $qb->select('d')
            ->from('DreamsDreamBundle:Dream', 'd')
            ->where('d.user = :user')
            ->setParameter('user',$user)
            ->orderBy('d.dateCreate', 'DESC');

        $query = $qb->getQuery();

        return $query->getResult();
    }

}
