CREATE TABLE `cartridge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `printerId` int(11) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `color` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cartridge_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8