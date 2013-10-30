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
    public function formAction() {
    	return $this->render('USECStudentBundle:Subscription:new.html.twig', array(
    			'nextSemesters' => self::getNextSemestersAbrev(),
    	));
    }
    
    public function processAction(Request $request) {
    	$student = new Student();
    	$student->setCreationDate(new \DateTime());
    	$student->setName($request->request->get('name'));
    	$student->setFirstName($request->request->get('firstName'));
    	$student->setLoginUtc($request->request->get('loginUtc'));
    	$student->setEmail($request->request->get('email'));
    	$student->setPhone($request->request->get('phone'));
    	$student->setCourse($request->request->get('course'));
    	$student->setEndCourseSemester($request->request->get('endCourseSemester'));
    	$student->setMotivation($request->request->get('motivation'));
    	$student->setInterestedIn($request->request->get('interestedIn'));
    	$student->setSkills($request->request->get('skills'));
    	
    	$validator = $this->get('validator');
    	$errors = $validator->validate($student);
    	
    	if(count($errors) > 0) {
    		return new Response(print_r($errors, true));
    		return new Response(json_encode(array('status' => false, 'errors' => print_r($errors, true))), 200, array('Content-Type', 'application/json'));
    	}
    	else {
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($student);
	    	$em->flush();
	    	$this->onSubscription($student);
	    	return new Response(json_encode(array('status' => true)), 200, array('Content-Type', 'application/json'));
    	}
    }
    
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
    
    protected static function getNextSemestersAbrev($timestamp = NULL) {
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
