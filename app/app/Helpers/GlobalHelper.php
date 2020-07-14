<?php
  
function getGeocodingByAddress($address) {
    $response = \GoogleMaps::load('geocoding')
        ->setParam (['address' => $address])
        ->get();
    
    $response = json_decode($response);

    return $response->results[0]->place_id;
}

function splitAddress($complete_address) {
    $exploded_address = explode( ' - ', $complete_address );
    $street = explode(',', $exploded_address[0])[0];
    $neighborhood = $exploded_address[1];
    $city = $exploded_address[2];
    $number_and_complement = explode(' ', explode(',', $exploded_address[0])[1]);
    $number = $number_and_complement[1];
    $complement = implode(' ', array_slice($number_and_complement, 2));
    $complement = ($complement != '') ? $complement : null;

    $splitted_address = [
        'street' => $street,
        'number' => $number,
        'complement' => $complement,
        'neighborhood'  => $neighborhood,
        'city' => $city
    ];

    return $splitted_address;
}

function getDefalutParamsToGenerateRoutes() {
    $params = [];
    $params['waypoints'] = ['optimize:true'];
    $params['origin'] = env('DEFAULT_ORIGIN_ADDRESS');
    $params['destination'] = env('DEFAULT_DESTINY_ADDRESS', env('DEFAULT_ORIGIN_ADDRESS'));
    $params['language'] = 'pt-BR';

    return $params;
}