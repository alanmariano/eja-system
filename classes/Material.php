<?php

//include "../globals.php";
require_once __DIR__ . "/../vendor/autoload.php"; 

    class Material{

        private $title;
        private $content;
        private $privacy;
        private $tags;
        private $author;

        //Constructor
        public function __construct($title, $content, $privacy, $tags, $author){
            $this->setTitle($title);
            $this->setContent($content);
            $this->setPrivacy($privacy);
            $this->setTags($tags);
            $this->setAuthor($author);
        }

        //Getters
        function getTitle(){
            return $this->title;
        }

        function getContent(){
            return $this->content;
        }

        function getPrivacy(){
            return $this->privacy;
        }

        function getTags(){
            return $this->tags;
        }

        function getAuthor(){
            return $this->author;
        }

        //Setters
        function setTitle($title){
            $this->title = $title;
        }

        function setContent($content){
            $this->content = $content;
        }

        function setPrivacy($privacy){
            $this->privacy = $privacy;
        }

        function setTags($tags){
            $this->tags = $tags;
        }

        function setAuthor($author){
            $this->author = $author;
        }

        //CRUD functions
        function new(){

            $user = "admin";
            $pwd = "pass123ASSFv";
            try{
                $client = new MongoDB\Client("mongodb://${user}:${pwd}@127.0.0.1:27017");
                $collection = $client->project_db->materiais_didaticos;

                $insertOneResult = $collection->insertOne([
                    'titulo' => $this->getTitle(),
                    'privacidade' => $this->getPrivacy(),
                    'conteudo' => $this->getContent(),
                    'autor' => $this->getAuthor()
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

    }

?>