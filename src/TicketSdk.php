<?php
namespace TicketPlatform\ClientSDK;
use Exception;

class TicketSdk extends Sdk {

    public function __construct(){
        parent::__construct();
    }

    public function getTicket($ticket_id){
        try{
            $query = '{
              getTicket(id: ' . $ticket_id . '){
                id
                title
                desc
                deadline
                created_date
                ticket_type_id
                version
                custom_fields
                version
                parental_id
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
        } catch (Exception $exception){
            error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": ".$exception->getMessage(), 3, "errors.log");
            return null;
        }
        return null;
    }

    public function getTicketList($ticket_type_id, $version){
        try{
            if($ticket_type_id && $version){
                $query = '{
                  getTicketList(ticket_type_id: ' . $ticket_type_id . ',version:'.$version.'){
                    id
                    title
                    desc
                    deadline
                    created_date
                    ticket_type_id
                    version
                    custom_fields
                    version
                    reference_user_ids
                    group {id name}
                    status {id name}
                    priority{id name}
                    owner{id email fullname username}
                    assign{id email fullname username}
                  }
                }';
                $response = $this->_request->request($query);
                if($response->__get('getTicketList')){
                    $ticket_list = $response->__get('getTicketList');
                    $ticket_list = json_decode(json_encode($ticket_list), true);
                    return $ticket_list;
                }
            }
        } catch(Exception $exception){
            error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": ".$exception->getMessage(), 3, "errors.log");
            return null;
        }
        return null;
    }

    public function getLastTicketId(){
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
            error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": ".$exception->getMessage(), 3, "errors.log");
            return null;
        }
        return null;
    }

    public function getRelationTickets($parent_id, $ticket_type_id, $version){
        try{
            if($parent_id && $ticket_type_id && $version){
                $query = '{
                  getRelationTickets(parent_id: ' . $parent_id . ', ticket_type_id:'.$ticket_type_id.', version:'.$version.'){
                    id   
                    title             
                    ticket_type_id
                    custom_fields
                    version 
                    assign{
                        id
                        username
                        firstname
                        lastname
                        fullname
                    }
                    status {id name}
                  }
                }';
                $response = $this->_request->request($query);
                if($response->__get('getRelationTickets')){
                    $relation_tickets = $response->__get('getRelationTickets');
                    $relation_tickets = json_decode(json_encode($relation_tickets), true);
                    return $relation_tickets;
                }
            }

        } catch(Exception $exception){
            error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": ".$exception->getMessage(), 3, "errors.log");
            return null;
        }
        return null;
    }

    public function createTicket($ticket_info){
        include_once 'helper.php';
        try{
            $params = $ticket_info;
            $user = null;
            $assign_id = $params['assign_id'];
            $query_assign = '{
                          getUser(id: ' . $assign_id . ' ){
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

            if (isset($user['id'])) {
                $create_params = '';
                $ticket_type = isset($params['ticket_type']) ? $params['ticket_type'] : null;
                foreach ($params as $key => $v) {
                    if(is_array($v)){
                        $v = implode(",",$v);
                    }
                    if (key_exists($key . '_data_type', $params)) {
                        if ($params[$key . '_data_type'] == 'Int' || $params[$key . '_data_type'] == 'Number') {
                            $create_params .= ', ' . $key . ': ' . trim($v);
                        } else {
                            if (is_array($v)) {
                                $v = rtrim(implode(',', $v), ',');
                            }
                            $create_params .= ', ' . $key . ': "' . trim($v) . '"';
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
                            reference_user_ids
                            group {id name}
                            status {id name}
                            priority{id name}
                            owner{id email fullname username}
                            assign{id email fullname username}
                          }
                        }';
                $result = $this->_request->request($create_ticket, array('ticket_type' => $ticket_type));
                if($result->__get('createTicket')){
                    $ticket = $result->__get('createTicket');
                    $ticket = resolveCustomFields(json_decode(json_encode($ticket), true));
                    return $ticket;
                } else {
                    error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": \n".$result, 3, "errors.log");
                    return null;
                }
            } else {
                error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": Assigned user does not exist", 3, "errors.log");
                return null;
            }
        } catch(Exception $exception){
            error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": ".$exception->getMessage(), 3, "errors.log");
            return null;
        }
    }
}