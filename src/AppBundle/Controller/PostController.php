<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/post", name="post")
     */
    public function indexAction()
    {
        return $this->render('post/index.html.twig', array(
            'title' => 'My First Post Title',
            'body' => 'My first post body.'
        ));
    }
}
