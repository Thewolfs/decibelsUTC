<?php

namespace Decibels\RealisationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\RealisationBundle\Entity\Realisation;
use Decibels\RealisationBundle\Form\RealisationType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class BackEndController extends Controller
{  
    public function addRealisationAction(Request $request) {		
		$realisation = new Realisation();
		
		$form = $this->get('form.factory')->create(new RealisationType(), $realisation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($realisation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Réalisation bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_realisation_list'));
		}
		
		return $this->render('DecibelsRealisationBundle:BackEnd:addRealisation.html.twig', array('form' => $form->createView()));
	}
	
	public function editRealisationAction(Request $request, $id) {		
		$em = $this->getDoctrine()->getManager();
		$realisation = $em->getRepository('DecibelsRealisationBundle:Realisation')->find($id);
		$form = $this->get('form.factory')->create(new RealisationType(), $realisation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em->persist($realisation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Réalisation bien modifiée.');
			 
			return $this->redirect($this->generateUrl('decibels_realisation_list'));
		}
		
		return $this->render('DecibelsRealisationBundle:BackEnd:editRealisation.html.twig', array('form' => $form->createView()));
	}
	
	public function deleteRealisationAction(Request $request, $id) {		
		$em = $this->getDoctrine()->getManager();
		
		$realisation = $em->getRepository('DecibelsRealisationBundle:Realisation')->find($id);
		
		if(null === $realisation)
		{
			throw new NotFoundHttpException("La réalisation spécifiée n'existe pas");
		}
		
		$form = $this->createFormBuilder()->getForm();
		
		if($form->handleRequest($request)->isValid())
		{
			$em->remove($realisation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'La réalisation spécifié a bien été supprimée');
			
			return $this->redirect($this->generateUrl('decibels_réalisation'));
		}
		
		return $this->render('DecibelsRealisationBundle:BackEnd:deleteRealisation.html.twig', array('form' => $form->createView()));
	}
}