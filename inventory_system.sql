-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 30, 2024 at 12:43 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `sale_id`, `user_id`, `qty`) VALUES
(56, 15, 37, 3),
(57, 14, 37, 47),
(61, 16, 37, 8),
(62, 16, 28, 3),
(63, 17, 34, 3),
(65, 15, 34, 2),
(66, 14, 28, 1),
(68, 18, 28, 5),
(69, 18, 34, 6);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(2, 'Medicine'),
(3, 'Malaria'),
(4, 'Diabetes');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `status` enum('Pending','Delivered','Received') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `sale_id`, `price`, `qty`, `order_date`, `invoice`, `status`) VALUES
(19, 28, 14, 100, 1, '2024-07-28', '1806884902', 'Pending'),
(20, 28, 14, 100, 1, '2024-07-28', '11229742', 'Pending'),
(21, 28, 18, 43, 2, '2024-07-28', '785899547', 'Delivered'),
(22, 28, 18, 43, 2, '2024-07-28', '185955894', 'Delivered'),
(23, 28, 18, 43, 2, '2024-07-28', '1866842870', 'Delivered'),
(24, 28, 18, 43, 2, '2024-07-28', '419782586', 'Delivered'),
(25, 28, 18, 43, 2, '2024-07-28', '565119880', 'Delivered'),
(26, 28, 18, 43, 2, '2024-07-28', '565119880', 'Delivered'),
(27, 28, 18, 43, 2, '2024-07-28', '1831575723', 'Delivered'),
(28, 28, 18, 43, 2, '2024-07-28', '1831575723', 'Delivered'),
(29, 28, 18, 43, 2, '2024-07-28', '288016226', 'Delivered'),
(30, 28, 18, 43, 2, '2024-07-28', '51881783', 'Delivered'),
(31, 28, 18, 43, 1, '2024-07-28', '385210350', 'Delivered'),
(32, 28, 18, 43, 2, '2024-07-28', '1622248083', 'Delivered'),
(33, 34, 18, 43, 2, '2024-07-28', '1008598686', 'Received'),
(34, 34, 18, 43, 1, '2024-07-30', '669212420', 'Pending'),
(35, 34, 18, 43, 2, '2024-07-30', '1242282664', 'Pending'),
(36, 34, 18, 43, 2, '2024-07-30', '1821737243', 'Pending'),
(37, 34, 18, 43, 2, '2024-07-30', '940955234', 'Pending'),
(38, 34, 18, 43, 2, '2024-07-30', '257713916', 'Pending'),
(39, 34, 18, 43, 1, '2024-07-30', '1516112346', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `blood_sugar` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_name`, `surname`, `date_of_birth`, `gender`, `weight`, `height`, `respiratory_rate`, `blood_sugar`, `bmi`, `Email`) VALUES
(5, 'Judercio', 'Nhauche', '2002-02-18', 'Female', '66.00', '56.00', 67, '33.00', '210.46', 'judercio.nhauche@ashesi.edu.gh'),
(6, 'Judercio', 'James', '2024-07-11', 'Female', '44.00', '44.00', 566, '67.00', '227.27', 'judercio.nhauche@ashesi.edu.gh'),
(7, 'Reynolds', 'Jacinta', '2024-07-03', 'Female', '22.00', '22.00', 22, '22.00', '454.55', 'judercio.nhauche@ashesi.edu.gh');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `amount`, `payment_date`, `payment_method`, `user_id`) VALUES
(2, 34, '43.00', '2024-07-30', 'Paystack', 34),
(3, 36, '86.00', '2024-07-30', 'Paystack', 34),
(4, 37, '86.00', '2024-07-30', 'Paystack', 34),
(5, 38, '86.00', '2024-07-30', 'Paystack', 34),
(6, 39, '43.00', '2024-07-30', 'Paystack', 34);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `instructions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `pharma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `item`, `price`, `qty`, `category_id`, `date`, `barcode`, `brand_name`, `pharma_id`) VALUES
(39, 'Acetaminophen And Diphenhydramine Citrate 10 coated caplets', 43, 2, 3, '2024-07-28 20:09:30', '0319810001818', 'Excedrin', 34);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `barcode` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `distributor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `item`, `price`, `qty`, `total`, `category_id`, `added_date`, `barcode`, `brand`, `distributor_id`) VALUES
(14, 'Flu Therapy & Fever Relief 24 liqui-gels', '100.00', 0, '1000.00', 2, '2024-07-27 00:51:50', '0319810007698', 'Bristol-Myers Squibb', 36),
(15, 'Castor Oil', '200.00', 0, '400.00', 3, '2024-07-27 00:52:24', '0318858501328', 'Flamingo', 36),
(16, 'Pain Reliever Pain Reliever Aid 24 tablet', '90.00', 0, '450.00', 4, '2024-07-27 00:52:57', '0319810007902', 'Excedrin', 36),
(17, 'Alertness Aid 60 caplets', '70.00', 0, '210.00', 3, '2024-07-27 00:53:17', '0319810006257', 'Bristol-Myers Squibb', 36),
(18, 'Acetaminophen And Diphenhydramine Citrate 10 coated caplets', '43.00', 2, '1419.00', 3, '2024-07-28 19:36:02', '0319810001818', 'Excedrin', 35);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(10, 'Joao', 'Joao', 'Judercio', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 1, 'no_image.jpg', 1, NULL),
(28, 'Judercio', 'Nhauche', 'judercio.nhauche@ashesi.edu.gh', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 1, 'no_image.jpg', 1, '2024-07-30 12:37:12'),
(29, 'John', 'Stones', '@j30000', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 2, 'no_image.jpg', 0, '2024-07-16 10:31:14'),
(30, 'Judy', 'Nhauche', 'Ishmael', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 1, 'no_image.jpg', 1, NULL),
(31, 'Judy', 'Nhauche', 'Judercion', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 1, 'no_image.jpg', 1, NULL),
(32, 'Judy', 'Nhauche', 'Jose', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 1, 'no_image.jpg', 1, '2024-05-22 17:06:57'),
(33, 'Judy', 'Nhauche', 'Joster', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 1, 'no_image.jpg', 1, NULL),
(34, 'Chelsea', 'Nhauche', 'Chelsea@2008', '6ba8bea990536fc1e76b0d8e014f1697f7dfe6c9', 2, 'no_image.jpg', 1, '2024-07-30 12:37:54'),
(35, 'Junior', 'James', 'Junior@gmail.com', '0fe6c366f52204d0663b58bb6e47c5debc9cb439', 3, 'no_image.jpg', 1, '2024-07-28 20:08:05'),
(36, 'Rey', 'Rey', 'Rey', '683772ebbfd1630f936bf8c5c49b4d8d9d44a2da', 3, 'no_image.jpg', 1, '2024-07-28 13:29:29'),
(37, 'Rey', 'Reyy', 'Reyy', '683772ebbfd1630f936bf8c5c49b4d8d9d44a2da', 2, 'no_image.jpg', 1, '2024-07-28 13:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Pharmacist', 2, 1),
(3, 'Distributor', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `pharmacist_id` (`user_id`),
  ADD KEY `orders_ibfk_2` (`sale_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`item`),
  ADD KEY `categorie_id` (`category_id`),
  ADD KEY `pharma` (`pharma_id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `distributor` (`distributor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `user_level` (`user_level`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `pharma` FOREIGN KEY (`pharma_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `distributor` FOREIGN KEY (`distributor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
