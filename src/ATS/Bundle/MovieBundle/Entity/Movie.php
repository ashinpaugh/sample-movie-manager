<?php

namespace ATS\Bundle\MovieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Movie extends AbstractEntity
{
    /**
     * @ManyToOne(targetEntity="User", inversedBy="movies", cascade={"persist"})
     * 
     * @var User
     */
    protected $owner;
    
    /**
     * The reviews created for this movie.
     * 
     * #ORM\OneToMany(targetEntity="Review", mappedBy="movie")
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
     * The movie title.
     * 
     * @ORM\Column(type="string", length=50)
     * @var String
     */
    protected $title;
    
    /**
     * How to view the movie.
     * IE: Streaming, DVD, or VHS
     * 
     * @ORM\Column(type="string")
     * @var String
     */
    protected $format;
    
    /**
     * The length of the movie in seconds.
     * 
     * @ORM\Column(type="integer")
     * @var Integer
     */
    protected $length;
    
    /**
     * The year the movie was released.
     * 
     * @ORM\Column(type="integer")
     * @var Integer
     */
    protected $year;
    
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
    
    
    public function getRuntime()
    {
        $hours   = floor($this->length / 3600);
        $minutes = floor(($this->length - ($hours * 3600)) / 60);
        
        return "{$hours} hrs {$minutes}m";
    }
    
    public function __construct()
    {
        //$this->reviews = new ArrayCollection();
    }
    
    /**
     * @ORM\PreFlush()
     */
    public function onPreFlush()
    {
        $this->date_created = new \DateTime();
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
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param String $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    /**
     * @return String
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    /**
     * @param String $format
     *
     * @return Movie
     */
    public function setFormat($format)
    {
        $this->format = $format;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }
    
    /**
     * @param int $length
     *
     * @return Movie
     */
    public function setLength($length)
    {
        $this->length = $length;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }
    
    /**
     * @param int $year
     *
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;
        
        return $this;
    }
    
    /**
     * @return Review[]
     */
    /*public function getReviews()
    {
        return $this->reviews;
    }
    
    public function addReview(Review $review)
    {
        $this->reviews->add($review);
        
        return $this;
    }*/
    
    /**
     * @param Review[] $reviews
     *
     * @return Movie
     */
    /*public function setReviews($reviews)
    {
        $this->reviews = $reviews;
        
        return $this;
    }*/
    
    /*public function getAvgRating()
    {
        $total = $count = 0;
        
        foreach ($this->reviews as $review) {
            $count++;
            $total += $review->getRating();
        }
        
        if (!$count) {
            return 1;
        }
        
        return ($total / $count);
    }*/
    
    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    /**
     * @param User $owner
     *
     * @return Movie
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
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
     * @return Movie
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        
        return $this;
    }

}