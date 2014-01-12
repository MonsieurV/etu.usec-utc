<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class StudentSubscriptionEvent extends Event
{
	protected $student;
	
	public function __construct($student) {
		$this->student = $student;
	}

	public function getStudent()
	{
		return $this->student;
	}
}