-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 29, 2021 at 10:31 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ttcar_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessory`
--

CREATE TABLE `accessory` (
                             `id` int(11) NOT NULL,
                             `mark_id` int(11) DEFAULT NULL,
                             `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `year` int(11) DEFAULT NULL,
                             `price` int(11) DEFAULT NULL,
                             `item_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessory`
--

INSERT INTO `accessory` (`id`, `mark_id`, `libelle`, `year`, `price`, `item_img`) VALUES
                                                                                      (1, 1, 'Plein d\'essence', 0, 45, 'petrol-616ec47fd37d8.png'),
(2, 1, 'Siège enfant', 2017, 30, 'baby-car-seat-616ec49872ea3.png'),
(3, 2, 'Plein d\'essence', 0, 45, 'petrol-616fd43178c94.png'),
                                                                                      (4, 2, 'Siège enfant', 2017, 30, 'baby-car-seat-616fd444ac2c0.png');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
                        `id` int(11) NOT NULL,
                        `category_post_id` int(11) NOT NULL,
                        `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `create_at` date NOT NULL,
                        `post_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `category_post_id`, `title`, `content`, `author`, `create_at`, `post_img`) VALUES
                                                                                                         (1, 1, 'Test1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'slothie', '2021-10-19', 'cookie-616ec69968e1d.png'),
                                                                                                         (2, 2, 'Test2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'slothie', '2021-10-19', 'cookie-616ec6a8b7aec.png'),
                                                                                                         (3, 3, 'Test3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'slothie', '2021-10-19', 'cookie-616ec6bdda009.png');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
                        `id` int(11) NOT NULL,
                        `mark_id` int(11) NOT NULL,
                        `ranges_id` int(11) NOT NULL,
                        `price_id` int(11) DEFAULT NULL,
                        `price_supplier_id` int(11) DEFAULT NULL,
                        `margin` int(11) DEFAULT NULL,
                        `fuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roof_rack` int(11) NOT NULL,
                        `chains` int(11) DEFAULT NULL,
                        `selling_price` int(11) DEFAULT NULL,
                        `years` int(11) NOT NULL,
                        `passenger` int(11) NOT NULL,
                        `door` int(11) NOT NULL,
                        `transmission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `clim` tinyint(1) NOT NULL,
                        `contact_actived` tinyint(1) NOT NULL,
                        `co2` int(11) NOT NULL,
                        `luggage` int(11) NOT NULL,
                        `items` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
                        `is_online` tinyint(1) NOT NULL,
                        `date_start` date NOT NULL,
                        `date_end` date NOT NULL,
                        `car_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `min_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `mark_id`, `ranges_id`, `price_id`, `price_supplier_id`, `margin`, `fuel`, `name`, `roof_rack`, `chains`, `selling_price`, `years`, `passenger`, `door`, `transmission`, `description`, `clim`, `contact_actived`, `co2`, `luggage`, `items`, `is_online`, `date_start`, `date_end`, `car_img`, `min_days`) VALUES
                                                                                                                                                                                                                                                                                                                                          (1, 1, 1, 1, 1, 15, 'essence', 'G21-Mégane Diesel BVM GPS Europe', 3, 5, 20000, 1999, 5, 3, 'Auto', 'G21-Mégane Diesel BVM GPS Europe', 1, 0, 200, 5, 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}', 1, '2021-10-05', '2022-04-30', 'renault-megane-berline-big-616ec35e32018.jpg', 1),
                                                                                                                                                                                                                                                                                                                                          (2, 2, 2, 2, 2, 15, 'essence', 'G21 - 308 - DIESEL - BVA', 3, 5, 20000, 1999, 9, 3, 'Auto', 'G21 - 308 - DIESEL - BVA', 1, 1, 200, 5, 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}', 1, '2021-10-19', '2022-02-28', 'peugeot-308-berline-big-616ec41977b2f.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_post`
--

CREATE TABLE `category_post` (
                                 `id` int(11) NOT NULL,
                                 `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_post`
--

INSERT INTO `category_post` (`id`, `name`) VALUES
                                               (1, 'Divers'),
                                               (2, 'Guide du TT'),
                                               (3, 'Mise à jours');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
                           `id` int(11) NOT NULL,
                           `create_at` date NOT NULL,
                           `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `is_read` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_cars`
--

CREATE TABLE `contact_cars` (
                                `id` int(11) NOT NULL,
                                `create_at` date NOT NULL,
                                `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                `car_id` int(11) NOT NULL,
                                `is_read` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_douane`
--

CREATE TABLE `contact_douane` (
                                  `id` int(11) NOT NULL,
                                  `create_at` date NOT NULL,
                                  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `is_read` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
                           `id` int(11) NOT NULL,
                           `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `name_fr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `code`, `name_fr`, `name_en`) VALUES
                                                               (1, 'FR', 'France', 'France'),
                                                               (2, 'Lib', 'Liban', 'Libanon'),
                                                               (3, 'ES', 'Espagne', 'Spain'),
                                                               (4, 'AMES', 'Amerique', 'America'),
                                                               (5, 'IT', 'Italie', 'Italia');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
                            `id` int(11) NOT NULL,
                            `nationality_id` int(11) DEFAULT NULL,
                            `reason_id` int(11) DEFAULT NULL,
                            `user_id` int(11) DEFAULT NULL,
                            `adress_country_id` int(11) DEFAULT NULL,
                            `adress_country_hue_id` int(11) DEFAULT NULL,
                            `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `phone` int(11) NOT NULL,
                            `adress_ue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `adress_no_ue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `birthdays_date` date NOT NULL,
                            `country_birth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `pice_identity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `number_piece` int(11) NOT NULL,
                            `delivery_piece` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `name_young` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `date_piece` date NOT NULL,
                            `adress_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `adress_city_hue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `adress_code` int(11) NOT NULL,
                            `adress_code_hue` int(11) NOT NULL,
                            `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `customer_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `birth_postal` int(11) NOT NULL,
                            `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nationality_id`, `reason_id`, `user_id`, `adress_country_id`, `adress_country_hue_id`, `name`, `username`, `phone`, `adress_ue`, `adress_no_ue`, `birthdays_date`, `country_birth`, `pice_identity`, `number_piece`, `delivery_piece`, `name_young`, `date_piece`, `adress_city`, `adress_city_hue`, `adress_code`, `adress_code_hue`, `email`, `customer_type`, `birth_postal`, `profession`) VALUES
    (1, 2, 1, 1, 4, 4, 'Mister', 'Testeur', 623159999, '123 City', '123 rue du test', '2021-11-25', 'Angola', 'Passport', 123123123, 'Test Valley', 'Test', '2021-11-11', 'L.A', 'LocalTest', 98200, 127001, 'queille.johanna@gmail.com', 'mr', 92320, 'Testeur de flow');

-- --------------------------------------------------------

--
-- Table structure for table `mark`
--

CREATE TABLE `mark` (
                        `id` int(11) NOT NULL,
                        `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `mark_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `margin` int(11) DEFAULT NULL,
                        `delivery_days` int(11) DEFAULT NULL,
                        `max_days` int(11) DEFAULT NULL,
                        `min_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mark`
--

INSERT INTO `mark` (`id`, `libelle`, `mark_img`, `margin`, `delivery_days`, `max_days`, `min_days`) VALUES
                                                                                                        (1, 'Renault', 'renault-icon-616ec13033e37.png', 10, 5, 199, 1),
                                                                                                        (2, 'Peugeot', 'peugeottrans-616ec19ed84ba.png', 15, 5, 199, 1),
                                                                                                        (3, 'Citroën', 'citroentrans-616ec2515288d.png', 5, 5, 199, 1),
                                                                                                        (4, 'DS', 'dstrans-616ec279e4b8b.png', 5, 5, 199, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
                               `id` int(11) NOT NULL,
                               `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `name_fr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`id`, `code`, `name_fr`, `name_en`) VALUES
                                                                   (1, 'FRZS', 'Francaise', 'French'),
                                                                   (2, 'AM', 'Americaine', 'American');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
                              `id` int(11) NOT NULL,
                              `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `follow_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
                         `id` int(11) NOT NULL,
                         `country_id` int(11) DEFAULT NULL,
                         `nationality_id` int(11) DEFAULT NULL,
                         `adress_country_hue_id` int(11) DEFAULT NULL,
                         `reason_id` int(11) DEFAULT NULL,
                         `create_date` date NOT NULL,
                         `place_plane` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `car_libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `customer_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `customer_old_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `customer_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `postal_code` int(11) NOT NULL,
                         `phone` int(11) NOT NULL,
                         `birth_date` date NOT NULL,
                         `birth_postal` int(11) NOT NULL,
                         `birth_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `birth_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `passport_number` int(11) NOT NULL,
                         `passport_date` date NOT NULL,
                         `passport_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `depart_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `depart_price` int(11) NOT NULL,
                         `depart_date` date NOT NULL,
                         `return_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `return_price` int(11) NOT NULL,
                         `return_date` date NOT NULL,
                         `basic_price` int(11) NOT NULL,
                         `promotions` int(11) DEFAULT NULL,
                         `price` int(11) NOT NULL,
                         `update_at` date DEFAULT NULL,
                         `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `adress_more` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `adress_more_no_ue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `adress_no_ue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `adress_city_hue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `adress_code_hue` int(11) DEFAULT NULL,
                         `items` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
                         `count_items` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
                         `plane_date2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `number_plane` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `promo_libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `count_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `country_id`, `nationality_id`, `adress_country_hue_id`, `reason_id`, `create_date`, `place_plane`, `car_libelle`, `customer_type`, `customer_name`, `customer_old_name`, `customer_username`, `adress`, `city`, `postal_code`, `phone`, `birth_date`, `birth_postal`, `birth_city`, `birth_country`, `passport_number`, `passport_date`, `passport_place`, `depart_place`, `depart_price`, `depart_date`, `return_place`, `return_price`, `return_date`, `basic_price`, `promotions`, `price`, `update_at`, `lang`, `email`, `adress_more`, `adress_more_no_ue`, `adress_no_ue`, `adress_city_hue`, `adress_code_hue`, `items`, `count_items`, `plane_date2`, `number_plane`, `comment`, `password`, `profession`, `mark`, `promo_libelle`, `count_days`) VALUES
    (1, 4, 2, 4, 1, '2021-11-22', 'AIRFRR', 'G21-Mégane Diesel BVM GPS Europe', 'null', 'Mister', NULL, 'Testeur', '123 City', 'L.A', 98200, 623159999, '2021-11-25', 98200, '123 City', 'Angola', 123123123, '2021-11-11', 'Test Valley', 'Charle de gaulle', 100, '2021-12-13', 'Charle de gaulle', 100, '2022-01-08', 1200, NULL, 1200, NULL, 'fr', 'queille.johanna@gmail.com', NULL, NULL, '123 rue du test', 'LocalTest', 127001, 'N;', 'N;', '10:41:00', '78672A', NULL, NULL, 'Testeur de flow', 'Renault', 'null', 27);

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
                         `id` int(11) NOT NULL,
                         `brand_id_id` int(11) DEFAULT NULL,
                         `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `libelle_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `full_adress_fr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `full_adress_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `create_at` date DEFAULT NULL,
                         `update_at` date DEFAULT NULL,
                         `delete_at` date DEFAULT NULL,
                         `place_pdf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `brand_id_id`, `libelle`, `libelle_en`, `latitude`, `longitude`, `full_adress_fr`, `full_adress_en`, `create_at`, `update_at`, `delete_at`, `place_pdf`) VALUES
                                                                                                                                                                                        (1, 1, 'Charle de gaulle', 'charle de gaulle airport', '49.009691', '2.547925', '95700 Roissy-en-France', '95700 Roissy-en-France', '2021-10-19', NULL, NULL, 'TTcarOrder56-2-616ec6f907adf.pdf'),
                                                                                                                                                                                        (2, 1, 'Toulouse', 'Toulouse', '49.009691', '2.547925', '10 avenue saint exupery', '8 bis place', '2021-10-19', NULL, NULL, 'TTcarOrder56-2-616ec8239c1ef.pdf'),
                                                                                                                                                                                        (3, 2, 'Charle de gaulle', 'charle de gaulle airport', '49.009691', '2.547925', '95700 Roissy-en-France', '95700 Roissy-en-France', '2021-10-19', NULL, NULL, 'TTcarOrder56-2-616ec83bc24e9.pdf'),
                                                                                                                                                                                        (4, 2, 'Roissy', 'Roissy', '49.009691', '2.547925', '10 avenue saint exupery', '8 bis place', '2021-10-19', NULL, NULL, 'TTcarOrder56-1-616ec85b7a85a.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `place_extra`
--

CREATE TABLE `place_extra` (
                               `id` int(11) NOT NULL,
                               `brand` int(11) NOT NULL,
                               `extra_1` int(11) NOT NULL,
                               `extra_2` int(11) NOT NULL,
                               `days_limit` int(11) NOT NULL,
                               `create_at` date NOT NULL,
                               `update_at` date DEFAULT NULL,
                               `deleted_at` date DEFAULT NULL,
                               `free` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place_extra`
--

INSERT INTO `place_extra` (`id`, `brand`, `extra_1`, `extra_2`, `days_limit`, `create_at`, `update_at`, `deleted_at`, `free`) VALUES
                                                                                                                                  (1, 1, 100, 120, 45, '2021-10-19', NULL, NULL, 0),
                                                                                                                                  (2, 1, 100, 120, 45, '2021-10-19', NULL, NULL, 1),
                                                                                                                                  (3, 2, 100, 120, 45, '2021-10-19', NULL, NULL, 0),
                                                                                                                                  (4, 2, 100, 120, 45, '2021-10-19', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `place_extra_place`
--

CREATE TABLE `place_extra_place` (
                                     `place_extra_id` int(11) NOT NULL,
                                     `place_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place_extra_place`
--

INSERT INTO `place_extra_place` (`place_extra_id`, `place_id`) VALUES
                                                                   (1, 1),
                                                                   (2, 2),
                                                                   (3, 3),
                                                                   (4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
                         `id` int(11) NOT NULL,
                         `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `price` int(11) NOT NULL,
                         `date_start` date NOT NULL,
                         `date_end` date NOT NULL,
                         `date_start_delivery` date NOT NULL,
                         `date_end_delivery` date NOT NULL,
                         `price_supplier_value` int(11) NOT NULL,
                         `promo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `libelle`, `price`, `date_start`, `date_end`, `date_start_delivery`, `date_end_delivery`, `price_supplier_value`, `promo`) VALUES
                                                                                                                                                          (1, '1', 1200, '2021-10-12', '2022-04-30', '2021-10-19', '2022-04-30', 1000, 30),
                                                                                                                                                          (2, '2', 1500, '2021-10-19', '2022-01-31', '2021-10-19', '2022-01-31', 1000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `price_supplier`
--

CREATE TABLE `price_supplier` (
                                  `id` int(11) NOT NULL,
                                  `price_customer_id` int(11) DEFAULT NULL,
                                  `price` int(11) NOT NULL,
                                  `date_start` date NOT NULL,
                                  `date_end` date NOT NULL,
                                  `date_start_delivery` date NOT NULL,
                                  `date_end_delivery` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_supplier`
--

INSERT INTO `price_supplier` (`id`, `price_customer_id`, `price`, `date_start`, `date_end`, `date_start_delivery`, `date_end_delivery`) VALUES
                                                                                                                                            (1, 1, 1000, '2021-10-12', '2022-04-30', '2021-10-19', '2022-04-30'),
                                                                                                                                            (2, 2, 1000, '2021-10-19', '2022-01-31', '2021-10-19', '2022-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
                              `id` int(11) NOT NULL,
                              `place_delivery_id` int(11) DEFAULT NULL,
                              `mark_id` int(11) DEFAULT NULL,
                              `place_departure_id` int(11) DEFAULT NULL,
                              `type_id` int(11) DEFAULT NULL,
                              `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `value` int(11) NOT NULL,
                              `start_date` date NOT NULL,
                              `end_date` date NOT NULL,
                              `start_delivery` date NOT NULL,
                              `end_delivery` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `place_delivery_id`, `mark_id`, `place_departure_id`, `type_id`, `libelle`, `description`, `value`, `start_date`, `end_date`, `start_delivery`, `end_delivery`) VALUES
                                                                                                                                                                                                    (1, 1, NULL, 1, 1, '30', '30% sur toute la gamme', 30, '2021-01-01', '2023-01-01', '2021-01-01', '2023-01-01'),
                                                                                                                                                                                                    (2, 2, 1, 1, 1, '30', '30% sur toute la marque', 30, '2021-01-01', '2024-01-01', '2021-01-01', '2024-01-01'),
                                                                                                                                                                                                    (3, 3, 2, 2, 1, '30', '30% sur toute la marque', 30, '2021-01-01', '2023-01-01', '2021-02-01', '2023-01-01'),
                                                                                                                                                                                                    (4, NULL, 3, NULL, 1, '30', '30% sur toute la marque', 30, '2021-01-01', '2025-01-01', '2021-01-01', '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `promotions_range`
--

CREATE TABLE `promotions_range` (
                                    `promotions_id` int(11) NOT NULL,
                                    `range_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions_range`
--

INSERT INTO `promotions_range` (`promotions_id`, `range_id`) VALUES
    (1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo_code`
--

CREATE TABLE `promo_code` (
                              `id` int(11) NOT NULL,
                              `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `active` tinyint(1) NOT NULL,
                              `value` int(11) NOT NULL,
                              `type_promo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_code`
--

INSERT INTO `promo_code` (`id`, `code`, `active`, `value`, `type_promo`) VALUES
    (1, '1234', 1, 30, '%');

-- --------------------------------------------------------

--
-- Table structure for table `range`
--

CREATE TABLE `range` (
                         `id` int(11) NOT NULL,
                         `mark_id` int(11) NOT NULL,
                         `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `range_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                         `extra_cost` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `range`
--

INSERT INTO `range` (`id`, `mark_id`, `libelle`, `range_img`, `extra_cost`) VALUES
                                                                                (1, 1, 'RENAULT Mégane Berline', 'renault-megane-berline-big-616ec30ec07b4.jpg', 1),
                                                                                (2, 2, 'PEUGEOT 308 Berline', 'peugeot-308-berline-big-616ec3dc82b4c.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
                          `id` int(11) NOT NULL,
                          `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`id`, `content`) VALUES
                                           (1, 'Touriste'),
                                           (2, 'Etudiant'),
                                           (3, 'Stage'),
                                           (4, 'Chargée de mission'),
                                           (5, 'Membre de mission / Journaliste');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
                                          `id` int(11) NOT NULL,
                                          `user_id` int(11) NOT NULL,
                                          `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                                          `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                                          `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slice`
--

CREATE TABLE `slice` (
                         `id` int(11) NOT NULL,
                         `tarif_id` int(11) DEFAULT NULL,
                         `mark_id` int(11) DEFAULT NULL,
                         `code_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                         `value` int(11) NOT NULL,
                         `days` int(11) NOT NULL,
                         `price_supplier_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slice`
--

INSERT INTO `slice` (`id`, `tarif_id`, `mark_id`, `code_price`, `value`, `days`, `price_supplier_value`) VALUES
                                                                                                             (1, 1, 1, 'TT1', 45, 22, 45),
                                                                                                             (2, 2, 2, 'TT1', 45, 22, 20);

-- --------------------------------------------------------

--
-- Table structure for table `slice_supplier`
--

CREATE TABLE `slice_supplier` (
                                  `id` int(11) NOT NULL,
                                  `price_id` int(11) DEFAULT NULL,
                                  `mark_id` int(11) DEFAULT NULL,
                                  `code_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `value` int(11) NOT NULL,
                                  `days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slice_supplier`
--

INSERT INTO `slice_supplier` (`id`, `price_id`, `mark_id`, `code_price`, `value`, `days`) VALUES
                                                                                              (1, 1, 1, 'TT1', 45, 22),
                                                                                              (2, 2, 2, 'TT1', 20, 22);

-- --------------------------------------------------------

--
-- Table structure for table `type_promo`
--

CREATE TABLE `type_promo` (
                              `id` int(11) NOT NULL,
                              `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_promo`
--

INSERT INTO `type_promo` (`id`, `type`) VALUES
                                            (1, '%'),
                                            (2, 'Jour'),
                                            (3, '€');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
                        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `create_at` date NOT NULL,
                        `is_verified` tinyint(1) NOT NULL,
                        `is_customer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `roles`, `password`, `create_at`, `is_verified`, `is_customer`) VALUES
    (1, 'queille.johanna@gmail.com', 'slothDev', '[\"ROLE_ADMIN\"]', '$2y$13$WcIAvysA4GJm1rgoZfBjWezDtia7.eoqrpAAGqiokCjie/IR1iG1q', '2021-10-19', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessory`
--
ALTER TABLE `accessory`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A1B1251C4290F12B` (`mark_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C01551438C514352` (`category_post_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_95C71D144290F12B` (`mark_id`),
  ADD KEY `IDX_95C71D145B3DBCEF` (`ranges_id`),
  ADD KEY `IDX_95C71D14D614C7E7` (`price_id`),
  ADD KEY `IDX_95C71D142D04219A` (`price_supplier_id`);

--
-- Indexes for table `category_post`
--
ALTER TABLE `category_post`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_cars`
--
ALTER TABLE `contact_cars`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_douane`
--
ALTER TABLE `contact_douane`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_81398E09E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_81398E09A76ED395` (`user_id`),
  ADD KEY `IDX_81398E091C9DA55` (`nationality_id`),
  ADD KEY `IDX_81398E0959BB1592` (`reason_id`),
  ADD KEY `IDX_81398E09D3711A23` (`adress_country_id`),
  ADD KEY `IDX_81398E09A8A84437` (`adress_country_hue_id`);

--
-- Indexes for table `mark`
--
ALTER TABLE `mark`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398F92F3E70` (`country_id`),
  ADD KEY `IDX_F52993981C9DA55` (`nationality_id`),
  ADD KEY `IDX_F5299398A8A84437` (`adress_country_hue_id`),
  ADD KEY `IDX_F529939859BB1592` (`reason_id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_741D53CD24BD5740` (`brand_id_id`);

--
-- Indexes for table `place_extra`
--
ALTER TABLE `place_extra`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_extra_place`
--
ALTER TABLE `place_extra_place`
    ADD PRIMARY KEY (`place_extra_id`,`place_id`),
  ADD KEY `IDX_80735BC91CE7845` (`place_extra_id`),
  ADD KEY `IDX_80735BC9DA6A219` (`place_id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_supplier`
--
ALTER TABLE `price_supplier`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F99C5769944C8FE5` (`price_customer_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EA1B30341CE62185` (`place_delivery_id`),
  ADD KEY `IDX_EA1B30344290F12B` (`mark_id`),
  ADD KEY `IDX_EA1B3034A6B17FBF` (`place_departure_id`),
  ADD KEY `IDX_EA1B3034C54C8C93` (`type_id`);

--
-- Indexes for table `promotions_range`
--
ALTER TABLE `promotions_range`
    ADD PRIMARY KEY (`promotions_id`,`range_id`),
  ADD KEY `IDX_418CE0010007789` (`promotions_id`),
  ADD KEY `IDX_418CE002A82D0B1` (`range_id`);

--
-- Indexes for table `promo_code`
--
ALTER TABLE `promo_code`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `range`
--
ALTER TABLE `range`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93875A494290F12B` (`mark_id`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `slice`
--
ALTER TABLE `slice`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3DAE78A5357C0A59` (`tarif_id`),
  ADD KEY `IDX_3DAE78A54290F12B` (`mark_id`);

--
-- Indexes for table `slice_supplier`
--
ALTER TABLE `slice_supplier`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CB1CD8D8D614C7E7` (`price_id`),
  ADD KEY `IDX_CB1CD8D84290F12B` (`mark_id`);

--
-- Indexes for table `type_promo`
--
ALTER TABLE `type_promo`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessory`
--
ALTER TABLE `accessory`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_post`
--
ALTER TABLE `category_post`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_cars`
--
ALTER TABLE `contact_cars`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_douane`
--
ALTER TABLE `contact_douane`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mark`
--
ALTER TABLE `mark`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `place_extra`
--
ALTER TABLE `place_extra`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `price_supplier`
--
ALTER TABLE `price_supplier`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promo_code`
--
ALTER TABLE `promo_code`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `range`
--
ALTER TABLE `range`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slice`
--
ALTER TABLE `slice`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slice_supplier`
--
ALTER TABLE `slice_supplier`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `type_promo`
--
ALTER TABLE `type_promo`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessory`
--
ALTER TABLE `accessory`
    ADD CONSTRAINT `FK_A1B1251C4290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`);

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
    ADD CONSTRAINT `FK_C01551438C514352` FOREIGN KEY (`category_post_id`) REFERENCES `category_post` (`id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
    ADD CONSTRAINT `FK_95C71D142D04219A` FOREIGN KEY (`price_supplier_id`) REFERENCES `price_supplier` (`id`),
  ADD CONSTRAINT `FK_95C71D144290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`),
  ADD CONSTRAINT `FK_95C71D145B3DBCEF` FOREIGN KEY (`ranges_id`) REFERENCES `range` (`id`),
  ADD CONSTRAINT `FK_95C71D14D614C7E7` FOREIGN KEY (`price_id`) REFERENCES `price` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
    ADD CONSTRAINT `FK_81398E091C9DA55` FOREIGN KEY (`nationality_id`) REFERENCES `nationality` (`id`),
  ADD CONSTRAINT `FK_81398E0959BB1592` FOREIGN KEY (`reason_id`) REFERENCES `reason` (`id`),
  ADD CONSTRAINT `FK_81398E09A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_81398E09A8A84437` FOREIGN KEY (`adress_country_hue_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `FK_81398E09D3711A23` FOREIGN KEY (`adress_country_id`) REFERENCES `country` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
    ADD CONSTRAINT `FK_F52993981C9DA55` FOREIGN KEY (`nationality_id`) REFERENCES `nationality` (`id`),
  ADD CONSTRAINT `FK_F529939859BB1592` FOREIGN KEY (`reason_id`) REFERENCES `reason` (`id`),
  ADD CONSTRAINT `FK_F5299398A8A84437` FOREIGN KEY (`adress_country_hue_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `FK_F5299398F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Constraints for table `place`
--
ALTER TABLE `place`
    ADD CONSTRAINT `FK_741D53CD24BD5740` FOREIGN KEY (`brand_id_id`) REFERENCES `mark` (`id`);

--
-- Constraints for table `place_extra_place`
--
ALTER TABLE `place_extra_place`
    ADD CONSTRAINT `FK_80735BC91CE7845` FOREIGN KEY (`place_extra_id`) REFERENCES `place_extra` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_80735BC9DA6A219` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `price_supplier`
--
ALTER TABLE `price_supplier`
    ADD CONSTRAINT `FK_F99C5769944C8FE5` FOREIGN KEY (`price_customer_id`) REFERENCES `price` (`id`);

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
    ADD CONSTRAINT `FK_EA1B30341CE62185` FOREIGN KEY (`place_delivery_id`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `FK_EA1B30344290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`),
  ADD CONSTRAINT `FK_EA1B3034A6B17FBF` FOREIGN KEY (`place_departure_id`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `FK_EA1B3034C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_promo` (`id`);

--
-- Constraints for table `promotions_range`
--
ALTER TABLE `promotions_range`
    ADD CONSTRAINT `FK_418CE0010007789` FOREIGN KEY (`promotions_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_418CE002A82D0B1` FOREIGN KEY (`range_id`) REFERENCES `range` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `range`
--
ALTER TABLE `range`
    ADD CONSTRAINT `FK_93875A494290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
    ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `slice`
--
ALTER TABLE `slice`
    ADD CONSTRAINT `FK_3DAE78A5357C0A59` FOREIGN KEY (`tarif_id`) REFERENCES `price` (`id`),
  ADD CONSTRAINT `FK_3DAE78A54290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`);

--
-- Constraints for table `slice_supplier`
--
ALTER TABLE `slice_supplier`
    ADD CONSTRAINT `FK_CB1CD8D84290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`),
  ADD CONSTRAINT `FK_CB1CD8D8D614C7E7` FOREIGN KEY (`price_id`) REFERENCES `price_supplier` (`id`);
