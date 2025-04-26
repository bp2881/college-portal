-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 05:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty_login`
--

CREATE TABLE `faculty_login` (
  `sno` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_login`
--

INSERT INTO `faculty_login` (`sno`, `uid`, `password`) VALUES
(1, 840, 'vgnt'),
(2, 848, 'vgnt'),
(3, 111, 'vgnt');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `sno` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roll_num` varchar(50) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `sem_start` date DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`sno`, `email`, `password`, `roll_num`, `Name`, `sem_start`, `year`) VALUES
(1, 'pranavbairy2@gmail.com', '$2y$10$3RYb9Ou9uwFLxKs97Pf78.PcxEtkZypyRBrD4R7q7iNHXX0kWXB6e', '23891A0549', 'Pranav', '2025-01-10', 2),
(2, 'ushashankvarma12@gmail.com', '$2y$10$8PGzQuh4kawHp4pISPxb/..BcVB3hNqNHaskWKnvo/Aw.IblsTcQW', '23891A0558', 'Shashank', '2025-01-10', 2),
(3, 'deveshrayudu@gmail.com', '$2y$10$BaQA7IcleWjTAYlb0bJh..PU.c4TNlOhBoExY4/34Looqjoiz4kD.', '23891A0512', 'Devesh', '2025-01-10', 2),
(4, 'aakashjarubula117@gmail.com', '$2y$10$R/DaIMCplqrJ4w14Pps5l.ruKHJoy7wiXagVOFb3/NhBrrmlb04r.', '23891A0522', 'Aakash', '2025-01-10', 2),
(5, 'pallechandureddy1@gmail.com', '$2y$10$SJ53jfzzhIik6TufwHFwsOSE/RJ4GrwPjrhCnuEhYfGGXB/SH87XG', '23891A0540', 'Chandu', '2025-01-10', 2);

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `set_sem_start` BEFORE INSERT ON `students` FOR EACH ROW BEGIN
    SET NEW.sem_start = CASE NEW.year
                          WHEN 1 THEN '2025-02-01'
                          WHEN 2 THEN '2025-01-10'
                          WHEN 3 THEN '2025-01-27'
                          WHEN 4 THEN '2025-02-01'
                          ELSE NULL
                        END;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `roll_num` varchar(255) DEFAULT NULL,
  `attendance` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`roll_num`, `attendance`) VALUES
('23891A0549', 78.75),
('23891A0558', 81.94),
('23891A0512', 78.5),
('23891A0522', 88),
('23891A0540', 95.5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty_login`
--
ALTER TABLE `faculty_login`
  ADD PRIMARY KEY (`sno`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`sno`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `roll_num` (`roll_num`),
  ADD UNIQUE KEY `roll_num_2` (`roll_num`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD KEY `fk_roll_num` (`roll_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty_login`
--
ALTER TABLE `faculty_login`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `fk_roll_num` FOREIGN KEY (`roll_num`) REFERENCES `students` (`roll_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
