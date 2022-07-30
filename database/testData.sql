-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.28 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table celtra_notes.folders: ~0 rows (approximately)
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` (`id_folder`, `name`, `id_user`, `created_at`, `updated_at`) VALUES
	(1, 'Opravki', 1, '2022-07-30 09:30:26', '2022-07-30 09:31:51'),
	(2, 'Zapiski', 1, '2022-07-30 09:30:51', '2022-07-30 09:30:51'),
	(3, 'Zgodovina', 2, '2022-07-30 12:39:55', '2022-07-30 12:39:55'),
	(4, 'Druzina', 2, '2022-07-30 12:40:13', '2022-07-30 12:42:43'),
	(6, 'Dopust ideje', 2, '2022-07-30 12:44:11', '2022-07-30 12:44:11');
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;

-- Dumping data for table celtra_notes.notes: ~0 rows (approximately)
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` (`id_note`, `name`, `id_user`, `id_folder`, `public`, `id_note_type`, `created_at`, `updated_at`) VALUES
	(1, 'Nakopovalni list', 1, 1, NULL, 2, '2022-07-30 09:32:23', '2022-07-30 13:04:57'),
	(2, 'Čistilka', 1, 1, NULL, 1, '2022-07-30 12:45:17', '2022-07-30 12:45:17'),
	(3, 'Otroci', 1, 1, NULL, 1, '2022-07-30 12:46:02', '2022-07-30 12:46:02'),
	(4, 'Plačaj položnice', 1, 1, NULL, 1, '2022-07-30 12:46:16', '2022-07-30 12:46:16'),
	(5, 'Ideje za projekte', 1, 2, 1, 2, '2022-07-30 12:47:05', '2022-07-30 13:05:28'),
	(7, 'Zapiski zgodovina', 2, NULL, 1, 2, '2022-07-30 13:09:48', '2022-07-30 13:09:48'),
	(8, 'Zapiski likovna vzgoja', 2, NULL, 1, 2, '2022-07-30 13:10:15', '2022-07-30 13:10:15'),
	(9, 'Zapiski Programiranje1', 2, NULL, 1, 2, '2022-07-30 13:10:27', '2022-07-30 13:10:27'),
	(10, 'Datastat projekti', 1, 2, NULL, 1, '2022-07-30 13:22:06', '2022-07-30 13:22:06'),
	(11, 'Črna gora', 2, 6, NULL, 2, '2022-07-30 13:34:40', '2022-07-30 13:34:40'),
	(12, 'Maldivi', 2, 6, NULL, 2, '2022-07-30 13:34:50', '2022-07-30 13:34:50'),
	(13, 'Columbia', 2, 6, NULL, 2, '2022-07-30 13:34:55', '2022-07-30 13:34:55'),
	(14, 'Krk', 2, 6, NULL, 2, '2022-07-30 13:34:59', '2022-07-30 13:34:59');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;

