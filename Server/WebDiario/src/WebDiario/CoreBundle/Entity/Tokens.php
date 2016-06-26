<?php

namespace WebDiario\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tokens")
 * @ORM\Entity(repositoryClass="WebDiario\CoreBundle\Repository\TokensRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tokens
{
    /**
     * @ORM\Column(name="tokens", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Professors")
     * @ORM\JoinColumn(name="professor_id", referencedColumnName="id", nullable=true)
     */
    private $professor;

    /**
     * @ORM\OneToOne(targetEntity="Students")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=true)
     */
    private $student;

    /**
     * @ORM\Column(name="token", type="string", length=128)
     */
    private $token;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="expire", type="datetime")
     */
    private $expire;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param mixed $professor
     */
    public function setProfessor($professor)
    {
        $this->professor = $professor;
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * @return mixed
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param mixed $expire
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
    }



}