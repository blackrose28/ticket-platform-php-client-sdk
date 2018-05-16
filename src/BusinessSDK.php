<?php

namespace TicketPlatform\ClientSDK;
use Exception;
class BusinessSDK extends Sdk{
    public function __construct()
    {
        parent::__construct();
    }
    //save business
    public function saveBusiness($business)
    {
        try {
            $business_id = isset($business['business_id']) ? $business['business_id'] : 0;
            $business_name = isset($business['name']) ? $business['name'] : '';
            $department_id = isset($business['department_id']) ? $business['department_id'] : 0;
            $business_desc = isset($business['desc']) ? $business['desc'] : '';
            $user_id = isset($business['user_id']) ? $business['user_id'] : 0;
            if ($business_name != '' && $department_id != 0 && $user_id != 0) {
                $mutation = '
                  mutation{
                  createBusiness(
                       business_id: ' . $business_id . '
                       name:"' . $business_name . '",
                       department_id: ' . $department_id . ',
                       description: "' . $business_desc . '",
                       user_id: ' . $user_id . '
                       )
                      {
                       id,
                       main_ticket_type_id
                      },
                  }
                ';
                $resp = $this->_request->request($mutation);
                if ($resp->__get('createBusiness')) {
                    $business = \GuzzleHttp\json_encode($resp->__get('createBusiness'));
                    $business = \GuzzleHttp\json_decode($business, true);
                    return $business;
                }
            }else{
                return false;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //get business
    public function getBusiness($department_id)
    {
        try {
            $query = 'query{
                  getAllBusiness(department_id:' . $department_id . '){
                    id,
                    name,
                    description
                    main_ticket_type_id
                  }
            }';

            $resp = $this->_request->request($query);
            if ($resp->__get('getAllBusiness')) {
                $business = \GuzzleHttp\json_encode($resp->__get('getAllBusiness'));
                $business = \GuzzleHttp\json_decode($business, true);
                return $business;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //get business by user
    public function getBusinessByUser($user_id){
        try{
            $query = '{
              getBusinessByUser(user_id: ' . $user_id . '){
                id,
                name,
                description,
                main_ticket_type_id,
                department_id,
                user_id
              }
            }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getBusinessByUser')) {
                $business = \GuzzleHttp\json_encode($resp->__get('getBusinessByUser'));
                $business = \GuzzleHttp\json_decode($business, true);
                return $business;
            }
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
    }
    //get business by id
    public function getBusinessByIds($business_ids){
        try{
            $query = '{
              getBusinessByIds(business_ids: "' . $business_ids . '"){
                id,
                name,
                description,
                main_ticket_type_id,
                department_id,
                user_id
              }
            }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getBusinessByIds')) {
                $business = \GuzzleHttp\json_encode($resp->__get('getBusinessByIds'));
                $business = \GuzzleHttp\json_decode($business, true);
                return $business;
            }
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
    }
    //getBusinessByUserDepartment
    public function getBusinessByUserDepartment($user_id, $department_id){
        try{
            $query = '{
             getBusinessByUserDepartment(user_id: ' . $user_id . ', department_id: '.$department_id.'){
                    id,
                    name,
                    description,
                    main_ticket_type_id,
                    department_id,
                    user_id
                  }
            }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getBusinessByUserDepartment')) {
                $business = \GuzzleHttp\json_encode($resp->__get('getBusinessByUserDepartment'));
                $business = \GuzzleHttp\json_decode($business, true);
                return $business;
            }
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
    }
}