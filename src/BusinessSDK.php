<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class BusinessSDK extends Sdk{
    public function __construct()
    {
        parent::__construct();
        include_once 'helper.php';
    }
    //save business
    public function saveBusiness($business)
    {
        try {
            $mutation = '
              mutation{
              createBusiness(
                   business_id: ' . $business['business_id'] . '
                   name:"' . $business['name'] . '",
                   department_id: ' . $business['department_id'] . ',
                   description: "' . $business['desc'] . '",
                   user_id: ' . $business['user_id'] . '
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
}