<?php
    class Book{
        private $id;
        private $name;
        private $year;
        private $genre;
        private $ageGroup;
        private $authorId;
        private $authorName;
        private $loanUserId;

        function getId() {
            return $this->id;
        }

        function getName() {
            return $this->name;
        }

        function getYear() {
            return $this->year;
        }

        function getGenre() {
            return $this->genre;
        }

        function getAgeGroup() {
            return $this->ageGroup;
        }

        function getAuthorId() {
            return $this->authorId;
        }

        function getAuthorName() {
            return $this->authorName;
        }

        function getLoanUserId() {
            return $this->loanUserId;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setName($name) {
            $this->name = $name;
        }

        function setYear($year) {
            $this->year = $year;
        }

        function setGenre($genre) {
            $this->genre = $genre;
        }

        function setAgeGroup($ageGroup) {
            $this->ageGroup = $ageGroup;
        }

        function setAuthorId($authorId) {
            $this->authorId = $authorId;
        }

        function setAuthorName($authorName) {
            $this->authorName = $authorName;
        }

        function setLoanUserId($loanUserId) {
            $this->loanUserId = $loanUserId;
        }
    }
?>
