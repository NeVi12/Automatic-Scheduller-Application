-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 08:21 AM
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
-- Database: `automatic_tt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `password`) VALUES
(0, 'Admin', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$NnNJZ01sUS82d1QzRm1RSw$7EqgZTbsdfhcpC/QJ+nW515GVay4LEi8vmQsEL4PSoY');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `dep_id`) VALUES
(1, 'Accounting and Finance', 1),
(2, 'Human Resource Management', 1),
(3, 'Marketing Management', 1),
(4, 'Operations Management', 1),
(5, 'Supply Chain Management ', 1),
(6, 'Cloud Computing', 2),
(7, 'Cyber Security', 2),
(8, 'Data Science', 2),
(9, 'Software Engineering', 2),
(10, 'Civil Engineering', 3),
(11, 'Electronics and Engineering Management', 3),
(12, 'Electronics and Power Systems', 3),
(13, 'Electronics and Telecommunications', 3),
(14, 'Information and Communication Engineering', 3),
(15, 'Mechatronics Engineering', 3),
(16, 'Biosystems Engineering', 4),
(17, 'E-Tourism and Digital Marketing', 4),
(18, 'Fashion Merchandise Management', 4),
(19, 'Textile and Clothing Technology', 4),
(20, 'Travel And Tourism Management/Honours', 4),
(21, 'Agricultural Technology', 5),
(22, 'BTech Electronics', 5),
(23, 'Environmental Technology', 5);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dep_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dep_id`, `department_name`) VALUES
(1, 'Faculty of Business Management'),
(2, 'Faculty of Computing & IT'),
(3, 'Faculty of Engineering'),
(4, 'Faculty of Science'),
(5, 'Faculty of Technology');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `lec_id` int(11) NOT NULL,
  `lecturer_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lec_id`, `lecturer_name`, `email`, `dep_id`) VALUES
(4, 'Gayathri Ananthanara', 'gayathri@iitdh.ac.in', 1),
(5, 'Gopal Sharan Parash', 'gp@iitdh.ac.in', 2),
(6, 'Kedar Khandeparkar', 'kedark@iitdh.ac.in', 3),
(7, 'Mahadeva Prasanna', 'prasanna@iitdh.ac.in', 4),
(8, 'N.L.Sarda', 'rnls@iitdh.ac.in', 5),
(9, 'Prabuchandran K J', 'prabukj@iitdh.ac.in', 1),
(10, 'Prof. G. Nagaraja', 'prof.gn@iitdh.ac.in', 2),
(11, 'Rajshekar K', 'rajshekar.k@iitdh.ac.in', 3),
(12, 'Ramchandra Phawade', 'prb@iitdh.ac.in', 4),
(13, 'Sagnik Sen', 'sen@iitdh.ac.in', 5),
(14, 'Sandeep R.B', 'sandeeprb@iitdh.ac.in', 1),
(15, 'Siba Narayan Swain', 'sibaswain@iitdh.ac.in', 2),
(16, 'Sudhanshu Shukla', 'sudhanshu@iitdh.ac.in', 3),
(17, 'Sudheendra Hangal', 'hangal@iitdh.ac.in', 4);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `capacity`) VALUES
(1, 'FF3', 100),
(2, 'FF2', 100),
(3, 'FF1', 100),
(4, 'FF4', 100),
(5, ' L-05.1', 100),
(6, ' L-04.1', 100),
(7, ' L-02.1', 100),
(8, 'Comman Area 1', 150),
(9, 'Comman Area 2', 100);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `lec_id` int(10) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `course_id`, `lec_id`, `dep_id`) VALUES
(1, 'Cloud Security and Privacy', 7, 5, 2),
(2, 'Discrete Mathematics', 7, 10, 2),
(3, 'Cyber Security Domains and Tools', 7, 15, 2),
(4, 'Natural Language Processing', 9, 10, 2),
(5, 'Software Quality Assurance', 6, 15, 2),
(6, 'Human Factors in Computer Systems', 6, 5, 2),
(7, 'Software Engineering Methods', 9, 10, 2),
(8, 'Biochemistry', 16, 17, 4),
(9, 'Bioinstrumentation and control', 16, 12, 4),
(10, 'Bioenergy systems', 16, 7, 4),
(11, 'Engineering Mathematics', 12, 6, 3),
(12, 'Advanced Calculus-Multi variable integration', 12, 11, 3),
(13, 'Industrial Law', 12, 16, 3),
(14, 'Management Principles', 2, 4, 1),
(15, 'Labour Economics', 2, 9, 1),
(16, 'HR Accounting', 2, 14, 1),
(17, 'Animal Science', 21, 8, 5),
(18, 'Agricultural Machinery and Power Management', 21, 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `timetable_id` int(11) NOT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `lec_id` int(11) DEFAULT NULL,
  `time_id` int(11) DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`timetable_id`, `dep_id`, `course_id`, `room_id`, `subject_id`, `lec_id`, `time_id`, `day_of_week`) VALUES
