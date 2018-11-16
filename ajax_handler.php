<?php
     
    require_once (__DIR__ . "/classes/Material.php");
    require_once (__DIR__ . "/classes/User.php");
    require_once (__DIR__ . "/db/db_handler.php");
    require_once (__DIR__ . "/vendor/autoload.php");

    session_start();
    
    $rawdata = file_get_contents('php://input');
    $data = json_decode($rawdata);

    if($data->func == "new_material"){
        $material = new Material(null, $data->title, $data->content, $data->privacy, $data->tags, $data->shareList, $_SESSION['user']->getOid());
        $db = new DB_Handler();
        echo json_encode($db->new_material($material));
    }

    if($data->func == "edit_material"){
        $material = new Material(new MongoDB\BSON\ObjectId("$data->oid"), $data->title, $data->content, $data->privacy, $data->tags, $data->shareList, $_SESSION['user']->getOid());
        $db = new DB_Handler();
        echo json_encode($db->edit_material($material));
    }

    if($data->func == "delete_materials"){
        $materials = array();
        foreach($data->oids as $oid){
            $materials[] = new Material(new MongoDB\BSON\ObjectId("$oid"), null, null, null, null, null, $_SESSION['user']->getOid());
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

    if($data->func == "search_images"){
        $query = array("titulo" => $data->titulo);
        $db = new DB_Handler();
        echo json_encode($db->search_images($query));
    }

    if($data->func == "new_user"){
        $user = new User(null, $data->name, $data->email, $data->password, null, $data->role);
        $db = new DB_Handler();
        echo json_encode($db->new_user($user));
    }

    if($data->func == "delete_users"){
        $users = array();
        foreach($data->oids as $oid){
            $users[] = new User(new MongoDB\BSON\ObjectId("$oid"), null, null, null, null, null);
        }
        $db = new DB_Handler();
        echo json_encode($db->delete_users($users));
    }

    if($data->func == "get_user"){
        $oid = new MongoDB\BSON\ObjectId("$data->oid");
        $query = array("_id" => $oid);
        $db = new DB_Handler();
        echo json_encode($db->get_users($query));
    }

    if($data->func == "edit_user"){
        $user = new User(new MongoDB\BSON\ObjectId("$data->oid"), $data->name, $data->email, $data->password, null, $data->role);
        $db = new DB_Handler();
        echo json_encode($db->edit_user($user));
    }

    if($data->func == "login"){
        $user = new User(null, null, $data->email, $data->password, null, null);
        $db = new DB_Handler();
        echo json_encode($db->login($user));
    }

    if($data->func == "logout"){
        session_destroy();
        echo json_encode(array("status" => "ok"));
    }
    
?>