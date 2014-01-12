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

class DefaultAdminController extends Controller
{
	public function indexAction()
	{
		return $this->render('USECStudentBundle:Default:adminindex.html.twig');
	}
	
	// TODO To move to an Util class.
	public static function isUserAdmin($user, $controllerCntext) {
		return in_array($user->getRole(), array(
				$controllerCntext->container->getParameter('role_admin'),
				$controllerCntext->container->getParameter('role_allowed_to_switch'),
				$controllerCntext->container->getParameter('role_super_admin'),
		));
	}
}
