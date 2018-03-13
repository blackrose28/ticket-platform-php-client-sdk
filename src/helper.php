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