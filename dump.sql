-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 01, 2021 at 07:29 AM
-- Server version: 5.7.21
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ttcar_www`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessory`
--

CREATE TABLE `accessory` (
                             `id` int(11) NOT NULL,
                             `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `price` int(11) DEFAULT NULL,
                             `year` int(11) DEFAULT NULL,
                             `mark_id` int(11) DEFAULT NULL,
                             `item_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessory`
--

INSERT INTO `accessory` (`id`, `libelle`, `price`, `year`, `mark_id`, `item_img`) VALUES
(1, 'Plein d\'essence', 40, 2020, 1, 'petrol-603e362fb9387.png'),
(2, 'Siège bébé', 35, 2020, 1, 'baby-car-seat-603e3637455e2.png');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` date NOT NULL,
  `post_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `author`, `create_at`, `post_img`, `category_post_id`) VALUES
(3, 'Test1', 'je suis un test d\'article', 'slothie', '2021-03-08', 'default2-6045de7cec020.png', 1),
(4, 'Test2', 'Je suis toujours un test', 'slothie', '2021-03-08', 'default2-6045de8f44fe8.png', 2),
(5, 'Test3', 'Je retest et retest', 'slothie', '2021-03-08', 'default2-6045e07fe719e.png', 4),
(6, 'Test4', 'Je suis un test 4', 'slothie', '2021-03-08', 'default2-6045e254ad273.png', 6),
(7, 'test42', '<p>je suis un <u><strong>test</strong></u></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2><u><strong>dzzsw<em>cccccc</em></strong></u></h2>', 'slothie', '2021-03-11', 'transport-maritime-604a137338e48.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
                        `id` int(11) NOT NULL,
                        `margin` int(11) DEFAULT NULL,
                        `fuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roof_rack` int(11) NOT NULL,
                        `chains` int(11) DEFAULT NULL,
                        `years` int(11) NOT NULL,
                        `selling_price` int(11) DEFAULT NULL,
                        `passenger` int(11) NOT NULL,
                        `door` int(11) NOT NULL,
                        `transmission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `clim` tinyint(1) NOT NULL,
                        `co2` int(11) NOT NULL,
                        `luggage` int(11) NOT NULL,
                        `mark_id` int(11) NOT NULL,
                        `ranges_id` int(11) NOT NULL,
                        `car_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `items` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
                        `is_online` tinyint(1) NOT NULL,
                        `date_start` date NOT NULL,
                        `date_end` date NOT NULL,
                        `price_id` int(11) DEFAULT NULL,
                        `contact_actived` tinyint(1) NOT NULL,
                        `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `margin`, `fuel`, `name`, `roof_rack`, `chains`, `years`, `selling_price`, `passenger`, `door`, `transmission`, `clim`, `co2`, `luggage`, `mark_id`, `ranges_id`, `car_img`, `items`, `is_online`, `date_start`, `date_end`, `price_id`, `contact_actived`, `description`) VALUES
