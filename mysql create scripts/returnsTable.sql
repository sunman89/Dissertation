CREATE TABLE `Returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` bigint(13) NOT NULL,
  `issue` int(2) NOT NULL,
  `return_quantity` int(11) DEFAULT NULL,
  `return_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_barcode_idx` (`barcode`),
  CONSTRAINT `fk_returns_barcode` FOREIGN KEY (`barcode`) REFERENCES `Products` (`barcode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1$$

