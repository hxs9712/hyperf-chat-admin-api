/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.12 : Database - hyperf-chat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hyperf-chat` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `hyperf-chat`;

/*Table structure for table `wolive_chat` */

DROP TABLE IF EXISTS `wolive_chat`;

CREATE TABLE `wolive_chat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `from_service_id` int(11) NOT NULL,
  `to_service_id` int(11) NOT NULL,
  `unread_count` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `wolive_chat` */

insert  into `wolive_chat`(`cid`,`from_service_id`,`to_service_id`,`unread_count`,`create_time`,`update_time`) values (1,30,85,0,'2022-01-06 10:33:30','2022-01-11 07:12:25');
insert  into `wolive_chat`(`cid`,`from_service_id`,`to_service_id`,`unread_count`,`create_time`,`update_time`) values (8,30,86,0,'2022-01-07 06:46:31','2022-01-11 10:33:23');

/*Table structure for table `wolive_chat_record` */

DROP TABLE IF EXISTS `wolive_chat_record`;

CREATE TABLE `wolive_chat_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_service_id` int(11) NOT NULL,
  `to_service_id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `wolive_chat_record` */

insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (1,30,85,1,'2',1,NULL,NULL);
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (2,30,85,1,'1',1,'2022-01-07 02:36:09','2022-01-07 02:36:09');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (3,30,85,1,'2',1,'2022-01-07 02:36:22','2022-01-07 02:36:22');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (10,30,85,1,'终于可以了',1,'2022-01-07 04:17:47','2022-01-07 04:17:47');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (6,30,85,1,'3',1,'2022-01-07 03:38:23','2022-01-07 03:38:23');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (7,30,85,1,'1',1,'2022-01-07 03:38:59','2022-01-07 03:38:59');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (8,85,30,1,'2',1,'2022-01-07 03:39:09','2022-01-07 03:39:09');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (9,30,85,1,'我是testHu',1,'2022-01-07 03:40:22','2022-01-07 03:40:22');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (11,30,85,1,'会话',1,'2022-01-07 04:20:00','2022-01-07 04:20:00');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (12,85,30,1,'1',1,'2022-01-07 04:20:28','2022-01-07 04:20:28');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (13,30,85,1,'啊啊啊',1,'2022-01-07 06:11:38','2022-01-07 06:11:38');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (14,85,30,1,'顶顶顶',1,'2022-01-07 06:11:56','2022-01-07 06:11:56');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (15,85,30,1,'踩踩踩',1,'2022-01-07 06:12:38','2022-01-07 06:12:38');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (16,30,85,1,'啊啊啊',1,'2022-01-07 06:12:43','2022-01-07 06:12:43');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (17,30,85,1,'1',1,'2022-01-07 06:40:31','2022-01-07 06:40:31');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (18,85,30,1,'2',1,'2022-01-07 06:40:38','2022-01-07 06:40:38');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (19,85,30,1,'1',1,'2022-01-07 10:33:15','2022-01-07 10:33:15');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (20,85,30,1,'2',1,'2022-01-07 10:36:16','2022-01-07 10:36:16');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (21,30,85,1,'1',1,'2022-01-10 02:31:56','2022-01-10 02:31:56');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (22,85,30,1,'2',1,'2022-01-10 02:31:59','2022-01-10 02:31:59');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (23,85,30,1,'今天是2022年1月10号',1,'2022-01-10 02:32:12','2022-01-10 02:32:12');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (24,30,86,8,'enter发送',1,'2022-01-10 03:39:38','2022-01-10 03:39:38');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (25,30,85,1,'enter键发送',1,'2022-01-10 03:44:06','2022-01-10 03:44:06');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (26,30,85,1,'enter发送',1,'2022-01-10 03:44:13','2022-01-10 03:44:13');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (27,30,85,1,'',1,'2022-01-10 03:46:17','2022-01-10 03:46:17');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (28,30,85,1,'1',1,'2022-01-10 03:46:47','2022-01-10 03:46:47');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (29,30,85,1,'1',1,'2022-01-10 03:47:20','2022-01-10 03:47:20');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (30,85,30,1,'我',1,'2022-01-10 03:47:40','2022-01-10 03:47:40');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (31,85,30,1,'啊',1,'2022-01-10 03:47:43','2022-01-10 03:47:43');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (32,30,85,1,'1',1,'2022-01-10 03:47:55','2022-01-10 03:47:55');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (33,85,30,1,'2',1,'2022-01-10 03:47:59','2022-01-10 03:47:59');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (34,85,30,1,'1',1,'2022-01-10 03:48:06','2022-01-10 03:48:06');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (35,30,85,1,'3',1,'2022-01-10 03:48:12','2022-01-10 03:48:12');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (36,30,85,1,'啊',1,'2022-01-10 03:48:17','2022-01-10 03:48:17');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (37,30,85,1,'4',0,'2022-01-10 03:50:30','2022-01-10 03:50:30');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (38,30,86,8,'1',1,'2022-01-10 10:54:36','2022-01-10 10:54:36');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (39,30,86,8,'bb',1,'2022-01-10 10:56:18','2022-01-10 10:56:18');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (40,85,30,1,'啊啊',0,'2022-01-11 07:12:05','2022-01-11 07:12:05');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (41,85,30,1,'瞅瞅',0,'2022-01-11 07:12:25','2022-01-11 07:12:25');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (42,86,30,8,'啊啊',0,'2022-01-11 07:15:22','2022-01-11 07:15:22');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (43,86,30,8,'我是bb23',0,'2022-01-11 07:15:43','2022-01-11 07:15:43');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (44,86,30,8,'你为什么收不到',0,'2022-01-11 07:16:07','2022-01-11 07:16:07');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (45,30,86,8,'哈哈',0,'2022-01-11 10:33:21','2022-01-11 10:33:21');
insert  into `wolive_chat_record`(`id`,`from_service_id`,`to_service_id`,`cid`,`content`,`read`,`create_time`,`update_time`) values (46,30,86,8,'我收到了',0,'2022-01-11 10:33:23','2022-01-11 10:33:23');

/*Table structure for table `wolive_chat_room` */

DROP TABLE IF EXISTS `wolive_chat_room`;

CREATE TABLE `wolive_chat_room` (
  `crid` int(11) NOT NULL AUTO_INCREMENT,
  `cr_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '群聊名称',
  `service_id` int(11) NOT NULL COMMENT '发起人客服id',
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发起人名称',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`crid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `wolive_chat_room` */

