
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES (1,'Maria Santos','maria.santos@example.com','0917-123-4567','2026-10-06 09:00:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES (2,'Juan Dela Cruz','juan.delacruz@example.com','0918-234-5678','2026-10-06 09:01:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES (3,'Angela Reyes','angela.reyes@example.com','0919-345-6789','2026-10-06 09:02:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES (4,'Mark Villanueva','mark.villanueva@example.com','0920-456-7890','2026-10-06 09:03:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES (5,'Katrina Bautista','katrina.bautista@example.com','0921-567-8901','2026-10-06 09:04:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES (6,'Ramon Tan','ramon.tan@example.com','0922-678-9012','2026-10-06 09:05:00');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES (1,'admin01','Patricia Gomez','2026-10-06 09:00:00');
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES (2,'cashier01','Jerome Aquino','2026-10-06 09:01:00');
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES (3,'cashier02','Liza Mendoza','2026-10-06 09:02:00');
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES (4,'stockclerk01','Noel Fernandez','2026-10-06 09:03:00');
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES (5,'manager01','Cristina Ramos','2026-10-06 09:04:00');
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`) VALUES (6,'super01','Vincent Cruz','2026-10-06 09:05:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

