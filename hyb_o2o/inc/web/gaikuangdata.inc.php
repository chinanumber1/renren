<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];

/*今日平台销售总额*/
$timenew = date("Y-m-d",time());

//微信支付
$wxgoods = pdo_fetchall("SELECT sum(o_count_money) as money  FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and o_xdtime like '%$timenew%' ",array(":uniacid"=>$uniacid,":o_pay_type"=>"微信"));
$wxfuwu = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timenew%' ",array(":uniacid"=>$uniacid,":o_pay_typess"=>"微信支付"));
if ($wxgoods[0]['money']=="null") {
	$wxgoods[0]['money']="0";
}
if ($wxfuwu[0]['money']=="null") {
	$wxfuwu[0]['money']="0";
}
$wxtotal =$wxgoods[0]['money']+$wxfuwu[0]['money'];
//余额支付
$yegoods = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and o_xdtime like '%$timenew%' ",array(":uniacid"=>$uniacid,":o_pay_type"=>"余额"));
$yefuwu = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime and o_xdtime like '%$timenew%' ",array(":uniacid"=>$uniacid,":o_pay_typess"=>"余额支付"));
if ($yegoods[0]['money']=="null") {
	$yegoods[0]['money']="0";
}
if ($yefuwu[0]['money']=="null") {
	$yefuwu[0]['money']="0";
}
$yuetotal = $yegoods[0]['money']+$yefuwu[0]['money'];
//现金支付
$xjfuwu = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timenew%'",array(":uniacid"=>$uniacid,":o_pay_typess"=>"现金支付"));
if ($xjfuwu[0]['money']=='null') {
	$xjfuwu[0]['money']="0";
}
$xjtotal = $xjfuwu[0]['money'];
$newtimetotal  =$wxtotal+$yuetotal+$xjtotal;


//今日已完成订单
$newsp = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_xdtime like '%$timenew%' and o_type in ('已完成','已删除')",array(":uniacid"=>$uniacid));
$newsm = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timenew%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"上门服务"));
$newdd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timenew%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"到店服务"));
$newjf = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and time like '%$timenew%' and type in ('已完成','已删除')",array(":uniacid"=>$uniacid));


//今日新增商户
$newsh = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_time like '%$timenew%'",array(":uniacid"=>$uniacid));

//今日新增派单
$newpd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_time like '%$timenew%'",array(":uniacid"=>$uniacid));

$newtotal = $newsp+$newsm+$newdd+$newjf;


/*昨日平台总收入*/

//微信支付
$timeold = date("Y-m-d",strtotime("-1 day"));
$wxgoods2 = pdo_fetchall("SELECT sum(o_count_money) as money  FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and o_xdtime like '%$timeold%' ",array(":uniacid"=>$uniacid,":o_pay_type"=>"微信"));
$wxfuwu2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timeold%' ",array(":uniacid"=>$uniacid,":o_pay_typess"=>"微信支付"));
if ($wxgoods2[0]['money']=="null") {
	$wxgoods2[0]['money']="0";
}
if ($wxfuwu2[0]['money']=="null") {
	$wxfuwu2[0]['money']="0";
}
$wxtotal2 =$wxgoods2[0]['money']+$wxfuwu2[0]['money'];
//余额支付
$yegoods2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and o_xdtime like '%$timeold%' ",array(":uniacid"=>$uniacid,":o_pay_type"=>"余额"));
$yefuwu2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime and o_xdtime like '%$timeold%' ",array(":uniacid"=>$uniacid,":o_pay_typess"=>"余额支付"));
if ($yegoods2[0]['money']=="null") {
	$yegoods2[0]['money']="0";
}
if ($yefuwu2[0]['money']=="null") {
	$yefuwu2[0]['money']="0";
}
$yuetotal2 = $yegoods2[0]['money']+$yefuwu2[0]['money'];
//现金支付
$xjfuwu2 = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_pay_typess=:o_pay_typess and o_xdtime like '%$timeold%'",array(":uniacid"=>$uniacid,":o_pay_typess"=>"现金支付"));
if ($xjfuwu2[0]['money']=='null') {
	$xjfuwu2[0]['money']="0";
}
$xjtotal2 = $xjfuwu[0]['money'];
$oldtimetotal  =$wxtotal2+$yuetotal2+$xjtotal2;


//昨日已完成订单
$oldsp = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_xdtime like '%$timeold%' and o_type in ('已完成','已删除')",array(":uniacid"=>$uniacid));
$oldsm = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timeold%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"上门服务"));
$olddd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_xdtime like '%$timeold%' and o_type in ('已完成','已删除') and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_xiangmu_xingshi"=>"到店服务"));
$oldjf = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and time like '%$timeold%' and type in ('已完成','已删除')",array(":uniacid"=>$uniacid));


//昨日新增商户
$oldsh = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_time like '%$timeold%'",array(":uniacid"=>$uniacid));

//昨日新增派单
$oldpd = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_time like '%$timeold%'",array(":uniacid"=>$uniacid));

$oldtotal = $oldsp+$oldsm+$olddd+$oldjf;




/*会员信息*/
// 今日新增
$jrhy = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userchongzhi")." WHERE uniacid=:uniacid and time like like '%$timenew%'",array(":uniacid"=>$uniacid));
//昨日新增
$zrhy = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userchongzhi")." WHERE uniacid=:uniacid and time like like '%$timeold%'",array(":uniacid"=>$uniacid));
//本月新增
$timeby = date("Y-m-d ",time());
$byhy =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userchongzhi")." WHERE uniacid=:uniacid and time like like '%$timeby%'",array(":uniacid"=>$uniacid));
//会员总数
$hytotal = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and u_type!=0",array(":uniacid"=>$uniacid));


/*提现申请*/
$dtx = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and statue=:statue",array(":uniacid"=>$uniacid,":statue"=>"待提现"));
$ytx = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and statue=:statue",array(":uniacid"=>$uniacid,":statue"=>"已提现"));


/*订单*/
$yxfw = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type in('已完成','已删除')",array(":uniacid"=>$uniacid));
$yxsp = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." WHERE uniacid=:uniacid and o_type='已完成'",array(":uniacid"=>$uniacid));
$yxjf = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." WHERE uniacid=:uniacid and type in('已完成','已删除')",array(":uniacid"=>$uniacid));
$yxdd = $yxfw+$yxsp+$yxjf;

$wxfw = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_type in('已取消','已退款')",array(":uniacid"=>$uniacid));
$wxsp = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." WHERE uniacid=:uniacid and o_type='已取消'",array(":uniacid"=>$uniacid));
$wxjf = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." WHERE uniacid=:uniacid and type='已取消'",array(":uniacid"=>$uniacid));
$wxdd = $wxfw+$wxsp+$wxjf;


include $this->template('web/gaikuangdata');