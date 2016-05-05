<?php

namespace Decibels\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Decibels\CommonBundle\Form\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontEndController extends Controller
{	
	public function presentationAction(Request $request) {
		$file = fopen('../src/Decibels/CommonBundle/Resources/public/presentation.txt', 'r');
		$presentation = '';
		while(!feof($file))
		{
			$presentation = $presentation.fgets($file);				
		}
		fclose($file);
		
		return $this->render('DecibelsCommonBundle:FrontEnd:presentation.html.twig', array('presentation' => $presentation));
	}
	
	public function contactAction(Request $request) {
		$data = array();
		$form = $this->createFormBuilder($data, array('attr' => array('id' => 'form-contact')))
					 ->add('email', 'email', array(
						 'label' => 'Votre e-mail',
						 'label_attr' => array("class" => "hidden"), 
						 'attr' => array(
						 	'placeholder' => 'Votre e-mail'
					 )))
					 ->add('sujet', 'text', array(
						 'label' => 'Sujet',
						 'label_attr' => array("class" => "hidden"), 
						 'attr' => array(
						 	'placeholder' => 'Sujet'
					 )))
					 ->add('demande', 'textarea', array(
						 'label' => 'Votre demande',
						 'label_attr' => array("class" => "hidden"), 
						 'attr' => array(
						 	'placeholder' => 'Votre demande',
							'rows' => 5
					 )))
					 ->add('Envoyer', 'submit')
					 ->getForm();
		
		if($form->handleRequest($request)->isValid())
		{
			$data = $form->getData();
			
			$message = \Swift_Message::NewInstance()
				->setSubject($data['sujet'])
				->setFrom($data['email'])
				->setTo('decibels.asso.utc@gmail.com')
				->setBody($data['demande']);
			
			if($this->get('mailer')->send($message)) {
				return new JsonResponse(array(
				'success' => true
            ));
			}
			
			return new JsonResponse(array(
				'success' => false
            ));
		}
		
		return $this->render('DecibelsCommonBundle:FrontEnd:contact.html.twig', array('form' => $form->createView()));
	}
}
