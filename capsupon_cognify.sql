-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2026 at 11:50 PM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capsupon_cognify`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `full_name`, `username`, `password_hash`) VALUES
(1, 'System Administrator', 'admin', '$2y$12$VtAcd/FYpAJUvYoS5ZP9VeY.NM1s2vTUifBOmK/CFK9jiwALNm4pu');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(4, 'Analyze'),
(3, 'Apply'),
(6, 'Create'),
(5, 'Evaluate'),
(1, 'Remember'),
(2, 'Understand');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_image` varchar(255) DEFAULT '',
  `image_label` varchar(255) DEFAULT '',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `category_id`, `question_text`, `question_image`, `image_label`, `created_at`) VALUES
(2, 1, 'Which component of the Central Processing Unit (CPU) is responsible for performing arithmetic and logical operations?', '', '', '2026-03-08 07:44:28'),
(3, 1, 'Which type of memory is non-volatile and is used to store the computer’s firmware instructions during the boot process?', '', '', '2026-03-08 07:45:34'),
(4, 1, 'Which unit of measurement is commonly used to measure the processing speed of a CPU?', '', '', '2026-03-08 07:47:22'),
(5, 2, 'How does solid-state drive (SSD) storage differ from hard disk drive (HDD) in terms of data access?', '', '', '2026-03-08 07:50:25'),
(6, 2, 'Maria is running multiple programs on her computer, including a web browser, a video editor, and a game. She notices her computer is slowing down. Which of the following would most directly improve her computer’s performance?', '', '', '2026-03-08 07:55:14'),
(7, 2, 'John’s computer is running very slowly while editing videos. The task manager shows that the RAM is almost full, and the system is using the hard drive as memory.\r\n\r\nWhat is causing the slow performance?', '', '', '2026-03-08 07:57:40'),
(8, 3, 'A web developer wants to securely store user passwords in a database so that even if the database is compromised, the original passwords cannot be easily retrieved.\r\n\r\nWhich method should they apply?', '', '', '2026-03-08 08:00:32'),
(9, 3, 'A developer is designing a program that reads user input and stores it temporarily while processing tasks.\r\n\r\nWhich concept should they implement to ensure smooth sequential handling of data?', '', '', '2026-03-08 08:01:40'),
(10, 3, 'A software engineer needs to implement a real-time recommendation system that updates suggestions as users interact with the platform.\r\n\r\nWhich approach should they apply to efficiently manage large-scale, frequently changing data?', '', '', '2026-03-08 08:03:26'),
(11, 4, 'Analyzing the flowchart, what is the purpose of this program?', 'uploads/questions/q_1772957399_2208.png', 'A flowchart showing a program with decisions and loops: input → check if number > 0 → if yes, divide by 2 → loop back → if no, print result.', '2026-03-08 08:09:59'),
(12, 4, 'Analyzing the code, what does this function compute?', 'uploads/questions/q_1772957555_8654.jpg', 'A snippet of code showing a recursive function:', '2026-03-08 08:12:35'),
(13, 4, 'Analyze the code and answer the following:\r\n\r\nWhat is the output of the program and which algorithm is implemented?', 'uploads/questions/q_1772957709_4282.jpg', 'Snippet of code:', '2026-03-08 08:15:09'),
(14, 5, 'Evaluate the flowchart and determine which improvement would make the program more efficient for handling multiple numbers in a sequence.', 'uploads/questions/q_1772958648_3030.png', 'A flowchart showing a program that: Start → Input a number → If number divisible by 2 → Print \"Even\" → Else → Print \"Odd\" → End', '2026-03-08 08:30:48'),
(15, 5, 'Evaluate the code and select the best improvement to optimize performance for large n.', 'uploads/questions/q_1772959049_6115.jpg', 'A snippet of Python code that uses a recursive Fibonacci function:.', '2026-03-08 08:37:29'),
(16, 5, 'Evaluate this approach. Which modification would improve efficiency for very large text datasets?', 'uploads/questions/q_1772959247_8719.jpg', 'A code snippet showing a Python dictionary being used for counting words:', '2026-03-08 08:40:47'),
(17, 6, 'You need to complete the flowchart to ensure the program outputs \"Valid\" or \"Invalid\" depending on the checks. Which step should you add?', 'uploads/questions/q_1772959693_1778.png', 'A partially completed flowchart for a password validation program showing: Start → Input Password → Check Length → Check Special Characters → (Missing) → End', '2026-03-08 08:48:13'),
(18, 6, 'You are tasked to design a query to find the top 5 students with the highest grades. Which SQL query should you create?', 'uploads/questions/q_1772959936_7345.png', 'A diagram of a database table with columns: StudentID, Name, Grade, DateOfBirth.', '2026-03-08 08:52:16'),
(19, 6, 'You are asked to optimize this recursion for large inputs. Which solution should you implement?', 'uploads/questions/q_1772960178_2921.png', 'A Python code snippet diagram showing a recursive function call stack for computing factorial with visual arrows between calls.', '2026-03-08 08:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `question_choices`
--

CREATE TABLE `question_choices` (
  `choice_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `question_choices`
--

INSERT INTO `question_choices` (`choice_id`, `question_id`, `choice_text`, `is_correct`, `sort_order`) VALUES
(5, 2, 'A. Control Unit (CU)', 0, 1),
(6, 2, 'B. Arithmetic Logic Unit (ALU)', 1, 2),
(7, 2, 'C. Register Unit (RU)', 0, 3),
(8, 2, 'D. Cache Memory', 0, 4),
(9, 3, 'A. RAM (Random Access Memory)', 0, 1),
(10, 3, 'B. Cache Memory', 0, 2),
(11, 3, 'C. ROM (Read-Only Memory)', 1, 3),
(12, 3, 'D. Virtual Memory', 0, 4),
(13, 4, 'A. Byte', 0, 1),
(14, 4, 'B. Pixel', 0, 2),
(15, 4, 'C.Hz', 1, 3),
(16, 4, 'D. Volt', 0, 4),
(17, 5, 'A. SSDs store data magnetically while HDDs use flash memory', 0, 1),
(18, 5, 'B. SSDs have no moving parts and provide faster read/write speeds than HDDs', 1, 2),
(19, 5, 'C. SSDs are slower but more durable than HDDs', 0, 3),
(20, 5, 'D. SSDs are only used for temporary storage', 0, 4),
(21, 6, 'A. Increasing the computer’s RAM', 1, 1),
(22, 6, 'B. Upgrading to a larger monitor', 0, 2),
(23, 6, 'C. Deleting the operating system', 0, 3),
(24, 6, 'D. Turning off Wi-Fi', 0, 4),
(25, 6, 'E. Using a different keyboard', 0, 5),
(26, 6, 'F. Reducing screen brightness', 0, 6),
(27, 7, 'A. The monitor resolution is too high', 0, 1),
(28, 7, 'B. The CPU has too few cores', 0, 2),
(29, 7, 'C. The sound system is active', 0, 3),
(30, 7, 'D. The keyboard is faulty', 0, 4),
(31, 7, 'E. The computer is using virtual memory', 1, 5),
(32, 7, 'D. The mouse is not calibrated', 0, 6),
(33, 8, 'A. Store passwords in plain text', 0, 1),
(34, 8, 'B. Hash passwords using a strong cryptographic algorithm', 1, 2),
(35, 8, 'C. Store passwords in a text file on the server', 0, 3),
(36, 8, 'D. Use Base64 encoding', 0, 4),
(37, 8, 'E. Encrypt passwords with reversible encryption', 0, 5),
(38, 8, 'F. Save passwords in a cache', 0, 6),
(39, 9, 'A. Recursion', 0, 1),
(40, 9, 'B. Stack', 0, 2),
(41, 9, 'C. Queue', 1, 3),
(42, 9, 'D. Graph', 0, 4),
(43, 9, 'E. Binary Search', 0, 5),
(44, 9, 'F. Hash Function', 0, 6),
(45, 10, 'A. Store all data in a single array', 0, 1),
(46, 10, 'B. Use a relational database with frequent full-table scans', 0, 2),
(47, 10, 'C.Use a static CSV file for data', 0, 3),
(48, 10, 'D. . Implement a NoSQL database with caching mechanisms', 1, 4),
(49, 10, 'E. Apply Bubble Sort every time data changes', 0, 5),
(50, 10, 'F. Store data only in RAM without persistence', 0, 6),
(51, 11, 'A. Compute factorial', 0, 1),
(52, 11, 'B. Count the number of divisions by 2 until the number is ≤ 0', 1, 2),
(53, 11, 'C. Check if the number is even', 0, 3),
(54, 11, 'D. Sort an array', 0, 4),
(55, 11, 'E. Generate a Fibonacci sequence', 0, 5),
(56, 11, 'F. Find the largest number', 0, 6),
(57, 12, 'A. Fibonacci number', 0, 1),
(58, 12, 'B. n modulo 2', 0, 2),
(59, 12, 'C. Sum of numbers from 1 to n', 0, 3),
(60, 12, 'D. n squared', 0, 4),
(61, 12, 'E. Exponential of n', 0, 5),
(62, 12, 'F. Factorial of n', 1, 6),
(63, 13, 'A. [5, 2, 9, 1, 6], Quick Sort', 0, 1),
(64, 13, 'B. [1, 2, 5, 6, 9], Merge Sort', 1, 2),
(65, 13, 'C. [1, 2, 5, 6, 9], Bubble Sort', 0, 3),
(66, 13, 'D. [1, 2, 5, 6, 9], Insertion Sort', 0, 4),
(67, 13, 'E. [5, 2, 9, 1, 6], Selection Sort', 0, 5),
(68, 13, 'F. [2, 1, 5, 6, 9], Merge Sort', 0, 6),
(69, 14, 'A. Add a loop to process multiple numbers', 1, 1),
(70, 14, 'B. Change the decision to check for divisibility by 3', 0, 2),
(71, 14, 'C. Use recursion instead of a loop', 0, 3),
(72, 14, 'D. Store numbers in a text file only', 0, 4),
(73, 14, 'E. Remove the decision entirely', 0, 5),
(74, 14, 'F. Print the numbers instead of \"Even/Odd\"', 0, 6),
(75, 15, 'A.Increase the recursion depth limit', 0, 1),
(76, 15, 'B. Replace + with *', 0, 2),
(77, 15, 'C. Print results instead of returning', 0, 3),
(78, 15, 'D. Use memoization or dynamic programming', 1, 4),
(79, 15, 'E. Sort the Fibonacci numbers', 0, 5),
(80, 15, 'F. Use an array for input', 0, 6),
(81, 16, 'A. Use collections.Counter instead of manual counting', 1, 1),
(82, 16, 'B. Use a list instead of a dictionary', 0, 2),
(83, 16, 'C. Count only the first 5 words', 0, 3),
(84, 16, 'D. Remove .split() and use characters', 0, 4),
(85, 16, 'E. Sort the words first', 0, 5),
(86, 16, 'F. Use recursion instead of a loop', 0, 6),
(87, 17, 'A. Print \"Password Saved\" directly after input', 0, 1),
(88, 17, 'B.Add a loop to input multiple passwords without checks', 0, 2),
(89, 17, 'C. Decision: Are all checks passed? → Yes: Print \"Valid\" → No: Print \"Invalid\"', 1, 3),
(90, 17, 'D. Delete the length check', 0, 4),
(91, 17, 'E. Use recursion to validate each character', 0, 5),
(92, 17, 'F. Skip special character check', 0, 6),
(93, 18, 'A. INSERT INTO Students ORDER BY Grade;', 0, 1),
(94, 18, 'B. SELECT * FROM Students WHERE Grade > 5;', 0, 2),
(95, 18, 'C. SELECT TOP 5 * FROM Students;', 0, 3),
(96, 18, 'D. SELECT * FROM Students ORDER BY Name ASC;', 0, 4),
(97, 18, 'E. SELECT * FROM Students;', 0, 5),
(98, 18, '. SELECT * FROM Students ORDER BY Grade DESC LIMIT 5;', 1, 6),
(99, 19, 'A. Use dynamic programming / memoization', 1, 1),
(100, 19, 'B. Increase recursion depth limit only', 0, 2),
(101, 19, 'C. Replace factorial with Fibonacci', 0, 3),
(102, 19, 'D. Remove the base case', 0, 4),
(103, 19, 'E. Use print statements instead of return', 0, 5),
(104, 19, 'F. Split recursion into multiple functions unnecessarily', 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL DEFAULT 0,
  `score` int(11) NOT NULL DEFAULT 0,
  `top1_intelligence` varchar(255) NOT NULL,
  `top2_intelligence` varchar(255) NOT NULL,
  `top3_intelligence` varchar(255) NOT NULL,
  `taken_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `student_id`, `total_questions`, `score`, `top1_intelligence`, `top2_intelligence`, `top3_intelligence`, `taken_at`) VALUES
(1, 1, 1, 1, 'Logical–Mathematical Intelligence', 'Verbal–Linguistic Intelligence', 'No third intelligence found', '2026-03-08 06:57:28'),
(2, 1, 18, 5, 'Verbal–Linguistic Intelligence', 'Interpersonal Intelligence', 'Spatial Intelligence', '2026-03-08 08:57:37'),
(3, 3, 18, 5, 'Verbal–Linguistic Intelligence', 'Interpersonal Intelligence', 'Logical–Mathematical Intelligence', '2026-03-08 09:00:45'),
(4, 4, 18, 8, 'Spatial Intelligence', 'Bodily–Kinesthetic Intelligence', 'Interpersonal Intelligence', '2026-03-08 09:29:16'),
(5, 5, 18, 8, 'Logical–Mathematical Intelligence', 'Spatial Intelligence', 'Intrapersonal Intelligence', '2026-03-08 13:29:00'),
(6, 6, 18, 5, 'Verbal–Linguistic Intelligence', 'Interpersonal Intelligence', 'Logical–Mathematical Intelligence', '2026-03-08 13:35:07'),
(7, 7, 18, 13, 'Logical–Mathematical Intelligence', 'Verbal–Linguistic Intelligence', 'Spatial Intelligence', '2026-03-08 13:39:53'),
(8, 8, 18, 9, 'Spatial Intelligence', 'Logical–Mathematical Intelligence', 'Bodily–Kinesthetic Intelligence', '2026-03-08 13:42:31'),
(9, 9, 18, 7, 'Verbal–Linguistic Intelligence', 'Interpersonal Intelligence', 'Logical–Mathematical Intelligence', '2026-03-08 13:44:24'),
(10, 10, 18, 6, 'Spatial Intelligence', 'Logical–Mathematical Intelligence', 'Intrapersonal Intelligence', '2026-03-08 13:45:59'),
(11, 11, 18, 9, 'Logical–Mathematical Intelligence', 'Verbal–Linguistic Intelligence', 'Intrapersonal Intelligence', '2026-03-08 13:48:35'),
(12, 12, 18, 8, 'Spatial Intelligence', 'Logical–Mathematical Intelligence', 'Bodily–Kinesthetic Intelligence', '2026-03-08 13:50:06'),
(13, 13, 18, 11, 'Logical–Mathematical Intelligence', 'Spatial Intelligence', 'Verbal–Linguistic Intelligence', '2026-03-08 13:52:24'),
(14, 1, 18, 5, 'Logical–Mathematical Intelligence', 'Intrapersonal Intelligence', 'Verbal–Linguistic Intelligence', '2026-03-10 05:59:19');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answers`
--

CREATE TABLE `quiz_answers` (
  `answer_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_choice_id` int(11) NOT NULL DEFAULT 0,
  `correct_choice_id` int(11) NOT NULL DEFAULT 0,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `quiz_answers`
--

INSERT INTO `quiz_answers` (`answer_id`, `quiz_id`, `question_id`, `selected_choice_id`, `correct_choice_id`, `is_correct`) VALUES
(2, 2, 2, 7, 6, 0),
(3, 2, 3, 10, 11, 0),
(4, 2, 4, 14, 15, 0),
(5, 2, 5, 18, 18, 1),
(6, 2, 6, 21, 21, 1),
(7, 2, 7, 27, 31, 0),
(8, 2, 8, 36, 34, 0),
(9, 2, 9, 41, 41, 1),
(10, 2, 10, 47, 48, 0),
(11, 2, 11, 51, 52, 0),
(12, 2, 12, 61, 62, 0),
(13, 2, 13, 64, 64, 1),
(14, 2, 14, 74, 69, 0),
(15, 2, 15, 78, 78, 1),
(16, 2, 16, 82, 81, 0),
(17, 2, 17, 87, 89, 0),
(18, 2, 18, 93, 98, 0),
(19, 2, 19, 102, 99, 0),
(20, 3, 2, 5, 6, 0),
(21, 3, 3, 9, 11, 0),
(22, 3, 4, 15, 15, 1),
(23, 3, 5, 18, 18, 1),
(24, 3, 6, 21, 21, 1),
(25, 3, 7, 27, 31, 0),
(26, 3, 8, 33, 34, 0),
(27, 3, 9, 39, 41, 0),
(28, 3, 10, 47, 48, 0),
(29, 3, 11, 54, 52, 0),
(30, 3, 12, 60, 62, 0),
(31, 3, 13, 63, 64, 0),
(32, 3, 14, 69, 69, 1),
(33, 3, 15, 75, 78, 0),
(34, 3, 16, 81, 81, 1),
(35, 3, 17, 88, 89, 0),
(36, 3, 18, 94, 98, 0),
(37, 3, 19, 100, 99, 0),
(38, 4, 2, 5, 6, 0),
(39, 4, 3, 9, 11, 0),
(40, 4, 4, 16, 15, 0),
(41, 4, 5, 18, 18, 1),
(42, 4, 6, 21, 21, 1),
(43, 4, 7, 28, 31, 0),
(44, 4, 8, 34, 34, 1),
(45, 4, 9, 41, 41, 1),
(46, 4, 10, 48, 48, 1),
(47, 4, 11, 52, 52, 1),
(48, 4, 12, 60, 62, 0),
(49, 4, 13, 65, 64, 0),
(50, 4, 14, 69, 69, 1),
(51, 4, 15, 80, 78, 0),
(52, 4, 16, 84, 81, 0),
(53, 4, 17, 89, 89, 1),
(54, 4, 18, 95, 98, 0),
(55, 4, 19, 100, 99, 0),
(56, 5, 2, 5, 6, 0),
(57, 5, 3, 9, 11, 0),
(58, 5, 4, 13, 15, 0),
(59, 5, 5, 18, 18, 1),
(60, 5, 6, 22, 21, 0),
(61, 5, 7, 28, 31, 0),
(62, 5, 8, 34, 34, 1),
(63, 5, 9, 39, 41, 0),
(64, 5, 10, 45, 48, 0),
(65, 5, 11, 52, 52, 1),
(66, 5, 12, 62, 62, 1),
(67, 5, 13, 65, 64, 0),
(68, 5, 14, 69, 69, 1),
(69, 5, 15, 75, 78, 0),
(70, 5, 16, 81, 81, 1),
(71, 5, 17, 89, 89, 1),
(72, 5, 18, 94, 98, 0),
(73, 5, 19, 99, 99, 1),
(74, 6, 2, 5, 6, 0),
(75, 6, 3, 9, 11, 0),
(76, 6, 4, 15, 15, 1),
(77, 6, 5, 18, 18, 1),
(78, 6, 6, 21, 21, 1),
(79, 6, 7, 31, 31, 1),
(80, 6, 8, 33, 34, 0),
(81, 6, 9, 39, 41, 0),
(82, 6, 10, 47, 48, 0),
(83, 6, 11, 55, 52, 0),
(84, 6, 12, 58, 62, 0),
(85, 6, 13, 63, 64, 0),
(86, 6, 14, 74, 69, 0),
(87, 6, 15, 75, 78, 0),
(88, 6, 16, 84, 81, 0),
(89, 6, 17, 87, 89, 0),
(90, 6, 18, 93, 98, 0),
(91, 6, 19, 99, 99, 1),
(92, 7, 2, 6, 6, 1),
(93, 7, 3, 10, 11, 0),
(94, 7, 4, 15, 15, 1),
(95, 7, 5, 18, 18, 1),
(96, 7, 6, 21, 21, 1),
(97, 7, 7, 31, 31, 1),
(98, 7, 8, 34, 34, 1),
(99, 7, 9, 41, 41, 1),
(100, 7, 10, 46, 48, 0),
(101, 7, 11, 52, 52, 1),
(102, 7, 12, 62, 62, 1),
(103, 7, 13, 66, 64, 0),
(104, 7, 14, 69, 69, 1),
(105, 7, 15, 77, 78, 0),
(106, 7, 16, 81, 81, 1),
(107, 7, 17, 89, 89, 1),
(108, 7, 18, 93, 98, 0),
(109, 7, 19, 99, 99, 1),
(110, 8, 2, 5, 6, 0),
(111, 8, 3, 9, 11, 0),
(112, 8, 4, 15, 15, 1),
(113, 8, 5, 18, 18, 1),
(114, 8, 6, 21, 21, 1),
(115, 8, 7, 28, 31, 0),
(116, 8, 8, 34, 34, 1),
(117, 8, 9, 41, 41, 1),
(118, 8, 10, 48, 48, 1),
(119, 8, 11, 52, 52, 1),
(120, 8, 12, 62, 62, 1),
(121, 8, 13, 66, 64, 0),
(122, 8, 14, 70, 69, 0),
(123, 8, 15, 76, 78, 0),
(124, 8, 16, 83, 81, 0),
(125, 8, 17, 89, 89, 1),
(126, 8, 18, 96, 98, 0),
(127, 8, 19, 102, 99, 0),
(128, 9, 2, 5, 6, 0),
(129, 9, 3, 10, 11, 0),
(130, 9, 4, 15, 15, 1),
(131, 9, 5, 18, 18, 1),
(132, 9, 6, 21, 21, 1),
(133, 9, 7, 28, 31, 0),
(134, 9, 8, 37, 34, 0),
(135, 9, 9, 42, 41, 0),
(136, 9, 10, 48, 48, 1),
(137, 9, 11, 53, 52, 0),
(138, 9, 12, 57, 62, 0),
(139, 9, 13, 66, 64, 0),
(140, 9, 14, 69, 69, 1),
(141, 9, 15, 77, 78, 0),
(142, 9, 16, 81, 81, 1),
(143, 9, 17, 89, 89, 1),
(144, 9, 18, 93, 98, 0),
(145, 9, 19, 101, 99, 0),
(146, 10, 2, 5, 6, 0),
(147, 10, 3, 9, 11, 0),
(148, 10, 4, 13, 15, 0),
(149, 10, 5, 18, 18, 1),
(150, 10, 6, 21, 21, 1),
(151, 10, 7, 30, 31, 0),
(152, 10, 8, 33, 34, 0),
(153, 10, 9, 40, 41, 0),
(154, 10, 10, 45, 48, 0),
(155, 10, 11, 52, 52, 1),
(156, 10, 12, 62, 62, 1),
(157, 10, 13, 65, 64, 0),
(158, 10, 14, 70, 69, 0),
(159, 10, 15, 76, 78, 0),
(160, 10, 16, 82, 81, 0),
(161, 10, 17, 89, 89, 1),
(162, 10, 18, 95, 98, 0),
(163, 10, 19, 99, 99, 1),
(164, 11, 2, 5, 6, 0),
(165, 11, 3, 9, 11, 0),
(166, 11, 4, 15, 15, 1),
(167, 11, 5, 18, 18, 1),
(168, 11, 6, 21, 21, 1),
(169, 11, 7, 28, 31, 0),
(170, 11, 8, 34, 34, 1),
(171, 11, 9, 42, 41, 0),
(172, 11, 10, 47, 48, 0),
(173, 11, 11, 52, 52, 1),
(174, 11, 12, 62, 62, 1),
(175, 11, 13, 63, 64, 0),
(176, 11, 14, 69, 69, 1),
(177, 11, 15, 75, 78, 0),
(178, 11, 16, 81, 81, 1),
(179, 11, 17, 89, 89, 1),
(180, 11, 18, 96, 98, 0),
(181, 11, 19, 102, 99, 0),
(182, 12, 2, 5, 6, 0),
(183, 12, 3, 9, 11, 0),
(184, 12, 4, 15, 15, 1),
(185, 12, 5, 18, 18, 1),
(186, 12, 6, 23, 21, 0),
(187, 12, 7, 27, 31, 0),
(188, 12, 8, 34, 34, 1),
(189, 12, 9, 42, 41, 0),
(190, 12, 10, 48, 48, 1),
(191, 12, 11, 52, 52, 1),
(192, 12, 12, 62, 62, 1),
(193, 12, 13, 65, 64, 0),
(194, 12, 14, 70, 69, 0),
(195, 12, 15, 75, 78, 0),
(196, 12, 16, 84, 81, 0),
(197, 12, 17, 89, 89, 1),
(198, 12, 18, 93, 98, 0),
(199, 12, 19, 99, 99, 1),
(200, 13, 2, 5, 6, 0),
(201, 13, 3, 9, 11, 0),
(202, 13, 4, 15, 15, 1),
(203, 13, 5, 18, 18, 1),
(204, 13, 6, 21, 21, 1),
(205, 13, 7, 28, 31, 0),
(206, 13, 8, 34, 34, 1),
(207, 13, 9, 39, 41, 0),
(208, 13, 10, 45, 48, 0),
(209, 13, 11, 52, 52, 1),
(210, 13, 12, 62, 62, 1),
(211, 13, 13, 63, 64, 0),
(212, 13, 14, 69, 69, 1),
(213, 13, 15, 78, 78, 1),
(214, 13, 16, 83, 81, 0),
(215, 13, 17, 89, 89, 1),
(216, 13, 18, 98, 98, 1),
(217, 13, 19, 99, 99, 1),
(218, 14, 2, 5, 6, 0),
(219, 14, 3, 9, 11, 0),
(220, 14, 4, 15, 15, 1),
(221, 14, 5, 19, 18, 0),
(222, 14, 6, 24, 21, 0),
(223, 14, 7, 30, 31, 0),
(224, 14, 8, 35, 34, 0),
(225, 14, 9, 41, 41, 1),
(226, 14, 10, 46, 48, 0),
(227, 14, 11, 52, 52, 1),
(228, 14, 12, 61, 62, 0),
(229, 14, 13, 66, 64, 0),
(230, 14, 14, 69, 69, 1),
(231, 14, 15, 75, 78, 0),
(232, 14, 16, 81, 81, 1),
(233, 14, 17, 88, 89, 0),
(234, 14, 18, 97, 98, 0),
(235, 14, 19, 102, 99, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_key`, `setting_value`) VALUES
(1, 'quiz_question_limit', '30');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_no` varchar(100) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT '',
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_no`, `full_name`, `email`, `password_hash`, `created_at`) VALUES
(1, 'joshiya', 'Joshua Jequinto', 'sleeping.slavix@gmail.com', '$2y$10$0WKnZw2BW0lXGOGQt7tPCu45vgad5nyoKhxf3d2wN9BEfBAiOmAua', '2026-03-08 06:57:12'),
(2, 'nanjiruu55', 'Sean Patrick Jequinto', 'sleeping.slavix@gmail.com', '$2y$10$/grvu3gUv/Rm9VNHtDdgh.GboFxmY/2w5ZhaSA.OvowGOFMN9UDVu', '2026-03-08 08:58:51'),
(3, 'Josh', 'Justin Beiber', 'sleeping.slavix@gmail.com', '$2y$10$wz.Luq2Ycj3MUuhc6oTxXuZF7KvdsluT7XioMmCHgt1hAbeMtjzdS', '2026-03-08 08:59:58'),
(4, 'gilomi', 'Gilamae Buenafe', 'gilamaebuenafe4@gmail.com', '$2y$10$H5dQnWtnq9DA5fq/wMOz3O.OolBsqOIaPEjTfac6669VZVgN8Yjyq', '2026-03-08 09:13:31'),
(5, 'Emmanuel Palangre', 'Emmanuel Palangre', 'Emmanuel11@gmail.com', '$2y$10$QQZiYq5SAWUeuthKanECs.nDFT5eX26CR6Ca6PieGp5oytwaERrr2', '2026-03-08 13:25:27'),
(6, 'Kurt Golero', 'Kurt Golero', 'KurtGolero33@gmail.com', '$2y$10$ZoOuxdOKI1/mo7f6b.zVj.jBW7OOTITU9JF7hNo2ru.IlnoXck6e2', '2026-03-08 13:31:04'),
(7, 'Marjorie M. Amoroso', 'Marjorie M. Amoroso', 'marjorie355@gmail.com', '$2y$10$qlejBp4er1rH9/4mwJJmKOYyCXiKPZW6gyeHOFfOJDpwQ1eIp55Nm', '2026-03-08 13:36:38'),
(8, 'Rowena Garcia', 'Rowena Garcia', 'orchid666@gmail.com', '$2y$10$T3MvUqrH/0BNszqr2h0cl.7Nmxzb9FcxabgLacaqJQ66QDPBGoIiq', '2026-03-08 13:41:41'),
(9, 'Martin Dave Demaisip', 'Martin Dave Demaisip', 'Davemartin45@gmail.com', '$2y$10$Qk4lJtX7Z14kzr67GIsCluabKI/M1LiLSUGKrqeHZA8teKQmBqGXe', '2026-03-08 13:43:22'),
(10, 'Danica B. Focnal', 'Danica B. Focnal', 'Danicafocnal@gmail.com', '$2y$10$g7O0Rt9dzjGBbb9fHY8fhu3H98MkNCoviqLaGy2riaMbVyU/i0oGe', '2026-03-08 13:45:14'),
(11, 'Christian Deguma', 'Christian Deguma', 'christian99@gmail.com', '$2y$10$MjUI6lXuvCH01xOEmGv6FOBOFnKJ4FLhgoW.wxEHtyz239Wb0YG9a', '2026-03-08 13:47:00'),
(12, 'Luomark Bautista', 'Luomark Bautista', 'luomarkbautista@gmail.com', '$2y$10$/Z0Y37VTYu9IO9Yiq7cf1O999A8S0tqSkwlSgX09gjYgdMma2s9YG', '2026-03-08 13:49:18'),
(13, 'Jocelyn Reyes', 'Jocelyn Reyes', 'joceltnreyes22@gmail.com', '$2y$10$NWh4Akhfyl9v4El0IaUFFu7uRADgvJNQokSxCHqnV8AknxbJfMPO.', '2026-03-08 13:51:05'),
(14, 'Joe Ann Labrador', 'Joe Ann Labrador', 'joeannlabrador@gmail.com', '$2y$10$8nWIvxVatxTIG6ZouycOkuSSVlrnNe7KmuB/UeM7O1W7nz218WedG', '2026-03-09 07:10:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `fk_questions_category` (`category_id`);

--
-- Indexes for table `question_choices`
--
ALTER TABLE `question_choices`
  ADD PRIMARY KEY (`choice_id`),
  ADD KEY `fk_choices_question` (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `fk_quiz_student` (`student_id`);

--
-- Indexes for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `fk_qa_quiz` (`quiz_id`),
  ADD KEY `fk_qa_question` (`question_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_no` (`student_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `question_choices`
--
ALTER TABLE `question_choices`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `question_choices`
--
ALTER TABLE `question_choices`
  ADD CONSTRAINT `fk_choices_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `fk_quiz_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD CONSTRAINT `fk_qa_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_qa_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
