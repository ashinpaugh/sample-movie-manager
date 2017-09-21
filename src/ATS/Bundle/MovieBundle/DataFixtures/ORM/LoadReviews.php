<?php

namespace ATS\Bundle\MovieBundle\DataFixtures\ORM;


use ATS\Bundle\MovieBundle\Entity\Review;
use Doctrine\Common\Persistence\ObjectManager;

class LoadReviews extends AbstractFixture
{
    
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    /*public function load(ObjectManager $manager)
    {
        $review = new Review();
        
        $review
            ->setUser($this->getReference('ashinpaugh'))
            ->setMovie($this->getReference('PIB'))
            ->setComment('It was purrfect.')
            ->setRating(5)
        ;
        
        $this->store($manager, $review, 'r1');
        
        $review = new Review();
        $review
            ->setUser($this->getReference('dog'))
            ->setMovie($this->getReference('PIB'))
            ->setComment("Hurr durr look at me I'm a cat. Booo")
            ->setRating(1)
        ;
        
        $this->store($manager, $review, 'r2');
        
        $manager->flush();
    }*/
    
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}