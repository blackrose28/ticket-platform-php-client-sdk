<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class BufftimeSdk extends Sdk{

    public function __construct(){
        parent::__construct();
    }

    public function setBuffTime($buff_time){
        $result = null;
        try{
            if(is_array($buff_time)) {
                if (isset($buff_time['ticket_id']) && $buff_time['ticket_id'] && is_numeric($buff_time['ticket_id'])) {
                    if(isset($buff_time['day']) && isset($buff_time['hour'])){
                        if ($buff_time['day'] || $buff_time['hour']) {
                            if (is_numeric($buff_time['day']) && is_numeric($buff_time['hour'])) {
                                $mutation = 'mutation {
                                  buffTime(
                                    ticket_id: ' . $buff_time['ticket_id'] . ',
                                    day:' . $buff_time['day'] . ',
                                    hour:' . $buff_time['hour'] . ',
                                    user_id:' . $buff_time['user_id'] . '
                                  ) {
                                    result
                                  }
                                }';
                                $response = $this->_request->request($mutation);
                                if($response->__get('buffTime')){
                                    $result = $response->__get('buffTime');
                                    $result = json_decode(json_encode($result), true);
                                }
                            }
                        }
                    } else {
                        addErrorsLog("Set Buff Time: Check your time parameters");
                    }
                } else {
                    addErrorsLog("Set Buff Time: Check your ticket_id");
                }
                return $result;
            } else {
                addErrorsLog("Set Buff Time: Check your parameters");
            }
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function cancelTime($cancel_time)
    {
        $result = null;
        try{
            if(is_array($cancel_time)){
                if (isset($cancel_time['ticket_id']) && $cancel_time['ticket_id'] && is_numeric($cancel_time['ticket_id'])) {
                    if(isset($cancel_time['user_id']) && $cancel_time['user_id'] && is_numeric($cancel_time['user_id'])){
                        $mutation = 'mutation {
                          cancelTime(
                            ticket_id: ' . $cancel_time['ticket_id'] . ',
                            user_id: ' . $cancel_time['user_id'] . '
                          ) {
                            result
                          }
                        }';
//                        $params = array('query' => $mutation);
//                        $params = json_encode($params, true);
//                        $resp = connectGatewayJs($params);
//                        echo json_encode($resp, true);
                        $response = $this->_request->request($mutation);
                        if($response->__get('cancelTime')){
                            $result = $response->__get('cancelTime');
                            $result = json_decode(json_encode($result), true);
                        }
                    } else {
                        addErrorsLog("Cancel Buff Time: Check your user_id parameter");
                    }
                } else {
                    addErrorsLog("Cancel Buff Time: Check your ticket_id parameter");
                }
            } else {
                addErrorsLog("Cancel Buff Time: Check your parameters");
            }
            return $result;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}