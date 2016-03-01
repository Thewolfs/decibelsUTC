<?php

namespace Decibels\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Decibels\GeneralBundle\Entity\Realisation;
use Decibels\GeneralBundle\Form\RealisationType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Decibels\GeneralBundle\Entity\File;
use Decibels\GeneralBundle\Form\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$listRea = $em->getRepository('DecibelsGeneralBundle:Realisation')->findAllSortByIdDesc();
		
        return $this->render('DecibelsGeneralBundle:Default:index.html.twig', array('listRea' => $listRea));
    }
	
	public function addRealisationAction(Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
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
		
		return $this->render('DecibelsGeneralBundle:Default:addRealisation.html.twig', array('form' => $form->createView()));
	}
	
	public function editRealisationAction(Request $request, $id)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$em = $this->getDoctrine()->getManager();
		$realisation = $em->getRepository('DecibelsGeneralBundle:Realisation')->find($id);
		$form = $this->get('form.factory')->create(new RealisationType(), $realisation);
		
		if($form->handleRequest($request)->isValid())
		{
			$em->persist($realisation);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Réalisation bien modifiée.');
			 
			return $this->redirect($this->generateUrl('decibels_realisation_list'));
		}
		
		return $this->render('DecibelsGeneralBundle:Default:editRealisation.html.twig', array('form' => $form->createView()));
	}
	
	public function deleteRealisationAction(Request $request, $id)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$realisation = $em->getRepository('DecibelsGeneralBundle:Realisation')->find($id);
		
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
		
		return $this->render('DecibelsGeneralBundle:Default:deleteRealisation.html.twig', array('form' => $form->createView()));
	}
	
	public function presentationAction(Request $request)
	{
		$file = fopen('../src/Decibels/GeneralBundle/Resources/public/presentation.txt', 'r');
		$presentation = '';
		while(!feof($file))
		{
			$presentation = $presentation.fgets($file);				
		}
		fclose($file);
		
		return $this->render('DecibelsGeneralBundle:Default:presentation.html.twig', array('presentation' => $presentation));
	}
	
	public function editPresentationAction(Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$presentation = file_get_contents('../src/Decibels/GeneralBundle/Resources/public/presentation.txt');
		
		$data = array('presentation' => $presentation);
		
		$form = $this->createFormBuilder($data)
					 ->add('presentation', 'textarea', array('label' => 'Nouvelle présentation'))
					 ->add('Modifier', 'submit')
					 ->getForm();
					 
		if($form->handleRequest($request)->isValid())
		{
			$data = $form->getData();
			
			file_put_contents('../src/Decibels/GeneralBundle/Resources/public/presentation.txt', $data['presentation']);
			
			$request->getSession()->getFlashBag()->add('notice', 'La présentation a bien été supprimée');
			return $this->redirect($this->generateUrl('decibels_presentation'));
		}
		
		return $this->render('DecibelsGeneralBundle:Default:editPresentation.html.twig', array('form' => $form->createView()));
	}
	
	public function contactAction(Request $request)
	{
		$data = array();
		$form = $this->createFormBuilder($data)
					 ->add('email', 'email', array('label' => 'Votre e-mail'))
					 ->add('sujet', 'text', array('label' => 'Sujet'))
					 ->add('demande', 'textarea', array('label' => 'Votre demande'))
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
			
			$this->get('mailer')->send($message);
			
			$request->getSession()->getFlashBag()->add('notice', 'Demande envoyée');
		}
		
		return $this->render('DecibelsGeneralBundle:Default:contact.html.twig', array('form' => $form->createView()));
	}
	
	public function adminAction(Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		return $this->render('DecibelsGeneralBundle:Default:admin.html.twig');
	}
	
	public function listAdminAction(Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$listRea = $this->getDoctrine()->getManager()->getRepository('DecibelsGeneralBundle:Realisation')->findAll();
		
		return $this->render('DecibelsGeneralBundle:Default:listAdmin.html.twig', array('listRea' => $listRea));
	}
	
	public function uploadFileAction(Request $request)
    {
        $file = new File;
        $form = $this->createForm(new FileType, $file);
		
        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($file);

            $manager = $this->get('stof_doctrine_extensions.uploadable.manager');
			$manager->getUploadableListener()->setDefaultPath($this->get('kernel')->getRootDir().'/../web'.$request->request->get('webDirPath', '/uploads'));
            $manager->markEntityToUpload($file, $file->getFile());

            $em->flush();

            return new JsonResponse(array(
                'id' => $file->getId(),
				'test' => $request->request->get('file')
            ));
        }

        return new JsonResponse(array(
            'error' => $form->getErrors(true),
			'test' => $request->request->get('file')
        ), 400);
    }
}
