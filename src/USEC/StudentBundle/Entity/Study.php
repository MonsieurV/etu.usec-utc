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

/**
 * Study
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Study {
	
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;
	
	/**
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;
	
	/**
	 * @ORM\Column(name="department", type="string", length=20)
	 */
	private $department = null;
	
	/**
	 * @ORM\Column(name="skills_required", type="string", length=255, nullable=true)
	 */
	private $skillsRequired = null;
	
	/**
	 * @ORM\Column(name="company", type="string", length=255, nullable=true)
	 */
	private $company = null;
	
	/**
	 * @ORM\Column(name="estimated_pay", type="string", length=255)
	 */
	private $estimatedPay;
	
	/**
	 * @ORM\Column(name="created_by", type="integer")
	 */
	private $createdBy;
	
	/**
	 * @ORM\Column(name="creation_date", type="datetime")
	 */
	private $creationDate;
	
	/**
	 * @ORM\Column(name="change_date", type="datetime", nullable=true)
	 */
	private $changeDate = null;
	
	/**
	 * @ORM\Column(name="closed_date", type="datetime", nullable=true)
	 */
	private $closedDate = null;
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id) {
    	$this->id = $id;
    	
    	return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Study
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Study
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set skillsRequired
     *
     * @param string $skillsRequired
     * @return Study
     */
    public function setSkillsRequired($skillsRequired)
    {
        $this->skillsRequired = $skillsRequired;
    
        return $this;
    }

    /**
     * Get skillsRequired
     *
     * @return string 
     */
    public function getSkillsRequired()
    {
        return $this->skillsRequired;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Study
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set estimatedPay
     *
     * @param string $estimatedPay
     * @return Study
     */
    public function setEstimatedPay($estimatedPay)
    {
        $this->estimatedPay = $estimatedPay;
    
        return $this;
    }

    /**
     * Get estimatedPay
     *
     * @return string 
     */
    public function getEstimatedPay()
    {
        return $this->estimatedPay;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Study
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
     * @return Study
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
     * Set closedDate
     *
     * @param \DateTime $closedDate
     * @return Study
     */
    public function setClosedDate($closedDate)
    {
        $this->closedDate = $closedDate;
    
        return $this;
    }

    /**
     * Get closedDate
     *
     * @return \DateTime 
     */
    public function getClosedDate()
    {
        return $this->closedDate;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     * @return Study
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return Study
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    
        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment()
    {
        return $this->department;
    }
    
    /**
     * Custom setter for closedDate.
     * 
     * @param boolean $isClosed
     * @return \USEC\StudentBundle\Entity\Study
     */
    public function setIsClosed($isClosed) {
    	$this->closedDate = ($isClosed && $this->closedDate == null) ? new \DateTime() : null;
    	
    	return $this;
    }
    
    /**
     * Custom getter for closedDate.
     * 
     * @return boolean
     */
    public function isClosed() {
    	return $this->closedDate != null;
    }
}