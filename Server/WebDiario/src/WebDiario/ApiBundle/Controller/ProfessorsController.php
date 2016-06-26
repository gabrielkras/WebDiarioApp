<?php

namespace WebDiario\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use WebDiario\CoreBundle\Services\Aware\ProfessorServiceAware;
use WebDiario\CoreBundle\Services\Aware\SubjectsServiceAware;

/**
 * Class ProfessorsController
 * @package WebDiario\ApiBundle\Controller
 */
class ProfessorsController
{
    use AuthenticationServiceAware;
    use SubjectsServiceAware;
    use ProfessorServiceAware;

    public function subjectList(Request $request, $id)
    {
        if ($this->authentication->checkUserAuthentication($request)) {
            return $this->subjectsService->receivedRequest($request, $id);
        }
    }

    public function listProfessors(Request $request, $id)
    {
        if ($this->authentication->checkUserAuthentication($request)) {
            return $this->professorService->listAllPerStudents($request, $id);
        }
    }
}