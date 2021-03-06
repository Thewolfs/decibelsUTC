<?php

namespace Decibels\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Decibels\TrainingBundle\Entity\Training;
use Decibels\TrainingBundle\Form\TrainingType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BackEndController extends Controller
{
	public function listAdminAction(Request $request) {		
		$listTraining = $this->getDoctrine()->getManager()->getRepository('DecibelsTrainingBundle:Training')->findAll();
		
		return $this->render('DecibelsTrainingBundle:BackEnd:listAdmin.html.twig', array('listTraining' => $listTraining));
	}
	
    public function addAction(Request $request) {
		$training = new Training();
		
		$form = $this->get('form.factory')->create(new TrainingType(), $training);
		
		if($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$file = $em->getRepository('DecibelsCommonBundle:File')->find($request->request->get('file_id'));
			$training->setFile($file);
			$date = new \DateTime();
			$training->setDate($date);
			$em->persist($training);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Formation bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_training_list'));
		}
		
        return $this->render('DecibelsTrainingBundle:BackEnd:add.html.twig', array("form" => $form->createView()));
    }
	
	public function editAction($id, Request $request) {		
		$em = $this->getDoctrine()->getManager();
		
		$training = $em->getRepository('DecibelsTrainingBundle:Training')->find($id);
		
		if(null === $training)
		{
			throw new NotFoundHttpException("La formation spécifié n'existe pas");
		}
		
		$form = $this->get('form.factory')->create(new TrainingType, $training);
		
		if($form->handleRequest($request)->isValid())
		{
			if($request->request->get('file_id')) 
			{
				$file = $em->getRepository('DecibelsCommonBundle:File')->find($request->request->get('file_id'));
				$training->setFile($file);
			}
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Formation bien modifiée.');
			 
			return $this->redirect($this->generateUrl('decibels_training_list'));
		}
		
		return $this->render('DecibelsTrainingBundle:BackEnd:edit.html.twig', array(
			'form' => $form->createView()
		));
	}
	
	public function deleteAction($id, Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$training = $em->getRepository('DecibelsTrainingBundle:Training')->find($id);
		
		if(null === $training)
		{
			throw new NotFoundHttpException("La formation spécifié n'existe pas");
		}
		
		$form = $this->createFormBuilder()->getForm();
		
		if($form->handleRequest($request)->isValid())
		{
			$em->remove($training);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Formation bien supprimée.');
			 
			return $this->redirect($this->generateUrl('decibels_training_list'));
		}
		
		return $this->render('DecibelsTrainingBundle:BackEnd:delete.html.twig', array(
			'form' => $form->createView(),
			'training' => $training
		));
	}
}
