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
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
        
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
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
        
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
                $img = $em->getRepository('DecibelsGeneralBundle:Carrousel')->find($element->id); 
                $img->setActive($element->active);
                $em->persist($img);
            }
            
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Images bien modifiées.');
			 
			return $this->redirect($this->generateUrl('decibels_homepage'));
        }
        
        return $this->render('DecibelsGeneralBundle:Carrousel:changeImage.html.twig', array(
            'listImage' => $listImage,
            'form' => $form->createView()
        ));
    }
    
    public function deleteImageAction(Request $request, $id) 
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            throw new AccessDeniedException();
        } 
        
        $em = $this->getDoctrine()->getManager();
		
		$image = $em->getRepository('DecibelsGeneralBundle:Carrousel')->find($id);
		
		if(null === $image)
		{
			throw new NotFoundHttpException("L'image spécifiée n'existe pas");
		}
		
		$form = $this->createFormBuilder()->getForm();
		
		if($form->handleRequest($request)->isValid())
		{
			$em->remove($image);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', "L'image spécifiée a bien été supprimée");
			
			return $this->redirect($this->generateUrl('decibels_homepage'));
		}
        
        return $this->render('DecibelsGeneralBundle:Carrousel:deleteImage.html.twig', array(
            'form' => $form->createView(),
            'image' => $image
        ));
    }
}