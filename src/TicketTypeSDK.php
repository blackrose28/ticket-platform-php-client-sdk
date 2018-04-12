<?php

namespace TicketPlatform\ClientSDK;
use Exception;
class TicketTypeSDK extends Sdk{
    public function __construct()
    {
        parent::__construct();
        include_once 'helper.php';
    }

    //get all ticket type
    public function getAllTicketType(){
        try {
            $query = 'query{
              getAllTicketType{
                    id
                    name
                    desc
                    main
                    version
                    business_id
                      }
                }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getAllTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('getAllTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //get list ticket type where business_id
    public function getListTicketType($business_id){
        try {
            $query = 'query{
              getListTicketType(business_id:' . $business_id . '){
                    id
                    name
                    desc
                    main
                    version
                    }
               }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getListTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('getListTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    //create ticket type
    public function createTicketType($ticket_type){
        try {
            $mutation = 'mutation{
             createTicketType(
                name:"' . $ticket_type['name_ticket'] . '",
                desc: "' . $ticket_type['desc_ticket'] . '", 
                business_id:' . $ticket_type['business_id'] . ',
                department_id: ' . $ticket_type['department_id'] . '
                ){
                   id
                 }
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('createTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('createTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    //delete ticket type
    public function delTicketType($ticket_type){
        try {
            $mutation = 'mutation{
                deleteTicketType(id:' . $ticket_type['id'] . ', business_id: ' . $ticket_type['business_id'] . ', version:' . $ticket_type['version'] . '){
                       id
                  }
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('deleteTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('deleteTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
        }
    }

    //ticket type main
    public function ticketTypeMain($main){
        try {
            $mutation = 'mutation{
                updateMainTicketType(id:' . $main['id'] . ', main:' . $main['main'] . ')
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('updateMainTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('updateMainTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
        }
    }
    //get ticket type
    public function getTicketType($id, $version)
    {
        try {
            $query = '
                    query{
                      getTicketType(id:' . $id . ', version:' . $version . '){
                        id,
                        name,
                        desc,
                        main,
                        version,
                        business_id,
                        format{
                            name
                        },
                        data_type{
                            name
                        },
                        default_field,
                        common_field {
                              ...detail_field
                        },
                        specific_field {
                            name,
                            ticket_type_name,
                            fields{
                               ...detail_field
                            }
                        },
                        general_field{
                            fields{
                                name,
                                ticket_type_name,
                                ticket_type_id,
                                fields{
                                ...detail_field
                               }
                            }
                        }
                      }
                    }
               fragment detail_field on Field
                {
                    id,
                    name,
                    format,
                    data_type,
                    default,
                    default_value,
                    ticket_type_name,
                    ticket_type_id,
                    field_key,
                    field_search
                    }
                ';
            $resp = $this->_request->request($query);
            if ($resp->__get('getTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('getTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //edit ticket type
    public function editTicketType($datas){
        $data = str_replace('"', '!!!###', $datas);
        try {
            $mutation = 'mutation{
                editTicketType(data:"' . $data . '"){
                       id
                  }
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('editTicketType')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('editTicketType'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
        }
    }
    //current ticket type
    public function currentTicketType($business_id,$id, $version){
        try{
            $query = 'query{
              getCurrent(id: '.$id.',business_id:' . $business_id . ', version: '.$version.'){
                        id,
                        main,
                        version,
                        business_id,
                        specific_field {
                            name,
                            ticket_type_name,
                            fields{
                               ...detail_field
                            }
                        },
                        general_field{
                            fields{
                                name,
                                ticket_type_name,
                                fields{
                                ...detail_field
                               }
                            }
                        }
                      }
                }
                fragment detail_field on Field
                {
                    id,
                    name,
                    format,
                    data_type,
                    default,
                    default_value,
                    ticket_type_name
                    }
                ';
            $resp = $this->_request->request($query);
            if ($resp->__get('getCurrent')) {
                $tickettpyes = \GuzzleHttp\json_encode($resp->__get('getCurrent'));
                $tickettpyes = \GuzzleHttp\json_decode($tickettpyes, true);
                return $tickettpyes;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
        }
    }


}