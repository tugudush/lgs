/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : lgs

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-05-21 12:17:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `books`
-- ----------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `book_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `qty` int(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `unique_isbn` (`isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of books
-- ----------------------------
INSERT INTO `books` VALUES ('2', null, 'Fifty Shades of Grey', 'E. L. James', 'erotic', '2011', '500', '4');
INSERT INTO `books` VALUES ('3', null, 'Thirteen Reasons Why', 'Jay Asher', null, '2007', '500', '4');
INSERT INTO `books` VALUES ('4', null, 'The Da Vinci Code', 'Dan Brown', 'fiction', '2003', '500', '3');
INSERT INTO `books` VALUES ('7', null, 'Business Mathematics', 'Norma D. Lopez Mariano, Ph.D', 'Mathematics', '2001', '500', '7');
INSERT INTO `books` VALUES ('8', null, 'Business Ethics and Social Responsibility', 'Aliza Racelis', null, '2000', '500', '4');
INSERT INTO `books` VALUES ('9', null, 'A Teaching Handbook on Asking Questions', 'Manuel Garcia', 'Education', '1999', '500', '4');
INSERT INTO `books` VALUES ('10', null, 'Strategic Planning in Education : Making Change Happen', 'Dr. Eusebio F. Miclat, Jr.', 'Education', '1999', '500', '4');
INSERT INTO `books` VALUES ('11', null, 'Tourism Marketing (OBE Aligned)', 'Maricel Gatchalian-Badilla', 'Marketitng', '2000', '500', '2');
INSERT INTO `books` VALUES ('12', null, 'Life Works and Writings', 'Gregorio F. Zaide', 'history', '1990', '500', '5');
INSERT INTO `books` VALUES ('13', null, 'How to Lie With Statistics', 'Darrell Huff', 'Mathematics', '1990', '500', '4');
INSERT INTO `books` VALUES ('14', null, 'The Study Of Philippine History', 'Rebecca R. Ongsotto', 'history', '1990', '500', '4');
INSERT INTO `books` VALUES ('15', null, 'The Law on Transfer and Business Taxation', 'Hector S. De Leon, Hector M. De Leon, Jr.', 'Law', '2000', '500', '0');
INSERT INTO `books` VALUES ('16', null, 'Tax Digest', 'Crescencio P. Co Untian, Jr.', 'Law', '1998', '500', '3');
INSERT INTO `books` VALUES ('17', null, 'Law on Sales', 'Cesar L. Villanueva', 'Law', '2004', '500', '5');
INSERT INTO `books` VALUES ('19', null, 'Principles of Teaching I', 'Acero', 'Education', '1999', '500', '2');
INSERT INTO `books` VALUES ('20', null, 'Application Software', 'Engr. Fautisno D. Reyes II', null, '2003', '500', '5');
INSERT INTO `books` VALUES ('21', null, 'Teaching Computer for Secondary and Tertiary Levels', 'Casiano, M.﻿', null, '2001', '500', '1');
INSERT INTO `books` VALUES ('22', null, 'Mathematical Analysis', 'Anonio Roland I. CoPo et. Al', 'Mathematics', '2007', '500', '4');
INSERT INTO `books` VALUES ('23', null, 'The Best of Marketing Rx', 'Dr. Ned Roberto', 'Marketing', '2009', '500', '2');
INSERT INTO `books` VALUES ('24', null, 'Management Accounting 1', 'Leonardo Aliling; Flordeliza Anastacio\r\nLeonardo Aliling', 'Marketing', '2010', '500', '4');
INSERT INTO `books` VALUES ('25', null, 'Principles of Marketing', 'A.B. Ilano', 'Marketing', '2011', '500', '3');
INSERT INTO `books` VALUES ('39', null, 'Principles of Teaching 2', 'Acero', 'Education', '1999', '500', '1');
INSERT INTO `books` VALUES ('41', null, 'Earth and Life Science', 'CENGAGE', 'Science', '2000', '500', '3');
INSERT INTO `books` VALUES ('43', null, 'The Law on Business Organization', 'J. Torres﻿', 'Law', '2008', '500', '3');
INSERT INTO `books` VALUES ('45', null, 'Acctg. Principles and Procedures Sole Prop. Vol. I-Servicing', 'Galanza, R.M.﻿', 'Accounting', '2009', '500', '2');
INSERT INTO `books` VALUES ('47', null, 'Rizal, The Greatest Filipino Hero', 'A Purino', 'History', '2000', '500', '7');
INSERT INTO `books` VALUES ('50', null, 'Jose P. Rizal: Isang Aklat sa Pandalubhasaang Kurso', 'Adanza, et al﻿', 'History', '2005', '500', '3');
INSERT INTO `books` VALUES ('58', '9789718161760', 'Lakompake! Ang Babaeng Bukod na Pinagpala sa Lahat', 'Senyora', 'Comedy', '2017', '2000', '6');

