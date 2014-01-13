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

class StudiesController extends Controller {
	public function indexAction() {
		// Check that user is registered first. If not, redirect him to the subscription page.
		$user = $this->get('security.context')->getToken()->getUser();
		if(!$user->isRegistered())
			return $this->redirect($this->generateUrl('subscription_form', array('registerFirst' => true)));
		$em = $this->getDoctrine()->getManager();
		$studies = $em->getRepository('USECStudentBundle:Study')->findAllAvailable();
		return $this->render('USECStudentBundle:Studies:list.html.twig', array(
				'studies' => $studies,
				'isUserAdmin' => DefaultAdminController::isUserAdmin($user, $this),
		));
	}
	
	public function showAction(Request $request, $id) {
		// Check that user is registered first. If not, redirect him to the subscription page.
		$user = $this->get('security.context')->getToken()->getUser();
		if(!$user->isRegistered())
			return $this->redirect($this->generateUrl('subscription_form', array('registerFirst' => true)));
		$em = $this->getDoctrine()->getManager();
		$study = $em->getRepository('USECStudentBundle:Study')
			->findOneAvailableById($id);
		if(!$study)
			throw $this->createNotFoundException('L\'étude n\'existe pas ou n\'est plus accessible');
		$student = $em->getRepository('USECStudentBundle:Student')
			->findOneById($study->getCreatedBy());
		$statusPost = $request->query->get('statusPost');
		return $this->render('USECStudentBundle:Studies:show.html.twig', array(
				'study' => $study,
				'createdByLogin' => $student->getUsername(),
				'isUserAdmin' => DefaultAdminController::isUserAdmin($user, $this),
				'statusPost' => ($statusPost != null)
					? array('success' => $statusPost['success'], 'isNew' => $statusPost['isNew'])
					: null,
		));
	}
}