insert  into `wolive_chat_room`(`crid`,`cr_name`,`service_id`,`user_name`,`create_time`,`update_time`) values (2,'测试聊天室',30,'testHu','2022-01-10 10:38:29','2022-01-10 10:38:29');

/*Table structure for table `wolive_chat_room_member` */

DROP TABLE IF EXISTS `wolive_chat_room_member`;

CREATE TABLE `wolive_chat_room_member` (
  `crmid` int(11) NOT NULL AUTO_INCREMENT,
  `crid` int(11) NOT NULL COMMENT '群id',
  `service_id` int(11) NOT NULL COMMENT '群成员id',
  `unread_count` int(11) NOT NULL DEFAULT '0' COMMENT '未读消息数量',
  `create_time` datetime NOT NULL COMMENT '加入时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`crmid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `wolive_chat_room_member` */

insert  into `wolive_chat_room_member`(`crmid`,`crid`,`service_id`,`unread_count`,`create_time`,`update_time`) values (1,2,86,0,'2022-01-10 10:38:29','2022-01-10 10:38:29');
insert  into `wolive_chat_room_member`(`crmid`,`crid`,`service_id`,`unread_count`,`create_time`,`update_time`) values (2,2,85,0,'2022-01-10 10:38:29','2022-01-10 10:38:29');
insert  into `wolive_chat_room_member`(`crmid`,`crid`,`service_id`,`unread_count`,`create_time`,`update_time`) values (3,2,30,0,'2022-01-10 10:38:29','2022-01-10 10:38:29');

/*Table structure for table `wolive_chat_room_record` */

DROP TABLE IF EXISTS `wolive_chat_room_record`;

CREATE TABLE `wolive_chat_room_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_service_id` int(11) NOT NULL,
  `to_service_id` int(11) NOT NULL,
  `crid` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `wolive_chat_room_record` */

insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (117,85,30,2,'请大家多多指教',0,'2022-01-11 10:34:46','2022-01-11 10:34:46');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (116,85,85,2,'请大家多多指教',0,'2022-01-11 10:34:46','2022-01-11 10:34:46');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (115,85,86,2,'请大家多多指教',0,'2022-01-11 10:34:46','2022-01-11 10:34:46');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (114,85,30,2,'大家好，我是aa',0,'2022-01-11 10:34:37','2022-01-11 10:34:37');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (113,85,85,2,'大家好，我是aa',0,'2022-01-11 10:34:37','2022-01-11 10:34:37');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (112,85,86,2,'大家好，我是aa',0,'2022-01-11 10:34:37','2022-01-11 10:34:37');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (111,30,30,2,'不对也对',0,'2022-01-11 08:23:05','2022-01-11 08:23:05');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (110,30,85,2,'不对也对',0,'2022-01-11 08:23:05','2022-01-11 08:23:05');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (109,30,86,2,'不对也对',0,'2022-01-11 08:23:05','2022-01-11 08:23:05');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (108,30,30,2,'对也对',0,'2022-01-11 08:23:03','2022-01-11 08:23:03');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (107,30,85,2,'对也对',0,'2022-01-11 08:23:03','2022-01-11 08:23:03');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (106,30,86,2,'对也对',0,'2022-01-11 08:23:03','2022-01-11 08:23:03');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (105,30,30,2,'你说啥都对',0,'2022-01-11 08:22:59','2022-01-11 08:22:59');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (104,30,85,2,'你说啥都对',0,'2022-01-11 08:22:59','2022-01-11 08:22:59');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (103,30,86,2,'你说啥都对',0,'2022-01-11 08:22:59','2022-01-11 08:22:59');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (102,86,30,2,'没毛病啊',0,'2022-01-11 08:21:57','2022-01-11 08:21:57');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (101,86,85,2,'没毛病啊',0,'2022-01-11 08:21:57','2022-01-11 08:21:57');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (100,86,86,2,'没毛病啊',0,'2022-01-11 08:21:57','2022-01-11 08:21:57');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (99,30,30,2,'对',0,'2022-01-11 08:21:48','2022-01-11 08:21:48');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (98,30,85,2,'对',0,'2022-01-11 08:21:48','2022-01-11 08:21:48');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (97,30,86,2,'对',0,'2022-01-11 08:21:48','2022-01-11 08:21:48');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (96,30,30,2,'啊',0,'2022-01-11 08:21:44','2022-01-11 08:21:44');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (95,30,85,2,'啊',0,'2022-01-11 08:21:44','2022-01-11 08:21:44');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (94,30,86,2,'啊',0,'2022-01-11 08:21:44','2022-01-11 08:21:44');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (93,86,30,2,'群聊可是有点费数据库啊',0,'2022-01-11 07:23:26','2022-01-11 07:23:26');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (92,86,85,2,'群聊可是有点费数据库啊',0,'2022-01-11 07:23:26','2022-01-11 07:23:26');
insert  into `wolive_chat_room_record`(`id`,`from_service_id`,`to_service_id`,`crid`,`content`,`read`,`create_time`,`update_time`) values (91,86,86,2,'群聊可是有点费数据库啊',0,'2022-01-11 07:23:26','2022-01-11 07:23:26');

/*Table structure for table `wolive_service` */

DROP TABLE IF EXISTS `wolive_service`;

CREATE TABLE `wolive_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `fd` int(11) DEFAULT NULL COMMENT 'websocket用户唯一标识fd',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `nick_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '昵称',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '用户token',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '手机',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '邮箱',
  `avatar` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '/assets/images/admin/avatar-admin2.png' COMMENT '头像',
  PRIMARY KEY (`service_id`) USING BTREE,
  UNIQUE KEY `user_name` (`user_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台客服表';

/*Data for the table `wolive_service` */

insert  into `wolive_service`(`service_id`,`fd`,`user_name`,`nick_name`,`password`,`token`,`phone`,`email`,`avatar`) values (30,20,'testHu','客服胡2','0017b8c19aff4bbb457fc77f2acc1ea6',NULL,'','hu@qq.com','/assets/images/admin/avatar-admin2.png');
insert  into `wolive_service`(`service_id`,`fd`,`user_name`,`nick_name`,`password`,`token`,`phone`,`email`,`avatar`) values (85,23,'aa','aaa','9afe516824d5a2b839aab7c9fe00e04e',NULL,'','aa@qq.com','/assets/images/admin/avatar-admin2.png');
insert  into `wolive_service`(`service_id`,`fd`,`user_name`,`nick_name`,`password`,`token`,`phone`,`email`,`avatar`) values (86,2,'bb23','bbb','b89ff102f3d7b3c3cec55b0cd48e1380',NULL,'','bb@qq.com','/assets/images/admin/avatar-admin2.png');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
