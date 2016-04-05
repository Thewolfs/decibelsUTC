<?php

namespace Decibels\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Decibels\FormationBundle\Entity\Formation;
use Decibels\FormationBundle\Form\FormationType;

class DefaultController extends Controller
{
    public function listAction(Request $request)
    {
		$listFormation = $this->getDoctrine()->getManager()->getRepository("DecibelsFormationBundle:Formation")->findAll();
		
        return $this->render('DecibelsFormationBundle:Default:list.html.twig', array("listFormation" => $listFormation));
    }
	
	public function addAction(Request $request)
    {
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$formation = new Formation();
		
		$form = $this->get('form.factory')->create(new FormationType(), $formation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($formation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Formation bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_formation_list'));
		}
		
        return $this->render('DecibelsFormationBundle:Default:add.html.twig', array("form" => $form->createView()));
    }
	
	public function editAction($id, Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$formation = $em->getRepository('DecibelsFormationBundle:Formation')->find($id);
		
		if(null === $formation)
		{
			throw new NotFoundHttpException("La formation spécifié n'existe pas");
		}
		
		$form = $this->get('form.factory')->create(new MaterielType, $formation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Formation bien modifié.');
			 
			return $this->redirect($this->generateUrl('decibels_formation_list'));
		}
		
		return $this->render('DecibelsFormationBundle:Default:edit.html.twig', array(
			'form' => $form->createView()
		));
	}
}
