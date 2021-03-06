CREATE TABLE `tickets` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `assignedTo` int(11) DEFAULT NULL,
  `closedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` blob,
  `contentType` varchar(64) DEFAULT NULL,
  `department` varchar(32) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `loggedBy` varchar(32) DEFAULT NULL,
  `serviceDesk` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ticketDatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closedBy` int(11) DEFAULT NULL,
  `closedWhy` varchar(256) DEFAULT NULL,
  `closedReason` varchar(64) DEFAULT NULL,
  `priority` int(11) DEFAULT '0',
  PRIMARY KEY (`logId`),
  UNIQUE KEY `tickets_logId_uindex` (`logId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8