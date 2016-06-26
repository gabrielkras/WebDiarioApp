<?php

namespace WebDiario\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use WebDiario\CoreBundle\Services\Aware\StudentServiceAware;

class StudentsController
{
    use AuthenticationServiceAware;
    use StudentServiceAware;

    /**
     * @param Request $request
     *
     * @ApiDoc(
     *     description="List all students",
     *     statusCodes={
     *         200="Returned when your request is ok",
     *         400="Returned when your request is in bad format",
     *         401="Returned when your don't have authorization to consumed the resource",
     *         405="Returned when you try to access this resource with another http method",
     *         500="Returned when the server have a some error",
     *     }
     * )
     */
    public function listAllStudents(Request $request)
    {
        if($this->authentication->checkUserAuthentication($request) == true)
        {
            return $this->studentService->listAllStudents($request);
        }
    }
}