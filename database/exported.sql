CREATE DATABASE  IF NOT EXISTS `symptomschecker` ;
USE `symptomschecker`;
-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: symptomschecker
-- ------------------------------------------------------
-- Server version	8.0.25



--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `pat_id` int NOT NULL,
  `doc_id` int NOT NULL,
  `slot_id` int NOT NULL,
  `health_issue` varchar(255)  DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `probable_start_time` varchar(5)  NOT NULL,
  `actual_end_time` varchar(5)  NOT NULL,
  `patient_note` varchar(255)  DEFAULT 'Not Specified',
  `doctor_note` varchar(255)  DEFAULT 'Not Specified',
  `validator` varchar(45)  NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `doc_appointment_fk_idx` (`doc_id`),
  KEY `pat_appointment_fk_idx` (`pat_id`),
  CONSTRAINT `fk_appointment_doctor` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`doc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`pat_id`) REFERENCES `patients` (`pat_id`) ON DELETE CASCADE ON UPDATE CASCADE
)  ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,53,22,1,'Routine or follow-up visit','2021-06-04','1:00','2:00','','Getting Better\r\n','Friday 2021-06-04 1 1:00 PM'),(2,53,23,1,'Routine or follow-up visit','2021-06-11','1:00','2:00','','Not Specified','Friday 2021-06-11 1 1:00 PM'),(3,56,23,2,'I have a concern or question about my medication','2021-06-11','2:00','3:00','say something to your doctor','Getting better....','Friday 2021-06-11 2 2:00 PM'),(4,53,23,2,'My reason is not listed here','2021-06-14','2:00','3:00','Very Serious Issue','Not Specified','Monday 2021-06-14 2 2:00 PM'),(5,58,24,1,'Routine or follow-up visit','2021-06-07','1:00','2:00','','Not Specified','Monday 2021-06-07 1 1:00 PM'),(8,61,23,1,'My reason is not listed here','2021-06-16','1:00','2:00','mugies','Not Specified','Wednesday 2021-06-16 1 1:00 PM');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disease_symp`
--

DROP TABLE IF EXISTS `disease_symp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disease_symp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disease_name` varchar(45) DEFAULT NULL,
  `symptom` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disease_presc_idx` (`symptom`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disease_symp`
--

