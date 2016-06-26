<?php

namespace WebDiario\CoreBundle\Services\Subjects;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\ApiBundle\Helpers\ApiProblem;
use WebDiario\ApiBundle\Helpers\ApiProblemException;
use WebDiario\ApiBundle\Helpers\ApiResponse;
use WebDiario\CoreBundle\Entity\ClassroomStudents;
use WebDiario\CoreBundle\Services\Aware\EntityManagerAware;

/**
 * Class SubjectsService
 * @package WebDiario\CoreBundle\Services\Subjects
 */
class SubjectsService
{
    use EntityManagerAware;

    public function receivedRequest($id)
    {
        $professor = $this->em->getRepository("CoreBundle:Professors")
            ->findOneBy(array(
                'id' => $id
            ));
        if (!$professor) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set("message","O recurso solicitado nao foi encontrado!");
            throw new ApiProblemException($apiProblem);
        }
        $subjectsArray = $this->em->getRepository("CoreBundle:Classroom")
            ->findAllSubjectsByProfessor($professor);
        if (!$subjectsArray) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set("message","O professor ".$professor->getName()." nao possui materias!");
            throw new ApiProblemException($apiProblem);
        }

        $arrayFinal = array();
        foreach ($subjectsArray as $key => $value) {
            $arrayFinalStud = array();
            foreach ($value['students'] as $key2 => $value2) {
                $arrayStud = [
                    "name" => $value2['name'],
                    "registry" => $value2['registry'],
                    "studentId" => $value2['id']
                ];
                array_push($arrayFinalStud,$arrayStud);
            }
            $array = [
                "name" => $value['subject']['name'],
                "abbreviation" => $value['subject']['abbreviation'],
                "subjectId" => $value['subject']['id'],
                "course" => array(
                    "name" => $value['course']['name'],
                    "abbreviation" => $value['course']['abbreviation'],
                    "code" => $value['course']['code'],
                    "timeCode" => $value['course']['timeCode']
                ),
                "professor" => array(
                    "name" => $value['professor']['name'],
                    "registry" => $value['professor']['registry'],
                ),
                "students" => $arrayFinalStud
            ];
            array_push($arrayFinal, $array);
        }

        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_OK);
        $apiResponse->setMessage("Listagem de Materias Realizada com sucesso!");
        $apiResponse->set("subjects", $arrayFinal);
        return $apiResponse->getResponse();
    }

}