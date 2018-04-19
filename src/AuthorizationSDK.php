<?php

namespace TicketPlatform\ClientSDK;
use Exception;
class AuthorizationSDK extends Sdk
{
    public function __construct()
    {
        parent::__construct();
    }
    //get all role permission
    public function getAllRolePerms(){
        try {
            $query = 'query{
              authorization_allRolePerms{
                    RoleID
			        PermissionID
			        Title
              }
        }';
            $resp = $this->_request->request($query);
            if ($resp->__get('authorization_allRolePerms')) {
                $auth = \GuzzleHttp\json_encode($resp->__get('authorization_allRolePerms'));
                $auth = \GuzzleHttp\json_decode($auth, true);
                return $auth;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //assign Role to User
    public function assignRoleUser($roles, $user_id , $department_id){
        $roles_id = '';
        if ($roles != null){
            $roles_id = implode(",",$roles);
        }
        try {
            $mutation = '
              mutation{
              authorization_assign_role(role:"' . $roles_id . '",user: ' . $user_id . ', department_id: ' . $department_id . ')
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('authorization_assign_role')) {
                $auth = \GuzzleHttp\json_encode($resp->__get('authorization_assign_role'));
                $auth = \GuzzleHttp\json_decode($auth, true);
                return $auth;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //get All User Role
    public function getAllUserRole(){
        try {
            $query = 'query{
              authorization_allUserRole{
                    UserID
			        RoleID
			        role_name
			        business_id
			        department_id
              }
        }';
            $resp = $this->_request->request($query);
            if ($resp->__get('authorization_allUserRole')) {
                $auth = \GuzzleHttp\json_encode($resp->__get('authorization_allUserRole'));
                $auth = \GuzzleHttp\json_decode($auth, true);
                return $auth;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //check permission user
    public function checkUserPermission($user, $permission){
        try {
            $query = 'query{authorization_can(user:' . $user . ' , permission:"' . $permission . '" )}';
            $resp = $this->_request->request($query);
            if ($resp->__get('authorization_can')) {
                $auth = \GuzzleHttp\json_encode($resp->__get('authorization_can'));
                $auth = \GuzzleHttp\json_decode($auth, true);
                return $auth;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return false;
        }
    }
    //get all permission
    public function getAllPermission($department_id){
        try {
            $query = 'query{
              authorization_allPerms(department_id:' . $department_id . ' ){
                  ID
                  Title
                  Description
                  }
            }';
            $resp = $this->_request->request($query);
            if ($resp->__get('authorization_allPerms')) {
                $perms = \GuzzleHttp\json_encode($resp->__get('authorization_allPerms'));
                $perms = \GuzzleHttp\json_decode($perms, true);
                return $perms;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //edit permission
    public function editPermission($post){
        try {
            $mutation = '
                  mutation{
                  authorization_edit_perm(
                       id: ' . $post['id'] . ',
                       name: "' . $post['name'] . '",
                       desc: "' . $post['description'] . '",
                       department_id: ' . $post['department_id'] . '
                       )
                      {
                       ID
                      },
                  }
                ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('authorization_edit_perm')) {
                $perms = \GuzzleHttp\json_encode($resp->__get('authorization_edit_perm'));
                $perms = \GuzzleHttp\json_decode($perms, true);
                return $perms;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //get all role
    public function getAllRole($department_id){
        try {
            $query = 'query{
              authorization_allRoles(department_id:' . $department_id . ' ){
                  ID
                  Title
                  }
                }';
            $resp = $this->_request->request($query);
            if ($resp->__get('authorization_allRoles')) {
                $roles = \GuzzleHttp\json_encode($resp->__get('authorization_allRoles'));
                $roles = \GuzzleHttp\json_decode($roles, true);
                return $roles;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //create role
    public function createRole($post){
        try {
            $mutation = '
              mutation{
              authorization_create_role(
                   name:"' . $post['name'] . '",
                   desc: "' . $post['description'] . '",
                   department_id: ' . $post["department_id"] . '
                   )
                  {
                   ID
                  },
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('authorization_create_role')) {
                $roles = \GuzzleHttp\json_encode($resp->__get('authorization_create_role'));
                $roles = \GuzzleHttp\json_decode($roles, true);
                return $roles;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //edit role
    public function editRole($post){
        try {
            $mutation = '
              mutation{
              authorization_edit_role(
                   id: ' . $post['id'] . '
                   name:"' . $post['name'] . '",
                   desc: "' . $post['description'] . '",
                   department_id: ' . $post['department_id'] . '
                   )
                  {
                   ID
                  },
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('authorization_edit_role')) {
                $roles = \GuzzleHttp\json_encode($resp->__get('authorization_edit_role'));
                $roles = \GuzzleHttp\json_decode($roles, true);
                return $roles;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //delete role
    public function deleteRole($id, $department_id){
        try {
            $mutation = '
                  mutation{
                  authorization_delete_role(
                       id: ' . $id . ',
                       department_id: ' . $department_id . '
                       )
                      {
                       ID
                      },
                  }
                ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('authorization_delete_role')) {
                $roles = \GuzzleHttp\json_encode($resp->__get('authorization_delete_role'));
                $roles = \GuzzleHttp\json_decode($roles, true);
                return $roles;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }

    }
    //assign permission to role
    public function assignPermissionRole($permission_id, $role_id){
        $permission = '';
        if ($permission_id != null){
            $permission = implode(',', $permission_id);
        }
        try {
            $mutation = '
              mutation{
              authorization_assign_perm(perm: "' . $permission . '", role: ' . $role_id . ')
              }
            ';
            $resp = $this->_request->request($mutation);
            if ($resp->__get('authorization_assign_perm')) {
                $roles = \GuzzleHttp\json_encode($resp->__get('authorization_assign_perm'));
                $roles = \GuzzleHttp\json_decode($roles, true);
                return $roles;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
    //get list role ban
    public function allRoleban($department_id){
        try {
            $query = 'query{
              authorization_allRoleBan(department_id:' . $department_id . ' ){
                  id,
                  role_id
                  }
            }';
            $resp = $this->_request->request($query);
            if ($resp->__get('authorization_allRoleBan')) {
                $roles = \GuzzleHttp\json_encode($resp->__get('authorization_allRoleBan'));
                $roles = \GuzzleHttp\json_decode($roles, true);
                return $roles;
            }
        }catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}