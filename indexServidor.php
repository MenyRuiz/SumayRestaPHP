<?php

require_once 'lib/nusoap.php';


$service = 'service01';

$server = new soap_server();

$server->configureWSDL($service);
            
$input_array = array('a' => 'xsd:int', 'b' => 'xsd:int');
$return_array = array('result' => 'xsd:int');
$server->register(
    'addNumbers', 
    $input_array, 
    $return_array, 
    "urn:$service",
    "urn:$service#addNumbers",
    'rpc', 
    'encoded', 
    'Devuelve la suma de los dos numeros que se le pasen como argumento'
);
            

$server->service(file_get_contents('php://input'));

function addNumbers($a,$b)
{
    $c = $a + $b;
    return $c;
}
function RestNumbers($a,$b)
{
    $c = $a - $b;
    return $c;
}