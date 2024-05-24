<?php
header("Access-Control-Allow-Origin: *");

$stkCallbackResponse = file_get_contents('php://input');

$logFile = "stkCallbackResponse.json";