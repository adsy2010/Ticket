DROP TABLE IF EXISTS `desks`;
CREATE TABLE `desks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `desks_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8