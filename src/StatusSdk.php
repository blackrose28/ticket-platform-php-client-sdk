<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class StatusSdk extends Sdk{
    public function __construct(){
        parent::__construct();
    }

    public function getStatuses()
    {
        try {
            $resp = null;
            $statuses = null;
            $status_query = '{
              getStatuses{
                id 
                name
              }
            }';
            $response = $this->_request->request($status_query);
            if($response->__get('getStatuses')){
                $statuses = $response->__get('getStatuses');
                $statuses = json_decode(json_encode($statuses), true);
            }
            return $statuses;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}