(576, 2, 7, 1, 1, 5, 2, 'Tuesday'),
(577, 2, 7, 1, 2, 10, 4, 'Wednesday'),
(578, 2, 7, 1, 3, 15, 5, 'Thursday'),
(579, 2, 9, 2, 4, 10, 2, 'Thursday'),
(580, 2, 6, 1, 5, 15, 3, 'Tuesday'),
(581, 2, 6, 2, 6, 5, 3, 'Wednesday'),
(582, 2, 9, 1, 7, 10, 1, 'Monday'),
(583, 4, 16, 1, 8, 17, 6, 'Tuesday'),
(584, 4, 16, 1, 9, 12, 7, 'Tuesday'),
(585, 4, 16, 2, 10, 7, 7, 'Wednesday'),
(586, 3, 12, 2, 11, 6, 1, 'Tuesday'),
(587, 3, 12, 2, 12, 11, 5, 'Tuesday'),
(588, 3, 12, 3, 13, 16, 2, 'Monday'),
(589, 1, 2, 4, 14, 4, 2, 'Monday'),
(590, 1, 2, 2, 15, 9, 4, 'Wednesday'),
(591, 1, 2, 3, 16, 14, 3, 'Friday'),
(592, 5, 21, 4, 17, 8, 3, 'Thursday'),
(593, 5, 21, 3, 18, 13, 4, 'Thursday');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `time_id` int(11) NOT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`time_id`, `time_slot`, `start_time`, `end_time`) VALUES
(1, 'Slot 1', '08:00:00', '09:00:00'),
(2, 'Slot 2', '09:00:00', '10:00:00'),
(3, 'Slot 3', '10:00:00', '12:00:00'),
(4, 'Slot 4', '12:00:00', '13:00:00'),
(5, 'Slot 5', '13:00:00', '15:00:00'),
(6, 'Slot 6', '15:00:00', '16:00:00'),
(7, 'Slot 7', '16:00:00', '17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lec_id`),
  ADD KEY `dep_id` (`dep_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `dep_id` (`dep_id`),
  ADD KEY `subject_lec_fk` (`lec_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`timetable_id`),
  ADD KEY `dep_id` (`dep_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `lecturer_id` (`lec_id`),
  ADD KEY `time_id` (`time_id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`time_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `lec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=594;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`);

--
-- Constraints for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturers_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subject_lec_fk` FOREIGN KEY (`lec_id`) REFERENCES `lecturers` (`lec_id`),
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`);

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`),
  ADD CONSTRAINT `timetable_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `timetable_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `timetable_ibfk_4` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `timetable_ibfk_5` FOREIGN KEY (`lec_id`) REFERENCES `lecturers` (`lec_id`),
  ADD CONSTRAINT `timetable_ibfk_6` FOREIGN KEY (`time_id`) REFERENCES `time_slots` (`time_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
