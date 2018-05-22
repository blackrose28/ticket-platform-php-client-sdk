<?php

namespace TicketPlatform\ClientSDK;
use Exception;
class DepartmentSDK extends Sdk
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getDepartmentsByParentId($parent_id){
        try{
            $query = '{
             getDepartmentsByParentId(parent_id: ' . $parent_id . '){
                    id,
                    name
                  }
            }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getDepartmentsByParentId')) {
                $department = \GuzzleHttp\json_encode($resp->__get('getDepartmentsByParentId'));
                $department = \GuzzleHttp\json_decode($department, true);
                return $department;
            }
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
    }
    
    public function getDepartment($department_id){
        try{
            $query = '{
                      getDepartment(department_id: ' . $department_id . '){
                        id
                        name
                        description
                        parent_id
                        parent{
                            id
                            name
                        }
                      }
                    }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getDepartment')) {
                $department = \GuzzleHttp\json_encode($resp->__get('getDepartment'));
                $department = \GuzzleHttp\json_decode($department, true);
                return $department;
            }
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
    }
}