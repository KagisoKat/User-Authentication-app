<?php
    namespace Library;
    class Author {
        private $id;
        private $name;
        private $age;
        private $genre;

        function getId() {
            return $this->id;
        }

        function getName() {
            return $this->name;
        }

        function getAge() {
            return $this->age;
        }

        function getGenre() {
            return $this->genre;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setName($name) {
            $this->name = $name;
        }

        function setAge($age) {
            $this->age = $age;
        }

        function setGenre($genre) {
            $this->genre = $genre;
        }
    }
?>