(56, 10, 'diesel', 'G20-Mégane Diesel BVA GPS Europe', 25, 30, 2020, 35000, 5, 4, 'Manuel', 1, 102, 5, 1, 1, 'renault-megane-berline-6007ebe9a4f21.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:1:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}}}', 1, '2020-11-30', '2021-11-20', 1, 1, NULL),
(58, 10, 'diesel', '2019 - Scénic Blue', 25, 30, 2019, 35000, 5, 4, 'Manuel', 1, 102, 5, 1, 1, 'renault-scenics-6007ec642c158.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:2:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}i:1;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:2;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:13:\"Siège bébé\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";r:7;s:27:\"\0App\\Entity\\Accessory\0price\";i:35;}}}', 1, '2020-04-18', '2022-08-24', 2, 0, NULL),
(59, 55, 'diesel', '2019 - 308 DIESEL - BVA', 25, 30, 2019, 35000, 5, 4, 'auto', 1, 102, 5, 2, 3, 'peugeot-308-sw1-big-6007ecbfbd356.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:1:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}}}', 1, '2020-08-13', '2021-11-19', 1, 0, NULL),
(60, 25, 'diesel', '2019 - 508 DIESEL - BVA - GPS', 25, 30, 2020, 35000, 5, 4, 'auto', 1, 102, 5, 2, 4, 'peugeot-508-berline1-big-6007ecee098d4.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:1:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}}}', 1, '2020-07-17', '2021-10-19', 2, 0, NULL),
(61, 10, 'diesel', '2019 - C3 DIESEL- BVM - GPS', 25, 30, 2020, 35000, 5, 4, 'auto', 1, 102, 5, 3, 5, 'citroen-c3-big-6007ed17bdf38.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:2:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}i:1;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:2;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:13:\"Siège bébé\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";r:7;s:27:\"\0App\\Entity\\Accessory\0price\";i:35;}}}', 1, '2020-10-25', '2021-10-26', 1, 0, NULL),
(62, 55, 'diesel', 'C4 - DIESEL - BOITE AUTO - GPS', 25, 30, 2020, 38000, 5, 4, 'auto', 1, 102, 5, 3, 6, 'citroen-c4-berline-big-6007ed433ba97.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:1:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}}}', 1, '2020-03-19', '2021-04-19', 2, 0, NULL),
(63, 10, 'diesel', '2019 - DS7 CROSSBACK - DIESEL - BVA - GPS', 25, 30, 2020, 35000, 5, 4, 'auto', 1, 102, 5, 4, 7, 'ds7-crossback-big-6007ed7b17a5b.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:1:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}}}', 1, '2021-02-14', '2022-11-30', 1, 0, NULL),
(64, 55, 'diesel', '2019 - DS3 CROSSBACK - ESSENCE - BVA - GPS', 25, 30, 2019, 35000, 5, 4, 'Manuel', 1, 102, 5, 4, 8, 'ds3-crossback-big-6007ed9fd9495.jpg', 'O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:1:{i:0;O:20:\"App\\Entity\\Accessory\":5:{s:24:\"\0App\\Entity\\Accessory\0id\";i:1;s:29:\"\0App\\Entity\\Accessory\0libelle\";s:15:\"Plein d\'essence\";s:26:\"\0App\\Entity\\Accessory\0year\";i:2020;s:26:\"\0App\\Entity\\Accessory\0mark\";O:30:\"Proxies\\__CG__\\App\\Entity\\Mark\":7:{s:17:\"__isInitialized__\";b:0;s:19:\"\0App\\Entity\\Mark\0id\";i:1;s:24:\"\0App\\Entity\\Mark\0libelle\";N;s:21:\"\0App\\Entity\\Mark\0cars\";N;s:23:\"\0App\\Entity\\Mark\0ranges\";N;s:24:\"\0App\\Entity\\Mark\0markImg\";N;s:28:\"\0App\\Entity\\Mark\0accessories\";N;}s:27:\"\0App\\Entity\\Accessory\0price\";i:40;}}}', 1, '2021-11-30', '2022-11-30', 2, 0, NULL);

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
(3, 'Informations utiles'),
(4, 'Mise à jours'),
(5, 'Portraits et témoignages d’expatriés'),
(6, 'Revue de presse'),
(7, 'Réductions'),
(8, 'Services aux expatriés');

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

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `create_at`, `email`, `content`, `name`, `is_read`) VALUES
(2, '2021-01-22', 'TTcar@ttcar.com2', 'je suis un test', 'Test_2', 1),
(3, '2021-01-22', 'TTcar@ttcar.com', 'Bonjour je suis intéressée', 'test_42', 0);

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

--
-- Dumping data for table `contact_cars`
--

INSERT INTO `contact_cars` (`id`, `create_at`, `email`, `content`, `name`, `car_id`, `is_read`) VALUES
(1, '2021-03-02', 'test@test.com', 'Je souhaite des renseignement sur la disponibilité de cette voiture\r\n\r\nDu 13 fev au 34 juil', 'testMoi', 56, 1);

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

--
-- Dumping data for table `contact_douane`
--

INSERT INTO `contact_douane` (`id`, `create_at`, `email`, `content`, `name`, `is_read`) VALUES
(1, '2021-03-10', 'Test@douane.fr', 'Je souhaite des info douane', 'douaneMe', 1);

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
(1, 'FRED', 'France', 'French'),
(2, 'AMES', 'Amerique', 'America');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
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
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_piece` date NOT NULL,
  `adress_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress_code` int(11) NOT NULL,
  `adress_code_hue` int(11) NOT NULL,
  `adress_city_hue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_postal` int(11) NOT NULL,
  `adress_country_id` int(11) DEFAULT NULL,
  `adress_country_hue_id` int(11) DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `reason_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `name`, `username`, `phone`, `adress_ue`, `adress_no_ue`, `birthdays_date`, `country_birth`, `pice_identity`, `number_piece`, `delivery_piece`, `name_young`, `email`, `date_piece`, `adress_city`, `adress_code`, `adress_code_hue`, `adress_city_hue`, `customer_type`, `birth_postal`, `adress_country_id`, `adress_country_hue_id`, `nationality_id`, `reason_id`) VALUES
