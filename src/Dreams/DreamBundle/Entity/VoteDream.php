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
     * @ORM\JoinColumn(name="dream_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $dream;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $vote;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dream
     *
     * @param \Dreams\DreamBundle\Entity\Dream $dream
     * @return VoteDream
     */
    public function setDream(\Dreams\DreamBundle\Entity\Dream $dream = null)
    {
        $this->dream = $dream;
    
        return $this;
    }

    /**
     * Get dream
     *
     * @return \Dreams\DreamBundle\Entity\Dream 
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Set user
     *
     * @param \Dreams\UserBundle\Entity\User $user
     * @return VoteDream
     */
    public function setUser(\Dreams\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Dreams\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get vote
     *
     * @return integer
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set vote
     *
     * @param integer $vote
     * @return VoteDream
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }
}