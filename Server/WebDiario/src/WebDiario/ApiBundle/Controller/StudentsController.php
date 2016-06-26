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
    public function listAllStudents(Request $request)
    {
        if($this->authentication->checkUserAuthentication($request) == true)
        {
            return $this->studentService->listAllStudents($request);
        }
    }
}