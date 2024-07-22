<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getDetailtCity($cityId) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/city?id=".$cityId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: 6b5ae6f345b32a50c26c87b48e6a799e"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        echo "Error: " . $err;
        return null;
    }

    $data = json_decode($response, true);

  
    if (!isset($data['rajaongkir']['results'])) {
        echo "Error: Unexpected response format.";
        return null;
    }

    return $data;
}


function getOngkir($origin, $destination, $weight, $courier) {
    $curl = curl_init();
    $data = array(
        'origin' => $origin,
        'destination' => $destination,
        'weight' => $weight,
        'courier' => $courier
    );
    $data_string = json_encode($data);

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "key: 6b5ae6f345b32a50c26c87b48e6a799e"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
     
        return array('error' => "CURL Error: $err");
    } else {
       
        $data = json_decode($response, true);
        if(isset($data['rajaongkir']['status']['description']) && $data['rajaongkir']['status']['description'] === 'OK') {
            return $data;
        } else {
           
            return array('error' => "API Error: " . $data['rajaongkir']['status']['description']);
        }
    }
}


?>


