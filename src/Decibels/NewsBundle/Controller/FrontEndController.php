<?php

namespace Decibels\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Decibels\NewsBundle\Entity\News;
use Decibels\NewsBundle\Form\NewsType;
use Symfony\Component\Finder\Finder;

/**
 * News Frontend controller.
 *
 */
class FrontEndController extends Controller
{
    public function indexAction() {
		$em = $this->getDoctrine()->getManager();
        
        $listImg = $em->getRepository('DecibelsCommonBundle:Carrousel')->findAllActiveJoinFile();

        $entities = $em->getRepository('DecibelsNewsBundle:News')->findAllSortDate();

        return $this->render('DecibelsNewsBundle:FrontEnd:index.html.twig', array(
            'entities' => $entities,
			'listImg' => $listImg
        ));
    }
	
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DecibelsNewsBundle:News')->findWithComments($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        return $this->render('DecibelsNewsBundle:FrontEnd:show.html.twig', array(
            'entity'      => $entity
        ));
    }
}
