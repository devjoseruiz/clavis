
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
--
-- Database structure
--
-- --------------------------------------------------------

--
-- Table structure for `users`
--
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for `groups`
--
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for `subjects`
--
CREATE TABLE `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for `groups_subjects` (relationship table)
--
CREATE TABLE `groups_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_group` int NOT NULL,
  `id_subject` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_subject_unique` (`id_group`, `id_subject`),
  CONSTRAINT `fk_gs_group` FOREIGN KEY (`id_group`) 
    REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gs_subject` FOREIGN KEY (`id_subject`) 
    REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for `subjects_teachers` (relationship table)
--
CREATE TABLE `subjects_teachers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_subject` int NOT NULL,
  `id_teacher` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subject_teacher_unique` (`id_subject`, `id_teacher`),
  CONSTRAINT `fk_st_subject` FOREIGN KEY (`id_subject`) 
    REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_st_teacher` FOREIGN KEY (`id_teacher`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for `lessons`
--
CREATE TABLE `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_teacher` int NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `available_on` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_lesson_teacher` FOREIGN KEY (`id_teacher`) 
    REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `movements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` ENUM('income', 'expense') NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=12;

--
-- Table structure for `options`
--
CREATE TABLE `options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option` (`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=16;

COMMIT;
