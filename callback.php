<?php
header("Access-Control-Allow-Origin: *");

$stkCallbackResponse = file_get_contents('php://input');

$logFile = "stkCallbackResponse.json";

$data = '{}';

file_put_contents($logFile, $data);

$log = fopen($logFile, 'a');
fwrite($log, $stkCallbackResponse);
fclose($log);
