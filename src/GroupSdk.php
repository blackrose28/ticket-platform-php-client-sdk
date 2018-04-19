<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class GroupSdk extends Sdk{

    public function __construct(){
        parent::__construct();
    }

    public function getGroups($ticket_type_id){
        try{
            $resp = null;
            $groups = null;
            $query = '{
              getGroups(ticket_type_id: '.$ticket_type_id.'){
                id
                name
              }
            }';
            $response = $this->_request->request($query);
            if($response->__get('getGroups')){
                $groups = $response->__get('getGroups');
                $groups = json_decode(json_encode($groups), true);
            }
            return $groups;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function create($ticket_type_id, $group_name){
        $group = null;
        try{
            $query = 'mutation{
              createGroups(
                name:"' . $group_name . '",
                ticket_type_id: ' . $ticket_type_id . '
              ){
                id
                name
              }
            }';
            $response = $this->_request->request($query);
            if($response->__get('createGroups')){
                $group = $response->__get('createGroups');
                $group = json_decode(json_encode($group), true);
            }
            return $group;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}