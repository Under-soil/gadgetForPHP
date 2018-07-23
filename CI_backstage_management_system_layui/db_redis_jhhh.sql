/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : db_redis_jhhh

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-20 11:00:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_agent
-- ----------------------------
DROP TABLE IF EXISTS `t_agent`;
CREATE TABLE `t_agent` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(32) NOT NULL COMMENT '帐号',
  `passwd` varchar(64) NOT NULL COMMENT '密码',
  `realname` varchar(64) NOT NULL COMMENT '真实姓名',
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `wechat` varchar(32) NOT NULL COMMENT '微信号',
  `openid` varchar(64) DEFAULT NULL,
  `openid_bak` varchar(128) DEFAULT NULL,
  `bank_code` varchar(20) DEFAULT '',
  `bank_number` varchar(50) DEFAULT '',
  `appuid` int(10) unsigned NOT NULL COMMENT '游戏用户ID',
  `level` int(10) DEFAULT NULL COMMENT '代理级别',
  `code` int(10) unsigned NOT NULL COMMENT '代理邀请码',
  `pcode` int(10) unsigned NOT NULL COMMENT '上级代理邀请码',
  `area_code` int(10) NOT NULL,
  `state` int(10) NOT NULL DEFAULT '1' COMMENT '状态：1正常，2禁止，3删除',
  `balance` double(16,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `freeze_amount` double(16,2) DEFAULT '0.00',
  `total` double(16,2) NOT NULL DEFAULT '0.00' COMMENT '累计金额',
  `member_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员数',
  `agent_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下级代理数',
  `address` varchar(256) NOT NULL COMMENT '省份',
  `create_time` datetime DEFAULT '2017-03-06 00:00:00' COMMENT '添加时间',
  `create_ip` varchar(15) NOT NULL COMMENT '注册ip',
  `login_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `login_ip` varchar(15) DEFAULT '' COMMENT '登录ip',
  `operate_code` int(11) NOT NULL DEFAULT '0',
  `operate_ip` varchar(15) DEFAULT NULL,
  `pwd_strength` tinyint(3) NOT NULL DEFAULT '0',
  `login_failed_num` int(11) NOT NULL DEFAULT '0',
  `can_login_time` int(10) DEFAULT NULL,
  `yunying` int(11) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=117545 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_agent
-- ----------------------------
INSERT INTO `t_agent` VALUES ('117540', 'ceshi', '2b9cfee236af60d5584401f629668968', '测试', '15272042030', '690889880', 'oqJfi1E6iInZ01m7LqCNKg5kJRIk', null, '', '', '17549392', '0', '8000', '0', '8000', '1', '0.00', '0.00', '0.00', '2', '4', '', '2018-07-05 09:02:31', '119.96.209.94', '2018-07-05 11:48:22', '119.96.209.94', '117539', null, '0', '0', null, '0');
INSERT INTO `t_agent` VALUES ('117541', 'ceshi1', '5df2a586587c528751c3b36eaaa0aa50', '测试一', '13886473209', '781241753', 'oqJfi1MM9gxBnvnb97ev40R85PN4', null, '', '', '19507826', '1', '98765', '8000', '8000', '1', '0.00', '0.00', '0.00', '2', '5', '', '2018-07-05 09:18:29', '119.96.209.94', '2018-07-05 15:43:59', '119.96.209.94', '117541', null, '0', '0', null, '0');
INSERT INTO `t_agent` VALUES ('117542', 'ceshi2', '385579633b3076be480d362ccc0a85e3', '测试二', '15234658965', '856523561', 'oqJfi1J0SgU1dAArAbvz1I7DD19E', null, '', '', '13906719', '2', '98989', '98765', '8000', '1', '0.00', '0.00', '0.00', '3', '0', '黄冈', '2018-07-05 10:46:21', '119.96.209.94', '2018-07-05 14:22:06', '119.96.209.94', '117542', null, '0', '0', null, '0');
INSERT INTO `t_agent` VALUES ('117543', 'ceshi3', 'e6e407b1edb2cca3def82992c8ef32d9', '测试三', '15326895689', '235645786', 'oqJfi1DVwuKavk7K8Y_DYYBYSVdk', null, '', '', '14873180', '3', '96396', '98765', '8000', '1', '0.00', '0.00', '0.00', '2', '0', '襄阳', '2018-07-05 10:52:16', '119.96.209.94', '2018-07-05 11:55:47', '119.96.209.94', '117545', null, '0', '0', null, '0');
INSERT INTO `t_agent` VALUES ('117544', 'ceshi4', '5cc6625158fc77c524693ed56422eb68', '测试四', '15232658956', '153654753', 'oqJfi1FvtSaZamj1negBbNDHVhf0', null, '', '', '15372753', '2', '25825', '98765', '8000', '1', '0.00', '0.00', '0.00', '0', '0', '', '2018-07-05 15:45:12', '119.96.209.94', '0000-00-00 00:00:00', '', '0', null, '0', '0', null, '0');

-- ----------------------------
-- Table structure for t_agent_group
-- ----------------------------
DROP TABLE IF EXISTS `t_agent_group`;
CREATE TABLE `t_agent_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `title` char(100) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `rules` text COMMENT '规则id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of t_agent_group
-- ----------------------------
INSERT INTO `t_agent_group` VALUES ('1', '1', '1', '壹级', '', '6,20,1,3,4,5,64,139,222,146,147,194,151,160,152,196,155,177,178,179,180,181,183,186,201,148,195');
INSERT INTO `t_agent_group` VALUES ('2', '1', '1', '贰级', '', '6,146,147,194,151,160,152,196,155,177,178,179,180,181,183,186,191,192,193,201,148,195');
INSERT INTO `t_agent_group` VALUES ('3', '1', '1', '三级', '', '6,146,147,194,151,160,152,196,201,148,195');
INSERT INTO `t_agent_group` VALUES ('100', '0', '1', '运营', '', '6,20,1,3,4,5,64,139,133,136,163,165,166,171,172,141,142,143,144,145,197,146,147,194,149,156,151,160,152,196,153,161,155,177,178,179,180,181,183,186,191,192,193,184,187,185,188,189,190,202,203,204,201,148,195,150,157,158,159');
INSERT INTO `t_agent_group` VALUES ('101', '0', '1', '管理员', '', '6,133,134,162,136,163,165,166,167,168,169,170,171,172,173,174,175,176,146,147,151,160,152,196,155,177,178,179,180,181,183,186,191,192,193,184,187,185,188,189,190,202,203,204,201,150,157,158,159,233,234,235,236,237,238');
INSERT INTO `t_agent_group` VALUES ('127', '0', '1', '系统管理员', '', '6,20,1,3,4,5,64,139,222,21,7,8,9,10,130,137,11,12,13,14,15,16,123,124,125,140,133,134,162,205,136,163,165,166,167,168,169,170,171,172,173,174,175,176,141,142,143,144,145,197,146,147,194,151,160,155,177,178,179,180,181,183,186,191,192,193,184,187,185,188,189,190,202,203,204,201,148,195,150,157,158,159,207,217,218,219,220,221,223,224,225,226,227,228,229,233,234,235,236,237,238,239,240');
INSERT INTO `t_agent_group` VALUES ('138', '0', '1', '客服', '', '6,207,217,218,219,220,221,223,224,225,226,227,228,229');
INSERT INTO `t_agent_group` VALUES ('142', '1', '1', '区域1', '', '6,146,147,194,230,151,160,155,177,178,179,180,181,183,186,191,192,193,184,187,201,150,157,158,159');
INSERT INTO `t_agent_group` VALUES ('143', '0', '1', '11', '', null);

-- ----------------------------
-- Table structure for t_agent_login_log
-- ----------------------------
DROP TABLE IF EXISTS `t_agent_login_log`;
CREATE TABLE `t_agent_login_log` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `login_time` datetime NOT NULL,
  `login_ip` varchar(50) NOT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `del_flag` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1025 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_agent_login_log
-- ----------------------------
INSERT INTO `t_agent_login_log` VALUES ('0000000957', '1', '1', '2018-06-07 18:06:40', '219.140.231.21', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000958', '1', '1', '2018-06-08 09:02:12', '219.140.231.21', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000959', '1', '1', '2018-06-08 09:38:34', '219.140.231.21', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000960', '1', '1', '2018-07-04 14:35:54', '119.96.211.110', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000961', '1', '1', '2018-07-04 14:38:55', '119.96.211.110', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000962', '117539', '1', '2018-07-05 08:55:18', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000963', '117540', '1', '2018-07-05 09:08:40', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000964', '117539', '1', '2018-07-05 09:09:27', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000965', '117540', '1', '2018-07-05 09:13:56', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000966', '117540', '1', '2018-07-05 09:48:36', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000967', '117541', '1', '2018-07-05 09:49:27', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000968', '117540', '1', '2018-07-05 09:50:37', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000969', '117541', '1', '2018-07-05 09:52:22', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000970', '117539', '1', '2018-07-05 09:55:19', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000971', '1', '1', '2018-07-05 09:56:01', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000972', '117540', '1', '2018-07-05 10:08:54', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000973', '117541', '1', '2018-07-05 10:10:14', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000974', '117540', '1', '2018-07-05 10:11:13', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000975', '117539', '1', '2018-07-05 10:12:16', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000976', '117541', '1', '2018-07-05 10:37:42', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000977', '117539', '1', '2018-07-05 10:39:06', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000978', '117539', '1', '2018-07-05 10:43:14', '119.96.211.110', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000979', '117540', '1', '2018-07-05 10:44:30', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000980', '117542', '1', '2018-07-05 10:47:10', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000981', '117542', '1', '2018-07-05 10:48:04', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000982', '117539', '1', '2018-07-05 11:05:56', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000983', '117539', '1', '2018-07-05 11:10:16', '119.96.211.110', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000984', '117539', '1', '2018-07-05 11:11:35', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000985', '117543', '1', '2018-07-05 11:12:54', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000986', '117543', '1', '2018-07-05 11:13:33', '119.96.209.94', null, '1');
INSERT INTO `t_agent_login_log` VALUES ('0000000987', '117539', '1', '2018-07-05 11:23:29', '119.96.211.110', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000988', '117539', '1', '2018-07-05 11:26:56', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000989', '1', '1', '2018-07-05 11:36:25', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000990', '117540', '1', '2018-07-05 11:48:22', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000991', '117539', '1', '2018-07-05 11:49:09', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000992', '117543', '1', '2018-07-05 11:55:18', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000993', '117543', '1', '2018-07-05 11:55:47', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000994', '117539', '1', '2018-07-05 11:59:43', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000995', '117539', '1', '2018-07-05 14:18:28', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000996', '117542', '1', '2018-07-05 14:20:30', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000997', '1', '1', '2018-07-05 14:21:55', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000998', '117542', '1', '2018-07-05 14:22:06', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000000999', '117539', '1', '2018-07-05 14:25:32', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001000', '117541', '1', '2018-07-05 15:18:36', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001001', '117541', '1', '2018-07-05 15:43:59', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001002', '117539', '1', '2018-07-06 08:59:03', '119.96.208.252', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001003', '1', '1', '2018-07-06 09:17:51', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001004', '1', '1', '2018-07-06 11:55:45', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001005', '1', '1', '2018-07-06 14:15:33', '119.96.209.94', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001006', '117539', '1', '2018-07-06 14:27:54', '119.96.208.252', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001007', '117545', '1', '2018-07-19 09:13:12', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001008', '117545', '1', '2018-07-19 09:13:52', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001009', '117545', '1', '2018-07-19 09:20:59', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001010', '117545', '1', '2018-07-19 11:16:13', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001011', '117545', '1', '2018-07-19 11:21:35', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001012', '117545', '1', '2018-07-19 14:47:02', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001013', '117545', '1', '2018-07-19 07:30:46', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001014', '117545', '1', '2018-07-19 07:31:24', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001015', '117545', '1', '2018-07-19 07:31:52', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001016', '117545', '1', '2018-07-19 16:12:30', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001017', '117545', '1', '2018-07-20 08:14:37', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001018', '117545', '1', '2018-07-20 01:28:02', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001019', '117545', '1', '2018-07-20 01:30:29', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001020', '117545', '1', '2018-07-20 01:35:08', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001021', '117545', '1', '2018-07-20 01:35:45', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001022', '117545', '1', '2018-07-20 09:36:22', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001023', '117545', '1', '2018-07-20 01:55:10', '127.0.0.1', null, '0');
INSERT INTO `t_agent_login_log` VALUES ('0000001024', '117545', '1', '2018-07-20 02:38:20', '127.0.0.1', null, '0');

-- ----------------------------
-- Table structure for t_agent_nav
-- ----------------------------
DROP TABLE IF EXISTS `t_agent_nav`;
CREATE TABLE `t_agent_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `mca` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `ico` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `order_number` int(11) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_agent_nav
-- ----------------------------
INSERT INTO `t_agent_nav` VALUES ('1', '0', '系统设置', 'Admin/ShowNav/config', 'cog', '6');
INSERT INTO `t_agent_nav` VALUES ('2', '1', '菜单管理', 'admin/nav/index', null, null);
INSERT INTO `t_agent_nav` VALUES ('4', '0', '权限控制', 'Admin/ShowNav/rule', 'expeditedssl', '5');
INSERT INTO `t_agent_nav` VALUES ('7', '4', '权限管理', 'admin/rule/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('8', '4', '用户组管理', 'admin/group/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('47', '46', '在线统计', 'game/online/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('50', '0', '系统用户管理', 'Admin/user', 'users', '4');
INSERT INTO `t_agent_nav` VALUES ('51', '50', '用户列表', 'admin/user/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('53', '0', '推广管理', 'admin/shownav/agent', 'folder-o', '1');
INSERT INTO `t_agent_nav` VALUES ('54', '53', '个人信息', 'agent/agent_info/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('55', '92', '我的会员', 'agent/member_list/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('57', '92', '用户查询', 'agent/player_query/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('58', '53', '账单明细', 'agent/billing_details/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('59', '53', '今日房间', 'agent/my_room/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('62', '53', '新增推广', 'user/promotion/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('63', '0', '游戏数据', 'Admin/ShowNav/game', 'gamepad', '3');
INSERT INTO `t_agent_nav` VALUES ('64', '63', '区域统计', 'user/area/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('65', '63', '红名&封号', 'game/playerlist/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('66', '63', '在线统计', 'game/online/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('67', '63', '房间列表', 'game/roomlist/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('68', '63', '房间统计', 'game/room/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('69', '63', '每日统计', 'game/daily/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('70', '63', '取款记录', 'withdraw/record/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('71', '63', '开房数据', 'game/roomdata/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('72', '63', '总体明细', 'game/detail/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('73', '63', '未绑定充值', 'game/recharge/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('76', '53', '修改记录', 'user/operate/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('77', '53', '推广升级', 'user/upgrade/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('92', '0', '会员管理', 'Admin/ShowNav/member', 'users', '2');
INSERT INTO `t_agent_nav` VALUES ('94', '53', '新增靓号推广', 'user/promotion/special', '', null);
INSERT INTO `t_agent_nav` VALUES ('95', '53', '推广员列表', 'agent/agent_list/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('96', '0', '游戏配置', 'dev/game/setting', 'cog', '7');
INSERT INTO `t_agent_nav` VALUES ('97', '96', '游戏列表', 'dev/game/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('98', '96', '游戏公告', 'dev/notice/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('99', '96', '公告播放列表', 'dev/message/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('100', '96', '游戏下拉选项', 'dev/game/select', '', null);
INSERT INTO `t_agent_nav` VALUES ('101', '0', '游戏工具', 'admin/nav/tool', 'legal', '8');
INSERT INTO `t_agent_nav` VALUES ('102', '101', '玩家加钻', 'tool/diamond/index', '', null);
INSERT INTO `t_agent_nav` VALUES ('103', '101', '加钻列表', 'tool/diamond/record', '', null);
INSERT INTO `t_agent_nav` VALUES ('104', '101', '创建房间', 'tool/custom_service/index', '', null);

-- ----------------------------
-- Table structure for t_agent_rule
-- ----------------------------
DROP TABLE IF EXISTS `t_agent_rule`;
CREATE TABLE `t_agent_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `order_number` int(11) unsigned DEFAULT '0' COMMENT '排序',
  `ico` varchar(20) DEFAULT NULL COMMENT 'font-awesome图标',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of t_agent_rule
-- ----------------------------
INSERT INTO `t_agent_rule` VALUES ('1', '20', 'Admin/Nav/index', '菜单管理', '1', '1', '', null, null);
INSERT INTO `t_agent_rule` VALUES ('3', '1', 'Admin/Nav/add', '添加菜单', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('4', '1', 'Admin/Nav/edit', '修改菜单', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('5', '1', 'Admin/Nav/delete', '删除菜单', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('6', '0', 'welcome/index', '后台首页', '1', '1', '', '0', 'null');
INSERT INTO `t_agent_rule` VALUES ('7', '21', 'Admin/Rule/index', '权限管理', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('8', '7', 'Admin/Rule/add', '添加权限', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('9', '7', 'Admin/Rule/edit', '修改权限', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('10', '7', 'Admin/Rule/delete', '删除权限', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('11', '21', 'Admin/Group/Index', '用户组管理', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('12', '11', 'Admin/Group/add', '添加用户组', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('13', '11', 'Admin/Group/edit', '修改用户组', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('14', '11', 'Admin/Group/delete', '删除用户组', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('15', '11', 'Admin/Group/rule', '分配权限', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('16', '11', 'Admin/Rule/check_user', '添加成员', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('20', '0', 'Admin/ShowNav/config', '系统设置', '1', '1', '', '6', 'cog');
INSERT INTO `t_agent_rule` VALUES ('21', '0', 'Admin/ShowNav/rule', '权限控制', '1', '1', '', '5', 'expeditedssl');
INSERT INTO `t_agent_rule` VALUES ('64', '1', 'Admin/Nav/order', '菜单排序', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('106', '105', 'Admin/Posts/add_posts', '添加文章', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('107', '105', 'Admin/Posts/edit_posts', '修改文章', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('108', '105', 'Admin/Posts/delete_posts', '删除文章', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('109', '104', 'Admin/Posts/category_list', '分类列表', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('110', '109', 'Admin/Posts/add_category', '添加分类', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('111', '109', 'Admin/Posts/edit_category', '修改分类', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('112', '109', 'Admin/Posts/delete_category', '删除分类', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('117', '109', 'Admin/Posts/order_category', '分类排序', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('118', '105', 'Admin/Posts/order_posts', '文章排序', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('123', '11', 'Admin/Rule/add_user_to_group', '设置为管理员', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('124', '11', 'Admin/Rule/add_admin', '添加管理员', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('125', '11', 'Admin/Rule/edit_admin', '修改管理员', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('130', '7', 'Admin/Group/deal', '分配权限处理', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('133', '0', 'Admin/ShowNav/game', '游戏数据', '1', '1', '', '3', 'gamepad');
INSERT INTO `t_agent_rule` VALUES ('134', '133', 'game/online/index', '在线统计', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('136', '133', 'Game/roomlist/index', '房间列表', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('137', '7', 'Admin/Rule/data', '规则列表', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('139', '1', 'Admin/nav/data', '菜单列表', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('140', '11', 'Admin/Group/data', '用户组列表', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('141', '0', 'admin/User', '系统用户管理', '1', '1', '', '4', 'users');
INSERT INTO `t_agent_rule` VALUES ('142', '141', 'Admin/User/index', '用户列表', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('143', '142', 'admin/User/data', '用户数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('144', '142', 'Admin/User/view', '添加用户页面', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('145', '142', 'Admin/User/add', '添加用户处理', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('146', '0', 'Admin/ShowNav/agent', '推广管理', '1', '1', '', '1', 'folder-o');
INSERT INTO `t_agent_rule` VALUES ('147', '146', 'agent/agent_info/index', '个人信息', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('148', '201', 'agent/member_list/index', '我的会员', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('150', '201', 'agent/player_query/index', '用户查询', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('151', '146', 'agent/billing_details/index', '账单明细', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('152', '146', 'agent/my_room/index', '今日房间', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('155', '146', 'user/promotion/index', '新增推广', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('157', '150', 'agent/player_query/data', '游戏用户详情', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('158', '150', 'agent/player_query/summary', '游戏用户充值合计', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('159', '150', 'agent/player_query/detail', '游戏用户充值明细', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('160', '151', 'agent/billing_details/data', '账单明细数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('162', '134', 'game/online/data', '在线统计数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('163', '136', 'game/roomlist/data', '房间列表数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('165', '133', 'game/room/index', '房间统计', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('166', '165', 'game/room/data', '房间统计数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('167', '133', 'game/daily/index', '每日统计', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('168', '167', 'game/daily/data', '每日统计数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('169', '133', 'withdraw/record/index', '取款记录', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('170', '169', 'withdraw/record/data', '取款数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('171', '133', 'game/roomdata/index', '开房数据', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('172', '171', 'game/roomdata/data', '开房数据详情', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('173', '133', 'game/detail/index', '总体明细', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('174', '173', 'game/detail/summary', '总体明细数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('175', '133', 'game/recharge/index', '未绑定充值', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('176', '175', 'game/recharge/data', '未绑定充值数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('177', '155', 'user/manage/isUsernameExists', '用户名是否存在', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('178', '155', 'user/manage/isAppUIdExists', '检查游戏ID', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('179', '155', 'user/manage/isCodeExists', '检查验证码', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('180', '155', 'user/manage/isPCodeExists', '检查pcode', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('181', '155', 'user/manage/addUser', '添加代理处理', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('183', '146', 'agent/agent_list/index', '推广员列表', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('184', '146', 'user/operate/index', '修改记录', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('185', '146', 'user/upgrade/index', '推广升级', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('186', '183', 'agent/agent_list/data', '代理数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('187', '184', 'user/operate/data', '修改记录数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('188', '185', 'user/upgrade/data', '三级代理数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('189', '185', 'user/upgrade/update', '代理升级处理', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('190', '185', 'user/upgrade/isPCodeExists', '检查pcode', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('191', '183', 'user/manage/setuserstate', '禁用/解禁用户', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('192', '183', 'user/manage/pwdreset', '重置密码', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('193', '183', 'user/manage/useredit', '编辑代理信息', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('194', '147', 'agent/agent_info/transfers', '取款', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('195', '148', 'agent/member_list/data', '我的会员数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('196', '152', 'agent/my_room/data', '今天房间数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('197', '142', 'admin/user/setState', '管理用户禁用/启用', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('201', '0', 'Admin/ShowNav/member', '会员管理', '1', '1', '', '2', 'users');
INSERT INTO `t_agent_rule` VALUES ('202', '146', 'user/promotion/special', '新增靓号推广', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('203', '202', 'user/manage/isspecialcodeexists', '检查靓号是否存在', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('204', '202', 'user/manage/addspecial', '处理添加靓号', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('205', '134', 'game/online/echarts', '图表数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('206', '104', 'Admin/Posts/index', '文章列表', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('207', '0', 'dev/game/setting', '游戏配置', '1', '1', '', '7', 'cog');
INSERT INTO `t_agent_rule` VALUES ('208', '207', 'dev/game/index', '游戏列表', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('209', '208', 'dev/game/setstate', '修改状态', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('210', '208', 'dev/game/save', '修改游戏', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('211', '208', 'dev/game/delete', '删除游戏', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('212', '208', 'dev/game/store', '处理游戏添加', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('213', '208', 'dev/game/table', '游戏数据显示', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('214', '208', 'dev/game/create', '添加游戏', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('215', '208', 'dev/game/data', '游戏数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('217', '207', 'tool/notice/index', '游戏公告', '1', '1', '', '0', '');
INSERT INTO `t_agent_rule` VALUES ('218', '217', 'tool/notice/data', '公告数据', '1', '1', '', '0', 'null');
INSERT INTO `t_agent_rule` VALUES ('219', '217', 'tool/notice/store', '添加公告', '1', '1', '', '0', 'null');
INSERT INTO `t_agent_rule` VALUES ('220', '217', 'tool/notice/delete', '删除公告', '1', '1', '', '0', 'null');
INSERT INTO `t_agent_rule` VALUES ('221', '217', 'tool/notice/save', '保存修改的公告', '1', '1', '', '0', 'null');
INSERT INTO `t_agent_rule` VALUES ('222', '1', 'admin/nav/child', '获取子菜单', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('223', '207', 'dev/message/index', '公告播放列表', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('224', '223', 'dev/message/data', '公告播放数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('225', '223', 'dev/message/exists', '检查公告ID是否存在', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('226', '223', 'dev/message/store', '保存新增数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('227', '223', 'dev/message/save', '保存修改数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('228', '223', 'dev/message/publish', '刷新公告', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('229', '223', 'dev/message/setstate', '设置可用性', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('230', '147', 'agent/agent_info/auto_transfer', '重复发起请求', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('231', '207', 'dev/game/select', '游戏下拉选项', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('232', '231', 'dev/game/savedrop', '游戏下拉菜单修改', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('233', '0', 'admin/nav/tool', '游戏工具', '1', '1', '', '8', 'legal');
INSERT INTO `t_agent_rule` VALUES ('234', '233', 'tool/diamond/index', '玩家加钻', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('235', '234', 'tool/diamond/player', '获取玩家信息', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('236', '234', 'tool/diamond/save', '加钻操作', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('237', '233', 'tool/diamond/record', '加钻列表', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('238', '237', 'tool/diamond/data', '获取列表数据', '1', '1', '', '0', null);
INSERT INTO `t_agent_rule` VALUES ('239', '233', 'tool/custom_service/index', '创建房间', '1', '1', '', null, '');
INSERT INTO `t_agent_rule` VALUES ('240', '239', 'tool/custom_service/save', '保存创建房间数据', '1', '1', '', '0', null);

-- ----------------------------
-- Table structure for t_agent_user
-- ----------------------------
DROP TABLE IF EXISTS `t_agent_user`;
CREATE TABLE `t_agent_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(32) NOT NULL COMMENT '帐号',
  `passwd` varchar(64) NOT NULL COMMENT '密码',
  `level` int(10) DEFAULT NULL COMMENT '代理级别',
  `state` int(10) NOT NULL DEFAULT '1' COMMENT '状态：1正常，2禁止，3删除',
  `create_time` datetime DEFAULT '2017-03-06 00:00:00' COMMENT '添加时间',
  `create_ip` varchar(15) NOT NULL COMMENT '注册ip',
  `login_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `login_ip` varchar(15) DEFAULT '' COMMENT '登录ip',
  `pwd_strength` tinyint(3) NOT NULL DEFAULT '0',
  `login_failed_num` int(11) NOT NULL DEFAULT '0',
  `can_login_time` int(10) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=117547 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_agent_user
-- ----------------------------
INSERT INTO `t_agent_user` VALUES ('1', 'pkguanli', '97d809b27c87a59f23f4188453cfeb53', '127', '1', '2017-03-06 00:00:00', '', '2018-07-06 14:15:33', '119.96.209.94', '3', '0', '0', 'h0d06ramjii9ge5fp2o5iaupccuqr7t4');
INSERT INTO `t_agent_user` VALUES ('117539', 'ytmjguanli', '930799628558c6ab30beb8514b3aae69', '101', '1', '2018-07-04 15:09:45', '119.96.211.110', '2018-07-06 14:27:54', '119.96.208.252', '0', '0', '0', 'neha35crecogv3f2tupi6icdc82bp31m');
INSERT INTO `t_agent_user` VALUES ('117540', 'ceshi', '2b9cfee236af60d5584401f629668968', '0', '1', '2018-07-05 09:02:31', '119.96.209.94', '2018-07-05 11:48:22', '119.96.209.94', '3', '0', '0', 'j5lqde5ssr76rh3iks73q8f18me91q13');
INSERT INTO `t_agent_user` VALUES ('117541', 'ceshi1', '5df2a586587c528751c3b36eaaa0aa50', '1', '1', '2018-07-05 09:18:29', '119.96.209.94', '2018-07-05 15:43:59', '119.96.209.94', '3', '0', '0', 'lnmqqcprvq9ogcdqogaihbgv16l43m0d');
INSERT INTO `t_agent_user` VALUES ('117542', 'ceshi2', '385579633b3076be480d362ccc0a85e3', '2', '1', '2018-07-05 10:46:21', '119.96.209.94', '2018-07-05 14:22:06', '119.96.209.94', '3', '0', '0', 'rk84d5gs3vgpc2fakh9na8ebj5urbnc1');
INSERT INTO `t_agent_user` VALUES ('117543', 'ceshi3', 'e6e407b1edb2cca3def82992c8ef32d9', '2', '1', '2018-07-05 10:52:16', '119.96.209.94', '2018-07-05 11:55:47', '119.96.209.94', '3', '0', '0', 'clgdcd3qa343vbfuvdbh9hdt3f3hvn4t');
INSERT INTO `t_agent_user` VALUES ('117544', 'ceshi4', '5cc6625158fc77c524693ed56422eb68', '2', '1', '2018-07-05 15:45:12', '119.96.209.94', '0000-00-00 00:00:00', '', '0', '0', null, null);
INSERT INTO `t_agent_user` VALUES ('117545', 'xhc', 'e10adc3949ba59abbe56e057f20f883e', '127', '1', '2017-03-06 00:00:00', '', '2018-07-20 02:38:20', '127.0.0.1', '0', '0', '0', 'sivrkg4bl03ekq3vrvsb2a7nug21suco');
INSERT INTO `t_agent_user` VALUES ('117546', 'sjjskjk', '4297f44b13955235245b2497399d7a93', '100', '1', '2018-07-19 08:03:09', '127.0.0.1', '0000-00-00 00:00:00', '', '0', '0', null, null);

-- ----------------------------
-- Function structure for f_dz_next_seq
-- ----------------------------
DROP FUNCTION IF EXISTS `f_dz_next_seq`;
DELIMITER ;;
CREATE DEFINER=`xuebao108`@`%` FUNCTION `f_dz_next_seq`(var VARCHAR(50)) RETURNS varchar(50) CHARSET latin1
BEGIN
RETURN (SELECT current_value FROM t_dz_sequence WHERE NAME = var);

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `t_afterUpdate_on_agent`;
DELIMITER ;;
CREATE TRIGGER `t_afterUpdate_on_agent` AFTER UPDATE ON `t_agent` FOR EACH ROW begin
    begin
        set @t = now();
        if old.username != new.username THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('username', old.username, new.username,old.code,new.operate_code,@t);
        END if;
        if old.passwd != new.passwd THEN
            set @pwd_type = 'passwd';
            if new.operate_code != new.uid THEN
                set @pwd_type = 'passwd_reset';
            end if;
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values(@pwd_type, old.passwd, new.passwd,old.code,new.operate_code,@t);
        END if;
        if old.realname != new.realname THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('realname', old.realname, new.realname,old.code,new.operate_code,@t);
        END if;
        if old.phone != new.phone THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('phone', old.phone, new.phone,old.code,new.operate_code,@t);
        END if;
        if old.wechat != new.wechat THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('wechat', old.wechat, new.wechat,old.code,new.operate_code,@t);
        END if;
        if old.appuid != new.appuid THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('appuid', old.appuid, new.appuid,old.code,new.operate_code,@t);
        END if;
        if old.code != new.code THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('code', old.code, new.code,old.code,new.operate_code,@t);
        END if;
        if old.pcode != new.pcode THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('pcode', old.pcode, new.pcode,old.code,new.operate_code,@t);
        END if;
        if old.area_code != new.area_code THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('area_code', old.area_code, new.area_code,old.code,new.operate_code,@t);
        END if;
        if old.address != new.address THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('address', old.address, new.address,old.code,new.operate_code,@t);
        END if;
        if old.level != new.level THEN
            insert into t_agent_operate_log (change_item,original_content,new_content,agent_code,operate_code,create_time) values('level', old.level, new.level,old.code,new.operate_code,@t);
        END if;
        if old.state != new.state and new.state = 1 THEN
        	update t_agent_login_log set del_flag = 1 where uid = old.uid;
        end if;
    end;
end
;;
DELIMITER ;
