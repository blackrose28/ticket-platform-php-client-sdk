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

    public function getTreeDepartments(){
        try{
            $query = '{
                      getTreeDepartments{
                        id
                        name
                        child_ids
                        parent_id
                        childs{
                          id
                          name
                          parent_id
                        }
                      }
                    }';
            $resp = $this->_request->request($query);
            if ($resp->__get('getTreeDepartments')) {
                $department = \GuzzleHttp\json_encode($resp->__get('getTreeDepartments'));
                $department = \GuzzleHttp\json_decode($department, true);
                return $department;
            }
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function initDepartment($name, $description, $parent_id, $user_id){
        try {
            if ($name != '' && $parent_id != 0 && $user_id != 0) {
                $mutation = 'mutation{
                      initDepartment(name: "'.$name.'", description: "'.$description.'", parent_id: '.$parent_id.', user_id:'.$user_id.'){
                        id
                        name
                        description
                        child_ids
                        parent_id
                        parent{
                            id
                            name
                        }
                        childs{
                            id
                            name
                            parent_id
                        }
                      }
                    }';
                $resp = $this->_request->request($mutation);
                if ($resp->__get('initDepartment')) {
                    $department = \GuzzleHttp\json_encode($resp->__get('initDepartment'));
                    $department = \GuzzleHttp\json_decode($department, true);
                    return $department;
                }
            }else{
                return false;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function updateDepartment($name, $description, $department_id, $parent_id){
        try {
            if ($name != '' && $department_id != 0 && $parent_id != 0) {
                $mutation = 'mutation{
                      updateDepartment(id: '.$department_id.',name: "'.$name.'", description: "'.$description.'", parent_id: '.$parent_id.'){
                        id
                        name
                        description
                        parent_id
                      }
                    }';
                $resp = $this->_request->request($mutation);
                if ($resp->__get('updateDepartment')) {
                    $department = \GuzzleHttp\json_encode($resp->__get('updateDepartment'));
                    $department = \GuzzleHttp\json_decode($department, true);
                    return $department;
                }
            }else{
                return false;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}