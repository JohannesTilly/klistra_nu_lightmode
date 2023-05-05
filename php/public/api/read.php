<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/include/hash.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/include/encryption.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/include/redis.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("HTTP/1.1 400 Bad Request");
    die();
}

//Get data
try {
    $inputJSON = file_get_contents("php://input");
    $inputObj = json_decode($inputJSON);
} catch (Exception $e) {
    header("HTTP/1.1 204 No Content");
    die();
}

//Validate data
try {
    //Validate id
    if (!is_string($inputObj->id)) {
        validationError("Invalid property: id (string)");
    }
    if (strlen($inputObj->id) < 4) {
        validationError("Invalid property: id (string) too short");
    }

    //Password
    if (!is_string($inputObj->pass)) {
        validationError("Invalid property: pass (string)");
    }
} catch (Exception $e) {
    validationError("Unknown error");
}

$redisConn = new RedisConn();
$dbObject = new stdClass();
$response = new stdClass();

try {
    $dbObject = json_decode($redisConn->Get($inputObj->id));

    //PREPARE DATA
    $response->id = $dbObject->id;
    $response->timeoutUnix = $dbObject->timeoutUnix;
    $response->passwordProtected = $dbObject->passwordProtected;

    //DE-ENCRYPT DATA
    $passwordHash = create_secure_hash($inputObj->pass, $inputObj->id);
    $encryption = new Encryption($passwordHash);
    $response->text = $encryption->decrypt($dbObject->text);

    if ($encryption->decrypt($dbObject->text) == false) {
        header("HTTP/1.1 401 Unauthorized");
        die();
    }
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "Error storing Klister";
    die();
}

//PRESENT DATA
header("HTTP/1.1 200 OK");
header("Content-Type: application/json; charset=utf-8");
echo json_encode($response);
die();

function validationError($reason)
{
    header("HTTP/1.1 400 Bad Request");
    echo $reason;
    die();
}
