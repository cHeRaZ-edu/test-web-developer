<?php
    require_once("db.php");
    $personal = $_POST["personal"] ? $_POST["personal"] : null;
    $personal = json_decode($personal);
    $connection = db::connect();
    $personalResult =  db::CrearPersonal($connection, $personal);
    $response = (object) array("status" => 200,"message" => "Se ha subido con éxito.", "personal" => $personalResult);
    echo json_encode($response);
?>