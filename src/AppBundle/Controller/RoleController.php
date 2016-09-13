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

class RoleController extends Controller
{
    /**
     * @Route("/role/{roleId}", name="role_show")
     */
    public function showAction($roleId)
    {
        /** @var Role $role */
        $role = $this->getDoctrine()
            ->getRepository('AppBundle:Role')
            ->find($roleId);

        if (!$role) {
            throw $this->createNotFoundException(
                'No role found for id ' . $roleId
            );
        }

        return $this->render('role/show.html.twig', array(
            'name' => $role->getName(),
            'description' => $role->getDescription(),
            'id' => $role->getId(),
            'stories' => $role->getStories(),
        ));
    }

    /**
     * @Route("/roles", name="role_list")
     */
    public function listAction()
    {
        $roles = $this->getDoctrine()
            ->getRepository('AppBundle:Role')
            ->findAll();

        if (!$roles) {
            throw $this->createNotFoundException(
                'No roles found'
            );
        }

        return $this->render('role/list.html.twig', array(
            'roles' => $roles
        ));
    }

    /**
     * @Route("/role/create/", name="role_create")
     */
    public function createAction(Request $request)
    {
        $role = new Role();

        $form = $this->createFormBuilder($role)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->getData();
            $role->setCreatedBy($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role_show', array (
                'roleId' => $role->getId()
            ));
        }

        return $this->render('role/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/role/edit/{roleId}", name="role_edit")
     */
    public function editAction($roleId, Request $request)
    {
        $role = new Role();

        if ($roleId) {
            /** @var Role $role */
            $role = $this->getDoctrine()
                ->getRepository('AppBundle:Role')
                ->find($roleId);

            if (!$role) {
                throw $this->createNotFoundException(
                    'No role found for id ' . $roleId
                );
            }
        }

        if ($role->getCreatedBy() !== $this->getUser()) {
            throw $this->createNotFoundException(
                'You did not create this so you cannot edit it.'
            );
        }

        $form = $this->createFormBuilder($role)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role_show', array (
                'roleId' => $role->getId()
            ));
        }

        return $this->render('role/edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $role->getId(),
        ));
    }
}
