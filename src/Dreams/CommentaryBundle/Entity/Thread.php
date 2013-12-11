<?php
// src/Dreams/CommentaryBundle/Entity/Thread.php

namespace Dreams\CommentaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * Dreams\DreamBundle\Entity\Dream
 *
 * @ORM\Entity(repositoryClass="Dreams\CommentaryBundle\Entity\ThreadRepository")
 * @ORM\Table(name="threads")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread
{
    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * Set id
     *
     * @param string $id
     * @return Thread
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}