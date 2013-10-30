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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Student
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="USEC\StudentBundle\Entity\StudentRepository")
 */
class Student implements UserInterface, \Serializable, EquatableInterface
{
	const DEFAULT_ROLE = 'ROLE_UTC_CAS';
	
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * The username used for the CAS is the UTC login.
	 * 
	 * @ORM\Column(name="username", type="string", length=255)
	 */
	private $username;
	
	/**
	 * @ORM\Column(name="is_registered", type="boolean")
	 */
	private $isRegistered;
	
	/**
	 * @ORM\Column(name="role", type="string", length=30)
	 */
	private $role;

	/**
	 * @ORM\Column(name="email", type="string", length=255, nullable=true)
	 */
	private $email = null;

	/**
	 * @ORM\Column(name="phone", type="string", length=255, nullable=true)
	 */
	private $phone = null;
	
	/**
	 * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
	 */
	private $firstName = null;

	/**
	 * @ORM\Column(name="name", type="string", length=255, nullable=true)
	 */
	private $name = null;

	/**
	 * @ORM\Column(name="course", type="string", length=255, nullable=true)
	 */
	private $course = null;
	
	/**
	 * @ORM\Column(name="end_course_semester", type="string", length=255, nullable=true)
	 */
	private $endCourseSemester = null;

	/**
	 * @ORM\Column(name="skills", type="text", nullable=true, nullable=true)
	 */
	private $skills = null;
	
	/**
	 * @ORM\Column(name="interested_in", type="text", nullable=true)
	 */
	private $interestedIn = null;
	
	/**
	 * @ORM\Column(name="motivation", type="text", nullable=true)
	 */
	private $motivation = null;

	/**
	 * @ORM\Column(name="is_cv_uploaded", type="boolean", nullable=true)
	 */
	private $isCvUploaded;

	/**
	 * @ORM\Column(name="creation_date", type="datetime")
	 */
	private $creationDate;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="change_date", type="datetime", nullable=true)
	 */
	private $changeDate = null;
	
	public function __construct()
	{
		/*
		 * If a student has been connected to the platform by CAS,
	 	 * that doesn't mean that he is registered. 
		 */
		$this->isRegistered = false;
		// Currently, we manage and persist only one role.
		$this->role = array(self::DEFAULT_ROLE);
		$this->isCvUploaded = false;
		$this->creationDate = new \DateTime();
	}
	
	/**
	 * @inheritDoc
	 */
	public function getUsername()
	{
		// .
		return $this->username;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getPassword()
	{
		// As we only use the UTC CAS for login, no password is needed.
		return 'coincoin';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getSalt()
	{
		// As there is no password needed, no salt is needed.
		return '42';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getRoles()
	{
		return array($this->role);
	}
	
	public function setRoles($roles)
	{
		$this->role = empty($roles) ? self::DEFAULT_ROLE : $roles[0];
	}
	
	/**
	 * @inheritDoc
	 */
	public function eraseCredentials()
	{
	}

	/**
	 * @see \Serializable::serialize()
	 */
	public function serialize()
	{
		return serialize(array(
				$this->id,
				$this->username
		));
	}
	
	/**
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized)
	{
		list (
				$this->id,
				$this->username
		) = unserialize($serialized);
	}
	
	public function isEqualTo(UserInterface $user)
	{
		return $this->username === $user->getUsername();
	}
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Student
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set course
     *
     * @param string $course
     * @return Student
     */
    public function setCourse($course)
    {
        $this->course = $course;
    
        return $this;
    }

    /**
     * Get course
     *
     * @return string 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set endCourseSemester
     *
     * @param string $endCourseSemester
     * @return Student
     */
    public function setEndCourseSemester($endCourseSemester)
    {
        $this->endCourseSemester = $endCourseSemester;
    
        return $this;
    }

    /**
     * Get endCourseSemester
     *
     * @return string 
     */
    public function getEndCourseSemester()
    {
        return $this->endCourseSemester;
    }

    /**
     * Set skills
     *
     * @param string $skills
     * @return Student
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    
        return $this;
    }

    /**
     * Get skills
     *
     * @return string 
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set interestedIn
     *
     * @param string $interestedIn
     * @return Student
     */
    public function setInterestedIn($interestedIn)
    {
        $this->interestedIn = $interestedIn;
    
        return $this;
    }

    /**
     * Get interestedIn
     *
     * @return string 
     */
    public function getInterestedIn()
    {
        return $this->interestedIn;
    }

    /**
     * Set motivation
     *
     * @param string $motivation
     * @return Student
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;
    
        return $this;
    }

    /**
     * Get motivation
     *
     * @return string 
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set isCvUploaded
     *
     * @param boolean $isCvUploaded
     * @return Student
     */
    public function setIsCvUploaded($isCvUploaded)
    {
        $this->isCvUploaded = $isCvUploaded;
    
        return $this;
    }

    /**
     * Get isCvUploaded
     *
     * @return boolean 
     */
    public function getIsCvUploaded()
    {
        return $this->isCvUploaded;
    }

    /**
     * Set unsuscribeDate
     *
     * @param \DateTime $unsuscribeDate
     * @return Student
     */
    public function setUnsuscribeDate($unsuscribeDate)
    {
        $this->unsuscribeDate = $unsuscribeDate;
    
        return $this;
    }

    /**
     * Get unsuscribeDate
     *
     * @return \DateTime 
     */
    public function getUnsuscribeDate()
    {
        return $this->unsuscribeDate;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Student
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set changeDate
     *
     * @param \DateTime $changeDate
     * @return Student
     */
    public function setChangeDate($changeDate)
    {
        $this->changeDate = $changeDate;
    
        return $this;
    }

    /**
     * Get changeDate
     *
     * @return \DateTime 
     */
    public function getChangeDate()
    {
        return $this->changeDate;
    }

    /**
     * Set isRegistered
     *
     * @param boolean $isRegistered
     * @return Student
     */
    public function setIsRegistered($isRegistered)
    {
        $this->isRegistered = $isRegistered;
    
        return $this;
    }

    /**
     * Get isRegistered
     *
     * @return boolean 
     */
    public function getIsRegistered()
    {
        return $this->isRegistered;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Student
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
}