<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_FILES['file'])) {        

        $errors = [];
        $year = date("Y");   
        $month = date("m"); 
        $path = '/images/uploads/'.$year."/".$month."/";
        
        $extensions = ['jpg', 'jpeg', 'png'];

        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));

        $file_new_name = time().$file_name;
        $file = __DIR__.$path.$file_new_name;

        if (!in_array($file_ext, $extensions)) {
            $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }

        if ($file_size > 2097152) {
            $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }

        if (empty($errors)) {
            if(is_dir(__DIR__.'/images/uploads/'.$year."/")){
                if(is_dir(__DIR__.'/images/uploads/'.$year."/".$month."/")){
                    move_uploaded_file($file_tmp, $file); 
                    echo json_encode(array("status" => "ok", "img_path" => $path.$file_new_name));
                }else{
                    mkdir(__DIR__.'/images/uploads/'.$year."/".$month."/", 0777, true);
                    move_uploaded_file($file_tmp, $file);
                    echo json_encode(array("status" => "ok", "img_path" => $path.$file_new_name));
                }
            }else{
                mkdir(__DIR__.'/images/uploads/'.$year."/".$month."/", 0777, true);
                move_uploaded_file($file_tmp, $file);
                echo json_encode(array("status" => "ok", "img_path" => $path.$file_new_name));
            }
        }


        if ($errors){
            echo json_encode(array("status" => "error", "errors" => $errors));
        };

    }
}

?>