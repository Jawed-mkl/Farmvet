-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 07:00 AM
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
-- Database: `farmvet`
--

-- --------------------------------------------------------

--
-- Table structure for table `farmer`
--

CREATE TABLE `farmer` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `firstn` varchar(50) NOT NULL,
  `lastn` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `image` varchar(150) NOT NULL,
  `location` varchar(100) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer`
--

INSERT INTO `farmer` (`id`, `user_id`, `firstn`, `lastn`, `mail`, `password`, `url_address`, `image`, `location`, `date`) VALUES
(1, 26253554, 'Farmer', 'Farmer', 'farmer@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'farmer.farmer', 'uploads/pexels-rihan-ishan-das-739500-2519332.jpg', 'sidi bel abbes', '1986-06-18'),
(2, 1502958263116636, 'Mohamed', 'Kader', 'moh@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mohamed.kader', 'uploads/pexels-jakeheinemann-1482101.jpg', 'sidi bel abbes', '1975-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `contentid` bigint(20) NOT NULL,
  `likes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `type`, `contentid`, `likes`) VALUES
(1, 'post', 863777733, '[{\"user_id\":\"26253554\",\"date\":\"2024-06-09 00:32:01\"},{\"user_id\":\"1502958263116636\",\"date\":\"2024-06-09 00:33:18\"},{\"user_id\":\"86635830\",\"date\":\"2024-06-09 01:07:24\"}]'),
(2, 'post', 339240, '[{\"user_id\":\"1502958263116636\",\"date\":\"2024-06-09 01:50:21\"},{\"user_id\":\"26253554\",\"date\":\"2024-06-09 05:51:38\"}]'),
(3, 'post', 919235106877072795, '[{\"user_id\":\"323688\",\"date\":\"2024-06-09 02:27:26\"},{\"user_id\":\"26253554\",\"date\":\"2024-06-09 05:51:33\"},{\"user_id\":\"86635830\",\"date\":\"2024-06-09 06:22:22\"}]'),
(4, 'post', 6193, '[{\"user_id\":\"323688\",\"date\":\"2024-06-09 02:28:34\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `msgid` varchar(60) NOT NULL,
  `sender` bigint(20) NOT NULL,
  `receiver` bigint(20) NOT NULL,
  `message` text DEFAULT NULL,
  `file` varchar(500) DEFAULT NULL,
  `received` tinyint(1) NOT NULL DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `delete_sender` tinyint(1) NOT NULL DEFAULT 0,
  `delete_receiver` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msgid`, `sender`, `receiver`, `message`, `file`, `received`, `seen`, `delete_sender`, `delete_receiver`, `date`) VALUES
(1, 'SU#(N_bSX#KO', 26253554, 86635830, 'hello', '', 0, 1, 0, 0, '2024-06-08 15:32:43'),
(2, 'SU#(N_bSX#KO', 26253554, 86635830, 'can i get some help please!!', '', 0, 1, 0, 0, '2024-06-08 15:32:57'),
(3, 'iQ8vapu%)#s6sQmw^75tGS^fADVZ^@9H0-VV(B+GP', 1502958263116636, 323688, 'hi doctor', '', 0, 1, 0, 0, '2024-06-08 15:34:34'),
(4, 'x@$6R^BmmBa*', 323688, 26253554, 'hi', '', 0, 1, 0, 0, '2024-06-08 16:43:52'),
(5, 'iQ8vapu%)#s6sQmw^75tGS^fADVZ^@9H0-VV(B+GP', 323688, 1502958263116636, 'مرحبا', '', 0, 0, 0, 0, '2024-06-08 20:27:21'),
(6, 'SU#(N_bSX#KO', 86635830, 26253554, 'welcome', '', 0, 0, 0, 0, '2024-06-08 21:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `post` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `comments` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `has_image` tinyint(1) NOT NULL,
  `parent` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_id`, `user_id`, `post`, `image`, `comments`, `likes`, `date`, `has_image`, `parent`) VALUES
