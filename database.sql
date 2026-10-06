CREATE DATABASE IF NOT EXISTS `pbl_ti_2025_3c_aldoahmadhirzi`;
USE `pbl_ti_2025_3c_aldoahmadhirzi`;

CREATE TABLE IF NOT EXISTS `account_type` (
  `id` VARCHAR(36) NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `actions` (
  `id` VARCHAR(36) NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` VARCHAR(36) NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(128) NOT NULL UNIQUE,
  `password` TEXT NOT NULL,
  `account_type_id` VARCHAR(36) NOT NULL,
  `status` VARCHAR(128) NOT NULL,
  `identification_number` VARCHAR(128) NOT NULL,
  `identification_type` ENUM('NIM', 'NIP') NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounts_account_type` (`account_type_id`),
  CONSTRAINT `fk_accounts_account_type` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `account_type` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('a011b98d-e43d-4c31-8935-71e16f31bf01', 'Admin', 'Pengelola sistem, punya akses penuh', '2026-10-02 10:04:00', NULL, NULL),
('a011b98d-e43d-4c31-8935-71e16f31bf02', 'Dosen', 'Akun untuk dosen (identitas NIP)', '2026-10-02 10:04:00', NULL, NULL),
('a011b98d-e43d-4c31-8935-71e16f31bf03', 'Mahasiswa', 'Akun untuk mahasiswa (identitas NIM)', '2026-10-02 10:04:00', NULL, NULL)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

INSERT INTO `actions` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('b011b98d-e43d-4c31-8935-71e16f31bf01', 'Create', 'Menambahkan data baru', '2026-10-02 10:04:00', NULL, NULL),
('b011b98d-e43d-4c31-8935-71e16f31bf02', 'Read', 'Melihat data', '2026-10-02 10:04:00', NULL, NULL),
('b011b98d-e43d-4c31-8935-71e16f31bf03', 'Update', 'Mengubah data yang sudah ada', '2026-10-02 10:04:00', NULL, NULL),
('b011b98d-e43d-4c31-8935-71e16f31bf04', 'Delete', 'Menghapus data (soft delete)', '2026-10-02 10:04:00', NULL, NULL)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `account_type_id`, `status`, `identification_number`, `identification_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
('c011b98d-e43d-4c31-8935-71e16f31bf01', 'Administrator', 'admin@it.pnj.ac.id', '$2y$10$ziF.kR0eiaVzU50JOpcN9.JWAQmPZJboOBzlsGiQXD86./elwTmbK', 'a011b98d-e43d-4c31-8935-71e16f31bf01', 'Aktif', '520000000000000746', 'NIP', '2026-10-02 10:04:00', NULL, NULL)
ON DUPLICATE KEY UPDATE `email`=VALUES(`email`);
