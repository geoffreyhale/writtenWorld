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
            ->findBy(
                array(),
                array('id' => 'DESC'),
                10
            );

        $locations = $this->getDoctrine()
            ->getRepository('AppBundle:Location')
            ->findBy(
                array(),
                array('id' => 'DESC'),
                10
            );

        $roles = $this->getDoctrine()
            ->getRepository('AppBundle:Role')
            ->findBy(
                array(),
                array('id' => 'DESC'),
                10
            );

        return $this->render('home.html.twig', array(
            'stories' => $stories,
            'locations' => $locations,
            'roles' => $roles,
        ));
    }
}