(1, 863777733, 26253554, 'hi im new here i need some help, and thank you guys', '', 0, 3, '2024-06-08 23:07:24', 0, 0),
(2, 85712529182, 1502958263116636, 'hi brother i hope that you finde someone to help you', '', 0, 0, '2024-06-08 22:33:44', 0, 863777733),
(3, 8088432159086, 86635830, 'hi i\'m in your service contact me', '', 0, 0, '2024-06-08 23:07:21', 0, 863777733),
(4, 339240, 1502958263116636, 'can i ask about vaccination date', 'uploads/sheeps.jpg', 0, 2, '2024-06-09 03:51:38', 1, 0),
(5, 96413230440900599, 323688, 'its the right time ', '', 0, 0, '2024-06-08 23:51:22', 0, 339240),
(6, 5126, 323688, 'welcome i have it available', '', 0, 0, '2024-06-08 23:52:15', 0, 96413230440900599),
(7, 919235106877072795, 323688, 'السلام عليكم معكم البيطري محمد في الخدمة راسلني اذا احتجت اي استفسار', 'uploads/pexels-rdne-6129104.jpg', 0, 3, '2024-06-09 04:22:22', 1, 0),
(8, 6193, 323688, 'موقع المحل سيدي بلعباس بجنب الدائرة', '', 0, 1, '2024-06-09 00:28:34', 0, 919235106877072795);

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `id` bigint(20) NOT NULL,
  `publication_id` bigint(20) NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `texte` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`id`, `publication_id`, `admin_id`, `title`, `texte`, `date`, `image`) VALUES
(1, 7438625595631345489, 22055681102, 'سوق المواشي في الجزائر ', '            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam maxime iure obcaecati voluptatum optio, quaerat quidem consequuntur quas alias velit cupiditate facere, hic error cum, impedit ea exercitationem. Suscipit, incidunt.', '2024-06-08 21:57:08', 'uploads/OIP.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `vet_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  `descreption` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `product_id`, `vet_id`, `name`, `price`, `image`, `descreption`) VALUES
(1, 80213, 323688, 'sirop', 500, 'uploads/sirop.png', 'Animal medicine encompasses treatments and care for the health and well-being of various species, ranging from preventive measures to specialized treatments.'),
(2, 743469, 323688, 'Rabbit haemorrhagic', 650, 'uploads/Rabbit_haemorrhagic.png', 'Animal medicine encompasses treatments and care for the health and well-being of various species, ranging from preventive measures to specialized treatments.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `firstn` varchar(50) NOT NULL,
  `lastn` varchar(50) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `firstn`, `lastn`, `mail`, `password`, `type`, `url_address`, `img`) VALUES
(1, 26253554, 'Farmer', 'Farmer', 'farmer@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'farmer', 'farmer.farmer', 'uploads/pexels-rihan-ishan-das-739500-2519332.jpg'),
(2, 323688, 'Vet', 'Vet', 'vet@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'veterinary', 'vet.vet', 'uploads/pexels-pavel-danilyuk-6753425.jpg'),
(3, 86635830, 'wissal', 'vet', 'amina@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'veterinary', 'amina.vet', 'uploads/pexels-thirdman-5327585.jpg'),
(4, 1502958263116636, 'Mohamed', 'Kader', 'moh@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'farmer', 'mohamed.kader', 'uploads/pexels-jakeheinemann-1482101.jpg'),
(5, 22055681102, 'Admin', 'SBA_22', 'adminsba@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin', 'admin.sba', 'uploads/vet.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `veterinary`
--

CREATE TABLE `veterinary` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `firstn` varchar(50) NOT NULL,
  `lastn` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(100) NOT NULL,
  `bio` text NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veterinary`
--

INSERT INTO `veterinary` (`id`, `user_id`, `firstn`, `lastn`, `mail`, `password`, `url_address`, `date`, `location`, `bio`, `image`) VALUES
(1, 323688, 'Vet', 'Vet', 'vet@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'vet.vet', '1992-06-16', 'sidi bel abbes', 'hi im a veterinary and i live in oran                                                                                                                                                                                                                                                                                   ', 'uploads/pexels-pavel-danilyuk-6753425.jpg'),
(2, 86635830, 'wissal', 'vet', 'amina@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'amina.vet', '2003-05-22', 'oran', 'hi i\'m a veterinary and i live in oran contact me if you need anny help                                                                                                                                                                                                                                                                                   ', 'uploads/pexels-thirdman-5327585.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `farmer`
--
ALTER TABLE `farmer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_address` (`url_address`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `contentid` (`contentid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `received` (`received`),
  ADD KEY `seen` (`seen`),
  ADD KEY `delete_sender` (`delete_sender`),
  ADD KEY `delete_receiver` (`delete_receiver`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`),
  ADD KEY `has_image` (`has_image`),
  ADD KEY `parent` (`parent`);
ALTER TABLE `posts` ADD FULLTEXT KEY `texte` (`post`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail` (`mail`),
  ADD KEY `url_address` (`url_address`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `veterinary`
--
ALTER TABLE `veterinary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `url_address` (`url_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `farmer`
--
ALTER TABLE `farmer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `veterinary`
--
ALTER TABLE `veterinary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
