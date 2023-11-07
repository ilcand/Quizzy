-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2023 at 03:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizzy`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `id_question` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `title`, `id_question`) VALUES
(1, '1. Nu exista', 1),
(2, '2. Nu rezista', 1),
(3, '3. 1.41 g/cm³', 1),
(4, '4', 2),
(5, '1 + 2 = 3', 3),
(6, '2 + 2 - 1 = 4', 3),
(7, '3 + 0 = 3', 3),
(8, '1. Merele sunt rosii', 4),
(9, '2. Perele sunt galbene', 4),
(10, '3. Rodia este o leguma', 4),
(11, '4. Mowgli era un ren', 4),
(12, '5. Tren rimeaza cu treaz', 4),
(13, '1. Soarele este o stea', 5),
(14, '2. Soarele este o planeta', 5),
(15, '3. Soarele nu exista', 5),
(16, '1', 6),
(17, '2', 6),
(18, '3', 6),
(19, '4', 6),
(20, '8', 7),
(21, 'bnn', 8);

-- --------------------------------------------------------

--
-- Table structure for table `correct`
--

CREATE TABLE `correct` (
  `id` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_answer` int(11) NOT NULL,
  `hidden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `correct`
--

INSERT INTO `correct` (`id`, `id_question`, `id_answer`, `hidden`) VALUES
(1, 1, 3, 0),
(2, 2, 4, 1),
(3, 3, 5, 0),
(4, 3, 7, 0),
(5, 4, 8, 0),
(6, 4, 9, 0),
(7, 5, 13, 0),
(8, 6, 18, 0),
(9, 7, 20, 1),
(10, 8, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `score` float NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `type`, `score`, `owner`) VALUES
(1, 'Care este densitatea soarelui?', 'sa-mark', 10, 2),
(2, '2 + 2 = ?', 'sa-text', 10, 2),
(3, 'Choose the right answers', 'ma-checkbox', 10, 2),
(4, 'Alege variantele corecte', 'ma-checkbox', 6, 3),
(5, 'Alege afirmatia corecta', 'sa-mark', 10, 2),
(6, 'Question to delete', 'sa-mark', 2, 2),
(7, '4 + 4 = ?', 'sa-text', 5, 2),
(8, 'bvnbn', 'sa-text', 66, 2);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `questions` varchar(9999) NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `questions`, `owner`) VALUES
(1, 'Quizz #1', 'Alege variantele corecte', 3),
(2, 'xcx', '2 + 2 = ?', 3),
(3, 'bnk', '2 + 2 = ?, Care este densitatea soarelui?', 3),
(4, 'Quiz #2', 'Care este densitatea soarelui?, 2 + 2 = ?, Choose the right answers, Alege variantele corecte', 2),
(5, 'Quiz Mix', 'Alege variantele corecte, 2 + 2 = ?, Choose the right answers', 3),
(6, 'Quiz Test', '2 + 2 = ?, Choose the right answers, Alege afirmatia corecta', 2),
(7, 'Final Quiz', '2 + 2 = ?, Choose the right answers, Alege variantele corecte, Alege afirmatia corecta', 2),
(8, 'Latest Quiz', '4 + 4 = ?, 2 + 2 = ?, Choose the right answers, Alege variantele corecte, Alege afirmatia corecta', 2);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_id`, `quiz_id`, `score`) VALUES
(1, 2, 8, '0.61'),
(2, 2, 8, '0.37'),
(3, 2, 1, '0.00'),
(4, 2, 1, '0.00'),
(5, 2, 2, '1.00'),
(6, 2, 6, '0.33'),
(7, 2, 6, '0.67'),
(8, 2, 6, '1.00'),
(9, 2, 4, '0.28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(9999) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'demo', 'demo@demo.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 'user'),
(3, 'user', 'user@user.com', 'ee11cbb19052e40b07aac0ca060c23ee', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `correct`
--
ALTER TABLE `correct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_answer` (`id_answer`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `correct`
--
ALTER TABLE `correct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `correct`
--
ALTER TABLE `correct`
  ADD CONSTRAINT `correct_ibfk_1` FOREIGN KEY (`id_answer`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correct_ibfk_2` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