LOCK TABLES `disease_symp` WRITE;
/*!40000 ALTER TABLE `disease_symp` DISABLE KEYS */;
INSERT INTO `disease_symp` VALUES (1,'Covid','High temperature'),(2,'Covid','Continuous Cough Treatment'),(3,'Covid','Lost sense of taste'),(4,'Covid','Shortness of breath'),(5,'High blood pressure','Severe headaches'),(6,'High blood pressure','Nosebleed'),(7,'High blood pressure','Vision problem'),(8,'High blood pressure','Chest pain'),(9,'High blood pressure','Difficulty breathing'),(10,'High blood pressure','Blood in urine'),(11,'High heart rate','Stress or anxiety'),(12,'High heart rate','Heavy alcohol'),(13,'High heart rate','Heart disease'),(14,'Covid','Covid'),(15,'High blood pressure','High blood pressure'),(16,'High heart rate','High heart rate');
/*!40000 ALTER TABLE `disease_symp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doct_spec`
--

DROP TABLE IF EXISTS `doct_spec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doct_spec` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doc_id` int DEFAULT NULL,
  `spec_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1_idx` (`doc_id`),
  KEY `fk2_idx` (`spec_id`),
  CONSTRAINT `fk1` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`doc_id`) ON DELETE CASCADE,
  CONSTRAINT `fk2` FOREIGN KEY (`spec_id`) REFERENCES `specialization` (`spec_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doct_spec`
--

LOCK TABLES `doct_spec` WRITE;
/*!40000 ALTER TABLE `doct_spec` DISABLE KEYS */;
INSERT INTO `doct_spec` VALUES (1,22,8),(2,23,1),(3,24,4),(5,26,10);
/*!40000 ALTER TABLE `doct_spec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctors` (
  `doc_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(45)  NOT NULL,
  `lname` varchar(45)  NOT NULL,
  `phone` varchar(45)  DEFAULT NULL,
  `email` varchar(45)  NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`doc_id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (22,'Oliver','Seth','3100088880','oliver@bmc.co.uk','1992-01-01'),(23,'Usama','Arain','03113300054','usama@bmc.co.uk','1996-04-24'),(24,'Dean','Smith','031111333333','dean@bmc.co.uk','1996-04-17'),(26,'Humera','Arain','07588497772','humera@bmc.co.uk','1996-06-01');
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255)  NOT NULL,
  `token` varchar(255)  DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
)  ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `pat_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(45)  NOT NULL,
  `lname` varchar(45)  NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(45)  NOT NULL,
  `phone` varchar(15)  NULL,
  PRIMARY KEY (`pat_id`),
  UNIQUE KEY `phone_UNIQUE` (`phone`)
)  ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (53,'Ramon','Scott','1996-03-02','ramon@outlook.com','03113300054'),(56,'Mugies','Arain','2003-05-13','mugies@yahoo.com','03133381805'),(58,'Shahid','Arain','2003-04-16','shahid@outlook.com','03453598916'),(61,'Waqar','Shafqat','2003-03-12','waqar@outlook.com','07588497772');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doc_id` int NOT NULL,
  `day` varchar(15)  NOT NULL,
  `time_from` time NOT NULL,
  `time_till` time NOT NULL,
  `availability` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk3_idx` (`doc_id`),
  CONSTRAINT `fk3` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`doc_id`) ON DELETE CASCADE
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (1,22,'Monday','13:00:00','16:00:00',1),(2,22,'Tuesday','13:00:00','16:00:00',1),(3,22,'Wednesday','13:00:00','16:00:00',1),(4,22,'Thursday','13:00:00','16:00:00',1),(5,22,'Friday','13:00:00','16:00:00',1),(6,23,'Monday','13:00:00','16:00:00',1),(7,23,'Tuesday','13:00:00','16:00:00',1),(8,23,'Wednesday','13:00:00','16:00:00',1),(9,23,'Thursday','13:00:00','16:00:00',1),(10,23,'Friday','13:00:00','16:00:00',1),(11,24,'Monday','13:00:00','16:00:00',1),(12,24,'Tuesday','13:00:00','16:00:00',1),(13,24,'Wednesday','13:00:00','16:00:00',1),(14,24,'Thursday','13:00:00','16:00:00',1),(15,24,'Friday','13:00:00','16:00:00',1),(21,26,'Monday','13:00:00','16:00:00',1),(22,26,'Tuesday','13:00:00','16:00:00',1),(23,26,'Wednesday','13:00:00','16:00:00',1),(24,26,'Thursday','13:00:00','16:00:00',1),(25,26,'Friday','13:00:00','16:00:00',1);
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialization`
--

DROP TABLE IF EXISTS `specialization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialization` (
  `spec_id` int NOT NULL AUTO_INCREMENT,
  `specialization_name` varchar(100)  NOT NULL,
  PRIMARY KEY (`spec_id`)
)  ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialization`
--

LOCK TABLES `specialization` WRITE;
/*!40000 ALTER TABLE `specialization` DISABLE KEYS */;
INSERT INTO `specialization` VALUES (1,'Cardiologists'),(2,'Dermatologists'),(3,'Neurologist'),(4,'Heart'),(5,'Kidney'),(6,'Plastic Surgeon'),(7,'Medicine'),(8,'Bone'),(10,'General Physician');
/*!40000 ALTER TABLE `specialization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `symptoms_prescription`
--

DROP TABLE IF EXISTS `symptoms_prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `symptoms_prescription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `symptom` varchar(45) DEFAULT NULL,
  `prescription` longtext,
  PRIMARY KEY (`id`),
  KEY `fk_idx` (`symptom`),
  CONSTRAINT `fk` FOREIGN KEY (`symptom`) REFERENCES `disease_symp` (`symptom`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `symptoms_prescription`
--

LOCK TABLES `symptoms_prescription` WRITE;
/*!40000 ALTER TABLE `symptoms_prescription` DISABLE KEYS */;
INSERT INTO `symptoms_prescription` VALUES (1,'High temperature','Take your temperature and assess your symptoms. If your temperature runs 100.4°F (38°C) or higher, you have a fever.'),(2,'High temperature','Stay in bed and rest.'),(3,'High temperature','Keep hydrated. Drinking water, iced tea, or very diluted juice to replenish fluids lost through sweating. But if keeping liquids down is difficult, suck on ice chips.'),(4,'High temperature','Take over-the-counter medications like acetaminophen and ibuprofen to reduce fever. Note the proper dosage, and don’t them use alongside other fever-reducing medications. '),(5,'High temperature','Stay cool. Remove extra layers of clothing and blankets, unless you have the chills.'),(6,'Continuous Cough Treatment','Drink fluids. Liquid helps thin the mucus in your throat. Warm liquids, such as broth, tea or juice, can soothe your throat.'),(7,'Continuous Cough Treatment','Antihistamines, corticosteroids and decongestants. These drugs are standard treatment for allergies and postnasal drip.'),(8,'Continuous Cough Treatment','Inhaled asthma drugs. The most effective treatments for asthma-related cough are corticosteroids and bronchodilators, which reduce inflammation and open up your airways.'),(9,'Continuous Cough Treatment','Antibiotics. If a bacterial, fungal or mycobacterial infection is causing your chronic cough, your doctor may prescribe medications to address the infection.'),(10,'Lost sense of taste','quitting smoking. '),(11,'Lost sense of taste','improving dental hygiene by brushing, flossing, and using a medicated mouthwash daily.'),(12,'Lost sense of taste','using over-the-counter antihistamines or vaporizers to reduce inflammation in the nose.'),(13,'Shortness of breath','A commonly prescribed drug is ipatropium bromide (Atrovent®). Bronchodilators - These drugs work by opening (or dilating) the lung passages, and offering relief of symptoms, including shortness of breath. These drugs, typically given by inhalation (aerosol), but are also available in pill form.'),(14,'Severe headaches','Rest in a quiet, dark room.'),(15,'Severe headaches','Hot or cold compresses to your head or neck.'),(16,'Severe headaches','Massage and small amounts of caffeine.'),(17,'Severe headaches','Over-the-counter medications such as ibuprofen (Advil, Motrin IB, others), acetaminophen (Tylenol, others) and aspirin.'),(18,'Nosebleed','Sit down and pinch the soft parts of the nose firmly, breathe through the mouth.'),(19,'Nosebleed','Lean forward (not backward) to prevent blood from draining into the sinuses and throat, which can result in inhaling the blood or gagging.'),(20,'Nosebleed','Sit upright so that the head is higher than the heart; this reduces blood pressure and slows further bleeding.'),(21,'Nosebleed','Continue putting pressure on the nose, leaning forward, and sitting upright for a minimum of 5 minutes and up to 20 minutes, so that the blood clots. If bleeding persists for more than 20 minutes, medical attention is required.'),(22,'Nosebleed','Apply an ice pack to the nose and cheek to soothe the area and avoid strenuous activity for the next few days.'),(23,'Vision problem','An ophthalmologist to treat the eye disease causing the vision problems.'),(24,'Vision problem','An optometrist to manage the vision problems. This type of doctor can prescribe optical aids, such as special magnifiers.'),(25,'Vision problem','A physical therapist to help you with balance and walking problems, and to teach you how to use a cane if you need one.'),(26,'Vision problem','An occupational therapist to help you with normal daily activities and to teach you how to use optical aids.'),(27,'Vision problem','A social worker or therapist to help you cope with the emotional issues of vision loss.'),(28,'Chest pain','medications, which may include nitroglycerin and other medications that open partially closed arteries, clot-busting drugs, or blood thinners'),(29,'Chest pain','cardiac catheterization, which may involve using balloons or stents to open blocked arteries'),(30,'Chest pain','surgical repair of the arteries, which is also known as coronary artery bypass grafting or bypass surgery'),(31,'Difficulty breathing','A commonly prescribed drug is ipatropium bromide (Atrovent®). Bronchodilators - These drugs work by opening (or dilating) the lung passages, and offering relief of symptoms, including shortness of breath. These drugs, typically given by inhalation (aerosol), but are also available in pill form.'),(32,'Blood in urine','Your doctor will treat the condition that’s causing blood in your urine. Then, they’ll test you again to see if the blood is gone. If you still have blood in your urine, you may need more tests, or you may see a specialist called a urologist or nephrologist.'),(33,'Heart disease','Heart disease is the leading cause of death in the United States, causing about 1 in 4 deaths. The term “heart disease” refers to several types of heart conditions. In the United States, the most common type of heart disease is coronary artery disease (CAD), which can lead to heart attack. Following are the well known medications used'),(34,'Stress or anxiety','The most prominent of anti-anxiety drugs for the purpose of immediate relief are those known as benzodiazepines; among them are alprazolam (Xanax), clonazepam (Klonopin), chlordiazepoxide (Librium), diazepam (Valium), and lorazepam (Ativan).'),(35,'Heavy alcohol','A GP is a good place to start. They can discuss your problems with you and get you into treatment. They may offer you treatment at the practice or refer you to your local drug service. If you\'re not comfortable talking to a GP, you can approach your local drug treatment service yourself.'),(36,'High heart rate','Beta-blockers - can be used to slow down your heart rate, and improve blood flow through your body. You may take this drug if you have been diagnosed with irregular heartbeats, or high blood pressure. Some examples of this medication may include: Metoprolol (Lopressor®), propanolol (Inderal®), and atenolol (Tenormin®).'),(38,'High blood pressure','ACE inhibitors – such as enalapril, lisinopril, perindopril and ramipril'),(39,'High blood pressure','angiotensin-2 receptor blockers (ARBs) – such as candesartan, irbesartan, losartan, valsartan and olmesartan'),(40,'High blood pressure','calcium channel blockers – such as amlodipine, felodipine and nifedipine or diltiazem and verapamil'),(41,'High blood pressure','diuretics – such as indapamide and bendroflumethiazide'),(42,'High blood pressure','beta blockers – such as atenolol and bisoprolol'),(43,'High blood pressure','alpha blockers – such as doxazosin'),(44,'High blood pressure','other diuretics – such as amiloride and spironolactone'),(45,'Covid','There are things you can do to treat mild symptoms of coronavirus (COVID-19) while you’re staying at home (self-isolating).'),(46,'Covid','If you have a high temperature:'),(47,'Covid','get lots of rest'),(48,'Covid','drink plenty of fluids (water is best) to avoid dehydration – drink enough so your pee is light yellow and clear'),(49,'Covid','take paracetamol or ibuprofen if you feel uncomfortable'),(50,'Covid','If you have a cough:'),(51,'Covid','avoid lying on your back – lie on your side or sit upright instead'),(52,'Covid','try having a teaspoon of honey – but do not give honey to babies under 12 months'),(53,'Covid','If you feel breathless:'),(54,'Covid','keep your room cool by turning the heating down or opening a window – do not use a fan as it may spread the virus'),(55,'Covid','sit upright in a chair and relax your shoulders'),(56,'Covid','try breathing slowly in through your nose and out through your mouth, with your lips together like you\'re gently blowing out a candle'),(57,'Blood in urine','If your doctor can’t find a cause during the first evaluation, they might tell you to have follow-up urine testing and blood pressure monitoring every 3 to 6 months, especially if you have risk factors for bladder cancer. These include being 50 or older, smoking cigarettes and coming into contact with certain industrial chemicals.'),(58,'Heart disease','Benazepril (Lotensin)'),(59,'Heart disease','Captopril (Capoten)'),(60,'Heart disease','Enalapril (Vasotec)'),(61,'Heart disease','Fosinopril (Monopril)');
/*!40000 ALTER TABLE `symptoms_prescription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(10)  NOT NULL,
  `lastname` varchar(10)  NOT NULL,
  `email` varchar(255)  NOT NULL,
  `password_hash` varchar(255)  NOT NULL,
  `role` tinyint(1) DEFAULT '0' COMMENT 'This field store different roles each individual has.\\n\\nTotal roles are\\n1) Use (0)r/Patient(1)\\n2) Doctors(2)\\n3) Admin',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_access` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Oliver','Seth','oliver@bmc.co.uk','$2y$10$o8QZw/v1UVP8zk4EENx8yuBAKVejy1l.Zsc/BMw6A.AJiKtLWjWeu',1,'2021-06-03 10:58:19','2021-06-04 01:17:59'),(2,'Ramon','Scott','ramon@outlook.com','$2y$10$pebYAqLas6AzusLI9jt2leiTaeTwRiYsl0qxdWu8S7UXzawQ4oiKm',0,'2021-06-03 11:24:49','2021-06-04 01:20:15'),(3,'Usama','Arain','usama@bmc.co.uk','$2y$10$2IDYKpG27j/x0BewcGh7KeCkE5XBg5.SKSyvKm693iO8T1Bv/In/W',1,'2021-06-03 14:17:19','2021-06-04 03:05:39'),(4,'Mugies','Arain','mugies@yahoo.com','$2y$10$f2CnS0perjtj7Ds3M4LVx.fnuuoIFGxKmZtbRkUCNuH/TeDVAiMrG',0,'2021-06-04 01:01:02','2021-06-04 01:01:18'),(5,'Admin','','admin@bmc.co.uk','$2y$10$bMKhwEhYgfAMyMem6YSd0.pXyVAkh2meblRv5Wgp1d5Q.T.SU1zpm',2,'2021-06-04 01:12:16','2021-06-04 03:07:53'),(6,'Dean','Smith','dean@bmc.co.uk','$2y$10$DGgqb0J0ujXn6CnOGBYE4ugZLpC5u.RNB3VfWSw9O8rLiKaw54zTG',1,'2021-06-04 01:13:18','2021-06-04 01:15:44'),(7,'Shahid','Arain','shahid@outlook.com','$2y$10$8A8sxNW0pXtD6PcmI8tRb.4oMAuD3WLsvxDPw9SwLVa8De5JKtuxC',0,'2021-06-04 01:22:44','2021-06-04 01:22:48'),(8,'Waqar','Shafqat','waqar@outlook.com','$2y$10$6NiqDrcMXouqGFwWjp6CnOq6v3IGDjqcK1hcPyi67Ez55d6aEOafK',0,'2021-06-04 02:31:43','2021-06-04 02:32:14'),(9,'Humera','Arain','humera@bmc.co.uk','$2y$10$snQB4qF6jRGMkCtAPwWixuAM9mcPqdiVqJnETTtQdemtXPEX2X5ta',1,'2021-06-04 02:51:09','2021-06-04 03:02:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-04  3:30:11
