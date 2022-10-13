/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `detail_transaksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_produk` bigint(20) unsigned DEFAULT NULL,
  `id_transaksi` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_produk` (`id_produk`),
  KEY `id_transaksi` (`id_transaksi`),
  CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`),
  CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `produk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `transaksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO `detail_transaksi` (`id`, `id_produk`, `id_transaksi`) VALUES
(68, 1, 1);
INSERT INTO `detail_transaksi` (`id`, `id_produk`, `id_transaksi`) VALUES
(69, 3, 1);
INSERT INTO `detail_transaksi` (`id`, `id_produk`, `id_transaksi`) VALUES
(70, 4, 1);
INSERT INTO `detail_transaksi` (`id`, `id_produk`, `id_transaksi`) VALUES
(71, 2, 2),
(72, 3, 2),
(73, 5, 2),
(74, 1, 3),
(75, 2, 3),
(76, 3, 3),
(77, 5, 3),
(78, 2, 4),
(79, 5, 4);

INSERT INTO `produk` (`id`, `nama`) VALUES
(1, '1');
INSERT INTO `produk` (`id`, `nama`) VALUES
(2, '2');
INSERT INTO `produk` (`id`, `nama`) VALUES
(3, '3');
INSERT INTO `produk` (`id`, `nama`) VALUES
(4, '4'),
(5, '5');

INSERT INTO `transaksi` (`id`, `tanggal`) VALUES
(1, '2022-09-10');
INSERT INTO `transaksi` (`id`, `tanggal`) VALUES
(2, '2022-09-11');
INSERT INTO `transaksi` (`id`, `tanggal`) VALUES
(3, '2022-09-12');
INSERT INTO `transaksi` (`id`, `tanggal`) VALUES
(4, '2022-09-13');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;