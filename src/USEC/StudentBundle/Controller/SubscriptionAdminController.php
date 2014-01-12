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

class SubscriptionAdminController extends Controller
{
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();
		$students = $em->getRepository('USECStudentBundle:Student')->findAllSubscribed();
		return $this->render('USECStudentBundle:Subscription:list.html.twig', array(
				'students' => $students,
		));
	}
	
	public function showAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$student = $em->getRepository('USECStudentBundle:Student')->findOneSubscribed($id);
		if(!$student)
			throw $this->createNotFoundException('L\'étudiant n\'existe pas ou n\'est plus accessible');
		return $this->render('USECStudentBundle:Subscription:show.html.twig', array(
				'student' => $student,
		));
	}
}