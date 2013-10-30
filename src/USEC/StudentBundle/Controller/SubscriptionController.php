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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use USEC\StudentBundle\Entity\Student;

class SubscriptionController extends Controller
{
	private static $LIST_COURSES = array('TC', 'GB', 'GP', 'GI', 'GM', 'GSU', 'ESCOM', 'Autre');
	
    public function formAction() {
    	return $this->render('USECStudentBundle:Subscription:sign.html.twig', array(
    			'nextSemesters' => self::getNextSemestersAbrev(),
    			'listCourses' => self::$LIST_COURSES,
    			'user' => $this->get('security.context')->getToken()->getUser(),
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
    	$student->setSkills($request->request->get('skills'));
    	if(($isNew = $student->isRegistered()) != true)
    		$student->setIsRegistered(true);
    	
    	$validator = $this->get('validator');
    	$errors = $validator->validate($student);
    	
    	if(count($errors) > 0) {
    		return $this->redirect($this->generateUrl('subscription_form', array('postStatus' => false)));
    	}
    	else {
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($student);
	    	$em->flush();
	    	if($isNew)
	    		$this->onSubscription($student);
	    	return $this->redirect($this->generateUrl('subscription_form', array('postStatus' => true)));
    	}
    }
    
    // TODO Create a real Synfony event and deplace the event handler in a service class.
    protected function onSubscription(Student $student) {
    	// Send a notification to the suscriber.
    	$message = \Swift_Message::newInstance()
    	->setSubject('[USEC][PLATEFORME-ETU] Votre inscription a bien été prise en compte')
    	->setFrom($this->container->getParameter('notification_subscription_from'))
    	->setTo($student->getEmail())
    	->setBody($this->renderView('USECStudentBundle:Subscription:notificationEmail.txt.twig', array('student' => $student)));
    	$this->get('mailer')->send($message);
    	// Send an email to USEC team.
    	$message = \Swift_Message::newInstance()
	    	->setSubject('[USEC][PLATEFORME-ETU] Inscription de ' . $student->getFirstName() . ' ' . $student->getName())
	    	->setFrom($this->container->getParameter('forward_subscription_from'))
	    	->setTo($this->container->getParameter('forward_subscription_to'))
	    	->setBody($this->renderView('USECStudentBundle:Subscription:forwardEmail.txt.twig', array('student' => $student)));
    	$this->get('mailer')->send($message);
    }
    
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
