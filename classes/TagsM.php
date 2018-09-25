<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class TagsM{

        private $title;
        private $materials;

        public function __construct($title, $materials){
            $this->setTitle($title);
            $this->setMaterials($materials);
        }

        function getTitle(){
            return $this->title;
        }

        function getMaterials(){
            return $this->materials;
        }

        function setTitle($title){
            $this->title = $title;
        }

        function setMaterials($materials){
            $this->materials = $materials;
        }

    }

?>