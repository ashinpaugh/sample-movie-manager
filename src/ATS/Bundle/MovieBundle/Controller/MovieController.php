<?php

namespace ATS\Bundle\MovieBundle\Controller;

use ATS\Bundle\MovieBundle\Entity\Movie;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;

/**
 * @RouteResource("movie", pluralize=false)
 * @View(serializerEnableMaxDepthChecks=true)
 */
class MovieController extends AbstractController
{
    public function getAction()
    {
        return ['movies' => $this->getMovies()];
    }
    
    /**
     * Get a subset of movies.
     * 
     * @param mixed[] $filter
     *
     * @return array|Movie[]
     */
    protected function getMovies(array $filters = [])
    {
        $repo = $this->getDoctrine()->getRepository(Movie::class);
        
        return $repo->findBy(array_filter($filters));
    }
}