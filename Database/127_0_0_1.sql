-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2020 at 11:29 AM
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

--
-- Dumping data for table `active_exams`
--

INSERT INTO `active_exams` (`id`, `title`, `date`, `time`, `duration`, `purpose`, `total_question`, `total_marks`, `exam_key`, `negative_marking`, `questions`, `examiner_id`, `status`) VALUES
(4, 'demo 1', '2020-06-05', '09:34:00', '00:05:00', 'testing', 2, 10, 'testing', 'no', 'id4id5', 1, 0),
(5, 'demo 1', '2020-06-05', '10:22:00', '00:05:00', 'demo 1', 2, 10, 'testing', 'no', 'id5id7', 1, 0);

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

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `answer_text`, `question_id`, `category`, `status`) VALUES
(10, 'no', 4, 3, 0),
(11, 'yes', 4, 3, 0),
(12, 'HyperText Markup Language', 5, 3, 0),
(13, 'Hyper Makup Language', 5, 3, 0),
(14, 'onabort', 6, 3, 0),
(15, 'abort', 6, 3, 0),
(16, 'ononline', 7, 3, 0),
(17, 'onmessage', 7, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_detail`
--

CREATE TABLE `candidate_detail` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `hsc` varchar(100) NOT NULL,
  `ssc` varchar(100) NOT NULL,
  `higherstudies` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate_detail`
--

INSERT INTO `candidate_detail` (`id`, `candidate_id`, `name`, `hsc`, `ssc`, `higherstudies`) VALUES
(3, 1, 'YUVRAJ HINGER', '70%', '53%', '72%');

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
(6, '16egics123', '16egics123', 0),
(7, '16egics122', '16egics122', 0),
(8, '16egics121', '16egics121', 0);

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

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `examiner_id`, `status`) VALUES
(3, 'HTML5', 1, 0),
(4, 'Apptitude', 1, 0),
(5, 'C', 1, 0);

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
(1, 'admin', 'admin', 0),
(4, '123', '123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_applicant`
--

CREATE TABLE `exam_applicant` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_applicant`
--

INSERT INTO `exam_applicant` (`id`, `exam_id`, `applicant_id`) VALUES
(7, 4, 6),
(8, 5, 1);

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

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `question_text`, `answer_id`, `category`, `status`) VALUES
(4, ' Are HTML tags case sensitive?', 10, 3, 0),
(5, 'HTML Stands For ?', 12, 3, 0),
(6, '?Which of the following attribute triggers an abort event?', 14, 3, 0),
(7, 'Which of the following attribute triggers event when the document comes online?', 16, 3, 0);

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
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `exam_id`, `applicant_id`, `report`, `time_remaining`) VALUES
(5, 4, 6, '[{\"qid\": \"4\",\"aid\": \"10\"},{\"qid\": \"5\",\"aid\": \"13\"}]', 'Time Remaining:  00:04:45'),
(6, 5, 1, '[{\"qid\": \"5\",\"aid\": \"12\"},{\"qid\": \"7\",\"aid\": \"17\"}]', 'Time Remaining:  00:04:26');

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
-- Indexes for table `candidate_detail`
--
ALTER TABLE `candidate_detail`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `candidate_detail`
--
ALTER TABLE `candidate_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidate_login`
--
ALTER TABLE `candidate_login`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `examiner_login`
--
ALTER TABLE `examiner_login`
  MODIFY `examiner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_applicant`
--
ALTER TABLE `exam_applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
