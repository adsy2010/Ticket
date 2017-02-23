CREATE TABLE `cartridge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `printerId` int(11) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `color` varchar(24) DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cartridge_id_uindex` (`id`),
  UNIQUE KEY `cartridge_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8