(2, 4, 'dupont', 'Lea', 622188580, '10 av st', 'no', '2021-01-04', 'France', 'Passport', 123, 'domont', 'duponnet', 'testtinggg@add.fr', '2021-01-02', 'Chatillon', 92320, 0, 'no', 'mme', 95200, 1, 1, 1, 1),
(3, 15, 'testkn,', 'moitest', 7864398, 'testasres', 'null', '2021-01-14', 'TestCountry', 'Passport', 986533, 'placetest', 'NULL', 'hfgbcwt@azeis.fr', '2017-01-01', 'tesdrt', 92320, 0, 'null', '', 0, 1, 1, 1, 2),
(4, 23, 'testmoi', 'moitest', 623159999, 'testasres', 'noOOOOOOOOOOOO', '2021-03-12', 'France', 'Passport', 99865339, 'placetest', 'testmoi', 'email@customer.com', '2021-03-12', 'sarcelles', 95200, 75007, 'sarcelles', 'mr', 92320, 1, 1, 2, 5),
(5, 24, 'testmoi', 'moitest', 623159999, 'testasres', 'noOOOOOOOOOOOO', '2021-03-05', 'France', 'Passport', 99865339, 'placetest', 'testmoi', 'email@customer42.com', '2021-03-06', 'sarcelles', 95200, 75007, 'sarcelles', 'mme', 95200, 1, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201217090006', '2020-12-17 09:02:17', 120);

-- --------------------------------------------------------

--
-- Table structure for table `mark`
--

CREATE TABLE `mark` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `margin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mark`
--

INSERT INTO `mark` (`id`, `libelle`, `mark_img`, `margin`) VALUES
(1, 'Renault', 'logo-Renault-5ffc0c0daff48.png', 35),
(2, 'Peugeot', 'logo-peugeot-5ffc0c59dbb93.png', 20),
(3, 'Citroën', 'Logo-Citroen-1-5ffc0cb5aff89.jpg', 15),
(4, 'DS Automobile', 'dsauto-5ffc0d306891d.jpg', 15);

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
(1, 'FRCDE', 'Francaise', 'French'),
(2, 'FRZS', 'Americaine', 'American');

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
  `create_date` date NOT NULL,
  `place_plane` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `adress_no_ue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress_city_hue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress_code_hue` int(11) DEFAULT NULL,
  `car_libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `plane_date2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_plane` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress_more` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress_more_no_ue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `reason_id` int(11) DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `adress_country_hue_id` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `create_date`, `place_plane`, `customer_type`, `customer_name`, `customer_old_name`, `customer_username`, `adress`, `city`, `postal_code`, `phone`, `birth_date`, `birth_postal`, `birth_city`, `birth_country`, `passport_number`, `passport_date`, `passport_place`, `depart_place`, `depart_price`, `depart_date`, `return_place`, `return_price`, `return_date`, `basic_price`, `promotions`, `price`, `update_at`, `lang`, `email`, `adress_no_ue`, `adress_city_hue`, `adress_code_hue`, `car_libelle`, `items`, `plane_date2`, `number_plane`, `adress_more`, `adress_more_no_ue`, `country_id`, `reason_id`, `nationality_id`, `adress_country_hue_id`, `comment`, `mark`, `count_days`) VALUES
