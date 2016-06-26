<?php

namespace WebDiario\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use WebDiario\CoreBundle\Services\Aware\SubjectsServiceAware;

/**
 * Class ProfessorsController
 * @package WebDiario\ApiBundle\Controller
 */
class ProfessorsController
{
    use AuthenticationServiceAware;
    use SubjectsServiceAware;

    public function subjectList(Request $request, $id)
    {
        if ($this->authentication->checkUserAuthentication($request)) {
            return $this->subjectsService->receivedRequest($id);
        }
    }
}