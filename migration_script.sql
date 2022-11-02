-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: userlist_test
-- Source Schemata: userlist
-- Created: Wed Nov  2 15:38:13 2022
-- Workbench Version: 8.0.30
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema userlist_test
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `userlist_test` ;
CREATE SCHEMA IF NOT EXISTS `userlist_test` ;

-- ----------------------------------------------------------------------------
-- Table userlist_test.users
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `userlist_test`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(249) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `password` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_cs' NOT NULL,
  `username` VARCHAR(255) NULL DEFAULT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `verified` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `resettable` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` INT UNSIGNED NOT NULL DEFAULT '0',
  `registered` INT UNSIGNED NOT NULL,
  `last_login` INT UNSIGNED NULL DEFAULT NULL,
  `force_logout` MEDIUMINT UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email` (`email` ASC) VISIBLE)
ENGINE = MyISAM
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table userlist_test.users_confirmations
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `userlist_test`.`users_confirmations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `email` VARCHAR(249) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL,
  `selector` VARCHAR(16) CHARACTER SET 'latin1' COLLATE 'latin1_general_cs' NOT NULL,
  `token` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_cs' NOT NULL,
  `expires` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `selector` (`selector` ASC) VISIBLE,
  INDEX `email_expires` (`email` ASC, `expires` ASC) VISIBLE,
  INDEX `user_id` (`user_id` ASC) VISIBLE)
ENGINE = MyISAM
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table userlist_test.users_info
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `userlist_test`.`users_info` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `profession` VARCHAR(45) NULL DEFAULT NULL,
  `address` VARCHAR(45) NULL DEFAULT NULL,
  `phone` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `img` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- ----------------------------------------------------------------------------
-- Table userlist_test.users_remembered
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `userlist_test`.`users_remembered` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` INT UNSIGNED NOT NULL,
  `selector` VARCHAR(24) CHARACTER SET 'latin1' NOT NULL,
  `token` VARCHAR(255) CHARACTER SET 'latin1' NOT NULL,
  `expires` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `selector` (`selector` ASC) VISIBLE,
  INDEX `user` (`user` ASC) VISIBLE)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table userlist_test.users_resets
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `userlist_test`.`users_resets` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` INT UNSIGNED NOT NULL,
  `selector` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `token` VARCHAR(255) CHARACTER SET 'latin1' NOT NULL,
  `expires` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `selector` (`selector` ASC) VISIBLE,
  INDEX `user_expires` (`user` ASC, `expires` ASC) VISIBLE)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table userlist_test.users_throttling
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `userlist_test`.`users_throttling` (
  `bucket` VARCHAR(44) CHARACTER SET 'latin1' NOT NULL,
  `tokens` FLOAT UNSIGNED NOT NULL,
  `replenished_at` INT UNSIGNED NOT NULL,
  `expires_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`bucket`),
  INDEX `expires_at` (`expires_at` ASC) VISIBLE)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;
SET FOREIGN_KEY_CHECKS = 1;
