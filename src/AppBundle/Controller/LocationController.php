<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Entity\Role;
use AppBundle\Entity\Story;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LocationController extends Controller
{
    /**
     * @Route("/location/{locationId}", name="location_show")
     */
    public function showAction($locationId)
    {
        /** @var Location $location */
        $location = $this->getDoctrine()
            ->getRepository('AppBundle:Location')
            ->find($locationId);

        if (!$location) {
            throw $this->createNotFoundException(
                'No location found for id ' . $locationId
            );
        }

        $stories = $location->getStories();

        return $this->render('location/show.html.twig', array(
            'name' => $location->getName(),
            'description' => $location->getDescription(),
            'id' => $location->getId(),
            'stories' => $stories,
        ));
    }
}
