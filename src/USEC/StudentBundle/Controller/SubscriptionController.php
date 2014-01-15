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
use USEC\StudentBundle\Entity\Student;
use USEC\StudentBundle\Event\StudentSubscriptionEvent;

class SubscriptionController extends Controller
{
	private static $LIST_COURSES = array('TC', 'GB', 'GP', 'GI', 'GM', 'GSU', 'ESCOM', 'Autre');
	
    public function formAction(Request $request) {
    	return $this->render('USECStudentBundle:Subscription:sign.html.twig', array(
    			'nextSemesters' => self::getNextSemestersAbrev(),
    			'listCourses' => self::$LIST_COURSES,
    			'user' => $this->get('security.context')->getToken()->getUser(),
    			'statusPost' => ($request->query->get('statusPost') != null)
			    				? array('success' => $request->query->get('statusPost'), 'isNew' => $request->query->get('isNew'))
			    				: null,
    			'registerFirst' => ($request->query->get('registerFirst') != null) ? true : false, 
    			'emailUsecDsi' => $this->container->getParameter('email_usec_dsi'),
    	));
    }
    
    public function processAction(Request $request) {
    	$student = $this->get('security.context')->getToken()->getUser();
    	$student->setChangeDate(new \DateTime());
    	$student->setName($request->request->get('name'));
    	$student->setFirstName($request->request->get('firstName'));
    	$student->setEmail($request->request->get('email'));
    	$student->setPhone($request->request->get('phone'));
    	$student->setCourse($request->request->get('course'));
    	$student->setEndCourseSemester($request->request->get('endCourseSemester'));
    	$student->setMotivation($request->request->get('motivation'));
    	$student->setInterestedIn($request->request->get('interestedIn'));
    	$student->setApprenti($request->request->get('apprenti'));
    	$student->setSkills($request->request->get('skills'));
    	$student->setIsSubscribedToEmails($request->request->get('subscribedToEmails') != null);
    	if($isNew = !$student->isRegistered())
    		$student->setIsRegistered(true);
    	
    	$validator = $this->get('validator');
    	$errors = $validator->validate($student);
    	
    	if(count($errors) > 0) {
    		return $this->redirect($this->generateUrl('subscription_form', array('statusPost' => false)));
    	}
    	else {
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($student);
	    	$em->flush();
	    	if($isNew) {
	    		$this->get('event_dispatcher')->dispatch('usec.events.studentsubscription', new StudentSubscriptionEvent($student));
	    	}
	    	return $this->redirect($this->generateUrl('subscription_form', array('statusPost' => true, 'isNew' => $isNew)));
    	}
    }
    
    // TODO Move to an util class.
    public static function getNextSemestersAbrev($timestamp = NULL) {
    	if($timestamp == NULL)
    		$timestamp = time();
    	// Generate next semesters abreviations (A12, P13, A13, etc.).
    	$currentYear = (int) date('y', $timestamp);
    	$currentMonth = (int) date('n', $timestamp);
    	$currentSemester = 'A';
    	if($currentMonth >= 2 && $currentMonth <= 8) {
    		// Printemps (Février, ..., Août).
    		$currentSemester = 'P';
    	} // Else : Automne (Septembre, ..., Janvier).
    	if($currentMonth == 1)
    		$currentYear--;
    	for($i = 0; $i < 11; $i++) {
    		$nextSemesters[] = $currentSemester . (($currentYear < 10) ? 0 . $currentYear : $currentYear);
    		if($currentSemester == 'A')
    			$currentYear++;
    		if($currentYear == 100)
    			$currentYear = 00;
    		$currentSemester = ($currentSemester == 'A') ? 'P' : 'A';
    	}
    	return $nextSemesters;
    }
}
