<?php
// src/Dreams/CommentaryBundle/Entity/Commentary.php

namespace Dreams\CommentaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;

/**
 * Dreams\DreamBundle\Entity\Dream
 *
 * @ORM\Entity(repositoryClass="Dreams\CommentaryBundle\Entity\CommentaryRepository")
 * @ORM\Table(name="commentaries")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Commentary extends BaseComment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Dreams\CommentaryBundle\Entity\Thread")
     */
    protected $thread;

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
     * Set thread
     *
     * @param \Dreams\CommentaryBundle\Entity\Thread $thread
     * @return Commentary
     */
    public function setThread(\Dreams\CommentaryBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;
    
        return $this;
    }

    /**
     * Get thread
     *
     * @return \Dreams\CommentaryBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }
}