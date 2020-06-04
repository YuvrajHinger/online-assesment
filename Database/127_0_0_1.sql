-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2020 at 10:26 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `major_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_exams`
--

CREATE TABLE `active_exams` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `duration` time NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `total_question` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `exam_key` varchar(100) NOT NULL,
  `negative_marking` varchar(100) NOT NULL,
  `questions` varchar(200) NOT NULL,
  `examiner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `answer_text` varchar(200) NOT NULL,
  `question_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_login`
--

CREATE TABLE `candidate_login` (
  `candidate_id` int(11) NOT NULL,
  `candidate_username` varchar(250) NOT NULL,
  `candidate_password` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidate_login`
--

INSERT INTO `candidate_login` (`candidate_id`, `candidate_username`, `candidate_password`, `status`) VALUES
(1, 'user', 'user', 0),
(2, 'user1', 'pass1', 0),
(3, '123', '123', 0),
(4, '122', '122', 0),
(5, '121', '121', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `examiner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examiner_login`
--

CREATE TABLE `examiner_login` (
  `examiner_id` int(11) NOT NULL,
  `examiner_username` varchar(200) NOT NULL,
  `examiner_password` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examiner_login`
--

INSERT INTO `examiner_login` (`examiner_id`, `examiner_username`, `examiner_password`, `status`) VALUES
(1, 'admin', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_applicant`
--

CREATE TABLE `exam_applicant` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `question_text` varchar(200) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `report` varchar(2000) NOT NULL,
  `time_remaining` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_exams`
--
ALTER TABLE `active_exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `candidate_login`
--
ALTER TABLE `candidate_login`
  ADD PRIMARY KEY (`candidate_id`),
  ADD UNIQUE KEY `candidate_username` (`candidate_username`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `examiner_login`
--
ALTER TABLE `examiner_login`
  ADD PRIMARY KEY (`examiner_id`),
  ADD UNIQUE KEY `examiner_username` (`examiner_username`);

--
-- Indexes for table `exam_applicant`
--
ALTER TABLE `exam_applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_exams`
--
ALTER TABLE `active_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_login`
--
ALTER TABLE `candidate_login`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examiner_login`
--
ALTER TABLE `examiner_login`
  MODIFY `examiner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_applicant`
--
ALTER TABLE `exam_applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
