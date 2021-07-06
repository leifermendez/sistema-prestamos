-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `agent_has_client`
--

LOCK TABLES `agent_has_client` WRITE;
/*!40000 ALTER TABLE `agent_has_client` DISABLE KEYS */;
INSERT INTO `agent_has_client` VALUES (3,4,1),(3,5,1),(7,8,2),(7,9,2),(7,10,2),(7,11,2);
/*!40000 ALTER TABLE `agent_has_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `agent_has_supervisor`
--

LOCK TABLES `agent_has_supervisor` WRITE;
/*!40000 ALTER TABLE `agent_has_supervisor` DISABLE KEYS */;
INSERT INTO `agent_has_supervisor` VALUES (1,3,2,NULL,100000.00,1),(2,7,6,'2021-06-24 23:51:46',0.00,2);
/*!40000 ALTER TABLE `agent_has_supervisor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
INSERT INTO `audit` VALUES (1,1,'{\"name\":\"Administrador \",\"id\":1,\"email\":\"admin@admin.com\"}','update','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Inicio de sesión','2021-06-24 23:50:23',NULL),(2,3,'{\"created_at\":\"2021-06-25T06:50:46.843954Z\",\"payment_number\":\"30\",\"utility\":\"0.2\",\"amount_neto\":\"100\",\"id_user\":4,\"id_agent\":3,\"order_list\":1,\"user_name\":\"JORGE ARTURO REA\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cliente','2021-06-24 23:50:46',NULL),(3,3,'{\"created_at\":\"2021-06-25T06:51:05.209213Z\",\"payment_number\":\"30\",\"utility\":\"0.2\",\"amount_neto\":\"500\",\"id_user\":5,\"id_agent\":3,\"order_list\":2,\"user_name\":\"JOSE LOPEZ LOPEZ\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cliente','2021-06-24 23:51:05',NULL),(4,1,'{\"name\":\"madrid\",\"created_at\":\"2021-06-25T06:51:19.601273Z\",\"country\":\"1\",\"address\":\"MADRID\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cartera','2021-06-24 23:51:19',NULL),(5,7,'{\"created_at\":\"2021-06-25T06:58:53.062671Z\",\"payment_number\":\"30\",\"utility\":\"0.2\",\"amount_neto\":\"400\",\"id_user\":8,\"id_agent\":7,\"order_list\":3,\"user_name\":\"RBOERTO ROBERTO\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cliente','2021-06-24 23:58:53',NULL),(6,1,'{\"name\":\"Administrador \",\"id\":1,\"email\":\"admin@admin.com\"}','update','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Inicio de sesión','2021-06-28 13:03:20',NULL),(7,7,'{\"created_at\":\"2021-06-28T20:03:49.089668Z\",\"payment_number\":\"30\",\"utility\":\"0.2\",\"amount_neto\":\"444\",\"id_user\":9,\"id_agent\":7,\"order_list\":4,\"user_name\":\"JORGE ARTUROFAEFEA REA\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cliente','2021-06-28 13:03:49',NULL),(8,7,'{\"created_at\":\"2021-06-28T20:03:55.684266Z\",\"id_credit\":\"3\",\"id_user\":\"8\",\"user\":\"RBOERTO ROBERTO\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Pago saltado','2021-06-28 13:03:55',NULL),(9,7,'{\"created_at\":\"2021-06-28T20:05:28.843900Z\",\"payment_number\":\"30\",\"utility\":\"0.2\",\"amount_neto\":\"4545\",\"id_user\":10,\"id_agent\":7,\"order_list\":5,\"user_name\":\"JORGE ARTURO REA\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cliente','2021-06-28 13:05:28',NULL),(10,7,'{\"created_at\":\"2021-06-28T20:05:45.906790Z\",\"payment_number\":\"30\",\"utility\":\"0.2\",\"amount_neto\":\"6666\",\"id_user\":11,\"id_agent\":7,\"order_list\":6,\"user_name\":\"THTDHTDH HDTHTDH\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Cliente','2021-06-28 13:05:45',NULL),(11,1,'{\"name\":\"Administrador \",\"id\":1,\"email\":\"admin@admin.com\"}','update','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Inicio de sesión','2021-06-28 23:57:56',NULL),(12,3,'{\"created_at\":\"2021-06-29T08:19:13.224497Z\",\"id_credit\":\"1\",\"id_user\":\"4\",\"user\":\"JORGE ARTURO REA\"}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Pago saltado','2021-06-29 01:19:13',NULL),(13,3,'{\"credit_amount_neto\":100,\"credit_order_list\":1,\"credit_id_user\":4,\"credit_payment_number\":30,\"credit_utility\":0.2,\"credit_status\":\"inprogress\",\"user_name\":\"JORGE ARTURO\",\"amount\":\"4\",\"id_credit\":\"1\",\"id_agent\":3,\"created_at\":\"2021-06-29T08:55:09.000000Z\",\"number_index\":1}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Pago','2021-06-29 01:55:09',NULL),(14,3,'{\"credit_amount_neto\":100,\"credit_order_list\":1,\"credit_id_user\":4,\"credit_payment_number\":30,\"credit_utility\":0.2,\"credit_status\":\"inprogress\",\"user_name\":\"JORGE ARTURO\",\"amount\":\"4\",\"id_credit\":\"1\",\"id_agent\":3,\"created_at\":\"2021-06-29T08:56:13.000000Z\",\"number_index\":2}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Pago','2021-06-29 01:56:13',NULL),(15,3,'{\"credit_amount_neto\":500,\"credit_order_list\":2,\"credit_id_user\":5,\"credit_payment_number\":30,\"credit_utility\":0.2,\"credit_status\":\"inprogress\",\"user_name\":\"JOSE LOPEZ\",\"amount\":\"300\",\"id_credit\":\"2\",\"id_agent\":3,\"created_at\":\"2021-06-29T09:01:21.000000Z\",\"number_index\":1}','create','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Pago','2021-06-29 02:01:21',NULL),(16,1,'{\"name\":\"Administrador \",\"id\":1,\"email\":\"admin@admin.com\"}','update','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Inicio de sesión','2021-06-30 06:36:49',NULL),(17,1,'{\"name\":\"Administrador \",\"id\":1,\"email\":\"admin@admin.com\"}','update','{\"Dispositivo\":\"Escritorio\",\"Tipo\":\"WebKit\",\"Ip\":\"127.0.0.0\",\"plataforma\":\"Windows\",\"Direccion\":null,\"Mapa\":null,\"Coordenadas\":null}','Inicio de sesión','2021-06-30 06:37:17',NULL);
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `blacklists`
--

LOCK TABLES `blacklists` WRITE;
/*!40000 ALTER TABLE `blacklists` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `close_day`
--

LOCK TABLES `close_day` WRITE;
/*!40000 ALTER TABLE `close_day` DISABLE KEYS */;
/*!40000 ALTER TABLE `close_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `countrys`
--

LOCK TABLES `countrys` WRITE;
/*!40000 ALTER TABLE `countrys` DISABLE KEYS */;
INSERT INTO `countrys` VALUES (1,'Benin'),(2,'Ethiopia'),(3,'Nigeria');
/*!40000 ALTER TABLE `countrys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `credit`
--

LOCK TABLES `credit` WRITE;
/*!40000 ALTER TABLE `credit` DISABLE KEYS */;
INSERT INTO `credit` VALUES (1,100.00,1,4,3,30,0.20,NULL,'inprogress','2021-06-24 23:50:46',NULL),(2,500.00,2,5,3,30,0.20,NULL,'inprogress','2021-06-24 23:51:05',NULL),(3,400.00,3,8,7,30,0.20,NULL,'inprogress','2021-06-24 23:58:53',NULL),(4,444.00,4,9,7,30,0.20,NULL,'inprogress','2021-06-28 13:03:49',NULL),(5,4545.00,5,10,7,30,0.20,NULL,'inprogress','2021-06-28 13:05:28',NULL),(6,6666.00,6,11,7,30,0.20,NULL,'inprogress','2021-06-28 13:05:45',NULL);
/*!40000 ALTER TABLE `credit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `db_pending_pays`
--

LOCK TABLES `db_pending_pays` WRITE;
/*!40000 ALTER TABLE `db_pending_pays` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_pending_pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `list_bill`
--

LOCK TABLES `list_bill` WRITE;
/*!40000 ALTER TABLE `list_bill` DISABLE KEYS */;
INSERT INTO `list_bill` VALUES (1,'Gasolina'),(2,'Almuerzo'),(3,'Sueldo'),(4,'Sueldo Supervisor'),(5,'Recarga'),(6,'Aceite'),(7,'Moto'),(8,'Sistema'),(9,'Transito'),(10,'Arriendo'),(11,'Servicios'),(12,'Retiro de Caja'),(13,'Para otro Cobro'),(14,'Ajuste de Caja'),(15,'Deposito'),(16,'Policia');
/*!40000 ALTER TABLE `list_bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2017_12_03_000000_create_agent_has_supervisor_table',1),(2,'2017_12_03_000001_create_users_table',1),(3,'2017_12_03_000002_create_credit_table',1),(4,'2017_12_03_000003_create_agent_has_client_table',1),(5,'2017_12_03_000004_create_password_resets_table',1),(6,'2017_12_03_000005_create_route_table',1),(7,'2017_12_03_000006_create_migrations_table',1),(8,'2017_12_03_000007_create_summary_table',1),(9,'2017_12_03_000008_create_countrys_table',1),(10,'2017_12_03_000009_create_not_pay_table',1),(11,'2017_12_03_000010_create_users_has_route_table',1),(12,'2017_12_03_000011_create_payment_number_table',1),(13,'2017_12_03_000012_create_close_day_table',1),(14,'2017_12_03_000013_create_bills_table',1),(15,'2017_12_03_000014_create_list_bill_table',1),(16,'2017_12_03_000015_create_wallet_table',1),(17,'2021_04_23_024554_create_db_pending_pays_table',1),(18,'2021_04_30_085511_create_pending_pays_table',1),(19,'2021_05_01_151407_create_audit_table',1),(20,'2021_05_30_224119_create_db_blacklists_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `not_pay`
--

LOCK TABLES `not_pay` WRITE;
/*!40000 ALTER TABLE `not_pay` DISABLE KEYS */;
INSERT INTO `not_pay` VALUES (1,'2021-06-28 13:03:55',3,8);
/*!40000 ALTER TABLE `not_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `payment_number`
--

LOCK TABLES `payment_number` WRITE;
/*!40000 ALTER TABLE `payment_number` DISABLE KEYS */;
INSERT INTO `payment_number` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL),(3,3,NULL,NULL),(4,4,NULL,NULL),(5,5,NULL,NULL),(6,6,NULL,NULL),(7,7,NULL,NULL),(8,8,NULL,NULL),(9,9,NULL,NULL),(10,10,NULL,NULL),(11,11,NULL,NULL),(12,12,NULL,NULL),(13,13,NULL,NULL),(14,14,NULL,NULL),(15,15,NULL,NULL),(16,16,NULL,NULL),(17,17,NULL,NULL),(18,18,NULL,NULL),(19,19,NULL,NULL),(20,20,NULL,NULL),(21,21,NULL,NULL),(22,22,NULL,NULL),(23,23,NULL,NULL),(24,24,NULL,NULL),(25,25,NULL,NULL),(26,26,NULL,NULL),(27,27,NULL,NULL),(28,28,NULL,NULL),(29,29,NULL,NULL),(30,30,NULL,NULL);
/*!40000 ALTER TABLE `payment_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pending_pays`
--

LOCK TABLES `pending_pays` WRITE;
/*!40000 ALTER TABLE `pending_pays` DISABLE KEYS */;
/*!40000 ALTER TABLE `pending_pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
/*!40000 ALTER TABLE `route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `summary`
--

LOCK TABLES `summary` WRITE;
/*!40000 ALTER TABLE `summary` DISABLE KEYS */;
INSERT INTO `summary` VALUES (1,4.00,3,1,1,'2021-06-28 01:55:09',NULL),(2,4.00,3,1,2,'2021-06-26 01:56:13',NULL),(3,300.00,3,2,1,'2021-06-28 02:01:21',NULL);
/*!40000 ALTER TABLE `summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@admin.com','$2y$10$tmxdr5QN2FvIRv9hVnuudObbJf2NzTQ9V4o2MQtbrZCdkbrLr35W.','enabled',NULL,'admin',NULL,NULL,NULL,NULL,NULL,'good',NULL,NULL,NULL,NULL,NULL),(2,'Supervisor','supervisor@supervisor.com','$2y$10$MF..WFsbDv/L3ICeLUdVJusayvxeWRotb8wzUAWkpKwKTsuG6RZIa','enabled',NULL,'supervisor',NULL,NULL,NULL,NULL,NULL,'good',NULL,NULL,NULL,NULL,NULL),(3,'Agente','agente@agente.com','$2y$10$njhUbzLBAMiDxZkBbFKUSunwGSp6Sy5MTFd1NV8MvzQBUC2PSUFeG','enabled',NULL,'agent',NULL,NULL,NULL,NULL,NULL,'good',NULL,NULL,NULL,NULL,NULL),(4,'JORGE ARTURO','2323','YySac','enabled',NULL,'user','REA','LAGASCA, 26 - 1ER PISO DERECH','MADRID','3333','2323','good',NULL,NULL,NULL,NULL,NULL),(5,'JOSE LOPEZ','8765','scXBl','enabled',NULL,'user','LOPEZ','LAGASCA, 26 - 1ER PISO DERECH','MADRID','523519133385','8765','good',NULL,NULL,NULL,NULL,NULL),(6,'jorge vega','awslatinoamerica','$2y$10$5GRqe7wN6O1VPj9/sN.FyeNXrnN2LgGvV3aHFIvgwsmtYR51s7k1K','enabled',NULL,'supervisor',NULL,NULL,NULL,NULL,NULL,'good',NULL,NULL,NULL,NULL,NULL),(7,'COBRADOR2','cobrador2','$2y$10$98WwCPHhYcdqbyVgbaKppeJdq.cqf76GqNJuye8QXEeFWIBm9Tvam','enabled',NULL,'agent',NULL,'MADRID',NULL,NULL,NULL,'good',NULL,NULL,'Benin',NULL,'2021-06-24 23:51:46'),(8,'RBOERTO','33124142','JZG5H','enabled',NULL,'user','ROBERTO','LAGASCA, 26 - 1ER PISO DERECH','MADRID','523519133385','33124142','good',NULL,NULL,NULL,NULL,NULL),(9,'JORGE ARTUROFAEFEA','331241421','HfggB','enabled',NULL,'user','REA','LAGASCA, 26 - 1ER PISO DERECH','MADRID','eafeafeaf','331241421','good',NULL,NULL,NULL,NULL,NULL),(10,'JORGE ARTURO','33124142432434','hdnbj','enabled',NULL,'user','REA','LAGASCA, 26 - 1ER PISO DERECH','MADRID','3434','33124142432434','good',NULL,NULL,NULL,NULL,NULL),(11,'THTDHTDH','88678','gUrZ7','enabled',NULL,'user','HDTHTDH','HTDHTDHDTH','MADRID','35344343','88678','good',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users_has_route`
--

LOCK TABLES `users_has_route` WRITE;
/*!40000 ALTER TABLE `users_has_route` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_has_route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `wallet`
--

LOCK TABLES `wallet` WRITE;
/*!40000 ALTER TABLE `wallet` DISABLE KEYS */;
INSERT INTO `wallet` VALUES (1,'Caja principal',NULL,'1','Madrid'),(2,'madrid','2021-06-24 23:51:19','1','MADRID');
/*!40000 ALTER TABLE `wallet` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-06 16:38:30
