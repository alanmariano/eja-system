<?php

    class User{

        private $oid;
        private $name;
        private $email;
        private $password;
        private $materials;
        private $role;

        public function __construct($oid, $name, $email, $password, $materials, $role){
            $this->setOid($oid);
            $this->setName($name);
            $this->setEmail($email);
            $this->setPassword($password);
            $this->setMaterials($materials);
            $this->setRole($role);
        }

        
        function getOid(){
            return $this->oid;
        }

        function getName(){
            return $this->name;
        }

        function getEmail(){
            return $this->email;
        }

        function getPassword(){
            return $this->password;
        }

        function getMaterials(){
            return $this->materials;
        }

        function getRole(){
            return $this->role;
        }

        function setOid($oid){
            $this->oid = $oid;
        }

        function setName($name){
            $this->name = $name;
        }

        function setEmail($email){
            $this->email = $email;
        }

        function setPassword($password){
            $this->password = $password;
        }

        function setMaterials($materials){
            $this->materials = $materials;
        }

        function setRole($role){
            $this->role = $role;
        }

    }

?>