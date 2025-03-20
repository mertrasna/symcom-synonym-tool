-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 05:10 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_database_synonym_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `arznei`
--
DROP DATABASE IF EXISTS symcom_minified_db; 
CREATE DATABASE symcom_minified_db;
USE symcom_minified_db;

CREATE TABLE `arznei` (
  `arznei_id` int(11) UNSIGNED NOT NULL COMMENT 'medicine_id',
  `titel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'title',
  `kuerzel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'shortcut (separate several with "|")',
  `synonyms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'comma separated values',
  `kommentar` text CHARACTER SET utf8 DEFAULT NULL COMMENT 'comment',
  `unklarheiten` text CHARACTER SET utf8 DEFAULT NULL COMMENT 'unclear (German word is Unklarheiten)',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='medicine';

--
-- Dumping data for table `arznei`
--

INSERT INTO `arznei` (`arznei_id`, `titel`, `kuerzel`, `synonyms`, `kommentar`, `unklarheiten`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(2, 'Actaea spicata', NULL, '(R?ckert)\nChristophskraut (Jahr SK)', '', '', 1, NULL, '2015-09-15 13:27:00', 0, '2014-09-22 17:26:10', 6),
(3, 'Aethusa cynapium ', NULL, 'Hundsdillgleiss (ANN), Gartenschierling, Hundspetersilie (Jahr SK), Narrenpetersilie, Gleiße (Clarke)', NULL, NULL, 1, '78.94.1.201', '2020-10-08 15:55:10', 1, '2014-09-22 17:26:10', 0),
(4, 'Agaricus muscarius', NULL, 'Fliegen-Pilz, Fliegen-Schwamm (CK2), Fliegenpilz (H&T), Amanita muscaria (Clarke)', NULL, NULL, 1, '78.94.1.201', '2020-10-08 15:55:49', 1, '2014-09-22 17:26:10', 0),
(5, 'Agnus castus', NULL, 'Keuschlamm (ACS), Vitex agnus castus, M?nchspfeffer (Stapf B.)\nKeuschbaum (Jahr SK)\nVerbena verticillata (Clarke)', '', '', 1, NULL, '2016-05-18 14:27:00', 2, '2014-09-22 17:26:10', 0),
(6, 'Alcoholus', NULL, 'Alcohol (ACS)', '', '', 1, NULL, '2016-05-18 14:27:00', 2, '2014-09-22 17:26:10', 0),
(7, 'Aloe', NULL, '(AHZ XX)\nGummi Aloes (Jahr SK)\nAloe socotrina, Gew?hnliche Aloe (Clarke)', '', '', 1, NULL, '2016-05-18 14:28:00', 2, '2014-09-22 17:26:10', 0),
(8, 'Alumina', NULL, 'Alaunerde, Thonerde (CK Bd.2)Argilla pura, Terra aluminosa, Alumium oxydatum (H&T)Reine Thonerde (Jahr SK)Tonerde, Aluminiumoxid (Clarke)Dellm.: ev. Umbennung in: Aluminium oxydatum?, vgl. Boericke', NULL, NULL, 1, '110.235.192.154', '2019-06-06 11:02:13', 1, '2014-09-22 17:26:10', 0),
(9, 'Ambra grisea', NULL, 'Graue Ambra, Ambra ambrosiaca L. (RA Bd.6)\nGrauer Amber (Clarke)', '', '', 1, NULL, '2016-05-18 14:30:00', 6, '2014-09-22 17:26:10', 0),
(10, 'Ammoniacum gummi', NULL, 'Ammoniacum, Ammoniak-Gummi, Gummi Ammoniacum (Jahr SK)', '', '', 1, NULL, '2016-05-18 14:31:00', 6, '2014-09-22 17:26:10', 0),
(11, 'Ammonium carbonicum', NULL, 'Ammonium-Salz, Fl?chtiges Laugensalz (CK Bd.2)\nAmmonium, Ammonium carbonicum (H&T S. 544), Kohlensaures Ammonium (H&T S. 855)\nAmmoniumcarbonat (Clarke)', '', '', 1, NULL, '2015-07-02 13:31:00', 6, '2015-07-02 19:31:00', 6),
(12, 'Ammonium causticum', NULL, '(Wibmer)\nKaustisches Ammonium (Jahr SK)\n?tzammoniak, Liquor Ammonii caustici, Salmiakgeist (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(13, 'Ammonium muriaticum', NULL, 'Salzsaures Ammonium (ANN 1833)\nSalmiak (CK Bd.2)\nAmmoniumchlorid (Clarke)', '', '', 1, NULL, '2016-05-18 14:31:00', 2, '2014-09-22 17:26:10', 0),
(14, 'Amygdalae amarae', NULL, 'Bittermandelwasser (J?rg)\nAmygdalae amarae aqua, Amygdalus communis, Bittermandel (Clarke)\n\ns. Laurocerasus: ev. als Option mit Laur. zusammenfassen', '', '', 1, NULL, '2016-05-18 14:32:00', 2, '2014-09-22 17:26:10', 0),
(15, 'Anacardium orientale', NULL, 'Anacardium, Anakardien-Herznuss, Malacka-Nuss, Semecarpus Anacardium, Avicennia tomentosa (CK Bd.2)\nMalakka-Nu? (Jahr SK)\nMerknu? (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(16, 'Anagallis arvensis', NULL, '(ACS)\nAcker-Gauchheil (Clarke)', '', '', 1, NULL, '2015-07-13 14:42:50', 6, '2015-07-13 20:42:50', 6),
(17, 'Angustura vera', NULL, 'Cortex Angusturae, Angusturae, Bonplandia trifoliata (RA Bd.6)\nAngustura-Rinde (Jahr SK)\nGalipea cusparia (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(18, 'Anisum stellatum', NULL, '(ACS)\nSternanis (Jahr SK)\nPimpinella anisum, Illicium anisatum (Clarke)', '', '', 1, NULL, '2015-07-13 14:43:32', 6, '2015-07-13 20:43:32', 6),
(19, 'Anthrokokali', NULL, '(Jahr SK)\nAnthrocokali (Clarke)', '', '', 1, NULL, '2015-06-24 13:14:58', 6, '2015-06-24 19:14:58', 6),
(20, 'Antimonium crudum', NULL, 'Roher Spiessglanz, Schwefel-Spiessglanz, Stibium sulphuratum nigrum (CK Bd.2)\nRohes Spiessglanz (H&T)\nNat?rliches Antimonsulfid, Grauspie?glanz (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(21, 'Antimonium tartaricum', NULL, 'Weinsteinsaures Spie?glanz, Stibium tartaricum, Tartarus stibiatus, Tartarus emeticus, Brechweinstein (ACS)\nKalium-Antimonyl-Tatrat (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(22, 'Aphis chenopodii glauci', NULL, '(ACS)\nR?hrenlaus, Aphide (Clarke)', '', '', 1, NULL, '2015-07-13 14:48:27', 6, '2015-07-13 20:48:27', 6),
(23, 'Aranea diadema', NULL, '(AHZ)\nDiadema, Kreuzspinne (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(24, 'Argentum metallicum', NULL, 'Silber, Blatt-Silber, Argentum foliatum (RA Bd.4)\nBlattsilber, Pr?zipitiertes Silber (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(25, 'Argentum nitricum', NULL, 'Salpetersaure Silberaufl?sung (RA Bd.4) \nSalpetersaures Silber (Jahr SK)\nSilbernitrat, H?llenstein (Clarke)\n\n(in RA Bd.4 als salperters. Silberaufl?sung bezeichnet; Zuordnung zu Arg-n. von Wischner/Lucae Bd.1 S. 197)', '<p>in RA Bd.4 als salperters. Silberauflösung bezeichnet; Zuordnung zu Arg-n. von Wischner/Lucae Bd.1 S. 197</p>', '', 1, NULL, '2015-09-15 14:02:00', 0, '2014-09-22 17:26:10', 6),
(26, 'Arnica montana', NULL, 'Wohlverleih (RA Bd.1)Flores Arnicae, Radices Arnicae montanae (J?rg)Berg-Wohlverleih, Fallkraut (Jahr SK)', '<p>13.10.16 Texte in Franks Magazin sind Fließtexte, deshalb keine Symptome erfasst.</p>\r\n<p>13.10.16 Supplementheft von Allens MM enthält keine Hervorhebungen/ Verifikationen, deshalb daraus nichts erfasst</p>', NULL, 1, '110.235.192.154', '2019-06-06 10:14:21', 1, '2014-09-22 17:26:10', 0),
(27, 'Arsenicum album', NULL, 'Arsenik, Arsenikmetall (RA Bd.2) (CK Bd.5)\nAcidum arseniosum, Arsenige S?ure (Jahr SK)\nWei?es Arsenoxid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(28, 'Arsenicum sulphuratum flavum', NULL, 'Auripigmentum, Operment (RA Bd.2)\nAurum pigmentum, Arsenicum citrinum (Jahr SK)\nAuripigment (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(29, 'Artemisia vulgaris', NULL, 'Gemeiner Beifu? (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(30, 'Arum maculatum', NULL, '(ACS)\nGefleckter Aron (Jahr SK)\nEinheimischer Aronstab, Aasblume, Deutscher Ingwer (Clarke)', '', '', 1, NULL, '2015-07-13 14:48:52', 6, '2015-07-13 20:48:52', 6),
(31, 'Asa foetida', NULL, 'Stinkasand (J?rg)\nFerula asafoetida, Narthex foetida (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(32, 'Asarum europaeum', NULL, 'Haselwurzel (RA Bd.3)\nHaselwurz (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(33, 'Asparagus officinalis', NULL, '(HYG 1840)\nSpargel (Jahr SK)', '', '', 1, NULL, '2015-06-24 13:17:51', 6, '2015-06-24 19:17:51', 6),
(34, 'Athamanta oreoselinum', NULL, '(ACS)\nBergeppich, Bergpetersilie (Jahr SK)', '', '', 1, NULL, '2015-07-13 14:49:23', 6, '2015-07-13 20:49:23', 6),
(35, 'Aurum fulminans', NULL, 'Knallgold (RA Bd.4)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(36, 'Aurum metallicum', NULL, 'Blatt-Gold (RA Bd.4)\nGold, Aurum foliatum (CK Bd.2)\nMetallisches Gold, Blattgold (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(37, 'Aurum muriaticum', NULL, 'Gold-Aufl?sung (RA Bd.4 S. 106)\nSalzsaure Gold-Aufl?sung (CK Bd.2)\nSalzsaures Gold (Jahr SK)\nGoldchlorid (Clarke)\n\nDellm.: Goldaufl?sung = Aur-mur., oder?\n(?ber Gold (Aurum foliat.: \"\"nicht... durch? chemische Veranstaltungen ver?nderten Golde, also? von dem durch S?uren aufgel?seten?\"\", RA Bd.4)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(38, 'Barium aceticum', NULL, 'Essigsaurer Baryt (ACS)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(39, 'Barium carbonicum', NULL, 'Baryta carbonica, Schwererde, Kochsalzsaure Schwererde (CK Bd.2)\nKohlensaurer Baryt (H&T)\nBaryta (Jahr SK)\nBariumcarbonat (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(40, 'Barium muriaticum', NULL, 'Baryta muriatica, Salzsaure Schwererde (Jahr SK)\nBariumchlorid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(41, 'Bartfelder Sauerbrunnen', NULL, '(ACS)', '', '', 1, NULL, '2015-07-13 14:50:06', 6, '2015-07-13 20:50:06', 6),
(42, 'Belladonna', NULL, 'Atropa Belladonna (FRA)\nBelladonne (RA Bd.1)\nTollkirsche (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(43, 'Berberis vulgaris', NULL, 'Berberitzenwurzel (JAL 1834)\nBerberitze, Sauerdorn (Jahr SK)\nGemeiner Sauerdorn (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(44, 'Bismuthum subnitricum', NULL, 'Wismuth, Bismuthum, Wismuthum (RA Bd.6)\nBasisches salpetersaures Wismuth (H&T)\nWismut (Clarke)\n\nDellm. Unterschied Bismuthum?', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(45, 'Borax veneta', NULL, 'Natron(sub)boracicum, Boras natricus, Borax (CK Bd.2)\nNatrum boracicum, Borar (Jahr SK)\nNatrium boracicum, Natriumborat (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(46, 'Bovista lycoperdon', NULL, 'Bovist, Lycoperdon Bovista (H&T)\nRauchpilz (Jahr SK)\nSt?ubling (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(47, 'Bromium', NULL, '(ACS 1846)\nBrom (Clarke)', '', '', 1, NULL, '2015-07-13 14:50:32', 6, '2015-07-13 20:50:32', 6),
(48, 'Brucea antidysenterica', NULL, 'Falsche Angustura, Braune Brucea (Jahr SK)\nAngustura falsa, Angustura spuria (Clarke)\n\n(Anmerkung Jahr SK S. 78: A. spuria ist nicht sicher identisch mit Brucea antidysenterica; Jahr f?hrt deshalb beide getrennt auf.)\nDellm.', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(49, 'Bryonia alba', NULL, 'Zaunrebe (RA Bd.2)\nWei?e Zaunr?be (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(50, 'Bufo rana', NULL, 'Kr?te, Bufo bufo (Erdkr?te), Bufo satyhiensis (brasilianische Kr?te) (Clarke)', '', '', 1, NULL, '2015-06-24 13:48:40', 6, '2015-06-24 19:48:40', 6),
(51, 'Caladium seguinum', NULL, '(ACS)\nArum seguinum, Giftiger Aron (Jahr SK)\nCaladium seguina, Schierlings-Caladium, Buntwurz, Sch?naron (Clarke)', '', '', 1, NULL, '2015-07-13 14:51:33', 6, '2015-07-13 20:51:33', 6),
(52, 'Calcium aceticum', NULL, 'Essigsaure Kalkerde, Terra calcarea acetica (RA Bd.5)\nCalcarea acetica, Unreines Calciumacetat (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(53, 'Calcium carbonicum', NULL, 'Calcarea carbonica, Kalkerde (CK Bd.2)\nKohlensaure Kalkerde (Jahr SK)\nUnreines Calciumcarbonat  (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(54, 'Calcium phosphoricum', NULL, '(Amerik. Korrespondenzblatt)\nCalcarea phosphorica, Phosphorsaure Kalkerde (Jahr SK)\nCalciumphosphat (Clarke)', '', '', 1, NULL, '2015-06-23 13:40:17', 6, '2015-06-23 19:40:17', 6),
(55, 'Calendula officinalis', NULL, 'Gemeine Ringelblume (Jahr SK)\nRingelblume (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(56, 'Camphora officinalis', NULL, 'Laurus Camphora L., Kampher (FRA) \nKampherbaum (RA Bd.4)\nCamphora (J?rg)\nKampfer, Cinnamonum camphore, Laurus camphora (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(57, 'Cannabis sativa', NULL, 'Hanf, Cannabis sativa L. (RA Bd.1)\nHanfsamen (Jahr SK)\nEurop?ischer Hanf, Amerikanischer Hanf (Clarke)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(58, 'Cantharis vesicatoria', NULL, 'Lytta vesicatoria L. (FRA)\nKanthariden (ACS)\nCanthariden, Meloe vesicatorius L., Lytta vesicatoria Fabric. (H&T)\nSpanische Fliege (Jahr SK)\nCantharides (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(59, 'Capsicum annuum', NULL, 'Kapsicum (RA Bd.6)\nSpanischer Pfeffer (Jahr SK)\nCayennepfeffer, Paprika (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(60, 'Carbo animalis', NULL, 'Thierkohle (RA Bd.6)\nTierkohle (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(61, 'Carbo vegetabilis', NULL, 'Holzkohle, Carbo ligni, Birkenholz (RA Bd.6) \nUnreiner Kohlenstoff (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(62, 'Carboneum sulphuratum', NULL, 'Carbonium sulphuratum, Alcohol sulphuris Lampadii, Schwefel-Alkohol (AZH)\nSchwefelkohlenstoff, Kohlenstoffdisulfid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(63, 'Carduus benedictus', NULL, '(PMG 1826)\nCnicus benedictus L., Benediktinerkraut, Benediktendistel (Clarke)', '', '', 1, NULL, '2015-07-01 13:02:10', 6, '2015-07-01 19:02:10', 6),
(64, 'Carlsbad aqua', NULL, '(ACS 1843)\nKarlsbader Wasser (Clarke)', '', '', 1, NULL, '2015-07-13 14:55:39', 6, '2015-07-13 20:55:39', 6),
(65, 'Cascarilla', NULL, 'Croton cascarilla, Cascarille (Jahr SK)\nCroton eluteria, Kaskarille, Falscher Fieberrindenbaum, Ruhrrindenbaum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(66, 'Castor equi', NULL, 'Castor equorum, Daumennagel der Pferde (AZH 1850)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(67, 'Castoreum canadense', NULL, 'Biebergeil, Castoreum (J?rg)\nBibergeil (Jahr SK)\nBiber, Castor fiber (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(68, 'Causticum', NULL, 'Aetzstoff (CK Bd.3) (H&T)\n\n\n\nDellm.: Zusammenfassen mit Caust.?', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(69, 'Causticum Hahnemanni', NULL, 'Acris tinctura (FRA)\nAetzstoff-Tinctur, Tinctura acris sine kali (RA Bd.2 1824) (H&T S. 529, 854) \nAetzstoff (Jahr SK)\nKaliumhydrat (Clarke)\n\n(Aetzstoff/ A.-Tinktur: s. Kommentar Hahnemann CK Bd.3 85 (1837): Aetzstoff, ebenso CK Bd.4 (1830); auch Vorwort-Passage identisch!)\nDellm. (in Clarke zs.-fa?t: Tinct. acris ? unter Caust.)\nGy.: Erstpr?fung: Fragmenta (korrekt), CK Bd.2. Aufl. 1837: Unsinn, hat da nichts zu suchen, wurde schon in der RA (1816,1824) und 1. Aufl. CK (1830) ver?ffentlicht!! (Kl?ren: Unterschied Aetzstoff, Aetzstofftinktur)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(70, 'Chamomilla', NULL, 'Matricaria Chamomilla L. (FRA)\nChamille-Mettram, Feld-Chamille, H?lmerchen (RA Bd.3)\nChamomilla vulgaris (Jahr SK)\nEchte Kamille (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(71, 'Chelidonium majus', NULL, 'Sch?llkraut (RA Bd.4)\nGro?es Sch?llkraut (Clarke)\n\n(ganzes Kraut: RA; von der Wurzel: H&T)', '<p>ganzes Kraut: RA; von der Wurzel: H&amp;T</p>', '', 1, NULL, '2015-09-15 13:59:00', 0, '2014-09-22 17:26:10', 6),
(72, 'Chenopodium glaucum', NULL, '(ACS)\nGraue Melde (Jahr SK)\nGraugr?ner G?nsefu? (Wikipedia)', '', '', 1, NULL, '2015-07-13 14:56:28', 6, '2015-07-13 20:56:28', 6),
(73, 'China officinalis', NULL, 'Cinchona officinalis, Cinchona vulgaris officinalis, Cinchona regia (FRA)\nChinarinde, K?nigs-Chinarinde (RA Bd.3)\nCinchona calisaya, Perurindenbaum, Chinarindenbaum, Jesuitenrinde (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(74, 'Chininum sulphuricum', NULL, '(JAL II)\nSchwefelsaures Chinin (Jahr SK)\nChininsulfat (Clarke)', '', '', 1, NULL, '2015-07-01 12:18:00', 6, '2015-07-01 18:18:00', 6),
(75, 'Chlorum', NULL, 'Chlor (ACS)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(76, 'Cicuta virosa', NULL, 'W?therich (RA Bd.6)\nWasserschierling (Jahr SK)\nW?terich (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(77, 'Cimex lectularius', NULL, '(ACS)\n(Nordamerik. Hom. Journal, in Jahr SK) \nViverra putorius, Nordamerikanisches Stinkthier (Jahr SK)\nAcanthia lectularia, Bettwanze (Clarke)', '', '', 1, NULL, '2015-09-15 13:57:00', 6, '2015-07-13 20:57:44', 6),
(78, 'Cina maritima', NULL, 'Cinasamen, Semen Cinae, Semen Santonici, Sem. Contra, Artemisia Contra, Zitwersamen, Semen zedoariae (RA Bd.1)\nArtemisia judaica, Wurmsamen, Zittwersamen (Jahr SK)\nArtemisia maritima aut cina (Clarke)\nArtemisia Cina, Artemisia Cina Berg, Zitwerbeifu?, Wurmsaat (Gypser)\n\n(?Man nennt ihn unrecht, blos weil ... auch Zitwersamen, Semen zedoariae? (RA Bd.1 S. 119)\n\nDellm: wenn nur Symptome von Santonin: mit einbeziehen? (Minder: ?der Einbezug der Santoninsymptome in das Arzneibild von Cina korrekt sein d?rfte. Aber dennoch bei Gy.: Es wurden nur Symptome von Cina selbst aufgenommen)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(79, 'Cinnabaris', NULL, 'Zinnober, R?ucherung mit Zinnober (RA Bd.1)\nMercurius sulphuratus ruber, Rotes Quecksilbersulfid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(80, 'Cinnamomum ceylanicum', NULL, 'Zimmet (Jahr SK)\nCinnamomum aromaticum, Cinnamomum cassia, Zeylonzimt, Chinesischer Zimt (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(81, 'Cistus canadensis', NULL, '(Nordamerik. Journal)\nCistus Helianthemum, Cistenr?schen (Jahr SK)\nHelianthemum canadense, Felsrose, Frostkraut, Ein Sonnenr?schen (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(82, 'Citrus limonum', NULL, 'Citri succus, Zitronens?ure (Jahr SK)\nZitrone (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(83, 'Clematis erecta', NULL, 'Clematis erecta L., Flammula Jovis, Brenn-Waldrebe (CK Bd.3)\nClematis recta, Aufrechte Waldrebe, Brennwaldrebe (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(84, 'Coccinella septempunctata', NULL, '(PMG)\nChrysomela septempunctata, Sonnenk?fer, Himmelskuh (Jahr SK)\nMarienk?fer, Siebenpunkt (Clarke)', '', '', 1, NULL, '2015-07-01 13:13:37', 6, '2015-07-01 19:13:37', 6),
(85, 'Cocculus indicus', NULL, 'Menispermum Cocculus L. (FRA)\nKockel, Kockelsamen (RA Bd.1)\nKockelsk?rnerstrauch (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(86, 'Cochlearia armoracia', NULL, '(ACS)\nArmoracia Cochlearea, Meerrettig (Jahr SK)\nCochlearea armoracea, Armoracea rusticana, Meerrettich (Clarke)\nArmoracea sativa (Vermeulen)', '', '', 1, NULL, '2015-07-13 15:00:17', 6, '2015-07-13 21:00:17', 6),
(87, 'Coffea cruda', NULL, 'Kaffee (ACS), Rohkaffee, Coffea arabica L. (Stapf B.)\nRoher Kaffee (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(88, 'Colchicum autumnale', NULL, 'Herbstzeitlose, Lichtblume (ACS)\nColchicum auctumnale (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(89, 'Colocynthis', NULL, 'Koloquinte, Cucumis Colocynthis (RA Bd.6)\nCitrullus colocynthis (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(90, 'Conium maculatum', NULL, 'Schierling (RA Bd.4)\nFlecken-Schierling (CK Bd.3)\nFleckenschierling (Jahr SK)\nGemeiner gefleckter Schierling, Erdschierling, Tollkerbel, Wilde Petersilie, W?terich (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(91, 'Convolvulus arvensis', NULL, 'Feldwinde (Jahr SK)\nAckerwinde, Kornwinde (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(92, 'Copaiva officinalis', NULL, 'Copaifera balsamum L. (FRA)\nCopaivae Balsamum, Copaiv-Balsam (Jahr SK)\nCopaiva, Balsamum copaivae, Kopaivabalsam (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(93, 'Corallium rubrum', NULL, '(ACS)\nRothe Koralle (Jahr SK)\nCorallium nobile, Corallium rubrum, Rote Koralle, Edelkoralle (Clarke)', '', '', 1, NULL, '2015-07-13 15:02:26', 6, '2015-07-13 21:02:26', 6),
(94, 'Crocus sativus', NULL, 'Safran, Crocus sativus L. (Stapf B.)\nAechter Safran (Jahr SK)\nEchter Safran, Herbstsafran (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(95, 'Crotalus horridus', NULL, '(Hering, Schlangengift)\nKlapperschlangen-Gift (Jahr SK)\nKlapperschlange Nordamerikas, Crotalus durissus (Clarke)', '', '', 1, NULL, '2015-09-15 13:35:00', 0, '2014-09-22 17:26:10', 6),
(96, 'Croton tiglium', NULL, 'Oleum Crotonis (PMG 1828 S. 88)\nPurgier-Croton (Jahr SK)\nTiglium officinale, Eine Krebsblume, Purgierkroton, Kroton?lsamen (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(97, 'Cuprum aceticum', NULL, 'Gr?nspan, Essigsaures Kupfer (Jahr SK)\nKupferacetat (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(98, 'Cuprum carbonicum', NULL, 'Kohlensaures Kupfer (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(99, 'Cuprum metallicum', NULL, 'Kupfer (CK Bd.3)\nKupfer-Metall (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(100, 'Cuprum sulphuricum', NULL, 'Cuprum vitriolatum (FRA)\nKupfervitriol, Schwefelsaures Kupfer (Jahr SK)\nKupfersulfat (Clarke)\n\nDellm.: synon. mit Cupr. sulfuratum?', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(101, 'Cyclamen europaeum', NULL, 'Erdscheibe, Erdscheibe-Schweinsbrod (RA Bd.5)\nCyclamen purpurascens, Alpenveilchen (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(102, 'Daphne indica', NULL, '(NAJ, in Jahr SK)\nDaphne odorata, Indischer Seidelbast, Kellerhals (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(103, 'Dematium petraeum', NULL, '(ACS)', '', '', 1, NULL, '2015-07-13 15:02:54', 6, '2015-07-13 21:02:54', 6),
(104, 'Digitalis purpurea', NULL, 'Fingerhut (RA Bd.4)\nPurpur-Fingerhut (CK Bd.3)\nRother Fingerhut, Herba digitalis purpureae (J?rg)\nRoter Fingerhut, Purpurfingerhut (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(105, 'Drosera rotundifolia', NULL, 'Sonnenthau (RA Bd.6)\nRorella (Jahr SK)\nRundbl?ttriger Sonnentau, Jungfernbl?te, Sonnenkraut (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(106, 'Dulcamara', NULL, 'Bitters?ss, Solanum dulcamara (RA Bd.1)\nBitters??-Nachtschatten (Jahr SK)\nBitters??, Bitters??er Nachtschatten (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(107, 'Electricitas', NULL, 'Elektricit?t (Jahr SK)\nElektrizit?t (Clarke)\nPositive Elektrizit?t (Caspari)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(108, 'Eugenia jambos', NULL, '(ACS)\nJambosa vulgaris, Wilder Jambos (Jahr SK)\nEine Kirschmyrte (Clarke)', '', '', 1, NULL, '2015-07-13 15:03:14', 6, '2015-07-13 21:03:14', 6),
(109, 'Euonymus europaea', NULL, '(PMG 1827)\nEvonymus europaeus, Pfaffenh?tchen (Jahr SK)\nGew?hnliches Pfaffenk?ppchen (Clarke)', '', '', 1, NULL, '2015-07-01 13:13:14', 6, '2015-07-01 19:13:14', 6),
(110, 'Euphorbium officinalis', NULL, 'Euphorbium officinarum, Euphorbium canariensis (CK Bd.3)\nWolfsmilch (Jahr SK)\nEuphorbiumharz, Euphorbia resinifera (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(111, 'Euphrasia officinalis', NULL, 'Augentrost (RA Bd.5)\nEuphrasia rostkoviana, Wiesenaugentrost (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(112, 'Ferrum magneticum', NULL, 'Magnetstein, Lapis magneticus (Caspari 1827)\nLapis magneticus, Magneteisenstein (Jahr SK)\nEisensesquioxid, Ein schwarzes Eisenoxid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(113, 'Ferrum metallicum', NULL, 'Eisen, Ferrum (RA Bd.2)\nMetallisches Eisen (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(114, 'Ferrum muriaticum', NULL, '(B?nninghausen, Verwandtschaften)\nSalzsaures Eisen (Jahr SK)\nEisendichlorid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(115, 'Filix mas', NULL, 'M?nnliches Farnkraut (Jahr SK)\nDryopteris filix-mas, Aspidium filix-mas, M?nnlicher Wurmfarn (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(116, 'Fluoricum acidum', NULL, '(ACS)\nFlu?s?ure (Clarke)', '', '', 1, NULL, '2015-07-13 15:04:03', 6, '2015-07-13 21:04:03', 6),
(117, 'Fragaria vesca', NULL, '(ACS)\nGemeine Erdbeere (Jahr SK)', '', '', 1, NULL, '2015-07-13 15:04:23', 6, '2015-07-13 21:04:23', 6),
(118, 'Galvanismus', NULL, '(Caspari 1828)\nZinkpol, Silberpol, Kupferpol (Clarke)', '', '', 1, NULL, '2015-06-24 12:26:54', 6, '2015-06-24 18:26:54', 6),
(119, 'Gentiana lutea', NULL, '(HYG)\nGentiana lutetia, Enzian (Jahr SK)\nGelber Enzian, Bitterwurz, Fieberwurzel (Clarke)', '', '', 1, NULL, '2015-07-01 12:12:41', 6, '2015-07-01 18:12:41', 6),
(120, 'Geum rivale', NULL, '(ACS)\nBachnelkenwurz, Ufererdr?schen (Clarke)', '', '', 1, NULL, '2015-07-13 15:04:49', 6, '2015-07-13 21:04:49', 6),
(121, 'Ginseng quinquefolia', NULL, 'Chinesische Ginseng Wurzel (AZH 1850 S. 11-41), Amerikanischer Ginseng (AZH 1850 S. 25)\nNordamerikanische Kraftwurzel (Jahr SK)\nPanax quinquefolia, Aralia quinquefolia (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(122, 'Granatum', NULL, '(HYG)\nPunica Granatum, Cranatwurzelrinde (Jahr SK)\nGranatapfelbaum (Clarke)', '', '', 1, NULL, '2015-06-24 13:23:57', 6, '2015-06-24 19:23:57', 6),
(123, 'Graphites', NULL, 'Graphit, Reissblei (CK Bd.3)\nRei?blei (Jahr SK)\nGraphites naturalis, Nat?rliches Graphit (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(124, 'Gratiola officinalis', NULL, 'Gnadenkraut, Gottesgnadenkraut, Wilder Aurin, Gratiola officinalis L. (H&T)\nHeckenysop, Gichtkraut, Purgierkraut (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(125, 'Guajacum officinale', NULL, 'Guajak-Gummi, Guajacum (RA Bd.4), \nGuajak, Gummi Guajaci (CK Bd.3)\nGuajakharz (Jahr SK)\nGuaiacum officinale, Gum guaiacum, Franzosenholzbaum, Packholzbaum, Heiligenholz, Lignum sanctum, Lignum vitae (Clarke)\n\n(Dellm.: officinale oder officinalis? (au?er Guajc. noch Taraxacum und Zingiber; alle andere werden mit officinalis bezeichnet)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(126, 'Haematoxylum campechianum', NULL, '(Biblioth. de Gen?ve)\nHaematoxylum, Fernambuck-Holz, Campeschenholz (Jahr SK)\nHaematoxylon campechianum, Kampescheholz, Blauholz, Blutholzbaum, Blutbaum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(127, 'Heliotropium peruvianum', NULL, '(ACS)\nVanillenkraut, Vanillenheliotrop, Eine Sonnenwende (Clarke)', '', '', 1, NULL, '2015-07-13 15:05:14', 6, '2015-07-13 21:05:14', 6),
(128, 'Helleborus niger', NULL, 'Melampodium (FRA)\nSchwarz-Christwurzel (RA Bd.3)\nSchwarze Christwurzel, Schwarz-Nie?wurz (Jahr SK)\nSchwarze Nieswurz, Christrose, Weihnachtsrose, Winterrose, Schneerose (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(129, 'Hepar sulphuris calcareum', NULL, 'Kalkerdige Schwefelleber (RA Bd.4)\nKalk-Schwefelleber (CK Bd.3)\nKalkartige Schwefelleber (Jahr SK) \nCalcarea sulphurata Hahnemannii, Ein unreines Kalziumsulphid (Clarke)\n\n(ein Gemisch von Austernschalen und Schwefelblumen: RA Bd.4)', '<p>ein Gemisch von Austernschalen und Schwefelblumen: RA Bd.4</p>', '', 1, NULL, '2015-09-15 14:07:00', 0, '2014-09-22 17:26:10', 6),
(130, 'Heracleum sphondylium', NULL, 'B?renklau (Jahr SK)\nWiesenb?renklau, B?rentatze, B?renwurz (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(131, 'Hydrocyanicum acidum', NULL, 'Acidum hydrocyanicum (J?rg)\nBlaus?ure (ACS)\nHydrocyani Acidum (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(132, 'Hyoscyamus niger', NULL, 'Bilsenkraut (RA Bd.4)\nSchwarzes Bilsenkraut, H?hnertod, Rindswurz, Zigeunerkorn (Clarke)', '', '', 1, NULL, '2015-06-22 14:44:22', 6, '2015-06-22 20:44:22', 6),
(133, 'Ictodes foetida', NULL, '(Amerik. Korrespondenzblatt)\nPothos foetida (Jahr SK)\nSymplocarpus foetidus, Pothos foetidus, Stinktierkohl, Stinktierkraut (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(134, 'Ignatia amara', 'Ign.', 'Ignazbohne (RA Bd.2)Ignatiusbohne, Ignazbohne, Faba sancti Ignatii (J?rg)Strychnos ignatia (?), Strychnos multiflora (?), Faba indica (Clarke)(Samen: RA Bd.2; Tinktur und Pulver: J?rgStrychnos ign./multiflora: ?Es ist nicht bekannt, von welchem Bauch die Bohnen stammen?, Clarke)', NULL, NULL, 1, '49.37.104.66', '2023-09-15 08:59:55', 1, '2014-09-22 17:49:53', 0),
(135, 'Indigo tinctoria', NULL, 'Indigofera tinctoria, Indigo (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(136, 'Iodium purum', NULL, 'Jodium, Jode, Jodine (CK Bd.3)\nJodine, Tinctura Jodini (J?rg)\nJod (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(137, 'Ipecacuanha', NULL, 'Ipekakuanha, Cephaelis Ipecacuanha Willd., Ruhrwurzel (RA Bd.3)\nCallicocca Ipecacuanha Brat, Brechwurzel (Jahr SK)\nCephaelis ipecacuanha (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(138, 'Jalapa', NULL, 'Jalappa (Jahr SK)\nIpomoea purga (Hayne), Convolvulus purga (Wunderoth), Exogonium purga (Benth.), Jalapawurzel, Jalappe, Trichterwinde (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(139, 'Jatropha curcas', NULL, 'Ficus infernalis, H?llenfeige, Schwarze Brechnu? (Jahr SK)\nSchwarze Purgiernu?, Brechnu? (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(140, 'Juncus effusus', NULL, '(ACS)\nFlatterbinse, Flattersimse (Clarke)', '', '', 1, NULL, '2015-07-13 15:06:56', 6, '2015-07-13 21:06:56', 6),
(141, 'Kalium bichromicum', NULL, '(?ZH)\nKaliumbichromat, Kalium dichromicum (Clarke)', '', '', 1, NULL, '2015-07-01 13:47:33', 6, '2015-07-01 19:47:33', 6),
(142, 'Kalium carbonicum', NULL, 'Kali, Gew?chs-Laugensalz (CK Bd.4)\nKohlensaures Kali (H&T)\nKaliumkarbonat, Neutrales kohlensaures Kali, Pottasche, Gew?chslaugensalz (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(143, 'Kalium chloricum', NULL, '(ACS)\nKali Chloricum, Chlorsaures Kali (Jahr SK)\nKaliumchlorat (Clarke)', '', '', 1, NULL, '2015-07-13 15:07:37', 6, '2015-07-13 21:07:37', 6),
(144, 'Kalium iodatum', NULL, 'Hydriosaures Kali, Kali hydriodicum (H&T)\nKali hydroiodicum, Hydrojodsaures Kali (Jahr SK)\nKalium hydriodicum, Kaliumiodid (Clarke)\n\n(Zuordnung von Kalihydriod. zu Kali iodatum in Clarke)', '<p>Zuordnung von Kalihydriod. zu Kali iodatum in Clarke</p>', '', 1, NULL, '2015-09-16 05:58:00', 6, '2014-09-22 17:26:10', 0),
(145, 'Kalium nitricum', NULL, 'Nitrum, Kali nitricum, Salpeter (CK Bd.4)\nGereinigter Salpeter, Nitrum depuratum, Nitrum, Kali nitricum purum (J?rg)\nSalpetersaures Kali (ACS) \nSalpeter (ANN) \nKaliumnitrat (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(146, 'Kissingen Ragozi-Brunnen', NULL, '(ACS)\nSaline Quellen von Bad Kissingen, Rakoczy-Quelle (Clarke)', '', '', 1, NULL, '2015-07-13 15:08:19', 6, '2015-07-13 21:08:19', 6),
(147, 'Kreosotum', NULL, '(ACS, Wahle)\nKreosot (Jahr SK)\nBuchholzteerkreosot, Holzkohlenteer, Carbo pyroligneus (Clarke)', '', '', 1, NULL, '2015-06-17 15:44:28', 6, '2015-06-17 21:44:28', 6),
(148, 'Lacerta agilis', NULL, '(ACS)\nZauneidechse (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(149, 'Lachesis muta', NULL, '(Hering)\nTrigonocephalus Lachesis, Lachesis-Schlangengift (Jahr SK)\nSurukuku, Ophidiotoxicon, Buschmeisterschlange (Clarke) \n\n(siehe auch Ophiotoxicon (Zahngift unbestimmter Schlangen: brasil. Schlangen & Naja), Jahr SK)', '', '', 1, NULL, '2015-06-24 12:57:52', 6, '2015-06-24 18:57:52', 6),
(150, 'Lactuca virosa', NULL, '(JAL)\nGiftlattig (Jahr SK)\nGilftlattich, Lactuca sativa, Kopfsalat, Lactucarium, Pariser Lactucarium (Clarke)\n\n(in der Tinktur k?nnen beide Arten, L. virosa und L. sativa, enthalten sein, Clarke)', '<p>in der Tinktur können beide Arten, L. virosa und L. sativa, enthalten sein, Clarke</p>', '', 1, NULL, '2015-09-15 14:10:00', 6, '2015-07-01 18:22:22', 6),
(151, 'Lamium album', NULL, 'Wei?bienensaug (ACS)\nWei?e Nessel (Jahr SK)\nWei?e Taubnessel, Bienensaug, Wei?bienensauf (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(152, 'Laurocerasus', NULL, 'Kirschlorbeerwasser, Aqua Laurocerasi (J?rg)\r\nKirschlorbeer, Prunus Laurocerasus (H&T)\r\nAqua laurocerasi (Clarke)\r\n\r\nDell.: Symptome der Blaus?ure (z.B. bei Gerstel) mit hineinnehmen oder als Option? \r\nSymptome von k?nstlicher Blaus?ure u. von bitteren Mandeln mit reinnehmen (H&T)? Oder als Option mit reinnehmen? (Blaus?ure = Hydrocyanicum acid., Bittermandel = Amygdalae amarae)\r\nVorschlag: Amyg. unterscheidet sich kaum von Blaus?ure (Clarke). Blaus?ure: keine sehr kleine Pr?fung, die letzteren beiden zusammenfassen als Option.\r\nHydrocyanicum acidum + Amygdalae aqua', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(153, 'Ledum palustre', NULL, 'Ledum palustre L. (FRA)\nPorst (RA Bd.4)\nSumpfporst, Wilder Rosmarin (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(154, 'Lobelia inflata', NULL, '(HYG)\nLobelie (Jahr SK)\nIndianertabak (Clarke)', '', '', 1, NULL, '2015-07-01 12:15:58', 6, '2015-07-01 18:15:58', 6),
(155, 'Lupulus humulus', NULL, '(AHZ)\nLupulus, Humulus Lupulus, Hopfen (Jahr SK)\nLupulin (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(156, 'Lycopodium clavatum', NULL, 'Lycopodii pollen, B?rlapp-Staub, B?rlapp-Kolbenmoos (CK Bd.4)\nB?rlappsamen, Herenmehl, Streupulver (Jahr SK)\nMuscus terrestris repens, Pes ursinus, Kolbenb?rlapp, Keulenb?rlapp, B?rlappsporen (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(157, 'Magnesium carbonicum', NULL, 'Magnesia carbonica, Magnesie, Bittersalzerde, Bittersalz, Sedlitzer Salz, Epsom-Salz (CK Bd.4)\nKohlensaure Magnesia, Bittererde (H&T)\nKohlensaure Talkerde (Jahr SK)\nMagnesium carbonicum leve (BP), Basisches Magnesiumkarbonat, Kohlensaure Magnesie (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(158, 'Magnesium muriaticum', NULL, 'Magnesia muriatica, Murias magnesiae, Kochsalzsaure Bittersalzerde (CK Bd.4)\nKochsalzsaure Bittererde (ANN) (H&T)\nSalzsaure Bittererde (Jahr SK)\nMagnesiumchlorid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(159, 'Magnesium sulphuricum', NULL, 'Schwefelsaure Bittererde, Magnesia sulphurica (ANN)\nMagnesiumsulfat, Sal amarum, Schwefelsaures Bittersalz, Epsomsalz (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(160, 'Magnetis polus ambo', NULL, 'Magnet, Magnes artificialis (RA Bd.2)\nK?nstlicher Magnet (Jahr SK)\n\n(k?nstlicher Magnet ohne Unterschied der Pole: Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(161, 'Magnetis polus arcticus', NULL, 'Nordpol des Magnetstabes (RA Bd.2)\nNordpol des Magneten (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(162, 'Magnetis polus australis', NULL, 'S?dpol des Magnetstabes (RA Bd.2)\nS?dpol des Magneten (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(163, 'Mancinella', NULL, '(AZH)\nHippomane mancinella, Manschapfel, Manchinellenbaum (Clarke)', '', '', 1, NULL, '2015-06-26 11:49:53', 6, '2015-06-26 17:49:53', 6),
(164, 'Manganum', NULL, 'Manganum, Magnesium, Manganesium, Braunstein, Schwarzes Braunstein-Oxyd, Manganum carbonicum, Kohlensaurer Braunstein (CK Bd.4)\nManganum aceticum aut carbonicum: Manganum aceticum, Manganacetat, Essigsaurer Braunstein, Manganum carbonicum, Mangancarbonat, Kohlensaurer Braunstein (Clarke) \n\n(\"\"Die eine wie die andere Bereitung (d.h.: Mang-c. und Mang-ac.) ist zu nachfolgenden Pr?fungen ihrer reinen Wirkung angewendet worden.\"\" CK Bd. 4 S. 213) (!)\n\nDellm.: warum ?Magnesium? in CK Bd. 4 (und auch in RA Bd.6 bei Mang. aceticum!) als Synonym?\nev. Mang-ac. hiermit zusammenfassen', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(165, 'Manganum aceticum', NULL, 'Essigsaurer Braunstein (Magnesium, Manganesium, Manganum aceticum), Schwarzes Braunstein-Oxyd (RA Bd.6)\n\n(in RA nur die Pr?fung von Mang-ac., s. Manganum)\nManganum aceticum aut carbonic\n\nDellm.: s. Clarke, Manganum: Mang. Carb.  + Mang. Acet. zusammenfassen? Auch hier wieder Magnesium als Synonym, vgl. Manganum.', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(166, 'Menyanthes trifoliata', NULL, 'Bitterklee (RA Bd.5)\nFieberklee (Jahr SK)\nTrifolium fibrinum, Wiesenmangold, Biberklee (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(167, 'Mephitis putorius', NULL, '(ACS) (Nordamerik. Hom. Journal, in Jahr SK)\nViverra putorius, Nordamerikanisches Stinkthier (Jahr SK)\nStinktier (Clarke)', '<p>S. 198-200</p>', '', 1, NULL, '2015-09-15 13:51:00', 0, '2014-09-22 17:26:10', 6),
(168, 'Mercurialis perennis', NULL, '(ACS)\nAusdauerndes Bingelkraut (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(169, 'Mercurius aceticus', NULL, 'Acetas mercurii, Essigsaurer Quecksilber (RA Bd.1)\nMercurius acetatus (Jahr SK)\nQuecksilberacetat, Essigsaures Quecksilber (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(170, 'Mercurius corrosivus', NULL, 'Quecksilber-Sublimat (RA Bd.1 S. 422), \nKochsalzsaures Quecksilbersalz, Aetzsublimat, Mercurius sublimatus corrosivus, Hydrargyrum muriaticum corrosivum (RA Bd.1 S. 348)\nAetzender Quecksilbersublimat (H&T)\nNetzsublimat (Jahr SK)\nMercurius sublimatus, Quecksilbersublimat, ?tzsublimat, Quecksilberchlorid (Clarke)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(171, 'Mercurius dulcis', NULL, 'Vers??tes Quecksilber, Calomel hydrargyrum muriaticum mite (RA Bd.1 S. 348)\nKalomel (Jahr SK)\nCalomel, Quecksilberchlor?r (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(172, 'Mercurius praecipitatus ruber ', NULL, 'Rotes Quecksilberoxyd (RA Bd.1)\nMercurius oxydatus (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(173, 'Mercurius solubilis Hahnemanni', NULL, 'Quecksilber, Argentum vivum, Schwarzes Quecksilberoxyd, Mercurius oxydulatus niger (RA Bd.1 S. 350)\nMercurius solubilis aut vivus, Hydrargyrum oxydulatum nigrum, Scharzes Quecksilberoxyd, Mercuramidonitrat (Clarke)\nMercurius vivus, Argentum vivum, Metallisches\n Quecksilber (Clarke)\n\n(?Obwohl Hahnemann Mercurius solobilis pr?fte, empfahl er die Verwendung von Triturationen des reinen Metalls in der Praxis, da es das am einfachsten herzustellende Quecksilberpr?parat darstellt, leichter erh?ltlich ist und sich in gleichem Ma?e f?r die Verschreibung nach den Symptomen von Mercurius solubilis eignet.?)\n\n(Mercurius vivus = Argentum viv. =  metall. Quecksilber, Hg (Clarke)', '<p>„Obwohl Hahnemann Mercurius solobilis prüfte, empfahl er die Verwendung von Triturationen des reinen Metalls in der Praxis, da es das am einfachsten herzustellende Quecksilberpräparat darstellt, leichter erhältlich ist und sich in gleichem Maße für die Verschreibung nach den Symptomen von Mercurius solubilis eignet.“</p>', '', 1, NULL, '2015-09-15 14:11:00', 0, '2014-09-22 17:49:53', 6),
(174, 'Mercurius, verschied. Quecksilbermittel', NULL, 'Quecksilberrauch, Rauch von Zinnober, verschied. Quecksilbermittel in ?gypten, Sublimat, Quecksilberoxyd, Calomel u.a. (RA Bd.1)\nMercurialia, Unbestimmte Pr?parate (Jahr SK)\n\n(siehe RA Bd.1 S. 429 ff.; alle diese Symptome m?ssen bei den anderen Quecksilber-Mitteln eingearbeitet werden; vgl. andere Mercurius-Mittel bei Clarke)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(175, 'Mezereum', NULL, 'Daphne mezereum L. (FRA)\nKellerhals (CK Bd.4)\nSeidelbast (Jahr SK)\nChamaelia germanica (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(176, 'Millefolium ', NULL, 'Schaafgarbe, Achillaea millefolium (ANN) \nSchafgarbe, Tausendblatt (Jahr SK)\nAchillea millefolium, Gew?hnliche Schafgarbe (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(177, 'Morphinum', NULL, '(H&T)\nMorphinum aceticum aut muriaticium, Morphium, Ein Opiumalkaloid (Clarke)\nMorphinum aceticum, Morphiumacetat, Essigsaures Morphium \nMorphinum muriaticum, Morphinum hydrochloricum, Morphiumhydrochlorat, Salzsaures Morphium\nMorphium sulphuricum, Morphiumsulfat, Schwefelsaures Morphium (Clarke)', '', '', 1, NULL, '2015-07-01 11:41:50', 6, '2015-07-01 17:41:50', 6),
(178, 'Moschus', NULL, 'Bisam (RA Bd.1)\nMoschusbock, Moschus moschiferus, Bisamziege, Bisam (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(179, 'Murex purpurea', NULL, '(Franz?s. Journal, Petroz)\nPurpurmuschel (Jahr SK)\nPurpurschnecke, Eine Meeresschnecke (Clarke)', '', '', 1, NULL, '2015-10-05 14:17:00', 6, '2014-09-22 17:26:10', 0),
(180, 'Muriaticum acidum', NULL, 'Acidum muriaticum, Kochsalzs?ure (RA Bd.5)\nAcidum hydrochloricum (CK Bd.4)\nMuriatis acidum, Salzs?ure (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(181, 'Naja tripudians', NULL, 'Coluber naja, Gemeine Brillenschlange, Kobra, Cobra di Capello, Schildviper, Hutschlange (Clarke)\n\n(siehe Ophiotoxicon: Zahngift unbestimmter Schlangen (brasil. Schlangen & Naja), in Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(182, 'Natrium carbonicum', NULL, 'Natrum carbonicum, Mineralisches Laugensalz, Natron (CK Bd.4)\nNatrum (H&T)\nKohlensaures Laugensalz (Jahr SK)\nNatriumkarbonat (Clarke)\n\n(Natron: basischer Teil des Koch- oder Glaubersalzes: CK Bd.4)\n(Zuordnung von Natrum (H&T) zu Nat-c. (CK) durch Symptomvergleich (in CK Symptome von H&T ?bernommen); Zuordn. auch von B.v.d.Lieth)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(183, 'Natrium muriaticum', NULL, 'Natrum muriaticum, Natrium chloratum, Sal culinare, Kochsalz (CK Bd.4)\nSalzsaures Natrum (Jahr SK)\nNatriumchlorid, Speisesalz, Tafelsalz (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(184, 'Natrium nitricum', NULL, '(ACS)\nNatrum nitricum, Salpetersaures Natrum (Jahr SK)\nNatriumnitrat, Natronsalpeter (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(185, 'Natrium sulphuratum', NULL, 'Schwefelnatrium (ACS, Croserio)\n\n(in Vint separat aufgef?hrt; Internet: Natrium sulphuricum (Nat-s.) Na2CO4, Natrium sulphuratum (Nat-sula) Na2SO4; in Clarke u. Boerike nur Natr. sulphuricum)\n\nDellm.: Unterschied Natr. sulfuricum?', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(186, 'Natrium sulphuricum', NULL, 'Schwefelsaures Natrum (ANN S. 464), Natrum sulphuricum (ANN S. 487)\nGlaubersalz (Jahr SK)\nNatriumsulfat, Sal glauberi (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(187, 'Niccolum carbonicum aut metallicum', NULL, 'Nickel (ANN)\nNickelkarbonat, Metallisches Nickel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(188, 'Nitri spiritus dulcis', NULL, 'Spiritus nitri dulcis, Vers??ter Salpetergeist (Jahr SK)\nSpiritus nitrico aethereus, Aethylum nitrosum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(189, 'Nitricum acidum', NULL, 'Nitri acidum, Salpeters?ure (CK Bd.4)\nAcidum nitricum (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(190, 'Nux moschata', NULL, '(Helbig, Herakid. I)\nMuskatnu? (Jahr SK)\nMyristica fragrans, Myristica officinalis, Myristica moschata (Clarke)', '', '', 1, NULL, '2015-06-30 12:47:17', 6, '2015-06-30 18:47:17', 6),
(191, 'Nux vomica', NULL, 'Strychnos Nux vomica L. (FRA)\nKr?henaugen, Kr?henaug-Samen (RA Bd.1)\nKr?henaugensamen (H&T)\nBrechnu? (Jahr SK)\nStrychninbaum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(192, 'Oenanthe crocata', NULL, '(ACS)\nGiftige Rebendolde (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(193, 'Oleander', NULL, 'Nerium Oleander (RA Bd.1)\nLorbeer-Rose, Oleander (Jahr SK)\nLorbeerrose (Clarke)', '', '', 1, NULL, '2015-07-13 13:19:08', 6, '2015-07-13 19:19:08', 6),
(194, 'Oleum animale', NULL, 'Aetherisches Thier?l, Thier?l?ther, Oleum animale aethereum, Oleum Cornu Cervi rectificatum, Oleum pyro-animale depuratum (H&T) (s. Altschul)\nOleum animale aethereum Dippeli, Oleum cornu cervi, Dippels Tier?l, Knochen-Naphthalin (Clarke)\nOleum Dippelii, Brenz?l (Vermeulen)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(195, 'Oleum jecoris aselli', NULL, 'Oleum jecoris morrhuae, Leberthran, Stockfisch-Leberthran (Jahr SK)\nDorschlebertran, Stockfischlebertran (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(196, 'Oniscus asellus', NULL, '(ACS)\nKellerassel, Tausendbein (Jahr SK)\nOniscus armadillo, Armadillo officinalis, Mauerassel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(197, 'Opium', NULL, 'Papaver somniferum (FRA)\nMohnsaft, Papaver officinale (RA Bd.1)\nSchlafmohn, Klatschmohn (Clarke)\n\n(Tinktur oder gereinigtes Opium: J?rg)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(198, 'Paeonia officinalis', NULL, '(PMG 1826)\nRadix Paeoniae, P?onienwurzel (Jahr SK)\nPfingstrose, Gichtrose (Clarke)', '', '', 1, NULL, '2015-07-01 13:12:20', 6, '2015-07-01 19:12:20', 6),
(199, 'Paris quadrifolia', NULL, 'Paris, Paris quadrifolia L., Vierbl?ttrige Einbeere (ACS)\nEinbeer (H&T)\nEinbeere (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(200, 'Pertusaria corallina', NULL, 'Stereocaulon corallinum (PMG 1826)\n\n(Hauptname durch Internetrecherche gefunden, s. Ausdruck)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(201, 'Petroleum', NULL, 'Oleum petrae, Berg?l, Stein?l (CK Bd.4)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(202, 'Petroselinum sativum', NULL, 'Petersilie (Jahr SK)\nPetroselinum crispum, Carum petroselinum, Apium petroselinum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(203, 'Phellandrium aquaticum', NULL, 'Wasserfenchel, Phellandrium (H&T)\nOenanthe phellandrium, Gro?er Wasserfenchel, Ro?k?mmel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(204, 'Phosphoricum acidum', NULL, 'Phosphors?ure, Acidum phosphoricum (RA Bd.5)\nPhosphori acidum (Jahr SK)', '', '', 1, NULL, '2015-06-23 13:42:41', 6, '2015-06-23 19:42:41', 6),
(205, 'Phosphorus', NULL, 'Phosphor (CK Bd.5)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(206, 'Pinus sylvestris', NULL, 'Gemeine Kiefer (Jahr SK)\nWaldkiefer, F?hre, Forle (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(207, 'Platinum metallicum', NULL, 'Platina, Platigne (CK Bd.5)\nPlatin (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(208, 'Platinum muriaticum', NULL, '(ACS)\nPlatintetrachlorid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(209, 'Platinum muriaticum natronatum', NULL, '(ACS)\nNatriumplatiniumchlorid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(210, 'Plumbum metallicum', NULL, '(ACS, Plumbum aceticum)\nBlei, Essigsaures Blei (H&T)\nBleiacetat, Essigsaures Bleioxyd, \nPlumbum carbonicum, Bleikarbonat, Kohlensaures Blei, Wei?bleierz, Cerussit  (Clarke)\n\n(?Die Wirkungen der drei oben genannten Bleipr?parationen wurden alle im Schema aufgenommen, da weder ein Versuch unternommen wurde, sie voneinander getrennt zu halten, noch spezifische Unterschiede festgestellt wurden.? Clarke)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(211, 'Podophyllum peltatum', NULL, '(AZH 1850)\nFu?blatt, Entenfu?, Maiapfel, Mandrake, Wilde Zitrone (Clarke)', '', '', 1, NULL, '2015-06-30 11:54:45', 6, '2015-06-30 17:54:45', 6),
(212, 'Prunus spinosa', NULL, '(ACS)\nSchlehendorn (Jahr SK)\nSchlehdorn, Schwarzdorn, Schlehe (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(213, 'Psorinum', NULL, '(ACS)\nPsoricum, Psorin, Kr?tzstoff, Die Psora-Nosode, Psora sicca (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(214, 'Pulsatilla pratensis', NULL, 'Anemone pratensis L.(FRA)\nPulsatille (RA Bd.2)\nPulsatilla nigricans, Wiesen-Anemone, K?chenschelle (Jahr SK)\nWiesenk?chenschelle, Wiesenkuhschelle, Wiesenanemone, Osterblume (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(215, 'Ranunculus acris', NULL, '(Stapf B.)\nScharfer Hahnenfu? (Jahr SK)\nGemeiner Wiesenranunkel, Kleine Schmalzblume, Ankelblume (Clarke)', '', '', 1, NULL, '2015-07-01 13:36:26', 6, '2015-07-01 19:36:26', 6),
(216, 'Ranunculus bulbosus', NULL, '(ACS)\nKnolliger Hahnenfu? (Jahr SK)\nZwiebelhahenfu?, Knolliger Ranunkel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(217, 'Ranunculus flammula', NULL, '(Stapf B.)\nKleiner Sumpfhahnenfu? (Jahr SK)\nBrennender Hahnenfu?, Bei?ender Hahnenfu?, Egelkraut, Sumpfranunkel (Clarke)', '', '', 1, NULL, '2015-06-12 10:06:45', 7, '2015-06-12 16:06:45', 7),
(218, 'Ranunculus repens', NULL, '(Stapf B.)\nKriechender Hahnenfu? (Jahr SK)\nAuslaufender Hahnenfu?, Goldkn?pfchen (Clarke)', '', '', 1, NULL, '2015-07-01 13:33:49', 6, '2015-07-01 19:33:49', 6),
(219, 'Ranunculus sceleratus', NULL, '(ACS) \nB?ser Hahnenfu?, Gift-Wasserhahnenfu?, Froschpfeffer, Wassereppich, Gei?blume (Stapf B.)\nGifthahnenfu?, Giftiger Wasserhahnenfu?, Froscheppich (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(220, 'Raphanus sativus', NULL, '(Dr. Nusser)\nRettig (Jahr SK)\nRettich, Raphanus raphanistrum (Hederich) (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0);
INSERT INTO `arznei` (`arznei_id`, `titel`, `kuerzel`, `synonyms`, `kommentar`, `unklarheiten`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(221, 'Ratanhia peruviana', NULL, 'Krameria triandra (H&T)\nRatanhia (Jahr SK)\nKramperia triandra, Mapato, Pumacuchu, Radix Ratanhiae, Ratanhienwurzel (Clarke)\nKramperia peruviana (Remedia)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(222, 'Rhamnus cathartica', NULL, '(AZH)\nGemeiner Kreuzdorn, Purgierkreuzdorn, Purgierwegdorn, Amselbeere, Hirschdorn, Rainbeere (Clarke)', '', '', 1, NULL, '2015-07-01 11:09:50', 6, '2015-07-01 17:09:50', 6),
(223, 'Rhamnus frangula', NULL, '(AZH)\nFaulbaum, Spillbaum, Pulverholz, Zapfenholz  (Clarke)', '', '', 1, NULL, '2015-06-30 12:42:39', 6, '2015-06-30 18:42:39', 6),
(224, 'Rheum palmatum', NULL, 'Rhabarber, Rheum (RA Bd.2)\nRhabarbarum, Rheum undulatum L. (Jahr SK)\nRheum officinale, T?rken-Rhabarber (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(225, 'Rhododendron chrysyanthum', NULL, 'Rhododendron chrysyanthum Pall., Sibirische Schneerose, Gichtrose, Alpenrose (Stapf B.)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(226, 'Rhus toxicodendron', NULL, 'Wurzel-Sumach, Rhus radicans, Rhus toxicodendron (RA Bd.2)\nWurzelsumach (H&T)\nGiftsumach (Jahr SK)\nToxicodendron quercifolium (Clarke)\n\n(?Rhus-radicans und Rhus-t. wurden unabh?ngig voneinander gepr?ft, und wo es n?tig wird, sie zu unterscheiden, werde ich sie als Rhus-r. und Rhus-t. bezeichnen.? Clarke)', '<p>„Rhus-radicans und Rhus-t. wurden unabhängig voneinander geprüft, und wo es nötig wird, sie zu unterscheiden, werde ich sie als Rhus-r. und Rhus-t. bezeichnen.“ Clarke</p>', '', 1, NULL, '2015-09-15 14:16:00', 0, '2014-09-22 17:49:53', 6),
(227, 'Rhus venenata', NULL, '(ACS)\nFirni?sumach, Rhus vernix (Jahr SK)\nToxicodendron venenata, Giftsumach, Firnisbaum, Firnissumach (Clarke)\n\n(Giftsumach ist auch Synonym von Rhus-t.!)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(228, 'Ruta graveolens', NULL, 'Raute (RA Bd.4)\nGartenraute (Jahr SK)\nWeinraute (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(229, 'Sabadilla officinalis', NULL, 'Sabadillsaamen, Veratrum Sabadilla, Semen Sabadillae (ACS) (Stapf B.)\nSabadille, Mexikanischer L?usesamen (Jahr SK)\nSabadilla officinarum, Schoenocaulon officinale, Asgraea officinalis, Veratrum officinale, Cabadilla, Cebadilla, Mexikanisches L?usekraut, Semen sabadillae, L?usesamen (Clarke)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(230, 'Sabina', NULL, 'Sadebaum (ACS) (H&T)\nJuniperus Sabina (Stapf B.)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(231, 'Sambucus nigra', NULL, 'Flieder, Hollunder (RA Bd.5)\nSchwarzer Holunder (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(232, 'Sanguinaria canadensis', NULL, '(Nordamerik. Journal)\nBlutkraut (Jahr SK)\nBlutwurzel, Azetum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(233, 'Sarsaparilla officinalis', NULL, 'Sassaparille, Smilax Sassaparilla (RA Bd.4)\nSassaparilla, Sarsaparilla (CK Bd.5)\nSmilax officinalis, Smilax sarsaparilla, Eine Stechwinde, Sarsaparillawurzel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(234, 'Scrophularia nodosa', NULL, '(ACS)\nGemeine Braunwurz (Jahr SK S. 762)\nScrophularia marylandica, Knotige Braunwurz, Saukraut, Knotenwurz, Feigwarzenkraut (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(235, 'Secale cornutum      ', NULL, 'Mutterkorn (ANN)\nClaviceps purpurea, Mutterkornpilz,korn, Kornzapfen, Hahnensporn (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(236, 'Selenium', NULL, '(ACS)\nSelen (Jahr SK)', '', '', 1, NULL, '2015-07-13 15:09:05', 6, '2015-07-13 21:09:05', 6),
(237, 'Senega', NULL, 'Polygala Senega L., Senegawurzel, Klapperschlangenwurzel, Senegaramsel, Radix Seneka, Polygala virginiana (Stapf B.)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(238, 'Senna', NULL, '(PMG 1826)\nFolia Sennae, Sonnenbl?tter (Jahr SK)\nSennesbl?tter, Cassia obovata, Cassia acutifolia, Cassia senna (Clarke)', '', '', 1, NULL, '2015-07-01 13:07:30', 6, '2015-07-01 19:07:30', 6),
(239, 'Sepia succus', NULL, 'Sepia-Saft (CK Bd.5)\nSepiae succus, Sepiensaft (Jahr SK)\nSepia officinalis, Tintenfisch (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(240, 'Serpentaria aristolochia', NULL, 'Virginisches Schlangenkraut, Radix Serpentariae Virginianae (J?rg)\nAristolochia serpentaria, Virginische Schlangenwurzel, Schlangenwurz-Osterluzei (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(241, 'Silicea terra', NULL, 'Kieselerde, Bergkrystall, Weisser Sand (CK Bd.5)\nTerra silicea, Kiesels?ure, Siliziumanhydrid, Siliziumdioxid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(242, 'Solanum lycopersicum', NULL, '(ACS)\nLycopersicon esculentum, Liebesapfel (Jahr SK S. 762)', '', '', 1, NULL, '2015-07-13 15:10:01', 6, '2015-07-13 21:10:01', 6),
(243, 'Solanum mammosum', NULL, '(ACS)\nZitzen-Nachtschatten (Jahr SK)\nZitzennachtschatten (Clarke)', '', '', 1, NULL, '2015-07-13 15:10:39', 6, '2015-07-13 21:10:39', 6),
(244, 'Solanum nigrum', NULL, '(ACS)\nSchwarzer Nachtschatten (Jahr SK)', '', '', 1, NULL, '2015-07-13 15:11:16', 6, '2015-07-13 21:11:16', 6),
(245, 'Spigelia anthelmia', NULL, 'Spigelie (RA Bd.5)\nWurm-Spigelie (Jahr SK)\nEin Wurmgras (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(246, 'Spongia tosta', NULL, 'R?st-Schwamm, Spongia marina tosta, Badeschwamm (RA Bd.6)\nEuspongia officinalis, Ger?steter Meerschwamm, R?stschwamm (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(247, 'Squilla maritima', NULL, 'Meerzwiebel, Meerzwiebel-Squille (RA Bd.3)\nScilla maritima, Urginea maritima, Ein Blaustern (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(248, 'Stannum metallicum', NULL, 'Zinn, Un?chtes Silber, Metall-Silber, Schaum-Silber (RA Bd.6) (CK Bd.5)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(249, 'Staphysagria', NULL, 'Stephansk?rner, Delphinium Staphisagria (RA Bd.5)\nRittersporn, Stefansk?rner (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(250, 'Stramonium', NULL, 'Datura Stramonium L. (FRA)\nStechapfel (RA Bd.3)\nTeufelsapfel, Tollkraut, Dornapfel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(251, 'Strontium carbonicum', NULL, 'Strontian, Strontianit, C?lestin, Kohlensaurer Strontian, Strontiana carbonica (H&T)\nStrontiana (Jahr SK)\nStrontiumkarbonat, Kohlensaures Strontiumoxid (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(252, 'Sulphur lotum', NULL, 'Schwefel, Schwefelblumen, Flores sulphuris (RA Bd.4)\nStangen-Schwefel (CK Bd.5)\nSulphur sublimatum, Schwefelbl?ten (Clarke)\nSchwefelmilch, Pr?zipitierter Schwefel (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(253, 'Sulphur lotum Dunst', NULL, 'Dunst des brennenden Schwefels (RA Bd. 4 S. 318)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(254, 'Sulphuricum acidum', NULL, 'Schwefel-S?ure, Vitriol-S?ure (CK Bd.5)\nSchwefels?ure, Acidum sulphuricum (ANN)\nSulphuris acidum (Jahr SK)\nVitriols?ure (Clarke)', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(255, 'Tabacum', NULL, 'Taback, Nicotiana Tabacum, Nicotianin (H&T)\nTabak (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(256, 'Tanacetum vulgare', NULL, '(ACS)\nGemeiner Rainfarrn (Jahr SK)\nChrysanthemum vulgare, Rainfarn, Wurmkraut, Kn?pfchen (Clarke)', '', '', 1, NULL, '2015-07-13 14:31:33', 6, '2015-07-13 20:31:33', 6),
(257, 'Taraxacum officinale', NULL, 'Leontodon Taraxacum, L?wenzahn (RA Bd.5)\nPfaffenr?hrlein, Hundeblume (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(258, 'Tartaricum acidum', NULL, '(PMG 1827)\nAcidum tartaricum (PMG)\nTartari acidum, Weinsteins?ure (Jahr SK)\nWeins?ure (Clarke)', '', '', 1, NULL, '2015-07-01 13:12:51', 6, '2015-07-01 19:12:51', 6),
(259, 'Taxus baccata', NULL, '(ACS) (Biblioth. de Gen?ve)\nEibenbaum, Tarusbaum (Jahr SK)\nBeeren-Eibe, Roteibe, Gemeiner Taxbaum (Clarke)', '', '', 1, NULL, '2015-07-13 14:33:17', 6, '2015-07-13 20:33:17', 6),
(260, 'Teplitz aqua', NULL, 'Teplitzer Mineralwasser (ACS)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(261, 'Terebinthiniae oleum', NULL, 'Terpenthin?l (ANN)\nTerebinthina, Oleum Terebinthinae, Terpentin?l (Jahr SK)\nOzonisiertes Terpentin?l (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(262, 'Teucrium marum verum', NULL, 'Katzenkraut, Teucrium marum verum (Stapf B.)\nMarum verum, Katzengamander, Amberkraut, Moschuskraut (Clarke)', '', '', 1, NULL, '2015-07-10 11:44:41', 6, '2015-07-10 17:44:41', 6),
(263, 'Thea chinensis', NULL, 'Thea sinensis, Thea caesarea, Chinesischer Kaiserthee (Jahr SK)\nCamellia sinensis, Chinesischer Tee (schwarzer oder gr?ner Tee), Chinesischer Teestrauch (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(264, 'Theridion curassavicum', NULL, '(ACS)\nFeuerspinnchen (Jahr SK)\nLatrodectus curassavicus, Eine Kugelspinne, Westindische Feuerspinne (Clarke)', '', '', 1, NULL, '2015-07-13 14:35:12', 6, '2015-07-13 20:35:12', 6),
(265, 'Thuja occidentalis', NULL, 'Lebensbaum (RA Bd.5)\nArbor vitae, Sumpfzeder, Totenbaum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(266, 'Tongo   ', NULL, 'Tongobohne, Baryosma Tongo, Dipterix odorata, Coumarouma odorata (ANN)\nCoumarouna odorata, Tonkabaum (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(267, 'Urtica urens', NULL, '(ACS)\nBrennessel (Jahr SK)\nKleine Brennessel, Eiternessel (Clarke)\n\n(Urtica dioica, die gro?e Brennessel, hat ?hnliche, wenn nicht gar identische Eigenschaften; Clarke)', '<p>Urtica dioica, die große Brennessel, hat ähnliche, wenn nicht gar identische Eigenschaften; Clarke</p>', '', 1, NULL, '2015-09-15 12:56:00', 6, '2015-07-13 20:35:40', 6),
(268, 'Uva ursi', NULL, '(ORG 4. Aufl.; aus Jahr SK)\nArbutus uva ursi, B?rentraube (Jahr SK)\nArctostaphylos uva-ursi, Arzneib?rentraube (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(269, 'Valeriana minor', NULL, 'Baldrianwurzel, Valeriana min. L., Valeriana Phu, Valeriana Nardus cretica, Valeriana Cordus (Stapf B. S.120)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(270, 'Valeriana officinalis', NULL, 'Radix Valerianae sylvestris, Baldrianwurzel (J?rg)\nBaldrian, Baldrian-Wurzel, Valeriana Sylvestris (ANN)\nBaldrianwurzel, Valeriana minor L. (Stapf B.)\nEchter Arzneibaldrian, Katzenbaldrian (Clarke)\n\n(Baldrianwurzel = minor = Bald. sylvestris: nach Meyer 1835, s. Quellen, Verschiedenes)\n(bei Gy. keine Unterscheidung von Hahnemanns Pr?fung u. Stapf Beitr?ge (minor))\n\nDellm.: Unterschied officinale / minor?', '', '', 1, NULL, '2014-09-22 11:49:53', 0, '2014-09-22 17:49:53', 0),
(271, 'Veratrum album', NULL, 'Wei?-Nie?wurzel (RA Bd.3)\nWei?e Nie?wurz (Jahr SK)\nWei?er Germer, Brechwurz (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(272, 'Verbascum thapsus', NULL, 'K?nigs-Kerze (RA Bd.6)\nVerbascum thapsus aut thapsiforme, Verbascum densiflorum, Kleinbl?tige K?nigskerze, Gro?bl?tige K?nigskerze, Wollblume (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(273, 'Vespa vulgaris', NULL, '(ACS)\nVespa (Wespe), Vespa crabro (Hornisse), Vespa maculata (Gelbjacke, amerikanische Hornisse) (Clarke)', '', '', 1, NULL, '2015-07-13 14:36:08', 6, '2015-07-13 20:36:08', 6),
(274, 'Vinca minor', NULL, '(ACS)\nWintergr?n, Kleines Sinngr?n (Jahr SK)\nImmergr?n (Clarke)', '', '', 1, NULL, '2015-07-13 14:36:36', 6, '2015-07-13 20:36:36', 6),
(275, 'Viola odorata', NULL, 'M?rzveilchen (ACS)\nWohlriechendes Veilchen (Jahr SK)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(276, 'Viola tricolor', NULL, 'Freisam-Veilchen, Jacea (ACS)\nStiefm?tterchen (Jahr SK)\nAckerstiefm?tterchen, Feldstiefm?tterchen, Freisamveilchen, Dreifaltigkeitsblume, Jel?ngerjelieber (Clarke)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(277, 'Vipera redi', NULL, '(Hering, Schlangengift)\nItalienische Otter (Jahr SK)', '', '', 1, NULL, '2015-09-15 13:19:00', 0, '2014-09-22 17:26:10', 6),
(278, 'Vipera torva', NULL, '(Hering, Schlangengift)\nDeutsche Otter (Jahr SK)', '', '', 1, NULL, '2015-09-15 13:19:00', 0, '2014-09-22 17:26:10', 6),
(279, 'Wiesbaden aqua', NULL, '(ACS)\nThermen in Wiesbaden (Clarke)', '', '', 1, NULL, '2015-07-13 14:38:01', 6, '2015-07-13 20:38:01', 6),
(280, 'Zincum aceticum', NULL, '(ACS)\nZinkacetat (Clarke)', '', '', 1, NULL, '2015-07-13 14:39:10', 6, '2015-07-13 20:39:10', 6),
(281, 'Zincum metallicum', NULL, 'Zink, Metallisches Zink (CK Bd.5)', '', '', 1, NULL, '2014-09-22 11:26:10', 0, '2014-09-22 17:26:10', 0),
(282, 'Zincum muriaticum', NULL, '(ACS)\nZinkchlorid (Clarke)', '', '', 1, NULL, '2015-07-13 14:39:32', 6, '2015-07-13 20:39:32', 6),
(283, 'Zincum oxydatum', NULL, '(HYG)\nZinkoxyd (Jahr SK)\nZinkoxid (Clarke)', '', '', 1, NULL, '2015-06-30 11:52:09', 6, '2015-06-30 17:52:09', 6),
(284, 'Zincum sulphuricum', NULL, '(ACS)\nSchwefelsaures Zink (Jahr SK)\nZinksulfat, Schwefelsaurer Zink, Zinkvitriol (Clarke)', '', '', 1, NULL, '2015-07-13 14:40:01', 6, '2015-07-13 20:40:01', 6),
(285, 'Zingiber officinale', NULL, '(ACS)\nIngwer (Jahr SK)', '', '', 1, NULL, '2015-07-13 14:40:24', 6, '2015-07-13 20:40:24', 6),
(287, 'Artemisia absinthium', NULL, NULL, '', '', 1, NULL, '2015-06-03 14:07:47', 6, '2015-06-03 20:07:47', 6),
(288, 'Dictamnus albus', NULL, NULL, '', '', 1, NULL, '2015-06-11 13:18:22', 6, '2015-06-11 19:18:22', 6),
(290, 'ParamTest', 'Bapt.', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-12 10:53:47', NULL),
(291, 'ParamTest 2', 'Hyos.', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-07-12 10:53:47', NULL),
(292, 'Test Remedy Partha', 'TRP', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-03-05 08:40:38', NULL),
(293, '', '', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-03-05 08:40:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `arznei_autor`
--

CREATE TABLE `arznei_autor` (
  `arznei_id` int(11) UNSIGNED NOT NULL COMMENT 'medicine_id',
  `autor_id` int(11) UNSIGNED NOT NULL COMMENT 'author_id',
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arznei_autor`
--

INSERT INTO `arznei_autor` (`arznei_id`, `autor_id`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(2, 18, '2016-02-03 10:23:42', NULL, NULL, NULL),
(11, 10, '2016-02-03 10:23:42', NULL, NULL, NULL),
(19, 11, '2016-02-03 10:23:42', NULL, NULL, NULL),
(95, 15, '2016-02-03 10:23:42', NULL, NULL, NULL),
(118, 5, '2016-02-03 10:23:42', NULL, NULL, NULL),
(147, 17, '2016-02-03 10:23:42', NULL, NULL, NULL),
(149, 15, '2016-02-03 10:23:42', NULL, NULL, NULL),
(177, 10, '2016-02-03 10:23:42', NULL, NULL, NULL),
(179, 37, '2016-02-03 10:23:42', NULL, NULL, NULL),
(190, 14, '2016-02-03 10:23:42', NULL, NULL, NULL),
(193, 11, '2016-02-03 10:23:42', NULL, NULL, NULL),
(215, 2, '2016-02-03 10:23:42', NULL, NULL, NULL),
(217, 2, '2016-02-03 10:23:42', NULL, NULL, NULL),
(218, 2, '2016-02-03 10:23:42', NULL, NULL, NULL),
(226, 1, '2016-02-03 10:23:42', NULL, NULL, NULL),
(262, 2, '2016-02-03 10:23:42', NULL, NULL, NULL),
(277, 15, '2016-02-03 10:23:42', NULL, NULL, NULL),
(278, 15, '2016-02-03 10:23:42', NULL, NULL, NULL),
(287, 1, '2016-02-03 10:23:42', NULL, NULL, NULL),
(288, 7, '2016-02-03 10:23:42', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `arznei_quelle`
--

CREATE TABLE `arznei_quelle` (
  `arznei_id` int(11) UNSIGNED NOT NULL COMMENT 'medicine_id',
  `quelle_id` int(11) UNSIGNED NOT NULL COMMENT 'source_id',
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arznei_quelle`
--

INSERT INTO `arznei_quelle` (`arznei_id`, `quelle_id`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(41, 120, NULL, NULL, '2024-02-05 09:01:52', NULL),
(164, 2195, NULL, NULL, '2023-06-07 10:39:41', NULL),
(230, 2206, NULL, NULL, '2023-10-10 13:56:04', NULL),
(292, 3119, NULL, NULL, '2025-01-10 17:00:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE `autor` (
  `autor_id` int(11) UNSIGNED NOT NULL COMMENT 'Author id',
  `code` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Also known as Abbreviation and Kürzel',
  `suchname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Wird für die Auswahlboxen genutzt (Will be used for the selection boxes)',
  `titel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Title (here it is using like salutation)',
  `vorname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'first given name',
  `nachname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Surname',
  `geburtsdatum` date DEFAULT NULL COMMENT 'Date of birth',
  `sterbedatum` date DEFAULT NULL COMMENT 'date of death',
  `kommentar` text CHARACTER SET utf8 DEFAULT NULL COMMENT 'comment',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'Updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editorID',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'Created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creatorID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='author' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`autor_id`, `code`, `suchname`, `titel`, `vorname`, `nachname`, `geburtsdatum`, `sterbedatum`, `kommentar`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(1, 'Hn', NULL, 'Dr.', 'C. F. Samuel', 'Hahnemann', NULL, NULL, NULL, 1, '185.71.171.27', '2024-04-01 16:04:43', 1, '2015-05-21 17:29:03', 1),
(2, 'EST', NULL, '', 'Ernst Stapf', 'Stapf', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-05-21 17:29:03', 1),
(3, 'Hl', NULL, 'Dr.', 'Carl Georg Christian', 'Hartlaub', NULL, NULL, NULL, 1, '93.129.195.147', '2024-01-05 18:06:39', 1, '2015-06-17 20:54:44', 1),
(4, 'Clar', NULL, NULL, NULL, 'Clarke', NULL, NULL, NULL, 1, '49.37.104.116', '2023-09-20 10:19:24', 1, '2015-05-21 17:29:03', 0),
(5, 'CASP', NULL, '', 'Carl Gottlob', 'Caspari', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-05-21 17:29:03', 1),
(6, 'Gr.', NULL, '', 'Gross', 'Gross', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-01 12:28:59', 1),
(8, 'JAS', NULL, '', 'Johann Adolph Schubert', 'Schubert', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-04 14:44:51', 1),
(9, 'CGF', NULL, '', 'C. G. Franz', 'Franz', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-17 19:48:00', 1),
(10, 'Ts', NULL, 'Dr.', 'Carl Friedrich', 'Trinks', NULL, NULL, NULL, 1, '49.37.104.221', '2023-11-15 13:16:26', 98, '2015-06-17 19:49:16', 1),
(11, 'Jr', NULL, NULL, 'Georg Heinrich Gottlieb Jahr', 'Jahr', NULL, NULL, NULL, 1, '49.37.104.221', '2023-11-15 13:48:48', 98, '2015-06-17 20:40:17', 1),
(13, 'JEG', NULL, '', 'J. E.  Greding', 'Greding', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-17 20:52:58', 1),
(14, 'Helb.', NULL, '', 'C. G.  Helbing', 'Helbing', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-17 20:53:42', 1),
(15, 'Hr', NULL, 'Dr.', 'Constantine', 'Hering', '1800-01-01', '1880-11-07', NULL, 1, '77.189.52.125', '2024-03-22 12:03:30', 1, NULL, 0),
(16, 'Clarke', NULL, NULL, 'J. H.  Clarke', 'Clarke', NULL, NULL, NULL, 1, '49.37.105.71', '2023-03-21 10:12:21', 1, '2015-06-17 21:27:09', 1),
(17, 'W', NULL, '', 'Wahle', 'Wahle', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-17 21:44:12', 1),
(18, 'DS', NULL, NULL, 'Theodor J.', 'Rückert J', NULL, NULL, NULL, 1, '49.37.104.116', '2023-09-20 09:53:52', 1, '2015-07-06 14:25:09', 1),
(19, 'FH', NULL, '', 'Franz Hartmann', 'Hartmann', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-19 19:19:38', 1),
(20, 'Schw', NULL, '', 'Georg August Benjamin Schweikert', 'Schweikert', '1774-09-25', '1845-12-15', '', 1, '', '2018-09-26 08:28:48', 1, '2015-06-22 20:20:50', 1),
(22, 'S', NULL, '', 'Sonnenberg', 'Sonnenberg', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-24 20:12:34', 1),
(23, 'JvP', NULL, '', 'Joseph von Pleyel', 'von Pleyel', NULL, NULL, '', 1, '', '2018-10-05 05:55:25', 1, '2015-06-25 18:08:07', 1),
(31, 'FJR', NULL, '', 'Friedrich Jakob Rummel', 'Rummel', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 0, NULL, 1),
(32, 'KzB', NULL, '', 'Kretschmar zu Belzig', 'Kretschmar zu Belzig', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 0, NULL, 1),
(33, 'Loe', NULL, '', 'Gottlob Heinrich Löscher', 'Löscher', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 1),
(34, 'Zink', NULL, '', 'Moritz Zinkhan', 'Zinkhan', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 0, NULL, 1),
(35, 'Bern', NULL, '', 'Bernhardi', 'Bernhardi', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 0, NULL, 1),
(38, '', NULL, '', 'J. K. ', 'Baudis', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(39, '', NULL, '', '', 'Messerschmidt', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(40, '', NULL, '', 'Giuseppe', 'Mauro', NULL, NULL, '<p>In Palermo geboren; kam 1814 nach Neapel</p>', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(41, '', NULL, '', '', 'Diehl', NULL, NULL, '<p>Dr. Diehl zu Bruchsal im Großherzogtum Baden</p>', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(42, '', NULL, '', '', 'Necher', NULL, NULL, '<p>Dr. Necher in Neapel, Leibarzt von Baron von Koller, promovierte an der Neapolitanischen Universität</p>', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(43, '', NULL, '', '', 'Bigel', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(44, '', NULL, '', 'Timothy Field', 'Allen', '1837-04-24', '1902-12-05', '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(45, '', NULL, '', 'Bernhard', 'Bähr', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(46, '', NULL, '', 'W.', 'Reil', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(47, '', NULL, '', 'Antoine Jaques Louis', 'Jourdan', '1788-12-29', '1848-01-02', '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(48, '', NULL, '', 'R. E.', 'Dudgeon', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(49, 'Na', NULL, 'Dr.', 'Alphons', 'Noack', '1809-03-10', '1885-05-01', NULL, 1, '49.37.107.50', '2023-11-16 12:22:02', 98, NULL, 0),
(50, '', NULL, 'Dr.', 'H.C.', 'Allen', NULL, NULL, '', 1, '', '2018-10-05 05:56:35', 1, NULL, 0),
(51, 'PPM', NULL, 'Prof.', 'Partha', 'Pratim', NULL, NULL, NULL, 1, '49.37.104.200', '2024-01-09 10:59:50', 1, '2023-09-20 09:54:52', 1),
(52, 'Ml', NULL, 'Dr.', 'Clotar', 'Müller', NULL, NULL, NULL, 1, '78.51.16.240', NULL, NULL, '2024-03-21 20:44:13', 1),
(53, 'Bn', NULL, 'Dr.', 'Clemens', 'von Bönninghausen', NULL, NULL, NULL, 1, '77.189.52.125', NULL, NULL, '2024-03-22 11:55:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pre_comparison_master_data`
--

CREATE TABLE `pre_comparison_master_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `quelle_id` int(11) DEFAULT NULL,
  `table_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comparison_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `similarity_rate` int(11) DEFAULT NULL,
  `comparison_language` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'de or en',
  `arznei_id` int(11) DEFAULT NULL,
  `comparison_option` int(11) DEFAULT NULL,
  `initial_source` int(11) DEFAULT NULL,
  `comparing_sources` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('queued','processing','done','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'queued' COMMENT '''queued'',''processing'',''done'',''failed''',
  `comparison_save_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Initial stage when compared(Blue), 1 = State when user saved comparison(Yellow), 2 = State when admin approved the saved comparison(Green), 3 when supervisor is working in a comparison(orange)',
  `is_comparison_renamed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=Yes, 0=No',
  `final_view` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `rmm` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `chapter_assigned_complete` int(11) NOT NULL DEFAULT 0,
  `editor_connection_process` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Used for automatic connection process by the editor in the comparison page',
  `editor_ini` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pruefer`
--

CREATE TABLE `pruefer` (
  `pruefer_id` int(11) UNSIGNED NOT NULL COMMENT 'tester_id',
  `kuerzel` varchar(1024) CHARACTER SET utf8 DEFAULT NULL COMMENT 'shortcut (separate several with "|")',
  `suchname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT ' search name [Wird für die Auswahlboxen genutzt (Will be used for the selection boxes)]',
  `titel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'title',
  `vorname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'first given name',
  `nachname` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'surname',
  `geburtsdatum` date DEFAULT NULL COMMENT 'date of birth',
  `sterbedatum` date DEFAULT NULL COMMENT 'date of death',
  `kommentar` text CHARACTER SET utf8 DEFAULT NULL COMMENT 'comment',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='tester';

--
-- Dumping data for table `pruefer`
--

INSERT INTO `pruefer` (`pruefer_id`, `kuerzel`, `suchname`, `titel`, `vorname`, `nachname`, `geburtsdatum`, `sterbedatum`, `kommentar`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(3, 'St.', 'Stapf', NULL, NULL, 'Stapf', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(4, 'SH', NULL, 'Dr.', 'Samuel', 'Hahnemann', NULL, NULL, NULL, 1, '77.182.154.7', '2022-12-14 20:56:54', 1, NULL, NULL),
(5, 'v Gf', 'Gersdorff', NULL, NULL, 'von Gersdorff', NULL, NULL, NULL, 1, '82.212.9.221', '2018-11-23 10:34:33', 1, NULL, NULL),
(7, 'Hm|Htn|Htm', 'Hartmann', NULL, NULL, 'Hartmann', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(8, 'Cp', 'Caspari', NULL, NULL, 'Caspari', NULL, NULL, NULL, 1, '82.212.9.221', '2018-11-23 10:58:37', 1, NULL, NULL),
(10, 'Frz.|Fz|Franz|Carl Franz', NULL, NULL, NULL, 'Franz', NULL, NULL, NULL, 1, '78.51.16.240', '2024-03-21 20:49:34', 1, NULL, NULL),
(12, 'Thn', 'Teuthorn', NULL, NULL, 'Teuthorn', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(13, 'Schk', 'Schönke', NULL, NULL, 'Schönke', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(14, 'Lgh|Lr|Langhammer|Lhr', 'Langhammer', NULL, NULL, 'Langhammer', NULL, NULL, NULL, 1, '82.212.9.221', '2018-11-27 12:05:54', 1, NULL, NULL),
(15, 'Ng.|Nn', NULL, 'Dr.', 'D.', 'Nenning', NULL, NULL, NULL, 1, '78.94.1.201', '2022-12-19 11:07:34', 1, NULL, NULL),
(16, 'Herm.|Hmn', NULL, NULL, NULL, 'Herrmann', NULL, NULL, NULL, 1, '78.51.16.240', '2024-03-21 20:50:43', 1, NULL, NULL),
(17, 'v. S.', 'Sonnenberg', NULL, NULL, 'von Sonnenberg', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(18, 'v. Pl.', 'Pleyel', NULL, NULL, 'von Pleyel', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(19, 'Fr. Hn.|F. H-n.|Fr. H-n.|Fr. Hahnemann|Fr. H.', 'Friedrich Hahnemann', NULL, 'Friedrich', 'Hahnemann', NULL, NULL, NULL, 1, '82.212.9.221', '2021-06-07 08:38:01', 1, NULL, NULL),
(20, 'Bthm.', NULL, 'Dr.', 'Heinrich', 'Bethmann', NULL, NULL, NULL, 1, '78.94.1.201', '2022-12-19 11:08:09', 1, NULL, NULL),
(22, 'S.', NULL, 'Dr.', NULL, 'Schréter', NULL, NULL, NULL, 1, '78.94.1.201', '2022-12-19 11:10:01', 1, NULL, NULL),
(1454, 'Hrnb.|Hornburg|Chn. G. Hornburg', NULL, NULL, NULL, 'Hornburg', NULL, NULL, NULL, 1, '78.51.16.240', '2024-03-21 20:48:42', 1, NULL, NULL),
(2208, 'Bhr.|Baehr.|Baehr', 'Baehr', NULL, 'August', 'Baehr', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(2210, 'Kr.|Kummer|Ernst Eduard Kummer', 'Kummer', NULL, NULL, 'Kummer', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(2211, 'Wsl.|Wislicenus|W. E. Wislicenus|Ws.', NULL, NULL, NULL, 'Wislicenus', NULL, NULL, NULL, 1, '78.51.16.240', '2024-03-21 20:50:11', 1, NULL, NULL),
(2212, 'Wahle|Wilh. Wahle', 'Wahle', 'Dr.', 'Johann Wilhelm', 'Wahle', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(2213, 'Ahner', 'Ahner', NULL, 'Gustav', 'Ahner', NULL, NULL, NULL, 1, NULL, '2018-02-14 14:36:12', 1, NULL, NULL),
(2214, 'Rückert|Rck', 'Rückert', 'Dr.', 'C. F.', 'Rückert', NULL, NULL, NULL, 1, '77.190.100.40', '2018-11-02 00:02:28', 1, NULL, NULL),
(2217, 'Stf.', 'Stf.', '', '', 'Stapf', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2218, 'Bte.', NULL, 'Dr.', 'H. G.', 'Bute', NULL, NULL, NULL, 1, '78.94.1.201', '2022-12-19 11:38:19', 1, NULL, NULL),
(2219, 'Prüfer', 'Prüfer', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:12:32', NULL),
(2220, 'Htb.|Hb.', NULL, 'Dr.', 'Carl Georg Christian', 'Hartlaub', NULL, NULL, NULL, 1, '78.94.1.201', '2022-12-19 11:08:45', 1, NULL, NULL),
(2221, 'Voigtel', 'Voigtel', '', '', 'Voigtel', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2222, 'Bds.', 'Bds.', '', '', 'Bds', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2223, 'Jahn', 'Jahn', '', '', 'Jahn', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2224, 'Mbn.', 'Mbn.', '', '', 'Mbn', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2225, 'Sr.', 'Sr.', '', '', 'Sr', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2226, 'Goull.', 'Goull.', '', '', 'Goull', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2227, 'Whl.', 'Whl.', 'Dr.', '', 'Wahle', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2228, 'Fr. Walther.|Walther', 'Fr. Walther.', '', 'Fr.', 'Walther', NULL, NULL, '', 1, NULL, '2024-02-17 13:33:33', NULL, NULL, NULL),
(2229, 'Andoynus.', 'Andoynus.', '', '', 'Andoynus', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2230, 'Ts.|Tr.', NULL, 'Dr.', 'Charles Friedrich Gottfried', 'Trinks', NULL, NULL, NULL, 1, '78.94.1.201', '2022-12-19 11:07:04', 1, '2021-06-07 09:17:25', NULL),
(2231, 'Gr.|Groß|Gss.', NULL, 'Dr.', NULL, 'Groß', NULL, NULL, NULL, 1, '78.51.16.240', '2024-04-30 10:13:06', 1, NULL, NULL),
(2233, 'Hbg.', 'Hbg.', 'Dr.', '', 'Hornburg', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2234, 'Dr. Douglas', 'Dr. Douglas', 'Dr.', '', 'Douglas', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2235, 'J. S. Douglas', 'J. S. Douglas', 'Dr.', '', 'Douglas', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2238, 'Hg.', NULL, 'Dr.', 'Constantin', 'Hering', NULL, NULL, NULL, 1, '78.94.1.201', NULL, NULL, '2022-12-19 11:06:26', 1),
(2240, 'Hahnemann', 'Hahnemann', '', '', 'Hahnemann', NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL),
(2241, 'Hrtb.', 'Hrtb.', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2024-02-29 08:21:34', NULL, '2024-02-12 08:24:09', NULL),
(2249, 'Hrtm.', NULL, 'Dr.', 'Franz', 'Hartmann', NULL, NULL, NULL, 1, '78.51.16.240', '2024-03-21 20:55:44', 1, '2024-03-08 10:24:53', NULL),
(2252, 'Lemn.|Lemnius, a.a.O.', NULL, 'Dr.', 'L.', 'Lemnius', NULL, NULL, NULL, 1, '78.51.16.240', '2024-03-21 21:04:18', 1, NULL, NULL),
(2253, 'Lngh.', NULL, 'Dr.', NULL, 'Langhammer', NULL, NULL, NULL, 1, '78.51.16.240', NULL, NULL, '2024-03-21 20:53:46', 1),
(2254, 'Hartlaub', 'Hartlaub', NULL, NULL, 'Hartlaub', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(2255, 'Nenning', 'Nenning', NULL, NULL, 'Nenning', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(2256, 'Schreter', 'Schreter', NULL, NULL, 'Schreter', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(2257, 'Trinks', 'Trinks', NULL, NULL, 'Trinks', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(2258, 'Bute', 'Bute', NULL, NULL, 'Bute', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(2259, 'Fr. Walther, in einem Aufsatze|Fr. Walther|F. Walther', NULL, NULL, 'Fr.', 'Walther', NULL, NULL, NULL, 1, '49.37.111.48', NULL, NULL, '2024-11-26 11:46:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quelle`
--

CREATE TABLE `quelle` (
  `quelle_id` int(11) UNSIGNED NOT NULL COMMENT 'source_id',
  `quelle_type_id` int(11) UNSIGNED DEFAULT NULL COMMENT '1 = Bücher or Quelle, 2 = Zeitschriften, 3 = Saved comparison quelle',
  `quelle_schema_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'source_schema_id',
  `herkunft_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'origin_id ',
  `code` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Kürzel (shortcut name of the source)',
  `titel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'title',
  `title_abbreviation_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_abbreviation_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_abbreviation_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_abbreviation_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jahr` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'year',
  `band` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `jahrgang` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'vintage',
  `nummer` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'number',
  `supplementheft` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'supplement issue',
  `auflage` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'edition',
  `file_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'uploaded file',
  `verlag_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'publisher_id',
  `sprache` enum('deutsch','englisch') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'language(''deutsch'',''englisch'')',
  `source_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autor_or_herausgeber` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kommentar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comment (@C)',
  `potency_of_remedy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_coding_with_symptom_number` tinyint(1) NOT NULL DEFAULT 1,
  `is_materia_medica` tinyint(4) NOT NULL DEFAULT 1,
  `comparison_save_status` tinyint(1) NOT NULL DEFAULT 2 COMMENT '0 = Initial stage when compared(Blue), 1 = State when user saved comparison(Yellow), 2 = State when admin approved the saved comparison(Green), 3 when supervisor is working in a comparison(orange)',
  `editor_ini` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Source';

--
-- Dumping data for table `quelle`
--

INSERT INTO `quelle` (`quelle_id`, `quelle_type_id`, `quelle_schema_id`, `herkunft_id`, `code`, `titel`, `title_abbreviation_1`, `title_abbreviation_2`, `title_abbreviation_3`, `title_abbreviation_4`, `jahr`, `band`, `jahrgang`, `nummer`, `supplementheft`, `auflage`, `file_url`, `verlag_id`, `sprache`, `source_type`, `autor_or_herausgeber`, `kommentar`, `potency_of_remedy`, `is_coding_with_symptom_number`, `is_materia_medica`, `comparison_save_status`, `editor_ini`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(139, 22, NULL, NULL, NULL, 'remedia.at', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'deutsch', NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 1, NULL, '2018-10-23 05:46:05', 1, '2016-01-27 20:10:00', 1),
(3018, 3, NULL, NULL, NULL, 'HlPPM1 1811_6 1821_Vinca minor', NULL, NULL, NULL, NULL, '1811', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, 1, NULL, NULL, NULL, '2024-08-20 08:59:24', NULL),
(3050, 3, NULL, NULL, '1833_EST1 2013_ParamTest', '1833_EST1 2013_ParamTest', NULL, NULL, NULL, NULL, '1833', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 1, NULL, NULL, NULL, '2024-09-02 13:16:48', NULL),
(3119, 1, NULL, 7, NULL, 'Testing Source', 'TS', NULL, NULL, NULL, '2025', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'englisch', NULL, NULL, NULL, NULL, 0, 1, 2, 'ADMIN', 1, '117.238.109.60', '2025-01-10 17:00:26', NULL, '2025-01-10 16:55:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quelle_autor`
--

CREATE TABLE `quelle_autor` (
  `quelle_id` int(11) UNSIGNED NOT NULL COMMENT 'source_id',
  `autor_id` int(11) UNSIGNED NOT NULL COMMENT 'author_id',
  `insert_order` int(11) NOT NULL DEFAULT 0,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quelle(Source) and autor(author) relationship table';

--
-- Dumping data for table `quelle_autor`
--

INSERT INTO `quelle_autor` (`quelle_id`, `autor_id`, `insert_order`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(3119, 51, 0, NULL, NULL, '2025-01-10 16:55:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quelle_autor_as_editor`
--

CREATE TABLE `quelle_autor_as_editor` (
  `quelle_id` int(11) UNSIGNED NOT NULL COMMENT 'source_id',
  `autor_id` int(11) UNSIGNED NOT NULL COMMENT 'author_id',
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This is the relationship between Quelle(Source) and autor(author) as editor';

-- --------------------------------------------------------

--
-- Table structure for table `quelle_import_master`
--

CREATE TABLE `quelle_import_master` (
  `id` int(11) NOT NULL,
  `import_rule` varchar(60) DEFAULT NULL,
  `importing_language` varchar(50) DEFAULT NULL,
  `is_symptoms_available_in_de` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Yes, 0 = No',
  `is_symptoms_available_in_en` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Yes, 0 = No',
  `translation_method_of_de` varchar(100) DEFAULT NULL COMMENT 'Professional Translation, Google Translation, If it is a saved comparison then value will be NULL',
  `translation_method_of_en` varchar(100) DEFAULT NULL COMMENT 'Professional Translation, Google Translation, If it is a saved comparison then value will be NULL',
  `arznei_id` int(11) DEFAULT NULL,
  `quelle_id` int(11) DEFAULT NULL,
  `pruefer_ids` varchar(255) DEFAULT NULL COMMENT 'comma separated pruefer ids',
  `excluding_symptoms_chapters` varchar(255) DEFAULT NULL COMMENT 'Chapters to exclude their symptoms in comparison',
  `import_comment` varchar(255) DEFAULT NULL COMMENT 'Comment (@C)',
  `is_synonyms_up_to_date` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Yes, 0=No',
  `is_materia_medica` tinyint(1) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quelle_import_master`
--

INSERT INTO `quelle_import_master` (`id`, `import_rule`, `importing_language`, `is_symptoms_available_in_de`, `is_symptoms_available_in_en`, `translation_method_of_de`, `translation_method_of_en`, `arznei_id`, `quelle_id`, `pruefer_ids`, `excluding_symptoms_chapters`, `import_comment`, `is_synonyms_up_to_date`, `is_materia_medica`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(4168, 'default_setting', 'de', 1, 0, 'Professional Translation', NULL, 41, 120, NULL, NULL, NULL, 0, 1, 1, '49.37.111.11', '2024-09-26 09:13:59', 1, '2024-02-05 09:01:52', NULL),
(5069, 'default_setting', 'en', 0, 1, NULL, 'Professional Translation', 292, 3119, NULL, NULL, NULL, 0, 1, 1, '127.0.0.1', '2025-01-11 05:08:43', 100, '2025-01-10 17:00:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quelle_import_test`
--

CREATE TABLE `quelle_import_test` (
  `id` int(11) NOT NULL,
  `original_symptom_id` int(11) DEFAULT NULL COMMENT 'NULL if it is the original, else original symptom id',
  `master_id` int(11) DEFAULT NULL COMMENT 'Quelle import master id',
  `arznei_id` int(11) DEFAULT NULL,
  `quelle_id` int(11) DEFAULT NULL,
  `original_quelle_id` int(11) DEFAULT NULL,
  `quelle_code` varchar(255) DEFAULT NULL COMMENT 'concatenated code of quelle''s(code+'' ''+jahr)',
  `Symptomnummer` int(11) DEFAULT NULL,
  `SeiteOriginalVon` int(11) DEFAULT NULL,
  `SeiteOriginalBis` int(11) DEFAULT NULL,
  `final_version_de` text DEFAULT NULL,
  `final_version_en` text DEFAULT NULL,
  `Beschreibung_de` text DEFAULT NULL COMMENT 'The whole symptom string is kept here as it is found in the doc without any modifications',
  `Beschreibung_en` text DEFAULT NULL COMMENT 'The whole symptom string is kept here as it is found in the doc without any modifications in english',
  `BeschreibungOriginal_de` text DEFAULT NULL COMMENT 'The whole symptom string is kept here with applicable modifications (This string will remain unchange after import)',
  `BeschreibungOriginal_en` text DEFAULT NULL COMMENT 'The whole symptom string is kept here with applicable modifications in english (This string will remain unchange after import)',
  `BeschreibungFull_de` text DEFAULT NULL COMMENT 'The whole symptom string is kept here with applicable modifications in german (This string will be use in operations, and this can get change by edit operation)',
  `BeschreibungFull_en` text DEFAULT NULL COMMENT 'The whole symptom string is kept here with applicable modifications in english (This string will be use in operations, and this can get change by edit operation)',
  `BeschreibungPlain_de` text DEFAULT NULL COMMENT 'The whole symptom string is kept here as plain means without any html tags',
  `BeschreibungPlain_en` text DEFAULT NULL COMMENT 'The whole symptom string is kept here as plain means without any html tags in english',
  `searchable_text_de` text DEFAULT NULL COMMENT 'This is the searchable symptom string used in comparison. Only symptom string is kept here excluding other data pruefer, remedy, time data etc.',
  `searchable_text_en` text DEFAULT NULL COMMENT 'This is the searchable symptom string used in comparison. Only symptom string is kept here excluding other data pruefer, remedy, time data etc. in english',
  `bracketedString_de` varchar(255) DEFAULT NULL,
  `bracketedString_en` varchar(255) DEFAULT NULL,
  `part_of_symptom_string` varchar(255) DEFAULT NULL,
  `timeString_de` varchar(255) DEFAULT NULL,
  `timeString_en` varchar(255) DEFAULT NULL,
  `Fussnote` text DEFAULT NULL,
  `PrueferID` varchar(255) DEFAULT NULL,
  `EntnommenAus` text DEFAULT NULL COMMENT 'full literature reference text	',
  `Verweiss` text DEFAULT NULL,
  `Graduierung` varchar(255) DEFAULT NULL,
  `BereichID` varchar(255) DEFAULT NULL,
  `isKDCommandChapter` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1= Yes, 0=No (if chapter is assigned through @KD command then its value is 1, Chapter assigned through @KD command is superior to automatic chapter assignment process)',
  `Kommentar` text DEFAULT NULL,
  `Unklarheiten` text DEFAULT NULL,
  `Remedy` varchar(255) DEFAULT NULL,
  `symptom_of_different_remedy` varchar(255) DEFAULT NULL,
  `subChapter` varchar(200) DEFAULT NULL,
  `subSubChapter` varchar(200) DEFAULT NULL,
  `chapter_information` varchar(255) DEFAULT NULL,
  `modality` varchar(255) DEFAULT NULL COMMENT 'Related to chapter information',
  `synonym_word` varchar(1200) DEFAULT NULL,
  `synonym` varchar(1200) DEFAULT NULL,
  `cross_reference` varchar(1200) DEFAULT NULL,
  `synonym_partial_2` varchar(1200) DEFAULT NULL,
  `generic_term` varchar(1200) DEFAULT NULL,
  `sub_term` varchar(1200) DEFAULT NULL,
  `synonym_nn` varchar(1200) DEFAULT NULL,
  `symptom_edit_comment` varchar(255) DEFAULT NULL,
  `individual_upgrade_justification` varchar(255) DEFAULT NULL,
  `symptom_edit_count` int(11) NOT NULL DEFAULT 0,
  `is_excluded_in_comparison` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Checking is symptom excluded in the comparison process',
  `is_final_version_available` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Connect edit, 2 = Paste edit',
  `is_symptom_number_mismatch` tinyint(1) NOT NULL DEFAULT 0,
  `is_symptom_appended` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes',
  `is_appended_symptom_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = No, 1 = Yes',
  `ip_address` varchar(15) DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created at',
  `ersteller_id` int(11) DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quelle_import_test`
--

INSERT INTO `quelle_import_test` (`id`, `original_symptom_id`, `master_id`, `arznei_id`, `quelle_id`, `original_quelle_id`, `quelle_code`, `Symptomnummer`, `SeiteOriginalVon`, `SeiteOriginalBis`, `final_version_de`, `final_version_en`, `Beschreibung_de`, `Beschreibung_en`, `BeschreibungOriginal_de`, `BeschreibungOriginal_en`, `BeschreibungFull_de`, `BeschreibungFull_en`, `BeschreibungPlain_de`, `BeschreibungPlain_en`, `searchable_text_de`, `searchable_text_en`, `bracketedString_de`, `bracketedString_en`, `part_of_symptom_string`, `timeString_de`, `timeString_en`, `Fussnote`, `PrueferID`, `EntnommenAus`, `Verweiss`, `Graduierung`, `BereichID`, `isKDCommandChapter`, `Kommentar`, `Unklarheiten`, `Remedy`, `symptom_of_different_remedy`, `subChapter`, `subSubChapter`, `chapter_information`, `modality`, `synonym_word`, `synonym`, `cross_reference`, `synonym_partial_2`, `generic_term`, `sub_term`, `synonym_nn`, `symptom_edit_comment`, `individual_upgrade_justification`, `symptom_edit_count`, `is_excluded_in_comparison`, `is_final_version_available`, `is_symptom_number_mismatch`, `is_symptom_appended`, `is_appended_symptom_active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(1, NULL, 5069, 292, 3119, 3119, '2025', NULL, NULL, NULL, NULL, NULL, NULL, 'Stitch in forehead, eyes fog.', NULL, '<non-asterisk-degree-normal>Stitch in forehead, eyes fog.</non-asterisk-degree-normal>', NULL, '<non-asterisk-degree-normal>Stitch in forehead, eyes fog.</non-asterisk-degree-normal>', NULL, 'Stitch in forehead, eyes fog.', NULL, '<non-asterisk-degree-normal>Stitch in forehead, eyes fog.</non-asterisk-degree-normal>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a:2:{s:8:\"forehead\";s:8:\"forehead\";s:3:\"fog\";s:3:\"fog\";}', 'a:2:{s:8:\"forehead\";s:4:\"brow\";s:3:\"fog\";s:10:\"mist, haze\";}', NULL, NULL, 'a:1:{s:8:\"forehead\";s:5:\"front\";}', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL),
(2, NULL, 5069, 292, 3119, 3119, '2025', NULL, NULL, NULL, NULL, NULL, NULL, 'Press in forehead and dizzy.', NULL, '<non-asterisk-degree-normal>Press in forehead and dizzy.</non-asterisk-degree-normal>', NULL, '<non-asterisk-degree-normal>Press in forehead and dizzy.</non-asterisk-degree-normal>', NULL, 'Press in forehead and dizzy.', NULL, '<non-asterisk-degree-normal>Press in forehead and dizzy.</non-asterisk-degree-normal>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a:2:{s:8:\"forehead\";s:8:\"forehead\";s:5:\"dizzy\";s:5:\"giddy\";}', 'a:2:{s:8:\"forehead\";s:4:\"brow\";s:5:\"dizzy\";s:5:\"dizzy\";}', 'a:1:{s:5:\"dizzy\";s:7:\"vertigo\";}', NULL, 'a:1:{s:8:\"forehead\";s:5:\"front\";}', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 5069, 292, 3119, 3119, '2025', NULL, NULL, NULL, NULL, NULL, NULL, 'Nostril cold and agony.', NULL, '<non-asterisk-degree-normal>Nostril cold and agony.</non-asterisk-degree-normal>', NULL, '<non-asterisk-degree-normal>Nostril cold and agony.</non-asterisk-degree-normal>', NULL, 'Nostril cold and agony.', NULL, '<non-asterisk-degree-normal>Nostril cold and agony.</non-asterisk-degree-normal>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a:2:{s:7:\"nostril\";s:15:\"ala of the nose\";s:5:\"agony\";s:4:\"pain\";}', 'a:2:{s:7:\"nostril\";s:19:\"nostril, nasal wing\";s:5:\"agony\";s:19:\"ache, aching, agony\";}', 'a:1:{s:5:\"agony\";s:10:\"hurt,prick\";}', 'a:1:{s:5:\"agony\";s:14:\"trouble, wound\";}', 'a:1:{s:5:\"agony\";s:17:\"discomfort,strain\";}', 'a:1:{s:5:\"agony\";s:20:\"soreness, irritation\";}', 'a:1:{s:5:\"agony\";s:15:\"distress,twinge\";}', NULL, NULL, 0, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quelle_pruefer`
--

CREATE TABLE `quelle_pruefer` (
  `quelle_id` int(11) UNSIGNED NOT NULL COMMENT 'source_id',
  `pruefer_id` int(11) UNSIGNED NOT NULL COMMENT 'pruefer_id',
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quelle(Source) and pruefer(tester) relationship table';

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `reference_id` int(11) UNSIGNED NOT NULL COMMENT 'reference_id',
  `full_reference` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'full literature reference text',
  `autor` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'autor name',
  `reference` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'reference name',
  `kommentar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'comment',
  `unklarheiten` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'unclear (German word is Unklarheiten)',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Literature reference';

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`reference_id`, `full_reference`, `autor`, `reference`, `kommentar`, `unklarheiten`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(66, 'Avon Szontagh, N. Z. f. H. Kl., 7, 10, proving with the tincture, 1 to 100 drops.', 'Avon Szontagh', ' N. Z. f. H. Kl., 7, 10, proving with the tincture, 1 to 100 drops.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:37:20', NULL),
(67, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:37:36', NULL),
(68, 'B. J. of Hom., 7, 391, Chapman\'s case (external application).', 'B. J. of Hom.', ' 7, 391, Chapman\'s case (external application).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:38:53', NULL),
(69, 'Jörg, Materialen, 1, provings of self and class with infusion of the flowers.', 'Jörg', ' Materialen, 1, provings of self and class with infusion of the flowers.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:39:50', NULL),
(70, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.;Fr. Hah-n.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.;Fr. Hah-n.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:40:26', NULL),
(71, 'ACS 1826, Band 5 Heft 3, S. 224-228;Stapf. (from Archiv. 5, 3).', 'ACS 1826', ' Band 5 Heft 3, S. 224-228;Stapf. (from Archiv. 5, 3).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:40:58', NULL),
(73, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Hornburg.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Hornburg.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:42:31', NULL),
(77, 'Lancet, 1864 (effects of one ounce of the tincture).', 'Lancet', ' 1864 (effects of one ounce of the tincture).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:44:47', NULL),
(79, 'Avon Szontagh, N. Z. f. H. Kl., 7, 10, proving with 15th and 3d dils..', 'Avon Szontagh', ' N. Z. f. H. Kl., 7, 10, proving with 15th and 3d dils..', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:45:41', NULL),
(80, 'Vienna Soc. of (Allop.) Physicians, B. J. of Hom., 6, 267; Proving of extract of Arnica.', 'Vienna Soc. of (Allop.) Physicians', ' B. J. of Hom., 6, 267; Proving of extract of Arnica.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:46:40', NULL),
(81, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Thomas A. Thuessink.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Thomas A. Thuessink.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:46:53', NULL),
(82, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Bæhr.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Bæhr.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:47:33', NULL),
(83, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. AuflageBand 1, S. 473ff.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. AuflageBand 1, S. 473ff.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:49:14', NULL),
(84, 'B. J. of Hom., 7, 391, Chapman\'s case (external application).', 'B. J. of Hom.', ' 7, 391, Chapman\'s case (external application).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:51:35', NULL),
(85, 'Jörg, Materialen, 1, Jörg and class, provings of the root.', 'Jörg', ' Materialen, 1, Jörg and class, provings of the root.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:52:49', NULL),
(86, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. AuflageBand 1, S. 473ff.; De la Marche (Effects in cases of injury treated by Arnica).', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. AuflageBand 1, S. 473ff.; De la Marche (Effects in cases of injury treated by Arnica).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:54:01', NULL),
(87, 'B. J. of Hom., 25, 320, Robinson\'s proving with 1/1000th.', 'B. J. of Hom.', ' 25, 320, Robinson\'s proving with 1/1000th.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:54:37', NULL),
(88, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Kummer.', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Kummer.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:54:56', NULL),
(89, 'Hahnemann S., Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Pelargus (a child to which Arnica was given for a fall from a height).', 'Hahnemann S.', ' Reine Arzneimittellehre 1830, 3. Auflage Band 1, S. 473ff.; Pelargus (a child to which Arnica was given for a fall from a height).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:56:58', NULL),
(90, 'B. J. of Hom., 25, 320, Robinson\'s proving with 1/1000th.', 'B. J. of Hom.', ' 25, 320, Robinson\'s proving with 1/1000th.', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:57:08', NULL),
(91, 'B. J. of Hom., 7, 391, Chapman\'s case (external application).', 'B. J. of Hom.', ' 7, 391, Chapman\'s case (external application).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 08:57:15', NULL),
(92, 'B. J. of Hom., 7, 391, Chapman\'s case (external application).', 'B. J. of Hom.', ' 7, 391, Chapman\'s case (external application).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 09:02:42', NULL),
(93, 'B. J. of H., 2, 275, Black (external application).', 'B. J. of H.', ' 2, 275, Black (external application).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 09:10:20', NULL),
(94, 'Œst. Med. Woch. (B. J. of H., 3, 254), (external application).', 'Œst. Med. Woch. (B. J. of H.', ' 3, 254), (external application).', NULL, NULL, 1, NULL, NULL, NULL, '2019-04-06 09:10:29', NULL),
(95, 'Collin, Obs. circa morbas, IV. S. 5 und V. S. 108', 'Collin', ' Obs. circa morbas, IV. S. 5 und V. S. 108', NULL, NULL, 1, NULL, NULL, NULL, '2019-06-07 07:30:35', NULL),
(96, 'Thomas a Thuessink, Warnemingen, Groningen 1805.', 'Thomas a Thuessink', ' Warnemingen, Groningen 1805.', NULL, NULL, 1, NULL, NULL, NULL, '2019-06-10 06:25:17', NULL),
(97, 'Brust, Rücken, Hüften', 'Brust', ' Rücken, Hüften', NULL, NULL, 1, NULL, NULL, NULL, '2019-06-10 06:33:58', NULL),
(99, 'Apis, Rhus tox.', 'Apis', ' Rhus tox.', NULL, NULL, 1, NULL, NULL, NULL, '2019-07-11 11:01:25', NULL),
(100, 'Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', 'Collin', ' obs. circa morbos, IV. S. 5. und V. S. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2019-10-24 07:46:06', NULL),
(101, 'Strecker, in Rust’s Magazin für d. ges. Heilk. Bd. XXV. Heft. 3. 1828.', 'Strecker', ' in Rust’s Magazin für d. ges. Heilk. Bd. XXV. Heft. 3. 1828.', NULL, NULL, 1, NULL, NULL, NULL, '2019-10-29 13:16:01', NULL),
(102, 'Smith, in Journ. de Chim. medic. Dec. 1827.', 'Smith', ' in Journ. de Chim. medic. Dec. 1827.', NULL, NULL, 1, NULL, NULL, NULL, '2019-10-31 14:50:04', NULL),
(103, 'Orfila u. Renauldin, in Revue medic. Tom. II.', 'Orfila u. Renauldin', ' in Revue medic. Tom. II.', NULL, NULL, 1, NULL, NULL, NULL, '2019-11-02 15:41:26', NULL),
(104, 'Hahnemann S., Chronische Krankheiten 1835, 2. Auflage, Band 2, S. 33ff.', 'Hahnemann S.', ' Chronische Krankheiten 1835, 2. Auflage, Band 2, S. 33ff.', NULL, NULL, 1, NULL, NULL, NULL, '2019-11-19 10:37:57', NULL),
(105, 'Hahnemann S., Chronische Krankheiten 1835, 2. Auflage, Band 2, S. 33ff', 'Hahnemann S.', ' Chronische Krankheiten 1835, 2. Auflage, Band 2, S. 33ff', NULL, NULL, 1, NULL, NULL, NULL, '2019-11-19 10:41:07', NULL),
(106, 'Henning, in Hufeland’s Journ. Bd. LVII. St. 3. p. 55.', 'Henning', ' in Hufeland’s Journ. Bd. LVII. St. 3. p. 55.', NULL, NULL, 1, NULL, NULL, NULL, '2019-11-21 10:09:58', NULL),
(107, 'Matthey: in Gilbert’s Annalen, Jahrg. 1821. St. VII. p. 321.', 'Matthey: in Gilbert’s Annalen', ' Jahrg. 1821. St. VII. p. 321.', NULL, NULL, 1, NULL, NULL, NULL, '2019-11-30 10:20:21', NULL),
(108, 'Archiv f. d. homöop. Heilk. V. III.', 'No Author', 'Archiv f. d. homöop. Heilk. V. III.', NULL, NULL, 1, NULL, NULL, NULL, '2020-01-27 11:00:25', NULL),
(109, 'No Author, Archiv f. d. homöop. Heilk. V. III.', 'No Author', ' Archiv f. d. homöop. Heilk. V. III.', NULL, NULL, 1, NULL, NULL, NULL, '2020-05-23 13:42:08', NULL),
(114, 'Tennert, Prax. med. lib. 6, pg. 6. C. 2', 'Tennert', ' Prax. med. lib. 6, pg. 6. C. 2', NULL, NULL, 1, NULL, NULL, NULL, '2021-04-03 09:37:26', NULL),
(115, 'A. Myrrhen, Misc. N.C. Dec. III. ann. 91, 10, Obs. 220.', 'A. Myrrhen', ' Misc. N.C. Dec. III. ann. 91, 10, Obs. 220.', NULL, NULL, 1, NULL, NULL, NULL, '2021-04-03 09:37:41', NULL),
(116, 'Alberti, Jurisprud. Medic. Tom. II. P. 527-530.', 'Alberti', ' Jurisprud. Medic. Tom. II. P. 527-530.', NULL, NULL, 1, NULL, NULL, NULL, '2021-04-03 09:37:44', NULL),
(117, 'A. Crichton, Samml. br. Abhandl. F. pr. Aerzte, XIII. 3.', 'A. Crichton', ' Samml. br. Abhandl. F. pr. Aerzte, XIII. 3.', NULL, NULL, 1, NULL, NULL, NULL, '2021-04-03 09:43:44', NULL),
(118, 'Voigtel, Arzneimittellehre', 'Voigtel', ' Arzneimittellehre', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:13:22', NULL),
(119, 'Jahn, Mat. med.', 'Jahn', ' Mat. med.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:14:16', NULL),
(120, 'Kortum, in Hufel. Journ.', 'Kortum', ' in Hufel. Journ.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:14:19', NULL),
(121, 'Weigel, Diss. inaug. d. phosph. us.', 'Weigel', ' Diss. inaug. d. phosph. us.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:15:47', NULL),
(122, 'Brera, bei Voigtel', 'Brera', ' bei Voigtel', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:16:43', NULL),
(123, 'No Author, Conradi in Hufel. Journ.', 'No Author', ' Conradi in Hufel. Journ.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:17:30', NULL),
(124, 'Lobstein, Unters. üb. d. Phosph.', 'Lobstein', ' Unters. üb. d. Phosph.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:18:07', NULL),
(125, 'Morgagni, de sed. et caus. mort.', 'Morgagni', ' de sed. et caus. mort.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:33:34', NULL),
(126, 'Ardoynus, de venen. Lib. II. C. XV.', 'Ardoynus', ' de venen. Lib. II. C. XV.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:42:42', NULL),
(127, 'Hufel. Journ.', NULL, 'Hufel. Journ.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:47:25', NULL),
(128, 'Morgagni.', NULL, 'Morgagni.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 08:53:00', NULL),
(129, 'Rücken, Brust, Handwurzel', 'Rücken', ' Brust, Handwurzel', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:17:59', NULL),
(130, 'de Meza, in Samml. br. Abh. f. pr. Aerzte XIII. - Edinb. med. Comment. Dec. II. B. II.', 'de Meza', ' in Samml. br. Abh. f. pr. Aerzte XIII. - Edinb. med. Comment. Dec. II. B. II.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:40', NULL),
(131, 'Thomas a Thuessink, Waarnehm. Groning. 1805.', 'Thomas a Thuessink', ' Waarnehm. Groning. 1805.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:42', NULL),
(132, 'de la Marche, Diss. de arnica vera. Halae, 1719. S. 15-22.', 'de la Marche', ' Diss. de arnica vera. Halae, 1719. S. 15-22.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:45', NULL),
(133, 'A. Crichton, in Samml. br. Abh. für pr. A. XIII. 3.', 'A. Crichton', ' in Samml. br. Abh. für pr. A. XIII. 3.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:47', NULL),
(134, 'Murray, Appar. Medicam. I. S. 234.', 'Murray', ' Appar. Medicam. I. S. 234.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:48', NULL),
(135, 'Stoll, Rat. Med. III. S. 162.', 'Stoll', ' Rat. Med. III. S. 162.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:49', NULL),
(136, 'Aaskow, Act. soc. med. Hafn. II. S. 162.', 'Aaskow', ' Act. soc. med. Hafn. II. S. 162.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:18:51', NULL),
(137, 'Murray, Appar. Medicam. I. S. 234., Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', 'Murray', ' Appar. Medicam. I. S. 234., Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:19:35', NULL),
(138, 'A. Crichton, in Samml. br. Abh. für pr. A. XIII. 3., Stoll, Rat. Med. III. S. 162.', 'A. Crichton', ' in Samml. br. Abh. für pr. A. XIII. 3., Stoll, Rat. Med. III. S. 162.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:19:59', NULL),
(139, 'Pelargus, Obs. I. S. 263, 264.', 'Pelargus', ' Obs. I. S. 263, 264.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:20:03', NULL),
(140, 'de Meza, in Samml. br. Abh. f. pr. Aerzte XIII.', 'de Meza', ' in Samml. br. Abh. f. pr. Aerzte XIII.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:20:05', NULL),
(141, 'Fehr, in Eph. Nat. Cur. Ann. 9, 10.', 'Fehr', ' in Eph. Nat. Cur. Ann. 9, 10.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:20:09', NULL),
(142, 'Vicat, Mat. med. I. S. 20 u. 362.', 'Vicat', ' Mat. med. I. S. 20 u. 362.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:20:10', NULL),
(143, 'de la Marche, Diss. de arnica vera. Halae, 1719. S. 15-22., Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', 'de la Marche', ' Diss. de arnica vera. Halae, 1719. S. 15-22., Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:20:27', NULL),
(144, 'Veckoskrift for Läkare, VIII.', 'Veckoskrift for Läkare', ' VIII.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:20:34', NULL),
(145, 'de la Marche, Diss. de arnica vera. Halae, 1719. S. 15-22., de Meza, in Samml. br. Abh. f. pr. Aerzte XIII., Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', 'de la Marche', ' Diss. de arnica vera. Halae, 1719. S. 15-22., de Meza, in Samml. br. Abh. f. pr. Aerzte XIII., Collin, obs. circa morbos, IV. S. 5. und V. S. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-06-07 09:21:08', NULL),
(146, 'Archiv. f. d. homoop.. Heilk., v, iii.', 'Archiv. f. d. homoop.. Heilk.', ' v, iii.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:35:04', NULL),
(147, 'THOMAS A THUESSINK, Waarnehm., Groning., 1805.', 'THOMAS A THUESSINK', ' Waarnehm., Groning., 1805.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:35:55', NULL),
(148, 'COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', 'COLLIN', ' Obs. circa Morbos, iv, p. 5, and v, p. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:35:58', NULL),
(149, 'DE LA MARCHE, Diss. de arnica vera, Halae, 1719, pp. 15-22.', 'DE LA MARCHE', ' Diss. de arnica vera, Halae, 1719, pp. 15-22.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:39:41', NULL),
(150, 'CRICHTON, A., Samml. br. Abh. f. pr. Aerzte, xiii, 3.', 'CRICHTON', ' A., Samml. br. Abh. f. pr. Aerzte, xiii, 3.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:39:48', NULL),
(151, 'Archiv. f. d. homoop. Heilk., v, iii.', 'Archiv. f. d. homoop. Heilk.', ' v, iii.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:39:50', NULL),
(152, 'MURRAY, Appar. Medicam., i, p. 234.', 'MURRAY', ' Appar. Medicam., i, p. 234.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:39:52', NULL),
(153, 'STOLL, Rat. Med., iii, p. 162.', 'STOLL', ' Rat. Med., iii, p. 162.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:39:55', NULL),
(154, 'AASKOW, Act. soc. med. Hafn. ii, p. 162.', 'AASKOW', ' Act. soc. med. Hafn. ii, p. 162.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:39:58', NULL),
(155, 'MURRAY, Appar. Medicam., i, p. 234. - COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', 'MURRAY', ' Appar. Medicam., i, p. 234. - COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:40:00', NULL),
(156, 'CRICHTON, A., Samml. br. Abh. f. pr. Aerzte, xiii, 3. - STOLL, Rat. Med., iii, p. 162.', 'CRICHTON', ' A., Samml. br. Abh. f. pr. Aerzte, xiii, 3. - STOLL, Rat. Med., iii, p. 162.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:40:08', NULL),
(157, 'PELARGUS, Obs., i, pp. 263, 264.', 'PELARGUS', ' Obs., i, pp. 263, 264.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:40:16', NULL),
(158, 'DE MEZA, in Samml. br. Abh. f. pr. Aerzte, xiii.', 'DE MEZA', ' in Samml. br. Abh. f. pr. Aerzte, xiii.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:40:30', NULL),
(159, 'FEHR, in Eph. Nat. Cur., Dec. I, Ann. 9, 10, O. 2.', 'FEHR', ' in Eph. Nat. Cur., Dec. I, Ann. 9, 10, O. 2.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:40:42', NULL),
(160, 'VICAT, Mat. Med., i, pp. 20 and 362.', 'VICAT', ' Mat. Med., i, pp. 20 and 362.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:41:05', NULL),
(161, 'DE LA MARCHE, Diss. de arnica vera, Halae, 1719, pp. 15-22. - COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', 'DE LA MARCHE', ' Diss. de arnica vera, Halae, 1719, pp. 15-22. - COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:56:20', NULL),
(162, 'Veckoskrift for. Läkare,2 viii.', 'Veckoskrift for. Läkare', '2 viii.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:57:15', NULL),
(163, 'DE LA MARCHE, Diss. de arnica vera, Halae, 1719, pp. 15-22. - DE MEZA, in Samml. br. Abh. f. pr. Aerzte, xiii. - COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', 'DE LA MARCHE', ' Diss. de arnica vera, Halae, 1719, pp. 15-22. - DE MEZA, in Samml. br. Abh. f. pr. Aerzte, xiii. - COLLIN, Obs. circa Morbos, iv, p. 5, and v, p. 108.', NULL, NULL, 1, NULL, NULL, NULL, '2021-11-08 09:57:43', NULL),
(188, 'N-g, in: Chr. Krank., 1, 33;', 'N-g', ' in: Chr. Krank., 1, 33;', NULL, NULL, 1, NULL, NULL, NULL, '2022-09-19 08:59:56', NULL),
(189, 'See Anxiety, Sadness', 'See Anxiety', ' Sadness', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:48:34', NULL),
(190, 'See Obstinate, Irritable', 'See Obstinate', ' Irritable', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:48:50', NULL),
(191, 'See Images, spectres', 'See Images', ' spectres', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:48:56', NULL),
(192, 'See Desires, Death', 'See Desires', ' Death', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:49:31', NULL),
(193, 'See Delirium, Insanity, Rage, etc.', 'See Delirium', ' Insanity, Rage, etc.', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:49:34', NULL),
(194, 'See Anxiety, Despair, Fear', 'See Anxiety', ' Despair, Fear', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:49:54', NULL),
(195, 'See Anxiety, Remorse', 'See Anxiety', ' Remorse', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:50:34', NULL),
(196, 'See Fullness, Pulsation', 'See Fullness', ' Pulsation', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:51:04', NULL),
(197, 'See Fullness, Pulsation', 'See Fullness', ' Pulsation', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:51:04', NULL),
(198, 'See Knocking, Looseness, Shaking, Waving, etc.', 'See Knocking', ' Looseness, Shaking, Waving, etc.', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:51:33', NULL),
(199, 'See Motion, Stepping', 'See Motion', ' Stepping', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:53:49', NULL),
(200, 'See Bursting, Drawing', 'See Bursting', ' Drawing', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:54:51', NULL),
(201, 'See Cutting, Lancinating, Shocks, Stitches, etc.', 'See Cutting', ' Lancinating, Shocks, Stitches, etc.', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:55:13', NULL),
(202, 'See Cutting, Lancinating, Shocks, Stitches, etc.', 'See Cutting', ' Lancinating, Shocks, Stitches, etc.', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:55:13', NULL),
(203, 'See Sore, Tearing etc.', 'See Sore', ' Tearing etc.', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:55:23', NULL),
(204, 'See Bursting, Congestion, Hammering', 'See Bursting', ' Congestion, Hammering', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:55:28', NULL),
(205, 'See Jerking Pain, Pulsation, Plug, Nail', 'See Jerking Pain', ' Pulsation, Plug, Nail', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:55:32', NULL),
(206, 'See Sparks, Flashes', 'See Sparks', ' Flashes', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:56:15', NULL),
(207, 'See Eyes, weak', 'See Eyes', ' weak', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:56:23', NULL),
(208, 'See Eyes, weak', 'See Eyes', ' weak', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:56:24', NULL),
(209, 'See Fistula, Boils, Ulcers, Pustules, Suppuration', 'See Fistula', ' Boils, Ulcers, Pustules, Suppuration', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 07:57:39', NULL),
(210, 'See Boring, Drawing, Distress, Digging, Gnawing, Pressing, etc.', 'See Boring', ' Drawing, Distress, Digging, Gnawing, Pressing, etc.', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 08:00:05', NULL),
(211, 'See Urination, Frequent', 'See Urination', ' Frequent', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 08:01:36', NULL),
(212, 'See Chordee, Urethra', 'See Chordee', ' Urethra', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 08:02:14', NULL),
(213, 'See Labor-like Pains, also Pains in Abdomen', 'See Labor-like Pains', ' also Pains in Abdomen', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 08:02:53', NULL),
(214, 'See Generalities, Cold', 'See Generalities', ' Cold', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 08:11:11', NULL),
(215, 'See Lassitude, Weariness', 'See Lassitude', ' Weariness', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-17 08:13:37', NULL),
(216, 'N-g, in: Chr. Krank., 1, 33', 'N-g', ' in: Chr. Krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2023-02-22 08:33:29', NULL),
(218, 'Ernst Stapf, in einem Briefe', 'Ernst Stapf', ' in einem Briefe', NULL, NULL, 1, NULL, NULL, NULL, '2023-05-22 11:48:43', NULL),
(221, 'Fr. Hartmann, in einem Aufsatze', 'Fr. Hartmann', ' in einem Aufsatze', NULL, NULL, 1, NULL, NULL, NULL, '2023-05-22 11:48:57', NULL),
(223, 'El. Camerarius, hort. med.', 'El. Camerarius', ' hort. med.', NULL, NULL, 1, NULL, NULL, NULL, '2023-05-22 11:49:06', NULL),
(226, 'Lev. Lemnius, de occultis Naturae miraculis II. Cap. 1.', 'Lev. Lemnius', ' de occultis Naturae miraculis II. Cap. 1.', NULL, NULL, 1, NULL, NULL, NULL, '2023-05-22 11:49:22', NULL),
(227, 'Morgagni, de sedib. et caus. morb. LV. 9.', 'Morgagni', ' de sedib. et caus. morb. LV. 9.', NULL, NULL, 1, NULL, NULL, NULL, '2023-09-15 14:08:13', NULL),
(243, 'Hanuman, in Chr. Kn., S. Hahnemann, 1839.', 'Hanuman', ' in Chr. Kn., S. Hahnemann, 1839.', NULL, NULL, 1, NULL, NULL, NULL, '2024-01-09 11:15:21', NULL),
(244, 'Fr. Hanuman, in Chr. Kn., S. Hahnemann, 1839.', 'Fr. Hanuman', ' in Chr. Kn., S. Hahnemann, 1839.', NULL, NULL, 1, NULL, NULL, NULL, '2024-01-09 11:15:21', NULL),
(245, 'Hahnetesting, in Chr. Kn., S. Hahnemann, 1839.', 'Hahnetesting', ' in Chr. Kn., S. Hahnemann, 1839.', NULL, NULL, 1, NULL, NULL, NULL, '2024-01-09 12:08:36', NULL),
(276, 'Hahnemann, R. A. M. L., 2, 273', 'Hahnemann', ' R. A. M. L., 2, 273', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(277, 'Bergius, Mat. Med., p. 519 (general statement, -Hughes), from Anemone sylvestris, L.', 'Bergius', ' Mat. Med., p. 519 (general statement, -Hughes), from Anemone sylvestris, L.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(278, 'Hellwing, Flora campana, Lips, 1719, p. 86, see note by Hahnemann to symptom 776', 'Hellwing', ' Flora campana, Lips, 1719, p. 86, see note by Hahnemann to symptom 776', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(279, 'Heyer, in Crell\'s Journ., 2, p. 205 (not found, -Hughes)', 'Heyer', ' in Crell\'s Journ., 2, p. 205 (not found, -Hughes)', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(280, 'Saur, in Bergius Mat. Med., p. 517 (effects of emanations of evaporating juice, -Hughes)', 'Saur', ' in Bergius Mat. Med., p. 517 (effects of emanations of evaporating juice, -Hughes)', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(281, 'Aut. v. Störck, von der Pulsatille, Frst., 1771), (observations, chiefly on patients, -Hughes)', 'Aut. v. Störck', ' von der Pulsatille, Frst., 1771), (observations, chiefly on patients, -Hughes)', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(282, 'Lembke, N. Z. f. Hom., Klinik, 8, 145, took tincture 2 drops, first day; 5 drops, fifth day; 20 drops, ninth day; 30, twelfth day; 40 fourteenth and nineteenth days; 50, twenty-second and twenty-ninth days; 60 drops, thirty-fourth day', 'Lembke', ' N. Z. f. Hom., Klinik, 8, 145, took tincture 2 drops, first day; 5 drops, fifth day; 20 drops, ninth day; 30, twelfth day; 40 fourteenth and nineteenth days; 50, twenty-second and twenty-ninth days; 60 drops, thirty-fourth day', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(283, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a young woman took a pill of the 30th every second morning', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a young woman took a pill of the 30th every second morning', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(284, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a young woman took the 200th in water every third morning', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a young woman took the 200th in water every third morning', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(285, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a woman took 30th in water every night', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a woman took 30th in water every night', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(286, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a man took 200th in water night and morning', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a man took 200th in water night and morning', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(287, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a young woman took 200th in water, one dose', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a young woman took 200th in water, one dose', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(288, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a young woman took one dose of 200th', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a young woman took one dose of 200th', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(289, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a young woman took 30th in water every third morning', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a young woman took 30th in water every third morning', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(290, 'Dr. Robinson, Br. J. of Hom., 25, p. 328, a young woman took every second morning, in order, the 1000th, 200th, 30th, and 12th', 'Dr. Robinson', ' Br. J. of Hom., 25, p. 328, a young woman took every second morning, in order, the 1000th, 200th, 30th, and 12th', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(291, 'Berridge, Am. J. Hom., Mat. Med., 8, 128, a man took a dose of the \"16m.,\" Fincke', 'Berridge', ' Am. J. Hom., Mat. Med., 8, 128, a man took a dose of the \"16m.,\" Fincke', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(292, 'Davis, J. E. L, MS. proving, constant effect of the 3d dil.', 'Davis', ' J. E. L, MS. proving, constant effect of the 3d dil.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(293, 'Wenzel, Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, doses of 10 drops of tincture three times a day, for several days', 'Wenzel', ' Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, doses of 10 drops of tincture three times a day, for several days', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(294, 'Wenzel, Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, increased doses', 'Wenzel', ' Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, increased doses', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(295, 'Wenzel, Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, 20-drop doses, thrice daily, for a month', 'Wenzel', ' Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, 20-drop doses, thrice daily, for a month', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(296, 'Wenzel, Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, a 40-drop doses', 'Wenzel', ' Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, a 40-drop doses', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(297, 'Wenzel, Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, a 40-drop doses continued a week.', 'Wenzel', ' Trans. of the Alumni Ass. of the Hasp. Coll. of Med., Louisville Med. News, 3, 114, 1877, a 40-drop doses continued a week.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-20 09:05:56', NULL),
(298, 'Hahnemann, R. A. M. L., 4.', 'Hahnemann', ' R. A. M. L., 4.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(301, 'Hartmann in: Hahnemann, R. A. M. L., 4.', 'Hartmann in: Hahnemann', ' R. A. M. L., 4.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(305, 'Stapf in: Hahnemann, R. A. M. L., 4.', 'Stapf in: Hahnemann', ' R. A. M. L., 4.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(307, 'Lev. Leminus, de occultis Nat. Miraculis, II, cap. I.', 'Lev. Leminus', ' de occultis Nat. Miraculis, II, cap. I.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(308, 'Hartlaub and Trinks, R. A. M. L., 1, 139.', 'Hartlaub and Trinks', ' R. A. M. L., 1, 139.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(309, 'Hering, Archiv f. Hom., 15, 1, 187.', 'Hering', ' Archiv f. Hom., 15, 1, 187.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(310, 'Roth, in Buchner\'s Toxicology, p. 265, effects of plucking the leaves from a plant in flower, on a hot day.', 'Roth', ' in Buchner\'s Toxicology, p. 265, effects of plucking the leaves from a plant in flower, on a hot day.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(311, 'Bulliard, Plant. vén. de la France (from Wibmer), effects of large doses.', 'Bulliard', ' Plant. vén. de la France (from Wibmer), effects of large doses.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(312, 'Plinius, Hist. Nat., 1, 20, c. 13 (from Wibmer), effects of handling Rue, in a gardener.', 'Plinius', ' Hist. Nat., 1, 20, c. 13 (from Wibmer), effects of handling Rue, in a gardener.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(313, 'Helie, Annals de Hyg., pub. 1841 (from Archiv f. Hom., 19, 171), a woman, four months pregnant, took an infusion of three fresh roots.', 'Helie', ' Annals de Hyg., pub. 1841 (from Archiv f. Hom., 19, 171), a woman, four months pregnant, took an infusion of three fresh roots.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(314, 'Helie, Annals de Hyg., pub. 1841 (from Archiv f. Hom., 19, 171), another pregnant woman took an infusion.', 'Helie', ' Annals de Hyg., pub. 1841 (from Archiv f. Hom., 19, 171), another pregnant woman took an infusion.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(315, 'Helie, Annals de Hyg., pub. 1841 (from Archiv f. Hom., 19, 171), a pregnant woman took a large quantity of the freshly expressed juice.', 'Helie', ' Annals de Hyg., pub. 1841 (from Archiv f. Hom., 19, 171), a pregnant woman took a large quantity of the freshly expressed juice.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(316, 'Soubeiran, Gaz. Hebdom., 1861, L\'Art Méd., 14, 466, effects of handling the leaves.', 'Soubeiran', ' Gaz. Hebdom., 1861, L\'Art Méd., 14, 466, effects of handling the leaves.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(317, 'Schelling, A. H. Z., 84, 44, proving with 7th dil., two doses, first day.', 'Schelling', ' A. H. Z., 84, 44, proving with 7th dil., two doses, first day.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(318, 'Schelling, A. H. Z., 84, 44, took 4th dil. five times a day.', 'Schelling', ' A. H. Z., 84, 44, took 4th dil. five times a day.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(319, 'Dr. Van der Warker, \"The Detection of Criminal Abortion,\", p. 6, proving with 10-minim doses of the oil, at 9.05, 9.30, and 9.35 P.M., one evening.', 'Dr. Van der Warker', ' \"The Detection of Criminal Abortion,\", p. 6, proving with 10-minim doses of the oil, at 9.05, 9.30, and 9.35 P.M., one evening.', NULL, NULL, 1, NULL, NULL, NULL, '2024-02-28 07:46:26', NULL),
(320, 'Kopf, Augen, Ohren, Nase, Schlund, Magen, Bauch, Blase, Rücken, Extremitäten', 'Kopf', ' Augen, Ohren, Nase, Schlund, Magen, Bauch, Blase, Rücken, Extremitäten', NULL, NULL, 1, NULL, NULL, NULL, '2024-03-16 07:43:35', NULL),
(321, 'Nachmittags, ½ Stunde lang', 'Nachmittags', ' ½ Stunde lang', NULL, NULL, 1, NULL, NULL, NULL, '2024-03-21 13:25:50', NULL),
(322, 'Hartlaub und Trinks, Reine Arzneimittell. 1. Bd. pag. 321', 'Hartlaub und Trinks', ' Reine Arzneimittell. 1. Bd. pag. 321', NULL, NULL, 1, NULL, NULL, NULL, '2024-03-21 21:06:22', NULL),
(323, 'Helie, Annal. d’hygi_ne publ. et de med. legale (Hufel. Journ. 1841, Juni, Hyg. XI. p. 525.)', 'Helie', ' Annal. d’hygi_ne publ. et de med. legale (Hufel. Journ. 1841, Juni, Hyg. XI. p. 525.)', NULL, NULL, 1, NULL, NULL, NULL, '2024-03-21 21:06:46', NULL),
(324, 'Roth, Buchner Toxicolog. p. 265', 'Roth', ' Buchner Toxicolog. p. 265', NULL, NULL, 1, NULL, NULL, NULL, '2024-03-21 21:07:08', NULL),
(325, 'Archiv f. d. Homöopath. Heilkunst, V. III.', 'Archiv f. d. Homöopath. Heilkunst', ' V. III.', NULL, NULL, 1, NULL, NULL, NULL, '2024-03-22 09:23:35', NULL),
(326, 'hahnemann, chr. krank., 1, 33', 'hahnemann', ' chr. krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(327, 'hartlaub, in: chr. krank., 1, 33', 'hartlaub', ' in: chr. krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(328, 'nenning, in: chr. krank., 1, 33', 'nenning', ' in: chr. krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(329, 'schreter, in: chr. krank., 1, 33', 'schreter', ' in: chr. krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(330, 'trinks, in: chr. krank., 1, 33', 'trinks', ' in: chr. krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(331, 'bute, in: chr. krank., 1, 33', 'bute', ' in: chr. krank., 1, 33', NULL, NULL, 1, NULL, NULL, NULL, '2024-04-18 11:47:37', NULL),
(332, 'Chr. Fr. Langhammer, in einem Aufsatze', 'Chr. Fr. Langhammer', ' in einem Aufsatze', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 07:46:26', NULL),
(333, 'W.E. Wislicenus, in einem Aufsatze', 'W.E. Wislicenus', ' in einem Aufsatze', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 07:46:29', NULL),
(334, 'Chr. G. Hornburg, in einem Aufsatze', 'Chr. G. Hornburg', ' in einem Aufsatze', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 07:46:33', NULL),
(335, 'Carl Franz, in einem Aufsatze', 'Carl Franz', ' in einem Aufsatze', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 07:46:37', NULL),
(336, 'Gross, a.a.O.', 'Gross', ' a.a.O.', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 09:51:24', NULL),
(337, 'Gross, a.a.O.', 'Gross', ' a.a.O.', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 09:51:28', NULL),
(338, 'Gross, a.a.O.', 'Gross', ' a.a.O.', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-19 12:42:51', NULL),
(339, 'Aug. Fr. Walther, a.a.O.', 'Aug. Fr. Walther', ' a.a.O.', NULL, NULL, 1, NULL, NULL, NULL, '2024-11-26 09:43:00', NULL),
(340, 'No Author, Hufel. Journal d. pr. A. III. S. 773.', 'No Author', ' Hufel. Journal d. pr. A. III. S. 773.', NULL, NULL, 1, NULL, NULL, NULL, '2024-12-23 09:33:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `remedy`
--

CREATE TABLE `remedy` (
  `remedy_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remedy`
--

INSERT INTO `remedy` (`remedy_id`, `name`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(1, 'Tub.', 1, NULL, NULL, NULL, '2019-03-15 10:19:58', NULL),
(2, 'Puls.', 1, NULL, NULL, NULL, '2019-03-15 10:20:56', NULL),
(3, 'Spig.', 1, NULL, NULL, NULL, '2019-03-15 10:21:20', NULL),
(4, 'Phos', 1, NULL, NULL, NULL, '2019-03-15 10:26:47', NULL),
(5, 'Ars', 1, NULL, NULL, NULL, '2019-03-15 11:01:40', NULL),
(6, 'Caust.', 1, NULL, NULL, NULL, '2019-03-15 11:01:50', NULL),
(7, 'Cupr.', 1, NULL, NULL, NULL, '2019-03-15 11:01:50', NULL),
(8, 'Nux v', 1, NULL, NULL, NULL, '2019-03-15 11:02:51', NULL),
(11, 'Anac.', 1, NULL, NULL, NULL, '2019-03-15 11:25:44', NULL),
(12, 'Lach.', 1, NULL, NULL, NULL, '2019-03-15 11:25:44', NULL),
(13, 'Nux m.', 1, NULL, NULL, NULL, '2019-03-15 11:25:53', NULL),
(14, 'Nit. ac.', 1, NULL, NULL, NULL, '2019-03-15 11:26:01', NULL),
(15, 'Opi.', 1, NULL, NULL, NULL, '2019-03-15 11:26:05', NULL),
(16, 'Sulph.', 1, NULL, NULL, NULL, '2019-03-15 11:26:09', NULL),
(17, 'Bap.', 1, NULL, NULL, NULL, '2019-03-15 11:26:13', NULL),
(18, 'Ant-c.', 1, NULL, NULL, NULL, '2019-03-15 11:26:16', NULL),
(19, 'Brom.', 1, NULL, NULL, NULL, '2019-03-15 11:26:31', NULL),
(20, 'Baryt. carb.', 1, NULL, NULL, NULL, '2019-03-15 11:27:04', NULL),
(21, 'Phos. ac.', 1, NULL, NULL, NULL, '2019-03-15 11:27:08', NULL),
(22, 'Aur.', 1, NULL, NULL, NULL, '2019-03-15 11:27:31', NULL),
(23, 'Hep. s.', 1, NULL, NULL, NULL, '2019-03-15 11:27:31', NULL),
(24, 'Iodi.', 1, NULL, NULL, NULL, '2019-03-15 11:27:31', NULL),
(25, 'Kreos.', 1, NULL, NULL, NULL, '2019-03-15 11:27:31', NULL),
(26, 'Merc.', 1, NULL, NULL, NULL, '2019-03-15 11:27:31', NULL),
(27, 'Nitr. ac.', 1, NULL, NULL, NULL, '2019-03-15 11:27:31', NULL),
(28, 'Bell.', 1, NULL, NULL, NULL, '2019-03-18 08:14:29', NULL),
(29, 'Plat.', 1, NULL, NULL, NULL, '2019-03-22 14:17:04', NULL),
(30, 'Baryt. c.', 1, NULL, NULL, NULL, '2019-03-22 14:28:02', NULL),
(31, 'Ambr.', 1, NULL, NULL, NULL, '2019-03-22 20:46:36', NULL),
(32, 'Bar. c.', 1, NULL, NULL, NULL, '2019-03-22 20:48:13', NULL),
(33, 'Rhus.', 1, NULL, NULL, NULL, '2019-03-22 20:48:26', NULL),
(34, 'Agn.', 1, NULL, NULL, NULL, '2019-03-22 20:51:20', NULL),
(35, 'Bar-c.', 1, NULL, NULL, NULL, '2019-03-22 20:51:20', NULL),
(36, 'Calc.', 1, NULL, NULL, NULL, '2019-03-22 20:51:20', NULL),
(37, 'clotted.', 1, NULL, NULL, NULL, '2019-04-04 12:52:57', NULL),
(38, 'Croc.', 1, NULL, NULL, NULL, '2019-06-03 10:20:07', NULL),
(39, 'Ant. crud.', 1, NULL, NULL, NULL, '2019-06-03 10:20:14', NULL),
(40, 'Sil.', 1, NULL, NULL, NULL, '2019-06-03 10:20:14', NULL),
(41, 'Acon.', 1, NULL, NULL, NULL, '2019-06-03 10:20:25', NULL),
(42, 'Lyc.', 1, NULL, NULL, NULL, '2019-06-03 10:20:25', NULL),
(43, 'Graph.', 1, NULL, NULL, NULL, '2019-06-03 10:20:30', NULL),
(44, 'Cham.', 1, NULL, NULL, NULL, '2019-06-03 10:20:33', NULL),
(45, 'Bry.', 1, NULL, NULL, NULL, '2019-06-03 10:20:38', NULL),
(46, 'Calc. c.', 1, NULL, NULL, NULL, '2019-06-03 10:20:50', NULL),
(47, 'Chin. sulph.', 1, NULL, NULL, NULL, '2019-06-03 10:20:50', NULL),
(48, 'Agar.', 1, NULL, NULL, NULL, '2019-06-03 10:29:21', NULL),
(49, 'Jabor.', 1, NULL, NULL, NULL, '2019-06-03 10:29:21', NULL),
(50, 'Con.', 1, NULL, NULL, NULL, '2019-06-03 10:29:21', NULL),
(51, 'Ruta', 1, NULL, NULL, NULL, '2019-06-03 10:29:21', NULL),
(52, 'Nat-m.', 1, NULL, NULL, NULL, '2019-06-03 10:29:21', NULL),
(53, 'Lefevre', 1, NULL, NULL, NULL, '2019-07-08 08:20:42', NULL),
(54, 'Can.', 1, NULL, NULL, NULL, '2019-07-08 08:25:32', NULL),
(55, 'Ind.', 1, NULL, NULL, NULL, '2019-07-08 08:25:32', NULL),
(56, 'Bapt.', 1, NULL, NULL, NULL, '2019-07-11 11:00:03', NULL),
(57, 'Hyos.', 1, NULL, NULL, NULL, '2019-07-11 11:00:03', NULL),
(58, 'Alum.', 1, NULL, NULL, NULL, '2019-07-11 11:00:57', NULL),
(59, 'Coni.', 1, NULL, NULL, NULL, '2019-07-11 11:00:57', NULL),
(60, 'Coff.', 1, NULL, NULL, NULL, '2019-07-11 11:00:59', NULL),
(61, 'Ign.', 1, NULL, NULL, NULL, '2019-07-11 11:00:59', NULL),
(62, 'Ptel.', 1, NULL, NULL, NULL, '2019-07-11 11:01:02', NULL),
(63, 'Ant. tart.', 1, NULL, NULL, NULL, '2019-07-11 11:01:04', NULL),
(64, 'Psor.', 1, NULL, NULL, NULL, '2019-07-11 11:01:04', NULL),
(65, 'Sep.', 1, NULL, NULL, NULL, '2019-07-11 11:01:04', NULL),
(66, 'Valer.', 1, NULL, NULL, NULL, '2019-07-11 11:01:04', NULL),
(67, 'Cinch.', 1, NULL, NULL, NULL, '2019-07-11 11:01:10', NULL),
(68, 'Kali carb.', 1, NULL, NULL, NULL, '2019-07-11 11:01:13', NULL),
(69, 'Cact.', 1, NULL, NULL, NULL, '2019-07-11 11:01:15', NULL),
(70, 'Lil.', 1, NULL, NULL, NULL, '2019-07-11 11:01:15', NULL),
(71, 'Apoc.', 1, NULL, NULL, NULL, '2019-07-11 11:01:17', NULL),
(72, 'Dig.', 1, NULL, NULL, NULL, '2019-07-11 11:01:17', NULL),
(73, 'Dulc.', 1, NULL, NULL, NULL, '2019-07-11 11:01:19', NULL),
(74, 'Berb.', 1, NULL, NULL, NULL, '2019-07-11 11:01:22', NULL),
(75, 'Rhus tox.', 1, NULL, NULL, NULL, '2019-07-11 11:01:22', NULL),
(76, 'Cimic.', 1, NULL, NULL, NULL, '2019-07-11 11:01:23', NULL),
(77, 'Apis', 1, NULL, NULL, NULL, '2019-07-11 11:01:28', NULL),
(78, 'Led.', 1, NULL, NULL, NULL, '2019-07-11 11:01:28', NULL),
(79, 'Op.', 1, NULL, NULL, NULL, '2019-07-11 11:01:29', NULL),
(80, 'Laur.', 1, NULL, NULL, NULL, '2019-07-11 11:01:29', NULL),
(84, 'Kali. c.', 1, NULL, NULL, NULL, '2019-11-19 10:34:01', NULL),
(87, 'Augenbutter', 1, NULL, NULL, NULL, '2021-03-25 11:06:28', NULL),
(88, 'Tr.', 1, NULL, NULL, NULL, '2021-03-25 11:46:25', NULL),
(89, 'Hb.', 1, NULL, NULL, NULL, '2021-03-25 11:46:57', NULL),
(92, 'Ant-t.', 1, NULL, NULL, NULL, '2021-04-03 09:31:53', NULL),
(93, 'Ng.', 1, NULL, NULL, NULL, '2021-06-07 07:25:57', NULL),
(94, 'S.', 1, NULL, NULL, NULL, '2021-06-07 07:26:08', NULL),
(95, 'Gr.', 1, NULL, NULL, NULL, '2021-06-07 08:16:05', NULL),
(96, 'Gll.', 1, NULL, NULL, NULL, '2021-06-07 08:16:11', NULL),
(97, 'Hg.', 1, NULL, NULL, NULL, '2021-06-07 08:16:15', NULL),
(98, 'Kortum', 1, NULL, NULL, NULL, '2021-06-07 08:16:49', NULL),
(99, 'Vormittags', 1, NULL, NULL, NULL, '2021-06-07 08:45:59', NULL),
(100, 'Bor.', 1, NULL, NULL, NULL, '2022-03-08 08:37:04', NULL),
(101, 'Au.', 1, NULL, NULL, NULL, '2022-12-15 10:18:34', NULL),
(102, 'Hug.', 1, NULL, NULL, NULL, '2022-12-15 10:18:34', NULL),
(103, 'etc.', 1, NULL, NULL, NULL, '2023-02-17 08:00:36', NULL),
(104, 'Remedy', 1, NULL, NULL, NULL, '2023-07-07 10:06:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stop_words`
--

CREATE TABLE `stop_words` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `language` varchar(50) NOT NULL DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stop_words`
--

INSERT INTO `stop_words` (`id`, `name`, `active`, `language`) VALUES
(1, 'a', 1, 'english'),
(2, 'about', 1, 'english'),
(3, 'above', 1, 'english'),
(4, 'across', 1, 'english'),
(5, 'after', 1, 'english'),
(6, 'afterwards', 1, 'english'),
(7, 'again', 1, 'english'),
(8, 'against', 1, 'english'),
(9, 'all', 1, 'english'),
(10, 'almost', 1, 'english'),
(11, 'alone', 1, 'english'),
(12, 'along', 1, 'english'),
(13, 'already', 1, 'english'),
(14, 'also', 1, 'english'),
(15, 'although', 1, 'english'),
(16, 'always', 1, 'english'),
(17, 'am', 1, 'english'),
(18, 'among', 1, 'english'),
(19, 'amongst', 1, 'english'),
(20, 'amoungst', 1, 'english'),
(21, 'amount', 1, 'english'),
(22, 'an', 1, 'english'),
(23, 'and', 1, 'english'),
(24, 'another', 1, 'english'),
(25, 'any', 1, 'english'),
(26, 'anyhow', 1, 'english'),
(27, 'anyone', 1, 'english'),
(28, 'anything', 1, 'english'),
(29, 'anyway', 1, 'english'),
(30, 'anywhere', 1, 'english'),
(31, 'are', 1, 'english'),
(32, 'around', 1, 'english'),
(33, 'as', 1, 'english'),
(34, 'at', 1, 'english'),
(35, 'back', 1, 'english'),
(36, 'be', 1, 'english'),
(37, 'became', 1, 'english'),
(38, 'because', 1, 'english'),
(39, 'become', 1, 'english'),
(40, 'becomes', 1, 'english'),
(41, 'becoming', 1, 'english'),
(42, 'been', 1, 'english'),
(43, 'before', 1, 'english'),
(44, 'beforehand', 1, 'english'),
(45, 'behind', 1, 'english'),
(46, 'being', 1, 'english'),
(47, 'below', 1, 'english'),
(48, 'beside', 1, 'english'),
(49, 'besides', 1, 'english'),
(50, 'between', 1, 'english'),
(51, 'beyond', 1, 'english'),
(52, 'bill', 1, 'english'),
(53, 'both', 1, 'english'),
(54, 'bottom', 1, 'english'),
(55, 'but', 1, 'english'),
(56, 'by', 1, 'english'),
(57, 'call', 1, 'english'),
(58, 'can', 1, 'english'),
(59, 'cannot', 1, 'english'),
(60, 'cant', 1, 'english'),
(61, 'co', 1, 'english'),
(62, 'computer', 1, 'english'),
(63, 'con', 1, 'english'),
(64, 'could', 1, 'english'),
(65, 'couldnt', 1, 'english'),
(66, 'cry', 1, 'english'),
(67, 'de', 1, 'english'),
(68, 'describe', 1, 'english'),
(69, 'detail', 1, 'english'),
(70, 'do', 1, 'english'),
(71, 'done', 1, 'english'),
(72, 'down', 1, 'english'),
(73, 'due', 1, 'english'),
(74, 'during', 0, 'english'),
(75, 'each', 1, 'english'),
(76, 'eg', 1, 'english'),
(77, 'eight', 1, 'english'),
(78, 'either', 1, 'english'),
(79, 'eleven', 1, 'english'),
(80, 'else', 1, 'english'),
(81, 'elsewhere', 1, 'english'),
(82, 'empty', 0, 'english'),
(83, 'enough', 1, 'english'),
(84, 'etc', 1, 'english'),
(85, 'even', 1, 'english'),
(86, 'ever', 1, 'english'),
(87, 'every', 1, 'english'),
(88, 'everyone', 1, 'english'),
(89, 'everything', 1, 'english'),
(90, 'everywhere', 1, 'english'),
(91, 'except', 1, 'english'),
(92, 'few', 1, 'english'),
(93, 'fifteen', 1, 'english'),
(94, 'fify', 1, 'english'),
(95, 'fill', 1, 'english'),
(96, 'find', 1, 'english'),
(97, 'fire', 1, 'english'),
(98, 'first', 1, 'english'),
(99, 'five', 1, 'english'),
(100, 'for', 0, 'english'),
(101, 'former', 1, 'english'),
(102, 'formerly', 1, 'english'),
(103, 'forty', 1, 'english'),
(104, 'found', 1, 'english'),
(105, 'four', 1, 'english'),
(106, 'from', 1, 'english'),
(107, 'front', 1, 'english'),
(108, 'full', 1, 'english'),
(109, 'further', 1, 'english'),
(110, 'get', 1, 'english'),
(111, 'give', 1, 'english'),
(112, 'go', 1, 'english'),
(113, 'had', 1, 'english'),
(114, 'has', 1, 'english'),
(115, 'hasnt', 1, 'english'),
(116, 'have', 1, 'english'),
(117, 'he', 1, 'english'),
(118, 'hence', 1, 'english'),
(119, 'her', 1, 'english'),
(120, 'here', 1, 'english'),
(121, 'hereafter', 1, 'english'),
(122, 'hereby', 1, 'english'),
(123, 'herein', 1, 'english'),
(124, 'hereupon', 1, 'english'),
(125, 'hers', 1, 'english'),
(126, 'herself', 1, 'english'),
(127, 'him', 1, 'english'),
(128, 'himself', 1, 'english'),
(129, 'his', 1, 'english'),
(130, 'how', 1, 'english'),
(131, 'however', 1, 'english'),
(132, 'hundred', 1, 'english'),
(133, 'ie', 1, 'english'),
(134, 'if', 1, 'english'),
(135, 'in', 1, 'english'),
(136, 'inc', 1, 'english'),
(137, 'indeed', 1, 'english'),
(138, 'interest', 1, 'english'),
(139, 'into', 1, 'english'),
(140, 'is', 1, 'english'),
(141, 'it', 1, 'english'),
(142, 'its', 1, 'english'),
(143, 'itself', 1, 'english'),
(144, 'keep', 1, 'english'),
(145, 'last', 1, 'english'),
(146, 'latter', 1, 'english'),
(147, 'latterly', 1, 'english'),
(148, 'least', 1, 'english'),
(149, 'less', 1, 'english'),
(150, 'ltd', 1, 'english'),
(151, 'made', 1, 'english'),
(152, 'many', 1, 'english'),
(153, 'may', 1, 'english'),
(154, 'me', 1, 'english'),
(155, 'meanwhile', 1, 'english'),
(156, 'might', 1, 'english'),
(157, 'mill', 1, 'english'),
(158, 'mine', 1, 'english'),
(159, 'more', 1, 'english'),
(160, 'moreover', 1, 'english'),
(161, 'most', 1, 'english'),
(162, 'mostly', 1, 'english'),
(163, 'move', 1, 'english'),
(164, 'much', 1, 'english'),
(165, 'must', 1, 'english'),
(166, 'my', 1, 'english'),
(167, 'myself', 1, 'english'),
(168, 'name', 1, 'english'),
(169, 'namely', 1, 'english'),
(170, 'neither', 1, 'english'),
(171, 'never', 1, 'english'),
(172, 'nevertheless', 1, 'english'),
(173, 'next', 1, 'english'),
(174, 'nine', 1, 'english'),
(175, 'no', 1, 'english'),
(176, 'nobody', 1, 'english'),
(177, 'none', 1, 'english'),
(178, 'noone', 1, 'english'),
(179, 'nor', 1, 'english'),
(180, 'not', 1, 'english'),
(181, 'nothing', 0, 'english'),
(182, 'now', 1, 'english'),
(183, 'nowhere', 1, 'english'),
(184, 'of', 1, 'english'),
(185, 'off', 1, 'english'),
(186, 'often', 1, 'english'),
(187, 'on', 1, 'english'),
(188, 'once', 1, 'english'),
(189, 'one', 1, 'english'),
(190, 'only', 1, 'english'),
(191, 'onto', 1, 'english'),
(192, 'or', 1, 'english'),
(193, 'other', 1, 'english'),
(194, 'others', 1, 'english'),
(195, 'otherwise', 1, 'english'),
(196, 'our', 1, 'english'),
(197, 'ours', 1, 'english'),
(198, 'ourselves', 1, 'english'),
(199, 'out', 1, 'english'),
(200, 'over', 1, 'english'),
(201, 'own', 1, 'english'),
(202, 'part', 1, 'english'),
(203, 'per', 1, 'english'),
(204, 'perhaps', 1, 'english'),
(205, 'please', 1, 'english'),
(206, 'put', 1, 'english'),
(207, 'rather', 1, 'english'),
(208, 're', 1, 'english'),
(209, 'same', 1, 'english'),
(210, 'see', 1, 'english'),
(211, 'seem', 1, 'english'),
(212, 'seemed', 1, 'english'),
(213, 'seeming', 1, 'english'),
(214, 'seems', 1, 'english'),
(215, 'serious', 1, 'english'),
(216, 'several', 1, 'english'),
(217, 'she', 1, 'english'),
(218, 'should', 1, 'english'),
(219, 'show', 1, 'english'),
(220, 'side', 1, 'english'),
(221, 'since', 1, 'english'),
(222, 'sincere', 1, 'english'),
(223, 'six', 1, 'english'),
(224, 'sixty', 1, 'english'),
(225, 'so', 1, 'english'),
(226, 'some', 1, 'english'),
(227, 'somehow', 1, 'english'),
(228, 'someone', 1, 'english'),
(229, 'something', 1, 'english'),
(230, 'sometime', 1, 'english'),
(231, 'sometimes', 1, 'english'),
(232, 'somewhere', 1, 'english'),
(233, 'still', 1, 'english'),
(234, 'such', 1, 'english'),
(235, 'system', 1, 'english'),
(236, 'take', 1, 'english'),
(237, 'ten', 1, 'english'),
(238, 'than', 1, 'english'),
(239, 'that', 1, 'english'),
(240, 'the', 1, 'english'),
(241, 'their', 1, 'english'),
(242, 'them', 1, 'english'),
(243, 'themselves', 1, 'english'),
(244, 'then', 1, 'english'),
(245, 'thence', 1, 'english'),
(246, 'there', 1, 'english'),
(247, 'thereafter', 1, 'english'),
(248, 'thereby', 1, 'english'),
(249, 'therefore', 1, 'english'),
(250, 'therein', 1, 'english'),
(251, 'thereupon', 1, 'english'),
(252, 'these', 1, 'english'),
(253, 'they', 1, 'english'),
(254, 'thickv', 1, 'english'),
(255, 'thin', 1, 'english'),
(256, 'third', 1, 'english'),
(257, 'this', 1, 'english'),
(258, 'those', 1, 'english'),
(259, 'though', 1, 'english'),
(260, 'three', 1, 'english'),
(261, 'through', 1, 'english'),
(262, 'throughout', 1, 'english'),
(263, 'thru', 1, 'english'),
(264, 'thus', 1, 'english'),
(265, 'to', 1, 'english'),
(266, 'together', 1, 'english'),
(267, 'too', 1, 'english'),
(268, 'top', 1, 'english'),
(269, 'toward', 1, 'english'),
(270, 'towards', 1, 'english'),
(271, 'twelve', 1, 'english'),
(272, 'twenty', 1, 'english'),
(273, 'two', 1, 'english'),
(274, 'un', 1, 'english'),
(275, 'under', 1, 'english'),
(276, 'until', 1, 'english'),
(277, 'up', 1, 'english'),
(278, 'upon', 1, 'english'),
(279, 'us', 1, 'english'),
(280, 'very', 1, 'english'),
(281, 'via', 1, 'english'),
(282, 'was', 1, 'english'),
(283, 'we', 1, 'english'),
(284, 'well', 1, 'english'),
(285, 'were', 1, 'english'),
(286, 'what', 1, 'english'),
(287, 'whatever', 1, 'english'),
(288, 'when', 1, 'english'),
(289, 'whence', 1, 'english'),
(290, 'whenever', 1, 'english'),
(291, 'where', 1, 'english'),
(292, 'whereafter', 1, 'english'),
(293, 'whereas', 1, 'english'),
(294, 'whereby', 1, 'english'),
(295, 'wherein', 1, 'english'),
(296, 'whereupon', 1, 'english'),
(297, 'wherever', 1, 'english'),
(298, 'whether', 1, 'english'),
(299, 'which', 1, 'english'),
(300, 'while', 1, 'english'),
(301, 'whither', 1, 'english'),
(302, 'who', 1, 'english'),
(303, 'whoever', 1, 'english'),
(304, 'whole', 1, 'english'),
(305, 'whom', 1, 'english'),
(306, 'whose', 1, 'english'),
(307, 'why', 1, 'english'),
(308, 'will', 1, 'english'),
(309, 'with', 1, 'english'),
(310, 'within', 1, 'english'),
(311, 'without', 0, 'english'),
(312, 'would', 1, 'english'),
(313, 'yet', 1, 'english'),
(314, 'you', 1, 'english'),
(315, 'your', 1, 'english'),
(316, 'yours', 1, 'english'),
(317, 'yourself', 1, 'english'),
(318, 'yourselves', 1, 'english'),
(319, 'like', 1, 'english'),
(327, 'ab', 1, 'german'),
(328, 'aber', 1, 'german'),
(329, 'ach', 1, 'german'),
(330, 'acht', 1, 'german'),
(331, 'achte', 1, 'german'),
(332, 'achten', 1, 'german'),
(333, 'achter', 1, 'german'),
(334, 'achtes', 1, 'german'),
(335, 'ag', 1, 'german'),
(336, 'alle', 1, 'german'),
(337, 'allein', 1, 'german'),
(338, 'allem', 1, 'german'),
(339, 'allen', 1, 'german'),
(340, 'aller', 1, 'german'),
(341, 'allerdings', 1, 'german'),
(342, 'alles', 1, 'german'),
(343, 'allgemeinen', 1, 'german'),
(344, 'als', 1, 'german'),
(345, 'ander', 1, 'german'),
(346, 'andere', 1, 'german'),
(347, 'anderem', 1, 'german'),
(348, 'anderen', 1, 'german'),
(349, 'anderer', 1, 'german'),
(350, 'anderes', 1, 'german'),
(351, 'anderm', 1, 'german'),
(352, 'andern', 1, 'german'),
(353, 'anderr', 1, 'german'),
(354, 'anders', 1, 'german'),
(355, 'au', 1, 'german'),
(356, 'auch', 1, 'german'),
(357, 'auf', 1, 'german'),
(358, 'aus', 1, 'german'),
(359, 'ausser', 1, 'german'),
(360, 'ausserdem', 1, 'german'),
(361, 'außer', 1, 'german'),
(362, 'außerdem', 1, 'german'),
(363, 'b', 1, 'german'),
(364, 'bald', 1, 'german'),
(365, 'bei', 1, 'german'),
(366, 'beide', 1, 'german'),
(367, 'beiden', 1, 'german'),
(368, 'beim', 1, 'german'),
(369, 'beispiel', 1, 'german'),
(370, 'bekannt', 1, 'german'),
(371, 'bereits', 1, 'german'),
(372, 'besonders', 1, 'german'),
(373, 'besser', 1, 'german'),
(374, 'besten', 1, 'german'),
(375, 'bin', 1, 'german'),
(376, 'bis', 1, 'german'),
(377, 'bisher', 1, 'german'),
(378, 'bist', 1, 'german'),
(379, 'c', 1, 'german'),
(380, 'd', 1, 'german'),
(381, 'd.h', 1, 'german'),
(382, 'da', 1, 'german'),
(383, 'dabei', 1, 'german'),
(384, 'dadurch', 1, 'german'),
(385, 'dafür', 1, 'german'),
(386, 'dagegen', 1, 'german'),
(387, 'daher', 1, 'german'),
(388, 'dahin', 1, 'german'),
(389, 'dahinter', 1, 'german'),
(390, 'damals', 1, 'german'),
(391, 'damit', 1, 'german'),
(392, 'danach', 1, 'german'),
(393, 'daneben', 1, 'german'),
(394, 'dank', 1, 'german'),
(395, 'dann', 1, 'german'),
(396, 'daran', 1, 'german'),
(397, 'darauf', 1, 'german'),
(398, 'daraus', 1, 'german'),
(399, 'darf', 1, 'german'),
(400, 'darfst', 1, 'german'),
(401, 'darin', 1, 'german'),
(402, 'darum', 1, 'german'),
(403, 'darunter', 1, 'german'),
(404, 'darüber', 1, 'german'),
(405, 'das', 1, 'german'),
(406, 'dasein', 1, 'german'),
(407, 'daselbst', 0, 'german'),
(408, 'dass', 1, 'german'),
(409, 'dasselbe', 1, 'german'),
(410, 'davon', 1, 'german'),
(411, 'davor', 1, 'german'),
(412, 'dazu', 1, 'german'),
(413, 'dazwischen', 1, 'german'),
(414, 'daß', 1, 'german'),
(415, 'dein', 1, 'german'),
(416, 'deine', 1, 'german'),
(417, 'deinem', 1, 'german'),
(418, 'deinen', 1, 'german'),
(419, 'deiner', 1, 'german'),
(420, 'deines', 1, 'german'),
(421, 'dem', 1, 'german'),
(422, 'dementsprechend', 1, 'german'),
(423, 'demgegenüber', 1, 'german'),
(424, 'demgemäss', 1, 'german'),
(425, 'demgemäß', 1, 'german'),
(426, 'demselben', 1, 'german'),
(427, 'demzufolge', 1, 'german'),
(428, 'den', 1, 'german'),
(429, 'denen', 1, 'german'),
(430, 'denn', 1, 'german'),
(431, 'denselben', 1, 'german'),
(432, 'der', 1, 'german'),
(433, 'deren', 1, 'german'),
(434, 'derer', 1, 'german'),
(435, 'derjenige', 1, 'german'),
(436, 'derjenigen', 1, 'german'),
(437, 'dermassen', 1, 'german'),
(438, 'dermaßen', 1, 'german'),
(439, 'derselbe', 1, 'german'),
(440, 'derselben', 1, 'german'),
(441, 'des', 1, 'german'),
(442, 'deshalb', 1, 'german'),
(443, 'desselben', 1, 'german'),
(444, 'dessen', 1, 'german'),
(445, 'deswegen', 1, 'german'),
(446, 'dich', 1, 'german'),
(447, 'die', 1, 'german'),
(448, 'diejenige', 1, 'german'),
(449, 'diejenigen', 1, 'german'),
(450, 'dies', 1, 'german'),
(451, 'diese', 1, 'german'),
(452, 'dieselbe', 1, 'german'),
(453, 'dieselben', 1, 'german'),
(454, 'diesem', 1, 'german'),
(455, 'diesen', 1, 'german'),
(456, 'dieser', 1, 'german'),
(457, 'dieses', 1, 'german'),
(458, 'dir', 1, 'german'),
(459, 'doch', 1, 'german'),
(460, 'dort', 1, 'german'),
(461, 'drei', 1, 'german'),
(462, 'drin', 1, 'german'),
(463, 'dritte', 1, 'german'),
(464, 'dritten', 1, 'german'),
(465, 'dritter', 1, 'german'),
(466, 'drittes', 1, 'german'),
(467, 'du', 1, 'german'),
(468, 'durch', 1, 'german'),
(469, 'durchaus', 1, 'german'),
(470, 'durfte', 1, 'german'),
(471, 'durften', 1, 'german'),
(472, 'dürfen', 1, 'german'),
(473, 'dürft', 1, 'german'),
(474, 'e', 1, 'german'),
(475, 'eben', 1, 'german'),
(476, 'ebenso', 1, 'german'),
(477, 'ehrlich', 1, 'german'),
(478, 'ei', 1, 'german'),
(479, 'ei,', 1, 'german'),
(480, 'eigen', 1, 'german'),
(481, 'eigene', 1, 'german'),
(482, 'eigenen', 1, 'german'),
(483, 'eigener', 1, 'german'),
(484, 'eigenes', 1, 'german'),
(485, 'ein', 1, 'german'),
(486, 'einander', 1, 'german'),
(487, 'eine', 1, 'german'),
(488, 'einem', 1, 'german'),
(489, 'einen', 1, 'german'),
(490, 'einer', 1, 'german'),
(491, 'eines', 1, 'german'),
(492, 'einig', 1, 'german'),
(493, 'einige', 1, 'german'),
(494, 'einigem', 1, 'german'),
(495, 'einigen', 1, 'german'),
(496, 'einiger', 1, 'german'),
(497, 'einiges', 1, 'german'),
(498, 'einmal', 1, 'german'),
(499, 'eins', 1, 'german'),
(500, 'elf', 1, 'german'),
(501, 'en', 1, 'german'),
(502, 'ende', 1, 'german'),
(503, 'endlich', 1, 'german'),
(504, 'entweder', 0, 'german'),
(505, 'er', 1, 'german'),
(506, 'ernst', 1, 'german'),
(507, 'erst', 1, 'german'),
(508, 'erste', 1, 'german'),
(509, 'ersten', 1, 'german'),
(510, 'erster', 1, 'german'),
(511, 'erstes', 1, 'german'),
(512, 'es', 1, 'german'),
(513, 'etwa', 1, 'german'),
(514, 'etwas', 1, 'german'),
(515, 'euch', 1, 'german'),
(516, 'euer', 1, 'german'),
(517, 'eure', 1, 'german'),
(518, 'eurem', 1, 'german'),
(519, 'euren', 1, 'german'),
(520, 'eurer', 1, 'german'),
(521, 'eures', 1, 'german'),
(522, 'f', 1, 'german'),
(523, 'folgende', 1, 'german'),
(524, 'früher', 1, 'german'),
(525, 'fünf', 1, 'german'),
(526, 'fünfte', 1, 'german'),
(527, 'fünften', 1, 'german'),
(528, 'fünfter', 1, 'german'),
(529, 'fünftes', 1, 'german'),
(530, 'für', 1, 'german'),
(531, 'g', 1, 'german'),
(532, 'gab', 1, 'german'),
(533, 'ganz', 1, 'german'),
(534, 'ganze', 1, 'german'),
(535, 'ganzen', 1, 'german'),
(536, 'ganzer', 1, 'german'),
(537, 'ganzes', 1, 'german'),
(538, 'gar', 1, 'german'),
(539, 'gedurft', 1, 'german'),
(540, 'gegen', 1, 'german'),
(541, 'gegenüber', 1, 'german'),
(542, 'gehabt', 1, 'german'),
(543, 'gehen', 1, 'german'),
(544, 'geht', 1, 'german'),
(545, 'gekannt', 1, 'german'),
(546, 'gekonnt', 1, 'german'),
(547, 'gemacht', 1, 'german'),
(548, 'gemocht', 1, 'german'),
(549, 'gemusst', 1, 'german'),
(550, 'genug', 1, 'german'),
(551, 'gerade', 1, 'german'),
(552, 'gern', 1, 'german'),
(553, 'gesagt', 1, 'german'),
(554, 'geschweige', 0, 'german'),
(555, 'gewesen', 1, 'german'),
(556, 'gewollt', 1, 'german'),
(557, 'geworden', 1, 'german'),
(558, 'gibt', 1, 'german'),
(559, 'ging', 1, 'german'),
(560, 'gleich', 1, 'german'),
(561, 'gott', 1, 'german'),
(562, 'gross', 1, 'german'),
(563, 'grosse', 1, 'german'),
(564, 'grossen', 1, 'german'),
(565, 'grosser', 1, 'german'),
(566, 'grosses', 1, 'german'),
(567, 'groß', 1, 'german'),
(568, 'große', 1, 'german'),
(569, 'großen', 1, 'german'),
(570, 'großer', 1, 'german'),
(571, 'großes', 1, 'german'),
(572, 'gut', 1, 'german'),
(573, 'gute', 1, 'german'),
(574, 'guter', 1, 'german'),
(575, 'gutes', 1, 'german'),
(576, 'h', 1, 'german'),
(577, 'hab', 1, 'german'),
(578, 'habe', 1, 'german'),
(579, 'haben', 1, 'german'),
(580, 'habt', 1, 'german'),
(581, 'hast', 1, 'german'),
(582, 'hat', 1, 'german'),
(583, 'hatte', 1, 'german'),
(584, 'hatten', 1, 'german'),
(585, 'hattest', 1, 'german'),
(586, 'hattet', 1, 'german'),
(587, 'heisst', 1, 'german'),
(588, 'heute', 1, 'german'),
(589, 'hier', 1, 'german'),
(590, 'hin', 1, 'german'),
(591, 'hinter', 1, 'german'),
(592, 'hoch', 1, 'german'),
(593, 'hätte', 1, 'german'),
(594, 'hätten', 1, 'german'),
(595, 'i', 1, 'german'),
(596, 'ich', 1, 'german'),
(597, 'ihm', 1, 'german'),
(598, 'ihn', 1, 'german'),
(599, 'ihnen', 1, 'german'),
(600, 'ihr', 1, 'german'),
(601, 'ihre', 1, 'german'),
(602, 'ihrem', 1, 'german'),
(603, 'ihren', 1, 'german'),
(604, 'ihrer', 1, 'german'),
(605, 'ihres', 1, 'german'),
(606, 'im', 0, 'german'),
(607, 'immer', 1, 'german'),
(608, 'indem', 1, 'german'),
(609, 'infolgedessen', 1, 'german'),
(610, 'ins', 1, 'german'),
(611, 'irgend', 1, 'german'),
(612, 'ist', 1, 'german'),
(613, 'j', 1, 'german'),
(614, 'ja', 1, 'german'),
(615, 'jahr', 1, 'german'),
(616, 'jahre', 1, 'german'),
(617, 'jahren', 1, 'german'),
(618, 'je', 1, 'german'),
(619, 'jede', 1, 'german'),
(620, 'jedem', 1, 'german'),
(621, 'jeden', 1, 'german'),
(622, 'jeder', 1, 'german'),
(623, 'jedermann', 1, 'german'),
(624, 'jedermanns', 1, 'german'),
(625, 'jedes', 1, 'german'),
(626, 'jedoch', 1, 'german'),
(627, 'jemand', 1, 'german'),
(628, 'jemandem', 1, 'german'),
(629, 'jemanden', 1, 'german'),
(630, 'jene', 1, 'german'),
(631, 'jenem', 1, 'german'),
(632, 'jenen', 1, 'german'),
(633, 'jener', 1, 'german'),
(634, 'jenes', 1, 'german'),
(635, 'jetzt', 1, 'german'),
(636, 'k', 1, 'german'),
(637, 'kam', 1, 'german'),
(638, 'kann', 1, 'german'),
(639, 'kannst', 1, 'german'),
(640, 'kaum', 1, 'german'),
(641, 'kein', 1, 'german'),
(642, 'keine', 1, 'german'),
(643, 'keinem', 1, 'german'),
(644, 'keinen', 1, 'german'),
(645, 'keiner', 1, 'german'),
(646, 'keines', 1, 'german'),
(647, 'kleine', 1, 'german'),
(648, 'kleinen', 1, 'german'),
(649, 'kleiner', 1, 'german'),
(650, 'kleines', 1, 'german'),
(651, 'kommen', 1, 'german'),
(652, 'kommt', 1, 'german'),
(653, 'konnte', 1, 'german'),
(654, 'konnten', 1, 'german'),
(655, 'kurz', 1, 'german'),
(656, 'können', 1, 'german'),
(657, 'könnt', 1, 'german'),
(658, 'könnte', 1, 'german'),
(659, 'l', 1, 'german'),
(660, 'lang', 1, 'german'),
(661, 'lange', 1, 'german'),
(662, 'leicht', 1, 'german'),
(663, 'leide', 1, 'german'),
(664, 'lieber', 1, 'german'),
(665, 'los', 1, 'german'),
(666, 'm', 1, 'german'),
(667, 'machen', 1, 'german'),
(668, 'macht', 1, 'german'),
(669, 'machte', 1, 'german'),
(670, 'mag', 1, 'german'),
(671, 'magst', 1, 'german'),
(672, 'mahn', 1, 'german'),
(673, 'mal', 1, 'german'),
(674, 'man', 1, 'german'),
(675, 'manche', 1, 'german'),
(676, 'manchem', 1, 'german'),
(677, 'manchen', 1, 'german'),
(678, 'mancher', 1, 'german'),
(679, 'manches', 1, 'german'),
(680, 'mann', 1, 'german'),
(681, 'mehr', 1, 'german'),
(682, 'mein', 1, 'german'),
(683, 'meine', 1, 'german'),
(684, 'meinem', 1, 'german'),
(685, 'meinen', 1, 'german'),
(686, 'meiner', 1, 'german'),
(687, 'meines', 1, 'german'),
(688, 'mensch', 1, 'german'),
(689, 'menschen', 1, 'german'),
(690, 'mich', 1, 'german'),
(691, 'mir', 1, 'german'),
(692, 'mit', 1, 'german'),
(693, 'mittel', 1, 'german'),
(694, 'mochte', 1, 'german'),
(695, 'mochten', 1, 'german'),
(696, 'morgen', 1, 'german'),
(697, 'muss', 1, 'german'),
(698, 'musst', 1, 'german'),
(699, 'musste', 1, 'german'),
(700, 'mussten', 1, 'german'),
(701, 'muß', 1, 'german'),
(702, 'mußt', 1, 'german'),
(703, 'möchte', 1, 'german'),
(704, 'mögen', 1, 'german'),
(705, 'möglich', 1, 'german'),
(706, 'mögt', 1, 'german'),
(707, 'müssen', 1, 'german'),
(708, 'müsst', 1, 'german'),
(709, 'müßt', 1, 'german'),
(710, 'n', 1, 'german'),
(711, 'na', 1, 'german'),
(712, 'nach', 1, 'german'),
(713, 'nachdem', 1, 'german'),
(714, 'nahm', 1, 'german'),
(715, 'natürlich', 1, 'german'),
(716, 'neben', 1, 'german'),
(717, 'nein', 1, 'german'),
(718, 'neue', 1, 'german'),
(719, 'neuen', 1, 'german'),
(720, 'neun', 1, 'german'),
(721, 'neunte', 1, 'german'),
(722, 'neunten', 1, 'german'),
(723, 'neunter', 1, 'german'),
(724, 'neuntes', 1, 'german'),
(725, 'nicht', 1, 'german'),
(726, 'nichts', 0, 'german'),
(727, 'nie', 1, 'german'),
(728, 'niemand', 1, 'german'),
(729, 'niemandem', 1, 'german'),
(730, 'niemanden', 1, 'german'),
(731, 'noch', 1, 'german'),
(732, 'nun', 1, 'german'),
(733, 'nur', 1, 'german'),
(734, 'o', 1, 'german'),
(735, 'ob', 1, 'german'),
(736, 'oben', 1, 'german'),
(737, 'oder', 1, 'german'),
(738, 'offen', 1, 'german'),
(739, 'oft', 1, 'german'),
(740, 'ohne', 1, 'german'),
(741, 'ordnung', 1, 'german'),
(742, 'p', 1, 'german'),
(743, 'q', 1, 'german'),
(744, 'r', 1, 'german'),
(745, 'recht', 1, 'german'),
(746, 'rechte', 1, 'german'),
(747, 'rechten', 1, 'german'),
(748, 'rechter', 1, 'german'),
(749, 'rechtes', 1, 'german'),
(750, 'richtig', 1, 'german'),
(751, 'rund', 1, 'german'),
(752, 's', 1, 'german'),
(753, 'sa', 1, 'german'),
(754, 'sache', 1, 'german'),
(755, 'sagt', 1, 'german'),
(756, 'sagte', 1, 'german'),
(757, 'sah', 1, 'german'),
(758, 'satt', 1, 'german'),
(759, 'schlecht', 1, 'german'),
(760, 'schluss', 1, 'german'),
(761, 'schon', 1, 'german'),
(762, 'sechs', 1, 'german'),
(763, 'sechste', 1, 'german'),
(764, 'sechsten', 1, 'german'),
(765, 'sechster', 1, 'german'),
(766, 'sechstes', 1, 'german'),
(767, 'sehr', 1, 'german'),
(768, 'sei', 1, 'german'),
(769, 'seid', 1, 'german'),
(770, 'seien', 1, 'german'),
(771, 'sein', 1, 'german'),
(772, 'seine', 1, 'german'),
(773, 'seinem', 1, 'german'),
(774, 'seinen', 1, 'german'),
(775, 'seiner', 1, 'german'),
(776, 'seines', 1, 'german'),
(777, 'seit', 1, 'german'),
(778, 'seitdem', 1, 'german'),
(779, 'selbst', 1, 'german'),
(780, 'sich', 1, 'german'),
(781, 'sie', 1, 'german'),
(782, 'sieben', 1, 'german'),
(783, 'siebente', 1, 'german'),
(784, 'siebenten', 1, 'german'),
(785, 'siebenter', 1, 'german'),
(786, 'siebentes', 1, 'german'),
(787, 'sind', 1, 'german'),
(788, 'solang', 1, 'german'),
(789, 'solche', 1, 'german'),
(790, 'solchem', 1, 'german'),
(791, 'solchen', 1, 'german'),
(792, 'solcher', 1, 'german'),
(793, 'solches', 1, 'german'),
(794, 'soll', 1, 'german'),
(795, 'sollen', 1, 'german'),
(796, 'sollst', 1, 'german'),
(797, 'sollt', 1, 'german'),
(798, 'sollte', 1, 'german'),
(799, 'sollten', 1, 'german'),
(800, 'sondern', 1, 'german'),
(801, 'sonst', 1, 'german'),
(802, 'soweit', 1, 'german'),
(803, 'sowie', 1, 'german'),
(804, 'später', 1, 'german'),
(805, 'startseite', 1, 'german'),
(806, 'statt', 1, 'german'),
(807, 'steht', 1, 'german'),
(808, 'suche', 1, 'german'),
(809, 't', 1, 'german'),
(810, 'tag', 1, 'german'),
(811, 'tage', 1, 'german'),
(812, 'tagen', 1, 'german'),
(813, 'tat', 1, 'german'),
(814, 'teil', 1, 'german'),
(815, 'tel', 1, 'german'),
(816, 'tritt', 1, 'german'),
(817, 'trotzdem', 1, 'german'),
(818, 'tun', 1, 'german'),
(819, 'u', 1, 'german'),
(820, 'uhr', 1, 'german'),
(821, 'um', 1, 'german'),
(822, 'und', 1, 'german'),
(823, 'und?', 1, 'german'),
(824, 'uns', 1, 'german'),
(825, 'unse', 1, 'german'),
(826, 'unsem', 1, 'german'),
(827, 'unsen', 1, 'german'),
(828, 'unser', 1, 'german'),
(829, 'unsere', 1, 'german'),
(830, 'unserer', 1, 'german'),
(831, 'unses', 1, 'german'),
(832, 'unter', 1, 'german'),
(833, 'v', 1, 'german'),
(834, 'vergangenen', 1, 'german'),
(835, 'viel', 1, 'german'),
(836, 'viele', 1, 'german'),
(837, 'vielem', 1, 'german'),
(838, 'vielen', 1, 'german'),
(839, 'vielleicht', 1, 'german'),
(840, 'vier', 1, 'german'),
(841, 'vierte', 1, 'german'),
(842, 'vierten', 1, 'german'),
(843, 'vierter', 1, 'german'),
(844, 'viertes', 1, 'german'),
(845, 'vom', 1, 'german'),
(846, 'von', 1, 'german'),
(847, 'vor', 1, 'german'),
(848, 'w', 1, 'german'),
(849, 'wahr?', 1, 'german'),
(850, 'wann', 1, 'german'),
(851, 'war', 1, 'german'),
(852, 'waren', 1, 'german'),
(853, 'warst', 1, 'german'),
(854, 'wart', 1, 'german'),
(855, 'warum', 1, 'german'),
(856, 'weg', 1, 'german'),
(857, 'wegen', 1, 'german'),
(858, 'weil', 1, 'german'),
(859, 'weit', 1, 'german'),
(860, 'weiter', 1, 'german'),
(861, 'weitere', 1, 'german'),
(862, 'weiteren', 1, 'german'),
(863, 'weiteres', 1, 'german'),
(864, 'welche', 1, 'german'),
(865, 'welchem', 1, 'german'),
(866, 'welchen', 1, 'german'),
(867, 'welcher', 1, 'german'),
(868, 'welches', 1, 'german'),
(869, 'wem', 1, 'german'),
(870, 'wen', 1, 'german'),
(871, 'wenig', 1, 'german'),
(872, 'wenige', 1, 'german'),
(873, 'weniger', 1, 'german'),
(874, 'weniges', 1, 'german'),
(875, 'wenigstens', 1, 'german'),
(876, 'wenn', 1, 'german'),
(877, 'wer', 1, 'german'),
(878, 'werde', 1, 'german'),
(879, 'werden', 1, 'german'),
(880, 'werdet', 1, 'german'),
(881, 'weshalb', 1, 'german'),
(882, 'wessen', 1, 'german'),
(883, 'wie', 1, 'german'),
(884, 'wieder', 1, 'german'),
(885, 'wieso', 1, 'german'),
(886, 'willst', 1, 'german'),
(887, 'wir', 1, 'german'),
(888, 'wird', 1, 'german'),
(889, 'wirklich', 1, 'german'),
(890, 'wirst', 1, 'german'),
(891, 'wissen', 1, 'german'),
(892, 'wo', 1, 'german'),
(893, 'woher', 1, 'german'),
(894, 'wohin', 1, 'german'),
(895, 'wohl', 1, 'german'),
(896, 'wollen', 1, 'german'),
(897, 'wollt', 1, 'german'),
(898, 'wollte', 1, 'german'),
(899, 'wollten', 1, 'german'),
(900, 'worden', 1, 'german'),
(901, 'wurde', 1, 'german'),
(902, 'wurden', 1, 'german'),
(903, 'während', 1, 'german'),
(904, 'währenddem', 1, 'german'),
(905, 'währenddessen', 1, 'german'),
(906, 'wäre', 1, 'german'),
(907, 'würde', 1, 'german'),
(908, 'würden', 1, 'german'),
(909, 'x', 1, 'german'),
(910, 'y', 1, 'german'),
(911, 'z', 1, 'german'),
(912, 'z.b', 1, 'german'),
(913, 'zehn', 1, 'german'),
(914, 'zehnte', 1, 'german'),
(915, 'zehnten', 1, 'german'),
(916, 'zehnter', 1, 'german'),
(917, 'zehntes', 1, 'german'),
(918, 'zeit', 1, 'german'),
(919, 'zu', 1, 'german'),
(920, 'zuerst', 1, 'german'),
(921, 'zugleich', 1, 'german'),
(922, 'zum', 1, 'german'),
(923, 'zunächst', 1, 'german'),
(924, 'zur', 1, 'german'),
(925, 'zurück', 1, 'german'),
(926, 'zusammen', 1, 'german'),
(927, 'zwanzig', 1, 'german'),
(928, 'zwar', 1, 'german'),
(929, 'zwei', 1, 'german'),
(930, 'zweite', 1, 'german'),
(931, 'zweiten', 1, 'german'),
(932, 'zweiter', 1, 'german'),
(933, 'zweites', 1, 'german'),
(934, 'zwischen', 1, 'german'),
(935, 'zwölf', 1, 'german'),
(936, 'über', 1, 'german'),
(937, 'überhaupt', 1, 'german'),
(938, 'übrigens', 1, 'german'),
(939, 'isn\'t', 1, 'english');

-- --------------------------------------------------------

--
-- Table structure for table `synonym_de`
--

CREATE TABLE `synonym_de` (
  `synonym_id` int(11) UNSIGNED NOT NULL,
  `word` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synonym` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cross_reference` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'It is now considered as cross reference',
  `synonym_partial_2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'It is now considered as hyperlink',
  `generic_term` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_term` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synonym_nn` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `non_secure_flag` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `source_reference_ns` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'Updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editorID',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'Created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'CreatorID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `synonym_de`
--

INSERT INTO `synonym_de` (`synonym_id`, `word`, `synonym`, `cross_reference`, `synonym_partial_2`, `generic_term`, `sub_term`, `synonym_nn`, `comment`, `non_secure_flag`, `source_reference_ns`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(16, 'Aberwitz', 'Wahnsinn', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:09:35', 1),
(17, 'Aderkröpfe', 'Varices, Krampfadern', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:11:31', 1),
(18, 'Ameisen-Laufen', 'Ameisenlaufen, Kriebeln, Kribbeln', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:20:40', 1),
(19, 'Apoplexie', 'Schlagfluss', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:21:09', 1),
(20, 'argwöhnisch', 'misstrauisch', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:22:01', 1),
(21, 'Athem', 'Atem, Odem', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:22:24', 1),
(22, 'Augenbutter', 'Augenschleim', NULL, NULL, 'Schleimabsonderung', NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:28:41', 1),
(23, 'Aufschwellung', 'Geschwulst, Auftreibung', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:29:52', 1),
(24, 'Augenfell', 'Pannus', NULL, NULL, 'Bindegewebswucherung', NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:32:05', 1),
(25, 'Auswurf', 'Sputa, Sputum', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-06-27 10:33:53', 1),
(28, 'niedergeschlagen', 'traurig', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, NULL, NULL, NULL, '2022-07-21 13:06:30', NULL),
(29, 'taumlich', 'taumelig, wackelig', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, NULL, NULL, NULL, '2022-08-04 10:13:04', NULL),
(30, 'Schründe', 'Schrunde, Hautriss, Einriss, Ragade, Rhagade', NULL, NULL, 'Hautveränderung', NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-08-11 11:00:05', 1);

-- --------------------------------------------------------

--
 -- Table structure for table `synonym_de_notes`
 --
 
 CREATE TABLE `synonym_de_notes` (
   `note_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
   `synonym_id` int(11) UNSIGNED NOT NULL,
   `note` TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
   `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`note_id`),
   KEY `idx_synonym_id` (`synonym_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `synonym_de_synonym_reference`
--

CREATE TABLE `synonym_de_synonym_reference` (
  `synonym_id` int(11) UNSIGNED NOT NULL,
  `synonym_reference_id` int(11) UNSIGNED NOT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quelle(Source) and autor(author) relationship table';

-- --------------------------------------------------------

--
-- Table structure for table `synonym_en`
--

CREATE TABLE `synonym_en` (
  `synonym_id` int(11) UNSIGNED NOT NULL,
  `word` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synonym` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cross_reference` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'It is now considered as cross reference',
  `synonym_partial_2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'It is now considered as hyperlink',
  `generic_term` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_term` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synonym_nn` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `non_secure_flag` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `source_reference_ns` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'Updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editorID',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'Created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'CreatorID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `synonym_en`
--

INSERT INTO `synonym_en` (`synonym_id`, `word`, `synonym`, `cross_reference`, `synonym_partial_2`, `generic_term`, `sub_term`, `synonym_nn`, `reference_id`, `comment`, `non_secure_flag`, `source_reference_ns`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(1, 'pain', 'ache, aching, agony', 'hurt,prick', 'trouble, wound', 'discomfort,strain', 'soreness, irritation', 'distress,twinge', NULL, NULL, '0', '0', 1, '47.29.172.64', '2022-07-09 19:06:13', 1, '2022-06-18 09:32:58', 1),
(2, 'Fat', 'Stout', 'Corpulent,Paunchy', 'Plump', NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '47.29.172.64', NULL, NULL, '2022-07-09 19:07:21', 1),
(3, 'grief', 'sorrow, pain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:25:57', 1),
(4, 'ennui', 'boredom', 'boring', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:27:00', 1),
(5, 'uneasy', 'worried, unsettled, alarmed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:28:51', 1),
(6, 'vertigo', 'dizziness', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:29:26', 1),
(7, 'nausea', 'sickness', 'feeling sick', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:30:26', 1),
(8, 'neck', 'nape of the neck', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:31:55', 1),
(9, 'giddy', 'dizzy', 'vertigo', NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:34:55', 1),
(10, 'vertex', 'crown, apex', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:36:22', 1),
(11, 'forehead', 'brow', NULL, NULL, 'front', NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:38:50', 1),
(12, 'lachrymation', 'lacrymation, tear secretion', NULL, NULL, 'secretion', NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:41:32', 1),
(13, 'dim-sightedness', 'dimsightedness, visual impairment, lacking perception, dim sight', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:46:27', 1),
(14, 'fog', 'mist, haze', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:48:14', 1),
(15, 'ala of the nose', 'nostril, nasal wing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:49:39', 1),
(16, 'soreness', 'rawness, painfulness', 'raw, sore', NULL, 'pain, ache', NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', '2022-07-11 09:53:34', 1, '2022-07-11 09:51:38', 1),
(17, 'evacuation', 'deflation, emptying', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '78.94.1.201', NULL, NULL, '2022-07-11 09:54:47', 1),
(18, 'head', 'forehead a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, '127.0.0.1', '2025-01-13 07:39:09', 100, '2022-11-16 07:39:03', NULL);

-- --------------------------------------------------------

--
 -- Table structure for table `synonym_en_notes`
 --
 
 CREATE TABLE `synonym_en_notes` (
   `note_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
   `synonym_id` int(11) UNSIGNED NOT NULL,
   `note` TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
   `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`note_id`),
   KEY `idx_synonym_id` (`synonym_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `synonym_en_synonym_reference`
--

CREATE TABLE `synonym_en_synonym_reference` (
  `synonym_id` int(11) UNSIGNED NOT NULL,
  `synonym_reference_id` int(11) UNSIGNED NOT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editor_id',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creator_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quelle(Source) and autor(author) relationship table';

-- --------------------------------------------------------

--
-- Table structure for table `synonym_reference`
--

CREATE TABLE `synonym_reference` (
  `synonym_reference_id` int(11) UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'title',
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'Updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editorID',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'Created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'CreatorID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='origin' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `synonym_reference`
--

INSERT INTO `synonym_reference` (`synonym_reference_id`, `code`, `titel`, `comment`, `active`, `ip_address`, `stand`, `bearbeiter_id`, `ersteller_datum`, `ersteller_id`) VALUES
(22, NULL, 'Test Synonym Reference', 'Here is a test comment.', 1, '127.0.0.1', NULL, NULL, '2025-01-11 05:08:18', 100);

-- --------------------------------------------------------

--
-- Table structure for table `verlag`
--

CREATE TABLE `verlag` (
  `verlag_id` int(11) UNSIGNED NOT NULL COMMENT 'publisherID',
  `code` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `titel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'title',
  `strasse` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Road',
  `plz` varchar(6) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ZIP Code',
  `ort` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Place or Location',
  `land_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'countryID',
  `telefon` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `homepage` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Homepage url',
  `bemerkungen` text CHARACTER SET utf8 DEFAULT NULL COMMENT 'Remarks',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stand` timestamp NULL DEFAULT NULL COMMENT 'Updated at',
  `bearbeiter_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'editorID',
  `ersteller_datum` timestamp NULL DEFAULT NULL COMMENT 'Created at',
  `ersteller_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'creatorID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Publishing company (Publisher)' ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arznei`
--
ALTER TABLE `arznei`
  ADD PRIMARY KEY (`arznei_id`);

--
-- Indexes for table `arznei_autor`
--
ALTER TABLE `arznei_autor`
  ADD PRIMARY KEY (`arznei_id`,`autor_id`),
  ADD KEY `bearbeiter_id` (`bearbeiter_id`),
  ADD KEY `ersteller_id` (`ersteller_id`);

--
-- Indexes for table `arznei_quelle`
--
ALTER TABLE `arznei_quelle`
  ADD PRIMARY KEY (`arznei_id`,`quelle_id`),
  ADD KEY `bearbeiter_id` (`bearbeiter_id`),
  ADD KEY `ersteller_id` (`ersteller_id`);

--
-- Indexes for table `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`autor_id`),
  ADD KEY `code` (`code`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `active` (`active`) USING BTREE;

--
-- Indexes for table `pre_comparison_master_data`
--
ALTER TABLE `pre_comparison_master_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pruefer`
--
ALTER TABLE `pruefer`
  ADD PRIMARY KEY (`pruefer_id`),
  ADD KEY `ersteller_id` (`ersteller_id`),
  ADD KEY `bearbeiter_id` (`bearbeiter_id`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `quelle`
--
ALTER TABLE `quelle`
  ADD PRIMARY KEY (`quelle_id`),
  ADD KEY `herkunft_id` (`herkunft_id`) USING BTREE,
  ADD KEY `sprache` (`sprache`) USING BTREE,
  ADD KEY `verlag_id` (`verlag_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE,
  ADD KEY `quelle_type_id` (`quelle_type_id`) USING BTREE,
  ADD KEY `quelle_schema_id` (`quelle_schema_id`) USING BTREE,
  ADD KEY `code` (`code`) USING BTREE,
  ADD KEY `jahr` (`jahr`) USING BTREE;

--
-- Indexes for table `quelle_autor`
--
ALTER TABLE `quelle_autor`
  ADD PRIMARY KEY (`quelle_id`,`autor_id`),
  ADD KEY `quelle_id` (`quelle_id`) USING BTREE,
  ADD KEY `autor_id` (`autor_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE;

--
-- Indexes for table `quelle_autor_as_editor`
--
ALTER TABLE `quelle_autor_as_editor`
  ADD PRIMARY KEY (`quelle_id`,`autor_id`),
  ADD KEY `quelle_id` (`quelle_id`) USING BTREE,
  ADD KEY `autor_id` (`autor_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE;

--
-- Indexes for table `quelle_import_master`
--
ALTER TABLE `quelle_import_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quelle_import_test`
--
ALTER TABLE `quelle_import_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_id` (`master_id`),
  ADD KEY `arznei_id` (`arznei_id`),
  ADD KEY `quelle_id` (`quelle_id`);

--
-- Indexes for table `quelle_pruefer`
--
ALTER TABLE `quelle_pruefer`
  ADD PRIMARY KEY (`quelle_id`,`pruefer_id`),
  ADD KEY `quelle_id` (`quelle_id`) USING BTREE,
  ADD KEY `autor_id` (`pruefer_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE;

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`reference_id`);

--
-- Indexes for table `remedy`
--
ALTER TABLE `remedy`
  ADD PRIMARY KEY (`remedy_id`);

--
-- Indexes for table `stop_words`
--
ALTER TABLE `stop_words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `synonym_de`
--
ALTER TABLE `synonym_de`
  ADD PRIMARY KEY (`synonym_id`),
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE,
  ADD KEY `active` (`active`) USING BTREE,
  ADD KEY `code` (`word`) USING BTREE,
  ADD KEY `synonym` (`synonym`);

--
-- Indexes for table `synonym_de_synonym_reference`
--
ALTER TABLE `synonym_de_synonym_reference`
  ADD PRIMARY KEY (`synonym_id`,`synonym_reference_id`),
  ADD KEY `quelle_id` (`synonym_id`) USING BTREE,
  ADD KEY `autor_id` (`synonym_reference_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE;

--
-- Indexes for table `synonym_en`
--
ALTER TABLE `synonym_en`
  ADD PRIMARY KEY (`synonym_id`),
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE,
  ADD KEY `active` (`active`) USING BTREE,
  ADD KEY `code` (`word`) USING BTREE,
  ADD KEY `synonym` (`synonym`);

--
-- Indexes for table `synonym_en_synonym_reference`
--
ALTER TABLE `synonym_en_synonym_reference`
  ADD PRIMARY KEY (`synonym_id`,`synonym_reference_id`),
  ADD KEY `quelle_id` (`synonym_id`) USING BTREE,
  ADD KEY `autor_id` (`synonym_reference_id`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE;

--
-- Indexes for table `synonym_reference`
--
ALTER TABLE `synonym_reference`
  ADD PRIMARY KEY (`synonym_reference_id`),
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE,
  ADD KEY `active` (`active`) USING BTREE,
  ADD KEY `code` (`code`) USING BTREE;

--
-- Indexes for table `verlag`
--
ALTER TABLE `verlag`
  ADD PRIMARY KEY (`verlag_id`),
  ADD KEY `code` (`code`) USING BTREE,
  ADD KEY `land_id` (`land_id`) USING BTREE,
  ADD KEY `active` (`active`) USING BTREE,
  ADD KEY `bearbeiter_id` (`bearbeiter_id`) USING BTREE,
  ADD KEY `ersteller_id` (`ersteller_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arznei`
--
ALTER TABLE `arznei`
  MODIFY `arznei_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'medicine_id', AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `autor_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Author id', AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pre_comparison_master_data`
--
ALTER TABLE `pre_comparison_master_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2071;

--
-- AUTO_INCREMENT for table `pruefer`
--
ALTER TABLE `pruefer`
  MODIFY `pruefer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'tester_id', AUTO_INCREMENT=2262;

--
-- AUTO_INCREMENT for table `quelle`
--
ALTER TABLE `quelle`
  MODIFY `quelle_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'source_id', AUTO_INCREMENT=3120;

--
-- AUTO_INCREMENT for table `quelle_import_master`
--
ALTER TABLE `quelle_import_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5070;

--
-- AUTO_INCREMENT for table `quelle_import_test`
--
ALTER TABLE `quelle_import_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `reference_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'reference_id', AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `remedy`
--
ALTER TABLE `remedy`
  MODIFY `remedy_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `stop_words`
--
ALTER TABLE `stop_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=940;

--
-- AUTO_INCREMENT for table `synonym_de`
--
ALTER TABLE `synonym_de`
  MODIFY `synonym_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `synonym_en`
--
ALTER TABLE `synonym_en`
  MODIFY `synonym_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `synonym_reference`
--
ALTER TABLE `synonym_reference`
  MODIFY `synonym_reference_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `verlag`
--
ALTER TABLE `verlag`
  MODIFY `verlag_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'publisherID', AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE synonym_de ADD COLUMN root_word VARCHAR(255) AFTER synonym_id;
ALTER TABLE `synonym_de`  ADD COLUMN `isgreen` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Indicates if green';
ALTER TABLE synonym_de DROP INDEX synonym;
ALTER TABLE synonym_de MODIFY synonym TEXT;
ALTER TABLE synonym_de MODIFY synonym LONGTEXT;
ALTER TABLE `synonym_de` ADD COLUMN `isyellow` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Indicates if yellow';
ALTER TABLE `synonym_en`   ADD COLUMN `isyellow` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Indicates if yellow';
ALTER TABLE synonym_en ADD COLUMN root_word VARCHAR(255) NULL AFTER synonym_id;
ALTER TABLE synonym_en DROP COLUMN reference_id;
ALTER TABLE synonym_en ADD COLUMN isgreen TINYINT(1) NOT NULL DEFAULT 0 AFTER ersteller_id;