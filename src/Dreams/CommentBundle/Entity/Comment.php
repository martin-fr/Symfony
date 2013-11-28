<?php

namespace Dreams\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;

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
}