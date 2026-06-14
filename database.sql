-- =============================================================
-- Campus Resource Tracking System (CRT)
-- Database Setup File
-- Run this entire file in phpMyAdmin > SQL tab > Click Go
-- =============================================================

-- Create and use the database (InfinityFree creates it for you,
-- so skip the CREATE DATABASE line and just run from SET onwards)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- -------------------------------------------------------------
-- Table: admin
-- Stores admin login credentials
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(50)  NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------------
-- Table: resources
-- Stores all campus resources
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `resources` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(100) NOT NULL,
  `type`        VARCHAR(50)  NOT NULL,
  `location`    VARCHAR(100) NOT NULL,
  `quantity`    INT(11)      NOT NULL DEFAULT 1,
  `status`      ENUM('Available','In Use','Maintenance') NOT NULL DEFAULT 'Available',
  `description` TEXT,
  `added_on`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------------
-- Default Admin Account
-- Username: admin
-- Password: admin123
-- (This is the bcrypt hash of "admin123")
-- -------------------------------------------------------------
INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '$2y$10$KIXtHJJRPMvq7RmNDMqzs.p5oCrnegotiations/placeholder');

-- NOTE: The hash above is a placeholder.
-- After uploading files, visit: yoursite.com/setup.php
-- That will insert the correct hash automatically.
-- Then DELETE setup.php from your server.

-- -------------------------------------------------------------
-- Sample Resources (10 examples for demo)
-- -------------------------------------------------------------
INSERT INTO `resources` (`name`, `type`, `location`, `quantity`, `status`, `description`) VALUES
('Computer Lab A',     'Lab',         'Block A, Floor 1', 40, 'Available',    'Windows 10 PCs with internet access'),
('Computer Lab B',     'Lab',         'Block B, Floor 2', 35, 'In Use',       'Linux workstations for programming'),
('Projector - Hall 1', 'Projector',   'Main Hall',         1, 'Available',    'HD projector, HDMI and VGA ports'),
('Projector - Hall 2', 'Projector',   'Seminar Room',      1, 'Maintenance',  'Under repair, available next week'),
('Classroom 101',      'Classroom',   'Block A, Floor 1', 60, 'Available',    'AC classroom with whiteboard'),
('Classroom 202',      'Classroom',   'Block B, Floor 2', 50, 'In Use',       'Lecture in progress'),
('Library',            'Library',     'Central Block',   120, 'Available',    'Open 8AM - 8PM on weekdays'),
('Sports Ground',      'Sports',      'Campus Ground',   200, 'Available',    'Football and cricket ground'),
('Laptop - Set 1',     'Laptop',      'IT Department',   15,  'Available',    'Dell laptops for student use'),
('Conference Room',    'Room',        'Admin Block',      20, 'Maintenance',  'Renovation in progress');
