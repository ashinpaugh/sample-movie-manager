<?php

namespace ATS\Bundle\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Review extends AbstractEntity
{
    /**
     * @ManyToOne(targetEntity="Movie", inversedBy="reviews", cascade={"persist"})
     * @var Movie
     */
    protected $movie;
    
    /**
     * The user that left this comment.
     * 
     * @ManyToOne(targetEntity="User", inversedBy="reviews", cascade={"persist"})
     * @var User
     */
    protected $user;
    
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var Integer
     */
    protected $id;
    
    /**
     * A comment left by the reviewer.
     * 
     * @ORM\Column(type="string")
     * @var String
     */
    protected $comment;
    
    /**
     * The rating the user gave the movie.
     * 
     * @ORM\Column(type="smallint")
     * @var Integer
     */
    protected $rating;
    
    /**
     * The date the movie was added to the manager.
     * 
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $date_created;
    
    /**
     * @ORM\PreFlush()
     */
    public function onPreFlush()
    {
        $this->date_created = new \DateTime();
    }
    
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     *
     * @return Review
     */
    public function setUser($user)
    {
        $this->user = $user;
        
        $user->addReview($this);
        
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
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * @param String $comment
     *
     * @return Review
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
    
    /**
     * @param int $rating
     *
     * @return Review
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        
        return $this;
    }
    
    /**
     * @return Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }
    
    /**
     * @param Movie $movie
     *
     * @return Review
     */
    public function setMovie($movie)
    {
        $this->movie = $movie;
        
        $movie->addReview($this);
        
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }
    
}