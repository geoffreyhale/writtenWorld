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

class StoryController extends Controller
{
    /**
     * @Route("/stories", name="story_list")
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

        $stories = $story->getStories();

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
     * @Route("/story/create/", name="story_create")
     */
    public function createAction(Request $request)
    {
        $story = new Story();

        $form = $this->createFormBuilder($story)
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $story = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();

            return $this->redirectToRoute('story_show', array (
                'storyId' => $story->getId()
            ));
        }

        return $this->render('story/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/story/edit/{storyId}", name="story_edit")
     */
    public function editAction($storyId, Request $request)
    {
        $story = new Story();

        if ($storyId) {
            /** @var Story $story */
            $story = $this->getDoctrine()
                ->getRepository('AppBundle:Story')
                ->find($storyId);

            if (!$story) {
                throw $this->createNotFoundException(
                    'No story found for id ' . $storyId
                );
            }
        }

        $form = $this->createFormBuilder($story)
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $story = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();

            return $this->redirectToRoute('story_show', array (
                'storyId' => $story->getId()
            ));
        }

        return $this->render('story/edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $story->getId(),
        ));
    }
}
