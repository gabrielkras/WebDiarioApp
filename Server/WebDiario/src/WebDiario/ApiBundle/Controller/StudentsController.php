<?php

namespace WebDiario\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use WebDiario\CoreBundle\Services\Aware\StudentServiceAware;

class StudentsController
{
    use AuthenticationServiceAware;
    use StudentServiceAware;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllStudents(Request $request, $id)
    {
        if($this->authentication->checkUserAuthentication($request) == true)
        {
            return $this->studentService->listAllStudents($request, $id);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listSubjectsByStudent(Request $request, $id)
    {
        if($this->authentication->checkUserAuthentication($request) == true)
        {
            return $this->studentService->listAllStudents($request, $id);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createFouls(Request $request)
    {
        if($this->authentication->checkUserAuthentication($request) == true)
        {
            return $this->studentService->createFouls($request);
        }
    }

    public function listFouls(Request $request, $id)
    {
        if($this->authentication->checkUserAuthentication($request) == true)
        {
            return $this->studentService->getFouls($request, $id);
        }
    }
}