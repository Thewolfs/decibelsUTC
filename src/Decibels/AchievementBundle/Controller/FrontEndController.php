<?php

namespace Decibels\AchievementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decibels\AchievementBundle\Entity\Achievement;
use Decibels\AchievementBundle\Form\AchievementType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class FrontEndController extends Controller
{
    public function listAchievementAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		
		$listAchievement = $em->getRepository('DecibelsAchievementBundle:Achievement')->findAllSortByIdDesc();
		
        return $this->render('DecibelsAchievementBundle:FrontEnd:listAchievement.html.twig', array('listAchievement' => $listAchievement));
    }
}
