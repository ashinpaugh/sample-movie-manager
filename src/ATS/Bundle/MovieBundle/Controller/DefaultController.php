<?php

namespace ATS\Bundle\MovieBundle\Controller;


use ATS\Bundle\MovieBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository(Movie::class);
        
        return $this->render('ATSMovieBundle:Default:index.html.twig', [
            'movies' => $repo->findAll(),
        ]);
    }
}
