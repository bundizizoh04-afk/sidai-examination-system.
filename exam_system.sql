-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2026 at 12:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `examinations`
--

CREATE TABLE `examinations` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `term` varchar(20) NOT NULL,
  `year` int(11) NOT NULL,
  `exam_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinations`
--

INSERT INTO `examinations` (`id`, `exam_name`, `term`, `year`, `exam_date`) VALUES
(1, 'End of Term Exam', 'Term 1', 2026, '2026-06-25');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `student_id`, `exam_id`, `registration_date`) VALUES
(1, 1, 1, '2026-06-25 17:46:45'),
(2, 2, 1, '2026-06-25 21:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `marks` int(11) NOT NULL,
  `grade` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `exam_id`, `subject`, `marks`, `grade`) VALUES
(1, 1, 1, 'English', 78, 'B'),
(2, 1, 1, 'Kiswahili', 80, 'A'),
(3, 1, 1, 'Mathematics', 90, 'A'),
(4, 1, 1, 'Integrated Science', 87, 'A'),
(5, 1, 1, 'Social Studies', 75, 'B'),
(6, 1, 1, 'Pre-Technical Studies', 67, 'C'),
(7, 1, 1, 'Agriculture', 95, 'A'),
(8, 1, 1, 'Business Studies', 70, 'B'),
(9, 1, 1, 'Religious Education', 85, 'A'),
(10, 1, 1, 'Creative Arts and Sports', 76, 'B'),
(11, 1, 1, 'Computer Science', 76, 'B'),
(12, 1, 1, 'French', 60, 'C'),
(13, 1, 1, 'German', 58, 'D'),
(14, 1, 1, 'Arabic', 32, 'F'),
(15, 1, 1, 'Home Science', 60, 'C'),
(16, 2, 1, 'English', 80, 'A'),
(17, 2, 1, 'Kiswahili', 75, 'B'),
(18, 2, 1, 'Mathematics', 95, 'A'),
(19, 2, 1, 'Integrated Science', 87, 'A'),
(20, 2, 1, 'Social Studies', 75, 'B'),
(21, 2, 1, 'Agriculture', 90, 'A'),
(22, 2, 1, 'Business Studies', 65, 'C'),
(23, 2, 1, 'Religious Education', 98, 'A'),
(24, 2, 1, 'Creative Arts and Sports', 78, 'B'),
(25, 2, 1, 'Computer Science', 89, 'A'),
(26, 2, 1, 'French', 70, 'B'),
(27, 2, 1, 'Home Science', 93, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `admission_no` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `class` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `admission_no`, `full_name`, `gender`, `class`) VALUES
(1, '4362', 'Zizo Bm', 'Male', 'Grade 8'),
(2, '4362', 'joe bare', 'Female', 'Grade 8');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`) VALUES
(1, 'English'),
(2, 'Kiswahili'),
(3, 'Mathematics'),
(4, 'Integrated Science'),
(5, 'Social Studies'),
(7, 'Agriculture'),
(8, 'Business Studies'),
(9, 'Religious Education'),
(10, 'Creative Arts and Sports'),
(11, 'Computer Science'),
(12, 'French'),
(15, 'Home Science');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `examinations`
--
ALTER TABLE `examinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `examinations`
--
ALTER TABLE `examinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
