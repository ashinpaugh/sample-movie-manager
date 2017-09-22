<?php

namespace ATS\Bundle\MovieBundle\Controller;

use ATS\Bundle\MovieBundle\Entity\Movie;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @RouteResource("movie", pluralize=false)
 * @View(serializerEnableMaxDepthChecks=true)
 */
class MovieController extends AbstractController
{
    /**
     * Used to print the individual movie tiles.
     * 
     * @Route("/movie/list")
     * @Template("@ATSMovie/Movie/list.html.twig")
     * 
     * @return array
     */
    public function getListAction()
    {
        return ['movies' => $this->getMovies()];
    }
    
    /**
     * Return all the movies, used for adding the serialized movie entities
     * to the page for Chosen.
     * 
     * @Route(requirements={"_format"="json"})
     * 
     * @return array
     */
    public function cgetAction()
    {
        return ['movies' => $this->getMovies()];
    }
    
    /**
     * Prints the create movie template.
     * 
     * @Route("/movie")
     * @Security("has_role('ROLE_USER')")
     */
    public function getAction()
    {
        return $this->render('@ATSMovie/Movie/create.html.twig');
    }
    
    /**
     * Create a movie.
     * 
     * @Route("/movie")
     * @Security("has_role('ROLE_USER')")
     */
    public function putAction(Request $request)
    {
        if (!$this->isValidSubmission($request)) {
            throw new BadRequestHttpException('Invalid values.');
        }
        
        $movie = new Movie();
        $movie
            ->setTitle($request->get('title'))
            ->setFormat($request->get('format'))
            ->setLength($request->get('length') * 60)
            ->setYear($request->get('year'))
            ->setRating($request->get('rating'))
            ->setOwner($this->getUser())
        ;
        
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($movie);
        $manager->flush();
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * Edit a movie.
     *
     * @Route("/movie/{id}")
     * @Security("has_role('ROLE_USER')")
     *
     * @ParamConverter("movie", class="ATSMovieBundle:Movie")
     *
     * @param Request $request
     * @param Movie   $movie
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function patchAction(Request $request, Movie $movie)
    {
        if ($movie->getOwner()->getId() !== $this->getUser()->getId()) {
            throw new AccessDeniedHttpException("This movie doesn't belong to you.");
        }
        
        if (!$this->isValidSubmission($request)) {
            throw new BadRequestHttpException('Invalid values.');
        }
        
        $movie
            ->setTitle($request->get('title'))
            ->setFormat($request->get('format'))
            ->setLength($request->get('length') * 60)
            ->setYear($request->get('year'))
            ->setRating($request->get('rating'))
        ;
        
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * Remove a movie.
     * 
     * @Route("/movie/{id}")
     * @Security("has_role('ROLE_USER')")
     *
     * @ParamConverter("movie", class="ATSMovieBundle:Movie")
     *
     * @param Movie $movie
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Movie $movie)
    {
        if ($movie->getOwner()->getId() !== $this->getUser()->getId()) {
            throw new AccessDeniedHttpException("This movie doesn't belong to you.");
        }
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($movie);
        $manager->flush();
        
        return $this->redirectToRoute('homepage');
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
    
    /**
     * Validate a submission (create / edit) before storing the received values.
     * 
     * @param Request $request
     *
     * @return bool
     */
    private function isValidSubmission(Request $request)
    {
        $title    = $request->get('title');
        $format   = $request->get('format');
        $year     = $request->get('year');
        $duration = $request->get('length');
        $rating   = $request->get('rating');
        
        $length = strlen($title);
        if ($length < 1 || $length > 50) {
            return false;
        }
        
        if (!in_array($format, ['Streaming', 'DVD', 'VHS'], true)) {
            return false;
        }
        
        if ($year <= 1800 || $year >= 2100) {
            return false;
        }
        
        if ($duration < 1 || $duration >= 500) {
            return false;
        }
        
        if ($rating < 1 || $rating > 5) {
            return false;
        }
        
        return true;
    }
}