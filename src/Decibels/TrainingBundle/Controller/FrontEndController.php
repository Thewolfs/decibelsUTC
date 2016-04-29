<?php

namespace Decibels\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Decibels\TrainingBundle\Entity\Training;
use Decibels\TrainingBundle\Form\TrainingType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FrontEndController extends Controller
{
    public function listAction(Request $request)
    {
		$listTraining = $this->getDoctrine()->getManager()->getRepository("DecibelsTrainingBundle:Training")->findAll();
		
        return $this->render('DecibelsTrainingBundle:FrontEnd:list.html.twig', array("listTraining" => $listTraining));
    }
}
