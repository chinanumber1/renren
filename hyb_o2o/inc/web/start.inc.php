<?php

global $_GPC, $_W;
$action = 'start';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);


//查询商家信息
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$storeid));

/*今日商家销售总额*/
$timenew = date("Y-m-d",time());
//微信支付
$wxfuwu = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timenew%' and o_store=:o_store",array(":uniacid"=>$uniacid,":o_pay_typess"=>"微信支付",":o_store"=>$storeid));

if ($wxfuwu[0]['money']=="null") {
	$wxfuwu[0]['money']="0";
}
$wxtotal = $wxfuwu[0]['money'];
//余额支付
$yefuwu = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timenew%' and o_store=:o_store",array(":uniacid"=>$uniacid,":o_pay_typess"=>"余额支付",":o_store"=>$storeid));

if ($yefuwu[0]['money']=="null") {
	$yefuwu[0]['money']="0";
}
$yuetotal = $yefuwu[0]['money'];
//现金支付
$xjfuwu = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timenew%' and o_store=:o_store",array(":uniacid"=>$uniacid,":o_pay_typess"=>"现金支付",":o_store"=>$storeid));
if ($xjfuwu[0]['money']=='null') {
	$xjfuwu[0]['money']="0";
}
$xjtotal = $xjfuwu[0]['money'];
$newtimetotal  = $wxtotal+$yuetotal+$xjtotal;


/*今日商家已完成订单*/
$newpd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_time like '%$timenew%' and q_styles in ('已完成','已删除') and q_openid=:q_openid",array(":uniacid"=>$uniacid,":q_openid"=>$shangjia['s_u_openid']));
$newsm = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timenew%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_store=:o_store",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"上门服务",":o_store"=>$storeid));
$newdd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timenew%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_store=:o_store",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"到店服务",":o_store"=>$storeid));
$newtotal = $newpd+$newsm+$newdd;

/*今日新增员工*/
$newyg = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_time like '%$timenew%'",array(":uniacid"=>$uniacid,":y_sjname"=>$storeid));


/*昨日商家总收入*/

//微信支付
$timeold = date("Y-m-d",strtotime("-1 day"));
$wxfuwu2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timeold%' and o_store=:o_store",array(":uniacid"=>$uniacid,":o_pay_typess"=>"微信支付",":o_store"=>$storeid));
if ($wxfuwu2[0]['money']=="null") {
	$wxfuwu2[0]['money']="0";
}
$wxtotal2 = $wxfuwu2[0]['money'];

//余额支付
$yefuwu2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime and o_xdtime like '%$timeold%' and o_store=:o_store",array(":uniacid"=>$uniacid,":o_pay_typess"=>"余额支付",":o_store"=>$storeid));
if ($yefuwu2[0]['money']=="null") {
	$yefuwu2[0]['money']="0";
}
$yuetotal2 = $yefuwu2[0]['money'];

//现金支付
$xjfuwu2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timeold%' and o_store=:o_store",array(":uniacid"=>$uniacid,":o_pay_typess"=>"现金支付",":o_store"=>$storeid));
if ($xjfuwu2[0]['money']=='null') {
	$xjfuwu2[0]['money']="0";
}
$xjtotal2 = $xjfuwu[0]['money'];
$oldtimetotal  =$wxtotal2+$yuetotal2+$xjtotal2;


//昨日已完成订单
$oldpd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_time like '%$timeold%' and q_styles in ('已完成','已删除') and q_openid=:q_openid",array(":uniacid"=>$uniacid,":q_openid"=>$shangjia['s_u_openid']));
$oldsm = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timeold%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_store=:o_store",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"上门服务",":o_store"=>$storeid));
$olddd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timeold%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_store=:o_store",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"到店服务",":o_store"=>$storeid));

//昨日新增员工
$oldyg = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_time like '%$timeold%'",array(":uniacid"=>$uniacid,":y_sjname"=>$storeid));

$oldtotal = $oldpd+$oldsm+$olddd;

/*退款信息*/
$jrtk = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type=:o_type and o_store=:o_store and o_xdtime like '%$timenew%'",array(":uniacid"=>$uniacid,":o_store"=>$storeid,":o_type"=>"已退款"));
$zrtk = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type=:o_type and o_store=:o_store and o_xdtime like '%$timeold%'",array(":uniacid"=>$uniacid,":o_store"=>$storeid,":o_type"=>"已退款"));
$timeby = date("Y-m-d ",time());
$bytk = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type=:o_type and o_store=:o_store and o_xdtime like '%$timeby%'",array(":uniacid"=>$uniacid,":o_store"=>$storeid,":o_type"=>"已退款"));
$tktotal = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type=:o_type and o_store=:o_store ",array(":uniacid"=>$uniacid,":o_store"=>$storeid,":o_type"=>"已退款"));

/*提现申请*/
$dtx = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and statue=:statue and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"待提现",":s_id"=>$storeid));
$ytx = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and statue=:statue and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"已提现",":s_id"=>$storeid));


/*订单*/
$yxdd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type in('已完成','已删除') and o_store=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$storeid));


$wxdd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type in('已取消','已退款') and o_store=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$storeid));


include $this->template('web/dlindex');
