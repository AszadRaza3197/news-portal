-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2026 at 09:37 PM
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
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `role` text NOT NULL,
  `action` varchar(100) NOT NULL,
  `affected` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`log_id`, `uid`, `role`, `action`, `affected`, `time`) VALUES
(1, 4, 'editor', 'logged out', '', '2026-08-17 09:28:27'),
(2, 4, 'editor', 'logged in', '', '2026-08-19 08:37:04'),
(3, 4, 'editor', 'logged out', '', '2026-08-19 08:43:09'),
(4, 3, 'reporter', 'logged in', '', '2026-08-19 08:43:16'),
(5, 3, 'reporter', 'logged out', '', '2026-08-19 08:44:41'),
(6, 4, 'editor', 'logged in', '', '2026-08-19 08:44:47'),
(7, 4, 'editor', 'published news', 'newsid: 113', '2026-08-19 08:45:05'),
(8, 4, 'editor', 'published news', 'newsid: 113', '2026-08-19 08:45:15'),
(9, 4, 'editor', 'logged out', '', '2026-08-19 08:45:50'),
(10, 3, 'reporter', 'logged in', '', '2026-08-19 08:46:12'),
(11, 3, 'reporter', 'uploaded news', 'Buffalo meat exports cross $5 billion, on track to top $6 billion', '2026-08-19 08:49:15'),
(12, 3, 'reporter', 'uploaded news', 'World News Live Updates: UAE warns of possible ‘missile threats’, urges people to take shelter', '2026-08-19 08:57:40'),
(13, 3, 'reporter', 'uploaded news', 'PM Modi’s man in Nitin Nabin’s core team: The Gujarat subplot in BJP rejig', '2026-08-19 09:01:24'),
(14, 3, 'reporter', 'scheduled news', 'PM Modi’s man in Nitin Nabin’s core team: The Gujarat subplot in BJP rejig', '2026-08-19 09:01:24'),
(15, 3, 'reporter', 'uploaded news', 'The TATA succession battle: Over to Noel', '2026-08-19 09:11:13'),
(16, 3, 'reporter', 'scheduled news', 'Employee in morning, protester by evening: Meet those rendered jobless by Jharkhand call to scrap ex', '2026-08-19 09:12:35'),
(17, 3, 'reporter', 'logged out', '', '2026-08-19 09:15:34'),
(18, 3, 'reporter', 'logged in', '', '2026-08-19 09:15:38'),
(19, 3, 'reporter', 'logged out', '', '2026-08-19 09:15:44'),
(20, 4, 'editor', 'logged in', '', '2026-08-19 09:15:48'),
(21, 4, 'editor', 'published news', 'newsid: 121', '2026-08-19 09:15:54'),
(22, 4, 'editor', 'published news', 'newsid: 126', '2026-08-19 09:15:56'),
(23, 4, 'editor', 'published news', 'newsid: 125', '2026-08-19 09:15:56'),
(24, 4, 'editor', 'published news', 'newsid: 123', '2026-08-19 09:15:57'),
(25, 4, 'editor', 'published news', 'newsid: 124', '2026-08-19 09:15:58'),
(26, 4, 'editor', 'published news', 'newsid: 122', '2026-08-19 09:15:58'),
(27, 0, '', 'logged out', '', '2026-08-19 09:33:00'),
(28, 3, 'reporter', 'logged in', '', '2026-08-19 09:33:06'),
(29, 0, '', 'logged out', '', '2026-08-19 10:13:17'),
(30, 3, 'reporter', 'logged in', '', '2026-08-19 10:13:21'),
(31, 2, 'member', 'logged in', '', '2026-08-27 12:08:54'),
(32, 2, 'member', 'logged out', '', '2026-08-27 12:09:11'),
(33, 4, 'editor', 'logged in', '', '2026-08-27 12:09:18'),
(34, 4, 'editor', 'published news', 'newsid: 1', '2026-08-27 12:09:30'),
(35, 4, 'editor', 'logged out', '', '2026-08-27 12:09:33'),
(36, 3, 'reporter', 'logged in', '', '2026-08-27 12:09:37'),
(37, 3, 'reporter', 'logged out', '', '2026-08-27 12:09:54'),
(38, 1, 'admin', 'logged in', '', '2026-09-01 11:11:16'),
(39, 1, 'admin', 'logged out', '', '2026-09-01 11:11:19'),
(40, 1, 'admin', 'logged in', '', '2026-09-01 11:14:31'),
(41, 1, 'admin', 'logged out', '', '2026-09-01 11:16:05'),
(42, 6, 'editor', 'logged in', '', '2026-09-01 11:16:13'),
(43, 6, 'editor', 'logged out', '', '2026-09-01 23:10:57'),
(44, 1, 'admin', 'logged in', '', '2026-09-01 23:11:50'),
(45, 1, 'admin', 'logged out', '', '2026-09-01 23:12:32'),
(46, 4, 'editor', 'logged in', '', '2026-09-01 23:12:41'),
(47, 4, 'editor', 'logged out', '', '2026-09-01 23:12:57'),
(48, 3, 'reporter', 'logged in', '', '2026-09-01 23:13:06'),
(49, 3, 'reporter', 'uploaded news', '', '2026-09-01 23:22:47'),
(50, 3, 'reporter', 'uploaded news', '', '2026-09-01 23:22:55'),
(51, 3, 'reporter', 'scheduled news', 'US green card backlog: Indian EB-2 wait could stretch to 179 years', '2026-09-01 23:24:54'),
(52, 3, 'reporter', 'logged out', '', '2026-09-01 23:28:01'),
(53, 1, 'admin', 'logged in', '', '2026-09-01 23:28:06'),
(54, 1, 'admin', 'logged out', '', '2026-09-01 23:28:18'),
(55, 3, 'reporter', 'logged in', '', '2026-09-01 23:31:14'),
(56, 3, 'reporter', 'scheduled news', 'Virat Kohli’s advice, Lewis Hamilton example help Sanat Sangwan play vital knock', '2026-09-01 23:45:04'),
(57, 3, 'reporter', 'uploaded news', 'As accountant’s phone is hacked, sugar trader loses Rs 3 crore in whale phishing attack', '2026-09-02 00:58:39'),
(58, 3, 'reporter', 'scheduled news', 'Lionel Messi’s international retirement: Football loses a part of its soul', '2026-09-02 00:59:50'),
(59, 3, 'reporter', 'logged out', '', '2026-09-02 01:03:56'),
(60, 4, 'editor', 'logged in', '', '2026-09-02 01:04:03'),
(61, 4, 'editor', 'published news', 'newsid: 131', '2026-09-02 01:04:15'),
(62, 4, 'editor', 'logged out', '', '2026-09-02 01:04:17'),
(63, 1, 'admin', 'logged in', '', '2026-09-02 01:04:24'),
(64, 1, 'admin', 'logged out', '', '2026-09-02 01:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `bid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `bookmark_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`bid`, `user_id`, `news_id`, `bookmark_date`) VALUES
(2, 2, 2, '2026-08-16 08:47:21'),
(4, 2, 4, '2026-08-16 14:41:39'),
(5, 2, 8, '2026-08-16 14:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(5) NOT NULL,
  `category` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `category`, `is_delete`) VALUES
(1, 'all', 0),
(2, 'Crime', 0),
(3, 'Politics', 0),
(4, 'Cinema', 0),
(5, 'Sports', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `com_id` int(5) NOT NULL,
  `news_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `comments` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `replied_on` int(5) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `news_id`, `user_id`, `comments`, `date`, `replied_on`, `is_verified`, `is_delete`) VALUES
(1, 1, 2, 'hay', '2026-08-07 10:38:55', 0, 0, 0),
(2, 8, 2, 'hii', '2026-08-07 11:10:54', 0, 0, 0),
(3, 8, 2, 'hii', '2026-08-07 11:12:38', 0, 0, 0),
(4, 8, 2, 'hii', '2026-08-07 11:12:39', 0, 0, 0),
(5, 8, 2, 'hii', '2026-08-07 11:13:16', 0, 0, 0),
(6, 8, 2, 'hii', '2026-08-07 11:14:18', 0, 0, 0),
(7, 8, 2, 'hii', '2026-08-07 11:14:19', 0, 0, 0),
(8, 4, 2, 'hii', '2026-08-07 11:14:34', 0, 0, 0),
(9, 4, 2, 'hii', '2026-08-07 11:14:54', 0, 0, 0),
(10, 4, 2, 'hi', '2026-08-07 11:15:12', 0, 0, 0),
(11, 4, 2, 'hi', '2026-08-07 11:17:13', 0, 0, 0),
(12, 4, 2, 'hi', '2026-08-07 11:17:20', 0, 0, 0),
(13, 4, 2, 'hi', '2026-08-07 11:17:55', 0, 0, 0),
(14, 2, 2, 'hi', '2026-08-07 11:18:20', 0, 0, 0),
(15, 2, 2, 'hi', '2026-08-07 11:18:51', 0, 0, 0),
(16, 2, 2, 'hi', '2026-08-07 11:20:20', 0, 0, 0),
(17, 3, 2, 'hi', '2026-08-07 11:22:00', 0, 0, 0),
(18, 3, 2, 'hi', '2026-08-07 11:22:32', 0, 0, 0),
(19, 3, 2, 'hi', '2026-08-07 11:25:22', 0, 0, 0),
(21, 3, 2, 'hi', '2026-08-07 11:26:51', 0, 0, 0),
(22, 3, 2, 'hi', '2026-08-07 11:27:36', 0, 0, 0),
(23, 3, 2, 'hi', '2026-08-07 11:28:06', 0, 0, 0),
(24, 3, 2, 'hi', '2026-08-07 11:28:07', 0, 0, 0),
(25, 3, 2, 'hi', '2026-08-07 11:28:33', 0, 0, 0),
(26, 3, 2, 'hi', '2026-08-07 11:28:36', 0, 0, 0),
(27, 3, 2, 'hi', '2026-08-07 11:28:37', 0, 0, 0),
(29, 3, 2, 'hi', '2026-08-07 11:30:43', 0, 0, 0),
(32, 8, 2, 'new comm', '2026-08-16 20:10:41', 0, 0, 0),
(33, 4, 2, 'new comm', '2026-08-16 20:13:04', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `internal_chat`
--

CREATE TABLE `internal_chat` (
  `message_id` int(11) NOT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internal_chat`
--

INSERT INTO `internal_chat` (`message_id`, `from_id`, `to_id`, `message`, `attachment`, `date`, `is_delete`) VALUES
(1, 1, 6, 'hii this is my first email', '1788241498ecommerce.jpg', '2026-09-01 05:44:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(5) NOT NULL,
  `news_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `news_id`, `user_id`) VALUES
(1, 1, 2),
(3, 4, 2),
(4, 2, 2),
(6, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `loc_id` int(5) NOT NULL,
  `location` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`loc_id`, `location`, `is_delete`) VALUES
(1, 'all', 0),
(2, 'Hyderabad', 0),
(3, 'Banglore', 0),
(4, 'Mumbai', 0),
(5, 'Patna', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_table`
--

CREATE TABLE `news_table` (
  `nid` int(5) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `n_category_id` int(5) NOT NULL,
  `n_location_id` int(5) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `reporter_id` int(5) NOT NULL,
  `editor_id` int(11) NOT NULL,
  `news_image` varchar(50) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `views` int(5) NOT NULL,
  `is_delete` int(5) NOT NULL DEFAULT 0,
  `is_publish` int(5) NOT NULL DEFAULT 0,
  `is_breaking` int(5) NOT NULL DEFAULT 0,
  `scheduled_publish_at` datetime DEFAULT NULL,
  `is_scheduled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_table`
--

INSERT INTO `news_table` (`nid`, `heading`, `n_category_id`, `n_location_id`, `description`, `reporter_id`, `editor_id`, `news_image`, `posted_date`, `views`, `is_delete`, `is_publish`, `is_breaking`, `scheduled_publish_at`, `is_scheduled`) VALUES
(1, 'Indian student visas to US fell 62% in 2025; visas', 2, 2, 'US student visas issued to Indian nationals have plunged 62 per cent in 2025, according to a new report that also calls for scrapping the Optional Practical Training (OPT) programme, arguing that it hurts American workers. The proposal, if adopted, could affect thousands of Indian students hoping to work in the US after graduation.\r\n\r\nThe number of US visas issued to Indian students has seen a sharp decline in 2025 as compared to 2024, a move that could be beneficial for American students and highlights President Donald Trump’s administration’s strict immigration measures introduced recently, affecting F-1 visa applicants, news agency PTI reported, citing data analysed by the CIS.\r\n\r\nAlso Read | Why Trump’s proposed $100,000 OPT fee could hit Indian students hard\r\nIndian student visas to US fall 62% in 2025\r\nThe United States immigration authorities issued 22,149 student visas to Indian nationals in 2025 as against 58,694 in 2024. The report also highlighted a dip in student visas issued to China, with a 34 per cent decline to 40,034 in 2025, compared with 61,075 in 2024.\r\n\r\nAccording to the annual census by the Institute of International Education (IIE), in the 2024-25 academic year, 3,63,019 students from India and 2,65,919 from China made up 53 per cent of all foreign students (1,177,766) at the post-secondary level in the United States, PTI reported.\r\n\r\nAlso Read | US tightens Green Card rules: Incomplete applications can now be rejected outright\r\nIndian students account for nearly half of all OPT participants\r\n“Of the more than one million foreign students in the US during the 2024-25 academic year, about 294,253 students had already completed their degrees and were working in the US pursuant to ‘Optional Practical Training’ (OPT),” the report stated, quoting the IIE data.\r\n\r\nThe report, which has been critical of OPT, a temporary work program for eligible F-1 student visa holders in the US, revealed that under the OPT programme in 2024-25, about 49 per cent (143,740) were from India, followed by 21 per cent or 61,981 from China.\r\n\r\nWhat is OPT (Optional Practical Training)?\r\nOptional Practical Training (OPT) is a US work programme that allows eligible international students on F-1 visas to gain temporary work experience related to their field of study after completing their degree.', 3, 4, 'newspic/Indian-student-in-US.webp', '2026-08-05 18:30:00', 18, 0, 1, 1, NULL, 0),
(2, 'A gangland murder in Mumbai, a son’s ‘revenge’ and', 2, 2, 'Life just happened for Kumar Pillai. To grow up as a Tamil boy in the Bombay of the 1970s, to dream of a life in the US like his brother before him, to help his father Krishna Pillai with his smuggling business, to see his father lying dead.\r\n\r\nNow, nearly four decades later, he recalls his 20-year-old self standing in the city’s civic-run Rajawadi Hospital on October 17, 1989, surrounded by his father’s men, many who owed their underworld careers to Krishna Pillai. Inside, the man lay dead, his body pumped with bullets.\r\n\r\nOver the next few years, a string of attacks followed, including the murder of an alleged conspirator in the Krishna Pillai killing. Police saw Kumar ’s hand in the attacks, alleging that he was avenging his father’s murder. The BSc student who dreamt of studying automobile engineering in the US was now “gangster” Kumar Pillai.\r\n\r\nIn 1997, after over six years in jail and an acquittal in the alleged revenge killing case, Kumar moved to Hong Kong, started a life and career there. But the police never took their eyes off him. They alleged that he continued to make extortion and threat calls from Hong Kong. Kumar was once again a wanted man.\r\n\r\nAlmost two decades later, in 2016, the Mumbai Police got Kumar arrested while he was on a trip to Singapore and secured his extradition to India. Back in India, he stood trial but once again, the cases against him fell and, by March 2024, he was acquitted in all.', 3, 4, 'newspic/PIC-1-KUMAR-PILLAI.webp', '2026-08-05 18:30:00', 18, 0, 1, 0, NULL, 0),
(3, 'In Prashant Kishor’s win, BJP’s moment of reckonin', 3, 3, 'Who could have imagined that within weeks of wresting West Bengal from Mamata Banerjee and splitting her Trinamool Congress (TMC) – and Uddhav Thackeray’s Shiv Sena once again – and coming close to mustering a two thirds majority in Parliament to push through the constitutional amendment legislation linked to Delimitation Bill in the current Monsoon Session of Parliament, the BJP dispensation would “sacrifice” Union Education Minister Dharmendra Pradhan to placate protesting youths at Delhi’s Jantar Mantar.\r\n\r\nSimilarly, who would have thought that eight months after sweeping the Bihar Assembly elections and going on to install a BJP Chief Minister on the Pataliputra gaddi for the first time, the BJP would be defeated in one of its', 5, 0, 'newspic/prashant-kishor-4.webp', '2026-08-06 18:30:00', 3, 0, 1, 1, NULL, 0),
(4, 'Trump signs new birthright citizenship rules weeks', 4, 4, 'United States President Donald Trump Thursday signed two new executive orders aimed at curbing birthright citizenship, about five weeks after the country’s Supreme Court rejected his first attempt at the same goal, Reuters reported.\r\n\r\nThe move keeps birthright citizenship at the centre of Trump’s immigration agenda. Unlike his first order, signed on his opening day back in office in 2025, the two new orders seem to be written more narrowly.\r\n\r\nInstead of targeting all children born in the US to parents who are undocumented or live in the country temporarily, the new orders zero in on smaller groups: children born to foreign government or embassy staff, children of people the administration labels “alien enemies,” and children whose parents are found to have used ‘fraud’ to gain citizenship, according to Associated Press (AP).\r\n\r\nTrump\r\nCommerce Secretary Howard Lutnick speaks during an event with President Donald Trump in the Oval Office of the White House. (Photo: AP)\r\nThe second order targets whom the White House calls “birth tourism” pregnant travellers who come to the US mainly to have their child born on American soil, giving the newborn automatic citizenship. Under the new rules, tighter checks would apply to visitors applying for visas with this purpose, Reuters reported.\r\n\r\nSpeaking at the Oval Office, White House aide Stephen Miller said the government considers the practice of birth tourism as “hereby banned.” Trump, too, defended the move, arguing the country is being taken advantage of by people who pay their way into citizenship rather than earn it.\r\n\r\nLegal groups are already lining up against the orders. The American Civil Liberties Union says the effort is bound to fail, given the Supreme Court ruling just weeks ago. ACLU lawyer Cody Wofsy asserted that “birthright citizenship is guaranteed by the Constitution.”', 7, 0, 'newspic/World-1.webp', '2026-08-06 18:30:00', 30, 0, 1, 0, NULL, 0),
(7, 'Experts relied on chits, memory to leak NEET quest', 5, 5, 'The CBI probe into the NEET (UG) paper leak has found that three subject experts took exam questions out of the National Testing Agency (NTA) office in Delhi using different methods — one scrawled questions on paper chits before hiding them while two others memorised the questions, returned to their hotel rooms to either write them down or mark the relevant paragraphs in NCERT textbooks.\r\n\r\nAnd, according to the CBI, they could do this because they were not frisked while exiting the “confidential section”, a wing situated on the first floor of the NTA office, which also lacked a dedicated CCTV live feed monitoring control room.\r\n\r\nThe three subject experts, among 13 named in a chargesheet filed on July 28 before a Delhi fast-track court, have been identified by the CBI as NTA Biology expert Manisha Mandhare, NTA Chemistry expert Pralhad Vithalrao Kulkarni, NTA Physics expert Manisha Sanjay Havaldar.\r\n\r\nRead | ‘Nothing left to discover’: CBI rejects NEET accused’s offer to take lie-detector test\r\nAccording to the CBI, the three subject experts were handed plain paper sheets inside the NTA “confidential section” for translation rough work.\r\n\r\nKulkarni, the CBI probe found, used the sheets to make small chits. He allegedly scrawled all 135 Chemistry questions in brief along with the answer options.\r\n\r\nRead | ‘Be here at 10 am sharp, every minute important’: Delhi judge hearing NEET ‘paper leak’\r\nHe organised special coaching classes with the help of co-accused Manisha Waghmare and dictated the questions to the students along with the options and the correct answers, the probe found.\r\n\r\nRead | Leaked NEET papers took two routes out of Maharashtra: CBI probe\r\nKulkarni did back translation for three sets of questions (135 in total) from March 31 to April 2 this year.\r\n\r\nMandhare, the English to Marathi translator for Botany and back translator for Zoology, would return to her hotel room and mark the relevant paragraphs in NCERT textbooks, according to the CBI. She too conducted special coaching classes for students at her Pune residence, the probe found.', 12, 0, 'newspic/NEET-accused-file-photo_20260806212148.web', '2026-08-06 18:30:00', 0, 0, 0, 0, NULL, 0),
(8, 'Only 3.67% of Punjab under forest cover; 3 Shivali', 5, 5, 'Punjab planted over 45.91 lakh saplings across 5,827 hectares during 2022-23 under the Compensatory Afforestation Fund Management and Planning Authority (CAMPA), yet the state continues to have one of the lowest forest covers in the country, with forests accounting for just 3.67 per cent of its total geographical area.\r\n\r\nThe Punjab CAMPA Annual Report 2022-23, tabled in the Vidhan Sabha on Thursday, shows that against Punjab’s geographical area of 50,362 sq km, forest cover stands at only 1,846.09 sq km.\r\n\r\nAs per the report, Hoshiarpur has 697.31 sq km of forests, accounting for nearly 38 per cent of the state’s total forest cover of 1,846.09 sq km. It is followed by Rupnagar (275.90 sq km) and Pathankot (192.46 sq km). Together, these three Shivalik districts account for 1,165.67', 12, 0, 'newspic/siswan-.webp', '2026-08-06 18:30:00', 104, 0, 1, 0, NULL, 0),
(101, 'NASA discovers ancient alien city ruins on Mars', 2, 4, 'Scientists claim recent high-res images show massive pyramids and structures on the Martian surface.', 3, 4, 'newspic/World-1.webp', '2026-08-10 04:30:00', 450, 0, 1, 1, NULL, 0),
(102, 'Entire Pacific island mysteriously vanishes overni', 4, 4, 'A small island in the Pacific Ocean completely disappeared from maps following seismic activity.', 7, 4, 'newspic/break.jpg', '2026-08-10 06:00:00', 890, 0, 1, 0, NULL, 0),
(103, '500-year-old hidden treasure found in Himalayan ca', 5, 5, 'Local shepherds claim to have stumbled upon a cave filled with ancient gold and silver coins.', 12, 0, 'newspic/siswan-.webp', '2026-08-10 06:45:00', 1200, 0, 1, 1, NULL, 0),
(104, 'New miracle seed grows fully grown apples in 24 ho', 3, 3, 'Viral posts falsely claim scientists created a modified seed that yields instant fruit.', 5, 0, 'newspic/sunset.jpg', '2026-08-10 07:30:00', 310, 0, 1, 0, NULL, 0),
(105, 'Giant mythical flying creature spotted over city s', 4, 4, 'A viral video showing a massive bird-like shadow in the clouds was exposed as CGI editing.', 7, 0, 'newspic/zilla.jpg', '2026-08-10 08:50:00', 540, 0, 1, 0, NULL, 0),
(106, 'Miracle pill promises to cut weight in half overni', 1, 1, 'Fake online advertisements claim a single dose burns all body fat without exercise.', 2, 1, 'newspic/hydfraud.jpg', '2026-08-10 10:15:00', 2101, 0, 1, 1, NULL, 0),
(107, 'Mysterious wooden chest full of gold washes ashore', 5, 5, 'Beachgoers found an old wooden box containing vintage coins, which experts proved was a prank.', 12, 0, 'newspic/crime hyd.jpg', '2026-08-10 10:40:00', 670, 0, 1, 0, NULL, 0),
(108, 'Scientists invent laser beam system to stop rain s', 2, 2, 'Social media posts falsely report a new technology capable of pushing storm clouds away.', 3, 4, 'newspic/chenent.jpg', '2026-08-10 11:30:00', 150, 0, 1, 0, NULL, 0),
(109, 'Massive fresh water ocean discovered inside Moon s', 2, 4, 'A fake report claims lunar drilling revealed a hidden underground ocean system.', 3, 4, 'newspic/Indian-student-in-US.webp', '2026-08-10 13:00:00', 980, 0, 1, 0, NULL, 0),
(110, 'Heavy snowfall covers Sahara Desert in viral video', 4, 4, 'Old footage of a different region was digitally altered to show snow dunes in the Sahara.', 7, 0, 'newspic/break.jpg', '2026-08-10 13:30:00', 430, 0, 1, 0, NULL, 0),
(111, 'DIY free energy fan runs forever using basic magne', 3, 3, 'A misleading video tutorial claims magnetic force can power ceiling fans infinitely without power.', 5, 0, 'newspic/hydfraud.jpg', '2026-08-11 02:30:00', 1120, 0, 1, 0, NULL, 0),
(112, '1000-year-old sunken train spotted in ocean depths', 5, 5, 'Fact-checkers debunked images claiming a medieval train wreck was found on the seabed.', 12, 0, 'newspic/protest.jpg', '2026-08-11 03:45:00', 870, 0, 1, 0, NULL, 0),
(113, 'Plants near 5G tower wither in seconds, viral post', 2, 2, 'Edited pictures circulating online falsely link mobile tower radiation to instant plant decay.', 3, 4, 'newspic/siswan-.webp', '2026-08-11 05:15:00', 390, 0, 1, 0, NULL, 0),
(114, 'Edited video shows sun rising twice in single nigh', 4, 4, 'Arctic summer video clips were manipulated to create a hoax about multiple sun rises.', 7, 0, 'newspic/sunset.jpg', '2026-08-11 05:50:00', 650, 0, 1, 0, NULL, 0),
(115, 'Home remedy guarantees 100% eyesight recovery in 7', 1, 1, 'Medical experts warn against a viral post advocating unverified oil drops for vision correction.', 2, 1, 'newspic/sonam.jpg', '2026-08-11 06:30:00', 1450, 0, 1, 0, NULL, 0),
(116, 'Glowing blue meteorite crash lands in farm field', 2, 4, 'Photographs of illuminated glass sculptures were falsely shared as fallen cosmic rocks.', 3, 4, 'newspic/zilla.jpg', '2026-08-11 08:00:00', 510, 0, 1, 0, NULL, 0),
(117, 'Real mermaid body found on remote beach, claims po', 5, 5, 'An artistic silicone sculpture was misrepresented as biological evidence of a mermaid.', 12, 0, 'newspic/break.jpg', '2026-08-11 08:40:00', 3200, 0, 1, 0, NULL, 0),
(118, 'Charge your smartphone using just a potato and cop', 3, 3, 'A recycled internet prank claims root vegetables can fast-charge modern lithium batteries.', 5, 0, 'newspic/hydfraud.jpg', '2026-08-11 09:30:00', 940, 0, 1, 0, NULL, 0),
(119, 'Massive ancient pyramid spotted beneath Antarctica', 4, 4, 'Edited Google Earth satellite screenshots were used to fabricate claims of polar ruins.', 7, 0, 'newspic/World-1.webp', '2026-08-11 10:55:00', 1890, 0, 1, 0, NULL, 0),
(120, 'Instant hair growth shampoo grows full beard in 10', 1, 1, 'Manipulated before-and-after photos were used to promote an unregistered cosmetic product.', 2, 1, 'newspic/and.jpg', '2026-08-11 12:10:00', 780, 0, 1, 0, NULL, 0),
(121, 'Buffalo meat exports cross $5 billion, on track to', 2, 2, 'Which is India’s best-performing agricultural export item?\r\n\r\nThe answer: Buffalo meat, the shipments of which surged by 25.6% to $5.1 billion in 2025-26 (April-March). The current fiscal has seen further growth, a whopping 66.6% from $896.8 million in April-June 2025 to nearly $1.5 billion in April-June 2026.\r\n\r\n“We crossed $5 billion for the first time last fiscal and are on track to do $6 billion-plus in 2026-27,” said a Commerce Ministry official.\r\n\r\nBut it’s not just overall value increase. More impressive is the value realisation per tonne.\r\n\r\nIn 2014-15, India exported 14.8 lakh tonnes (lt) of buffalo meat worth $4.8 billion, translating into an average value of $3,240 per tonne. The subsequent years till 2023-24 recorded a drop in the value as well as quantity of exports (see charts), and also average', 3, 4, 'newspic/Buffalo-meat.webp', '2026-08-19 03:19:15', 0, 0, 1, 0, NULL, 0),
(122, 'World News Live Updates: UAE warns of possible ‘mi', 2, 2, 'The UAE’s defence ⁠ministry ​said its ​air ​defence systems ⁠detected a ‌missile threat on ⁠Tuesday, according ⁠to an X post ​by ‌the ministry. The ministry wrote, “UAE Air Defence Systems have detected a missile threat directed towards the country. Kindly follow warnings and updates issued through official channels. The Ministry of Defence clarifies that, if any sounds are heard, they are the result of air defence interceptions.”\r\n\r\nUAE’s National Emergency Crisis and Disaster Management Authority on Tuesday said that its air defence systems detected a missile threat targeting the country. The agency added, “Please remain in a safe location and follow warnings and updates issued through official channels.”\r\n\r\nPakistan top court orders Imran Khan to be moved to hospital from jail, says his party\r\nPakistan’s Supreme Court ordered former Prime Minister Imran Khan to be moved from jail to a hospital on Tuesday, according to his PTI party. Khan has been in jail since August 2023, after he was convicted in a string of cases that he claims were politically driven following his ouster. “It’s a very welcome ‌order, and we wish it had happened sooner so his eye and general health would not have deteriorated this much,” PTI spokesperson Zulfikar Bukhari said, according to news agency Reuters. “He should remain in hospital until all doctors are satisfied,” he said. The top court directed the former Pak PM to be moved to Shifa International Hospital ⁠within 48 hours and remain there until September 16, Khan’s spokesperson Naeem Haider Panjutha ⁠said on ‌X.\r\n\r\n‘Very positive’ US-Iran talks ongoing, says Trump’s envoy\r\nThe UK’s Maritime Trade Operations agency (UKMTO) said it had received a report of an incident in the Strait of Hormuz, with a vessel struck by an unidentified projectile while making an outbound transit. The strike damaged the ship’s engine room and left one crew member dead, UKMTO said, adding that the rest of the crew were being helped by the Omani Coast Guard. The incident comes as the US-Iran memorandum aimed at de-escalating hostilities lapsed without renewal, with President Trump telling Fox News on Monday that Tehran should raise the “white flag” in the five-month US-Israel conflict.\r\n\r\nDespite claiming to have opened a direct backchannel with Iran’s Revolutionary Guard, Trump said he’s in no rush to strike a deal, even as he threatened military action against US ally Oman if it interferes with reopening the blockaded Strait of Hormuz a threat that lands as Iran and Oman work on a joint arrangement to keep the waterway open to commercial shipping.\r\n\r\nAmid the rising tensions, Turkish President Tayyip Erdogan pressed Trump in a phone call on Tuesday to pursue diplomacy, offering Ankara’s support for peace efforts, according to the Turkish presidency. The call came hours after a senior Iranian official told Reuters that Tehran would shift to a “fully offensive” military posture, with talks on a permanent end to the war having stalled and Washington ruling out extending the ceasefire.', 3, 4, 'newspic/US-attack-in-iran-AP.webp', '2026-08-19 03:27:40', 0, 0, 1, 0, NULL, 0),
(123, 'PM Modi’s man in Nitin Nabin’s core team: The Guja', 2, 2, 'As part of the ongoing reshuffle within the BJP leadership, the party’s national president Nitin Nabin on Tuesday appointed Rajya Sabha MP Tarun Chugh, 53, as the party’s Gujarat in-charge with immediate effect. This marks the end of the nearly 10-year tenure of Union Minister Bhupender Yadav, 57, as the BJP’s Gujarat in-charge.\r\n\r\nNabin also appointed the BJP’s newly appointed national secretary from Gujarat, Jagdish Patel, 62, as the party’s co-in-charge for Uttar Pradesh. Patel, known to be close to Prime Minister Narendra Modi, is learnt to haveAs part of the ongoing reshuffle within the BJP leadership, the party’s national president Nitin Nabin on Tuesday appointed Rajya Sabha MP Tarun Chugh, 53, as the party’s Gujarat in-charge with immediate effect. This marks the end of the nearly 10-year tenure of Union Minister Bhupender Yadav, 57, as the BJP’s Gujarat in-charge.\r\n\r\nNabin also appointed the BJP’s newly appointed national secretary from Gujarat, Jagdish Patel, 62, as the party’s co-in-charge for Uttar Pradesh. Patel, known to be close to Prime Minister Narendra Modi, is learnt to haveAs part of the ongoing reshuffle within the BJP leadership, the party’s national president Nitin Nabin on Tuesday appointed Rajya Sabha MP Tarun Chugh, 53, as the party’s Gujarat in-charge with immediate effect. This marks the end of the nearly 10-year tenure of Union Minister Bhupender Yadav, 57, as the BJP’s Gujarat in-charge.\r\n\r\nNabin also appointed the BJP’s newly appointed national secretary from Gujarat, Jagdish Patel, 62, as the party’s co-in-charge for Uttar Pradesh. Patel, known to be close to Prime Minister Narendra Modi, is learnt to have', 3, 4, 'newspic/Jagdish-Patel-1.webp', '2026-08-19 03:31:24', 0, 0, 1, 0, NULL, 0),
(124, 'PM Modi’s man in Nitin Nabin’s core team: The Guja', 2, 2, 'As part of the ongoing reshuffle within the BJP leadership, the party’s national president Nitin Nabin on Tuesday appointed Rajya Sabha MP Tarun Chugh, 53, as the party’s Gujarat in-charge with immediate effect. This marks the end of the nearly 10-year tenure of Union Minister Bhupender Yadav, 57, as the BJP’s Gujarat in-charge.\r\n\r\nNabin also appointed the BJP’s newly appointed national secretary from Gujarat, Jagdish Patel, 62, as the party’s co-in-charge for Uttar Pradesh. Patel, known to be close to Prime Minister Narendra Modi, is learnt to haveAs part of the ongoing reshuffle within the BJP leadership, the party’s national president Nitin Nabin on Tuesday appointed Rajya Sabha MP Tarun Chugh, 53, as the party’s Gujarat in-charge with immediate effect. This marks the end of the nearly 10-year tenure of Union Minister Bhupender Yadav, 57, as the BJP’s Gujarat in-charge.\r\n\r\nNabin also appointed the BJP’s newly appointed national secretary from Gujarat, Jagdish Patel, 62, as the party’s co-in-charge for Uttar Pradesh. Patel, known to be close to Prime Minister Narendra Modi, is learnt to haveAs part of the ongoing reshuffle within the BJP leadership, the party’s national president Nitin Nabin on Tuesday appointed Rajya Sabha MP Tarun Chugh, 53, as the party’s Gujarat in-charge with immediate effect. This marks the end of the nearly 10-year tenure of Union Minister Bhupender Yadav, 57, as the BJP’s Gujarat in-charge.\r\n\r\nNabin also appointed the BJP’s newly appointed national secretary from Gujarat, Jagdish Patel, 62, as the party’s co-in-charge for Uttar Pradesh. Patel, known to be close to Prime Minister Narendra Modi, is learnt to have', 3, 4, 'newspic/Jagdish-Patel-1.webp', '2026-08-19 03:31:24', 0, 0, 1, 0, '2026-08-19 09:05:00', 0),
(125, 'The TATA succession battle: Over to Noel', 2, 2, 'It was set to be a done deal. Had it been put to vote, Natarajan Chandrasekaran would have sailed through, securing another term as chairman of Tata Sons, the holding company of the 158-year-old Tata Group. After all, four of the six board members were in his favour. But that day, February 24, 2026, the boardroom was tense. One man on the board, Noel Tata, had tough questions — about losses made by several companies in the $180 billion group, about its possible public listing, and what justified another term for Chandrasekaran as\r\nIt was set to be a done deal. Had it been put to vote, Natarajan Chandrasekaran would have sailed through, securing another term as chairman of Tata Sons, the holding company of the 158-year-old Tata Group. After all, four of the six board members were in his favour. But that day, February 24, 2026, the boardroom was tense. One man on the board, Noel Tata, had tough questions — about losses made by several companies in the $180 billion group, about its possible public listing, and what justified another term for Chandrasekaran as\r\nIt was set to be a done deal. Had it been put to vote, Natarajan Chandrasekaran would have sailed through, securing another term as chairman of Tata Sons, the holding company of the 158-year-old Tata Group. After all, four of the six board members were in his favour. But that day, February 24, 2026, the boardroom was tense. One man on the board, Noel Tata, had tough questions — about losses made by several companies in the $180 billion group, about its possible public listing, and what justified another term for Chandrasekaran as', 3, 4, 'newspic/Noel-Tata.webp', '2026-08-19 03:41:13', 0, 0, 1, 0, NULL, 0),
(126, 'Employee in morning, protester by evening: Meet th', 2, 2, 'On Monday night, as heavy rain lashed Ranchi, scores of people, dressed in formal office uniform, stood waiting outside the Jharkhand Mantralaya.\r\n\r\nOne of them was Roshan Kumar, 30, speaking to his parents over the phone, crying inconsolably. “Everything is over, mumma,” he told them, repeatedly.\r\n\r\nJust hours earlier, Roshan was an Assistant Section Officer (ASO) posted at Nepal House, having joined the government posting this January, after a legal battle over the JSSC-CGL examination.\r\n\r\nBy Tuesday, he was no longer sure if he had a job.\r\n\r\nOn Monday evening, following a prolonged agitation by students demanding action over alleged irregularities, the state government cancelled the Jharkhand Staff Selection Commission — Combined Graduate Level (JSSC-CGL) examination. The move — though hailed by those protesting alleged irregularities and pushing for exam cancellations \r\nOn Monday night, as heavy rain lashed Ranchi, scores of people, dressed in formal office uniform, stood waiting outside the Jharkhand Mantralaya.\r\n\r\nOne of them was Roshan Kumar, 30, speaking to his parents over the phone, crying inconsolably. “Everything is over, mumma,” he told them, repeatedly.\r\n\r\nJust hours earlier, Roshan was an Assistant Section Officer (ASO) posted at Nepal House, having joined the government posting this January, after a legal battle over the JSSC-CGL examination.\r\n\r\nBy Tuesday, he was no longer sure if he had a job.\r\n\r\nOn Monday evening, following a prolonged agitation by students demanding action over alleged irregularities, the state government cancelled the Jharkhand Staff Selection Commission — Combined Graduate Level (JSSC-CGL) examination. The move — though hailed by those protesting alleged irregularities and pushing for exam cancellations \r\nOn Monday night, as heavy rain lashed Ranchi, scores of people, dressed in formal office uniform, stood waiting outside the Jharkhand Mantralaya.\r\n\r\nOne of them was Roshan Kumar, 30, speaking to his parents over the phone, crying inconsolably. “Everything is over, mumma,” he told them, repeatedly.\r\n\r\nJust hours earlier, Roshan was an Assistant Section Officer (ASO) posted at Nepal House, having joined the government posting this January, after a legal battle over the JSSC-CGL examination.\r\n\r\nBy Tuesday, he was no longer sure if he had a job.\r\n\r\nOn Monday evening, following a prolonged agitation by students demanding action over alleged irregularities, the state government cancelled the Jharkhand Staff Selection Commission — Combined Graduate Level (JSSC-CGL) examination. The move — though hailed by those protesting alleged irregularities and pushing for exam cancellations ', 3, 4, 'newspic/Jharkhand-protest-2.webp', '2026-08-19 03:42:35', 2, 0, 1, 0, '2026-08-19 09:15:00', 0),
(129, 'US green card backlog: Indian EB-2 wait could stre', 2, 2, 'An Indian professional applying for an employment-based green card (permanent residence) in the United States this year may have to wait for an estimated 179 years due to a massive immigration backlog, according to an analysis by a US-based think tank.\r\n\r\nThe report stated that Indian professionals are projected to face the longest delays due to visa backlogs and statutory limits imposed on the number of green cards issued each year.\r\n\r\nNearly 1 million Indians stuck in green card backlog\r\nThe analysis, published by the National Foundation for American Policy (NFAP), highlights that nearly 1 million people from India are stuck in the employment-based immigration backlog, which makes up 79 per cent of the total green card stockpile as of December 2025.\r\n\r\nThe report states that nationality-based green cards disproportionately affect Indian nationals compared to Chinese and Philippine nationals.\r\n\r\nEB-2 wait for Indians could stretch to 179 years\r\nThe report estimates that a highly skilled worker from India with a labour certification application or employment-based immigrant petition filed in January 2026 could face a potential wait of 4 to 5 years for EB-1, 179 years for EB-2, and 38 years for EB-3 visa categories.', 3, 0, 'newspic/US-6-3.webp', '2026-09-01 17:54:54', 0, 0, 1, 0, '2026-09-01 23:26:00', 0),
(130, 'Virat Kohli’s advice, Lewis Hamilton example help ', 2, 2, 'Coach Devendra Sharma seldom starts his day by sending WhatsApp messages. On Tuesday, though, he did.\r\n\r\n“Today will be the most important innings of your career so far. Lamba khelna hai (play long),” read his message to his student, Sanat Sangwan.\r\n\r\nSharma had reason to invest such weight in a message. A year ago, his most famous protégé, Rishabh Pant, had wandered into the nets at Sonnet Cricket Club in Delhi and asked, as he does on every visit, who the next big talent might be. The coach pointed to a left-hander mid-stroke.\r\n\r\n“That’s Sanat Sangwan,” he said. “Remember the name. You’ll see him in the Indian team one day.”\r\n\r\nSanat has not disappointed his coach since. In the 2025-26 Ranji Trophy, Sanat finished third on the batting charts, with 828 runs. But nothing in that tally carried the weight of Tuesday’s assignment. South Zone held a 117-run first-innings lead in the Duleep Trophy semi-final. The result seemed a foregone conclusion, but Sanat’s 76 at least ensured that the game reached the fourth day.', 3, 0, 'newspic/news.webp', '2026-09-01 18:15:04', 0, 0, 1, 0, '2026-09-01 23:46:00', 0),
(131, 'As accountant’s phone is hacked, sugar trader lose', 2, 2, 'A Pune-based sugar trader lost a staggering Rs three crore in an invasive form of a whale-phishing attack within an hour on Monday. Police said that the cyber fraudsters hacked his accountant’s phone, made it appear as though messages were being sent by the trader himself and then used the ruse to get three money transfers made from the company’s bank account.\r\n\r\nAccording to an FIR registered at the Pune City Cyber Police Station on Monday, the fraud took place in less than an hour on the morning of August 31. The complainant, a 42-year-old sugar trader, runs the business through a family-owned trading firm based in Market Yard. The complainant told police that his accountant, who has been working with the firm for around nine years, received a WhatsApp message from an unknown number saved under the trader’s name at around 10.47 am. The message sought details of the firm’s internet banking balance. The accountant responded that the account had a balance of around Rs 8.50 crore.\r\n\r\nSoon after, the accountant received details of a Bank of Baroda account along with a WhatsApp message asking him to “transfer 3 Cr”. Believing the messages were from the trader, the accountant used the company’s accounting software to make three transfers of Rs one crore each. Probe has revealed these transfers were made to a mule accounts Rewa districts of Madhya Pradesh.\r\n\r\nThe fraud came to light when the trader was contacted by the accountant for a GST number relating to the transaction. The trader told him that he had neither initiated any such transaction nor instructed anyone to transfer money. On checking the accountant’s computer, the company found that Rs three crore had been transferred from its account to the beneficiary account in three transactions.\r\n\r\nThe trader also checked the accountant’s mobile phone and found that his own name had been used to save the WhatsApp number from which the instructions were sent. However, the WhatsApp number and the conversation subsequently disappeared from the device.\r\n\r\nDuring further questioning, the accountant told the trader that he had received a suspicious file named “Transaction_Details_31/08/2026 img” two days earlier from another unknown number. A second accountant working with the firm had also reportedly received the same file. “Probe suggests that this malware was used to compromise the accountants phone, hack into the contacts and use the compromised device for the fraud,” said an officer. Police have registered a case under provisions of the Information Technology Act and the Bharatiya Nyaya Sanhita relating to cheating and criminal conspiracy. Police Inspector Sharad Shelke has been assigned the investigation.\r\n\r\nAn officer from the Cyber police station said, “Whale phishing, also known as a boss scam or CEO scam, is a highly targeted form of phishing in which fraudsters specifically target senior executives, business owners or individuals with access to large sums of money. Unlike conventional phishing, it involves studying the victim’s communication patterns and relationships to make fraudulent messages appear genuine. In a typical whale-phishing attempt, fraudsters may contact the victim from an unknown number using a CEO’s name and photograph. In this more invasive form, however, the attackers gain access to an existing device or account, use the victim’s chats and continue conversations within the same thread, mimicking earlier communication patterns and context.”\r\n\r\nHow to avoid such attacks\r\nCyber police advise companies to treat payment instructions received through messaging applications with caution. Every request involving large fund transfers or changes in beneficiary accounts should be independently verified through a phone call to a known and previously verified number. Organisations should regularly review active WhatsApp Web sessions, enable multi-factor authentication, restrict installation of unverified software and conduct periodic cyber-security audits. Finance teams should also adopt dual-approval mechanisms for high-value transactions and undergo regular awareness training to recognise signs of phishing and account compromise, officials said.', 3, 4, 'newspic/phishing_20260901184526.webp', '2026-09-01 19:28:39', 0, 0, 1, 0, NULL, 0),
(132, 'Lionel Messi’s international retirement: Football ', 2, 2, 'If words could cry, Lionel Messi’s emotionally-constructed retirement sentences, rather than a full-fledged speech, did. The lines were posted on Instagram, a platform that did not exist when he first wore the sky blue and white stripes of Argentina 21 years ago, and defined the shirt and its hallowed number – 10.\r\n\r\nThe lines were somewhat platitudinal yet so powerful that the reader could visualise Messi uttering those words, with hollow, sunken eyes; words stuttering, breath choking, the suffocating silence of the long pauses, the shrill voice echoing in the room, the applause and tears, the chaos and uproar in the room, and the immeasurable emptiness. “Time is running short, chapters come to a close, and this is one that hurts me deeply,” he wrote.\r\n\r\nEmptiness strikes. It is not simply the power of words, but the power of Messi’s persona. The audience doubt the authenticity of the news, a part of their mind is still inclined to believe that it’s all a handiwork of an expert hacker; they reel in the belief that something more was left of him, an unseen trick or turn, a conviction that his talent hadn’t quite reached its end point. It is the intimacy that Messi had forged between him and his legion\r\nIf words could cry, Lionel Messi’s emotionally-constructed retirement sentences, rather than a full-fledged speech, did. The lines were posted on Instagram, a platform that did not exist when he first wore the sky blue and white stripes of Argentina 21 years ago, and defined the shirt and its hallowed number – 10.\r\n\r\nThe lines were somewhat platitudinal yet so powerful that the reader could visualise Messi uttering those words, with hollow, sunken eyes; words stuttering, breath choking, the suffocating silence of the long pauses, the shrill voice echoing in the room, the applause and tears, the chaos and uproar in the room, and the immeasurable emptiness. “Time is running short, chapters come to a close, and this is one that hurts me deeply,” he wrote.\r\n\r\nEmptiness strikes. It is not simply the power of words, but the power of Messi’s persona. The audience doubt the authenticity of the news, a part of their mind is still inclined to believe that it’s all a handiwork of an expert hacker; they reel in the belief that something more was left of him, an unseen trick or turn, a conviction that his talent hadn’t quite reached its end point. It is the intimacy that Messi had forged between him and his legion', 3, 0, 'newspic/Messi-Argentina-2026-WC.webp', '2026-09-01 19:29:50', 0, 0, 1, 0, '2026-09-02 01:01:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `uid` int(5) NOT NULL,
  `name` text NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` text NOT NULL,
  `photo` varchar(50) NOT NULL,
  `cat_id` int(5) NOT NULL,
  `loc_id` int(5) NOT NULL,
  `is_verified` int(5) NOT NULL DEFAULT 0,
  `is_deleted` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`uid`, `name`, `mobile`, `email`, `password`, `role`, `photo`, `cat_id`, `loc_id`, `is_verified`, `is_deleted`) VALUES
(1, 'admin', '783597234', 'admin@gmail.com', '$2y$10$DRR', 'admin', 'profilepics/604e362cb4554680a58b09f7cef689f8.jpg', 1, 1, 1, 0),
(2, 'member', '9823672934', 'member@gmail.com', 'asdf', 'member', 'profilepics/2019-06-15-07-53-28-389.jpg', 1, 1, 1, 0),
(3, 'reporter', '9823678293', 'reporter@gmail.com', 'asdf', 'reporter', '', 2, 2, 1, 0),
(4, 'editor', '925273852', 'editor@gmail.com', '$2y$10$2FJ', 'editor', '', 2, 2, 1, 0),
(5, 'reporter2', '9376347934', 'reporter2@gmail.com', 'asdf', 'reporter', '', 3, 3, 1, 0),
(6, 'editor2', '987628472', 'editor2@gmail.com', 'asdf', 'editor', '', 3, 3, 1, 0),
(7, 'reporter3', '9435675697', 'reporter3@gmail.com', 'asdf', 'reporter', '', 4, 4, 1, 0),
(8, 'editor3', '9368837462', 'editor3@gmail.com', 'asdf', 'editor', '', 4, 4, 1, 0),
(11, 'member1', '92572358', 'member1@gmail.com', 'asdf', 'member', '', 1, 1, 1, 0),
(12, 'reporter4', '925629876', 'reporter4@gmail.com', 'asdf', 'reporter', '', 5, 5, 1, 0),
(13, 'editor4', '92729837', 'editor4@gmail.com', 'asdf', 'editor', '', 5, 5, 1, 0),
(14, 'Aszad Raza', '0797035023', 'raszad75@gmail.com', 'asdf', 'editor', '', 5, 5, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `internal_chat`
--
ALTER TABLE `internal_chat`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `news_table`
--
ALTER TABLE `news_table`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `n_location_id` (`n_location_id`),
  ADD KEY `n_category_id` (`n_category_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `loc_id` (`loc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `com_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `internal_chat`
--
ALTER TABLE `internal_chat`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `loc_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `news_table`
--
ALTER TABLE `news_table`
  MODIFY `nid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `uid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news_table` (`nid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news_table`
--
ALTER TABLE `news_table`
  ADD CONSTRAINT `news_table_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `user_details` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `news_table_ibfk_2` FOREIGN KEY (`n_category_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_details_ibfk_3` FOREIGN KEY (`loc_id`) REFERENCES `location` (`loc_id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `publish_scheduled_news` ON SCHEDULE EVERY 1 MINUTE STARTS '2026-08-19 09:15:04' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE news_table
SET
    is_publish = 1,
    is_scheduled = 0
WHERE
    is_scheduled = 1
    AND is_publish = 0
    AND is_delete = 0
    AND scheduled_publish_at <= NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
