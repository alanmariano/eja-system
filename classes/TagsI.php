<?php

    class TagsI{

        private $title;
        private $images;

        public function __construct($title, $images){
            $this->setTitle($title);
            $this->setImages($images);
        }

        function getTitle(){
            return $this->title;
        }

        function getImages(){
            return $this->images;
        }

        function setTitle($title){
            $this->title = $title;
        }

        function setImages($images){
            $this->images = $images;
        }

    }

?>