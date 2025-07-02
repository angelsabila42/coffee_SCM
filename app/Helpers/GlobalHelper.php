<?php

if (!function_exists('changeBadgeStatus')){
      
         function changeBadgeStatus(string $status){
           return match (ucfirst(strtolower($status))){
            'Requested' => 'badge-primary',
            'Pending' => 'badge-warning',
            'Cancelled' => 'badge-danger',
            'Delivered' => 'badge-secondary',
            'Confirmed' => 'badge-success',
            default=> 'badge-light'
           };

         }

    }

?>