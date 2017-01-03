CREATE TABLE `cartridgelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cartridgeId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `actionedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost` double DEFAULT NULL,
  `archived` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cartridgeLog_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8