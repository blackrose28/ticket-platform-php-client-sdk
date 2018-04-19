<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class PrioritySdk extends Sdk{

    public function __construct(){
        parent::__construct();
    }

    public function getPriorities()
    {
        try{
            $resp = null;
            $priorities = null;
            $query = '{
              getPriorities{
                id
                name
              }
            }';
            $response = $this->_request->request($query);
            if($response->__get('getPriorities')){
                $priorities = $response->__get('getPriorities');
                $priorities = json_decode(json_encode($priorities), true);
            }
            return $priorities;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }

    }
}