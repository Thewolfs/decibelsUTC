<?php

namespace Decibels\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Decibels\GeneralBundle\Entity\Carrousel;
use Decibels\GeneralBundle\Form\CarrouselType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CarrouselController extends Controller
{
    public function addImageAction(Request $request) 
    {
        $carrousel = new Carrousel();
		
		$form = $this->get('form.factory')->create(new CarrouselType(), $carrousel);
        
        if($form->handleRequest($request)->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $image = $em->getRepository('DecibelsGeneralBundle:FIle')->find($request->request->get('file_id'));
            $carrousel->setPicture($image);
            $carrousel->setActive(true);
            $em->persist($carrousel);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Image bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_homepage'));
        }
        return $this->render('DecibelsGeneralBundle:Carrousel:addImage.html.twig', array('form' => $form->createView()));
    }
}