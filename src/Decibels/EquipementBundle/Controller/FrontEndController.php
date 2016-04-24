<?php

namespace Decibels\EquipementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\EquipementBundle\Entity\Equipement;
use Decibels\EquipementBundle\Form\EquipementType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontEndController extends Controller
{
	public function listEquipementAction(Request $request) {
		$repository = $this->getDoctrine()->getManager()->getRepository('DecibelsEquipementBundle:Equipement');
		
		$listEquipement = $repository->findAll();
		
		return $this->render('DecibelsEquipementBundle:FrontEnd:listEquipement.html.twig', array('equipements' => $listEquipement));
	}
	
	public function showOneEquipementAction($id, Request $request) {
		$equipement = $this->getDoctrine()->getManager()->getRepository('DecibelsEquipementBundle:Equipement')->find($id);
		
		if(null === $equipement)
		{
			throw new NotFoundHttpException("Le matériel spécifié n'existe pas");
		}
		
		return $this->render('DecibelsEquipementBundle:FrontEnd:showOneEquipement.html.twig', array(
		'equipement' => $equipement
		));
	}
	
	public function showSpecificsAction(Request $request) {
		
		$em = $this->getDoctrine()->getManager();
		
		$id = $request->request->get('id');
		
		$entity = $em->getRepository("DecibelsEquipementBundle:Equipement")->find($id);
		
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
