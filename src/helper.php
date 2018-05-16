<?php

function resolveCustomField($ticket){
    $custom_fields = json_decode($ticket['custom_fields'], true);
    if(count($custom_fields)){
        foreach ($custom_fields as $key => $val){
            $ticket[$key] = $val;
        }
    }
    unset($ticket['custom_fields']);
    return $ticket;
}

function addErrorsLog($message){
    error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": \n".$message, 3, "errors.log");
}

function connectGateway($params = null)
{
    $gateway = getenv('GATEWAY_URL').'/shorthand.php';
    $curl = curl_init();
    $args = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $gateway
    );
    if ($params) {
        $args[CURLOPT_POST] = 1;
        $args[CURLOPT_POSTFIELDS] = $params;
    }
    curl_setopt_array($curl, $args);
    $resp = curl_exec($curl);
    curl_close($curl);
    $resp = json_decode($resp, true);
    return $resp;
}

function replaceSpecialCharacters($string)
{
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", md5('$2y$10$I8Lau6vInSADmcUaxGWxP.U7wR4Vg7GD4F5U9h212Vy3LDnzb4hUK'), md5('$2y$10$n5B97hwNQUZMTJ3cujs8merJ9bH4sU14TU/vBlRQSoOAc2cQCcDwC'), "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $string);
    return $result;
}