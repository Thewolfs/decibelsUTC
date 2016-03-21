<?php

namespace Decibels\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Decibels\NewsBundle\Entity\News;
use Decibels\NewsBundle\Form\NewsType;
use Symfony\Component\Finder\Finder;

/**
 * News controller.
 *
 */
class NewsController extends Controller
{

    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
        
        $listImg = $em->getRepository('DecibelsGeneralBundle:Carrousel')->findAllActiveJoinFile();

        $entities = $em->getRepository('DecibelsNewsBundle:News')->findAllSortDate();

        return $this->render('DecibelsNewsBundle:News:index.html.twig', array(
            'entities' => $entities,
			'listImg' => $listImg
        ));
    }
	
	public function listAdminAction(Request $request)
	{
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
		
		$listNews = $this->getDoctrine()->getManager()->getRepository('DecibelsNewsBundle:News')->findAllSortDate();
		
		return $this->render('DecibelsNewsBundle:News:listAdmin.html.twig', array('listNews' => $listNews));
	}

    public function newAction(Request $request)
    {
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
        $entity = new News();
        $form = $this->createForm(new NewsType(), $entity);
        $form->add('Publier', 'submit');

        if ($form->handleRequest($request)->isValid()) {
			$date = new \DateTime();
			$entity->setDate($date);
			$author = $this->getUser()->getUsername();
			$entity->setAuthor($author);
            $em = $this->getDoctrine()->getManager();
            $image = $em->getRepository('DecibelsGeneralBundle:File')->find($request->request->get('file_id'));
            $entity->setPicture($image);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('decibels_news_show', array('id' => $entity->getId())));
        }

        return $this->render('DecibelsNewsBundle:News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DecibelsNewsBundle:News')->findWithComments($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        return $this->render('DecibelsNewsBundle:News:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DecibelsNewsBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('News introuvable');
        }

        $form = $this->createForm(new NewsType(), $entity);
        $form->add('Modifier', 'submit');
        
        if ($form->handleRequest($request)->isValid()) {
            $image = $em->getRepository('DecibelsGeneralBundle:File')->find($request->request->get('file_id'));
            $entity->setPicture($image);
            $em->flush();

            return $this->redirect($this->generateUrl('decibels_news_edit', array('id' => $id)));
        }

        return $this->render('DecibelsNewsBundle:News:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
		if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
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
        return $this->render('DecibelsNewsBundle:News:delete.html.twig', array(
            'form' => $form->createView(), 
            'news' => $entity
        ));
    }
}
