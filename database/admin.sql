/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : house

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 08/05/2023 16:18:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` enum('superadmin','master') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'Admin', 'asdasdsad', 'onyxsto@gmail.com', '37477701105', '2021-03-22 00:07:42', '$2y$10$.I/Y1Am6z0i34n2Rupc3c.hjQtRUnDGRcWy4weY3gdn02bsVbWtiW', NULL, NULL, '2021-03-29 17:46:28', 'admin', 'superadmin', NULL);

-- ----------------------------
-- Table structure for billings
-- ----------------------------
DROP TABLE IF EXISTS `billings`;
CREATE TABLE `billings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_hash` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_total` int NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `type` enum('stripe','paypal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paypal_order_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `paypal_transaction_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of billings
-- ----------------------------
INSERT INTO `billings` VALUES (1, 'INV-6398c7301d5d8', 300, '2022-12-13 22:41:19', 'paypal', '11944153UK7126905', '52433020NW8015243');
INSERT INTO `billings` VALUES (2, 'INV-6398f5b33bd5e', 212, '2022-12-14 02:00:04', 'paypal', '9GW829599G150431K', '9W9236510D459094E');
INSERT INTO `billings` VALUES (3, 'INV-6398f64db1f43', 212, '2022-12-14 02:02:23', 'paypal', '1EV0992606242912W', '5JM33312CF1211003');
INSERT INTO `billings` VALUES (4, 'INV-63a0b4a602c4f', 350, '2022-12-19 23:00:56', 'paypal', '5F515942DJ9181024', '7X873560R47763225');
INSERT INTO `billings` VALUES (5, 'INV-63fc6840662d2', 212, '2023-02-27 12:23:09', 'paypal', '4GB8057333913212H', '8SG10642SM9586338');

-- ----------------------------
-- Table structure for collections
-- ----------------------------
DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title_droped` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `temp` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `ordering` int NULL DEFAULT NULL,
  `featured` tinyint(1) NULL DEFAULT 0,
  `image_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of collections
-- ----------------------------
INSERT INTO `collections` VALUES (1, 'col-1', 'Dolar si amut', 'simplicity<br> is the keynote', NULL, NULL, '2022-11-28 22:17:41', 1, NULL, 2, 1, NULL);
INSERT INTO `collections` VALUES (2, 'col-2', 'Lorem ipsum', 'simplicity<br>is the keynote', NULL, NULL, '2022-11-28 22:18:02', 0, '2022-12-14 14:58:47', 1, NULL, 41);
INSERT INTO `collections` VALUES (3, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:17:00', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (4, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:20:06', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (5, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:21:40', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (6, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:21:52', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (7, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:23:12', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (8, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:24:06', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (9, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:24:22', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (10, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:29:05', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (11, NULL, NULL, NULL, NULL, 1, '2022-12-13 15:32:17', 0, NULL, 3, 0, NULL);
INSERT INTO `collections` VALUES (12, NULL, NULL, NULL, NULL, 1, '2022-12-13 23:55:53', 0, NULL, 4, 0, NULL);
INSERT INTO `collections` VALUES (13, 'fghjfghj', 'fghjfg', 'hjfghjf', NULL, NULL, '2022-12-14 14:58:37', 1, NULL, 1, 1, 102);
INSERT INTO `collections` VALUES (14, NULL, NULL, NULL, NULL, 1, '2022-12-14 15:04:29', 0, NULL, 6, 0, NULL);
INSERT INTO `collections` VALUES (15, NULL, NULL, NULL, NULL, 1, '2023-03-28 15:22:30', 0, NULL, 7, 0, NULL);

-- ----------------------------
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `price` int NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES (1, 'Armenia', 200, 1);
INSERT INTO `countries` VALUES (2, 'Russia', 1000, 1);
INSERT INTO `countries` VALUES (3, 'Usa', 5000, 1);

-- ----------------------------
-- Table structure for dictionary
-- ----------------------------
DROP TABLE IF EXISTS `dictionary`;
CREATE TABLE `dictionary`  (
  `key` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `en` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` enum('dictionary','email','notification') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'dictionary',
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dictionary
-- ----------------------------
INSERT INTO `dictionary` VALUES ('email.footer', 'Copyright © 2022 The House. All rights reserved.', 'email');
INSERT INTO `dictionary` VALUES ('email.header', 'The House LLC', 'email');
INSERT INTO `dictionary` VALUES ('header_sign_in', 'Sign', 'dictionary');
INSERT INTO `dictionary` VALUES ('maintenance_canceled_subject', 'Maintenance :sku canceled.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_canceled_text', 'Maintenance :sku canceled.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_canceled_title', 'Maintenance canceled', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_expired_subject', 'Maintenance :sku expired.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_expired_text', 'Maintenance :sku expired.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_expired_title', 'Maintenance expired', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_paid_subject', 'Maintenance :sku paid.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_paid_text', 'Maintenance :sku successfully paid.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_paid_title', 'Payment success', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_sign_subject', 'Maintenance :sku signed.', 'email');
INSERT INTO `dictionary` VALUES ('maintenance_sign_text', 'Maintenance :sku successfully signed.', 'email');
INSERT INTO `dictionary` VALUES ('master_assign_subject', 'Assigned order', 'email');
INSERT INTO `dictionary` VALUES ('master_assign_text', 'Order :sku assigned.', 'email');
INSERT INTO `dictionary` VALUES ('master_invitation_subject', 'Master Invitation', 'email');
INSERT INTO `dictionary` VALUES ('master_invitation_text', 'Welcome to admin panel', 'email');
INSERT INTO `dictionary` VALUES ('master_retracted_subject', 'Retracted order', 'email');
INSERT INTO `dictionary` VALUES ('master_retracted_text', 'Order :sku retracted.', 'email');
INSERT INTO `dictionary` VALUES ('order_canceled_subject', 'Order :sku canceled.', 'email');
INSERT INTO `dictionary` VALUES ('order_canceled_text', 'Order :sku canceled.', 'email');
INSERT INTO `dictionary` VALUES ('order_canceled_title', 'Order canceled', 'email');
INSERT INTO `dictionary` VALUES ('order_created_subject', 'Order :sku created', 'email');
INSERT INTO `dictionary` VALUES ('order_created_text', 'Order :sku successfully created.', 'email');
INSERT INTO `dictionary` VALUES ('order_created_title', 'Order created', 'email');
INSERT INTO `dictionary` VALUES ('order_done_master_subject', 'Order :sku done by master.', 'email');
INSERT INTO `dictionary` VALUES ('order_done_master_text', 'Order :sku successfully done by master.', 'email');
INSERT INTO `dictionary` VALUES ('order_done_master_title', 'Order done', 'email');
INSERT INTO `dictionary` VALUES ('order_done_subject', 'Order :sku done.', 'email');
INSERT INTO `dictionary` VALUES ('order_done_text', 'Order :sku successfully done. Please leave a review.', 'email');
INSERT INTO `dictionary` VALUES ('order_done_title', 'Order done', 'email');
INSERT INTO `dictionary` VALUES ('order_paid_subject', 'Order :sku paid.', 'email');
INSERT INTO `dictionary` VALUES ('order_paid_text', 'Order :sku successfully paid.', 'email');
INSERT INTO `dictionary` VALUES ('order_paid_title', 'Payment success', 'email');
INSERT INTO `dictionary` VALUES ('order_pay_later_subject', 'Order :sku marked \"pay as done\".', 'email');
INSERT INTO `dictionary` VALUES ('order_pay_later_text', 'Order :sku marked \"pay as done\".', 'email');
INSERT INTO `dictionary` VALUES ('order_pay_later_title', 'Status changed', 'email');
INSERT INTO `dictionary` VALUES ('order_scheduled_subject', 'Order :sku scheduled.', 'email');
INSERT INTO `dictionary` VALUES ('order_scheduled_text', 'Order :sku scheduled.', 'email');
INSERT INTO `dictionary` VALUES ('order_scheduled_title', 'Order scheduled', 'email');
INSERT INTO `dictionary` VALUES ('order_shipping_subject', 'Order :sku shipping.', 'email');
INSERT INTO `dictionary` VALUES ('order_shipping_text', 'Order :sku shipping.', 'email');
INSERT INTO `dictionary` VALUES ('order_shipping_title', 'Order shipping', 'email');
INSERT INTO `dictionary` VALUES ('password_recovery_reset_password', 'Reset password', 'email');
INSERT INTO `dictionary` VALUES ('password_recovery_subject', 'Password recovery', 'email');
INSERT INTO `dictionary` VALUES ('password_recovery_text', 'We\'ve received a request to reset your password. If you didn\'t make the request,<br>\r\n	just ignore this email. Otherwise, you can reset your password using this link.', 'email');
INSERT INTO `dictionary` VALUES ('password_recovery_title', 'Password recovery', 'email');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `temp` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of galleries
-- ----------------------------
INSERT INTO `galleries` VALUES (1, 0, '2022-11-28 23:47:38', '2022-11-28 23:47:38');
INSERT INTO `galleries` VALUES (2, 0, '2022-11-28 23:48:14', '2022-11-28 23:48:14');
INSERT INTO `galleries` VALUES (3, 0, '2022-11-29 00:05:12', '2022-11-29 00:05:12');
INSERT INTO `galleries` VALUES (4, 0, '2022-11-29 00:05:16', '2022-11-29 00:05:16');
INSERT INTO `galleries` VALUES (5, 1, '2022-11-29 00:20:18', '2022-11-29 00:20:18');
INSERT INTO `galleries` VALUES (6, 1, '2022-11-29 00:20:24', '2022-11-29 00:20:24');
INSERT INTO `galleries` VALUES (7, 1, '2022-11-29 00:20:38', '2022-11-29 00:20:38');
INSERT INTO `galleries` VALUES (8, 1, '2022-11-29 00:20:44', '2022-11-29 00:20:44');
INSERT INTO `galleries` VALUES (9, 1, '2022-11-29 00:21:01', '2022-11-29 00:21:01');
INSERT INTO `galleries` VALUES (10, 1, '2022-11-29 00:21:39', '2022-11-29 00:21:39');
INSERT INTO `galleries` VALUES (11, 1, '2022-11-29 00:23:37', '2022-11-29 00:23:37');
INSERT INTO `galleries` VALUES (12, 1, '2022-11-29 00:25:59', '2022-11-29 00:25:59');
INSERT INTO `galleries` VALUES (13, 1, '2022-11-29 00:26:17', '2022-11-29 00:26:17');
INSERT INTO `galleries` VALUES (14, 1, '2022-11-29 00:27:46', '2022-11-29 00:27:46');
INSERT INTO `galleries` VALUES (15, 1, '2022-11-29 00:28:26', '2022-11-29 00:28:26');
INSERT INTO `galleries` VALUES (16, 1, '2022-11-29 00:29:26', '2022-11-29 00:29:26');
INSERT INTO `galleries` VALUES (17, 1, '2022-11-29 00:29:37', '2022-11-29 00:29:37');
INSERT INTO `galleries` VALUES (18, 1, '2022-11-29 00:30:17', '2022-11-29 00:30:17');
INSERT INTO `galleries` VALUES (19, 1, '2022-11-29 00:30:52', '2022-11-29 00:30:52');
INSERT INTO `galleries` VALUES (20, 1, '2022-11-29 00:34:22', '2022-11-29 00:34:22');
INSERT INTO `galleries` VALUES (21, 1, '2022-11-29 00:34:50', '2022-11-29 00:34:50');
INSERT INTO `galleries` VALUES (22, 1, '2022-11-29 00:35:03', '2022-11-29 00:35:03');
INSERT INTO `galleries` VALUES (23, 1, '2022-11-29 00:35:32', '2022-11-29 00:35:32');
INSERT INTO `galleries` VALUES (24, 1, '2022-11-29 00:35:42', '2022-11-29 00:35:42');
INSERT INTO `galleries` VALUES (25, 1, '2022-11-29 00:36:04', '2022-11-29 00:36:04');
INSERT INTO `galleries` VALUES (26, 1, '2022-11-29 00:36:12', '2022-11-29 00:36:12');
INSERT INTO `galleries` VALUES (27, 1, '2022-11-29 00:36:33', '2022-11-29 00:36:33');
INSERT INTO `galleries` VALUES (28, 1, '2022-11-29 00:36:51', '2022-11-29 00:36:51');
INSERT INTO `galleries` VALUES (29, 1, '2022-11-29 00:38:12', '2022-11-29 00:38:12');
INSERT INTO `galleries` VALUES (30, 0, '2022-12-13 15:17:00', '2022-12-13 15:17:00');
INSERT INTO `galleries` VALUES (31, 0, '2022-12-13 15:20:06', '2022-12-13 15:20:06');
INSERT INTO `galleries` VALUES (32, 0, '2022-12-13 15:21:52', '2022-12-13 15:21:52');
INSERT INTO `galleries` VALUES (33, 0, '2022-12-13 15:23:12', '2022-12-13 15:23:12');
INSERT INTO `galleries` VALUES (34, 0, '2022-12-13 15:24:06', '2022-12-13 15:24:06');
INSERT INTO `galleries` VALUES (35, 0, '2022-12-13 15:24:22', '2022-12-13 15:24:22');
INSERT INTO `galleries` VALUES (36, 0, '2022-12-13 15:29:05', '2022-12-13 15:29:05');
INSERT INTO `galleries` VALUES (37, 0, '2022-12-13 15:32:17', '2022-12-13 15:32:17');
INSERT INTO `galleries` VALUES (38, 0, '2022-12-13 15:39:25', '2022-12-13 15:39:25');
INSERT INTO `galleries` VALUES (39, 0, '2022-12-13 15:41:00', '2022-12-13 15:41:00');
INSERT INTO `galleries` VALUES (40, 0, '2022-12-13 15:41:40', '2022-12-13 15:41:40');
INSERT INTO `galleries` VALUES (41, 0, '2022-12-13 15:42:18', '2022-12-13 15:42:18');
INSERT INTO `galleries` VALUES (42, 0, '2022-12-13 15:42:47', '2022-12-13 15:42:47');
INSERT INTO `galleries` VALUES (43, 0, '2022-12-13 15:43:02', '2022-12-13 15:43:02');
INSERT INTO `galleries` VALUES (44, 0, '2022-12-13 15:44:34', '2022-12-13 15:44:34');
INSERT INTO `galleries` VALUES (45, 0, '2022-12-13 15:44:45', '2022-12-13 15:44:45');
INSERT INTO `galleries` VALUES (46, NULL, '2022-12-13 18:53:10', '2022-12-13 18:53:10');
INSERT INTO `galleries` VALUES (47, NULL, '2022-12-13 18:55:16', '2022-12-13 18:55:16');
INSERT INTO `galleries` VALUES (48, NULL, '2022-12-13 18:59:11', '2022-12-13 18:59:11');
INSERT INTO `galleries` VALUES (49, NULL, '2022-12-13 18:59:36', '2022-12-13 18:59:36');
INSERT INTO `galleries` VALUES (50, NULL, '2022-12-13 19:00:00', '2022-12-13 19:00:00');
INSERT INTO `galleries` VALUES (51, NULL, '2022-12-13 21:50:08', '2022-12-13 21:50:08');
INSERT INTO `galleries` VALUES (52, NULL, '2022-12-13 22:37:06', '2022-12-13 22:37:06');
INSERT INTO `galleries` VALUES (53, NULL, '2022-12-13 22:37:34', '2022-12-13 22:37:34');
INSERT INTO `galleries` VALUES (54, NULL, '2022-12-14 01:20:08', '2022-12-14 01:20:08');
INSERT INTO `galleries` VALUES (55, NULL, '2022-12-14 17:36:59', '2022-12-14 17:36:59');
INSERT INTO `galleries` VALUES (56, NULL, '2022-12-16 10:52:51', '2022-12-16 10:52:51');
INSERT INTO `galleries` VALUES (57, NULL, '2023-03-20 11:54:58', '2023-03-20 11:54:58');
INSERT INTO `galleries` VALUES (58, NULL, '2023-04-27 13:20:45', '2023-04-27 13:20:45');

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `temp` int NULL DEFAULT 0,
  `ordering` int NULL DEFAULT 0,
  `parent_id` int NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `size` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ext` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 113 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES (10, 'fb91617ea014', 0, 0, 5, '2022-11-29 00:20:22', '3763289', 'jpg', '2022-11-29 00:20:22', NULL);
INSERT INTO `images` VALUES (11, 'ce0552116530', 0, 0, 7, '2022-11-29 00:20:42', '3763289', 'jpg', '2022-11-29 00:20:42', NULL);
INSERT INTO `images` VALUES (16, '831edab75617', 0, 0, NULL, '2022-11-29 01:10:47', '3763289', 'jpg', '2022-11-29 01:10:47', NULL);
INSERT INTO `images` VALUES (17, 'f6563b6ad57e', 0, 0, NULL, '2022-11-29 01:11:04', '25783', 'jpg', '2022-11-29 01:11:04', NULL);
INSERT INTO `images` VALUES (25, '2bbc7d1e90ed', 0, 1, 2, '2022-12-11 21:06:20', '3763289', 'jpg', '2022-12-11 21:06:20', NULL);
INSERT INTO `images` VALUES (41, '0d40474884f8', NULL, 0, NULL, '2022-12-09 01:00:30', '43697', 'jpeg', '2022-12-09 01:00:30', NULL);
INSERT INTO `images` VALUES (50, 'ad4b48a082bd', 0, 0, 2, '2022-12-11 21:05:27', '43697', 'jpeg', '2022-12-11 21:05:27', NULL);
INSERT INTO `images` VALUES (53, '1cd577119d80', 0, 0, 3, '2022-12-09 08:59:42', '71335', 'jpg', '2022-12-09 08:59:42', NULL);
INSERT INTO `images` VALUES (54, '73412fce4f59', 0, 1, 3, '2022-12-11 23:44:46', '107450', 'jpg', '2022-12-11 23:44:46', 'green');
INSERT INTO `images` VALUES (74, 'bb94727b1ea7', 0, 2, 4, '2022-12-12 12:39:31', '44027', 'jpg', '2022-12-12 12:39:31', NULL);
INSERT INTO `images` VALUES (76, '1ede94032289', 0, 2, 2, '2022-12-11 21:01:20', '114668', 'png', '2022-12-11 21:01:20', 'white');
INSERT INTO `images` VALUES (77, 'c7d9cc0117c2', 0, 3, 2, '2022-12-11 20:40:03', '43697', 'jpeg', '2022-12-11 20:40:03', 'blue');
INSERT INTO `images` VALUES (78, '3bd87f879523', 0, 4, 2, '2022-12-11 20:39:55', '44027', 'jpg', '2022-12-11 20:39:55', 'black');
INSERT INTO `images` VALUES (79, '8e1bfe782231', 0, 5, 2, '2022-12-11 20:39:53', '213651', 'jpg', '2022-12-11 20:39:53', 'green');
INSERT INTO `images` VALUES (81, '97e87f508714', 0, 3, 4, '2022-12-12 12:39:19', '25783', 'jpg', '2022-12-12 12:39:19', 'black');
INSERT INTO `images` VALUES (82, '7844c5029d8c', 0, 4, 4, '2022-12-11 23:44:40', '25783', 'jpg', '2022-12-11 23:44:40', 'green');
INSERT INTO `images` VALUES (83, 'e0c1adeb1dfd', 0, 0, 38, '2022-12-13 18:08:05', '25783', 'jpg', '2022-12-13 18:08:05', 'white');
INSERT INTO `images` VALUES (84, 'd1e81ebe6518', 0, 1, 38, '2022-12-13 18:21:09', '26648', 'jpg', '2022-12-13 18:21:09', 'blue');
INSERT INTO `images` VALUES (85, 'f381c95ed6ba', 0, 2, 38, '2022-12-13 18:21:10', '50645', 'jpg', '2022-12-13 18:21:10', 'blue');
INSERT INTO `images` VALUES (88, 'cd03eb5b3e6d', 0, 0, 51, '2022-12-13 21:50:41', '44027', 'jpg', '2022-12-13 21:50:41', 'white');
INSERT INTO `images` VALUES (89, '580b97b3a8ac', 0, 1, 51, '2022-12-13 21:50:40', '26648', 'jpg', '2022-12-13 21:50:40', 'green');
INSERT INTO `images` VALUES (90, 'f5b85c1bc909', 0, 0, 52, '2022-12-13 22:37:28', '44027', 'jpg', '2022-12-13 22:37:28', 'black');
INSERT INTO `images` VALUES (91, '2cd5656e765e', 0, 1, 52, '2022-12-13 22:37:29', '44027', 'jpg', '2022-12-13 22:37:29', 'white');
INSERT INTO `images` VALUES (92, '7670406d956c', 0, 0, 53, '2022-12-13 22:37:56', '43697', 'jpeg', '2022-12-13 22:37:56', NULL);
INSERT INTO `images` VALUES (93, 'b5c328fca3f1', 0, 0, NULL, '2022-12-14 01:13:07', '3763289', 'jpg', '2022-12-14 01:13:07', NULL);
INSERT INTO `images` VALUES (95, 'fab74ccbaf47', 0, 0, NULL, '2022-12-14 02:57:47', '3763289', 'jpg', '2022-12-14 02:57:47', NULL);
INSERT INTO `images` VALUES (96, '5b907c79bbb7', 0, 0, NULL, '2022-12-14 02:58:16', '44027', 'jpg', '2022-12-14 02:58:16', NULL);
INSERT INTO `images` VALUES (97, '97ca44b6a062', 0, 2, 52, '2022-12-14 15:05:06', '246826', 'jpg', '2022-12-14 15:05:06', 'white');
INSERT INTO `images` VALUES (98, '735aa0139762', 0, 1, 55, '2022-12-19 23:22:04', '246826', 'jpg', '2022-12-19 23:22:04', NULL);
INSERT INTO `images` VALUES (99, 'e9cfcdd51e8b', 0, 2, 55, '2022-12-19 23:22:04', '526131', 'png', '2022-12-19 23:22:04', NULL);
INSERT INTO `images` VALUES (100, '5b37d95f4e63', 0, 3, 55, '2022-12-19 23:22:04', '542231', 'png', '2022-12-19 23:22:04', 'white');
INSERT INTO `images` VALUES (101, 'a0b7097e51b7', 0, 0, 55, '2022-12-19 23:22:04', '266089', 'jpg', '2022-12-19 23:22:04', 'green');
INSERT INTO `images` VALUES (102, 'a30dfa2a072a', NULL, 0, NULL, '2023-02-27 14:33:00', '619639', 'PNG', '2023-02-27 14:33:00', NULL);
INSERT INTO `images` VALUES (103, '1dc82f191ec8', 0, 1, 57, '2023-03-20 11:57:44', '299921', 'png', '2023-03-20 11:57:44', 'white');
INSERT INTO `images` VALUES (104, '45845332cf3a', 0, 0, 57, '2023-03-20 11:57:44', '342911', 'png', '2023-03-20 11:57:44', 'black');
INSERT INTO `images` VALUES (107, '5b827bed78d1', 0, 4, 57, '2023-03-20 11:57:20', '335398', 'png', '2023-03-20 11:57:20', 'black');
INSERT INTO `images` VALUES (108, '217e7d74fde8', 0, 0, NULL, '2023-05-03 15:32:33', '208593', 'jpg', '2023-05-03 15:32:33', NULL);
INSERT INTO `images` VALUES (109, '22c767e3d3c5', 0, 0, NULL, '2023-05-03 15:33:24', '208593', 'jpg', '2023-05-03 15:33:24', NULL);
INSERT INTO `images` VALUES (110, 'ff1b4306948b', 0, 0, NULL, '2023-05-03 15:37:04', '208593', 'jpg', '2023-05-03 15:37:04', NULL);
INSERT INTO `images` VALUES (111, 'a79761c32d79', 0, 0, NULL, '2023-05-03 15:37:24', '208593', 'jpg', '2023-05-03 15:37:24', NULL);
INSERT INTO `images` VALUES (112, '5cb31eed6874', 0, 0, NULL, '2023-05-03 17:36:24', '208593', 'jpg', '2023-05-03 17:36:24', NULL);

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `hash` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('new','pending','paid','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `paypal_order_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoices
-- ----------------------------
INSERT INTO `invoices` VALUES (1, 1, '2022-12-13 22:40:28', '2022-12-13 22:40:30', 'INV-6398c71c30172', 'new', '26S18065AR666964R');
INSERT INTO `invoices` VALUES (2, 1, '2022-12-13 22:40:45', '2022-12-13 22:40:46', 'INV-6398c72d96ae4', 'new', '2AU8030705757403P');
INSERT INTO `invoices` VALUES (3, 1, '2022-12-13 22:40:48', '2022-12-13 22:40:49', 'INV-6398c7301d5d8', 'paid', '11944153UK7126905');
INSERT INTO `invoices` VALUES (4, 4, '2022-12-14 01:59:15', '2022-12-14 01:59:16', 'INV-6398f5b33bd5e', 'paid', '9GW829599G150431K');
INSERT INTO `invoices` VALUES (5, 5, '2022-12-14 02:01:49', '2022-12-14 02:01:51', 'INV-6398f64db1f43', 'paid', '1EV0992606242912W');
INSERT INTO `invoices` VALUES (6, 8, '2022-12-19 19:29:05', '2022-12-19 19:29:08', 'INV-63a083411c267', 'new', '29F77504GR957942A');
INSERT INTO `invoices` VALUES (7, 9, '2022-12-19 22:59:50', '2022-12-19 22:59:52', 'INV-63a0b4a602c4f', 'paid', '5F515942DJ9181024');
INSERT INTO `invoices` VALUES (8, 10, '2022-12-19 23:25:12', '2022-12-19 23:25:14', 'INV-63a0ba98dcb51', 'new', '2FV34918NT074422D');
INSERT INTO `invoices` VALUES (9, 12, '2023-02-27 12:22:24', '2023-02-27 12:22:26', 'INV-63fc6840662d2', 'paid', '4GB8057333913212H');
INSERT INTO `invoices` VALUES (10, 13, '2023-02-27 14:32:04', '2023-02-27 14:32:06', 'INV-63fc86a49b1c6', 'new', '4FJ61908XJ2241427');
INSERT INTO `invoices` VALUES (11, 15, '2023-03-20 11:50:33', '2023-03-20 11:50:35', 'INV-6418104915a59', 'new', '1JG815763P318150C');

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------
INSERT INTO `jobs` VALUES (26, 'default', '{\"uuid\":\"eae7c601-2d7b-4e47-9e14-50f9708216aa\",\"displayName\":\"App\\\\Listeners\\\\SendNotificationEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":19:{s:5:\\\"class\\\";s:35:\\\"App\\\\Listeners\\\\SendNotificationEmail\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:27:\\\"App\\\\Events\\\\SendNotification\\\":2:{s:4:\\\"type\\\";s:13:\\\"order_created\\\";s:7:\\\"payload\\\";a:1:{s:2:\\\"id\\\";i:4;}}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1670864986, 1670864986);

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner_id` int NULL DEFAULT NULL,
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `owner_type` enum('order') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'order',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 54 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES (22, 2, 'order_created', '', '2022-12-13 22:50:52', 'order');
INSERT INTO `log` VALUES (23, 3, 'order_created', '', '2022-12-13 22:53:00', 'order');
INSERT INTO `log` VALUES (29, 1, 'status_changed', '{\"old_status\":\"done\",\"new_status\":\"paid\"}', '2022-12-13 23:22:43', 'order');
INSERT INTO `log` VALUES (30, 1, 'status_changed', '{\"old_status\":\"paid\",\"new_status\":\"shipping\"}', '2022-12-13 23:22:47', 'order');
INSERT INTO `log` VALUES (31, 1, 'status_changed', '{\"old_status\":\"shipping\",\"new_status\":\"done\"}', '2022-12-13 23:22:48', 'order');
INSERT INTO `log` VALUES (32, 1, 'status_changed', '{\"old_status\":\"done\",\"new_status\":\"canceled\"}', '2022-12-13 23:22:50', 'order');
INSERT INTO `log` VALUES (33, 1, 'status_changed', '{\"old_status\":\"canceled\",\"new_status\":\"paid\"}', '2022-12-13 23:23:21', 'order');
INSERT INTO `log` VALUES (34, 1, 'status_changed', '{\"old_status\":\"paid\",\"new_status\":\"shipping\"}', '2022-12-13 23:44:46', 'order');
INSERT INTO `log` VALUES (35, 1, 'status_changed', '{\"old_status\":\"shipping\",\"new_status\":\"done\"}', '2022-12-14 01:52:26', 'order');
INSERT INTO `log` VALUES (36, 4, 'order_created', '', '2022-12-14 01:59:13', 'order');
INSERT INTO `log` VALUES (37, 4, 'order_paid', '', '2022-12-14 02:00:04', 'order');
INSERT INTO `log` VALUES (38, 5, 'order_created', '', '2022-12-14 02:01:48', 'order');
INSERT INTO `log` VALUES (39, 5, 'order_paid', '', '2022-12-14 02:02:23', 'order');
INSERT INTO `log` VALUES (40, 5, 'status_changed', '{\"old_status\":\"paid\",\"new_status\":\"shipping\"}', '2022-12-14 15:00:27', 'order');
INSERT INTO `log` VALUES (41, 5, 'status_changed', '{\"old_status\":\"shipping\",\"new_status\":\"done\"}', '2022-12-14 15:01:33', 'order');
INSERT INTO `log` VALUES (42, 6, 'order_created', '', '2022-12-14 15:02:11', 'order');
INSERT INTO `log` VALUES (43, 7, 'order_created', '', '2022-12-19 15:52:40', 'order');
INSERT INTO `log` VALUES (44, 8, 'order_created', '', '2022-12-19 19:29:02', 'order');
INSERT INTO `log` VALUES (45, 9, 'order_created', '', '2022-12-19 22:59:47', 'order');
INSERT INTO `log` VALUES (46, 9, 'order_paid', '', '2022-12-19 23:00:56', 'order');
INSERT INTO `log` VALUES (47, 10, 'order_created', '', '2022-12-19 23:25:09', 'order');
INSERT INTO `log` VALUES (48, 11, 'order_created', '', '2022-12-19 23:25:18', 'order');
INSERT INTO `log` VALUES (49, 12, 'order_created', '', '2023-02-27 12:22:19', 'order');
INSERT INTO `log` VALUES (50, 12, 'order_paid', '', '2023-02-27 12:23:09', 'order');
INSERT INTO `log` VALUES (51, 13, 'order_created', '', '2023-02-27 14:31:59', 'order');
INSERT INTO `log` VALUES (52, 14, 'order_created', '', '2023-02-27 14:32:12', 'order');
INSERT INTO `log` VALUES (53, 15, 'order_created', '', '2023-03-20 11:50:30', 'order');

-- ----------------------------
-- Table structure for meta
-- ----------------------------
DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `pagename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_id` int NULL DEFAULT NULL,
  `published` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of meta
-- ----------------------------
INSERT INTO `meta` VALUES (1, 'home', 'WithTheDoc', 'WithTheDoc Desc', 95, 1, NULL, NULL, NULL);
INSERT INTO `meta` VALUES (2, 'shop', 'Shop', 'Shop', 96, 1, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 2);
INSERT INTO `migrations` VALUES (6, '2022_10_06_083153_create_payments_table', 3);

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL,
  `price` int NULL DEFAULT NULL,
  `order_id` int NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `color` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `size` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_items
-- ----------------------------
INSERT INTO `order_items` VALUES (1, 2, 2, 50, 1, NULL, NULL, 'green', NULL, 'test1');
INSERT INTO `order_items` VALUES (2, 2, 1, 50, 2, NULL, NULL, 'green', NULL, 'test1');
INSERT INTO `order_items` VALUES (3, 2, 1, 50, 3, NULL, NULL, 'green', NULL, 'test1');
INSERT INTO `order_items` VALUES (4, 1, 1, 12, 4, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (5, 1, 1, 12, 5, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (6, 1, 3, 12, 6, NULL, NULL, 'black', 'm', 'test');
INSERT INTO `order_items` VALUES (7, 1, 1, 12, 7, NULL, NULL, 'black', 'm', 'test');
INSERT INTO `order_items` VALUES (8, 2, 2, 50, 8, NULL, NULL, 'green', 's', 'test1');
INSERT INTO `order_items` VALUES (9, 2, 3, 50, 9, NULL, NULL, 'green', 's', 'test1');
INSERT INTO `order_items` VALUES (10, 1, 1, 12, 10, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (11, 1, 1, 12, 11, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (12, 1, 1, 12, 12, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (13, 1, 1, 12, 13, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (14, 1, 1, 12, 14, NULL, NULL, 'black', 's', 'test');
INSERT INTO `order_items` VALUES (15, 1, 1, 12, 15, NULL, NULL, 'black', 's', 'test');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('new','paid','shipping','done','canceled') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'new',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `total` int NULL DEFAULT NULL,
  `hash` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `owner_id` int NULL DEFAULT NULL,
  `payment_intent` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `notes` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL,
  `post_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `country_id` int NULL DEFAULT NULL,
  `sku` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `shipping_price` int NULL DEFAULT NULL,
  `data` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `items_price` int NULL DEFAULT NULL,
  `is_paid` tinyint(1) NULL DEFAULT 0,
  `comment` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 'sdfgs', 'dfgsdfg', 'leonid.sahakyan@gmail.com', '234234', 'dfghdfgh', 'done', '2022-12-13 22:40:26', '2022-12-14 01:52:28', 300, '0cb6cd59-5091-48be-8a16-44c27a298a05', NULL, NULL, 'gsdfgsdfg', 2, 'sdfgsdf', 1, 'O-6398c719f3a06', 200, '[{\"product_id\":2,\"qty\":\"2\",\"color\":\"green\",\"size\":null,\"price\":50,\"title\":\"test1\"}]', 'asdasd', 100, 1, 'dfgdfsgdfgfghjfhgj');
INSERT INTO `orders` VALUES (2, 'dfgh', 'dfghdfg', 'hdfghdfgh@asdsad.com', '345345', 'dfghdfgh', 'new', '2022-12-13 22:50:52', '2022-12-13 22:50:52', 1050, '8d9adb31-d79b-45b2-b0b5-dd7c829fb6db', NULL, NULL, NULL, 1, 'dfghdfgh', 2, 'O-6398c98cab9f9', 1000, '[{\"product_id\":2,\"qty\":\"1\",\"color\":\"green\",\"size\":null,\"price\":50,\"title\":\"test1\"}]', 'dfghdfgh', 50, 0, NULL);
INSERT INTO `orders` VALUES (3, 'fgh', 'jfghj', 'fghjfghj@asdasd.copm', 'fghjfghj', 'Moldovakan15', 'new', '2022-12-13 22:53:00', '2022-12-13 22:56:09', 250, '71ff2709-14d1-4a9c-b942-83b841192f41', NULL, NULL, 'sdfgsdfg', 1, 'fghjfg', 1, 'O-6398ca0c95198', 200, '[{\"product_id\":2,\"qty\":\"1\",\"color\":\"green\",\"size\":null,\"price\":50,\"title\":\"test1\"}]', 'asdasd', 50, 0, 'dfghdfghdgfh');
INSERT INTO `orders` VALUES (4, 'asdfas', 'dasdfa', 'leonid.sahakyan@gmail.com', '123213', 'asdfasdfasdf', 'paid', '2022-12-14 01:59:13', '2022-12-14 01:59:13', 212, 'e7b93556-3740-457b-9d67-0a3ea32b2bee', NULL, NULL, 'fdfdfdf', 1, 'asdfasdf', 1, 'O-6398f5b1a634f', 200, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', 'asdasd', 12, 1, NULL);
INSERT INTO `orders` VALUES (5, 'asdfasii', 'dasdfa', 'leonid.sahakyan@gmail.com', '123213', 'asdfasdfasdf', 'done', '2022-12-14 02:01:48', '2022-12-14 15:01:35', 212, '0d6860c0-bbf7-4379-b5dd-cc7d780ec3c9', NULL, NULL, 'fdfdfdf', 1, 'asdfasdf', 1, 'O-6398f64c974fd', 200, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', 'asdasd', 12, 1, 'asdfasdfdffghjkfk');
INSERT INTO `orders` VALUES (6, 'sdfg', 'sdfgs', 'dfghdgfhasd@asdsad.coim', '234234', 'sdfgsdfg', 'new', '2022-12-14 15:02:11', '2022-12-14 15:02:11', 1036, '9e3ee914-ed8d-45c0-a1e1-ff23aa0cd698', NULL, NULL, 'sdfgsdfgsdfg', 3, 'sdfgsdfg', 2, 'O-6399ad33083c9', 1000, '[{\"product_id\":1,\"qty\":\"3\",\"color\":\"black\",\"size\":\"m\",\"price\":12,\"title\":\"test\"}]', 'sdfgsdfg', 36, 0, NULL);
INSERT INTO `orders` VALUES (7, 'ujki', 'ghjkg', 'hjkghjks@asdsa.com', 'dfghdfg', 'dfghdfgh', 'new', '2022-12-19 15:52:40', '2022-12-19 15:52:40', 212, 'c315be09-5f30-4b0c-b3ac-960a02baf8d4', NULL, NULL, 'dfghdfgh', 1, 'dfgh', 1, 'O-63a050888a6c6', 200, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"m\",\"price\":12,\"title\":\"test\"}]', 'Yerevan', 12, 0, NULL);
INSERT INTO `orders` VALUES (8, 'sdfg', 'sdfgsd', 'fgsdfg@asdasd.com', '213123213', 'asdfasdfasdf', 'new', '2022-12-19 19:29:02', '2022-12-19 19:29:02', 300, '0f0e8318-3dec-47a8-ad0b-879ed3cd695e', NULL, NULL, 'fasdfasdfadsf', 2, 'asdfasdfasd', 1, 'O-63a0833ddef74', 200, '[{\"product_id\":2,\"qty\":\"2\",\"color\":\"green\",\"size\":\"s\",\"price\":50,\"title\":\"test1\"}]', 'asdfadsf', 100, 0, NULL);
INSERT INTO `orders` VALUES (9, 'fdghdfg', 'hdfgh', 'fgdh@asdsad.com', 'sdfgsdfg', 'sdfgsdfgsfdg', 'paid', '2022-12-19 22:59:47', '2022-12-19 22:59:47', 350, 'a81b636a-ac28-49c7-b933-1d61a89e5a8c', NULL, NULL, 'sdfgsdfgsdfgsdfg', 3, 'sdfgsdfgs', 1, 'O-63a0b4a32b131', 200, '[{\"product_id\":2,\"qty\":\"3\",\"color\":\"green\",\"size\":\"s\",\"price\":50,\"title\":\"test1\"}]', 'asdfadsf', 150, 1, NULL);
INSERT INTO `orders` VALUES (10, 'fgdhfg', 'hfgh', 'fghffgh@asdsad.com', '123123', 'asdsdasd', 'new', '2022-12-19 23:25:09', '2022-12-19 23:25:09', 1012, '1b96b6af-631c-46f3-abbf-ceafab57bbbb', NULL, NULL, NULL, 1, 'sdfgsdfg', 2, 'O-63a0ba9524167', 1000, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', 'Yerevan', 12, 0, NULL);
INSERT INTO `orders` VALUES (11, 'fgdhfg', 'hfgh', 'fghffgh@asdsad.com', '123123', 'asdsdasd', 'new', '2022-12-19 23:25:18', '2022-12-19 23:25:18', 1012, '5b6d6f4d-1ad3-4489-afea-9e0389503f90', NULL, NULL, NULL, 1, 'sdfgsdfg', 2, 'O-63a0ba9e7c5d8', 1000, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', 'Yerevan', 12, 0, NULL);
INSERT INTO `orders` VALUES (12, 'asdf', 'asdfasdf', 'onyxsto@gmail.com', '12341234', '1dsfasdfasdf', 'paid', '2023-02-27 12:22:19', '2023-02-27 12:22:19', 212, '35fe30aa-c3c9-487a-8a46-f3606d373672', NULL, NULL, 'asdfasdfasdf', 1, 'asdfasdfasd', 1, 'O-63fc683b9e435', 200, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', '1234123', 12, 1, NULL);
INSERT INTO `orders` VALUES (13, 'sdfgsdf', 'gsdfg', 'sdfgsdfg@asdsadasd.com', '123123', 'Moldovakan15', 'new', '2023-02-27 14:31:59', '2023-02-27 14:31:59', 212, '20b371ff-25d6-44a3-9be4-0c359d9ce44c', NULL, NULL, 'asdfasdfasdfasdf', 1, '12321321', 1, 'O-63fc869fb897f', 200, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', '123123123', 12, 0, NULL);
INSERT INTO `orders` VALUES (14, 'sdfgsdf', 'gsdfg', 'sdfgsdfg@asdsadasd.com', '123123', 'Moldovakan15', 'new', '2023-02-27 14:32:12', '2023-02-27 14:32:12', 212, '013e144f-c5ca-4114-88a1-1dca5b145cc6', NULL, NULL, 'asdfasdfasdfasdf', 1, '12321321', 1, 'O-63fc86ac14bc0', 200, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', '123123123', 12, 0, NULL);
INSERT INTO `orders` VALUES (15, 'cghjfgh', 'jfghj', 'fghjfghj@asdasd.copm', '435345', 'gfhdfgh', 'new', '2023-03-20 11:50:30', '2023-03-20 11:50:30', 1012, '805666d9-c948-4d2c-a917-f4be07b61925', NULL, NULL, 'dfghdfghdfgh', 1, 'fdghdfgh', 2, 'O-64181045e1b81', 1000, '[{\"product_id\":1,\"qty\":\"1\",\"color\":\"black\",\"size\":\"s\",\"price\":12,\"title\":\"test\"}]', 'asdasd', 12, 0, NULL);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title_am` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description_am` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` int NULL DEFAULT NULL,
  `image_id` int NULL DEFAULT NULL,
  `ordering` int NULL DEFAULT NULL,
  `featured` tinyint(1) NULL DEFAULT 0,
  `status` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `parent_id` int NULL DEFAULT NULL,
  `sku` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `gallery_id` int NULL DEFAULT NULL,
  `colors` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sizes` varbinary(255) NULL DEFAULT NULL,
  `temp` tinyint(1) NULL DEFAULT 0,
  `title_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description_ru` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `description_en` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, 'test', 'test', 'teasdfasdfasdf', NULL, 12, 90, 3, 1, 1, '2022-12-13 22:37:06', NULL, NULL, 1, 'test', 52, '[\"black\",\"white\",\"blue\"]', 0x5B2273222C226D222C226C225D, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `product` VALUES (2, 'test1', 'test1', 'looooo', NULL, 50, 92, 2, 1, 0, '2022-12-13 22:37:34', NULL, '2022-12-19 23:22:56', 1, 'test1', 53, '[\"green\",\"red\"]', 0x5B2273225D, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `product` VALUES (3, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 0, '2022-12-14 01:20:08', NULL, NULL, NULL, NULL, 54, NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `product` VALUES (4, 'asdfas', 'dfasdf', 'sdfasdfasdf', NULL, 333, 98, 1, 0, 1, '2022-12-14 17:36:59', NULL, NULL, 1, 'asdfa', 55, '[\"black\",\"white\",\"blue\",\"green\",\"red\"]', 0x5B2273222C226D222C226C222C22786C225D, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `product` VALUES (6, 'sdfgsdfgsdfg', 'hjklhjkl', 'hjklhjklhkl', NULL, 20, 104, 2, 1, 1, '2023-03-20 11:54:58', NULL, NULL, 1, 'sdfgsdfg', 57, '[\"black\",\"white\"]', 0x5B2273225D, NULL, 'ghjk', 'ghjkgh', 'ghjkghjk', 'jkghjkghjk');
INSERT INTO `product` VALUES (7, NULL, NULL, NULL, NULL, NULL, NULL, 5, 0, 0, '2023-04-27 13:20:45', NULL, NULL, NULL, NULL, 58, NULL, NULL, 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'dictionary_sync', '1');

-- ----------------------------
-- Table structure for sliders
-- ----------------------------
DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `image_id` int NULL DEFAULT NULL,
  `ordering` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `temp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deleted_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `LinkType` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sliders
-- ----------------------------
INSERT INTO `sliders` VALUES (1, 'ghjkghjk', 111, '6', '1', '2023-05-03 17:36:09', NULL, '1', NULL, 'google.com', '0');
INSERT INTO `sliders` VALUES (2, 'asdfasdf', 112, '7', '1', '2023-05-03 17:36:25', NULL, '1', NULL, 'yahoo.com', '0');

-- ----------------------------
-- Table structure for timezones
-- ----------------------------
DROP TABLE IF EXISTS `timezones`;
CREATE TABLE `timezones`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of timezones
-- ----------------------------
INSERT INTO `timezones` VALUES (1, '-12:00', '(GMT -12:00) Eniwetok, Kwajalein');
INSERT INTO `timezones` VALUES (2, '-11:00', '(GMT -11:00) Midway Island, Samoa');
INSERT INTO `timezones` VALUES (3, '-10:00', '(GMT -10:00) Hawaii');
INSERT INTO `timezones` VALUES (4, '-09:50', '(GMT -9:30) Taiohae');
INSERT INTO `timezones` VALUES (5, '-09:00', '(GMT -9:00) Alaska');
INSERT INTO `timezones` VALUES (6, '-08:00', '(GMT -8:00) Pacific Time (US &amp; Canada)');
INSERT INTO `timezones` VALUES (7, '-07:00', '(GMT -7:00) Mountain Time (US &amp; Canada)');
INSERT INTO `timezones` VALUES (8, '-06:00', '(GMT -6:00) Central Time (US &amp; Canada), Mexico City');
INSERT INTO `timezones` VALUES (9, '-05:00', '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima');
INSERT INTO `timezones` VALUES (10, '-04:50', '(GMT -4:30) Caracas');
INSERT INTO `timezones` VALUES (11, '-04:00', '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz');
INSERT INTO `timezones` VALUES (12, '-03:50', '(GMT -3:30) Newfoundland');
INSERT INTO `timezones` VALUES (13, '-03:00', '(GMT -3:00) Brazil, Buenos Aires, Georgetown');
INSERT INTO `timezones` VALUES (14, '-02:00', '(GMT -2:00) Mid-Atlantic');
INSERT INTO `timezones` VALUES (15, '-01:00', '(GMT -1:00) Azores, Cape Verde Islands');
INSERT INTO `timezones` VALUES (16, '+00:00', '(GMT) Western Europe Time, London, Lisbon, Casablanca');
INSERT INTO `timezones` VALUES (17, '+01:00', '(GMT +1:00) Brussels, Copenhagen, Madrid, Paris');
INSERT INTO `timezones` VALUES (18, '+02:00', '(GMT +2:00) Kaliningrad, South Africa');
INSERT INTO `timezones` VALUES (19, '+03:00', '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg');
INSERT INTO `timezones` VALUES (20, '+03:50', '(GMT +3:30) Tehran');
INSERT INTO `timezones` VALUES (21, '+04:00', '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi');
INSERT INTO `timezones` VALUES (22, '+04:50', '(GMT +4:30) Kabul');
INSERT INTO `timezones` VALUES (23, '+05:00', '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent');
INSERT INTO `timezones` VALUES (24, '+05:50', '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi');
INSERT INTO `timezones` VALUES (25, '+05:75', '(GMT +5:45) Kathmandu, Pokhar');
INSERT INTO `timezones` VALUES (26, '+06:00', '(GMT +6:00) Almaty, Dhaka, Colombo');
INSERT INTO `timezones` VALUES (27, '+06:50', '(GMT +6:30) Yangon, Mandalay');
INSERT INTO `timezones` VALUES (28, '+07:00', '(GMT +7:00) Bangkok, Hanoi, Jakarta');
INSERT INTO `timezones` VALUES (29, '+08:00', '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong');
INSERT INTO `timezones` VALUES (30, '+08:75', '(GMT +8:45) Eucla');
INSERT INTO `timezones` VALUES (31, '+09:00', '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk');
INSERT INTO `timezones` VALUES (32, '+09:50', '(GMT +9:30) Adelaide, Darwin');
INSERT INTO `timezones` VALUES (33, '+10:00', '(GMT +10:00) Eastern Australia, Guam, Vladivostok');
INSERT INTO `timezones` VALUES (34, '+10:50', '(GMT +10:30) Lord Howe Island');
INSERT INTO `timezones` VALUES (35, '+11:00', '(GMT +11:00) Magadan, Solomon Islands, New Caledonia');
INSERT INTO `timezones` VALUES (36, '+11:50', '(GMT +11:30) Norfolk Island');
INSERT INTO `timezones` VALUES (37, '+12:00', '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka');
INSERT INTO `timezones` VALUES (38, '+12:75', '(GMT +12:45) Chatham Islands');
INSERT INTO `timezones` VALUES (39, '+13:00', '(GMT +13:00) Apia, Nukualofa');
INSERT INTO `timezones` VALUES (40, '+14:00', '(GMT +14:00) Line Islands, Tokelau');

SET FOREIGN_KEY_CHECKS = 1;
