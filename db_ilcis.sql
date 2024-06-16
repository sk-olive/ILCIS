-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 05:13 PM
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
-- Database: `db_ilcis`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointments`
--

CREATE TABLE `tbl_appointments` (
  `appointment_id` int(11) NOT NULL,
  `appointment_contact_person` varchar(256) NOT NULL,
  `appointment_position` varchar(256) NOT NULL,
  `appointment_company_name` varchar(256) NOT NULL,
  `appointment_company_address` text NOT NULL,
  `appointment_phone_number` varchar(200) NOT NULL,
  `appointment_email` varchar(256) NOT NULL,
  `appointment_status` enum('Pending','Approved','Cancelled','Did not attend','Postponed') NOT NULL DEFAULT 'Pending',
  `appointment_date_time` datetime NOT NULL,
  `appointment_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_appointments`
--

INSERT INTO `tbl_appointments` (`appointment_id`, `appointment_contact_person`, `appointment_position`, `appointment_company_name`, `appointment_company_address`, `appointment_phone_number`, `appointment_email`, `appointment_status`, `appointment_date_time`, `appointment_message`) VALUES
(11, 'Joshua Clutario', 'Software Engineer', 'PLDT', 'Makati General Office', '09638721664', 'joshua.pentecostes.clutario@gmail.com', 'Did not attend', '2024-05-28 12:11:00', 'test'),
(12, 'Monte', 'Asawa ni Joshua', 'Angkan ni Angge at Joshua', 'Dasmariñas, Cavite', '09123456789', 'joshua.clutario@cvsu.com', 'Approved', '2024-05-27 12:43:00', 'fghdfggsd');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chats`
--

