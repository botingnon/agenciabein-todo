CREATE DATABASE IF NOT EXISTS `todo` 
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

SET default_storage_engine = INNODB;

USE todo;

CREATE TABLE `todo`.`task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
);
