<?php

namespace ATS\Bundle\MovieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @ORM\OneToMany(targetEntity="Movie", mappedBy="owner")
     * @var Movie[]
     */
    protected $movies;
    
    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="user")
     * @var Review[]
     */
    protected $reviews;
    
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var Integer
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     * @var String
     */
    protected $username;
    
    /**
     * @ORM\Column(type="string")
     * @var String
     */
    protected $password;
    
    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->movies  = new ArrayCollection();
    }
    
    /**
     * @return Movie[]
     */
    public function getMovies()
    {
        return $this->movies;
    }
    
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
    public function getReviews()
    {
        return $this->reviews;
    }
    
    public function addReview(Review $review)
    {
        $this->reviews->add($review);
        
        return $this;
    }
    
    /**
     * @param Review[] $reviews
     *
     * @return User
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
    
    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }
    
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return $this;
    }
}