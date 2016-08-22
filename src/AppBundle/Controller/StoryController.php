<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StoryController extends Controller
{
    /**
     * @Route("/story/{slug}", name="story_show")
     */
    public function showAction($slug)
    {
        return $this->render('story/show.html.twig', array(
            'title' => 'Title for Story #' . $slug,
            'body' => 'Body for Story #' . $slug,
            'id' => $slug
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
