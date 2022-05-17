<?php
    if(empty($_POST)){die();}

    $embed = [
        "embeds" => [
            [
                "type" => "rich",
                "title" => "Error Log",
                "timestamp" => gmdate("Y-m-d H:i:s", time()),
                "color" => ($_POST["realm"] == "server") ? hexdec(sprintf("%02x%02x%02x", 100, 100, 255)) : hexdec(sprintf("%02x%02x%02x", 255, 94, 0)),
                "description" => $_POST["error"],

                "fields" => [
                    [
                        "name" => 'Stack',
                        "value" => $_POST["stack"] ? $_POST["stack"] : 'No stack',
                    ],

                    [
                        "name" => 'Addon',
                        "value" => strval($_POST["addon"] ? $_POST["addon"] : 0),
                    ],
                ],
            ]
        ]
    ];

    
    $json_str = json_encode($embed);
    $curl = curl_init();
    
    print_r($json_str);
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'Your Webhook Here',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_str,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_str),
        ),
    ));
    
    $result = curl_exec($curl);
    curl_close($curl);
    
    exit();
?>