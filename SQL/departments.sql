CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_department_uindex` (`department`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8