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
  `offline_first` tinyint(2) DEFAULT '0' COMMENT '是否离线优先',
  `account_state` enum('reception','not_receive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'reception' COMMENT '账户状态：接待:''receive'',不接待:''not_receive'',',
  `online_state` enum('normal','disable') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ' ''normal''：正常 ''disable''：停用',
  PRIMARY KEY (`service_id`) USING BTREE,
  UNIQUE KEY `user_name` (`user_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台客服表';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
