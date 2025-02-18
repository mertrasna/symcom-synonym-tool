-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2025 at 08:37 AM
-- Server version: 5.7.42-0ubuntu0.18.04.1
-- PHP Version: 7.1.33-39+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `development_repertory_lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `rel_symptom_english_synonym`
--

CREATE TABLE `rel_symptom_english_synonym` (
  `symptom_id` int(11) NOT NULL COMMENT 'from quelle_import_test table',
  `english_synonym_id` int(11) NOT NULL COMMENT 'from synonym_en table',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editor_id` int(10) UNSIGNED DEFAULT NULL,
  `creator_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='english synonyms assigned to symptoms';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rel_symptom_english_synonym`
--
ALTER TABLE `rel_symptom_english_synonym`
  ADD PRIMARY KEY (`symptom_id`,`english_synonym_id`),
  ADD KEY `english_synonym_id` (`english_synonym_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rel_symptom_english_synonym`
--
ALTER TABLE `rel_symptom_english_synonym`
  ADD CONSTRAINT `rel_symptom_english_synonym_ibfk_1` FOREIGN KEY (`symptom_id`) REFERENCES `quelle_import_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rel_symptom_english_synonym_ibfk_2` FOREIGN KEY (`english_synonym_id`) REFERENCES `synonym_en` (`synonym_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
