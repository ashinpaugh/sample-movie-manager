<?php

namespace ATS\Bundle\MovieBundle\DataFixtures\ORM;

use ATS\Bundle\MovieBundle\Entity\AbstractEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\SharedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture as BaseAbstractFixture;

/**
 * Class AbstractFixture
 *
 * @package ATS\Bundle\MovieBundle\DataFixtures\ORM
 */
abstract class AbstractFixture extends BaseAbstractFixture implements ContainerAwareInterface, FixtureInterface, OrderedFixtureInterface, SharedFixtureInterface
{
    /**
     * @var Container
     */
    protected $container;
    
    protected function store(ObjectManager $manager, AbstractEntity $entity, $key)
    {
        $manager->persist($entity);
        
        $this->addReference($key, $entity);
        
        return $this;
    }
    
    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}