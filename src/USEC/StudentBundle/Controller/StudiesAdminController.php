<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use USEC\StudentBundle\Entity\Study;
use USEC\StudentBundle\Form\Type\CustomSubmitType;

class StudiesAdminController extends Controller {
	
	public function newAction(Request $request)
	{
		$study = new Study();
		
		$form = $this->createStudyForm($study, true);
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$study->setCreationDate(new \DateTime());
			$study->setCreatedBy($this->get('security.context')->getToken()->getUser()->getId());
			$em = $this->getDoctrine()->getManager();
			$em->persist($study);
			$em->flush();
			
			return $this->redirect($this->generateUrl('study_show', array(
					'id' => $study->getId(),
					'statusPost' => array('success' => true, 'isNew' => true)
			)));
		}
		
		return $this->render('USECStudentBundle:Studies:form.html.twig', array(
				'statusPost' => null,
				'form' => $form->createView(),
				'isNew' => true,
		));
	}
	
	public function editAction(Request $request, $id)
	{
		$study = $this->getDoctrine()->getRepository('USECStudentBundle:Study')->find($id);
		if(!$study)
			throw $this->createNotFoundException('L\'étude n\'existe pas');
		
		$form = $this->createStudyForm($study);
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$study->setChangeDate(new \DateTime());
			$em = $this->getDoctrine()->getManager();
			$em->persist($study);
			$em->flush();
			
			$redirectTo = ($study->isClosed()) ? 'study_edit' : 'study_show';
			return $this->redirect($this->generateUrl($redirectTo, array(
					'id' => $study->getId(),
					'statusPost' => array('success' => true, 'isNew' => false)
			)));
		}
		
		return $this->render('USECStudentBundle:Studies:form.html.twig', array(
				'statusPost' => null,
				'form' => $form->createView(),
				'isNew' => false,
				'studyTitle' => $study->getTitle(),
		));
	}
	
	private function createStudyForm($study, $isNew = false) {
	 	$form = $this->createFormBuilder($study)
			->add('id', 'hidden')
			->add('title', 'text', array('label' => 'Titre'))
			->add('description', 'textarea')
			->add('department', 'choice', array(
					'choices' => Study::$LIST_COURSES,
					'label' => 'Département'
			))
			->add('skillsRequired', 'text', array('label' => 'Compétences (facultatif)', 'required' => false))
			->add('company', 'text', array('label' => 'Entreprise (facultatif)', 'required' => false))
			->add('estimatedPay', 'text', array('label' => 'Rémunération estimée (somme exacte ou intervalle)'));
	 	if(!$isNew)
	 		$form->add('closed', 'checkbox', array('label' => 'Cloturer la recherche de consultants', 'required' => false));
		$form->add('save', 'custom_submit', array(
				'label' => ($isNew) ? 'Créer l\'étude' : 'Modifier l\'étude',
				'return_path' => $this->generateUrl('studies_available'),
		));
		 return $form->getForm();
	}
}
