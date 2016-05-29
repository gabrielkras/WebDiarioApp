<?php

namespace WebDiario\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="WebDiario\CoreBundle\Repository\CourseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Course
{
    const DIURNAL = 0;
    const VESPERTINE = 1;
    const NOCTURNAL = 2;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="abbreviation",type="string")
     */
    private $abbreviation;

    /**
     * @ORM\Column(name="code",type="string",length=8)
     */
    private $code;

    /**
     * @ORM\Column(name="time_code",type="integer",length=1)
     */
    private $timeCode;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param mixed $abbreviation
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getTimeCode()
    {
        return $this->timeCode;
    }

    /**
     * @param mixed $timeCode
     */
    public function setTimeCode($timeCode)
    {
        $this->timeCode = $timeCode;
    }



}