<?php

namespace Decibels\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Decibels\NewsBundle\Entity\News;
use Decibels\NewsBundle\Form\NewsType;
use Symfony\Component\Finder\Finder;

/**
 * News Backend controller.
 *
 */
class BackEndController extends Controller
{
	public function listAdminAction(Request $request) {		
		$listNews = $this->getDoctrine()->getManager()->getRepository('DecibelsNewsBundle:News')->findAllSortDate();
		
		return $this->render('DecibelsNewsBundle:BackEnd:listAdmin.html.twig', array('listNews' => $listNews));
	}

    public function newAction(Request $request) {
        $entity = new News();
        $form = $this->createForm(new NewsType(), $entity);
        $form->add('Publier', 'submit');

        if ($form->handleRequest($request)->isValid()) {
			$date = new \DateTime();
			$entity->setDate($date);
			$author = $this->getUser()->getUsername();
			$entity->setAuthor($author);
            $em = $this->getDoctrine()->getManager();
            $image = $em->getRepository('DecibelsCommonBundle:File')->find($request->request->get('file_id'));
            $entity->setPicture($image);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('decibels_news_show', array('id' => $entity->getId())));
        }

        return $this->render('DecibelsNewsBundle:BackEnd:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DecibelsNewsBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('News introuvable');
        }

        $form = $this->createForm(new NewsType(), $entity);
        $form->add('Modifier', 'submit');
        
        if ($form->handleRequest($request)->isValid()) {
            $image = $em->getRepository('DecibelsCommonBundle:File')->find($request->request->get('file_id'));
            $entity->setPicture($image);
            $em->flush();

            return $this->redirect($this->generateUrl('decibels_news_edit', array('id' => $id)));
        }

        return $this->render('DecibelsNewsBundle:BackEnd:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DecibelsNewsBundle:News')->find($id);

        if (!$entity) 
        {
            throw $this->createNotFoundException('News introuvable !');
        }
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {

            $em->remove($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('decibels_news_listAdmin'));
        }
        return $this->render('DecibelsNewsBundle:BackEnd:delete.html.twig', array(
            'form' => $form->createView(), 
            'news' => $entity
        ));
    }
}
