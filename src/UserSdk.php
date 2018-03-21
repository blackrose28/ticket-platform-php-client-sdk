<?php
namespace TicketPlatform\ClientSDK;
use Exception;

class UserSdk extends Sdk {

    public function __construct(){
        parent::__construct();
        include_once 'helper.php';
    }

    /**
     * Init user after login with VietID
     *
     * @param array $user_info
     */
    public function initUser($user_info){
        try{
            $mutation = 'mutation {
              initUser(
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
                $user = $response->__get('createUser');
                $user = json_decode(json_encode($user), true);
                return $user;
            }
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }

        return null;
    }

    /**
     * get the list of User
     *
     * @param int $department_id = 0 is get all system users
     */
    public function getUserList($department_id = 0){
        try{
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
                $users = json_decode(json_encode($users), true);
                return $users;
            }
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
        return null;
    }

    /**
     * get User with given user_id
     * @param int $user_id
     */
    public function getUser($user_id){
        try{
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
                $user = $response->__get('getUser');
                $user = json_decode(json_encode($user), true);
                return $user;
            }
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
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
        try{
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
                $user = $response->__get('inviteUser');
                $user = json_decode(json_encode($user), true);
                return $user;
            }
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
        return null;
    }
}