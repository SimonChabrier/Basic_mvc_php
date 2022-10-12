-- Import MariaDB

CREATE TABLE `course` (
`id` INT AUTO_INCREMENT NOT NULL, 
`title` VARCHAR(150) NOT NULL,
`price` INT NOT NULL,
`duration` INT NOT NULL,
`short_description` VARCHAR(255) NOT NULL,
`description` LONGTEXT NOT NULL,
`picture` VARCHAR(50) NOT NULL,
`created_at` DATE NOT NULL,
`updated_at` DATE DEFAULT NULL,
`is_published` BOOLEAN NOT NULL,
PRIMARY KEY(id)
);


CREATE TABLE `user` (
`id` INT AUTO_INCREMENT NOT NULL, 
`username` VARCHAR(60) NOT NULL, 
`email` VARCHAR(60) NOT NULL, 
`password` VARCHAR(60) NOT NULL, 
`status` tinyint(1) DEFAULT NULL,
`role` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'ROLE_USER' COMMENT '(DC2Type:json)',
`created_at` date NOT NULL DEFAULT current_timestamp(),
`updated_at` date DEFAULT current_timestamp(),
PRIMARY KEY(id)
);


