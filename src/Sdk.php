<?php
namespace TicketPlatform\ClientSDK;

class Sdk{

    protected $_request;
    protected $_gateway;

    public function __construct(){
        $this->_request = new Request();
        $congiguration = new Configuration();
        $this->_gateway = $congiguration->getGateway();
        $this->_request->setUrl($this->_gateway);
        include_once 'helper.php';
    }
}