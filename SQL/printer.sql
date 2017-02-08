DROP TABLE IF EXISTS `printer`;
CREATE TABLE `printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(64) DEFAULT NULL,
  `make` varchar(64) DEFAULT NULL,
  `model` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `printer_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8