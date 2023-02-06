<?php

    /* Get User Location */
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];

    $result  = array('country'=>'', 'city'=>'');

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }else if(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://ip-api.com/json/".$ip));

    if($ip_data && $ip_data->country != null){
        $result['country'] = $ip_data->country;
        $result['city'] = $ip_data->city;
    }

    // $country = 'United States';
    $country = $result['country'];
    $money = ($country === 'Argentina') ? 'ARS' : 'USD';