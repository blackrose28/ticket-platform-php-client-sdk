<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class HistorySdk extends Sdk{

    public function __construct(){
        parent::__construct();
    }

    public function getHistories($ticket_id){
        $result = null;
        try{
            if($ticket_id){
                $query = '{
                      getHistories(ticket_id: ' . $ticket_id . '){
                        histories
                      }
                    }';
                $response = $this->_request->request($query);
                if($response->__get('getHistories')){
                    $result = $response->__get('getHistories');
                    $result = json_decode(json_encode($result), true);
                }
            } else {
                addErrorsLog("Check your ticket_id");
            }
            return $result;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}