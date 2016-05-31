<?php

namespace WebDiario\ApiBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use WebDiario\CoreBundle\Services\Aware\AuthenticationServiceAware;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class LoginController
{
    use AuthenticationServiceAware;
    /**
     * @param Request $request
     *
     * @ApiDoc(
     *     description="Make login in API",
     *     parameters={
     *         {
     *          "name"="email",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="User's email to authenticate"
     *      },
     *     {
     *          "name"="password",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="User's password to authenticate"
     *      },
     *     },
     *     statusCodes={
     *         201="Returned when your email and password is authorized",
     *         400="Returned when your request is in bad format",
     *         401="Returned when your don't have authorization to consumed the resource",
     *         403="Returned when your email and password is invalid",
     *         405="Returned when you try to access this resource with another http method",
     *     }
     * )
     */
    public function loginAction(Request $request)
    {
        return $this->authentication->receivedCredentialsAction($request);
    }

    /**
     * @param Request $request
     *
     * @ApiDoc(
     *     description="Make logout in API",
     *     statusCodes={
     *         200="Returned when your are logged out from api",
     *         400="Returned when your request is in bad format",
     *         405="Returned when you try to access this resource with another http method",
     *     }
     * )
     */
    public function logoutAction(Request $request)
    {
        return $this->authentication->loggedOut($request);
    }
}