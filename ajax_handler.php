<?php
     
    require_once (__DIR__ . "/classes/Material.php");
    require_once (__DIR__ . "/db/db_handler.php");
    require_once (__DIR__ . "/vendor/autoload.php");
    
    $rawdata = file_get_contents('php://input');
    $data = json_decode($rawdata);

    $author = "5bac156c3ed8327ae72f2aa7"; //admin
    //$author = "5bac156c3ed8327ae72f2ab7"; //user fake para testes

    if($data->func == "new_material"){
        $material = new Material(null, $data->title, $data->content, $data->privacy, $data->tags, new MongoDB\BSON\ObjectId("$author"));
        $db = new DB_Handler();
        echo json_encode($db->new_material($material));
    }

    if($data->func == "edit_material"){
        $material = new Material(new MongoDB\BSON\ObjectId("$data->oid"), $data->title, $data->content, $data->privacy, $data->tags, new MongoDB\BSON\ObjectId("$author"));
        $db = new DB_Handler();
        echo json_encode($db->edit_material($material));
    }

    if($data->func == "delete_materials"){
        $materials = array();
        foreach($data->oids as $oid){
            $materials[] = new Material(new MongoDB\BSON\ObjectId("$oid"), null, null, null, null, new MongoDB\BSON\ObjectId("$author"));
        }
        $db = new DB_Handler();
        echo json_encode($db->delete_materials($materials));

    }

    if($data->func == "get_material"){
        $oid = new MongoDB\BSON\ObjectId("$data->oid");
        $query = array("_id" => $oid);
        $db = new DB_Handler();
        echo json_encode($db->get_materials($query));
    }
    
?>