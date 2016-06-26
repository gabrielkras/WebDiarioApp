<?php

namespace WebDiario\CoreBundle\Services\Students;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\ApiBundle\Helpers\ApiProblem;
use WebDiario\ApiBundle\Helpers\ApiProblemException;
use WebDiario\ApiBundle\Helpers\ApiResponse;
use WebDiario\CoreBundle\Services\Aware\EntityManagerAware;

class StudentService
{
    use EntityManagerAware;

    public function listAllStudents(Request $request)
    {
        $students = $this->em->getRepository('CoreBundle:Students')
            ->findAll();

        if(!$students)
        {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set('message', "Nao existem alunos cadastrados no banco de dados");
            throw new ApiProblemException($apiProblem);
        }
        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_OK);
        $apiResponse->setMessage("Listagem de alunos realizada com sucesso!");
        $apiResponse->set('Object_data', $students);
        return $apiResponse->getResponse();
    }

}