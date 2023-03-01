-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2023 at 09:29 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_age` varchar(255) NOT NULL,
  `author_genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `author_age`, `author_genre`) VALUES
(1, 'Vikram Seth', '68yrs', 'noverlist, poet'),
(2, 'Abu\'l-Fazi ibn Mubarak', 'deceased', 'biography'),
(3, 'Philip Zimbardo', '87yrs', 'psychologist'),
(4, 'Jane Austen', 'deceased', 'poet, novelist'),
(5, 'J.M. Coetzee', '81yrs', 'noverlist, essayist, linguist'),
(9, 'niklaas', '76', 'sunnyvale resident'),
(11, 'stevie', '2', 'waav');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `book_year` int(11) NOT NULL,
  `book_genre` varchar(255) NOT NULL,
  `book_age_group` varchar(255) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `loan_user_id` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `book_year`, `book_genre`, `book_age_group`, `author_id`, `loan_user_id`) VALUES
(17, 'The Tale of Melon City', 1981, 'Poetry', '16 year olds and above', 1, -1),
(18, 'The Humble Administrator\'s Garden', 1985, 'Poetry', '18 year olds and above', 1, -1),
(19, 'All you Who Sleep Tonight', 1990, 'Poetry', '18 year olds and above', 1, -1),
(20, 'Akbarnama', 2011, 'Biography', '18 year olds and above', 2, -1),
(21, 'The Cognitive Control of Motivation', 1969, 'Psychology', '18 year olds and above', 3, -1),
(22, 'Stanford prison experiment: A simulation study of the psychology of imprisonment', 1972, 'Psychology', '18 year olds and above', 3, -1),
(23, 'Influencing Attitudes and Changing Behavior', 1969, 'Psychology', '18 year olds and above', 3, -1),
(24, 'Sense and Sensibility', 1871, 'Novel', '12 year olds and above', 4, -1),
(25, 'Pride and Prejudice', 1813, 'Novel', '14 year olds and above', 4, -1),
(26, 'Mansfield Park', 1814, 'Novel', 'adult fiction', 4, -1),
(27, 'Emma', 1871, 'Novel', 'children fiction', 4, -1),
(28, 'Persuasion', 1818, 'Novel', 'adult fiction', 4, -1),
(29, 'Lady Susan', 1871, 'Novel', 'adult fiction', 4, -1),
(30, 'The Childhood of Jesus', 2013, 'Novel', '12 to 15 year olds', 5, -1),
(31, 'The Schooldays of Jesus', 2016, 'Novel', '8 to 10 year olds', 5, -1),
(32, 'The Death of Jesus', 2019, 'Novel', '12 to 17 year olds', 5, -1),
(35, 'Northanger Abbey', 1818, 'Novel', 'teenage fiction', 4, -1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Jerry tommy', 'jerry@tom.com', '$2y$10$Gn6foAne196GTobMsIaWG.RKik2RRwOnP2o2EBI/NQzt/xR8mk4U2', 'member'),
(2, 'orange', 'orange@gmail.com', '$2y$10$CNk47M6SRGVE7HEYW7SdHe7k/SE9xUm0oadE0OVenOO0qY4ScsOGu', 'member'),
(3, 'coder', 'coder@gmail.com', '$2y$10$BgsxoMH95kqEOC/xyOCqnuZpqNvFuBaCC1d7BoPWmKngh8RwdK406', 'member'),
(4, 'peppa', 'peppapig@gmail.com', '$2y$10$5u6xfZrB5AjL9TGDneiXp.JHgKK8qJLNafPtojYpA7FS5jwbx0Awy', 'librarian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