(51, '2021-03-21', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-26', 95200, 'sarcelles', 'France', 42424342, '2021-03-19', 'placetest', 'Marseille', 75, '2021-04-22', 'Montpellier', 100, '2021-05-01', 1165, 1015, 1165, NULL, 'fr', 'email@email.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-19 11:05:00', '42424242A', 'Adresse de societe', 'Adresse de societe', 1, 4, 2, 1, '', '', 0),
(52, '2021-03-21', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-26', 95200, 'sarcelles', 'France', 42424342, '2021-03-19', 'placetest', 'Marseille', 75, '2021-04-22', 'Montpellier', 100, '2021-05-01', 1165, 1015, 1165, NULL, 'fr', 'email@email.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-19 11:05:00', '42424242A', 'Adresse de societe', 'Adresse de societe', 1, 4, 2, 1, '', '', 0),
(53, '2021-03-21', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-26', 95200, 'sarcelles', 'France', 42424342, '2021-03-19', 'placetest', 'Marseille', 75, '2021-04-22', 'Montpellier', 100, '2021-05-01', 1165, 1015, 1165, NULL, 'fr', 'email@email.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-19 11:05:00', '42424242A', 'Adresse de societe', 'Adresse de societe', 1, 4, 2, 1, '', '', 0),
(54, '2021-03-21', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-26', 95200, 'sarcelles', 'France', 42424342, '2021-03-19', 'placetest', 'Marseille', 75, '2021-04-22', 'Montpellier', 100, '2021-05-01', 1165, 1015, 1165, NULL, 'fr', 'email@email.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-19 11:05:00', '42424242A', 'Adresse de societe', 'Adresse de societe', 1, 4, 2, 1, '', '', 0),
(55, '2021-03-21', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-26', 95200, 'sarcelles', 'France', 42424342, '2021-03-19', 'placetest', 'Marseille', 75, '2021-04-22', 'Montpellier', 100, '2021-05-01', 1165, 1015, 1165, NULL, 'fr', 'email@email.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-19 11:05:00', '42424242A', 'Adresse de societe', 'Adresse de societe', 1, 4, 2, 1, '', '', 0),
(57, '2021-03-22', 'AFtestFR', 'mme', 'testmoi', 'no', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-06', 95200, 'sarcelles', 'France', 98653330, '2021-03-24', 'placetest', 'Marseille', 75, '2021-04-30', 'Montpellier', 100, '2021-05-29', 1245, 1095, 1245, NULL, 'fr', 'compte@test.com', 'noOOOOOOOOOOOO', 'sarcelles', NULL, '2019 - Scénic Blue', 'N;', '2021-03-27 13:42:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 4, 1, 1, '', '', 0),
(58, '2021-03-22', 'AFtestFR', 'mme', 'testmoi', 'no', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-06', 95200, 'sarcelles', 'France', 98653330, '2021-03-24', 'placetest', 'Marseille', 75, '2021-04-30', 'Montpellier', 100, '2021-05-29', 1245, 1095, 1245, NULL, 'fr', 'compte@test.com', 'noOOOOOOOOOOOO', 'sarcelles', NULL, '2019 - Scénic Blue', 'N;', '2021-03-27 13:42:00', '42424242', 'Adresse de societe', 'Adresse de societe', 2, 4, 2, 1, '', '', 0),
(62, '2021-03-22', 'AFtestFR', 'mme', 'Johanna Queille', 'testmoi', 'kjkl', 'testasres', 'Châtillon', 92320, 622188580, '2021-03-20', 95200, 'sarcelles', 'France', 986533900, '2021-03-18', 'placetest', 'Montpellier', 100, '2021-04-15', 'Montpellier', 100, '2021-05-08', 1210, 1060, 1210, NULL, 'fr', 'queille.johanna@gmail.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-26 18:35:00', '42424242A', '10 avenue saint exupery', 'Adresse de societe', 1, 5, 1, 1, NULL, '', 0),
(63, '2021-03-22', 'AFtestFR', 'mme', 'Johanna Queille', 'testmoi', 'kjkl', 'testasres', 'Châtillon', 92320, 622188580, '2021-03-20', 95200, 'sarcelles', 'France', 986533900, '2021-03-18', 'placetest', 'Montpellier', 100, '2021-04-15', 'Montpellier', 100, '2021-05-08', 1210, 1060, 1210, NULL, 'fr', 'queille.johanna@gmail.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-26 18:35:00', '42424242A', '10 avenue saint exupery', 'Adresse de societe', 1, 5, 1, 1, NULL, '', 0),
(64, '2021-03-22', 'AFtestFR', 'mme', 'testmoi', 'no', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-04-03', 95200, 'sarcelles', 'France', 986533900, '2021-03-20', 'placetest', 'Montpellier', 100, '2021-04-15', 'Montpellier', 100, '2021-05-08', 1210, 1060, 1210, NULL, 'fr', 'email@email.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '2021-03-27 19:38:00', '42424242F', 'Adresse de societe', 'Adresse de societe', 1, 5, 1, 1, NULL, '', 0),
(65, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-25', 95200, 'sarcelles', 'France', 986533333, '2021-04-03', 'placetest', 'Marseille', 75, '2021-04-20', 'Montpellier', 100, '2021-05-29', 1345, 1195, 1275, NULL, 'fr', 'email@compte.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:20:\"Plein d&#039;essence\";}', '12:33:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 3, 1, 1, NULL, '', 0),
(66, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-25', 95200, 'sarcelles', 'France', 986533333, '2021-04-03', 'placetest', 'Marseille', 75, '2021-04-20', 'Montpellier', 100, '2021-05-29', 1345, 1195, 1275, NULL, 'fr', 'email@compte.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:20:\"Plein d&#039;essence\";}', '12:33:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 3, 1, 1, NULL, '', 0),
(67, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(68, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 1, 1, 'Je suis un commentaire', '', 0),
(69, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(70, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(71, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(72, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(73, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(74, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(75, '2021-03-23', 'AFtest', 'mr', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(76, '2021-03-23', 'AFtest', 'mr', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-12', 92320, 'Châtillon', 'France', 99865339, '2021-03-12', 'placetest', 'Marseille', 75, '2021-04-23', 'Montpellier', 100, '2021-05-29', 1315, 1165, 1235, NULL, 'fr', 'email@customer.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:1:{i:0;s:13:\"Siège bébé\";}', '11:39:00', '42424242', 'Adresse de societe', 'Adresse de societe', 1, 5, 2, 1, 'Je suis un commentaire', '', 0),
(77, '2021-03-23', 'AFtest', 'mme', 'testmoi', 'testmoi', 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'sarcelles', 'France', 99865339, '2021-03-06', 'placetest', 'Marseille', 75, '2021-04-29', 'Montpellier', 100, '2021-05-08', 1165, 1015, 1165, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'N;', '12:51:00', '42424242A', 'Adresse de societe', 'Adresse de societe', 1, 4, 1, 1, NULL, '', 0),
(81, '2021-03-23', 'AIRFRR', 'null', 'testmoi', NULL, 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'testasres', 'France', 99865339, '2021-03-06', 'placetest', 'Montpellier', 100, '2021-04-16', 'Paris', 35, '2021-05-29', 1345, 1195, 1270, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:2:{i:0;s:20:\"Plein d&#039;essence\";i:1;s:13:\"Siège bébé\";}', '17:11:00', '78672A', NULL, NULL, 1, 4, 1, 1, NULL, '', 0),
(82, '2021-03-24', 'AIRFRR', 'null', 'testmoi', NULL, 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'testasres', 'France', 99865339, '2021-03-06', 'placetest', 'Marseille', 75, '2021-04-29', 'Montpellier', 100, '2021-06-05', 1325, 1175, 1270, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:2:{i:0;s:20:\"Plein d&#039;essence\";i:1;s:13:\"Siège bébé\";}', '11:17:00', '78672A', NULL, NULL, 1, 4, 1, 1, NULL, '', 0),
(83, '2021-03-24', 'AIRFRR', 'null', 'testmoi', NULL, 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'testasres', 'France', 99865339, '2021-03-06', 'placetest', 'Marseille', 75, '2021-04-29', 'Montpellier', 100, '2021-06-05', 1325, 1175, 1270, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:2:{i:0;s:20:\"Plein d&#039;essence\";i:1;s:13:\"Siège bébé\";}', '11:17:00', '78672A', NULL, NULL, 1, 4, 1, 1, NULL, '', 0),
(84, '2021-03-24', 'AIRFRR', 'null', 'testmoi', NULL, 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'testasres', 'France', 99865339, '2021-03-06', 'placetest', 'Marseille', 75, '2021-04-29', 'Montpellier', 100, '2021-06-05', 1325, 1175, 1270, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:2:{i:0;s:20:\"Plein d&#039;essence\";i:1;s:13:\"Siège bébé\";}', '11:17:00', '78672A', NULL, NULL, 1, 4, 1, 1, NULL, '', 0),
(85, '2021-03-24', 'AIRFRR', 'null', 'testmoi', NULL, 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'testasres', 'France', 99865339, '2021-03-06', 'placetest', 'Marseille', 75, '2021-04-29', 'Montpellier', 100, '2021-06-05', 1325, 1175, 1270, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:2:{i:0;s:20:\"Plein d&#039;essence\";i:1;s:13:\"Siège bébé\";}', '11:17:00', '78672A', NULL, NULL, 1, 4, 1, 1, NULL, '', 0),
(86, '2021-03-24', 'AIRFRR', 'null', 'testmoi', NULL, 'moitest', 'testasres', 'sarcelles', 95200, 623159999, '2021-03-05', 95200, 'testasres', 'France', 99865339, '2021-03-06', 'placetest', 'Marseille', 75, '2021-04-29', 'Montpellier', 100, '2021-06-05', 1325, 1175, 1270, NULL, 'fr', 'email@customer42.com', 'noOOOOOOOOOOOO', 'sarcelles', 75007, '2019 - Scénic Blue', 'a:2:{i:0;s:20:\"Plein d&#039;essence\";i:1;s:13:\"Siège bébé\";}', '11:17:00', '78672A', NULL, NULL, 1, 4, 1, 1, NULL, '', 0),
(88, '2021-03-31', 'AIRFRR', 'null', 'dupont', 'OldName', 'Lea', '10 av st', 'Chatillon', 92320, 622188580, '2021-01-04', 92320, '10 av st', 'France', 123, '2021-01-02', 'domont', 'Marseille', 75, '2021-04-22', 'Montpellier', 100, '2021-05-29', 1325, 1175, 1325, NULL, 'fr', 'testtinggg@add.fr', 'no', 'no', 0, '2019 - Scénic Blue', 'N;', '11:25:00', '78672A', NULL, NULL, 1, 1, 1, 1, 'Je suis un commentaire', '', 0),
(89, '2021-03-31', 'AIRFRR', 'null', 'dupont', NULL, 'Lea', '10 av st', 'Chatillon', 92320, 622188580, '2021-01-04', 92320, '10 av st', 'France', 123, '2021-01-02', 'domont', 'Paris', 35, '2021-04-29', 'Marseille', 75, '2021-07-03', 1675, 837, 1675, NULL, 'fr', 'testtinggg@add.fr', 'no', 'no', 0, '2019 - 508 DIESEL - BVA - GPS', 'N;', '12:55:00', '78672A', NULL, NULL, 1, 1, 1, 1, NULL, '', 0),
(90, '2021-03-31', 'AIRFRR', 'null', 'dupont', NULL, 'Lea', '10 av st', 'Chatillon', 92320, 622188580, '2021-01-04', 92320, '10 av st', 'France', 123, '2021-01-02', 'domont', 'Montpellier', 100, '2021-04-29', 'Marseille', 75, '2021-06-25', 1660, 830, 1660, NULL, 'fr', 'testtinggg@add.fr', 'no', 'no', 0, '2019 - 508 DIESEL - BVA - GPS', 'N;', '16:48:00', '78672A', NULL, NULL, 1, 1, 1, 1, NULL, 'Peugeot', 57),
(91, '2021-03-31', 'AIRFRR', 'null', 'dupont', NULL, 'Lea', '10 av st', 'Chatillon', 92320, 622188580, '2021-01-04', 92320, '10 av st', 'France', 123, '2021-01-02', 'domont', 'Paris', 35, '2021-04-30', 'Montpellier', 100, '2021-07-02', 1680, 840, 1680, NULL, 'fr', 'testtinggg@add.fr', 'no', 'no', 0, '2019 - 508 DIESEL - BVA - GPS', 'N;', '18:54:00', '78672A', NULL, NULL, 1, 1, 1, 1, NULL, 'Peugeot', 63),
(92, '2021-03-31', 'AIRFRR', 'null', 'dupont', NULL, 'Lea', '10 av st', 'Chatillon', 92320, 622188580, '2021-01-04', 92320, '10 av st', 'France', 123, '2021-01-02', 'domont', 'Paris', 35, '2021-05-01', 'Paris', 35, '2021-05-21', 1060, 910, 1060, NULL, 'fr', 'testtinggg@add.fr', 'no', 'no', 0, '2019 - Scénic Blue', 'N;', '21:38:00', '78672A', NULL, NULL, 1, 1, 1, 1, NULL, 'Renault', 20);

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `place_pdf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `libelle`, `price`, `place_pdf`) VALUES
(1, 'Paris', 35, ''),
(2, 'Marseille', 75, ''),
(3, 'Montpellier', 100, '');

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
  `date_end_delivery` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `libelle`, `price`, `date_start`, `date_end`, `date_start_delivery`, `date_end_delivery`) VALUES
(1, '1', 1500, '2020-01-06', '2020-01-18', '2020-04-04', '2022-12-16'),
(2, '2', 900, '2021-02-04', '2021-12-01', '2021-01-14', '2022-06-18');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `place_delivery_id` int(11) DEFAULT NULL,
  `place_departure_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_delivery` date NOT NULL,
  `end_delivery` date NOT NULL,
  `mark_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `place_delivery_id`, `place_departure_id`, `type_id`, `libelle`, `description`, `value`, `start_date`, `end_date`, `start_delivery`, `end_delivery`, `mark_id`) VALUES
(1, 2, 1, 3, 'Renault promo gamme', '50% pendant 2 semaines', 50, '2021-01-06', '2021-09-30', '2021-01-11', '2021-09-20', 2),
(2, 1, 3, 2, 'Livraison Offerte', 'Livraison offert pendant 1mois', 150, '2021-01-03', '2022-01-04', '2021-01-04', '2022-01-20', 3),
(3, 3, 2, 1, 'Renault promo gamme2', 'jour offert', 25, '2021-01-01', '2022-01-01', '2021-01-01', '2022-01-01', NULL),
(4, 3, 2, 3, 'Peugeot promo gamme2', '50% pendant 2 semaines', 50, '2020-01-01', '2021-01-01', '2020-01-01', '2021-01-01', NULL),
(5, 3, 2, 2, 'Renault promo mark', '150€ offert', 150, '2020-01-01', '2022-01-01', '2021-01-01', '2022-01-01', 1),
(6, 1, 3, 1, 'DS promo', 'Livraison offert pendant 1mois', 0, '2021-01-01', '2021-02-01', '2021-01-01', '2022-01-01', 4);

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
(1, 1),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `range`
--

CREATE TABLE `range` (
  `id` int(11) NOT NULL,
  `mark_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `range_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `range`
--

INSERT INTO `range` (`id`, `mark_id`, `libelle`, `range_img`) VALUES
(1, 1, 'Renault megane Berline', 'renault-megane-berline-5ffc131ed02a8.jpg'),
(2, 1, 'Renault Scenic', 'renault-scenics-5ffc13450dcb6.jpg'),
(3, 2, 'Peugeot 308 SW', 'peugeot-308-sw1-big-5ffc135f8e886.jpg'),
(4, 2, 'Peugeot 508 Berline', 'peugeot-508-berline1-big-5ffc1388b2296.jpg'),
(5, 3, 'Citroën C3', 'citroen-c3-big-5ffc13a622128.jpg'),
(6, 3, 'Citroën C4 Berline', 'citroen-c4-berline-big-5ffc13be8123a.jpg'),
(7, 4, 'DS7  Crossback', 'ds7-crossback-big-5ffc13d9c0b76.jpg'),
(8, 4, 'DS3 Crossback', 'ds3-crossback-big-5ffc13e62d653.jpg');

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
  `days_min` int(11) NOT NULL,
  `days_max` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operators` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slice`
--

INSERT INTO `slice` (`id`, `tarif_id`, `mark_id`, `code_price`, `days_min`, `days_max`, `value`, `days`, `type`, `operators`) VALUES
(1, 1, 1, 'Supprime 100', 28, 90, 5, 0, '€', '<'),
(2, 2, 1, 'Test', 21, 0, 10, 21, '€', '≥'),
(3, 2, NULL, '4357', 21, 0, 25, 21, '%', '<');

-- --------------------------------------------------------

--
-- Table structure for table `ttcar_info`
--

CREATE TABLE `ttcar_info` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress_code` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ttcar_info`
--

INSERT INTO `ttcar_info` (`id`, `number`, `adress`, `adress_city`, `adress_country`, `adress_code`, `email`, `hours`) VALUES
(1, 140717240, '2 AVENUE DE LA PORTE DE SAINT-CLOUD', 'PARIS', 'France', 75016, 'info@ttcar.net', 'lundi-vendredi 9h00-17h00');

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
(1, 'Jours'),
(2, 'Euros'),
(3, '%');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `create_at` date NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_customer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `create_at`, `username`, `is_customer`) VALUES
(4, 'testtinggg@add.fr', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$d05VeG4xRzBibUhwR21IaQ$pwlbYdnJYckqNEGBK2Z1l4w+zWMX+99krVDp1oXdRwo', 0, '2021-01-28', 'SlothDev', 1),
(5, 'testcxw@tes2is.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$k8ahBomCxu4r36Qj93vBhQ$8hN0vWCGug0gcI1XGy9PKmoLgHItTDjIHAqLyaLevCI', 0, '2021-02-19', 'moitest', 0),
(6, 'testccsc@tes2is.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$nM4gMz7sXqinjPbV5+N7gg$9wty0hfqPhyS27MdNnpGbLMKbp3IDjLHwhDVcBZ40Eg', 0, '2021-02-19', 'moitest', 0),
(7, '42test@tes2is.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$a39xZSiPdIeql3onIOjhWQ$YPLKRINq8LQQgoAL8Ddrmz3cU+jhdgdxBJKLa9VLycw', 0, '2021-02-19', 'moitest', 0),
(8, '42texcst@tes2is.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$8P8vt24EQS0fWFcubgVPiw$at+lcYr7c87qsvzij69I+kGl2P6RD+ANDdKpiSFBPUQ', 0, '2021-02-19', 'moitest', 0),
(9, '42texcst@tescwx2is.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$5H5YKVxIhjjD7JjE5w0ByQ$L6ovefrH6bPYsem2hb+vKKCtZ2tJDd7gkb37UeYs/pE', 0, '2021-02-19', 'moitest', 0),
(10, '42texcst@azeis.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$5hH8qMYk+EUMpOED/jiCTA$/tl8Mk3J9x1GHKTZWsgnCJ8jLFGtZCb/qvvbGPP02qA', 0, '2021-02-19', 'moitest', 0),
(11, 'uoiout@azeis.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$B13djl0yz3tr4hSXSqVe1g$3VqTeP7KRt8m/jiaVXULaR4225TP0/Ra2sSK3VnEpJI', 0, '2021-02-19', 'moitest', 0),
(12, 'uwcxwt@azeis.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$KTgFFPu2gPDJqROMOER04Q$S2vqsQTxjfQ9BdpbPMDlVxxG5ByT0B9UtGAZ+ltn3jk', 0, '2021-02-19', 'moitest', 0),
(13, 'uwcwt@azeis.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$eS4PF9PxZ1SrJfSX4MEbbA$+JQ1YjLzbVl/uYh4/nikR10RUeG23Mdny9R0coJGOmY', 0, '2021-02-19', 'moitest', 0),
(14, 'iuyicwt@azeis.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$sQskJKdpYUAKpMdTKtgSiQ$COFSCtL8lZKxXOJs6HVKhOPkE7RBQiPYzDZ/CwLCVr0', 0, '2021-02-19', 'moitest', 0),
(15, 'hfgbcwt@azeis.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$h/2lQNHFM5XQMPvzO+y+iA$K0KhfomU29KDX2bWKonxJKE7or1KNsgFB5sIuLNCPaM', 0, '2021-02-19', 'moitest', 0),
(16, 'testdumatin@test.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$2wZD1f94TBOPsfe6htzrWA$aLDnhmnt8/pYsMfMdSXXOcBNArmxdo7B32JUCjtWN9o', 0, '2021-02-22', 'kjkl', 0),
(17, 'email@email.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$a5HNa2SBXX6xnohAw+UyPQ$rwvTsnmOm9WJjBywKC2e1YrsNswZg/ZiVX5EKKk5X/M', 0, '2021-03-21', 'moitest', 0),
(18, 'compte@test.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$uU7Cg592/xZI5UuDG0Zxnw$i6ZkxgOSz3d4Yh4BKJ4bG9re7kzSjC0GJk+CNjCNx5Q', 0, '2021-03-22', 'moitest', 0),
(19, 'queille.johanna@gmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$txOgEA4a3Ws8t0ucBv//Dg$0CcSZBFSshKJ1DpPfs2rcjk5LZm+reMuOZvdha+/yME', 0, '2021-03-22', 'kjkl', 0),
(20, 'email@compte.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$tNVR7LjxpmojZt+FUbeHkw$gftxrj2ysaBaMeTh9SBA2jTHIm3IEqQdKeyC2KipQyw', 0, '2021-03-23', 'moitest', 0),
(23, 'email@customer.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$hkhUxmBbOajgEWmgwCqsgg$WaUI3tf+njRKT7I1F/Ir0LyOAlQ4BWklD2hUAIfZ5PA', 0, '2021-03-23', 'moitest', 0),
(24, 'email@customer42.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$eBMFGs72e0fcEFUtq1KH1A$FVLB/zDTbogDfKErCl2cWBuYRKVmuiUNb2TXtuw0x3U', 0, '2021-03-23', 'moitest', 1);

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
  ADD KEY `IDX_95C71D14D614C7E7` (`price_id`);

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
  ADD KEY `IDX_81398E09D3711A23` (`adress_country_id`),
  ADD KEY `IDX_81398E09A8A84437` (`adress_country_hue_id`),
  ADD KEY `IDX_81398E091C9DA55` (`nationality_id`),
  ADD KEY `IDX_81398E0959BB1592` (`reason_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

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
  ADD KEY `IDX_F529939859BB1592` (`reason_id`),
  ADD KEY `IDX_F52993981C9DA55` (`nationality_id`),
  ADD KEY `IDX_F5299398A8A84437` (`adress_country_hue_id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EA1B30341CE62185` (`place_delivery_id`),
  ADD KEY `IDX_EA1B3034A6B17FBF` (`place_departure_id`),
  ADD KEY `IDX_EA1B3034C54C8C93` (`type_id`),
  ADD KEY `IDX_EA1B30344290F12B` (`mark_id`);

--
-- Indexes for table `promotions_range`
--
ALTER TABLE `promotions_range`
  ADD PRIMARY KEY (`promotions_id`,`range_id`),
  ADD KEY `IDX_418CE0010007789` (`promotions_id`),
  ADD KEY `IDX_418CE002A82D0B1` (`range_id`);

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
-- Indexes for table `ttcar_info`
--
ALTER TABLE `ttcar_info`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `category_post`
--
ALTER TABLE `category_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_cars`
--
ALTER TABLE `contact_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_douane`
--
ALTER TABLE `contact_douane`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mark`
--
ALTER TABLE `mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `range`
--
ALTER TABLE `range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ttcar_info`
--
ALTER TABLE `ttcar_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type_promo`
--
ALTER TABLE `type_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
