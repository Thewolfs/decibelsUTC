<?php

namespace Decibels\MaterielBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\MaterielBundle\Entity\Materiel;
use Decibels\MaterielBundle\Form\MaterielType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
	    public function listMaterielAction(Request $request)
	{
		$repository = $this->getDoctrine()->getManager()->getRepository('DecibelsMaterielBundle:Materiel');
		
		$listMateriel = $repository->findAll();
		
		return $this->render('DecibelsMaterielBundle:Default:listMateriel.html.twig', array('materiels' => $listMateriel));
	}
	
	public function showOneMaterielAction($id, Request $request)
	{
		$materiel = $this->getDoctrine()->getManager()->getRepository('DecibelsMaterielBundle:Materiel')->find($id);
		
		if(null === $materiel)
		{
			throw new NotFoundHttpException("Le matériel spécifié n'existe pas");
		}
		
		return $this->render('DecibelsMaterielBundle:Default:showOneMateriel.html.twig', array(
		'materiel' => $materiel
		));
	}
	
	public function addMaterielAction(Request $request)
    {
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$materiel = new Materiel();
		$form = $this->get('form.factory')->create(new MaterielType(), $materiel);
		
		if($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($materiel);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Matériel bien ajouté.');
			 
			return $this->redirect($this->generateUrl('decibels_materiel_list'));
		}
		
        return $this->render('DecibelsMaterielBundle:Default:addMateriel.html.twig', array('form' => $form->createView()));
    }
	
	public function editMaterielAction($id, Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$materiel = $em->getRepository('DecibelsMaterielBundle:Materiel')->find($id);
		
		if(null === $materiel)
		{
			throw new NotFoundHttpException("Le matériel spécifié n'existe pas");
		}
		
		$form = $this->get('form.factory')->create(new MaterielType, $materiel);
		
		if($form->handleRequest($request)->isValid())
		{
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Matériel bien modifié.');
			 
			return $this->redirect($this->generateUrl('decibels_materiel_list'));
		}
		
		return $this->render('DecibelsMaterielBundle:Default:editMateriel.html.twig', array(
		'form' => $form->createView()
		));
	}
	
	public function deleteMaterielAction($id, Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$materiel = $em->getRepository('DecibelsMaterielBundle:Materiel')->find($id);
		
		if(null === $materiel)
		{
			throw new NotFoundHttpException("Le matériel spécifié n'existe pas");
		}
		
		$form = $this->createFormBuilder()->getForm();
		
		if($form->handleRequest($request)->isValid())
		{
			$em->remove($materiel);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'Le matériel spécifié a bien été supprimé');
			
			return $this->redirect($this->generateUrl('decibels_materiel_list'));
		}
		
		return $this->render('DecibelsMaterielBundle:Default:deleteMateriel.html.twig', array(
		'form' => $form->createView(),
		'materiel' => $materiel
		));
	}
	
	public function showSpecificsAction(Request $request) {
		
		$em = $this->getDoctrine()->getManager();
		
		$id = $request->request->get('id');
		
		$entity = $em->getRepository("DecibelsMaterielBundle:Materiel")->find($id);
		
		if($entity !== null) {
			return new JSONResponse(array(
				'id' => $entity->getId(),
				'nom' => $entity->getNom(),
				'description' => $entity->getDescription()
            ));
		}
		
		return new JSONResponse(array(), 400);
	}
}
