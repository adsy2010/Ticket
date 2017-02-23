CREATE TABLE `printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make` varchar(64) DEFAULT NULL,
  `model` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `printer_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8