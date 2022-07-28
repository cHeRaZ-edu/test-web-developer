<?php 
    require_once("db.php");
    $connection = db::connect();
    $personalResult =  db::ObtenerPersonal($connection);
    $response = (object) array("status" => 200,"message" => "Hay personal en la base de datos.", "personalArray" => $personalResult);
    echo json_encode($response);
?>