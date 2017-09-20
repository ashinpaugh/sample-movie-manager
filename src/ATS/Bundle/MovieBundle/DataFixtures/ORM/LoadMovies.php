<?php

namespace ATS\Bundle\MovieBundle\DataFixtures\ORM;

use ATS\Bundle\MovieBundle\Entity\Movie;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMovies extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $movie = new Movie();
        
        $movie
            ->setTitle('Puss In Boots')
            ->setYear(2011)
            ->setFormat('DVD')
            ->setLength(5400)
            ->setOwner($this->getReference('ashinpaugh'))
        ;
        
        $this->store($manager, $movie, 'PIB');
        
        $manager->flush();
        
        $movie = new Movie();
        $movie
            ->setTitle('Garfield: The Movie')
            ->setYear(2004)
            ->setFormat('VHS')
            ->setLength(4800)
            ->setOwner($this->getReference('dog'))
        ;
        
        $this->store($manager, $movie, 'Garfield');
        $manager->flush();
    }
    
    
    
    public function getOrder()
    {
        return 2;
    }
}