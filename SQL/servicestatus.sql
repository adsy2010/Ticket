DROP TABLE IF EXISTS `servicestatus`;
CREATE TABLE `servicestatus` (
  `name` varchar(128) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  UNIQUE KEY `serviceStatus_name_uindex` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8