-- Dumping data for table celtra_notes.note_bodies: ~0 rows (approximately)
/*!40000 ALTER TABLE `note_bodies` DISABLE KEYS */;
INSERT INTO `note_bodies` (`id_note_body`, `id_note`, `text`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Paradižnik', '2022-07-30 12:47:45', '2022-07-30 12:50:26'),
	(2, 1, 'Pomaranče', '2022-07-30 12:47:59', '2022-07-30 12:47:59'),
	(3, 1, 'Kruh', '2022-07-30 12:50:43', '2022-07-30 12:50:43'),
	(4, 1, 'Arašidi', '2022-07-30 12:50:48', '2022-07-30 12:50:48'),
	(5, 1, 'Sir', '2022-07-30 12:50:53', '2022-07-30 12:50:53'),
	(6, 1, 'Jajca', '2022-07-30 12:50:59', '2022-07-30 12:50:59'),
	(7, 5, 'Hribi.si', '2022-07-30 12:56:14', '2022-07-30 12:56:52'),
	(8, 5, 'Wordle', '2022-07-30 12:57:02', '2022-07-30 12:57:02'),
	(9, 5, 'Movie guesser', '2022-07-30 12:57:13', '2022-07-30 12:57:13'),
	(10, 2, 'Nepozabi poklicati čistilke, tel: 040 321 321', '2022-07-30 12:57:43', '2022-07-30 12:57:43'),
	(11, 3, 'Poberi otroke iz šole v ponedeljek 15:00, torek 16:00  in petek 18:00', '2022-07-30 12:59:25', '2022-07-30 12:59:25'),
	(12, 4, 'Plačaj elektriko in plin do 30.7.2022', '2022-07-30 13:00:03', '2022-07-30 13:00:03'),
	(14, 7, 'Karl veliki se je rodil....', '2022-07-30 13:16:48', '2022-07-30 13:16:48'),
	(15, 7, 'Rimsko cesarstvo (latinsko Imperivm Romanvm, grško Βασιλεία τῶν Ῥωμαίων, Basileía tōn Rhōmaíōn) je bilo obdobje starega Rima, ki je sledilo Rimski republiki.', '2022-07-30 13:17:16', '2022-07-30 13:17:16'),
	(16, 7, 'Zaradi velikega ozemlja in dolgega obstoja Rimskega cesarstva so rimske upravne prakse in kultura močno in trajno vplivale na razvoj jezika, religije, umetnosti, arhitekture, filozofije, prava in oblik vladanja ne samo na ozemlju, ki ga je obsegalo, temveč tudi daleč preko meja.', '2022-07-30 13:17:27', '2022-07-30 13:17:27'),
	(17, 9, 'Python is a high-level, interpreted, general-purpose programming language. Its design philosophy emphasizes code readability with the use of significant indentation.', '2022-07-30 13:17:54', '2022-07-30 13:17:54'),
	(18, 9, 'Python consistently ranks as one of the most popular programming languages.', '2022-07-30 13:18:42', '2022-07-30 13:18:42'),
	(19, 11, 'Relativno poceni', '2022-07-30 13:35:18', '2022-07-30 13:35:18'),
	(20, 11, 'Lepe plaže', '2022-07-30 13:35:26', '2022-07-30 13:35:26'),
	(21, 11, 'Prijazni domačini', '2022-07-30 13:35:34', '2022-07-30 13:35:34'),
	(23, 12, 'Lepi razgledi', '2022-07-30 13:36:14', '2022-07-30 13:36:14'),
	(24, 12, 'Žena želi it', '2022-07-30 13:36:21', '2022-07-30 13:36:21'),
	(25, 12, 'Otroci bojo mel za ig slike', '2022-07-30 13:36:30', '2022-07-30 13:36:30'),
	(26, 13, 'Zelo poceni', '2022-07-30 13:36:47', '2022-07-30 13:36:47'),
	(27, 13, 'Veliko za vidit', '2022-07-30 13:36:53', '2022-07-30 13:36:53'),
	(28, 14, 'Blizu', '2022-07-30 13:37:01', '2022-07-30 13:37:01'),
	(29, 14, 'Lahko gremo z avtom', '2022-07-30 13:37:09', '2022-07-30 13:37:09'),
	(30, 14, 'Lahko gremo pogledat še Hrenove, ker imajo blizu prikolico', '2022-07-30 13:37:32', '2022-07-30 13:37:57');
/*!40000 ALTER TABLE `note_bodies` ENABLE KEYS */;

-- Dumping data for table celtra_notes.note_types: ~0 rows (approximately)
/*!40000 ALTER TABLE `note_types` DISABLE KEYS */;
INSERT INTO `note_types` (`id_note_type`, `name`) VALUES
	(1, 'Text note'),
	(2, 'List note');
/*!40000 ALTER TABLE `note_types` ENABLE KEYS */;

-- Dumping data for table celtra_notes.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id_user`, `first_name`, `last_name`, `email`, `username`, `password`, `created_at`, `updated_at`) VALUES
	(1, 'Matic', 'Lampret', 'matic.lampret@gmail.com', 'matic', '$2y$10$UWVT4HWXWTJDEnqNY/84k.70FLIFg0SPY/kdEKe7TPW2EE9FHyAPa', NULL, NULL),
	(2, 'test', 'uporabnik', 'test@gmail.com', 'test', '$2a$12$ZPOUmh2Byj/fQ24yNHz9UeiniYeU6S2fQr92kVMOcqonuQzr4/jnC', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
