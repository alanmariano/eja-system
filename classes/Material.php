<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Material{

        private $title;
        private $data;
        private $privacy;
        private $author;

        public function __construct($title, $data, $privacy, $author){
            $this->setTitle($title);
            $this->setData($data);
            $this->setPrivacy($privacy);
            $this->setAuthor($author);
        }


        function getTitle(){
            return $this->title;
        }

        function getData(){
            return $this->data;
        }

        function getPrivacy(){
            return $this->privacy;
        }

        function getAuthor(){
            return $this->author;
        }

        function setTitle($title){
            $this->title = $title;
        }

        function setData($data){
            $this->data = $data;
        }

        function setPrivacy($privacy){
            $this->privacy = $privacy;
        }

        function setAuthor($author){
            $this->author = $author;
        }

    }

?>