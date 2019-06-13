<?php
//升级数据表
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_addres_bak` (
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

");

if(!pdo_fieldexists('hyb_o2o_addres_bak','d_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD 
  `d_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','d_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `d_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','d_xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `d_xxaddress` varchar(255) DEFAULT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','d_uname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `d_uname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','d_phone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `d_phone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_addres_bak','d_checked')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_addres_bak')." ADD   `d_checked` int(10) DEFAULT '0' COMMENT '是否设为默认'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_address` (
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

");

if(!pdo_fieldexists('hyb_o2o_address','d_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD 
  `d_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_address','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_address','d_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `d_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_address','d_xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `d_xxaddress` varchar(255) DEFAULT NULL COMMENT '详细地址'");}
if(!pdo_fieldexists('hyb_o2o_address','d_uname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `d_uname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_address','d_phone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `d_phone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_address','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_address','d_checked')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_address')." ADD   `d_checked` int(10) DEFAULT '0' COMMENT '是否设为默认'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_base` (
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

");

if(!pdo_fieldexists('hyb_o2o_base','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_base','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `thumb` longtext");}
if(!pdo_fieldexists('hyb_o2o_base','city_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `city_type` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_base','city')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `city` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','banquan')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `banquan` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','baidukey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `baidukey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','xieyi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `xieyi` longtext");}
if(!pdo_fieldexists('hyb_o2o_base','gaodekey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `gaodekey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','gaodexcxkey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `gaodexcxkey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','sm_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `sm_money` varchar(255) DEFAULT NULL COMMENT '上门服务费'");}
if(!pdo_fieldexists('hyb_o2o_base','pt_show')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `pt_show` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_base','qjbcolor')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `qjbcolor` varchar(255) DEFAULT NULL COMMENT '上门服务费'");}
if(!pdo_fieldexists('hyb_o2o_base','s_ttthumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `s_ttthumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','fdsh_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `fdsh_type` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_base','qjcolor')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `qjcolor` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_base','bcolor')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_base')." ADD   `bcolor` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_city` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parentid` int(10) DEFAULT '0',
  `tuijian` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=990110 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_city','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_city')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_city','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_city')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_city','name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_city')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_city','parentid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_city')." ADD   `parentid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_city','tuijian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_city')." ADD   `tuijian` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_cunchu` (
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

");

if(!pdo_fieldexists('hyb_o2o_cunchu','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_cunchu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','alioss_key')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `alioss_key` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','alioss_secret')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `alioss_secret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','alioss_bucket')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `alioss_bucket` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','alioss_url')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `alioss_url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','alioss_ossurl')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `alioss_ossurl` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','qiniu_accesskey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `qiniu_accesskey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','qiniu_secretkey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `qiniu_secretkey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','qiniu_bucket')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `qiniu_bucket` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','qiniu_url')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `qiniu_url` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_cunchu','type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_cunchu')." ADD   `type` varchar(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_daohang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '导航标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '导航图标',
  `thumb2` varchar(255) DEFAULT NULL COMMENT '导航切换图标',
  `lianjie` varchar(255) DEFAULT NULL COMMENT '导航链接',
  `ids` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_daohang','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_daohang','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_daohang','title')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD   `title` varchar(255) DEFAULT NULL COMMENT '导航标题'");}
if(!pdo_fieldexists('hyb_o2o_daohang','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD   `thumb` varchar(255) DEFAULT NULL COMMENT '导航图标'");}
if(!pdo_fieldexists('hyb_o2o_daohang','thumb2')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD   `thumb2` varchar(255) DEFAULT NULL COMMENT '导航切换图标'");}
if(!pdo_fieldexists('hyb_o2o_daohang','lianjie')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD   `lianjie` varchar(255) DEFAULT NULL COMMENT '导航链接'");}
if(!pdo_fieldexists('hyb_o2o_daohang','ids')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_daohang')." ADD   `ids` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `shi` varchar(255) DEFAULT NULL,
  `xian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2861 DEFAULT CHARSET=utf8 COMMENT='高德行政区域数据';

");

if(!pdo_fieldexists('hyb_o2o_district','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_district')." ADD 
  `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_district','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_district')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_district','shi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_district')." ADD   `shi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_district','xian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_district')." ADD   `xian` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_email` (
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

");

if(!pdo_fieldexists('hyb_o2o_email','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_email','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailhost')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailhost` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailport')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailport` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailhostname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailhostname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailformname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailformname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailusername')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailusername` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailpassword')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailpassword` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_email','mailsend')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_email')." ADD   `mailsend` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fadan` (
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

");

if(!pdo_fieldexists('hyb_o2o_fadan','fa_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD 
  `fa_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fadan','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_ordersn')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwimgpath')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwimgpath` longtext");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwstyle1')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwstyle1` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwstyle2')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwstyle2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwmoney')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwmoney` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwaddresss')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwaddresss` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwlongitude')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwlongitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwlatitude')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwlatitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwcontent')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwcontent` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwtelphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwtelphone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_style')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_style` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwpay_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwpay_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwpay_types')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwpay_types` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_fwshagneng')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_fwshagneng` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_pay')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_pay` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fadan','fa_dizhi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `fa_dizhi` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fadan','del')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fadan')." ADD   `del` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fenxiao` (
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

");

if(!pdo_fieldexists('hyb_o2o_fenxiao','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','is_open')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `is_open` int(10) DEFAULT NULL COMMENT '是否开启分销1开启2关闭'");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','is_ej')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `is_ej` int(10) DEFAULT NULL COMMENT '是否开启二级分销1开启2关闭'");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','fzthumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `fzthumb` longtext");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','sfthumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `sfthumb` longtext");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','fxthumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `fxthumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','y_moneyyi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `y_moneyyi` varchar(255) DEFAULT NULL COMMENT '一级佣金'");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','y_moneyer')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `y_moneyer` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','tx_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `tx_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','tx_rate')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `tx_rate` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','fx_details')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `fx_details` longtext");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','tx_details')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `tx_details` longtext");}
if(!pdo_fieldexists('hyb_o2o_fenxiao','instructions')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiao')." ADD   `instructions` longtext");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fenxiaotixian` (
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

");

if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD 
  `t_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_fopenid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_fopenid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_fid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_fid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_shouxufei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_shouxufei` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaotixian','t_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaotixian')." ADD   `t_type` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fenxiaoyongjin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `yonghu` varchar(255) DEFAULT NULL,
  `yongjin` varchar(255) DEFAULT NULL,
  `parentid` int(10) DEFAULT NULL,
  `parentopenid` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','yonghu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD   `yonghu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','yongjin')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD   `yongjin` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','parentid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD   `parentid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','parentopenid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD   `parentopenid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fenxiaoyongjin','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fenxiaoyongjin')." ADD   `time` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fuwu` (
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

");

if(!pdo_fieldexists('hyb_o2o_fuwu','x_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD 
  `x_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fuwu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_parenttype')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_parenttype` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_xingshi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_xingshi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_thumbs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_thumbs` longtext");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_pay_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_pay_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_pay_bili')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_pay_bili` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_pay_smgj')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_pay_smgj` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_guigename')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_guigename` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_guigecontent')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_guigecontent` longtext");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_content` longtext");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_jianjie_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_jianjie_thumb` longtext");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_wenxintishi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_wenxintishi` text");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_jiage')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_jiage` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_danwei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_danwei` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_xiaoliang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_xiaoliang` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_status` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_shangjia` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_jifenstatus')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_jifenstatus` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_jifen` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_manjianstatus')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_manjianstatus` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_manjian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_manjian` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_huiyuanstatus')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_huiyuanstatus` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_youhuiquanstatus')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_youhuiquanstatus` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_youhuiquan')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_youhuiquan` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_tuijian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_tuijian` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','x_timecontent')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `x_timecontent` longtext");}
if(!pdo_fieldexists('hyb_o2o_fuwu','fx_yi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `fx_yi` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu','fx_er')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu')." ADD   `fx_er` varchar(255) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fuwu_time` (
  `x_id` int(10) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL COMMENT '选择的时间',
  `time` varchar(255) DEFAULT NULL COMMENT '选择的时间段',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_id` int(11) DEFAULT NULL,
  `status` int(3) NOT NULL DEFAULT '0' COMMENT '1 已下单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_fuwu_time','x_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD 
  `x_id` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_time','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_time','date')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD   `date` varchar(255) DEFAULT NULL COMMENT '选择的时间'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_time','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD   `time` varchar(255) DEFAULT NULL COMMENT '选择的时间段'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_time','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD   `id` int(11) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fuwu_time','o_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD   `o_id` int(11) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_time','status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_time')." ADD   `status` int(3) NOT NULL DEFAULT '0' COMMENT '1 已下单'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fuwu_type` (
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

");

if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD 
  `xt_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_ids')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_ids` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_tuijian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_tuijian` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_parentid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_parentid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','choushui')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `choushui` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_tuijian_fabu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_tuijian_fabu` int(2) NOT NULL DEFAULT '0' COMMENT '推荐是否跳转发布'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_reference_price')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_reference_price` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '平台参考价'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_tzej')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_tzej` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_fuwu_type','xt_smreference_price')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwu_type')." ADD   `xt_smreference_price` decimal(10,2) DEFAULT '0.00'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fuwupingjia` (
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

");

if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD 
  `p_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_content` text");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_pic')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_pic` longtext");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_sid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_sid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_fenshu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_fenshu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_huifu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_huifu` text");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_htime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_htime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_fuwupingjia','p_yid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fuwupingjia')." ADD   `p_yid` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_fxuser` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL COMMENT '用户openid',
  `y_openid` varchar(255) DEFAULT NULL COMMENT '被邀人openid',
  `y_order` int(10) DEFAULT '0' COMMENT '被邀请的人是否下单',
  `uniacid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_fxuser','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fxuser')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_fxuser','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fxuser')." ADD   `openid` varchar(255) DEFAULT NULL COMMENT '用户openid'");}
if(!pdo_fieldexists('hyb_o2o_fxuser','y_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fxuser')." ADD   `y_openid` varchar(255) DEFAULT NULL COMMENT '被邀人openid'");}
if(!pdo_fieldexists('hyb_o2o_fxuser','y_order')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fxuser')." ADD   `y_order` int(10) DEFAULT '0' COMMENT '被邀请的人是否下单'");}
if(!pdo_fieldexists('hyb_o2o_fxuser','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_fxuser')." ADD   `uniacid` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_gonggao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_gonggao','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_gonggao')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_gonggao','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_gonggao')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_gonggao','title')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_gonggao')." ADD   `title` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_gonggao','content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_gonggao')." ADD   `content` longtext");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_goods` (
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

");

if(!pdo_fieldexists('hyb_o2o_goods','g_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD 
  `g_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_goods','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_city')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_city` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_jiage')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_jiage` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_goods','g_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_thumbs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_thumbs` longtext");}
if(!pdo_fieldexists('hyb_o2o_goods','g_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_content` longtext");}
if(!pdo_fieldexists('hyb_o2o_goods','g_baoyou')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_baoyou` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_kuaidi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_kuaidi` int(11) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_goods','g_guigename')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_guigename` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_guigecontent')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_guigecontent` longtext");}
if(!pdo_fieldexists('hyb_o2o_goods','g_xiaoliang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_xiaoliang` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_goods','g_status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_status` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_goods','g_tuijian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_tuijian` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','g_ids')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `g_ids` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods','fx_yi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `fx_yi` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_goods','fx_er')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods')." ADD   `fx_er` varchar(255) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_goods_style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_goods_style','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods_style')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_goods_style','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods_style')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goods_style','title')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goods_style')." ADD   `title` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_goodspingjia` (
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

");

if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD 
  `p_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_content` text");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_pic')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_pic` longtext");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_sid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_sid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_fenshu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_fenshu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_huifu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_huifu` text");}
if(!pdo_fieldexists('hyb_o2o_goodspingjia','p_htime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_goodspingjia')." ADD   `p_htime` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_huiyuan` (
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

");

if(!pdo_fieldexists('hyb_o2o_huiyuan','h_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD 
  `h_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_zhekou')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_zhekou` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_money` varchar(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_song')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_song` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_huiyuan','h_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huiyuan')." ADD   `h_time` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_huodong` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_huodong','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huodong')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_huodong','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huodong')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huodong','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huodong')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huodong','appid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huodong')." ADD   `appid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_huodong','path')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_huodong')." ADD   `path` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_img` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=973 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_img','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_img')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_img','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_img')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_img','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_img')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_img','imgs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_img')." ADD   `imgs` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_img','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_img')." ADD   `time` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jfgoods` (
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

");

if(!pdo_fieldexists('hyb_o2o_jfgoods','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','thumbs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `thumbs` longtext");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `content` longtext");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','num')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `num` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfgoods','status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfgoods')." ADD   `status` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jforder` (
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

");

if(!pdo_fieldexists('hyb_o2o_jforder','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jforder','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','ordersn')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `time` varchar(255) DEFAULT NULL COMMENT '兑换时间'");}
if(!pdo_fieldexists('hyb_o2o_jforder','jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `jifen` varchar(255) DEFAULT '0' COMMENT '兑换所用积分'");}
if(!pdo_fieldexists('hyb_o2o_jforder','statues')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `statues` int(10) DEFAULT '0' COMMENT '0-未支付 1-等待发货 2-等待收货 -3完成'");}
if(!pdo_fieldexists('hyb_o2o_jforder','j_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `j_id` int(10) DEFAULT NULL COMMENT '积分商品id'");}
if(!pdo_fieldexists('hyb_o2o_jforder','address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `xxaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','username')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `username` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','usertel')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `usertel` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','form_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `form_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jforder','type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jforder')." ADD   `type` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jfthumb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_jfthumb','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfthumb')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jfthumb','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfthumb')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfthumb','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfthumb')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfthumb','appid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfthumb')." ADD   `appid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jfthumb','path')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jfthumb')." ADD   `path` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jianmian` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `m_money` int(20) DEFAULT NULL,
  `j_money` int(20) DEFAULT NULL,
  `statue` int(10) DEFAULT NULL,
  `uniacid` int(20) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_jianmian','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jianmian')." ADD 
  `id` int(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jianmian','m_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jianmian')." ADD   `m_money` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jianmian','j_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jianmian')." ADD   `j_money` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jianmian','statue')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jianmian')." ADD   `statue` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jianmian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jianmian')." ADD   `uniacid` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jianmian','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jianmian')." ADD   `openid` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jibie` (
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

");

if(!pdo_fieldexists('hyb_o2o_jibie','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_zhekou')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_zhekou` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jibie','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_chong')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_chong` int(20) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_xiaofei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_xiaofei` int(20) NOT NULL DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_money` int(20) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_jibie','j_song')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jibie')." ADD   `j_song` int(20) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jifen` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `f_jifen` int(20) DEFAULT '0' COMMENT '分享所得积分（分享）',
  `uniacid` int(20) DEFAULT NULL,
  `b_jifen` int(20) DEFAULT '0' COMMENT '购买所得积分',
  `statue` int(10) DEFAULT '0' COMMENT '积分状态：0-关闭；1-开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_jifen','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jifen')." ADD 
  `id` int(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jifen','f_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jifen')." ADD   `f_jifen` int(20) DEFAULT '0' COMMENT '分享所得积分（分享）'");}
if(!pdo_fieldexists('hyb_o2o_jifen','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jifen')." ADD   `uniacid` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jifen','b_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jifen')." ADD   `b_jifen` int(20) DEFAULT '0' COMMENT '购买所得积分'");}
if(!pdo_fieldexists('hyb_o2o_jifen','statue')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jifen')." ADD   `statue` int(10) DEFAULT '0' COMMENT '积分状态：0-关闭；1-开启'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_jishiset` (
  `r_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `r_money` varchar(255) DEFAULT NULL,
  `r_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_jishiset','r_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jishiset')." ADD 
  `r_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_jishiset','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jishiset')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jishiset','r_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jishiset')." ADD   `r_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_jishiset','r_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_jishiset')." ADD   `r_time` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_manjian` (
  `m_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `m_money` int(10) DEFAULT NULL,
  `j_money` int(10) DEFAULT NULL,
  `shangjia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_manjian','m_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_manjian')." ADD 
  `m_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_manjian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_manjian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_manjian','m_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_manjian')." ADD   `m_money` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_manjian','j_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_manjian')." ADD   `j_money` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_manjian','shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_manjian')." ADD   `shangjia` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_memdian` (
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

");

if(!pdo_fieldexists('hyb_o2o_memdian','md_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD 
  `md_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_memdian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_name` varchar(50) DEFAULT NULL COMMENT '门店名称'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_thumb` longtext COMMENT '门店宣传图'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_content` longtext COMMENT '门店内容'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_address` varchar(255) DEFAULT NULL COMMENT '门店地址'");}
if(!pdo_fieldexists('hyb_o2o_memdian','latitude')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `latitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_memdian','longitude')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `longitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_telphone` varchar(255) DEFAULT NULL COMMENT '门店联系电话'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_shouxufei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_shouxufei` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_money` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_index')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_index` varchar(255) DEFAULT NULL COMMENT '门店首页地址'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_f_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_f_jifen` int(10) DEFAULT '0' COMMENT '分销为积分时一次积多少分'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_f_yongjin')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_f_yongjin` int(10) DEFAULT '0' COMMENT '分销为佣金时一次多少佣金'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_jfthumbs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_jfthumbs` longtext COMMENT '积分商品页的幻灯片'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_f_yjtx')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_f_yjtx` varchar(255) DEFAULT '0' COMMENT '佣金提现兑换数'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_f_eyongjin')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_f_eyongjin` int(10) DEFAULT '0' COMMENT '二级分销成功一级所得佣金'");}
if(!pdo_fieldexists('hyb_o2o_memdian','md_f_ejifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_memdian')." ADD   `md_f_ejifen` int(10) DEFAULT '0' COMMENT '二级分销成功一级所得积分'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_mendian` (
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

");

if(!pdo_fieldexists('hyb_o2o_mendian','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_mendian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','thumbs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `thumbs` longtext");}
if(!pdo_fieldexists('hyb_o2o_mendian','content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `content` longtext");}
if(!pdo_fieldexists('hyb_o2o_mendian','address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','xaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `xaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','latitude')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `latitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','longitude')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `longitude` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `telphone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','fuzeren')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `fuzeren` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','yingyetime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `yingyetime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','fuwustyle')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `fuwustyle` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','baozhang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `baozhang` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_mendian','fwfw')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_mendian')." ADD   `fwfw` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_moban` (
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

");

if(!pdo_fieldexists('hyb_o2o_moban','m_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD 
  `m_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_moban','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','show')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `show` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','huiyuan')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `huiyuan` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','zhishi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `zhishi` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','fuwu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `fuwu` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','title')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `title` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_moban','select')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_moban')." ADD   `select` varchar(255) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_news` (
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

");

if(!pdo_fieldexists('hyb_o2o_news','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_news','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','accessKeyId')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `accessKeyId` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','accessKeySecret')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `accessKeySecret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','SignName')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `SignName` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','shtz')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `shtz` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','pdtzyh')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `pdtzyh` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','pdtzyg')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `pdtzyg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','fdtz')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `fdtz` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','fdtzyh')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `fdtzyh` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','fdtzyg')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `fdtzyg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','rztz')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `rztz` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','sjrztz')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `sjrztz` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','ddtzsjkf')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `ddtzsjkf` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','ddtzsjwc')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `ddtzsjwc` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','fdtzsh')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `fdtzsh` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','qdtzyh')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `qdtzyh` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','fdtzfwk')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `fdtzfwk` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','fdtzfww')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `fdtzfww` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','ddtzzf')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `ddtzzf` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','ddtzzfq')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `ddtzzfq` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','baojia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `baojia` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','yzm')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `yzm` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','tybaojia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `tybaojia` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','btybaojia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `btybaojia` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_news','xdtzyg')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_news')." ADD   `xdtzyg` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_order` (
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

");

if(!pdo_fieldexists('hyb_o2o_order','o_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD 
  `o_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_order','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_telphone` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_xiangmu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_xiangmu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_num')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_num` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_xid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_xid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_monney')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_monney` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_count_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_count_money` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_yy_riqi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_yy_riqi` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_beizhu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_beizhu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_xdtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_xdtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_xiangmu_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_xiangmu_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','ordersn')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_status` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_order','o_xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_xxaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_sex')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_sex` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_order','o_pingjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_pingjia` int(10) DEFAULT '0' COMMENT '评价状态 0-未评价 1-已评价'");}
if(!pdo_fieldexists('hyb_o2o_order','o_store')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_order')." ADD   `o_store` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_orderfuwu` (
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

");

if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD 
  `o_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','ordersn')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_telphone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xxaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_localtion')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_localtion` varchar(100) DEFAULT NULL COMMENT '订单收货地址经纬度'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xiangmu_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xiangmu_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xiangmu_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xiangmu_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xiangmu_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xiangmu_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xiangmu_xingshi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xiangmu_xingshi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xiangmu_guige')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xiangmu_guige` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xiangmu_guigemoney')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xiangmu_guigemoney` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_num')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_num` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_yy_riqi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_yy_riqi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_fwry')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_fwry` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_ding_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_ding_money` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_sheng_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_sheng_money` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_shangmen_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_shangmen_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_count_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_count_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_beizhu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_beizhu` text");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_xdtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_xdtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_pay_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_pay_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_pay_types')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_pay_types` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_store')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_store` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_huiyaunyouhui')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_huiyaunyouhui` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_youhuiquanyouhui')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_youhuiquanyouhui` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_manjianyouhui')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_manjianyouhui` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_pingjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_pingjia` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_fw_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_fw_type` int(10) DEFAULT '0' COMMENT '1代表服务中2代表服务完成'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_pay_typess')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_pay_typess` varchar(255) DEFAULT NULL COMMENT '支付方式'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_hexiaomashuzi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_hexiaomashuzi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','yonghu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `yonghu` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `shangjia` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_fwry_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_fwry_id` int(10) DEFAULT NULL COMMENT '服务人员id'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_uid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_uid` int(10) DEFAULT NULL COMMENT '下单人员id'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','yg')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `yg` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_orderfuwu','o_fwry_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_orderfuwu')." ADD   `o_fwry_type` int(10) DEFAULT NULL COMMENT '0代表员工/技师  1代表商家'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_ordergoods` (
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

");

if(!pdo_fieldexists('hyb_o2o_ordergoods','o_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD 
  `o_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','ordersn')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `ordersn` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_telphone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_xxaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_gid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_gid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_goodsname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_goodsname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_goodsthumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_goodsthumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_goodsguige')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_goodsguige` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_num')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_num` int(10) DEFAULT '1'");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_monney')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_monney` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_count_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_count_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_kuaidi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_kuaidi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_beizhu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_beizhu` text");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_xdtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_xdtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_pingjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_pingjia` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_ordergoods','o_pay_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_ordergoods')." ADD   `o_pay_type` varchar(255) NOT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_paidan` (
  `p_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `p_qdname` varchar(255) DEFAULT NULL,
  `p_openid` varchar(255) DEFAULT NULL,
  `p_name` varchar(255) DEFAULT NULL,
  `p_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_paidan','p_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidan')." ADD 
  `p_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_paidan','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidan')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidan','p_qdname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidan')." ADD   `p_qdname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidan','p_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidan')." ADD   `p_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidan','p_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidan')." ADD   `p_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidan','p_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidan')." ADD   `p_time` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_paidanpingjia` (
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

");

if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD 
  `pj_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `pj_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `pj_content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_fen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `pj_fen` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_yuangong')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `pj_yuangong` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `pj_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpingjia','pj_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpingjia')." ADD   `pj_name` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_paidanpj` (
  `pj_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `pj_openid` varchar(255) DEFAULT NULL,
  `pj_content` varchar(255) DEFAULT NULL,
  `pj_fen` varchar(255) DEFAULT NULL,
  `pj_yuangong` varchar(255) DEFAULT NULL,
  `pj_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_paidanpj','pj_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD 
  `pj_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_paidanpj','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpj','pj_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD   `pj_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpj','pj_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD   `pj_content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpj','pj_fen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD   `pj_fen` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpj','pj_yuangong')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD   `pj_yuangong` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_paidanpj','pj_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_paidanpj')." ADD   `pj_time` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_parameter` (
  `k_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `mch_id` varchar(255) DEFAULT NULL,
  `appkey` varchar(255) DEFAULT NULL,
  `mbid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`k_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_parameter','k_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD 
  `k_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_parameter','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parameter','appid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD   `appid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parameter','appsecret')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD   `appsecret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parameter','mch_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD   `mch_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parameter','appkey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD   `appkey` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parameter','mbid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parameter')." ADD   `mbid` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_parment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `mchid` varchar(255) DEFAULT NULL,
  `wxkey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_parment','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parment')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_parment','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parment')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parment','appid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parment')." ADD   `appid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parment','appsecret')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parment')." ADD   `appsecret` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parment','mchid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parment')." ADD   `mchid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_parment','wxkey')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_parment')." ADD   `wxkey` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_pingjia` (
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

");

if(!pdo_fieldexists('hyb_o2o_pingjia','p_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD 
  `p_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_content` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_huifu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_huifu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_sjopenid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_sjopenid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_sjname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_sjname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_xiangmu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_xiangmu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_xid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_xid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_htime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_htime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_onum')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_onum` varchar(255) DEFAULT NULL COMMENT '评价的订单号'");}
if(!pdo_fieldexists('hyb_o2o_pingjia','fw_pingfen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `fw_pingfen` int(10) DEFAULT '0' COMMENT '店铺评分'");}
if(!pdo_fieldexists('hyb_o2o_pingjia','sp_pingfen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `sp_pingfen` int(10) DEFAULT '0' COMMENT '项目评分'");}
if(!pdo_fieldexists('hyb_o2o_pingjia','p_pic')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_pingjia')." ADD   `p_pic` longtext");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_qiangdan` (
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

");

if(!pdo_fieldexists('hyb_o2o_qiangdan','q_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD 
  `q_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_dname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_dname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_types')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_types` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_pdname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_pdname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_pd_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_pd_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_qiangdan','q_styles')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_qiangdan')." ADD   `q_styles` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_question` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_question','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_question')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_question','question')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_question')." ADD   `question` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_question','answer')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_question')." ADD   `answer` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_question','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_question')." ADD   `uniacid` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_shangjia` (
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

");

if(!pdo_fieldexists('hyb_o2o_shangjia','s_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD 
  `s_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_shangjia','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_u_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_u_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_u_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_u_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_telphone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_content` longtext");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_yingyetime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_yingyetime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_xxaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','jing')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `jing` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','wei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `wei` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_imgpath')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_imgpath` longtext");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_zhizhao')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_zhizhao` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_money` float(255,2) DEFAULT '0.00'");}
if(!pdo_fieldexists('hyb_o2o_shangjia','ruzhu_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `ruzhu_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','ruzhu_endtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `ruzhu_endtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_status` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_tuijian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_tuijian` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_xiaoliang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_xiaoliang` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_shangjia','pingtai')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `pingtai` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','label')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `label` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_ids')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_ids` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','baozhang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `baozhang` longtext");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_idcard')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_idcard` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_idcard2')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_idcard2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','s_dizhi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `s_dizhi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjia','fwfw')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjia')." ADD   `fwfw` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_shangjiaruzhu` (
  `r_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `r_money` varchar(255) DEFAULT NULL,
  `r_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_shangjiaruzhu','r_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjiaruzhu')." ADD 
  `r_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_shangjiaruzhu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjiaruzhu')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjiaruzhu','r_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjiaruzhu')." ADD   `r_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_shangjiaruzhu','r_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_shangjiaruzhu')." ADD   `r_time` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_sjliushui` (
  `l_id` int(20) NOT NULL AUTO_INCREMENT,
  `s_id` int(20) DEFAULT NULL,
  `l_total` varchar(20) DEFAULT '0',
  `l_dtotal` varchar(20) DEFAULT '0',
  `l_mtotal` varchar(20) DEFAULT '0',
  `l_ytotal` varchar(20) DEFAULT '0',
  `uniacid` int(10) DEFAULT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_sjliushui','l_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD 
  `l_id` int(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_sjliushui','s_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD   `s_id` int(20) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjliushui','l_total')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD   `l_total` varchar(20) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_sjliushui','l_dtotal')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD   `l_dtotal` varchar(20) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_sjliushui','l_mtotal')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD   `l_mtotal` varchar(20) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_sjliushui','l_ytotal')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD   `l_ytotal` varchar(20) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_sjliushui','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjliushui')." ADD   `uniacid` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_sjruzhu` (
  `r_id` int(10) NOT NULL AUTO_INCREMENT,
  `r_time` varchar(255) DEFAULT NULL,
  `r_money` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `r_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_sjruzhu','r_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjruzhu')." ADD 
  `r_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_sjruzhu','r_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjruzhu')." ADD   `r_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjruzhu','r_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjruzhu')." ADD   `r_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjruzhu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjruzhu')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjruzhu','r_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjruzhu')." ADD   `r_name` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_sjtype` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) DEFAULT NULL,
  `t_thumb` varchar(255) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `t_statue` varchar(20) DEFAULT NULL COMMENT '是否在首页显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_sjtype','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjtype')." ADD 
  `id` int(20) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_sjtype','t_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjtype')." ADD   `t_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjtype','t_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjtype')." ADD   `t_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjtype','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjtype')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_sjtype','t_statue')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_sjtype')." ADD   `t_statue` varchar(20) DEFAULT NULL COMMENT '是否在首页显示'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_symx` (
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

");

if(!pdo_fieldexists('hyb_o2o_symx','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_symx','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_symx','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_symx','orderid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `orderid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_symx','ordermoney')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `ordermoney` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_symx','fadanid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `fadanid` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_symx','fadanmoney')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `fadanmoney` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_symx','money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_symx','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_symx','type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `type` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_symx','y_choucheng')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `y_choucheng` varchar(255) DEFAULT '0' COMMENT '员工抽成'");}
if(!pdo_fieldexists('hyb_o2o_symx','p_choucheng')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `p_choucheng` varchar(255) DEFAULT '0' COMMENT '平台抽成'");}
if(!pdo_fieldexists('hyb_o2o_symx','status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `status` varchar(255) DEFAULT NULL COMMENT '说明'");}
if(!pdo_fieldexists('hyb_o2o_symx','leixing')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_symx')." ADD   `leixing` int(10) DEFAULT '0' COMMENT '0为下单1为发单'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_tixian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `shouxufei` varchar(255) DEFAULT NULL,
  `apiclient_cert` varchar(255) DEFAULT NULL,
  `apiclient_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_tixian','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tixian')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_tixian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tixian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tixian','shouxufei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tixian')." ADD   `shouxufei` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tixian','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tixian')." ADD   `apiclient_cert` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tixian','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tixian')." ADD   `apiclient_key` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_tongzhi` (
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

");

if(!pdo_fieldexists('hyb_o2o_tongzhi','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `uniacid` varchar(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','xufei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `xufei` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','chongzhi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `chongzhi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','fuwuyy')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `fuwuyy` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','fuwudj')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `fuwudj` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','fuwuzf')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `fuwuzf` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','spzf')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `spzf` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','ygsh')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `ygsh` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_tongzhi','jfdh')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_tongzhi')." ADD   `jfdh` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_userchongzhi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `money` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `jibie` varchar(255) DEFAULT NULL COMMENT '充值的会员级别',
  `song` varchar(255) DEFAULT '0' COMMENT '充值赠送',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_userchongzhi','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_userchongzhi','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userchongzhi','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userchongzhi','money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD   `money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userchongzhi','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD   `time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userchongzhi','jibie')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD   `jibie` varchar(255) DEFAULT NULL COMMENT '充值的会员级别'");}
if(!pdo_fieldexists('hyb_o2o_userchongzhi','song')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userchongzhi')." ADD   `song` varchar(255) DEFAULT '0' COMMENT '充值赠送'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_userfenxiao` (
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

");

if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD 
  `f_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_tel')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_tel` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_money` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_style')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_style` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_parentid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_parentid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userfenxiao','f_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userfenxiao')." ADD   `f_type` int(10) DEFAULT '0'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_userinfo` (
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

");

if(!pdo_fieldexists('hyb_o2o_userinfo','u_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD 
  `u_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_userinfo','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_type` int(10) DEFAULT '0' COMMENT '会员'");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_typeendtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_typeendtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_money` varchar(255) DEFAULT '0.00'");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_shangjia` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_yuangong')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_yuangong` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_jifen` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_fenxiao')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_fenxiao` int(10) DEFAULT '0' COMMENT '是否为分销'");}
if(!pdo_fieldexists('hyb_o2o_userinfo','u_tel')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `u_tel` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','lat')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `lat` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo','lon')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo')." ADD   `lon` varchar(50) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_userinfo_bak` (
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

");

if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD 
  `u_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_type` int(10) DEFAULT '0' COMMENT '会员'");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_typeendtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_typeendtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_money` varchar(255) DEFAULT '0.00'");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_shangjia` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_yuangong')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_yuangong` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_jifen` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_userinfo_bak','u_fenxiao')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userinfo_bak')." ADD   `u_fenxiao` int(10) DEFAULT '0' COMMENT '是否为分销'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_userjifen` (
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

");

if(!pdo_fieldexists('hyb_o2o_userjifen','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_userjifen','jnum')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `jnum` varchar(255) DEFAULT NULL COMMENT '兑换积分订单号'");}
if(!pdo_fieldexists('hyb_o2o_userjifen','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userjifen','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userjifen','money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `money` varchar(255) DEFAULT '0' COMMENT '兑换所花金额'");}
if(!pdo_fieldexists('hyb_o2o_userjifen','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `time` varchar(255) DEFAULT NULL COMMENT '兑换时间'");}
if(!pdo_fieldexists('hyb_o2o_userjifen','jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `jifen` varchar(255) DEFAULT '0' COMMENT '兑换所用积分'");}
if(!pdo_fieldexists('hyb_o2o_userjifen','statues')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `statues` int(10) DEFAULT '0' COMMENT '0-未支付 1-等待发货 2-等待收货 -3完成'");}
if(!pdo_fieldexists('hyb_o2o_userjifen','j_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `j_id` int(10) DEFAULT NULL COMMENT '积分商品id'");}
if(!pdo_fieldexists('hyb_o2o_userjifen','address')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `address` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userjifen','xxaddress')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `xxaddress` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userjifen','username')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `username` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_userjifen','usertel')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_userjifen')." ADD   `usertel` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_usertixian` (
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

");

if(!pdo_fieldexists('hyb_o2o_usertixian','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_usertixian','tnum')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `tnum` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','u_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `u_id` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_usertixian','s_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `s_id` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_usertixian','y_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `y_id` int(10) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_usertixian','money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','s_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `s_money` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','statue')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `statue` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','xingshi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `xingshi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','zhanghao')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `zhanghao` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','xingming')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `xingming` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','kaihuhang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `kaihuhang` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_usertixian','partner_trade_no')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_usertixian')." ADD   `partner_trade_no` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_useryouhuiquan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `y_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '未使用、已使用',
  `x_id` int(10) DEFAULT NULL COMMENT '项目id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_useryouhuiquan','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_useryouhuiquan')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_useryouhuiquan','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_useryouhuiquan')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_useryouhuiquan','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_useryouhuiquan')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_useryouhuiquan','y_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_useryouhuiquan')." ADD   `y_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_useryouhuiquan','type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_useryouhuiquan')." ADD   `type` varchar(255) DEFAULT NULL COMMENT '未使用、已使用'");}
if(!pdo_fieldexists('hyb_o2o_useryouhuiquan','x_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_useryouhuiquan')." ADD   `x_id` int(10) DEFAULT NULL COMMENT '项目id'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_xiangmu` (
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

");

if(!pdo_fieldexists('hyb_o2o_xiangmu','x_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD 
  `x_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_name` varchar(255) DEFAULT NULL COMMENT '名称'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_type')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_type` varchar(50) DEFAULT NULL COMMENT '所属分类'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_thumb` varchar(255) DEFAULT NULL COMMENT '缩略图'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_content')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_content` varchar(255) DEFAULT NULL COMMENT '内容'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_jiage')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_jiage` varchar(255) DEFAULT NULL COMMENT '现价'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_status` varchar(50) DEFAULT '0' COMMENT '上架'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_hdp_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_hdp_thumb` longtext");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_sjname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_sjname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_yuyue')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_yuyue` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_xingshi')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_xingshi` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','label')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `label` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_xiaoliang')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_xiaoliang` int(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_jifen')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_jifen` varchar(255) DEFAULT '0' COMMENT '是否参加积分活动'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_manjian')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_manjian` varchar(255) DEFAULT '0' COMMENT '是否参加减免活动'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_youhuiquan')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_youhuiquan` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_wxts')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_wxts` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_danwei')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_danwei` varchar(255) DEFAULT NULL COMMENT '项目单位（服务时长或者次数）'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu','x_hyqy')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu')." ADD   `x_hyqy` varchar(255) DEFAULT NULL COMMENT '1开启0关闭'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_xiangmu_type` (
  `xt_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `xt_name` varchar(255) DEFAULT NULL,
  `xt_ids` varchar(50) DEFAULT NULL,
  `xt_thumb` varchar(255) DEFAULT NULL,
  `xt_p_id` int(10) DEFAULT '0' COMMENT '父级id',
  `xt_idss` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`xt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_xiangmu_type','xt_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD 
  `xt_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_xiangmu_type','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD   `uniacid` int(10) NOT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu_type','xt_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD   `xt_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu_type','xt_ids')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD   `xt_ids` varchar(50) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu_type','xt_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD   `xt_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_xiangmu_type','xt_p_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD   `xt_p_id` int(10) DEFAULT '0' COMMENT '父级id'");}
if(!pdo_fieldexists('hyb_o2o_xiangmu_type','xt_idss')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_xiangmu_type')." ADD   `xt_idss` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_yjtixian` (
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

");

if(!pdo_fieldexists('hyb_o2o_yjtixian','yj_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD 
  `yj_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','yj_num')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `yj_num` varchar(255) DEFAULT NULL COMMENT '佣金提现订单号'");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','yj_yongjin')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `yj_yongjin` varchar(255) DEFAULT NULL COMMENT '提现佣金数'");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','yj_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `yj_money` varchar(255) DEFAULT NULL COMMENT '提现金额'");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','yj_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `yj_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yjtixian','yj_statue')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yjtixian')." ADD   `yj_statue` int(10) DEFAULT '0' COMMENT '0-失败   1-成功'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_youhuiquan` (
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

");

if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD 
  `y_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `y_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `y_money` float(10,2) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_shuoming')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `y_shuoming` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_yaoqiu')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `y_yaoqiu` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_starttime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `y_starttime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','y_endtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `y_endtime` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_youhuiquan','shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_youhuiquan')." ADD   `shangjia` int(10) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_yuangong` (
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

");

if(!pdo_fieldexists('hyb_o2o_yuangong','y_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD 
  `y_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_yuangong','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_name')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_name` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_openid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_openid` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_thumb')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_thumb` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_sex')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_sex` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_age')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_age` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_telphone')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_telphone` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_sjname')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_sjname` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_imgpath1')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_imgpath1` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_imgpath2')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_imgpath2` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_jineng')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_jineng` longtext");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_fwqy')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_fwqy` longtext");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_jdnum')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_jdnum` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_styles')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_styles` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_typs')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_typs` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_jin')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_jin` int(10) DEFAULT '0' COMMENT '1为禁止'");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_time')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_time` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_money')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_money` varchar(255) DEFAULT '0'");}
if(!pdo_fieldexists('hyb_o2o_yuangong','form_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `form_id` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_rz')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_rz` int(10) DEFAULT '0' COMMENT '0代表员工1代表技师'");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_choucheng')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_choucheng` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_zgeimg')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_zgeimg` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_yuangong','y_endtime')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_yuangong')." ADD   `y_endtime` varchar(255) DEFAULT NULL");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_zhanghao` (
  `z_id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `zhanghao` varchar(255) DEFAULT NULL,
  `mima` varchar(255) DEFAULT NULL,
  `z_shangjia` varchar(255) DEFAULT NULL,
  `status` int(10) DEFAULT '1',
  PRIMARY KEY (`z_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_zhanghao','z_id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhanghao')." ADD 
  `z_id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_zhanghao','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhanghao')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_zhanghao','zhanghao')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhanghao')." ADD   `zhanghao` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_zhanghao','mima')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhanghao')." ADD   `mima` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_zhanghao','z_shangjia')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhanghao')." ADD   `z_shangjia` varchar(255) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_zhanghao','status')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhanghao')." ADD   `status` int(10) DEFAULT '1'");}
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hyb_o2o_zhengshu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT NULL,
  `apiclient_cert` longtext,
  `apiclient_key` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

");

if(!pdo_fieldexists('hyb_o2o_zhengshu','id')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhengshu')." ADD 
  `id` int(10) NOT NULL AUTO_INCREMENT");}
if(!pdo_fieldexists('hyb_o2o_zhengshu','uniacid')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhengshu')." ADD   `uniacid` int(10) DEFAULT NULL");}
if(!pdo_fieldexists('hyb_o2o_zhengshu','apiclient_cert')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhengshu')." ADD   `apiclient_cert` longtext");}
if(!pdo_fieldexists('hyb_o2o_zhengshu','apiclient_key')) {pdo_query("ALTER TABLE ".tablename('hyb_o2o_zhengshu')." ADD   `apiclient_key` longtext");}
