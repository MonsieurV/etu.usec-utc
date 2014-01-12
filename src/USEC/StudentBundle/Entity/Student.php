<?php

namespace USEC\StudentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="USEC\StudentBundle\Repository\StudentRepository")
 */
class Student
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="phone", type="string", length=255)
	 */
	private $phone;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="first_name", type="string", length=255)
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="login_utc", type="string", length=255)
	 */
	private $loginUtc;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="course", type="string", length=255)
	 */
	private $course;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="end_course_semester", type="string", length=255)
	 */
	private $endCourseSemester;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="skills", type="text", nullable=true)
	 */
	private $skills = null;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="interested_in", type="text", nullable=true)
	 */
	private $interestedIn = null;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="motivation", type="text", nullable=true)
	 */
	private $motivation = null;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_cv_uploaded", type="boolean")
	 */
	private $isCvUploaded;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="unsuscribe_date", type="datetime", nullable=true)
	 */
	private $unsuscribeDate = null;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="creation_date", type="datetime")
	 */
	private $creationDate;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="change_date", type="datetime", nullable=true)
	 */
    private $changeDate = null;

	private $apprenti = null;


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
     * Set loginUtc
     *
     * @param string $loginUtc
     * @return Student
     */
    public function setLoginUtc($loginUtc)
    {
        $this->loginUtc = $loginUtc;
    
        return $this;
    }

    /**
     * Get loginUtc
     *
     * @return string 
     */
    public function getLoginUtc()
    {
        return $this->loginUtc;
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
     * Set changeDate
     *
     * @param \DateTime $changeDate
     * @return Student
     */
    public function setApprenti($apprenti)
    {
        $this->apprenti = $apprenti;
    
        return $this;
    }

    /**
     * Get changeDate
     *
     * @return \DateTime 
     */
    public function getApprenti()
    {
        return $this->apprenti;
    }
}