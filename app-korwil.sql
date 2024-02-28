/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MariaDB
 Source Server Version : 110202 (11.2.2-MariaDB-log)
 Source Host           : localhost:3306
 Source Schema         : app-korwil

 Target Server Type    : MariaDB
 Target Server Version : 110202 (11.2.2-MariaDB-log)
 File Encoding         : 65001

 Date: 28/02/2024 17:19:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for absensi
-- ----------------------------
DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `id_absensi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sekolah` int(10) unsigned DEFAULT NULL,
  `id_ta` int(10) unsigned DEFAULT NULL,
  `id_staff` int(10) unsigned DEFAULT NULL,
  `hari` date DEFAULT NULL,
  `ket` enum('0','1','2','3','4') DEFAULT '0',
  PRIMARY KEY (`id_absensi`),
  KEY `sekolah_absensi` (`id_sekolah`),
  KEY `ta_absen` (`id_ta`),
  KEY `staff_absensi` (`id_staff`) USING BTREE,
  CONSTRAINT `sekolah_absensi` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`),
  CONSTRAINT `staff_absensi` FOREIGN KEY (`id_staff`) REFERENCES `staff` (`id_staff`),
  CONSTRAINT `ta_absen` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajar` (`id_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of absensi
-- ----------------------------
BEGIN;
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (16, 3, 4, 1, '2023-12-01', '1');
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (17, 3, 4, 2, '2023-12-01', '1');
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (18, 3, 4, 3, '2023-12-01', '2');
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (19, 3, 4, 6, '2023-12-01', '0');
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (20, 3, 4, 7, '2023-12-01', '0');
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (21, 3, 4, 4, '2023-12-01', '0');
INSERT INTO `absensi` (`id_absensi`, `id_sekolah`, `id_ta`, `id_staff`, `hari`, `ket`) VALUES (22, 3, 4, 5, '2023-12-01', '0');
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for jabatan_staff
-- ----------------------------
DROP TABLE IF EXISTS `jabatan_staff`;
CREATE TABLE `jabatan_staff` (
  `id_jabatan_staff` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ta` int(10) unsigned DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `id_staff` int(10) unsigned DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `jam_mengajar` int(11) DEFAULT 0,
  PRIMARY KEY (`id_jabatan_staff`) USING BTREE,
  KEY `jabatan_staff` (`id_staff`),
  KEY `ta_staff` (`id_ta`),
  CONSTRAINT `jabatan_staff` FOREIGN KEY (`id_staff`) REFERENCES `staff` (`id_staff`),
  CONSTRAINT `ta_staff` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajar` (`id_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of jabatan_staff
-- ----------------------------
BEGIN;
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (1, 4, '12-2023', 1, 'KEPALA SEKOLAH', 0);
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (2, 4, '12-2023', 2, 'GURU KELAS', 24);
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (3, 4, '12-2023', 3, 'GURU KELAS', 24);
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (4, 4, '12-2023', 6, 'GURU KELAS', 24);
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (5, 4, '12-2023', 7, 'GURU KELAS', 24);
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (6, 4, '12-2023', 4, 'GURU KELAS', 24);
INSERT INTO `jabatan_staff` (`id_jabatan_staff`, `id_ta`, `periode`, `id_staff`, `jabatan`, `jam_mengajar`) VALUES (7, 4, '12-2023', 5, 'GURU KELAS', 24);
COMMIT;

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id_kelas` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_staff` int(10) unsigned DEFAULT NULL,
  `id_sekolah` int(11) unsigned NOT NULL,
  `id_ta` int(11) unsigned NOT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `alias` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `tahun-ajar_kelas` (`id_ta`),
  KEY `sekolah_kelas` (`id_sekolah`),
  KEY `wali_kelas` (`id_staff`),
  CONSTRAINT `sekolah_kelas` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`),
  CONSTRAINT `tahun-ajar_kelas` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajar` (`id_ta`),
  CONSTRAINT `wali_kelas` FOREIGN KEY (`id_staff`) REFERENCES `staff` (`id_staff`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of kelas
-- ----------------------------
BEGIN;
INSERT INTO `kelas` (`id_kelas`, `id_staff`, `id_sekolah`, `id_ta`, `kelas`, `alias`) VALUES (1, 2, 3, 4, 'KELAS VI', 'VI');
INSERT INTO `kelas` (`id_kelas`, `id_staff`, `id_sekolah`, `id_ta`, `kelas`, `alias`) VALUES (3, 3, 3, 4, 'KELAS V', 'V');
INSERT INTO `kelas` (`id_kelas`, `id_staff`, `id_sekolah`, `id_ta`, `kelas`, `alias`) VALUES (4, 4, 3, 4, 'KELAS IV', 'IV');
INSERT INTO `kelas` (`id_kelas`, `id_staff`, `id_sekolah`, `id_ta`, `kelas`, `alias`) VALUES (5, 5, 3, 4, 'KELAS III', 'III');
INSERT INTO `kelas` (`id_kelas`, `id_staff`, `id_sekolah`, `id_ta`, `kelas`, `alias`) VALUES (6, 6, 3, 4, 'KELAS II', 'II');
INSERT INTO `kelas` (`id_kelas`, `id_staff`, `id_sekolah`, `id_ta`, `kelas`, `alias`) VALUES (7, 7, 3, 4, 'KELAS I', 'I');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2024_01_01_134701_create_permission_tables', 1);
COMMIT;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
BEGIN;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (2, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (2, 'App\\Models\\User', 5);
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'dashboard', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'view sekolah', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (3, 'profil sekolah', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (4, 'create sekolah', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (5, 'update sekolah', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (6, 'delete sekolah', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (7, 'view operator', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (8, 'update operator', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (9, 'delete operator', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (10, 'rekap absen', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (11, 'rekap sarpras', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (12, 'rekap siswa', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (13, 'view absen harian', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (14, 'view absen bulanan', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (15, 'tambah absen', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (16, 'update absen', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (17, 'delete absen', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (18, 'view sarpras', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (19, 'tambah sarpras', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (20, 'update sarpras', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (21, 'delete sarpras', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (26, 'view tahun ajar', 'web', '2024-02-26 05:56:13', '2024-02-26 05:56:18');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (27, 'view staff', 'web', '2024-02-26 05:59:48', '2024-02-26 05:59:53');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (28, 'create staff', 'web', '2024-02-26 06:00:26', '2024-02-26 06:00:28');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (29, 'update staff', 'web', '2024-02-26 06:00:42', '2024-02-26 06:00:44');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (30, 'delete staff', 'web', '2024-02-26 06:01:02', '2024-02-26 06:01:04');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (31, 'view jabatan', 'web', '2024-02-26 11:48:23', '2024-02-26 11:48:25');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (32, 'create jabatan', 'web', '2024-02-26 11:48:37', '2024-02-26 11:48:38');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (33, 'update jabatan', 'web', '2024-02-26 11:48:48', '2024-02-26 11:48:49');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (34, 'delete jabatan', 'web', '2024-02-26 11:48:59', '2024-02-26 11:49:01');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (35, 'view kelas', 'web', '2024-02-26 12:02:31', '2024-02-26 12:02:33');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (36, 'create kelas', 'web', '2024-02-26 12:02:44', '2024-02-26 12:02:46');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (37, 'update kelas', 'web', '2024-02-26 12:02:57', '2024-02-26 12:02:59');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (38, 'delete kelas', 'web', '2024-02-26 12:03:09', '2024-02-26 12:03:11');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (39, 'view siswa', 'web', '2024-02-26 12:08:43', '2024-02-26 12:08:45');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (40, 'view absensi', 'web', '2024-02-26 12:12:53', '2024-02-26 12:12:55');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (41, 'view absensi bulanan', 'web', '2024-02-26 12:20:47', '2024-02-26 12:20:49');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (42, 'create operator', 'web', '2024-02-26 12:20:42', '2024-02-26 12:20:44');
COMMIT;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
BEGIN;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (1, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (2, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (4, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (5, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (6, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (7, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (8, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (9, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (10, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (11, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (12, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (26, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (42, 1);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (3, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (13, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (14, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (15, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (16, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (17, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (18, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (19, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (20, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (21, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (27, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (28, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (29, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (30, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (31, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (32, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (33, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (34, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (35, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (36, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (37, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (38, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (39, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (40, 2);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (41, 2);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'admin', 'web', '2024-02-12 15:33:36', '2024-02-12 15:33:36');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'operator', 'web', '2024-02-12 15:33:37', '2024-02-12 15:33:37');
COMMIT;

-- ----------------------------
-- Table structure for sarpras
-- ----------------------------
DROP TABLE IF EXISTS `sarpras`;
CREATE TABLE `sarpras` (
  `id_sarpras` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sekolah` int(11) DEFAULT NULL,
  `id_ta` int(10) unsigned DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `ruang` varchar(255) DEFAULT NULL,
  `kondisi` enum('B','RR','RB') DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sarpras`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of sarpras
-- ----------------------------
BEGIN;
INSERT INTO `sarpras` (`id_sarpras`, `id_sekolah`, `id_ta`, `periode`, `ruang`, `kondisi`, `jumlah`) VALUES (1, 3, 4, '12-2023', 'Guru', 'RR', 1);
INSERT INTO `sarpras` (`id_sarpras`, `id_sekolah`, `id_ta`, `periode`, `ruang`, `kondisi`, `jumlah`) VALUES (2, 3, 4, '12-2023', 'Kepala Sekolah', 'B', 1);
INSERT INTO `sarpras` (`id_sarpras`, `id_sekolah`, `id_ta`, `periode`, `ruang`, `kondisi`, `jumlah`) VALUES (4, 3, 4, '12-2023', 'Aula', 'B', 1);
COMMIT;

-- ----------------------------
-- Table structure for sekolah
-- ----------------------------
DROP TABLE IF EXISTS `sekolah`;
CREATE TABLE `sekolah` (
  `id_sekolah` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(255) NOT NULL,
  `npsn_nsss` varchar(50) DEFAULT NULL,
  `tanggal_berdiri` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `status_tanah` varchar(50) DEFAULT NULL,
  `luas_tanah` float DEFAULT NULL,
  `luas_bangunan` float DEFAULT NULL,
  `luas_pekarangan` float DEFAULT NULL,
  `luas_kebun` varchar(255) DEFAULT NULL,
  `nip_pengawas` varchar(255) DEFAULT NULL,
  `nama_pengawas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_sekolah`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of sekolah
-- ----------------------------
BEGIN;
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (1, 'Nama Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (2, 'Williams Network Systems LLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (3, 'SDN 1 PERUMPUNG RAYA', '10605117/101110105117', NULL, 'PERUMPUNG RAYA', 'LALAN', 'MUSI BANYUASIN', 'SUMATERA SELATAN', 'TANAH NEGARA', 10000, 280, 7220, '2500', NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (4, 'Anderson\'s Consultants Inc.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (5, 'Wright\'s Communications LLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (6, 'Foster\'s Engineering LLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (7, 'Hall Telecommunication Inc.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (8, 'Alexander Consultants Inc.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (9, 'Matthew Software Inc.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (10, 'Ruiz LLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (11, 'Black Food Inc.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (12, 'Robin Engineering Inc.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (13, 'Annie Pharmaceutical LLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `npsn_nsss`, `tanggal_berdiri`, `alamat`, `kabupaten`, `kecamatan`, `provinsi`, `status_tanah`, `luas_tanah`, `luas_bangunan`, `luas_pekarangan`, `luas_kebun`, `nip_pengawas`, `nama_pengawas`) VALUES (14, 'Eugene Toy LLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for siswa
-- ----------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
  `id_siswa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ta` int(10) unsigned DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `id_kelas` int(10) unsigned DEFAULT NULL,
  `id_sekolah` int(10) unsigned DEFAULT NULL,
  `type` enum('awal','masuk','keluar','akhir') DEFAULT NULL,
  `l` int(11) DEFAULT NULL,
  `p` int(11) DEFAULT NULL,
  `warga_negara` enum('wni','wna') DEFAULT NULL,
  PRIMARY KEY (`id_siswa`) USING BTREE,
  KEY `tahun_siswa` (`id_ta`),
  KEY `kelas_sis` (`id_kelas`),
  KEY `sekolah` (`id_sekolah`),
  CONSTRAINT `kelas_sis` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  CONSTRAINT `sekolah` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`),
  CONSTRAINT `tahun_siswa` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajar` (`id_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of siswa
-- ----------------------------
BEGIN;
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (1, 4, '12-2023', 7, 3, 'awal', 14, 18, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (2, 4, '12-2023', 6, 3, 'awal', 6, 13, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (3, 4, '12-2023', 5, 3, 'awal', 8, 6, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (4, 4, '12-2023', 4, 3, 'awal', 12, 6, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (5, 4, '12-2023', 3, 3, 'awal', 8, 7, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (6, 4, '12-2023', 1, 3, 'awal', 13, 6, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (7, 4, '12-2023', 7, 3, 'awal', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (8, 4, '12-2023', 6, 3, 'awal', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (9, 4, '12-2023', 5, 3, 'awal', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (10, 4, '12-2023', 4, 3, 'awal', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (11, 4, '12-2023', 3, 3, 'awal', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (12, 4, '12-2023', 1, 3, 'awal', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (13, 4, '12-2023', 7, 3, 'keluar', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (14, 4, '12-2023', 6, 3, 'keluar', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (15, 4, '12-2023', 5, 3, 'keluar', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (16, 4, '12-2023', 4, 3, 'keluar', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (17, 4, '12-2023', 3, 3, 'keluar', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (18, 4, '12-2023', 1, 3, 'keluar', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (19, 4, '12-2023', 7, 3, 'keluar', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (20, 4, '12-2023', 6, 3, 'keluar', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (21, 4, '12-2023', 5, 3, 'keluar', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (22, 4, '12-2023', 4, 3, 'keluar', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (23, 4, '12-2023', 3, 3, 'keluar', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (24, 4, '12-2023', 1, 3, 'keluar', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (25, 4, '12-2023', 7, 3, 'masuk', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (26, 4, '12-2023', 6, 3, 'masuk', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (27, 4, '12-2023', 5, 3, 'masuk', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (28, 4, '12-2023', 4, 3, 'masuk', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (29, 4, '12-2023', 3, 3, 'masuk', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (30, 4, '12-2023', 1, 3, 'masuk', 0, 0, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (31, 4, '12-2023', 7, 3, 'masuk', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (32, 4, '12-2023', 6, 3, 'masuk', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (33, 4, '12-2023', 5, 3, 'masuk', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (34, 4, '12-2023', 4, 3, 'masuk', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (35, 4, '12-2023', 3, 3, 'masuk', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (36, 4, '12-2023', 1, 3, 'masuk', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (37, 4, '12-2023', 7, 3, 'akhir', 14, 18, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (38, 4, '12-2023', 6, 3, 'akhir', 6, 13, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (39, 4, '12-2023', 5, 3, 'akhir', 8, 6, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (40, 4, '12-2023', 4, 3, 'akhir', 12, 6, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (41, 4, '12-2023', 3, 3, 'akhir', 8, 7, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (42, 4, '12-2023', 1, 3, 'akhir', 13, 6, 'wni');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (43, 4, '12-2023', 7, 3, 'akhir', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (44, 4, '12-2023', 6, 3, 'akhir', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (45, 4, '12-2023', 5, 3, 'akhir', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (46, 4, '12-2023', 4, 3, 'akhir', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (47, 4, '12-2023', 3, 3, 'akhir', 0, 0, 'wna');
INSERT INTO `siswa` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`) VALUES (48, 4, '12-2023', 1, 3, 'akhir', 0, 0, 'wna');
COMMIT;

-- ----------------------------
-- Table structure for siswa_agama
-- ----------------------------
DROP TABLE IF EXISTS `siswa_agama`;
CREATE TABLE `siswa_agama` (
  `id_siswa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ta` int(10) unsigned DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `id_sekolah` int(10) unsigned DEFAULT NULL,
  `type` enum('awal','masuk','keluar','akhir') DEFAULT NULL,
  `l` int(11) DEFAULT NULL,
  `p` int(11) DEFAULT NULL,
  `warga_negara` enum('wni','wna') DEFAULT NULL,
  `agama` enum('ISLAM','KRISTEN','KATOLIK','HINDU','BUDHA','LAINNYA') DEFAULT NULL,
  PRIMARY KEY (`id_siswa`) USING BTREE,
  KEY `tahun_siswa` (`id_ta`),
  KEY `sekolah` (`id_sekolah`),
  CONSTRAINT `siswa_agama_ibfk_2` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`),
  CONSTRAINT `siswa_agama_ibfk_3` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajar` (`id_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of siswa_agama
-- ----------------------------
BEGIN;
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (1, 4, '12-2023', 3, 'awal', 59, 55, 'wni', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (2, 4, '12-2023', 3, 'awal', 2, 0, 'wni', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (3, 4, '12-2023', 3, 'awal', 0, 1, 'wni', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (4, 4, '12-2023', 3, 'awal', 0, 0, 'wni', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (5, 4, '12-2023', 3, 'awal', 0, 0, 'wni', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (6, 4, '12-2023', 3, 'awal', 0, 0, 'wni', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (7, 4, '12-2023', 3, 'awal', 0, 0, 'wna', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (8, 4, '12-2023', 3, 'awal', 0, 0, 'wna', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (9, 4, '12-2023', 3, 'awal', 0, 0, 'wna', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (10, 4, '12-2023', 3, 'awal', 0, 0, 'wna', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (11, 4, '12-2023', 3, 'awal', 0, 0, 'wna', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (12, 4, '12-2023', 3, 'awal', 0, 0, 'wna', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (13, 4, '12-2023', 3, 'keluar', 0, 0, 'wni', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (14, 4, '12-2023', 3, 'keluar', 0, 0, 'wni', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (15, 4, '12-2023', 3, 'keluar', 0, 0, 'wni', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (16, 4, '12-2023', 3, 'keluar', 0, 0, 'wni', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (17, 4, '12-2023', 3, 'keluar', 0, 0, 'wni', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (18, 4, '12-2023', 3, 'keluar', 0, 0, 'wni', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (19, 4, '12-2023', 3, 'keluar', 0, 0, 'wna', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (20, 4, '12-2023', 3, 'keluar', 0, 0, 'wna', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (21, 4, '12-2023', 3, 'keluar', 0, 0, 'wna', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (22, 4, '12-2023', 3, 'keluar', 0, 0, 'wna', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (23, 4, '12-2023', 3, 'keluar', 0, 0, 'wna', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (24, 4, '12-2023', 3, 'keluar', 0, 0, 'wna', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (25, 4, '12-2023', 3, 'masuk', 0, 0, 'wni', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (26, 4, '12-2023', 3, 'masuk', 0, 0, 'wni', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (27, 4, '12-2023', 3, 'masuk', 0, 0, 'wni', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (28, 4, '12-2023', 3, 'masuk', 0, 0, 'wni', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (29, 4, '12-2023', 3, 'masuk', 0, 0, 'wni', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (30, 4, '12-2023', 3, 'masuk', 0, 0, 'wni', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (31, 4, '12-2023', 3, 'masuk', 0, 0, 'wna', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (32, 4, '12-2023', 3, 'masuk', 0, 0, 'wna', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (33, 4, '12-2023', 3, 'masuk', 0, 0, 'wna', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (34, 4, '12-2023', 3, 'masuk', 0, 0, 'wna', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (35, 4, '12-2023', 3, 'masuk', 0, 0, 'wna', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (36, 4, '12-2023', 3, 'masuk', 0, 0, 'wna', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (37, 4, '12-2023', 3, 'akhir', 59, 55, 'wni', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (38, 4, '12-2023', 3, 'akhir', 2, 0, 'wni', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (39, 4, '12-2023', 3, 'akhir', 0, 1, 'wni', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (40, 4, '12-2023', 3, 'akhir', 0, 0, 'wni', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (41, 4, '12-2023', 3, 'akhir', 0, 0, 'wni', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (42, 4, '12-2023', 3, 'akhir', 0, 0, 'wni', 'LAINNYA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (43, 4, '12-2023', 3, 'akhir', 0, 0, 'wna', 'ISLAM');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (44, 4, '12-2023', 3, 'akhir', 0, 0, 'wna', 'KRISTEN');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (45, 4, '12-2023', 3, 'akhir', 0, 0, 'wna', 'KATOLIK');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (46, 4, '12-2023', 3, 'akhir', 0, 0, 'wna', 'HINDU');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (47, 4, '12-2023', 3, 'akhir', 0, 0, 'wna', 'BUDHA');
INSERT INTO `siswa_agama` (`id_siswa`, `id_ta`, `periode`, `id_sekolah`, `type`, `l`, `p`, `warga_negara`, `agama`) VALUES (48, 4, '12-2023', 3, 'akhir', 0, 0, 'wna', 'LAINNYA');
COMMIT;

-- ----------------------------
-- Table structure for siswa_umur
-- ----------------------------
DROP TABLE IF EXISTS `siswa_umur`;
CREATE TABLE `siswa_umur` (
  `id_siswa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ta` int(10) unsigned DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `id_kelas` int(10) unsigned DEFAULT NULL,
  `id_sekolah` int(10) unsigned DEFAULT NULL,
  `u5` int(11) DEFAULT NULL,
  `u6` int(11) DEFAULT NULL,
  `u7` int(11) DEFAULT NULL,
  `u8` int(11) DEFAULT NULL,
  `u9` int(11) DEFAULT NULL,
  `u10` int(11) DEFAULT NULL,
  `u11` int(11) DEFAULT NULL,
  `u12` int(11) DEFAULT NULL,
  `u13` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_siswa`) USING BTREE,
  KEY `tahun_siswa` (`id_ta`),
  KEY `kelas_sis` (`id_kelas`),
  KEY `sekolah` (`id_sekolah`),
  CONSTRAINT `siswa_umur_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  CONSTRAINT `siswa_umur_ibfk_2` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`),
  CONSTRAINT `siswa_umur_ibfk_3` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajar` (`id_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of siswa_umur
-- ----------------------------
BEGIN;
INSERT INTO `siswa_umur` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `u5`, `u6`, `u7`, `u8`, `u9`, `u10`, `u11`, `u12`, `u13`) VALUES (1, 4, '12-2023', 7, 3, 0, 0, 27, 5, 0, 0, 0, 0, 0);
INSERT INTO `siswa_umur` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `u5`, `u6`, `u7`, `u8`, `u9`, `u10`, `u11`, `u12`, `u13`) VALUES (2, 4, '12-2023', 6, 3, 0, 0, 0, 17, 2, 0, 0, 0, 0);
INSERT INTO `siswa_umur` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `u5`, `u6`, `u7`, `u8`, `u9`, `u10`, `u11`, `u12`, `u13`) VALUES (3, 4, '12-2023', 5, 3, 0, 0, 0, 3, 9, 2, 0, 0, 0);
INSERT INTO `siswa_umur` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `u5`, `u6`, `u7`, `u8`, `u9`, `u10`, `u11`, `u12`, `u13`) VALUES (4, 4, '12-2023', 4, 3, 0, 0, 0, 0, 4, 12, 2, 0, 0);
INSERT INTO `siswa_umur` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `u5`, `u6`, `u7`, `u8`, `u9`, `u10`, `u11`, `u12`, `u13`) VALUES (5, 4, '12-2023', 3, 3, 0, 0, 0, 0, 0, 13, 2, 0, 0);
INSERT INTO `siswa_umur` (`id_siswa`, `id_ta`, `periode`, `id_kelas`, `id_sekolah`, `u5`, `u6`, `u7`, `u8`, `u9`, `u10`, `u11`, `u12`, `u13`) VALUES (6, 4, '12-2023', 1, 3, 0, 0, 0, 0, 0, 0, 9, 10, 0);
COMMIT;

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id_staff` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sekolah` int(10) unsigned DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT 'L',
  `agama` enum('ISLAM','KRISTEN','KHATOLIK','HINDU','BUDHA') DEFAULT NULL,
  `golongan` enum('PENGATUR MUDA / II.A','PENGATUR MUDA TK. I / II.B','PENGATUR / II.C','PENGATUR TK. I / II.D','PENATA MUDA / III.A','PENATA MUDA TK. I / III.B','PENATA / III.C','PENATA TK. I / III.D','PEMBINA / IV.A','PEMBINA TK. I / IV.B','PEMBINA UTAMA MUDA / IV.C','PEMBINA UTAMA MADYA / IV.D','PEMBINA UTAMA / IV.E','IX','-') DEFAULT NULL,
  `tmt` varchar(255) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `bulan` int(11) DEFAULT NULL,
  `pendidikan` enum('SD','SMP','SMA','D-I','D-II','D-III','S-I','S-II') DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_staff`),
  KEY `sekolah_staff` (`id_sekolah`),
  CONSTRAINT `sekolah_staff` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of staff
-- ----------------------------
BEGIN;
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (1, 3, '198411282014071001', 'TUKINO, S.Pd', 'L', 'ISLAM', 'PENATA MUDA TK. I / III.B', '01/04/2023', 13, 3, 'S-I', 'PGSD', 'PNS');
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (2, 3, '196807031992111001', 'SLAMET WIDODO, S.Pd.SD', 'L', 'ISLAM', 'PEMBINA TK. I / IV.B', '01/10/2017', 20, 10, 'S-I', 'PGSD', 'PNS');
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (3, 3, '198106282014071001', 'SUPRIADI, S.Pd.SD', 'L', 'ISLAM', 'PENGATUR MUDA TK. I / II.B', '02/10/2017', 12, 9, 'S-I', 'PGSD', 'PNS');
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (4, 3, '197902202014071002', 'MANSUR, S.Pd.SD', 'L', 'ISLAM', 'PENGATUR MUDA TK. I / II.B', '01/04/2022', 13, 3, 'S-I', 'PGSD', 'PNS');
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (5, 3, '198206122021212001', 'SRI PURWATI, S.Pd', 'P', 'KHATOLIK', 'IX', '01/10/2021', 2, 7, 'S-I', 'PGSD', 'PKKK');
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (6, 3, '198106282014072001', 'TRI WAYUNIANTO, S.Pd', 'L', 'ISLAM', 'PENATA MUDA TK. I / III.B', '01/10/2021', 12, 9, 'S-I', 'PGSD', 'PNS');
INSERT INTO `staff` (`id_staff`, `id_sekolah`, `nip`, `nama`, `jk`, `agama`, `golongan`, `tmt`, `tahun`, `bulan`, `pendidikan`, `jurusan`, `status`) VALUES (7, 3, '197902202014072002', 'SURAJI, S.Pd.SD', 'L', 'ISLAM', 'PENATA MUDA TK. I / III.B', '01/04/2022', 13, 3, 'S-I', 'PGSD', 'PNS');
COMMIT;

-- ----------------------------
-- Table structure for tahun_ajar
-- ----------------------------
DROP TABLE IF EXISTS `tahun_ajar`;
CREATE TABLE `tahun_ajar` (
  `id_ta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tahun_ajar` varchar(50) NOT NULL,
  `periode` varchar(255) NOT NULL,
  PRIMARY KEY (`id_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of tahun_ajar
-- ----------------------------
BEGIN;
INSERT INTO `tahun_ajar` (`id_ta`, `tahun_ajar`, `periode`) VALUES (1, '2020/2021', '19/02/2024 - 19/02/2024');
INSERT INTO `tahun_ajar` (`id_ta`, `tahun_ajar`, `periode`) VALUES (2, '2021/2022', '01/06/2021 - 30/06/2022');
INSERT INTO `tahun_ajar` (`id_ta`, `tahun_ajar`, `periode`) VALUES (3, '2022/2023', '01/06/2022 - 30/06/2023');
INSERT INTO `tahun_ajar` (`id_ta`, `tahun_ajar`, `periode`) VALUES (4, '2023/2024', '19/02/2024 - 19/02/2024');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_sekolah` int(10) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `user_sekolah` (`id_sekolah`),
  CONSTRAINT `user_sekolah` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `email`, `id_sekolah`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Admin Korwil', 'admin@gmail.com', NULL, '2024-02-12 15:33:37', '$2y$10$fdya7Tmdw8x2/vPQWTJksOqNrSLD.5Jty1opA3ECV98aFyle7BE32', '3BAlcXHI3haMEL3uMmZD3Os08VpKBCanwYBzy1OW6sDr26jou4OvyOtElDJ7', '2024-02-12 15:33:37', '2024-02-12 15:33:37');
INSERT INTO `users` (`id`, `name`, `email`, `id_sekolah`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (3, 'Jhon Doe edit', 'jhondoe@gmail.com', 4, '2024-02-12 15:33:37', '$2y$10$hM2c8wFl9Ayumv6DM0.AoOIapgm05zkMKa83XfjWvLeOiHqjYPdza', '87upGQNADR', '2024-02-12 15:33:37', '2024-02-13 13:41:47');
INSERT INTO `users` (`id`, `name`, `email`, `id_sekolah`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (4, 'Operator', 'op@gmail.com', 3, '2024-02-12 15:50:59', '$2y$10$MupMRz3cE6PJMBRao/Jrz.lillj27TxhCfwCX7wjqYWcPCy0bFtdS', '6FbpIHnFuZGesxi6BFz90yluJyYXMT2hy0tybTBLrmjVOSdamfuGJREuObCm', '2024-02-12 15:50:59', '2024-02-16 18:39:31');
INSERT INTO `users` (`id`, `name`, `email`, `id_sekolah`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (5, 'Operator 2', 'op2@gmail.com', 2, '2024-02-13 13:46:46', '$2y$10$lkuPnniHerwiPL43TCB3eebZCLLywKFElvV0OLw.sX9nB/adz1J/S', 'LRCMT0EoET', '2024-02-13 13:46:46', '2024-02-13 13:46:46');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
