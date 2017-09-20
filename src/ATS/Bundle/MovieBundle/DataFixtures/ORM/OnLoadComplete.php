<?php

namespace ATS\Bundle\MovieBundle\DataFixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;

class OnLoadComplete extends AbstractFixture
{
    
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
}