<?php

namespace WebDiario\CoreBundle\Services\Aware;

use WebDiario\CoreBundle\Services\professors\ProfessorService;

trait ProfessorServiceAware
{
    /**
     * @var ProfessorService
     */
    protected $professorService;

    public function setProfessorService(ProfessorService $professorService)
    {
        $this->professorService = $professorService;
    }

}