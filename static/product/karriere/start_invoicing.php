<?php

$data = array(
    'variables' => array(
        'anzahlLizenzen' => array(
            'value' => $_POST['numberOfLicenses'],
            'type' => 'Integer'
        ),
        'land' => array(
            'value' => $_POST['country'],
            'type' => 'String'
        ),
        'ort' => array(
            'value' => $_POST['location'],
            'type' => 'String'
        ),
        'anrede' => array(
            'value' => $_POST['salutation'],
            'type' => 'String'
        ),
        'nachname' => array(
            'value' => $_POST['lastName'],
            'type' => 'String'
        ),
        'firmenname' => array(
            'value' => $_POST['companyName'],
            'type' => 'String'
        ),
        'rechtsform' => array(
            'value' => $_POST['legalForm'],
            'type' => 'String'
        ),
        'vorname' => array(
            'value' => $_POST['firstName'],
            'type' => 'String'
        ),
        'postleitzahl' => array(
            'value' => $_POST['postalCode'],
            'type' => 'String'
        ),
        'vertreter' => array(
            'value' => $_POST['representative'],
            'type' => 'String'
        ),
        'telefon' => array(
            'value' => $_POST['phone'],
            'type' => 'String'
        ),
        'email' => array(
            'value' => $_POST['email'],
            'type' => 'String'
        ),
        'straße' => array(
            'value' => $_POST['address'],
            'type' => 'String'
        ),
        'ustid' => array(
            'value' => $_POST['salesTax'],
            'type' => 'String'
        ),
        'ustidnr' => array(
            'value' => $_POST['salesTaxnr'],
            'type' => 'String'
        )
    )
);
$json = json_encode($data);

//cURL resource
$url = 'https://workflow.cib.de/engine-rest/process-definition/key/rechnungserstellung-brewer/start';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

// Set HTTP Header for POST request 
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json)
    )
);

// Submit the POST request
$result = curl_exec($ch);

// Close cURL session handle
curl_close($ch);

?>