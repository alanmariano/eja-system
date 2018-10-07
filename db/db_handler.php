<?php
    
    require_once (__DIR__ . "/../classes/Material.php");
    require_once (__DIR__ . "/../vendor/autoload.php");
    


    

class DB_Handler{

    private $client;
    public $database;   
    public $author;

    public function __construct(){
        $this->database = "project_db";
        $this->author = "5bac156c3ed8327ae72f2aa7";
        $user = "admin";
        $pwd = "pass123ASSFv";
        $this->client = new MongoDB\Client("mongodb://${user}:${pwd}@127.0.0.1:27017");        
    }


    //CRUD functions
    ////////////////////////NEW
    function new_material($material){    

        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;

            $insertOneResult = $collection->insertOne(
                [
                    'titulo' => $material->getTitle(),
                    'privacidade' => $material->getPrivacy(),
                    'conteudo' => $material->getContent(),
                    'autor' => $material->getAuthor(),
                    'tags'  => $material->getTags()
                ]
            );

            if($insertOneResult->getInsertedCount()>0){
                return 'ok';
            }else{
                return 'erro ao inserir';
            }

        }catch(Exception $e){
            return $e->getMessage();
        }    
    }


    ////////////////////EDIT
    function edit_material($material){    

        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;

            $document = $collection->findOne(
                [
                    "_id" => $material->getOid()
                ]
            );

            if($document->autor->__toString() == $material->getAuthor()->__toString()){
                $updated = $collection->findOneAndUpdate(
                    [
                        "_id" => $material->getOid()
                    ],
                    [
                        '$set' => [
                            'titulo' => $material->getTitle(),
                            'privacidade' => $material->getPrivacy(),
                            'conteudo' => $material->getContent(),
                            'tags'  => $material->getTags()
                        ]
                    ],
                    [
                        'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER
                    ]
                );
    
                if($updated != null){
                    return 'ok';
                }else{
                    return 'erro ao inserir';
                }
            }else{
                return "Você não é o criador desse documento";
            }            

        }catch(Exception $e){
            return $e->getMessage();
        }    
    }

    ///////////////////////DELETE
    function delete_materials($materials){

        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;

            foreach($materials as $material){
                $deleted = $collection->deleteOne(
                    [
                        "_id" => $material->getOid(),
                        "autor" => $material->getAuthor()
                    ]
                );
    
                if($deleted->getDeletedCount()==1){
                    continue;
                }else if($deleted->getDeletedCount()==0){
                    return "Erro ao deletar o material ".$material->getOid().". Material não existe ou você não é o autor.";
                }
            }

            return "ok";

        }catch(Exception $e){
            return $e->getMessage();
        }

    }

    function get_user_materials(){

        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;
            $oid = new MongoDB\BSON\ObjectId("$this->author");

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

    function get_materials($query, $single = true,  $options = array()){

        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;

            if($single){
                $document = $collection->findOne(
                    $query,
                    $options
                );

                $response  = array();
                $response[] = array(
                    "oid"           =>  $document->_id->__toString(),
                    "titulo"        =>  $document->titulo,
                    "conteudo"      =>  $document->conteudo,
                    "tags"          =>  $document->tags,
                    "autor"         =>  $document->autor->__toString(),
                    "privacidade"   =>  $document->privacidade
                );                 

                return $response;

            }else{
                $cursor = $collection->find(
                    $query,
                    $options
                );

                $response  = array();
                foreach($cursor as $c){
                    $response[] = array(
                        "oid"           =>  $c->_id->__toString(),
                        "titulo"        =>  $c->titulo,
                        "conteudo"      =>  $c->conteudo,
                        "tags"          =>  $c->tags,
                        "autor"         =>  $c->autor->__toString(),
                        "privacidade"   =>  $c->privacidade
                    ); 
                } 

                return $response;

            }
            
        }catch(Exception $e){
            return $e->getMessage();
        }   
        
    }

}

?>