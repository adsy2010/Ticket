CREATE TABLE `situatedprinter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printerId` int(11) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `exemption` int(11) DEFAULT '0',
  `costingdepartment` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8