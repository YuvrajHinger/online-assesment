-- CREATE DATABASE major_project;

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
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `answer_text` varchar(200) NOT NULL,
  `question_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `candidate_login` (
  `candidate_id` int(11) NOT NULL,
  `candidate_username` varchar(250) NOT NULL,
  `candidate_password` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `examiner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `examiner_login` (
  `examiner_id` int(11) NOT NULL,
  `examiner_username` varchar(200) NOT NULL,
  `examiner_password` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `exam_applicant` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `question_text` varchar(200) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `report` varchar(2000) NOT NULL,
  `time_remaining` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `active_exams`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`);

ALTER TABLE `candidate_login`
  ADD PRIMARY KEY (`candidate_id`),
  ADD UNIQUE KEY `candidate_username` (`candidate_username`);

ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

ALTER TABLE `examiner_login`
  ADD PRIMARY KEY (`examiner_id`),
  ADD UNIQUE KEY `examiner_username` (`examiner_username`);

ALTER TABLE `exam_applicant`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `active_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `candidate_login`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `examiner_login`
  MODIFY `examiner_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `exam_applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

