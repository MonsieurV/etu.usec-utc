<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\Entity;

use BeSimple\SsoAuthBundle\Security\Core\User\UserFactoryInterface;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use USEC\StudentBundle\Entity\Student;

/**
 * UserRepository
 */
class UserProvider implements UserProviderInterface, UserFactoryInterface
{
	protected $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}
	
	public function loadUserByUsername($username)
	{
		$user = $this->em->getRepository('USECStudentBundle:Student')->findOneByUsername($username);
		if(empty($user)){
			throw new UsernameNotFoundException(sprintf('Impossible de trouver l\'utilisateur "%s".', $username));
		}
	
		return $user;
	}
	
	public function refreshUser(UserInterface $user)
	{
		$class = get_class($user);
		if (!$this->supportsClass($class)) {
			throw new UnsupportedUserException(
					sprintf(
							'Instances of "%s" are not supported.',
							$class
					)
			);
		}
	
		return $this->em->getRepository('USECStudentBundle:Student')->findOneById($user->getId());
	}
	
	public function supportsClass($class)
	{
		return $class === 'USEC\StudentBundle\Entity\Student'
			|| is_subclass_of($class, 'USEC\StudentBundle\Entity\Student');
	}
	
	/**
	 * Use to create automatically student connecting using the CAS
	 * and that don't already exist in database.
	 *
	 * @inheritDoc
	 */
	public function createUser($username, array $roles, array $attributes) {
		$student = new Student();
		$student->setUsername($username);
		$student->setRoles($roles);
		$this->em->persist($student);
		$this->em->flush();
		return $student;
	}
}
