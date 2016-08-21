<?php

namespace AppBundle\Controller;

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
}
