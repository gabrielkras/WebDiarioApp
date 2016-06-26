<?php

namespace WebDiario\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="professors")
 * @ORM\Entity(repositoryClass="WebDiario\CoreBundle\Repository\ProfessorsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Professors
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="registry", type="string", length=32)
     */
    private $registry;

    /**
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="status_code", type="boolean")
     */
    private $enabled;

    /**
     * @return mixed
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param mixed $registry
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return "professor";
    }

}