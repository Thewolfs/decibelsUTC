<?php

namespace Decibels\AchievementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\AchievementBundle\Entity\Achievement;
use Decibels\AchievementBundle\Form\AchievementType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class BackEndController extends Controller
{  
    public function addAchievementAction(Request $request) {		
		$realisation = new Achievement();
		
		$form = $this->get('form.factory')->create(new AchievementType(), $realisation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($realisation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Réalisation bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_realisation_list'));
		}
		
		return $this->render('DecibelsAchievementBundle:BackEnd:addAchievement.html.twig', array('form' => $form->createView()));
	}
	
	public function editAchievementAction(Request $request, $id) {		
		$em = $this->getDoctrine()->getManager();
		$realisation = $em->getRepository('DecibelsAchievementBundle:Achievement')->find($id);
		$form = $this->get('form.factory')->create(new AchievementType(), $realisation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em->persist($realisation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Réalisation bien modifiée.');
			 
			return $this->redirect($this->generateUrl('decibels_realisation_list'));
		}
		
		return $this->render('DecibelsAchievementBundle:BackEnd:editAchievement.html.twig', array('form' => $form->createView()));
	}
	
	public function deleteAchievementAction(Request $request, $id) {		
		$em = $this->getDoctrine()->getManager();
		
		$realisation = $em->getRepository('DecibelsAchievementBundle:Achievement')->find($id);
		
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
		
		return $this->render('DecibelsAchievementBundle:BackEnd:deleteAchievement.html.twig', array('form' => $form->createView()));
	}
}