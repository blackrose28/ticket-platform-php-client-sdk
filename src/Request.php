<?php namespace TicketPlatform\ClientSDK;

use Omnilance\GraphQL\Client;

/**
*  Request class
*
*  This is class handle all request to Ticket Platform, including query, mutation.
*
*  @author chuonglv
*/
class Request{

  /**  @var Omnilance\GraphQL\Client $m_client This is graphql client for handling request */
  private $m_client = null;

  /** @var string $m_url This is url for the gateway */
  private $m_url = '';

  /**
  * Set custom gateway url 
  *
  * Set the gateway url
  *
  * @param string $url Url to the new gateway
  */
   public function setUrl($url){
       $this->m_url = $url;
       $this->m_client = new Client('');
       $this->m_client->setHost($url);
   }

   /**
    * Custom query or mutation
    * 
    * Use this method to request resource not define in sdk
    * @param string $query The query or mutaion send to gateway
    * 
    * @return mixed
    */
    public function request($query, $variables = [], $headers = []){
        return $this->m_client->response($query, $variables, $headers);
    }
}