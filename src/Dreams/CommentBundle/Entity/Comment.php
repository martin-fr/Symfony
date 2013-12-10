<?php

namespace Dreams\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dreams\CommentBundle\Entity\Comment
 * @ORM\Entity(repositoryClass="Dreams\CommentBundle\Entity\CommentRepository")
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $answerTo;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\DreamBundle\Entity\Dream")
     */
    private $dream;

    /**
     * @ORM\ManyToOne(targetEntity="Dreams\UserBundle\Entity\User")
     */
    private $user;

    public function __construct()
    {
        $this->dateCreate = new \DateTime('now');
        $this->dateUpdate = new \DateTime('now');
        $this->note = 0;
    }

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
     * Set description
     *
     * @param string $description
     * @return Comment
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Comment
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    
        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return Comment
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    
        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return Comment
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set answerTo
     *
     * @param integer $answerTo
     * @return Comment
     */
    public function setAnswerTo($answerTo)
    {
        $this->answerTo = $answerTo;
    
        return $this;
    }

    /**
     * Get answerTo
     *
     * @return integer 
     */
    public function getAnswerTo()
    {
        return $this->answerTo;
    }

    /**
     * Set dream
     *
     * @param \Dreams\DreamBundle\Entity\Dream $dream
     * @return Comment
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
     * @return Comment
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