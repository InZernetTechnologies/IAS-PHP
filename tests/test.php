<?php
require_once "../vendor/autoload.php";

use InZernetTechnologies\IAS\Options\permissionAccessType as perm;

$IAS = new InZernetTechnologies\IAS\IAS();
$create = array(
    "saves",
    "profiles",
    "games",
);
$permissions = array(
    "name_first" => perm::both,
    "name_middle" => "hooplah",
    "name_last" => perm::both
);
$url = $IAS->loginRequest(false, \InZernetTechnologies\IAS\Options\callbackType::POST, "http://localhost/IAS-PHP/IAS/tests/server.php", $create, $permissions);
echo $url;