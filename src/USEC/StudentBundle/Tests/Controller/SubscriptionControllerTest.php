<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\Tests\Controller;

use USEC\StudentBundle\Controller\SubscriptionController;

class SubscriptiontControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNextSemestersAbrevP()
    {
        $nextSemesters = SubscriptionController::getNextSemestersAbrev(strtotime('01-02-2013'));
        $this->assertEquals(11, count($nextSemesters));
        $this->assertEquals('P13', $nextSemesters[0]);
        $this->assertEquals('A13', $nextSemesters[1]);
        $this->assertEquals('P14', $nextSemesters[2]);
        $this->assertEquals('A14', $nextSemesters[3]);
        $this->assertEquals('P15', $nextSemesters[4]);
        $this->assertEquals('A15', $nextSemesters[5]);
        $this->assertEquals('P16', $nextSemesters[6]);
        $this->assertEquals('A16', $nextSemesters[7]);
        $this->assertEquals('P17', $nextSemesters[8]);
        $this->assertEquals('A17', $nextSemesters[9]);
        $this->assertEquals('P18', $nextSemesters[10]);
    }
    
    public function testGetNextSemestersAbrevA()
    {
    	$nextSemesters = SubscriptionController::getNextSemestersAbrev(strtotime('01-09-2013'));
    	$this->assertEquals(11, count($nextSemesters));
    	$this->assertEquals('A13', $nextSemesters[0]);
    	$this->assertEquals('P14', $nextSemesters[1]);
    	$this->assertEquals('A14', $nextSemesters[2]);
    	$this->assertEquals('P15', $nextSemesters[3]);
    	$this->assertEquals('A15', $nextSemesters[4]);
    	$this->assertEquals('P16', $nextSemesters[5]);
    	$this->assertEquals('A16', $nextSemesters[6]);
    	$this->assertEquals('P17', $nextSemesters[7]);
    	$this->assertEquals('A17', $nextSemesters[8]);
    	$this->assertEquals('P18', $nextSemesters[9]);
    	$this->assertEquals('A18', $nextSemesters[10]);
    }
}
