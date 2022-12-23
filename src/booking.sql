/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MariaDB
 Source Server Version : 101002 (10.10.2-MariaDB-1:10.10.2+maria~ubu2204)
 Source Host           : localhost:3306
 Source Schema         : booking

 Target Server Type    : MariaDB
 Target Server Version : 101002 (10.10.2-MariaDB-1:10.10.2+maria~ubu2204)
 File Encoding         : 65001

 Date: 23/12/2022 12:46:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for booking
-- ----------------------------
DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cabinet_id` bigint(20) NOT NULL,
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cabinet_id`(`cabinet_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of booking
-- ----------------------------
INSERT INTO `booking` VALUES (1, 1, '1', '2022-12-14', '2022-12-22');

-- ----------------------------
-- Table structure for cabinets
-- ----------------------------
DROP TABLE IF EXISTS `cabinets`;
CREATE TABLE `cabinets`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cabinets
-- ----------------------------
INSERT INTO `cabinets` VALUES (1, 'Cabinet 1');
INSERT INTO `cabinets` VALUES (2, 'Cabinet 2');
INSERT INTO `cabinets` VALUES (3, 'Cabinet 3');
INSERT INTO `cabinets` VALUES (4, 'Cabinet 4');
INSERT INTO `cabinets` VALUES (5, 'Cabinet 5');

SET FOREIGN_KEY_CHECKS = 1;
