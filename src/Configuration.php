<?php
namespace TicketPlatform\ClientSDK;
class Configuration{

    /** @var string $_gateway_url  This is url for the gateway */
    private $_gateway_url;

    public function __construct(){
        include_once 'config.php';
        $this->_gateway_url = getenv('GATEWAYJS_URL');
    }

    public function getGateway(){
        return $this->_gateway_url;
    }

    public function setGateway($url){
        $this->_gateway_url = $url;
    }
}