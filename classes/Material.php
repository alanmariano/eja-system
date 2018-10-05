<?php



    class Material{

        private $oid;
        private $title;
        private $content;
        private $privacy;
        private $tags;
        private $author;

        //Constructor
        public function __construct($oid, $title, $content, $privacy, $tags, $author){
            $this->setOid($oid);
            $this->setTitle($title);
            $this->setContent($content);
            $this->setPrivacy($privacy);
            $this->setTags($tags);
            $this->setAuthor($author);
        }

        //Getters
        function getOid(){
            return $this->oid;
        }

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
        function setOid($oid){
            $this->oid = $oid;
        }
        
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

        

    }

?>