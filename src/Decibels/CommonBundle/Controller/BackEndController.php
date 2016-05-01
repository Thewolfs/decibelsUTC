<?php

namespace Decibels\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Decibels\CommonBundle\Entity\Carrousel;
use Decibels\CommonBundle\Form\CarrouselType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Decibels\CommonBundle\Entity\File;
use Decibels\CommonBundle\Form\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;

class BackEndController extends Controller
{
    public function adminAction(Request $request) {		
		return $this->render('DecibelsCommonBundle:BackEnd:admin.html.twig');
	}
    
    public function editPresentationAction(Request $request) {		
		$presentation = file_get_contents('../src/Decibels/CommonBundle/Resources/public/presentation.txt');
		
		$data = array('presentation' => $presentation);
		
		$form = $this->createFormBuilder($data)
					 ->add('presentation', 'textarea', array('label' => 'Nouvelle présentation', "attr" => array("rows" => 10)))
					 ->add('Modifier', 'submit')
					 ->getForm();
					 
		if($form->handleRequest($request)->isValid())
		{
			$data = $form->getData();
			
			file_put_contents('../src/Decibels/CommonBundle/Resources/public/presentation.txt', $data['presentation']);
			
			$request->getSession()->getFlashBag()->add('notice', 'La présentation a bien été supprimée');
			return $this->redirect($this->generateUrl('decibels_presentation'));
		}
		
		return $this->render('DecibelsCommonBundle:BackEnd:editPresentation.html.twig', array('form' => $form->createView()));
	}
    
    public function addImageAction(Request $request) 
    {        
        $carrousel = new Carrousel();
		
		$form = $this->get('form.factory')->create(new CarrouselType(), $carrousel);
        
        if($form->handleRequest($request)->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $image = $em->getRepository('DecibelsCommonBundle:File')->find($request->request->get('file_id'));
            $carrousel->setPicture($image);
            $carrousel->setActive(true);
            $em->persist($carrousel);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Image bien ajoutée.');
			 
			return $this->redirect($this->generateUrl('decibels_homepage'));
        }
        return $this->render('DecibelsCommonBundle:BackEnd:addImage.html.twig', array('form' => $form->createView()));
    }
    
    public function changeImageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listImage = $em->getRepository('DecibelsCommonBundle:Carrousel')->findAllJoinFile();
        
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
                $img = $em->getRepository('DecibelsCommonBundle:Carrousel')->find($element->id); 
                $img->setActive($element->active);
                $em->persist($img);
            }
            
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Images bien modifiées.');
			 
			return $this->redirect($this->generateUrl('decibels_homepage'));
        }
        
        return $this->render('DecibelsCommonBundle:BackEnd:changeImage.html.twig', array(
            'listImage' => $listImage,
            'form' => $form->createView()
        ));
    }
    
    public function deleteImageAction(Request $request, $id) 
    {        
        $em = $this->getDoctrine()->getManager();
		
		$image = $em->getRepository('DecibelsCommonBundle:Carrousel')->find($id);
		
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
        
        return $this->render('DecibelsCommonBundle:BackEnd:deleteImage.html.twig', array(
            'form' => $form->createView(),
            'image' => $image
        ));
    }
    
    public function uploadFileAction(Request $request) {
        $file = new File;
        $form = $this->createForm(new FileType, $file);
		
        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($file);

            $manager = $this->get('stof_doctrine_extensions.uploadable.manager');
			$manager->getUploadableListener()->setDefaultPath($this->get('kernel')->getRootDir().'/../web/uploads'.$request->request->get('webDirPath', ''));
            $manager->markEntityToUpload($file, $file->getFile());

            $em->flush();

            return new JsonResponse(array(
				'id' => $file->getId(),
                'path' => $file->getPath(),
				'name' => $file->getName()
            ));
        }

        return new JsonResponse(array(
            'error' => $form->getErrors(true)
        ), 400);
    }
}