<?php

namespace WebDiario\CoreBundle\Services\Aware;


use WebDiario\CoreBundle\Services\Subjects\SubjectsService;

trait SubjectsServiceAware
{
    /**
     * @var SubjectsService
     */
    protected $subjectsService;

    public function setSubjectsService(SubjectsService $subjectsService)
    {
        $this->subjectsService = $subjectsService;
    }
}