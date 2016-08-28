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

    /**
     * @Route("/locations", name="location_list")
     */
    public function listAction()
    {
        $locations = $this->getDoctrine()
            ->getRepository('AppBundle:Location')
            ->findAll();

        if (!$locations) {
            throw $this->createNotFoundException(
                'No locations found'
            );
        }

        return $this->render('location/list.html.twig', array(
            'locations' => $locations
        ));
    }

    /**
     * @Route("/location/create/", name="location_create")
     */
    public function createAction(Request $request)
    {
        $location = new Location();

        $form = $this->createFormBuilder($location)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('location_edit', array (
                'locationId' => $location->getId()
            ));
        }

        return $this->render('location/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/location/edit/{locationId}", name="location_edit")
     */
    public function editAction($locationId, Request $request)
    {
        $location = new Location();

        if ($locationId) {
            /** @var Location $location */
            $location = $this->getDoctrine()
                ->getRepository('AppBundle:Location')
                ->find($locationId);

            if (!$location) {
                throw $this->createNotFoundException(
                    'No location found for id ' . $locationId
                );
            }
        }

        $form = $this->createFormBuilder($location)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('location_edit', array (
                'locationId' => $location->getId()
            ));
        }

        return $this->render('location/edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $location->getId(),
        ));
    }
}
