DROP TABLE IF EXISTS `ticketcomments`;
CREATE TABLE `ticketcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `logId` int(11) DEFAULT NULL,
  `commentDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` blob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticketComments_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8