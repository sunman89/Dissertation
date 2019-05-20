CREATE TABLE `Deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` bigint(13) NOT NULL,
  `issue` int(2) NOT NULL,
  `delivered_quantity` int(11) DEFAULT NULL,
  `delivered_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_barcode_idx` (`barcode`),
  CONSTRAINT `fk_deliveries_barcode` FOREIGN KEY (`barcode`) REFERENCES `Products` (`barcode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1$$

