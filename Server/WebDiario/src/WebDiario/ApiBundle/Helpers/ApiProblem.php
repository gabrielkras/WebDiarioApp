<?php
namespace WebDiario\ApiBundle\Helpers;


use Symfony\Component\HttpFoundation\Response;

class ApiProblem
{
    const TYPE_VALIDATION_ERROR = 'validation_error'; // 400
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format'; // 400
    const TYPE_UNAUTHORIZED = 'unauthorized'; // 401
    const TYPE_BAD_CREDENTIALS = 'bad_credentials'; // 403
    const TYPE_METHOD_NOT_ALLOWED = 'http_method_not_allowed'; // 405
    const TYPE_RESOURCE_NOT_FOUND = 'resource_not_found'; // 404
    const TYPE_INTERNAL_SERVER_ERROR = 'internal_server_error'; // 500

    private static $titles = array(
        self::TYPE_VALIDATION_ERROR => "Erro de validacao!",
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => "Formato JSON invaldo!",
        self::TYPE_UNAUTHORIZED => "Requisicao nao autorizada!",
        self::TYPE_BAD_CREDENTIALS => "As credenciais informadas sao invalidas!",
        self::TYPE_METHOD_NOT_ALLOWED => "Metodo HTTP nao permitido!",
        self::TYPE_INTERNAL_SERVER_ERROR => "Erro interno do servidor!",
        self::TYPE_RESOURCE_NOT_FOUND => "O Recurso buscado nao foi encontrado!"
    );

    private static $httpCodes = array(
        self::TYPE_VALIDATION_ERROR => 400,
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 400,
        self::TYPE_UNAUTHORIZED => 401,
        self::TYPE_BAD_CREDENTIALS => 403,
        self::TYPE_METHOD_NOT_ALLOWED => 405,
        self::TYPE_RESOURCE_NOT_FOUND => 404,
        self::TYPE_INTERNAL_SERVER_ERROR => 500
    );

    private $statusCode;
    private $type;
    private $title;
    private $details;
    private $response;

    public function __construct($type = null)
    {
        $this->type = $type;
        $this->title = self::$titles[$type];
        $this->statusCode = self::$httpCodes[$type];
        $this->details = array();
        $this->response = new Response();
        $this->response->setStatusCode($this->statusCode);
        $this->response->headers->set('Content-Type', "application/problem+json; charset=utf-8");
    }

    public static function createApiProblemByCode($code)
    {
        if(gettype($code) == "integer")
        {
            foreach(self::$httpCodes as $key => $value){
                if($code == $value)
                {
                    $code = $key;
                    break;
                }
            }
        }
        $apiProblem = $apiProblem = new ApiProblem(self::TYPE_INTERNAL_SERVER_ERROR);
        switch($code)
        {
            case self::TYPE_VALIDATION_ERROR:
                $apiProblem = new ApiProblem(self::TYPE_VALIDATION_ERROR);
                break;
            case self::TYPE_METHOD_NOT_ALLOWED:
                $apiProblem = new ApiProblem(self::TYPE_METHOD_NOT_ALLOWED);
                break;
            case self::TYPE_BAD_CREDENTIALS:
                $apiProblem = new ApiProblem(self::TYPE_BAD_CREDENTIALS);
                break;
            case self::TYPE_INVALID_REQUEST_BODY_FORMAT:
                $apiProblem = new ApiProblem(self::TYPE_INVALID_REQUEST_BODY_FORMAT);
                break;
            case self::TYPE_RESOURCE_NOT_FOUND:
                $apiProblem = new ApiProblem(self::TYPE_RESOURCE_NOT_FOUND);
                break;
            case self::TYPE_UNAUTHORIZED:
                $apiProblem = new ApiProblem(self::TYPE_UNAUTHORIZED);
                break;
        }
        return $apiProblem;
    }

    public function set($name, $value)
    {
        $this->details[$name] = $value;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getResponse()
    {
        if(!$this->response->getContent())
        {
            $this->finishContent();
        }
        return $this->response;
    }

    private function toArray()
    {
        return array_merge(
            array(
                'type' => $this->type,
                'title' => $this->title,
                'statusCode' => $this->statusCode,
                'extraInformation' => $this->details,
            )
        );
    }

    private function finishContent()
    {
        $this->response->setContent(
            $this->encodeData($this->toArray())
        );
    }

    private function encodeData($data)
    {
        return json_encode($data);
    }

}