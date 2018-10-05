<?php
    
    require_once (__DIR__ . "/../classes/Material.php");
    require_once (__DIR__ . "/../vendor/autoload.php");
    


    

class DB_Handler{

    private $client;
    public $database;   

    public function __construct(){
        $this->database = "project_db";
        $user = "admin";
        $pwd = "pass123ASSFv";
        $this->client = new MongoDB\Client("mongodb://${user}:${pwd}@127.0.0.1:27017");        
    }


    //CRUD functions
    function new_material($material){    
        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;

            $insertOneResult = $collection->insertOne([
                'titulo' => $material->getTitle(),
                'privacidade' => $material->getPrivacy(),
                'conteudo' => $material->getContent(),
                'autor' => $material->getAuthor(),
                'tags'  => $material->getTags()
            ]);

            if($insertOneResult->getInsertedCount()>0){
                return 'ok';
            }else{
                return 'erro ao inserir';
            }

        }catch(Exception $e){
            return $e->getMessage();
        }    
    }

    function get_my_materials(){
        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;
            $oid = new MongoDB\BSON\ObjectId("5bac156c3ed8327ae72f2aa7");

            $cursor = $collection->find(
                [
                    'autor' => $oid
                ],
                [
                    'sort' => ['titulo' => 1],
                    'projection' => [
                        'autor' => 0
                    ]
                ]
            );

            return $cursor;

        }catch(Exception $e){
            return $e->getMessage();
        }    
        
    }
}

?>