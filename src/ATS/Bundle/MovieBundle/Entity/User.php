<?php

namespace ATS\Bundle\MovieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 */
class User extends AbstractEntity implements UserInterface, \Serializable //EquatableInterface
{
    /**
     * @Serializer\Exclude()
     * 
     * @ORM\OneToMany(targetEntity="Movie", mappedBy="owner")
     * @var Movie[]
     */
    protected $movies;
    
    /**
     * #ORM\OneToMany(targetEntity="Review", mappedBy="user")
     * #var Review[]
     */
    //protected $reviews;
    
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var Integer
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", unique=true)
     * @var String
     */
    protected $username;
    
    /**
     * @Serializer\Exclude()
     * 
     * @ORM\Column(type="string")
     * @var String
     */
    protected $password;
    
    /**
     * User constructor.
     */
    public function __construct()
    {
        //$this->reviews = new ArrayCollection();
        $this->movies  = new ArrayCollection();
    }
    
    /**
     * @return Movie[]
     */
    public function getMovies()
    {
        return $this->movies;
    }
    
    /**
     * @param Movie $movie
     *
     * @return $this
     */
    public function addMovie(Movie $movie)
    {
        $this->movies->add($movie);
        
        return $this;
    }
    
    /**
     * @param Movie[] $movies
     *
     * @return User
     */
    public function setMovies($movies)
    {
        $this->movies = $movies;
        
        return $this;
    }
    
    /**
     * @return Review[]
     */
    /*public function getReviews()
    {
        return $this->reviews;
    }*/
    
    /**
     * @param Review $review
     *
     * @return $this
     */
    /*public function addReview(Review $review)
    {
        $this->reviews->add($review);
        
        return $this;
    }*/
    
    /**
     * @param Review[] $reviews
     *
     * @return User
     */
    /*public function setReviews($reviews)
    {
        $this->reviews = $reviews;
        
        return $this;
    }*/
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Required for the authentication process.
     * 
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @param String $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @param String $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ["ROLE_USER"];
    }
    
    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        
        return $this;
    }
    
    /**
     * @param $salt
     *
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            'id'       => $this->getId(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'salt'     => $this->getSalt(),
            'roles'    => $this->getRoles(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $results = unserialize($serialized);
        
        $this
            ->setId($results['id'])
            ->setUsername($results['username'])
            ->setPassword($results['password'])
            ->setSalt($results['salt'])
            ->setRoles($results['roles'])
        ;
    }
}