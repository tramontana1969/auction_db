-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: auction_db:3306
-- Generation Time: Jan 27, 2022 at 12:37 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`administrator`@`%` PROCEDURE `add_auction` (IN `day` DATE, IN `hm` TIME, IN `location` TEXT, IN `descr` TEXT)  INSERT INTO auction (date, time, place, description) VALUES (day, hm, location, descr)$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `add_customer` (IN `person` CHAR(48))  INSERT INTO customer (name) VALUE (person)$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `add_seller` (IN `person` CHAR(48))  INSERT INTO seller (name) VALUE (person)$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `allow_selling` (IN `number` INT, IN `start` INT, IN `descr` TEXT, IN `id_auction` INT, IN `id_item` INT)  BEGIN
UPDATE item SET lot = number WHERE id = id_item;
INSERT INTO auction_item (auction_id, item_id, start_price, description) VALUES (id_auction, id_item, start, descr);
END$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `auction_in_place` (IN `location` CHAR(64))  SELECT date, time, description FROM auction WHERE place = location$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `auction_list` (IN `first` DATE, IN `second` DATE)  SELECT date, place FROM auction WHERE date BETWEEN first AND second$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `customer_list` (IN `start` DATE, IN `end` DATE)  SELECT customer.name, item.name, auction.date
FROM customer JOIN item ON customer.id = item.customer_id JOIN auction_item ON item.id = auction_item.id JOIN auction ON auction.id = auction_item.auction_id
WHERE auction.date BETWEEN start AND end$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `item_list` (IN `first` DATE, IN `second` DATE)  SELECT item.name FROM 
item JOIN auction_item ON item.id = auction_item.item_id JOIN auction ON auction.id = auction_item.auction_id 
WHERE auction.date BETWEEN first AND second$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `salary` ()  SELECT auction.description, auction.date, SUM(auction_item.actual_price) AS salary
FROM auction JOIN auction_item ON auction.id = auction_item.auction_id
GROUP BY auction.id ORDER BY salary$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `sellers_names` (IN `start` DATE, IN `end` DATE)  SELECT seller.name, auction.date
FROM seller JOIN item ON seller.id = item.seller_id JOIN auction_item ON item.id = auction_item.item_id JOIN auction ON auction.id = auction_item.id
WHERE auction.date BETWEEN start AND end$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `seller_list` (IN `start` DATE, IN `end` DATE)  SELECT seller.name, SUM(auction_item.actual_price) AS salary
FROM seller JOIN item ON seller.id = item.seller_id JOIN auction_item ON item.id = auction_item.item_id JOIN auction ON auction.id = auction_item.auction_id
WHERE auction.date BETWEEN start AND end GROUP BY seller.name$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `sell_item` (IN `auction` INT, IN `item` INT, IN `price` INT, IN `descr` TEXT)  INSERT INTO auction_item (auction_id, item_id, start_price, description) VALUES (auction, item, price, descr)$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `update_customer` (IN `person` CHAR(48), IN `num` INT)  UPDATE customer SET name = person WHERE id = num$$

CREATE DEFINER=`administrator`@`%` PROCEDURE `update_seller` (IN `person` CHAR(48), IN `num` INT)  UPDATE seller SET name = person where id = num$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `place` char(64) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`id`, `date`, `time`, `place`, `description`) VALUES
(1, '2022-01-02', '12:00:00', 'New York', 'Some old stuff for selling'),
(2, '2021-11-10', '11:30:00', 'Sydney', 'Selling old original paintings'),
(3, '2021-05-30', '11:00:00', 'Moscow', 'Selling old russian forks'),
(4, '2022-01-04', '15:25:00', 'Minsk', 'Ctoto'),
(5, '2022-01-03', '11:30:00', 'Sydney', 'qwertyuio');

-- --------------------------------------------------------

--
-- Table structure for table `auction_item`
--

CREATE TABLE `auction_item` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `start_price` int(11) NOT NULL,
  `actual_price` int(11) DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auction_item`
--

INSERT INTO `auction_item` (`id`, `auction_id`, `item_id`, `start_price`, `actual_price`, `description`) VALUES
(1, 1, 2, 250000, 800, 'Very old cars'),
(2, 2, 1, 387000000, 525, 'Original Mona Lisa by Da Vinci'),
(3, 2, 3, 150000, 12345, 'An original painting by Salvador Dali'),
(7, 1, 1, 123, NULL, 'wqwq'),
(8, 5, 3, 15000, 250000, 'fdsafdsaf'),
(9, 4, 4, 58, 585, 'mmm'),
(10, 4, 1, 65, 82828282, 'iii');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `name` char(24) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`name`, `id`) VALUES
('Alex Jnson', 1),
('Pamella Crew', 2),
('Amanda Split', 3),
('Paul Morrison', 4),
('Richard Fool', 5);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` char(48) NOT NULL,
  `lot` int(11) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `lot`, `seller_id`, `customer_id`) VALUES
(1, 'Mona Lisa', 123, 1, 1),
(2, 'BMW', 789, 2, 2),
(3, 'La persistencia de la memoria', NULL, 3, 2),
(4, 'weeeee', NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `name` char(24) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`name`, `id`) VALUES
('John Doe', 1),
('Smith Brown', 2),
('Kirill Ivanov', 3),
('Andrew Smith', 4),
('Micahel Useless', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auction_item`
--
ALTER TABLE `auction_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_id` (`auction_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auction_item`
--
ALTER TABLE `auction_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auction_item`
--
ALTER TABLE `auction_item`
  ADD CONSTRAINT `auction_item_ibfk_1` FOREIGN KEY (`auction_id`) REFERENCES `auction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auction_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
