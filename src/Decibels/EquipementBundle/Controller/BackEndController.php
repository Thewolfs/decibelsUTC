<?php

namespace Decibels\EquipementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\EquipementBundle\Entity\Equipement;
use Decibels\EquipementBundle\Form\EquipementType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class BackEndController extends Controller
{	
	public function addEquipementAction(Request $request) {
		$equipement = new Equipement();
		$form = $this->get('form.factory')->create(new EquipementType(), $equipement);
		
		if($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($equipement);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Matériel bien ajouté.');
			 
			return $this->redirect($this->generateUrl('decibels_equipement_list'));
		}
		
        return $this->render('DecibelsEquipementBundle:BackEnd:addEquipement.html.twig', array('form' => $form->createView()));
    }
	
	public function editEquipementAction($id, Request $request) {		
		$em = $this->getDoctrine()->getManager();
		
		$equipement = $em->getRepository('DecibelsEquipementBundle:Equipement')->find($id);
		
		if(null === $equipement)
		{
			throw new NotFoundHttpException("Le matériel spécifié n'existe pas");
		}
		
		$form = $this->get('form.factory')->create(new EquipementType, $equipement);
		
		if($form->handleRequest($request)->isValid())
		{
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Matériel bien modifié.');
			 
			return $this->redirect($this->generateUrl('decibels_equipement_list'));
		}
		
		return $this->render('DecibelsEquipementBundle:BackEnd:editEquipement.html.twig', array(
		'form' => $form->createView()
		));
	}
	
	public function deleteEquipementAction($id, Request $request) {		
		$em = $this->getDoctrine()->getManager();
		
		$equipement = $em->getRepository('DecibelsEquipementBundle:Equipement')->find($id);
		
		if(null === $equipement)
		{
			throw new NotFoundHttpException("Le matériel spécifié n'existe pas");
		}
		
		$form = $this->createFormBuilder()->getForm();
		
		if($form->handleRequest($request)->isValid())
		{
			$em->remove($equipement);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'Le matériel spécifié a bien été supprimé');
			
			return $this->redirect($this->generateUrl('decibels_equipement_list'));
		}
		
		return $this->render('DecibelsEquipementBundle:BackEnd:deleteEquipement.html.twig', array(
		'form' => $form->createView(),
		'equipement' => $equipement
		));
	}
}
