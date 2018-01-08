<?php
require_once "../vendor/autoload.php";

$IAS = new InZernetTechnologies\IAS\IAS();
$url = $IAS->loginRequest(false, \InZernetTechnologies\IAS\Options\callbackType::POST, "http://ias.inzernettechnologies.com/server.php");
echo $url;