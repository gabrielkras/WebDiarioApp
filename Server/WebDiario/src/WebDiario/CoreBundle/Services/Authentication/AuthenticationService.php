<?php
namespace WebDiario\CoreBundle\Services\Authentication;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use WebDiario\ApiBundle\Helpers\ApiProblem;
use WebDiario\ApiBundle\Helpers\ApiProblemException;
use WebDiario\ApiBundle\Helpers\ApiResponse;
use WebDiario\CoreBundle\Services\Aware\EntityManagerAware;

class AuthenticationService
{
    use EntityManagerAware;
    use ContainerAwareTrait;

    public function receivedCredentialsAction(Request $request)
    {
        $information = $this->decodeRequest($request);
        if((!isset($information['email'])) || (!isset($information['password'])))
        {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_VALIDATION_ERROR);
            $apiProblem->set("message","O JSON recebido nao possui os campos 'email' e/ou 'password'");
            throw new ApiProblemException($apiProblem);
        }
        $email = $information['email'];
        $password = $information['password'];
        $account = $this->checkEmailAndPassword($email,$password);
        if(get_class($account) === "Wideti\\DomainBundle\\Entity\\Account")
        {
            if($account)
            {
                $token = $this->generateToken();
                if(!$token){
                    $problem = new ApiProblem(ApiProblem::TYPE_INTERNAL_SERVER_ERROR);
                    $problem->set('message',"Erro ao gerar token de validacao!");
                    throw new ApiProblemException($problem);
                }
                $this->saveTokenAndActiveThen($token,$account);
                $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_CREATED);
                $apiResponse->set('token', $token);
                $apiResponse->setMessage("Autenticacao realizada com sucesso!");
                return $apiResponse->getResponse();
            }
        }
        else if(get_class($account) === "Symfony\\Component\\HttpFoundation\\Response")
        {
            return $account;
        }
        throw new ApiProblemException(new ApiProblem(ApiProblem::TYPE_BAD_CREDENTIALS));
    }

    public function checkUserAuthentication(Request $request)
    {
        $auth = $request->headers->get('Authorization');
        if(!$auth)
        {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_UNAUTHORIZED);
            $apiProblem->set('message',"Para consumir este recurso o usuario precisa estar autenticado!");
            throw new ApiProblemException($apiProblem);
        }
        $token = $this->em->getRepository('DomainBundle:Tokens')
            ->findOneBy(
                array(
                    'token' => $auth
                )
            );
        if(!$token)
        {
            throw new ApiProblemException(ApiProblem::createApiProblemByCode(ApiProblem::TYPE_BAD_CREDENTIALS));
        }
        return true;
    }

    public function loggedOut(Request $request)
    {
        $auth = $request->headers->get('Authorization');
        if(!$auth)
        {
            $apiProblem = ApiProblem::createApiProblemByCode(ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            $apiProblem->set('message', "Nao foi possivel identifica-lo! Por favor, envie o token de autorizacao");
            throw new ApiProblemException($apiProblem);
        }
        $token = $this->em->getRepository('DomainBundle:Tokens')
            ->findOneBy(
                array(
                    'token' => $auth
                )
            );
        if(!$token)
        {
            throw new ApiProblemException(ApiProblem::createApiProblemByCode(ApiProblem::TYPE_BAD_CREDENTIALS));
        }
        $this->em->remove($token);
        $this->em->flush();
        $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_OK);
        $apiResponse->setMessage("Voce foi desconectado com sucesso da API!");
        return $apiResponse->getResponse();
    }

    private function decodeRequest(Request $request)
    {
        return json_decode($request->getContent(),true);
    }

    private function checkEmailAndPassword($email, $password)
    {
        $account = $this->em->getRepository('DomainBundle:Account')
            ->findOneBy([
                'email' => $email,
                'password' => $password
            ]);
        if(!$account)
        {
            throw new ApiProblemException(ApiProblem::createApiProblemByCode(ApiProblem::TYPE_BAD_CREDENTIALS));
        }
        $token = $this->em->getRepository('DomainBundle:Tokens')
            ->findOneBy([
                'account' => $account,
            ]);
        if(!$token)
        {
            return $account;
        }
        $dateTime = new \DateTime("now");
        if($token->getExpire() > $dateTime)
        {
            $apiResponse = ApiResponse::createApiResponseByCode(ApiResponse::HTTP_CREATED);
            $apiResponse->set('token', $token->getToken());
            $apiResponse->setMessage("Autenticacao realizada com sucesso!");
            return $apiResponse->getResponse();
        }
        else
        {
            $this->em->remove($token);
            $this->em->flush();
            return $account;
        }

    }

    private function generateToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes($this->container->getParameter('token_length')));
        $token = strtoupper($token);
        return $token;
    }

    private function saveTokenAndActiveThen($token, Account $account)
    {
        $Token = new Tokens();
        $Token->setAccount($account);
        $Token->setToken($token);
        $Token->setExpire(new \DateTime(
            "+ ".$this->container->getParameter('token_expire_time')." hours"
        ));
        $Token->setCreated();
        $this->em->persist($Token);
        $this->em->flush();
    }

}