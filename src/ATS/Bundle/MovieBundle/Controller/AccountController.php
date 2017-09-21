<?php

namespace ATS\Bundle\MovieBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/account")
 * @Security("has_role('ROLE_USER')")
 */
class AccountController extends AbstractController
{
    /**
     * @Route(".{_format}", name="account.view")
     */
    public function viewAction()
    {
        return $this->forward('ATSMovieBundle:Movie:get', [
            'user' => $this->getUser()->getId(),
        ]);
    }
}