<?php
require_once (__DIR__ . "/vendor/autoload.php");
use thiagoalessio\TesseractOCR\TesseractOCR;

$ocr = new TesseractOCR();

if (isset($_FILES['file'])) {
    
    $path = '/temp/';

    $extensions = ['jpg', 'jpeg', 'png'];

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));

    $file_new_name = time().$file_name;

    $file = __DIR__.$path.$file_new_name;
    
    if (!in_array($file_ext, $extensions)) {
        echo json_encode(array("status" => "error", "message" => 'Extension not allowed: ' . $file_name . ' ' . $file_type));
        exit();
    }

    move_uploaded_file($file_tmp, $file);    

    echo json_encode(array("status" => "ok", "data" => "<p>".$ocr->image("temp/".$file_new_name)->lang('por')->run()."</p>"));

    unlink($file);
        
}
    


/*
require_once (__DIR__ . "/vendor/autoload.php");
use thiagoalessio\TesseractOCR\TesseractOCR;

$ocr = new TesseractOCR();
    
    echo "<p>".$ocr->image('ocr_images/1.png')->lang('por')->run()."</p>";
    echo "<p>".$ocr->image('ocr_images/2.png')->lang('por')->run()."</p>";
    echo "<p>".$ocr->image('ocr_images/3.png')->lang('por')->run()."</p>";;
    echo "<p>".$ocr->image('ocr_images/4.png')->lang('por')->run()."</p>";
    echo "<p>".$ocr->image('ocr_images/mozilla.png')->lang('por')->run()."</p>";
    echo "<p>".$ocr->image('ocr_images/mozilla2.png')->lang('por')->run()."</p>";
    echo "<p>".$ocr->image('ocr_images/mozilla3.png')->lang('por')->run()."</p>";
    echo "<p>".$ocr->image('ocr_images/mozilla4.png')->lang('por')->run()."</p>";
    */

?>