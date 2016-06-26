<?php

namespace WebDiario\CoreBundle\Services\Aware;

use WebDiario\CoreBundle\Services\Students\StudentService;

trait StudentServiceAware
{
    /**
     * @var StudentService
     */
    protected $studentService;

    public function setStudentService(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

}