CREATE TABLE `tbl_chats` (
  `chat_id` int(11) NOT NULL,
  `chat_from` int(11) NOT NULL,
  `chat_to` int(11) NOT NULL,
  `chat_message` text DEFAULT NULL,
  `chat_attachments` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chats`
--

INSERT INTO `tbl_chats` (`chat_id`, `chat_from`, `chat_to`, `chat_message`, `chat_attachments`) VALUES
(47, 41, 10, 'test', NULL),
(48, 41, 10, 'test', NULL),
(49, 41, 10, 'test', NULL),
(50, 41, 10, 'test', NULL),
(51, 41, 10, 'test', NULL),
(52, 41, 10, 'asdsadasdasd', NULL),
(53, 41, 10, 'sadasddas', NULL),
(54, 41, 10, 'asdasdsadsda', NULL),
(55, 41, 10, 'sda', NULL),
(56, 41, 10, 'asd', NULL),
(57, 41, 10, 'das', NULL),
(58, 10, 41, 'sdaasddasasd', NULL),
(59, 41, 10, 'asdasd', NULL),
(60, 41, 10, '', 'uploads/attachments/6653da173d4eb.png'),
(61, 10, 41, 'asd', NULL),
(62, 10, 41, 'test', 'uploads/attachments/6653da2ed5710.png'),
(63, 10, 41, 'test', NULL),
(64, 10, 41, '', 'uploads/attachments/6653dac044a0d.png'),
(65, 41, 10, 'test', NULL),
(66, 37, 10, 'asdasdadssda', NULL),
(67, 37, 10, '', 'uploads/attachments/6653daf5a12f7.png'),
(68, 10, 37, 'asdsadasddasdasdasasd', NULL),
(69, 37, 10, 'asdadsadsdas', NULL),
(70, 10, 37, 'k', NULL),
(71, 37, 10, 'kl', NULL),
(72, 37, 10, 'aad', NULL),
(73, 42, 10, 'test', NULL),
(74, 42, 10, '', 'uploads/attachments/6654070e470e4.jpg'),
(75, 43, 10, 'test', NULL),
(76, 43, 10, '', 'uploads/attachments/665408781ba33.docx'),
(77, 45, 10, '', 'uploads/attachments/6654119ac680e.jpg'),
(78, 10, 42, 'noice', NULL),
(79, 10, 42, '', 'uploads/attachments/66541229a8275.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_confidential_documents`
--

CREATE TABLE `tbl_confidential_documents` (
  `document_id` int(11) NOT NULL,
  `document_type` varchar(200) NOT NULL,
  `document_file` text NOT NULL,
  `document_status` enum('Processing','Approved','Denied') NOT NULL DEFAULT 'Processing',
  `document_company` varchar(200) NOT NULL,
  `document_uploaded_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_confidential_documents`
--

INSERT INTO `tbl_confidential_documents` (`document_id`, `document_type`, `document_file`, `document_status`, `document_company`, `document_uploaded_by`) VALUES
(1, 'General Format', 'uploads/files/6654084b5af58.docx', 'Approved', 'PLDT', 43);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content`
--

CREATE TABLE `tbl_content` (
  `content_id` int(11) NOT NULL,
  `content_author` text NOT NULL,
  `content_title` text NOT NULL,
  `content_content` text NOT NULL,
  `content_date` datetime NOT NULL,
  `content_type` enum('announcement','events','news') NOT NULL,
  `content_status` enum('published','unpublished','for approval') NOT NULL,
  `content_photo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_content`
--

INSERT INTO `tbl_content` (`content_id`, `content_author`, `content_title`, `content_content`, `content_date`, `content_type`, `content_status`, `content_photo`) VALUES
(50, 'Angkan ni Angge at Joshua', 'tjhrthdh', '<p>hvfjlkugtuikgoiyh</p>', '2024-05-27 14:12:55', 'events', 'unpublished', 'uploads//665412aaab4df.png'),
(52, 'PLDT', 'bddbdjdh', '<p>rjr3uejrj</p>', '2024-05-27 13:47:29', 'events', 'published', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_experts`
--

CREATE TABLE `tbl_experts` (
  `expert_id` int(11) NOT NULL,
  `expert_name` varchar(256) NOT NULL,
  `expert_department` varchar(256) NOT NULL,
  `expert_position` text NOT NULL,
  `expert_contact` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_experts`
--

INSERT INTO `tbl_experts` (`expert_id`, `expert_name`, `expert_department`, `expert_position`, `expert_contact`) VALUES
(2, 'Joshua Clutario', 'Campus Secretary', 'test', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forgot_password`
--

CREATE TABLE `tbl_forgot_password` (
  `forgot_id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inquiry`
--

CREATE TABLE `tbl_inquiry` (
  `inquiry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inquiry_subject` varchar(256) NOT NULL,
  `inquiry_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inquiry`
--

INSERT INTO `tbl_inquiry` (`inquiry_id`, `user_id`, `inquiry_subject`, `inquiry_message`) VALUES
(13, 44, 'trhfghfhdhdf', 'trhfghfhdhdf'),
(14, 45, 'fghsdgytsrg', 'fdgbhfsbgsrgsrh');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inquiry1`
--

CREATE TABLE `tbl_inquiry1` (
  `inquiry_id` int(11) NOT NULL,
  `inquiry_name` varchar(256) NOT NULL,
  `inquiry_email` varchar(256) NOT NULL,
  `inquiry_subject` text NOT NULL,
  `inquiry_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_institutional_membership`
--

CREATE TABLE `tbl_institutional_membership` (
  `institutional_membership_id` int(11) NOT NULL,
  `institutional_membership_name` varchar(256) NOT NULL,
  `institutional_membership_photo` text NOT NULL,
  `institutional_membership_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_linkages`
--

CREATE TABLE `tbl_linkages` (
  `linkage_id` int(11) NOT NULL,
  `linkage_name` varchar(256) NOT NULL,
  `linkage_photo` text NOT NULL,
  `linkage_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ojt_partners`
--

CREATE TABLE `tbl_ojt_partners` (
  `ojt_id` int(11) NOT NULL,
  `ojt_name` varchar(256) NOT NULL,
  `ojt_photo` text NOT NULL,
  `ojt_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_partners`
--

CREATE TABLE `tbl_partners` (
  `partner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `partner_name` varchar(256) NOT NULL,
  `partner_address` text NOT NULL,
  `partner_contact` varchar(256) DEFAULT NULL,
  `partner_position` varchar(256) DEFAULT NULL,
  `partner_telephone` varchar(256) DEFAULT NULL,
  `partner_photo` text NOT NULL DEFAULT '/public/assets/images/user.png',
  `partner_person` varchar(256) DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_partners`
--

INSERT INTO `tbl_partners` (`partner_id`, `user_id`, `partner_name`, `partner_address`, `partner_contact`, `partner_position`, `partner_telephone`, `partner_photo`, `partner_person`) VALUES
(19, 43, 'PLDT', 'Makati General Office', '09638721664', 'Software Engineer', '096-3872-1664', '/public/assets/images/user.png', 'Joshua Clutario'),
(20, 45, 'Angkan ni Angge at Joshua', 'Dasmariñas, Cavite', '09123456789', 'Asawa ni Joshua', '', '/public/assets/images/user.png', 'Monte'),
(21, 46, 'PCU', 'Dasmariñas, Cavite', '09638721664', 'Developer', '', '/public/assets/images/user.png', 'Johniel Rigor Diaz');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_fname` varchar(256) NOT NULL,
  `student_lname` varchar(256) NOT NULL,
  `student_number` varchar(256) NOT NULL,
  `student_birthday` date NOT NULL,
  `student_gender` enum('Male','Female') NOT NULL,
  `student_course` enum('BS in Information Technology','BS Business Administration Major in Marketing Management','BS Hospitality Management','BS Psychology','Bachelor of Science in Office Administration','Bachelor of Secondary Education Major in English') NOT NULL,
  `student_photo` text NOT NULL DEFAULT '/public/assets/images/user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `user_id`, `student_fname`, `student_lname`, `student_number`, `student_birthday`, `student_gender`, `student_course`, `student_photo`) VALUES
(23, 42, 'Joshua', 'Clutario', '2020-100-432', '1999-10-06', 'Male', 'BS in Information Technology', 'uploads/students/665406f29184a.jpg'),
(24, 44, 'joshua', 'calingo', '2020-100-432', '2024-05-27', 'Male', 'BS in Information Technology', '/public/assets/images/user.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('admin','student','partner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_email`, `user_password`, `user_role`) VALUES
(10, 'admin@admin.com', '$2a$12$evIU2480aqVI4FHFU9U1SuxkoudbwBkgB0ldavletfV315O7WRAhO', 'admin'),
(42, 'joshua.clutario@cvsu.edu.ph', '$2y$10$6ylUih6uRn9keDsW1EMbQe2HWTZgFB0LiF87ReqtfPocQ/NDrWBKe', 'student'),
(43, 'joshua.pentecostes.clutario@gmail.com', '$2y$10$qzdEDU/D74Pd2jNv2ROnyOWajHQzU0tR4Pm35rQldpPlKCzDJ9xrS', 'partner'),
(44, 'angelica.clutario@gmail.com', '$2y$10$Q0ZsZRDnTETDrbzdxNNUsu/6lY/fND6ucj5txXRbH4Wtrr4wQjreK', 'student'),
(45, 'joshua.clutario@cvsu.com', '$2y$10$c.Y17ZkJ0iGkwOfKuZt31ePIwDr1c7jppEfdG8NONVt/EZ.waNFPC', 'partner'),
(46, 'johnielrigordiaz@gmail.com', '$2y$10$INGOybHatS1plN1RQpLt9OgwnzfJ4CGt7/mVXuO5YTxGHVkM4tydS', 'partner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `tbl_chats`
--
ALTER TABLE `tbl_chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `tbl_confidential_documents`
--
ALTER TABLE `tbl_confidential_documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `tbl_content`
--
ALTER TABLE `tbl_content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `tbl_experts`
--
ALTER TABLE `tbl_experts`
  ADD PRIMARY KEY (`expert_id`);

--
-- Indexes for table `tbl_forgot_password`
--
ALTER TABLE `tbl_forgot_password`
  ADD PRIMARY KEY (`forgot_id`);

--
-- Indexes for table `tbl_inquiry`
--
ALTER TABLE `tbl_inquiry`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `FK_tbl_inquiry` (`user_id`);

--
-- Indexes for table `tbl_inquiry1`
--
ALTER TABLE `tbl_inquiry1`
  ADD PRIMARY KEY (`inquiry_id`);

--
-- Indexes for table `tbl_institutional_membership`
--
ALTER TABLE `tbl_institutional_membership`
  ADD PRIMARY KEY (`institutional_membership_id`);

--
-- Indexes for table `tbl_linkages`
--
ALTER TABLE `tbl_linkages`
  ADD PRIMARY KEY (`linkage_id`);

--
-- Indexes for table `tbl_ojt_partners`
--
ALTER TABLE `tbl_ojt_partners`
  ADD PRIMARY KEY (`ojt_id`);

--
-- Indexes for table `tbl_partners`
--
ALTER TABLE `tbl_partners`
  ADD PRIMARY KEY (`partner_id`),
  ADD KEY `FK_tbl_partners_1` (`user_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `FK_tbl_students_1` (`user_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_chats`
--
ALTER TABLE `tbl_chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tbl_confidential_documents`
--
ALTER TABLE `tbl_confidential_documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_content`
--
ALTER TABLE `tbl_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tbl_experts`
--
ALTER TABLE `tbl_experts`
  MODIFY `expert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_forgot_password`
--
ALTER TABLE `tbl_forgot_password`
  MODIFY `forgot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_inquiry`
--
ALTER TABLE `tbl_inquiry`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_inquiry1`
--
ALTER TABLE `tbl_inquiry1`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_institutional_membership`
--
ALTER TABLE `tbl_institutional_membership`
  MODIFY `institutional_membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_linkages`
--
ALTER TABLE `tbl_linkages`
  MODIFY `linkage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_ojt_partners`
--
ALTER TABLE `tbl_ojt_partners`
  MODIFY `ojt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_partners`
--
ALTER TABLE `tbl_partners`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_inquiry`
--
ALTER TABLE `tbl_inquiry`
  ADD CONSTRAINT `FK_tbl_inquiry` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);

--
-- Constraints for table `tbl_partners`
--
ALTER TABLE `tbl_partners`
  ADD CONSTRAINT `FK_tbl_partners_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);

--
-- Constraints for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `FK_tbl_students_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
