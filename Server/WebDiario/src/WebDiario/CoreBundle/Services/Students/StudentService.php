<?php

namespace WebDiario\CoreBundle\Services\Students;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\ApiBundle\Helpers\ApiProblem;
use WebDiario\ApiBundle\Helpers\ApiProblemException;
use WebDiario\ApiBundle\Helpers\ApiResponse;
use WebDiario\CoreBundle\Entity\Fouls;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use WebDiario\CoreBundle\Services\Aware\EntityManagerAware;

class StudentService
{
    use EntityManagerAware;
    use AuthenticationServiceAware;

    public function listAllStudents(Request $request, $id)
    {
        $professor = $this->em->getRepository("CoreBundle:Professors")
            ->findOneBy(array(
                "id" => $id
            ));
        if(!$professor)
        {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set('message', "O Recurso solicitado nao foi encontrado");
            throw new ApiProblemException($apiProblem);
        }
        $subjectsArray = $this->em->getRepository("CoreBundle:Classroom")
            ->findAllSubjectsByProfessor($professor);
        if (!$subjectsArray) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set("message","O professor ".$professor->getName()." nao possui materias!");
            throw new ApiProblemException($apiProblem);
        }

        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_OK);
        $apiResponse->setMessage("Listagem de alunos realizada com sucesso!");
        $apiResponse->set('Object_data', $professor);
        return $apiResponse->getResponse();
    }

    public function listStudentSubjects(Request $request, $id) {
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
        if (!$subjectsArray) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set("message","O professor ".$student->getName()." nao possui materias!");
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

    public function createFouls(Request $request)
    {
        $information = $this->decodeRequest($request);
        if (!$information) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            $apiProblem->set("message","O corpo da requisicao encontra-se vazio!");
            throw new ApiProblemException($apiProblem);
        }
        if (!isset($information["fouls"])) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            $apiProblem->set("message","Nao foi possivel encontrar o atributo 'fouls'!");
            throw new ApiProblemException($apiProblem);
        }
        $foulsArray = array();
        foreach ($information['fouls'] as $key => $value) {
            if (!isset($value['student_id']) || !isset($value['classroom_id']) ||
            !isset($value['date']) || !isset($value['quantity'])){
                $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
                $apiProblem->set("message","O Campo 'student_id' ou 'classroom_id' ou 'date' ou 'quantity' nao foram encontrado no corpo da requisição! ");
                throw new ApiProblemException($apiProblem);
            }
            if ($value['quantity'] <= 0) {
                $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
                $apiProblem->set("message","o campo 'quantity' nao pode possuir valores menores do que zero" );
                throw new ApiProblemException($apiProblem);
            }
            $student = $this->em->getRepository("CoreBundle:Students")
                ->findOneBy(array(
                    "id" => $value['student_id']
                ));
            if(!$student){
                $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
                $apiProblem->set("message","O 'student_id' =>".$value['student_id']." nao existe!" );
                throw new ApiProblemException($apiProblem);
            }
            $classroom = $this->em->getRepository("CoreBundle:Classroom")
                ->findOneBy(array(
                    "id" => $value['classroom_id']
                ));
            if(!$classroom){
                $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
                $apiProblem->set("message","O 'classroom_id' =>".$value['classroom_id']." nao existe!" );
                throw new ApiProblemException($apiProblem);
            }
            $fouls = new Fouls();
            $fouls->setClassroom($classroom);
            $fouls->setQuantity($value['quantity']);
            $fouls->setStudent($student);
            $fouls->setDate(new \DateTime($value['date']));
            $this->em->persist($fouls);
            $this->em->flush();
            array_push($foulsArray, array(
                "name" => $fouls->getStudent()->getName(),
                "registry" => $fouls->getStudent()->getRegistry(),
                "fouls" => array(
                    "subject" => array(
                        "name" => $fouls->getClassroom()->getSubjects()->getName(),
                        "abbreviation" => $fouls->getClassroom()->getSubjects()->getAbbreviation(),
                    ),
                    "quantity" => $fouls->getQuantity(),
                    "date" => $fouls->getDate()
                ),
            ));
        }
        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_CREATED);
        $apiResponse->setMessage("As faltas foram aplicadas com sucesso");
        $apiResponse->set("subjects", $foulsArray);
        return $apiResponse->getResponse();
    }

    public function getFouls(Request $request, $id)
    {
        $student = $this->em->getRepository("CoreBundle:Students")
            ->findOneBy(array(
                "id" => $id
            ));
        if(!$student){
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            $apiProblem->set("message","O recurso solicitado não existe!");
            throw new ApiProblemException($apiProblem);
        }
        $fouls = $this->em->getRepository("CoreBundle:Fouls")
            ->findBy(array(
                "student" => $student
            ));
        if (!$fouls) {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_RESOURCE_NOT_FOUND);
            $apiProblem->set("message","O aluno '".$student->getName()."' nao possui faltas!");
            throw new ApiProblemException($apiProblem);
        }
        $arrayFinal = array();
        foreach ($fouls as $key => $value) {
            $array = [
                "subject" => array(
                    "name" => $value->getClassroom()->getSubjects()->getName(),
                    "abbreviation" => $value->getClassroom()->getSubjects()->getName(),
                    "classroom" => array(
                        "classroom_id" => $value->getClassroom()->getId(),
                        "year" => $value->getClassroom()->getYear(),
                        "semester" => $value->getClassroom()->getSemester()
                    ),
                    "professor" => array(
                        "name" => $value->getClassroom()->getProfessor()->getName(),
                        "registry" => $value->getClassroom()->getProfessor()->getRegistry()
                    ),
                    "foul" => array(
                        "quantity" => $value->getQuantity(),
                        "date" => $value->getDate(),
                    ),
                ),
            ];
            array_push($arrayFinal,$array);
        }
        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_CREATED);
        $apiResponse->setMessage("As faltas foram aplicadas com sucesso");
        $apiResponse->set("fouls", $arrayFinal);
        return $apiResponse->getResponse();
    }

    private function decodeRequest(Request $request)
    {
        return json_decode($request->getContent(),true);
    }

}