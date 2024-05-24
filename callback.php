<?php
header("Access-Control-Allow-Origin: *");

$stkCallbackResponse = file_get_contents('php://input');

$logFile = "stkCallbackResponse.json";

$data = '{}';

file_put_contents($logFile, $data);

$log = fopen($logFile, 'a');
fwrite($log, $stkCallbackResponse);
fclose($log);

$stkCallbackResponse = json_decode($stkCallbackResponse);

$ResultCode = $stkCallbackResponse->Body->stkCallback->ResultCode;
$CheckoutRequestID = $stkCallbackResponse->Body->stkCallback->CheckoutRequestID;
$Amount = $stkCallbackResponse->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$MpesaReceiptNumber = $stkCallbackResponse->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$PhoneNumber = $stkCallbackResponse->Body->stkCallback->CallbackMetadata->Item[2]->Value;
$ExternalReference = $stkCallbackResponse->Body->stkCallback->CallbackMetadata->Item[3]->Value;


if ($ResultCode == 0) {

    include "conn.php";

    $sql = "INSERT INTO payments (Amount, MpesaReceiptNumber, PhoneNumber, ExternalReference) VALUES ('$Amount', '$MpesaReceiptNumber', '$PhoneNumber', '$ExternalReference')";
    $result = $conn->query($sql);

    $conn = null;
    
    $data = json_encode(array(
        'ResultCode' => $ResultCode,
        'CheckoutRequestID' => $CheckoutRequestID,
        'Amount' => $Amount,
        'MpesaReceiptNumber' => $MpesaReceiptNumber,
        'PhoneNumber' => $PhoneNumber,
        'ExternalReference' => $ExternalReference
    ));
    file_put_contents($logFile, $data);
}