<?php

require_once 'lib/nusoap.php';

class Client01
{
    const SERVICE_NAME = '/apps/soap/service01.php?wsdl';
    const FUNCTION_NAME = 'addNumbers';

    private $client;
    private $log;
    private $result;

    public function __construct()
    {
        $wsdl = "http://{$_SERVER['HTTP_HOST']}" . self::SERVICE_NAME;
        $this->client = new nusoap_client($wsdl);
        if (($error = $this->client->getError())) {
            $this->log("error conectado con el servicio SOAP: $error");
            $this->client = null;
        }
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getLog()
    {
        return $this->log;
    }

    public function run($firstNumber, $secondNumber)
    {
        if ($this->client == null) {
            return false;
        }

        $this->result = null;
        $this->log = array();

        $params=array(
            'a' => $firstNumber,
            'b' => $secondNumber,
        );

        $this->log('SERVICE ' . self::FUNCTION_NAME . ' REQUEST START');
        $result = $this->client->call(self::FUNCTION_NAME, $params);
        $this->log('SERVICE ' . self::FUNCTION_NAME . ' REQUEST FINISHED');

        if (($error = $this->client->getError())) {
            $this->log('Ha ocurrido algún error');
            $this->log($error);
            return false;
        } else {
            $this->log('Todo ok');
            $this->result = $result;
            return true;
        }
    }

    private function log($message)
    {
        $this->log[] = $message;
    }
}