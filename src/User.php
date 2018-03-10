<?php
namespace TicketPlatform\ClientSDK;

use phpDocumentor\Reflection\Types\String_;

class User{

    private $_request;
    private $_gateway;

    public function __construct(){
        $this->_request = new Request();
        $congiguration = new Configuration();
        $this->_gateway = $congiguration->getGateway();
        $this->_request->setUrl($this->_gateway);
    }

    /**
     * Init user after login with VietID
     *
     * @param array $user_info
     */
    public function initUser($user_info){
        $mutation = 'mutation {
              createUser(
                vietId: "' . $user_info['id'] . '",
                username:"' . $user_info['name'] . '",
                email: "' . $user_info['email'] . '",               
                fullname: "' . $user_info['fullname'] . '",
                phone: "' . $user_info['mobile'] . '",
                avatar:"' . $user_info['avatar'] . '",
              ){
                id,
                vietId,
                username,
                fullname,
                email,
                access_token,
                avatar,
                department_ids,
                departments{
                    id,
                    name,
                    child_ids,
                    childs{
                        id,
                        name
                    }
                }
              }
            }';
        $response = $this->_request->request($mutation);;
        if($response->__get('createUser')){
           $user = (array)$response->__get('createUser');
           return $user;
        }
        return null;
    }

    /**
     * get the list of User
     *
     * @param int $department_id = 0 is get all system users
     */
    public function getUserList($department_id = 0){
        $query = '{
          getUserList(department_id: '.$department_id.'){
            id
            vietId
            username
            email
            fullname
          }
        }';
        $response = $this->_request->request($query);
        if($response->__get('getUserList')){
            $users = $response->__get('getUserList');
            return $users;
        }
        return null;
    }

    /**
     * get User with given user_id
     * @param int $user_id
     */
    public function getUser($user_id){
        $query = '{
              getUser(id: ' . $user_id . ' ){
                id
                username
                email
                fullname
                avatar
              }
          }';
        $response = $this->_request->request($query);
        if($response->__get('getUser')){
            $users = $response->__get('getUser');
            return $users;
        }
        return null;
    }

    /**
     * invite a list of Users to join system by emails
     * @param String $sender_email
     * @param String $sender_name
     * @param String $receiver_emails is a list of emails, separated by ',' character
     */
    public function inviteUser($sender_email, $sender_name, $receiver_emails, $department_id){
        $mutation = 'mutation {
                  inviteUser(
                    sender_email:"' . $sender_email . '",
                    sender_name: "' . $sender_name . '",               
                    receiver_emails: "' . $receiver_emails . '",
                    department_id: ' . $department_id . '
                  ){
                    id,
                    email,
                    department_ids,
                    departments{
                        id, 
                        name
                    }
                  }
                }';
        $response = $this->_request->request($mutation);
        if($response->__get('inviteUser')){
            $users = $response->__get('inviteUser');
            return $users;
        }
        return null;
    }
}