<?php

namespace WebDiario\ApiBundle\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    // http status code (good)
    const HTTP_OK = 'ok';
    const HTTP_CREATED = 'created';
    const HTTP_NO_CONTENT = 'no_content';

    private static $titles = array(
        self::HTTP_OK => "Operacao realizada com sucesso!",
        self::HTTP_CREATED => "Recurso criado com sucesso!",
        self::HTTP_NO_CONTENT => "Sucesso! - Nao foi necessario retornar valores do servidor para esta requisicao!"
    );

    private static $httpCodes = array(
        self::HTTP_OK => 200,
        self::HTTP_CREATED => 201,
        self::HTTP_NO_CONTENT => 204,
    );

    private $type;
    private $title;
    private $statusCode;
    private $message;
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
        $this->response->headers->set('Content-Type', "application/json; charset=utf-8");
    }

    public static function createApiResponseByCode($code)
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
        $apiResponse = $apiResponse = new ApiResponse(self::HTTP_OK);
        switch($code)
        {
            case self::HTTP_OK:
                $apiResponse = new ApiResponse(self::HTTP_OK);
                break;
            case self::HTTP_CREATED:
                $apiResponse = new ApiResponse(self::HTTP_CREATED);
                break;
            case self::HTTP_NO_CONTENT:
                $apiResponse = new ApiResponse(self::HTTP_NO_CONTENT);
                break;
        }
        return $apiResponse;
    }

    public function set($name, $value)
    {
        $this->details[$name] = $value;
    }

    public function setMessage($message)
    {
        $this->message = $message;
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
                'message' => $this->message,
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