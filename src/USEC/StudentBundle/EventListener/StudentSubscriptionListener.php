<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\EventListener;

use USEC\StudentBundle\Event\StudentSubscriptionEvent;

class StudentSubscriptionListener {
	protected $mailer;
	protected $templating;
	protected $notificationSubscriptionFrom;
	protected $forwardSubscriptionFrom;
	protected $forwardSubscriptionTo;
	
	public function __construct($mailer, $templating, $notificationSubscriptionFrom, $forwardSubscriptionFrom, $forwardSubscriptionTo) {
		$this->mailer = $mailer;
		$this->templating = $templating;
		$this->notificationSubscriptionFrom = $notificationSubscriptionFrom;
		$this->forwardSubscriptionFrom = $forwardSubscriptionFrom;
		$this->forwardSubscriptionTo = $forwardSubscriptionTo;
	}
	
	public function onSubscription(StudentSubscriptionEvent $event) {
		$student = $event->getStudent();
		// Send a notification to the suscriber.
		$message = \Swift_Message::newInstance()
		->setContentType("text/html")
		->setSubject('[USEC][PLATEFORME-ETU] Votre inscription a bien été prise en compte')
		->setFrom($this->notificationSubscriptionFrom)
		->setTo($student->getEmail())
		->setBody($this->templating->renderResponse('USECStudentBundle:Subscription:notificationEmail.txt.twig', array('student' => $student)));
		$this->mailer->send($message);
		// Send an email to USEC team.
		$message = \Swift_Message::newInstance()
		->setContentType("text/html")
		->setSubject('[USEC][PLATEFORME-ETU] Inscription de ' . $student->getFirstName() . ' ' . $student->getName())
		->setFrom($this->forwardSubscriptionFrom)
		->setTo($this->forwardSubscriptionTo)
		->setBody($this->templating->renderResponse('USECStudentBundle:Subscription:forwardEmail.txt.twig', array('student' => $student)));
		$this->mailer->send($message);
	}
}
