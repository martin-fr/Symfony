<?php
/**
 * Created by PhpStorm.
 * User: tristanchanteloup
 * Date: 28/11/2013
 * Time: 14:40
 */

namespace Dreams\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dreams\CommentBundle\Entity\VoteComment
 * @ORM\Entity(repositoryClass="Dreams\CommentBundle\Entity\VoteCommentRepository")
 * @ORM\Table(name="votes_comments")
 */
class VoteComment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\CommentBundle\Entity\Comment")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\UserBundle\Entity\User")
     */
    private $user;

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
     * Set comment
     *
     * @param \Dreams\CommentBundle\Entity\Comment $comment
     * @return VoteComment
     */
    public function setComment(\Dreams\CommentBundle\Entity\Comment $comment = null)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return \Dreams\CommentBundle\Entity\Comment 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set user
     *
     * @param \Dreams\UserBundle\Entity\User $user
     * @return VoteComment
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
}