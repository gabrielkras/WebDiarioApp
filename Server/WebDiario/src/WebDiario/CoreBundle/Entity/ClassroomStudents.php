<?php

namespace WebDiario\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="classroom_students")
 * @ORM\Entity(repositoryClass="WebDiario\CoreBundle\Repository\ClassroomStudentsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ClassroomStudents
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="WebDiario\CoreBundle\Entity\Students")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="WebDiario\CoreBundle\Entity\Classroom")
     * @ORM\JoinColumn(name="classroom_id", referencedColumnName="id")
     */
    private $classroom;

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
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * @param mixed $classroom
     */
    public function setClassroom($classroom)
    {
        $this->classroom = $classroom;
    }

}