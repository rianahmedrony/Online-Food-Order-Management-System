-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2023 at 05:53 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ice_foods`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `full_name`, `email`, `pass`, `mobile`, `address`) VALUES
(1, 'mehedi', 'Mehedi Hasan Janny', 'mehedi@email.com', '$2y$10$awKJbxKhVc2HPHV/54oQ1.vhQ5vAz9pcued25EWJSNce/ngxSZv8S', '01711000011', 'Khulna, Bangladesh'),
(2, 'Fallen_Amber', 'Md Tohidul Islam', 'tanzid1971@gmail.com', '$2y$10$udiZr068JvHTnuPEtBTDD.8jwJx/013h8adoFl86DkI3z8qfI/gfy', '', ''),
(3, 'Risad', 'Risad Mia', 'risadmia128@gmail.com', '$2y$10$Z2E5.E5hi9.oKpjE0l2/dO/B/wrfom6fd09LXMfKDZKuGvVP54gCi', '', ''),
(4, 'nahid', 'Md Abu Nahid', 'abunahidru23@gmail.com', '$2y$10$ErmitOcM4YWLFp6CRX7yjOY22AO15tyuGA7KbuE76ifQIsEwpiCBe', '', ''),
(5, 'Majumder', 'Prieom', 'prieommajumder1@gmail.com', '$2y$10$rSYr6cgvOQciH6mpAi3jiuoNGIWP9Z2fjcfzhLwIT4f4v5g7dBPsi', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `cat` varchar(25) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `in_stock` int(11) NOT NULL DEFAULT 0,
  `sold` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `cat`, `name`, `price`, `img`, `in_stock`, `sold`) VALUES
(1, 'burgers', 'Burger 1', 150, 'burger-1.png', 1, 1),
(2, 'burgers', 'Burger 2', 220, 'burger-2.png', 3, 2),
(3, 'desserts', 'Dessert 1', 120, 'dessert-1.png', 13, 0),
(4, 'desserts', 'Dessert 2', 130, 'dessert-2.png', 15, 0),
(5, 'desserts', 'Dessert 3', 140, 'dessert-3.png', 7, 0),
(6, 'desserts', 'Dessert 4', 150, 'dessert-4.png', 23, 0),
(7, 'desserts', 'Dessert 5', 160, 'dessert-5.png', 17, 0),
(8, 'desserts', 'Dessert 6', 110, 'dessert-6.png', 11, 0),
(9, 'dishes', 'Dish 1', 140, 'dish-1.png', 19, 0),
(10, 'dishes', 'Dish 2', 160, 'dish-2.png', 9, 0),
(11, 'dishes', 'Dish 3', 200, 'dish-3.png', 8, 0),
(12, 'dishes', 'Dish 4', 210, 'dish-4.png', 5, 0),
(13, 'drinks', 'Drink 1', 110, 'drink-1.png', 12, 0),
(14, 'drinks', 'Drink 2', 80, 'drink-2.png', 16, 0),
(15, 'drinks', 'Drink 3', 90, 'drink-3.png', 10, 0),
(16, 'drinks', 'Drink 4', 100, 'drink-4.png', 21, 0),
(17, 'drinks', 'Drink 5', 120, 'drink-5.png', 30, 0),
(18, 'pizzas', 'Pizza 1', 220, 'pizza-1.png', 25, 0),
(19, 'pizzas', 'Pizza 2', 250, 'pizza-2.png', 16, 0),
(20, 'pizzas', 'Pizza 3', 300, 'pizza-3.png', 14, 0),
(21, 'pizzas', 'Pizza 4', 280, 'pizza-4.png', 8, 0),
(22, 'pizzas', 'Pizza 5', 240, 'pizza-5.png', 18, 0),
(23, 'burgers', 'Burger 3', 270, 'burger-1.png', 19, 0),
(24, 'burgers', 'Burger 4', 225, 'burger-2.png', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `full_name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `total_amount` int(11) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Pending',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cust_id`, `full_name`, `email`, `mobile`, `address`, `total_amount`, `payment_method`, `status`, `date`) VALUES
(1, 1, 'Mehedi Hasan Janny', 'mehedi@email.com', '01711000011', 'Test Address', 590, 'COD', 'Pending', '2023-03-08 09:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `price`, `quantity`) VALUES
(1, 1, 1, 220, 1),
(2, 1, 2, 220, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
