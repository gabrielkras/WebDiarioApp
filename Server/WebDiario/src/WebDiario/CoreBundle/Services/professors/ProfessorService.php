<?php

namespace WebDiario\CoreBundle\Services\professors;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\ApiBundle\Helpers\ApiProblem;
use WebDiario\ApiBundle\Helpers\ApiProblemException;
use WebDiario\ApiBundle\Helpers\ApiResponse;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use WebDiario\CoreBundle\Services\Aware\EntityManagerAware;

/**
 * Class ProfessorService
 * @package WebDiario\CoreBundle\Services\professors
 */
class ProfessorService
{
    use EntityManagerAware;
    use AuthenticationServiceAware;

    public function listAllPerStudents(Request $request, $id)
    {
        $student = $this->em->getRepository("CoreBundle:Students")
            ->findOneBy(array(
                'id' => $id
            ));
        if (!$student) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set("message","O recurso solicitado nao foi encontrado!");
            throw new ApiProblemException($apiProblem);
        }
        $subjectsArray = $this->em->getRepository("CoreBundle:Classroom")
            ->findAllSubjectsByStudent($student);
        $arrayFinal = array();
        foreach ($subjectsArray as $key => $value) {
            $array = [
                "subject" => array(
                    "name" => $value['subject']['name'],
                    "abbreviation" => $value['subject']['abbreviation'],
                    "classroom" => array(
                        "classroom_id" => $value['id'],
                        "year" => $value['year'],
                        "semester" => $value['semester'],
                        "enabled" => $value['enabled']
                    ),
                    "professor" => array(
                        "name" => $value['professor']['name'],
                        "registry" => $value['professor']['registry'],
                        "id" => $value['professor']['id']
                    ),
                    "student" => array(
                        "name" => $value['students'][0]['name'],
                        "registry" => $value['students'][0]['registry'],
                        "id" => $value['students'][0]['id']
                    )
                ),
            ];
            array_push($arrayFinal, $array);
        }
        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_OK);
        $apiResponse->setMessage("Listagem de Professores Realizada com sucesso!");
        $apiResponse->set("subjects", $arrayFinal);
        return $apiResponse->getResponse();
    }
}