-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_rekom_pegawai
CREATE DATABASE IF NOT EXISTS `db_rekom_pegawai` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_rekom_pegawai`;

-- Dumping structure for table db_rekom_pegawai.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.migrations: ~6 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_03_19_102456_create_permission_tables', 1),
	(6, '2022_03_29_105225_create_settings_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.model_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.model_has_roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.opd
CREATE TABLE IF NOT EXISTS `opd` (
  `id` int(10) unsigned NOT NULL,
  `nama` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pengajuan_berkas_0` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_rekom_pegawai.opd: ~0 rows (approximately)
/*!40000 ALTER TABLE `opd` DISABLE KEYS */;
/*!40000 ALTER TABLE `opd` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.pegawai
CREATE TABLE IF NOT EXISTS `pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama` varchar(500) DEFAULT NULL,
  `jabatan` varchar(500) DEFAULT NULL,
  `opd_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pegawai_users_0` (`user_id`),
  CONSTRAINT `fk_pegawai_users_0` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_rekom_pegawai.pegawai: ~0 rows (approximately)
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.pengajuan
CREATE TABLE IF NOT EXISTS `pengajuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(16) DEFAULT NULL,
  `nama` varchar(500) DEFAULT NULL,
  `pengirim_id` int(11) DEFAULT NULL,
  `penerima_opd_id` int(10) unsigned DEFAULT NULL,
  `pengirim_opd_id` int(10) unsigned DEFAULT NULL,
  `file_sk_pns` varchar(500) DEFAULT NULL,
  `file_sk_pangkat_terakhir` varchar(500) DEFAULT NULL,
  `file_sk_jabatan` varchar(500) DEFAULT NULL,
  `file_skp` varchar(500) DEFAULT NULL,
  `catatan` text,
  `file_sk_cpns` varchar(500) DEFAULT NULL,
  `uuid` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pengajuan_opd` (`pengirim_opd_id`),
  KEY `fk_pengajuan_opd_0` (`penerima_opd_id`),
  KEY `fk_pengajuan_users` (`pengirim_id`),
  CONSTRAINT `fk_pengajuan_opd` FOREIGN KEY (`pengirim_opd_id`) REFERENCES `opd` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pengajuan_opd_0` FOREIGN KEY (`penerima_opd_id`) REFERENCES `opd` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pengajuan_users` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table db_rekom_pegawai.pengajuan: ~10 rows (approximately)
/*!40000 ALTER TABLE `pengajuan` DISABLE KEYS */;
INSERT INTO `pengajuan` (`id`, `nip`, `nama`, `pengirim_id`, `penerima_opd_id`, `pengirim_opd_id`, `file_sk_pns`, `file_sk_pangkat_terakhir`, `file_sk_jabatan`, `file_skp`, `catatan`, `file_sk_cpns`, `uuid`, `created_at`, `updated_at`) VALUES
	(2, '121212', 'Sudirman', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpCB3E.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpCB40.tmp', NULL, 'qwdqwdqw', 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpCB3F.tmp', 0, '2022-11-24 14:24:04', '2022-11-24 14:24:04'),
	(3, 'qwd', 'dqwd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php782F.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php7831.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php7830.tmp', 0, '2022-11-24 14:59:46', '2022-11-24 14:59:46'),
	(4, 'd', 'qwdqw', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpBF0F.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpBF11.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpBF10.tmp', 0, '2022-11-24 15:00:04', '2022-11-24 15:00:04'),
	(5, 'wqd', 'dqwd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpF60.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpF71.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpF70.tmp', 0, '2022-11-24 15:01:30', '2022-11-24 15:01:30'),
	(6, 'qwd', 'qwd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpC68D.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpC68F.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpC68E.tmp', 0, '2022-11-24 15:02:17', '2022-11-24 15:02:17'),
	(7, 'qwd', 'dwqd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php16BA.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php16CC.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php16BB.tmp', 0, '2022-11-24 15:04:48', '2022-11-24 15:04:48'),
	(8, 'qw', 'dqwd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php5AEA.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php5AEC.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php5AEB.tmp', 0, '2022-11-24 15:05:06', '2022-11-24 15:05:06'),
	(9, 'qwd', 'dwqd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php1D72.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php1D74.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php1D73.tmp', 0, '2022-11-24 15:05:56', '2022-11-24 15:05:56'),
	(10, 'qw', 'qwd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php6423.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php6425.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\php6424.tmp', 0, '2022-11-24 15:06:14', '2022-11-24 15:06:14'),
	(11, 'qwd', 'dqwd', NULL, NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpA342.tmp', NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpA344.tmp', NULL, NULL, 'C:\\Users\\Lian Mafutra\\AppData\\Local\\Temp\\phpA343.tmp', 0, '2022-11-24 15:06:30', '2022-11-24 15:06:30');
/*!40000 ALTER TABLE `pengajuan` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.pengajuan_histori
CREATE TABLE IF NOT EXISTS `pengajuan_histori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pengajuan_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl_kirim` timestamp NULL DEFAULT NULL,
  `tgl_baca` timestamp NULL DEFAULT NULL,
  `penerima_opd_id` int(11) DEFAULT NULL,
  `pengirim_opd_id` int(11) DEFAULT NULL,
  `pengirim_id` int(11) DEFAULT NULL,
  `status` enum('PROSES','TOLAK','SELESAI') DEFAULT NULL COMMENT 'dqwdqwdqwd',
  PRIMARY KEY (`id`),
  KEY `fk_pengajuan_histori_pengajuan_0` (`pengajuan_id`),
  CONSTRAINT `fk_pengajuan_histori_pengajuan_0` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Status pengajuan Berkas dari admin OPD ke inspektorat\n\nPROSES, TOLAK, SELESAI';

-- Dumping data for table db_rekom_pegawai.pengajuan_histori: ~0 rows (approximately)
/*!40000 ALTER TABLE `pengajuan_histori` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengajuan_histori` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.permissions: ~24 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'filemanager', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(2, 'read module', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(3, 'delete setting', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(4, 'update setting', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(5, 'read setting', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(6, 'create setting', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(7, 'delete user', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(8, 'update user', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(9, 'read user', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(10, 'create user', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(11, 'delete role', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(12, 'update role', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(13, 'read role', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(14, 'create role', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(15, 'delete permission', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(16, 'update permission', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(17, 'read permission', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(18, 'create permission', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(19, 'view_data_pegawai', 'web', '2022-11-18 11:16:07', '2022-11-18 11:16:07'),
	(20, 'pengajuan', 'web', '2022-11-18 11:41:26', '2022-11-18 11:41:26'),
	(21, 'pengajuan create', 'web', '2022-11-22 09:08:40', '2022-11-22 09:08:40'),
	(22, 'pengajuan store', 'web', '2022-11-22 14:59:32', '2022-11-22 14:59:32'),
	(23, 'pengajuan destroy', 'web', '2022-11-22 14:59:43', '2022-11-22 14:59:43'),
	(24, 'pengajuan update', 'web', '2022-11-22 14:59:50', '2022-11-22 14:59:50');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.roles: ~3 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'superadmin', 'web', '2022-11-18 10:50:20', '2022-11-18 10:50:20'),
	(4, 'admin_inspektorat', 'web', '2022-11-18 11:33:06', '2022-11-18 11:33:06'),
	(5, 'admin_opd', 'web', '2022-11-18 11:33:28', '2022-11-18 11:33:28');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.role_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` enum('information','contact','payment','email','api') COLLATE utf8mb4_unicode_ci DEFAULT 'information',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.settings: ~6 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `key`, `value`, `name`, `type`, `ext`, `category`, `created_at`, `updated_at`) VALUES
	(1, 'app_name', 'RekomPeg', 'Application Short Name', 'text', NULL, 'information', '2022-11-18 10:50:20', '2022-11-21 10:59:58'),
	(2, 'app_short_name', 'RekomPeg', 'Application Name', 'text', NULL, 'information', '2022-11-18 10:50:20', '2022-11-21 10:59:58'),
	(3, 'app_logo', 'storage/logo_kota.png', 'Application Logo', 'file', 'png', 'information', '2022-11-18 10:50:20', '2022-11-21 10:59:58'),
	(4, 'app_favicon', 'storage/logo_kota.png', 'Application Favicon', 'file', 'png', 'information', '2022-11-18 10:50:20', '2022-11-21 10:59:58'),
	(5, 'app_loading_gif', 'storage/logo_kota.png', 'Application Loading Image', 'file', 'gif', 'information', '2022-11-18 10:50:20', '2022-11-21 10:59:58'),
	(6, 'app_map_loaction', 'none', 'Application Map Location', 'textarea', NULL, 'contact', '2022-11-18 10:50:20', '2022-11-18 11:32:23');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table db_rekom_pegawai.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_rekom_pegawai.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`) VALUES
	(1, 'Lian Mafutra', NULL, NULL, '$2a$12$cbboE8Ci243P4NqHRwbcTuNAgE.A4DrPKp7KkQtGzYZmTBNc0rpZ.', 'LvYBjWeQOGhBueHNotYP1W1ZdR5hhSALYjapJj8lhsDZ65TPyAmSWGBR3Axe', '2022-11-23 16:04:52', '2022-11-23 16:04:55', 'superadmin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
