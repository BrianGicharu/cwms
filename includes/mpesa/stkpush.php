
<?php
include_once("../settings/api_settings.php");

function paySTKPushMpesa($phoneNumber = "2547111850445", $paymentAmt = 1, $transactionDesc = "Payment4CarWash")
{
    global $passKey; // = "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjMwNTA3MTYwNDA4";
    global $accRef; // = "BenjyCarWash";
    global $callBackURL; // = "https://mydomain.com/path";
    global $bearerToken; // = "Bearer exrURZFmjvqYRQMEKo53XNsEa1Z7";
    global $consumerKey;
    global $consumerSecret;

    $authUrl = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

    $c = curl_init($authUrl);
    $creds =  $consumerKey . ':' . $consumerSecret;
    $headers = [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($creds)
    ];

    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($c);
    curl_close($c);

    echo "<pre>".htmlentities($response) . "<br>";
    // . (json_decode($response))->access_token . "<br>";

    $bsShortCode = 174379;
    $stamp = date("YmdHis", time());

    // echo $stamp . " " . time() . "<br>" . date("YmdHis", 3599) . "<br>";

    $password = base64_encode($bsShortCode . (json_decode($response))->access_token . $stamp);


    // 2nd auth & API call

    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');

    $headers2 = [
        'Authorization: Bearer ' . json_decode($response)->access_token
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "BusinessShortCode" =>  174379,
        "Password" =>  base64_encode($bsShortCode . $consumerKey . $stamp),
        "Timestamp" => $stamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $paymentAmt,
        "PartyA" => $phoneNumber,
        "PartyB" =>  174379,
        "PhoneNumber" => $phoneNumber,
        "CallBackURL" => "https://1263-105-161-183-222.ngrok-free.app/includes/mpesa/stkpush.php",
        "AccountReference" => "Test",
        "TransactionDesc" => $transactionDesc
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

echo paySTKPushMpesa()."</pre>";
