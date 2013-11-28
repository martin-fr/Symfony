<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28/11/13
 * Time: 14:44
 */

namespace Dreams\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dreams\DreamBundle\Entity\VoteDream
 *
 * @ORM\Entity(repositoryClass="Dreams\DreamBundle\Entity\VoteDreamRepository")
 * @ORM\Table(name="votes_dreams")
 */
class VoteDream {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\DreamBundle\Entity\Dream")
     */
    private $dream;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\UserBundle\Entity\User")
     */
    private $user;

} 