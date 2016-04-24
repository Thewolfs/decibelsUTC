<?php

namespace Decibels\RealisationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\RealisationBundle\Entity\Realisation;
use Decibels\RealisationBundle\Form\RealisationType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class FrontEndController extends Controller
{
    public function listRealisationAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$listRea = $em->getRepository('DecibelsRealisationBundle:Realisation')->findAllSortByIdDesc();
		
        return $this->render('DecibelsRealisationBundle:FrontEnd:listRealisation.html.twig', array('listRea' => $listRea));
    }
}
