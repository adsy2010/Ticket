CREATE TABLE `authusers` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `emailAddress` varchar(128) DEFAULT NULL,
  `serviceDesk` int(11) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `authusers_userID_uindex` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8