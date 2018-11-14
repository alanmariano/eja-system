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
    ////////////////////////NEW MATERIALS
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

                $inserteId = $insertOneResult->getInsertedId();
                
                $collection = $this->client->$db->tags_materiais;

                foreach($material->getTags() as $tag){
                    try{
                        $updateResult = $collection->updateOne(
                            [ 'titulo' => $tag ],
                            [ '$addToSet' => [ 'materiais' => $inserteId ]],
                            [ 'upsert' => true]
                        );
                    }catch(Exception $e){
                        return array("status" => "error", "message" => "Erro ao inserir tags. Erro: ".$e->getMessage());
                    }
                }                
                return array("status" => "ok", "message" => "Inserido com sucesso");
            }else{
                return array("status" => "error", "message" => "Material não foi inserido");
            }

        }catch(Exception $e){
            return array("status" => "error", "message" => "Erro ao inserir material. Erro: ".$e->getMessage());
        }    
    }


    ////////////////////EDIT MATERIALS
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

                $deleted = array_diff((array)$document->tags, (array)$material->getTags());
                $added = array_diff((array)$material->getTags(), (array)$document->tags);

                //return $deleted; 
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

                $collection = $this->client->$db->tags_materiais;

                foreach($added as $a){
                    try{
                        $tagUpdateResult = $collection->updateOne(
                            [ 'titulo' => $a ],
                            [ '$addToSet' => [ 'materiais' => $material->getOid() ]],
                            [ 'upsert' => true]
                        );
                    }catch(Exception $e){
                        return array("status" => "error", "message" => "Erro ao inserir tags. Erro: ".$e->getMessage());
                    }
                }

                foreach($deleted as $d){
                    try{
                        $tagUpdateResult = $collection->updateOne(
                            [ 'titulo' => $d ],
                            [ '$pull' => [ 'materiais' => $material->getOid() ]],
                            [ 'upsert' => true]
                        );
                    }catch(Exception $e){
                        return array("status" => "error", "message" => "Erro ao remover tags. Erro: ".$e->getMessage());
                    }
                }
    
                if($updated != null){
                    return array("status" => "ok", "message" => "Editado com sucesso");
                }else{
                    return array("status" => "error", "message" => "erro ao editar");
                }
            }else{
                return array("status" => "error", "message" => "Você não é o criador desse documento");
            }            

        }catch(Exception $e){
            return array("status" => "error", "message" => $e->getMessage());
        }    
    }

    ///////////////////////DELETE MATERIALS
    function delete_materials($materials){

        try{
            $db = $this->database;

            foreach($materials as $material){

                $collection = $this->client->$db->materiais_didaticos;
                $deleted = $collection->deleteOne(
                    [
                        "_id" => $material->getOid(),
                        "autor" => $material->getAuthor()
                    ]
                );

                $collection = $this->client->$db->tags_materiais;
                
                try{
                    $tagUpdateResult = $collection->updateMany(
                        [ ],
                        [ '$pull' => [ 'materiais' => $material->getOid() ]],
                        [ 'upsert' => true]
                    );
                }catch(Exception $e){
                    return array("status" => "error", "message" => "Erro ao remover tags. Erro: ".$e->getMessage());
                }
                
    
                if($deleted->getDeletedCount()==1){
                    continue;
                }else if($deleted->getDeletedCount()==0){
                    return array("status" => "error", "message" => "Erro ao deletar o material ".$material->getOid().". Material não existe ou você não é o autor.");
                }
            }

            return array("status" => "ok", "message" => "Deletado com sucesso");

        }catch(Exception $e){
            return array("status" => "error", "message" => $e->getMessage());
        }

    }

    function get_user_materials($author){

        try{
            $db = $this->database;
            $collection = $this->client->$db->materiais_didaticos;

            $cursor = $collection->find(
                [
                    'autor' => $author
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

    function search_materials($query, $options = array()){
        
        try{

            $db = $this->database;
            $collection = $this->client->$db->tags_materiais;

            $document = $collection->findOne(
                $query
            );
            
            if($document == null){
                return "Tag não encontrada";
            }

            $collection = $this->client->$db->materiais_didaticos;

            $cursor = $collection->find(
                [ 
                    "_id" => [ '$in' => $document->materiais],
                    "privacidade" => "0"
                ],
                $options
            );

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
            
            
        }catch(Exception $e){
            return $e->getMessage();
        }   
    }


    /////////////////////// NEW IMAGE
    function new_image($data){
        $image_path = $data['image_path'];
        $erros = array();
        try{
            $db = $this->database;
            $collection = $this->client->$db->tags_imagens;

            foreach($data['tags'] as $tag){
                try{
                    $updateResult = $collection->updateOne(
                        [ 'titulo' => $tag ],
                        [ '$addToSet' => [ 'imagens' => $image_path ]],
                        [ 'upsert' => true]
                    );
                }catch(Exception $e){
                    $erros[] = $e->getMessage();
                }
            }

            if(empty($erros)){
                return array("status" => "ok", "message" => "Inserido com sucesso");
            }else{
                return array("status" => "error", "message" => "Erro ao inserir ao menos uma tag. Erro: ".$erros[0]);
            }
        }catch(Exception $e){
            return array("status" => "error", "message" => "Erro ao inserir imagem. Erro: ".$e->getMessage());
        }
    }


    /////////////////////// SEARCH IMAGES
    function search_images($query, $options = array()){

        try{

            $db = $this->database;
            $collection = $this->client->$db->tags_imagens;

            $document = $collection->findOne(
                $query
            );
            
            if($document == null){
                return array("status" => "error", "message" => "Tag não encontrada");
            }else{
                foreach($document->imagens as $imagem){
                    $images[] = $imagem;
                }
                return array("status" => "ok", "images" => $images);
            }
            
        }catch(Exception $e){
            return array("status" => "error", "message" => $e->getMessage());
        }   
    }


    //////////////////////////////NEW USER
    function new_user($user){    
        
        try{
            $db = $this->database;
            $collection = $this->client->$db->usuarios;

            $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);

            $insertOneResult = $collection->insertOne(
                [
                    'nome' => $user->getName(),
                    'email' => $user->getEmail(),
                    'senha' => $pass,
                    'funcao' => $user->getRole()
                ]
            );

            if($insertOneResult->getInsertedCount()>0){                
                return array("status" => "ok", "message" => "Inserido com sucesso");
            }else{
                return array("status" => "error", "message" => "Usuário não foi inserido");
            }

        }catch(Exception $e){
            return array("status" => "error", "message" => "Erro ao inserir usuário. Erro: ".$e->getMessage());
        }    
    }


    //////////////////GET ALL USERS
    function get_users($query = array(), $options = array()){

        try{
            $db = $this->database;
            $collection = $this->client->$db->usuarios;

            $response = array();

            $cursor = $collection->find(
                $query,
                $options                
            );

            foreach ($cursor as $c){
                $response[] = array(
                    "oid"           =>  $c->_id->__toString(),
                    "nome"        =>  $c->nome,
                    "email"      =>  $c->email,
                    "funcao"          =>  $c->funcao
                );
            }
            return $response;

        }catch(Exception $e){
            return $e->getMessage();
        }    

    }

    ///////////////////////DELETE MATERIALS
    function delete_users($users){

        try{
            $db = $this->database;

            foreach($users as $user){

                $collection = $this->client->$db->usuarios;
                $deleted = $collection->deleteOne(
                    [
                        "_id" => $user->getOid()
                    ]
                );

                if($deleted->getDeletedCount()==1){
                    continue;
                }else if($deleted->getDeletedCount()==0){
                    return array("status" => "error", "message" => "Erro ao deletar o usuário ".$user->getOid());
                }
            }

            return array("status" => "ok", "message" => "Deletado com sucesso");

        }catch(Exception $e){
            return array("status" => "error", "message" => $e->getMessage());
        }

    }

    ////////////////////EDIT MATERIALS
    function edit_user($user){    

        try{
            $db = $this->database;
            $collection = $this->client->$db->usuarios;

            
            $document = $collection->findOne(
                [
                    "_id" => $user->getOid()
                ]
            );

            if($user->getPassword() != "" && !password_verify($user->getPassword(), $document->senha)){
                $updated = $collection->findOneAndUpdate(
                    [
                        "_id" => $user->getOid()
                    ],
                    [
                        '$set' => [
                            'nome' => $user->getName(),
                            'email' => $user->getEmail(),
                            'senha' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                            'funcao'  => $user->getRole()
                        ]
                    ],
                    [
                        'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER
                    ]
                );
            }else{
                $updated = $collection->findOneAndUpdate(
                    [
                        "_id" => $user->getOid()
                    ],
                    [
                        '$set' => [
                            'nome' => $user->getName(),
                            'email' => $user->getEmail(),
                            'funcao'  => $user->getRole()
                        ]
                    ],
                    [
                        'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER
                    ]
                );
            }

            if($updated != null){
                return array("status" => "ok", "message" => "Editado com sucesso");
            }else{
                return array("status" => "error", "message" => "erro ao editar");
            }

        }catch(Exception $e){
            return array("status" => "error", "message" => $e->getMessage());
        }
         
    }

    /////////////////////CHECK IF USER INPUT ON LOGIN IS RIGTH
    function login($user){
        try{
            $db = $this->database;
            $collection = $this->client->$db->usuarios;

            $document = $collection->findOne(
                [
                    'email' => $user->getEmail()
                ]
            );

            if($document == null){
                return array("status" => "error", "message" => "Email incorreto");
            }else{
                if(password_verify($user->getPassword(), $document->senha)){
                    //LOGOU
                    session_start();
                    $_SESSION["logged"] = true;
                    $_SESSION["user"] = new User($document->_id, $document->nome, null, null, null, $document->funcao);

                    return array("status" => "ok", "message" => "Logged in");
                }else{
                    return array("status" => "error", "message" => "Senha incorreta");
                }
            }
        }catch(Exception $e){
            return array("status" => "error", "message" => $e->getMessage());
        }
    }


}

?>