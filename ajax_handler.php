<?php
    include "classes/Material.php";

    $rawdata = file_get_contents('php://input');
    $data = json_decode($rawdata);
    if($data->func == "new_material"){
        $material = new Material($data->title, $data->content, $data->privacy, $data->tags, "5bac156c3ed8327ae72f2aa7");
        echo $material->new();
    }
    
?>