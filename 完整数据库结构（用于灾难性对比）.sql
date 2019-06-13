/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-04-27 20:48:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_hyb_o2o_addres_bak
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_addres_bak`;
CREATE TABLE `ims_hyb_o2o_addres_bak` (
  `d_id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `d_address` varchar(255) DEFAULT NULL,
  `d_xxaddress` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `d_uname` varchar(255) DEFAULT NULL,
  `d_phone` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `d_checked` int(10) DEFAULT '0' COMMENT '是否设为默认',
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_address
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_address`;
CREATE TABLE `ims_hyb_o2o_address` (
  `d_id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `d_address` varchar(255) DEFAULT NULL,
  `d_xxaddress` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `d_uname` varchar(255) DEFAULT NULL,
  `d_phone` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `d_checked` int(10) DEFAULT '0' COMMENT '是否设为默认',
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_base
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_base`;
CREATE TABLE `ims_hyb_o2o_base` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `thumb` longtext,
  `city_type` int(10) DEFAULT '0',
  `city` varchar(255) DEFAULT NULL,
  `banquan` varchar(255) DEFAULT NULL,
  `baidukey` varchar(255) DEFAULT NULL,
  `xieyi` longtext,
  `gaodekey` varchar(255) DEFAULT NULL,
  `gaodexcxkey` varchar(255) DEFAULT NULL,
  `sm_money` varchar(255) DEFAULT NULL COMMENT '上门服务费',
  `pt_show` int(10) DEFAULT '0',
  `qjbcolor` varchar(255) DEFAULT NULL COMMENT '上门服务费',
  `s_ttthumb` varchar(255) DEFAULT NULL,
  `fdsh_type` int(10) DEFAULT '0',
  `qjcolor` varchar(255) DEFAULT NULL,
  `bcolor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_city
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_city`;
CREATE TABLE `ims_hyb_o2o_city` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parentid` int(10) DEFAULT '0',
  `tuijian` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=990110 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_cunchu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_cunchu`;
CREATE TABLE `ims_hyb_o2o_cunchu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `alioss_key` varchar(255) DEFAULT NULL,
  `alioss_secret` varchar(255) DEFAULT NULL,
  `alioss_bucket` varchar(255) DEFAULT NULL,
  `alioss_url` varchar(255) DEFAULT NULL,
  `alioss_ossurl` varchar(255) DEFAULT NULL,
  `qiniu_accesskey` varchar(255) DEFAULT NULL,
  `qiniu_secretkey` varchar(255) DEFAULT NULL,
  `qiniu_bucket` varchar(255) DEFAULT NULL,
  `qiniu_url` varchar(255) DEFAULT NULL,
  `type` varchar(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_daohang
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_daohang`;
CREATE TABLE `ims_hyb_o2o_daohang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '导航标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '导航图标',
  `thumb2` varchar(255) DEFAULT NULL COMMENT '导航切换图标',
  `lianjie` varchar(255) DEFAULT NULL COMMENT '导航链接',
  `ids` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_district
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_district`;
CREATE TABLE `ims_hyb_o2o_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `shi` varchar(255) DEFAULT NULL,
  `xian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2861 DEFAULT CHARSET=utf8 COMMENT='高德行政区域数据';

-- ----------------------------
-- Table structure for ims_hyb_o2o_email
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_email`;
CREATE TABLE `ims_hyb_o2o_email` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `mailhost` varchar(255) DEFAULT NULL,
  `mailport` varchar(255) DEFAULT NULL,
  `mailhostname` varchar(255) DEFAULT NULL,
  `mailformname` varchar(255) DEFAULT NULL,
  `mailusername` varchar(255) DEFAULT NULL,
  `mailpassword` varchar(255) DEFAULT NULL,
  `mailsend` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fadan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fadan`;
CREATE TABLE `ims_hyb_o2o_fadan` (
  `fa_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `fa_ordersn` varchar(255) DEFAULT NULL,
  `fa_openid` varchar(255) DEFAULT NULL,
  `fa_name` varchar(255) DEFAULT NULL,
  `fa_fwname` varchar(255) DEFAULT NULL,
  `fa_fwimgpath` longtext,
  `fa_fwstyle1` varchar(255) DEFAULT NULL,
  `fa_fwstyle2` varchar(255) DEFAULT NULL,
  `fa_fwtime` varchar(255) DEFAULT NULL,
  `fa_fwmoney` varchar(255) DEFAULT NULL,
  `fa_fwaddress` varchar(255) DEFAULT NULL,
  `fa_fwaddresss` varchar(255) DEFAULT NULL,
  `fa_fwlongitude` varchar(255) DEFAULT NULL,
  `fa_fwlatitude` varchar(255) DEFAULT NULL,
  `fa_fwcontent` varchar(255) DEFAULT NULL,
  `fa_fwtelphone` varchar(255) DEFAULT NULL,
  `fa_time` varchar(255) DEFAULT NULL,
  `fa_style` varchar(255) DEFAULT NULL,
  `fa_fwpay_type` varchar(255) DEFAULT NULL,
  `fa_fwpay_types` varchar(255) DEFAULT NULL,
  `fa_fwshagneng` varchar(255) DEFAULT NULL,
  `fa_pay` int(10) DEFAULT '0',
  `fa_dizhi` int(10) DEFAULT '0',
  `del` int(10) DEFAULT '0',
  PRIMARY KEY (`fa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fenxiao
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fenxiao`;
CREATE TABLE `ims_hyb_o2o_fenxiao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `is_open` int(10) DEFAULT NULL COMMENT '是否开启分销1开启2关闭',
  `is_ej` int(10) DEFAULT NULL COMMENT '是否开启二级分销1开启2关闭',
  `fzthumb` longtext,
  `sfthumb` longtext,
  `fxthumb` varchar(255) DEFAULT NULL,
  `y_moneyyi` varchar(255) DEFAULT NULL COMMENT '一级佣金',
  `y_moneyer` varchar(255) DEFAULT NULL,
  `tx_money` varchar(255) DEFAULT NULL,
  `tx_rate` varchar(255) DEFAULT NULL,
  `fx_details` longtext,
  `tx_details` longtext,
  `instructions` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fenxiaotixian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fenxiaotixian`;
CREATE TABLE `ims_hyb_o2o_fenxiaotixian` (
  `t_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `t_fopenid` varchar(255) DEFAULT NULL,
  `t_fid` int(10) DEFAULT NULL,
  `t_name` varchar(255) DEFAULT NULL,
  `t_money` varchar(255) DEFAULT NULL,
  `t_shouxufei` varchar(255) DEFAULT NULL,
  `t_time` varchar(255) DEFAULT NULL,
  `t_status` varchar(255) DEFAULT NULL,
  `t_type` int(10) DEFAULT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fenxiaoyongjin
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fenxiaoyongjin`;
CREATE TABLE `ims_hyb_o2o_fenxiaoyongjin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `yonghu` varchar(255) DEFAULT NULL,
  `yongjin` varchar(255) DEFAULT NULL,
  `parentid` int(10) DEFAULT NULL,
  `parentopenid` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fuwu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fuwu`;
CREATE TABLE `ims_hyb_o2o_fuwu` (
  `x_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `x_name` varchar(255) DEFAULT NULL,
  `x_type` varchar(255) DEFAULT NULL,
  `x_parenttype` varchar(255) DEFAULT NULL,
  `x_xingshi` varchar(255) DEFAULT NULL,
  `x_thumb` varchar(255) DEFAULT NULL,
  `x_thumbs` longtext,
  `x_pay_type` varchar(255) DEFAULT NULL,
  `x_pay_bili` varchar(255) DEFAULT NULL,
  `x_pay_smgj` varchar(255) DEFAULT NULL,
  `x_guigename` varchar(255) DEFAULT NULL,
  `x_guigecontent` longtext,
  `x_content` longtext,
  `x_jianjie_thumb` longtext,
  `x_wenxintishi` text,
  `x_jiage` varchar(255) DEFAULT NULL,
  `x_danwei` varchar(255) DEFAULT NULL,
  `x_xiaoliang` int(10) DEFAULT '0',
  `x_status` varchar(255) DEFAULT '0',
  `x_shangjia` varchar(255) DEFAULT NULL,
  `x_jifenstatus` int(10) DEFAULT '0',
  `x_jifen` int(10) DEFAULT '0',
  `x_manjianstatus` int(10) DEFAULT '0',
  `x_manjian` int(10) DEFAULT '0',
  `x_huiyuanstatus` int(10) DEFAULT '0',
  `x_youhuiquanstatus` int(10) DEFAULT '0',
  `x_youhuiquan` int(10) DEFAULT '0',
  `x_tuijian` int(10) DEFAULT '0',
  `x_timecontent` longtext,
  `fx_yi` varchar(255) DEFAULT '0',
  `fx_er` varchar(255) DEFAULT '0',
  PRIMARY KEY (`x_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fuwu_time
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fuwu_time`;
CREATE TABLE `ims_hyb_o2o_fuwu_time` (
  `x_id` int(10) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL COMMENT '选择的时间',
  `time` varchar(255) DEFAULT NULL COMMENT '选择的时间段',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_id` int(11) DEFAULT NULL,
  `status` int(3) NOT NULL DEFAULT '0' COMMENT '1 已下单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fuwu_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fuwu_type`;
CREATE TABLE `ims_hyb_o2o_fuwu_type` (
  `xt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `xt_name` varchar(255) DEFAULT NULL,
  `xt_thumb` varchar(255) DEFAULT NULL,
  `xt_ids` int(10) DEFAULT NULL,
  `xt_tuijian` int(10) DEFAULT '0',
  `xt_parentid` int(10) DEFAULT '0',
  `choushui` varchar(255) DEFAULT NULL,
  `xt_tuijian_fabu` int(2) NOT NULL DEFAULT '0' COMMENT '推荐是否跳转发布',
  `xt_reference_price` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '平台参考价',
  `xt_tzej` int(10) DEFAULT '0',
  `xt_smreference_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`xt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fuwupingjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fuwupingjia`;
CREATE TABLE `ims_hyb_o2o_fuwupingjia` (
  `p_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `p_openid` varchar(255) DEFAULT NULL,
  `p_name` varchar(255) DEFAULT NULL,
  `p_thumb` varchar(255) DEFAULT NULL,
  `p_content` text,
  `p_pic` longtext,
  `p_sid` int(10) DEFAULT NULL,
  `p_fenshu` varchar(255) DEFAULT NULL,
  `p_time` varchar(255) DEFAULT NULL,
  `p_huifu` text,
  `p_htime` varchar(255) DEFAULT NULL,
  `p_yid` int(10) DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_fxuser
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_fxuser`;
CREATE TABLE `ims_hyb_o2o_fxuser` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL COMMENT '用户openid',
  `y_openid` varchar(255) DEFAULT NULL COMMENT '被邀人openid',
  `y_order` int(10) DEFAULT '0' COMMENT '被邀请的人是否下单',
  `uniacid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_gonggao
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_gonggao`;
CREATE TABLE `ims_hyb_o2o_gonggao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_goods
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_goods`;
CREATE TABLE `ims_hyb_o2o_goods` (
  `g_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `g_name` varchar(255) DEFAULT NULL,
  `g_type` varchar(255) DEFAULT NULL,
  `g_city` varchar(255) DEFAULT NULL,
  `g_jiage` int(10) DEFAULT '0',
  `g_thumb` varchar(255) DEFAULT NULL,
  `g_thumbs` longtext,
  `g_content` longtext,
  `g_baoyou` int(10) DEFAULT NULL,
  `g_kuaidi` int(11) DEFAULT '0',
  `g_guigename` varchar(255) DEFAULT NULL,
  `g_guigecontent` longtext,
  `g_xiaoliang` int(10) DEFAULT '0',
  `g_status` int(10) DEFAULT '0',
  `g_tuijian` int(10) DEFAULT NULL,
  `g_ids` int(10) DEFAULT NULL,
  `fx_yi` varchar(255) DEFAULT '0',
  `fx_er` varchar(255) DEFAULT '0',
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_goods_style
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_goods_style`;
CREATE TABLE `ims_hyb_o2o_goods_style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_goodspingjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_goodspingjia`;
CREATE TABLE `ims_hyb_o2o_goodspingjia` (
  `p_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `p_openid` varchar(255) DEFAULT NULL,
  `p_name` varchar(255) DEFAULT NULL,
  `p_thumb` varchar(255) DEFAULT NULL,
  `p_content` text,
  `p_pic` longtext,
  `p_sid` int(10) DEFAULT NULL,
  `p_fenshu` varchar(255) DEFAULT NULL,
  `p_time` varchar(255) DEFAULT NULL,
  `p_huifu` text,
  `p_htime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_huiyuan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_huiyuan`;
CREATE TABLE `ims_hyb_o2o_huiyuan` (
  `h_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `h_name` varchar(255) DEFAULT NULL,
  `h_thumb` varchar(255) DEFAULT NULL,
  `h_content` varchar(255) DEFAULT NULL,
  `h_zhekou` int(10) DEFAULT NULL,
  `h_money` varchar(10) DEFAULT '0',
  `h_song` int(10) DEFAULT '0',
  `h_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`h_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_huodong
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_huodong`;
CREATE TABLE `ims_hyb_o2o_huodong` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_img
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_img`;
CREATE TABLE `ims_hyb_o2o_img` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=973 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jfgoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jfgoods`;
CREATE TABLE `ims_hyb_o2o_jfgoods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `thumbs` longtext,
  `content` longtext,
  `num` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jforder
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jforder`;
CREATE TABLE `ims_hyb_o2o_jforder` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `ordersn` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL COMMENT '兑换时间',
  `jifen` varchar(255) DEFAULT '0' COMMENT '兑换所用积分',
  `statues` int(10) DEFAULT '0' COMMENT '0-未支付 1-等待发货 2-等待收货 -3完成',
  `j_id` int(10) DEFAULT NULL COMMENT '积分商品id',
  `address` varchar(255) DEFAULT NULL,
  `xxaddress` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `usertel` varchar(255) DEFAULT NULL,
  `form_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jfthumb
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jfthumb`;
CREATE TABLE `ims_hyb_o2o_jfthumb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jianmian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jianmian`;
CREATE TABLE `ims_hyb_o2o_jianmian` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `m_money` int(20) DEFAULT NULL,
  `j_money` int(20) DEFAULT NULL,
  `statue` int(10) DEFAULT NULL,
  `uniacid` int(20) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jibie
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jibie`;
CREATE TABLE `ims_hyb_o2o_jibie` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `j_name` varchar(255) DEFAULT NULL,
  `j_thumb` varchar(255) DEFAULT NULL,
  `j_content` varchar(255) DEFAULT NULL,
  `j_zhekou` int(10) DEFAULT NULL,
  `uniacid` int(10) NOT NULL,
  `j_chong` int(20) NOT NULL DEFAULT '0',
  `j_xiaofei` int(20) NOT NULL DEFAULT '0',
  `j_money` int(20) DEFAULT '0',
  `j_song` int(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jifen
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jifen`;
CREATE TABLE `ims_hyb_o2o_jifen` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `f_jifen` int(20) DEFAULT '0' COMMENT '分享所得积分（分享）',
  `uniacid` int(20) DEFAULT NULL,
  `b_jifen` int(20) DEFAULT '0' COMMENT '购买所得积分',
  `statue` int(10) DEFAULT '0' COMMENT '积分状态：0-关闭；1-开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_jishiset
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_jishiset`;
CREATE TABLE `ims_hyb_o2o_jishiset` (
  `r_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `r_money` varchar(255) DEFAULT NULL,
  `r_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_manjian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_manjian`;
CREATE TABLE `ims_hyb_o2o_manjian` (
  `m_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `m_money` int(10) DEFAULT NULL,
  `j_money` int(10) DEFAULT NULL,
  `shangjia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_memdian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_memdian`;
CREATE TABLE `ims_hyb_o2o_memdian` (
  `md_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `md_name` varchar(50) DEFAULT NULL COMMENT '门店名称',
  `md_thumb` longtext COMMENT '门店宣传图',
  `md_content` longtext COMMENT '门店内容',
  `md_address` varchar(255) DEFAULT NULL COMMENT '门店地址',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `md_telphone` varchar(255) DEFAULT NULL COMMENT '门店联系电话',
  `md_shouxufei` int(10) DEFAULT '0',
  `md_money` varchar(255) DEFAULT '0',
  `md_index` varchar(255) DEFAULT NULL COMMENT '门店首页地址',
  `md_f_jifen` int(10) DEFAULT '0' COMMENT '分销为积分时一次积多少分',
  `md_f_yongjin` int(10) DEFAULT '0' COMMENT '分销为佣金时一次多少佣金',
  `md_jfthumbs` longtext COMMENT '积分商品页的幻灯片',
  `md_f_yjtx` varchar(255) DEFAULT '0' COMMENT '佣金提现兑换数',
  `md_f_eyongjin` int(10) DEFAULT '0' COMMENT '二级分销成功一级所得佣金',
  `md_f_ejifen` int(10) DEFAULT '0' COMMENT '二级分销成功一级所得积分',
  PRIMARY KEY (`md_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_mendian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_mendian`;
CREATE TABLE `ims_hyb_o2o_mendian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `thumbs` longtext,
  `content` longtext,
  `address` varchar(255) DEFAULT NULL,
  `xaddress` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `telphone` varchar(255) DEFAULT NULL,
  `fuzeren` varchar(255) DEFAULT NULL,
  `yingyetime` varchar(255) DEFAULT NULL,
  `fuwustyle` varchar(255) DEFAULT NULL,
  `baozhang` varchar(255) DEFAULT NULL,
  `fwfw` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_moban
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_moban`;
CREATE TABLE `ims_hyb_o2o_moban` (
  `m_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `show` varchar(50) DEFAULT NULL,
  `huiyuan` varchar(50) DEFAULT NULL,
  `zhishi` varchar(50) DEFAULT NULL,
  `fuwu` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `select` varchar(255) DEFAULT '0',
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_news`;
CREATE TABLE `ims_hyb_o2o_news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `accessKeyId` varchar(255) DEFAULT NULL,
  `accessKeySecret` varchar(255) DEFAULT NULL,
  `SignName` varchar(255) DEFAULT NULL,
  `shtz` varchar(255) DEFAULT NULL,
  `pdtzyh` varchar(255) DEFAULT NULL,
  `pdtzyg` varchar(255) DEFAULT NULL,
  `fdtz` varchar(255) DEFAULT NULL,
  `fdtzyh` varchar(255) DEFAULT NULL,
  `fdtzyg` varchar(255) DEFAULT NULL,
  `rztz` varchar(255) DEFAULT NULL,
  `sjrztz` varchar(255) DEFAULT NULL,
  `ddtzsjkf` varchar(255) DEFAULT NULL,
  `ddtzsjwc` varchar(255) DEFAULT NULL,
  `fdtzsh` varchar(255) DEFAULT NULL,
  `qdtzyh` varchar(255) DEFAULT NULL,
  `fdtzfwk` varchar(255) DEFAULT NULL,
  `fdtzfww` varchar(255) DEFAULT NULL,
  `ddtzzf` varchar(255) DEFAULT NULL,
  `ddtzzfq` varchar(255) DEFAULT NULL,
  `baojia` varchar(255) DEFAULT NULL,
  `yzm` varchar(255) DEFAULT NULL,
  `tybaojia` varchar(255) DEFAULT NULL,
  `btybaojia` varchar(255) DEFAULT NULL,
  `xdtzyg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_order`;
CREATE TABLE `ims_hyb_o2o_order` (
  `o_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `o_name` varchar(255) DEFAULT NULL,
  `o_telphone` varchar(50) DEFAULT NULL,
  `o_address` varchar(255) DEFAULT NULL,
  `o_xiangmu` varchar(255) DEFAULT NULL,
  `o_num` varchar(10) DEFAULT NULL,
  `o_xid` varchar(255) DEFAULT NULL,
  `o_monney` varchar(50) DEFAULT NULL,
  `o_count_money` varchar(50) DEFAULT NULL,
  `o_yy_riqi` varchar(50) DEFAULT NULL,
  `o_beizhu` varchar(255) DEFAULT NULL,
  `o_xdtime` varchar(255) DEFAULT NULL,
  `o_xiangmu_thumb` varchar(255) DEFAULT NULL,
  `ordersn` varchar(255) DEFAULT NULL,
  `o_type` varchar(255) DEFAULT NULL,
  `o_status` int(10) DEFAULT '0',
  `o_xxaddress` varchar(255) DEFAULT NULL,
  `o_sex` varchar(255) DEFAULT NULL,
  `o_pingjia` int(10) DEFAULT '0' COMMENT '评价状态 0-未评价 1-已评价',
  `o_store` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB AUTO_INCREMENT=482 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_orderfuwu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_orderfuwu`;
CREATE TABLE `ims_hyb_o2o_orderfuwu` (
  `o_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `ordersn` varchar(255) DEFAULT NULL,
  `o_name` varchar(255) DEFAULT NULL,
  `o_telphone` varchar(255) DEFAULT NULL,
  `o_address` varchar(255) DEFAULT NULL,
  `o_xxaddress` varchar(255) DEFAULT NULL,
  `o_localtion` varchar(100) DEFAULT NULL COMMENT '订单收货地址经纬度',
  `o_xid` int(10) DEFAULT NULL,
  `o_xiangmu_name` varchar(255) DEFAULT NULL,
  `o_xiangmu_thumb` varchar(255) DEFAULT NULL,
  `o_xiangmu_money` varchar(255) DEFAULT NULL,
  `o_xiangmu_xingshi` varchar(255) DEFAULT NULL,
  `o_xiangmu_guige` varchar(255) DEFAULT NULL,
  `o_xiangmu_guigemoney` varchar(255) DEFAULT NULL,
  `o_num` int(10) DEFAULT NULL,
  `o_yy_riqi` varchar(255) DEFAULT NULL,
  `o_fwry` varchar(255) DEFAULT NULL,
  `o_ding_money` varchar(255) DEFAULT '0',
  `o_sheng_money` varchar(255) DEFAULT '0',
  `o_shangmen_money` varchar(255) DEFAULT NULL,
  `o_count_money` varchar(255) DEFAULT NULL,
  `o_beizhu` text,
  `o_xdtime` varchar(255) DEFAULT NULL,
  `o_pay_type` varchar(255) DEFAULT NULL,
  `o_pay_types` int(10) DEFAULT '0',
  `o_type` varchar(255) DEFAULT NULL,
  `o_store` varchar(255) DEFAULT NULL,
  `o_huiyaunyouhui` int(10) DEFAULT '0',
  `o_youhuiquanyouhui` int(10) DEFAULT '0',
  `o_manjianyouhui` int(10) DEFAULT '0',
  `o_pingjia` int(10) DEFAULT '0',
  `o_fw_type` int(10) DEFAULT '0' COMMENT '1代表服务中2代表服务完成',
  `o_pay_typess` varchar(255) DEFAULT NULL COMMENT '支付方式',
  `o_hexiaomashuzi` varchar(255) DEFAULT NULL,
  `yonghu` int(10) DEFAULT '0',
  `shangjia` int(10) DEFAULT '0',
  `o_fwry_id` int(10) DEFAULT NULL COMMENT '服务人员id',
  `o_uid` int(10) DEFAULT NULL COMMENT '下单人员id',
  `yg` int(10) DEFAULT '0',
  `o_fwry_type` int(10) DEFAULT NULL COMMENT '0代表员工/技师  1代表商家',
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_ordergoods
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_ordergoods`;
CREATE TABLE `ims_hyb_o2o_ordergoods` (
  `o_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `ordersn` varchar(255) DEFAULT NULL,
  `o_name` varchar(255) DEFAULT NULL,
  `o_telphone` varchar(255) DEFAULT NULL,
  `o_address` varchar(255) DEFAULT NULL,
  `o_xxaddress` varchar(255) DEFAULT NULL,
  `o_gid` int(10) DEFAULT NULL,
  `o_goodsname` varchar(255) DEFAULT NULL,
  `o_goodsthumb` varchar(255) DEFAULT NULL,
  `o_goodsguige` varchar(255) DEFAULT NULL,
  `o_num` int(10) DEFAULT '1',
  `o_monney` varchar(255) DEFAULT NULL,
  `o_count_money` varchar(255) DEFAULT NULL,
  `o_kuaidi` varchar(255) DEFAULT NULL,
  `o_beizhu` text,
  `o_xdtime` varchar(255) DEFAULT NULL,
  `o_type` varchar(255) DEFAULT NULL,
  `o_pingjia` int(10) DEFAULT '0',
  `o_pay_type` varchar(255) NOT NULL,
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_paidan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_paidan`;
CREATE TABLE `ims_hyb_o2o_paidan` (
  `p_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `p_qdname` varchar(255) DEFAULT NULL,
  `p_openid` varchar(255) DEFAULT NULL,
  `p_name` varchar(255) DEFAULT NULL,
  `p_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_paidanpingjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_paidanpingjia`;
CREATE TABLE `ims_hyb_o2o_paidanpingjia` (
  `pj_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `pj_openid` varchar(255) DEFAULT NULL,
  `pj_content` varchar(255) DEFAULT NULL,
  `pj_fen` varchar(255) DEFAULT NULL,
  `pj_yuangong` varchar(255) DEFAULT NULL,
  `pj_time` varchar(255) DEFAULT NULL,
  `pj_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_paidanpj
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_paidanpj`;
CREATE TABLE `ims_hyb_o2o_paidanpj` (
  `pj_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `pj_openid` varchar(255) DEFAULT NULL,
  `pj_content` varchar(255) DEFAULT NULL,
  `pj_fen` varchar(255) DEFAULT NULL,
  `pj_yuangong` varchar(255) DEFAULT NULL,
  `pj_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_parameter
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_parameter`;
CREATE TABLE `ims_hyb_o2o_parameter` (
  `k_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `mch_id` varchar(255) DEFAULT NULL,
  `appkey` varchar(255) DEFAULT NULL,
  `mbid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`k_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_parment
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_parment`;
CREATE TABLE `ims_hyb_o2o_parment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `mchid` varchar(255) DEFAULT NULL,
  `wxkey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_pingjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_pingjia`;
CREATE TABLE `ims_hyb_o2o_pingjia` (
  `p_id` int(10) NOT NULL AUTO_INCREMENT,
  `p_content` varchar(255) DEFAULT NULL,
  `p_huifu` varchar(255) DEFAULT NULL,
  `p_openid` varchar(255) DEFAULT NULL,
  `p_name` varchar(255) DEFAULT NULL,
  `p_thumb` varchar(255) DEFAULT NULL,
  `p_sjopenid` varchar(255) DEFAULT NULL,
  `p_sjname` varchar(255) DEFAULT NULL,
  `p_xiangmu` varchar(255) DEFAULT NULL,
  `p_xid` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `p_time` varchar(255) DEFAULT NULL,
  `p_htime` varchar(255) DEFAULT NULL,
  `p_onum` varchar(255) DEFAULT NULL COMMENT '评价的订单号',
  `fw_pingfen` int(10) DEFAULT '0' COMMENT '店铺评分',
  `sp_pingfen` int(10) DEFAULT '0' COMMENT '项目评分',
  `p_pic` longtext,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_qiangdan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_qiangdan`;
CREATE TABLE `ims_hyb_o2o_qiangdan` (
  `q_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `q_openid` varchar(255) DEFAULT NULL,
  `q_dname` varchar(255) DEFAULT NULL,
  `q_time` varchar(255) DEFAULT NULL,
  `q_types` varchar(255) DEFAULT NULL,
  `q_pdname` varchar(255) DEFAULT NULL,
  `q_pd_time` varchar(255) DEFAULT NULL,
  `q_styles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_question
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_question`;
CREATE TABLE `ims_hyb_o2o_question` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_shangjia
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_shangjia`;
CREATE TABLE `ims_hyb_o2o_shangjia` (
  `s_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `s_u_name` varchar(255) DEFAULT NULL,
  `s_u_openid` varchar(255) DEFAULT NULL,
  `s_telphone` varchar(255) DEFAULT NULL,
  `s_content` longtext,
  `s_type` varchar(255) DEFAULT NULL,
  `s_yingyetime` varchar(255) DEFAULT NULL,
  `s_address` varchar(255) DEFAULT NULL,
  `s_xxaddress` varchar(255) DEFAULT NULL,
  `jing` varchar(255) DEFAULT NULL,
  `wei` varchar(255) DEFAULT NULL,
  `s_thumb` varchar(255) DEFAULT NULL,
  `s_imgpath` longtext,
  `s_zhizhao` varchar(255) DEFAULT NULL,
  `s_money` float(255,2) DEFAULT '0.00',
  `ruzhu_money` varchar(255) DEFAULT NULL,
  `ruzhu_endtime` varchar(255) DEFAULT NULL,
  `s_status` varchar(255) DEFAULT NULL,
  `s_tuijian` varchar(255) DEFAULT NULL,
  `s_xiaoliang` int(10) DEFAULT '0',
  `pingtai` int(10) DEFAULT '0',
  `s_time` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `s_ids` varchar(255) DEFAULT NULL,
  `baozhang` longtext,
  `s_idcard` varchar(255) DEFAULT NULL,
  `s_idcard2` varchar(255) DEFAULT NULL,
  `s_dizhi` varchar(255) DEFAULT NULL,
  `fwfw` int(10) DEFAULT '0',
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_shangjiaruzhu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_shangjiaruzhu`;
CREATE TABLE `ims_hyb_o2o_shangjiaruzhu` (
  `r_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `r_money` varchar(255) DEFAULT NULL,
  `r_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_sjliushui
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_sjliushui`;
CREATE TABLE `ims_hyb_o2o_sjliushui` (
  `l_id` int(20) NOT NULL AUTO_INCREMENT,
  `s_id` int(20) DEFAULT NULL,
  `l_total` varchar(20) DEFAULT '0',
  `l_dtotal` varchar(20) DEFAULT '0',
  `l_mtotal` varchar(20) DEFAULT '0',
  `l_ytotal` varchar(20) DEFAULT '0',
  `uniacid` int(10) DEFAULT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_sjruzhu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_sjruzhu`;
CREATE TABLE `ims_hyb_o2o_sjruzhu` (
  `r_id` int(10) NOT NULL AUTO_INCREMENT,
  `r_time` varchar(255) DEFAULT NULL,
  `r_money` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `r_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_sjtype
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_sjtype`;
CREATE TABLE `ims_hyb_o2o_sjtype` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) DEFAULT NULL,
  `t_thumb` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `t_statue` varchar(20) DEFAULT NULL COMMENT '是否在首页显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_symx
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_symx`;
CREATE TABLE `ims_hyb_o2o_symx` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `orderid` int(10) DEFAULT '0',
  `ordermoney` varchar(255) DEFAULT '0',
  `fadanid` int(10) DEFAULT '0',
  `fadanmoney` varchar(255) DEFAULT '0',
  `money` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `y_choucheng` varchar(255) DEFAULT '0' COMMENT '员工抽成',
  `p_choucheng` varchar(255) DEFAULT '0' COMMENT '平台抽成',
  `status` varchar(255) DEFAULT NULL COMMENT '说明',
  `leixing` int(10) DEFAULT '0' COMMENT '0为下单1为发单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_tixian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_tixian`;
CREATE TABLE `ims_hyb_o2o_tixian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `shouxufei` varchar(255) DEFAULT NULL,
  `apiclient_cert` varchar(255) DEFAULT NULL,
  `apiclient_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_tongzhi
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_tongzhi`;
CREATE TABLE `ims_hyb_o2o_tongzhi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(10) DEFAULT NULL,
  `xufei` varchar(255) DEFAULT NULL,
  `chongzhi` varchar(255) DEFAULT NULL,
  `fuwuyy` varchar(255) DEFAULT NULL,
  `fuwudj` varchar(255) DEFAULT NULL,
  `fuwuzf` varchar(255) DEFAULT NULL,
  `spzf` varchar(255) DEFAULT NULL,
  `ygsh` varchar(255) DEFAULT NULL,
  `jfdh` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_userchongzhi
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_userchongzhi`;
CREATE TABLE `ims_hyb_o2o_userchongzhi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `jibie` varchar(255) DEFAULT NULL COMMENT '充值的会员级别',
  `song` varchar(255) DEFAULT '0' COMMENT '充值赠送',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_userfenxiao
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_userfenxiao`;
CREATE TABLE `ims_hyb_o2o_userfenxiao` (
  `f_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `f_openid` varchar(255) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `f_tel` varchar(255) DEFAULT NULL,
  `f_address` varchar(255) DEFAULT NULL,
  `f_money` varchar(255) DEFAULT '0',
  `f_style` varchar(255) DEFAULT NULL,
  `f_time` varchar(255) DEFAULT NULL,
  `f_parentid` int(10) DEFAULT NULL,
  `f_type` int(10) DEFAULT '0',
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_userinfo`;
CREATE TABLE `ims_hyb_o2o_userinfo` (
  `u_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `u_name` varchar(255) DEFAULT NULL,
  `u_thumb` varchar(255) DEFAULT NULL,
  `u_type` int(10) DEFAULT '0' COMMENT '会员',
  `u_typeendtime` varchar(255) DEFAULT NULL,
  `u_money` varchar(255) DEFAULT '0.00',
  `u_shangjia` varchar(255) DEFAULT '0',
  `u_yuangong` varchar(255) DEFAULT '0',
  `u_jifen` varchar(255) DEFAULT '0',
  `u_fenxiao` int(10) DEFAULT '0' COMMENT '是否为分销',
  `u_tel` varchar(255) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=989 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_userinfo_bak
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_userinfo_bak`;
CREATE TABLE `ims_hyb_o2o_userinfo_bak` (
  `u_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `u_name` varchar(255) DEFAULT NULL,
  `u_thumb` varchar(255) DEFAULT NULL,
  `u_type` int(10) DEFAULT '0' COMMENT '会员',
  `u_typeendtime` varchar(255) DEFAULT NULL,
  `u_money` varchar(255) DEFAULT '0.00',
  `u_shangjia` varchar(255) DEFAULT '0',
  `u_yuangong` varchar(255) DEFAULT '0',
  `u_jifen` varchar(255) DEFAULT '0',
  `u_fenxiao` int(10) DEFAULT '0' COMMENT '是否为分销',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=803 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_userjifen
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_userjifen`;
CREATE TABLE `ims_hyb_o2o_userjifen` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `jnum` varchar(255) DEFAULT NULL COMMENT '兑换积分订单号',
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT '0' COMMENT '兑换所花金额',
  `time` varchar(255) DEFAULT NULL COMMENT '兑换时间',
  `jifen` varchar(255) DEFAULT '0' COMMENT '兑换所用积分',
  `statues` int(10) DEFAULT '0' COMMENT '0-未支付 1-等待发货 2-等待收货 -3完成',
  `j_id` int(10) DEFAULT NULL COMMENT '积分商品id',
  `address` varchar(255) DEFAULT NULL,
  `xxaddress` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `usertel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_usertixian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_usertixian`;
CREATE TABLE `ims_hyb_o2o_usertixian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tnum` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `u_id` int(10) DEFAULT '0',
  `s_id` int(10) DEFAULT '0',
  `y_id` int(10) DEFAULT '0',
  `money` varchar(255) DEFAULT NULL,
  `s_money` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `statue` varchar(255) DEFAULT NULL,
  `xingshi` varchar(255) DEFAULT NULL,
  `zhanghao` varchar(255) DEFAULT NULL,
  `xingming` varchar(255) DEFAULT NULL,
  `kaihuhang` varchar(255) DEFAULT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_useryouhuiquan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_useryouhuiquan`;
CREATE TABLE `ims_hyb_o2o_useryouhuiquan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `y_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '未使用、已使用',
  `x_id` int(10) DEFAULT NULL COMMENT '项目id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_xiangmu
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_xiangmu`;
CREATE TABLE `ims_hyb_o2o_xiangmu` (
  `x_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `x_name` varchar(255) DEFAULT NULL COMMENT '名称',
  `x_type` varchar(50) DEFAULT NULL COMMENT '所属分类',
  `x_thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `x_content` varchar(255) DEFAULT NULL COMMENT '内容',
  `x_jiage` varchar(255) DEFAULT NULL COMMENT '现价',
  `x_status` varchar(50) DEFAULT '0' COMMENT '上架',
  `x_hdp_thumb` longtext,
  `x_sjname` varchar(255) DEFAULT NULL,
  `x_yuyue` varchar(255) DEFAULT NULL,
  `x_xingshi` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `x_xiaoliang` int(255) DEFAULT '0',
  `x_jifen` varchar(255) DEFAULT '0' COMMENT '是否参加积分活动',
  `x_manjian` varchar(255) DEFAULT '0' COMMENT '是否参加减免活动',
  `x_youhuiquan` varchar(255) DEFAULT '0',
  `x_wxts` varchar(255) DEFAULT NULL,
  `x_danwei` varchar(255) DEFAULT NULL COMMENT '项目单位（服务时长或者次数）',
  `x_hyqy` varchar(255) DEFAULT NULL COMMENT '1开启0关闭',
  PRIMARY KEY (`x_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_xiangmu_type
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_xiangmu_type`;
CREATE TABLE `ims_hyb_o2o_xiangmu_type` (
  `xt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `xt_name` varchar(255) DEFAULT NULL,
  `xt_ids` varchar(50) DEFAULT NULL,
  `xt_thumb` varchar(255) DEFAULT NULL,
  `xt_p_id` int(10) DEFAULT '0' COMMENT '父级id',
  `xt_idss` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`xt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_yjtixian
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_yjtixian`;
CREATE TABLE `ims_hyb_o2o_yjtixian` (
  `yj_id` int(10) NOT NULL AUTO_INCREMENT,
  `yj_num` varchar(255) DEFAULT NULL COMMENT '佣金提现订单号',
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `yj_yongjin` varchar(255) DEFAULT NULL COMMENT '提现佣金数',
  `yj_money` varchar(255) DEFAULT NULL COMMENT '提现金额',
  `yj_time` varchar(255) DEFAULT NULL,
  `yj_statue` int(10) DEFAULT '0' COMMENT '0-失败   1-成功',
  PRIMARY KEY (`yj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_youhuiquan
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_youhuiquan`;
CREATE TABLE `ims_hyb_o2o_youhuiquan` (
  `y_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `y_name` varchar(255) DEFAULT NULL,
  `y_money` float(10,2) DEFAULT NULL,
  `y_shuoming` varchar(255) DEFAULT NULL,
  `y_yaoqiu` varchar(255) DEFAULT NULL,
  `y_starttime` varchar(255) DEFAULT NULL,
  `y_endtime` varchar(255) DEFAULT NULL,
  `shangjia` int(10) DEFAULT NULL,
  PRIMARY KEY (`y_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_yuangong
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_yuangong`;
CREATE TABLE `ims_hyb_o2o_yuangong` (
  `y_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `y_name` varchar(255) DEFAULT NULL,
  `y_openid` varchar(255) DEFAULT NULL,
  `y_thumb` varchar(255) DEFAULT NULL,
  `y_sex` varchar(255) DEFAULT NULL,
  `y_age` varchar(255) DEFAULT NULL,
  `y_telphone` varchar(255) DEFAULT NULL,
  `y_sjname` varchar(255) DEFAULT NULL,
  `y_imgpath1` varchar(255) DEFAULT NULL,
  `y_imgpath2` varchar(255) DEFAULT NULL,
  `y_jineng` longtext,
  `y_fwqy` longtext,
  `y_jdnum` varchar(255) DEFAULT NULL,
  `y_styles` varchar(255) DEFAULT NULL,
  `y_typs` varchar(255) DEFAULT NULL,
  `y_jin` int(10) DEFAULT '0' COMMENT '1为禁止',
  `y_time` varchar(255) DEFAULT NULL,
  `y_money` varchar(255) DEFAULT '0',
  `form_id` varchar(255) DEFAULT NULL,
  `y_rz` int(10) DEFAULT '0' COMMENT '0代表员工1代表技师',
  `y_choucheng` varchar(255) DEFAULT NULL,
  `y_zgeimg` varchar(255) DEFAULT NULL,
  `y_endtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`y_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_hyb_o2o_zhanghao
-- ----------------------------
DROP TABLE IF EXISTS `ims_hyb_o2o_zhanghao`;
CREATE TABLE `ims_hyb_o2o_zhanghao` (
  `z_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `zhanghao` varchar(255) DEFAULT NULL,
  `mima` varchar(255) DEFAULT NULL,
  `z_shangjia` varchar(255) DEFAULT NULL,
  `status` int(10) DEFAULT '1',
  PRIMARY KEY (`z_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
