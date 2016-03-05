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
            $image = $em->getRepository('DecibelsGeneralBundle:File')->find($request->request->get('file_id'));
            $carrousel->setPicture($image);
            $carrousel->setActive(true);
            $em->persist($carrousel);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Image bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_homepage'));
        }
        return $this->render('DecibelsGeneralBundle:Carrousel:addImage.html.twig', array('form' => $form->createView()));
    }
    
    public function changeImageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listImage = $em->getRepository('DecibelsGeneralBundle:Carrousel')->findAllJoinFile();
        
        $data = array();
		
		$form = $this->createFormBuilder($data)
					 ->add('modifiedImgs', 'hidden')
					 ->add('Modifier', 'submit')
					 ->getForm();
        
        if($form->handleRequest($request)->isValid()) 
        {
            $data = $form->getData();
            $modifiedImgs = json_decode($data['modifiedImgs']);
            
            foreach($modifiedImgs as $element) 
            {
                $img = $em->getRepository('DecibelsGeneralBundle:Carrousel')->find($element[0]); 
                $img->setActive($element[1]);
                $em->persist($img);
            }
            
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Images bien modifiées.');
			 
			return $this->redirect($this->generateUrl('decibels_homepage'));
        }
        
        return $this->render('DecibelsGeneralBundle:Carrousel:changeImage.html.twig', array(
            'listImage' => $listImage,
            'form' => $form
        ));
    }
}