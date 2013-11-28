<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 13/11/13
 * Time: 21:01
 */

namespace Dreams\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dreams\UserBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="Dreams\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Dreams\DreamBundle\Entity\Dream", mappedBy="user", cascade={"persist", "remove", "merge"})
     */
    private $dreams;

    public function __construct()
    {
        parent::__construct();

        $this->dreams = new ArrayCollection();
        $this->roles = array('ROLE_USER');
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
     * Add dreams
     *
     * @param \Dreams\DreamBundle\Entity\Dream $dreams
     * @return Dream
     */
    public function addDream(\Dreams\DreamBundle\Entity\Dream $dreams)
    {
        $this->dreams[] = $dreams;
    
        return $this;
    }

    /**
     * Remove dreams
     *
     * @param \Dreams\DreamBundle\Entity\Dream $dreams
     */
    public function removeDream(\Dreams\DreamBundle\Entity\Dream $dreams)
    {
        $this->dreams->removeElement($dreams);
    }

    /**
     * Get dreams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDreams()
    {
        return $this->dreams;
    }
}