<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}", name="post_show")
     */
    public function showAction($slug)
    {
        return $this->render('post.html.twig', array(
            'title' => 'This is the PostController showAction page for $slug = "' . $slug . '".',
            'body' => 'This is a post body for $slug = "' . $slug . '".'
        ));
    }
}
