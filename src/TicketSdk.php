<?php
namespace TicketPlatform\ClientSDK;
use Exception;

class TicketSdk extends Sdk {

    public function __construct(){
        parent::__construct();
    }

    public function getTicket($ticket_id, $user_id){
        try{
            if($ticket_id && $user_id){
                $query = '{
                      getTicket(ticket_id: ' . $ticket_id . ', user_id: '. $user_id .'){
                        id
                        title
                        desc
                        deadline
                        created_date
                        ticket_type_id
                        version
                        custom_fields
                        version
                        parent_id
                        reference_user_ids
                        extend_deadline
                        group {id name}
                        status {id name}
                        priority{id name}
                        owner{id email fullname username}
                        assign{id email fullname username}
                      }
                    }';
                $response = $this->_request->request($query);
                if($response->__get('getTicket')){
                    $ticket = $response->__get('getTicket');
                    $ticket = json_decode(json_encode($ticket), true);
                    return $ticket;
                }
            } else {
                addErrorsLog("getTicket: Check your ticket_id or user_id");
            }
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
        return null;
    }

    public function getTicketList($user_id, $business_id, $status_id, $title, $owner_id, $assign_id, $ticket_id, $page, $ticket_type_id, $time_from, $time_to, $limit){
        $ticket_list = null;
        try{
            $page         = $page ? $page : 1;
            $ticket_id    = $ticket_id ? $ticket_id : 0;
            $title        = $title ? $title : "";
            $status_id    = $status_id ? $status_id : 0;
            $owner_id     = $owner_id ? $owner_id : 0;
            $assign_id    = $assign_id ? $assign_id : 0;
            $user_id  = $user_id ? $user_id : 0;
            $business_id = $business_id ? $business_id : 0;
            $ticket_type_id = $ticket_type_id ? $ticket_type_id : '';
            $time_from = $time_from ? $time_from : '';
            $time_to = $time_to ? $time_to : '';
            $limit = $limit ? $limit : 5;
            $query = '{
                getTicketListnew(user_id: '.$user_id.', business_id: '.$business_id.', status_id : '.$status_id.', title: "'.$title.'", owner_id: '.$owner_id.', ticket_type_id: "'.$ticket_type_id.'",assign_id: '.$assign_id.',ticket_id:'.$ticket_id.',time_from:"'.$time_from.'",time_to:"'.$time_to.'", limit: '.$limit.', page: '.$page.') {   
                 ticket_list {
                                id
                                title
                                desc
                                deadline
                                business_id
                                created_date
                                deadline
                                ticket_type_id
                                version
                                status_id
                                priority_id
                                custom_fields
                                parent_id
                                version
                                reference_user_ids
                                assign_id
                                owner_id
                                }                            
                        count_ticket
                        }                           
                    }';
            $response = $this->_request->request($query);
            if($response->__get('getTicketListnew')){
                $ticket_list = $response->__get('getTicketListnew');
                $ticket_list = json_decode(json_encode($ticket_list), true);
                return $ticket_list;
            }
            return $ticket_list;
        } catch(Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function getLastTicketId(){
        $ticket_id = null;
        try{
            $query = '{
              getLastTicketId{
                id
              }
            }';
            $response = $this->_request->request($query);
            if($response->__get('getLastTicketId')){
                $ticket_id = $response->__get('getLastTicketId');
                $ticket_id = json_decode(json_encode($ticket_id), true);
                return $ticket_id;
            }
        } catch(Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function getRelationTickets($parent_id){
        $relation_tickets = null;
        try{
            if($parent_id){
                $query = '{
                  getRelationTickets(parent_id: '. $parent_id .'){
                    id   
                    title             
                    ticket_type_id
                    custom_fields
                    config_view
                    parent_id
                    deadline
                    version 
                    assign{id email fullname username}
                    status {id name}
                  }
                }';
                $response = $this->_request->request($query);
                if($response->__get('getRelationTickets')){
                    $relation_tickets = $response->__get('getRelationTickets');
                    $relation_tickets = json_decode(json_encode($relation_tickets), true);
                    return $relation_tickets;
                }
            } else {
                addErrorsLog("getRelationTickets: Check your parent_id");
            }
            return $relation_tickets;
        } catch(Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function create($ticket_info){
        try{
            $user = null;
            $assign_id = isset($ticket_info['assign_id']) ? $ticket_info['assign_id'] : 0;
            $query_assign = '{
                          getUser(user_id: ' . $assign_id . ' ){
                            id
                            username
                            email
                            fullname
                          }
                      }';

            $response = $this->_request->request($query_assign);
            if($response->__get('getUser')){
                $user = $response->__get('getUser');
                $user = json_decode(json_encode($user), true);
            }
            if (is_array($user) && isset($user['id']) && $user['id']) {
                $create_params = '';
                $ticket_type = isset($ticket_info['ticket_type']) ? $ticket_info['ticket_type'] : null;
                foreach ($ticket_info as $key => $v) {
                    if(is_array($v)){
                        $v = implode(",",$v);
                    }
                    if (array_key_exists($key . '_data_type', $ticket_info)) {
                        if ($ticket_info[$key . '_data_type'] == 'Int' || $ticket_info[$key . '_data_type'] == 'Number') {
                            $create_params .= ', ' . $key . ': ' . trim($v);
                        } else {
                            if (is_array($v)) {
                                $v = rtrim(implode(',', $v), ',');
                            }
                            $create_params .= ', ' . $key . ': "' . replaceSpecialCharacters(trim($v)) . '"';
                        }
                    }
                }

                $create_params = trim($create_params, ', ');
                $create_ticket = 'mutation {
                          createTicket(' . $create_params . '){
                            id
                            title
                            desc
                            deadline
                            version
                            created_date
                            ticket_type_id
                            custom_fields
                            config_view                            
                            reference_user_ids
                            group {id name}
                            status {id name}
                            priority{id name}
                            owner{id email fullname username}
                            assign{id email fullname username}
                          }
                        }';
                $params = array(
                    'mutation' => $create_ticket
                );
                if(is_array($ticket_type) && $ticket_type['id']){
                    $params['ticket_type'] = $ticket_type;
                    $info = array('info' => json_encode($params, true));
                    $result = connectGateway($info);
                    if(isset($result['data']) && array_key_exists('createTicket', $result['data'])){
                        $ticket = $result['data']['createTicket'];
                        $ticket = resolveCustomFields(json_decode(json_encode($ticket), true));
                        return $ticket;
                    } else {
                        addErrorsLog("Create Ticket: ".$result);
                        return null;
                    }
                } else {
                    addErrorsLog("Create Ticket: Check your ticket type parameter");
                    return null;
                }
            } else {
                addErrorsLog("Assigned user does not exist");
                return null;
            }
        } catch(Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

//    public function updateTicket($ticket_info){
//        try {
//            if(is_array($ticket_info)){
//                $breakStep = false;
//                $user = null;
//                if (isset($ticket_info['assign_id'])) {
//                    $assign_id = $ticket_info['assign_id'];
//                    $query_assign = '{
//                          getUser(user_id: ' . $assign_id . ' ){
//                            id
//                            username
//                            email
//                            fullname
//                          }
//                      }';
//                    $response = $this->_request->request($query_assign);
//                    if($response->__get('getUser')){
//                        $user = $response->__get('getUser');
//                        $user = json_decode(json_encode($user), true);
//                    }
//                } else {
//                    $user = [];
//                    $breakStep = true;
//                }
//
//                if(is_array($user)) {
//                    if ((isset($user['id']) && $user['id']) || $breakStep) {
////                        $ticket_info = str_replace('"', '!!!###', $ticket_info);
//                        foreach ($ticket_info as $key => &$v) {
//                            if(is_array($v)){
//                                $v = implode(",",$v);
//                            }
//                            if (key_exists($key . '_data_type', $ticket_info)) {
//                                if ($ticket_info[$key . '_data_type'] == 'Int' || $ticket_info[$key . '_data_type'] == 'Number') {
//                                    $create_params .= ', ' . $key . ': ' . trim($v);
//                                } else {
//                                    if (is_array($v)) {
//                                        $v = rtrim(implode(',', $v), ',');
//                                    }
//                                    $create_params .= ', ' . $key . ': "' . replaceSpecialCharacters(trim($v)) . '"';
//                                }
//                            }
//                        }
//                        $data = json_encode($ticket_info, true);
////                        printValues($data);
//                        $mutation = 'mutation {
//                          updateTicket(data:"' . $data . '"){
//                            id
//                            title
//                            desc
//                            deadline
//                            created_date
//                            ticket_type_id
//                            custom_fields
//                            version
//                            reference_user_ids
//                            group {id name}
//                            status {id name}
//                            priority{id name}
//                            owner{id email fullname username}
//                            assign{id email fullname username}
//                          }
//                        }';
//
//                        //$ticket_info = array('info' => json_encode($params, true));
////                        $params = array('query' => $mutation);
////                        $params = json_encode($params, true);
//
////                        $resp = connectGatewayJs($params);
////                        $ticket = null;
////                        if (isset($resp['data']['updateTicket']) && $resp['data']['updateTicket']) {
////                            $ticket = $resp['data']['updateTicket'];
////                            $ticket = resolveCustomFields($ticket);
////                        }
//
//                        $response = $this->_request->request($mutation);
//                        if($response->__get('updateTicket')){
//                            $ticket = $response->__get('updateTicket');
//                            $ticket = json_decode(json_encode($ticket), true);
//                            $ticket = resolveCustomFields($ticket);
//                            return $ticket;
//                        }
//                    } else {
//                        addErrorsLog("Update Ticket: assigned user doesn't exist.");
//                    }
//                } else {
//                    addErrorsLog("Update Ticket: assigned user doesn't exist.");
//                }
//            } else {
//                addErrorsLog("Update Ticket: check your parameter");
//            }
//        } catch(Exception $exception){
//            addErrorsLog($exception->getMessage());
//            return null;
//        }
//    }
}