-- ----------------------------
-- Table structure for `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `log_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(6) NOT NULL,
  `student_id` int(6) NOT NULL,
  `borrowed_datetime` datetime DEFAULT NULL,
  `returned_datetime` datetime DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'borrowed',
  `paid` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES ('6', '20', '75', '2017-04-03 11:20:00', '2017-04-04 04:30:00', 'returned', '');
INSERT INTO `logs` VALUES ('7', '58', '75', '2017-05-01 11:22:00', '2017-05-08 11:22:00', 'returned', 'yes');
INSERT INTO `logs` VALUES ('9', '2', '75', '2017-05-15 11:23:00', null, 'borrowed', null);

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'editable_date', 'yes');

-- ----------------------------
-- Table structure for `students`
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `student_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `id_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `unique_id_no` (`id_no`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES ('1', '201310965', 'Pia Mae', null, 'Beltran', 'BSN');
INSERT INTO `students` VALUES ('2', '201310966', 'Mary Jane', null, 'Bartolome', 'BSM');
INSERT INTO `students` VALUES ('3', '201510950', 'Margarita', null, 'Panganiban', 'ABCOMM');
INSERT INTO `students` VALUES ('4', '201510951', 'Nikko', null, 'Hilado', 'BSED');
INSERT INTO `students` VALUES ('6', '201510970', 'John Paul', null, 'Respicio', 'ACT');
INSERT INTO `students` VALUES ('7', '201510971', 'Jaron', null, 'Napoles', 'BSCS');
INSERT INTO `students` VALUES ('8', '201510973', 'John Christan', null, 'Guinto', 'BSIT');
INSERT INTO `students` VALUES ('9', '201410969', 'Mary Jane', null, 'Araneta', 'BSTM');
INSERT INTO `students` VALUES ('10', '201410970', 'Rushellyn', null, 'Caharian', 'BSHRM');
INSERT INTO `students` VALUES ('11', '201410971', 'Richard', null, 'Muit', 'BSBA');
INSERT INTO `students` VALUES ('12', '201510863', 'Jaypee', null, 'Sario', 'ACT');
INSERT INTO `students` VALUES ('13', '201510864', 'Aaron Johnpaul', null, 'Anunciocon', 'ACT');
INSERT INTO `students` VALUES ('14', '201510865', 'Jenriel', null, 'Acosidsid', 'ACT');
INSERT INTO `students` VALUES ('15', '201510866', 'Chainz', null, 'Diokno', 'BSN');
INSERT INTO `students` VALUES ('16', '201510867', 'Kyle', null, 'Dominguez', 'BSHRM');
INSERT INTO `students` VALUES ('17', '201510868', 'Jaycee', null, 'Marcelino', 'BSBA');
INSERT INTO `students` VALUES ('18', '201510869', 'Jayvee', null, 'Marcelino', 'BSBA');
INSERT INTO `students` VALUES ('19', '201510870', 'Jerico', null, 'Matias', 'ACT');
INSERT INTO `students` VALUES ('20', '201510871', 'Julius', null, 'Perez', 'ACT');
INSERT INTO `students` VALUES ('21', '201510892', 'Mary Joy', null, 'Elbambo', 'BSIT');
INSERT INTO `students` VALUES ('22', '201610892', 'Kristal Joy', null, 'Maya', 'BSIT');
INSERT INTO `students` VALUES ('23', '201410893', 'Rafael', null, 'Palapar', 'BSIT');
INSERT INTO `students` VALUES ('24', '201510894', 'Raymark', null, 'Maliao', 'BSCS');
INSERT INTO `students` VALUES ('25', '201310865', 'Grace', null, 'Landringan', 'BSIT');
INSERT INTO `students` VALUES ('26', '201410865', 'Vanessa', null, 'Ejan', 'BSN');
INSERT INTO `students` VALUES ('27', '201310866', 'Ghara', null, 'Escobal', 'BSN');
INSERT INTO `students` VALUES ('28', '201410867', 'Olga', null, 'Orencia', 'BSN');
INSERT INTO `students` VALUES ('30', '201410869', 'Tey', null, 'Miguel', 'BSN');
INSERT INTO `students` VALUES ('31', '201510872', 'Lester', null, 'Samonte', 'BSIT');
INSERT INTO `students` VALUES ('32', '201510873', 'Arnel', null, 'Arquero', 'BSCS');
INSERT INTO `students` VALUES ('33', '201510874', 'Aaron Paul', null, 'Trivinio', 'BSCS');
INSERT INTO `students` VALUES ('34', '201510875', 'France', null, 'Ignacio', 'ACT');
INSERT INTO `students` VALUES ('35', '201510876', 'Christian', null, 'Delapaz', 'BSHRM');
INSERT INTO `students` VALUES ('36', '201510877', 'Lalaine', null, 'Espirito', 'BSBA');
INSERT INTO `students` VALUES ('37', '201510878', 'Niks', null, 'Hilads', 'BSED');
INSERT INTO `students` VALUES ('38', '201510879', 'Rizza', null, 'Padua', 'BSED');
INSERT INTO `students` VALUES ('39', '201510880', 'Jenny', null, 'De Leon', 'BSED');
INSERT INTO `students` VALUES ('40', '201510881', 'Mark', null, 'Ayala', 'ABCOMM');
INSERT INTO `students` VALUES ('41', '201510882', 'Dante', null, 'Zaragoza', 'ACT');
INSERT INTO `students` VALUES ('43', '201510884', 'Aalliyah Joyce', null, 'Cruz', 'BSN');
INSERT INTO `students` VALUES ('44', '201510885', 'Princess', null, 'Isidro', 'ABCOMM');
INSERT INTO `students` VALUES ('45', '201510886', 'Jheojienes', null, 'Cielo', 'BSTM');
INSERT INTO `students` VALUES ('46', '201510887', 'Ralph', null, 'Dela Cruz', 'BSIT');
INSERT INTO `students` VALUES ('47', '201510888', 'Zamaira', null, 'Cosina', 'BSIT');
INSERT INTO `students` VALUES ('48', '201510889', 'Jerome', null, 'Saldua', 'BSCS');
INSERT INTO `students` VALUES ('49', '201510890', 'Jannela', null, 'Galindez', 'BSBA');
INSERT INTO `students` VALUES ('50', '201510891', 'Lea', null, 'Repolido', 'ACT');
INSERT INTO `students` VALUES ('72', '2016-1234', 'Jocelyn', null, 'Ducena', 'BEED');
INSERT INTO `students` VALUES ('75', '20040395', 'Jerome', 'Mortejo', 'Gomez', 'BSIT');
INSERT INTO `students` VALUES ('76', '20040396', 'Jocelyn', 'Jocelyn', 'Ducena', 'BEED');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '$2y$10$VlX7Y2kkpfuS.GKHouQsQ.h7JbJj0jY8qO4x7rRK5ytpwlLvivh/a', 'admin', '1');
INSERT INTO `users` VALUES ('2', 'guest', '$2y$10$J8QOaTGfabUtSlWaAUa.xejzC4ZTBqVEX9thxPz0a2XII0izzR9uu', 'guest', '1');
INSERT INTO `users` VALUES ('16', '2004-0395', '$2y$10$r5cfUdgOWYbAd28cjGLA4uedB9WuCPdu.EjYlyV8cV30KOcU8Uw5y', 'student', '0');
INSERT INTO `users` VALUES ('17', '20040396', '$2y$10$l0a/2Ix5pI51ENkzBRB/5uePTAKrrJjO5nnBVWe592Wy5bRsOkl8S', 'student', '0');
