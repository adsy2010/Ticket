DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `desk` int(11) DEFAULT NULL,
  `statusType` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8