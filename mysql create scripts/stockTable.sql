CREATE TABLE `Stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` bigint(13) NOT NULL,
  `issue` int(2) NOT NULL,
  `warehouse_stock` int(11) NOT NULL,
  `shop1_stock` int(11) NOT NULL,
  `shop2_stock` int(11) NOT NULL,
  `received_date` date NOT NULL,
  `return_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_barcode_idx` (`barcode`),
  CONSTRAINT `fk_barcode` FOREIGN KEY (`barcode`) REFERENCES `Products` (`barcode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1$$

