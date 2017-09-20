<?php

namespace ATS\Bundle\MovieBundle\DataFixtures\ORM;


use ATS\Bundle\MovieBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUsers extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $user    = new User();
        
        $user
            ->setUsername('ashinpaugh')
            ->setPassword($encoder->encodePassword($user, 'pass'))
        ;
        
        $this->store($manager, $user, 'ashinpaugh');
        
        $user = new User();
        $user
            ->setUsername('dog')
            ->setPassword($encoder->encodePassword($user, 'pass'))
        ;
        
        $this->store($manager, $user, 'dog');
    }
    
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}