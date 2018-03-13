<?php
namespace TicketPlatform\ClientSDK;
class Configuration{

    /** @var string $_gateway_url  This is url for the gateway */
    private $_gateway_url;

    public function __construct(){
        $this->_gateway_url = 'http://gateway.test/shorthand_sdk.php';
    }

    public function getGateway(){
        return $this->_gateway_url;
    }
}