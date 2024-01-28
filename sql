/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : salary

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2024-01-28 14:26:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `uid` int(4) NOT NULL DEFAULT '0' COMMENT '添加入',
  `pwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `add_time` datetime NOT NULL,
  `edit_time` datetime NOT NULL,
  `locktime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0-删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '1', '9fa6b68de1f95b2ee0ea3984abda2410', '2011-11-11 00:00:00', '2024-01-27 15:01:12', '2011-11-11 11:11:00', '1');
INSERT INTO `admins` VALUES ('2', 'test', '1', '9954e3d4cd9bc57cd40fb7f2711fdec9', '2024-01-27 15:00:34', '2024-01-27 15:00:42', '2024-01-27 15:00:34', '0');

-- ----------------------------
-- Table structure for salaries
-- ----------------------------
DROP TABLE IF EXISTS `salaries`;
CREATE TABLE `salaries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL DEFAULT '0' COMMENT '用户id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '薪水',
  `cny_to_usd_rate` float(4,2) NOT NULL DEFAULT '0.00' COMMENT '薪水发放时汇率',
  `usd_salary` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'usdt薪水',
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '该周开始时间',
  `end_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '该周结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-已发放',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of salaries
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addrres` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '发币地址',
  `salary_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-周薪，2-时薪',
  `salary` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '工资/周（/小时）',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uid` int(4) NOT NULL DEFAULT '0' COMMENT '后台操作人',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
