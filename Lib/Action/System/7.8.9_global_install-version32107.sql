set names utf8;
set foreign_key_checks=0;
DROP TABLE IF EXISTS `fx_account`;
CREATE TABLE `fx_account` (
  `a_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户账户ID',
  `a_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '账号类型,0银行，1网上支付',
  `a_apply_bank` varchar(255) NOT NULL DEFAULT '' COMMENT '开户行',
  `a_apply_name` varchar(50) NOT NULL DEFAULT '' COMMENT '开户名',
  `a_account_number` varchar(50) NOT NULL DEFAULT '' COMMENT '账号',
  `a_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为默认账户，0为否，1为是',
  `a_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效',
  `a_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `a_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收款账户';

-- ----------------------------
-- Table structure for fx_admin
-- ----------------------------
DROP TABLE IF EXISTS `fx_admin`;
CREATE TABLE `fx_admin` (
  `u_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_name` varchar(50) NOT NULL DEFAULT '' COMMENT '理员管名称',
  `u_passwd` varchar(100) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `u_lastlogin_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '登录ip',
  `u_real_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员姓名',
  `u_department` varchar(50) NOT NULL DEFAULT '' COMMENT '部门',
  `u_no` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员编号',
  `u_mome` mediumtext COMMENT '管理员备注',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `u_status` smallint(1) NOT NULL DEFAULT '1' COMMENT '是否启用(0不启用,1启用)',
  `u_login_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `u_lastlogin_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `u_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `u_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`u_id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Table structure for fx_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_admin_log`;
CREATE TABLE `fx_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '登陆日志ID',
  `u_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登陆者ID',
  `u_name` varchar(60) NOT NULL DEFAULT '' COMMENT '登陆管理员',
  `log_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登陆时间',
  `log_ip` varchar(15) NOT NULL COMMENT '登陆IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员日志';
DROP TABLE IF EXISTS `fx_announcement`;
CREATE TABLE `fx_announcement` (
  `pn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `pn_title` varchar(255) NOT NULL DEFAULT '' COMMENT '公告标题',
  `pn_content` text NOT NULL COMMENT '公告内容',
  `pn_is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 0否 1是',
  `pn_is_all` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否对全部会员开放权限 0否 1是',
  `pn_read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `pn_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `pn_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `pn_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`pn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='违规公告表';
DROP TABLE IF EXISTS `fx_area_jurisdiction`;
CREATE TABLE `fx_area_jurisdiction` (
  `cr_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '城市区域ID',
  `cr_name` varchar(100) NOT NULL DEFAULT '' COMMENT '城市区域名称',
  `s_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司ID',
  KEY `cr_id` (`cr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='子公司管辖区域';

-- ----------------------------
-- Table structure for fx_article
-- ----------------------------
DROP TABLE IF EXISTS `fx_article`;
CREATE TABLE `fx_article` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章分类id',
  `a_title` varchar(150) NOT NULL DEFAULT '' COMMENT '文章标题',
  `a_content` longtext NOT NULL COMMENT '文章内容',
  `a_author` varchar(30) NOT NULL DEFAULT '' COMMENT '文章作者',
  `a_author_email` varchar(60) NOT NULL DEFAULT '' COMMENT '作者email',
  `a_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo文章关键字',
  `a_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `a_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `a_link` varchar(255) NOT NULL DEFAULT '' COMMENT '外部链接',
  `a_description` varchar(255) DEFAULT '' COMMENT 'seo描述',
  `ul_image_path` varchar(255) DEFAULT NULL COMMENT '文章广告图片地址',
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '附件id(来自fx_package表)',
  `a_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `a_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示(0不显示，1显示)',
  `hot` tinyint(4) DEFAULT '0' COMMENT '热门标记(0:非热门；1:热门）',
  `hits` int(11) DEFAULT '0' COMMENT '点击量',
  `a_desc` varchar(255) DEFAULT NULL COMMENT '商品简介',
  `a_order` int(5) NOT NULL DEFAULT '0' COMMENT '排序（数字越大排序靠前）',
  `a_startime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `a_endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  PRIMARY KEY (`a_id`),
  KEY `cat_id` (`cat_id`) USING BTREE,
  KEY `a_status` (`a_status`),
  KEY `a_is_display` (`a_is_display`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';
DROP TABLE IF EXISTS `fx_article_cat`;
CREATE TABLE `fx_article_cat` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `cat_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `sort_order` tinyint(3) NOT NULL DEFAULT '50' COMMENT '分类排序',
  `parent_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '父分类id',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐显示',
  PRIMARY KEY (`cat_id`),
  KEY `is_recommend` (`is_recommend`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类';
DROP TABLE IF EXISTS `fx_authorize_line`;
CREATE TABLE `fx_authorize_line` (
  `al_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '授权线id',
  `al_name` varchar(100) NOT NULL DEFAULT '' COMMENT '分销授权线名称',
  `al_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为默认(1为是,0为否)',
  `al_valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有效(1为有效,0为无效)',
  `al_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `al_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '?????o?—?é—′',
  `al_modify_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`al_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权线表';
DROP TABLE IF EXISTS `fx_balance_info`;
CREATE TABLE `fx_balance_info` (
  `bi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '结余款调整单ID',
  `bi_sn` varchar(100) NOT NULL COMMENT '结余款调整单单据编号，当前时间戳+6位ID不足补0',
  `bt_id` int(11) NOT NULL DEFAULT '0' COMMENT '结余款类型ID',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员名',
  `bi_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '制单人',
  `bi_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '调整类型：0为收入，1为支出，2为冻结',
  `bi_accounts_bank` varchar(50) DEFAULT NULL COMMENT '收款银行',
  `bi_payeec` varchar(50) DEFAULT NULL COMMENT '收款人',
  `bi_accounts_receivable` varchar(50) DEFAULT '' COMMENT '收款账号',
  `bi_payment_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '付款时间',
  `o_id` bigint(20) DEFAULT NULL COMMENT '订单号',
  `or_id` bigint(20) DEFAULT NULL COMMENT '退款单号',
  `ps_id` bigint(20) DEFAULT NULL COMMENT '收款单号',
  `pc_serial_number` varchar(100) not null default '' comment '充值卡流水号',
  `bi_verify_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '作废状态：0未作废,2已作废',
  `bi_service_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '客审状态：0未审核，1已审核',
  `bi_finance_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '财审状态：0未审核，1已审核',
  `bi_desc` varchar(255) DEFAULT NULL COMMENT '备注',
  `bi_order` int(5) NOT NULL DEFAULT '10' COMMENT '排序（数字越大排序靠前）',
  `bi_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录制单时间',
  `bi_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `single_type` tinyint(1) DEFAULT '1' COMMENT '制单类型：1.系统管理员制单，2.用户制单',
  `local_ip` varchar(100) NOT NULL DEFAULT '' COMMENT '记录ip',
  PRIMARY KEY (`bi_id`),
  UNIQUE KEY `bi_sn` (`bi_sn`) USING BTREE,
  KEY `bt_id` (`bt_id`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `or_id` (`or_id`) USING BTREE,
  KEY `bi_type` (`bi_type`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `bi_order` (`bi_order`) USING BTREE,
  KEY `bi_accounts_receivable` (`bi_accounts_receivable`) USING BTREE,
  KEY `bi_finance_verify` (`bi_finance_verify`) USING BTREE,
  KEY `bi_verify_status` (`bi_verify_status`) USING BTREE,
  KEY `bi_service_verify` (`bi_service_verify`) USING BTREE,
  KEY `bi_create_time` (`bi_create_time`) USING BTREE,
  KEY `bi_update_time` (`bi_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='结余款调整单表';
DROP TABLE IF EXISTS `fx_balance_type`;
CREATE TABLE `fx_balance_type` (
  `bt_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '结余款类型ID',
  `bt_code` int(5) NOT NULL COMMENT '结余款类型代码',
  `bt_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `bt_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '类型描述',
  `bt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型状态：0为停用，1为启用',
  `bt_orderby` int(5) NOT NULL DEFAULT '10' COMMENT '类型排序，数值越大越靠前',
  `bt_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `bt_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`bt_id`),
  UNIQUE KEY `bt_code` (`bt_code`) USING BTREE,
  KEY `bt_status` (`bt_status`) USING BTREE,
  KEY `bt_orderby` (`bt_orderby`) USING BTREE,
  KEY `bt_create_time` (`bt_create_time`) USING BTREE,
  KEY `bt_update_time` (`bt_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='结余款类型表';

DROP TABLE IF EXISTS `fx_balance_verify_log`;
CREATE TABLE `fx_balance_verify_log` (
  `bvl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '操作人名',
  `bi_sn` bigint(20) NOT NULL COMMENT '操作人ID',
  `bvl_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `bvl_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型，0为新增操作，1为作废操作，2为客审操作，3为财审',
  `bvl_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核结果，0新增记录，1为审核通过,2未审核通过',
  `bvl_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`bvl_id`),
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `bvl_type` (`bvl_type`) USING BTREE,
  KEY `bvl_status` (`bvl_status`) USING BTREE,
  KEY `bvl_create_time` (`bvl_create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='结余款调整单审核日志';

-- ----------------------------
-- Table structure for fx_bonus_info
-- ----------------------------
DROP TABLE IF EXISTS `fx_bonus_info`;
CREATE TABLE `fx_bonus_info` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '红包调整单ID',
  `bn_sn` bigint(20) NOT NULL COMMENT '红包调整单单据编号，当前时间戳+6位ID不足补0',
  `bt_id` int(11) NOT NULL DEFAULT '0' COMMENT '红包类型ID',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员名',
  `bn_money` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '制单人',
  `bn_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '调整类型：0为收入，1为支出，2为冻结',
  `o_id` bigint(20) DEFAULT NULL COMMENT '订单号',
  `or_id` bigint(20) DEFAULT NULL COMMENT '退款单号',
  `pc_serial_number` varchar(100) NOT NULL DEFAULT '' COMMENT '充值卡流水号',
  `bn_verify_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '作废状态：0未作废,1已确认,2已作废',
  `bn_service_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '客审状态：0未审核，1已审核',
  `bn_finance_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '财审状态：0未审核，1已审核',
  `bn_desc` varchar(255) DEFAULT NULL COMMENT '备注',
  `bn_order` int(5) NOT NULL DEFAULT '10' COMMENT '排序（数字越大排序靠前）',
  `bn_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录制单时间',
  `bn_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `single_type` tinyint(1) DEFAULT '1' COMMENT '制单类型：1.系统管理员制单，2.用户制单',
  PRIMARY KEY (`bn_id`),
  UNIQUE KEY `bn_sn` (`bn_sn`) USING BTREE,
  KEY `bt_id` (`bt_id`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `or_id` (`or_id`) USING BTREE,
  KEY `bn_type` (`bn_type`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `bn_order` (`bn_order`) USING BTREE,
  KEY `bn_finance_verify` (`bn_finance_verify`) USING BTREE,
  KEY `bn_verify_status` (`bn_verify_status`) USING BTREE,
  KEY `bn_service_verify` (`bn_service_verify`) USING BTREE,
  KEY `bn_create_time` (`bn_create_time`) USING BTREE,
  KEY `bn_update_time` (`bn_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包调整单表';

-- ----------------------------
-- Table structure for fx_bonus_type
-- ----------------------------
DROP TABLE IF EXISTS `fx_bonus_type`;
CREATE TABLE `fx_bonus_type` (
  `bt_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '红包类型ID',
  `bt_code` int(5) NOT NULL COMMENT '红包类型代码',
  `bt_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `bt_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '类型描述',
  `bt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型状态：0为停用，1为启用',
  `bt_orderby` int(5) NOT NULL DEFAULT '10' COMMENT '类型排序，数值越大越靠前',
  `bt_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `bt_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`bt_id`),
  UNIQUE KEY `bt_code` (`bt_code`) USING BTREE,
  KEY `bt_status` (`bt_status`) USING BTREE,
  KEY `bt_orderby` (`bt_orderby`) USING BTREE,
  KEY `bt_create_time` (`bt_create_time`) USING BTREE,
  KEY `bt_update_time` (`bt_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包类型表';

-- ----------------------------
-- Table structure for fx_bonus_verify_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_bonus_verify_log`;
CREATE TABLE `fx_bonus_verify_log` (
  `bvl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '操作人名',
  `bn_sn` bigint(20) NOT NULL COMMENT '红包单据编号',
  `bvl_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `bvl_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型，0为新增操作，1为作废操作，2为客审操作，3为财审',
  `bvl_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核结果，0新增记录，1为审核通过,2未审核通过',
  `bvl_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`bvl_id`),
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `bvl_type` (`bvl_type`) USING BTREE,
  KEY `bvl_status` (`bvl_status`) USING BTREE,
  KEY `bvl_create_time` (`bvl_create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包调整单审核日志';

-- ----------------------------
-- Table structure for fx_cards_info
-- ----------------------------
DROP TABLE IF EXISTS `fx_cards_info`;
CREATE TABLE `fx_cards_info` (
  `ci_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '储值卡调整单ID',
  `ci_sn` bigint(20) NOT NULL COMMENT '储值卡调整单单据编号，当前时间戳+6位ID不足补0',
  `ct_id` int(11) NOT NULL DEFAULT '0' COMMENT '储值卡类型ID',
  `ct_num` varchar(20) NOT NULL DEFAULT '' COMMENT '储值卡卡号',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员名',
  `ci_money` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '制单人',
  `ci_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '调整类型：0为收入，1为支出，2为冻结',
  `o_id` bigint(20) DEFAULT NULL COMMENT '订单号',
  `or_id` bigint(20) DEFAULT NULL COMMENT '退款单号',
  `pc_serial_number` varchar(100) NOT NULL DEFAULT '' COMMENT '充值卡流水号',
  `ci_verify_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '作废状态：0未作废,1已确认,2已作废',
  `ci_service_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '客审状态：0未审核，1已审核',
  `ci_finance_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '财审状态：0未审核，1已审核',
  `ci_desc` varchar(255) DEFAULT NULL COMMENT '备注',
  `ci_order` int(5) NOT NULL DEFAULT '10' COMMENT '排序（数字越大排序靠前）',
  `ci_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录制单时间',
  `ci_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `single_type` tinyint(1) DEFAULT '1' COMMENT '制单类型：1.系统管理员制单，2.用户制单',
  PRIMARY KEY (`ci_id`),
  UNIQUE KEY `ci_sn` (`ci_sn`) USING BTREE,
  KEY `ct_id` (`ct_id`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `or_id` (`or_id`) USING BTREE,
  KEY `ci_type` (`ci_type`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `ci_order` (`ci_order`) USING BTREE,
  KEY `ci_finance_verify` (`ci_finance_verify`) USING BTREE,
  KEY `ci_verify_status` (`ci_verify_status`) USING BTREE,
  KEY `ci_service_verify` (`ci_service_verify`) USING BTREE,
  KEY `ci_create_time` (`ci_create_time`) USING BTREE,
  KEY `ci_update_time` (`ci_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='储值卡调整单表';

-- ----------------------------
-- Table structure for fx_cards_type
-- ----------------------------
DROP TABLE IF EXISTS `fx_cards_type`;
CREATE TABLE `fx_cards_type` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '储值卡类型ID',
  `ct_code` int(5) NOT NULL COMMENT '储值卡类型代码',
  `ct_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `ct_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '类型描述',
  `ct_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型状态：0为停用，1为启用',
  `ct_orderby` int(5) NOT NULL DEFAULT '10' COMMENT '类型排序，数值越大越靠前',
  `ct_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `ct_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`ct_id`),
  UNIQUE KEY `ct_code` (`ct_code`) USING BTREE,
  KEY `ct_status` (`ct_status`) USING BTREE,
  KEY `ct_orderby` (`ct_orderby`) USING BTREE,
  KEY `ct_create_time` (`ct_create_time`) USING BTREE,
  KEY `ct_update_time` (`ct_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='储值卡类型表';

-- ----------------------------
-- Table structure for fx_cards_verify_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_cards_verify_log`;
CREATE TABLE `fx_cards_verify_log` (
  `cvl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '操作人名',
  `ci_sn` bigint(20) NOT NULL COMMENT '储值卡单据编号',
  `cvl_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `cvl_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型，0为新增操作，1为作废操作，2为客审操作，3为财审',
  `cvl_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核结果，0新增记录，1为审核通过,2未审核通过',
  `cvl_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`cvl_id`),
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `cvl_type` (`cvl_type`) USING BTREE,
  KEY `cvl_status` (`cvl_status`) USING BTREE,
  KEY `cvl_create_time` (`cvl_create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='储值卡调整单审核日志';

-- ----------------------------
-- Table structure for fx_city_region
DROP TABLE IF EXISTS `fx_city_region`;
CREATE TABLE `fx_city_region` (
  `cr_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '城市区域ID',
  `cr_parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父类目ID',
  `cr_path` varchar(100) NOT NULL DEFAULT '' COMMENT '类目路径',
  `cr_is_parent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是父类目，0为否，1为是',
  `cr_name` varchar(100) NOT NULL DEFAULT '' COMMENT '城市区域名称',
  `cr_order` int(11) NOT NULL DEFAULT '0' COMMENT '类目排序',
  `cr_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '区域类型，1为国家；2为省/直辖市；3为地级市；4为区/县；',
  `cr_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `cr_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `cr_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`cr_id`),
  KEY `cr_path` (`cr_path`),
  KEY `cr_order` (`cr_order`),
  KEY `cr_status` (`cr_status`),
  KEY `cr_create_time` (`cr_create_time`),
  KEY `cr_update_time` (`cr_update_time`),
  KEY `cr_parent_id` (`cr_parent_id`),
  KEY `cr_is_parent` (`cr_is_parent`),
  KEY `cr_name` (`cr_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='城市区域通用表';

DROP TABLE IF EXISTS `fx_collect_goods`;
CREATE TABLE `fx_collect_goods` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `m_id` int(8) unsigned NOT NULL DEFAULT '0',
  `g_id` int(11) NOT NULL COMMENT '货品id',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `pdt_id` (`g_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏表';
DROP TABLE IF EXISTS `fx_coupon`;
CREATE TABLE `fx_coupon` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `ca_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联优惠券活动表',
  `c_name` varchar(50) NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `c_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '优惠券序列号',
  `c_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `c_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `c_is_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用；0未使用，1已使用',
  `c_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `c_condition_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '使用条件(满足订单多少钱使用)',
  `c_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用状态：0全局，其他为指定用户id（该谁用）',
  `c_used_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用用户id(被谁用了)',
  `c_order_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '使用订单id',
  `c_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `c_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠券类型（0：现金券，1:折扣券）',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_sn` (`c_sn`) USING BTREE,
  KEY `c_used_id` (`c_used_id`) USING BTREE,
  KEY `c_type` (`c_type`),
  KEY `c_name` (`c_name`),
  KEY `c_order_id` (`c_order_id`),
  KEY `c_start_time` (`c_start_time`),
  KEY `c_end_time` (`c_end_time`),
  KEY `c_is_use` (`c_is_use`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券表';

DROP TABLE IF EXISTS `fx_coupon_activities`;
CREATE TABLE `fx_coupon_activities` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `ca_name` varchar(50) NOT NULL DEFAULT '' COMMENT '活动名称',
  `ca_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '同号为优惠券编码,异号为活动生成优惠券规则明细',
  `ca_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '活动类型（0:同号券，1:异号券，2:注册券）',
  `ca_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有效,默认0,为有效',
  `ca_total` int(11) NOT NULL DEFAULT '0' COMMENT '总数',
  `ca_used_num` int(11) NOT NULL DEFAULT '0' COMMENT '已领取的数量',
  `ca_limit_nums` int(11) NOT NULL DEFAULT '0' COMMENT '限制一个会员最多可以参与活动的次数,默认0,不限制',
  `ca_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `ca_ggid` varchar(255) NOT NULL DEFAULT '' COMMENT '所属的商品分组',
  `ca_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动开始时间',
  `ca_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动结束时间',
  `ca_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `c_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠券类型（0：现金券，1:折扣券）',
  `c_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '优惠券可用开始时间',
  `c_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '优惠券可用结束时间',
  `c_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `c_condition_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '使用条件(满足订单多少钱使用)',
  PRIMARY KEY (`ca_id`),
  KEY `ca_name` (`ca_name`),
  KEY `ca_sn` (`ca_sn`), 
  KEY `ca_type` (`ca_type`),
  KEY `ca_status` (`ca_status`),
  KEY `ca_ggid` (`ca_ggid`),
  KEY `ca_start_time` (`ca_start_time`),
  KEY `ca_end_time` (`ca_end_time`),
  KEY `c_start_time` (`c_start_time`),
  KEY `c_end_time` (`c_end_time`),
  KEY `c_type` (`c_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券活动表';

-- ----------------------------
-- Table structure for fx_email_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_email_log`;
CREATE TABLE `fx_email_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发送状态 0,未成功 1,成功',
  `check_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证状态 0,未认证 1,已认证 2,无效',
  `code` text NOT NULL COMMENT '验证码',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `email_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:普通邮件 1:忘记密码 2:邮件验证 3:重置密码',
  PRIMARY KEY (`id`),
  KEY `email` (`email`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `check_status` (`check_status`) USING BTREE,
  KEY `email_type` (`email_type`) USING BTREE,
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮件日志表';

-- ----------------------------
-- Table structure for fx_email_templates
-- ----------------------------
DROP TABLE IF EXISTS `fx_email_templates`;
CREATE TABLE `fx_email_templates` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '模板编码',
  `subject` varchar(200) NOT NULL DEFAULT '' COMMENT '模板标题',
  `content` text NOT NULL COMMENT '模板内容',
  `last_modify` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '模板修改时间',
  `last_send` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '模板发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for fx_feedback
-- ----------------------------
DROP TABLE IF EXISTS `fx_feedback`;
CREATE TABLE `fx_feedback` (
  `msg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父ID默认0',
  `user_id` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_mobile` varchar(200) NOT NULL DEFAULT '' COMMENT '手机号',
  `msg_title` varchar(200) NOT NULL DEFAULT '' COMMENT '标题',
  `msg_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型,0留言；1投诉；2询问；3售后；4求购',
  `msg_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0:未回复，1：已回复)',
  `msg_content` text NOT NULL COMMENT '内容',
  `msg_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `message_img` varchar(80) DEFAULT '' COMMENT '附件',
  `order_id` varchar(11) NOT NULL DEFAULT '0' COMMENT '订单号',
  `msg_area` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内容',
  `file_url` varchar(200) DEFAULT NULL COMMENT '上传附件url',
  `readed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否阅读',
  `msg_address` varchar(180) NOT NULL DEFAULT '' COMMENT '地址',
  PRIMARY KEY (`msg_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `user_name` (`user_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='买家留言';
DROP TABLE IF EXISTS `fx_free_collocation`;
CREATE TABLE `fx_free_collocation` (
  `fc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_title` varchar(200) NOT NULL COMMENT '搭配名称',
  `fc_related_good_id` varchar(200) NOT NULL COMMENT '关联商品ID',
  `fc_create_time` datetime DEFAULT NULL COMMENT '新增时间',
  `fc_update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `fc_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '有效时间开始时间',
  `fc_end_time` datetime DEFAULT '2099-00-00 00:00:00' COMMENT '有效时间结束时间',
  `fc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用，0：停用',
  PRIMARY KEY (`fc_id`),
  KEY `fc_related_good_id` (`fc_related_good_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自由推荐表';
DROP TABLE IF EXISTS `fx_free_recommend`;
CREATE TABLE `fx_free_recommend` (
  `fr_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `fr_name` varchar(100) NOT NULL DEFAULT '' COMMENT '自由搭配名称',
  `fr_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '搭配商品id',
  `fr_goods_picture` varchar(100) NOT NULL DEFAULT '' COMMENT '商品图片',
  `fr_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '搭配价格',
  `fr_original_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '商品原价',
  `fr_statr_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `fr_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `fr_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用 0不启用 1启用',
  PRIMARY KEY (`fr_id`),
  KEY `fr_goods_id` (`fr_goods_id`),
  KEY `fr_name` (`fr_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自由搭配表';
DROP TABLE IF EXISTS `fx_goods`;
CREATE TABLE `fx_goods` (
  `g_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `gb_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品品牌ID',
  `gt_id` int(11) DEFAULT '0' COMMENT '商品类型ID',
  `g_on_sale` tinyint(1) NOT NULL DEFAULT '1' COMMENT '销售状态：1在架，2下架，3预上架',
  `g_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `g_sn` char(255) NOT NULL DEFAULT '' COMMENT '商品编号,规则为：类型ID+品牌ID+时间戳+千分秒+5位随机数（8位）',
  `g_off_sale_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '下架时间',
  `g_on_sale_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上架时间(预上架日期)',
  `g_new` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否新品上架1 是,0 不是,2翻新',
  `g_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否热销产品1是0不是',
  `g_order`  int(5) NOT NULL DEFAULT 0 COMMENT '排序（越小越靠前）',
  `g_retread_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '翻新日期',
  `g_pre_sale_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '预售状态( 0 否,1 是 )',
  `g_gifts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否赠品，0为不是，1为不可正常销售赠品，2为可正常销售赠品',
  `g_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `g_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  `erp_guid` varchar(36) DEFAULT NULL COMMENT 'ERP的GUID',
  `g_related_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '关联类型',
  `g_related_goods_ids` varchar(100) NOT NULL DEFAULT '' COMMENT '关联商品',
  `g_is_prescription_rugs` tinyint(1) NOT NULL DEFAULT '0' COMMENT '医药行业字段：是否处方药，0为非处方药，1为处方药。',
  `g_is_combination_goods` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否组合商品：0不是 1是',
  `thd_gid` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方商品ID',
  `thd_indentify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方对接平台:1,淘宝;2,拍拍;',
  `gm_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品用户ID',
  `taobao_id` varchar(50) NOT NULL DEFAULT '' COMMENT '淘宝商家编码ID',
  `g_art_no` varchar(50) NOT NULL DEFAULT '' COMMENT '对应线下长益商品货号',
  PRIMARY KEY (`g_id`),
  UNIQUE KEY `g_sn` (`g_sn`) USING BTREE,
  UNIQUE KEY `erp_guid` (`erp_guid`) USING BTREE,
  KEY `gb_id` (`gb_id`) USING BTREE,
  KEY `gt_id` (`gt_id`) USING BTREE,
  KEY `g_on_sale` (`g_on_sale`) USING BTREE,
  KEY `g_on_sale_time` (`g_off_sale_time`) USING BTREE,
  KEY `g_off_sale_time` (`g_off_sale_time`) USING BTREE,
  KEY `g_status` (`g_status`) USING BTREE,
  KEY `g_hot` (`g_hot`) USING BTREE,
  KEY `g_new` (`g_new`) USING BTREE,
  KEY `g_pre_sale_status` (`g_pre_sale_status`) USING BTREE,
  KEY `g_is_prescription_rugs` (`g_is_prescription_rugs`) USING BTREE,
  KEY `g_gifts` (`g_gifts`) USING BTREE,
  KEY `g_is_combination_goods` (`g_is_combination_goods`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品基本信息表';

-- ----------------------------
-- Table structure for fx_goods_brand
-- ----------------------------
DROP TABLE IF EXISTS `fx_goods_brand`;
CREATE TABLE `fx_goods_brand` (
  `gb_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `gb_name` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `gb_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `gb_url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `gb_logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'LOGO图片上传地址',
  `gb_detail` text COMMENT '详细说明',
  `gb_display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '无商品时是否在前台显示 0不显示，1显示',
  `gb_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gb_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gb_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `thd_indentify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方对接平台:1,淘宝；2,拍拍；',
  `thd_gbid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方品牌ID，淘宝是属性值ID',
  `gb_sn` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌编码',
  PRIMARY KEY (`gb_id`),
  KEY `gb_name` (`gb_name`) USING BTREE,
  KEY `gb_order` (`gb_order`) USING BTREE,
  KEY `gb_display` (`gb_display`) USING BTREE,
  KEY `gb_status` (`gb_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品品牌表';
DROP TABLE IF EXISTS `fx_goods_category`;
CREATE TABLE `fx_goods_category` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `gc_parent_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '父类目ID',
  `gc_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类分级数，0是一级，1是二级以此类推。',
  `gc_is_parent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是父类目(0不是父级，1是父级)',
  `gc_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类目名称',
  `gc_order` int(11) NOT NULL DEFAULT '0' COMMENT '类目排序',
  `gc_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台是否显示 0不显示 1显示',
  `gc_description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `gc_keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',
  `gc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `thd_catid` varchar(20) DEFAULT '' COMMENT '第三方分类ID',
  `thd_cat_identity` varchar(20) DEFAULT '' COMMENT '第三方分类标识，淘宝：taobao，拍拍：paipai，京东：360buy',
  `thd_cat_info` text COMMENT '第三方分类详细信息',
  `gc_ad_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类目促销图片展示类型（0：Flash,1:图片展示）',
  `gc_is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类目是否热销展示;',
  `gc_pic_url` varchar(255) NOT NULL DEFAULT '' COMMENT '类目图片地址',
  `gc_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类目所属类型;0为默认普通分类;1为楼层属性;2为店铺属性;',
  PRIMARY KEY (`gc_id`),
  KEY `gc_parent_id` (`gc_parent_id`) USING BTREE,
  KEY `gc_is_parent` (`gc_is_parent`) USING BTREE,
  KEY `gc_order` (`gc_order`) USING BTREE,
  KEY `gc_is_display` (`gc_is_display`) USING BTREE,
  KEY `gc_status` (`gc_status`) USING BTREE,
  KEY `gc_name` (`gc_name`),
  KEY `gc_type` (`gc_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类';
DROP TABLE IF EXISTS `fx_goods_comments`;
CREATE TABLE `fx_goods_comments` (
  `gcom_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论人ID，默认值为0，表示匿名用户',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '被评论商品ID',
  `gcom_title` varchar(100) NOT NULL DEFAULT '' COMMENT '评论标题',
  `gcom_content` text NOT NULL COMMENT '评论内容',
  `gcom_mbname` varchar(50) NOT NULL DEFAULT '' COMMENT '评论人昵称',
  `gcom_email` varchar(100) NOT NULL DEFAULT '' COMMENT '评论人邮箱账号',
  `gcom_phone` varchar(200) NOT NULL DEFAULT '' COMMENT '评论人手机',
  `gcom_qq` varchar(20) NOT NULL DEFAULT '' COMMENT '评论人QQ号码(预留字段)',
  `gcom_ip_address` varchar(20) NOT NULL DEFAULT '' COMMENT '评论人IP地址',
  `gcom_star_score` varchar(20) NOT NULL DEFAULT '' COMMENT '评分 20/一星 40/二星 60/三星 80/四星 100/五星',
  `gcom_verify` tinyint(1) NOT NULL DEFAULT '2' COMMENT '审核状态，0审核不通过；1审核通过；2审核中；',
  `gcom_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '记录状态，0：已删除；1：正常；2：进入回收站',
  `gcom_parentid` int(11) NOT NULL DEFAULT '0' COMMENT '回复评论的ID，默认值为0',
  `gcom_contacts` varchar(100) NOT NULL COMMENT '联系方式',
  `gcom_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gcom_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复人ID',
  `gcom_pics` text COMMENT '晒单图片',
  `gcom_order_id` bigint(20) DEFAULT '0' COMMENT '订单号',
  PRIMARY KEY (`gcom_id`),
  KEY `m_id` (`m_id`),
  KEY `g_id` (`g_id`),
  KEY `gcom_star_score` (`gcom_star_score`),
  KEY `gcom_verify` (`gcom_verify`),
  KEY `gcom_status` (`gcom_status`),
  KEY `u_id` (`u_id`),
  KEY `gcom_parentid` (`gcom_parentid`),
  KEY `gcom_update_time` (`gcom_update_time`),
  KEY `gcom_order_id` (`gcom_order_id`),
  KEY `gcom_create_time` (`gcom_create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评论表';
DROP TABLE IF EXISTS `fx_goods_group`;
CREATE TABLE `fx_goods_group` (
  `gg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `gg_name` varchar(20) NOT NULL DEFAULT '' COMMENT '分组名称',
  `gg_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '分组描述',
  `gg_order` int(11) NOT NULL DEFAULT '0' COMMENT '分组排序，数字越小越靠前',
  `gg_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据记录状态，0为删除，1为正常。',
  `gg_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '分组创建时间',
  `gg_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '分组最后更新时间',
  PRIMARY KEY (`gg_id`),
  UNIQUE KEY `gg_name` (`gg_name`),
  KEY `gg_order` (`gg_order`),
  KEY `gg_status` (`gg_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分组表';

-- ----------------------------
-- Table structure for fx_goods_info
-- ----------------------------
DROP TABLE IF EXISTS `fx_goods_info`;
CREATE TABLE `fx_goods_info` (
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `g_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `g_keywords` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `g_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO商品描述',
  `g_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '单价',
  `g_market_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '商品市场价',
  `g_tax_rate` float DEFAULT '0' COMMENT '商品税率',
  `g_stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `g_weight` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '重量',
  `g_unit` varchar(50) NOT NULL DEFAULT '' COMMENT '单位',
  `g_desc` text COMMENT '产品介绍',
  `g_phone_desc` text COMMENT '手机端产品介绍',
  `g_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '商品备注',
  `g_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `g_no_stock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许无库存销售 1允许 0 不允许，暂不启用，需求可以使用预售实现',
  `ma_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '商品最高价，此商品的所有SKU中的最高价格',
  `mi_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '商品最低价，此商品的所有SKU中的最低价格',
  `g_red_num` int(1) NOT NULL DEFAULT '0' COMMENT '商品警戒值',
  `g_source` varchar(20) NOT NULL DEFAULT 'local' COMMENT '商品来源：local：本地，erp：erp，taobao：淘宝，paipai：拍拍',
  `g_custom_field_1` varchar(200) NOT NULL DEFAULT '' COMMENT '商品资料自定义字段1',
  `g_custom_field_2` varchar(200) NOT NULL DEFAULT '' COMMENT '商品资料自定义字段2',
  `g_custom_field_3` varchar(200) NOT NULL DEFAULT '' COMMENT '商品资料自定义字段3',
  `g_custom_field_4` varchar(200) NOT NULL DEFAULT '' COMMENT '商品资料自定义字段4',
  `g_custom_field_5` varchar(200) NOT NULL DEFAULT '' COMMENT '商品资料自定义字段5',
  `g_salenum` int(11) DEFAULT '0' COMMENT '销量',
  `is_exchange` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否积分兑换',
  `point` int(10) NOT NULL DEFAULT '0' COMMENT '商品兑换积分',
  `g_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `g_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `g_collocation_price` decimal(10,3) DEFAULT NULL COMMENT '自由推荐价格',
  `gifts_point` int(10) NOT NULL DEFAULT '0' COMMENT '购买商品赠送积分数',
  `mobile_show`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '手机端是否显示(1显示,0不显示)',
  UNIQUE KEY `gi_id` (`g_id`) USING BTREE,
  KEY `g_name` (`g_name`) USING BTREE,
  KEY `g_keywords` (`g_keywords`) USING BTREE,
  KEY `g_description` (`g_description`) USING BTREE,
  KEY `g_price` (`g_price`) USING BTREE,
  KEY `g_market_price` (`g_market_price`) USING BTREE,
  KEY `g_stock` (`g_stock`) USING BTREE,
  KEY `g_no_stock` (`g_no_stock`) USING BTREE,
  KEY `ma_price` (`ma_price`) USING BTREE,
  KEY `mi_price` (`mi_price`) USING BTREE,
  KEY `g_red_num` (`g_red_num`) USING BTREE,
  KEY `g_source` (`g_source`) USING BTREE,
  KEY `g_salenum` (`g_salenum`) USING BTREE,
  KEY `is_exchange` (`is_exchange`) USING BTREE,
  KEY `point` (`point`) USING BTREE,
  CONSTRAINT `fx_goods_info_ibfk_1` FOREIGN KEY (`g_id`) REFERENCES `fx_goods` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品详细表';

-- ----------------------------
-- Table structure for fx_goods_pictures
-- ----------------------------
DROP TABLE IF EXISTS `fx_goods_pictures`;
CREATE TABLE `fx_goods_pictures` (
  `gp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品图片ID',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `gp_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片地址（相对路径，前面不加斜杠）',
  `gp_order` smallint(5) NOT NULL DEFAULT '0' COMMENT '排序 值越大越靠前',
  `gp_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gp_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gp_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录创建时间',
  PRIMARY KEY (`gp_id`),
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `gp_status` (`gp_status`) USING BTREE,
  KEY `gp_order` (`gp_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品图片表';
DROP TABLE IF EXISTS `fx_goods_products`;
CREATE TABLE `fx_goods_products` (
  `pdt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `g_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '商品货号',
  `pdt_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '货号，规则：商品id+pdt_spec的连续编号',
  `pdt_sale_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '销售价',
  `pdt_cost_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '成本价',
  `pdt_market_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '市场价',
  `pdt_weight` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '重量',
  `pdt_total_stock` int(11) NOT NULL DEFAULT '0' COMMENT '总库存数，即仓库中的实际库存数',
  `pdt_stock` int(11) NOT NULL DEFAULT '0' COMMENT '可下单库存',
  `pdt_freeze_stock` int(11) NOT NULL DEFAULT '0' COMMENT '冻结库存',
  `pdt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `pdt_place` varchar(100) NOT NULL DEFAULT '' COMMENT '货位',
  `pdt_red_num` int(11) NOT NULL DEFAULT '0' COMMENT '货品库存预警值',
  `pdt_max_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量溢出( 单次下单最大值)',
  `pdt_min_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品( 单次下单最小值 )',
  `pdt_price_up` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '售价区间最高价',
  `pdt_price_down` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '售价区间最低价',
  `pdt_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '货品备注',
  `pdt_on_way_stock` int(10) NOT NULL DEFAULT '0' COMMENT 'erp中的在途数',
  `factory_arrival_start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '厂家计划最早到货日',
  `factory_arrival_end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '厂家计划最晚到货日',
  `promise_send_start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '承诺最早发货日',
  `promise_send_end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '承诺最晚发货日',
  `pdt_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `pdt_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `pdt_is_combination_goods` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否组合商品：0不是 1是',
  `pdt_collocation_price` decimal(10,3) DEFAULT NULL COMMENT '自由推荐价格',
  `pdt_g_remark` varchar(255) COMMENT '商品备注',
  `thd_indentify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方对接平台:1,淘宝；2,拍拍；',
  `thd_pdtid` bigint(11) NOT NULL DEFAULT '0' COMMENT '第三方SKU ID',
  `taobao_sku_id` varchar(50) NOT NULL DEFAULT '' COMMENT '淘宝商品规格编码ID',
  PRIMARY KEY (`pdt_id`),
  UNIQUE KEY `pdt_sn` (`pdt_sn`) USING BTREE,
  KEY `thd_indentify` (`thd_indentify`),
  KEY `thd_pdtid` (`thd_pdtid`),
  KEY `pdt_stock` (`pdt_stock`),
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `g_sn` (`g_sn`) USING BTREE,
  KEY `pdt_sale_price` (`pdt_sale_price`) USING BTREE,
  KEY `pdt_cost_price` (`pdt_cost_price`) USING BTREE,
  KEY `pdt_market_price` (`pdt_market_price`) USING BTREE,
  KEY `pdt_status` (`pdt_status`) USING BTREE,
  KEY `pdt_place` (`pdt_place`) USING BTREE,
  KEY `pdt_memo` (`pdt_memo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货品表';
DROP TABLE IF EXISTS `fx_goods_products_modify_log`;
CREATE TABLE `fx_goods_products_modify_log` (
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '被编辑的商品ID',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时涉及的货品ID',
  `pdt_sn` varchar(255) NOT NULL DEFAULT '0' COMMENT '编辑时设计的货品的货号',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID（即后台管理员ID）',
  `gpml_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '操作备注',
  `gpml_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `pdt_sn` (`pdt_sn`) USING BTREE,
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `gpml_create_time` (`gpml_create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品资料编辑日志表 只对部分敏感操作记录日志';
DROP TABLE IF EXISTS `fx_goods_spec`;
CREATE TABLE `fx_goods_spec` (
  `gs_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品规格ID',
  `gs_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格名称',
  `gs_simple_name` varchar(50) NOT NULL DEFAULT '' COMMENT '规格别名',
  `gs_remark` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格备注（暂不启用）',
  `gs_show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示类型，1为文字，2为图片',
  `gs_input_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '输入类型 1文本输入 2选择 3文本域输入 4评分',
  `gs_is_sale_spec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否销售规格 0否，1是',
  `gs_order` int(11) NOT NULL DEFAULT '0' COMMENT '属性排序',
  `gs_is_search` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '属性是否允许搜索',
  `gs_is_system_spec` tinyint(4) NOT NULL DEFAULT '0' COMMENT '属性标识，是否是系统属性，0为非系统属性，1为系统属性。当此字段值为1时，属性不可编辑和删除。',
  `gs_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，1为有效，0为删除',
  `gs_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gs_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最新修改时间',
  `thd_indentify` varchar(20) NOT NULL DEFAULT '0' COMMENT '第三方对接平台:1,淘宝；2,拍拍；',
  `thd_gpid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方属性ID',
  `top_cid` int(11) NOT NULL DEFAULT '0' COMMENT '淘宝商品分类ID，用于批量刷新属性所属类型',
  PRIMARY KEY (`gs_id`),
  KEY `gs_show_type` (`gs_show_type`) USING BTREE,
  KEY `gs_input_type` (`gs_input_type`) USING BTREE,
  KEY `gs_is_sale_spec` (`gs_is_sale_spec`) USING BTREE,
  KEY `gs_status` (`gs_status`) USING BTREE,
  KEY `thd_gpid` (`thd_gpid`),
  KEY `gs_order` (`gs_order`) USING BTREE,
  KEY `gs_is_system_spec` (`gs_is_system_spec`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';

-- ----------------------------
-- Table structure for fx_goods_spec_detail
-- ----------------------------
DROP TABLE IF EXISTS `fx_goods_spec_detail`;
CREATE TABLE `fx_goods_spec_detail` (
  `gsd_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品规格值ID',
  `gs_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品规格ID',
  `gsd_value` varchar(1000) NOT NULL DEFAULT '' COMMENT '明细值',
  `gsd_rgb_value` varchar(10) NOT NULL DEFAULT '' COMMENT '颜色属性的色卡值，16进制RGB色卡值',
  `gsd_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序，升序',
  `gsd_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '明细值图片地址',
  `gsd_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gsd_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gsd_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `thd_indentify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方对接平台:1,淘宝；2,拍拍；',
  `thd_gpid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方属性ID',
  `thd_gpvid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方属性值ID',
  PRIMARY KEY (`gsd_id`),
  KEY `thd_indentify` (`thd_indentify`),
  KEY `thd_gpid` (`thd_gpid`),
  KEY `thd_gpvid` (`thd_gpvid`),
  KEY `gs_id` (`gs_id`) USING BTREE,
  KEY `gsd_order` (`gsd_order`) USING BTREE,
  KEY `gsd_status` (`gsd_status`) USING BTREE,
  KEY `gsd_value` (`gsd_value`(30))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格明细表';

DROP TABLE IF EXISTS `fx_goods_type`;
CREATE TABLE `fx_goods_type` (
  `gt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品类型ID',
  `gt_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品类型名称',
  `gt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，0为不启用，1为启用',
  `gt_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gt_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `gt_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0商品属性，1商品试用属性',
  PRIMARY KEY (`gt_id`),
  KEY `gt_name` (`gt_name`),
  KEY `gt_status` (`gt_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品类型表';
DROP TABLE IF EXISTS `fx_groupbuy`;
CREATE TABLE `fx_groupbuy` (
  `gp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团购ID',
  `gp_title` varchar(255) NOT NULL COMMENT '团购标题',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `gp_picture` varchar(100) NOT NULL COMMENT '团购图片',
  `gp_start_time` datetime NOT NULL COMMENT '活动开始时间',
  `gp_end_time` datetime NOT NULL COMMENT '活动结束时间',
  `gp_deposit_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '定金',
  `gp_per_number` int(10) NOT NULL DEFAULT '0' COMMENT '每人限购数量',
  `gp_overdue_start_time` datetime NOT NULL COMMENT '补交余款开始时间',
  `gp_overdue_end_time` datetime NOT NULL COMMENT '补交余款结束时间',
  `gp_send_point` int(11) NOT NULL DEFAULT '0' COMMENT '赠送积分数',
  `gp_number` int(10) NOT NULL DEFAULT '0' COMMENT '限购数量',
  `gp_pre_number` int(10) NOT NULL DEFAULT '0' COMMENT '虚拟购买数量',
  `gp_desc` text NOT NULL COMMENT '团购介绍',
  `gp_mobile_desc` text NOT NULL COMMENT '手机端描述',
  `gp_goodshow_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示商品详情',
  `gp_now_number` int(10) NOT NULL DEFAULT '0' COMMENT '已团购数量',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `gp_order` int(10) NOT NULL DEFAULT '0' COMMENT '显示次序',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `is_deposit` tinyint(1) DEFAULT '0' COMMENT '是否启用担保金',
  `gp_create_time` datetime NOT NULL COMMENT '团购创建时间',
  `gp_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '团购更新时间',
  `gp_price` decimal(10,3) DEFAULT '0.000' COMMENT '团购初始价',
  `gbb_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购所属品牌类目',
  `gp_tiered_pricing_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '价格阶梯类型',
  `gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购所属分类',
  `gp_is_baoyou` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包邮：0：不包邮；1:包邮',
  `gp_remark` varchar(255) DEFAULT NULL COMMENT '团购简介',
  `gp_start_code` tinyint(1) DEFAULT '0' COMMENT '是否启用验证码',
  PRIMARY KEY (`gp_id`),
  KEY `is_active` (`is_active`),
  KEY `sort_order` (`gp_order`),
  KEY `gp_start_time` (`gp_start_time`),
  KEY `gp_end_time` (`gp_end_time`),
  KEY `g_id` (`g_id`),
  KEY `gp_goodshow_status` (`gp_goodshow_status`),
  KEY `gp_overdue_start_time` (`gp_overdue_start_time`),
  KEY `gp_overdue_end_time` (`gp_overdue_end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品团购表';

-- ----------------------------
-- Table structure for fx_groupbuy_brand
-- ----------------------------
DROP TABLE IF EXISTS `fx_groupbuy_brand`;
CREATE TABLE `fx_groupbuy_brand` (
  `gbb_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `gbb_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类目名称',
  `gbb_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '类目图片',
  `gbb_order` int(11) NOT NULL DEFAULT '0' COMMENT '类目排序',
  `gbb_is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否热门品牌促销 1是 0默认不是',
  `gbb_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台是否显示 0不显示 1显示',
  `gbb_description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `gbb_keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',
  `gbb_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gbb_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gbb_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`gbb_id`),
  KEY `gbb_name` (`gbb_name`) USING BTREE,
  KEY `gbb_order` (`gbb_order`) USING BTREE,
  KEY `gbb_is_display` (`gbb_is_display`) USING BTREE,
  KEY `gbb_status` (`gbb_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购商品品牌类目表';

-- ----------------------------
-- Table structure for fx_groupbuy_category
-- ----------------------------
DROP TABLE IF EXISTS `fx_groupbuy_category`;
CREATE TABLE `fx_groupbuy_category` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `gc_parent_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '父类目ID',
  `gc_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类分级数，0是一级，1是二级以此类推。',
  `gc_is_parent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是父类目(0不是父级，1是父级)',
  `gc_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类目名称',
  `gc_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '类目图片',
  `gc_order` int(11) NOT NULL DEFAULT '0' COMMENT '类目排序',
  `gc_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台是否显示 0不显示 1显示',
  `gc_description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `gc_keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',
  `gc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`gc_id`),
  KEY `gc_parent_id` (`gc_parent_id`) USING BTREE,
  KEY `gc_is_parent` (`gc_is_parent`) USING BTREE,
  KEY `gc_order` (`gc_order`) USING BTREE,
  KEY `gc_is_display` (`gc_is_display`) USING BTREE,
  KEY `gc_status` (`gc_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购商品分类';

-- ----------------------------
-- Table structure for fx_groupbuy_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_groupbuy_log`;
CREATE TABLE `fx_groupbuy_log` (
  `gpl_id` int(11) NOT NULL AUTO_INCREMENT,
  `o_id` bigint(20) NOT NULL COMMENT '订单ID',
  `gp_id` int(10) NOT NULL DEFAULT '0' COMMENT '团购ID',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `g_id` int(10) NOT NULL COMMENT '商品ID',
  `num` int(4) NOT NULL DEFAULT '0' COMMENT '购买数量。取值范围:大于零的整数',
  `gpl_remark` varchar(200) NOT NULL COMMENT '备注',
  PRIMARY KEY (`gpl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购日志表';
DROP TABLE IF EXISTS `fx_groupbuy_set`;
CREATE TABLE `fx_groupbuy_set` (
  `gs_id` int(11) NOT NULL AUTO_INCREMENT,
  `gs_related_city` text NOT NULL COMMENT '关联热销城市',
  `gs_related_price` text NOT NULL COMMENT '价格区间',
  `gs_timeshow_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示剩余时间（1:显示，0不显示）',
  `gs_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `gs_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`gs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购设置表';

-- ----------------------------
-- Table structure for fx_inventory_lock
-- ----------------------------
DROP TABLE IF EXISTS `fx_inventory_lock`;
CREATE TABLE `fx_inventory_lock` (
  `iny_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `iny_num` int(11) NOT NULL DEFAULT '0' COMMENT '分配数量',
  PRIMARY KEY (`iny_id`),
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='BASE:库存锁定/买断 表';

-- ----------------------------
-- Table structure for fx_inventory_pdt_lock
-- ----------------------------
DROP TABLE IF EXISTS `fx_inventory_pdt_lock`;
CREATE TABLE `fx_inventory_pdt_lock` (
  `iny_pdt_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `iny_id` int(11) NOT NULL DEFAULT '0' COMMENT 'lock_id',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '货品id',
  `ipl_num` int(11) NOT NULL DEFAULT '0' COMMENT '货品库存分量',
  `ipl_num_frozen` int(11) NOT NULL DEFAULT '0' COMMENT '货品冻结库存分量',
  `iny_expired_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '过期时间',
  `iny_is_payed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为买断(0为锁定,1为买断)',
  `ipl_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`iny_pdt_id`),
  KEY `iny_expired_time` (`iny_expired_time`) USING BTREE,
  KEY `iny_is_payed` (`iny_is_payed`) USING BTREE,
  KEY `iny_id` (`iny_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `ipl_num` (`ipl_num`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='BASE:货品库存锁定/买断 表';

-- ----------------------------
-- Table structure for fx_invoice_collect
-- ----------------------------
DROP TABLE IF EXISTS `fx_invoice_collect`;
CREATE TABLE `fx_invoice_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动增长id',
  `is_invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开发票 0:否 1:是 ',
  `invoice_type` int(11) NOT NULL DEFAULT '1' COMMENT '发票类型 1普通发票 2增值税发票',
  `invoice_head` varchar(50) NOT NULL DEFAULT '0' COMMENT '发票抬头 1个人 2单位 ',
  `invoice_name` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `invoice_content` varchar(255) NOT NULL DEFAULT '' COMMENT '发票内容',
  `m_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发票收藏用户id ',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认，0为否，1为是',
  `invoice_people` varchar(30) DEFAULT '' COMMENT '个人姓名',
  `invoice_identification_number` varchar(50) DEFAULT '' COMMENT '纳税人识别号',
  `invoice_address` varchar(255) DEFAULT '' COMMENT '注册地址',
  `invoice_phone` varchar(200) DEFAULT '' COMMENT '注册电话',
  `invoice_bank` varchar(60) DEFAULT '' COMMENT '开户银行',
  `invoice_account` varchar(20) DEFAULT '' COMMENT '银行帐户',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `is_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '增值税发票是否审核',
  PRIMARY KEY (`id`),
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发票收藏表';
DROP TABLE IF EXISTS `fx_invoice_config`;
CREATE TABLE `fx_invoice_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动增长id',
  `is_invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开发票 0:否 1:是 ',
  `invoice_type` varchar(11) NOT NULL DEFAULT '0' COMMENT '发票类型 0:不选 1:普通发票 2:增值税发票 格式:普通发票,增值税发票',
  `invoice_head` varchar(11) NOT NULL DEFAULT '0' COMMENT '发票抬头 0:不选 1:个人 2:单位 格式：个人,单位',
  `invoice_content` varchar(255) NOT NULL DEFAULT '' COMMENT '发票内容',
  `is_auto_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '增值税发票自动审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发票配置表';

-- ----------------------------
-- Table structure for fx_jlb_info
-- ----------------------------
DROP TABLE IF EXISTS `fx_jlb_info`;
CREATE TABLE `fx_jlb_info` (
  `ji_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '金币调整单ID',
  `ji_sn` bigint(20) NOT NULL COMMENT '金币调整单单据编号，当前时间戳+6位ID不足补0',
  `jt_id` int(11) NOT NULL DEFAULT '0' COMMENT '金币类型ID',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员名',
  `ji_money` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '制单人',
  `ji_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '调整类型：0为收入，1为支出，2为冻结',
  `o_id` bigint(20) DEFAULT NULL COMMENT '订单号',
  `or_id` bigint(20) DEFAULT NULL COMMENT '退款单号',
  `pc_serial_number` varchar(100) NOT NULL DEFAULT '' COMMENT '充值卡流水号',
  `ji_verify_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '作废状态：0未作废,1已确认,2已作废',
  `ji_service_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '客审状态：0未审核，1已审核',
  `ji_finance_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '财审状态：0未审核，1已审核',
  `ji_desc` varchar(255) DEFAULT NULL COMMENT '备注',
  `ji_order` int(5) NOT NULL DEFAULT '10' COMMENT '排序（数字越大排序靠前）',
  `ji_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录制单时间',
  `ji_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `single_type` tinyint(1) DEFAULT '1' COMMENT '制单类型：1.系统管理员制单，2.用户制单',
  PRIMARY KEY (`ji_id`),
  UNIQUE KEY `ji_sn` (`ji_sn`) USING BTREE,
  KEY `jt_id` (`jt_id`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `or_id` (`or_id`) USING BTREE,
  KEY `ji_type` (`ji_type`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `ji_order` (`ji_order`) USING BTREE,
  KEY `ji_finance_verify` (`ji_finance_verify`) USING BTREE,
  KEY `ji_verify_status` (`ji_verify_status`) USING BTREE,
  KEY `ji_service_verify` (`ji_service_verify`) USING BTREE,
  KEY `ji_create_time` (`ji_create_time`) USING BTREE,
  KEY `ji_update_time` (`ji_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金币调整单表';

-- ----------------------------
-- Table structure for fx_jlb_type
-- ----------------------------
DROP TABLE IF EXISTS `fx_jlb_type`;
CREATE TABLE `fx_jlb_type` (
  `jt_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '金币类型ID',
  `jt_code` int(5) NOT NULL COMMENT '金币类型代码',
  `jt_name` varchar(50) NOT NULL DEFAULT '' COMMENT '类型名称',
  `jt_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '类型描述',
  `jt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型状态：0为停用，1为启用',
  `jt_orderby` int(5) NOT NULL DEFAULT '10' COMMENT '类型排序，数值越大越靠前',
  `jt_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `jt_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`jt_id`),
  UNIQUE KEY `jt_code` (`jt_code`) USING BTREE,
  KEY `jt_status` (`jt_status`) USING BTREE,
  KEY `jt_orderby` (`jt_orderby`) USING BTREE,
  KEY `jt_create_time` (`jt_create_time`) USING BTREE,
  KEY `jt_update_time` (`jt_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金币类型表';

-- ----------------------------
-- Table structure for fx_jlb_verify_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_jlb_verify_log`;
CREATE TABLE `fx_jlb_verify_log` (
  `jvl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '操作人名',
  `ji_sn` bigint(20) NOT NULL COMMENT '金币单据编号',
  `jvl_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `jvl_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型，0为新增操作，1为作废操作，2为客审操作，3为财审',
  `jvl_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核结果，0新增记录，1为审核通过,2未审核通过',
  `jvl_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`jvl_id`),
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `jvl_type` (`jvl_type`) USING BTREE,
  KEY `jvl_status` (`jvl_status`) USING BTREE,
  KEY `jvl_create_time` (`jvl_create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金币调整单审核日志';

-- ----------------------------
-- Table structure for fx_keystore
-- ----------------------------
DROP TABLE IF EXISTS `fx_keystore`;
CREATE TABLE `fx_keystore` (
  `g_id` int(11) NOT NULL COMMENT '商品ID',
  `value` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  KEY `g_id` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品浏览记录表';
DROP TABLE IF EXISTS `fx_log_operation`;
CREATE TABLE `fx_log_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(80) DEFAULT NULL COMMENT '操作人员',
  `action` varchar(200) DEFAULT NULL COMMENT '动作',
  `content` text COMMENT '内容',
  `datetime` datetime DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日志操作记录';
DROP TABLE IF EXISTS `fx_logistic_corp`;
CREATE TABLE `fx_logistic_corp` (
  `lc_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `lc_name` varchar(200) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `lc_jd_name` varchar(50) NOT NULL COMMENT '京东物流公司名称',
  `lc_description` varchar(255) NOT NULL DEFAULT '' COMMENT '物流公司描述',
  `lc_cash_on_delivery` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否货到付款 1是 0否',
  `lc_is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用 0不启用，1启用',
  `lc_ordernum` smallint(4) NOT NULL DEFAULT '0' COMMENT '排序数字越大排位靠前',
  `lc_website` varchar(200) DEFAULT '' COMMENT '物流公司网址',
  `lc_abbreviation_name` varchar(50) NOT NULL DEFAULT '' COMMENT '物流公司简称(字母)',
  `lc_kuaidi100_name` varchar(50) NOT NULL DEFAULT '' COMMENT '快递100物流公司代码。',
  `erp_delivery_guid` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方物流ID',
  `lc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `lc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`lc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='物流公司表';
DROP TABLE IF EXISTS `fx_logistic_type`;
CREATE TABLE `fx_logistic_type` (
  `lt_id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `lc_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送公司id',
  `lt_name` varchar(50) NOT NULL DEFAULT '' COMMENT '配送名称',
  `lt_config` tinyint(1) NOT NULL DEFAULT '1' COMMENT '费用计算方式:1按重量计算，（可扩展）',
  `lt_expressions` text NOT NULL COMMENT '配送公式（josn格式存储）',
  `lt_detail` varchar(255) DEFAULT '' COMMENT '配送说明',
  `lt_protect` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否保价',
  `lt_protect_rate` float(6,0) NOT NULL DEFAULT '0' COMMENT '保价费率',
  `lt_minprice` float(10,0) NOT NULL DEFAULT '0' COMMENT '配送最小金额',
  `lt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:0为废弃，1为有效，2为进入回收站',
  `lt_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `lt_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`lt_id`),
  KEY `lc_id` (`lc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送表';

-- ----------------------------
-- Table structure for fx_lottery
-- ----------------------------
DROP TABLE IF EXISTS `fx_lottery`;
CREATE TABLE `fx_lottery` (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(50) NOT NULL COMMENT '抽奖名称',
  `l_desc` text COMMENT '抽奖描述(活动规则)',
  `l_start_time` datetime NOT NULL COMMENT '抽奖开始时间',
  `l_end_time` datetime NOT NULL COMMENT '抽奖结束时间',
  `l_create_time` datetime NOT NULL COMMENT '创建时间',
  `l_update_time` datetime NOT NULL COMMENT '更新时间',
  `l_number` int(11) NOT NULL DEFAULT '0' COMMENT '每日限购数量',
  `is_consume_pont` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用抽奖消耗积分',
  `consume_point` int(11) NOT NULL DEFAULT '0' COMMENT '每次抽奖消耗多少积分',
  `is_deleted` tinyint(255) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `l_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用（0：不启用，1：启用）',
  `l_detail` text COMMENT '促销规则设置',
  PRIMARY KEY (`l_id`),
  KEY `l_start_time` (`l_start_time`),
  KEY `l_end_time` (`l_end_time`),
  KEY `is_consume_pont` (`is_consume_pont`),
  KEY `is_deleted` (`is_deleted`),
  KEY `status` (`l_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖表';

-- ----------------------------
-- Table structure for fx_lottery_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_lottery_log`;
CREATE TABLE `fx_lottery_log` (
  `ll_id` int(11) NOT NULL AUTO_INCREMENT,
  `ll_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `ul_id` int(11) DEFAULT '0' COMMENT '如果中奖中奖ID',
  `m_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `ll_desc` varchar(200) DEFAULT NULL COMMENT '备注',
  `l_id` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖类型ID',
  PRIMARY KEY (`ll_id`),
  KEY `ol_create_time` (`ll_create_time`),
  KEY `ul_id` (`ul_id`),
  KEY `m_id` (`m_id`),
  KEY `l_id` (`l_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖日志表';

-- ----------------------------
-- Table structure for fx_lottery_user
-- ----------------------------
DROP TABLE IF EXISTS `fx_lottery_user`;
CREATE TABLE `fx_lottery_user` (
  `ul_id` int(11) NOT NULL AUTO_INCREMENT,
  `ul_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '奖品类型（0:未中奖；1:红包;2:神秘大奖）',
  `l_id` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖活动ID',
  `bn_id` int(11) NOT NULL DEFAULT '0' COMMENT '抽中红包对应红包调整单',
  `ul_bonus_money` decimal(10,3) DEFAULT '0.000' COMMENT '类型为红包是红包金额',
  `ul_title` varchar(50) DEFAULT NULL COMMENT '类型为神秘大奖是奖品内容',
  `is_used` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已被抽中',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '抽奖会员',
  `ul_create_time` datetime NOT NULL COMMENT '创建时间',
  `ul_update_time` datetime NOT NULL COMMENT '修改时间',
  `ul_confirm_time` datetime NOT NULL COMMENT '抽奖时间',
  PRIMARY KEY (`ul_id`),
  KEY `ul_type` (`ul_type`),
  KEY `l_id` (`l_id`),
  KEY `bn_id` (`bn_id`),
  KEY `is_used` (`is_used`),
  KEY `m_id` (`m_id`),
  KEY `ul_confirm_time` (`ul_confirm_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品表';

-- ----------------------------
-- Table structure for fx_member_competence
-- ----------------------------
DROP TABLE IF EXISTS `fx_member_competence`;
CREATE TABLE `fx_member_competence` (
  `mc_id` int(11) NOT NULL COMMENT '相关来源id',
  `ml_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级id',
  `mg_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员组id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `mc_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权限分类：1公告，2数据包，3客服，4违规公告',
  KEY `mc_id` (`mc_id`) USING BTREE,
  KEY `ml_id` (`ml_id`) USING BTREE,
  KEY `mg_id` (`mg_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='与会员相关的权限表';

-- ----------------------------
-- Table structure for fx_member_differ_price_rebates_record
-- ----------------------------
DROP TABLE IF EXISTS `fx_member_differ_price_rebates_record`;
CREATE TABLE `fx_member_differ_price_rebates_record` (
  `mdprr_id` int(10) NOT NULL AUTO_INCREMENT,
  `mdprr_pm_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级分销商id',
  `mdprr_pm_name` varchar(50) NOT NULL DEFAULT '' COMMENT '父级分销商名称',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员id',
  `m_name` varchar(50) NOT NULL DEFAULT '' COMMENT '下级分销商名称',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `oi_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单明细id',
  `g_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '商品编号',
  `pdt_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '货品编号',
  `mdprr_nums` int(10) NOT NULL DEFAULT '0' COMMENT '返利商品个数',
  `oi_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '下单时商品的价格',
  `mdprr_pm_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '父级分销商的会员价',
  `mdprr_differ_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '商品差价（和上级分销商之间的差价）',
  `mdprr_theory_rebates_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '理论应返利的金额',
  `mdprr_actual_rebates_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '实际返利金额，当返利计算出现异常时实际返利金额可能为0',
  `mdprr_is_unusual` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '返利是否异常，1：异常，0：正常',
  `mdprr_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录生成时间',
  `mdprr_modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后修改时间',
  PRIMARY KEY (`mdprr_id`),
  KEY `mdprr_pm_id` (`mdprr_pm_id`),
  KEY `m_id` (`m_id`),
  KEY `orderkey` (`o_id`,`oi_id`),
  KEY `g_sn` (`g_sn`),
  KEY `pdt_sn` (`pdt_sn`),
  KEY `mdprr_is_unusual` (`mdprr_is_unusual`),
  KEY `mdprr_create_time` (`mdprr_create_time`),
  KEY `mdprr_pm_name` (`mdprr_pm_name`),
  KEY `m_name` (`m_name`),
  KEY `mdprr_modify_time` (`mdprr_modify_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='差价返利记录表';

-- ----------------------------
-- Table structure for fx_member_payback
-- ----------------------------
DROP TABLE IF EXISTS `fx_member_payback`;
CREATE TABLE `fx_member_payback` (
  `saas_id` int(11) NOT NULL DEFAULT '0' COMMENT 'SAAS ID',
  `m_p_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商id',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `m_o_id` int(11) NOT NULL DEFAULT '0' COMMENT '返利对象id',
  `m_p_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '设置返利金额',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '货品id',
  PRIMARY KEY (`m_p_id`),
  KEY `m_id` (`m_id`),
  KEY `m_o_id` (`m_o_id`),
  KEY `g_id` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='BASE:返利 表';

-- ----------------------------
-- Table structure for fx_member_payback_statistics
-- ----------------------------
DROP TABLE IF EXISTS `fx_member_payback_statistics`;
CREATE TABLE `fx_member_payback_statistics` (
  `mps_id` int(11) NOT NULL AUTO_INCREMENT,
  `oi_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应order_items表的oi_id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应members表m_id',
  `m_o_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应member_payback表的m_o_id',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应order_items表pdt_id,货品ID',
  `mps_payback_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '返利金额',
  `mps_description` varchar(100) DEFAULT NULL COMMENT '返利规则描述信息,member_payback',
  PRIMARY KEY (`mps_id`),
  KEY `mps_index` (`oi_id`,`m_id`,`pdt_id`,`mps_payback_amount`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='分销商返利记录表';

-- ----------------------------
-- Table structure for fx_member_relation
-- ----------------------------
DROP TABLE IF EXISTS `fx_member_relation`;
CREATE TABLE `fx_member_relation` (
  `mr_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `m_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商id',
  `mr_path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `mr_p_id` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `mr_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `mr_child_count` int(11) NOT NULL DEFAULT '0' COMMENT '子节点数量',
  `mr_depth` int(11) NOT NULL DEFAULT '0' COMMENT '深度',
  PRIMARY KEY (`mr_id`),
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `mr_p_id` (`mr_p_id`) USING BTREE,
  KEY `mr_order` (`mr_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='分销商关系表';

-- ----------------------------
-- Table structure for fx_member_sales_set
-- ----------------------------
DROP TABLE IF EXISTS `fx_member_sales_set`;
CREATE TABLE `fx_member_sales_set` (
  `mss_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `m_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商id',
  `mss_time_begin` datetime NOT NULL COMMENT '开始日期',
  `mss_time_end` datetime NOT NULL COMMENT '结束日期',
  `mss_sales` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返利额度',
  PRIMARY KEY (`mss_id`),
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='销售额设定表';

-- ----------------------------
-- Table structure for fx_members
-- ----------------------------
DROP TABLE IF EXISTS `fx_members`;
CREATE TABLE `fx_members` (
  `m_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `m_name` varchar(50) NOT NULL DEFAULT '' COMMENT '会员名',
  `m_password` varchar(32) NOT NULL DEFAULT '' COMMENT '会员密码',
  `m_real_name` varchar(25) NOT NULL DEFAULT '' COMMENT '姓名',
  `m_sex` tinyint(1) NOT NULL DEFAULT '2' COMMENT '性别，0为女，1为男，2为保密',
  `cr_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '联系地址表里面的最终一级的ID',
  `m_address_detail` varchar(255) NOT NULL DEFAULT '' COMMENT '联系地址详细',
  `m_birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `m_zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `m_mobile` varchar(200) NOT NULL DEFAULT '' COMMENT '手机',
  `m_telphone` varchar(200) NOT NULL DEFAULT '' COMMENT '固定电话',
  `m_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员状态（0为停用1 为启用）',
  `m_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
  `ml_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级id',
  `mo_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '在线客服id',
  `m_wangwang` varchar(255) NOT NULL DEFAULT '' COMMENT '旺旺',
  `m_qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ',
  `m_website_url` varchar(255) NOT NULL DEFAULT '' COMMENT '网站地址',
  `m_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经审核，0为未审核，1为审核中，2为审核通过，3为审核未通过,4待审核',
  `m_balance` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '账户余额',
  `open_name`  varchar(50) NOT NULL DEFAULT '' COMMENT '第三方用户名',
  `open_token`  varchar(255) NOT NULL DEFAULT '' COMMENT '第三方登录token',
  `open_source`  varchar(100) NOT NULL DEFAULT '' COMMENT '第三方来源(QQ,新浪,支付宝)',
  `open_id`  varchar(100) NOT NULL DEFAULT '' COMMENT '第三方登录唯一标示ID',
  `m_all_cost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '账户消费总金额',
  `total_point` int(10) NOT NULL DEFAULT '0' COMMENT '当前积分',
  `freeze_point` int(10) NOT NULL DEFAULT '0' COMMENT '当前冻结积分',
  `m_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `m_last_login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后登入时间',
  `m_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  `thd_guid` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方用户唯一标识(包含erp)',
  `m_recommended` varchar(50) DEFAULT NULL COMMENT '推荐人',
  `m_security_deposit` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '会员的保证金就是押金',
  `m_alipay_name` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝账户',
  `m_balance_name` varchar(20) NOT NULL DEFAULT '' COMMENT '支付宝账户或银行账户',
  `m_order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '代理下单审核( 0-否,1-是 )',
  `is_proxy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否申请代理商（0为否，1 为是）',
  `login_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登录方式：1第三方授权登录 0传统登录',
  `m_subcompany_id` int(11) DEFAULT NULL COMMENT '子公司ID',
  `m_bonus` decimal(10,3) NOT NULL COMMENT '红包金额',
  `m_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员类型：1批发商,2供货商,0普通会员',
  `m_cards` decimal(10,3) NOT NULL COMMENT '会员储蓄卡余额',
  `m_jlb` decimal(10,3) NOT NULL COMMENT '会员的金币余额',
  `m_card_no` varchar(36) NOT NULL COMMENT '会员卡卡号',
  `m_ali_card_no` varchar(36) NOT NULL COMMENT '阿里会员卡卡号',
  `m_id_card` varchar(50) NOT NULL DEFAULT '' COMMENT '身份证号',
  `m_head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '会员头像',
  `m_role` ENUM('distributor','buyer') NOT NULL DEFAULT 'buyer' COMMENT '会员角色' ,
  `union_data`  varchar(255) NULL DEFAULT '' COMMENT '来源cps的一些数据 u_id username usersafekey json格式存储',
  `shop_code` varchar(100) NOT NULL DEFAULT '' COMMENT 'O2O店铺代码',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT 'O2O店铺id',
  PRIMARY KEY (`m_id`),
  UNIQUE KEY `m_name` (`m_name`) USING BTREE,
  KEY `a_id` (`cr_id`) USING BTREE,
  KEY `m_status` (`m_status`) USING BTREE,
  KEY `m_create_time` (`m_create_time`) USING BTREE,
  KEY `m_update_time` (`m_update_time`) USING BTREE,
  KEY `m_sex` (`m_sex`) USING BTREE,
  KEY `m_email` (`m_email`) USING BTREE,
  KEY `ml_id` (`ml_id`) USING BTREE,
  KEY `m_verify` (`m_verify`) USING BTREE,
  KEY `open_id` (`open_id`) USING BTREE,
  KEY `thd_guid` (`thd_guid`) USING BTREE,
  KEY `m_role` (`m_role`) USING BTREE,
  KEY `shop_id` (`shop_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员基本表';

DROP TABLE IF EXISTS `fx_members_deposit_log`;
CREATE TABLE `fx_members_deposit_log` (
  `mdl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录主键ID',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `mdl_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '本次更新的金额',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作者id',
  `u_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作者账号',
  `mdl_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`mdl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='保证金跟新记录表';
DROP TABLE IF EXISTS `fx_members_fields`;
CREATE TABLE `fx_members_fields` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(60) NOT NULL COMMENT '自定义属性名',
  `dis_order` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '排序 暂时不用',
  `is_display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示 1 显示 ，0 不显示',
  `list_display` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '会员列表是否显示 1 显示 ，0 不显示',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否自定义 1系统初始化，0是自定义',
  `is_need` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填 1 必填 ,0 可选',
  `is_register` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为注册项 1为注册项 ,0 不为注册项',
  `is_edit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否编辑 0不可编辑 1可以编辑',
  `fields_type` varchar(10) NOT NULL COMMENT '自定义属性类型',
  `fields_content` varchar(20) NOT NULL COMMENT '类型内容',
  `is_status` int(11) DEFAULT '1' COMMENT '记录状态，0为删除，1为有效',
  `fields_point` int(4) NOT NULL DEFAULT '0' COMMENT '赠送积分数',
  PRIMARY KEY (`id`),
  KEY `field_name` (`field_name`),
  KEY `fields_content` (`fields_content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员属性项设置';

-- ----------------------------
-- Table structure for fx_members_fields_info
-- ----------------------------
DROP TABLE IF EXISTS `fx_members_fields_info`;
CREATE TABLE `fx_members_fields_info` (
  `u_id` mediumint(8) unsigned NOT NULL COMMENT '用户Id',
  `field_id` int(10) unsigned NOT NULL COMMENT '会员属性项Id',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员属性项状态（0未审核 1 审核）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员属性项值';
DROP TABLE IF EXISTS `fx_members_group`;
CREATE TABLE `fx_members_group` (
  `mg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员组id',
  `mg_name` varchar(50) NOT NULL DEFAULT '' COMMENT '会员组名称',
  `mg_info` varchar(255) NOT NULL DEFAULT '' COMMENT '会员组描述',
  `mg_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效',
  `mg_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `mg_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`mg_id`),
  KEY `mg_status` (`mg_status`) USING BTREE,
  KEY `mg_create_time` (`mg_create_time`) USING BTREE,
  KEY `mg_update_time` (`mg_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组表';
DROP TABLE IF EXISTS `fx_members_level`;
CREATE TABLE `fx_members_level` (
  `ml_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员等级ID',
  `ml_code` varchar(50) NOT NULL DEFAULT '' COMMENT '会员等级代码',
  `ml_name` varchar(50) NOT NULL DEFAULT '' COMMENT '会员等级名称',
  `ml_discount` decimal(8,3) NOT NULL DEFAULT '0.000' COMMENT '会员等级折扣',
  `ml_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为会员默认等级，0为否，1为是',
  `ml_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效',
  `ml_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `ml_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `ml_erp_guid` varchar(50) NOT NULL DEFAULT '' COMMENT 'erp会员等级guid',
  `ml_order` int(4) NOT NULL DEFAULT '0' COMMENT '会员等级排序字段，越大越靠前，默认为0',
  `ml_up_fee` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '晋升要求',
  `ml_rebate` decimal(8,3) NOT NULL DEFAULT '0.000' COMMENT '返点比例',
  `ml_free_shipping` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包邮，0为否，1为是',
  PRIMARY KEY (`ml_id`),
  UNIQUE KEY `ml_name` (`ml_name`) USING BTREE,
  KEY `ml_status` (`ml_status`) USING BTREE,
  KEY `ml_create_time` (`ml_create_time`) USING BTREE,
  KEY `ml_update_time` (`ml_update_time`) USING BTREE,
  KEY `ml_default` (`ml_default`) USING BTREE,
  KEY `ml_erp_guid` (`ml_erp_guid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员等级表';

-- ----------------------------
-- Table structure for fx_members_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_members_log`;
CREATE TABLE `fx_members_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `m_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户资料日志表';
DROP TABLE IF EXISTS `fx_members_verify`;
CREATE TABLE `fx_members_verify` (
  `m_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `m_name` varchar(50) NOT NULL DEFAULT '' COMMENT '会员名',
  `m_password` varchar(32) NOT NULL DEFAULT '' COMMENT '会员密码',
  `m_real_name` varchar(25) NOT NULL DEFAULT '' COMMENT '姓名',
  `m_sex` tinyint(1) NOT NULL DEFAULT '2' COMMENT '性别，0为女，1为男，2为保密',
  `cr_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '联系地址表里面的最终一级的ID',
  `m_address_detail` varchar(255) NOT NULL DEFAULT '' COMMENT '联系地址详细',
  `m_birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `m_zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `m_mobile` varchar(200) NOT NULL DEFAULT '' COMMENT '手机',
  `m_telphone` varchar(200) NOT NULL DEFAULT '' COMMENT '固定电话',
  `m_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员状态（0为停用1 为启用）',
  `m_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
  `ml_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级id',
  `mo_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '在线客服id',
  `m_wangwang` varchar(255) NOT NULL DEFAULT '' COMMENT '旺旺',
  `m_qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ',
  `m_website_url` varchar(255) NOT NULL DEFAULT '' COMMENT '网站地址',
  `m_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经审核，0为未审核，1为审核中，2为审核通过，3为审核未通过',
  `m_balance` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '账户余额',
  `m_all_cost` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '账户消费总金额',
  `total_point` int(10) NOT NULL DEFAULT '0' COMMENT '当前积分',
  `freeze_point` int(10) NOT NULL DEFAULT '0' COMMENT '当前冻结积分',
  `m_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `m_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `thd_guid` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方用户唯一标识(包含erp)',
  `m_recommended` varchar(50) DEFAULT NULL COMMENT '推荐人',
  `m_security_deposit` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '会员的保证金就是押金',
  `m_alipay_name` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝账户',
  `m_balance_name` varchar(20) NOT NULL DEFAULT '' COMMENT '支付宝账户或银行账户',
  `m_subcompany_id` int(11) DEFAULT NULL COMMENT '子公司ID',
  `m_id_card` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  PRIMARY KEY (`m_id`),
  UNIQUE KEY `m_name` (`m_name`),
  KEY `a_id` (`cr_id`),
  KEY `m_status` (`m_status`),
  KEY `m_create_time` (`m_create_time`),
  KEY `m_update_time` (`m_update_time`),
  KEY `m_sex` (`m_sex`),
  KEY `m_email` (`m_email`),
  KEY `ml_id` (`ml_id`),
  KEY `m_verify` (`m_verify`),
  KEY `thd_guid` (`thd_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员系统默认属性待审核表';
DROP TABLE IF EXISTS `fx_menus`;
CREATE TABLE `fx_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `name` varchar(255) NOT NULL COMMENT '菜单名称',
  `type` varchar(10) NOT NULL DEFAULT '3' COMMENT '菜单属于平台类型：1.B2B,2.B2C,3.B2B2C',
  `group` varchar(50) NOT NULL COMMENT '菜单分组',
  `toporder` int(5) NOT NULL DEFAULT '0' COMMENT '一级菜单排序',
  `suborder` int(5) NOT NULL DEFAULT '0' COMMENT '二级菜单排序',
  `threeorder` int(5) DEFAULT '0' COMMENT '三级菜单排序',
  `url` text COMMENT '菜单链接',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `mstatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示：0.否，1.是',
  `sn` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单唯一标识',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for fx_merger_payment
-- ----------------------------
DROP TABLE IF EXISTS `fx_merger_payment`;
CREATE TABLE `fx_merger_payment` (
  `mp_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '合并支付id',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单id',
  `o_pay` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '每张订单已支付金额',
  `o_all_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '每张订单应付金额',
  `mp_all_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '合并订单总金额',
  `mp_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '合并支付订单创建时间',
  KEY `mp_id` (`mp_id`),
  KEY `o_id` (`o_id`),
  KEY `mp_create_time` (`mp_create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合并支付表';

-- ----------------------------
-- Table structure for fx_mycart
-- ----------------------------
DROP TABLE IF EXISTS `fx_mycart`;
CREATE TABLE `fx_mycart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(200) NOT NULL COMMENT '购物车键值',
  `value` text COMMENT '购物车值',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `key` (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';
DROP TABLE IF EXISTS `fx_nav`;
CREATE TABLE `fx_nav` (
  `n_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '导航id',
  `n_name` varchar(50) NOT NULL COMMENT '导航名称',
  `n_url` varchar(120) NOT NULL COMMENT '导航URL',
  `n_target` varchar(20) NOT NULL DEFAULT '_blank' COMMENT '打开方式',
  `n_category` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `n_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0.停用；1.启用',
  `n_order` int(11) NOT NULL DEFAULT '10',
  `n_position` varchar(10) NOT NULL DEFAULT 'top' COMMENT '导航位置',
  `n_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `n_update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`n_id`),
  UNIQUE KEY `n_name` (`n_name`,`n_position`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='导航栏表';
DROP TABLE IF EXISTS `fx_online_cat`;
CREATE TABLE `fx_online_cat` (
  `oc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `oc_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `oc_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `oc_order` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分类排序',
  `oc_parent_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '父分类id',
  PRIMARY KEY (`oc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服分类';
DROP TABLE IF EXISTS `fx_online_service`;
CREATE TABLE `fx_online_service` (
  `o_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `o_name` varchar(255) NOT NULL DEFAULT '' COMMENT '客服名称，仅用于后台显示用',
  `o_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '客服类型：1为QQ，2为旺旺',
  `o_code` text NOT NULL COMMENT '客服代码，需要从相应网站申请',
  `o_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序值，越大越靠前',
  `o_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用：1已启用，0已停用',
  `oc_parent_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '分类id',
  `mc_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 权限分配id（来自fx_member_competence表中mc_type=3的）',
  `ywy_guid` varchar(36) DEFAULT NULL COMMENT 'erp当中业务员guid 同步标识作用',
  `o_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `o_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后修改时间',
  PRIMARY KEY (`o_id`),
  KEY `oc_parent_id` (`oc_parent_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线客服表';
DROP TABLE IF EXISTS `fx_orders`;
CREATE TABLE `fx_orders` (
  `o_id` bigint(20) unsigned NOT NULL COMMENT '订单编号',
  `o_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '订单sn格式：md5（时间戳+千分秒+用户id）',
  `o_thd_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方支付订单sn',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `o_pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态 0.未支付，1.已支付，2.处理中，3部分支付',
  `o_goods_all_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单商品总价（销售价格带促销）',
  `o_all_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单总价(订单应付金额)',
  `o_tax_rate` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单税额',
  `o_discount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '购物车优惠金额',
  `o_pay` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '已支付金额（订单实付金额）',
  `o_cost_payment` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '支付手续费',
  `o_coupon_menoy` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '优惠券使用金额',
  `o_pre_sale` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单预售 0.否，1.是',
  `o_coupon` tinyint(1) NOT NULL DEFAULT '0' COMMENT '使用优惠劵 0.否，1.是',
  `coupon_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠劵编号',
  `coupon_value` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '优惠劵面额',
  `coupon_start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '优惠劵有效开始日',
  `coupon_end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '优惠劵有效结束日',
  `o_cost_freight` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '配送费用',
  `o_freeze_point` int(10) NOT NULL DEFAULT '0' COMMENT '当前冻结积分',
  `o_reward_point` int(10) NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `o_payment` mediumint(9) NOT NULL DEFAULT '0' COMMENT '支付方式',
  `o_receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人',
  `o_receiver_mobile` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人手机',
  `o_receiver_telphone` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `o_receiver_state` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人省份',
  `o_receiver_city` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人城市',
  `o_receiver_county` varchar(50) NOT NULL DEFAULT '' COMMENT '地区第三级（文字）',
  `o_receiver_address` varchar(500) NOT NULL DEFAULT '' COMMENT '收货人地址',
  `ra_id` int(10) NOT NULL DEFAULT '0' COMMENT '收货地址id（最后一级id）',
  `o_receiver_zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '收货人邮编',
  `o_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单创建时间',
  `o_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单修改时间',
  `o_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态 1.活动，2.死单（作废），3.暂停，4.完成，5.确认收货',
  `o_receiver_email` varchar(150) NOT NULL DEFAULT '' COMMENT '收货人Email',
  `o_receiver_time` varchar(50) NOT NULL DEFAULT '' COMMENT '要求发货时间',
  `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送id',
  `o_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态(0未审核,1审核)',
  `o_buyer_comments` varchar(255) NOT NULL DEFAULT '' COMMENT '买家订单留言',
  `o_seller_comments` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家留言',
  `o_source`  varchar(10) NULL DEFAULT 'pc' COMMENT '订单来源(pc,andriod,ios)',
  `o_source_type` varchar(50) NOT NULL DEFAULT 'local' COMMENT '订单类型（taobao,local,paipai）',
  `o_source_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方来源订单id',
  `o_visitor_id` int(11) NOT NULL DEFAULT '0' COMMENT '?????‰?–1?o—é“oid',
  `erp_sn` varchar(50) NOT NULL DEFAULT '' COMMENT 'erp sn号',
  `is_invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开发票 0:否 1:是 ',
  `invoice_account` varchar(20) DEFAULT '' COMMENT '银行帐户',
  `invoice_bank` varchar(60) DEFAULT '' COMMENT '开户银行',
  `invoice_phone` varchar(200) DEFAULT '' COMMENT '注册电话',
  `invoice_address` varchar(255) DEFAULT '' COMMENT '注册地址',
  `invoice_identification_number` varchar(50) DEFAULT '' COMMENT '纳税人识别号',
  `invoice_people` varchar(30) DEFAULT '' COMMENT '个人姓名',
  `invoice_type` int(11) NOT NULL DEFAULT '1' COMMENT '发票类型',
  `invoice_head` varchar(50) NULL DEFAULT '' COMMENT '发票抬头',
  `invoice_content` VARCHAR(255) NULL DEFAULT '' COMMENT '发票内容',
  `is_evaluate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否评价：0未评价，1已评价，2部分评价',
  `o_qc` varchar(30) NOT NULL DEFAULT '' COMMENT '质检员',
  `o_unfreeze_time` datetime DEFAULT NULL COMMENT '冻结解除时间（延迟发货时间）',
  `admin_id` int(11) DEFAULT NULL COMMENT '管理员操作者ID',
  `cacel_type` tinyint(4) DEFAULT '0' COMMENT '作废类型（1：用户不想要了；2：商品无货；3:重新下单；4:其他原因）',
  `o_total_discount_fee` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '让利金额',
  `o_goods_all_saleprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '销售总价',
  `o_goods_discount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '商品优惠金额',
  `invoice_name` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `o_shipping_remarks` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1.发货先发，缺货后发，2.等缺货一起发，3.修改订单，删除缺货商品',
  `o_promotion_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '促销优惠金额',
  `promotion` text COMMENT '促销信息',
  `initial_o_id` int(11) NOT NULL DEFAULT '0' COMMENT '父订单ID',
  `is_diff` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被拆分过',
  `erp_id` varchar(50) DEFAULT NULL COMMENT '订单所属ERP的ID',
  `o_diff_freight` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '邮费差价',
  `o_addorder_id` int(11) NOT NULL DEFAULT '0' COMMENT '替会员下单的卖家ID',
  `flag_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单旗帜（6个）',
  `o_trd_delivery_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '第三方发货状态1:未发货，2:仓库准备,3:已发货,4：缺货，5：退货，99:异常',
  `o_bonus_money` decimal(10,3) NOT NULL COMMENT '订单使用红包金额',
  `o_reward_jlb` int(10) NOT NULL DEFAULT '0' COMMENT '订单商品促销赠送金币',
  `o_point_money` decimal(10,3) NOT NULL COMMENT '订单使用积分抵扣的金额',
  `o_cards_money` decimal(10,3) NOT NULL COMMENT '订单使用储蓄卡支付的金额',
  `o_jlb_money` decimal(10,3) NOT NULL COMMENT '订单使用金币金额',
  `is_anonymous` tinyint(4) DEFAULT '0' COMMENT '是否是匿名购买(1：是）',
  `o_ip` varchar(50) DEFAULT NULL,
  `o_confirm_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '确认收货时间',
  `promotion_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '优惠金额',
  `o_receiver_idcard` varchar(200) NOT NULL DEFAULT '' comment '收货人身份证号',
  `channel_id`  varchar(255) NULL DEFAULT '' COMMENT 'cps 订单来源',
  `channel_related_info`  varchar(255) NULL DEFAULT '' COMMENT '联合登陆存储的一些相关信息 包括 u_id ',
  PRIMARY KEY (`o_id`),
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `o_source_id` (`o_source_id`) USING BTREE,
  KEY `o_payment` (`o_payment`) USING BTREE,
  KEY `initial_o_id` (`initial_o_id`) USING BTREE,
  KEY `is_diff` (`is_diff`) USING BTREE,
  KEY `o_pay_status` (`o_pay_status`),
  KEY `o_audit` (`o_audit`),
  KEY `o_status` (`o_status`),
  KEY `lt_id` (`lt_id`),
  KEY `o_crate_time` (`o_create_time`),
  KEY `o_receiver_name` (`o_receiver_name`),
  KEY `o_receiver_mobile` (`o_receiver_mobile`),
  KEY `o_receiver_county` (`o_receiver_county`),
  KEY `admin_id` (`admin_id`),
  KEY `o_create_time` (`o_create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单基本表';
DROP TABLE IF EXISTS `fx_orders_delivery`;
CREATE TABLE `fx_orders_delivery` (
  `od_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发货单号',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `od_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '发货单创建时间',
  `od_delivery` varchar(20) NOT NULL DEFAULT '' COMMENT '配送方式',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `od_money` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '配送费用',
  `od_is_protect` varchar(20) NOT NULL DEFAULT 'false' COMMENT '是否保价',
  `od_logi_id` int(11) NOT NULL DEFAULT '0' COMMENT '物流公司id',
  `od_logi_name` varchar(100) NOT NULL DEFAULT '' COMMENT '物流公司',
  `od_logi_no` varchar(50) NOT NULL DEFAULT '' COMMENT '物流单号',
  `u_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作者',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作者id',
  `od_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `od_receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人',
  `od_receiver_mobile` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人手机',
  `od_receiver_telphone` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `od_receiver_area` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人地区',
  `od_receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人地址',
  `od_receiver_zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '收货人邮编',
  `od_receiver_email` varchar(100) NOT NULL DEFAULT '' COMMENT '收货人Email',
  `od_outer_odid` varchar(30) NOT NULL DEFAULT '' COMMENT 'Erp发货单id',
  `od_receiver_city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `od_receiver_province` varchar(50) NOT NULL DEFAULT '' COMMENT '省份',
  `initial_o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '父订单ID',
  `erp_id` varchar(50) NOT NULL COMMENT 'erp的唯一标志',
  PRIMARY KEY (`od_id`),
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货单基本表';
DROP TABLE IF EXISTS `fx_orders_delivery_items`;
CREATE TABLE `fx_orders_delivery_items` (
  `odi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发货详情id',
  `od_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '发货单id',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单id',
  `oi_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单详情id',
  `odi_num` int(10) NOT NULL DEFAULT '0' COMMENT '发货数量',
  PRIMARY KEY (`odi_id`),
  KEY `oi_id` (`oi_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货单详情表';
DROP TABLE IF EXISTS `fx_orders_items`;
CREATE TABLE `fx_orders_items` (
  `oi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单详情id',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号（id）',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '货品id',
  `gt_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型id',
  `g_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '商品编号',
  `oi_g_name` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `oi_cost_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成本价',
  `pdt_sale_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '货品销售原价（单件打折之前的价格）',
  `oi_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '购买单价（单件商品成交价）',
  `oi_score` mediumint(8) NOT NULL DEFAULT '0' COMMENT '商品积分（单件）',
  `oi_nums` mediumint(8) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `oi_sendnum` mediumint(8) NOT NULL DEFAULT '0' COMMENT '已发货数量',
  `oi_point` mediumint(9) NOT NULL DEFAULT '0' COMMENT '赠品扣除积分',
  `oi_refund_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1：正常订单，2:退款中，3退货中,4:退款成功,5退货成功，6：被驳回',
  `o_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '订单sn',
  `pdt_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '货品sn',
  `oi_ship_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发货状态 0.待发货，1.仓库准备，2.已发货，3.缺货，4.退货',
  `oi_single_allowance` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '优惠金额（单价）',
  `oi_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `oi_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  `oi_thd_sale_price` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '商品在第三方平台的售价',
  `oi_type` int(4) NOT NULL DEFAULT '0' COMMENT '商品类型，11:积分+金额兑换 8:预售 7:秒杀商品 6:自由搭配商品 5:团购商品，4:自由推荐商品,3组合商品，2赠品， 1积分商品，0普通商品',
  `ml_rebate` decimal(8,3) NOT NULL DEFAULT '0.000' COMMENT '返点比例',
  `ml_discount` decimal(8,3) NOT NULL DEFAULT '0.000' COMMENT '等级折扣',
  `promotion` varchar(50) NOT NULL DEFAULT '' COMMENT '参与促销信息',
  `erp_id` varchar(50) NOT NULL DEFAULT '' COMMENT '商品所属ERP的ID',
  `fc_id` int(11) NOT NULL DEFAULT '0' COMMENT 'oi_typ=4:自由推荐ID；oi_type=3:组合ID；oi_type=6:自由搭配ID',
  `oi_use_coupon` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '优惠券均摊到订单详情表的金额',
  `oi_coupon_menoy` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '优惠券使用金额',
  `oi_bonus_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单使用红包金额',
  `oi_cards_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单使用储蓄卡支付的金额',
  `oi_jlb_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单使用金币金额',
  `oi_point_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单使用积分抵扣的金额',
  `oi_balance_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '订单使用结余款支付的金额',
  `promotion_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '促销优惠平摊金额',
  PRIMARY KEY (`oi_id`),
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `oi_create_time` (`oi_create_time`) USING BTREE,
  KEY `oi_ship_status` (`oi_ship_status`) USING BTREE,
  KEY `oi_refund_status` (`oi_refund_status`) USING BTREE,
  KEY `oi_type` (`oi_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单详情表';
DROP TABLE IF EXISTS `fx_orders_log`;
CREATE TABLE `fx_orders_log` (
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `ol_behavior` varchar(20) NOT NULL DEFAULT '' COMMENT '操作状态，例如创建、支付、发货等',
  `ol_text` varchar(255) DEFAULT '' COMMENT '日志内容',
  `ol_uname` varchar(30) NOT NULL DEFAULT '' COMMENT '操作人',
  `ol_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '日志创建时间',
  `ol_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单日志ID，主键，自增',
  `ol_desc` blob COMMENT '记录订单片段',
  PRIMARY KEY (`ol_id`),
  KEY `o_id` (`o_id`),
  KEY `ol_behavior` (`ol_behavior`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表';
DROP TABLE IF EXISTS `fx_orders_refunds`;
CREATE TABLE `fx_orders_refunds` (
  `or_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '退款单号',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `or_account` varchar(50) NOT NULL DEFAULT '' COMMENT '银行帐号',
  `or_bank` varchar(50) NOT NULL DEFAULT '' COMMENT '退款银行',
  `or_payee` varchar(50) NOT NULL DEFAULT '' COMMENT '收款人',
  `or_currency` varchar(20) NOT NULL DEFAULT '' COMMENT '货币',
  `or_money` varchar(20) NOT NULL DEFAULT '' COMMENT '金额',
  `or_t_sent` int(10) NOT NULL DEFAULT '0' COMMENT '发款时间',
  `or_t_received` int(10) NOT NULL DEFAULT '0' COMMENT '用户确认收款时间',
  `or_buyer_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '买家退款单备注',
  `or_seller_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家备注',
  `or_refund_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1,退款;2,退货;3,退运费',
  `or_return_sn` varchar(50) NOT NULL DEFAULT '' COMMENT '退款单号，系统自动生成',
  `or_return_logic_sn` varchar(50) NOT NULL DEFAULT '' COMMENT '退货- 买家将所退货物寄回时的物流单号',
  `or_processing_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '退款/退货状态，0:初始状态；1:退款/货成功；2：退款/货被作废',
  `or_service_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '客审',
  `or_finance_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '财审',
  `or_pay_type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0预付款 1在线退款 2线下退款',
  `or_reason` varchar(20) NOT NULL DEFAULT '' COMMENT '退款（退货）理由',
  `or_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '单据创建时间',
  `or_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '单据修改时间',
  `m_name` varchar(30) NOT NULL DEFAULT '' COMMENT '会员名称',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id(后台)',
  `u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `or_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `or_service_u_id` int(11) NOT NULL DEFAULT '0' COMMENT '客审操作人id',
  `or_service_u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '客审管理员名称',
  `or_finance_u_id` int(11) NOT NULL DEFAULT '0' COMMENT '财审操作人',
  `or_finance_u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '财审管理员名称',
  `or_service_time` datetime DEFAULT NULL COMMENT '客服确认时间',
  `or_finance_time` datetime DEFAULT NULL COMMENT '财务确认时间',
  `or_refuse_reason` varchar(200) DEFAULT NULL COMMENT '拒绝理由',
  `or_refunds_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '退款渠道：1预存款 2指定账户 3原路返回',
  `initial_tid` bigint(20) NOT NULL DEFAULT '0' COMMENT '父退款单ID',
  PRIMARY KEY (`or_id`),
  UNIQUE KEY `or_return_sn` (`or_return_sn`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `or_return_logic_sn` (`or_return_logic_sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款单表';
DROP TABLE IF EXISTS `fx_orders_refunds_items`;
CREATE TABLE `fx_orders_refunds_items` (
  `ori_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '退款单明细ID',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `or_id` int(11) NOT NULL DEFAULT '0' COMMENT '退款单ID',
  `oi_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单详情id',
  `ori_num` int(11) NOT NULL DEFAULT '0' COMMENT '退款货品数量',
  `erp_id` varchar(50) NOT NULL COMMENT 'erp的ID',
  PRIMARY KEY (`ori_id`),
  KEY `oi_id` (`oi_id`) USING BTREE,
  KEY `or_id` (`or_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款单明细表';
DROP TABLE IF EXISTS `fx_package`;
CREATE TABLE `fx_package` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '数据包',
  `p_cate` int(11) NOT NULL DEFAULT '0' COMMENT '类型(0其他，1淘宝，2拍拍)',
  `p_title` varchar(100) NOT NULL COMMENT '数据包标题',
  `p_path` varchar(100) NOT NULL COMMENT '数据包路径',
  `p_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0停用，1启用',
  `p_del_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '删除状态：0：已删除；1：正常',
  `p_is_all` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否对全部会员开放权限 0否 1是',
  `p_desc` text NOT NULL COMMENT '数据说明',
  `p_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `p_update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='数据包';
DROP TABLE IF EXISTS `fx_package_log`;
CREATE TABLE `fx_package_log` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '数据包下载日志',
  `m_id` int(11) NOT NULL COMMENT '会员id',
  `p_id` int(11) NOT NULL COMMENT '数据包id',
  `pl_create_time` datetime NOT NULL COMMENT '下载时间',
  PRIMARY KEY (`pl_id`),
  KEY `p_id` (`p_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='数据包下载日志';
DROP TABLE IF EXISTS `fx_payment_cfg`;
CREATE TABLE `fx_payment_cfg` (
  `pc_id` int(11) NOT NULL DEFAULT '0' COMMENT '付支方式主键id（不自增手动添加）',
  `pc_custom_name` varchar(300) NOT NULL DEFAULT '' COMMENT '支付方式',
  `pc_pay_type` varchar(90) NOT NULL DEFAULT '' COMMENT '支付类型',
  `pc_abbreviation` varchar(20) NOT NULL DEFAULT '' COMMENT '首字母简写',
  `pc_config` text null default null comment '支付配置',
  `pc_fee` decimal(11,3) NOT NULL DEFAULT '0.000' COMMENT '费率（手续费）',
  `pc_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `pc_last_modify` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `erp_payment_id` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方支付ID',
  `pc_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0无效，1有效',
  `pc_trd` tinyint(1) NOT NULL DEFAULT '0' COMMENT '否是第三方支付方式，0：否；1：是',
  `pc_position` int(11) NOT NULL DEFAULT '0' COMMENT '支付方式排序',
  `pc_source` int(11) DEFAULT NULL COMMENT '1 PC端,3 PC端或APP,4 wap ,5 PC端或wap,6 APP 或wap ,其他 PC 端 或APP或 wap ',
  PRIMARY KEY (`pc_id`),
  KEY `pc_pay_type` (`pc_pay_type`),
  KEY `pc_abbreviation` (`pc_abbreviation`),
  KEY `pc_source` (`pc_source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付配置表';

-- ----------------------------
-- Table structure for fx_payment_serial
-- ----------------------------
DROP TABLE IF EXISTS `fx_payment_serial`;
CREATE TABLE `fx_payment_serial` (
  `ps_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '支付序列编号',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `pc_code` varchar(30) NOT NULL DEFAULT '0' COMMENT '支付类型编号',
  `ps_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '支付总金额',
  `ps_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:支付，1:充值',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单id，如果0则表示充值',
  `ps_gateway_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '网关流水号',
  `ps_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:为完成，1:成功，2:已支付到担保方，3:付款至担保方结算完成',
  `ps_status_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '支付状态代码',
  `pay_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当前支付类型：0全额支付 1定金支付 2尾款支付',
  `ps_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `ps_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`ps_id`),
  KEY `pc_code` (`pc_code`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `ps_type` (`ps_type`),
  KEY `ps_gateway_sn` (`ps_gateway_sn`),
  KEY `ps_status` (`ps_status`),
  KEY `ps_update_time` (`ps_update_time`),
  KEY `o_id` (`o_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付序列表';
DROP TABLE IF EXISTS `fx_point_config`;
CREATE TABLE `fx_point_config` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动增长id',
  `is_consumed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分累计方式 0:不使用积分 1:按每笔订单中商品总价格计算积分 ',
  `cinsumed_channel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单积分节点：0发货后 1确认收货后 2订单完成后',
  `consumed_ratio` float DEFAULT NULL COMMENT '积分换算比率',
  `regist_points` bigint(20) DEFAULT NULL COMMENT '注册会员赠送积分',
  `recommend_points` bigint(20) DEFAULT NULL COMMENT '会员评论赠送积分',
  `invites_points` bigint(20) DEFAULT NULL COMMENT '会员邀请好友赠送积分',
  `is_buy_consumed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用积分抵金(0:不启用；1：启用)',
  `consumed_buy_ratio` int(11) NOT NULL DEFAULT '0' COMMENT '积分抵金比率应该是大于0小于等于100的数字（小数点后最多两位抵扣。100表示可完全用积分）',
  `consumed_points` float DEFAULT NULL COMMENT '每换1分钱需要抵用的积分数（不超过999999）',
  `again_recommend_points` int(11) NOT NULL DEFAULT '0' COMMENT '再次评价完成并审核成功发放,享受积分翻倍',
  `show_recommend_points` int(11) NOT NULL DEFAULT '0' COMMENT '会员晒单,评定审核成功后发放,享受积分翻倍',
  `login_points` int(11) NOT NULL DEFAULT '0' COMMENT ' 每日第一次手动登陆获得,不享受积分翻倍',
  `sign_points` int(11) NOT NULL DEFAULT '0' COMMENT '每日签到成功后赠送,不享受积分翻倍',
  `is_low_consumed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用积分抵扣最低额(0:不启用；1：启用)',
  `low_consumed_points` int(11) DEFAULT '100' COMMENT '积分抵扣最低额：(大于等于100的整数)',
  PRIMARY KEY (`sc_id`),
  KEY `is_consumed` (`is_consumed`),
  KEY `consumed_ratio` (`consumed_ratio`),
  KEY `is_buy_consumed` (`is_buy_consumed`),
  KEY `consumed_buy_ratio` (`consumed_buy_ratio`),
  KEY `consumed_points` (`consumed_points`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `fx_point_log`;
CREATE TABLE `fx_point_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员m_id',
  `o_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `consume_point` int(10) NOT NULL DEFAULT '0' COMMENT '消耗积分',
  `reward_point` int(10) NOT NULL DEFAULT '0' COMMENT '获得积分',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '类型(0:购物赠送；1：购物消耗；2：注册奖励积分；3：评论送积分；4：订单退货成功还原冻结积分；5：管理员积分调整；6：积分冻结；7：作废订单成功还原冻结积分 8:订单作废还原冻结积分；9：抽奖消耗；10:签到赠送积分；11：晒单；12：会员邀请好友；13会员登陆；14推荐注册 15:晒单)',
  `memo` varchar(40) NOT NULL DEFAULT '' COMMENT '摘要',
  `u_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `m_id` (`m_id`),
  KEY `o_id` (`o_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ----------------------------
-- Table structure for fx_points_level
-- ----------------------------
DROP TABLE IF EXISTS `fx_points_level`;
CREATE TABLE `fx_points_level` (
  `pl_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '积分等级ID',
  `pl_code` varchar(50) NOT NULL DEFAULT '' COMMENT '积分等级代码',
  `pl_name` varchar(50) NOT NULL DEFAULT '' COMMENT '积分等级名称',
  `pl_discount` float(8,3) NOT NULL COMMENT '积分等级倍数',
  `pl_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为积分默认等级，0为否，1为是',
  `pl_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效',
  `pl_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `pl_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `pl_erp_guid` varchar(50) NOT NULL DEFAULT '' COMMENT 'erp积分等级guid',
  `pl_order` int(4) NOT NULL DEFAULT '0' COMMENT '积分等级排序字段，越大越靠前，默认为0',
  `pl_up_fee` int(10) NOT NULL DEFAULT '0' COMMENT '晋升要求',
  PRIMARY KEY (`pl_id`),
  UNIQUE KEY `pl_name` (`pl_name`) USING BTREE,
  KEY `pl_status` (`pl_status`) USING BTREE,
  KEY `pl_create_time` (`pl_create_time`) USING BTREE,
  KEY `pl_update_time` (`pl_update_time`) USING BTREE,
  KEY `pl_default` (`pl_default`) USING BTREE,
  KEY `pl_erp_guid` (`pl_erp_guid`) USING BTREE,
  KEY `pl_up_fee` (`pl_up_fee`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分等级表';

-- ----------------------------
-- Table structure for fx_prepaid_card
-- ----------------------------
DROP TABLE IF EXISTS `fx_prepaid_card`;
CREATE TABLE `fx_prepaid_card` (
  `pc_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pc_name` varchar(50) NOT NULL DEFAULT '' COMMENT '充值卡名称',
  `pc_serial_number` varchar(100) NOT NULL DEFAULT '' COMMENT '充值卡流水号（YmdHis+自增id计算16进制计算出6位数字）',
  `pc_card_number` varchar(100) NOT NULL DEFAULT '' COMMENT '充值卡卡号',
  `pc_password` varchar(100) NOT NULL DEFAULT '' COMMENT '充值卡密码',
  `pc_money` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '面值',
  `pc_member_group` varchar(50) NOT NULL DEFAULT '' COMMENT '指定会员组',
  `pc_member_level` varchar(50) NOT NULL DEFAULT '' COMMENT '指定会员等级',
  `pc_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `pc_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `pc_meno` text COMMENT '充值卡备注',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用者id',
  `m_name` varchar(50) NOT NULL DEFAULT '' COMMENT '使用者',
  `pc_use_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '使用时间',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用 1启用 0停用',
  `pc_service_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '客审状态 0待审核 1通过',
  `pc_finance_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '财审状态 0待审核 1通过',
  `pc_processing_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态 0初始状态 1审核通过 2审核驳回',
  `pc_service_u_id` int(11) NOT NULL DEFAULT '0' COMMENT '客审操作人id',
  `pc_service_u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '客审人名称',
  `pc_finance_u_id` int(11) NOT NULL DEFAULT '0' COMMENT '财审操作人id',
  `pc_finance_u_name` varchar(30) NOT NULL DEFAULT '' COMMENT '财审操作人名称',
  `pc_service_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '客服确认时间',
  `pc_finance_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '财务确认时间',
  `pc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据有效性 0废弃 1有效 2进入回收站',
  `pc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '数据创建时间',
  `pc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '数据更新时间',
  PRIMARY KEY (`pc_id`),
  UNIQUE KEY `pc_card_number` (`pc_card_number`) USING BTREE,
  UNIQUE KEY `pc_serial_number` (`pc_serial_number`) USING BTREE,
  KEY `pc_password` (`pc_password`) USING BTREE,
  KEY `pc_start_time` (`pc_start_time`) USING BTREE,
  KEY `pc_end_time` (`pc_end_time`) USING BTREE,
  KEY `m_name` (`m_name`) USING BTREE,
  KEY `pc_money` (`pc_money`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=utf8 COMMENT='充值卡表';

-- ----------------------------
-- Table structure for fx_presale
-- ----------------------------
DROP TABLE IF EXISTS `fx_presale`;
CREATE TABLE `fx_presale` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '预售ID',
  `p_title` varchar(90) NOT NULL DEFAULT '' COMMENT '预售标题',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `p_picture` varchar(100) NOT NULL COMMENT '预售图片',
  `p_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '预售开始时间',
  `p_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '预售结束时间',
  `p_deposit_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '预售定金',
  `p_number` int(10) NOT NULL DEFAULT '0' COMMENT '预售限购数量',
  `p_overdue_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '补交余款开始时间',
  `p_overdue_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '补交余款结束时间',
  `p_per_number` int(10) NOT NULL DEFAULT '0' COMMENT '每人限购数量',
  `p_pre_number` int(10) NOT NULL DEFAULT '0' COMMENT '虚拟购买数量',
  `p_desc` text NOT NULL COMMENT '预售介绍',
  `p_goodshow_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示商品详情',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1为启用预售活动, 0为停用预售活动',
  `p_order` int(10) NOT NULL DEFAULT '0' COMMENT '显示次序, 数值越小越靠前',
  `p_tiered_pricing_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '价格阶梯类型',
  `p_now_number` int(10) NOT NULL DEFAULT '0' COMMENT '已预售数量',
  `p_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除, 0为正常状态, 1为删除状态',
  `is_deposit` tinyint(1) DEFAULT '0' COMMENT '是否启用定金 0为不启用定金, 1为启用定金',
  `p_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '预售创建时间',
  `p_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '预售更新时间',
  `p_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '预售初始价',
  PRIMARY KEY (`p_id`),
  KEY `is_active` (`is_active`),
  KEY `sort_order` (`p_order`),
  KEY `p_start_time` (`p_start_time`),
  KEY `P_end_time` (`p_end_time`),
  KEY `p_create_time` (`p_create_time`),
  KEY `p_update_time` (`p_update_time`),
  KEY `g_id` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='预售商品基本表';
DROP TABLE IF EXISTS `fx_presale_log`;
CREATE TABLE `fx_presale_log` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '预售日志ID',
  `o_id` bigint(20) NOT NULL COMMENT '订单ID',
  `p_id` int(10) NOT NULL DEFAULT '0' COMMENT '预售ID',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `g_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `num` int(4) NOT NULL DEFAULT '0' COMMENT '购买数量。取值范围:大于零的整数',
  `pl_remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='预售日志表';
DROP TABLE IF EXISTS `fx_presale_set`;
CREATE TABLE `fx_presale_set` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '预售设置ID',
  `ps_price_range` text NOT NULL COMMENT '价格区间',
  `ps_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `ps_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`ps_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='预售价格区间设置表';
DROP TABLE IF EXISTS `fx_product_member_level_price`;
CREATE TABLE `fx_product_member_level_price` (
  `pmlp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `ml_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级ID',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT 'SKU ID',
  `pmlp_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '会员等级固定价格',
  `pmlp_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '记录状态，0为删除；1为有效；',
  `pmlp_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `pmlp_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`pmlp_id`),
  UNIQUE KEY `ml_pdt` (`ml_id`,`pdt_id`) USING BTREE,
  KEY `pmlp_status` (`pmlp_status`) USING BTREE,
  KEY `pmlp_price` (`pmlp_price`) USING BTREE,
  KEY `pmlp_create_time` (`pmlp_create_time`) USING BTREE,
  KEY `pmlp_update_time` (`pmlp_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员等级固定价格表';
DROP TABLE IF EXISTS `fx_promotion`;
CREATE TABLE `fx_promotion` (
  `pmn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pmn_activity_name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动名称',
  `pmn_name` varchar(100) NOT NULL DEFAULT '' COMMENT '促销规则名称',
  `pmn_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用,0否，1是',
  `pmn_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '应用在商品或者订单等。。。1商品，2订单',
  `pmn_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '促销有效期开始时间',
  `pmn_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `pmn_order` int(11) NOT NULL DEFAULT '0' COMMENT '优先级(数字越大靠前)',
  `pmn_category` varchar(100) NOT NULL COMMENT '促销关联类目',
  `pmn_brand` varchar(100) NOT NULL COMMENT '促销关联品牌',
  `pmn_class` varchar(10) NOT NULL DEFAULT 'general' COMMENT '包邮/通用促销/单批(shipping/general/wholesale)',
  `pmn_config` text NOT NULL COMMENT '规则算法（json）',
  `pmn_memo` varchar(255) DEFAULT '' COMMENT '描述',
  `pmn_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `pmn_group` int(11) NOT NULL COMMENT '自定义分组ID',
  PRIMARY KEY (`pmn_id`),
  KEY `pmn_create_time` (`pmn_create_time`) USING BTREE,
  KEY `pmn_order` (`pmn_order`) USING BTREE,
  KEY `pmn_start_time` (`pmn_start_time`) USING BTREE,
  KEY `pmn_end_time` (`pmn_end_time`) USING BTREE,
  KEY `pmn_enable` (`pmn_enable`) USING BTREE,
  KEY `pmn_type` (`pmn_type`) USING BTREE,
  KEY `pmn_class` (`pmn_class`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='促销规则基本表';
DROP TABLE IF EXISTS `fx_related_promotion_goods_brand`;
CREATE TABLE `fx_related_promotion_goods_brand` (
  `rpgb_id` int(11) NOT NULL AUTO_INCREMENT,
  `pmn_id` int(11) NOT NULL COMMENT '促销ID',
  `brand_id` int(11) NOT NULL COMMENT '商品品牌ID',
  PRIMARY KEY (`rpgb_id`),
  KEY `pmn_id` (`pmn_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='促销与商品品牌关联表';
DROP TABLE IF EXISTS `fx_related_promotion_goods_category`;
CREATE TABLE `fx_related_promotion_goods_category` (
  `rpgc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pmn_id` int(11) NOT NULL COMMENT '促销ID',
  `gc_id` int(11) NOT NULL COMMENT '商品品牌ID',
  PRIMARY KEY (`rpgc_id`),
  KEY `pmn_id` (`pmn_id`),
  KEY `gc_id` (`gc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='促销与商品分类关联表';
DROP TABLE IF EXISTS `fx_public_notice`;
CREATE TABLE `fx_public_notice` (
  `pn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `pn_title` varchar(255) NOT NULL DEFAULT '' COMMENT '公告标题',
  `pn_content` text NOT NULL COMMENT '公告内容',
  `pn_is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶 0否 1是',
  `pn_is_all` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否对全部会员开放权限 0否 1是',
  `pn_read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `pn_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `pn_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `pn_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`pn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告表';
DROP TABLE IF EXISTS `fx_purchase_consultation`;
CREATE TABLE `fx_purchase_consultation` (
  `pc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `pc_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '咨询类型，0为匿名咨询，1为实名咨询（实名咨询需要登录）；如果是匿名咨询则显示时不显示用户名。',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '咨询者ID，只要用户登录了就记录会员信息',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '咨询的商品ID',
  `pc_question_title` varchar(200) NOT NULL DEFAULT '' COMMENT '购买咨询问题标题',
  `pc_question_content` text COMMENT '问题详细描述',
  `pc_answer` text COMMENT '管理员回复',
  `pc_is_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否回复',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复人ID',
  `pc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '提问时间',
  `pc_reply_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '购买咨询的回复时间',
  `pc_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`pc_id`),
  KEY `pc_type` (`pc_type`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `pc_question_title` (`pc_question_title`) USING BTREE,
  KEY `pc_is_reply` (`pc_is_reply`) USING BTREE,
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `pc_create_time` (`pc_create_time`) USING BTREE,
  KEY `pc_reply_time` (`pc_reply_time`) USING BTREE,
  KEY `pc_update_time` (`pc_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品资料用户购买咨询表';
DROP TABLE IF EXISTS `fx_receive_address`;
CREATE TABLE `fx_receive_address` (
  `ra_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '收货地址主键ID',
  `cr_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市区域ID',
  `m_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `ra_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `ra_detail`  varchar(500) not null default '' comment '详细地址',
  `ra_post_code` varchar(20) NOT NULL DEFAULT '' COMMENT '邮编',
  `ra_phone` varchar(200) NOT NULL DEFAULT '' COMMENT '电话',
  `ra_mobile_phone` varchar(200) NOT NULL DEFAULT '' COMMENT '手机',
  `ra_is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认，0为否，1为是',
  `ra_id_card` varchar(200) not null default '' comment '身份证号',
  `ra_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `ra_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `ra_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`ra_id`),
  KEY `cr_id` (`cr_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `ra_status` (`ra_status`) USING BTREE,
  KEY `ra_create_time` (`ra_create_time`) USING BTREE,
  KEY `ra_update_time` (`ra_update_time`) USING BTREE,
  KEY `ra_is_default` (`ra_is_default`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收货地址表';
DROP TABLE IF EXISTS `fx_recharge_examine`;
CREATE TABLE `fx_recharge_examine` (
  `re_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '充值ID',
  `re_name` varchar(50) NOT NULL DEFAULT '' COMMENT '汇款人',
  `re_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '调整金额',
  `re_money_end` varchar(5) NOT NULL DEFAULT '' COMMENT '尾数',
  `re_payment_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方单据编号',
  `re_message` varchar(255) NOT NULL DEFAULT '' COMMENT '会员留言',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `a_account_number` varchar(255) NOT NULL DEFAULT '' COMMENT '收账账号号码',
  `a_id` int(10) NOT NULL DEFAULT '0' COMMENT '收账账号ID',
  `a_apply_bank` varchar(50) NOT NULL DEFAULT '' COMMENT '开户银行',
  `a_apply_name` varchar(50) NOT NULL DEFAULT '' COMMENT '开户人',
  `re_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '充值时间',
  `re_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态，0为未审核，1为已审核通过，2为审核不通过',
  `re_user_message` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员留言',
  `re_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理id',
  `re_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效',
  `re_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `re_admin_message` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员留言',
  `re_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  `re_content` varchar(255) NOT NULL DEFAULT '' COMMENT '作废原因',
  PRIMARY KEY (`re_id`),
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值审核列表';

-- ----------------------------
-- Table structure for fx_red_enevlope
-- ----------------------------
DROP TABLE IF EXISTS `fx_red_enevlope`;
CREATE TABLE `fx_red_enevlope` (
  `rd_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `rd_name` varchar(50) NOT NULL DEFAULT '' COMMENT '红包规则名称',
  `rd_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动开始时间',
  `rd_end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动结束时间',
  `rd_is_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `rd_title` varchar(150) NOT NULL DEFAULT '' COMMENT '规则页面标题',
  `rd_keywords` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `rd_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO商品描述',
  `rd_memo` varchar(255) NOT NULL DEFAULT '' COMMENT '规则备注',
  PRIMARY KEY (`rd_id`),
  UNIQUE KEY `rd_name` (`rd_name`),
  KEY `rd_is_status` (`rd_is_status`),
  KEY `rd_start_time` (`rd_start_time`),
  KEY `rd_end_time` (`rd_end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='红包活动表';

-- ----------------------------
-- Table structure for fx_refunds_spec
-- ----------------------------
DROP TABLE IF EXISTS `fx_refunds_spec`;
CREATE TABLE `fx_refunds_spec` (
  `gs_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '规格ID',
  `gs_name` varchar(50) NOT NULL DEFAULT '' COMMENT '规格名称',
  `gs_simple_name` varchar(50) NOT NULL DEFAULT '' COMMENT '规格别名',
  `gs_remark` varchar(50) NOT NULL DEFAULT '' COMMENT '规格备注（暂不启用）',
  `gs_show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 1退款 2退货',
  `gs_input_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '输入类型 1文本输入 2附件 3文本域输入',
  `gs_order` int(11) NOT NULL DEFAULT '0' COMMENT '属性排序',
  `gs_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，1为有效，0为删除',
  `gs_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gs_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最新修改时间',
  PRIMARY KEY (`gs_id`),
  KEY `gs_show_type` (`gs_show_type`) USING BTREE,
  KEY `gs_input_type` (`gs_input_type`) USING BTREE,
  KEY `gs_status` (`gs_status`) USING BTREE,
  KEY `gs_order` (`gs_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款退货规格表';

DROP TABLE IF EXISTS `fx_refunds_reason`;
CREATE TABLE `fx_refunds_reason` (
  `rr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '退换货理由ID',
  `rr_name` varchar(50) NOT NULL DEFAULT '' COMMENT '退换货理由',
  `rr_show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 1退款 2退货',
  `rr_order` int(11) NOT NULL DEFAULT '0' COMMENT '属性排序',
  `rr_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，1为有效，0为删除',
  `rr_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否前台显示，1为显示，0为不显示',
  `rr_is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认，1为默认，0为不是默认',
  `rr_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `rr_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最新修改时间',
  PRIMARY KEY (`rr_id`),
  KEY `rr_show_type` (`rr_show_type`) USING BTREE,
  KEY `rr_status` (`rr_status`) USING BTREE,
  KEY `rr_order` (`rr_order`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='退款退货用户自定义表';

DROP TABLE IF EXISTS `fx_related_authorize`;
CREATE TABLE `fx_related_authorize` (
  `al_id` int(11) NOT NULL DEFAULT '0' COMMENT '授权线id',
  `ra_gb_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌id集合',
  `ra_gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id集合',
  `ra_gp_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID集合',
  KEY `al_id` (`al_id`) USING BTREE,
  KEY `ra_gb_id` (`ra_gb_id`) USING BTREE,
  KEY `ra_gc_id` (`ra_gc_id`) USING BTREE,
  KEY `ra_gp_id` (`ra_gp_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权商品范围';
DROP TABLE IF EXISTS `fx_related_authorize_member`;
CREATE TABLE `fx_related_authorize_member` (
  `al_id` int(11) NOT NULL DEFAULT '0' COMMENT '授权线id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  KEY `al_id` (`al_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权会员关系表';
DROP TABLE IF EXISTS `fx_related_brand_type`;
CREATE TABLE `fx_related_brand_type` (
  `gb_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品规格ID',
  `gt_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品品牌类型关联表';
DROP TABLE IF EXISTS `fx_related_coupon_goods_group`;
CREATE TABLE `fx_related_coupon_goods_group` (
  `rcgg_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `gg_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分组ID',
  PRIMARY KEY (`rcgg_id`),
  KEY `c_id` (`c_id`),
  KEY `gg_id` (`gg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券和商品分组关联表';
DROP TABLE IF EXISTS `fx_related_good_subcompany`;
CREATE TABLE `fx_related_good_subcompany` (
  `s_id` int(11) NOT NULL DEFAULT '0' COMMENT '子公司id',
  `ra_gb_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌id集合',
  `ra_gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id集合',
  `ra_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  KEY `s_id` (`s_id`) USING BTREE,
  KEY `ra_gb_id` (`ra_gb_id`) USING BTREE,
  KEY `ra_gc_id` (`ra_gc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='子公司授权商品范围';
DROP TABLE IF EXISTS `fx_related_goods_category`;
CREATE TABLE `fx_related_goods_category` (
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '品商分类id',
  UNIQUE KEY `g_gc_id` (`g_id`,`gc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类关联表';
DROP TABLE IF EXISTS `fx_related_goods_group`;
CREATE TABLE `fx_related_goods_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `gg_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分组ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `g_id_gg_id` (`g_id`,`gg_id`),
  KEY `g_id` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品-商品分组关联表';
DROP TABLE IF EXISTS `fx_related_goods_spec`;
CREATE TABLE `fx_related_goods_spec` (
  `gs_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品规格ID',
  `gsd_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格值ID',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '货品ID',
  `gs_is_sale_spec` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否销售规格 0否，1是',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `gsd_aliases` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性值别名，例如系统的红色可以别名为大红色或者深红色',
  `gsd_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性图片',
  KEY `gsd_id` (`gsd_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `gs_is_sale_spec` (`gs_is_sale_spec`) USING BTREE,
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `gs_id` (`gs_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='规格值关联表';

DROP TABLE IF EXISTS `fx_related_goods_type_spec`;
CREATE TABLE `fx_related_goods_type_spec` (
  `gt_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型ID',
  `gs_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品属性ID',
  UNIQUE KEY `gt_gs_id` (`gt_id`,`gs_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品类型属性关联表';

-- ----------------------------
-- Table structure for fx_related_goodscategory_ads
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_goodscategory_ads`;
CREATE TABLE `fx_related_goodscategory_ads` (
  `rgca_id` int(11) NOT NULL AUTO_INCREMENT,
  `gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '类目ID',
  `ad_url` varchar(255) NOT NULL COMMENT '链接地址',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_pic_url` varchar(255) NOT NULL COMMENT '图片链接地址',
  PRIMARY KEY (`rgca_id`),
  UNIQUE KEY `gcad` (`gc_id`,`ad_pic_url`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=330 DEFAULT CHARSET=utf8 COMMENT='类目和类目广告图片关联表';

-- ----------------------------
-- Table structure for fx_related_goodscategory_brand
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_goodscategory_brand`;
CREATE TABLE `fx_related_goodscategory_brand` (
  `rgcb_id` int(11) NOT NULL AUTO_INCREMENT,
  `gb_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '类目ID',
  PRIMARY KEY (`rgcb_id`),
  UNIQUE KEY `gcb` (`gb_id`,`gc_id`) USING BTREE COMMENT '类目和品牌ID'
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8 COMMENT='类目和品牌关联表';

-- ----------------------------
-- Table structure for fx_related_groupbuy_ads
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_groupbuy_ads`;
CREATE TABLE `fx_related_groupbuy_ads` (
  `rga_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_url` varchar(255) NOT NULL COMMENT '链接地址',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_pic_url` varchar(255) NOT NULL COMMENT '图片链接地址',
  PRIMARY KEY (`rga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购广告图片表';

-- ----------------------------
-- Table structure for fx_related_groupbuy_area
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_groupbuy_area`;
CREATE TABLE `fx_related_groupbuy_area` (
  `related_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联团购ID',
  `cr_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联区域ID',
  PRIMARY KEY (`related_area_id`),
  KEY `gp_id` (`gp_id`),
  KEY `cr_id` (`cr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购关联区域表';
DROP TABLE IF EXISTS `fx_related_groupbuy_price`;
CREATE TABLE `fx_related_groupbuy_price` (
  `related_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_id` int(11) NOT NULL COMMENT '团购ID',
  `rgp_price` decimal(10,3) NOT NULL COMMENT '享受价格',
  `rgp_num` int(10) NOT NULL DEFAULT '0' COMMENT '数量达到',
  PRIMARY KEY (`related_price_id`),
  KEY `gp_id` (`gp_id`),
  KEY `rgp_num` (`rgp_num`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购价格关联表';

-- ----------------------------
-- Table structure for fx_related_groupbuycategory_ads
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_groupbuycategory_ads`;
CREATE TABLE `fx_related_groupbuycategory_ads` (
  `rga_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_url` varchar(255) NOT NULL COMMENT '链接地址',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_pic_url` varchar(255) NOT NULL COMMENT '图片链接地址',
  `gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '类目ID',
  PRIMARY KEY (`rga_id`),
  KEY `gc_id` (`gc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='团购分类广告图片表';

-- ----------------------------
-- Table structure for fx_related_logistic_city
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_logistic_city`;
CREATE TABLE `fx_related_logistic_city` (
  `lt_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送区域',
  `cr_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市地址id最后一级id',
  KEY `lt_id` (`lt_id`) USING BTREE,
  KEY `cr_id` (`cr_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送区域和地址关联表';
DROP TABLE IF EXISTS `fx_related_members_group`;
CREATE TABLE `fx_related_members_group` (
  `mg_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员组id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '员会id',
  KEY `mg_id` (`mg_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员组表';
DROP TABLE IF EXISTS `fx_related_members_source_platform`;
CREATE TABLE `fx_related_members_source_platform` (
  `sp_id` int(11) NOT NULL DEFAULT '0' COMMENT '平台id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  PRIMARY KEY (`sp_id`,`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员-平台关联表';
DROP TABLE IF EXISTS `fx_related_presale_area`;
CREATE TABLE `fx_related_presale_area` (
  `related_area_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关联表ID',
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联预售ID',
  `cr_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联区域ID',
  PRIMARY KEY (`related_area_id`),
  KEY `p_id` (`p_id`),
  KEY `cr_id` (`cr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='预售区域关联表';
DROP TABLE IF EXISTS `fx_related_presale_price`;
CREATE TABLE `fx_related_presale_price` (
  `related_price_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关联表ID',
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '预售ID',
  `rgp_num` int(10) NOT NULL DEFAULT '0' COMMENT '数量达到值',
  `rgp_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '享受价格',
  PRIMARY KEY (`related_price_id`),
  KEY `p_id` (`p_id`),
  KEY `rgp_num` (`rgp_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='预售价格关联表';
DROP TABLE IF EXISTS `fx_related_promotion_goods`;
CREATE TABLE `fx_related_promotion_goods` (
  `pmn_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销规则id',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '货品表id',
  `g_price_config` text COMMENT '商品价格配置（josn）',
  KEY `pmn_id` (`pmn_id`) USING BTREE,
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='促销商品关系表';
DROP TABLE IF EXISTS `fx_related_promotion_goods_group`;
CREATE TABLE `fx_related_promotion_goods_group` (
  `rpmg_id` int(11) NOT NULL AUTO_INCREMENT,
  `pmn_id` int(11) NOT NULL COMMENT '促销ID',
  `gg_id` int(11) NOT NULL COMMENT '商品分组ID',
  PRIMARY KEY (`rpmg_id`),
  KEY `pmn_id` (`pmn_id`),
  KEY `gg_id` (`gg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='促销与商品分组关联表';
DROP TABLE IF EXISTS `fx_related_promotion_members`;
CREATE TABLE `fx_related_promotion_members` (
  `pmn_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销规则id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `mg_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员组id',
  `ml_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级id',
  KEY `pmn_id` (`pmn_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `mg_id` (`mg_id`) USING BTREE,
  KEY `ml_id` (`ml_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='促销会员关系表';
DROP TABLE IF EXISTS `fx_related_refund_spec`;
CREATE TABLE `fx_related_refund_spec` (
  `or_id` mediumint(8) unsigned NOT NULL COMMENT '退换货单or_id',
  `gs_id` int(10) unsigned NOT NULL COMMENT '属性项gs_id',
  `content` text NOT NULL COMMENT '内容',
  KEY `or_id` (`or_id`) USING BTREE,
  KEY `gs_id` (`gs_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款退货属性项值';

-- ----------------------------
-- Table structure for fx_related_spike_ads
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_spike_ads`;
CREATE TABLE `fx_related_spike_ads` (
  `rsa_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_url` varchar(255) NOT NULL COMMENT '链接地址',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_pic_url` varchar(255) NOT NULL COMMENT '图片链接地址',
  PRIMARY KEY (`rsa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='秒杀广告图片表';

-- ----------------------------
-- Table structure for fx_related_spike_area
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_spike_area`;
CREATE TABLE `fx_related_spike_area` (
  `rsa_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id` int(11) NOT NULL COMMENT '秒杀ID',
  `cr_id` int(11) NOT NULL COMMENT '区域ID',
  PRIMARY KEY (`rsa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='秒杀关联区域表';

-- ----------------------------
-- Table structure for fx_related_station_letters
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_station_letters`;
CREATE TABLE `fx_related_station_letters` (
  `sl_id` int(11) NOT NULL DEFAULT '0' COMMENT '站内信id',
  `rsl_to_m_id` int(11) NOT NULL DEFAULT '0' COMMENT '收信人',
  `rsl_is_look` tinyint(1) NOT NULL DEFAULT '0' COMMENT '查看状态（0：没有查看，1：以查看）',
  `rsl_to_del_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '收件人状态0：已删除；1：正常',
  KEY `sl_id` (`sl_id`) USING BTREE,
  KEY `rsl_to_m_id` (`rsl_to_m_id`) USING BTREE,
  KEY `rsl_is_look` (`rsl_is_look`) USING BTREE,
  KEY `rsl_to_del_status` (`rsl_to_del_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站内信关系表';

-- ----------------------------
-- Table structure for fx_related_try_ads
-- ----------------------------
DROP TABLE IF EXISTS `fx_related_try_ads`;
CREATE TABLE `fx_related_try_ads` (
  `rta_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_url` varchar(255) NOT NULL COMMENT '链接地址',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_pic_url` varchar(255) NOT NULL COMMENT '图片链接地址',
  PRIMARY KEY (`rta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='试用广告图片表';

-- ----------------------------
-- Table structure for fx_releted_combination_goods
-- ----------------------------
DROP TABLE IF EXISTS `fx_releted_combination_goods`;
CREATE TABLE `fx_releted_combination_goods` (
  `com_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '组合商品id',
  `releted_pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '组合商品关联货品id',
  `releted_pdt_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '关联货品pdt_sn',
  `com_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '单价规格的价格，用于售后退款计算使用',
  `com_nums` int(11) NOT NULL DEFAULT '0' COMMENT '组合数量',
  `com_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据有效性：0废弃 1有效 2进入回收站',
  `com_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '数据创建时间',
  `com_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '数据更新时间',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '组合商品的PDT-ID',
  PRIMARY KEY (`com_id`),
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `releted_pdt_id` (`releted_pdt_id`) USING BTREE,
  KEY `releted_pdt_sn` (`releted_pdt_sn`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合商品关联表';
DROP TABLE IF EXISTS `fx_releted_spec_combination`;
CREATE TABLE `fx_releted_spec_combination` (
  `sc_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格组合商品id',
  `rsc_spec_name` varchar(50) NOT NULL DEFAULT '' COMMENT '规格组合名',
  `rsc_spec_detail` varchar(100) NOT NULL DEFAULT '' COMMENT '规格组合值',
  `rsc_rel_good_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格组合关联商品id',
  `rsc_rel_good_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '规格组合关联商品编号',
  `rsc_show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示类型：1文字 2图片',
  `rsc_order` int(11) NOT NULL DEFAULT '0' COMMENT '属性排序',
  KEY `sc_show_type` (`rsc_show_type`) USING BTREE,
  KEY `sc_spec_name` (`rsc_spec_name`) USING BTREE,
  KEY `sc_spec_detail` (`rsc_spec_detail`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='规格组合商品关联表';
DROP TABLE IF EXISTS `fx_related_coupon_red`;
CREATE TABLE `fx_related_coupon_red` (
  `c_name` varchar(50) NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `rd_id` int(11) NOT NULL DEFAULT '0' COMMENT '规则id',
  KEY `c_name` (`c_name`),
  KEY `rd_id` (`rd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券与规则关联表';
DROP TABLE IF EXISTS `fx_role`;
CREATE TABLE `fx_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `status` smallint(2) NOT NULL DEFAULT '1' COMMENT '该用户组是否显示：0为不显示，1为显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='角色表';
DROP TABLE IF EXISTS `fx_role_access`;
CREATE TABLE `fx_role_access` (
  `role_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '节点id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '角色id',
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `node_id` (`node_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色节点关系表';

-- ----------------------------
-- Table structure for fx_role_node
-- ----------------------------
DROP TABLE IF EXISTS `fx_role_node`;
CREATE TABLE `fx_role_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
  `action` varchar(60) NOT NULL DEFAULT '' COMMENT '节点控制器',
  `action_name` varchar(60) NOT NULL DEFAULT '' COMMENT '节点控制器名称',
  `module` varchar(60) NOT NULL DEFAULT '' COMMENT '节点模型',
  `module_name` varchar(60) NOT NULL DEFAULT '' COMMENT '节点模型名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '节点是否可用:0为禁用,1为禁用',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '节点排序',
  `auth_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '授权模式：1:模块授权(module) 2:操作授权(action) 0:节点授权(node)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_module` (`action`,`module`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=735 DEFAULT CHARSET=utf8 COMMENT='节点表';

-- ----------------------------
-- Table structure for fx_running_account
-- ----------------------------
DROP TABLE IF EXISTS `fx_running_account`;
CREATE TABLE `fx_running_account` (
  `ra_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `ra_money` decimal(15,3) NOT NULL DEFAULT '0.000' COMMENT '变动金额（正负）',
  `ra_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '变更类型，0充值，1消费，2冻结，3解冻，4退款 ，5在线消费（第三方平台消费）',
  `ra_before_money` decimal(15,3) NOT NULL DEFAULT '0.000' COMMENT '变更前用户账户余额',
  `ra_after_money` decimal(15,3) NOT NULL DEFAULT '0.000' COMMENT '变更后用户账户余额',
  `ra_payment_method` varchar(50) NOT NULL DEFAULT '' COMMENT '支付方式，预存款->线下支付，其他为在线支付配置代码 ',
  `ra_payment_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '支付编号',
  `ra_memo` varchar(255) DEFAULT '' COMMENT '注备',
  `ra_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录生成时间',
  PRIMARY KEY (`ra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='流水账日志';
DROP TABLE IF EXISTS `fx_sales_receipts`;
CREATE TABLE `fx_sales_receipts` (
  `sr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sr_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '销货类型,0为线下支付，1为货到付款，后续如果还有其他类型再添加',
  `o_id` bigint(20) NOT NULL COMMENT '订单号',
  `sr_logistics_sn` varchar(50) NOT NULL COMMENT '物流单号',
  `sr_create_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单据产生类型，0为手工创建；1为接口产生；',
  `sr_create_uid` int(10) DEFAULT NULL COMMENT '制单员id，当且仅当sr_create_type=0时有效；',
  `sr_remit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '付款时间，如果是银行或者支付宝汇款就是汇款时间，如果是现金付款就是付款时间。',
  `sr_remitter` varchar(50) NOT NULL DEFAULT '' COMMENT '汇款人/付款人',
  `sr_bank` varchar(200) NOT NULL DEFAULT '' COMMENT '开户行',
  `sr_bank_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '银行汇款的流水号或者支付宝交易流水号',
  `to_post_balance` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '转账/汇款金额',
  `sr_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注，前台显示为一个textarea，允许输入120个中文字符',
  `sr_verify_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单据确认状态，0为未确认，1为已确认',
  `sr_verify_uid` int(11) NOT NULL DEFAULT '0' COMMENT '审核人ID',
  `sr_verify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '单据审核日期',
  `sr_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '单据创建时间',
  `sr_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `m_id` int(11) NOT NULL COMMENT '会员ID',
  `sr_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '作废状态，1未作废，0已作废',
  PRIMARY KEY (`sr_id`),
  KEY `sr_type` (`sr_type`) USING BTREE,
  KEY `o_id` (`o_id`) USING BTREE,
  KEY `sr_logistics_sn` (`sr_logistics_sn`) USING BTREE,
  KEY `sr_create_type` (`sr_create_type`) USING BTREE,
  KEY `sr_create_uid` (`sr_create_uid`) USING BTREE,
  KEY `sr_remitter` (`sr_remitter`) USING BTREE,
  KEY `sr_verify_status` (`sr_verify_status`) USING BTREE,
  KEY `sr_verify_uid` (`sr_verify_uid`) USING BTREE,
  KEY `sr_remark` (`sr_remark`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销货收款单单据表';
DROP TABLE IF EXISTS `fx_sales_receipts_modify_log`;
CREATE TABLE `fx_sales_receipts_modify_log` (
  `srml_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `sr_id` int(11) NOT NULL DEFAULT '0' COMMENT '被编辑的销货收款单ID',
  `srml_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '日志类型，日志类型，0为创建单据，1为单据修改，2为单据确认，3为单据作废',
  `srml_uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID，如果是API产生的单据，这里存0；',
  `srml_change` text COMMENT '数据变更，比如那些字段修改前和修改后的值对比',
  `srml_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '日志创建时间',
  PRIMARY KEY (`srml_id`),
  KEY `sr_id` (`sr_id`) USING BTREE,
  KEY `srml_type` (`srml_type`) USING BTREE,
  KEY `srml_uid` (`srml_uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='销货收款单修改日志表';
DROP TABLE IF EXISTS `fx_script_info`;
CREATE TABLE `fx_script_info` (
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '脚本名称',
  `code` varchar(255) NOT NULL DEFAULT '' COMMENT '脚本编号',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '运行脚本地址',
  `interval` int(11) NOT NULL DEFAULT '0' COMMENT '脚本运行间隔 分钟为单位',
  `run_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '运行时间',
  `result` tinyint(1) NOT NULL DEFAULT '0' COMMENT '运行结果：0失败,1成功',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '运行级别 1每间隔运行,2会员登入,3后台运行,4手动'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='定时脚本表';
DROP TABLE IF EXISTS `fx_shipping_address`;
CREATE TABLE `fx_shipping_address` (
  `sh_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发货/退货地址ID',
  `cr_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市区域ID',
  `sh_name` varchar(50) NOT NULL DEFAULT '' COMMENT '发货人姓名',
  `sh_detail` varchar(255) NOT NULL DEFAULT '' COMMENT '街道地址',
  `sh_post_code` varchar(20) NOT NULL DEFAULT '' COMMENT '邮编',
  `sh_phone` varchar(200) NOT NULL DEFAULT '' COMMENT '电话',
  `sh_mobile_phone` varchar(200) NOT NULL DEFAULT '' COMMENT '手机',
  `sh_company` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `sh_memo` text COMMENT '备注',
  `sh_is_address` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为发货地址，0为退货地址',
  `sh_is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认，0为否，1为是',
  `sh_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `sh_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `sh_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`sh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货退货地址表';
DROP TABLE IF EXISTS `fx_site_config`;
CREATE TABLE `fx_site_config` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id ',
  `sc_title` varchar(100) NOT NULL DEFAULT '' COMMENT '模块标题',
  `sc_memo` text COMMENT '模块描述',
  `sc_module` varchar(50) NOT NULL DEFAULT '' COMMENT '站点模块',
  `sc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `sc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`sc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='网站站点配置信息表';

-- ----------------------------
-- Table structure for fx_sms_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_sms_log`;
CREATE TABLE `fx_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '客服名称，仅用于后台显示用',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发送状态 0,未成功 1,成功',
  `check_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证状态 0,未认证 1,已认证 2,无效',
  `code` text NOT NULL COMMENT '验证码',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `sms_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:普通发送短信；1：手机绑定；2：更换手机号；3：密码找回,4:重置密码,5:支付验证,6:门店自提提货验证',
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `check_status` (`check_status`) USING BTREE,
  KEY `sms_type` (`sms_type`) USING BTREE,
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信日志表';

-- ----------------------------
-- Table structure for fx_sms_templates
-- ----------------------------
DROP TABLE IF EXISTS `fx_sms_templates`;
CREATE TABLE `fx_sms_templates` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '模板编码',
  `subject` varchar(200) NOT NULL DEFAULT '' COMMENT '模板标题',
  `content` text NOT NULL COMMENT '模板内容',
  `last_modify` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '模板修改时间',
  `last_send` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '模板发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for fx_source_platform
-- ----------------------------
DROP TABLE IF EXISTS `fx_source_platform`;
CREATE TABLE `fx_source_platform` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sp_code` varchar(50) NOT NULL DEFAULT 'loclhost' COMMENT '平台标识',
  `sp_name` varchar(255) NOT NULL DEFAULT '' COMMENT '平台名称',
  `sp_default` tinyint(1) DEFAULT '0' COMMENT '是否系统默认，0为否，1为是',
  `sp_stauts` tinyint(1) NOT NULL DEFAULT '1' COMMENT '属性平台的状态。0无效，1有效',
  `sp_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `sp_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`sp_id`),
  KEY `sp_code` (`sp_code`) USING BTREE,
  KEY `sp_default` (`sp_default`) USING BTREE,
  KEY `sp_stauts` (`sp_stauts`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='会员来源平台表';
DROP TABLE IF EXISTS `fx_spec_combination`;
CREATE TABLE `fx_spec_combination` (
  `scg_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `scg_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规格组合标题',
  `scg_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `scg_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '数据创建时间',
  `scg_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '数据更新时间',
  PRIMARY KEY (`scg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='规格组合表';
DROP TABLE IF EXISTS `fx_spike`;
CREATE TABLE `fx_spike` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '秒杀ID',
  `sp_title` varchar(255) NOT NULL COMMENT '秒杀标题',
  `sp_desc` text COMMENT '秒杀描述',
  `sp_mobile_desc` text NOT NULL COMMENT '手机端描述',
  `sp_picture` varchar(100) NOT NULL COMMENT '秒杀图片',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `sp_number` int(11) NOT NULL DEFAULT '0' COMMENT '限购数量',
  `sp_now_number` int(11) NOT NULL DEFAULT '0' COMMENT '已秒杀数量',
  `sp_send_point` int(11) NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `sp_price` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '秒杀价格',
  `sp_goods_desc_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示商品描述',
  `sp_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动开始时间',
  `sp_end_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动结束时间',
  `sp_tiered_pricing_type` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '价格优惠类型',
  `sp_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用：0.停用，1.启用',
  `sp_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '秒杀创建时间',
  `sp_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '秒杀更新时间',
  `gc_id` int(11) NOT NULL DEFAULT '0' COMMENT '秒杀所属分类',
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='秒杀';
DROP TABLE IF EXISTS `fx_spike_log`;
CREATE TABLE `fx_spike_log` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '秒杀日志ID',
  `o_id` bigint(20) NOT NULL COMMENT '订单ID',
  `sp_id` int(10) NOT NULL DEFAULT '0' COMMENT '秒杀ID',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `g_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `num` int(4) NOT NULL DEFAULT '0' COMMENT '购买数量。取值范围:大于零的整数',
  `pl_remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='秒杀日志表';

-- ----------------------------
-- Table structure for fx_spike_category
-- ----------------------------
DROP TABLE IF EXISTS `fx_spike_category`;
CREATE TABLE `fx_spike_category` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `gc_parent_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '父类目ID',
  `gc_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类分级数，0是一级，1是二级以此类推。',
  `gc_is_parent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是父类目(0不是父级，1是父级)',
  `gc_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类目名称',
  `gc_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '类目图片',
  `gc_order` int(11) NOT NULL DEFAULT '0' COMMENT '类目排序',
  `gc_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台是否显示 0不显示 1显示',
  `gc_description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `gc_keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',
  `gc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`gc_id`),
  KEY `gc_parent_id` (`gc_parent_id`) USING BTREE,
  KEY `gc_is_parent` (`gc_is_parent`) USING BTREE,
  KEY `gc_order` (`gc_order`) USING BTREE,
  KEY `gc_is_display` (`gc_is_display`) USING BTREE,
  KEY `gc_status` (`gc_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='秒杀商品分类';

-- ----------------------------
-- Table structure for fx_station_letters
-- ----------------------------
DROP TABLE IF EXISTS `fx_station_letters`;
CREATE TABLE `fx_station_letters` (
  `sl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sl_title` varchar(200) NOT NULL DEFAULT '' COMMENT '标题',
  `sl_content` text NOT NULL COMMENT '内容',
  `sl_from_m_id` int(11) NOT NULL DEFAULT '0' COMMENT '发件人id',
  `sl_from_m_name` varchar(50) NOT NULL DEFAULT '' COMMENT '发信人昵称',
  `sl_parentid` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `sl_from_del_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '发件人删除状态：0：已删除；1：正常',
  `sl_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `sl_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`sl_id`),
  KEY `sl_from_m_id` (`sl_from_m_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站内信';

-- ----------------------------
-- Table structure for fx_stock_inventory_lock_detail
-- ----------------------------
DROP TABLE IF EXISTS `fx_stock_inventory_lock_detail`;
CREATE TABLE `fx_stock_inventory_lock_detail` (
  `sild_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分销商库存调整单明细ID',
  `srr_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商库存调整单ID',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商ID',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '被调整的规格ID',
  `sild_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销商调整类型：增加/减少，0为增加，1为减少',
  `sild_num` int(11) NOT NULL DEFAULT '0' COMMENT '变更数量',
  `sild_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '记录类型，0为删除，1为正常',
  `sild_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `sild_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`sild_id`),
  KEY `srr_id` (`srr_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `sild_type` (`sild_type`) USING BTREE,
  KEY `sild_status` (`sild_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='分销商库存调整单明细表';

-- ----------------------------
-- Table structure for fx_stock_inventory_lock_modify_log
-- ----------------------------
DROP TABLE IF EXISTS `fx_stock_inventory_lock_modify_log`;
CREATE TABLE `fx_stock_inventory_lock_modify_log` (
  `silml_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID，主键自增',
  `srr_id` int(11) NOT NULL DEFAULT '0' COMMENT '调整单据ID',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商ID',
  `silml_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型，0为单据新建，1为单据修改，2为审核通过，3为作废，4为明细操作',
  `silml_detail_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '明细操作类型，当且仅当silml_type等于4时，此字段有效，0为新增明细，1为修改明细，2为删除明细，3为明细审核通过',
  `sild_id` int(11) NOT NULL DEFAULT '0' COMMENT '明细操作涉及的明细ID',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `srrml_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '日志记录时间',
  PRIMARY KEY (`silml_id`),
  KEY `srr_id` (`srr_id`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `silml_type` (`silml_type`) USING BTREE,
  KEY `silml_detail_type` (`silml_detail_type`) USING BTREE,
  KEY `sild_id` (`sild_id`) USING BTREE,
  KEY `u_id` (`u_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='分销商库存调整单日志表';

-- ----------------------------
-- Table structure for fx_stock_revise_receipt
-- ----------------------------
DROP TABLE IF EXISTS `fx_stock_revise_receipt`;
CREATE TABLE `fx_stock_revise_receipt` (
  `srr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '单据ID，主键，自增',
  `srr_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '创建人类型，0为系统单据，1为手工单据，2为API单据，3为表格/CSV导入单据',
  `srr_desc` text COMMENT '库存调整单备注',
  `srr_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单据审核状态，0为未审核，1为审核通过，2为审核不通过',
  `srr_create_id` int(11) NOT NULL DEFAULT '0' COMMENT '制单人ID',
  `srr_verify_id` int(11) NOT NULL DEFAULT '0' COMMENT '审核人ID',
  `srr_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `srr_verify_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `srr_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`srr_id`),
  KEY `srr_type` (`srr_type`) USING BTREE,
  KEY `srr_verify` (`srr_verify`) USING BTREE,
  KEY `srr_create_id` (`srr_create_id`) USING BTREE,
  KEY `srr_verify_id` (`srr_verify_id`) USING BTREE,
  KEY `srr_create_time` (`srr_create_time`) USING BTREE,
  KEY `srr_verify_time` (`srr_verify_time`) USING BTREE,
  KEY `srr_update_time` (`srr_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存调整单表';
DROP TABLE IF EXISTS `fx_stock_revise_receipt_detail`;
CREATE TABLE `fx_stock_revise_receipt_detail` (
  `srrd_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '库存调整单明细ID',
  `srr_id` int(11) NOT NULL DEFAULT '0' COMMENT '库存调整单ID',
  `pdt_id` int(11) NOT NULL DEFAULT '0' COMMENT '被调整的规格ID',
  `srrd_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '调整类型：增加/减少，0为增加，1为减少',
  `srrd_num` int(11) NOT NULL DEFAULT '0' COMMENT '变更数量',
  `srrd_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '记录类型，0为删除，1为正常',
  `srrd_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `srrd_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`srrd_id`),
  KEY `srr_id` (`srr_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `srrd_type` (`srrd_type`) USING BTREE,
  KEY `srrd_status` (`srrd_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存调整单明细表';
DROP TABLE IF EXISTS `fx_stock_revise_receipt_modify_log`;
CREATE TABLE `fx_stock_revise_receipt_modify_log` (
  `srrml_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID，主键自增',
  `srr_id` int(11) NOT NULL DEFAULT '0' COMMENT '调整单据ID',
  `srrml_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型，0为单据新建，1为单据修改，2为审核通过，3为作废，4为明细操作',
  `srrml_detail_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '明细操作类型，当且仅当srrml_type等于4时，此字段有效，0为新增明细，1为修改明细，2为删除明细，3为明细审核通过',
  `srrd_id` int(11) NOT NULL DEFAULT '0' COMMENT '明细操作涉及的明细ID',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `srrml_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '日志记录时间',
  PRIMARY KEY (`srrml_id`),
  KEY `srr_id` (`srr_id`) USING BTREE,
  KEY `srrml_type` (`srrml_type`) USING BTREE,
  KEY `srrml_detail_type` (`srrml_detail_type`) USING BTREE,
  KEY `srrd_id` (`srrd_id`) USING BTREE,
  KEY `u_id` (`u_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存调整单日志表';
DROP TABLE IF EXISTS `fx_subcompany`;
CREATE TABLE `fx_subcompany` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) NOT NULL DEFAULT '' COMMENT '公司名称',
  `s_website` varchar(50) DEFAULT NULL COMMENT '公司网址',
  `cr_id` int(11) DEFAULT NULL COMMENT '公司所属省份（联系地址表里面的最终一级的ID）',
  `s_contacts` varchar(20) DEFAULT NULL COMMENT '公司联系人',
  `s_detail` tinytext COMMENT '公司简介',
  `is_open` tinyint(4) DEFAULT '0' COMMENT '是否开启',
  `s_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `s_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `s_sort` int(11) NOT NULL DEFAULT '10' COMMENT '子公司排序，数值越小越靠前',
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='子公司表';
DROP TABLE IF EXISTS `fx_suggestions`;
CREATE TABLE `fx_suggestions` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `s_title` varchar(200) NOT NULL DEFAULT '' COMMENT '投诉标题',
  `s_content` text COMMENT '投诉内容',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '投诉人ID',
  `s_email` varchar(100) NOT NULL DEFAULT '' COMMENT '联系邮箱',
  `s_mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '联系手机',
  `s_is_handle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否处理，0为未处理；1为已处理；',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '处理人ID',
  `s_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '投诉时间',
  `s_handle_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '处理完成时间',
  `s_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`s_id`),
  KEY `s_title` (`s_title`) USING BTREE,
  KEY `m_id` (`m_id`) USING BTREE,
  KEY `s_email` (`s_email`) USING BTREE,
  KEY `s_mobile` (`s_mobile`) USING BTREE,
  KEY `s_is_handle` (`s_is_handle`) USING BTREE,
  KEY `u_id` (`u_id`) USING BTREE,
  KEY `s_create_time` (`s_create_time`) USING BTREE,
  KEY `s_handle_time` (`s_handle_time`) USING BTREE,
  KEY `s_update_time` (`s_update_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投诉建议表';
DROP TABLE IF EXISTS `fx_sys_config`;
CREATE TABLE `fx_sys_config` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动增长id',
  `sc_module` varchar(100) NOT NULL DEFAULT '' COMMENT '配置模块名称',
  `sc_key` varchar(100) NOT NULL DEFAULT '' COMMENT '配置key必须是唯一',
  `sc_value` text COMMENT '配置值,多值以逗号分割',
  `sc_value_desc` varchar(100) NOT NULL DEFAULT '' COMMENT '配置值描述',
  `sc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `sc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`sc_id`),
  UNIQUE KEY `sc_key` (`sc_module`,`sc_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COMMENT='系统配置表，配置值使用序列化数组存储';

-- ----------------------------
-- Table structure for fx_template
-- ----------------------------
DROP TABLE IF EXISTS `fx_template`;
CREATE TABLE `fx_template` (
  `ti_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模板ID',
  `ti_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `ti_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '第三方中心化SN',
  `ti_dir` varchar(32) NOT NULL DEFAULT '' COMMENT '模板目录',
  `ti_type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '模板类型 0-pc端 1-wap端 2-手机端 ',
  `ti_thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '模板缩略图路径',
  `ti_other_pic` varchar(255) DEFAULT '' COMMENT '其他图片，这里存成二维数组的json字符串',
  `ti_desc` text COMMENT '模板描述',
  `ti_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '模板创建时间',
  `ti_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间',
  PRIMARY KEY (`ti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模板表';
DROP TABLE IF EXISTS `fx_thd_agents_pictures`;
CREATE TABLE `fx_thd_agents_pictures` (
  `atp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片ID，系统自增；',
  `top_shop_code` int(11) NOT NULL DEFAULT '0' COMMENT '第三方店铺ID唯一标识',
  `top_picture_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '淘宝图片空间ID',
  `top_picture_category_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '淘宝图片空间分类ID',
  `top_picture_path` varchar(255) NOT NULL DEFAULT '' COMMENT '淘宝图片路径',
  `ecfx_picture_path` varchar(255) NOT NULL DEFAULT '' COMMENT '分销图片路径（与淘宝nick联合唯一）',
  `top_title` varchar(255) NOT NULL DEFAULT '' COMMENT '淘宝图片标题 为空即可',
  `top_sizes` int(11) NOT NULL DEFAULT '0' COMMENT '淘宝图片大小,单位是byte',
  `top_pixel` varchar(100) NOT NULL DEFAULT '' COMMENT '图片像素',
  `top_status` varchar(20) NOT NULL DEFAULT '' COMMENT '图片状态,unfroze代表没有被冻结，froze代表被冻结,pass代表排查通过',
  `top_deleted` varchar(20) NOT NULL DEFAULT '' COMMENT '图片是否删除的标记',
  `top_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '图片上传到淘宝图片空间的时间',
  `top_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '图片在淘宝上的最后更新时间',
  PRIMARY KEY (`atp_id`),
  UNIQUE KEY `nick_img` (`top_shop_code`,`ecfx_picture_path`),
  KEY `top_status` (`top_status`),
  KEY `top_deleted` (`top_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方店铺图片日志操作记录';
DROP TABLE IF EXISTS `fx_thd_goods`;
CREATE TABLE `fx_thd_goods` (
  `thd_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `thd_source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方来源标识：1为淘宝，2为拍拍。',
  `thd_goods_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方商品ID',
  `thd_goods_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方商品编号，也就是商家编码',
  `thd_goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方商品名称',
  `thd_goods_data` mediumtext COMMENT '第三方商品详细信息，存json_encode字符串(所有的数据)',
  `thd_goods_picture` varchar(200) NOT NULL DEFAULT '' COMMENT '商品主图地址，从淘宝下载到本地的。',
  `thd_goods_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录同步到本系统的时间',
  `thd_goods_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  `thd_goods_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '淘宝商品状态(1:在架，2；下架(仓库))',
  `ts_id` int(11) NOT NULL DEFAULT '0' COMMENT '来源于第三方店铺ID',
  PRIMARY KEY (`thd_id`),
  KEY `thd_goods_id` (`thd_goods_id`),
  KEY `ts_id` (`ts_id`),
  KEY `thd_source` (`thd_source`),
  KEY `thd_goods_sn` (`thd_goods_sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方商品数据表';
DROP TABLE IF EXISTS `fx_thd_logistic_template`;
CREATE TABLE `fx_thd_logistic_template` (
  `lt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键Id',
  `lt_assumer` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:表示买家承担服务费； 1:表示卖家承担服务费',
  `lt_fee_list` text COMMENT 'json格式。运费模板中运费详细信息对象，包含默认运费和指定地区运费',
  `lt_name` varchar(255) NOT NULL DEFAULT '' COMMENT '模板名称',
  `lt_supports` varchar(255) NOT NULL DEFAULT '' COMMENT '物流服务模板支持增值服务列表，多个用分号隔开。cod:货到付款 mops：刷卡付款',
  `lt_template_id` int(12) NOT NULL DEFAULT '0' COMMENT '淘宝物流模版ID',
  `lt_valuation` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:表示按宝贝件数计算运费,1:表示按宝贝重量计算运费,3:表示按宝贝体积计算运费',
  `lt_shop_id` varchar(50) NOT NULL DEFAULT '' COMMENT '卖家店铺ID',
  `lt_consign_area_id` int(10) NOT NULL DEFAULT '0' COMMENT '该模板上设置的卖家发货地址区域ID',
  `lt_address` varchar(255) NOT NULL DEFAULT '' COMMENT '运费模板上设置的发货地址',
  `lt_json_data` text COMMENT '原始json数据',
  PRIMARY KEY (`lt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方物流模版表';
DROP TABLE IF EXISTS `fx_thd_orders`;
CREATE TABLE `fx_thd_orders` (
  `to_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id ',
  `ts_id` int(10) NOT NULL DEFAULT '0' COMMENT '第三方网店id',
  `to_oid` varchar(32) NOT NULL DEFAULT '' COMMENT '第三方订单ID',
  `to_source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单来源，1为淘宝，2为拍拍，3京东，4亚马逊',
  `to_buyer_id` varchar(255) NOT NULL DEFAULT '' COMMENT '买家昵称',
  `to_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '交易创建时间（第三方创建时间）',
  `to_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '本地修改时间',
  `to_pay_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '付款时间（第三方付款时间）',
  `to_post_fee` decimal(8,0) NOT NULL DEFAULT '0' COMMENT '邮费（第三方）',
  `to_payment` decimal(8,0) NOT NULL DEFAULT '0' COMMENT '实付金额。精确到2位小数；单位:元。如:200.07，表示:200元7分（第三方）',
  `to_receiver_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人的详细地址（第三方）',
  `to_receiver_city` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人的所在城市（第三方）',
  `to_receiver_district` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人的所在地区',
  `to_receiver_mobile` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人的手机号码（第三方）',
  `to_receiver_phone` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `to_receiver_name` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人的姓名',
  `to_receiver_province` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人的所在省份',
  `to_receiver_zip` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人的邮编',
  `to_tt_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：尚未处理, 1：已经处理, 2：标记处理',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID（本地）',
  `to_visitor_id` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺来源id',
  `to_buyer_message` text COMMENT 'c2c下单买家留言',
  `to_seller_memo` text COMMENT '第三方平台的卖家备注',
  `to_pay_type` varchar(30) NOT NULL COMMENT '支付方式（1-货到付款, 2-邮局汇款, 3-自提, 4-在线支付, 5-公司转账, 6-银行转账）',
  `to_seller_title` varchar(255) DEFAULT '' COMMENT '卖家店铺名称',
  `to_thd_status` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方订单状态',
  `to_is_match` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已匹配 0:未匹配，1匹配',
  `to_seller_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '卖家备注旗帜 红、黄、绿、蓝、紫 分别对应 1、2、3、4、5',
  `to_temp_receiver_address` TEXT NOT NULL COMMENT '被卖家编辑后的详细地址（第三方）',
  `to_temp_seller_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '卖家备注旗帜临时字段 红、黄、绿、蓝、紫 分别对应 1、2、3、4、5',
  PRIMARY KEY (`to_id`),
  KEY `to_oid` (`to_oid`) USING BTREE,
  KEY `ts_id` (`ts_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方订单信息';
DROP TABLE IF EXISTS `fx_thd_orders_items`;
CREATE TABLE `fx_thd_orders_items` (
  `toi_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `to_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方订单的主键id',
  `toi_adjust_money` decimal(8,0) NOT NULL DEFAULT '0' COMMENT '手工调整金额',
  `toi_discount_money` decimal(8,0) NOT NULL DEFAULT '0' COMMENT '系统优惠金额（如打折，VIP，满就送等），精确到2位小数，单位：元。如：200.07，表示：200元7分',
  `toi_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品购买数量',
  `toi_num_id` varchar(32) NOT NULL DEFAULT '' COMMENT '商品系统编码',
  `toi_price` decimal(8,0) NOT NULL DEFAULT '0' COMMENT '商品价格',
  `toi_title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品标题',
  `toi_outer_id` varchar(255) NOT NULL DEFAULT '' COMMENT '商家外部编码(g_sn)',
  `toi_outer_sku_id` varchar(255) NOT NULL DEFAULT '' COMMENT '外部网店自己定义的Sku编号(pdt_sn)',
  `toi_url` varchar(255) NOT NULL DEFAULT '' COMMENT '快照URL',
  `toi_b2b_pdt_sn_info` varchar(255) NOT NULL DEFAULT '' COMMENT '以序列化的形式存放手工匹配之后对应的b2b货品号和其手工匹配时选择的数量（json）',
  `toi_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：未删除，1：已删除',
  `toi_spec_name` varchar(100) NOT NULL DEFAULT '' COMMENT '属性名称',
  PRIMARY KEY (`toi_id`),
  KEY `toi_outer_sku_id` (`toi_outer_sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方订单信息明细';
DROP TABLE IF EXISTS `fx_thd_related_logistic`;
CREATE TABLE `fx_thd_related_logistic` (
  `thd_lt_id_old` int(12) NOT NULL DEFAULT '0' COMMENT '原店铺的物流模版ID',
  `thd_lt_id_new` int(12) NOT NULL DEFAULT '0' COMMENT '新插入店铺的物流模版ID',
  `thd_shop_id_old` int(12) NOT NULL DEFAULT '0' COMMENT '原店铺的ID',
  `thd_shop_id_new` int(12) NOT NULL DEFAULT '0' COMMENT '新铺货店铺的ID',
  `thd_update_time` int(12) NOT NULL DEFAULT '0' COMMENT '插入记录时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='物流模版铺货新旧店内的ID对应关系表';
DROP TABLE IF EXISTS `fx_thd_shop_itemcats`;
CREATE TABLE `fx_thd_shop_itemcats` (
  `tsi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tsi_indentify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方对接平台:1,淘宝；2,拍拍；',
  `ts_sid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方店铺ID',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方店铺类目ID',
  `is_parent` varchar(5) NOT NULL DEFAULT 'false' COMMENT '是否是父分类',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方店铺分类名称',
  `parent_cid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方店铺分类的父分类ID',
  `sort_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序，默认值0',
  `cat_type` varchar(20) NOT NULL DEFAULT '' COMMENT '分类类型？？',
  `tsi_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tsi_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tsi_id`),
  KEY `tsi_indentify` (`tsi_indentify`) USING BTREE,
  KEY `ts_sid` (`ts_sid`) USING BTREE,
  KEY `cid` (`cid`) USING BTREE,
  KEY `is_parent` (`is_parent`) USING BTREE,
  KEY `parent_cid` (`parent_cid`) USING BTREE,
  KEY `sort_order` (`sort_order`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='第三方店铺分类表';

-- ----------------------------
-- Table structure for fx_thd_shops
-- ----------------------------
DROP TABLE IF EXISTS `fx_thd_shops`;
CREATE TABLE `fx_thd_shops` (
  `ts_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `ts_title` varchar(100) NOT NULL DEFAULT '',
  `ts_source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：默认，1:淘宝，2：拍拍，3：京东',
  `ts_sid` int(10) NOT NULL DEFAULT '0' COMMENT '第三方店铺id',
  `m_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员id',
  `u_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `ts_pic_path` varchar(255) NOT NULL DEFAULT '' COMMENT '店标地址。返回相对路径，可以用"http://logo.taobao.com/shop-logo"来拼接成绝对路径',
  `ts_nick` varchar(255) NOT NULL DEFAULT '' COMMENT '卖家昵称',
  `ts_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录生成时间',
  `ts_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后修改时间',
  `ts_shop_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '在第三方平台记录生成时间',
  `ts_seller_info_json` text COMMENT '卖家的信息json格式数据',
  `ts_shop_info_json` text COMMENT '店铺的json格式数据',
  `ts_shop_token` text COMMENT '店铺授权信息，主要用于拍拍平台自用型APP的授权信息',
  `ts_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否默认此店铺物流模板(0:否,1：是)',
  PRIMARY KEY (`ts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方网店表';
DROP TABLE IF EXISTS `fx_thd_spread_goods`;
CREATE TABLE `fx_thd_spread_goods` (
  `tsg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `tsg_platform` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方平台标识：1，淘宝；2：拍拍',
  `tsg_shop_sid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方店铺唯一标识,id',
  `tsg_item_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方商品ID，大B店铺内的商品ID',
  `tsg_goods_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '商品sn（对应淘宝商家编码）',
  `tsg_shop_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方商品id，小b店铺内的商品ID',
  `tsg_last_upload_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次上传时间',
  `tsg_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `tsg_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`tsg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方铺货记录表';
DROP TABLE IF EXISTS `fx_thd_top_items`;
CREATE TABLE `fx_thd_top_items` (
  `it_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关联关系id，系统自增；',
  `g_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `num_iid` bigint(11) NOT NULL DEFAULT '0' COMMENT '商品数字id',
  `pdt_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '商品货号',
  `sku_id` bigint(11) NOT NULL DEFAULT '0' COMMENT 'SKU数字id',
  `it_nick` varchar(255) NOT NULL DEFAULT '' COMMENT '关联的淘宝账号',
  `spec_name` varchar(255) NOT NULL COMMENT '属性名称',
  PRIMARY KEY (`it_id`),
  KEY `it_nick` (`it_nick`),
  KEY `it_sn_iid` (`g_id`,`num_iid`) USING BTREE,
  KEY `it_pdt_sku` (`pdt_id`,`sku_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分销商品与淘宝商品关联关系表';
DROP TABLE IF EXISTS `fx_thd_upload_tmp`;
CREATE TABLE `fx_thd_upload_tmp` (
  `tut_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `thd_indentify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '第三方平台标识：1，淘宝；2：拍拍',
  `thd_shop_sid` int(11) NOT NULL DEFAULT '0' COMMENT '第三方店铺唯一标识,id',
  `thd_item_id` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方商品g_sn，大B店铺内的商品g_sn',
  `thd_shop_item_iid` bigint(20) NOT NULL DEFAULT '0' COMMENT '第三方商品id，小b店铺内的商品ID',
  `last_upload_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次上传时间',
  `tut_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `tut_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后更新时间',
  PRIMARY KEY (`tut_id`),
  KEY `thd_indentify` (`thd_indentify`),
  KEY `thd_shop_sid` (`thd_shop_sid`),
  KEY `thd_item_id` (`thd_item_id`),
  KEY `thd_shop_item_iid` (`thd_shop_item_iid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方店铺商品上传记录表';
DROP TABLE IF EXISTS `fx_top_access_info`;
CREATE TABLE `fx_top_access_info` (
  `top_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '淘宝用户ID',
  `top_user_nick` varchar(255) NOT NULL DEFAULT '0' COMMENT '淘宝用户nick',
  `top_access_token` varchar(255) NOT NULL DEFAULT '' COMMENT '访问token',
  `top_expires_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'token过期时间',
  `top_refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT '刷新访问token使用的token',
  `top_refresh_expires_in` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新token的token过期时间',
  `top_w1_expires_in` int(11) NOT NULL DEFAULT '0' COMMENT 'w1权限字段授权过期时间，单位是秒',
  `top_w2_expires_in` int(11) NOT NULL DEFAULT '0' COMMENT 'w2权限字段授权过期时间，单位是秒',
  `top_r1_expires_in` int(11) NOT NULL DEFAULT '0' COMMENT 'r1权限字段授权过期时间，单位是秒',
  `top_r2_expires_in` int(11) NOT NULL DEFAULT '0' COMMENT 'r2权限字段授权过期时间，单位是秒',
  `top_type` tinyint(4) DEFAULT '0' COMMENT '店铺类型 0：默认，1:淘宝，2：拍拍，3：京东',
  `token_type` varchar(255) NOT NULL DEFAULT '' COMMENT '授权类型，token_type',
  `top_oauth_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '授权时间',
  PRIMARY KEY (`top_user_id`),
  UNIQUE KEY `top_user_nick` (`top_user_nick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='淘宝用户授权信息表';
DROP TABLE IF EXISTS `fx_top_itemprop_values`;
CREATE TABLE `fx_top_itemprop_values` (
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '类目ID',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '属性 ID',
  `prop_name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名',
  `vid` int(11) NOT NULL DEFAULT '0' COMMENT '属性值ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `name_alias` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值别名',
  `is_parent` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否为父类目属性',
  `status` varchar(10) NOT NULL DEFAULT '' COMMENT '状态。可选值:normal(正常),deleted(删除)',
  `sort_order` int(11) NOT NULL DEFAULT '0' COMMENT '排列序号。取值范围:大于零的整数',
  PRIMARY KEY (`vid`,`pid`,`cid`),
  KEY `cid` (`cid`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性值';
DROP TABLE IF EXISTS `fx_top_itemprops`;
CREATE TABLE `fx_top_itemprops` (
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '商品所属类目ID',
  `is_input_prop` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '在is_enum_prop是true的前提下，是否是卖家可以自行输入的属性（注：如果is_enum_prop返回false，该参数统一返回false）。可选值:true(是),false(否)。对于品牌和型号属性（包括子属性）：如果用户是C卖家，则可自定义属性；如果是B卖家，则不可自定义属性，而必须要授权的属性。',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '属性 ID 例：品牌的PID=20000',
  `parent_pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级属性ID',
  `parent_vid` int(11) NOT NULL DEFAULT '0' COMMENT '上级属性值ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '属性名',
  `is_key_prop` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否关键属性。可选值:true(是),false(否)',
  `is_sale_prop` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否销售属性。可选值:true(是),false(否)',
  `is_color_prop` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否颜色属性。可选值:true(是),false(否)',
  `is_enum_prop` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否枚举属性。可选值:true(是),false(否)。如果返回true，属性值是下拉框选择输入，如果返回false，属性值是用户自行手工输入。',
  `is_item_prop` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否商品属性。可选值:true(是),false(否)',
  `must` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '发布产品或商品时是否为必选属性。可选值:true(是),false(否)',
  `multi` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '发布产品或商品时是否可以多选。可选值:true(是),false(否)',
  `status` varchar(10) NOT NULL DEFAULT '' COMMENT '状态。可选值:normal(正常),deleted(删除)',
  `sort_order` int(11) NOT NULL DEFAULT '0' COMMENT '排列序号。取值范围:大于零的整排列序号。取值范围:大于零的整数',
  `child_template` varchar(255) NOT NULL DEFAULT '' COMMENT '子属性的模板（卖家自行输入属性时需要用到）',
  `is_allow_alias` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否允许别名。可选值：true（是），false（否）',
  PRIMARY KEY (`cid`,`pid`),
  KEY `parent_pid` (`parent_pid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性';

-- ----------------------------
-- Table structure for fx_try
-- ----------------------------
DROP TABLE IF EXISTS `fx_try`;
CREATE TABLE `fx_try` (
  `try_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '试用自增ID',
  `try_title` varchar(50) NOT NULL COMMENT '试用标题',
  `try_start_time` datetime NOT NULL COMMENT '试用开始时间',
  `try_end_time` datetime NOT NULL COMMENT '试用结束时间',
  `try_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:停用；1:启用 2:删除',
  `try_create_time` datetime NOT NULL COMMENT '创建时间',
  `try_update_time` datetime NOT NULL COMMENT '修改时间',
  `g_id` int(20) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `g_sn` varchar(50) NOT NULL COMMENT '商品编码',
  `try_picture` varchar(200) DEFAULT NULL COMMENT '试用图片',
  `try_desc` text COMMENT '试用描述',
  `try_now_num` int(11) NOT NULL DEFAULT '0' COMMENT '已申请试用数量',
  `try_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '显示此讯',
  `property_typeid` int(11) NOT NULL COMMENT '关联类型ID（问卷调查时试用)',
  `try_is_show_detail` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示商品详情',
  `try_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '试用数量',
  `property_typeid_front` int(11) NOT NULL DEFAULT '0' COMMENT '关联类型ID（申请试用时调用)',
  PRIMARY KEY (`try_id`),
  KEY `g_id` (`g_id`),
  KEY `property_typeid` (`property_typeid`),
  KEY `try_status` (`try_status`),
  KEY `try_start_time` (`try_start_time`),
  KEY `try_end_time` (`try_end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='试用表';
DROP TABLE IF EXISTS `fx_try_apply_records`;
CREATE TABLE `fx_try_apply_records` (
  `tar_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `try_id`  int(11) NOT NULL DEFAULT 0 COMMENT '申请试用的活动id',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '申请会员ID',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '申请商品ID',
  `property_typeid` int(11) NOT NULL DEFAULT '0' COMMENT '试用类型ID',
  `property_typeid_front` int(11) NOT NULL DEFAULT '0' COMMENT '关联类型ID（申请试用时调用)',
  `o_receiver_name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人',
  `o_receiver_mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人手机',
  `o_receiver_telphone` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `o_receiver_state` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人省份',
  `o_receiver_city` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人城市',
  `o_receiver_county` varchar(50) NOT NULL DEFAULT '' COMMENT '地区第三级（文字）',
  `o_receiver_address` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人地址',
  `ra_id` int(10) NOT NULL DEFAULT '0' COMMENT '收货地址id（最后一级id）',
  `o_receiver_zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '收货人邮编',
  `tar_create_time` datetime NOT NULL COMMENT '新增时间',
  `tar_update_time` datetime NOT NULL COMMENT '修改时间',
  `try_oid` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `try_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:申请中 1:审核通过 2:审核不通过',
  `try_apply_reason` varchar(255) DEFAULT NULL COMMENT '申请理由',
  PRIMARY KEY (`tar_id`),
  KEY `m_id` (`m_id`),
  KEY `g_id` (`g_id`),
  KEY `property_typeid` (`property_typeid`),
  KEY `try_oid` (`try_oid`),
  KEY `try_status` (`try_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='试用申请记录表';
DROP TABLE IF EXISTS `fx_try_attribute`;
CREATE TABLE `fx_try_attribute` (
  `ta_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `try_apply_id` int(11) NOT NULL DEFAULT '0' COMMENT '试用申请ID',
  `property_typeid` int(11) NOT NULL DEFAULT '0' COMMENT '试用类型ID',
  `attr_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性ID',
  `attr_value` text NOT NULL COMMENT '属性值',
  `attr_name` varchar(50) NOT NULL COMMENT '属性名称',
  PRIMARY KEY (`ta_id`),
  KEY `try_apply_id` (`try_apply_id`),
  KEY `property_typeid` (`property_typeid`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `fx_try_report`;
CREATE TABLE `fx_try_report` (
  `tr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `try_id` int(11) NOT NULL DEFAULT '0' COMMENT '试用ID',
  `property_typeid` int(11) NOT NULL DEFAULT '0' COMMENT '试用类型ID',
  `tr_create_time` datetime NOT NULL COMMENT '创建时间',
  `tr_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  `m_id` int(11) NOT NULL DEFAULT '0' COMMENT '报告人',
  `tr_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '报告状态 0:未审核 1:已审核 ',
  PRIMARY KEY (`tr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='试用报告';
DROP TABLE IF EXISTS `fx_try_report_attribute`;
CREATE TABLE `fx_try_report_attribute` (
  `ta_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `try_apply_id` int(11) NOT NULL DEFAULT '0' COMMENT '试用申请ID',
  `property_typeid` int(11) NOT NULL DEFAULT '0' COMMENT '试用类型ID',
  `attr_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性ID',
  `attr_value` text NOT NULL COMMENT '属性值',
  `attr_name` varchar(50) NOT NULL COMMENT '属性名称',
  PRIMARY KEY (`ta_id`),
  KEY `try_apply_id` (`try_apply_id`),
  KEY `property_typeid` (`property_typeid`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for fx_useful_links
-- ----------------------------
DROP TABLE IF EXISTS `fx_useful_links`;
CREATE TABLE `fx_useful_links` (
  `ul_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `ul_name` varchar(50) NOT NULL DEFAULT '' COMMENT '友情链接文字，显示在友情链接上的文字',
  `ul_image_path` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接图片地址',
  `ul_link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接地址，url',
  `ul_is_image_link` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是图片链接:0否，1是',
  `ul_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序，升序规定前台友情链接的显示顺序',
  `ul_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '友情链接状态，默认1，正常；0，废弃；2，进入回收站',
  `ul_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '友情链接添加时间',
  `ul_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '友情链接最后修改时间',
  PRIMARY KEY (`ul_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Table structure for fx_warehouse
-- ----------------------------
DROP TABLE IF EXISTS `fx_warehouse`;
CREATE TABLE `fx_warehouse` (
  `w_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '仓库ID',
  `w_name` varchar(50) NOT NULL COMMENT '商家的仓库名称，可更新',
  `w_code` varchar(100) NOT NULL COMMENT '商家的仓库编码，不允许重复，不允许更新(erp_id+erp_code)',
  `w_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仓库是否显示：0.否，1.是',
  `w_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '仓库创建时间',
  `w_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '仓库更新时间',
  `w_out_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未停用，1：停用',
  `w_alias_name` varchar(50) DEFAULT NULL COMMENT '仓库简称，可更新',
  `w_address` varchar(100) DEFAULT NULL COMMENT '仓库的物理地址，可更新',
  `w_address_area_name` varchar(50) DEFAULT NULL COMMENT '仓库区域名，可更新',
  `w_contact` varchar(30) DEFAULT NULL COMMENT '联系人，可更新',
  `w_phone` varchar(30) DEFAULT NULL COMMENT '联系电话，可更新',
  `w_postcode` varchar(10) DEFAULT NULL COMMENT '邮编，可更新 ',
  `erp_id` varchar(50) DEFAULT NULL COMMENT '对应ERPid',
  `erp_code` varchar(50) DEFAULT NULL COMMENT 'erp仓库编码',
  PRIMARY KEY (`w_id`),
  UNIQUE KEY `w_code` (`w_code`) USING BTREE,
  KEY `erp_id` (`erp_id`) USING BTREE,
  KEY `erp_code` (`erp_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库表';

-- ----------------------------
-- Table structure for fx_warehouse_delivery_area
-- ----------------------------
DROP TABLE IF EXISTS `fx_warehouse_delivery_area`;
CREATE TABLE `fx_warehouse_delivery_area` (
  `wa_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号ID',
  `w_id` int(11) NOT NULL COMMENT '仓库ID',
  `cr_id` int(11) NOT NULL COMMENT '地址库ID',
  `erp_code` varchar(50) NOT NULL COMMENT 'ERP区域代码',
  `lt_id` int(11) NOT NULL COMMENT '配送区域ID',
  PRIMARY KEY (`wa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库配送区域表';

-- ----------------------------
-- Table structure for fx_warehouse_stock
-- ----------------------------
DROP TABLE IF EXISTS `fx_warehouse_stock`;
CREATE TABLE `fx_warehouse_stock` (
  `ws_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分仓库存ID',
  `w_id` int(11) NOT NULL COMMENT '仓库ID',
  `pdt_id` int(11) NOT NULL COMMENT '货品ID',
  `g_id` int(11) NOT NULL COMMENT '商品ID',
  `pdt_total_stock` int(11) NOT NULL DEFAULT '0' COMMENT '总库存数，即仓库中的实际库存数',
  `pdt_stock` int(11) NOT NULL DEFAULT '0' COMMENT '可下单库存',
  `pdt_freeze_stock` int(11) NOT NULL DEFAULT '0' COMMENT '冻结库存',
  `pdt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `ws_create_time` int(11) NOT NULL COMMENT '仓库库存创建时间',
  `ws_update_time` int(11) NOT NULL COMMENT '仓库库存更新时间',
  `erp_id` varchar(50) DEFAULT NULL COMMENT 'ERP的ID',
  `erp_code` varchar(100) DEFAULT NULL COMMENT 'erp仓库代码',
  `pdt_sn` varchar(50) NOT NULL COMMENT '商品规格编码',
  `g_sn` varchar(50) NOT NULL COMMENT '商品编码',
  PRIMARY KEY (`ws_id`),
  UNIQUE KEY `pdt_sn_g_sn_w_id` (`pdt_sn`,`g_sn`,`w_id`) USING BTREE,
  KEY `pdt_id` (`pdt_id`) USING BTREE,
  KEY `g_id` (`g_id`) USING BTREE,
  KEY `w_id` (`w_id`) USING BTREE,
  KEY `code` (`erp_id`,`erp_code`) USING BTREE,
  KEY `pdt_sn` (`pdt_sn`) USING BTREE,
  KEY `g_sn` (`g_sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库库存表';

DROP TABLE IF EXISTS `fx_oss_pic`;
CREATE TABLE `fx_oss_pic` (
  `pic_url` varchar(250) NOT NULL COMMENT '本地图片路径',
  `pic_oss_url` varchar(500) NOT NULL COMMENT 'saas下图片路径',
  PRIMARY KEY (`pic_url`),
  UNIQUE KEY `pic_url` (`pic_url`) USING BTREE,
  KEY `pic_oss_url` (`pic_oss_url`(255)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='oss阿里云存储';

DROP TABLE IF EXISTS `fx_session`;
CREATE TABLE `fx_session` (
  `session_id` varchar(255) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` blob,
  UNIQUE KEY `session_id` (`session_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='session存取使用数据库';

DROP TABLE IF EXISTS `fx_template_operation_log`;
CREATE TABLE `fx_template_operation_log` (
  `tl_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `tl_operation` varchar(100) NOT NULL DEFAULT '' COMMENT '操作',
  `u_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `u_real_name` varchar(50) NOT NULL DEFAULT '' COMMENT '编辑人姓名',
  `tl_operation_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  `tl_model` varchar(30) NOT NULL DEFAULT '' COMMENT '操作模块',
  PRIMARY KEY (`tl_id`),
  KEY `u_real_name` (`u_real_name`) USING BTREE,
  KEY `u_name` (`u_name`) USING BTREE,
  KEY `tl_operation_time` (`tl_operation_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='模板操作日志表';

DROP TABLE IF EXISTS `fx_qn_pic`;
CREATE TABLE `fx_qn_pic` (
  `pic_url` varchar(250) NOT NULL COMMENT '本地图片路径',
  `pic_qn_url` varchar(500) NOT NULL COMMENT '七牛访问下图片路径',
  `sign_end_time` datetime NOT NULL COMMENT '签名到期日期',
  PRIMARY KEY (`pic_url`),
  UNIQUE KEY `pic_url` (`pic_url`) USING BTREE,
  KEY `pic_qn_url` (`pic_qn_url`(255)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='七牛存储';

DROP TABLE IF EXISTS `fx_goods_comment_statistics`;
CREATE TABLE `fx_goods_comment_statistics` (
	`gcs_id` INT(11) NOT NULL AUTO_INCREMENT,
	`g_id` INT(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
	`five_star_count` INT(11) NOT NULL DEFAULT '0' COMMENT '5星评论数',
	`four_star_count` INT(11) NOT NULL DEFAULT '0' COMMENT '4星评论数',
	`three_star_count` INT(11) NOT NULL DEFAULT '0' COMMENT '3星评论数',
	`two_star_count` INT(11) NOT NULL DEFAULT '0' COMMENT '2星评论数',
	`one_star_count` INT(11) NOT NULL DEFAULT '0' COMMENT '1星评论数',
	`total_count` INT(11) NOT NULL DEFAULT '0' COMMENT '总评论数',
	`average_score` INT(11) NOT NULL DEFAULT '0' COMMENT '平均评论得分',
	`last_month_count` INT(11) NOT NULL DEFAULT '0' COMMENT '最近一个月评论数',
	`two_months_count` INT(11) NOT NULL DEFAULT '0' COMMENT '最近2个月评论数',
	`three_months_count` INT(11) NOT NULL DEFAULT '0' COMMENT '最近3个月评论数',
	`pic_comment_count` INT(11) NOT NULL DEFAULT '0' COMMENT '总晒单数',
	`positive_count` INT(11) NOT NULL DEFAULT '0' COMMENT '好评数',
	`positive_ratio` FLOAT NOT NULL DEFAULT '0' COMMENT '好评率',
	PRIMARY KEY (`gcs_id`),
	INDEX `g_id` (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论统计';

DROP TABLE IF EXISTS `fx_admin_pay`;
CREATE TABLE `fx_admin_pay` (
  `ap_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单号',
  `add_u_id` int(11) NOT NULL DEFAULT '0' COMMENT '制单人',
  `verify_u_id` int(11) NOT NULL DEFAULT '0' COMMENT '审单人',
  `add_u_name` varchar(50) NOT NULL COMMENT '制单人名称',
  `verify_u_name` varchar(50) NOT NULL COMMENT '审单人名称',
  `ap_remark` varchar(255) NOT NULL COMMENT '备注',
  `ps_gateway_sn` varchar(255) NOT NULL COMMENT '网关流水号',
  `ap_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0未审核,1已审核,2已作废',
  `ps_id` int(11) NOT NULL DEFAULT '0' COMMENT '第三方流水号ID',
  `ap_create_time` datetime NOT NULL COMMENT '单据生成时间',
  `ap_update_time` datetime NOT NULL COMMENT '单据更新时间',
  PRIMARY KEY (`ap_id`),
  KEY `order_id` (`order_id`),
  KEY `ap_status` (`ap_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员强制支付列表';

DROP TABLE IF EXISTS `fx_integral`;
CREATE TABLE `fx_integral` (
  `integral_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分兑换ID',
  `integral_need` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '积分+金额兑换 所需积分',
  `integral_title` varchar(255) NOT NULL COMMENT '秒杀标题',
  `integral_desc` text COMMENT '积分+金额兑换描述',
  `integral_picture` varchar(100) NOT NULL COMMENT '秒杀图片',
  `g_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `integral_now_number` int(11) NOT NULL DEFAULT '0' COMMENT '已兑换数量',
  `money_need_to_pay` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '还需缴纳金额',
  `integral_goods_desc_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示商品描述',
  `integral_start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动开始时间',
  `integral_end_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动结束时间',
  `integral_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用：0.停用，1.启用',
  `integral_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '积分兑换创建时间',
  `integral_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '积分兑换更新时间',
  `integral_mobile_desc` text NOT NULL COMMENT '手机端描述',
   `integral_num`  int(11) NOT NULL DEFAULT 0 COMMENT '限购数量 当购买数量大于限购数量时 活动结束',
  `gc_id` int(11) NOT NULL DEFAULT 0 COMMENT '积分分类',
  PRIMARY KEY (`integral_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分兑换';

DROP TABLE IF EXISTS `fx_integral_category`;
CREATE TABLE `fx_integral_category` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `gc_parent_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '父类目ID',
  `gc_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类分级数，0是一级，1是二级以此类推。',
  `gc_is_parent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是父类目(0不是父级，1是父级)',
  `gc_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类目名称',
  `gc_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '类目图片',
  `gc_order` int(11) NOT NULL DEFAULT '0' COMMENT '类目排序',
  `gc_is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台是否显示 0不显示 1显示',
  `gc_description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `gc_keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',
  `gc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据记录状态，0为废弃，1为有效，2为进入回收站',
  `gc_create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `gc_update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录最后更新时间',
  PRIMARY KEY (`gc_id`),
  KEY `gc_parent_id` (`gc_parent_id`) USING BTREE,
  KEY `gc_is_parent` (`gc_is_parent`) USING BTREE,
  KEY `gc_order` (`gc_order`) USING BTREE,
  KEY `gc_is_display` (`gc_is_display`) USING BTREE,
  KEY `gc_status` (`gc_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分兑换商品分类';

-- ----------------------------
-- View structure for fx_view_orders
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_orders`;
CREATE VIEW `fx_view_orders` AS select `m`.`m_name` AS `m_name`,`m`.`m_password` AS `m_password`,`m`.`m_real_name` AS `m_real_name`,`m`.`m_sex` AS `m_sex`,`m`.`cr_id` AS `cr_id`,`m`.`m_address_detail` AS `m_address_detail`,`m`.`m_birthday` AS `m_birthday`,`m`.`m_zipcode` AS `m_zipcode`,`m`.`m_mobile` AS `m_mobile`,`m`.`m_telphone` AS `m_telphone`,`m`.`m_status` AS `m_status`,`m`.`m_email` AS `m_email`,`m`.`ml_id` AS `ml_id`,`m`.`m_wangwang` AS `m_wangwang`,`m`.`m_qq` AS `m_qq`,`m`.`m_website_url` AS `m_website_url`,`m`.`m_verify` AS `m_verify`,`m`.`m_balance` AS `m_balance`,`m`.`m_all_cost` AS `m_all_cost`,`m`.`m_create_time` AS `m_create_time`,`m`.`m_update_time` AS `m_update_time`,`m`.`thd_guid` AS `thd_guid`,`m`.`m_recommended` AS `m_recommended`,`m`.`m_security_deposit` AS `m_security_deposit`,`m`.`m_alipay_name` AS `m_alipay_name`,`m`.`m_balance_name` AS `m_balance_name`,`o`.`o_id` AS `o_id`,`o`.`o_sn` AS `o_sn`,`o`.`m_id` AS `m_id`,`o`.`o_pay_status` AS `o_pay_status`,`o`.`o_goods_all_price` AS `o_goods_all_price`,`o`.`o_all_price` AS `o_all_price`,`o`.`o_discount` AS `o_discount`,`o`.`o_pay` AS `o_pay`,`o`.`o_cost_payment` AS `o_cost_payment`,`o`.`o_cost_freight` AS `o_cost_freight`,`o`.`o_payment` AS `o_payment`,`o`.`o_receiver_name` AS `o_receiver_name`,`o`.`o_receiver_mobile` AS `o_receiver_mobile`,`o`.`o_receiver_telphone` AS `o_receiver_telphone`,`o`.`o_receiver_state` AS `o_receiver_state`,`o`.`o_receiver_city` AS `o_receiver_city`,`o`.`o_receiver_county` AS `o_receiver_county`,`o`.`o_receiver_address` AS `o_receiver_address`,`o`.`ra_id` AS `ra_id`,`o`.`o_receiver_zipcode` AS `o_receiver_zipcode`,`o`.`o_create_time` AS `o_create_time`,`o`.`o_update_time` AS `o_update_time`,`o`.`o_status` AS `o_status`,`o`.`o_receiver_email` AS `o_receiver_email`,`o`.`o_receiver_time` AS `o_receiver_time`,`o`.`lt_id` AS `lt_id`,`o`.`o_audit` AS `o_audit`,`o`.`o_buyer_comments` AS `o_buyer_comments`,`o`.`o_seller_comments` AS `o_seller_comments`,`o`.`o_source_type` AS `o_source_type`,`o`.`erp_sn` AS `erp_sn`,`o`.`o_pre_sale` AS `o_pre_sale`,`o`.`o_coupon` AS `o_coupon`,`o`.`coupon_sn` AS `coupon_sn`,`o`.`coupon_value` AS `coupon_value`,`o`.`coupon_start_date` AS `coupon_start_date`,`o`.`coupon_end_date` AS `coupon_end_date`,`oi`.`oi_id` AS `oi_id`,`oi`.`g_id` AS `g_id`,`oi`.`pdt_id` AS `pdt_id`,`oi`.`gt_id` AS `gt_id`,`oi`.`g_sn` AS `g_sn`,`oi`.`oi_g_name` AS `oi_g_name`,`oi`.`oi_cost_price` AS `oi_cost_price`,`oi`.`pdt_sale_price` AS `pdt_sale_price`,`oi`.`oi_price` AS `oi_price`,`oi`.`oi_score` AS `oi_score`,`oi`.`oi_nums` AS `oi_nums`,`oi`.`oi_sendnum` AS `oi_sendnum`,`oi`.`oi_point` AS `oi_point`,`oi`.`oi_refund_status` AS `oi_refund_status`,`oi`.`pdt_sn` AS `pdt_sn`,`oi`.`oi_ship_status` AS `oi_ship_status`,`oi`.`oi_single_allowance` AS `oi_single_allowance`,`oi`.`oi_create_time` AS `oi_create_time`,`oi`.`oi_update_time` AS `oi_update_time`,`oi`.`oi_thd_sale_price` AS `oi_thd_sale_price`,`o`.`o_freeze_point` AS `o_freeze_point`,`o`.`o_reward_point` AS `o_reward_point` from ((`fx_orders` `o` left join `fx_orders_items` `oi` on((`o`.`o_id` = `oi`.`o_id`))) left join `fx_members` `m` on((`o`.`m_id` = `m`.`m_id`))) ;

-- ----------------------------
-- View structure for fx_view_delivery
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_delivery`;
CREATE VIEW `fx_view_delivery` AS select `od`.`od_id` AS `od_id`,`od`.`o_id` AS `o_id`,`od`.`od_created` AS `od_created`,`od`.`od_delivery` AS `od_delivery`,`od`.`m_id` AS `m_id`,`od`.`od_money` AS `od_money`,`od`.`od_is_protect` AS `od_is_protect`,`od`.`od_logi_id` AS `od_logi_id`,`od`.`od_logi_name` AS `od_logi_name`,`od`.`od_logi_no` AS `od_logi_no`,`od`.`u_name` AS `u_name`,`od`.`u_id` AS `u_id`,`od`.`od_memo` AS `od_memo`,`od`.`od_receiver_name` AS `od_receiver_name`,`od`.`od_receiver_mobile` AS `od_receiver_mobile`,`od`.`od_receiver_telphone` AS `od_receiver_telphone`,`od`.`od_receiver_area` AS `od_receiver_area`,`od`.`od_receiver_address` AS `od_receiver_address`,`od`.`od_receiver_zipcode` AS `od_receiver_zipcode`,`od`.`od_receiver_email` AS `od_receiver_email`,`od`.`od_outer_odid` AS `od_outer_odid`,`od`.`od_receiver_city` AS `od_receiver_city`,`od`.`od_receiver_province` AS `od_receiver_province`,`odi`.`odi_id` AS `odi_id`,`odi`.`oi_id` AS `oi_id`,`odi`.`odi_num` AS `odi_num` from ((`fx_orders_delivery` `od` left join `fx_orders_delivery_items` `odi` on((`od`.`od_id` = `odi`.`od_id`))) left join `fx_view_orders` `vo` on((`od`.`o_id` = `vo`.`o_id`))) ;

-- ----------------------------
-- View structure for fx_view_goods
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_goods`;
CREATE VIEW `fx_view_goods` AS select `gc`.`gc_name` AS `gc_name`,`gc`.`gc_id` AS `gc_id`,`g`.`g_id` AS `g_id`,`g`.`gb_id` AS `gb_id`,`g`.`gt_id` AS `gt_id`,`g`.`g_on_sale` AS `g_on_sale`,`g`.`g_status` AS `g_status`,`g`.`g_sn` AS `g_sn`,`g`.`g_off_sale_time` AS `g_off_sale_time`,`g`.`g_on_sale_time` AS `g_on_sale_time`,`g`.`g_new` AS `g_new`,`g`.`g_hot` AS `g_hot`,`g`.`g_retread_date` AS `g_retread_date`,`g`.`g_pre_sale_status` AS `g_pre_sale_status`,`g`.`g_gifts` AS `g_gifts`,`g`.`g_is_prescription_rugs` AS `g_is_pres`,`gb`.`gb_name` AS `gb_name`,`gt`.`gt_name` AS `gt_name`,`gi`.`ma_price` AS `ma_price`,`gi`.`g_description` AS `gdescription`,`gi`.`mi_price` AS `mi_price`,`gi`.`g_name` AS `g_name`,`gi`.`g_price` AS `g_price`,`gi`.`g_unit` AS `g_unit`,`gi`.`g_desc` AS `g_desc`,`gi`.`g_picture` AS `g_picture`,`gi`.`g_no_stock` AS `g_no_stock`,`gi`.`g_create_time` AS `g_create_time`,`gi`.`g_update_time` AS `g_update_time`,`gi`.`g_red_num` AS `g_red_num`,`gi`.`g_source` AS `g_source`,`gi`.`g_stock` AS `g_stock`,`gi`.`g_salenum` AS `g_salenum`,`gi`.`point` AS `g_point`,`gi`.`is_exchange` AS `g_is_exchange` from (((((`fx_goods` `g` left join `fx_goods_info` `gi` on((`g`.`g_id` = `gi`.`g_id`))) left join `fx_goods_brand` `gb` on((`g`.`gb_id` = `gb`.`gb_id`))) left join `fx_goods_type` `gt` on((`g`.`gt_id` = `gt`.`gt_id`))) left join `fx_related_goods_category` `rgc` on((`g`.`g_id` = `rgc`.`g_id`))) left join `fx_goods_category` `gc` on((`rgc`.`gc_id` = `gc`.`gc_id`))) ;

-- ----------------------------
-- View structure for fx_view_logistic
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_logistic`;
CREATE VIEW `fx_view_logistic` AS select `rlc`.`cr_id` AS `cr_id`,`lt`.`lt_id` AS `lt_id`,`lt`.`lc_id` AS `lc_id`,`lt`.`lt_name` AS `lt_name`,`lt`.`lt_config` AS `lt_config`,`lt`.`lt_expressions` AS `lt_expressions`,`lt`.`lt_detail` AS `lt_detail`,`lt`.`lt_protect` AS `lt_protect`,`lt`.`lt_protect_rate` AS `lt_protect_rate`,`lt`.`lt_minprice` AS `lt_minprice`,`lt`.`lt_status` AS `lt_status`,`lt`.`lt_create_time` AS `lt_create_time`,`lt`.`lt_update_time` AS `lt_update_time`,`lc`.`lc_is_enable` AS `lc_is_enable`,`lc`.`lc_name` AS `lc_name`,`lc`.`lc_description` AS `lc_description`,`lc`.`lc_cash_on_delivery` AS `lc_cash_on_delivery`,`lc`.`lc_ordernum` AS `lc_ordernum`,`lc`.`lc_website` AS `lc_website`,`lc`.`lc_abbreviation_name` AS `lc_abbreviation_name`,`lc`.`erp_delivery_guid` AS `erp_delivery_guid`,`lc`.`lc_create_time` AS `lc_create_time`,`lc`.`lc_update_time` AS `lc_update_time` from ((`fx_logistic_type` `lt` left join `fx_logistic_corp` `lc` on((`lt`.`lc_id` = `lc`.`lc_id`))) left join `fx_related_logistic_city` `rlc` on((`rlc`.`lt_id` = `lt`.`lt_id`))) ;

-- ----------------------------
-- View structure for fx_view_members
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_members`;
CREATE VIEW `fx_view_members` AS select `m`.`m_id` AS `m_id`,`m`.`m_name` AS `m_name`,`m`.`m_password` AS `m_password`,`m`.`m_real_name` AS `m_real_name`,`m`.`m_sex` AS `m_sex`,`m`.`cr_id` AS `cr_id`,`m`.`m_address_detail` AS `m_address_detail`,`m`.`m_birthday` AS `m_birthday`,`m`.`m_zipcode` AS `m_zipcode`,`m`.`m_mobile` AS `m_mobile`,`m`.`m_telphone` AS `m_telphone`,`m`.`m_status` AS `m_status`,`m`.`m_email` AS `m_email`,`m`.`ml_id` AS `ml_id`,`m`.`m_wangwang` AS `m_wangwang`,`m`.`m_qq` AS `m_qq`,`m`.`m_website_url` AS `m_website_url`,`m`.`m_verify` AS `m_verify`,`m`.`m_balance` AS `m_balance`,`m`.`m_all_cost` AS `m_all_cost`,`m`.`m_create_time` AS `m_create_time`,`m`.`m_update_time` AS `m_update_time`,`m`.`thd_guid` AS `thd_guid`,`m`.`m_recommended` AS `m_recommended`,`m`.`m_security_deposit` AS `m_security_deposit`,`m`.`m_alipay_name` AS `m_alipay_name`,`m`.`m_balance_name` AS `m_balance_name`,`m`.`total_point` AS `total_point`,`ml`.`ml_name` AS `ml_name`,`ml`.`ml_discount` AS `ml_discount`,`ml`.`ml_default` AS `ml_default`,`ml`.`ml_status` AS `ml_status`,`ml`.`ml_create_time` AS `ml_create_time`,`ml`.`ml_update_time` AS `ml_update_time`,`ml`.`ml_erp_guid` AS `ml_erp_guid`,`ml`.`ml_order` AS `ml_order` from (`fx_members` `m` left join `fx_members_level` `ml` on((`m`.`ml_id` = `ml`.`ml_id`))) ;

-- ----------------------------
-- View structure for fx_view_members_group
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_members_group`;
CREATE VIEW `fx_view_members_group` AS select `mg`.`mg_id` AS `mg_id`,`mg`.`mg_name` AS `mg_name`,`mg`.`mg_info` AS `mg_info`,`mg`.`mg_status` AS `mg_status`,`mg`.`mg_create_time` AS `mg_create_time`,`mg`.`mg_update_time` AS `mg_update_time`,`m`.`m_id` AS `m_id`,`m`.`m_name` AS `m_name`,`m`.`m_password` AS `m_password`,`m`.`m_real_name` AS `m_real_name`,`m`.`m_sex` AS `m_sex`,`m`.`cr_id` AS `cr_id`,`m`.`m_address_detail` AS `m_address_detail`,`m`.`m_birthday` AS `m_birthday`,`m`.`m_zipcode` AS `m_zipcode`,`m`.`m_mobile` AS `m_mobile`,`m`.`m_telphone` AS `m_telphone`,`m`.`m_status` AS `m_status`,`m`.`m_email` AS `m_email`,`m`.`ml_id` AS `ml_id`,`m`.`m_wangwang` AS `m_wangwang`,`m`.`m_qq` AS `m_qq`,`m`.`m_website_url` AS `m_website_url`,`m`.`m_verify` AS `m_verify`,`m`.`m_balance` AS `m_balance`,`m`.`m_all_cost` AS `m_all_cost`,`m`.`m_create_time` AS `m_create_time`,`m`.`m_update_time` AS `m_update_time`,`m`.`thd_guid` AS `thd_guid`,`m`.`m_recommended` AS `m_recommended`,`m`.`m_security_deposit` AS `m_security_deposit`,`m`.`m_alipay_name` AS `m_alipay_name`,`m`.`m_balance_name` AS `m_balance_name` from ((`fx_members` `m` left join `fx_related_members_group` `rmg` on((`m`.`m_id` = `rmg`.`m_id`))) left join `fx_members_group` `mg` on((`rmg`.`mg_id` = `mg`.`mg_id`))) ;

-- ----------------------------
-- View structure for fx_view_products
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_products`;
CREATE VIEW `fx_view_products` AS select `vg`.`gc_name` AS `gc_name`,`vg`.`g_id` AS `g_id`,`vg`.`gb_id` AS `gb_id`,`vg`.`gt_id` AS `gt_id`,`vg`.`g_on_sale` AS `g_on_sale`,`vg`.`g_status` AS `g_status`,`vg`.`g_sn` AS `g_sn`,`vg`.`g_off_sale_time` AS `g_off_sale_time`,`vg`.`g_on_sale_time` AS `g_on_sale_time`,`vg`.`g_new` AS `g_new`,`vg`.`g_hot` AS `g_hot`,`vg`.`gb_name` AS `gb_name`,`vg`.`gt_name` AS `gt_name`,`vg`.`g_name` AS `g_name`,`vg`.`g_price` AS `g_price`,`vg`.`g_unit` AS `g_unit`,`vg`.`g_desc` AS `g_desc`,`vg`.`g_picture` AS `g_picture`,`vg`.`g_no_stock` AS `g_no_stock`,`vg`.`g_create_time` AS `g_create_time`,`vg`.`g_update_time` AS `g_update_time`,`vg`.`g_red_num` AS `g_red_num`,`vg`.`g_point` AS `g_point`,`vg`.`g_is_exchange` AS `g_is_exchange`,`gp`.`pdt_id` AS `pdt_id`,`gp`.`g_sn` AS `g_p_sn`,`gp`.`pdt_sn` AS `pdt_sn`,`gp`.`pdt_sale_price` AS `pdt_sale_price`,`gp`.`pdt_cost_price` AS `pdt_cost_price`,`gp`.`pdt_market_price` AS `pdt_market_price`,`gp`.`pdt_weight` AS `pdt_weight`,`gp`.`pdt_stock` AS `pdt_stock`,`gp`.`pdt_status` AS `pdt_status`,`gp`.`pdt_place` AS `pdt_place`,`gp`.`pdt_red_num` AS `pdt_red_num`,`gp`.`pdt_price_up` AS `pdt_price_up`,`gp`.`pdt_price_down` AS `pdt_price_down`,`gp`.`pdt_memo` AS `pdt_memo`,`gp`.`pdt_on_way_stock` AS `pdt_on_way_stock`,`gp`.`pdt_create_time` AS `pdt_create_time`,`gp`.`pdt_update_time` AS `pdt_update_time`,`gp`.`pdt_max_num` AS `pdt_max_num`,`gp`.`factory_arrival_start_date` AS `factory_arrival_start_date`,`gp`.`factory_arrival_end_date` AS `factory_arrival_end_date`,`gp`.`promise_send_start_date` AS `promise_send_start_date`,`gp`.`promise_send_end_date` AS `promise_send_end_date` from (`fx_goods_products` `gp` left join `fx_view_goods` `vg` on((`gp`.`g_id` = `vg`.`g_id`))) ;

-- ----------------------------
-- View structure for fx_view_recharge_examine
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_recharge_examine`;
CREATE VIEW `fx_view_recharge_examine` AS select `re`.`re_id` AS `re_id`,`re`.`re_name` AS `re_name`,`re`.`re_money` AS `re_money`,`re`.`re_money_end` AS `re_money_end`,`re`.`re_payment_sn` AS `re_payment_sn`,`re`.`re_message` AS `re_message`,`re`.`m_id` AS `m_id`,`re`.`a_account_number` AS `a_account_number`,`re`.`a_id` AS `a_id`,`re`.`a_apply_bank` AS `a_apply_bank`,`re`.`a_apply_name` AS `a_apply_name`,`re`.`re_time` AS `re_time`,`re`.`re_verify` AS `re_verify`,`re`.`re_user_message` AS `re_user_message`,`re`.`re_user_id` AS `re_user_id`,`re`.`re_status` AS `re_status`,`re`.`re_create_time` AS `re_create_time`,`re`.`re_update_time` AS `re_update_time`,`m`.`m_name` AS `m_name`,`m`.`m_password` AS `m_password`,`m`.`m_real_name` AS `m_real_name`,`m`.`m_sex` AS `m_sex`,`m`.`cr_id` AS `cr_id`,`m`.`m_address_detail` AS `m_address_detail`,`m`.`m_birthday` AS `m_birthday`,`m`.`m_zipcode` AS `m_zipcode`,`m`.`m_mobile` AS `m_mobile`,`m`.`m_telphone` AS `m_telphone`,`m`.`m_status` AS `m_status`,`m`.`m_email` AS `m_email`,`m`.`ml_id` AS `ml_id`,`m`.`m_wangwang` AS `m_wangwang`,`m`.`m_qq` AS `m_qq`,`m`.`m_website_url` AS `m_website_url`,`m`.`m_verify` AS `m_verify`,`m`.`m_balance` AS `m_balance`,`m`.`m_all_cost` AS `m_all_cost`,`m`.`m_create_time` AS `m_create_time`,`m`.`m_update_time` AS `m_update_time`,`m`.`thd_guid` AS `thd_guid`,`m`.`m_recommended` AS `m_recommended`,`m`.`m_security_deposit` AS `m_security_deposit`,`m`.`m_alipay_name` AS `m_alipay_name`,`m`.`m_balance_name` AS `m_balance_name` from (`fx_recharge_examine` `re` left join `fx_members` `m` on((`re`.`m_id` = `m`.`m_id`))) ;

-- ----------------------------
-- View structure for fx_view_refunds
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_refunds`;
CREATE VIEW `fx_view_refunds` AS select `ri`.`ori_id` AS `ori_id`,`or`.`o_id` AS `o_id`,`ri`.`oi_id` AS `oi_id`,`ri`.`ori_num` AS `ori_num`,`or`.`or_id` AS `or_id`,`or`.`m_id` AS `m_id`,`or`.`or_account` AS `or_account`,`or`.`or_bank` AS `or_bank`,`or`.`or_payee` AS `or_payee`,`or`.`or_currency` AS `or_currency`,`or`.`or_money` AS `or_money`,`or`.`or_t_sent` AS `or_t_sent`,`or`.`or_t_received` AS `or_t_received`,`or`.`or_buyer_memo` AS `or_buyer_memo`,`or`.`or_seller_memo` AS `or_seller_memo`,`or`.`or_refund_type` AS `or_refund_type`,`or`.`or_return_sn` AS `or_return_sn`,`or`.`or_processing_status` AS `or_processing_status`,`or`.`or_pay_type_id` AS `or_pay_type_id`,`or`.`or_create_time` AS `or_create_time`,`or`.`or_update_time` AS `or_update_time`,`or`.`m_name` AS `m_name`,`or`.`u_id` AS `u_id`,`or`.`u_name` AS `u_name` from (`fx_orders_refunds` `or` left join `fx_orders_refunds_items` `ri` on((`or`.`or_id` = `ri`.`or_id`))) ;

-- ----------------------------
-- View structure for fx_view_running_account
-- ----------------------------
DROP VIEW IF EXISTS `fx_view_running_account`;
CREATE VIEW `fx_view_running_account` AS select `m`.`m_id` AS `m_id`,`m`.`m_name` AS `m_name`,`m`.`m_password` AS `m_password`,`m`.`m_real_name` AS `m_real_name`,`m`.`m_sex` AS `m_sex`,`m`.`cr_id` AS `cr_id`,`m`.`m_address_detail` AS `m_address_detail`,`m`.`m_birthday` AS `m_birthday`,`m`.`m_zipcode` AS `m_zipcode`,`m`.`m_mobile` AS `m_mobile`,`m`.`m_telphone` AS `m_telphone`,`m`.`m_status` AS `m_status`,`m`.`m_email` AS `m_email`,`m`.`ml_id` AS `ml_id`,`m`.`m_wangwang` AS `m_wangwang`,`m`.`m_qq` AS `m_qq`,`m`.`m_website_url` AS `m_website_url`,`m`.`m_verify` AS `m_verify`,`m`.`m_balance` AS `m_balance`,`m`.`m_all_cost` AS `m_all_cost`,`m`.`m_create_time` AS `m_create_time`,`m`.`m_update_time` AS `m_update_time`,`m`.`thd_guid` AS `thd_guid`,`m`.`m_recommended` AS `m_recommended`,`m`.`m_security_deposit` AS `m_security_deposit`,`m`.`m_alipay_name` AS `m_alipay_name`,`m`.`m_balance_name` AS `m_balance_name`,`ra`.`ra_id` AS `ra_id`,`ra`.`ra_money` AS `ra_money`,`ra`.`ra_type` AS `ra_type`,`ra`.`ra_before_money` AS `ra_before_money`,`ra`.`ra_after_money` AS `ra_after_money`,`ra`.`ra_payment_method` AS `ra_payment_method`,`ra`.`ra_payment_sn` AS `ra_payment_sn`,`ra`.`ra_create_time` AS `ra_create_time`,`ra`.`ra_memo` AS `ra_memo` from (`fx_running_account` `ra` left join `fx_members` `m` on((`m`.`m_id` = `ra`.`m_id`))) ;

INSERT INTO `fx_admin` VALUES (1,'admin','93c509e58bb9ee2f29b5437006915929','127.0.0.1','系统管理员','分销','001',' ',1,1,50,'2013-04-02 10:45:25','2013-04-02 10:45:25','2013-04-02 10:45:25');
INSERT INTO `fx_balance_type` VALUES (1,1000,'购物消费','购物消费',1,10,'2013-06-05 21:43:03','0000-00-00 00:00:00'),(2,1001,'账户退款','账户退款',1,10,'2013-06-05 21:43:06','0000-00-00 00:00:00'),(3,1002,'账户充值','账户充值',1,10,'2013-06-05 21:43:09','0000-00-00 00:00:00'),(4,1003,'结余款提现','结余款提现',1,10,'2013-06-05 21:43:16','0000-00-00 00:00:00');
INSERT INTO `fx_area_jurisdiction` VALUES (110000,'北京市',0),(440000,'广东省',0),(450000,'广西壮族自治区',0),(460000,'海南省',0),(500000,'重庆市',0),(510000,'四川省',0),(520000,'贵州省',0),(530000,'云南省',0),(540000,'西藏自治区',0),(610000,'陕西省',0),(620000,'甘肃省',0),(630000,'青海省',0),(640000,'宁夏回族自治区',0),(650000,'新疆维吾尔自治区',0),(710000,'台湾省',0),(810000,'香港特别行政区',0),(430000,'湖南省',0),(420000,'湖北省',0),(120000,'天津市',0),(130000,'河北省',0),(140000,'山西省',0),(150000,'内蒙古自治区',0),(210000,'辽宁省',0),(220000,'吉林省',0),(230000,'黑龙江省',0),(310000,'上海市',0),(320000,'江苏省',0),(330000,'浙江省',0),(340000,'安徽省',0),(350000,'福建省',0),(360000,'江西省',0),(370000,'山东省',0),(410000,'河南省',0),(820000,'澳门特别行政区',0);
INSERT INTO `fx_goods_spec` VALUES (888,'颜色','','',1,2,1,1,1,1,1,'2013-05-29 04:12:12','0000-00-00 00:00:00','0',0,0);
INSERT INTO `fx_goods_spec_detail` VALUES (1,888,'军绿色','5d762a',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(2,888,'天蓝色','1eddff',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(3,888,'巧克力色','d2691e',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(4,888,'桔色','ffa500',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(5,888,'浅灰色','e4e4e4',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(6,888,'浅绿色','98fb98',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(7,888,'浅黄色','ffffb1',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(8,888,'深卡其布色','bdb76b',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(9,888,'深灰色','666666',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(10,888,'深紫色','4b0082',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(11,888,'深蓝色','041690',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(12,888,'白色','ffffff',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(13,888,'粉红色','ffb6c1',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(14,888,'紫罗兰','dda0dd',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(15,888,'紫色','800080',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(16,888,'红色','ff0000',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(17,888,'绿色','008000',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(18,888,'蓝色','0000ff',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(19,888,'褐色','855b00',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(20,888,'酒红色','990000',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(21,888,'黄色','ffff00',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0),(22,888,'黑色','000000',1,'',1,'2013-05-29 04:12:12','0000-00-00 00:00:00',0,0,0);
INSERT INTO `fx_invoice_config` VALUES (1,1,'2,1','1,1','生活用品',0);
INSERT IGNORE INTO `fx_members_fields` (`id`, `field_name`, `dis_order`, `is_display`, `list_display`, `type`, `is_need`, `is_register`, `is_edit`, `fields_type`, `fields_content`, `is_status`, `fields_point`) VALUES
	(1, '用户名', 1, 1, 0, 1, 1, 1, 1, 'text', 'm_name', 1, 0),
	(2, 'E-mail', 2, 0, 0, 1, 1, 1, 1, 'text', 'm_email', 1, 0),
	(3, '密码', 3, 1, 0, 1, 0, 1, 1, 'text', 'm_password', 1, 0),
	(4, '确认密码', 4, 1, 0, 1, 0, 1, 1, 'text', 'm_password_1', 1, 0),
	(5, '姓名', 5, 0, 0, 1, 0, 1, 1, 'text', 'm_real_name', 1, 0),
	(6, '邮编', 6, 0, 0, 1, 0, 1, 1, 'text', 'm_zipcode', 1, 0),
	(7, '联系地址', 7, 0, 0, 1, 0, 1, 1, 'text', 'm_address_detail', 1, 0),
	(8, '移动电话', 8, 0, 0, 1, 0, 1, 1, 'text', 'm_mobile', 1, 0),
	(9, '固定电话', 9, 0, 0, 1, 0, 1, 1, 'text', 'm_telphone', 1, 0),
	(10, '网站地址', 10, 0, 0, 1, 0, 0, 0, 'text', 'm_website_url', 1, 0),
	(11, '支付宝', 11, 0, 0, 1, 0, 0, 1, 'text', 'm_alipay_name', 1, 0),
	(12, '银行账户名', 12, 0, 0, 1, 0, 1, 1, 'text', 'm_balance_name', 1, 0),
	(13, 'QQ', 13, 0, 0, 1, 0, 0, 1, 'text', 'm_qq', 1, 0),
	(14, '省份/城市/区', 14, 0, 0, 1, 0, 0, 0, 'select', '', 1, 0),
	(15, '旺旺', 15, 0, 0, 1, 0, 0, 1, 'text', 'm_wangwang', 1, 0),
	(16, '保证金', 16, 0, 0, 1, 0, 0, 0, 'text', 'm_security_deposit', 1, 0),
	(17, '调整积分(增/减)', 17, 0, 0, 1, 0, 0, 1, 'text', 'tz_point', 1, 0),
	(18, '推荐人', 1, 0, 0, 1, 0, 1, 1, 'text', 'm_recommended', 1, 0),
	(19, '来源平台', 5, 0, 0, 0, 0, 1, 1, 'select', '淘宝,拍拍,京东', 1, 0),
	(20, '头像', 1, 1, 0, 0, 0, 0, 1, 'file', '', 1, 0);
INSERT INTO `fx_members_level` VALUES (1,'普通会员','普通会员',100.000,1,1,'2013-05-27 05:49:27','2013-05-27 05:51:31','',0,0.000,0.000,0);
INSERT INTO `fx_payment_cfg` VALUES ('1', '预存款', 'deposit', 'DEPOSIT', '', '0.000', '预存款', '2015-12-14 12:25:08', '000', '1', '0', '0', '7'),('2', '支付宝', 'alipay', 'ALIPAY', '{\"alipay_account\":\"test\",\"pay_safe_code\":\"test\",\"identity_id\":\"test\",\"interface_type\":\"1\"}', '0.000', '支付宝支付', '2015-04-10 17:20:13', '0', '0', '1', '0', '1'),('3', '线下支付', 'offline', 'OFFLINE', '', '0.000', '线下支付', '2015-12-14 12:25:08', '0', '0', '0', '0', '1'),('4', '财付通', 'tenpay', 'TENPAY', '', '0.000', '支付财付通', '2015-12-14 12:25:08', '0', '0', '1', '0', '1'),('5', '网银在线', 'chinabank', 'CHINABANK', '', '0.000', '支付网银在线', '2015-12-14 12:25:08', '0', '0', '1', '0', '1'),('6', '货到付款', 'cash_delivery', 'DELIVERY', '', '0.000', '货到付款', '2015-12-14 12:25:08', '0', '0', '0', '0', '5'),('7', '银联在线', 'chinapay', 'CHINAPAY', '', '0.000', '支付银联在线', '2015-12-14 12:25:08', '0', '0', '1', '0', '1'),('8', '中国银联', 'chinaunionpay', 'CHINAUNIONPAY', null, '0.000', '中国银联', '2015-12-14 12:25:08', '', '0', '0', '8', '1'),('9', 'WAP支付宝', 'wapalipay', 'WAPALIPAY', '{\"alipay_account\":\"test\",\"pay_safe_code\":\"test\",\"identity_id\":\"test\",\"interface_type\":\"1\",\"pay_encryp\":\"MD5\"}', '0.000', 'WAP支付宝', '2015-12-14 12:25:08', '', '0', '1', '10', '6'),('11', '工商银行', 'icbc', 'ICBC', null, '0.000', '此支付方式为工行接口', '2015-10-15 11:31:30', '', '0', '1', '12', '1'),('12', '银联在线v5.0.0', 'chinapayv5', 'CHINAPAYV5', null, '0.000', '银联在线支付(全渠道商户)', '2015-12-14 12:25:09', '0', '0', '1', '6', '5'),('13', '微信支付', 'weixin', 'WEIXIN', null, '0.000', '此支付方式为商城微信支付(PC端扫码支付、手机端公众号支付)', '2015-12-14 12:25:09', '', '0', '1', '13', '4'),('15', '交行支付', 'bocompay', 'BOCOMPAY', null, '0.000', '此支付方式为中国交通银行支付', '2015-12-14 12:33:30', '0', '0', '1', '15', '5');
INSERT INTO `fx_role_access` VALUES (11,16),(11,22),(11,29),(11,42),(11,49),(11,55),(11,63),(11,77),(11,84),(11,88),(11,91),(11,98),(11,110),(11,113),(11,130),(11,137),(11,146),(11,153),(11,162),(11,172),(11,184),(11,191),(11,212),(11,221),(11,229),(11,237),(11,241),(13,16),(13,22),(13,29),(13,42),(13,49),(13,55),(13,63),(13,77),(13,130),(13,184),(13,237),(14,98),(14,191),(12,18),(12,20),(12,23),(12,30),(12,36),(12,43),(12,50),(12,56),(12,64),(12,70),(12,78),(12,85),(12,89),(12,92),(12,99),(12,114),(12,120),(12,126),(12,130),(12,138),(12,147),(12,154),(12,163),(12,173),(12,185),(12,192),(12,197),(12,198),(12,199),(12,201),(12,208),(12,213),(12,222),(12,230),(12,238),(12,242);
INSERT INTO `fx_sys_config` VALUES (1,'GY_SMTP','GY_SMTP_AUTH','1','是否进行验证','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'GY_SMTP','GY_SMTP_FROM','guanyitest@163.com','发件人地址','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'GY_SMTP','GY_SMTP_FROM_NAME','管易分销测试','仅用于显示的发件人姓名','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'GY_SMTP','GY_SMTP_HOST','smtp.163.com','发送邮件的SMTP主机地址','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'GY_SMTP','GY_SMTP_NAME','guanyitest@163.com','邮件账户','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'GY_SMTP','GY_SMTP_PASS','abcde12345','邮件账户密码','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'GY_SMTP','GY_SMTP_PORT','25','SMTP的端口号，默认是25','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'GY_ERP_API','SWITCH','1','ERP开关','2013-03-14 11:40:21','2013-03-14 11:40:19'),(9,'GY_ERP_API','BASE_URL','http://223.4.54.64:30017/data.dpk','ERP地址','2013-03-14 11:40:22','2013-03-14 11:40:19'),(10,'GY_ERP_API','IMG_URL','http://223.4.54.64:30017/','ERP图片地址','2013-03-14 11:40:22','2013-03-14 11:40:19'),(11,'GY_ERP_API','APP_KEY','31A7301CF6C84DA48DDA9BB2C1E44B33','ERP的KEY','2013-03-14 11:40:22','2013-03-14 11:40:19'),(12,'GY_ERP_API','SHOP_CODE','001','ERP店铺代码','2013-03-14 11:40:22','2013-03-14 11:40:20'),(13,'GY_ERP_API','AUTO_ORDER','1','自动审单','2013-03-14 11:40:22','2013-03-14 11:40:20'),(14,'GY_ERP_API','SYN_PREDEPOSIT',NULL,'显示作废的预存款单','2013-03-14 11:40:22','2013-03-14 11:40:20'),(15,'GY_ERP_API','AGENT_PRICE',NULL,'使用ERP代理售价','2013-03-14 11:40:22','2013-03-14 11:40:20'),(16,'GY_ERP_API','AUTO_PREDEPOSIT',NULL,'预存款自动审核','2013-03-14 11:40:22','2013-03-14 11:40:20'),(17,'ADMIN_ACCESS','EXPIRED_TIME','3600','登陆超时时间','2013-01-28 21:47:06','0000-00-00 00:00:00'),(18,'ADMIN_ACCESS','SYS_ADMIN','admin','系统管理员','2013-01-28 21:47:12','0000-00-00 00:00:00'),(19,'GY_SEO','TITLE_INDEX','','首页标题','0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,'GY_SEO','DESC_INDEX','','首页描述','0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,'GY_SEO','KEY_INDEX','','首页关键词','0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,'GY_SEO','TITLE_CATEGORY','','分类列表页标题','0000-00-00 00:00:00','0000-00-00 00:00:00'),(23,'GY_SEO','DESC_CATEGORY','','分类列表页描述','0000-00-00 00:00:00','0000-00-00 00:00:00'),(24,'GY_SEO','KEY_CATEGORY','','分类列表页关键词','0000-00-00 00:00:00','0000-00-00 00:00:00'),(25,'GY_SEO','TITLE_BRAND','','品牌列表页标题','0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,'GY_SEO','DESC_BRAND','','品牌列表页描述','0000-00-00 00:00:00','0000-00-00 00:00:00'),(27,'GY_SEO','KEY_BRAND','','品牌列表页关键词','0000-00-00 00:00:00','0000-00-00 00:00:00'),(28,'GY_SEO','TITLE_GOODS','','商品详情页标题','0000-00-00 00:00:00','0000-00-00 00:00:00'),(29,'GY_SEO','DESC_GOODS','','商品详情页描述','0000-00-00 00:00:00','0000-00-00 00:00:00'),(30,'GY_SEO','KEY_GOODS','','商品详情页关键词','0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,'GY_SEO','SITE_NAME','','站点名称','0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,'GY_SITEMAP','INDEX_FREQ','','首页更新频率','0000-00-00 00:00:00','0000-00-00 00:00:00'),(33,'GY_SITEMAP','CATE_FREQ','','品牌/分类列表页更新频率','0000-00-00 00:00:00','0000-00-00 00:00:00'),(34,'GY_SITEMAP','GOODS_FREQ','','商品信息更新频率','0000-00-00 00:00:00','0000-00-00 00:00:00'),(35,'GY_SITEMAP','ARTI_FREQ','','文章/公告更新频率','0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,'GY_SITEMAP','MAP_FREQ','','站点地图缓存周期','0000-00-00 00:00:00','0000-00-00 00:00:00'),(37,'GY_SHOP','GY_SHOP_TITLE','分销测试店铺','店铺名称','2013-05-06 06:21:28','2013-05-06 03:23:25'),(38,'GY_SHOP','GY_SHOP_HOST','http://test001.abcde.com:8071/','店铺域名','2013-05-06 06:27:19','2013-05-06 03:23:25'),(39,'GY_SHOP','GY_SHOP_OPEN','1','店铺状态','2013-05-06 06:28:05','2013-05-06 03:23:25'),(40,'GY_SHOP','GY_SHOP_ICP','','ICP备案','2013-05-06 06:30:16','2013-05-06 06:29:31'),(41,'GY_SHOP','GY_SHOP_LOGO','','店铺LOGO地址','2013-05-06 06:34:17','2013-05-06 06:29:31'),(42,'GY_SHOP','GY_SHOP_CODE','','统计代码','2013-05-06 06:36:36','2013-05-06 06:36:33'),(43,'GY_TEMPLATE_DEFAULT','GY_TEMPLATE_DEFAULT','blue','设置默认模板','2013-04-23 01:38:36','2013-04-08 14:58:56'),(44,'GY_IMAGEWATER','MAGNIFIER_ON','1','放大镜开关','2013-08-13 02:38:02','2013-08-13 02:38:02'),(45,'GY_IMAGEWATER','MAGNIFIER_PIC_WIDTH','500','放大镜显示宽度','2013-08-13 02:38:02','2013-08-13 02:38:02'),(46,'GY_IMAGEWATER','MAGNIFIER_PIC_HEIGHT','500','放大镜显示高度','2013-08-13 02:38:02','2013-08-13 02:38:02'),(47,'GY_IMAGEWATER','THUMB_PIC_WIDTH','328','缩略图宽度','2013-08-13 02:38:02','2013-08-13 02:38:02'),(48,'GY_IMAGEWATER','THUMB_PIC_HEIGHT','328','缩略图高度','2013-08-13 02:38:02','2013-08-13 02:38:02'),(57,'GY_CAHE','Memcache_stat','0','是否开启Memcahe缓存 0 不开启 1开启','0000-00-00 00:00:00','0000-00-00 00:00:00'),(58,'GY_CAHE','Memcache_host','127.0.0.1','Memcahe服务器IP地址','0000-00-00 00:00:00','0000-00-00 00:00:00'),(59,'GY_CAHE','Memcache_port','11211','Memcahe服务器端口','0000-00-00 00:00:00','0000-00-00 00:00:00'),(60,'GY_CAHE','Memcache_time','100','Memcahe缓存有效时间','0000-00-00 00:00:00','0000-00-00 00:00:00'),(61,'GY_CAHE','File_cahe_stat','0','是否开启文件缓存 0 不开启 1开启','0000-00-00 00:00:00','0000-00-00 00:00:00'),(62,'GY_CAHE','File_cahe_name','test','缓存目录文件夹名','0000-00-00 00:00:00','0000-00-00 00:00:00'),(63,'GY_CAHE','File_cahe_time','86400','文件缓存有效时间','0000-00-00 00:00:00','0000-00-00 00:00:00'),(64,'GET_COUPON','GET_COUPON_SET','0','促销优惠券获取 0付款后 1发货后 2确认收货后 3订单完成后','0000-00-00 00:00:00','0000-00-00 00:00:00'),(65,'ADMIN_LOGIN_PROMPT','ADMIN_LOGIN_PROMPT_SET','1','显示管理员未登录提示语 0不显示 1显示','0000-00-00 00:00:00','0000-00-00 00:00:00'),(66,'GY_FOREIGN_ORDER', 'LIMIT_ORDER_AMOUNT', '1000', '订单1000元控制提示（单件超过1000元商品除外）', '2015-03-19 11:04:34', '2015-03-19 11:04:34'),(67,'GY_FOREIGN_ORDER', 'IS_AUTO_LIMIT_ORDER_AMOUNT', '0', '开启订单限额控制', '2015-03-19 10:35:53', '2015-03-19 10:35:53'),(68,'GY_FOREIGN_ORDER', 'TAX_THRESHOLD', '50', '订单中含税商品的税额之和是否小于等于50不收税', '2015-03-19 11:04:34', '2015-03-19 11:04:34'),(69, 'GY_OSS', 'GY_QN_ON', '1', '是否开启七牛上传', '2015-07-02 15:57:09', '2015-07-02 15:57:09');
INSERT INTO `fx_bonus_type` VALUES ('1', '1000', '注册红包', '注册红包', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_bonus_type` VALUES ('2', '1001', '抽奖红包', '抽奖红包', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_bonus_type` VALUES ('3', '1002', '红包充值', '红包充值', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_bonus_type` VALUES ('4', '1003', '消费红包', '消费红包', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_sms_templates` VALUES ('1', 'FORGET_PASSWORD', '忘记密码发送验证码', '验证码为:{$authnum},请登录网站,及时验证,谢谢.{$shop_name}', '2014-03-17 11:26:40', '2014-03-17 11:26:40');
INSERT INTO `fx_sms_templates` VALUES ('2', 'REGISTER_CODE', '账号注册发送验证码', '手机验证码为:{$authnum},及时验证,谢谢.{$shop_name}', '2014-08-05 16:36:11', '2014-03-17 11:26:40');
INSERT INTO `fx_sms_templates` VALUES ('3', 'SEND_PASSWORD', '忘记密码重置密码', '密码重置为:{$authnum},请登录网站及时修改密码,谢谢.{$shop_name}', '2014-08-06 14:30:28', '2014-08-06 14:30:36');
INSERT INTO `fx_sms_templates` VALUES ('4', 'MODIFY_MOBILE', '手机更换', '验证码为:{$authnum},请登录网站,及时验证,谢谢.{$shop_name}', '2014-08-06 14:31:41', '2014-08-06 14:31:44');
INSERT INTO `fx_sms_templates` VALUES ('5', 'PAY_CODE', '支付发送验证码', '支付验证码为:{$authnum},请验证支付,谢谢.{$shop_name}', '2014-08-06 14:31:41', '2014-08-06 14:31:41');
INSERT INTO `fx_sms_templates` VALUES ('6', 'BUY_CODE', '提现发送验证码', '提现验证码为:{$authnum},请验证后提现,谢谢.{$shop_name}', '2014-08-06 14:31:41', '2014-08-06 14:31:41');
insert into `fx_sms_templates` VALUES ('7', 'GET_CODE','门店提货发送验证码','亲，您的订单单号为:{$ordernum},提货人姓名为:{$receiver_name},请验证后提货,谢谢.{$shop_name}','2015-05-18 17:00:00','2015-05-18 17:00:00');
INSERT INTO `fx_email_templates` VALUES ('1', 'SEND_PASSWORD', '忘记密码邮件通知', '{$user_name}您好！  您已经进行了密码重置的操作，本链接有效期为10分钟，并且只能使用1次,请点击以下链接(或者复制到您的浏览器):{$reset_email}以确认您的新密码重置操作！{$shop_name}{$send_date}', '2014-08-07 08:57:36', '2014-08-07 08:57:36');
INSERT INTO `fx_email_templates` VALUES ('2', 'VALIDATE_EMAIL', '邮箱验证', '{$user_name}您好！  您已经进行了邮箱验证的操作，本链接有效期为10分钟，并且只能使用1次,请点击以下链接(或者复制到您的浏览器):{$reset_email}以确认您的邮箱操作！{$shop_name}{$send_date}', '2014-08-07 08:57:36', '2014-08-07 08:57:36');
INSERT INTO `fx_cards_type` VALUES ('1', '1000', '储值卡充值', '储值卡充值', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_cards_type` VALUES ('2', '1001', '消费储值卡', '消费储值卡', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_jlb_type` VALUES ('1', '1000', '金币充值', '金币充值', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_jlb_type` VALUES ('2', '1002', '消费金币', '消费金币', '1', '10', '2014-07-11 11:43:03', '2014-07-11 11:43:03');
INSERT INTO `fx_city_region` VALUES (1,0,'',1,'中国',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(2,0,'',1,'阿富汗',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(3,0,'',1,'奥兰群岛',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(4,0,'',1,'阿拉斯加',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(5,0,'',1,'阿尔巴尼亚',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(6,0,'',1,'阿尔及利亚',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(7,0,'',1,'东萨摩亚(美)',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(8,0,'',1,'安道尔',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(9,0,'',1,'安哥拉',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(10,0,'',1,'安圭拉岛(英)',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(11,0,'',1,'南极',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(12,0,'',1,'安提瓜和巴布达',0,1,1,'2014-05-05 12:00:03','2014-05-05 12:00:03'),(13,0,'',1,'阿根廷',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(14,0,'',1,'亚美尼亚',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(15,0,'',1,'阿鲁巴岛',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(16,0,'',1,'澳大利亚',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(17,0,'',1,'奥地利',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(18,0,'',1,'阿塞拜疆',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(19,0,'',1,'巴林',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(20,0,'',1,'根西岛(英)',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(21,0,'',1,'孟加拉国',0,1,1,'2014-05-05 12:00:04','2014-05-05 12:00:04'),(22,0,'',1,'巴巴多斯',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(23,0,'',1,'白俄罗斯',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(24,0,'',1,'比利时',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(25,0,'',1,'伯利兹',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(26,0,'',1,'贝宁',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(27,0,'',1,'百慕大群岛(英)',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(28,0,'',1,'不丹',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(29,0,'',1,'玻利维亚',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(30,0,'',1,'波斯尼亚和黑塞哥维那',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(31,0,'',1,'博茨瓦纳',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(32,0,'',1,'巴西',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(33,0,'',1,'保加利亚',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(34,0,'',1,'布基纳法索',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(35,0,'',1,'布隆迪',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(36,0,'',1,'喀麦隆',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(37,0,'',1,'加拿大',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(38,0,'',1,'加那利群岛',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(39,0,'',1,'佛得角',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(40,0,'',1,'开曼群岛(英)',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(41,0,'',1,'中非',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(42,0,'',1,'乍得',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(43,0,'',1,'智利',0,1,1,'2014-05-05 12:00:05','2014-05-05 12:00:05'),(44,0,'',1,'圣诞岛',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(45,0,'',1,'科科斯岛',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(46,0,'',1,'哥伦比亚',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(47,0,'',1,'科摩罗',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(48,0,'',1,'刚果',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(49,0,'',1,'科克群岛(新)',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(50,0,'',1,'哥斯达黎加',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(51,0,'',1,'克罗地亚',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(52,0,'',1,'古巴',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(53,0,'',1,'塞浦路斯',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(54,0,'',1,'捷克',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(55,0,'',1,'刚果(金)',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(56,0,'',1,'丹麦',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(57,0,'',1,'迪戈加西亚岛',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(58,0,'',1,'吉布提',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(59,0,'',1,'多米尼克国',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(60,0,'',1,'多米尼加共和国',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(61,0,'',1,'厄瓜多尔',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(62,0,'',1,'埃及',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(63,0,'',1,'萨尔瓦多',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(64,0,'',1,'赤道几内亚',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(65,0,'',1,'厄立特里亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(66,0,'',1,'爱沙尼亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(67,0,'',1,'埃塞俄比亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(68,0,'',1,'福克兰群岛',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(69,0,'',1,'法罗群岛(丹)',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(70,0,'',1,'斐济',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(71,0,'',1,'芬兰',0,1,1,'2014-05-05 12:00:06','2014-05-05 12:00:06'),(72,0,'',1,'法国',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(73,0,'',1,'法属波里尼西亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(74,0,'',1,'加蓬',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(75,0,'',1,'冈比亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(76,0,'',1,'格鲁吉亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(77,0,'',1,'德国',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(78,0,'',1,'加纳',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(79,0,'',1,'直布罗陀(英)',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(80,0,'',1,'希腊',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(81,0,'',1,'格陵兰岛',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(82,0,'',1,'格林纳达',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(83,0,'',1,'瓜德罗普岛(法)',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(84,0,'',1,'关岛(美)',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(85,0,'',1,'危地马拉',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(86,0,'',1,'几内亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(87,0,'',1,'几内亚比绍',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(88,0,'',1,'法属圭亚那',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(89,0,'',1,'圭亚那',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(90,0,'',1,'海地',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(91,0,'',1,'洪都拉斯',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(92,0,'',1,'匈牙利',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(93,0,'',1,'冰岛',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(94,0,'',1,'印度',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(95,0,'',1,'印度尼西亚',0,1,1,'2014-05-05 12:00:07','2014-05-05 12:00:07'),(96,0,'',1,'伊郎',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(97,0,'',1,'伊拉克',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(98,0,'',1,'爱尔兰',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(99,0,'',1,'马恩岛(英)',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(100,0,'',1,'以色列',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(101,0,'',1,'意大利',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(102,0,'',1,'科特迪瓦',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(103,0,'',1,'牙买加',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(104,0,'',1,'日本',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(105,0,'',1,'泽西岛(英)',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(106,0,'',1,'约旦',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(107,0,'',1,'柬埔塞',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(108,0,'',1,'哈萨克斯坦',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(109,0,'',1,'肯尼亚',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(110,0,'',1,'基里巴斯',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(111,0,'',1,'科威特',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(112,0,'',1,'吉尔吉斯斯坦',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(113,0,'',1,'老挝',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(114,0,'',1,'拉脱维亚',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(115,0,'',1,'黎巴嫩',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(116,0,'',1,'莱索托',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(117,0,'',1,'利比里亚',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(118,0,'',1,'利比亚',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(119,0,'',1,'列支敦士登',0,1,1,'2014-05-05 12:00:08','2014-05-05 12:00:08'),(120,0,'',1,'立陶宛',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(121,0,'',1,'卢森堡',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(122,0,'',1,'马其顿',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(123,0,'',1,'马达加斯加',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(124,0,'',1,'马拉维',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(125,0,'',1,'马来西亚',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(126,0,'',1,'马尔代夫',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(127,0,'',1,'马里',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(128,0,'',1,'马耳他',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(129,0,'',1,'马绍尔群岛',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(130,0,'',1,'马提尼克(法)',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(131,0,'',1,'毛里塔尼亚',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(132,0,'',1,'毛里求斯',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(133,0,'',1,'马约特岛',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(134,0,'',1,'墨西哥',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(135,0,'',1,'密克罗尼西亚(美)',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(136,0,'',1,'中途岛(美)',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(137,0,'',1,'摩纳哥',0,1,1,'2014-05-05 12:00:09','2014-05-05 12:00:09'),(138,0,'',1,'蒙古',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(139,0,'',1,'黑山',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(140,0,'',1,'蒙特塞拉特岛(英)',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(141,0,'',1,'摩洛哥',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(142,0,'',1,'莫桑比克',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(143,0,'',1,'缅甸',0,1,1,'2014-05-05 12:00:10','2014-05-05 12:00:10'),(144,0,'',1,'纳米比亚',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(145,0,'',1,'瑙鲁',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(146,0,'',1,'尼泊尔',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(147,0,'',1,'荷兰',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(148,0,'',1,'荷属安的列斯群岛',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(149,0,'',1,'新喀里多尼亚群岛(法)',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(150,0,'',1,'新西兰',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(151,0,'',1,'尼加拉瓜',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(152,0,'',1,'尼日尔',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(153,0,'',1,'尼日利亚',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(154,0,'',1,'纽埃岛(新)',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(155,0,'',1,'诺福克岛(澳)',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(156,0,'',1,'朝鲜',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(157,0,'',1,'马里亚纳群岛',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(158,0,'',1,'挪威',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(159,0,'',1,'阿曼',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(160,0,'',1,'巴基斯坦',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(161,0,'',1,'帕劳(美)',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(162,0,'',1,'巴拿马',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(163,0,'',1,'巴布亚新几内亚',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(164,0,'',1,'巴拉圭',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(165,0,'',1,'秘鲁',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(166,0,'',1,'菲律宾',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(167,0,'',1,'波兰',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(168,0,'',1,'葡萄牙',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(169,0,'',1,'波多黎各(美)',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(170,0,'',1,'卡塔尔',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(171,0,'',1,'摩尔多瓦',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(172,0,'',1,'留尼汪岛',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(173,0,'',1,'罗马尼亚',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(174,0,'',1,'俄罗斯',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(175,0,'',1,'卢旺达',0,1,1,'2014-05-05 12:00:11','2014-05-05 12:00:11'),(176,0,'',1,'阿森松(英)',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(177,0,'',1,'圣赫勒拿',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(178,0,'',1,'圣克里斯托弗和尼维斯',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(179,0,'',1,'圣卢西亚',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(180,0,'',1,'圣皮埃尔岛及密克隆岛',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(181,0,'',1,'圣文森特岛(英)',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(182,0,'',1,'西萨摩亚',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(183,0,'',1,'圣马力诺',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(184,0,'',1,'圣多美和普林西比',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(185,0,'',1,'沙特阿拉伯',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(186,0,'',1,'塞内加尔',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(187,0,'',1,'塞尔维亚',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(188,0,'',1,'塞舌尔',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(189,0,'',1,'塞拉利昂',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(190,0,'',1,'新加坡',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(191,0,'',1,'圣马丁(荷)',0,1,1,'2014-05-05 12:00:12','2014-05-05 12:00:12'),(192,0,'',1,'斯洛伐克',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(193,0,'',1,'斯洛文尼亚',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(194,0,'',1,'所罗门群岛',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(195,0,'',1,'索马里',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(196,0,'',1,'南非',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(197,0,'',1,'南乔治亚与南桑威奇群岛',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(198,0,'',1,'韩国',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(199,0,'',1,'西班牙',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(200,0,'',1,'斯里兰卡',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(201,0,'',1,'苏丹',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(202,0,'',1,'苏里南',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(203,0,'',1,'斯瓦尔巴群岛(挪)',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(204,0,'',1,'斯威士兰',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(205,0,'',1,'瑞典',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(206,0,'',1,'瑞士',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(207,0,'',1,'叙利亚',0,1,1,'2014-05-05 12:00:13','2014-05-05 12:00:13'),(208,0,'',1,'塔吉克斯坦',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(209,0,'',1,'泰国',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(210,0,'',1,'巴哈马国',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(211,0,'',1,'梵蒂冈',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(212,0,'',1,'东帝汶',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(213,0,'',1,'多哥',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(214,0,'',1,'托克劳群岛(新)',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(215,0,'',1,'汤加',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(216,0,'',1,'特立尼达和多巴哥',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(217,0,'',1,'突尼斯',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(218,0,'',1,'土耳其',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(219,0,'',1,'土库曼斯坦',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(220,0,'',1,'特克斯和凯科斯群岛(英)',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(221,0,'',1,'图瓦卢',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(222,0,'',1,'乌干达',0,1,1,'2014-05-05 12:00:14','2014-05-05 12:00:14'),(223,0,'',1,'乌克兰',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(224,0,'',1,'阿拉伯联合酋长国',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(225,0,'',1,'英国',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(226,0,'',1,'坦桑尼亚',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(227,0,'',1,'美国本土外小岛屿',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(228,0,'',1,'美国',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(229,0,'',1,'乌拉圭',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(230,0,'',1,'乌兹别克斯坦',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(231,0,'',1,'瓦努阿图',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(232,0,'',1,'委内瑞拉',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(233,0,'',1,'越南',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(234,0,'',1,'维尔京群岛(英)',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(235,0,'',1,'维尔京群岛(美)',0,1,1,'2014-05-05 12:00:16','2014-05-05 12:00:16'),(236,0,'',1,'瓦里斯和富士那群岛(法)',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(237,0,'',1,'西撒哈拉',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(238,0,'',1,'也门',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(239,0,'',1,'南斯拉夫',0,1,1,'2014-05-05 12:00:15','2014-05-05 12:00:15'),(240,0,'',1,'赞比亚',0,1,1,'2014-05-05 12:00:17','2014-05-05 12:00:17'),(241,0,'',1,'桑给巴尔',0,1,1,'2014-05-05 12:00:17','2014-05-05 12:00:17'),(242,0,'',1,'津巴布韦',0,1,1,'2014-05-05 12:00:17','2014-05-05 12:00:17'),(1000,125,'1',1,'槟榔屿',0,2,1,'2014-05-05 12:00:25','2014-05-05 12:32:18'),(1001,1000,'1|1000',1,'北海',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:18'),(1002,1000,'1|1000',1,'槟城',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1003,125,'1',1,'玻璃市',0,2,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1004,1000,'1|1000',1,'大山脚',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1005,1000,'1|1000',1,'高渊',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1006,1003,'1|1003',1,'加央',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1007,125,'1',1,'丁加奴',0,2,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1008,1007,'1|1007',1,'甘马挽',0,3,1,'2014-05-05 12:00:24','2014-05-05 12:32:19'),(1009,1007,'1|1007',1,'瓜拉丁加奴',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1010,1007,'1|1007',1,'龙运',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1011,1007,'1|1007',1,'马江',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1012,1007,'1|1007',1,'实兆',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1013,1007,'1|1007',1,'乌鲁',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1014,1007,'1|1007',1,'勿述',0,3,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1015,125,'1',1,'吉打',0,2,1,'2014-05-05 12:00:25','2014-05-05 12:32:19'),(1016,1015,'1|1015',1,'巴东得腊',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1017,1015,'1|1015',1,'笨筒',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1018,1015,'1|1015',1,'浮罗交怡',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1019,1015,'1|1015',1,'哥打士打',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1020,1015,'1|1015',1,'古邦巴素',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1021,1015,'1|1015',1,'瓜拉姆达',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1022,1015,'1|1015',1,'华玲',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:19'),(1023,1015,'1|1015',1,'居林',0,3,1,'2014-05-05 12:00:24','2014-05-05 12:32:19'),(1024,1015,'1|1015',1,'万拉峇鲁',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:19'),(1025,125,'1',1,'吉兰丹',0,2,1,'2014-05-05 12:00:27','2014-05-05 12:32:19'),(1026,1025,'1|1025',1,'巴西富地',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:19'),(1027,1025,'1|1025',1,'巴西马',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:19'),(1028,1025,'1|1025',1,'丹那美拉',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:19'),(1029,1025,'1|1025',1,'道北',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:19'),(1030,1025,'1|1025',1,'登卓',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:19'),(1031,1025,'1|1025',1,'哥打巴鲁',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1032,1025,'1|1025',1,'瓜拉吉赖',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1033,1025,'1|1025',1,'话望生',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1034,1025,'1|1025',1,'马樟',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1035,1025,'1|1025',1,'日里',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1036,125,'1',1,'吉隆坡',0,2,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1037,1036,'1|1036',1,'吉隆坡',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1038,125,'1',1,'马六甲',0,2,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1039,1038,'1|1038',1,'马六甲市',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:20'),(1040,1038,'1|1038',1,'亚罗牙也',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1041,1038,'1|1038',1,'野新',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1042,125,'1',1,'纳闽',0,2,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1043,1042,'1|1042',1,'纳闽',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1044,1042,'1|1042',1,'维多利亚',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:20'),(1045,125,'1',1,'彭亨',0,2,1,'2014-05-05 12:00:29','2014-05-05 12:32:20'),(1046,1045,'1|1045',1,'百乐',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:20'),(1047,1045,'1|1045',1,'北根',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:20'),(1048,1045,'1|1045',1,'淡马鲁',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1049,1045,'1|1045',1,'而连突',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1050,1045,'1|1045',1,'关丹',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1051,1045,'1|1045',1,'金马仑高原',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1052,1045,'1|1045',1,'劳勿',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1053,1045,'1|1045',1,'立卑',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1054,1045,'1|1045',1,'马兰',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1055,1045,'1|1045',1,'文冬',0,3,1,'2014-05-05 12:00:28','2014-05-05 12:32:20'),(1056,1045,'1|1045',1,'云冰',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1057,125,'1',1,'霹雳',0,2,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1058,1057,'1|1057',1,'安顺',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1059,1057,'1|1057',1,'丹绒马林',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1060,1057,'1|1057',1,'和丰',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1061,1057,'1|1057',1,'紅土坎',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1062,1057,'1|1057',1,'华都牙也',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1063,1057,'1|1057',1,'江沙',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1064,1057,'1|1057',1,'太平',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1065,1057,'1|1057',1,'怡保',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1066,125,'1',1,'柔佛',0,2,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1067,1066,'1|1066',1,'笨珍',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1068,1066,'1|1066',1,'丰盛港',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1069,1066,'1|1066',1,'哥打丁宜',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1070,1066,'1|1066',1,'居銮',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1071,1066,'1|1066',1,'峇株巴辖',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1072,1066,'1|1066',1,'麻坡',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1073,1066,'1|1066',1,'昔加末',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1074,1066,'1|1066',1,'新山',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1075,125,'1',1,'森美兰',0,2,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1076,1075,'1|1075',1,'波德申',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1077,1075,'1|1075',1,'淡边',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1078,1075,'1|1075',1,'芙蓉',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1079,1075,'1|1075',1,'瓜拉庇劳',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:21'),(1080,1075,'1|1075',1,'林茂',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1081,1075,'1|1075',1,'仁保',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1082,1075,'1|1075',1,'日叻务',0,3,1,'2014-05-05 12:00:29','2014-05-05 12:32:21'),(1083,125,'1',1,'沙巴',0,2,1,'2014-05-05 12:00:29','2014-05-05 12:32:22'),(1084,1083,'1|1083',1,'吧巴',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:22'),(1085,1083,'1|1083',1,'保佛',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:22'),(1086,1083,'1|1083',1,'比鲁兰',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:22'),(1087,1083,'1|1083',1,'必达士',0,3,1,'2014-05-05 12:00:30','2014-05-05 12:32:22'),(1088,1083,'1|1083',1,'兵南邦',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1089,1083,'1|1083',1,'担布南',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1090,1083,'1|1083',1,'丹南',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1091,1083,'1|1083',1,'斗湖',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1092,1083,'1|1083',1,'斗亚兰',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1093,1083,'1|1083',1,'哥打基纳巴鲁',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1094,1083,'1|1083',1,'哥打马鲁都',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1095,1083,'1|1083',1,'根地咬',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1096,1083,'1|1083',1,'古达',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1097,1083,'1|1083',1,'古打毛律',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1098,1083,'1|1083',1,'古纳',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1099,1083,'1|1083',1,'瓜拉班尤',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1100,1083,'1|1083',1,'京那巴登岸',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1101,1083,'1|1083',1,'兰脑',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1102,1083,'1|1083',1,'拿笃',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1103,1083,'1|1083',1,'纳巴湾',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:22'),(1104,1083,'1|1083',1,'山打根',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1105,1083,'1|1083',1,'西比陶',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1106,1083,'1|1083',1,'仙本那',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1107,125,'1',1,'沙捞越',0,2,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1108,1107,'1|1107',1,'古晋',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1109,1107,'1|1107',1,'加帛',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1110,1107,'1|1107',1,'林梦',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1111,1107,'1|1107',1,'美里',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1112,1107,'1|1107',1,'民都鲁',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1113,1107,'1|1107',1,'木胶',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1114,1107,'1|1107',1,'木中',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1115,1107,'1|1107',1,'三马拉汉',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1116,1107,'1|1107',1,'斯里阿曼',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1117,1107,'1|1107',1,'泗里街',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1118,1107,'1|1107',1,'泗务',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1119,125,'1',1,'雪兰莪',0,2,1,'2014-05-05 12:00:26','2014-05-05 12:32:23'),(1120,1119,'1|1119',1,'八打灵',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1121,1119,'1|1119',1,'鹅麦',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1122,1119,'1|1119',1,'瓜拉冷岳',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1123,1119,'1|1119',1,'瓜拉雪兰莪',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1124,1119,'1|1119',1,'沙白安南',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1125,1119,'1|1119',1,'乌鲁冷岳',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1126,1119,'1|1119',1,'乌鲁雪兰莪',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(1127,1119,'1|1119',1,'雪邦',0,3,1,'2014-05-05 12:00:27','2014-05-05 12:32:23'),(110000,1,'1',1,'北京',0,2,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110100,110000,'1|110000',1,'北京市',0,3,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110101,110100,'1|110000|110100',0,'东城区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110102,110100,'1|110000|110100',0,'西城区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110103,110100,'1|110000|110100',0,'崇文区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110104,110100,'1|110000|110100',0,'宣武区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110105,110100,'1|110000|110100',0,'朝阳区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110106,110100,'1|110000|110100',0,'丰台区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110107,110100,'1|110000|110100',0,'石景山区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110108,110100,'1|110000|110100',0,'海淀区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110109,110100,'1|110000|110100',0,'门头沟区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110111,110100,'1|110000|110100',0,'房山区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110112,110100,'1|110000|110100',0,'通州区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110113,110100,'1|110000|110100',0,'顺义区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110114,110100,'1|110000|110100',0,'昌平区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110115,110100,'1|110000|110100',0,'大兴区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110116,110100,'1|110000|110100',0,'怀柔区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110117,110100,'1|110000|110100',0,'平谷区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110228,110100,'1|110000|110100',0,'密云县',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110229,110100,'1|110000|110100',0,'延庆县',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(110230,110100,'1|110000|110100',0,'其它区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:32:24'),(120000,1,'1',1,'天津',0,2,1,'2014-05-05 12:02:22','2014-05-05 12:32:24'),(120100,120000,'1|120000',1,'天津市',0,3,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120101,120100,'1|120000|120100',0,'和平区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120102,120100,'1|120000|120100',0,'河东区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120103,120100,'1|120000|120100',0,'河西区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120104,120100,'1|120000|120100',0,'南开区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120105,120100,'1|120000|120100',0,'河北区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120106,120100,'1|120000|120100',0,'红桥区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120107,120100,'1|120000|120100',0,'塘沽区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120108,120100,'1|120000|120100',0,'汉沽区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120109,120100,'1|120000|120100',0,'大港区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120110,120100,'1|120000|120100',0,'东丽区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120111,120100,'1|120000|120100',0,'西青区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120112,120100,'1|120000|120100',0,'津南区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120113,120100,'1|120000|120100',0,'北辰区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120114,120100,'1|120000|120100',0,'武清区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120115,120100,'1|120000|120100',0,'宝坻区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120116,120100,'1|120000|120100',0,'滨海新区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:32:25'),(120221,120100,'1|120000|120100',0,'宁河县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:32:25'),(120223,120100,'1|120000|120100',0,'静海县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:32:25'),(120225,120100,'1|120000|120100',0,'蓟县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:32:25'),(120226,120100,'1|120000|120100',0,'其它区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:32:25'),(130000,1,'1',1,'河北省',0,2,1,'2014-05-05 12:02:51','2014-05-05 12:32:25'),(130100,130000,'1|130000',1,'石家庄市',0,3,1,'2014-05-05 12:02:43','2014-05-05 12:32:25'),(130102,130100,'1|130000|130100',0,'长安区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:25'),(130103,130100,'1|130000|130100',0,'桥东区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130104,130100,'1|130000|130100',0,'桥西区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130105,130100,'1|130000|130100',0,'新华区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130107,130100,'1|130000|130100',0,'井陉矿区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130108,130100,'1|130000|130100',0,'裕华区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130121,130100,'1|130000|130100',0,'井陉县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130123,130100,'1|130000|130100',0,'正定县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130124,130100,'1|130000|130100',0,'栾城区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130125,130100,'1|130000|130100',0,'行唐县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130126,130100,'1|130000|130100',0,'灵寿县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130127,130100,'1|130000|130100',0,'高邑县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130128,130100,'1|130000|130100',0,'深泽县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130129,130100,'1|130000|130100',0,'赞皇县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130130,130100,'1|130000|130100',0,'无极县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130131,130100,'1|130000|130100',0,'平山县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130132,130100,'1|130000|130100',0,'元氏县',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130133,130100,'1|130000|130100',0,'赵县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:32:26'),(130181,130100,'1|130000|130100',0,'辛集市',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130182,130100,'1|130000|130100',0,'藁城区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130183,130100,'1|130000|130100',0,'晋州市',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130184,130100,'1|130000|130100',0,'新乐市',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130185,130100,'1|130000|130100',0,'鹿泉市',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130186,130100,'1|130000|130100',0,'其它区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:26'),(130200,130000,'1|130000',1,'唐山市',0,3,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130202,130200,'1|130000|130200',0,'路南区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130203,130200,'1|130000|130200',0,'路北区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130204,130200,'1|130000|130200',0,'古冶区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130205,130200,'1|130000|130200',0,'开平区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130207,130200,'1|130000|130200',0,'丰南区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130208,130200,'1|130000|130200',0,'丰润区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130223,130200,'1|130000|130200',0,'滦县',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130224,130200,'1|130000|130200',0,'滦南县',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130225,130200,'1|130000|130200',0,'乐亭县',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130227,130200,'1|130000|130200',0,'迁西县',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130229,130200,'1|130000|130200',0,'玉田县',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130230,130200,'1|130000|130200',0,'曹妃甸区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130281,130200,'1|130000|130200',0,'遵化市',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130283,130200,'1|130000|130200',0,'迁安市',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130284,130200,'1|130000|130200',0,'其它区',0,4,1,'2014-05-05 12:02:44','2014-05-05 12:32:27'),(130300,130000,'1|130000',1,'秦皇岛市',0,3,1,'2014-05-05 12:02:45','2014-05-05 12:32:27'),(130302,130300,'1|130000|130300',0,'海港区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130303,130300,'1|130000|130300',0,'山海关区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130304,130300,'1|130000|130300',0,'北戴河区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130321,130300,'1|130000|130300',0,'青龙满族自治县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130322,130300,'1|130000|130300',0,'昌黎县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130323,130300,'1|130000|130300',0,'抚宁县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130324,130300,'1|130000|130300',0,'卢龙县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130398,130300,'1|130000|130300',0,'其它区',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:28'),(130399,130300,'1|130000|130300',0,'经济技术开发区',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:28'),(130400,130000,'1|130000',1,'邯郸市',0,3,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130402,130400,'1|130000|130400',0,'邯山区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130403,130400,'1|130000|130400',0,'丛台区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130404,130400,'1|130000|130400',0,'复兴区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130406,130400,'1|130000|130400',0,'峰峰矿区',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130421,130400,'1|130000|130400',0,'邯郸县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:28'),(130423,130400,'1|130000|130400',0,'临漳县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130424,130400,'1|130000|130400',0,'成安县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130425,130400,'1|130000|130400',0,'大名县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130426,130400,'1|130000|130400',0,'涉县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130427,130400,'1|130000|130400',0,'磁县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130428,130400,'1|130000|130400',0,'肥乡县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130429,130400,'1|130000|130400',0,'永年县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130430,130400,'1|130000|130400',0,'邱县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130431,130400,'1|130000|130400',0,'鸡泽县',0,4,1,'2014-05-05 12:02:45','2014-05-05 12:32:29'),(130432,130400,'1|130000|130400',0,'广平县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:29'),(130433,130400,'1|130000|130400',0,'馆陶县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:29'),(130434,130400,'1|130000|130400',0,'魏县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:29'),(130435,130400,'1|130000|130400',0,'曲周县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:29'),(130481,130400,'1|130000|130400',0,'武安市',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:29'),(130482,130400,'1|130000|130400',0,'其它区',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:29'),(130500,130000,'1|130000',1,'邢台市',0,3,1,'2014-05-05 12:02:47','2014-05-05 12:32:29'),(130502,130500,'1|130000|130500',0,'桥东区',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130503,130500,'1|130000|130500',0,'桥西区',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130521,130500,'1|130000|130500',0,'邢台县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130522,130500,'1|130000|130500',0,'临城县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130523,130500,'1|130000|130500',0,'内丘县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130524,130500,'1|130000|130500',0,'柏乡县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130525,130500,'1|130000|130500',0,'隆尧县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130526,130500,'1|130000|130500',0,'任县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130527,130500,'1|130000|130500',0,'南和县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130528,130500,'1|130000|130500',0,'宁晋县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:30'),(130529,130500,'1|130000|130500',0,'巨鹿县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:30'),(130530,130500,'1|130000|130500',0,'新河县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:30'),(130531,130500,'1|130000|130500',0,'广宗县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:30'),(130532,130500,'1|130000|130500',0,'平乡县',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:30'),(130533,130500,'1|130000|130500',0,'威县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:30'),(130534,130500,'1|130000|130500',0,'清河县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:30'),(130535,130500,'1|130000|130500',0,'临西县',0,4,1,'2014-05-05 12:02:46','2014-05-05 12:32:31'),(130581,130500,'1|130000|130500',0,'南宫市',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130582,130500,'1|130000|130500',0,'沙河市',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130583,130500,'1|130000|130500',0,'其它区',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130600,130000,'1|130000',1,'保定市',0,3,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130602,130600,'1|130000|130600',0,'新市区',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130603,130600,'1|130000|130600',0,'北市区',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130604,130600,'1|130000|130600',0,'南市区',0,4,1,'2014-05-05 12:02:47','2014-05-05 12:32:31'),(130621,130600,'1|130000|130600',0,'满城县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130622,130600,'1|130000|130600',0,'清苑县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130623,130600,'1|130000|130600',0,'涞水县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130624,130600,'1|130000|130600',0,'阜平县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130625,130600,'1|130000|130600',0,'徐水县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130626,130600,'1|130000|130600',0,'定兴县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130627,130600,'1|130000|130600',0,'唐县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130628,130600,'1|130000|130600',0,'高阳县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130629,130600,'1|130000|130600',0,'容城县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130630,130600,'1|130000|130600',0,'涞源县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130631,130600,'1|130000|130600',0,'望都县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130632,130600,'1|130000|130600',0,'安新县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130633,130600,'1|130000|130600',0,'易县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:31'),(130634,130600,'1|130000|130600',0,'曲阳县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130635,130600,'1|130000|130600',0,'蠡县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130636,130600,'1|130000|130600',0,'顺平县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130637,130600,'1|130000|130600',0,'博野县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130638,130600,'1|130000|130600',0,'雄县',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130681,130600,'1|130000|130600',0,'涿州市',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130682,130600,'1|130000|130600',0,'定州市',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130683,130600,'1|130000|130600',0,'安国市',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130684,130600,'1|130000|130600',0,'高碑店市',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130698,130600,'1|130000|130600',0,'高开区',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130699,130600,'1|130000|130600',0,'其它区',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130700,130000,'1|130000',1,'张家口市',0,3,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130702,130700,'1|130000|130700',0,'桥东区',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130703,130700,'1|130000|130700',0,'桥西区',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130705,130700,'1|130000|130700',0,'宣化区',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:32'),(130706,130700,'1|130000|130700',0,'下花园区',0,4,1,'2014-05-05 12:02:48','2014-05-05 12:32:32'),(130721,130700,'1|130000|130700',0,'宣化县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130722,130700,'1|130000|130700',0,'张北县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130723,130700,'1|130000|130700',0,'康保县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130724,130700,'1|130000|130700',0,'沽源县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130725,130700,'1|130000|130700',0,'尚义县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130726,130700,'1|130000|130700',0,'蔚县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130727,130700,'1|130000|130700',0,'阳原县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130728,130700,'1|130000|130700',0,'怀安县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130729,130700,'1|130000|130700',0,'万全县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130730,130700,'1|130000|130700',0,'怀来县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130731,130700,'1|130000|130700',0,'涿鹿县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130732,130700,'1|130000|130700',0,'赤城县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130733,130700,'1|130000|130700',0,'崇礼县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130734,130700,'1|130000|130700',0,'其它区',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130800,130000,'1|130000',1,'承德市',0,3,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130802,130800,'1|130000|130800',0,'双桥区',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130803,130800,'1|130000|130800',0,'双滦区',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130804,130800,'1|130000|130800',0,'鹰手营子矿区',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130821,130800,'1|130000|130800',0,'承德县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130822,130800,'1|130000|130800',0,'兴隆县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130823,130800,'1|130000|130800',0,'平泉县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130824,130800,'1|130000|130800',0,'滦平县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:33'),(130825,130800,'1|130000|130800',0,'隆化县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:34'),(130826,130800,'1|130000|130800',0,'丰宁满族自治县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:34'),(130827,130800,'1|130000|130800',0,'宽城满族自治县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:34'),(130828,130800,'1|130000|130800',0,'围场满族蒙古族自治县',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:34'),(130829,130800,'1|130000|130800',0,'其它区',0,4,1,'2014-05-05 12:02:49','2014-05-05 12:32:34'),(130900,130000,'1|130000',1,'沧州市',0,3,1,'2014-05-05 12:02:49','2014-05-05 12:32:34'),(130902,130900,'1|130000|130900',0,'新华区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130903,130900,'1|130000|130900',0,'运河区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130921,130900,'1|130000|130900',0,'沧县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130922,130900,'1|130000|130900',0,'青县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130923,130900,'1|130000|130900',0,'东光县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130924,130900,'1|130000|130900',0,'海兴县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130925,130900,'1|130000|130900',0,'盐山县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130926,130900,'1|130000|130900',0,'肃宁县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130927,130900,'1|130000|130900',0,'南皮县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130928,130900,'1|130000|130900',0,'吴桥县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130929,130900,'1|130000|130900',0,'献县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130930,130900,'1|130000|130900',0,'孟村回族自治县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130981,130900,'1|130000|130900',0,'泊头市',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130982,130900,'1|130000|130900',0,'任丘市',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130983,130900,'1|130000|130900',0,'黄骅市',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:34'),(130984,130900,'1|130000|130900',0,'河间市',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(130985,130900,'1|130000|130900',0,'其它区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131000,130000,'1|130000',1,'廊坊市',0,3,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131002,131000,'1|130000|131000',0,'安次区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131003,131000,'1|130000|131000',0,'广阳区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131022,131000,'1|130000|131000',0,'固安县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131023,131000,'1|130000|131000',0,'永清县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131024,131000,'1|130000|131000',0,'香河县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131025,131000,'1|130000|131000',0,'大城县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131026,131000,'1|130000|131000',0,'文安县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131028,131000,'1|130000|131000',0,'大厂回族自治县',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131051,131000,'1|130000|131000',0,'开发区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131052,131000,'1|130000|131000',0,'燕郊经济技术开发区',0,4,1,'2014-05-05 12:02:50','2014-05-05 12:32:35'),(131081,131000,'1|130000|131000',0,'霸州市',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131082,131000,'1|130000|131000',0,'三河市',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131083,131000,'1|130000|131000',0,'其它区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131100,130000,'1|130000',1,'衡水市',0,3,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131102,131100,'1|130000|131100',0,'桃城区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131121,131100,'1|130000|131100',0,'枣强县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131122,131100,'1|130000|131100',0,'武邑县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:35'),(131123,131100,'1|130000|131100',0,'武强县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131124,131100,'1|130000|131100',0,'饶阳县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131125,131100,'1|130000|131100',0,'安平县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131126,131100,'1|130000|131100',0,'故城县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131127,131100,'1|130000|131100',0,'景县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131128,131100,'1|130000|131100',0,'阜城县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131181,131100,'1|130000|131100',0,'冀州市',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131182,131100,'1|130000|131100',0,'深州市',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(131183,131100,'1|130000|131100',0,'其它区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:32:36'),(140000,1,'1',1,'山西省',0,2,1,'2014-05-05 12:00:30','2014-05-05 12:32:36'),(140100,140000,'1|140000',1,'太原市',0,3,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140105,140100,'1|140000|140100',0,'小店区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140106,140100,'1|140000|140100',0,'迎泽区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140107,140100,'1|140000|140100',0,'杏花岭区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140108,140100,'1|140000|140100',0,'尖草坪区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140109,140100,'1|140000|140100',0,'万柏林区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140110,140100,'1|140000|140100',0,'晋源区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:32:36'),(140121,140100,'1|140000|140100',0,'清徐县',0,4,1,'2014-05-05 12:00:30','2014-05-05 12:32:36'),(140122,140100,'1|140000|140100',0,'阳曲县',0,4,1,'2014-05-05 12:00:30','2014-05-05 12:32:36'),(140123,140100,'1|140000|140100',0,'娄烦县',0,4,1,'2014-05-05 12:00:30','2014-05-05 12:32:37'),(140181,140100,'1|140000|140100',0,'古交市',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140182,140100,'1|140000|140100',0,'其它区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140200,140000,'1|140000',1,'大同市',0,3,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140202,140200,'1|140000|140200',0,'城区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140203,140200,'1|140000|140200',0,'矿区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140211,140200,'1|140000|140200',0,'南郊区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140212,140200,'1|140000|140200',0,'新荣区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140221,140200,'1|140000|140200',0,'阳高县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140222,140200,'1|140000|140200',0,'天镇县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140223,140200,'1|140000|140200',0,'广灵县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140224,140200,'1|140000|140200',0,'灵丘县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140225,140200,'1|140000|140200',0,'浑源县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:37'),(140226,140200,'1|140000|140200',0,'左云县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:38'),(140227,140200,'1|140000|140200',0,'大同县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:38'),(140228,140200,'1|140000|140200',0,'其它区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:32:38'),(140300,140000,'1|140000',1,'阳泉市',0,3,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140302,140300,'1|140000|140300',0,'城区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140303,140300,'1|140000|140300',0,'矿区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140311,140300,'1|140000|140300',0,'郊区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140321,140300,'1|140000|140300',0,'平定县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140322,140300,'1|140000|140300',0,'盂县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140323,140300,'1|140000|140300',0,'其它区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:38'),(140400,140000,'1|140000',1,'长治市',0,3,1,'2014-05-05 12:00:20','2014-05-05 12:32:38'),(140421,140400,'1|140000|140400',0,'长治县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:38'),(140423,140400,'1|140000|140400',0,'襄垣县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:38'),(140424,140400,'1|140000|140400',0,'屯留县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:38'),(140425,140400,'1|140000|140400',0,'平顺县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:38'),(140426,140400,'1|140000|140400',0,'黎城县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:39'),(140427,140400,'1|140000|140400',0,'壶关县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:39'),(140428,140400,'1|140000|140400',0,'长子县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:39'),(140429,140400,'1|140000|140400',0,'武乡县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:39'),(140430,140400,'1|140000|140400',0,'沁县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:39'),(140431,140400,'1|140000|140400',0,'沁源县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:39'),(140481,140400,'1|140000|140400',0,'潞城市',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140482,140400,'1|140000|140400',0,'城区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140483,140400,'1|140000|140400',0,'郊区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140484,140400,'1|140000|140400',0,'高新区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140485,140400,'1|140000|140400',0,'其它区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140500,140000,'1|140000',1,'晋城市',0,3,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140502,140500,'1|140000|140500',0,'城区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:39'),(140521,140500,'1|140000|140500',0,'沁水县',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140522,140500,'1|140000|140500',0,'阳城县',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140524,140500,'1|140000|140500',0,'陵川县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:40'),(140525,140500,'1|140000|140500',0,'泽州县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:40'),(140581,140500,'1|140000|140500',0,'高平市',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140582,140500,'1|140000|140500',0,'其它区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140600,140000,'1|140000',1,'朔州市',0,3,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140602,140600,'1|140000|140600',0,'朔城区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140603,140600,'1|140000|140600',0,'平鲁区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:40'),(140621,140600,'1|140000|140600',0,'山阴县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:40'),(140622,140600,'1|140000|140600',0,'应县',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:40'),(140623,140600,'1|140000|140600',0,'右玉县',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:40'),(140624,140600,'1|140000|140600',0,'怀仁县',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:40'),(140625,140600,'1|140000|140600',0,'其它区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:40'),(140700,140000,'1|140000',1,'晋中市',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:40'),(140702,140700,'1|140000|140700',0,'榆次区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140721,140700,'1|140000|140700',0,'榆社县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140722,140700,'1|140000|140700',0,'左权县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140723,140700,'1|140000|140700',0,'和顺县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140724,140700,'1|140000|140700',0,'昔阳县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140725,140700,'1|140000|140700',0,'寿阳县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140726,140700,'1|140000|140700',0,'太谷县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140727,140700,'1|140000|140700',0,'祁县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140728,140700,'1|140000|140700',0,'平遥县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140729,140700,'1|140000|140700',0,'灵石县',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:41'),(140781,140700,'1|140000|140700',0,'介休市',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:32:41'),(140782,140700,'1|140000|140700',0,'其它区',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:32:41'),(140800,140000,'1|140000',1,'运城市',0,3,1,'2014-05-05 12:00:04','2014-05-05 12:32:41'),(140802,140800,'1|140000|140800',0,'盐湖区',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:41'),(140821,140800,'1|140000|140800',0,'临猗县',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:41'),(140822,140800,'1|140000|140800',0,'万荣县',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:41'),(140823,140800,'1|140000|140800',0,'闻喜县',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:41'),(140824,140800,'1|140000|140800',0,'稷山县',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:41'),(140825,140800,'1|140000|140800',0,'新绛县',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:41'),(140826,140800,'1|140000|140800',0,'绛县',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:41'),(140827,140800,'1|140000|140800',0,'垣曲县',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:41'),(140828,140800,'1|140000|140800',0,'夏县',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:42'),(140829,140800,'1|140000|140800',0,'平陆县',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:42'),(140830,140800,'1|140000|140800',0,'芮城县',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:42'),(140881,140800,'1|140000|140800',0,'永济市',0,4,1,'2014-05-05 12:00:07','2014-05-05 12:32:42'),(140882,140800,'1|140000|140800',0,'河津市',0,4,1,'2014-05-05 12:00:07','2014-05-05 12:32:42'),(140883,140800,'1|140000|140800',0,'其它区',0,4,1,'2014-05-05 12:00:07','2014-05-05 12:32:42'),(140900,140000,'1|140000',1,'忻州市',0,3,1,'2014-05-05 12:00:08','2014-05-05 12:32:42'),(140902,140900,'1|140000|140900',0,'忻府区',0,4,1,'2014-05-05 12:00:08','2014-05-05 12:32:42'),(140921,140900,'1|140000|140900',0,'定襄县',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:42'),(140922,140900,'1|140000|140900',0,'五台县',0,4,1,'2014-05-05 12:00:08','2014-05-05 12:32:42'),(140923,140900,'1|140000|140900',0,'代县',0,4,1,'2014-05-05 12:00:08','2014-05-05 12:32:42'),(140924,140900,'1|140000|140900',0,'繁峙县',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:42'),(140925,140900,'1|140000|140900',0,'宁武县',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:42'),(140926,140900,'1|140000|140900',0,'静乐县',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:42'),(140927,140900,'1|140000|140900',0,'神池县',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:42'),(140928,140900,'1|140000|140900',0,'五寨县',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:32:42'),(140929,140900,'1|140000|140900',0,'岢岚县',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:32:42'),(140930,140900,'1|140000|140900',0,'河曲县',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:32:42'),(140931,140900,'1|140000|140900',0,'保德县',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:32:42'),(140932,140900,'1|140000|140900',0,'偏关县',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:43'),(140981,140900,'1|140000|140900',0,'原平市',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:32:43'),(140982,140900,'1|140000|140900',0,'其它区',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:32:43'),(141000,140000,'1|140000',1,'临汾市',0,3,1,'2014-05-05 12:00:14','2014-05-05 12:32:43'),(141002,141000,'1|140000|141000',0,'尧都区',0,4,1,'2014-05-05 12:00:14','2014-05-05 12:32:43'),(141021,141000,'1|140000|141000',0,'曲沃县',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:43'),(141022,141000,'1|140000|141000',0,'翼城县',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:43'),(141023,141000,'1|140000|141000',0,'襄汾县',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:43'),(141024,141000,'1|140000|141000',0,'洪洞县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:43'),(141025,141000,'1|140000|141000',0,'古县',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:43'),(141026,141000,'1|140000|141000',0,'安泽县',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:43'),(141027,141000,'1|140000|141000',0,'浮山县',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:43'),(141028,141000,'1|140000|141000',0,'吉县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:43'),(141029,141000,'1|140000|141000',0,'乡宁县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:43'),(141030,141000,'1|140000|141000',0,'大宁县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:44'),(141031,141000,'1|140000|141000',0,'隰县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:44'),(141032,141000,'1|140000|141000',0,'永和县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:44'),(141033,141000,'1|140000|141000',0,'蒲县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:44'),(141034,141000,'1|140000|141000',0,'汾西县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:44'),(141081,141000,'1|140000|141000',0,'侯马市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141082,141000,'1|140000|141000',0,'霍州市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141083,141000,'1|140000|141000',0,'其它区',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141100,140000,'1|140000',1,'吕梁市',0,3,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141102,141100,'1|140000|141100',0,'离石区',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141121,141100,'1|140000|141100',0,'文水县',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:44'),(141122,141100,'1|140000|141100',0,'交城县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141123,141100,'1|140000|141100',0,'兴县',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:44'),(141124,141100,'1|140000|141100',0,'临县',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:44'),(141125,141100,'1|140000|141100',0,'柳林县',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:44'),(141126,141100,'1|140000|141100',0,'石楼县',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:44'),(141127,141100,'1|140000|141100',0,'岚县',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:44'),(141128,141100,'1|140000|141100',0,'方山县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:44'),(141129,141100,'1|140000|141100',0,'中阳县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:45'),(141130,141100,'1|140000|141100',0,'交口县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:45'),(141181,141100,'1|140000|141100',0,'孝义市',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:45'),(141182,141100,'1|140000|141100',0,'汾阳市',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:45'),(141183,141100,'1|140000|141100',0,'其它区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:45'),(150000,1,'1',1,'内蒙古自治区',0,2,1,'2014-05-05 12:01:14','2014-05-05 12:32:45'),(150100,150000,'1|150000',1,'呼和浩特市',0,3,1,'2014-05-05 12:01:14','2014-05-05 12:32:45'),(150102,150100,'1|150000|150100',0,'新城区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:32:45'),(150103,150100,'1|150000|150100',0,'回民区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:32:45'),(150104,150100,'1|150000|150100',0,'玉泉区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150105,150100,'1|150000|150100',0,'赛罕区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150121,150100,'1|150000|150100',0,'土默特左旗',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150122,150100,'1|150000|150100',0,'托克托县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150123,150100,'1|150000|150100',0,'和林格尔县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150124,150100,'1|150000|150100',0,'清水河县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150125,150100,'1|150000|150100',0,'武川县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150126,150100,'1|150000|150100',0,'其它区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150200,150000,'1|150000',1,'包头市',0,3,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150202,150200,'1|150000|150200',0,'东河区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150203,150200,'1|150000|150200',0,'昆都仑区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:45'),(150204,150200,'1|150000|150200',0,'青山区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:46'),(150205,150200,'1|150000|150200',0,'石拐区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:46'),(150206,150200,'1|150000|150200',0,'白云鄂博矿区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:46'),(150207,150200,'1|150000|150200',0,'九原区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:46'),(150221,150200,'1|150000|150200',0,'土默特右旗',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150222,150200,'1|150000|150200',0,'固阳县',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150223,150200,'1|150000|150200',0,'达尔罕茂明安联合旗',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:46'),(150224,150200,'1|150000|150200',0,'其它区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:32:46'),(150300,150000,'1|150000',1,'乌海市',0,3,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150302,150300,'1|150000|150300',0,'海勃湾区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150303,150300,'1|150000|150300',0,'海南区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150304,150300,'1|150000|150300',0,'乌达区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150305,150300,'1|150000|150300',0,'其它区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150400,150000,'1|150000',1,'赤峰市',0,3,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150402,150400,'1|150000|150400',0,'红山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150403,150400,'1|150000|150400',0,'元宝山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150404,150400,'1|150000|150400',0,'松山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:46'),(150421,150400,'1|150000|150400',0,'阿鲁科尔沁旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:46'),(150422,150400,'1|150000|150400',0,'巴林左旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:46'),(150423,150400,'1|150000|150400',0,'巴林右旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:46'),(150424,150400,'1|150000|150400',0,'林西县',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:47'),(150425,150400,'1|150000|150400',0,'克什克腾旗',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:47'),(150426,150400,'1|150000|150400',0,'翁牛特旗',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:47'),(150428,150400,'1|150000|150400',0,'喀喇沁旗',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:32:47'),(150429,150400,'1|150000|150400',0,'宁城县',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150430,150400,'1|150000|150400',0,'敖汉旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150431,150400,'1|150000|150400',0,'其它区',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150500,150000,'1|150000',1,'通辽市',0,3,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150502,150500,'1|150000|150500',0,'科尔沁区',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150521,150500,'1|150000|150500',0,'科尔沁左翼中旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150522,150500,'1|150000|150500',0,'科尔沁左翼后旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150523,150500,'1|150000|150500',0,'开鲁县',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150524,150500,'1|150000|150500',0,'库伦旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150525,150500,'1|150000|150500',0,'奈曼旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150526,150500,'1|150000|150500',0,'扎鲁特旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:47'),(150581,150500,'1|150000|150500',0,'霍林郭勒市',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:47'),(150582,150500,'1|150000|150500',0,'其它区',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:47'),(150600,150000,'1|150000',1,'鄂尔多斯市',0,3,1,'2014-05-05 12:01:18','2014-05-05 12:32:47'),(150602,150600,'1|150000|150600',0,'东胜区',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:48'),(150621,150600,'1|150000|150600',0,'达拉特旗',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:48'),(150622,150600,'1|150000|150600',0,'准格尔旗',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:48'),(150623,150600,'1|150000|150600',0,'鄂托克前旗',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:48'),(150624,150600,'1|150000|150600',0,'鄂托克旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:48'),(150625,150600,'1|150000|150600',0,'杭锦旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:48'),(150626,150600,'1|150000|150600',0,'乌审旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:48'),(150627,150600,'1|150000|150600',0,'伊金霍洛旗',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:32:48'),(150628,150600,'1|150000|150600',0,'其它区',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:32:48'),(150700,150000,'1|150000',1,'呼伦贝尔市',0,3,1,'2014-05-05 12:01:20','2014-05-05 12:32:48'),(150702,150700,'1|150000|150700',0,'海拉尔区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:48'),(150703,150700,'1|150000|150700',0,'扎赉诺尔区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:48'),(150721,150700,'1|150000|150700',0,'阿荣旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:48'),(150722,150700,'1|150000|150700',0,'莫力达瓦达斡尔族自治旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:48'),(150723,150700,'1|150000|150700',0,'鄂伦春自治旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:48'),(150724,150700,'1|150000|150700',0,'鄂温克族自治旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:48'),(150725,150700,'1|150000|150700',0,'陈巴尔虎旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:49'),(150726,150700,'1|150000|150700',0,'新巴尔虎左旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:49'),(150727,150700,'1|150000|150700',0,'新巴尔虎右旗',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:49'),(150781,150700,'1|150000|150700',0,'满洲里市',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:49'),(150782,150700,'1|150000|150700',0,'牙克石市',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:49'),(150783,150700,'1|150000|150700',0,'扎兰屯市',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:32:49'),(150784,150700,'1|150000|150700',0,'额尔古纳市',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:32:49'),(150785,150700,'1|150000|150700',0,'根河市',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:32:49'),(150786,150700,'1|150000|150700',0,'其它区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:32:49'),(150800,150000,'1|150000',1,'巴彦淖尔市',0,3,1,'2014-05-05 12:01:21','2014-05-05 12:32:49'),(150802,150800,'1|150000|150800',0,'临河区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:32:49'),(150821,150800,'1|150000|150800',0,'五原县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150822,150800,'1|150000|150800',0,'磴口县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150823,150800,'1|150000|150800',0,'乌拉特前旗',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150824,150800,'1|150000|150800',0,'乌拉特中旗',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150825,150800,'1|150000|150800',0,'乌拉特后旗',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150826,150800,'1|150000|150800',0,'杭锦后旗',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150827,150800,'1|150000|150800',0,'其它区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:49'),(150900,150000,'1|150000',1,'乌兰察布市',0,3,1,'2014-05-05 12:01:20','2014-05-05 12:32:50'),(150902,150900,'1|150000|150900',0,'集宁区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:32:50'),(150921,150900,'1|150000|150900',0,'卓资县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150922,150900,'1|150000|150900',0,'化德县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150923,150900,'1|150000|150900',0,'商都县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150924,150900,'1|150000|150900',0,'兴和县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150925,150900,'1|150000|150900',0,'凉城县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150926,150900,'1|150000|150900',0,'察哈尔右翼前旗',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150927,150900,'1|150000|150900',0,'察哈尔右翼中旗',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:50'),(150928,150900,'1|150000|150900',0,'察哈尔右翼后旗',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:51'),(150929,150900,'1|150000|150900',0,'四子王旗',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:32:51'),(150981,150900,'1|150000|150900',0,'丰镇市',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:32:51'),(150982,150900,'1|150000|150900',0,'其它区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:32:51'),(152200,150000,'1|150000',1,'兴安盟',0,3,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152201,152200,'1|150000|152200',0,'乌兰浩特市',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152202,152200,'1|150000|152200',0,'阿尔山市',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152221,152200,'1|150000|152200',0,'科尔沁右翼前旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152222,152200,'1|150000|152200',0,'科尔沁右翼中旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152223,152200,'1|150000|152200',0,'扎赉特旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152224,152200,'1|150000|152200',0,'突泉县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152225,152200,'1|150000|152200',0,'其它区',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152500,150000,'1|150000',1,'锡林郭勒盟',0,3,1,'2014-05-05 12:01:32','2014-05-05 12:32:51'),(152501,152500,'1|150000|152500',0,'二连浩特市',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:51'),(152502,152500,'1|150000|152500',0,'锡林浩特市',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:51'),(152522,152500,'1|150000|152500',0,'阿巴嘎旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152523,152500,'1|150000|152500',0,'苏尼特左旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:51'),(152524,152500,'1|150000|152500',0,'苏尼特右旗',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:51'),(152525,152500,'1|150000|152500',0,'东乌珠穆沁旗',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:51'),(152526,152500,'1|150000|152500',0,'西乌珠穆沁旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(152527,152500,'1|150000|152500',0,'太仆寺旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(152528,152500,'1|150000|152500',0,'镶黄旗',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:52'),(152529,152500,'1|150000|152500',0,'正镶白旗',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:52'),(152530,152500,'1|150000|152500',0,'正蓝旗',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:52'),(152531,152500,'1|150000|152500',0,'多伦县',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:52'),(152532,152500,'1|150000|152500',0,'其它区',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:32:52'),(152900,150000,'1|150000',1,'阿拉善盟',0,3,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(152921,152900,'1|150000|152900',0,'阿拉善左旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(152922,152900,'1|150000|152900',0,'阿拉善右旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(152923,152900,'1|150000|152900',0,'额济纳旗',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(152924,152900,'1|150000|152900',0,'其它区',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:32:52'),(210000,1,'1',1,'辽宁省',0,2,1,'2014-05-05 12:00:17','2014-05-05 12:32:52'),(210100,210000,'1|210000',1,'沈阳市',0,3,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210102,210100,'1|210000|210100',0,'和平区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210103,210100,'1|210000|210100',0,'沈河区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210104,210100,'1|210000|210100',0,'大东区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210105,210100,'1|210000|210100',0,'皇姑区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210106,210100,'1|210000|210100',0,'铁西区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210111,210100,'1|210000|210100',0,'苏家屯区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:52'),(210112,210100,'1|210000|210100',0,'东陵区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:53'),(210113,210100,'1|210000|210100',0,'新城子区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:32:53'),(210114,210100,'1|210000|210100',0,'于洪区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:53'),(210122,210100,'1|210000|210100',0,'辽中县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:53'),(210123,210100,'1|210000|210100',0,'康平县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:53'),(210124,210100,'1|210000|210100',0,'法库县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:53'),(210181,210100,'1|210000|210100',0,'新民市',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:53'),(210182,210100,'1|210000|210100',0,'浑南新区',0,4,1,'2014-05-05 12:00:03','2014-05-05 12:32:53'),(210183,210100,'1|210000|210100',0,'张士开发区',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:53'),(210184,210100,'1|210000|210100',0,'沈北新区',0,4,1,'2014-05-05 12:00:03','2014-05-05 12:32:54'),(210185,210100,'1|210000|210100',0,'其它区',0,4,1,'2014-05-05 12:00:03','2014-05-05 12:32:54'),(210200,210000,'1|210000',1,'大连市',0,3,1,'2014-05-05 12:00:04','2014-05-05 12:32:54'),(210202,210200,'1|210000|210200',0,'中山区',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:54'),(210203,210200,'1|210000|210200',0,'西岗区',0,4,1,'2014-05-05 12:00:04','2014-05-05 12:32:54'),(210204,210200,'1|210000|210200',0,'沙河口区',0,4,1,'2014-05-05 12:00:05','2014-05-05 12:32:54'),(210211,210200,'1|210000|210200',0,'甘井子区',0,4,1,'2014-05-05 12:00:06','2014-05-05 12:32:54'),(210212,210200,'1|210000|210200',0,'旅顺口区',0,4,1,'2014-05-05 12:00:06','2014-05-05 12:32:54'),(210213,210200,'1|210000|210200',0,'金州区',0,4,1,'2014-05-05 12:00:06','2014-05-05 12:32:54'),(210224,210200,'1|210000|210200',0,'长海县',0,4,1,'2014-05-05 12:00:06','2014-05-05 12:32:54'),(210251,210200,'1|210000|210200',0,'开发区',0,4,1,'2014-05-05 12:00:07','2014-05-05 12:32:54'),(210281,210200,'1|210000|210200',0,'瓦房店市',0,4,1,'2014-05-05 12:00:08','2014-05-05 12:32:55'),(210282,210200,'1|210000|210200',0,'普兰店市',0,4,1,'2014-05-05 12:00:08','2014-05-05 12:32:55'),(210283,210200,'1|210000|210200',0,'庄河市',0,4,1,'2014-05-05 12:00:08','2014-05-05 12:32:55'),(210297,210200,'1|210000|210200',0,'岭前区',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:55'),(210298,210200,'1|210000|210200',0,'其它区',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:55'),(210300,210000,'1|210000',1,'鞍山市',0,3,1,'2014-05-05 12:00:08','2014-05-05 12:32:55'),(210302,210300,'1|210000|210300',0,'铁东区',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:55'),(210303,210300,'1|210000|210300',0,'铁西区',0,4,1,'2014-05-05 12:00:09','2014-05-05 12:32:55'),(210304,210300,'1|210000|210300',0,'立山区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:32:55'),(210311,210300,'1|210000|210300',0,'千山区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:32:55'),(210321,210300,'1|210000|210300',0,'台安县',0,4,1,'2014-05-05 12:00:11','2014-05-05 12:32:55'),(210323,210300,'1|210000|210300',0,'岫岩满族自治县',0,4,1,'2014-05-05 12:00:11','2014-05-05 12:32:55'),(210351,210300,'1|210000|210300',0,'高新区',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:32:55'),(210381,210300,'1|210000|210300',0,'海城市',0,4,1,'2014-05-05 12:00:14','2014-05-05 12:32:55'),(210382,210300,'1|210000|210300',0,'其它区',0,4,1,'2014-05-05 12:00:14','2014-05-05 12:32:55'),(210400,210000,'1|210000',1,'抚顺市',0,3,1,'2014-05-05 12:00:16','2014-05-05 12:32:55'),(210402,210400,'1|210000|210400',0,'新抚区',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:55'),(210403,210400,'1|210000|210400',0,'东洲区',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:55'),(210404,210400,'1|210000|210400',0,'望花区',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:32:55'),(210411,210400,'1|210000|210400',0,'顺城区',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:55'),(210421,210400,'1|210000|210400',0,'抚顺县',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:32:56'),(210422,210400,'1|210000|210400',0,'新宾满族自治县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:56'),(210423,210400,'1|210000|210400',0,'清原满族自治县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:56'),(210424,210400,'1|210000|210400',0,'其它区',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:32:56'),(210500,210000,'1|210000',1,'本溪市',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:56'),(210502,210500,'1|210000|210500',0,'平山区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:56'),(210503,210500,'1|210000|210500',0,'溪湖区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:56'),(210504,210500,'1|210000|210500',0,'明山区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:56'),(210505,210500,'1|210000|210500',0,'南芬区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:56'),(210521,210500,'1|210000|210500',0,'本溪满族自治县',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:56'),(210522,210500,'1|210000|210500',0,'桓仁满族自治县',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:56'),(210523,210500,'1|210000|210500',0,'其它区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:32:56'),(210600,210000,'1|210000',1,'丹东市',0,3,1,'2014-05-05 12:00:23','2014-05-05 12:32:56'),(210602,210600,'1|210000|210600',0,'元宝区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:56'),(210603,210600,'1|210000|210600',0,'振兴区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:56'),(210604,210600,'1|210000|210600',0,'振安区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:32:57'),(210624,210600,'1|210000|210600',0,'宽甸满族自治县',0,4,1,'2014-05-05 12:00:26','2014-05-05 12:32:57'),(210681,210600,'1|210000|210600',0,'东港市',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:32:57'),(210682,210600,'1|210000|210600',0,'凤城市',0,4,1,'2014-05-05 12:00:24','2014-05-05 12:32:57'),(210683,210600,'1|210000|210600',0,'其它区',0,4,1,'2014-05-05 12:00:24','2014-05-05 12:32:57'),(210700,210000,'1|210000',1,'锦州市',0,3,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210702,210700,'1|210000|210700',0,'古塔区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210703,210700,'1|210000|210700',0,'凌河区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210711,210700,'1|210000|210700',0,'太和区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210726,210700,'1|210000|210700',0,'黑山县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210727,210700,'1|210000|210700',0,'义县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210781,210700,'1|210000|210700',0,'凌海市',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:57'),(210782,210700,'1|210000|210700',0,'北镇市',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:57'),(210783,210700,'1|210000|210700',0,'其它区',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:57'),(210800,210000,'1|210000',1,'营口市',0,3,1,'2014-05-05 12:00:19','2014-05-05 12:32:57'),(210802,210800,'1|210000|210800',0,'站前区',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:57'),(210803,210800,'1|210000|210800',0,'西市区',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:57'),(210804,210800,'1|210000|210800',0,'鲅鱼圈区',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:57'),(210811,210800,'1|210000|210800',0,'老边区',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:32:58'),(210881,210800,'1|210000|210800',0,'盖州市',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210882,210800,'1|210000|210800',0,'大石桥市',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210883,210800,'1|210000|210800',0,'其它区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210900,210000,'1|210000',1,'阜新市',0,3,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210902,210900,'1|210000|210900',0,'海州区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210903,210900,'1|210000|210900',0,'新邱区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210904,210900,'1|210000|210900',0,'太平区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210905,210900,'1|210000|210900',0,'清河门区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210911,210900,'1|210000|210900',0,'细河区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:32:58'),(210921,210900,'1|210000|210900',0,'阜新蒙古族自治县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:58'),(210922,210900,'1|210000|210900',0,'彰武县',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:58'),(210923,210900,'1|210000|210900',0,'其它区',0,4,1,'2014-05-05 12:00:20','2014-05-05 12:32:59'),(211000,210000,'1|210000',1,'辽阳市',0,3,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211002,211000,'1|210000|211000',0,'白塔区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211003,211000,'1|210000|211000',0,'文圣区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211004,211000,'1|210000|211000',0,'宏伟区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211005,211000,'1|210000|211000',0,'弓长岭区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211011,211000,'1|210000|211000',0,'太子河区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211021,211000,'1|210000|211000',0,'辽阳县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211081,211000,'1|210000|211000',0,'灯塔市',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:32:59'),(211082,211000,'1|210000|211000',0,'其它区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:32:59'),(211100,210000,'1|210000',1,'盘锦市',0,3,1,'2014-05-05 12:00:39','2014-05-05 12:32:59'),(211102,211100,'1|210000|211100',0,'双台子区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:32:59'),(211103,211100,'1|210000|211100',0,'兴隆台区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211121,211100,'1|210000|211100',0,'大洼县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211122,211100,'1|210000|211100',0,'盘山县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:32:59'),(211123,211100,'1|210000|211100',0,'其它区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:33:00'),(211200,210000,'1|210000',1,'铁岭市',0,3,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211202,211200,'1|210000|211200',0,'银州区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211204,211200,'1|210000|211200',0,'清河区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211221,211200,'1|210000|211200',0,'铁岭县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211223,211200,'1|210000|211200',0,'西丰县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211224,211200,'1|210000|211200',0,'昌图县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211281,211200,'1|210000|211200',0,'调兵山市',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211282,211200,'1|210000|211200',0,'开原市',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211283,211200,'1|210000|211200',0,'其它区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211300,210000,'1|210000',1,'朝阳市',0,3,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211302,211300,'1|210000|211300',0,'双塔区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211303,211300,'1|210000|211300',0,'龙城区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211321,211300,'1|210000|211300',0,'朝阳县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211322,211300,'1|210000|211300',0,'建平县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211324,211300,'1|210000|211300',0,'喀喇沁左翼蒙古族自治县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211381,211300,'1|210000|211300',0,'北票市',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211382,211300,'1|210000|211300',0,'凌源市',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211383,211300,'1|210000|211300',0,'其它区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211400,210000,'1|210000',1,'葫芦岛市',0,3,1,'2014-05-05 12:00:39','2014-05-05 12:33:00'),(211402,211400,'1|210000|211400',0,'连山区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:01'),(211403,211400,'1|210000|211400',0,'龙港区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:01'),(211404,211400,'1|210000|211400',0,'南票区',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:01'),(211421,211400,'1|210000|211400',0,'绥中县',0,4,1,'2014-05-05 12:00:39','2014-05-05 12:33:01'),(211422,211400,'1|210000|211400',0,'建昌县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:33:01'),(211481,211400,'1|210000|211400',0,'兴城市',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:33:01'),(211482,211400,'1|210000|211400',0,'其它区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:33:01'),(220000,1,'1',1,'吉林省',0,2,1,'2014-05-05 12:01:12','2014-05-05 12:33:01'),(220100,220000,'1|220000',1,'长春市',0,3,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220102,220100,'1|220000|220100',0,'南关区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220103,220100,'1|220000|220100',0,'宽城区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220104,220100,'1|220000|220100',0,'朝阳区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220105,220100,'1|220000|220100',0,'二道区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220106,220100,'1|220000|220100',0,'绿园区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220112,220100,'1|220000|220100',0,'双阳区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220122,220100,'1|220000|220100',0,'农安县',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:01'),(220181,220100,'1|220000|220100',0,'九台市',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:33:01'),(220182,220100,'1|220000|220100',0,'榆树市',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:01'),(220183,220100,'1|220000|220100',0,'德惠市',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:02'),(220184,220100,'1|220000|220100',0,'高新技术产业开发区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:02'),(220185,220100,'1|220000|220100',0,'汽车产业开发区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:02'),(220186,220100,'1|220000|220100',0,'经济技术开发区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:02'),(220187,220100,'1|220000|220100',0,'净月旅游开发区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:02'),(220188,220100,'1|220000|220100',0,'其它区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:02'),(220200,220000,'1|220000',1,'吉林市',0,3,1,'2014-05-05 12:01:30','2014-05-05 12:33:02'),(220202,220200,'1|220000|220200',0,'昌邑区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:33:02'),(220203,220200,'1|220000|220200',0,'龙潭区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:33:02'),(220204,220200,'1|220000|220200',0,'船营区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:33:02'),(220211,220200,'1|220000|220200',0,'丰满区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:02'),(220221,220200,'1|220000|220200',0,'永吉县',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:33:02'),(220281,220200,'1|220000|220200',0,'蛟河市',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:03'),(220282,220200,'1|220000|220200',0,'桦甸市',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:03'),(220283,220200,'1|220000|220200',0,'舒兰市',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:03'),(220284,220200,'1|220000|220200',0,'磐石市',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:03'),(220285,220200,'1|220000|220200',0,'其它区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:03'),(220300,220000,'1|220000',1,'四平市',0,3,1,'2014-05-05 12:01:32','2014-05-05 12:33:03'),(220302,220300,'1|220000|220300',0,'铁西区',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:33:03'),(220303,220300,'1|220000|220300',0,'铁东区',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:33:03'),(220322,220300,'1|220000|220300',0,'梨树县',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:33:03'),(220323,220300,'1|220000|220300',0,'伊通满族自治县',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:33:03'),(220381,220300,'1|220000|220300',0,'公主岭市',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:04'),(220382,220300,'1|220000|220300',0,'双辽市',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:04'),(220383,220300,'1|220000|220300',0,'其它区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:04'),(220400,220000,'1|220000',1,'辽源市',0,3,1,'2014-05-05 12:01:32','2014-05-05 12:33:04'),(220402,220400,'1|220000|220400',0,'龙山区',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:33:04'),(220403,220400,'1|220000|220400',0,'西安区',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:33:04'),(220421,220400,'1|220000|220400',0,'东丰县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:04'),(220422,220400,'1|220000|220400',0,'东辽县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:04'),(220423,220400,'1|220000|220400',0,'其它区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:04'),(220500,220000,'1|220000',1,'通化市',0,3,1,'2014-05-05 12:01:24','2014-05-05 12:33:04'),(220502,220500,'1|220000|220500',0,'东昌区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:33:04'),(220503,220500,'1|220000|220500',0,'二道江区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:33:04'),(220521,220500,'1|220000|220500',0,'通化县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:04'),(220523,220500,'1|220000|220500',0,'辉南县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:04'),(220524,220500,'1|220000|220500',0,'柳河县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:04'),(220581,220500,'1|220000|220500',0,'梅河口市',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:33:04'),(220582,220500,'1|220000|220500',0,'集安市',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:33:04'),(220583,220500,'1|220000|220500',0,'其它区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:33:04'),(220600,220000,'1|220000',1,'白山市',0,3,1,'2014-05-05 12:01:27','2014-05-05 12:33:04'),(220602,220600,'1|220000|220600',0,'浑江区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:33:04'),(220621,220600,'1|220000|220600',0,'抚松县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:05'),(220622,220600,'1|220000|220600',0,'靖宇县',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:33:05'),(220623,220600,'1|220000|220600',0,'长白朝鲜族自治县',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:33:05'),(220625,220600,'1|220000|220600',0,'江源区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:05'),(220681,220600,'1|220000|220600',0,'临江市',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220682,220600,'1|220000|220600',0,'其它区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220700,220000,'1|220000',1,'松原市',0,3,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220702,220700,'1|220000|220700',0,'宁江区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220721,220700,'1|220000|220700',0,'前郭尔罗斯蒙古族自治县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:05'),(220722,220700,'1|220000|220700',0,'长岭县',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220723,220700,'1|220000|220700',0,'乾安县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:05'),(220724,220700,'1|220000|220700',0,'扶余市',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220725,220700,'1|220000|220700',0,'其它区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:05'),(220800,220000,'1|220000',1,'白城市',0,3,1,'2014-05-05 12:01:23','2014-05-05 12:33:05'),(220802,220800,'1|220000|220800',0,'洮北区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:05'),(220821,220800,'1|220000|220800',0,'镇赉县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:05'),(220822,220800,'1|220000|220800',0,'通榆县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:05'),(220881,220800,'1|220000|220800',0,'洮南市',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:05'),(220882,220800,'1|220000|220800',0,'大安市',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:05'),(220883,220800,'1|220000|220800',0,'其它区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:05'),(222400,220000,'1|220000',1,'延边朝鲜族自治州',0,3,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222401,222400,'1|220000|222400',0,'延吉市',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222402,222400,'1|220000|222400',0,'图们市',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222403,222400,'1|220000|222400',0,'敦化市',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222404,222400,'1|220000|222400',0,'珲春市',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222405,222400,'1|220000|222400',0,'龙井市',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222406,222400,'1|220000|222400',0,'和龙市',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222424,222400,'1|220000|222400',0,'汪清县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222426,222400,'1|220000|222400',0,'安图县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(222427,222400,'1|220000|222400',0,'其它区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:06'),(230000,1,'1',1,'黑龙江省',0,2,1,'2014-05-05 12:02:16','2014-05-05 12:33:06'),(230100,230000,'1|230000',1,'哈尔滨市',0,3,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230102,230100,'1|230000|230100',0,'道里区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230103,230100,'1|230000|230100',0,'南岗区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:33:06'),(230104,230100,'1|230000|230100',0,'道外区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230106,230100,'1|230000|230100',0,'香坊区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230107,230100,'1|230000|230100',0,'动力区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230108,230100,'1|230000|230100',0,'平房区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230109,230100,'1|230000|230100',0,'松北区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230111,230100,'1|230000|230100',0,'呼兰区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:06'),(230123,230100,'1|230000|230100',0,'依兰县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230124,230100,'1|230000|230100',0,'方正县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230125,230100,'1|230000|230100',0,'宾县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230126,230100,'1|230000|230100',0,'巴彦县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230127,230100,'1|230000|230100',0,'木兰县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230128,230100,'1|230000|230100',0,'通河县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230129,230100,'1|230000|230100',0,'延寿县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:33:07'),(230181,230100,'1|230000|230100',0,'阿城区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:07'),(230182,230100,'1|230000|230100',0,'双城市',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:07'),(230183,230100,'1|230000|230100',0,'尚志市',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:07'),(230184,230100,'1|230000|230100',0,'五常市',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:07'),(230185,230100,'1|230000|230100',0,'阿城市',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:07'),(230186,230100,'1|230000|230100',0,'其它区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230200,230000,'1|230000',1,'齐齐哈尔市',0,3,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230202,230200,'1|230000|230200',0,'龙沙区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230203,230200,'1|230000|230200',0,'建华区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230204,230200,'1|230000|230200',0,'铁锋区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230205,230200,'1|230000|230200',0,'昂昂溪区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230206,230200,'1|230000|230200',0,'富拉尔基区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230207,230200,'1|230000|230200',0,'碾子山区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:33:08'),(230208,230200,'1|230000|230200',0,'梅里斯达斡尔族区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230221,230200,'1|230000|230200',0,'龙江县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230223,230200,'1|230000|230200',0,'依安县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230224,230200,'1|230000|230200',0,'泰来县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230225,230200,'1|230000|230200',0,'甘南县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230227,230200,'1|230000|230200',0,'富裕县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230229,230200,'1|230000|230200',0,'克山县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230230,230200,'1|230000|230200',0,'克东县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230231,230200,'1|230000|230200',0,'拜泉县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230281,230200,'1|230000|230200',0,'讷河市',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230282,230200,'1|230000|230200',0,'其它区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230300,230000,'1|230000',1,'鸡西市',0,3,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230302,230300,'1|230000|230300',0,'鸡冠区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230303,230300,'1|230000|230300',0,'恒山区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230304,230300,'1|230000|230300',0,'滴道区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230305,230300,'1|230000|230300',0,'梨树区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230306,230300,'1|230000|230300',0,'城子河区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230307,230300,'1|230000|230300',0,'麻山区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:33:09'),(230321,230300,'1|230000|230300',0,'鸡东县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:33:09'),(230381,230300,'1|230000|230300',0,'虎林市',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:33:09'),(230382,230300,'1|230000|230300',0,'密山市',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:33:10'),(230383,230300,'1|230000|230300',0,'其它区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:33:11'),(230400,230000,'1|230000',1,'鹤岗市',0,3,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230402,230400,'1|230000|230400',0,'向阳区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230403,230400,'1|230000|230400',0,'工农区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230404,230400,'1|230000|230400',0,'南山区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230405,230400,'1|230000|230400',0,'兴安区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230406,230400,'1|230000|230400',0,'东山区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230407,230400,'1|230000|230400',0,'兴山区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230421,230400,'1|230000|230400',0,'萝北县',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230422,230400,'1|230000|230400',0,'绥滨县',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230423,230400,'1|230000|230400',0,'其它区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230500,230000,'1|230000',1,'双鸭山市',0,3,1,'2014-05-05 12:02:11','2014-05-05 12:33:11'),(230502,230500,'1|230000|230500',0,'尖山区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230503,230500,'1|230000|230500',0,'岭东区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:11'),(230505,230500,'1|230000|230500',0,'四方台区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230506,230500,'1|230000|230500',0,'宝山区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:11'),(230521,230500,'1|230000|230500',0,'集贤县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:11'),(230522,230500,'1|230000|230500',0,'友谊县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:11'),(230523,230500,'1|230000|230500',0,'宝清县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:11'),(230524,230500,'1|230000|230500',0,'饶河县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:12'),(230525,230500,'1|230000|230500',0,'其它区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:12'),(230600,230000,'1|230000',1,'大庆市',0,3,1,'2014-05-05 12:02:13','2014-05-05 12:33:12'),(230602,230600,'1|230000|230600',0,'萨尔图区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230603,230600,'1|230000|230600',0,'龙凤区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230604,230600,'1|230000|230600',0,'让胡路区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230605,230600,'1|230000|230600',0,'红岗区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230606,230600,'1|230000|230600',0,'大同区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230621,230600,'1|230000|230600',0,'肇州县',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230622,230600,'1|230000|230600',0,'肇源县',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:12'),(230623,230600,'1|230000|230600',0,'林甸县',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:13'),(230624,230600,'1|230000|230600',0,'杜尔伯特蒙古族自治县',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:13'),(230625,230600,'1|230000|230600',0,'其它区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:33:13'),(230700,230000,'1|230000',1,'伊春市',0,3,1,'2014-05-05 12:02:09','2014-05-05 12:33:13'),(230702,230700,'1|230000|230700',0,'伊春区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:13'),(230703,230700,'1|230000|230700',0,'南岔区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:13'),(230704,230700,'1|230000|230700',0,'友好区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:13'),(230705,230700,'1|230000|230700',0,'西林区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:13'),(230706,230700,'1|230000|230700',0,'翠峦区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:13'),(230707,230700,'1|230000|230700',0,'新青区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:13'),(230708,230700,'1|230000|230700',0,'美溪区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230709,230700,'1|230000|230700',0,'金山屯区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230710,230700,'1|230000|230700',0,'五营区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230711,230700,'1|230000|230700',0,'乌马河区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230712,230700,'1|230000|230700',0,'汤旺河区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230713,230700,'1|230000|230700',0,'带岭区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230714,230700,'1|230000|230700',0,'乌伊岭区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230715,230700,'1|230000|230700',0,'红星区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230716,230700,'1|230000|230700',0,'上甘岭区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:14'),(230722,230700,'1|230000|230700',0,'嘉荫县',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:14'),(230781,230700,'1|230000|230700',0,'铁力市',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:14'),(230782,230700,'1|230000|230700',0,'其它区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:14'),(230800,230000,'1|230000',1,'佳木斯市',0,3,1,'2014-05-05 12:02:11','2014-05-05 12:33:14'),(230802,230800,'1|230000|230800',0,'永红区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:14'),(230803,230800,'1|230000|230800',0,'向阳区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:14'),(230804,230800,'1|230000|230800',0,'前进区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:14'),(230805,230800,'1|230000|230800',0,'东风区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:14'),(230811,230800,'1|230000|230800',0,'郊区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:15'),(230822,230800,'1|230000|230800',0,'桦南县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:15'),(230826,230800,'1|230000|230800',0,'桦川县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:15'),(230828,230800,'1|230000|230800',0,'汤原县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:15'),(230833,230800,'1|230000|230800',0,'抚远县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:33:15'),(230881,230800,'1|230000|230800',0,'同江市',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:15'),(230882,230800,'1|230000|230800',0,'富锦市',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:15'),(230883,230800,'1|230000|230800',0,'其它区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:15'),(230900,230000,'1|230000',1,'七台河市',0,3,1,'2014-05-05 12:02:10','2014-05-05 12:33:15'),(230902,230900,'1|230000|230900',0,'新兴区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:16'),(230903,230900,'1|230000|230900',0,'桃山区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:16'),(230904,230900,'1|230000|230900',0,'茄子河区',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:33:16'),(230921,230900,'1|230000|230900',0,'勃利县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(230922,230900,'1|230000|230900',0,'其它区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231000,230000,'1|230000',1,'牡丹江市',0,3,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231002,231000,'1|230000|231000',0,'东安区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231003,231000,'1|230000|231000',0,'阳明区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231004,231000,'1|230000|231000',0,'爱民区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231005,231000,'1|230000|231000',0,'西安区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231024,231000,'1|230000|231000',0,'东宁县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231025,231000,'1|230000|231000',0,'林口县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:16'),(231081,231000,'1|230000|231000',0,'绥芬河市',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:16'),(231083,231000,'1|230000|231000',0,'海林市',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:33:16'),(231084,231000,'1|230000|231000',0,'宁安市',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231085,231000,'1|230000|231000',0,'穆棱市',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231086,231000,'1|230000|231000',0,'其它区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231100,230000,'1|230000',1,'黑河市',0,3,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231102,231100,'1|230000|231100',0,'爱辉区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231121,231100,'1|230000|231100',0,'嫩江县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231123,231100,'1|230000|231100',0,'逊克县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231124,231100,'1|230000|231100',0,'孙吴县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:33:17'),(231181,231100,'1|230000|231100',0,'北安市',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:17'),(231182,231100,'1|230000|231100',0,'五大连池市',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:17'),(231183,231100,'1|230000|231100',0,'其它区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:17'),(231200,230000,'1|230000',1,'绥化市',0,3,1,'2014-05-05 12:02:07','2014-05-05 12:33:17'),(231202,231200,'1|230000|231200',0,'北林区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:17'),(231221,231200,'1|230000|231200',0,'望奎县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:18'),(231222,231200,'1|230000|231200',0,'兰西县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:18'),(231223,231200,'1|230000|231200',0,'青冈县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:18'),(231224,231200,'1|230000|231200',0,'庆安县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:18'),(231225,231200,'1|230000|231200',0,'明水县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:18'),(231226,231200,'1|230000|231200',0,'绥棱县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:33:18'),(231281,231200,'1|230000|231200',0,'安达市',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:18'),(231282,231200,'1|230000|231200',0,'肇东市',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:18'),(231283,231200,'1|230000|231200',0,'海伦市',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:18'),(231284,231200,'1|230000|231200',0,'其它区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:33:19'),(232700,230000,'1|230000',1,'大兴安岭地区',0,3,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(232702,232700,'1|230000|232700',0,'松岭区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(232703,232700,'1|230000|232700',0,'新林区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(232704,232700,'1|230000|232700',0,'呼中区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(232721,232700,'1|230000|232700',0,'呼玛县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:33:19'),(232722,232700,'1|230000|232700',0,'塔河县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:33:19'),(232723,232700,'1|230000|232700',0,'漠河县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(232724,232700,'1|230000|232700',0,'加格达奇区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(232725,232700,'1|230000|232700',0,'其它区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:33:19'),(310000,1,'1',1,'上海',0,2,1,'2014-05-05 12:03:02','2014-05-05 12:33:19'),(310100,310000,'1|310000',1,'上海市',0,3,1,'2014-05-05 12:03:03','2014-05-05 12:33:19'),(310101,310100,'1|310000|310100',0,'黄浦区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:19'),(310103,310100,'1|310000|310100',0,'卢湾区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:19'),(310104,310100,'1|310000|310100',0,'徐汇区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:19'),(310105,310100,'1|310000|310100',0,'长宁区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:19'),(310106,310100,'1|310000|310100',0,'静安区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:19'),(310107,310100,'1|310000|310100',0,'普陀区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:19'),(310108,310100,'1|310000|310100',0,'闸北区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:20'),(310109,310100,'1|310000|310100',0,'虹口区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:20'),(310110,310100,'1|310000|310100',0,'杨浦区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:33:20'),(310112,310100,'1|310000|310100',0,'闵行区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310113,310100,'1|310000|310100',0,'宝山区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310114,310100,'1|310000|310100',0,'嘉定区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310115,310100,'1|310000|310100',0,'浦东新区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310116,310100,'1|310000|310100',0,'金山区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310117,310100,'1|310000|310100',0,'松江区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310118,310100,'1|310000|310100',0,'青浦区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310119,310100,'1|310000|310100',0,'南汇区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310120,310100,'1|310000|310100',0,'奉贤区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:33:20'),(310152,310100,'1|310000|310100',0,'川沙区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:33:20'),(310230,310100,'1|310000|310100',0,'崇明县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:33:20'),(310231,310100,'1|310000|310100',0,'其它区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:33:20'),(320000,1,'1',1,'江苏省',0,2,1,'2014-05-05 12:01:57','2014-05-05 12:33:20'),(320100,320000,'1|320000',1,'南京市',0,3,1,'2014-05-05 12:01:57','2014-05-05 12:33:20'),(320102,320100,'1|320000|320100',0,'玄武区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320103,320100,'1|320000|320100',0,'白下区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320104,320100,'1|320000|320100',0,'秦淮区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320105,320100,'1|320000|320100',0,'建邺区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320106,320100,'1|320000|320100',0,'鼓楼区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320107,320100,'1|320000|320100',0,'下关区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320111,320100,'1|320000|320100',0,'浦口区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320113,320100,'1|320000|320100',0,'栖霞区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320114,320100,'1|320000|320100',0,'雨花台区',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:33:21'),(320115,320100,'1|320000|320100',0,'江宁区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:21'),(320116,320100,'1|320000|320100',0,'六合区',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:33:22'),(320124,320100,'1|320000|320100',0,'溧水区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320125,320100,'1|320000|320100',0,'高淳区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320126,320100,'1|320000|320100',0,'其它区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320200,320000,'1|320000',1,'无锡市',0,3,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320202,320200,'1|320000|320200',0,'崇安区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320203,320200,'1|320000|320200',0,'南长区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320204,320200,'1|320000|320200',0,'北塘区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320205,320200,'1|320000|320200',0,'锡山区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320206,320200,'1|320000|320200',0,'惠山区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320211,320200,'1|320000|320200',0,'滨湖区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:22'),(320281,320200,'1|320000|320200',0,'江阴市',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:22'),(320282,320200,'1|320000|320200',0,'宜兴市',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:22'),(320296,320200,'1|320000|320200',0,'新区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320297,320200,'1|320000|320200',0,'其它区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320300,320000,'1|320000',1,'徐州市',0,3,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320302,320300,'1|320000|320300',0,'鼓楼区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320303,320300,'1|320000|320300',0,'云龙区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320304,320300,'1|320000|320300',0,'九里区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320305,320300,'1|320000|320300',0,'贾汪区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:23'),(320311,320300,'1|320000|320300',0,'泉山区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:24'),(320321,320300,'1|320000|320300',0,'丰县',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320322,320300,'1|320000|320300',0,'沛县',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320323,320300,'1|320000|320300',0,'铜山区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320324,320300,'1|320000|320300',0,'睢宁县',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320381,320300,'1|320000|320300',0,'新沂市',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320382,320300,'1|320000|320300',0,'邳州市',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320383,320300,'1|320000|320300',0,'其它区',0,4,1,'2014-05-05 12:01:57','2014-05-05 12:33:24'),(320400,320000,'1|320000',1,'常州市',0,3,1,'2014-05-05 12:01:56','2014-05-05 12:33:24'),(320402,320400,'1|320000|320400',0,'天宁区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:24'),(320404,320400,'1|320000|320400',0,'钟楼区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:24'),(320405,320400,'1|320000|320400',0,'戚墅堰区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:24'),(320411,320400,'1|320000|320400',0,'新北区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:24'),(320412,320400,'1|320000|320400',0,'武进区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320481,320400,'1|320000|320400',0,'溧阳市',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320482,320400,'1|320000|320400',0,'金坛市',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320483,320400,'1|320000|320400',0,'其它区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320500,320000,'1|320000',1,'苏州市',0,3,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320502,320500,'1|320000|320500',0,'沧浪区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320503,320500,'1|320000|320500',0,'平江区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320504,320500,'1|320000|320500',0,'金阊区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320505,320500,'1|320000|320500',0,'虎丘区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320506,320500,'1|320000|320500',0,'吴中区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320507,320500,'1|320000|320500',0,'相城区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320508,320500,'1|320000|320500',0,'姑苏区',0,4,1,'2014-05-05 12:01:56','2014-05-05 12:33:25'),(320581,320500,'1|320000|320500',0,'常熟市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320582,320500,'1|320000|320500',0,'张家港市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320583,320500,'1|320000|320500',0,'昆山市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320584,320500,'1|320000|320500',0,'吴江区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320585,320500,'1|320000|320500',0,'太仓市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320594,320500,'1|320000|320500',0,'新区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320595,320500,'1|320000|320500',0,'园区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320596,320500,'1|320000|320500',0,'其它区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:25'),(320600,320000,'1|320000',1,'南通市',0,3,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320602,320600,'1|320000|320600',0,'崇川区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320611,320600,'1|320000|320600',0,'港闸区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320612,320600,'1|320000|320600',0,'通州区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320621,320600,'1|320000|320600',0,'海安县',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320623,320600,'1|320000|320600',0,'如东县',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320681,320600,'1|320000|320600',0,'启东市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320682,320600,'1|320000|320600',0,'如皋市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320683,320600,'1|320000|320600',0,'通州市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320684,320600,'1|320000|320600',0,'海门市',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320693,320600,'1|320000|320600',0,'开发区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320694,320600,'1|320000|320600',0,'其它区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320700,320000,'1|320000',1,'连云港市',0,3,1,'2014-05-05 12:01:55','2014-05-05 12:33:26'),(320703,320700,'1|320000|320700',0,'连云区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:27'),(320705,320700,'1|320000|320700',0,'新浦区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:27'),(320706,320700,'1|320000|320700',0,'海州区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:27'),(320721,320700,'1|320000|320700',0,'赣榆县',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:27'),(320722,320700,'1|320000|320700',0,'东海县',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:27'),(320723,320700,'1|320000|320700',0,'灌云县',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:27'),(320724,320700,'1|320000|320700',0,'灌南县',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:27'),(320725,320700,'1|320000|320700',0,'其它区',0,4,1,'2014-05-05 12:01:55','2014-05-05 12:33:28'),(320800,320000,'1|320000',1,'淮安市',0,3,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320802,320800,'1|320000|320800',0,'清河区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320803,320800,'1|320000|320800',0,'淮安区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320804,320800,'1|320000|320800',0,'淮阴区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320811,320800,'1|320000|320800',0,'清浦区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320826,320800,'1|320000|320800',0,'涟水县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320829,320800,'1|320000|320800',0,'洪泽县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320830,320800,'1|320000|320800',0,'盱眙县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320831,320800,'1|320000|320800',0,'金湖县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320832,320800,'1|320000|320800',0,'其它区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320900,320000,'1|320000',1,'盐城市',0,3,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320902,320900,'1|320000|320900',0,'亭湖区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320903,320900,'1|320000|320900',0,'盐都区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320921,320900,'1|320000|320900',0,'响水县',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:28'),(320922,320900,'1|320000|320900',0,'滨海县',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:28'),(320923,320900,'1|320000|320900',0,'阜宁县',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:28'),(320924,320900,'1|320000|320900',0,'射阳县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320925,320900,'1|320000|320900',0,'建湖县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:33:28'),(320981,320900,'1|320000|320900',0,'东台市',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:28'),(320982,320900,'1|320000|320900',0,'大丰市',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(320983,320900,'1|320000|320900',0,'其它区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321000,320000,'1|320000',1,'扬州市',0,3,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321002,321000,'1|320000|321000',0,'广陵区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321003,321000,'1|320000|321000',0,'邗江区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321011,321000,'1|320000|321000',0,'维扬区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321023,321000,'1|320000|321000',0,'宝应县',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321081,321000,'1|320000|321000',0,'仪征市',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321084,321000,'1|320000|321000',0,'高邮市',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321088,321000,'1|320000|321000',0,'江都区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:29'),(321092,321000,'1|320000|321000',0,'经济开发区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321093,321000,'1|320000|321000',0,'其它区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321100,320000,'1|320000',1,'镇江市',0,3,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321102,321100,'1|320000|321100',0,'京口区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321111,321100,'1|320000|321100',0,'润州区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321112,321100,'1|320000|321100',0,'丹徒区',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321181,321100,'1|320000|321100',0,'丹阳市',0,4,1,'2014-05-05 12:01:53','2014-05-05 12:33:30'),(321182,321100,'1|320000|321100',0,'扬中市',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:30'),(321183,321100,'1|320000|321100',0,'句容市',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:30'),(321184,321100,'1|320000|321100',0,'其它区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:30'),(321200,320000,'1|320000',1,'泰州市',0,3,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321202,321200,'1|320000|321200',0,'海陵区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321203,321200,'1|320000|321200',0,'高港区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321281,321200,'1|320000|321200',0,'兴化市',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321282,321200,'1|320000|321200',0,'靖江市',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321283,321200,'1|320000|321200',0,'泰兴市',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321284,321200,'1|320000|321200',0,'姜堰区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321285,321200,'1|320000|321200',0,'其它区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321300,320000,'1|320000',1,'宿迁市',0,3,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321302,321300,'1|320000|321300',0,'宿城区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321311,321300,'1|320000|321300',0,'宿豫区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321322,321300,'1|320000|321300',0,'沭阳县',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321323,321300,'1|320000|321300',0,'泗阳县',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321324,321300,'1|320000|321300',0,'泗洪县',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(321325,321300,'1|320000|321300',0,'其它区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:33:31'),(330000,1,'1',1,'浙江省',0,2,1,'2014-05-05 12:00:58','2014-05-05 12:33:31'),(330100,330000,'1|330000',1,'杭州市',0,3,1,'2014-05-05 12:00:58','2014-05-05 12:33:31'),(330102,330100,'1|330000|330100',0,'上城区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:31'),(330103,330100,'1|330000|330100',0,'下城区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:31'),(330104,330100,'1|330000|330100',0,'江干区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:31'),(330105,330100,'1|330000|330100',0,'拱墅区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330106,330100,'1|330000|330100',0,'西湖区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330108,330100,'1|330000|330100',0,'滨江区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330109,330100,'1|330000|330100',0,'萧山区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330110,330100,'1|330000|330100',0,'余杭区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330122,330100,'1|330000|330100',0,'桐庐县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330127,330100,'1|330000|330100',0,'淳安县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:32'),(330182,330100,'1|330000|330100',0,'建德市',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:32'),(330183,330100,'1|330000|330100',0,'富阳市',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:32'),(330185,330100,'1|330000|330100',0,'临安市',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:32'),(330186,330100,'1|330000|330100',0,'其它区',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:32'),(330200,330000,'1|330000',1,'宁波市',0,3,1,'2014-05-05 12:00:56','2014-05-05 12:33:32'),(330203,330200,'1|330000|330200',0,'海曙区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:32'),(330204,330200,'1|330000|330200',0,'江东区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:33'),(330205,330200,'1|330000|330200',0,'江北区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:33'),(330206,330200,'1|330000|330200',0,'北仑区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:33'),(330211,330200,'1|330000|330200',0,'镇海区',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:33'),(330212,330200,'1|330000|330200',0,'鄞州区',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:33:33'),(330225,330200,'1|330000|330200',0,'象山县',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:33'),(330226,330200,'1|330000|330200',0,'宁海县',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:33:33'),(330281,330200,'1|330000|330200',0,'余姚市',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330282,330200,'1|330000|330200',0,'慈溪市',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330283,330200,'1|330000|330200',0,'奉化市',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330284,330200,'1|330000|330200',0,'其它区',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330300,330000,'1|330000',1,'温州市',0,3,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330302,330300,'1|330000|330300',0,'鹿城区',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330303,330300,'1|330000|330300',0,'龙湾区',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330304,330300,'1|330000|330300',0,'瓯海区',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330322,330300,'1|330000|330300',0,'洞头县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330324,330300,'1|330000|330300',0,'永嘉县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330326,330300,'1|330000|330300',0,'平阳县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330327,330300,'1|330000|330300',0,'苍南县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330328,330300,'1|330000|330300',0,'文成县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:34'),(330329,330300,'1|330000|330300',0,'泰顺县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:35'),(330381,330300,'1|330000|330300',0,'瑞安市',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:35'),(330382,330300,'1|330000|330300',0,'乐清市',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:35'),(330383,330300,'1|330000|330300',0,'其它区',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:35'),(330400,330000,'1|330000',1,'嘉兴市',0,3,1,'2014-05-05 12:00:54','2014-05-05 12:33:35'),(330402,330400,'1|330000|330400',0,'南湖区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:33:35'),(330411,330400,'1|330000|330400',0,'秀洲区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:33:35'),(330421,330400,'1|330000|330400',0,'嘉善县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:35'),(330424,330400,'1|330000|330400',0,'海盐县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:35'),(330481,330400,'1|330000|330400',0,'海宁市',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:33:35'),(330482,330400,'1|330000|330400',0,'平湖市',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:33:36'),(330483,330400,'1|330000|330400',0,'桐乡市',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:33:36'),(330484,330400,'1|330000|330400',0,'其它区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:33:36'),(330500,330000,'1|330000',1,'湖州市',0,3,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330502,330500,'1|330000|330500',0,'吴兴区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330503,330500,'1|330000|330500',0,'南浔区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330521,330500,'1|330000|330500',0,'德清县',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330522,330500,'1|330000|330500',0,'长兴县',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330523,330500,'1|330000|330500',0,'安吉县',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330524,330500,'1|330000|330500',0,'其它区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330600,330000,'1|330000',1,'绍兴市',0,3,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330602,330600,'1|330000|330600',0,'越城区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330621,330600,'1|330000|330600',0,'绍兴县',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330624,330600,'1|330000|330600',0,'新昌县',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330681,330600,'1|330000|330600',0,'诸暨市',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330682,330600,'1|330000|330600',0,'上虞市',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330683,330600,'1|330000|330600',0,'嵊州市',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:36'),(330684,330600,'1|330000|330600',0,'其它区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:37'),(330700,330000,'1|330000',1,'金华市',0,3,1,'2014-05-05 12:00:56','2014-05-05 12:33:37'),(330702,330700,'1|330000|330700',0,'婺城区',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:37'),(330703,330700,'1|330000|330700',0,'金东区',0,4,1,'2014-05-05 12:00:56','2014-05-05 12:33:37'),(330723,330700,'1|330000|330700',0,'武义县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:37'),(330726,330700,'1|330000|330700',0,'浦江县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:37'),(330727,330700,'1|330000|330700',0,'磐安县',0,4,1,'2014-05-05 12:00:55','2014-05-05 12:33:37'),(330781,330700,'1|330000|330700',0,'兰溪市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:37'),(330782,330700,'1|330000|330700',0,'义乌市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:37'),(330783,330700,'1|330000|330700',0,'东阳市',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330784,330700,'1|330000|330700',0,'永康市',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330785,330700,'1|330000|330700',0,'其它区',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330800,330000,'1|330000',1,'衢州市',0,3,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330802,330800,'1|330000|330800',0,'柯城区',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330803,330800,'1|330000|330800',0,'衢江区',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330822,330800,'1|330000|330800',0,'常山县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330824,330800,'1|330000|330800',0,'开化县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330825,330800,'1|330000|330800',0,'龙游县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:37'),(330881,330800,'1|330000|330800',0,'江山市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:37'),(330882,330800,'1|330000|330800',0,'其它区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:37'),(330900,330000,'1|330000',1,'舟山市',0,3,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(330902,330900,'1|330000|330900',0,'定海区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(330903,330900,'1|330000|330900',0,'普陀区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(330921,330900,'1|330000|330900',0,'岱山县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(330922,330900,'1|330000|330900',0,'嵊泗县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(330923,330900,'1|330000|330900',0,'其它区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(331000,330000,'1|330000',1,'台州市',0,3,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(331002,331000,'1|330000|331000',0,'椒江区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(331003,331000,'1|330000|331000',0,'黄岩区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:38'),(331004,331000,'1|330000|331000',0,'路桥区',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:33:39'),(331021,331000,'1|330000|331000',0,'玉环县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331022,331000,'1|330000|331000',0,'三门县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331023,331000,'1|330000|331000',0,'天台县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331024,331000,'1|330000|331000',0,'仙居县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331081,331000,'1|330000|331000',0,'温岭市',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331082,331000,'1|330000|331000',0,'临海市',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331083,331000,'1|330000|331000',0,'其它区',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331100,330000,'1|330000',1,'丽水市',0,3,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331102,331100,'1|330000|331100',0,'莲都区',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331121,331100,'1|330000|331100',0,'青田县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:39'),(331122,331100,'1|330000|331100',0,'缙云县',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:40'),(331123,331100,'1|330000|331100',0,'遂昌县',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:33:40'),(331124,331100,'1|330000|331100',0,'松阳县',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:33:40'),(331125,331100,'1|330000|331100',0,'云和县',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:33:40'),(331126,331100,'1|330000|331100',0,'庆元县',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:33:40'),(331127,331100,'1|330000|331100',0,'景宁畲族自治县',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:33:40'),(331181,331100,'1|330000|331100',0,'龙泉市',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:40'),(331182,331100,'1|330000|331100',0,'其它区',0,4,1,'2014-05-05 12:01:00','2014-05-05 12:33:40'),(340000,1,'1',1,'安徽省',0,2,1,'2014-05-05 12:01:13','2014-05-05 12:33:40'),(340100,340000,'1|340000',1,'合肥市',0,3,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340102,340100,'1|340000|340100',0,'瑶海区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340103,340100,'1|340000|340100',0,'庐阳区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340104,340100,'1|340000|340100',0,'蜀山区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340111,340100,'1|340000|340100',0,'包河区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340121,340100,'1|340000|340100',0,'长丰县',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340122,340100,'1|340000|340100',0,'肥东县',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340123,340100,'1|340000|340100',0,'肥西县',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340151,340100,'1|340000|340100',0,'高新区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:40'),(340191,340100,'1|340000|340100',0,'中区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340192,340100,'1|340000|340100',0,'其它区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:40'),(340200,340000,'1|340000',1,'芜湖市',0,3,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340202,340200,'1|340000|340200',0,'镜湖区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340203,340200,'1|340000|340200',0,'弋江区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340207,340200,'1|340000|340200',0,'鸠江区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340208,340200,'1|340000|340200',0,'三山区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340221,340200,'1|340000|340200',0,'芜湖县',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340222,340200,'1|340000|340200',0,'繁昌县',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340223,340200,'1|340000|340200',0,'南陵县',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:41'),(340224,340200,'1|340000|340200',0,'其它区',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:33:41'),(340300,340000,'1|340000',1,'蚌埠市',0,3,1,'2014-05-05 12:01:13','2014-05-05 12:33:41'),(340302,340300,'1|340000|340300',0,'龙子湖区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:41'),(340303,340300,'1|340000|340300',0,'蚌山区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:41'),(340304,340300,'1|340000|340300',0,'禹会区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:42'),(340311,340300,'1|340000|340300',0,'淮上区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:42'),(340321,340300,'1|340000|340300',0,'怀远县',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:33:42'),(340322,340300,'1|340000|340300',0,'五河县',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:33:42'),(340323,340300,'1|340000|340300',0,'固镇县',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:33:42'),(340324,340300,'1|340000|340300',0,'其它区',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:33:42'),(340400,340000,'1|340000',1,'淮南市',0,3,1,'2014-05-05 12:01:13','2014-05-05 12:33:42'),(340402,340400,'1|340000|340400',0,'大通区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:42'),(340403,340400,'1|340000|340400',0,'田家庵区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:43'),(340404,340400,'1|340000|340400',0,'谢家集区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:43'),(340405,340400,'1|340000|340400',0,'八公山区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:43'),(340406,340400,'1|340000|340400',0,'潘集区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:43'),(340421,340400,'1|340000|340400',0,'凤台县',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:43'),(340422,340400,'1|340000|340400',0,'其它区',0,4,1,'2014-05-05 12:01:13','2014-05-05 12:33:43'),(340500,340000,'1|340000',1,'马鞍山市',0,3,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340502,340500,'1|340000|340500',0,'金家庄区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340503,340500,'1|340000|340500',0,'花山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340504,340500,'1|340000|340500',0,'雨山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340506,340500,'1|340000|340500',0,'博望区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340521,340500,'1|340000|340500',0,'当涂县',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340522,340500,'1|340000|340500',0,'其它区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340600,340000,'1|340000',1,'淮北市',0,3,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340602,340600,'1|340000|340600',0,'杜集区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340603,340600,'1|340000|340600',0,'相山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340604,340600,'1|340000|340600',0,'烈山区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340621,340600,'1|340000|340600',0,'濉溪县',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:33:43'),(340622,340600,'1|340000|340600',0,'其它区',0,4,1,'2014-05-05 12:01:16','2014-05-05 12:33:43'),(340700,340000,'1|340000',1,'铜陵市',0,3,1,'2014-05-05 12:01:17','2014-05-05 12:33:43'),(340702,340700,'1|340000|340700',0,'铜官山区',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:33:44'),(340703,340700,'1|340000|340700',0,'狮子山区',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:33:44'),(340711,340700,'1|340000|340700',0,'郊区',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:33:44'),(340721,340700,'1|340000|340700',0,'铜陵县',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:33:44'),(340722,340700,'1|340000|340700',0,'其它区',0,4,1,'2014-05-05 12:01:17','2014-05-05 12:33:44'),(340800,340000,'1|340000',1,'安庆市',0,3,1,'2014-05-05 12:01:14','2014-05-05 12:33:44'),(340802,340800,'1|340000|340800',0,'迎江区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:44'),(340803,340800,'1|340000|340800',0,'大观区',0,4,1,'2014-05-05 12:01:14','2014-05-05 12:33:44'),(340811,340800,'1|340000|340800',0,'宜秀区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:44'),(340822,340800,'1|340000|340800',0,'怀宁县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:44'),(340823,340800,'1|340000|340800',0,'枞阳县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:44'),(340824,340800,'1|340000|340800',0,'潜山县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(340825,340800,'1|340000|340800',0,'太湖县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(340826,340800,'1|340000|340800',0,'宿松县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(340827,340800,'1|340000|340800',0,'望江县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(340828,340800,'1|340000|340800',0,'岳西县',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(340881,340800,'1|340000|340800',0,'桐城市',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(340882,340800,'1|340000|340800',0,'其它区',0,4,1,'2014-05-05 12:01:15','2014-05-05 12:33:45'),(341000,340000,'1|340000',1,'黄山市',0,3,1,'2014-05-05 12:01:21','2014-05-05 12:33:45'),(341002,341000,'1|340000|341000',0,'屯溪区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:45'),(341003,341000,'1|340000|341000',0,'黄山区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341004,341000,'1|340000|341000',0,'徽州区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341021,341000,'1|340000|341000',0,'歙县',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341022,341000,'1|340000|341000',0,'休宁县',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341023,341000,'1|340000|341000',0,'黟县',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341024,341000,'1|340000|341000',0,'祁门县',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341025,341000,'1|340000|341000',0,'其它区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:33:46'),(341100,340000,'1|340000',1,'滁州市',0,3,1,'2014-05-05 12:01:20','2014-05-05 12:33:46'),(341102,341100,'1|340000|341100',0,'琅琊区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:46'),(341103,341100,'1|340000|341100',0,'南谯区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:46'),(341122,341100,'1|340000|341100',0,'来安县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:46'),(341124,341100,'1|340000|341100',0,'全椒县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:46'),(341125,341100,'1|340000|341100',0,'定远县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:46'),(341126,341100,'1|340000|341100',0,'凤阳县',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:46'),(341181,341100,'1|340000|341100',0,'天长市',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:46'),(341182,341100,'1|340000|341100',0,'明光市',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:46'),(341183,341100,'1|340000|341100',0,'其它区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:33:46'),(341200,340000,'1|340000',1,'阜阳市',0,3,1,'2014-05-05 12:01:22','2014-05-05 12:33:46'),(341202,341200,'1|340000|341200',0,'颍州区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:46'),(341203,341200,'1|340000|341200',0,'颍东区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:46'),(341204,341200,'1|340000|341200',0,'颍泉区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:47'),(341221,341200,'1|340000|341200',0,'临泉县',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:47'),(341222,341200,'1|340000|341200',0,'太和县',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:47'),(341225,341200,'1|340000|341200',0,'阜南县',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:47'),(341226,341200,'1|340000|341200',0,'颍上县',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:33:47'),(341282,341200,'1|340000|341200',0,'界首市',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:47'),(341283,341200,'1|340000|341200',0,'其它区',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:47'),(341300,340000,'1|340000',1,'宿州市',0,3,1,'2014-05-05 12:01:19','2014-05-05 12:33:47'),(341302,341300,'1|340000|341300',0,'埇桥区',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:47'),(341321,341300,'1|340000|341300',0,'砀山县',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:47'),(341322,341300,'1|340000|341300',0,'萧县',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:47'),(341323,341300,'1|340000|341300',0,'灵璧县',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:48'),(341324,341300,'1|340000|341300',0,'泗县',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:48'),(341325,341300,'1|340000|341300',0,'其它区',0,4,1,'2014-05-05 12:01:18','2014-05-05 12:33:48'),(341400,340100,'1|340000|340100',0,'巢湖市',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:48'),(341402,340100,'1|340000|340100',0,'居巢区',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:48'),(341421,340100,'1|340000|340100',0,'庐江县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:48'),(341422,340200,'1|340000|340200',0,'无为县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:48'),(341423,340500,'1|340000|340500',0,'含山县',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:33:48'),(341424,340500,'1|340000|340500',0,'和县',0,4,1,'2014-05-05 12:01:20','2014-05-05 12:33:48'),(341500,340000,'1|340000',1,'六安市',0,3,1,'2014-05-05 12:01:19','2014-05-05 12:33:49'),(341502,341500,'1|340000|341500',0,'金安区',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:33:49'),(341503,341500,'1|340000|341500',0,'裕安区',0,4,1,'2014-05-05 12:01:19','2014-05-05 12:33:49'),(341521,341500,'1|340000|341500',0,'寿县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341522,341500,'1|340000|341500',0,'霍邱县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341523,341500,'1|340000|341500',0,'舒城县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341524,341500,'1|340000|341500',0,'金寨县',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:33:49'),(341525,341500,'1|340000|341500',0,'霍山县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341526,341500,'1|340000|341500',0,'其它区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341600,340000,'1|340000',1,'亳州市',0,3,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341602,341600,'1|340000|341600',0,'谯城区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341621,341600,'1|340000|341600',0,'涡阳县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341622,341600,'1|340000|341600',0,'蒙城县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341623,341600,'1|340000|341600',0,'利辛县',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341624,341600,'1|340000|341600',0,'其它区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:33:49'),(341700,340000,'1|340000',1,'池州市',0,3,1,'2014-05-05 12:01:31','2014-05-05 12:33:49'),(341702,341700,'1|340000|341700',0,'贵池区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:49'),(341721,341700,'1|340000|341700',0,'东至县',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:49'),(341722,341700,'1|340000|341700',0,'石台县',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:49'),(341723,341700,'1|340000|341700',0,'青阳县',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:49'),(341724,341700,'1|340000|341700',0,'其它区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:33:50'),(341800,340000,'1|340000',1,'宣城市',0,3,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(341802,341800,'1|340000|341800',0,'宣州区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(341821,341800,'1|340000|341800',0,'郎溪县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(341822,341800,'1|340000|341800',0,'广德县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(341823,341800,'1|340000|341800',0,'泾县',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(341824,341800,'1|340000|341800',0,'绩溪县',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:33:50'),(341825,341800,'1|340000|341800',0,'旌德县',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:33:50'),(341881,341800,'1|340000|341800',0,'宁国市',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(341882,341800,'1|340000|341800',0,'其它区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:33:50'),(350000,1,'1',1,'福建省',0,2,1,'2014-05-05 12:00:38','2014-05-05 12:33:50'),(350100,350000,'1|350000',1,'福州市',0,3,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350102,350100,'1|350000|350100',0,'鼓楼区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350103,350100,'1|350000|350100',0,'台江区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350104,350100,'1|350000|350100',0,'仓山区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350105,350100,'1|350000|350100',0,'马尾区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350111,350100,'1|350000|350100',0,'晋安区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350121,350100,'1|350000|350100',0,'闽侯县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350122,350100,'1|350000|350100',0,'连江县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350123,350100,'1|350000|350100',0,'罗源县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:51'),(350124,350100,'1|350000|350100',0,'闽清县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:52'),(350125,350100,'1|350000|350100',0,'永泰县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:52'),(350128,350100,'1|350000|350100',0,'平潭县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:52'),(350181,350100,'1|350000|350100',0,'福清市',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:52'),(350182,350100,'1|350000|350100',0,'长乐市',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:52'),(350183,350100,'1|350000|350100',0,'其它区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:52'),(350200,350000,'1|350000',1,'厦门市',0,3,1,'2014-05-05 12:00:38','2014-05-05 12:33:52'),(350203,350200,'1|350000|350200',0,'思明区',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:33:52'),(350205,350200,'1|350000|350200',0,'海沧区',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:33:52'),(350206,350200,'1|350000|350200',0,'湖里区',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:33:52'),(350211,350200,'1|350000|350200',0,'集美区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:52'),(350212,350200,'1|350000|350200',0,'同安区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:52'),(350213,350200,'1|350000|350200',0,'翔安区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:52'),(350214,350200,'1|350000|350200',0,'其它区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:52'),(350300,350000,'1|350000',1,'莆田市',0,3,1,'2014-05-05 12:00:35','2014-05-05 12:33:52'),(350302,350300,'1|350000|350300',0,'城厢区',0,4,1,'2014-05-05 12:00:35','2014-05-05 12:33:52'),(350303,350300,'1|350000|350300',0,'涵江区',0,4,1,'2014-05-05 12:00:35','2014-05-05 12:33:52'),(350304,350300,'1|350000|350300',0,'荔城区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:52'),(350305,350300,'1|350000|350300',0,'秀屿区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:52'),(350322,350300,'1|350000|350300',0,'仙游县',0,4,1,'2014-05-05 12:00:35','2014-05-05 12:33:52'),(350323,350300,'1|350000|350300',0,'其它区',0,4,1,'2014-05-05 12:00:35','2014-05-05 12:33:53'),(350400,350000,'1|350000',1,'三明市',0,3,1,'2014-05-05 12:00:36','2014-05-05 12:33:53'),(350402,350400,'1|350000|350400',0,'梅列区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:53'),(350403,350400,'1|350000|350400',0,'三元区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:53'),(350421,350400,'1|350000|350400',0,'明溪县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:53'),(350423,350400,'1|350000|350400',0,'清流县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:53'),(350424,350400,'1|350000|350400',0,'宁化县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:53'),(350425,350400,'1|350000|350400',0,'大田县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:54'),(350426,350400,'1|350000|350400',0,'尤溪县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:54'),(350427,350400,'1|350000|350400',0,'沙县',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:33:54'),(350428,350400,'1|350000|350400',0,'将乐县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:54'),(350429,350400,'1|350000|350400',0,'泰宁县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:54'),(350430,350400,'1|350000|350400',0,'建宁县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:33:54'),(350481,350400,'1|350000|350400',0,'永安市',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350482,350400,'1|350000|350400',0,'其它区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350500,350000,'1|350000',1,'泉州市',0,3,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350502,350500,'1|350000|350500',0,'鲤城区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350503,350500,'1|350000|350500',0,'丰泽区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350504,350500,'1|350000|350500',0,'洛江区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350505,350500,'1|350000|350500',0,'泉港区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:54'),(350521,350500,'1|350000|350500',0,'惠安县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:55'),(350524,350500,'1|350000|350500',0,'安溪县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:55'),(350525,350500,'1|350000|350500',0,'永春县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:55'),(350526,350500,'1|350000|350500',0,'德化县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:55'),(350527,350500,'1|350000|350500',0,'金门县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:55'),(350581,350500,'1|350000|350500',0,'石狮市',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:55'),(350582,350500,'1|350000|350500',0,'晋江市',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:55'),(350583,350500,'1|350000|350500',0,'南安市',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:55'),(350584,350500,'1|350000|350500',0,'其它区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:55'),(350600,350000,'1|350000',1,'漳州市',0,3,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350602,350600,'1|350000|350600',0,'芗城区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350603,350600,'1|350000|350600',0,'龙文区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350622,350600,'1|350000|350600',0,'云霄县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350623,350600,'1|350000|350600',0,'漳浦县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350624,350600,'1|350000|350600',0,'诏安县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350625,350600,'1|350000|350600',0,'长泰县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350626,350600,'1|350000|350600',0,'东山县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350627,350600,'1|350000|350600',0,'南靖县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350628,350600,'1|350000|350600',0,'平和县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350629,350600,'1|350000|350600',0,'华安县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:55'),(350681,350600,'1|350000|350600',0,'龙海市',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:56'),(350682,350600,'1|350000|350600',0,'其它区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:33:56'),(350700,350000,'1|350000',1,'南平市',0,3,1,'2014-05-05 12:00:33','2014-05-05 12:33:56'),(350702,350700,'1|350000|350700',0,'延平区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:33:56'),(350721,350700,'1|350000|350700',0,'顺昌县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:56'),(350722,350700,'1|350000|350700',0,'浦城县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:56'),(350723,350700,'1|350000|350700',0,'光泽县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:56'),(350724,350700,'1|350000|350700',0,'松溪县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:56'),(350725,350700,'1|350000|350700',0,'政和县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350781,350700,'1|350000|350700',0,'邵武市',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350782,350700,'1|350000|350700',0,'武夷山市',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350783,350700,'1|350000|350700',0,'建瓯市',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350784,350700,'1|350000|350700',0,'建阳市',0,4,1,'2014-05-05 12:00:30','2014-05-05 12:33:57'),(350785,350700,'1|350000|350700',0,'其它区',0,4,1,'2014-05-05 12:00:30','2014-05-05 12:33:57'),(350800,350000,'1|350000',1,'龙岩市',0,3,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350802,350800,'1|350000|350800',0,'新罗区',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350821,350800,'1|350000|350800',0,'长汀县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350822,350800,'1|350000|350800',0,'永定县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350823,350800,'1|350000|350800',0,'上杭县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350824,350800,'1|350000|350800',0,'武平县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:57'),(350825,350800,'1|350000|350800',0,'连城县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:58'),(350881,350800,'1|350000|350800',0,'漳平市',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:58'),(350882,350800,'1|350000|350800',0,'其它区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:58'),(350900,350000,'1|350000',1,'宁德市',0,3,1,'2014-05-05 12:00:32','2014-05-05 12:33:58'),(350902,350900,'1|350000|350900',0,'蕉城区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:58'),(350921,350900,'1|350000|350900',0,'霞浦县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:58'),(350922,350900,'1|350000|350900',0,'古田县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:58'),(350923,350900,'1|350000|350900',0,'屏南县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:58'),(350924,350900,'1|350000|350900',0,'寿宁县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:58'),(350925,350900,'1|350000|350900',0,'周宁县',0,4,1,'2014-05-05 12:00:31','2014-05-05 12:33:58'),(350926,350900,'1|350000|350900',0,'柘荣县',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:33:58'),(350981,350900,'1|350000|350900',0,'福安市',0,4,1,'2014-05-05 12:00:28','2014-05-05 12:33:58'),(350982,350900,'1|350000|350900',0,'福鼎市',0,4,1,'2014-05-05 12:00:28','2014-05-05 12:33:58'),(350983,350900,'1|350000|350900',0,'其它区',0,4,1,'2014-05-05 12:00:28','2014-05-05 12:33:58'),(360000,1,'1',1,'江西省',0,2,1,'2014-05-05 12:00:42','2014-05-05 12:33:58'),(360100,360000,'1|360000',1,'南昌市',0,3,1,'2014-05-05 12:00:42','2014-05-05 12:33:58'),(360102,360100,'1|360000|360100',0,'东湖区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:33:58'),(360103,360100,'1|360000|360100',0,'西湖区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:33:58'),(360104,360100,'1|360000|360100',0,'青云谱区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:33:58'),(360105,360100,'1|360000|360100',0,'湾里区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:33:58'),(360111,360100,'1|360000|360100',0,'青山湖区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:33:59'),(360121,360100,'1|360000|360100',0,'南昌县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:33:59'),(360122,360100,'1|360000|360100',0,'新建县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:33:59'),(360123,360100,'1|360000|360100',0,'安义县',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:33:59'),(360124,360100,'1|360000|360100',0,'进贤县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:00'),(360125,360100,'1|360000|360100',0,'红谷滩新区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:00'),(360126,360100,'1|360000|360100',0,'经济技术开发区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:00'),(360127,360100,'1|360000|360100',0,'昌北区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:00'),(360128,360100,'1|360000|360100',0,'其它区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:00'),(360200,360000,'1|360000',1,'景德镇市',0,3,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360202,360200,'1|360000|360200',0,'昌江区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360203,360200,'1|360000|360200',0,'珠山区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360222,360200,'1|360000|360200',0,'浮梁县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360281,360200,'1|360000|360200',0,'乐平市',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360282,360200,'1|360000|360200',0,'其它区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360300,360000,'1|360000',1,'萍乡市',0,3,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360302,360300,'1|360000|360300',0,'安源区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360313,360300,'1|360000|360300',0,'湘东区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:00'),(360321,360300,'1|360000|360300',0,'莲花县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:00'),(360322,360300,'1|360000|360300',0,'上栗县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:00'),(360323,360300,'1|360000|360300',0,'芦溪县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360324,360300,'1|360000|360300',0,'其它区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360400,360000,'1|360000',1,'九江市',0,3,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360402,360400,'1|360000|360400',0,'庐山区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360403,360400,'1|360000|360400',0,'浔阳区',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360421,360400,'1|360000|360400',0,'九江县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360423,360400,'1|360000|360400',0,'武宁县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360424,360400,'1|360000|360400',0,'修水县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360425,360400,'1|360000|360400',0,'永修县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360426,360400,'1|360000|360400',0,'德安县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:01'),(360427,360400,'1|360000|360400',0,'星子县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:02'),(360428,360400,'1|360000|360400',0,'都昌县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:02'),(360429,360400,'1|360000|360400',0,'湖口县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:02'),(360430,360400,'1|360000|360400',0,'彭泽县',0,4,1,'2014-05-05 12:00:42','2014-05-05 12:34:02'),(360481,360400,'1|360000|360400',0,'瑞昌市',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:02'),(360482,360400,'1|360000|360400',0,'其它区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:02'),(360483,360400,'1|360000|360400',0,'共青城市',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:02'),(360500,360000,'1|360000',1,'新余市',0,3,1,'2014-05-05 12:02:31','2014-05-05 12:34:02'),(360502,360500,'1|360000|360500',0,'渝水区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:02'),(360521,360500,'1|360000|360500',0,'分宜县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:02'),(360522,360500,'1|360000|360500',0,'其它区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:03'),(360600,360000,'1|360000',1,'鹰潭市',0,3,1,'2014-05-05 12:02:31','2014-05-05 12:34:03'),(360602,360600,'1|360000|360600',0,'月湖区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:34:03'),(360622,360600,'1|360000|360600',0,'余江县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:34:03'),(360681,360600,'1|360000|360600',0,'贵溪市',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:03'),(360682,360600,'1|360000|360600',0,'其它区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:03'),(360700,360000,'1|360000',1,'赣州市',0,3,1,'2014-05-05 12:02:31','2014-05-05 12:34:03'),(360702,360700,'1|360000|360700',0,'章贡区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:03'),(360721,360700,'1|360000|360700',0,'赣县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360722,360700,'1|360000|360700',0,'信丰县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360723,360700,'1|360000|360700',0,'大余县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360724,360700,'1|360000|360700',0,'上犹县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360725,360700,'1|360000|360700',0,'崇义县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360726,360700,'1|360000|360700',0,'安远县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360727,360700,'1|360000|360700',0,'龙南县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360728,360700,'1|360000|360700',0,'定南县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360729,360700,'1|360000|360700',0,'全南县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360730,360700,'1|360000|360700',0,'宁都县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360731,360700,'1|360000|360700',0,'于都县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360732,360700,'1|360000|360700',0,'兴国县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:03'),(360733,360700,'1|360000|360700',0,'会昌县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:04'),(360734,360700,'1|360000|360700',0,'寻乌县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:04'),(360735,360700,'1|360000|360700',0,'石城县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:04'),(360751,360700,'1|360000|360700',0,'黄金区',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:34:04'),(360781,360700,'1|360000|360700',0,'瑞金市',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:34:04'),(360782,360700,'1|360000|360700',0,'南康市',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:34:05'),(360783,360700,'1|360000|360700',0,'其它区',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:34:05'),(360800,360000,'1|360000',1,'吉安市',0,3,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360802,360800,'1|360000|360800',0,'吉州区',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360803,360800,'1|360000|360800',0,'青原区',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360821,360800,'1|360000|360800',0,'吉安县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360822,360800,'1|360000|360800',0,'吉水县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360823,360800,'1|360000|360800',0,'峡江县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360824,360800,'1|360000|360800',0,'新干县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360825,360800,'1|360000|360800',0,'永丰县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360826,360800,'1|360000|360800',0,'泰和县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360827,360800,'1|360000|360800',0,'遂川县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:05'),(360828,360800,'1|360000|360800',0,'万安县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:06'),(360829,360800,'1|360000|360800',0,'安福县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:06'),(360830,360800,'1|360000|360800',0,'永新县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:34:06'),(360881,360800,'1|360000|360800',0,'井冈山市',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:07'),(360882,360800,'1|360000|360800',0,'其它区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:34:07'),(360900,360000,'1|360000',1,'宜春市',0,3,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360902,360900,'1|360000|360900',0,'袁州区',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360921,360900,'1|360000|360900',0,'奉新县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360922,360900,'1|360000|360900',0,'万载县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360923,360900,'1|360000|360900',0,'上高县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360924,360900,'1|360000|360900',0,'宜丰县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360925,360900,'1|360000|360900',0,'靖安县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360926,360900,'1|360000|360900',0,'铜鼓县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:34:07'),(360981,360900,'1|360000|360900',0,'丰城市',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(360982,360900,'1|360000|360900',0,'樟树市',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(360983,360900,'1|360000|360900',0,'高安市',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:34:07'),(360984,360900,'1|360000|360900',0,'其它区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(361000,360000,'1|360000',1,'抚州市',0,3,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(361002,361000,'1|360000|361000',0,'临川区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(361021,361000,'1|360000|361000',0,'南城县',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(361022,361000,'1|360000|361000',0,'黎川县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:07'),(361023,361000,'1|360000|361000',0,'南丰县',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:34:07'),(361024,361000,'1|360000|361000',0,'崇仁县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:07'),(361025,361000,'1|360000|361000',0,'乐安县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361026,361000,'1|360000|361000',0,'宜黄县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361027,361000,'1|360000|361000',0,'金溪县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361028,361000,'1|360000|361000',0,'资溪县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361029,361000,'1|360000|361000',0,'东乡县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361030,361000,'1|360000|361000',0,'广昌县',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361031,361000,'1|360000|361000',0,'其它区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:34:09'),(361100,360000,'1|360000',1,'上饶市',0,3,1,'2014-05-05 12:02:27','2014-05-05 12:34:09'),(361102,361100,'1|360000|361100',0,'信州区',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:34:09'),(361121,361100,'1|360000|361100',0,'上饶县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361122,361100,'1|360000|361100',0,'广丰县',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:34:09'),(361123,361100,'1|360000|361100',0,'玉山县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361124,361100,'1|360000|361100',0,'铅山县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361125,361100,'1|360000|361100',0,'横峰县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361126,361100,'1|360000|361100',0,'弋阳县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361127,361100,'1|360000|361100',0,'余干县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361128,361100,'1|360000|361100',0,'鄱阳县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361129,361100,'1|360000|361100',0,'万年县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361130,361100,'1|360000|361100',0,'婺源县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:34:09'),(361181,361100,'1|360000|361100',0,'德兴市',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:34:09'),(361182,361100,'1|360000|361100',0,'其它区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:34:10'),(370000,1,'1',1,'山东省',0,2,1,'2014-05-05 12:02:53','2014-05-05 12:34:10'),(370100,370000,'1|370000',1,'济南市',0,3,1,'2014-05-05 12:02:55','2014-05-05 12:34:10'),(370102,370100,'1|370000|370100',0,'历下区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:34:10'),(370103,370100,'1|370000|370100',0,'市中区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:34:10'),(370104,370100,'1|370000|370100',0,'槐荫区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:34:10'),(370105,370100,'1|370000|370100',0,'天桥区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:34:10'),(370112,370100,'1|370000|370100',0,'历城区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:10'),(370113,370100,'1|370000|370100',0,'长清区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:10'),(370124,370100,'1|370000|370100',0,'平阴县',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:10'),(370125,370100,'1|370000|370100',0,'济阳县',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:11'),(370126,370100,'1|370000|370100',0,'商河县',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:11'),(370181,370100,'1|370000|370100',0,'章丘市',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370182,370100,'1|370000|370100',0,'其它区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370200,370000,'1|370000',1,'青岛市',0,3,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370202,370200,'1|370000|370200',0,'市南区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370203,370200,'1|370000|370200',0,'市北区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370205,370200,'1|370000|370200',0,'四方区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370211,370200,'1|370000|370200',0,'黄岛区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:11'),(370212,370200,'1|370000|370200',0,'崂山区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:11'),(370213,370200,'1|370000|370200',0,'李沧区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370214,370200,'1|370000|370200',0,'城阳区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:12'),(370251,370200,'1|370000|370200',0,'开发区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370281,370200,'1|370000|370200',0,'胶州市',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370282,370200,'1|370000|370200',0,'即墨市',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370283,370200,'1|370000|370200',0,'平度市',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370284,370200,'1|370000|370200',0,'胶南市',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370285,370200,'1|370000|370200',0,'莱西市',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370286,370200,'1|370000|370200',0,'其它区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370300,370000,'1|370000',1,'淄博市',0,3,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370302,370300,'1|370000|370300',0,'淄川区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370303,370300,'1|370000|370300',0,'张店区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:12'),(370304,370300,'1|370000|370300',0,'博山区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370305,370300,'1|370000|370300',0,'临淄区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370306,370300,'1|370000|370300',0,'周村区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370321,370300,'1|370000|370300',0,'桓台县',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370322,370300,'1|370000|370300',0,'高青县',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370323,370300,'1|370000|370300',0,'沂源县',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370324,370300,'1|370000|370300',0,'其它区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:12'),(370400,370000,'1|370000',1,'枣庄市',0,3,1,'2014-05-05 12:03:00','2014-05-05 12:34:12'),(370402,370400,'1|370000|370400',0,'市中区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:13'),(370403,370400,'1|370000|370400',0,'薛城区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:13'),(370404,370400,'1|370000|370400',0,'峄城区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:14'),(370405,370400,'1|370000|370400',0,'台儿庄区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:14'),(370406,370400,'1|370000|370400',0,'山亭区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:34:14'),(370481,370400,'1|370000|370400',0,'滕州市',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:34:14'),(370482,370400,'1|370000|370400',0,'其它区',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:34:14'),(370500,370000,'1|370000',1,'东营市',0,3,1,'2014-05-05 12:02:56','2014-05-05 12:34:14'),(370502,370500,'1|370000|370500',0,'东营区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:34:14'),(370503,370500,'1|370000|370500',0,'河口区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:34:14'),(370521,370500,'1|370000|370500',0,'垦利县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:34:14'),(370522,370500,'1|370000|370500',0,'利津县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:34:14'),(370523,370500,'1|370000|370500',0,'广饶县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:34:14'),(370589,370500,'1|370000|370500',0,'西城区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:14'),(370590,370500,'1|370000|370500',0,'东城区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:14'),(370591,370500,'1|370000|370500',0,'其它区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:34:14'),(370600,370000,'1|370000',1,'烟台市',0,3,1,'2014-05-05 12:02:58','2014-05-05 12:34:14'),(370602,370600,'1|370000|370600',0,'芝罘区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:14'),(370611,370600,'1|370000|370600',0,'福山区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:14'),(370612,370600,'1|370000|370600',0,'牟平区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:14'),(370613,370600,'1|370000|370600',0,'莱山区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370634,370600,'1|370000|370600',0,'长岛县',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370681,370600,'1|370000|370600',0,'龙口市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370682,370600,'1|370000|370600',0,'莱阳市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370683,370600,'1|370000|370600',0,'莱州市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370684,370600,'1|370000|370600',0,'蓬莱市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370685,370600,'1|370000|370600',0,'招远市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370686,370600,'1|370000|370600',0,'栖霞市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:34:15'),(370687,370600,'1|370000|370600',0,'海阳市',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:34:15'),(370688,370600,'1|370000|370600',0,'其它区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370700,370000,'1|370000',1,'潍坊市',0,3,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370702,370700,'1|370000|370700',0,'潍城区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370703,370700,'1|370000|370700',0,'寒亭区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370704,370700,'1|370000|370700',0,'坊子区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370705,370700,'1|370000|370700',0,'奎文区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370724,370700,'1|370000|370700',0,'临朐县',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370725,370700,'1|370000|370700',0,'昌乐县',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370751,370700,'1|370000|370700',0,'开发区',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370781,370700,'1|370000|370700',0,'青州市',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370782,370700,'1|370000|370700',0,'诸城市',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:16'),(370783,370700,'1|370000|370700',0,'寿光市',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:18'),(370784,370700,'1|370000|370700',0,'安丘市',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370785,370700,'1|370000|370700',0,'高密市',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370786,370700,'1|370000|370700',0,'昌邑市',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370787,370700,'1|370000|370700',0,'其它区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370800,370000,'1|370000',1,'济宁市',0,3,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370802,370800,'1|370000|370800',0,'市中区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370811,370800,'1|370000|370800',0,'任城区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:18'),(370826,370800,'1|370000|370800',0,'微山县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370827,370800,'1|370000|370800',0,'鱼台县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370828,370800,'1|370000|370800',0,'金乡县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370829,370800,'1|370000|370800',0,'嘉祥县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370830,370800,'1|370000|370800',0,'汶上县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370831,370800,'1|370000|370800',0,'泗水县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370832,370800,'1|370000|370800',0,'梁山县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370881,370800,'1|370000|370800',0,'曲阜市',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370882,370800,'1|370000|370800',0,'兖州市',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370883,370800,'1|370000|370800',0,'邹城市',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370884,370800,'1|370000|370800',0,'其它区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370900,370000,'1|370000',1,'泰安市',0,3,1,'2014-05-05 12:03:02','2014-05-05 12:34:18'),(370902,370900,'1|370000|370900',0,'泰山区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:19'),(370903,370900,'1|370000|370900',0,'岱岳区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:19'),(370921,370900,'1|370000|370900',0,'宁阳县',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:19'),(370923,370900,'1|370000|370900',0,'东平县',0,4,1,'2014-05-05 12:03:03','2014-05-05 12:34:19'),(370982,370900,'1|370000|370900',0,'新泰市',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:20'),(370983,370900,'1|370000|370900',0,'肥城市',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:20'),(370984,370900,'1|370000|370900',0,'其它区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:20'),(371000,370000,'1|370000',1,'威海市',0,3,1,'2014-05-05 12:03:02','2014-05-05 12:34:20'),(371002,371000,'1|370000|371000',0,'环翠区',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:20'),(371081,371000,'1|370000|371000',0,'文登市',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371082,371000,'1|370000|371000',0,'荣成市',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371083,371000,'1|370000|371000',0,'乳山市',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371084,371000,'1|370000|371000',0,'其它区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371100,370000,'1|370000',1,'日照市',0,3,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371102,371100,'1|370000|371100',0,'东港区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371103,371100,'1|370000|371100',0,'岚山区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371121,371100,'1|370000|371100',0,'五莲县',0,4,1,'2014-05-05 12:03:02','2014-05-05 12:34:20'),(371122,371100,'1|370000|371100',0,'莒县',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371123,371100,'1|370000|371100',0,'其它区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:34:20'),(371200,370000,'1|370000',1,'莱芜市',0,3,1,'2014-05-05 12:03:06','2014-05-05 12:34:20'),(371202,371200,'1|370000|371200',0,'莱城区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371203,371200,'1|370000|371200',0,'钢城区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371204,371200,'1|370000|371200',0,'其它区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371300,370000,'1|370000',1,'临沂市',0,3,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371302,371300,'1|370000|371300',0,'兰山区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371311,371300,'1|370000|371300',0,'罗庄区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371312,371300,'1|370000|371300',0,'河东区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371321,371300,'1|370000|371300',0,'沂南县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371322,371300,'1|370000|371300',0,'郯城县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371323,371300,'1|370000|371300',0,'沂水县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371324,371300,'1|370000|371300',0,'苍山县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371325,371300,'1|370000|371300',0,'费县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:21'),(371326,371300,'1|370000|371300',0,'平邑县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:22'),(371327,371300,'1|370000|371300',0,'莒南县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:22'),(371328,371300,'1|370000|371300',0,'蒙阴县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:22'),(371329,371300,'1|370000|371300',0,'临沭县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:22'),(371330,371300,'1|370000|371300',0,'其它区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:22'),(371400,370000,'1|370000',1,'德州市',0,3,1,'2014-05-05 12:03:05','2014-05-05 12:34:22'),(371402,371400,'1|370000|371400',0,'德城区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:22'),(371421,371400,'1|370000|371400',0,'陵县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:34:22'),(371422,371400,'1|370000|371400',0,'宁津县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371423,371400,'1|370000|371400',0,'庆云县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371424,371400,'1|370000|371400',0,'临邑县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371425,371400,'1|370000|371400',0,'齐河县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371426,371400,'1|370000|371400',0,'平原县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371427,371400,'1|370000|371400',0,'夏津县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371428,371400,'1|370000|371400',0,'武城县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371451,371400,'1|370000|371400',0,'开发区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371481,371400,'1|370000|371400',0,'乐陵市',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371482,371400,'1|370000|371400',0,'禹城市',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371483,371400,'1|370000|371400',0,'其它区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371500,370000,'1|370000',1,'聊城市',0,3,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371502,371500,'1|370000|371500',0,'东昌府区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371521,371500,'1|370000|371500',0,'阳谷县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371522,371500,'1|370000|371500',0,'莘县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371523,371500,'1|370000|371500',0,'茌平县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371524,371500,'1|370000|371500',0,'东阿县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371525,371500,'1|370000|371500',0,'冠县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371526,371500,'1|370000|371500',0,'高唐县',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:23'),(371581,371500,'1|370000|371500',0,'临清市',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:24'),(371582,371500,'1|370000|371500',0,'其它区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:25'),(371600,370000,'1|370000',1,'滨州市',0,3,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371602,371600,'1|370000|371600',0,'滨城区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371621,371600,'1|370000|371600',0,'惠民县',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371622,371600,'1|370000|371600',0,'阳信县',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371623,371600,'1|370000|371600',0,'无棣县',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371624,371600,'1|370000|371600',0,'沾化县',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371625,371600,'1|370000|371600',0,'博兴县',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371626,371600,'1|370000|371600',0,'邹平县',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371627,371600,'1|370000|371600',0,'其它区',0,4,1,'2014-05-05 12:03:04','2014-05-05 12:34:25'),(371700,370000,'1|370000',1,'菏泽市',0,3,1,'2014-05-05 12:03:05','2014-05-05 12:34:25'),(371702,371700,'1|370000|371700',0,'牡丹区',0,4,1,'2014-05-05 12:03:05','2014-05-05 12:34:25'),(371721,371700,'1|370000|371700',0,'曹县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371722,371700,'1|370000|371700',0,'单县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371723,371700,'1|370000|371700',0,'成武县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371724,371700,'1|370000|371700',0,'巨野县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371725,371700,'1|370000|371700',0,'郓城县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371726,371700,'1|370000|371700',0,'鄄城县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371727,371700,'1|370000|371700',0,'定陶县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:25'),(371728,371700,'1|370000|371700',0,'东明县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:26'),(371729,371700,'1|370000|371700',0,'其它区',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:34:27'),(410000,1,'1',1,'河南省',0,2,1,'2014-05-05 12:00:43','2014-05-05 12:34:27'),(410100,410000,'1|410000',1,'郑州市',0,3,1,'2014-05-05 12:00:43','2014-05-05 12:34:27'),(410102,410100,'1|410000|410100',0,'中原区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:27'),(410103,410100,'1|410000|410100',0,'二七区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:27'),(410104,410100,'1|410000|410100',0,'管城回族区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:27'),(410105,410100,'1|410000|410100',0,'金水区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:28'),(410106,410100,'1|410000|410100',0,'上街区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:28'),(410108,410100,'1|410000|410100',0,'惠济区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:28'),(410122,410100,'1|410000|410100',0,'中牟县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:28'),(410181,410100,'1|410000|410100',0,'巩义市',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:28'),(410182,410100,'1|410000|410100',0,'荥阳市',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:28'),(410183,410100,'1|410000|410100',0,'新密市',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:28'),(410184,410100,'1|410000|410100',0,'新郑市',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:28'),(410185,410100,'1|410000|410100',0,'登封市',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:28'),(410186,410100,'1|410000|410100',0,'郑东新区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:28'),(410187,410100,'1|410000|410100',0,'高新区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:29'),(410188,410100,'1|410000|410100',0,'其它区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:29'),(410200,410000,'1|410000',1,'开封市',0,3,1,'2014-05-05 12:00:44','2014-05-05 12:34:29'),(410202,410200,'1|410000|410200',0,'龙亭区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:29'),(410203,410200,'1|410000|410200',0,'顺河回族区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410204,410200,'1|410000|410200',0,'鼓楼区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410205,410200,'1|410000|410200',0,'禹王台区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410211,410200,'1|410000|410200',0,'金明区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410221,410200,'1|410000|410200',0,'杞县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410222,410200,'1|410000|410200',0,'通许县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410223,410200,'1|410000|410200',0,'尉氏县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410224,410200,'1|410000|410200',0,'开封县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410225,410200,'1|410000|410200',0,'兰考县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410226,410200,'1|410000|410200',0,'其它区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:30'),(410300,410000,'1|410000',1,'洛阳市',0,3,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410302,410300,'1|410000|410300',0,'老城区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410303,410300,'1|410000|410300',0,'西工区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410304,410300,'1|410000|410300',0,'瀍河回族区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410305,410300,'1|410000|410300',0,'涧西区',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410306,410300,'1|410000|410300',0,'吉利区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:30'),(410307,410300,'1|410000|410300',0,'洛龙区',0,4,1,'2014-05-05 12:00:43','2014-05-05 12:34:30'),(410322,410300,'1|410000|410300',0,'孟津县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410323,410300,'1|410000|410300',0,'新安县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410324,410300,'1|410000|410300',0,'栾川县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:30'),(410325,410300,'1|410000|410300',0,'嵩县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:31'),(410326,410300,'1|410000|410300',0,'汝阳县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:32'),(410327,410300,'1|410000|410300',0,'宜阳县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:32'),(410328,410300,'1|410000|410300',0,'洛宁县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:32'),(410329,410300,'1|410000|410300',0,'伊川县',0,4,1,'2014-05-05 12:00:44','2014-05-05 12:34:32'),(410381,410300,'1|410000|410300',0,'偃师市',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410400,410000,'1|410000',1,'平顶山市',0,3,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410402,410400,'1|410000|410400',0,'新华区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410403,410400,'1|410000|410400',0,'卫东区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410404,410400,'1|410000|410400',0,'石龙区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410411,410400,'1|410000|410400',0,'湛河区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410421,410400,'1|410000|410400',0,'宝丰县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410422,410400,'1|410000|410400',0,'叶县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410423,410400,'1|410000|410400',0,'鲁山县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410425,410400,'1|410000|410400',0,'郏县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:32'),(410481,410400,'1|410000|410400',0,'舞钢市',0,4,1,'2014-05-05 12:00:46','2014-05-05 12:34:32'),(410482,410400,'1|410000|410400',0,'汝州市',0,4,1,'2014-05-05 12:00:46','2014-05-05 12:34:32'),(410483,410400,'1|410000|410400',0,'其它区',0,4,1,'2014-05-05 12:00:46','2014-05-05 12:34:32'),(410500,410000,'1|410000',1,'安阳市',0,3,1,'2014-05-05 12:00:46','2014-05-05 12:34:32'),(410502,410500,'1|410000|410500',0,'文峰区',0,4,1,'2014-05-05 12:00:46','2014-05-05 12:34:32'),(410503,410500,'1|410000|410500',0,'北关区',0,4,1,'2014-05-05 12:00:46','2014-05-05 12:34:33'),(410505,410500,'1|410000|410500',0,'殷都区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:33'),(410506,410500,'1|410000|410500',0,'龙安区',0,4,1,'2014-05-05 12:00:46','2014-05-05 12:34:33'),(410522,410500,'1|410000|410500',0,'安阳县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:33'),(410523,410500,'1|410000|410500',0,'汤阴县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:33'),(410526,410500,'1|410000|410500',0,'滑县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:33'),(410527,410500,'1|410000|410500',0,'内黄县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:33'),(410581,410500,'1|410000|410500',0,'林州市',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:33'),(410582,410500,'1|410000|410500',0,'其它区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410600,410000,'1|410000',1,'鹤壁市',0,3,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410602,410600,'1|410000|410600',0,'鹤山区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410603,410600,'1|410000|410600',0,'山城区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410611,410600,'1|410000|410600',0,'淇滨区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410621,410600,'1|410000|410600',0,'浚县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410622,410600,'1|410000|410600',0,'淇县',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410623,410600,'1|410000|410600',0,'其它区',0,4,1,'2014-05-05 12:00:45','2014-05-05 12:34:34'),(410700,410000,'1|410000',1,'新乡市',0,3,1,'2014-05-05 12:00:49','2014-05-05 12:34:34'),(410702,410700,'1|410000|410700',0,'红旗区',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:34'),(410703,410700,'1|410000|410700',0,'卫滨区',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:34'),(410704,410700,'1|410000|410700',0,'凤泉区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:34'),(410711,410700,'1|410000|410700',0,'牧野区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:35'),(410721,410700,'1|410000|410700',0,'新乡县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410724,410700,'1|410000|410700',0,'获嘉县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410725,410700,'1|410000|410700',0,'原阳县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410726,410700,'1|410000|410700',0,'延津县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410727,410700,'1|410000|410700',0,'封丘县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410728,410700,'1|410000|410700',0,'长垣县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410781,410700,'1|410000|410700',0,'卫辉市',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410782,410700,'1|410000|410700',0,'辉县市',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:35'),(410783,410700,'1|410000|410700',0,'其它区',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:35'),(410800,410000,'1|410000',1,'焦作市',0,3,1,'2014-05-05 12:00:47','2014-05-05 12:34:35'),(410802,410800,'1|410000|410800',0,'解放区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:35'),(410803,410800,'1|410000|410800',0,'中站区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:35'),(410804,410800,'1|410000|410800',0,'马村区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:35'),(410811,410800,'1|410000|410800',0,'山阳区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:34:35'),(410821,410800,'1|410000|410800',0,'修武县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:36'),(410822,410800,'1|410000|410800',0,'博爱县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:36'),(410823,410800,'1|410000|410800',0,'武陟县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:36'),(410825,410800,'1|410000|410800',0,'温县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:34:36'),(410881,410000,'1|1|410000',0,'济源市',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:36'),(410882,410800,'1|410000|410800',0,'沁阳市',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410883,410800,'1|410000|410800',0,'孟州市',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410884,410800,'1|410000|410800',0,'其它区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410900,410000,'1|410000',1,'濮阳市',0,3,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410902,410900,'1|410000|410900',0,'华龙区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410922,410900,'1|410000|410900',0,'清丰县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410923,410900,'1|410000|410900',0,'南乐县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410926,410900,'1|410000|410900',0,'范县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410927,410900,'1|410000|410900',0,'台前县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410928,410900,'1|410000|410900',0,'濮阳县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(410929,410900,'1|410000|410900',0,'其它区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411000,410000,'1|410000',1,'许昌市',0,3,1,'2014-05-05 12:00:50','2014-05-05 12:34:37'),(411002,411000,'1|410000|411000',0,'魏都区',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:37'),(411023,411000,'1|410000|411000',0,'许昌县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411024,411000,'1|410000|411000',0,'鄢陵县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411025,411000,'1|410000|411000',0,'襄城县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411081,411000,'1|410000|411000',0,'禹州市',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411082,411000,'1|410000|411000',0,'长葛市',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411083,411000,'1|410000|411000',0,'其它区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411100,410000,'1|410000',1,'漯河市',0,3,1,'2014-05-05 12:00:49','2014-05-05 12:34:37'),(411102,411100,'1|410000|411100',0,'源汇区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:39'),(411103,411100,'1|410000|411100',0,'郾城区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:39'),(411104,411100,'1|410000|411100',0,'召陵区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:39'),(411121,411100,'1|410000|411100',0,'舞阳县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:39'),(411122,411100,'1|410000|411100',0,'临颍县',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:39'),(411123,411100,'1|410000|411100',0,'其它区',0,4,1,'2014-05-05 12:00:49','2014-05-05 12:34:39'),(411200,410000,'1|410000',1,'三门峡市',0,3,1,'2014-05-05 12:00:51','2014-05-05 12:34:39'),(411202,411200,'1|410000|411200',0,'湖滨区',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:39'),(411221,411200,'1|410000|411200',0,'渑池县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:39'),(411222,411200,'1|410000|411200',0,'陕县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:39'),(411224,411200,'1|410000|411200',0,'卢氏县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:39'),(411281,411200,'1|410000|411200',0,'义马市',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411282,411200,'1|410000|411200',0,'灵宝市',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411283,411200,'1|410000|411200',0,'其它区',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411300,410000,'1|410000',1,'南阳市',0,3,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411302,411300,'1|410000|411300',0,'宛城区',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411303,411300,'1|410000|411300',0,'卧龙区',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411321,411300,'1|410000|411300',0,'南召县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411322,411300,'1|410000|411300',0,'方城县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411323,411300,'1|410000|411300',0,'西峡县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:39'),(411324,411300,'1|410000|411300',0,'镇平县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:40'),(411325,411300,'1|410000|411300',0,'内乡县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:40'),(411326,411300,'1|410000|411300',0,'淅川县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:40'),(411327,411300,'1|410000|411300',0,'社旗县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:40'),(411328,411300,'1|410000|411300',0,'唐河县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:40'),(411329,411300,'1|410000|411300',0,'新野县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:40'),(411330,411300,'1|410000|411300',0,'桐柏县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:34:41'),(411381,411300,'1|410000|411300',0,'邓州市',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:41'),(411382,411300,'1|410000|411300',0,'其它区',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:41'),(411400,410000,'1|410000',1,'商丘市',0,3,1,'2014-05-05 12:00:52','2014-05-05 12:34:41'),(411402,411400,'1|410000|411400',0,'梁园区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411403,411400,'1|410000|411400',0,'睢阳区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411421,411400,'1|410000|411400',0,'民权县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:41'),(411422,411400,'1|410000|411400',0,'睢县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:41'),(411423,411400,'1|410000|411400',0,'宁陵县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:41'),(411424,411400,'1|410000|411400',0,'柘城县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411425,411400,'1|410000|411400',0,'虞城县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411426,411400,'1|410000|411400',0,'夏邑县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411481,411400,'1|410000|411400',0,'永城市',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411482,411400,'1|410000|411400',0,'其它区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:41'),(411500,410000,'1|410000',1,'信阳市',0,3,1,'2014-05-05 12:00:53','2014-05-05 12:34:42'),(411502,411500,'1|410000|411500',0,'浉河区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:42'),(411503,411500,'1|410000|411500',0,'平桥区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:34:42'),(411521,411500,'1|410000|411500',0,'罗山县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:42'),(411522,411500,'1|410000|411500',0,'光山县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:42'),(411523,411500,'1|410000|411500',0,'新县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:42'),(411524,411500,'1|410000|411500',0,'商城县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:42'),(411525,411500,'1|410000|411500',0,'固始县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:42'),(411526,411500,'1|410000|411500',0,'潢川县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:42'),(411527,411500,'1|410000|411500',0,'淮滨县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:34:42'),(411528,411500,'1|410000|411500',0,'息县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411529,411500,'1|410000|411500',0,'其它区',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411600,410000,'1|410000',1,'周口市',0,3,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411602,411600,'1|410000|411600',0,'川汇区',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411621,411600,'1|410000|411600',0,'扶沟县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411622,411600,'1|410000|411600',0,'西华县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411623,411600,'1|410000|411600',0,'商水县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411624,411600,'1|410000|411600',0,'沈丘县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411625,411600,'1|410000|411600',0,'郸城县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411626,411600,'1|410000|411600',0,'淮阳县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:43'),(411627,411600,'1|410000|411600',0,'太康县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:44'),(411628,411600,'1|410000|411600',0,'鹿邑县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:34:44'),(411681,411600,'1|410000|411600',0,'项城市',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411682,411600,'1|410000|411600',0,'其它区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411700,410000,'1|410000',1,'驻马店市',0,3,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411702,411700,'1|410000|411700',0,'驿城区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411721,411700,'1|410000|411700',0,'西平县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411722,411700,'1|410000|411700',0,'上蔡县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411723,411700,'1|410000|411700',0,'平舆县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411724,411700,'1|410000|411700',0,'正阳县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411725,411700,'1|410000|411700',0,'确山县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:44'),(411726,411700,'1|410000|411700',0,'泌阳县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:45'),(411727,411700,'1|410000|411700',0,'汝南县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:45'),(411728,411700,'1|410000|411700',0,'遂平县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:45'),(411729,411700,'1|410000|411700',0,'新蔡县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:45'),(411730,411700,'1|410000|411700',0,'其它区',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:45'),(420000,1,'1',1,'湖北省',0,2,1,'2014-05-05 12:00:20','2014-05-05 12:34:45'),(420100,420000,'1|420000',1,'武汉市',0,3,1,'2014-05-05 12:00:22','2014-05-05 12:34:45'),(420102,420100,'1|420000|420100',0,'江岸区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:34:45'),(420103,420100,'1|420000|420100',0,'江汉区',0,4,1,'2014-05-05 12:00:21','2014-05-05 12:34:45'),(420104,420100,'1|420000|420100',0,'硚口区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420105,420100,'1|420000|420100',0,'汉阳区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420106,420100,'1|420000|420100',0,'武昌区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420107,420100,'1|420000|420100',0,'青山区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420111,420100,'1|420000|420100',0,'洪山区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420112,420100,'1|420000|420100',0,'东西湖区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420113,420100,'1|420000|420100',0,'汉南区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420114,420100,'1|420000|420100',0,'蔡甸区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420115,420100,'1|420000|420100',0,'江夏区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420116,420100,'1|420000|420100',0,'黄陂区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420117,420100,'1|420000|420100',0,'新洲区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420118,420100,'1|420000|420100',0,'其它区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420200,420000,'1|420000',1,'黄石市',0,3,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420202,420200,'1|420000|420200',0,'黄石港区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420203,420200,'1|420000|420200',0,'西塞山区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420204,420200,'1|420000|420200',0,'下陆区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420205,420200,'1|420000|420200',0,'铁山区',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420222,420200,'1|420000|420200',0,'阳新县',0,4,1,'2014-05-05 12:00:22','2014-05-05 12:34:46'),(420281,420200,'1|420000|420200',0,'大冶市',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:34:46'),(420282,420200,'1|420000|420200',0,'其它区',0,4,1,'2014-05-05 12:00:23','2014-05-05 12:34:47'),(420300,420000,'1|420000',1,'十堰市',0,3,1,'2014-05-05 12:00:26','2014-05-05 12:34:48'),(420302,420300,'1|420000|420300',0,'茅箭区',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:34:48'),(420303,420300,'1|420000|420300',0,'张湾区',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:34:48'),(420321,420300,'1|420000|420300',0,'郧县',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:34:48'),(420322,420300,'1|420000|420300',0,'郧西县',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:34:48'),(420323,420300,'1|420000|420300',0,'竹山县',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:34:48'),(420324,420300,'1|420000|420300',0,'竹溪县',0,4,1,'2014-05-05 12:00:25','2014-05-05 12:34:48'),(420325,420300,'1|420000|420300',0,'房县',0,4,1,'2014-05-05 12:00:24','2014-05-05 12:34:49'),(420381,420300,'1|420000|420300',0,'丹江口市',0,4,1,'2014-05-05 12:00:03','2014-05-05 12:34:49'),(420382,420300,'1|420000|420300',0,'城区',0,4,1,'2014-05-05 12:00:03','2014-05-05 12:34:49'),(420383,420300,'1|420000|420300',0,'其它区',0,4,1,'2014-05-05 12:00:03','2014-05-05 12:34:49'),(420500,420000,'1|420000',1,'宜昌市',0,3,1,'2014-05-05 12:00:10','2014-05-05 12:34:49'),(420502,420500,'1|420000|420500',0,'西陵区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:34:49'),(420503,420500,'1|420000|420500',0,'伍家岗区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:34:49'),(420504,420500,'1|420000|420500',0,'点军区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:34:49'),(420505,420500,'1|420000|420500',0,'猇亭区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:34:49'),(420506,420500,'1|420000|420500',0,'夷陵区',0,4,1,'2014-05-05 12:00:10','2014-05-05 12:34:49'),(420525,420500,'1|420000|420500',0,'远安县',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:34:49'),(420526,420500,'1|420000|420500',0,'兴山县',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:34:49'),(420527,420500,'1|420000|420500',0,'秭归县',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:34:49'),(420528,420500,'1|420000|420500',0,'长阳土家族自治县',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:34:51'),(420529,420500,'1|420000|420500',0,'五峰土家族自治县',0,4,1,'2014-05-05 12:00:12','2014-05-05 12:34:51'),(420551,420500,'1|420000|420500',0,'葛洲坝区',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:34:51'),(420552,420500,'1|420000|420500',0,'开发区',0,4,1,'2014-05-05 12:00:14','2014-05-05 12:34:51'),(420581,420500,'1|420000|420500',0,'宜都市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420582,420500,'1|420000|420500',0,'当阳市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420583,420500,'1|420000|420500',0,'枝江市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420584,420500,'1|420000|420500',0,'其它区',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420600,420000,'1|420000',1,'襄阳市',0,3,1,'2014-05-05 12:00:15','2014-05-05 12:34:51'),(420602,420600,'1|420000|420600',0,'襄城区',0,4,1,'2014-05-05 12:00:15','2014-05-05 12:34:51'),(420606,420600,'1|420000|420600',0,'樊城区',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:34:51'),(420607,420600,'1|420000|420600',0,'襄州区',0,4,1,'2014-05-05 12:00:16','2014-05-05 12:34:51'),(420624,420600,'1|420000|420600',0,'南漳县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420625,420600,'1|420000|420600',0,'谷城县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420626,420600,'1|420000|420600',0,'保康县',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420682,420600,'1|420000|420600',0,'老河口市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420683,420600,'1|420000|420600',0,'枣阳市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420684,420600,'1|420000|420600',0,'宜城市',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420685,420600,'1|420000|420600',0,'其它区',0,4,1,'2014-05-05 12:00:17','2014-05-05 12:34:51'),(420700,420000,'1|420000',1,'鄂州市',0,3,1,'2014-05-05 12:00:18','2014-05-05 12:34:51'),(420702,420700,'1|420000|420700',0,'梁子湖区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:34:52'),(420703,420700,'1|420000|420700',0,'华容区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:34:52'),(420704,420700,'1|420000|420700',0,'鄂城区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:34:52'),(420705,420700,'1|420000|420700',0,'其它区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:34:53'),(420800,420000,'1|420000',1,'荆门市',0,3,1,'2014-05-05 12:00:18','2014-05-05 12:34:53'),(420802,420800,'1|420000|420800',0,'东宝区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:34:53'),(420804,420800,'1|420000|420800',0,'掇刀区',0,4,1,'2014-05-05 12:00:18','2014-05-05 12:34:53'),(420821,420800,'1|420000|420800',0,'京山县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:34:53'),(420822,420800,'1|420000|420800',0,'沙洋县',0,4,1,'2014-05-05 12:00:19','2014-05-05 12:34:53'),(420881,420800,'1|420000|420800',0,'钟祥市',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420882,420800,'1|420000|420800',0,'其它区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420900,420000,'1|420000',1,'孝感市',0,3,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420902,420900,'1|420000|420900',0,'孝南区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420921,420900,'1|420000|420900',0,'孝昌县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420922,420900,'1|420000|420900',0,'大悟县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420923,420900,'1|420000|420900',0,'云梦县',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420981,420900,'1|420000|420900',0,'应城市',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420982,420900,'1|420000|420900',0,'安陆市',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420984,420900,'1|420000|420900',0,'汉川市',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:53'),(420985,420900,'1|420000|420900',0,'其它区',0,4,1,'2014-05-05 12:00:32','2014-05-05 12:34:53'),(421000,420000,'1|420000',1,'荆州市',0,3,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421002,421000,'1|420000|421000',0,'沙市区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421003,421000,'1|420000|421000',0,'荆州区',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421022,421000,'1|420000|421000',0,'公安县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421023,421000,'1|420000|421000',0,'监利县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421024,421000,'1|420000|421000',0,'江陵县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421081,421000,'1|420000|421000',0,'石首市',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421083,421000,'1|420000|421000',0,'洪湖市',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:54'),(421087,421000,'1|420000|421000',0,'松滋市',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:55'),(421088,421000,'1|420000|421000',0,'其它区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:55'),(421100,420000,'1|420000',1,'黄冈市',0,3,1,'2014-05-05 12:00:33','2014-05-05 12:34:55'),(421102,421100,'1|420000|421100',0,'黄州区',0,4,1,'2014-05-05 12:00:33','2014-05-05 12:34:55'),(421121,421100,'1|420000|421100',0,'团风县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421122,421100,'1|420000|421100',0,'红安县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421123,421100,'1|420000|421100',0,'罗田县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421124,421100,'1|420000|421100',0,'英山县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421125,421100,'1|420000|421100',0,'浠水县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421126,421100,'1|420000|421100',0,'蕲春县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421127,421100,'1|420000|421100',0,'黄梅县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421181,421100,'1|420000|421100',0,'麻城市',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:55'),(421182,421100,'1|420000|421100',0,'武穴市',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:56'),(421183,421100,'1|420000|421100',0,'其它区',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:56'),(421200,420000,'1|420000',1,'咸宁市',0,3,1,'2014-05-05 12:00:36','2014-05-05 12:34:56'),(421202,421200,'1|420000|421200',0,'咸安区',0,4,1,'2014-05-05 12:00:35','2014-05-05 12:34:56'),(421221,421200,'1|420000|421200',0,'嘉鱼县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:56'),(421222,421200,'1|420000|421200',0,'通城县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:56'),(421223,421200,'1|420000|421200',0,'崇阳县',0,4,1,'2014-05-05 12:00:35','2014-05-05 12:34:56'),(421224,421200,'1|420000|421200',0,'通山县',0,4,1,'2014-05-05 12:00:34','2014-05-05 12:34:56'),(421281,421200,'1|420000|421200',0,'赤壁市',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:34:56'),(421282,421200,'1|420000|421200',0,'温泉城区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:34:56'),(421283,421200,'1|420000|421200',0,'其它区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:34:56'),(421300,420000,'1|420000',1,'随州市',0,3,1,'2014-05-05 12:00:37','2014-05-05 12:34:56'),(421302,421300,'1|420000|421300',0,'曾都区',0,4,1,'2014-05-05 12:00:37','2014-05-05 12:34:56'),(421321,421300,'1|420000|421300',0,'随县',0,4,1,'2014-05-05 12:00:36','2014-05-05 12:34:56'),(421381,421300,'1|420000|421300',0,'广水市',0,4,1,'2014-05-05 12:00:28','2014-05-05 12:34:57'),(421382,421300,'1|420000|421300',0,'其它区',0,4,1,'2014-05-05 12:00:28','2014-05-05 12:34:57'),(422800,420000,'1|420000',1,'恩施土家族苗族自治州',0,3,1,'2014-05-05 12:00:41','2014-05-05 12:34:57'),(422801,422800,'1|420000|422800',0,'恩施市',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:57'),(422802,422800,'1|420000|422800',0,'利川市',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:57'),(422822,422800,'1|420000|422800',0,'建始县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:57'),(422823,422800,'1|420000|422800',0,'巴东县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:58'),(422825,422800,'1|420000|422800',0,'宣恩县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:34:58'),(422826,422800,'1|420000|422800',0,'咸丰县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:34:58'),(422827,422800,'1|420000|422800',0,'来凤县',0,4,1,'2014-05-05 12:00:41','2014-05-05 12:34:58'),(422828,422800,'1|420000|422800',0,'鹤峰县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:34:58'),(422829,422800,'1|420000|422800',0,'其它区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:34:58'),(429004,420000,'1|1|420000',0,'仙桃市',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:34:58'),(429005,420000,'1|1|420000',0,'潜江市',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:34:58'),(429006,420000,'1|1|420000',0,'天门市',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:34:58'),(429021,420000,'1|1|420000',0,'神农架林区',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:34:58'),(430000,1,'1',1,'湖南省',0,2,1,'2014-05-05 12:02:51','2014-05-05 12:34:58'),(430100,430000,'1|430000',1,'长沙市',0,3,1,'2014-05-05 12:02:54','2014-05-05 12:34:58'),(430102,430100,'1|430000|430100',0,'芙蓉区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:58'),(430103,430100,'1|430000|430100',0,'天心区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:58'),(430104,430100,'1|430000|430100',0,'岳麓区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:58'),(430105,430100,'1|430000|430100',0,'开福区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:59'),(430111,430100,'1|430000|430100',0,'雨花区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:59'),(430121,430100,'1|430000|430100',0,'长沙县',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:59'),(430122,430100,'1|430000|430100',0,'望城区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:59'),(430124,430100,'1|430000|430100',0,'宁乡县',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:34:59'),(430181,430100,'1|430000|430100',0,'浏阳市',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:35:00'),(430182,430100,'1|430000|430100',0,'其它区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:35:00'),(430200,430000,'1|430000',1,'株洲市',0,3,1,'2014-05-05 12:02:53','2014-05-05 12:35:00'),(430202,430200,'1|430000|430200',0,'荷塘区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430203,430200,'1|430000|430200',0,'芦淞区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430204,430200,'1|430000|430200',0,'石峰区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430211,430200,'1|430000|430200',0,'天元区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:00'),(430221,430200,'1|430000|430200',0,'株洲县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:00'),(430223,430200,'1|430000|430200',0,'攸县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:00'),(430224,430200,'1|430000|430200',0,'茶陵县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:00'),(430225,430200,'1|430000|430200',0,'炎陵县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:00'),(430281,430200,'1|430000|430200',0,'醴陵市',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430282,430200,'1|430000|430200',0,'其它区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430300,430000,'1|430000',1,'湘潭市',0,3,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430302,430300,'1|430000|430300',0,'雨湖区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:00'),(430304,430300,'1|430000|430300',0,'岳塘区',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:01'),(430321,430300,'1|430000|430300',0,'湘潭县',0,4,1,'2014-05-05 12:02:54','2014-05-05 12:35:01'),(430381,430300,'1|430000|430300',0,'湘乡市',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:01'),(430382,430300,'1|430000|430300',0,'韶山市',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:01'),(430383,430300,'1|430000|430300',0,'其它区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:01'),(430400,430000,'1|430000',1,'衡阳市',0,3,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430405,430400,'1|430000|430400',0,'珠晖区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430406,430400,'1|430000|430400',0,'雁峰区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430407,430400,'1|430000|430400',0,'石鼓区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430408,430400,'1|430000|430400',0,'蒸湘区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430412,430400,'1|430000|430400',0,'南岳区',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430421,430400,'1|430000|430400',0,'衡阳县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430422,430400,'1|430000|430400',0,'衡南县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430423,430400,'1|430000|430400',0,'衡山县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430424,430400,'1|430000|430400',0,'衡东县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430426,430400,'1|430000|430400',0,'祁东县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:02'),(430481,430400,'1|430000|430400',0,'耒阳市',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:02'),(430482,430400,'1|430000|430400',0,'常宁市',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:02'),(430483,430400,'1|430000|430400',0,'其它区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:02'),(430500,430000,'1|430000',1,'邵阳市',0,3,1,'2014-05-05 12:02:56','2014-05-05 12:35:03'),(430502,430500,'1|430000|430500',0,'双清区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:03'),(430503,430500,'1|430000|430500',0,'大祥区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:03'),(430511,430500,'1|430000|430500',0,'北塔区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:03'),(430521,430500,'1|430000|430500',0,'邵东县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:03'),(430522,430500,'1|430000|430500',0,'新邵县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:03'),(430523,430500,'1|430000|430500',0,'邵阳县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430524,430500,'1|430000|430500',0,'隆回县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430525,430500,'1|430000|430500',0,'洞口县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430527,430500,'1|430000|430500',0,'绥宁县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430528,430500,'1|430000|430500',0,'新宁县',0,4,1,'2014-05-05 12:02:55','2014-05-05 12:35:04'),(430529,430500,'1|430000|430500',0,'城步苗族自治县',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430581,430500,'1|430000|430500',0,'武冈市',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430582,430500,'1|430000|430500',0,'其它区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430600,430000,'1|430000',1,'岳阳市',0,3,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430602,430600,'1|430000|430600',0,'岳阳楼区',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430603,430600,'1|430000|430600',0,'云溪区',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430611,430600,'1|430000|430600',0,'君山区',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430621,430600,'1|430000|430600',0,'岳阳县',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430623,430600,'1|430000|430600',0,'华容县',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430624,430600,'1|430000|430600',0,'湘阴县',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430626,430600,'1|430000|430600',0,'平江县',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:04'),(430681,430600,'1|430000|430600',0,'汨罗市',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430682,430600,'1|430000|430600',0,'临湘市',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:04'),(430683,430600,'1|430000|430600',0,'其它区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:05'),(430700,430000,'1|430000',1,'常德市',0,3,1,'2014-05-05 12:02:56','2014-05-05 12:35:05'),(430702,430700,'1|430000|430700',0,'武陵区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:06'),(430703,430700,'1|430000|430700',0,'鼎城区',0,4,1,'2014-05-05 12:02:56','2014-05-05 12:35:06'),(430721,430700,'1|430000|430700',0,'安乡县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:06'),(430722,430700,'1|430000|430700',0,'汉寿县',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:35:06'),(430723,430700,'1|430000|430700',0,'澧县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:06'),(430724,430700,'1|430000|430700',0,'临澧县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:06'),(430725,430700,'1|430000|430700',0,'桃源县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:06'),(430726,430700,'1|430000|430700',0,'石门县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:06'),(430781,430700,'1|430000|430700',0,'津市市',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:35:06'),(430782,430700,'1|430000|430700',0,'其它区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:35:06'),(430800,430000,'1|430000',1,'张家界市',0,3,1,'2014-05-05 12:02:58','2014-05-05 12:35:06'),(430802,430800,'1|430000|430800',0,'永定区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:35:06'),(430811,430800,'1|430000|430800',0,'武陵源区',0,4,1,'2014-05-05 12:02:58','2014-05-05 12:35:06'),(430821,430800,'1|430000|430800',0,'慈利县',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:06'),(430822,430800,'1|430000|430800',0,'桑植县',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:06'),(430823,430800,'1|430000|430800',0,'其它区',0,4,1,'2014-05-05 12:02:57','2014-05-05 12:35:06'),(430900,430000,'1|430000',1,'益阳市',0,3,1,'2014-05-05 12:02:59','2014-05-05 12:35:07'),(430902,430900,'1|430000|430900',0,'资阳区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:07'),(430903,430900,'1|430000|430900',0,'赫山区',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:07'),(430921,430900,'1|430000|430900',0,'南县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:07'),(430922,430900,'1|430000|430900',0,'桃江县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:08'),(430923,430900,'1|430000|430900',0,'安化县',0,4,1,'2014-05-05 12:02:59','2014-05-05 12:35:08'),(430981,430900,'1|430000|430900',0,'沅江市',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(430982,430900,'1|430000|430900',0,'其它区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(431000,430000,'1|430000',1,'郴州市',0,3,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(431002,431000,'1|430000|431000',0,'北湖区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(431003,431000,'1|430000|431000',0,'苏仙区',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(431021,431000,'1|430000|431000',0,'桂阳县',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(431022,431000,'1|430000|431000',0,'宜章县',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431023,431000,'1|430000|431000',0,'永兴县',0,4,1,'2014-05-05 12:03:01','2014-05-05 12:35:08'),(431024,431000,'1|430000|431000',0,'嘉禾县',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431025,431000,'1|430000|431000',0,'临武县',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431026,431000,'1|430000|431000',0,'汝城县',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431027,431000,'1|430000|431000',0,'桂东县',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431028,431000,'1|430000|431000',0,'安仁县',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431081,431000,'1|430000|431000',0,'资兴市',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:08'),(431082,431000,'1|430000|431000',0,'其它区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:09'),(431100,430000,'1|430000',1,'永州市',0,3,1,'2014-05-05 12:03:00','2014-05-05 12:35:09'),(431102,431100,'1|430000|431100',0,'零陵区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:09'),(431103,431100,'1|430000|431100',0,'冷水滩区',0,4,1,'2014-05-05 12:03:00','2014-05-05 12:35:09'),(431121,431100,'1|430000|431100',0,'祁阳县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431122,431100,'1|430000|431100',0,'东安县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431123,431100,'1|430000|431100',0,'双牌县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431124,431100,'1|430000|431100',0,'道县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431125,431100,'1|430000|431100',0,'江永县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431126,431100,'1|430000|431100',0,'宁远县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431127,431100,'1|430000|431100',0,'蓝山县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:10'),(431128,431100,'1|430000|431100',0,'新田县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431129,431100,'1|430000|431100',0,'江华瑶族自治县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431130,431100,'1|430000|431100',0,'其它区',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431200,430000,'1|430000',1,'怀化市',0,3,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431202,431200,'1|430000|431200',0,'鹤城区',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431221,431200,'1|430000|431200',0,'中方县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431222,431200,'1|430000|431200',0,'沅陵县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431223,431200,'1|430000|431200',0,'辰溪县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431224,431200,'1|430000|431200',0,'溆浦县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431225,431200,'1|430000|431200',0,'会同县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431226,431200,'1|430000|431200',0,'麻阳苗族自治县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431227,431200,'1|430000|431200',0,'新晃侗族自治县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431228,431200,'1|430000|431200',0,'芷江侗族自治县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:11'),(431229,431200,'1|430000|431200',0,'靖州苗族侗族自治县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:12'),(431230,431200,'1|430000|431200',0,'通道侗族自治县',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:12'),(431281,431200,'1|430000|431200',0,'洪江市',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:12'),(431282,431200,'1|430000|431200',0,'其它区',0,4,1,'2014-05-05 12:02:51','2014-05-05 12:35:12'),(431300,430000,'1|430000',1,'娄底市',0,3,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(431302,431300,'1|430000|431300',0,'娄星区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(431321,431300,'1|430000|431300',0,'双峰县',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(431322,431300,'1|430000|431300',0,'新化县',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(431381,431300,'1|430000|431300',0,'冷水江市',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(431382,431300,'1|430000|431300',0,'涟源市',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(431383,431300,'1|430000|431300',0,'其它区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:35:13'),(433100,430000,'1|430000',1,'湘西土家族苗族自治州',0,3,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433101,433100,'1|430000|433100',0,'吉首市',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433122,433100,'1|430000|433100',0,'泸溪县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433123,433100,'1|430000|433100',0,'凤凰县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433124,433100,'1|430000|433100',0,'花垣县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433125,433100,'1|430000|433100',0,'保靖县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433126,433100,'1|430000|433100',0,'古丈县',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:35:13'),(433127,433100,'1|430000|433100',0,'永顺县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433130,433100,'1|430000|433100',0,'龙山县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:13'),(433131,433100,'1|430000|433100',0,'其它区',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:35:14'),(440000,1,'1',1,'广东省',0,2,1,'2014-05-05 12:02:23','2014-05-05 12:35:14'),(440100,440000,'1|440000',1,'广州市',0,3,1,'2014-05-05 12:02:24','2014-05-05 12:35:14'),(440103,440100,'1|440000|440100',0,'荔湾区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:35:14'),(440104,440100,'1|440000|440100',0,'越秀区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:35:14'),(440105,440100,'1|440000|440100',0,'海珠区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:35:14'),(440106,440100,'1|440000|440100',0,'天河区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:35:15'),(440111,440100,'1|440000|440100',0,'白云区',0,4,1,'2014-05-05 12:02:24','2014-05-05 12:35:15'),(440112,440100,'1|440000|440100',0,'黄埔区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440113,440100,'1|440000|440100',0,'番禺区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440114,440100,'1|440000|440100',0,'花都区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440115,440100,'1|440000|440100',0,'南沙区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440116,440100,'1|440000|440100',0,'萝岗区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440183,440100,'1|440000|440100',0,'增城市',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440184,440100,'1|440000|440100',0,'从化市',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440188,440100,'1|440000|440100',0,'东山区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440189,440100,'1|440000|440100',0,'其它区',0,4,1,'2014-05-05 12:02:23','2014-05-05 12:35:15'),(440200,440000,'1|440000',1,'韶关市',0,3,1,'2014-05-05 12:02:27','2014-05-05 12:35:15'),(440203,440200,'1|440000|440200',0,'武江区',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:35:15'),(440204,440200,'1|440000|440200',0,'浈江区',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:35:15'),(440205,440200,'1|440000|440200',0,'曲江区',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:35:16'),(440222,440200,'1|440000|440200',0,'始兴县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:35:16'),(440224,440200,'1|440000|440200',0,'仁化县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:35:16'),(440229,440200,'1|440000|440200',0,'翁源县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:35:16'),(440232,440200,'1|440000|440200',0,'乳源瑶族自治县',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:16'),(440233,440200,'1|440000|440200',0,'新丰县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:35:16'),(440281,440200,'1|440000|440200',0,'乐昌市',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:16'),(440282,440200,'1|440000|440200',0,'南雄市',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:16'),(440283,440200,'1|440000|440200',0,'其它区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:16'),(440300,440000,'1|440000',1,'深圳市',0,3,1,'2014-05-05 12:02:25','2014-05-05 12:35:16'),(440303,440300,'1|440000|440300',0,'罗湖区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:16'),(440304,440300,'1|440000|440300',0,'福田区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:17'),(440305,440300,'1|440000|440300',0,'南山区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:17'),(440306,440300,'1|440000|440300',0,'宝安区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:17'),(440307,440300,'1|440000|440300',0,'龙岗区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:17'),(440308,440300,'1|440000|440300',0,'盐田区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:17'),(440309,440300,'1|440000|440300',0,'其它区',0,4,1,'2014-05-05 12:02:25','2014-05-05 12:35:17'),(440320,440300,'1|440000|440300',0,'光明新区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:17'),(440321,440300,'1|440000|440300',0,'坪山新区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:17'),(440322,440300,'1|440000|440300',0,'大鹏新区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:17'),(440323,440300,'1|440000|440300',0,'龙华新区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:18'),(440400,440000,'1|440000',1,'珠海市',0,3,1,'2014-05-05 12:02:42','2014-05-05 12:35:18'),(440402,440400,'1|440000|440400',0,'香洲区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:18'),(440403,440400,'1|440000|440400',0,'斗门区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:18'),(440404,440400,'1|440000|440400',0,'金湾区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:18'),(440486,440400,'1|440000|440400',0,'金唐区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:18'),(440487,440400,'1|440000|440400',0,'南湾区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:18'),(440488,440400,'1|440000|440400',0,'其它区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:19'),(440500,440000,'1|440000',1,'汕头市',0,3,1,'2014-05-05 12:02:41','2014-05-05 12:35:19'),(440507,440500,'1|440000|440500',0,'龙湖区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:19'),(440511,440500,'1|440000|440500',0,'金平区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:19'),(440512,440500,'1|440000|440500',0,'濠江区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:19'),(440513,440500,'1|440000|440500',0,'潮阳区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:19'),(440514,440500,'1|440000|440500',0,'潮南区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:19'),(440515,440500,'1|440000|440500',0,'澄海区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:19'),(440523,440500,'1|440000|440500',0,'南澳县',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:19'),(440524,440500,'1|440000|440500',0,'其它区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:19'),(440600,440000,'1|440000',1,'佛山市',0,3,1,'2014-05-05 12:02:43','2014-05-05 12:35:19'),(440604,440600,'1|440000|440600',0,'禅城区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:19'),(440605,440600,'1|440000|440600',0,'南海区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:19'),(440606,440600,'1|440000|440600',0,'顺德区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:20'),(440607,440600,'1|440000|440600',0,'三水区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:20'),(440608,440600,'1|440000|440600',0,'高明区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:20'),(440609,440600,'1|440000|440600',0,'其它区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:20'),(440700,440000,'1|440000',1,'江门市',0,3,1,'2014-05-05 12:02:43','2014-05-05 12:35:20'),(440703,440700,'1|440000|440700',0,'蓬江区',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:20'),(440704,440700,'1|440000|440700',0,'江海区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440705,440700,'1|440000|440700',0,'新会区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440781,440700,'1|440000|440700',0,'台山市',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440783,440700,'1|440000|440700',0,'开平市',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440784,440700,'1|440000|440700',0,'鹤山市',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440785,440700,'1|440000|440700',0,'恩平市',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440786,440700,'1|440000|440700',0,'其它区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440800,440000,'1|440000',1,'湛江市',0,3,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440802,440800,'1|440000|440800',0,'赤坎区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440803,440800,'1|440000|440800',0,'霞山区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440804,440800,'1|440000|440800',0,'坡头区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440811,440800,'1|440000|440800',0,'麻章区',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440823,440800,'1|440000|440800',0,'遂溪县',0,4,1,'2014-05-05 12:02:42','2014-05-05 12:35:21'),(440825,440800,'1|440000|440800',0,'徐闻县',0,4,1,'2014-05-05 12:02:43','2014-05-05 12:35:22'),(440881,440800,'1|440000|440800',0,'廉江市',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(440882,440800,'1|440000|440800',0,'雷州市',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:23'),(440883,440800,'1|440000|440800',0,'吴川市',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:23'),(440884,440800,'1|440000|440800',0,'其它区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(440900,440000,'1|440000',1,'茂名市',0,3,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(440902,440900,'1|440000|440900',0,'茂南区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(440903,440900,'1|440000|440900',0,'茂港区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(440923,440900,'1|440000|440900',0,'电白县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(440981,440900,'1|440000|440900',0,'高州市',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:23'),(440982,440900,'1|440000|440900',0,'化州市',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:23'),(440983,440900,'1|440000|440900',0,'信宜市',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:23'),(440984,440900,'1|440000|440900',0,'其它区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:23'),(441200,440000,'1|440000',1,'肇庆市',0,3,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(441202,441200,'1|440000|441200',0,'端州区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(441203,441200,'1|440000|441200',0,'鼎湖区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:23'),(441223,441200,'1|440000|441200',0,'广宁县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:24'),(441224,441200,'1|440000|441200',0,'怀集县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:24'),(441225,441200,'1|440000|441200',0,'封开县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:24'),(441226,441200,'1|440000|441200',0,'德庆县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:24'),(441283,441200,'1|440000|441200',0,'高要市',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:24'),(441284,441200,'1|440000|441200',0,'四会市',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441285,441200,'1|440000|441200',0,'其它区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441300,440000,'1|440000',1,'惠州市',0,3,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441302,441300,'1|440000|441300',0,'惠城区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441303,441300,'1|440000|441300',0,'惠阳区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441322,441300,'1|440000|441300',0,'博罗县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441323,441300,'1|440000|441300',0,'惠东县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441324,441300,'1|440000|441300',0,'龙门县',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441325,441300,'1|440000|441300',0,'其它区',0,4,1,'2014-05-05 12:02:41','2014-05-05 12:35:25'),(441400,440000,'1|440000',1,'梅州市',0,3,1,'2014-05-05 12:02:40','2014-05-05 12:35:25'),(441402,441400,'1|440000|441400',0,'梅江区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:25'),(441421,441400,'1|440000|441400',0,'梅县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:25'),(441422,441400,'1|440000|441400',0,'大埔县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:35:25'),(441423,441400,'1|440000|441400',0,'丰顺县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:25'),(441424,441400,'1|440000|441400',0,'五华县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:26'),(441426,441400,'1|440000|441400',0,'平远县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:26'),(441427,441400,'1|440000|441400',0,'蕉岭县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:26'),(441481,441400,'1|440000|441400',0,'兴宁市',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:26'),(441482,441400,'1|440000|441400',0,'其它区',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:35:26'),(441500,440000,'1|440000',1,'汕尾市',0,3,1,'2014-05-05 12:02:39','2014-05-05 12:35:26'),(441502,441500,'1|440000|441500',0,'城区',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:30'),(441521,441500,'1|440000|441500',0,'海丰县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:30'),(441523,441500,'1|440000|441500',0,'陆河县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:30'),(441581,441500,'1|440000|441500',0,'陆丰市',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:30'),(441582,441500,'1|440000|441500',0,'其它区',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:30'),(441600,440000,'1|440000',1,'河源市',0,3,1,'2014-05-05 12:02:40','2014-05-05 12:38:30'),(441602,441600,'1|440000|441600',0,'源城区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441621,441600,'1|440000|441600',0,'紫金县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441622,441600,'1|440000|441600',0,'龙川县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441623,441600,'1|440000|441600',0,'连平县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441624,441600,'1|440000|441600',0,'和平县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441625,441600,'1|440000|441600',0,'东源县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441626,441600,'1|440000|441600',0,'其它区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441700,440000,'1|440000',1,'阳江市',0,3,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441702,441700,'1|440000|441700',0,'江城区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441721,441700,'1|440000|441700',0,'阳西县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441723,441700,'1|440000|441700',0,'阳东县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441781,441700,'1|440000|441700',0,'阳春市',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441782,441700,'1|440000|441700',0,'其它区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441800,440000,'1|440000',1,'清远市',0,3,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441802,441800,'1|440000|441800',0,'清城区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441821,441800,'1|440000|441800',0,'佛冈县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441823,441800,'1|440000|441800',0,'阳山县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441825,441800,'1|440000|441800',0,'连山壮族瑶族自治县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441826,441800,'1|440000|441800',0,'连南瑶族自治县',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441827,441800,'1|440000|441800',0,'清新区',0,4,1,'2014-05-05 12:02:40','2014-05-05 12:38:31'),(441881,441800,'1|440000|441800',0,'英德市',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:31'),(441882,441800,'1|440000|441800',0,'连州市',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:31'),(441883,441800,'1|440000|441800',0,'其它区',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:38:31'),(441900,440000,'1|440000',1,'东莞市',0,3,1,'2014-05-05 12:02:39','2014-05-05 12:38:31'),(442000,440000,'1|440000',1,'中山市',0,3,1,'2014-05-05 12:02:39','2014-05-05 12:38:31'),(442101,440000,'1|440000',1,'东沙群岛',0,3,1,'2014-05-05 12:02:39','2014-05-05 12:38:31'),(445100,440000,'1|440000',1,'潮州市',0,3,1,'2014-05-05 12:02:01','2014-05-05 12:38:31'),(445102,445100,'1|440000|445100',0,'湘桥区',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:38:31'),(445121,445100,'1|440000|445100',0,'潮安区',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:38:31'),(445122,445100,'1|440000|445100',0,'饶平县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:38:31'),(445185,445100,'1|440000|445100',0,'枫溪区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445186,445100,'1|440000|445100',0,'其它区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445200,440000,'1|440000',1,'揭阳市',0,3,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445202,445200,'1|440000|445200',0,'榕城区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445221,445200,'1|440000|445200',0,'揭东区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445222,445200,'1|440000|445200',0,'揭西县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445224,445200,'1|440000|445200',0,'惠来县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445281,445200,'1|440000|445200',0,'普宁市',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445284,445200,'1|440000|445200',0,'东山区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445285,445200,'1|440000|445200',0,'其它区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445300,440000,'1|440000',1,'云浮市',0,3,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445302,445300,'1|440000|445300',0,'云城区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445321,445300,'1|440000|445300',0,'新兴县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445322,445300,'1|440000|445300',0,'郁南县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:38:32'),(445323,445300,'1|440000|445300',0,'云安县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:38:32'),(445381,445300,'1|440000|445300',0,'罗定市',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(445382,445300,'1|440000|445300',0,'其它区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:32'),(450000,1,'1',1,'广西壮族自治区',0,2,1,'2014-05-05 12:02:17','2014-05-05 12:38:32'),(450100,450000,'1|450000',1,'南宁市',0,3,1,'2014-05-05 12:02:17','2014-05-05 12:38:32'),(450102,450100,'1|450000|450100',0,'兴宁区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450103,450100,'1|450000|450100',0,'青秀区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450105,450100,'1|450000|450100',0,'江南区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450107,450100,'1|450000|450100',0,'西乡塘区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450108,450100,'1|450000|450100',0,'良庆区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450109,450100,'1|450000|450100',0,'邕宁区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450122,450100,'1|450000|450100',0,'武鸣县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450123,450100,'1|450000|450100',0,'隆安县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450124,450100,'1|450000|450100',0,'马山县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450125,450100,'1|450000|450100',0,'上林县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450126,450100,'1|450000|450100',0,'宾阳县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450127,450100,'1|450000|450100',0,'横县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450128,450100,'1|450000|450100',0,'其它区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:32'),(450200,450000,'1|450000',1,'柳州市',0,3,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450202,450200,'1|450000|450200',0,'城中区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450203,450200,'1|450000|450200',0,'鱼峰区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450204,450200,'1|450000|450200',0,'柳南区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450205,450200,'1|450000|450200',0,'柳北区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450221,450200,'1|450000|450200',0,'柳江县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450222,450200,'1|450000|450200',0,'柳城县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450223,450200,'1|450000|450200',0,'鹿寨县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450224,450200,'1|450000|450200',0,'融安县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:33'),(450225,450200,'1|450000|450200',0,'融水苗族自治县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:33'),(450226,450200,'1|450000|450200',0,'三江侗族自治县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:33'),(450227,450200,'1|450000|450200',0,'其它区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:33'),(450300,450000,'1|450000',1,'桂林市',0,3,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450302,450300,'1|450000|450300',0,'秀峰区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450303,450300,'1|450000|450300',0,'叠彩区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450304,450300,'1|450000|450300',0,'象山区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450305,450300,'1|450000|450300',0,'七星区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450311,450300,'1|450000|450300',0,'雁山区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450321,450300,'1|450000|450300',0,'阳朔县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450322,450300,'1|450000|450300',0,'临桂区',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450323,450300,'1|450000|450300',0,'灵川县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450324,450300,'1|450000|450300',0,'全州县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450325,450300,'1|450000|450300',0,'兴安县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450326,450300,'1|450000|450300',0,'永福县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450327,450300,'1|450000|450300',0,'灌阳县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:33'),(450328,450300,'1|450000|450300',0,'龙胜各族自治县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450329,450300,'1|450000|450300',0,'资源县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450330,450300,'1|450000|450300',0,'平乐县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450331,450300,'1|450000|450300',0,'荔浦县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450332,450300,'1|450000|450300',0,'恭城瑶族自治县',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450333,450300,'1|450000|450300',0,'其它区',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450400,450000,'1|450000',1,'梧州市',0,3,1,'2014-05-05 12:02:20','2014-05-05 12:38:33'),(450403,450400,'1|450000|450400',0,'万秀区',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:34'),(450404,450400,'1|450000|450400',0,'蝶山区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450405,450400,'1|450000|450400',0,'长洲区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450406,450400,'1|450000|450400',0,'龙圩区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450421,450400,'1|450000|450400',0,'苍梧县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450422,450400,'1|450000|450400',0,'藤县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450423,450400,'1|450000|450400',0,'蒙山县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450481,450400,'1|450000|450400',0,'岑溪市',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450482,450400,'1|450000|450400',0,'其它区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450500,450000,'1|450000',1,'北海市',0,3,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450502,450500,'1|450000|450500',0,'海城区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450503,450500,'1|450000|450500',0,'银海区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450512,450500,'1|450000|450500',0,'铁山港区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450521,450500,'1|450000|450500',0,'合浦县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450522,450500,'1|450000|450500',0,'其它区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:34'),(450600,450000,'1|450000',1,'防城港市',0,3,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450602,450600,'1|450000|450600',0,'港口区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450603,450600,'1|450000|450600',0,'防城区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450621,450600,'1|450000|450600',0,'上思县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:34'),(450681,450600,'1|450000|450600',0,'东兴市',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:34'),(450682,450600,'1|450000|450600',0,'其它区',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:34'),(450700,450000,'1|450000',1,'钦州市',0,3,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450702,450700,'1|450000|450700',0,'钦南区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450703,450700,'1|450000|450700',0,'钦北区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450721,450700,'1|450000|450700',0,'灵山县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450722,450700,'1|450000|450700',0,'浦北县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450723,450700,'1|450000|450700',0,'其它区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450800,450000,'1|450000',1,'贵港市',0,3,1,'2014-05-05 12:01:43','2014-05-05 12:38:34'),(450802,450800,'1|450000|450800',0,'港北区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450803,450800,'1|450000|450800',0,'港南区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450804,450800,'1|450000|450800',0,'覃塘区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450821,450800,'1|450000|450800',0,'平南县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450881,450800,'1|450000|450800',0,'桂平市',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450882,450800,'1|450000|450800',0,'其它区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450900,450000,'1|450000',1,'玉林市',0,3,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450902,450900,'1|450000|450900',0,'玉州区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450903,450900,'1|450000|450900',0,'福绵区',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450921,450900,'1|450000|450900',0,'容县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450922,450900,'1|450000|450900',0,'陆川县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450923,450900,'1|450000|450900',0,'博白县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450924,450900,'1|450000|450900',0,'兴业县',0,4,1,'2014-05-05 12:01:43','2014-05-05 12:38:35'),(450981,450900,'1|450000|450900',0,'北流市',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(450982,450900,'1|450000|450900',0,'其它区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451000,450000,'1|450000',1,'百色市',0,3,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451002,451000,'1|450000|451000',0,'右江区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451021,451000,'1|450000|451000',0,'田阳县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451022,451000,'1|450000|451000',0,'田东县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451023,451000,'1|450000|451000',0,'平果县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451024,451000,'1|450000|451000',0,'德保县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451025,451000,'1|450000|451000',0,'靖西县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451026,451000,'1|450000|451000',0,'那坡县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451027,451000,'1|450000|451000',0,'凌云县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451028,451000,'1|450000|451000',0,'乐业县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451029,451000,'1|450000|451000',0,'田林县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451030,451000,'1|450000|451000',0,'西林县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451031,451000,'1|450000|451000',0,'隆林各族自治县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451032,451000,'1|450000|451000',0,'其它区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451100,450000,'1|450000',1,'贺州市',0,3,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451102,451100,'1|450000|451100',0,'八步区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451119,451100,'1|450000|451100',0,'平桂管理区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451121,451100,'1|450000|451100',0,'昭平县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:35'),(451122,451100,'1|450000|451100',0,'钟山县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:36'),(451123,451100,'1|450000|451100',0,'富川瑶族自治县',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:36'),(451124,451100,'1|450000|451100',0,'其它区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:38:36'),(451200,450000,'1|450000',1,'河池市',0,3,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451202,451200,'1|450000|451200',0,'金城江区',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451221,451200,'1|450000|451200',0,'南丹县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451222,451200,'1|450000|451200',0,'天峨县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451223,451200,'1|450000|451200',0,'凤山县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451224,451200,'1|450000|451200',0,'东兰县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451225,451200,'1|450000|451200',0,'罗城仫佬族自治县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451226,451200,'1|450000|451200',0,'环江毛南族自治县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451227,451200,'1|450000|451200',0,'巴马瑶族自治县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451228,451200,'1|450000|451200',0,'都安瑶族自治县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451229,451200,'1|450000|451200',0,'大化瑶族自治县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:36'),(451281,451200,'1|450000|451200',0,'宜州市',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451282,451200,'1|450000|451200',0,'其它区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451300,450000,'1|450000',1,'来宾市',0,3,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451302,451300,'1|450000|451300',0,'兴宾区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451321,451300,'1|450000|451300',0,'忻城县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:36'),(451322,451300,'1|450000|451300',0,'象州县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:37'),(451323,451300,'1|450000|451300',0,'武宣县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:37'),(451324,451300,'1|450000|451300',0,'金秀瑶族自治县',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:38:37'),(451381,451300,'1|450000|451300',0,'合山市',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451382,451300,'1|450000|451300',0,'其它区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451400,450000,'1|450000',1,'崇左市',0,3,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451402,451400,'1|450000|451400',0,'江州区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451421,451400,'1|450000|451400',0,'扶绥县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451422,451400,'1|450000|451400',0,'宁明县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451423,451400,'1|450000|451400',0,'龙州县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:37'),(451424,451400,'1|450000|451400',0,'大新县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:37'),(451425,451400,'1|450000|451400',0,'天等县',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:37'),(451481,451400,'1|450000|451400',0,'凭祥市',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:37'),(451482,451400,'1|450000|451400',0,'其它区',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:37'),(460000,1,'1',1,'海南省',0,2,1,'2014-05-05 12:01:36','2014-05-05 12:38:37'),(460100,460000,'1|460000',1,'海口市',0,3,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460105,460100,'1|460000|460100',0,'秀英区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460106,460100,'1|460000|460100',0,'龙华区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460107,460100,'1|460000|460100',0,'琼山区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460108,460100,'1|460000|460100',0,'美兰区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460109,460100,'1|460000|460100',0,'其它区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460200,460000,'1|460000',1,'三亚市',0,3,1,'2014-05-05 12:01:37','2014-05-05 12:38:37'),(460300,460000,'1|460000',1,'三沙市',0,3,1,'2014-05-05 12:01:34','2014-05-05 12:38:37'),(460321,460300,'1|460000|460300',0,'西沙群岛',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:38:37'),(460322,460300,'1|460000|460300',0,'南沙群岛',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:38:38'),(460323,460300,'1|460000|460300',0,'中沙群岛的岛礁及其海域',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:38:38'),(469001,460000,'1|1|460000',0,'五指山市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469002,460000,'1|1|460000',0,'琼海市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469003,460000,'1|1|460000',0,'儋州市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469005,460000,'1|1|460000',0,'文昌市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469006,460000,'1|1|460000',0,'万宁市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469007,460000,'1|1|460000',0,'东方市',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469025,460000,'1|1|460000',0,'定安县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469026,460000,'1|1|460000',0,'屯昌县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469027,460000,'1|1|460000',0,'澄迈县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:38:38'),(469028,460000,'1|1|460000',0,'临高县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:38:38'),(469030,460000,'1|1|460000',0,'白沙黎族自治县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:38:38'),(469031,460000,'1|1|460000',0,'昌江黎族自治县',0,4,1,'2014-05-05 12:00:58','2014-05-05 12:38:38'),(469033,460000,'1|1|460000',0,'乐东黎族自治县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469034,460000,'1|1|460000',0,'陵水黎族自治县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469035,460000,'1|1|460000',0,'保亭黎族苗族自治县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469036,460000,'1|1|460000',0,'琼中黎族苗族自治县',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469037,460000,'1|1|460000',0,'西沙群岛',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469038,460000,'1|1|460000',0,'南沙群岛',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(469039,460000,'1|1|460000',0,'中沙群岛的岛礁及其海域',0,4,1,'2014-05-05 12:00:59','2014-05-05 12:38:38'),(471004,410300,'1|410000|410300',0,'高新区',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:38:38'),(471005,410300,'1|410000|410300',0,'其它区',0,4,1,'2014-05-05 12:00:57','2014-05-05 12:38:38'),(500000,1,'1',1,'重庆',0,2,1,'2014-05-05 12:02:32','2014-05-05 12:38:38'),(500100,500000,'1|500000',1,'重庆市',0,3,1,'2014-05-05 12:02:32','2014-05-05 12:38:38'),(500101,500100,'1|500000|500100',0,'万州区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:38'),(500102,500100,'1|500000|500100',0,'涪陵区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:38'),(500103,500100,'1|500000|500100',0,'渝中区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:38'),(500104,500100,'1|500000|500100',0,'大渡口区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:38'),(500105,500100,'1|500000|500100',0,'江北区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500106,500100,'1|500000|500100',0,'沙坪坝区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500107,500100,'1|500000|500100',0,'九龙坡区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500108,500100,'1|500000|500100',0,'南岸区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500109,500100,'1|500000|500100',0,'北碚区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500110,500100,'1|500000|500100',0,'万盛区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500111,500100,'1|500000|500100',0,'双桥区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500112,500100,'1|500000|500100',0,'渝北区',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:38:39'),(500113,500100,'1|500000|500100',0,'巴南区',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:38:39'),(500114,500100,'1|500000|500100',0,'黔江区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500115,500100,'1|500000|500100',0,'长寿区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:38:39'),(500222,500100,'1|500000|500100',0,'綦江区',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:38:39'),(500223,500100,'1|500000|500100',0,'潼南县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:38:39'),(500224,500100,'1|500000|500100',0,'铜梁县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500225,500100,'1|500000|500100',0,'大足区',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500226,500100,'1|500000|500100',0,'荣昌县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500227,500100,'1|500000|500100',0,'璧山县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500228,500100,'1|500000|500100',0,'梁平县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500229,500100,'1|500000|500100',0,'城口县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500230,500100,'1|500000|500100',0,'丰都县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500231,500100,'1|500000|500100',0,'垫江县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500232,500100,'1|500000|500100',0,'武隆县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500233,500100,'1|500000|500100',0,'忠县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:39'),(500234,500100,'1|500000|500100',0,'开县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500235,500100,'1|500000|500100',0,'云阳县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500236,500100,'1|500000|500100',0,'奉节县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500237,500100,'1|500000|500100',0,'巫山县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500238,500100,'1|500000|500100',0,'巫溪县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500240,500100,'1|500000|500100',0,'石柱土家族自治县',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:38:40'),(500241,500100,'1|500000|500100',0,'秀山土家族苗族自治县',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:38:40'),(500242,500100,'1|500000|500100',0,'酉阳土家族苗族自治县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500243,500100,'1|500000|500100',0,'彭水苗族土家族自治县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:38:40'),(500381,500100,'1|500000|500100',0,'江津区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:38:40'),(500382,500100,'1|500000|500100',0,'合川区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:38:40'),(500383,500100,'1|500000|500100',0,'永川区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:38:40'),(500384,500100,'1|500000|500100',0,'南川区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:38:41'),(500385,500100,'1|500000|500100',0,'其它区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:38:41'),(510000,1,'1',1,'四川省',0,2,1,'2014-05-05 12:02:12','2014-05-05 12:38:41'),(510100,510000,'1|510000',1,'成都市',0,3,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510104,510100,'1|510000|510100',0,'锦江区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:41'),(510105,510100,'1|510000|510100',0,'青羊区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:41'),(510106,510100,'1|510000|510100',0,'金牛区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:41'),(510107,510100,'1|510000|510100',0,'武侯区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:41'),(510108,510100,'1|510000|510100',0,'成华区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:41'),(510112,510100,'1|510000|510100',0,'龙泉驿区',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510113,510100,'1|510000|510100',0,'青白江区',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510114,510100,'1|510000|510100',0,'新都区',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510115,510100,'1|510000|510100',0,'温江区',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510121,510100,'1|510000|510100',0,'金堂县',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510122,510100,'1|510000|510100',0,'双流县',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510124,510100,'1|510000|510100',0,'郫县',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510129,510100,'1|510000|510100',0,'大邑县',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510131,510100,'1|510000|510100',0,'蒲江县',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510132,510100,'1|510000|510100',0,'新津县',0,4,1,'2014-05-05 12:02:13','2014-05-05 12:38:41'),(510181,510100,'1|510000|510100',0,'都江堰市',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:38:41'),(510182,510100,'1|510000|510100',0,'彭州市',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:38:41'),(510183,510100,'1|510000|510100',0,'邛崃市',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:38:41'),(510184,510100,'1|510000|510100',0,'崇州市',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:38:41'),(510185,510100,'1|510000|510100',0,'其它区',0,4,1,'2014-05-05 12:02:12','2014-05-05 12:38:41'),(510300,510000,'1|510000',1,'自贡市',0,3,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510302,510300,'1|510000|510300',0,'自流井区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510303,510300,'1|510000|510300',0,'贡井区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510304,510300,'1|510000|510300',0,'大安区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510311,510300,'1|510000|510300',0,'沿滩区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510321,510300,'1|510000|510300',0,'荣县',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510322,510300,'1|510000|510300',0,'富顺县',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510323,510300,'1|510000|510300',0,'其它区',0,4,1,'2014-05-05 12:02:09','2014-05-05 12:38:42'),(510400,510000,'1|510000',1,'攀枝花市',0,3,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510402,510400,'1|510000|510400',0,'东区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510403,510400,'1|510000|510400',0,'西区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510411,510400,'1|510000|510400',0,'仁和区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510421,510400,'1|510000|510400',0,'米易县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510422,510400,'1|510000|510400',0,'盐边县',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510423,510400,'1|510000|510400',0,'其它区',0,4,1,'2014-05-05 12:02:11','2014-05-05 12:38:42'),(510500,510000,'1|510000',1,'泸州市',0,3,1,'2014-05-05 12:02:07','2014-05-05 12:38:42'),(510502,510500,'1|510000|510500',0,'江阳区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:42'),(510503,510500,'1|510000|510500',0,'纳溪区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:42'),(510504,510500,'1|510000|510500',0,'龙马潭区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:42'),(510521,510500,'1|510000|510500',0,'泸县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510522,510500,'1|510000|510500',0,'合江县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510524,510500,'1|510000|510500',0,'叙永县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510525,510500,'1|510000|510500',0,'古蔺县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510526,510500,'1|510000|510500',0,'其它区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510600,510000,'1|510000',1,'德阳市',0,3,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510603,510600,'1|510000|510600',0,'旌阳区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510623,510600,'1|510000|510600',0,'中江县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:42'),(510626,510600,'1|510000|510600',0,'罗江县',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510681,510600,'1|510000|510600',0,'广汉市',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510682,510600,'1|510000|510600',0,'什邡市',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510683,510600,'1|510000|510600',0,'绵竹市',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510684,510600,'1|510000|510600',0,'其它区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510700,510000,'1|510000',1,'绵阳市',0,3,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510703,510700,'1|510000|510700',0,'涪城区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510704,510700,'1|510000|510700',0,'游仙区',0,4,1,'2014-05-05 12:02:08','2014-05-05 12:38:43'),(510722,510700,'1|510000|510700',0,'三台县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510723,510700,'1|510000|510700',0,'盐亭县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510724,510700,'1|510000|510700',0,'安县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510725,510700,'1|510000|510700',0,'梓潼县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510726,510700,'1|510000|510700',0,'北川羌族自治县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510727,510700,'1|510000|510700',0,'平武县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510751,510700,'1|510000|510700',0,'高新区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510781,510700,'1|510000|510700',0,'江油市',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510782,510700,'1|510000|510700',0,'其它区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510800,510000,'1|510000',1,'广元市',0,3,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510802,510800,'1|510000|510800',0,'利州区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510811,510800,'1|510000|510800',0,'昭化区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:38:43'),(510812,510800,'1|510000|510800',0,'朝天区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510821,510800,'1|510000|510800',0,'旺苍县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510822,510800,'1|510000|510800',0,'青川县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510823,510800,'1|510000|510800',0,'剑阁县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510824,510800,'1|510000|510800',0,'苍溪县',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510825,510800,'1|510000|510800',0,'其它区',0,4,1,'2014-05-05 12:02:06','2014-05-05 12:38:43'),(510900,510000,'1|510000',1,'遂宁市',0,3,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(510903,510900,'1|510000|510900',0,'船山区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(510904,510900,'1|510000|510900',0,'安居区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(510921,510900,'1|510000|510900',0,'蓬溪县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(510922,510900,'1|510000|510900',0,'射洪县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(510923,510900,'1|510000|510900',0,'大英县',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(510924,510900,'1|510000|510900',0,'其它区',0,4,1,'2014-05-05 12:02:07','2014-05-05 12:38:44'),(511000,510000,'1|510000',1,'内江市',0,3,1,'2014-05-05 12:02:20','2014-05-05 12:38:44'),(511002,511000,'1|510000|511000',0,'市中区',0,4,1,'2014-05-05 12:02:20','2014-05-05 12:38:44'),(511011,511000,'1|510000|511000',0,'东兴区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:44'),(511024,511000,'1|510000|511000',0,'威远县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:44'),(511025,511000,'1|510000|511000',0,'资中县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:44'),(511028,511000,'1|510000|511000',0,'隆昌县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:44'),(511029,511000,'1|510000|511000',0,'其它区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:44'),(511100,510000,'1|510000',1,'乐山市',0,3,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511102,511100,'1|510000|511100',0,'市中区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511111,511100,'1|510000|511100',0,'沙湾区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511112,511100,'1|510000|511100',0,'五通桥区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511113,511100,'1|510000|511100',0,'金口河区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511123,511100,'1|510000|511100',0,'犍为县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511124,511100,'1|510000|511100',0,'井研县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511126,511100,'1|510000|511100',0,'夹江县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:44'),(511129,511100,'1|510000|511100',0,'沐川县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:45'),(511132,511100,'1|510000|511100',0,'峨边彝族自治县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:45'),(511133,511100,'1|510000|511100',0,'马边彝族自治县',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:45'),(511181,511100,'1|510000|511100',0,'峨眉山市',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:45'),(511182,511100,'1|510000|511100',0,'其它区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:38:45'),(511300,510000,'1|510000',1,'南充市',0,3,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511302,511300,'1|510000|511300',0,'顺庆区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511303,511300,'1|510000|511300',0,'高坪区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511304,511300,'1|510000|511300',0,'嘉陵区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511321,511300,'1|510000|511300',0,'南部县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511322,511300,'1|510000|511300',0,'营山县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511323,511300,'1|510000|511300',0,'蓬安县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511324,511300,'1|510000|511300',0,'仪陇县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511325,511300,'1|510000|511300',0,'西充县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511381,511300,'1|510000|511300',0,'阆中市',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:45'),(511382,511300,'1|510000|511300',0,'其它区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:45'),(511400,510000,'1|510000',1,'眉山市',0,3,1,'2014-05-05 12:02:19','2014-05-05 12:38:45'),(511402,511400,'1|510000|511400',0,'东坡区',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511421,511400,'1|510000|511400',0,'仁寿县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511422,511400,'1|510000|511400',0,'彭山县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511423,511400,'1|510000|511400',0,'洪雅县',0,4,1,'2014-05-05 12:02:18','2014-05-05 12:38:45'),(511424,511400,'1|510000|511400',0,'丹棱县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:45'),(511425,511400,'1|510000|511400',0,'青神县',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:46'),(511426,511400,'1|510000|511400',0,'其它区',0,4,1,'2014-05-05 12:02:19','2014-05-05 12:38:46'),(511500,510000,'1|510000',1,'宜宾市',0,3,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511502,511500,'1|510000|511500',0,'翠屏区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511521,511500,'1|510000|511500',0,'宜宾县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511522,511500,'1|510000|511500',0,'南溪区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511523,511500,'1|510000|511500',0,'江安县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511524,511500,'1|510000|511500',0,'长宁县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511525,511500,'1|510000|511500',0,'高县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511526,511500,'1|510000|511500',0,'珙县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511527,511500,'1|510000|511500',0,'筠连县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511528,511500,'1|510000|511500',0,'兴文县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511529,511500,'1|510000|511500',0,'屏山县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511530,511500,'1|510000|511500',0,'其它区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511600,510000,'1|510000',1,'广安市',0,3,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511602,511600,'1|510000|511600',0,'广安区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511603,511600,'1|510000|511600',0,'前锋区',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511621,511600,'1|510000|511600',0,'岳池县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511622,511600,'1|510000|511600',0,'武胜县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511623,511600,'1|510000|511600',0,'邻水县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:46'),(511681,511600,'1|510000|511600',0,'华蓥市',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:46'),(511682,511600,'1|510000|511600',0,'市辖区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:46'),(511683,511600,'1|510000|511600',0,'其它区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:46'),(511700,510000,'1|510000',1,'达州市',0,3,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511702,511700,'1|510000|511700',0,'通川区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511721,511700,'1|510000|511700',0,'达川区',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511722,511700,'1|510000|511700',0,'宣汉县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511723,511700,'1|510000|511700',0,'开江县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511724,511700,'1|510000|511700',0,'大竹县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511725,511700,'1|510000|511700',0,'渠县',0,4,1,'2014-05-05 12:02:17','2014-05-05 12:38:47'),(511781,511700,'1|510000|511700',0,'万源市',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:47'),(511782,511700,'1|510000|511700',0,'其它区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:47'),(511800,510000,'1|510000',1,'雅安市',0,3,1,'2014-05-05 12:02:14','2014-05-05 12:38:47'),(511802,511800,'1|510000|511800',0,'雨城区',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:47'),(511821,511800,'1|510000|511800',0,'名山区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511822,511800,'1|510000|511800',0,'荥经县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511823,511800,'1|510000|511800',0,'汉源县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511824,511800,'1|510000|511800',0,'石棉县',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:47'),(511825,511800,'1|510000|511800',0,'天全县',0,4,1,'2014-05-05 12:02:14','2014-05-05 12:38:47'),(511826,511800,'1|510000|511800',0,'芦山县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511827,511800,'1|510000|511800',0,'宝兴县',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511828,511800,'1|510000|511800',0,'其它区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511900,510000,'1|510000',1,'巴中市',0,3,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511902,511900,'1|510000|511900',0,'巴州区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511903,511900,'1|510000|511900',0,'恩阳区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(511921,511900,'1|510000|511900',0,'通江县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:47'),(511922,511900,'1|510000|511900',0,'南江县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:47'),(511923,511900,'1|510000|511900',0,'平昌县',0,4,1,'2014-05-05 12:02:16','2014-05-05 12:38:47'),(511924,511900,'1|510000|511900',0,'其它区',0,4,1,'2014-05-05 12:02:15','2014-05-05 12:38:47'),(512000,510000,'1|510000',1,'资阳市',0,3,1,'2014-05-05 12:01:54','2014-05-05 12:38:47'),(512002,512000,'1|510000|512000',0,'雁江区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:38:47'),(512021,512000,'1|510000|512000',0,'安岳县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:38:47'),(512022,512000,'1|510000|512000',0,'乐至县',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:38:48'),(512081,512000,'1|510000|512000',0,'简阳市',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:38:48'),(512082,512000,'1|510000|512000',0,'其它区',0,4,1,'2014-05-05 12:01:54','2014-05-05 12:38:48'),(513200,510000,'1|510000',1,'阿坝藏族羌族自治州',0,3,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513221,513200,'1|510000|513200',0,'汶川县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513222,513200,'1|510000|513200',0,'理县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513223,513200,'1|510000|513200',0,'茂县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513224,513200,'1|510000|513200',0,'松潘县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513225,513200,'1|510000|513200',0,'九寨沟县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513226,513200,'1|510000|513200',0,'金川县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513227,513200,'1|510000|513200',0,'小金县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513228,513200,'1|510000|513200',0,'黑水县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513229,513200,'1|510000|513200',0,'马尔康县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513230,513200,'1|510000|513200',0,'壤塘县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513231,513200,'1|510000|513200',0,'阿坝县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513232,513200,'1|510000|513200',0,'若尔盖县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513233,513200,'1|510000|513200',0,'红原县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513234,513200,'1|510000|513200',0,'其它区',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:48'),(513300,510000,'1|510000',1,'甘孜藏族自治州',0,3,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513321,513300,'1|510000|513300',0,'康定县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513322,513300,'1|510000|513300',0,'泸定县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513323,513300,'1|510000|513300',0,'丹巴县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513324,513300,'1|510000|513300',0,'九龙县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513325,513300,'1|510000|513300',0,'雅江县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513326,513300,'1|510000|513300',0,'道孚县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513327,513300,'1|510000|513300',0,'炉霍县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:48'),(513328,513300,'1|510000|513300',0,'甘孜县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:48'),(513329,513300,'1|510000|513300',0,'新龙县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513330,513300,'1|510000|513300',0,'德格县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513331,513300,'1|510000|513300',0,'白玉县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513332,513300,'1|510000|513300',0,'石渠县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513333,513300,'1|510000|513300',0,'色达县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513334,513300,'1|510000|513300',0,'理塘县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513335,513300,'1|510000|513300',0,'巴塘县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513336,513300,'1|510000|513300',0,'乡城县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513337,513300,'1|510000|513300',0,'稻城县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513338,513300,'1|510000|513300',0,'得荣县',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513339,513300,'1|510000|513300',0,'其它区',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513400,510000,'1|510000',1,'凉山彝族自治州',0,3,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513401,513400,'1|510000|513400',0,'西昌市',0,4,1,'2014-05-05 12:02:00','2014-05-05 12:38:49'),(513422,513400,'1|510000|513400',0,'木里藏族自治县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513423,513400,'1|510000|513400',0,'盐源县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513424,513400,'1|510000|513400',0,'德昌县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513425,513400,'1|510000|513400',0,'会理县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513426,513400,'1|510000|513400',0,'会东县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513427,513400,'1|510000|513400',0,'宁南县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513428,513400,'1|510000|513400',0,'普格县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513429,513400,'1|510000|513400',0,'布拖县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513430,513400,'1|510000|513400',0,'金阳县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513431,513400,'1|510000|513400',0,'昭觉县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:49'),(513432,513400,'1|510000|513400',0,'喜德县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513433,513400,'1|510000|513400',0,'冕宁县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513434,513400,'1|510000|513400',0,'越西县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513435,513400,'1|510000|513400',0,'甘洛县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513436,513400,'1|510000|513400',0,'美姑县',0,4,1,'2014-05-05 12:01:58','2014-05-05 12:38:49'),(513437,513400,'1|510000|513400',0,'雷波县',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:50'),(513438,513400,'1|510000|513400',0,'其它区',0,4,1,'2014-05-05 12:01:59','2014-05-05 12:38:50'),(520000,1,'1',1,'贵州省',0,2,1,'2014-05-05 12:01:50','2014-05-05 12:38:50'),(520100,520000,'1|520000',1,'贵阳市',0,3,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520102,520100,'1|520000|520100',0,'南明区',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520103,520100,'1|520000|520100',0,'云岩区',0,4,1,'2014-05-05 12:01:52','2014-05-05 12:38:50'),(520111,520100,'1|520000|520100',0,'花溪区',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520112,520100,'1|520000|520100',0,'乌当区',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520113,520100,'1|520000|520100',0,'白云区',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520114,520100,'1|520000|520100',0,'小河区',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520121,520100,'1|520000|520100',0,'开阳县',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520122,520100,'1|520000|520100',0,'息烽县',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520123,520100,'1|520000|520100',0,'修文县',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520151,520100,'1|520000|520100',0,'观山湖区',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:50'),(520181,520100,'1|520000|520100',0,'清镇市',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520182,520100,'1|520000|520100',0,'其它区',0,4,1,'2014-05-05 12:01:51','2014-05-05 12:38:50'),(520200,520000,'1|520000',1,'六盘水市',0,3,1,'2014-05-05 12:01:39','2014-05-05 12:38:50'),(520201,520200,'1|520000|520200',0,'钟山区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:50'),(520203,520200,'1|520000|520200',0,'六枝特区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:50'),(520221,520200,'1|520000|520200',0,'水城县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:50'),(520222,520200,'1|520000|520200',0,'盘县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:50'),(520223,520200,'1|520000|520200',0,'其它区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:51'),(520300,520000,'1|520000',1,'遵义市',0,3,1,'2014-05-05 12:01:40','2014-05-05 12:38:51'),(520302,520300,'1|520000|520300',0,'红花岗区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:51'),(520303,520300,'1|520000|520300',0,'汇川区',0,4,1,'2014-05-05 12:01:40','2014-05-05 12:38:51'),(520321,520300,'1|520000|520300',0,'遵义县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520322,520300,'1|520000|520300',0,'桐梓县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520323,520300,'1|520000|520300',0,'绥阳县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520324,520300,'1|520000|520300',0,'正安县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520325,520300,'1|520000|520300',0,'道真仡佬族苗族自治县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520326,520300,'1|520000|520300',0,'务川仡佬族苗族自治县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520327,520300,'1|520000|520300',0,'凤冈县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520328,520300,'1|520000|520300',0,'湄潭县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520329,520300,'1|520000|520300',0,'余庆县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520330,520300,'1|520000|520300',0,'习水县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520381,520300,'1|520000|520300',0,'赤水市',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520382,520300,'1|520000|520300',0,'仁怀市',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520383,520300,'1|520000|520300',0,'其它区',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520400,520000,'1|520000',1,'安顺市',0,3,1,'2014-05-05 12:01:38','2014-05-05 12:38:51'),(520402,520400,'1|520000|520400',0,'西秀区',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:52'),(520421,520400,'1|520000|520400',0,'平坝县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:52'),(520422,520400,'1|520000|520400',0,'普定县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:52'),(520423,520400,'1|520000|520400',0,'镇宁布依族苗族自治县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:38:52'),(520424,520400,'1|520000|520400',0,'关岭布依族苗族自治县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:52'),(520425,520400,'1|520000|520400',0,'紫云苗族布依族自治县',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:52'),(520426,520400,'1|520000|520400',0,'其它区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:38:52'),(522200,520000,'1|520000',1,'铜仁市',0,3,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522201,522200,'1|520000|522200',0,'碧江区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522222,522200,'1|520000|522200',0,'江口县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522223,522200,'1|520000|522200',0,'玉屏侗族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522224,522200,'1|520000|522200',0,'石阡县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522225,522200,'1|520000|522200',0,'思南县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522226,522200,'1|520000|522200',0,'印江土家族苗族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522227,522200,'1|520000|522200',0,'德江县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522228,522200,'1|520000|522200',0,'沿河土家族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522229,522200,'1|520000|522200',0,'松桃苗族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522230,522200,'1|520000|522200',0,'万山区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522231,522200,'1|520000|522200',0,'其它区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:52'),(522300,520000,'1|520000',1,'黔西南布依族苗族自治州',0,3,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522301,522300,'1|520000|522300',0,'兴义市',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522322,522300,'1|520000|522300',0,'兴仁县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522323,522300,'1|520000|522300',0,'普安县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522324,522300,'1|520000|522300',0,'晴隆县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522325,522300,'1|520000|522300',0,'贞丰县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522326,522300,'1|520000|522300',0,'望谟县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:52'),(522327,522300,'1|520000|522300',0,'册亨县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:53'),(522328,522300,'1|520000|522300',0,'安龙县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:53'),(522329,522300,'1|520000|522300',0,'其它区',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:53'),(522400,520000,'1|520000',1,'毕节市',0,3,1,'2014-05-05 12:01:46','2014-05-05 12:38:53'),(522401,522400,'1|520000|522400',0,'七星关区',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:53'),(522422,522400,'1|520000|522400',0,'大方县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522423,522400,'1|520000|522400',0,'黔西县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522424,522400,'1|520000|522400',0,'金沙县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522425,522400,'1|520000|522400',0,'织金县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522426,522400,'1|520000|522400',0,'纳雍县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522427,522400,'1|520000|522400',0,'威宁彝族回族苗族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522428,522400,'1|520000|522400',0,'赫章县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522429,522400,'1|520000|522400',0,'其它区',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522600,520000,'1|520000',1,'黔东南苗族侗族自治州',0,3,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522601,522600,'1|520000|522600',0,'凯里市',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522622,522600,'1|520000|522600',0,'黄平县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522623,522600,'1|520000|522600',0,'施秉县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:53'),(522624,522600,'1|520000|522600',0,'三穗县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522625,522600,'1|520000|522600',0,'镇远县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522626,522600,'1|520000|522600',0,'岑巩县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522627,522600,'1|520000|522600',0,'天柱县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522628,522600,'1|520000|522600',0,'锦屏县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522629,522600,'1|520000|522600',0,'剑河县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:53'),(522630,522600,'1|520000|522600',0,'台江县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:54'),(522631,522600,'1|520000|522600',0,'黎平县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:54'),(522632,522600,'1|520000|522600',0,'榕江县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522633,522600,'1|520000|522600',0,'从江县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522634,522600,'1|520000|522600',0,'雷山县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:54'),(522635,522600,'1|520000|522600',0,'麻江县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:54'),(522636,522600,'1|520000|522600',0,'丹寨县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522637,522600,'1|520000|522600',0,'其它区',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522700,520000,'1|520000',1,'黔南布依族苗族自治州',0,3,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522701,522700,'1|520000|522700',0,'都匀市',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522702,522700,'1|520000|522700',0,'福泉市',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522722,522700,'1|520000|522700',0,'荔波县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(522723,522700,'1|520000|522700',0,'贵定县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522725,522700,'1|520000|522700',0,'瓮安县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522726,522700,'1|520000|522700',0,'独山县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522727,522700,'1|520000|522700',0,'平塘县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:54'),(522728,522700,'1|520000|522700',0,'罗甸县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(522729,522700,'1|520000|522700',0,'长顺县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(522730,522700,'1|520000|522700',0,'龙里县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(522731,522700,'1|520000|522700',0,'惠水县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(522732,522700,'1|520000|522700',0,'三都水族自治县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(522733,522700,'1|520000|522700',0,'其它区',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:54'),(530000,1,'1',1,'云南省',0,2,1,'2014-05-05 12:01:46','2014-05-05 12:38:54'),(530100,530000,'1|530000',1,'昆明市',0,3,1,'2014-05-05 12:01:46','2014-05-05 12:38:54'),(530102,530100,'1|530000|530100',0,'五华区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:54'),(530103,530100,'1|530000|530100',0,'盘龙区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:54'),(530111,530100,'1|530000|530100',0,'官渡区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530112,530100,'1|530000|530100',0,'西山区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530113,530100,'1|530000|530100',0,'东川区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530121,530100,'1|530000|530100',0,'呈贡区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530122,530100,'1|530000|530100',0,'晋宁县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530124,530100,'1|530000|530100',0,'富民县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530125,530100,'1|530000|530100',0,'宜良县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530126,530100,'1|530000|530100',0,'石林彝族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530127,530100,'1|530000|530100',0,'嵩明县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530128,530100,'1|530000|530100',0,'禄劝彝族苗族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530129,530100,'1|530000|530100',0,'寻甸回族彝族自治县',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530181,530100,'1|530000|530100',0,'安宁市',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530182,530100,'1|530000|530100',0,'其它区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530300,530000,'1|530000',1,'曲靖市',0,3,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530302,530300,'1|530000|530300',0,'麒麟区',0,4,1,'2014-05-05 12:01:45','2014-05-05 12:38:55'),(530321,530300,'1|530000|530300',0,'马龙县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530322,530300,'1|530000|530300',0,'陆良县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530323,530300,'1|530000|530300',0,'师宗县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530324,530300,'1|530000|530300',0,'罗平县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530325,530300,'1|530000|530300',0,'富源县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530326,530300,'1|530000|530300',0,'会泽县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530328,530300,'1|530000|530300',0,'沾益县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:55'),(530381,530300,'1|530000|530300',0,'宣威市',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530382,530300,'1|530000|530300',0,'其它区',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530400,530000,'1|530000',1,'玉溪市',0,3,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530402,530400,'1|530000|530400',0,'红塔区',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530421,530400,'1|530000|530400',0,'江川县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530422,530400,'1|530000|530400',0,'澄江县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530423,530400,'1|530000|530400',0,'通海县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530424,530400,'1|530000|530400',0,'华宁县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530425,530400,'1|530000|530400',0,'易门县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530426,530400,'1|530000|530400',0,'峨山彝族自治县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530427,530400,'1|530000|530400',0,'新平彝族傣族自治县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530428,530400,'1|530000|530400',0,'元江哈尼族彝族傣族自治县',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530429,530400,'1|530000|530400',0,'其它区',0,4,1,'2014-05-05 12:01:44','2014-05-05 12:38:56'),(530500,530000,'1|530000',1,'保山市',0,3,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530502,530500,'1|530000|530500',0,'隆阳区',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530521,530500,'1|530000|530500',0,'施甸县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530522,530500,'1|530000|530500',0,'腾冲县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530523,530500,'1|530000|530500',0,'龙陵县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530524,530500,'1|530000|530500',0,'昌宁县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:56'),(530525,530500,'1|530000|530500',0,'其它区',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:56'),(530600,530000,'1|530000',1,'昭通市',0,3,1,'2014-05-05 12:01:49','2014-05-05 12:38:56'),(530602,530600,'1|530000|530600',0,'昭阳区',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:56'),(530621,530600,'1|530000|530600',0,'鲁甸县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530622,530600,'1|530000|530600',0,'巧家县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530623,530600,'1|530000|530600',0,'盐津县',0,4,1,'2014-05-05 12:01:48','2014-05-05 12:38:56'),(530624,530600,'1|530000|530600',0,'大关县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:56'),(530625,530600,'1|530000|530600',0,'永善县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:56'),(530626,530600,'1|530000|530600',0,'绥江县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:56'),(530627,530600,'1|530000|530600',0,'镇雄县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:56'),(530628,530600,'1|530000|530600',0,'彝良县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:56'),(530629,530600,'1|530000|530600',0,'威信县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:57'),(530630,530600,'1|530000|530600',0,'水富县',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:57'),(530631,530600,'1|530000|530600',0,'其它区',0,4,1,'2014-05-05 12:01:49','2014-05-05 12:38:57'),(530700,530000,'1|530000',1,'丽江市',0,3,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530702,530700,'1|530000|530700',0,'古城区',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530721,530700,'1|530000|530700',0,'玉龙纳西族自治县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530722,530700,'1|530000|530700',0,'永胜县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530723,530700,'1|530000|530700',0,'华坪县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530724,530700,'1|530000|530700',0,'宁蒗彝族自治县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530725,530700,'1|530000|530700',0,'其它区',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530800,530000,'1|530000',1,'普洱市',0,3,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530802,530800,'1|530000|530800',0,'思茅区',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530821,530800,'1|530000|530800',0,'宁洱哈尼族彝族自治县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530822,530800,'1|530000|530800',0,'墨江哈尼族自治县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530823,530800,'1|530000|530800',0,'景东彝族自治县',0,4,1,'2014-05-05 12:01:46','2014-05-05 12:38:57'),(530824,530800,'1|530000|530800',0,'景谷傣族彝族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530825,530800,'1|530000|530800',0,'镇沅彝族哈尼族拉祜族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530826,530800,'1|530000|530800',0,'江城哈尼族彝族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530827,530800,'1|530000|530800',0,'孟连傣族拉祜族佤族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530828,530800,'1|530000|530800',0,'澜沧拉祜族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530829,530800,'1|530000|530800',0,'西盟佤族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530830,530800,'1|530000|530800',0,'其它区',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530900,530000,'1|530000',1,'临沧市',0,3,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530902,530900,'1|530000|530900',0,'临翔区',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530921,530900,'1|530000|530900',0,'凤庆县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530922,530900,'1|530000|530900',0,'云县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530923,530900,'1|530000|530900',0,'永德县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530924,530900,'1|530000|530900',0,'镇康县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:57'),(530925,530900,'1|530000|530900',0,'双江拉祜族佤族布朗族傣族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:58'),(530926,530900,'1|530000|530900',0,'耿马傣族佤族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:58'),(530927,530900,'1|530000|530900',0,'沧源佤族自治县',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:58'),(530928,530900,'1|530000|530900',0,'其它区',0,4,1,'2014-05-05 12:01:47','2014-05-05 12:38:58'),(532300,530000,'1|530000',1,'楚雄彝族自治州',0,3,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532301,532300,'1|530000|532300',0,'楚雄市',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532322,532300,'1|530000|532300',0,'双柏县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532323,532300,'1|530000|532300',0,'牟定县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532324,532300,'1|530000|532300',0,'南华县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532325,532300,'1|530000|532300',0,'姚安县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532326,532300,'1|530000|532300',0,'大姚县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532327,532300,'1|530000|532300',0,'永仁县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532328,532300,'1|530000|532300',0,'元谋县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532329,532300,'1|530000|532300',0,'武定县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532331,532300,'1|530000|532300',0,'禄丰县',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532332,532300,'1|530000|532300',0,'其它区',0,4,1,'2014-05-05 12:01:50','2014-05-05 12:38:58'),(532500,530000,'1|530000',1,'红河哈尼族彝族自治州',0,3,1,'2014-05-05 12:02:03','2014-05-05 12:38:58'),(532501,532500,'1|530000|532500',0,'个旧市',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:58'),(532502,532500,'1|530000|532500',0,'开远市',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:58'),(532522,532500,'1|530000|532500',0,'蒙自市',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:58'),(532523,532500,'1|530000|532500',0,'屏边苗族自治县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:58'),(532524,532500,'1|530000|532500',0,'建水县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532525,532500,'1|530000|532500',0,'石屏县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532526,532500,'1|530000|532500',0,'弥勒市',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532527,532500,'1|530000|532500',0,'泸西县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532528,532500,'1|530000|532500',0,'元阳县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532529,532500,'1|530000|532500',0,'红河县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532530,532500,'1|530000|532500',0,'金平苗族瑶族傣族自治县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532531,532500,'1|530000|532500',0,'绿春县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532532,532500,'1|530000|532500',0,'河口瑶族自治县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532533,532500,'1|530000|532500',0,'其它区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532600,530000,'1|530000',1,'文山壮族苗族自治州',0,3,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532621,532600,'1|530000|532600',0,'文山市',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532622,532600,'1|530000|532600',0,'砚山县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532623,532600,'1|530000|532600',0,'西畴县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532624,532600,'1|530000|532600',0,'麻栗坡县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532625,532600,'1|530000|532600',0,'马关县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532626,532600,'1|530000|532600',0,'丘北县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532627,532600,'1|530000|532600',0,'广南县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532628,532600,'1|530000|532600',0,'富宁县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532629,532600,'1|530000|532600',0,'其它区',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:38:59'),(532800,530000,'1|530000',1,'西双版纳傣族自治州',0,3,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532801,532800,'1|530000|532800',0,'景洪市',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532822,532800,'1|530000|532800',0,'勐海县',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532823,532800,'1|530000|532800',0,'勐腊县',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532824,532800,'1|530000|532800',0,'其它区',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532900,530000,'1|530000',1,'大理白族自治州',0,3,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532901,532900,'1|530000|532900',0,'大理市',0,4,1,'2014-05-05 12:02:05','2014-05-05 12:38:59'),(532922,532900,'1|530000|532900',0,'漾濞彝族自治县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532923,532900,'1|530000|532900',0,'祥云县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532924,532900,'1|530000|532900',0,'宾川县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:38:59'),(532925,532900,'1|530000|532900',0,'弥渡县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532926,532900,'1|530000|532900',0,'南涧彝族自治县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532927,532900,'1|530000|532900',0,'巍山彝族回族自治县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532928,532900,'1|530000|532900',0,'永平县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532929,532900,'1|530000|532900',0,'云龙县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532930,532900,'1|530000|532900',0,'洱源县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532931,532900,'1|530000|532900',0,'剑川县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532932,532900,'1|530000|532900',0,'鹤庆县',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(532933,532900,'1|530000|532900',0,'其它区',0,4,1,'2014-05-05 12:02:04','2014-05-05 12:39:00'),(533100,530000,'1|530000',1,'德宏傣族景颇族自治州',0,3,1,'2014-05-05 12:02:01','2014-05-05 12:39:00'),(533102,533100,'1|530000|533100',0,'瑞丽市',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:00'),(533103,533100,'1|530000|533100',0,'芒市',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:00'),(533122,533100,'1|530000|533100',0,'梁河县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:00'),(533123,533100,'1|530000|533100',0,'盈江县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:00'),(533124,533100,'1|530000|533100',0,'陇川县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:00'),(533125,533100,'1|530000|533100',0,'其它区',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:00'),(533300,530000,'1|530000',1,'怒江傈僳族自治州',0,3,1,'2014-05-05 12:02:03','2014-05-05 12:39:00'),(533321,533300,'1|530000|533300',0,'泸水县',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:00'),(533323,533300,'1|530000|533300',0,'福贡县',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:00'),(533324,533300,'1|530000|533300',0,'贡山独龙族怒族自治县',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:39:00'),(533325,533300,'1|530000|533300',0,'兰坪白族普米族自治县',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:00'),(533326,533300,'1|530000|533300',0,'其它区',0,4,1,'2014-05-05 12:02:03','2014-05-05 12:39:00'),(533400,530000,'1|530000',1,'迪庆藏族自治州',0,3,1,'2014-05-05 12:02:02','2014-05-05 12:39:00'),(533421,533400,'1|530000|533400',0,'香格里拉县',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:01'),(533422,533400,'1|530000|533400',0,'德钦县',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:01'),(533423,533400,'1|530000|533400',0,'维西傈僳族自治县',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:01'),(533424,533400,'1|530000|533400',0,'其它区',0,4,1,'2014-05-05 12:02:02','2014-05-05 12:39:01'),(540000,1,'1',1,'西藏自治区',0,2,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540100,540000,'1|540000',1,'拉萨市',0,3,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540102,540100,'1|540000|540100',0,'城关区',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540121,540100,'1|540000|540100',0,'林周县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540122,540100,'1|540000|540100',0,'当雄县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540123,540100,'1|540000|540100',0,'尼木县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540124,540100,'1|540000|540100',0,'曲水县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540125,540100,'1|540000|540100',0,'堆龙德庆县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540126,540100,'1|540000|540100',0,'达孜县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540127,540100,'1|540000|540100',0,'墨竹工卡县',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(540128,540100,'1|540000|540100',0,'其它区',0,4,1,'2014-05-05 12:02:01','2014-05-05 12:39:01'),(542100,540000,'1|540000',1,'昌都地区',0,3,1,'2014-05-05 12:02:25','2014-05-05 12:39:01'),(542121,542100,'1|540000|542100',0,'昌都县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:01'),(542122,542100,'1|540000|542100',0,'江达县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:01'),(542123,542100,'1|540000|542100',0,'贡觉县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:02'),(542124,542100,'1|540000|542100',0,'类乌齐县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:02'),(542125,542100,'1|540000|542100',0,'丁青县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:02'),(542126,542100,'1|540000|542100',0,'察雅县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:02'),(542127,542100,'1|540000|542100',0,'八宿县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:02'),(542128,542100,'1|540000|542100',0,'左贡县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:39:02'),(542129,542100,'1|540000|542100',0,'芒康县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:39:02'),(542132,542100,'1|540000|542100',0,'洛隆县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:39:02'),(542133,542100,'1|540000|542100',0,'边坝县',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:39:02'),(542134,542100,'1|540000|542100',0,'其它区',0,4,1,'2014-05-05 12:02:26','2014-05-05 12:39:02'),(542200,540000,'1|540000',1,'山南地区',0,3,1,'2014-05-05 12:02:25','2014-05-05 12:39:02'),(542221,542200,'1|540000|542200',0,'乃东县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:02'),(542222,542200,'1|540000|542200',0,'扎囊县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:02'),(542223,542200,'1|540000|542200',0,'贡嘎县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:02'),(542224,542200,'1|540000|542200',0,'桑日县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:02'),(542225,542200,'1|540000|542200',0,'琼结县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:02'),(542226,542200,'1|540000|542200',0,'曲松县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:03'),(542227,542200,'1|540000|542200',0,'措美县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:03'),(542228,542200,'1|540000|542200',0,'洛扎县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:03'),(542229,542200,'1|540000|542200',0,'加查县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:03'),(542231,542200,'1|540000|542200',0,'隆子县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:03'),(542232,542200,'1|540000|542200',0,'错那县',0,4,1,'2014-05-05 12:02:29','2014-05-05 12:39:03'),(542233,542200,'1|540000|542200',0,'浪卡子县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:03'),(542234,542200,'1|540000|542200',0,'其它区',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:03'),(542300,540000,'1|540000',1,'日喀则地区',0,3,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542301,542300,'1|540000|542300',0,'日喀则市',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542322,542300,'1|540000|542300',0,'南木林县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542323,542300,'1|540000|542300',0,'江孜县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542324,542300,'1|540000|542300',0,'定日县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542325,542300,'1|540000|542300',0,'萨迦县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542326,542300,'1|540000|542300',0,'拉孜县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542327,542300,'1|540000|542300',0,'昂仁县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542328,542300,'1|540000|542300',0,'谢通门县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542329,542300,'1|540000|542300',0,'白朗县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542330,542300,'1|540000|542300',0,'仁布县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542331,542300,'1|540000|542300',0,'康马县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542332,542300,'1|540000|542300',0,'定结县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542333,542300,'1|540000|542300',0,'仲巴县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542334,542300,'1|540000|542300',0,'亚东县',0,4,1,'2014-05-05 12:02:27','2014-05-05 12:39:03'),(542335,542300,'1|540000|542300',0,'吉隆县',0,4,1,'2014-05-05 12:02:28','2014-05-05 12:39:03'),(542336,542300,'1|540000|542300',0,'聂拉木县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542337,542300,'1|540000|542300',0,'萨嘎县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542338,542300,'1|540000|542300',0,'岗巴县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542339,542300,'1|540000|542300',0,'其它区',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542400,540000,'1|540000',1,'那曲地区',0,3,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542421,542400,'1|540000|542400',0,'那曲县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542422,542400,'1|540000|542400',0,'嘉黎县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542423,542400,'1|540000|542400',0,'比如县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542424,542400,'1|540000|542400',0,'聂荣县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542425,542400,'1|540000|542400',0,'安多县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542426,542400,'1|540000|542400',0,'申扎县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542427,542400,'1|540000|542400',0,'索县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542428,542400,'1|540000|542400',0,'班戈县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542429,542400,'1|540000|542400',0,'巴青县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542430,542400,'1|540000|542400',0,'尼玛县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542431,542400,'1|540000|542400',0,'其它区',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542432,542400,'1|540000|542400',0,'双湖县',0,4,1,'2014-05-05 12:02:30','2014-05-05 12:39:04'),(542500,540000,'1|540000',1,'阿里地区',0,3,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542521,542500,'1|540000|542500',0,'普兰县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542522,542500,'1|540000|542500',0,'札达县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542523,542500,'1|540000|542500',0,'噶尔县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542524,542500,'1|540000|542500',0,'日土县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542525,542500,'1|540000|542500',0,'革吉县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542526,542500,'1|540000|542500',0,'改则县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542527,542500,'1|540000|542500',0,'措勤县',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542528,542500,'1|540000|542500',0,'其它区',0,4,1,'2014-05-05 12:02:31','2014-05-05 12:39:04'),(542600,540000,'1|540000',1,'林芝地区',0,3,1,'2014-05-05 12:02:32','2014-05-05 12:39:04'),(542621,542600,'1|540000|542600',0,'林芝县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:04'),(542622,542600,'1|540000|542600',0,'工布江达县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:04'),(542623,542600,'1|540000|542600',0,'米林县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:05'),(542624,542600,'1|540000|542600',0,'墨脱县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:05'),(542625,542600,'1|540000|542600',0,'波密县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:05'),(542626,542600,'1|540000|542600',0,'察隅县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:05'),(542627,542600,'1|540000|542600',0,'朗县',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:05'),(542628,542600,'1|540000|542600',0,'其它区',0,4,1,'2014-05-05 12:02:32','2014-05-05 12:39:05'),(610000,1,'1',1,'陕西省',0,2,1,'2014-05-05 12:02:21','2014-05-05 12:39:05'),(610100,610000,'1|610000',1,'西安市',0,3,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610102,610100,'1|610000|610100',0,'新城区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610103,610100,'1|610000|610100',0,'碑林区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610104,610100,'1|610000|610100',0,'莲湖区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610111,610100,'1|610000|610100',0,'灞桥区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610112,610100,'1|610000|610100',0,'未央区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610113,610100,'1|610000|610100',0,'雁塔区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610114,610100,'1|610000|610100',0,'阎良区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610115,610100,'1|610000|610100',0,'临潼区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610116,610100,'1|610000|610100',0,'长安区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610122,610100,'1|610000|610100',0,'蓝田县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610124,610100,'1|610000|610100',0,'周至县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610125,610100,'1|610000|610100',0,'户县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610126,610100,'1|610000|610100',0,'高陵县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610127,610100,'1|610000|610100',0,'其它区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610200,610000,'1|610000',1,'铜川市',0,3,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610202,610200,'1|610000|610200',0,'王益区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610203,610200,'1|610000|610200',0,'印台区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610204,610200,'1|610000|610200',0,'耀州区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610222,610200,'1|610000|610200',0,'宜君县',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:05'),(610223,610200,'1|610000|610200',0,'其它区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:06'),(610300,610000,'1|610000',1,'宝鸡市',0,3,1,'2014-05-05 12:02:21','2014-05-05 12:39:06'),(610302,610300,'1|610000|610300',0,'渭滨区',0,4,1,'2014-05-05 12:02:21','2014-05-05 12:39:06'),(610303,610300,'1|610000|610300',0,'金台区',0,4,1,'2014-05-05 12:02:22','2014-05-05 12:39:06'),(610304,610300,'1|610000|610300',0,'陈仓区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610322,610300,'1|610000|610300',0,'凤翔县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610323,610300,'1|610000|610300',0,'岐山县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610324,610300,'1|610000|610300',0,'扶风县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610326,610300,'1|610000|610300',0,'眉县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610327,610300,'1|610000|610300',0,'陇县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610328,610300,'1|610000|610300',0,'千阳县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610329,610300,'1|610000|610300',0,'麟游县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610330,610300,'1|610000|610300',0,'凤县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610331,610300,'1|610000|610300',0,'太白县',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610332,610300,'1|610000|610300',0,'其它区',0,4,1,'2014-05-05 12:02:37','2014-05-05 12:39:06'),(610400,610000,'1|610000',1,'咸阳市',0,3,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610402,610400,'1|610000|610400',0,'秦都区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610403,610400,'1|610000|610400',0,'杨陵区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610404,610400,'1|610000|610400',0,'渭城区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610422,610400,'1|610000|610400',0,'三原县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610423,610400,'1|610000|610400',0,'泾阳县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610424,610400,'1|610000|610400',0,'乾县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610425,610400,'1|610000|610400',0,'礼泉县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610426,610400,'1|610000|610400',0,'永寿县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610427,610400,'1|610000|610400',0,'彬县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610428,610400,'1|610000|610400',0,'长武县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610429,610400,'1|610000|610400',0,'旬邑县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:06'),(610430,610400,'1|610000|610400',0,'淳化县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:07'),(610431,610400,'1|610000|610400',0,'武功县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:07'),(610481,610400,'1|610000|610400',0,'兴平市',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:07'),(610482,610400,'1|610000|610400',0,'其它区',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:07'),(610500,610000,'1|610000',1,'渭南市',0,3,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610502,610500,'1|610000|610500',0,'临渭区',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610521,610500,'1|610000|610500',0,'华县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:07'),(610522,610500,'1|610000|610500',0,'潼关县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610523,610500,'1|610000|610500',0,'大荔县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610524,610500,'1|610000|610500',0,'合阳县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610525,610500,'1|610000|610500',0,'澄城县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610526,610500,'1|610000|610500',0,'蒲城县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610527,610500,'1|610000|610500',0,'白水县',0,4,1,'2014-05-05 12:02:39','2014-05-05 12:39:07'),(610528,610500,'1|610000|610500',0,'富平县',0,4,1,'2014-05-05 12:02:38','2014-05-05 12:39:07'),(610581,610500,'1|610000|610500',0,'韩城市',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610582,610500,'1|610000|610500',0,'华阴市',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610583,610500,'1|610000|610500',0,'其它区',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610600,610000,'1|610000',1,'延安市',0,3,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610602,610600,'1|610000|610600',0,'宝塔区',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610621,610600,'1|610000|610600',0,'延长县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610622,610600,'1|610000|610600',0,'延川县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610623,610600,'1|610000|610600',0,'子长县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610624,610600,'1|610000|610600',0,'安塞县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610625,610600,'1|610000|610600',0,'志丹县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:07'),(610626,610600,'1|610000|610600',0,'吴起县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:08'),(610627,610600,'1|610000|610600',0,'甘泉县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:08'),(610628,610600,'1|610000|610600',0,'富县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610629,610600,'1|610000|610600',0,'洛川县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610630,610600,'1|610000|610600',0,'宜川县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610631,610600,'1|610000|610600',0,'黄龙县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610632,610600,'1|610000|610600',0,'黄陵县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:08'),(610633,610600,'1|610000|610600',0,'其它区',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:08'),(610700,610000,'1|610000',1,'汉中市',0,3,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610702,610700,'1|610000|610700',0,'汉台区',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610721,610700,'1|610000|610700',0,'南郑县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610722,610700,'1|610000|610700',0,'城固县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610723,610700,'1|610000|610700',0,'洋县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610724,610700,'1|610000|610700',0,'西乡县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610725,610700,'1|610000|610700',0,'勉县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610726,610700,'1|610000|610700',0,'宁强县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610727,610700,'1|610000|610700',0,'略阳县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610728,610700,'1|610000|610700',0,'镇巴县',0,4,1,'2014-05-05 12:02:35','2014-05-05 12:39:08'),(610729,610700,'1|610000|610700',0,'留坝县',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610730,610700,'1|610000|610700',0,'佛坪县',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610731,610700,'1|610000|610700',0,'其它区',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610800,610000,'1|610000',1,'榆林市',0,3,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610802,610800,'1|610000|610800',0,'榆阳区',0,4,1,'2014-05-05 12:02:36','2014-05-05 12:39:08'),(610821,610800,'1|610000|610800',0,'神木县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:08'),(610822,610800,'1|610000|610800',0,'府谷县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:08'),(610823,610800,'1|610000|610800',0,'横山县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610824,610800,'1|610000|610800',0,'靖边县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610825,610800,'1|610000|610800',0,'定边县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610826,610800,'1|610000|610800',0,'绥德县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610827,610800,'1|610000|610800',0,'米脂县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610828,610800,'1|610000|610800',0,'佳县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610829,610800,'1|610000|610800',0,'吴堡县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610830,610800,'1|610000|610800',0,'清涧县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610831,610800,'1|610000|610800',0,'子洲县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610832,610800,'1|610000|610800',0,'其它区',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610900,610000,'1|610000',1,'安康市',0,3,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610902,610900,'1|610000|610900',0,'汉滨区',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610921,610900,'1|610000|610900',0,'汉阴县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(610922,610900,'1|610000|610900',0,'石泉县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(610923,610900,'1|610000|610900',0,'宁陕县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610924,610900,'1|610000|610900',0,'紫阳县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610925,610900,'1|610000|610900',0,'岚皋县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610926,610900,'1|610000|610900',0,'平利县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610927,610900,'1|610000|610900',0,'镇坪县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610928,610900,'1|610000|610900',0,'旬阳县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610929,610900,'1|610000|610900',0,'白河县',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(610930,610900,'1|610000|610900',0,'其它区',0,4,1,'2014-05-05 12:02:33','2014-05-05 12:39:09'),(611000,610000,'1|610000',1,'商洛市',0,3,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611002,611000,'1|610000|611000',0,'商州区',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611021,611000,'1|610000|611000',0,'洛南县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611022,611000,'1|610000|611000',0,'丹凤县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611023,611000,'1|610000|611000',0,'商南县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611024,611000,'1|610000|611000',0,'山阳县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611025,611000,'1|610000|611000',0,'镇安县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:09'),(611026,611000,'1|610000|611000',0,'柞水县',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:10'),(611027,611000,'1|610000|611000',0,'其它区',0,4,1,'2014-05-05 12:02:34','2014-05-05 12:39:10'),(620000,1,'1',1,'甘肃省',0,2,1,'2014-05-05 12:02:52','2014-05-05 12:39:10'),(620100,620000,'1|620000',1,'兰州市',0,3,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620102,620100,'1|620000|620100',0,'城关区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620103,620100,'1|620000|620100',0,'七里河区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620104,620100,'1|620000|620100',0,'西固区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620105,620100,'1|620000|620100',0,'安宁区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620111,620100,'1|620000|620100',0,'红古区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620121,620100,'1|620000|620100',0,'永登县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620122,620100,'1|620000|620100',0,'皋兰县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620123,620100,'1|620000|620100',0,'榆中县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620124,620100,'1|620000|620100',0,'其它区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620200,620000,'1|620000',1,'嘉峪关市',0,3,1,'2014-05-05 12:02:53','2014-05-05 12:39:10'),(620300,620000,'1|620000',1,'金昌市',0,3,1,'2014-05-05 12:02:52','2014-05-05 12:39:10'),(620302,620300,'1|620000|620300',0,'金川区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:10'),(620321,620300,'1|620000|620300',0,'永昌县',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:10'),(620322,620300,'1|620000|620300',0,'其它区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:10'),(620400,620000,'1|620000',1,'白银市',0,3,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620402,620400,'1|620000|620400',0,'白银区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620403,620400,'1|620000|620400',0,'平川区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620421,620400,'1|620000|620400',0,'靖远县',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620422,620400,'1|620000|620400',0,'会宁县',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620423,620400,'1|620000|620400',0,'景泰县',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620424,620400,'1|620000|620400',0,'其它区',0,4,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620500,620000,'1|620000',1,'天水市',0,3,1,'2014-05-05 12:02:52','2014-05-05 12:39:11'),(620502,620500,'1|620000|620500',0,'秦州区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620503,620500,'1|620000|620500',0,'麦积区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620521,620500,'1|620000|620500',0,'清水县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620522,620500,'1|620000|620500',0,'秦安县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620523,620500,'1|620000|620500',0,'甘谷县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620524,620500,'1|620000|620500',0,'武山县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620525,620500,'1|620000|620500',0,'张家川回族自治县',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620526,620500,'1|620000|620500',0,'其它区',0,4,1,'2014-05-05 12:02:53','2014-05-05 12:39:11'),(620600,620000,'1|620000',1,'武威市',0,3,1,'2014-05-05 12:03:08','2014-05-05 12:39:11'),(620602,620600,'1|620000|620600',0,'凉州区',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:39:11'),(620621,620600,'1|620000|620600',0,'民勤县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:11'),(620622,620600,'1|620000|620600',0,'古浪县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:11'),(620623,620600,'1|620000|620600',0,'天祝藏族自治县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:11'),(620624,620600,'1|620000|620600',0,'其它区',0,4,1,'2014-05-05 12:03:08','2014-05-05 12:39:11'),(620700,620000,'1|620000',1,'张掖市',0,3,1,'2014-05-05 12:03:07','2014-05-05 12:39:11'),(620702,620700,'1|620000|620700',0,'甘州区',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:11'),(620721,620700,'1|620000|620700',0,'肃南裕固族自治县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620722,620700,'1|620000|620700',0,'民乐县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620723,620700,'1|620000|620700',0,'临泽县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620724,620700,'1|620000|620700',0,'高台县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620725,620700,'1|620000|620700',0,'山丹县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620726,620700,'1|620000|620700',0,'其它区',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620800,620000,'1|620000',1,'平凉市',0,3,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620802,620800,'1|620000|620800',0,'崆峒区',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620821,620800,'1|620000|620800',0,'泾川县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620822,620800,'1|620000|620800',0,'灵台县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620823,620800,'1|620000|620800',0,'崇信县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620824,620800,'1|620000|620800',0,'华亭县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620825,620800,'1|620000|620800',0,'庄浪县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620826,620800,'1|620000|620800',0,'静宁县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620827,620800,'1|620000|620800',0,'其它区',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620900,620000,'1|620000',1,'酒泉市',0,3,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620902,620900,'1|620000|620900',0,'肃州区',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620921,620900,'1|620000|620900',0,'金塔县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620922,620900,'1|620000|620900',0,'瓜州县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620923,620900,'1|620000|620900',0,'肃北蒙古族自治县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:12'),(620924,620900,'1|620000|620900',0,'阿克塞哈萨克族自治县',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:13'),(620981,620900,'1|620000|620900',0,'玉门市',0,4,1,'2014-05-05 12:03:07','2014-05-05 12:39:13'),(620982,620900,'1|620000|620900',0,'敦煌市',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(620983,620900,'1|620000|620900',0,'其它区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621000,620000,'1|620000',1,'庆阳市',0,3,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621002,621000,'1|620000|621000',0,'西峰区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621021,621000,'1|620000|621000',0,'庆城县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621022,621000,'1|620000|621000',0,'环县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621023,621000,'1|620000|621000',0,'华池县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621024,621000,'1|620000|621000',0,'合水县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621025,621000,'1|620000|621000',0,'正宁县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621026,621000,'1|620000|621000',0,'宁县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621027,621000,'1|620000|621000',0,'镇原县',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621028,621000,'1|620000|621000',0,'其它区',0,4,1,'2014-05-05 12:03:06','2014-05-05 12:39:13'),(621100,620000,'1|620000',1,'定西市',0,3,1,'2014-05-05 12:03:10','2014-05-05 12:39:13'),(621102,621100,'1|620000|621100',0,'安定区',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:13'),(621121,621100,'1|620000|621100',0,'通渭县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:13'),(621122,621100,'1|620000|621100',0,'陇西县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:13'),(621123,621100,'1|620000|621100',0,'渭源县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:13'),(621124,621100,'1|620000|621100',0,'临洮县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:13'),(621125,621100,'1|620000|621100',0,'漳县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:14'),(621126,621100,'1|620000|621100',0,'岷县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:14'),(621127,621100,'1|620000|621100',0,'其它区',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:14'),(621200,620000,'1|620000',1,'陇南市',0,3,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621202,621200,'1|620000|621200',0,'武都区',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621221,621200,'1|620000|621200',0,'成县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621222,621200,'1|620000|621200',0,'文县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621223,621200,'1|620000|621200',0,'宕昌县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621224,621200,'1|620000|621200',0,'康县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621225,621200,'1|620000|621200',0,'西和县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621226,621200,'1|620000|621200',0,'礼县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621227,621200,'1|620000|621200',0,'徽县',0,4,1,'2014-05-05 12:03:09','2014-05-05 12:39:14'),(621228,621200,'1|620000|621200',0,'两当县',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:14'),(621229,621200,'1|620000|621200',0,'其它区',0,4,1,'2014-05-05 12:03:10','2014-05-05 12:39:14'),(622900,620000,'1|620000',1,'临夏回族自治州',0,3,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622901,622900,'1|620000|622900',0,'临夏市',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622921,622900,'1|620000|622900',0,'临夏县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622922,622900,'1|620000|622900',0,'康乐县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622923,622900,'1|620000|622900',0,'永靖县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622924,622900,'1|620000|622900',0,'广河县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622925,622900,'1|620000|622900',0,'和政县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622926,622900,'1|620000|622900',0,'东乡族自治县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622927,622900,'1|620000|622900',0,'积石山保安族东乡族撒拉族自治县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(622928,622900,'1|620000|622900',0,'其它区',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(623000,620000,'1|620000',1,'甘南藏族自治州',0,3,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(623001,623000,'1|620000|623000',0,'合作市',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(623021,623000,'1|620000|623000',0,'临潭县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(623022,623000,'1|620000|623000',0,'卓尼县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(623023,623000,'1|620000|623000',0,'舟曲县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:14'),(623024,623000,'1|620000|623000',0,'迭部县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:15'),(623025,623000,'1|620000|623000',0,'玛曲县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:15'),(623026,623000,'1|620000|623000',0,'碌曲县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:15'),(623027,623000,'1|620000|623000',0,'夏河县',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:15'),(623028,623000,'1|620000|623000',0,'其它区',0,4,1,'2014-05-05 12:00:38','2014-05-05 12:39:15'),(630000,1,'1',1,'青海省',0,2,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630100,630000,'1|630000',1,'西宁市',0,3,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630102,630100,'1|630000|630100',0,'城东区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630103,630100,'1|630000|630100',0,'城中区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630104,630100,'1|630000|630100',0,'城西区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630105,630100,'1|630000|630100',0,'城北区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630121,630100,'1|630000|630100',0,'大通回族土族自治县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630122,630100,'1|630000|630100',0,'湟中县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630123,630100,'1|630000|630100',0,'湟源县',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(630124,630100,'1|630000|630100',0,'其它区',0,4,1,'2014-05-05 12:00:40','2014-05-05 12:39:15'),(632100,630000,'1|630000',1,'海东市',0,3,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632121,632100,'1|630000|632100',0,'平安县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632122,632100,'1|630000|632100',0,'民和回族土族自治县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632123,632100,'1|630000|632100',0,'乐都区',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632126,632100,'1|630000|632100',0,'互助土族自治县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632127,632100,'1|630000|632100',0,'化隆回族自治县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632128,632100,'1|630000|632100',0,'循化撒拉族自治县',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632129,632100,'1|630000|632100',0,'其它区',0,4,1,'2014-05-05 12:00:48','2014-05-05 12:39:15'),(632200,630000,'1|630000',1,'海北藏族自治州',0,3,1,'2014-05-05 12:00:47','2014-05-05 12:39:15'),(632221,632200,'1|630000|632200',0,'门源回族自治县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:39:15'),(632222,632200,'1|630000|632200',0,'祁连县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:39:15'),(632223,632200,'1|630000|632200',0,'海晏县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:39:15'),(632224,632200,'1|630000|632200',0,'刚察县',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:39:15'),(632225,632200,'1|630000|632200',0,'其它区',0,4,1,'2014-05-05 12:00:47','2014-05-05 12:39:16'),(632300,630000,'1|630000',1,'黄南藏族自治州',0,3,1,'2014-05-05 12:00:48','2014-05-05 12:39:16'),(632321,632300,'1|630000|632300',0,'同仁县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:16'),(632322,632300,'1|630000|632300',0,'尖扎县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:16'),(632323,632300,'1|630000|632300',0,'泽库县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:16'),(632324,632300,'1|630000|632300',0,'河南蒙古族自治县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:16'),(632325,632300,'1|630000|632300',0,'其它区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:16'),(632500,630000,'1|630000',1,'海南藏族自治州',0,3,1,'2014-05-05 12:00:51','2014-05-05 12:39:16'),(632521,632500,'1|630000|632500',0,'共和县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:39:16'),(632522,632500,'1|630000|632500',0,'同德县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:39:16'),(632523,632500,'1|630000|632500',0,'贵德县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:39:16'),(632524,632500,'1|630000|632500',0,'兴海县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:39:16'),(632525,632500,'1|630000|632500',0,'贵南县',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:39:16'),(632526,632500,'1|630000|632500',0,'其它区',0,4,1,'2014-05-05 12:00:52','2014-05-05 12:39:16'),(632600,630000,'1|630000',1,'果洛藏族自治州',0,3,1,'2014-05-05 12:00:51','2014-05-05 12:39:16'),(632621,632600,'1|630000|632600',0,'玛沁县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:16'),(632622,632600,'1|630000|632600',0,'班玛县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:16'),(632623,632600,'1|630000|632600',0,'甘德县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:16'),(632624,632600,'1|630000|632600',0,'达日县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:16'),(632625,632600,'1|630000|632600',0,'久治县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632626,632600,'1|630000|632600',0,'玛多县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632627,632600,'1|630000|632600',0,'其它区',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632700,630000,'1|630000',1,'玉树藏族自治州',0,3,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632721,632700,'1|630000|632700',0,'玉树市',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632722,632700,'1|630000|632700',0,'杂多县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632723,632700,'1|630000|632700',0,'称多县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632724,632700,'1|630000|632700',0,'治多县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632725,632700,'1|630000|632700',0,'囊谦县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632726,632700,'1|630000|632700',0,'曲麻莱县',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632727,632700,'1|630000|632700',0,'其它区',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632800,630000,'1|630000',1,'海西蒙古族藏族自治州',0,3,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632801,632800,'1|630000|632800',0,'格尔木市',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632802,632800,'1|630000|632800',0,'德令哈市',0,4,1,'2014-05-05 12:00:50','2014-05-05 12:39:17'),(632821,632800,'1|630000|632800',0,'乌兰县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632822,632800,'1|630000|632800',0,'都兰县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632823,632800,'1|630000|632800',0,'天峻县',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(632824,632800,'1|630000|632800',0,'其它区',0,4,1,'2014-05-05 12:00:51','2014-05-05 12:39:17'),(640000,1,'1',1,'宁夏回族自治区',0,2,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640100,640000,'1|640000',1,'银川市',0,3,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640104,640100,'1|640000|640100',0,'兴庆区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640105,640100,'1|640000|640100',0,'西夏区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640106,640100,'1|640000|640100',0,'金凤区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640121,640100,'1|640000|640100',0,'永宁县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640122,640100,'1|640000|640100',0,'贺兰县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640181,640100,'1|640000|640100',0,'灵武市',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640182,640100,'1|640000|640100',0,'其它区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640200,640000,'1|640000',1,'石嘴山市',0,3,1,'2014-05-05 12:00:54','2014-05-05 12:39:17'),(640202,640200,'1|640000|640200',0,'大武口区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640205,640200,'1|640000|640200',0,'惠农区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640221,640200,'1|640000|640200',0,'平罗县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640222,640200,'1|640000|640200',0,'其它区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640300,640000,'1|640000',1,'吴忠市',0,3,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640302,640300,'1|640000|640300',0,'利通区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640303,640300,'1|640000|640300',0,'红寺堡区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640323,640300,'1|640000|640300',0,'盐池县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640324,640300,'1|640000|640300',0,'同心县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640381,640300,'1|640000|640300',0,'青铜峡市',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640382,640300,'1|640000|640300',0,'其它区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640400,640000,'1|640000',1,'固原市',0,3,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640402,640400,'1|640000|640400',0,'原州区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640422,640400,'1|640000|640400',0,'西吉县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640423,640400,'1|640000|640400',0,'隆德县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640424,640400,'1|640000|640400',0,'泾源县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640425,640400,'1|640000|640400',0,'彭阳县',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640426,640400,'1|640000|640400',0,'其它区',0,4,1,'2014-05-05 12:00:54','2014-05-05 12:39:18'),(640500,640000,'1|640000',1,'中卫市',0,3,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640502,640500,'1|640000|640500',0,'沙坡头区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640521,640500,'1|640000|640500',0,'中宁县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640522,640500,'1|640000|640500',0,'海原县',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(640523,640500,'1|640000|640500',0,'其它区',0,4,1,'2014-05-05 12:00:53','2014-05-05 12:39:18'),(650000,1,'1',1,'新疆维吾尔自治区',0,2,1,'2014-05-05 12:01:10','2014-05-05 12:39:18'),(650100,650000,'1|650000',1,'乌鲁木齐市',0,3,1,'2014-05-05 12:01:10','2014-05-05 12:39:18'),(650102,650100,'1|650000|650100',0,'天山区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650103,650100,'1|650000|650100',0,'沙依巴克区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650104,650100,'1|650000|650100',0,'新市区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650105,650100,'1|650000|650100',0,'水磨沟区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650106,650100,'1|650000|650100',0,'头屯河区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650107,650100,'1|650000|650100',0,'达坂城区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650108,650100,'1|650000|650100',0,'东山区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650109,650100,'1|650000|650100',0,'米东区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650121,650100,'1|650000|650100',0,'乌鲁木齐县',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650122,650100,'1|650000|650100',0,'其它区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650200,650000,'1|650000',1,'克拉玛依市',0,3,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650202,650200,'1|650000|650200',0,'独山子区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650203,650200,'1|650000|650200',0,'克拉玛依区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650204,650200,'1|650000|650200',0,'白碱滩区',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:19'),(650205,650200,'1|650000|650200',0,'乌尔禾区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:19'),(650206,650200,'1|650000|650200',0,'其它区',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:20'),(652100,650000,'1|650000',1,'吐鲁番地区',0,3,1,'2014-05-05 12:01:37','2014-05-05 12:39:20'),(652101,652100,'1|650000|652100',0,'吐鲁番市',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:20'),(652122,652100,'1|650000|652100',0,'鄯善县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652123,652100,'1|650000|652100',0,'托克逊县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652124,652100,'1|650000|652100',0,'其它区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:20'),(652200,650000,'1|650000',1,'哈密地区',0,3,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652201,652200,'1|650000|652200',0,'哈密市',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652222,652200,'1|650000|652200',0,'巴里坤哈萨克自治县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652223,652200,'1|650000|652200',0,'伊吾县',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652224,652200,'1|650000|652200',0,'其它区',0,4,1,'2014-05-05 12:01:38','2014-05-05 12:39:20'),(652300,650000,'1|650000',1,'昌吉回族自治州',0,3,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652301,652300,'1|650000|652300',0,'昌吉市',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652302,652300,'1|650000|652300',0,'阜康市',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652303,652300,'1|650000|652300',0,'米泉市',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652323,652300,'1|650000|652300',0,'呼图壁县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652324,652300,'1|650000|652300',0,'玛纳斯县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652325,652300,'1|650000|652300',0,'奇台县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652327,652300,'1|650000|652300',0,'吉木萨尔县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652328,652300,'1|650000|652300',0,'木垒哈萨克自治县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652329,652300,'1|650000|652300',0,'其它区',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:20'),(652700,650000,'1|650000',1,'博尔塔拉蒙古自治州',0,3,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652701,652700,'1|650000|652700',0,'博乐市',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652702,652700,'1|650000|652700',0,'阿拉山口市',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652722,652700,'1|650000|652700',0,'精河县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652723,652700,'1|650000|652700',0,'温泉县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652724,652700,'1|650000|652700',0,'其它区',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652800,650000,'1|650000',1,'巴音郭楞蒙古自治州',0,3,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652801,652800,'1|650000|652800',0,'库尔勒市',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652822,652800,'1|650000|652800',0,'轮台县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652823,652800,'1|650000|652800',0,'尉犁县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652824,652800,'1|650000|652800',0,'若羌县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652825,652800,'1|650000|652800',0,'且末县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652826,652800,'1|650000|652800',0,'焉耆回族自治县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652827,652800,'1|650000|652800',0,'和静县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652828,652800,'1|650000|652800',0,'和硕县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652829,652800,'1|650000|652800',0,'博湖县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652830,652800,'1|650000|652800',0,'其它区',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652900,650000,'1|650000',1,'阿克苏地区',0,3,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652901,652900,'1|650000|652900',0,'阿克苏市',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652922,652900,'1|650000|652900',0,'温宿县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652923,652900,'1|650000|652900',0,'库车县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652924,652900,'1|650000|652900',0,'沙雅县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652925,652900,'1|650000|652900',0,'新和县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652926,652900,'1|650000|652900',0,'拜城县',0,4,1,'2014-05-05 12:01:35','2014-05-05 12:39:21'),(652927,652900,'1|650000|652900',0,'乌什县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652928,652900,'1|650000|652900',0,'阿瓦提县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652929,652900,'1|650000|652900',0,'柯坪县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(652930,652900,'1|650000|652900',0,'其它区',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:21'),(653000,650000,'1|650000',1,'克孜勒苏柯尔克孜自治州',0,3,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653001,653000,'1|650000|653000',0,'阿图什市',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653022,653000,'1|650000|653000',0,'阿克陶县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653023,653000,'1|650000|653000',0,'阿合奇县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653024,653000,'1|650000|653000',0,'乌恰县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653025,653000,'1|650000|653000',0,'其它区',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653100,650000,'1|650000',1,'喀什地区',0,3,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653101,653100,'1|650000|653100',0,'喀什市',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653121,653100,'1|650000|653100',0,'疏附县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653122,653100,'1|650000|653100',0,'疏勒县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653123,653100,'1|650000|653100',0,'英吉沙县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653124,653100,'1|650000|653100',0,'泽普县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653125,653100,'1|650000|653100',0,'莎车县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653126,653100,'1|650000|653100',0,'叶城县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653127,653100,'1|650000|653100',0,'麦盖提县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653128,653100,'1|650000|653100',0,'岳普湖县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653129,653100,'1|650000|653100',0,'伽师县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653130,653100,'1|650000|653100',0,'巴楚县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653131,653100,'1|650000|653100',0,'塔什库尔干塔吉克自治县',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653132,653100,'1|650000|653100',0,'其它区',0,4,1,'2014-05-05 12:01:36','2014-05-05 12:39:22'),(653200,650000,'1|650000',1,'和田地区',0,3,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653201,653200,'1|650000|653200',0,'和田市',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653221,653200,'1|650000|653200',0,'和田县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653222,653200,'1|650000|653200',0,'墨玉县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653223,653200,'1|650000|653200',0,'皮山县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653224,653200,'1|650000|653200',0,'洛浦县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653225,653200,'1|650000|653200',0,'策勒县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653226,653200,'1|650000|653200',0,'于田县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:22'),(653227,653200,'1|650000|653200',0,'民丰县',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:23'),(653228,653200,'1|650000|653200',0,'其它区',0,4,1,'2014-05-05 12:01:37','2014-05-05 12:39:23'),(654000,650000,'1|650000',1,'伊犁哈萨克自治州',0,3,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654002,654000,'1|650000|654000',0,'伊宁市',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654003,654000,'1|650000|654000',0,'奎屯市',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654021,654000,'1|650000|654000',0,'伊宁县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654022,654000,'1|650000|654000',0,'察布查尔锡伯自治县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654023,654000,'1|650000|654000',0,'霍城县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654024,654000,'1|650000|654000',0,'巩留县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654025,654000,'1|650000|654000',0,'新源县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654026,654000,'1|650000|654000',0,'昭苏县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654027,654000,'1|650000|654000',0,'特克斯县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654028,654000,'1|650000|654000',0,'尼勒克县',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654029,654000,'1|650000|654000',0,'其它区',0,4,1,'2014-05-05 12:01:33','2014-05-05 12:39:23'),(654200,650000,'1|650000',1,'塔城地区',0,3,1,'2014-05-05 12:01:34','2014-05-05 12:39:23'),(654201,654200,'1|650000|654200',0,'塔城市',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:23'),(654202,654200,'1|650000|654200',0,'乌苏市',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:23'),(654221,654200,'1|650000|654200',0,'额敏县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:23'),(654223,654200,'1|650000|654200',0,'沙湾县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:23'),(654224,654200,'1|650000|654200',0,'托里县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654225,654200,'1|650000|654200',0,'裕民县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654226,654200,'1|650000|654200',0,'和布克赛尔蒙古自治县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654227,654200,'1|650000|654200',0,'其它区',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654300,650000,'1|650000',1,'阿勒泰地区',0,3,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654301,654300,'1|650000|654300',0,'阿勒泰市',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654321,654300,'1|650000|654300',0,'布尔津县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654322,654300,'1|650000|654300',0,'富蕴县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654323,654300,'1|650000|654300',0,'福海县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654324,654300,'1|650000|654300',0,'哈巴河县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654325,654300,'1|650000|654300',0,'青河县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654326,654300,'1|650000|654300',0,'吉木乃县',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(654327,654300,'1|650000|654300',0,'其它区',0,4,1,'2014-05-05 12:01:34','2014-05-05 12:39:24'),(659001,650000,'1|1|650000',0,'石河子市',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:39:24'),(659002,650000,'1|1|650000',0,'阿拉尔市',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:39:24'),(659003,650000,'1|1|650000',0,'图木舒克市',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:39:24'),(659004,650000,'1|1|650000',0,'五家渠市',0,4,1,'2014-05-05 12:02:10','2014-05-05 12:39:24'),(710000,1,'1',1,'台湾',0,2,1,'2014-05-05 12:01:20','2014-05-05 12:39:24'),(710100,710000,'1|710000',1,'台北市',0,3,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710101,710100,'1|710000|710100',0,'中正区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710102,710100,'1|710000|710100',0,'大同区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710103,710100,'1|710000|710100',0,'中山区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710104,710100,'1|710000|710100',0,'松山区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710105,710100,'1|710000|710100',0,'大安区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710106,710100,'1|710000|710100',0,'万华区',0,4,1,'2014-05-05 12:01:21','2014-05-05 12:39:24'),(710107,710100,'1|710000|710100',0,'信义区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:24'),(710108,710100,'1|710000|710100',0,'士林区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:25'),(710109,710100,'1|710000|710100',0,'北投区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:25'),(710110,710100,'1|710000|710100',0,'内湖区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:25'),(710111,710100,'1|710000|710100',0,'南港区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:25'),(710112,710100,'1|710000|710100',0,'文山区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:25'),(710113,710100,'1|710000|710100',0,'其它区',0,4,1,'2014-05-05 12:01:22','2014-05-05 12:39:25'),(710200,710000,'1|710000',1,'高雄市',0,3,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710201,710200,'1|710000|710200',0,'新兴区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710202,710200,'1|710000|710200',0,'前金区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710203,710200,'1|710000|710200',0,'芩雅区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710204,710200,'1|710000|710200',0,'盐埕区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710205,710200,'1|710000|710200',0,'鼓山区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710206,710200,'1|710000|710200',0,'旗津区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710207,710200,'1|710000|710200',0,'前镇区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710208,710200,'1|710000|710200',0,'三民区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710209,710200,'1|710000|710200',0,'左营区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710210,710200,'1|710000|710200',0,'楠梓区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710211,710200,'1|710000|710200',0,'小港区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:25'),(710212,710200,'1|710000|710200',0,'其它区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:25'),(710241,710200,'1|710000|710200',0,'苓雅区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:25'),(710242,710200,'1|710000|710200',0,'仁武区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:25'),(710243,710200,'1|710000|710200',0,'大社区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:25'),(710244,710200,'1|710000|710200',0,'冈山区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710245,710200,'1|710000|710200',0,'路竹区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710246,710200,'1|710000|710200',0,'阿莲区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710247,710200,'1|710000|710200',0,'田寮区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710248,710200,'1|710000|710200',0,'燕巢区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:39:26'),(710249,710200,'1|710000|710200',0,'桥头区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:39:26'),(710250,710200,'1|710000|710200',0,'梓官区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710251,710200,'1|710000|710200',0,'弥陀区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710252,710200,'1|710000|710200',0,'永安区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:39:26'),(710253,710200,'1|710000|710200',0,'湖内区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:39:26'),(710254,710200,'1|710000|710200',0,'凤山区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:39:26'),(710255,710200,'1|710000|710200',0,'大寮区',0,4,1,'2014-05-05 12:01:23','2014-05-05 12:39:26'),(710256,710200,'1|710000|710200',0,'林园区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710257,710200,'1|710000|710200',0,'鸟松区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710258,710200,'1|710000|710200',0,'大树区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710259,710200,'1|710000|710200',0,'旗山区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710260,710200,'1|710000|710200',0,'美浓区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710261,710200,'1|710000|710200',0,'六龟区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710262,710200,'1|710000|710200',0,'内门区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710263,710200,'1|710000|710200',0,'杉林区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710264,710200,'1|710000|710200',0,'甲仙区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710265,710200,'1|710000|710200',0,'桃源区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:26'),(710266,710200,'1|710000|710200',0,'那玛夏区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:27'),(710267,710200,'1|710000|710200',0,'茂林区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:27'),(710268,710200,'1|710000|710200',0,'茄萣区',0,4,1,'2014-05-05 12:01:24','2014-05-05 12:39:27'),(710300,710000,'1|710000',1,'台南市',0,3,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710301,710300,'1|710000|710300',0,'中西区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710302,710300,'1|710000|710300',0,'东区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710303,710300,'1|710000|710300',0,'南区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710304,710300,'1|710000|710300',0,'北区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710305,710300,'1|710000|710300',0,'安平区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710306,710300,'1|710000|710300',0,'安南区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710307,710300,'1|710000|710300',0,'其它区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:27'),(710339,710300,'1|710000|710300',0,'永康区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710340,710300,'1|710000|710300',0,'归仁区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710341,710300,'1|710000|710300',0,'新化区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710342,710300,'1|710000|710300',0,'左镇区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710343,710300,'1|710000|710300',0,'玉井区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710344,710300,'1|710000|710300',0,'楠西区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710345,710300,'1|710000|710300',0,'南化区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710346,710300,'1|710000|710300',0,'仁德区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710347,710300,'1|710000|710300',0,'关庙区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:27'),(710348,710300,'1|710000|710300',0,'龙崎区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710349,710300,'1|710000|710300',0,'官田区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710350,710300,'1|710000|710300',0,'麻豆区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710351,710300,'1|710000|710300',0,'佳里区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710352,710300,'1|710000|710300',0,'西港区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710353,710300,'1|710000|710300',0,'七股区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710354,710300,'1|710000|710300',0,'将军区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710355,710300,'1|710000|710300',0,'学甲区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710356,710300,'1|710000|710300',0,'北门区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710357,710300,'1|710000|710300',0,'新营区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710358,710300,'1|710000|710300',0,'后壁区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710359,710300,'1|710000|710300',0,'白河区',0,4,1,'2014-05-05 12:01:26','2014-05-05 12:39:28'),(710360,710300,'1|710000|710300',0,'东山区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710361,710300,'1|710000|710300',0,'六甲区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710362,710300,'1|710000|710300',0,'下营区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710363,710300,'1|710000|710300',0,'柳营区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710364,710300,'1|710000|710300',0,'盐水区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710365,710300,'1|710000|710300',0,'善化区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710366,710300,'1|710000|710300',0,'大内区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710367,710300,'1|710000|710300',0,'山上区',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:28'),(710368,710300,'1|710000|710300',0,'新市区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:28'),(710369,710300,'1|710000|710300',0,'安定区',0,4,1,'2014-05-05 12:01:25','2014-05-05 12:39:28'),(710400,710000,'1|710000',1,'台中市',0,3,1,'2014-05-05 12:01:30','2014-05-05 12:39:28'),(710401,710400,'1|710000|710400',0,'中区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:28'),(710402,710400,'1|710000|710400',0,'东区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:29'),(710403,710400,'1|710000|710400',0,'南区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:29'),(710404,710400,'1|710000|710400',0,'西区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:29'),(710405,710400,'1|710000|710400',0,'北区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:29'),(710406,710400,'1|710000|710400',0,'北屯区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:29'),(710407,710400,'1|710000|710400',0,'西屯区',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:29'),(710408,710400,'1|710000|710400',0,'南屯区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710409,710400,'1|710000|710400',0,'其它区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710431,710400,'1|710000|710400',0,'太平区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710432,710400,'1|710000|710400',0,'大里区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710433,710400,'1|710000|710400',0,'雾峰区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710434,710400,'1|710000|710400',0,'乌日区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710435,710400,'1|710000|710400',0,'丰原区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710436,710400,'1|710000|710400',0,'后里区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710437,710400,'1|710000|710400',0,'石冈区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710438,710400,'1|710000|710400',0,'东势区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710439,710400,'1|710000|710400',0,'和平区',0,4,1,'2014-05-05 12:01:30','2014-05-05 12:39:29'),(710440,710400,'1|710000|710400',0,'新社区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710441,710400,'1|710000|710400',0,'潭子区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710442,710400,'1|710000|710400',0,'大雅区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710443,710400,'1|710000|710400',0,'神冈区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710444,710400,'1|710000|710400',0,'大肚区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710445,710400,'1|710000|710400',0,'沙鹿区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710446,710400,'1|710000|710400',0,'龙井区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710447,710400,'1|710000|710400',0,'梧栖区',0,4,1,'2014-05-05 12:01:29','2014-05-05 12:39:29'),(710448,710400,'1|710000|710400',0,'清水区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710449,710400,'1|710000|710400',0,'大甲区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710450,710400,'1|710000|710400',0,'外埔区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710451,710400,'1|710000|710400',0,'大安区',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710500,710000,'1|710000',1,'金门县',0,3,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710507,710500,'1|710000|710500',0,'金沙镇',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710508,710500,'1|710000|710500',0,'金湖镇',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710509,710500,'1|710000|710500',0,'金宁乡',0,4,1,'2014-05-05 12:01:28','2014-05-05 12:39:30'),(710510,710500,'1|710000|710500',0,'金城镇',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:30'),(710511,710500,'1|710000|710500',0,'烈屿乡',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:30'),(710512,710500,'1|710000|710500',0,'乌坵乡',0,4,1,'2014-05-05 12:01:27','2014-05-05 12:39:30'),(710600,710000,'1|710000',1,'南投县',0,3,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710614,710600,'1|710000|710600',0,'南投市',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710615,710600,'1|710000|710600',0,'中寮乡',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710616,710600,'1|710000|710600',0,'草屯镇',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710617,710600,'1|710000|710600',0,'国姓乡',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710618,710600,'1|710000|710600',0,'埔里镇',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710619,710600,'1|710000|710600',0,'仁爱乡',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710620,710600,'1|710000|710600',0,'名间乡',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710621,710600,'1|710000|710600',0,'集集镇',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710622,710600,'1|710000|710600',0,'水里乡',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710623,710600,'1|710000|710600',0,'鱼池乡',0,4,1,'2014-05-05 12:01:32','2014-05-05 12:39:30'),(710624,710600,'1|710000|710600',0,'信义乡',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710625,710600,'1|710000|710600',0,'竹山镇',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710626,710600,'1|710000|710600',0,'鹿谷乡',0,4,1,'2014-05-05 12:01:31','2014-05-05 12:39:30'),(710700,710000,'1|710000',1,'基隆市',0,3,1,'2014-05-05 12:01:02','2014-05-05 12:39:30'),(710701,710700,'1|710000|710700',0,'仁爱区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710702,710700,'1|710000|710700',0,'信义区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710703,710700,'1|710000|710700',0,'中正区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710704,710700,'1|710000|710700',0,'中山区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710705,710700,'1|710000|710700',0,'安乐区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710706,710700,'1|710000|710700',0,'暖暖区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710707,710700,'1|710000|710700',0,'七堵区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710708,710700,'1|710000|710700',0,'其它区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(710800,710000,'1|710000',1,'新竹市',0,3,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710801,710800,'1|710000|710800',0,'东区',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710802,710800,'1|710000|710800',0,'北区',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710803,710800,'1|710000|710800',0,'香山区',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710804,710800,'1|710000|710800',0,'其它区',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710900,710000,'1|710000',1,'嘉义市',0,3,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710901,710900,'1|710000|710900',0,'东区',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710902,710900,'1|710000|710900',0,'西区',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:31'),(710903,710900,'1|710000|710900',0,'其它区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711100,710000,'1|710000',1,'新北市',0,3,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711130,711100,'1|710000|711100',0,'万里区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711131,711100,'1|710000|711100',0,'金山区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711132,711100,'1|710000|711100',0,'板桥区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711133,711100,'1|710000|711100',0,'汐止区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711134,711100,'1|710000|711100',0,'深坑区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711135,711100,'1|710000|711100',0,'石碇区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711136,711100,'1|710000|711100',0,'瑞芳区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:31'),(711137,711100,'1|710000|711100',0,'平溪区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711138,711100,'1|710000|711100',0,'双溪区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711139,711100,'1|710000|711100',0,'贡寮区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:31'),(711140,711100,'1|710000|711100',0,'新店区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711141,711100,'1|710000|711100',0,'坪林区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711142,711100,'1|710000|711100',0,'乌来区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711143,711100,'1|710000|711100',0,'永和区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711144,711100,'1|710000|711100',0,'中和区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711145,711100,'1|710000|711100',0,'土城区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711146,711100,'1|710000|711100',0,'三峡区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711147,711100,'1|710000|711100',0,'树林区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711148,711100,'1|710000|711100',0,'莺歌区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711149,711100,'1|710000|711100',0,'三重区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711150,711100,'1|710000|711100',0,'新庄区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711151,711100,'1|710000|711100',0,'泰山区',0,4,1,'2014-05-05 12:01:02','2014-05-05 12:39:32'),(711152,711100,'1|710000|711100',0,'林口区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711153,711100,'1|710000|711100',0,'芦洲区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711154,711100,'1|710000|711100',0,'五股区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711155,711100,'1|710000|711100',0,'八里区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711156,711100,'1|710000|711100',0,'淡水区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711157,711100,'1|710000|711100',0,'三芝区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711158,711100,'1|710000|711100',0,'石门区',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:32'),(711200,710000,'1|710000',1,'宜兰县',0,3,1,'2014-05-05 12:01:05','2014-05-05 12:39:32'),(711214,711200,'1|710000|711200',0,'宜兰市',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:32'),(711215,711200,'1|710000|711200',0,'头城镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:32'),(711216,711200,'1|710000|711200',0,'礁溪乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:32'),(711217,711200,'1|710000|711200',0,'壮围乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:32'),(711218,711200,'1|710000|711200',0,'员山乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711219,711200,'1|710000|711200',0,'罗东镇',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711220,711200,'1|710000|711200',0,'三星乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711221,711200,'1|710000|711200',0,'大同乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711222,711200,'1|710000|711200',0,'五结乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711223,711200,'1|710000|711200',0,'冬山乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711224,711200,'1|710000|711200',0,'苏澳镇',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711225,711200,'1|710000|711200',0,'南澳乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711226,711200,'1|710000|711200',0,'钓鱼台',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711300,710000,'1|710000',1,'新竹县',0,3,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711314,711300,'1|710000|711300',0,'竹北市',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711315,711300,'1|710000|711300',0,'湖口乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711316,711300,'1|710000|711300',0,'新丰乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711317,711300,'1|710000|711300',0,'新埔镇',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711318,711300,'1|710000|711300',0,'关西镇',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711319,711300,'1|710000|711300',0,'芎林乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711320,711300,'1|710000|711300',0,'宝山乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711321,711300,'1|710000|711300',0,'竹东镇',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711322,711300,'1|710000|711300',0,'五峰乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711323,711300,'1|710000|711300',0,'横山乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711324,711300,'1|710000|711300',0,'尖石乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711325,711300,'1|710000|711300',0,'北埔乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711326,711300,'1|710000|711300',0,'峨眉乡',0,4,1,'2014-05-05 12:01:03','2014-05-05 12:39:33'),(711400,710000,'1|710000',1,'桃园县',0,3,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711414,711400,'1|710000|711400',0,'中坜市',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711415,711400,'1|710000|711400',0,'平镇市',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711416,711400,'1|710000|711400',0,'龙潭乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711417,711400,'1|710000|711400',0,'杨梅市',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711418,711400,'1|710000|711400',0,'新屋乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:33'),(711419,711400,'1|710000|711400',0,'观音乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:34'),(711420,711400,'1|710000|711400',0,'桃园市',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:34'),(711421,711400,'1|710000|711400',0,'龟山乡',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:34'),(711422,711400,'1|710000|711400',0,'八德市',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:34'),(711423,711400,'1|710000|711400',0,'大溪镇',0,4,1,'2014-05-05 12:01:04','2014-05-05 12:39:34'),(711424,711400,'1|710000|711400',0,'复兴乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:34'),(711425,711400,'1|710000|711400',0,'大园乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:34'),(711426,711400,'1|710000|711400',0,'芦竹乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:34'),(711500,710000,'1|710000',1,'苗栗县',0,3,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711519,711500,'1|710000|711500',0,'竹南镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711520,711500,'1|710000|711500',0,'头份镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711521,711500,'1|710000|711500',0,'三湾乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711522,711500,'1|710000|711500',0,'南庄乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711523,711500,'1|710000|711500',0,'狮潭乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711524,711500,'1|710000|711500',0,'后龙镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711525,711500,'1|710000|711500',0,'通霄镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711526,711500,'1|710000|711500',0,'苑里镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711527,711500,'1|710000|711500',0,'苗栗市',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711528,711500,'1|710000|711500',0,'造桥乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711529,711500,'1|710000|711500',0,'头屋乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711530,711500,'1|710000|711500',0,'公馆乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711531,711500,'1|710000|711500',0,'大湖乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711532,711500,'1|710000|711500',0,'泰安乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711533,711500,'1|710000|711500',0,'铜锣乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711534,711500,'1|710000|711500',0,'三义乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711535,711500,'1|710000|711500',0,'西湖乡',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711536,711500,'1|710000|711500',0,'卓兰镇',0,4,1,'2014-05-05 12:01:05','2014-05-05 12:39:35'),(711700,710000,'1|710000',1,'彰化县',0,3,1,'2014-05-05 12:01:07','2014-05-05 12:39:35'),(711727,711700,'1|710000|711700',0,'彰化市',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:35'),(711728,711700,'1|710000|711700',0,'芬园乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:35'),(711729,711700,'1|710000|711700',0,'花坛乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:35'),(711730,711700,'1|710000|711700',0,'秀水乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:35'),(711731,711700,'1|710000|711700',0,'鹿港镇',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:35'),(711732,711700,'1|710000|711700',0,'福兴乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711733,711700,'1|710000|711700',0,'线西乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711734,711700,'1|710000|711700',0,'和美镇',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711735,711700,'1|710000|711700',0,'伸港乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711736,711700,'1|710000|711700',0,'员林镇',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711737,711700,'1|710000|711700',0,'社头乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711738,711700,'1|710000|711700',0,'永靖乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711739,711700,'1|710000|711700',0,'埔心乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711740,711700,'1|710000|711700',0,'溪湖镇',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711741,711700,'1|710000|711700',0,'大村乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711742,711700,'1|710000|711700',0,'埔盐乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711743,711700,'1|710000|711700',0,'田中镇',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:36'),(711744,711700,'1|710000|711700',0,'北斗镇',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711745,711700,'1|710000|711700',0,'田尾乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711746,711700,'1|710000|711700',0,'埤头乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711747,711700,'1|710000|711700',0,'溪州乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711748,711700,'1|710000|711700',0,'竹塘乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711749,711700,'1|710000|711700',0,'二林镇',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711750,711700,'1|710000|711700',0,'大城乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711751,711700,'1|710000|711700',0,'芳苑乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711752,711700,'1|710000|711700',0,'二水乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711900,710000,'1|710000',1,'嘉义县',0,3,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711919,711900,'1|710000|711900',0,'番路乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711920,711900,'1|710000|711900',0,'梅山乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711921,711900,'1|710000|711900',0,'竹崎乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:36'),(711922,711900,'1|710000|711900',0,'阿里山乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711923,711900,'1|710000|711900',0,'中埔乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711924,711900,'1|710000|711900',0,'大埔乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711925,711900,'1|710000|711900',0,'水上乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711926,711900,'1|710000|711900',0,'鹿草乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711927,711900,'1|710000|711900',0,'太保市',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711928,711900,'1|710000|711900',0,'朴子市',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711929,711900,'1|710000|711900',0,'东石乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711930,711900,'1|710000|711900',0,'六脚乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711931,711900,'1|710000|711900',0,'新港乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711932,711900,'1|710000|711900',0,'民雄乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711933,711900,'1|710000|711900',0,'大林镇',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711934,711900,'1|710000|711900',0,'溪口乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711935,711900,'1|710000|711900',0,'义竹乡',0,4,1,'2014-05-05 12:01:06','2014-05-05 12:39:37'),(711936,711900,'1|710000|711900',0,'布袋镇',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712100,710000,'1|710000',1,'云林县',0,3,1,'2014-05-05 12:01:08','2014-05-05 12:39:37'),(712121,712100,'1|710000|712100',0,'斗南镇',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712122,712100,'1|710000|712100',0,'大埤乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712123,712100,'1|710000|712100',0,'虎尾镇',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712124,712100,'1|710000|712100',0,'土库镇',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712125,712100,'1|710000|712100',0,'褒忠乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712126,712100,'1|710000|712100',0,'东势乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:37'),(712127,712100,'1|710000|712100',0,'台西乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:37'),(712128,712100,'1|710000|712100',0,'仑背乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:37'),(712129,712100,'1|710000|712100',0,'麦寮乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:37'),(712130,712100,'1|710000|712100',0,'斗六市',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:37'),(712131,712100,'1|710000|712100',0,'林内乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:37'),(712132,712100,'1|710000|712100',0,'古坑乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:37'),(712133,712100,'1|710000|712100',0,'莿桐乡',0,4,1,'2014-05-05 12:01:07','2014-05-05 12:39:38'),(712134,712100,'1|710000|712100',0,'西螺镇',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712135,712100,'1|710000|712100',0,'二仑乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712136,712100,'1|710000|712100',0,'北港镇',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712137,712100,'1|710000|712100',0,'水林乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712138,712100,'1|710000|712100',0,'口湖乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712139,712100,'1|710000|712100',0,'四湖乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712140,712100,'1|710000|712100',0,'元长乡',0,4,1,'2014-05-05 12:01:08','2014-05-05 12:39:38'),(712400,710000,'1|710000',1,'屏东县',0,3,1,'2014-05-05 12:01:10','2014-05-05 12:39:38'),(712434,712400,'1|710000|712400',0,'屏东市',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712435,712400,'1|710000|712400',0,'三地门乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712436,712400,'1|710000|712400',0,'雾台乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712437,712400,'1|710000|712400',0,'玛家乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712438,712400,'1|710000|712400',0,'九如乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712439,712400,'1|710000|712400',0,'里港乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712440,712400,'1|710000|712400',0,'高树乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712441,712400,'1|710000|712400',0,'盐埔乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712442,712400,'1|710000|712400',0,'长治乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712443,712400,'1|710000|712400',0,'麟洛乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712444,712400,'1|710000|712400',0,'竹田乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712445,712400,'1|710000|712400',0,'内埔乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712446,712400,'1|710000|712400',0,'万丹乡',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712447,712400,'1|710000|712400',0,'潮州镇',0,4,1,'2014-05-05 12:01:09','2014-05-05 12:39:38'),(712448,712400,'1|710000|712400',0,'泰武乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:38'),(712449,712400,'1|710000|712400',0,'来义乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712450,712400,'1|710000|712400',0,'万峦乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712451,712400,'1|710000|712400',0,'崁顶乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712452,712400,'1|710000|712400',0,'新埤乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712453,712400,'1|710000|712400',0,'南州乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712454,712400,'1|710000|712400',0,'林边乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712455,712400,'1|710000|712400',0,'东港镇',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712456,712400,'1|710000|712400',0,'琉球乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712457,712400,'1|710000|712400',0,'佳冬乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712458,712400,'1|710000|712400',0,'新园乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712459,712400,'1|710000|712400',0,'枋寮乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:42'),(712460,712400,'1|710000|712400',0,'枋山乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712461,712400,'1|710000|712400',0,'春日乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712462,712400,'1|710000|712400',0,'狮子乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712463,712400,'1|710000|712400',0,'车城乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712464,712400,'1|710000|712400',0,'牡丹乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712465,712400,'1|710000|712400',0,'恒春镇',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712466,712400,'1|710000|712400',0,'满州乡',0,4,1,'2014-05-05 12:01:12','2014-05-05 12:39:39'),(712500,710000,'1|710000',1,'台东县',0,3,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712517,712500,'1|710000|712500',0,'台东市',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712518,712500,'1|710000|712500',0,'绿岛乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712519,712500,'1|710000|712500',0,'兰屿乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712520,712500,'1|710000|712500',0,'延平乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712521,712500,'1|710000|712500',0,'卑南乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712522,712500,'1|710000|712500',0,'鹿野乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712523,712500,'1|710000|712500',0,'关山镇',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712524,712500,'1|710000|712500',0,'海端乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712525,712500,'1|710000|712500',0,'池上乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712526,712500,'1|710000|712500',0,'东河乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712527,712500,'1|710000|712500',0,'成功镇',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712528,712500,'1|710000|712500',0,'长滨乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712529,712500,'1|710000|712500',0,'金峰乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712530,712500,'1|710000|712500',0,'大武乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712531,712500,'1|710000|712500',0,'达仁乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712532,712500,'1|710000|712500',0,'太麻里乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712600,710000,'1|710000',1,'花莲县',0,3,1,'2014-05-05 12:01:11','2014-05-05 12:39:39'),(712615,712600,'1|710000|712600',0,'花莲市',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712616,712600,'1|710000|712600',0,'新城乡',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712617,712600,'1|710000|712600',0,'太鲁阁',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712618,712600,'1|710000|712600',0,'秀林乡',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712619,712600,'1|710000|712600',0,'吉安乡',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712620,712600,'1|710000|712600',0,'寿丰乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712621,712600,'1|710000|712600',0,'凤林镇',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712622,712600,'1|710000|712600',0,'光复乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712623,712600,'1|710000|712600',0,'丰滨乡',0,4,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712624,712600,'1|710000|712600',0,'瑞穗乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712625,712600,'1|710000|712600',0,'万荣乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712626,712600,'1|710000|712600',0,'玉里镇',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712627,712600,'1|710000|712600',0,'卓溪乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712628,712600,'1|710000|712600',0,'富里乡',0,4,1,'2014-05-05 12:01:11','2014-05-05 12:39:40'),(712700,710000,'1|710000',1,'澎湖县',0,3,1,'2014-05-05 12:01:10','2014-05-05 12:39:40'),(712707,712700,'1|710000|712700',0,'马公市',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712708,712700,'1|710000|712700',0,'西屿乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712709,712700,'1|710000|712700',0,'望安乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712710,712700,'1|710000|712700',0,'七美乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712711,712700,'1|710000|712700',0,'白沙乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712712,712700,'1|710000|712700',0,'湖西乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712800,710000,'1|710000',1,'连江县',0,3,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712805,712800,'1|710000|712800',0,'南竿乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712806,712800,'1|710000|712800',0,'北竿乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712807,712800,'1|710000|712800',0,'莒光乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(712808,712800,'1|710000|712800',0,'东引乡',0,4,1,'2014-05-05 12:01:01','2014-05-05 12:39:40'),(810000,1,'1',1,'香港特别行政区',0,2,1,'2014-05-05 12:01:42','2014-05-05 12:39:40'),(810100,810000,'1|810000',1,'香港岛',0,3,1,'2014-05-05 12:01:42','2014-05-05 12:39:40'),(810101,810100,'1|810000|810100',0,'中西区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:39:41'),(810102,810100,'1|810000|810100',0,'湾仔',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:39:41'),(810103,810100,'1|810000|810100',0,'东区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:39:41'),(810104,810100,'1|810000|810100',0,'南区',0,4,1,'2014-05-05 12:01:42','2014-05-05 12:39:41'),(810200,810000,'1|810000',1,'九龙',0,3,1,'2014-05-05 12:01:41','2014-05-05 12:39:41'),(810201,810200,'1|810000|810200',0,'九龙城区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:39:41'),(810202,810200,'1|810000|810200',0,'油尖旺区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:39:41'),(810203,810200,'1|810000|810200',0,'深水埗区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:39:41'),(810204,810200,'1|810000|810200',0,'黄大仙区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:39:41'),(810205,810200,'1|810000|810200',0,'观塘区',0,4,1,'2014-05-05 12:01:41','2014-05-05 12:39:41'),(810300,810000,'1|810000',1,'新界',0,3,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810301,810300,'1|810000|810300',0,'北区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810302,810300,'1|810000|810300',0,'大埔区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810303,810300,'1|810000|810300',0,'沙田区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810304,810300,'1|810000|810300',0,'西贡区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810305,810300,'1|810000|810300',0,'元朗区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810306,810300,'1|810000|810300',0,'屯门区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810307,810300,'1|810000|810300',0,'荃湾区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810308,810300,'1|810000|810300',0,'葵青区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(810309,810300,'1|810000|810300',0,'离岛区',0,4,1,'2014-05-05 12:01:39','2014-05-05 12:39:41'),(820000,1,'1',1,'澳门特别行政区',0,2,1,'2014-05-05 12:00:56','2014-05-05 12:39:41'),(820100,820000,'1|820000',1,'澳门半岛',0,3,1,'2014-05-05 12:00:56','2014-05-05 12:39:41'),(820200,820000,'1|820000',1,'离岛',0,3,1,'2014-05-05 12:00:56','2014-05-05 12:39:41'),(990000,1,'1',1,'海外',0,2,1,'2014-05-05 12:02:54','2014-05-05 12:39:41'),(990100,990000,'1|990000',1,'海外',0,3,1,'2014-05-05 12:02:55','2014-05-05 12:39:41');

update fx_city_region set cr_name='藁城区' where cr_id='130182';
update fx_city_region set cr_name='鹿泉区' where cr_id='130185';
update fx_city_region set cr_name='浑南区' where cr_id='210112';
update fx_city_region set cr_name='九台区' where cr_id='220181';
update fx_city_region set cr_name='双城区' where cr_id='230182';
update fx_city_region set cr_name='赣榆区' where cr_id='320721';
update fx_city_region set cr_name='富阳区' where cr_id='330183';
update fx_city_region set cr_name='柯桥区' where cr_id='330621';
update fx_city_region set cr_name='上虞区' where cr_id='330682';
update fx_city_region set cr_name='建阳区' where cr_id='350784';
update fx_city_region set cr_name='永定区' where cr_id='350822';
update fx_city_region set cr_name='南康区' where cr_id='360782';
update fx_city_region set cr_name='广丰区' where cr_id='361122';
update fx_city_region set cr_name='兖州区' where cr_id='370882';
update fx_city_region set cr_name='文登区' where cr_id='371081';
update fx_city_region set cr_name='兰陵县' where cr_id='371324';
update fx_city_region set cr_name='陵城区' where cr_id='371421';
update fx_city_region set cr_name='沾化区' where cr_id='371624';
update fx_city_region set cr_name='祥符区' where cr_id='410224';
update fx_city_region set cr_name='陕州区' where cr_id='411222';
update fx_city_region set cr_name='郧阳区' where cr_id='420321';
update fx_city_region set cr_name='增城区' where cr_id='440183';
update fx_city_region set cr_name='从化区' where cr_id='440184';
update fx_city_region set cr_name='电白区' where cr_id='440903';
update fx_city_region set cr_name='梅县区' where cr_id='441421';
update fx_city_region set cr_name='阳东区' where cr_id='441723';
update fx_city_region set cr_name='云安区' where cr_id='445323';
update fx_city_region set cr_name='武鸣区' where cr_id='450122';
update fx_city_region set cr_name='铜梁区' where cr_id='500224';
update fx_city_region set cr_name='璧山区' where cr_id='500227';
update fx_city_region set cr_name='彭山区' where cr_id='511422';
update fx_city_region set cr_name='康定市' where cr_id='513321';
update fx_city_region set cr_name='平坝区' where cr_id='520421';
update fx_city_region set cr_name='香格里拉市' where cr_id='533421';
update fx_city_region set cr_name='昌都市' where cr_id='542100';
update fx_city_region set cr_name='卡若区' where cr_id='542121';
update fx_city_region set cr_name='桑珠孜区' where cr_id='542301';
update fx_city_region set cr_name='日喀则市' where cr_id='542300';
update fx_city_region set cr_name='林芝市' where cr_id='542600';
update fx_city_region set cr_name='巴宜区' where cr_id='542621';
update fx_city_region set cr_name='高陵区' where cr_id='610126';
update fx_city_region set cr_name='平安区' where cr_id='632121';
update fx_city_region set cr_name='吐鲁番市' where cr_id='652100';
update fx_city_region set cr_name='高昌区' where cr_id='652101';

INSERT INTO `fx_source_platform` VALUES (1,'taobao','淘宝',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(2,'paipai','拍拍',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(3,'dangdang','当当',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(4,'360buy','京东',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(5,'amazon','亚马逊',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(6,'suning','苏宁易购',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(8,'WX','微信平台','0','1','2015-09-25 00:00:00','2015-09-25 00:00:00'),(7,'1haodian','一号店',1,1,'2013-05-29 04:12:12','2013-05-29 04:12:12'),(11,'QQ','腾讯',1,1,'2013-12-08 11:56:24','0000-00-00 00:00:00'),(12,'Sina','新浪微博',1,1,'2013-12-08 11:56:24','0000-00-00 00:00:00'),(13,'RenRen','人人网',1,1,'2013-12-08 11:56:24','0000-00-00 00:00:00');
INSERT INTO `fx_refunds_reason` VALUE ("1",'卖家缺货','1','1','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("2",'收到的物品不符','1','2','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("3",'商品质量问题','1','3','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("4",'未按约定时间发货','1','4','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("5",'买家拍错商品','1','5','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("6",'与卖家协商一致','1','6','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("7",'其他','1','7','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("8",'七天无理由退换货','1','2','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("9",'收到假货','2','2','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("10",'商品需要维修','2','3','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("11",'发票问题','2','4','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("12",'收到商品破损','2','5','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("13",'商品错发/漏发','2','6','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("14",'收到商品描述不符','2','7','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("15",'商品未按约定时间发货','2','8','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52'),("16",'商品质量问题','2','9','1','1','1','2015-07-03 10:52:52','2015-07-03 10:52:52');
INSERT INTO `fx_script_info` VALUES ('自动确认收货', 'confirmorderstatus', 'ConfirmOrderstatus', '10', '2015-11-24 13:00:00', '0', '1'),('自动确认完成', 'FinishOrderstatus', 'FinishOrderstatus', '10', '2015-11-24 13:00:00', '0', '1');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Home', '官网模板', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSetting', '查看官网基本信息设置', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSet', '更新官网基本信息', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageClose', '暂停营业公告', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSetClose', '添加/修改暂停营业公告', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageRegister', '注册协议', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddRegister', '处理注册协议', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageTpl', '官网模板管理', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageTopAd', '首页头部广告图片管理', 'Home', '官网模板', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Notice', '网站公告', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '公告列表', 'Notice', '网站公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '发布公告', 'Notice', '网站公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '处理添加公告', 'Notice', '网站公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑公告', 'Notice', '网站公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新公告', 'Notice', '网站公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除公告', 'Notice', '网站公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Announcement', '违规公告', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '违规公告列表', 'Announcement', '违规公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增违规公告', 'Announcement', '违规公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加违规公告', 'Announcement', '违规公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑违规公告', 'Announcement', '违规公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新违规公告', 'Announcement', '违规公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除违规公告', 'Announcement', '违规公告', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Article', '官网资讯', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '官网资讯列表', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增官网资讯', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加官网资讯', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑资讯', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新资讯', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除资讯', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageListCate', '官网资讯分类', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAddCate', '新增资讯分类', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddCate', '添加资讯分类', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEditCate', '编辑资讯分类', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditCate', '更新资讯分类', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelCate', '删除资讯分类', 'Article', '官网资讯', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Seo', '搜索引擎优化设置', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', 'SEO列表', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑SEO', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新SEO信息', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageMap', '站点地图设置展示', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doMapSave', '保存站点地图生成的配置信息', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doMapRefresh', '刷新站点地图缓存', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageCount', '统计脚本设置', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doCount', '保存第三方统计脚本', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageCach', '查看缓存设置', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'cachAdd', '执行保存缓存设置', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'deleteCacheDir', '删除缓存数据', 'Seo', '搜索引擎优化设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Links', '友情链接', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '友情链接列表', 'Links', '友情链接', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增友情链接', 'Links', '友情链接', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加友情链接', 'Links', '友情链接', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑友情链接', 'Links', '友情链接', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新友情链接', 'Links', '友情链接', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除友情链接', 'Links', '友情链接', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Online', '在线客服', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '在线客服列表', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增在线客服', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加在线客服', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑在线客服', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新在线客服', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除在线客服', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageListCate', '在线客服分类', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEditCate', '编辑在线客服分类', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAddCate', '新增在线客服分类', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddCate', '添加在线客服分类', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditCate', '更新在线客服分类', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelCate', '删除在线客服分类', 'Online', '在线客服', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Guestbook', '商品评论', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageProductsList', '商品评论列表', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageProductsSetting', '商品评论设置', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doPageProductsSetting', '更新商品评论设置', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doProductsDel', '商品评论删除', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doProductsAudit', '商品评论审核', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setGoodComment', '点击回复评论', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doGoodsComment', '回复评论', 'Guestbook', '商品评论', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Message', '站内信', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageMailBox', '站内信列表', 'Message', '站内信', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSend', '新增站内信', 'Message', '站内信', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加站内信', 'Message', '站内信', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageRead', '查看站内信', 'Message', '站内信', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageReply', '回复站内信', 'Message', '站内信', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doReply', '处理回复站内信', 'Message', '站内信', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除站内信', 'Message', '站内信', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Suggestions', '投诉建议', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '投诉建议列表', 'Suggestions', '投诉建议', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageDetail', '投诉建议详情', 'Suggestions', '投诉建议', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doIshandle', '处理投诉建议', 'Suggestions', '投诉建议', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Nav', '自定义导航栏', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '自定义导航列表', 'Nav', '自定义导航栏', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增自定义导航', 'Nav', '自定义导航栏', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑自定义导航', 'Nav', '自定义导航栏', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新自定义导航', 'Nav', '自定义导航栏', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除自定义导航', 'Nav', '自定义导航栏', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Operation', '日志操作记录设置', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '后台操作记录列表 ', 'Operation', '日志操作记录设置', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Products', '商品管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '商品列表', 'Products', '商品管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doGoodsisDel', '删除商品', 'Products', '商品管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageDetail', '查看商品详情', 'Products', '商品管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setGoodPoint', '设置商品积分', 'Products', '商品管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setItemSaleNumbers', '修改商品销量', 'Products', '商品管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doGoodsOnSale', '商品上下架', 'Products', '商品管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'detail', '商品预览', 'Products', '商品管理', '1', '0', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Goods', '商品管理详情', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'goodsAdd', '新增商品页面', 'Goods', '商品管理详情', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doGoodsAdd', '添加商品', 'Goods', '商品管理详情', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'goodsEdit', '商品编辑页面', 'Goods', '商品管理详情', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doGoodsEdit', '修改商品', 'Goods', '商品管理详情', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'ajaxSetGoodsFlag', '商品标记状态翻转(是否是新品、热销)', 'Goods', '商品管理详情', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'combinationGoodsList', '组合商品列表 ', 'Goods', '组合商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addCombinationGoodPage', '新增组合商品', 'Goods', '组合商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'editCombinationGoodsPage', '编辑组合商品', 'Goods', '组合商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'deleteCombiantionGoods', '删除组合商品', 'Goods', '组合商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'combinationPropertyGoodsList', '规格组合商品列表', 'Goods', '组合规格商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addCombinationPropertyGoodsPage', '添加规格组合商品', 'Goods', '组合规格商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'editCombinationPropertyGoodsPage', '规格组合商品详情', 'Goods', '组合规格商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'editCombinationPropertyGoods', '修改组合规格商品', 'Goods', '组合规格商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'ajaxDelCombinationPropertyGoods', '删除组合规格商品', 'Goods', '组合规格商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'enableCombinationPropertyGoods', '启用（停用）规格组合商品', 'Goods', '组合规格商品', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'configIndustrySpec', '行业属性配置', 'Goods', '组合商品', '1', '0', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Stock', '库存管理', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '库存调整单', 'Stock', '库存管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageDetail', '库存调整单明细', 'Stock', '库存管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增库存调整单', 'Stock', '库存管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '库存设置', 'Stock', '库存管理', '1', '0', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'GoodsCategory', '商品分类管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '商品分类列表 ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '分类编辑 ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addCategory', '添加商品分类 ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageDisplay', '更新分类显示状态(显示或不显示) ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '保存分类 ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新分类 ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除分类 ', 'GoodsCategory', '商品分类管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addCategoryPromotion', '类目促销区设置', 'GoodsCategory', '商品分类管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'GoodsType', '商品类型管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '商品类型列表 ', 'GoodsType', '商品类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addGoodsType', '类型添加 ', 'GoodsType', '商品类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'eidtGoodsType', '类型编辑 ', 'GoodsType', '商品类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelTypeDetail', '类型删除 ', 'GoodsType', '商品类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelType', '类型批量删除 ', 'GoodsType', '商品类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEidtType', '类型更新 ', 'GoodsType', '商品类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddType', '类型保存 ', 'GoodsType', '商品类型管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'GoodsProperty', '商品属性管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'specListPage', '商品属性列表 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'specEditPage', '编辑属性 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addSpecPage', '属性添加 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelSpec', '删除属性 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditSpec', '更新属性 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddSpec', '保存属性 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doPropertyIsSearch', '启用/停用属性 ', 'GoodsProperty', '商品属性管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'freeCollocationList', '自由推荐列表', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addFreeCollocationPage', '新增自由推荐', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addFreeCollocation', '保存自由推荐', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'enableFreeCollocation', '启用/关闭自由推荐', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'editFreeCollocationPage', '启用/编辑自由推荐', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'editFreeCollocation', '更新自由推荐', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'ajaxDelFreeCollocation', '删除自由推荐', 'GoodsFreeCollocation', '商品自由推荐管理', '1', '0', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'GoodsBrand', '商品品牌管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '品牌列表', 'GoodsBrand', '商品品牌管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addBrand', '新增商品品牌', 'GoodsBrand', '商品品牌管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加商品品牌', 'GoodsBrand', '商品品牌管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑商品品牌', 'GoodsBrand', '商品品牌管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新商品品牌', 'GoodsBrand', '商品品牌管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除商品品牌', 'GoodsBrand', '商品品牌管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doStatus', '品牌启用/停用', 'GoodsBrand', '商品品牌管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'GoodsGroup', '商品分组管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '商品分组列表', 'GoodsGroup', '商品分组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addGroup', '新增商品分组', 'GoodsGroup', '商品分组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addGoodsToGroup', '添加商品到分组', 'GoodsGroup', '商品分组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑商品分组', 'GoodsGroup', '商品分组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'removeGoodsToGroup', '移出分组的商品', 'GoodsGroup', '商品分组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除商品分组', 'GoodsGroup', '商品分组管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Orders', '订单管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '订单列表', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageDetails', '订单详情', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'ajaxInvalidOrder', '订单作废', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageWaitPayOrdersList', '待付款订单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageWaitDeliverOrdersList', '待发货订单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersProceedsList', '收款单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersRefundList', '退款单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setOrderRefund', '退款单详情', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersDeliverList', '发货单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersReturnList', '退货单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setOrderReturn', '退货单详情', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersReceipt', '售后单据', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doOrderStatus', '处理售后单据', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setAftersale', '售后服务配置', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddAftersale', '更新售后服务配置', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAftersaleList', '售后服务列表', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersLog', '订单日志', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '订单设置', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSet', '处理订单设置', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setSendShip', '发货设置', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'UpdateOrderStatus', '更新订单状态(发货状态)', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'explortOrdersInfo', '订单导出', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'ajaxUpdateOrderItemsPrice', '更新订单明细中商品价格', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'OrderRemarkUpdate', '订单列表设置备注', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'setOrdersRemark', '设置卖家备注', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'getOrdersSearch', '订单高级搜索', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doOrderPay', '订单支付', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEditOk', '等待发货订单编辑', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '未付款订单编辑', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新未付款订单信息', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditOk', '更新等待发货订单信息', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'delItems', '删除订单商品', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'checkAudit', '订单审核', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'removeOrderItems', '订单拆分', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'autoRemoveOrderItems', '手工拆单', 'Orders', '订单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'overOrder', '订单完结', 'Orders', '订单管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'RefundsProperty', '退换货属性管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'specListPage', '退换货属性列表', 'RefundsProperty', '退换货属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'specEditPage', '退换货属性编辑', 'RefundsProperty', '退换货属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'specAddPage', '退换货属性添加', 'RefundsProperty', '退换货属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditSpec', '保存修改退换货属性', 'RefundsProperty', '退换货属性管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelSpec', '删除退换货属性', 'RefundsProperty', '退换货属性管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Delivery', '配送设置', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '配送公司列表', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增配送公司', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑配送公司', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加配送公司', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新配送公司', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除配送公司', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageListArea', '配送区域列表', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAddArea', '新增配送区域', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEditArea', '编辑配送区域', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddArea', '添加配送区域', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditArea', '更新配送区域', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelArea', '删除配送区域', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAddress', '地址库管理', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'delCityAddress', '删除地址库管理', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addCityAddress', '添加地址库管理', 'Delivery', '配送设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'editCityAddress', '更新地址库管理', 'Delivery', '配送设置', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Promotions', '促销活动管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '促销活动列表', 'Promotions', '促销活动管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增促销活动', 'Promotions', '促销活动管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加促销活动', 'Promotions', '促销活动管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑促销活动', 'Promotions', '促销活动管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新促销活动', 'Promotions', '促销活动管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除促销活动', 'Promotions', '促销活动管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'ajaxDoProEdit', '启用/停用促销活动', 'Promotions', '促销活动管理', '1', '10', '0');


INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Coupon', '优惠券管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '后台优惠券列表', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增优惠券', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加优惠券', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAuto', '批量新增优惠券', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAuto', '批量添加优惠劵', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除优惠券', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑优惠券', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新优惠劵', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageGetExeclCoupon', '导出优惠券', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '优惠券获取节点', 'Coupon', '优惠券管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doCouponSet', '优惠券设置', 'Coupon', '优惠券管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Groupbuy', '团购活动', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '团购活动列表', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddSet', '处理团购设置', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增团购', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '保存团购', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑团购', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新团购', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除团购', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '团购设置', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageCateList', '团购类目列表', 'Groupbuy', '团购活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageBrandList', '团购品牌列表', 'Groupbuy', '团购活动', '1', '0', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Members', '会员信息', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '会员列表', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'memberAdd', '新增会员', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加会员', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑会员', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新会员', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '会员删除', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doBatDelMembers', '批量删除会员', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pointList', '会员积分记录', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doBacthMembers', '批量冻结', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'feedBackList', '买家留言列表', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'replyAjax', '回复买家留言', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'explortFeedBackList', '导出买家留言', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '会员基本设置', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSet', '保存会员基本设置', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'fieldsList', '会员属性项列表', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'fieldsAdd', '会员属性项详情', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doFields', '会员属性项添加', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doFieldDel', '会员属性项删除', 'Members', '会员管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addOrder', '替客户下单', 'Members', '会员管理', '1', '10', '0');

INSERT INTO `fx_role_node` SET `module`='Sourceplatform',`module_name`='会员所属平台管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='pageList',`action_name`='所属平台列表',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='pageAdd',`action_name`='添加平台',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doAdd',`action_name`='新增平台',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='pageEdit',`action_name`='所属平台编辑',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doEdit',`action_name`='更新所属平台信息',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doDel',`action_name`='删除所属平台',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doBatDelPlat',`action_name`='批量删除所属平台',`module`='Sourceplatform',`module_name`='所属平台管理',`auth_type`='0';

INSERT INTO `fx_role_node` SET `module`='MembersDistributed',`module_name`='会员平台分布管理',`auth_type`='1 ';
INSERT INTO `fx_role_node` SET `action`='platformPie',`action_name`='会员平台分布饼图',`module`='MembersDistributed',`module_name`='会员平台分布管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='membersAreaPie',`action_name`='会员地区分布饼图',`module`='MembersDistributed',`module_name`='会员平台分布管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='memberThdPic',`action_name`='第三方授权登录平台分步',`module`='MembersDistributed',`module_name`='会员平台分布管理',`auth_type`='0';


INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Memberlevel', '会员等级', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '会员等级列表', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增会员等级', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加会员等级', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑会员等级', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新会员等级', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除会员等级', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditLevelDefault', '设置会员等级默认值', 'Memberlevel', '会员等级', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doBacthLevel', '批量设置等级', 'Memberlevel', '会员等级', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Membergroup', '会员分组', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '会员分组列表', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增会员分组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加会员分组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑会员分组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新会员分组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除会员分组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'groupingPage', '会员归组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSet', '添加会员归组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelSet', '删除会员归组', 'Membergroup', '会员分组', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doBacthGroup', '批量设置分组', 'Membergroup', '会员分组', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Authorize', '分销产品授权', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '授权线管理列表', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增产品授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加产品授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑产品授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新产品授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDefault', '设置默认授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '会员授权线设置', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSet', '更新会员授权线', 'Authorize', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelSet', '删除会员授权线', 'Authorize', '分销产品授权', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Thdlogin', '第三方授权登录设置管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '授权登录设置页面', 'Thdlogin', '分销产品授权', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '保存第三方授权登录信息', 'Thdlogin', '分销产品授权', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Subcompany', '子公司管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '子公司列表页', 'Subcompany', '子公司管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '子公司添加页', 'Subcompany', '子公司管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '新增子公司', 'Subcompany', '子公司管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑子公司', 'Subcompany', '子公司管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '修改子公司', 'Subcompany', '子公司管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除子公司', 'Subcompany', '子公司管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'BalanceInfo', '结余款管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '结余款调整单列表', 'BalanceInfo', '结余款管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'detailBalanceInfo', '结余款调整单详情', 'BalanceInfo', '结余款管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addBalanceInfo', '新增结余款调整单', 'BalanceInfo', '结余款管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddBalanceInfo', '添加结余款调整单', 'BalanceInfo', '结余款管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'explortBalanceInfo', '导出结余款', 'BalanceInfo', '结余款管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doStatus', '审核结余款调整单', 'BalanceInfo', '结余款管理', '1', '10', '0');


INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'BalanceType', '结余款类型管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '结余款类型列表', 'BalanceType', '结余款类型管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doStatusBalanceType', '启用/停用结余款类型', 'BalanceType', '结余款类型管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Voucher', '销货收款单管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '销货收款单列表', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addVoucher', '新增销货收款单', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '保存销货收款单', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑销货收款单', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新销货收款单', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'explortVoucher', '导出销货收款单', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doStatus', '处理审核状态', 'Voucher', '销货收款单管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'detailVoucher', '销货收款单详情', 'Voucher', '销货收款单管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Financial', '支付管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageListOnline', '线上支付设置 ', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageListOffline', '线下支付配置', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAddOffline', '新增线下支付表单', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddOffline', '保存线下收款帐号', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageListVerify', '线下充值审核列表', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelOffline', '删除线下支付账号', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEditOffline', '编辑线下收款帐号', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditOffline', '更新线下收款帐号', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSetOnline', '设置默认线下支付方式', 'Financial', '支付管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doStatusOnline', '启用线上支付方式', 'Financial', '支付管理', '1', '10', '0');


INSERT INTO `fx_role_node` SET `module`='Invoice',`module_name`='发票设置管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='pageSet',`action_name`='设置发票',`module`='Invoice',`module_name`='发票设置',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doSet',`action_name`='修改发票设置',`module`='Invoice',`module_name`='发票设置',`auth_type`='0';

INSERT INTO `fx_role_node` SET `module`='IncreaseInvoice',`module_name`='增值税发票设置管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='pageList',`action_name`='增值税列表',`module`='IncreaseInvoice',`module_name`='增值税发票设置',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doVerify',`action_name`='增值税发票审核',`module`='IncreaseInvoice',`module_name`='增值税发票设置',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='detailInvoiceInfo',`action_name`='增值税发票详情',`module`='IncreaseInvoice',`module_name`='增值税发票设置',`auth_type`='0';

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'System', '管理帐号', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '管理员列表', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增管理员', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加管理员', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑管理员', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新管理员', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditStatus', '启用/停用管理员账号', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelete', '删除管理员', 'System', '管理帐号', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdminLog', '管理员登陆日志', 'System', '管理帐号', '1', '10', '0');

INSERT INTO `fx_role_node` SET `module`='Images',`module_name`='网站图片空间管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='index',`action_name`='图片列表',`module`='Images',`module_name`='网站图片空间管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doDel',`action_name`='删除图片',`module`='Images',`module_name`='网站图片空间管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='pageSet',`action_name`='水印设置',`module`='Images',`module_name`='网站图片空间管理',`auth_type`='0';
INSERT INTO `fx_role_node` VALUES (NULL, 'itemImageConfig', '商品详情页显示设置', 'Images', '官网模板', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Role', '权限组管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '角色列表', 'Role', '权限组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增角色', 'Role', '权限组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加角色', 'Role', '权限组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑角色', 'Role', '权限组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新角色', 'Role', '权限组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditStatus', '角色启用/停用', 'Role', '权限组管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelete', '删除角色', 'Role', '权限组管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'RoleNode', '节点管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '节点列表', 'RoleNode', '节点管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增节点', 'RoleNode', '节点管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加节点', 'RoleNode', '节点管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑节点', 'RoleNode', '节点管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新节点', 'RoleNode', '节点管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEditStatus', '节点启用/停用', 'RoleNode', '节点管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDelete', '删除节点', 'RoleNode', '节点管理', '1', '10', '0');

INSERT INTO `fx_role_node` SET `module`='Point',`module_name`='积分设置管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='pageSet',`action_name`='积分设置',`module`='Point',`module_name`='积分设置管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doSet',`action_name`='修改积分设置',`module`='Point',`module_name`='积分设置管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='pointLevel',`action_name`='积分等级列表',`module`='Point',`module_name`='积分等级列表',`auth_type`='0';

INSERT INTO `fx_role_node` SET `module`='Api',`module_name`='分销开放平台管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='pageSet',`action_name`='获取密钥',`module`='Api',`module_name`='分销开放平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='yunerppageSet',`action_name`='云ERP店铺授权',`module`='Api',`module_name`='分销开放平台管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='DoSetyunerp',`action_name`='保存云ERP店铺授权',`module`='Api',`module_name`='分销开放平台管理',`auth_type`='0';

INSERT INTO `fx_role_node` SET `module`='Consultation',`module_name`='购买咨询管理',`auth_type`='1';
INSERT INTO `fx_role_node` SET `action`='index',`action_name`='购买咨询列表',`module`='Consultation',`module_name`='购买咨询管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='pageDetail',`action_name`='购买咨询详情',`module`='Consultation',`module_name`='购买咨询管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doConsultationReply',`action_name`='回复购买咨询',`module`='Consultation',`module_name`='购买咨询管理',`auth_type`='0';
INSERT INTO `fx_role_node` SET `action`='doDel',`action_name`='删除咨询',`module`='Consultation',`module_name`='购买咨询管理',`auth_type`='0';

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Package', '数据包管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '数据包列表', 'Package', '数据包管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增数据包', 'Package', '数据包管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '添加数据包', 'Package', '数据包管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑数据包', 'Package', '数据包管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新数据包', 'Package', '数据包管理', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除数据包', 'Package', '数据包管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Email', '邮件设置', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', 'SMTP设置', 'Email', '邮件设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSetSmtp', '更新SMTP设置', 'Email', '邮件设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doTestSmtp', '发送测试邮件', 'Email', '邮件设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageTemp', '邮件模版', 'Email', '邮件设置', '1', '10', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '已发送列表', 'Email', '邮件设置', '1', '10', '0');
insert into fx_role_node set `module`='Distirbution',`module_name`='淘宝铺货',`auth_type`='1';
insert into fx_role_node set `action`='taobaoIndex',`action_name`='店铺绑定',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `action`='taobaoSetSynRules',`action_name`='下载淘宝商品',`module`='Distirbution',`module_name`='下载淘宝商品',`auth_type`='0';
insert into fx_role_node set `action`='deliveryTemplateList',`action_name`='物流模板列表',`module`='Distirbution',`module_name`='下载物流模板',`auth_type`='0';
insert into fx_role_node set `action`='taobaoSet',`action_name`='淘宝铺货设置',`module`='Distirbution',`module_name`='淘宝铺货设置',`auth_type`='0';
insert into fx_role_node set `action`='doDelShops',`action_name`='取消店铺授权',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `action`='topOauth',`action_name`='店铺授权更新',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `action`='doDelShopGoods',`action_name`='删除已下载淘宝商品',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `action`='downAllShopGoods',`action_name`='同步全部淘宝商品',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `action`='downShopGoods',`action_name`='批量下载淘宝商品',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `action`='downDeliveryTemplate',`action_name`='下载物流模板',`module`='Distirbution',`module_name`='店铺绑定',`auth_type`='0';
insert into fx_role_node set `module`='GoodsFreeRecommend',`module_name`='自由搭配管理',`auth_type`='1';
insert into fx_role_node set `action`='freeRecommendList',`action_name`='自由搭配列表',`module`='GoodsFreeRecommend',`module_name`='自由搭配管理',`auth_type`='0';
insert into fx_role_node set `action`='addFreeRecommendPage',`action_name`='新增自由搭配',`module`='GoodsFreeRecommend',`module_name`='自由搭配管理',`auth_type`='0';
insert into fx_role_node set `action`='editFreeRecommendPage',`action_name`='编辑自由搭配',`module`='GoodsFreeRecommend',`module_name`='自由搭配管理',`auth_type`='0';
insert into fx_role_node set `action`='ajaxDelFreeRecommend',`action_name`='删除自由搭配',`module`='GoodsFreeRecommend',`module_name`='自由搭配管理',`auth_type`='0';
insert into fx_role_node set `module`='Menus',`module_name`='系统菜单管理',`auth_type`='1';
insert into fx_role_node set `action`='index',`action_name`='后台菜单列表',`module`='Menus',`module_name`='返利列表',`auth_type`='0';
insert into fx_role_node set `action`='getUcenterMenus',`action_name`='会员中心菜单列表',`module`='Menus',`module_name`='返利列表',`auth_type`='0';
insert into fx_role_node set `action`='doStatusMenus',`action_name`='启用/停用菜单',`module`='Menus',`module_name`='返利列表',`auth_type`='0';
insert into fx_role_node set `module`='Spike',`module_name`='秒杀活动',`auth_type`='1';
insert into fx_role_node set `action`='index',`action_name`='秒杀列表',`module`='Spike',`module_name`='秒杀活动',`auth_type`='0';
insert into fx_role_node set `action`='add',`action_name`='新增秒杀',`module`='Spike',`module_name`='秒杀活动',`auth_type`='0';
insert into fx_role_node set `action`='pageSet',`action_name`='秒杀设置',`module`='Spike',`module_name`='秒杀活动',`auth_type`='0';
insert into fx_role_node set `action`='pageCateList',`action_name`='秒杀分类列表',`module`='Spike',`module_name`='秒杀活动',`auth_type`='0';
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Presale', '预售活动', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '预售活动列表', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAddSet', '处理预售设置', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增预售', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '保存预售', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageEdit', '编辑预售', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doEdit', '更新预售', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doDel', '删除预售', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '预售设置', 'Presale', '预售活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'PrepaidCard', '充值卡管理', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '充值卡列表', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '充值卡单个添加', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAdd', '执行充值卡单个添加', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAuto', '充值卡批量添加', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doAuto', '执行充值卡批量添加', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'isOpen', '充值卡开启、关闭', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pcServiceVerify', '充值卡客审', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pcFinanceVerify', '充值卡财审', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pcProcessingError', '充值卡驳回', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'deleteCard', '充值卡删除', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '充值卡配置', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doSet', '保存充值卡配置', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'doExcel', '充值卡导出', 'PrepaidCard', '充值卡管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Lottery', '抽奖活动', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '抽奖活动列表', 'Lottery', '抽奖活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'userList', '奖品列表', 'Lottery', '抽奖活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Sms', 'SMS管理', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSms', 'SMS设置', 'Sms', 'SMS管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '已发送列表', 'Sms', 'SMS管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageTemp', '短信模板', 'Sms', 'SMS管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '红包调整单列表', 'JlbInfo', '红包管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'addBonusInfo', '新增红包调整单', 'JlbInfo', '红包管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '红包设置', 'JlbInfo', '红包管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Salespromotion', '分销商引荐管理', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '分销商引荐管理', 'Salespromotion', '推广销售管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'showSalesSetList', '销售额设定', 'Salespromotion', '推广销售管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'index', '商品返利设定', 'Promotings', '推广销售管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'PBStatements', '返利报表', 'Promotings', '推广销售管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '试用活动列表', 'Try', '试用活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdd', '新增试用活动', 'Try', '试用活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'apply_index', '试用活动申请列表', 'Try', '试用活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'report', '试用报告列表', 'Try', '试用活动', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageSet', '试用活动设置', 'Try', '试用活动', '1', '0', '0');
insert into fx_role_node set action='',action_name='',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='1';
insert into fx_role_node set action='edit',action_name='可视化编辑页面',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
insert into fx_role_node set action='huifu',action_name='初始化首页',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
insert into fx_role_node set action='save',action_name='保存首页',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
insert into fx_role_node set action='zancun',action_name='暂存首页',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
insert into fx_role_node set action='index',action_name='预览暂存首页',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
insert into fx_role_node set action='huanyuan',action_name='还原上次编辑',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
insert into fx_role_node set action='searchEditLog',action_name='查看编辑日志',module='Edit',module_name='可视化模块',status='1',sort='10',auth_type='0';
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'MergerPayment', '合并支付管理', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageList', '合并支付订单列表', 'MergerPayment', '合并支付管理', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'SalesStatistics', '销售统计', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'SalesRanking', '销售量排名', 'SalesStatistics', '销售统计', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'MembersRanking', '购买量排名', 'SalesStatistics', '销售统计', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'Try', '使用活动', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'BonusInfo', '红包管理', '1', '10', '1');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'TopOss', '图片服务器设置', '1', '10', '1');

INSERT INTO `fx_role_node` VALUES (NULL, 'pageOrdersRefundDeliverList', '退运费单', 'Orders', '订单管理', '1', '10', '0');

INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'WapEdit', 'WAP可视化模块', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'edit', '可视化编辑页面', 'WapEdit', 'WAP可视化模块', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'save', '保存首页', 'WapEdit', 'WAP可视化模块', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'zancun', '暂存首页', 'WapEdit', 'WAP可视化模块', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, '', '', 'AppEdit', 'APP可视化模块', '1', '0', '1');
INSERT INTO `fx_role_node` VALUES (NULL, 'edit', '可视化编辑页面', 'AppEdit', 'APP可视化模块', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'save', '保存首页', 'AppEdit', 'APP可视化模块', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'zancun', '暂存首页', 'AppEdit', 'APP可视化模块', '1', '0', '0');
INSERT INTO `fx_role_node` VALUES (NULL, 'pageAdminOrdersPay', '付款申请列表', 'Orders', '订单管理', '1', '10', '0');

insert into fx_role_node set `module`='Integral',`module_name`='积分兑换',`auth_type`='1';
insert into fx_role_node set `action`='index',`action_name`='积分兑换列表',`module`='Integral',`module_name`='积分兑换',`auth_type`='0';
insert into fx_role_node set `action`='pageAdd',`action_name`='新增积分兑换',`module`='Integral',`module_name`='积分兑换',`auth_type`='0';
insert into fx_role_node set `action`='pageCateList',`action_name`='积分兑换分类列表',`module`='Integral',`module_name`='积分兑换',`auth_type`='0';

INSERT INTO `fx_sys_config` VALUES (NULL, 'GY_GOODS', 'VARIABLE_DEPTH', '3', '商品前台显示销售属性维度', '2015-12-15 11:28:47', '2015-12-15 11:28:47');

