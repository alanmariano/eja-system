<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class User{

        private $name;
        private $email;
        private $materials;
        private $role;

        public function __construct($name, $email, $materials, $role){
            $this->setName($name);
            $this->setEmail($email);
            $this->setMaterials($materials);
            $this->setRole($role);
        }


        function getName(){
            return $this->name;
        }

        function getEmail(){
            return $this->email;
        }

        function getMaterials(){
            return $this->materials;
        }

        function getRole(){
            return $this->role;
        }

        function setName($name){
            $this->name = $name;
        }

        function setEmail($email){
            $this->email = $email;
        }

        function setMaterials($materials){
            $this->materials = $materials;
        }

        function setRole($role){
            $this->role = $role;
        }

    }

?>