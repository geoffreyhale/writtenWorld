<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        $stories = $this->getDoctrine()
            ->getRepository('AppBundle:Story')
            ->findAll();

        $locations = $this->getDoctrine()
            ->getRepository('AppBundle:Location')
            ->findAll();

        $roles = $this->getDoctrine()
            ->getRepository('AppBundle:Role')
            ->findAll();

        return $this->render('home.html.twig', array(
            'stories' => $stories,
            'locations' => $locations,
            'roles' => $roles,
        ));
    }
}
