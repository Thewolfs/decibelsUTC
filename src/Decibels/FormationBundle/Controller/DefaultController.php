<?php

namespace Decibels\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function listAction()
    {
		$listFormation = $this->getDoctrine()->getManager()->getRepository("DecibelsFormationBundle:Formation")->findAll();
		
        return $this->render('DecibelsFormationBundle:Default:list.html.twig', array("listFormation" => $listFormation));
    }
}
