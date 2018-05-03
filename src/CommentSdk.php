<?php
namespace TicketPlatform\ClientSDK;
use Exception;
class CommentSdk extends Sdk{

    public function __construct(){
        parent::__construct();
    }

    public function getComments($ticket_id)
    {
        $result = null;
        try{
            if ($ticket_id) {
                $query = '{
                      getComments(ticket_id: ' . $ticket_id . '){
                        comments
                      }
                    }';
                $response = $this->_request->request($query);
                if($response->__get('getComments')){
                    $result = $response->__get('getComments');
                    $result = json_decode(json_encode($result), true);
                }
            } else {
                addErrorsLog("getComment: Check your ticket_id");
            }
            return $result;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }

    public function addComment($comment_info){
        $result = null;
        try{
            if(is_array($comment_info) && isset($comment_info['val_comment']) && isset($comment_info['ticket_id']) && isset($comment_info['file'])) {
                if (($comment_info['ticket_id'] && $comment_info['val_comment']) || ($comment_info['ticket_id'] && $comment_info['file'])) {
                    $user_name = isset($comment_info['user']) ? $comment_info['user'] : '';
                    $time = isset($comment_info['time']) ? $comment_info['time'] : '';
                    $avatar = isset($comment_info['avatar']) ? $comment_info['avatar'] : '';
                    $mutation = 'mutation {
                      addComment(
                        ticket_id: ' . $comment_info['ticket_id'] . ',
                        val_comment:"' . $comment_info['val_comment'] . '",
                        user:"' . $user_name . '",
                        time:"' . $time . '",
                        avatar:"' . $avatar . '",
                        file:"' . $comment_info['file'] . '",
                        user_id: ' . $comment_info['user_id']. ',
                      ){
                        comments,
                      }
                    }';
                    $response = $this->_request->request($mutation);
                    if($response->__get('addComment')){
                        $result = $response->__get('addComment');
                        $result = json_decode(json_encode($result), true);
                    }
                } else {
                    addErrorsLog("AddComment: Check your parameters");
                }
            } else {
                addErrorsLog("AddComment: Check your parameters");
            }
            return $result;
        } catch (Exception $exception){
            addErrorsLog($exception->getMessage());
            return null;
        }
    }
}