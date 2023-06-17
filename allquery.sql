DROP DATABASE IF EXISTS `smps`;
CREATE DATABASE IF NOT EXISTS `smps` DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
USE `smps`;

CREATE TABLE `admin` (
  `username` VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` CHAR(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT  INTO `admin`(`username`,`password`) VALUES 
('admin','31a556961f3438f9f632ca27812d22228e98e5083eea2bf9b78d0bb374d44deb0dc4d1bc16ab64127eb74e8452ea6902d97937c28310a7ab62a9ae1c15d96d69');

CREATE TABLE `peserta` (
  `email` VARCHAR(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohp` VARCHAR(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` CHAR(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `seminar` (
  `judul` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` TEXT COLLATE utf8mb4_unicode_ci,
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `waktu` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `peserta_seminar` (
  `id_seminar` INT(10) UNSIGNED NOT NULL,
  `email` VARCHAR(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_daftar` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hadir` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ps_seminar` (`id_seminar`),
  KEY `ps_peserta` (`email`),
  CONSTRAINT `ps_peserta` FOREIGN KEY (`email`) REFERENCES `peserta` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ps_seminar` FOREIGN KEY (`id_seminar`) REFERENCES `seminar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DELIMITER $$

CREATE PROCEDURE `add_peserta`(
	IN `email1` VARCHAR(70),
	IN `password1` CHAR(128),
	IN `nama1` VARCHAR(50),
	IN `nohp1` VARCHAR(20),
	IN `emailnow` VARCHAR(70),
	IN `gambar1` VARCHAR(100),
	IN `mode` TINYINT(1)
    )
BEGIN
		IF `mode` = 1 THEN
			INSERT INTO `peserta` SET
				`email` = `email1`,
				`password` = `password1`,
				`nama` = `nama1`,
				`gambar` = `gambar1`,
				`nohp` = `nohp1`;
		ELSE
			IF CHAR_LENGTH(`password1`) > 0 AND CHAR_LENGTH(`gambar1`) > 0 THEN
				UPDATE `peserta` SET
					`email` = `email1`,
					`password` = `password1`,
					`nama` = `nama1`,
					`gambar` = `gambar1`,
					`nohp` = `nohp1` 
				WHERE `email` = `emailnow`;
			ELSEIF CHAR_LENGTH(`password1`) = 0 AND CHAR_LENGTH(`gambar1`) > 0 THEN
				UPDATE `peserta` SET
					`email` = `email1`,
					`nama` = `nama1`,
					`gambar` = `gambar1`,
					`nohp` = `nohp1` 
				WHERE `email` = `emailnow`;
			ELSEIF CHAR_LENGTH(`password1`) > 0 AND CHAR_LENGTH(`gambar1`) = 0 THEN
				UPDATE `peserta` SET
					`email` = `email1`,
					`nama` = `nama1`,
					`password` = `password1`,
					`nohp` = `nohp1` 
				WHERE `email` = `emailnow`;
			ELSE
				UPDATE `peserta` SET
					`email` = `email1`,
					`nama` = `nama1`,
					`nohp` = `nohp1` 
				WHERE `email` = `emailnow`;
			END IF;
		END IF;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `add_peserta_seminar`(
	IN `id_seminar1` INT UNSIGNED,
	IN `email1` VARCHAR(70),
	IN `hadir1` TINYINT(1)
    )
BEGIN
		IF `hadir1` = 0 THEN
			INSERT INTO `peserta_seminar` SET
				`id_seminar` = `id_seminar1`,
				`email` = `email1`;
		ELSE
			UPDATE `peserta_seminar` SET `hadir` = 1 
				WHERE `id_seminar` = `id_seminar1` AND `email` = `email1`;
		END IF;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `add_seminar`(
	IN `judul1` VARCHAR(100),
	IN `keterangan1` TEXT,
	IN `waktu1` DATETIME,
	IN `idnow` INT UNSIGNED
    )
BEGIN
		IF `idnow` = 0
		THEN
			INSERT INTO `seminar` SET
				`judul` = `judul1`,
				`keterangan` = `keterangan1`,
				`waktu` = `waktu1`;
		ELSE
			UPDATE `seminar` SET
				`judul` = `judul1`,
				`keterangan` = `keterangan1`,
				`waktu` = `waktu1` 
			WHERE `id` = `idnow`;
		END IF;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `delete_peserta`(
	IN `email1` VARCHAR(70)
    )
BEGIN
		DELETE FROM `peserta` WHERE `email` = `email1`;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `delete_peserta_seminar`(
	IN `idnow` INT UNSIGNED,
	IN `hadir1` TINYINT(1)
    )
BEGIN
		IF `hadir1` = 0 THEN
			DELETE FROM `peserta_seminar` WHERE `id` = `idnow`;
		ELSE
			DELETE FROM `peserta_seminar` WHERE `hadir` = `hadir1`;
		END IF; 
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `delete_seminar`(
	IN `idnow` INT UNSIGNED,
	IN `mode` TINYINT(1)
    )
BEGIN
		IF `mode` <> 0 THEN
			DELETE FROM `seminar` WHERE `waktu` < (SELECT NOW());
		ELSE
			DELETE FROM `seminar` WHERE `id` = `idnow`;
		END IF;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `get_admin`(
	IN `uname` VARCHAR(20),
	IN `pass` CHAR(128) 
    )
BEGIN
		SELECT * FROM `admin` WHERE `username`=`uname` AND `password`=`pass`;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `get_count_peserta_seminar`()
BEGIN
		SELECT (SELECT COUNT(`email`) `peserta` FROM `peserta`) `peserta`,
			(SELECT COUNT(`id`) `seminar` FROM `seminar`) `seminar`;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `get_peserta`(
	IN `email` VARCHAR(70),
	IN `password` CHAR(128)
    )
BEGIN
		IF CHAR_LENGTH(`password`) = 0 AND CHAR_LENGTH(`email`) = 0
		THEN
			SELECT * FROM `peserta`;
		ELSEIF CHAR_LENGTH(`password`) = 0 AND CHAR_LENGTH(`email`) > 0
		THEN
			SELECT * FROM `peserta` `p` WHERE `p`.`email` = `email`;
		ELSE
			SELECT * FROM `peserta` `p` WHERE `p`.`email` = `email` AND `p`.`password` = `password`;
		END IF;
		
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `get_peserta_seminar`(
	IN `id_seminar1` INT UNSIGNED,
	IN `email1` VARCHAR(70)
    )
BEGIN
		IF `id_seminar1` = 0 AND CHAR_LENGTH(`email1`) = 0
		THEN
			SELECT `ps`.*, `s`.`judul`, `s`.`keterangan`, `s`.`waktu`, `p`.* 
				FROM `peserta_seminar` `ps` JOIN `seminar` `s` 
				ON `ps`.`id_seminar` = `s`.`id` JOIN `peserta` `p`
				ON `ps`.`email` = `p`.`email`;
		ELSEIF `id_seminar1` <> 0 AND CHAR_LENGTH(`email1`) = 0
		THEN
			SELECT `ps`.*, `s`.`judul`, `s`.`keterangan`, `s`.`waktu`, `p`.* 
				FROM `peserta_seminar` `ps` JOIN `seminar` `s` 
				ON `ps`.`id_seminar` = `s`.`id` JOIN `peserta` `p`
				ON `ps`.`email` = `p`.`email` 
				WHERE `ps`.`id_seminar` = `id_seminar1`;
		ELSEIF CHAR_LENGTH(`email1`) <> 0 AND `id_seminar1` = 0
		THEN
			SELECT `ps`.*, `s`.`judul`, `s`.`keterangan`, `s`.`waktu`, `p`.* 
				FROM `peserta_seminar` `ps` JOIN `seminar` `s` 
				ON `ps`.`id_seminar` = `s`.`id` JOIN `peserta` `p`
				ON `ps`.`email` = `p`.`email` 
				WHERE `ps`.`email` = `email1`;
		ELSE
			SELECT `ps`.*, `s`.`judul`, `s`.`keterangan`, `s`.`waktu`, `p`.* 
				FROM `peserta_seminar` `ps` JOIN `seminar` `s` 
				ON `ps`.`id_seminar` = `s`.`id` JOIN `peserta` `p`
				ON `ps`.`email` = `p`.`email` 
				WHERE `ps`.`email` = `email1` AND `ps`.`id_seminar` = `id_seminar1`;
		END IF;
	END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `get_seminar`(
	IN `id` INT
    )
BEGIN
		IF `id` = 0 THEN
			SELECT * FROM `seminar`;
		ELSE
			SELECT * FROM `seminar` `s` WHERE `s`.`id`=`id`;
		END IF;
	END $$
DELIMITER ;

