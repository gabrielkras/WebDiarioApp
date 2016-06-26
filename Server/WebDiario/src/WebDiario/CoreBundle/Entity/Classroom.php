<?php

namespace WebDiario\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="classroom")
 * @ORM\Entity(repositoryClass="WebDiario\CoreBundle\Repository\Classroom")
 * @ORM\HasLifecycleCallbacks()
 */
class Classroom
{
    const SEMESTER_1 = 0;
    const SEMESTER_2 = 1;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="Subjects")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    private $subjects;

    /**
     * @ORM\Column(name="year",type="integer", length=4)
     */
    private $year;

    /**
     * @ORM\Column(name="semester", type="integer", length=1)
     */
    private $semester;

    /**
     * @ORM\ManyToOne(targetEntity="Professors")
     * @ORM\JoinColumn(name="professor_id", referencedColumnName="id")
     */
    private $professor;

    /**
     * @ORM\ManyToMany(targetEntity="Students")
     * @ORM\JoinTable(name="classroom_students",
     *     joinColumns={
     *          @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="classroom_id", referencedColumnName="id")
     *     },
     * )
     */
    private $students;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

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
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @param mixed $subjects
     */
    public function setSubjects($subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
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
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param mixed $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
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

}