<?php
require_once "../vendor/autoload.php";

$IAS = new InZernetTechnologies\IAS\IAS();
try {
    $token = $IAS->loginResponse();
} catch (\InZernetTechnologies\IAS\Exceptions\invalidResponse $invalidResponse){
    exit("ERROR: " . $invalidResponse->getMessage());
}

echo "Your name is: " . $IAS->get($token)->first_name() . " " . $IAS->get($token)->last_name();