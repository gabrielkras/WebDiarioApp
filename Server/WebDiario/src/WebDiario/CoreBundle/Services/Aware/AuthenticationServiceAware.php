<?php

namespace WebDiario\CoreBundle\Services\Aware;

use WebDiario\CoreBundle\Services\Authentication\AuthenticationService;

trait AuthenticationServiceAware
{
    /**
     * @var AuthenticationService
     */
    protected $authentication;

    public function setAuthenticationService(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }


}