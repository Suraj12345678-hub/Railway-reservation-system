-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: May 03, 2026 at 09:49 AM
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
-- Database: `rail_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `pnr` varchar(12) NOT NULL,
  `user_id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `passenger_name` varchar(100) NOT NULL,
  `passenger_age` int(3) NOT NULL,
  `passenger_gender` varchar(10) NOT NULL,
  `coach` varchar(10) NOT NULL,
  `travel_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Confirmed',
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `pnr`, `user_id`, `train_id`, `passenger_name`, `passenger_age`, `passenger_gender`, `coach`, `travel_date`, `status`, `booking_time`) VALUES
(2, '6178372081', 1, 2, 'ragha', 23, '', '3A', '2026-04-04', 'Cancelled', '2026-04-04 18:31:02'),
(3, '5936568706', 0, 1, 'radhika', 25, 'Female', '3A', '2026-04-04', 'Cancelled', '2026-04-04 18:38:02'),
(4, '8937509646', 1, 1, 'abx', 28, 'Male', '2A', '2026-04-08', 'Confirmed', '2026-04-08 04:02:40'),
(5, '5847305595', 1, 1, 'xr4a3we', 58, 'Male', '3A', '2026-04-08', 'Confirmed', '2026-04-08 04:05:40'),
(6, '5955218988', 1, 1, 'xr4a3we', 58, 'Male', '3A', '2026-04-08', 'Confirmed', '2026-04-08 04:05:55'),
(7, '5188311893', 1, 1, 'xr4a3we', 58, 'Male', '3A', '2026-04-08', 'Confirmed', '2026-04-08 04:06:25'),
(10, '8047480869', 1, 1, 'zxaajhj', 25, 'Male', '2A', '2026-04-08', 'Cancelled', '2026-04-08 15:27:38'),
(11, '9176728752', 1, 1, 'swa', 18, 'Male', '2A', '2026-04-11', 'Confirmed', '2026-04-11 06:58:33'),
(12, '8517248339', 2, 1, 'sd', 25, 'Male', '2A', '2026-05-02', 'Confirmed', '2026-05-02 07:38:10'),
(13, '7487074498', 2, 1, 'Rajesh', 25, 'Male', '2A', '2026-05-02', 'Confirmed', '2026-05-02 09:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `item_type` enum('Veg','Non-Veg') DEFAULT 'Veg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `item_name`, `item_price`, `item_image`, `item_type`) VALUES
(1, 'Veg Maharaja Thali', 150.00, NULL, 'Veg'),
(2, 'Paneer Biryani', 120.00, NULL, 'Veg'),
(3, 'Chicken Dum Biryani', 180.00, NULL, 'Non-Veg'),
(4, 'Breakfast Combo (Poha/Upma)', 60.00, NULL, 'Veg');

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `id` int(11) NOT NULL,
  `train_number` varchar(10) NOT NULL,
  `train_name` varchar(100) NOT NULL,
  `source_station` varchar(100) NOT NULL,
  `destination_station` varchar(100) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `total_seats` int(11) DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`id`, `train_number`, `train_name`, `source_station`, `destination_station`, `departure_time`, `arrival_time`, `fare`, `total_seats`) VALUES
(1, '12123', 'Deccan Queen', 'Pune', 'Mumbai', '07:15:00', '10:25:00', 450.00, 5),
(2, '22105', 'Indrayani Express', 'Pune', 'Mumbai', '18:35:00', '21:05:00', 350.00, 5),
(3, '12951', 'Rajdhani Express', 'Mumbai', 'Delhi', '16:00:00', '08:32:00', 2100.00, 5),
(4, '12010', 'Shatabdi Express', 'Ahmedabad', 'Mumbai', '15:10:00', '21:20:00', 1200.00, 5),
(5, '12105', 'Vidarbha Express', 'Mumbai', 'Nagpur', '19:05:00', '08:55:00', 650.00, 5),
(6, '12222', 'Duronto Express', 'Pune', 'Howrah', '15:15:00', '20:15:00', 2800.00, 5),
(7, '22222', 'Vande Bharat Exp', 'Mumbai', 'Solapur', '16:05:00', '22:40:00', 1300.00, 5),
(8, '11019', 'Konark Express', 'Mumbai', 'Bhubaneswar', '15:15:00', '23:15:00', 850.00, 5),
(9, '12137', 'Punjab Mail', 'Mumbai', 'Firozpur', '19:35:00', '05:10:00', 950.00, 5),
(10, '10111', 'Konkan Kanya Exp', 'Mumbai', 'Goa', '23:05:00', '10:45:00', 550.00, 5),
(11, '789', 'Garibrath', 'Shegaon', 'Bhusaval', '09:07:00', '10:48:00', 200.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `password`, `role`, `created_at`) VALUES
(2, NULL, '1234567890', '$2y$10$vmIHTxhQBJFEAlb8c5HWWe9L.nPMWlfRQsIFxLR0LArcMEHeWV8AK', 'Passenger', '2026-04-04 16:19:43'),
(8, NULL, '9876543210', '$2y$10$TVzMTmpjFKnah83KvXj92uLJgefkWPLrxlg60jgVRvgeYqpU10wb6', 'Administrator', '2026-04-11 07:18:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pnr` (`pnr`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `train_number` (`train_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trains`
--
ALTER TABLE `trains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
