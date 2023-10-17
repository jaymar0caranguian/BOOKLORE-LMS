-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2023 at 11:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lib_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `book_title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `author_name`, `book_title`) VALUES
(6, 'Chimamanda Ngozi Adichie', NULL),
(7, 'Haruki Murakami', NULL),
(8, 'Michelle Obama', NULL),
(9, 'Stephen Hawking', NULL),
(10, 'Toni Morrison', NULL),
(11, 'Jane Austen', NULL),
(12, 'Fyodor Dostoevsky', NULL),
(13, 'Charlotte Bronte', NULL),
(14, 'Kristin Hannah', NULL),
(15, 'John Boyne', NULL),
(23, 'Evelyn Rivers', NULL),
(24, 'Rick Riordan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `isbn` char(20) DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `image`, `qty`, `isbn`, `book_title`, `tag_id`, `author_id`, `publisher_id`) VALUES
(12, '../uploads/americanah-1.jpg', 1, '978-0307271082', 'Americanah', 12, 6, 9),
(13, '../uploads/becoming.jpg', 2, '978-1524763138', 'Becoming', 13, 8, 10),
(14, '../uploads/1q84-6.jpg', 1, '978-0307593313', '1Q84', 12, 7, 9),
(15, '../uploads/history-time.jpg', 3, '978-0553380163', 'A Brief History of Time', 14, 9, 11),
(16, '../uploads/beloved.jpg', 1, '978-1400033416', 'Beloved', 12, 10, 12),
(17, '../uploads/pride-and-prejudice-71.jpg', 1, '978-0141439518', 'Pride and Prejudice', 15, 11, 13),
(18, '../uploads/crime-and-punishment-by-fyodor-dostoevsky-1.jpg', 1, '978-0140449136', 'Crime and Punishment', 15, 12, 13),
(19, '../uploads/jane-eyre-annotated.jpg', 2, '978-0141441146', 'Jane Eyre', 15, 13, 13),
(20, '../uploads/st.jpg', 1, '978-0312577223', 'The Nightingale', 16, 14, 14),
(21, '../uploads/heart.jpg', 3, '978-1524760786', 'The Hearts Invisible Furies', 16, 15, 15),
(24, '../uploads/sense.jpg', 1, '978-0141439662', 'Sense and Sensibility', 15, 11, 13),
(27, '../uploads/ena.jpg', 2, '978-1-234567-89-0', 'The Last Enchantment', 20, 23, 20),
(28, '../uploads/kafka.jpg', 2, '978-1-846-55237-2', 'Kafka on the Shore', 22, 7, 23);

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `publisher_name` varchar(100) NOT NULL,
  `book_title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `publisher_name`, `book_title`) VALUES
(9, 'Knopf', NULL),
(10, 'Crown Publishing Group', NULL),
(11, 'Bantam Books', NULL),
(12, 'Alfred A Knopf', NULL),
(13, 'Penguin Classics', NULL),
(14, 'St Martins Press', NULL),
(15, 'Hogarth Press', NULL),
(16, 'Crown Publishers', NULL),
(20, 'Celestial Books', NULL),
(21, 'Disney Hyperion', NULL),
(23, 'Vintage International', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  `book_title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `tag_name`, `book_title`) VALUES
(12, 'Fiction', NULL),
(13, 'Memoir', NULL),
(14, 'Science', NULL),
(15, 'Classic Literature', NULL),
(16, 'Historical Fiction', NULL),
(20, 'Fantasy', NULL),
(21, 'Non Fiction', NULL),
(22, 'Magical Realism', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `id` int(11) NOT NULL,
  `coursename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `coursename`) VALUES
(11, 'BSA'),
(12, 'BS Entrep'),
(13, 'BECEd'),
(14, 'BSIE'),
(16, 'BSIT'),
(17, 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_issued`
--

CREATE TABLE `tbl_issued` (
  `id` int(11) NOT NULL,
  `book_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date NOT NULL,
  `actual_return_date` date DEFAULT NULL,
  `fine` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_issued`
--

INSERT INTO `tbl_issued` (`id`, `book_code`, `user_id`, `issue_date`, `return_date`, `actual_return_date`, `fine`) VALUES
(37, 12, 303, '2023-04-27', '2023-05-01', '2023-05-02', 5.00),
(42, 19, 312, '2023-05-04', '2023-05-06', '2023-05-06', 0.00),
(43, 14, 308, '2023-05-01', '2023-05-03', '2023-05-06', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `u_img` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `roles` enum('student','librarian','faculty','super admin') DEFAULT NULL,
  `addresss` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `u_img`, `full_name`, `email`, `password`, `course_id`, `year_id`, `roles`, `addresss`, `phone`) VALUES
(304, '../uploads/art.jpg', 'Ivy Bayonon', 'ivybayonon@gmail.com', '724cf49b52e43f48505c6a99699c59b5428d9353', 17, 19, 'super admin', 'Quezon City', '09123456789'),
(308, '../uploads/cha.jpg', 'Chasty Caacoy', 'chastycaacoy@gmail.com', 'ababccb788ff5e89361613d19749476d44862db7', 17, 19, 'faculty', 'Manila City', '09123556789'),
(309, '../uploads/jan.jpg', 'Janzel Suagen', 'janzelsuagen@gmail.com', 'ae4aac590698611fd153e5159f15ea9a25438651', 17, 19, 'librarian', 'Marikina City', '09157133489'),
(312, '../uploads/angelize.jpg', 'Angelize Escario', 'angelizeescario@gmail.com', '7f520987094285e1db00e310c7ab69605f47b47a', 16, 16, 'student', 'Davao', '09923456789');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_years`
--

CREATE TABLE `tbl_years` (
  `id` int(11) NOT NULL,
  `yearsname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_years`
--

INSERT INTO `tbl_years` (`id`, `yearsname`) VALUES
(15, '1st Year'),
(16, '2nd Year'),
(17, '3rd Year'),
(18, '4th Year'),
(19, 'N/A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_issued`
--
ALTER TABLE `tbl_issued`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `year_id` (`year_id`);

--
-- Indexes for table `tbl_years`
--
ALTER TABLE `tbl_years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_issued`
--
ALTER TABLE `tbl_issued`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `tbl_years`
--
ALTER TABLE `tbl_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`);

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`id`),
  ADD CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`year_id`) REFERENCES `tbl_years` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
