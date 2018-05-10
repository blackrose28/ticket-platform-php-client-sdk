<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class UsergroupSDK extends Sdk
{
    public function __construct()
    {
        parent::__construct();
    }

    //get User Group
    public function getUserGroup($group_id){
        try{
                if($group_id){
                    $query = '{
                      getRole(role_id: ' . $group_id . '){
                        ID
                        Title
                        members{
                            id
                            username
                            fullname
                            email
                            phone
                        }
                      }
                    }';
                    $response = $this->_request->request($query);
                    $user_group = null;
                    if($response->__get('getRole')){
                        $user_group = $response->__get('getRole');
                        $user_group = json_decode(json_encode($user_group), true);
                        return $user_group;
                    }else{
                        return null;
                    }
                } else {
                    echo 'Check your group id';
                }
        } catch (Exception $exception){
            return null;
        }
    }
}