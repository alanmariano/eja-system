<?php
     
    require_once (__DIR__ . "/classes/Material.php");
    require_once (__DIR__ . "/db/db_handler.php");
    require_once (__DIR__ . "/vendor/autoload.php");
    
    $rawdata = file_get_contents('php://input');
    $data = json_decode($rawdata);
    
    if($data->func == "new_material"){
        $material = new Material(null, $data->title, $data->content, $data->privacy, $data->tags, new MongoDB\BSON\ObjectId("5bac156c3ed8327ae72f2aa7"));
        $db = new DB_Handler();
        echo $db->new_material($material);
    }
    
?>