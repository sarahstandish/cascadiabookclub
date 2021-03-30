<?php

include 'keys.php';

function add_subscriber($email, $first_name, $last_name) {

    $fields = [
        'email_address' => $email,
        'status'=> 'subscribed',
        'merge_fields' => [
            'FNAME' => $first_name,
            'LNAME' => $last_name
        ],
    ];

    $json_fields_array = json_encode($fields);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://us7.api.mailchimp.com/3.0/lists/86c372fe4f/members/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_fields_array,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ebd814a31fb6495dce0653eaa443fae8-us7',
            'Content-Type: application/json'
            ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
}

function add_tag($email, $new_tags) {

    $email_hash = md5(strtolower($email));

    $tags_array1 = [];

    foreach ($new_tags as $tag) {
        //convert to a series of key value pairs
        $temp_array = [
            "name" => $tag,
            "status" => 'active'
        ];
        array_push($tags_array1, $temp_array);
    }

    $tags_array2 = [
        "tags" => $tags_array1
    ];

    $json_tags_array = json_encode($tags_array2);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://us7.api.mailchimp.com/3.0/lists/86c372fe4f/members/$email_hash/tags",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_tags_array,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ebd814a31fb6495dce0653eaa443fae8-us7',
            'Content-Type: application/json'
            ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
}

?>
