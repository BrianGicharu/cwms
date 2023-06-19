<?php

include_once("settings/api_settings.php");

// MPesa STKPush response constants
define("MPESA_PAY_SUCCESS", 0);
define("MPESA_PAY_INSUFFICIENT_FUNDS", 1);
define("MPESA_PAY_INVALID_TRANSACTION", 3);
define("MPESA_PAY_AUTH_FAILURE", 4);
define("MPESA_PAY_INVALID_AMOUNT", 6);
define("MPESA_PAY_INVALID_PAYBILL_NO", 8);
define("MPESA_PAY_INVALID_DEBIT_ACC", 11);
define("MPESA_INVALID_PHONE_NUMBER", 13);
define("MPESA_DUPLICATE_PAYMENT_REQUEST", 14);
define("MPESA_PAYMENT_REQUEST_ERROR", 26);
// define("UNDEFINED_ERROR", 1000);


// Function to launch MPESA STKPush on customer's contact USSD
function payWithMPesaSTK(?string $phoneNumber, ?float $amount): array
{
    global $password;
    global $callBackURL;
    global $accRef;
    global $bearerToken;
    $time = time();
    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $bearerToken",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "BusinessShortCode" => 174379,
        "Password" => $password,
        "Timestamp" => $time,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $amount,
        "PartyA" => $phoneNumber,
        "PartyB" => 174379,
        "PhoneNumber" => $phoneNumber,
        "CallBackURL" => $callBackURL,
        "AccountReference" => $accRef,
        "TransactionDesc" => "Payment of X"
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $responseJson = curl_exec($ch);
    if (curl_errno($ch)) {
        $response = json_encode(['error' => curl_error($ch)]);
    } else {
        $response = json_decode($responseJson, true);
    }
    curl_close($ch);
    return array($responseJson);
}


// PAYMENT ERROR CODES

/* ---------------- MPESA ------------------------
    0: Payment succesfull
    1: Insufficient funds for transaction
    3: Invalid Transaction
    4: Authentication Failed
    6: Invalid Amount
    8: Invalid PayBill Number
    11: Debit Account Invalid
    13: Invalid Phone Number
    14: Payment Request is already being processed
    26: Failed to process request
*/