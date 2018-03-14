<?php

function resolveCustomFields($ticket){
    $custom_fields = json_decode($ticket['custom_fields'], true);
    if(count($custom_fields)){
        foreach ($custom_fields as $key => $val){
            $ticket[$key] = $val;
        }
    }
    unset($ticket['custom_fields']);
    return $ticket;
}

function addErrorsLog($message){
    error_log("\n".date('Y/m/d H:i:s')." -> ".__FILE__."- line ".__LINE__.": \n".$message, 3, "errors.log");
}