<?php

namespace ATS\Bundle\MovieBundle\Controller;

use ATS\Bundle\MovieBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;

/**
 * #Route("/")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @Rest\Post()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $auth_utils    = $this->container->get('security.authentication_utils');
        $error         = $auth_utils->getLastAuthenticationError();
        $last_username = $auth_utils->getLastUsername();
        
        /* @var Response $response */
        $response = $this->render('@ATSMovie/Security/login.html.twig', array(
            'last_username' => $last_username,
            'error'         => $error,
        ));
        
        $response->headers->set('Content-Type', 'html');
        
        return $response;
    }
    
    /**
     * @Route("/create", name="security.create")
     * @Post()
     */
    public function createAction(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        
        $repo  = $this->getDoctrine()->getRepository(User::class);
        $found = $repo->findBy(['username' => $username]);
        
        if (count($found)) {
            return Response::create('That username is already taken.', 400);
        }
        
        $encoder = $this->container->get('security.password_encoder');
        $user    = new User();
        
        $user
            ->setUsername($username)
            ->setPassword($encoder->encodePassword($user, $password))
        ;
        
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        
        $this->login($user);
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * Log the user in after they create an account.
     *
     * @param User $user
     *
     * @return $this
     */
    private function login(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'new_user', ['ROLE_USER']);
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
        
        return $this;
    }
}