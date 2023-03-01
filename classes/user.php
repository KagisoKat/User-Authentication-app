<?php
    namespace Library;
    class User {
        private $id;
        private $name;
        private $email;
        private $password;
        private $passwordHashed;
        private $role;

        function getId() {
            return $this->id;
        }

        function getName() {
            return $this->name;
        }

        function getEmail() {
            return $this->email;
        }

        function getPassword() {
            return $this->password;
        }

        function getPasswordHashed() {
            return $this->passwordHashed;
        }

        function getRole() {
            return $this->role;
        }

        function setId($id) {
            $this->id = $id;
        }
        
        function setName($name) {
            $this->name = $name;
        }

        function setEmail($email) {
            $this->email = $email;
        }

        function setPassword($password) {
            $this->password = $password;
        }

        function setPasswordHashed($passwordHashed) {
            $this->passwordHashed = $passwordHashed;
        }

        function setRole($role) {
            $this->role = $role;
        }
    }