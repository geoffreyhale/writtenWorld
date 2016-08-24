<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Entity\Role;
use AppBundle\Entity\Story;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StoryController extends Controller
{
    /**
     * @Route("/", name="story_list")
     */
    public function listAction()
    {
        $stories = $this->getDoctrine()
            ->getRepository('AppBundle:Story')
            ->findAll();

        if (!$stories) {
            throw $this->createNotFoundException(
                'No stories found'
            );
        }

        return $this->render('story/list.html.twig', array(
            'stories' => $stories
        ));
    }

    /**
     * @Route("/story/{storyId}", name="story_show")
     */
    public function showAction($storyId)
    {
        /** @var Story $story */
        $story = $this->getDoctrine()
            ->getRepository('AppBundle:Story')
            ->find($storyId);

        if (!$story) {
            throw $this->createNotFoundException(
                'No story found for id ' . $storyId
            );
        }

        //@todo show related Stories
        $stories = $this->getDoctrine()
            ->getRepository('AppBundle:Story')
            ->findAll();

        return $this->render('story/show.html.twig', array(
            'title' => $story->getTitle(),
            'body' => $story->getBody(),
            'id' => $story->getId(),
            'stories' => $stories,
            'locations' => $story->getLocations(),
            'roles' => $story->getRoles()
        ));
    }

    /**
     * @Route("/story/create/{title}/{body}", name="story_create")
     */
    public function createAction($title, $body)
    {
        $story = new Story();
        $story->setTitle($title);
        $story->setBody($body);

        $em = $this->getDoctrine()->getManager();
        $em->persist($story);
        $em->flush();

        return new Response('Created new story with id ' . $story->getId());
    }
}
