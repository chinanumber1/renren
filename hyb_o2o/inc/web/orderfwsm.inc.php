<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
//查询平台商家
$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
if ($op == "display") {
	$ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务"));
	//微信支付
	$wxfw = pdo_fetchall("SELECT sum(o_count_money) as money  FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>"微信支付",":o_xiangmu_xingshi"=>"上门服务"));
	if (empty($wxfw[0]['money'])) {
		$wxfw[0]['money']="0";
	}
	//余额支付
	$yefw = pdo_fetchall("SELECT sum(o_count_money) as money  FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>"余额支付",":o_xiangmu_xingshi"=>"上门服务"));
	if (empty($yefw[0]['money'])) {
		$yefw[0]['money']="0";
	}
	//现金支付
	$xjfw = pdo_fetchall("SELECT sum(o_count_money) as money  FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>"现金支付",":o_xiangmu_xingshi"=>"上门服务"));
	if (empty($xjfw[0]['money'])) {
		$xjfw[0]['money']="0";
	}
	$ordermoney = $wxfw[0]['money']+$yefw[0]['money']+$xjfw[0]['money'];



	$paytype = $_GPC['paytype'];
	$paytypes = $_GPC['paytypes'];
	$type = $_GPC['type'];
	$keyword  = $_GPC['keyword'];
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	if (empty($paytype) && empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务"));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务"));
	}
	if (!empty($paytype) && empty($paytypes) && empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype));
	}
	if (!empty($paytype) && !empty($paytypes) && empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
	}
	if (!empty($paytype) && !empty($paytypes) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
	}
	if (!empty($paytype) && !empty($paytypes) && empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
	}
	if (!empty($paytype) && !empty($paytypes) && !empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%'  order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
	}
	if (!empty($paytype) && empty($paytypes) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_type"=>$type));
	}
	if (!empty($paytype) && empty($paytypes) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype,":o_type"=>$type));
	}
	if (!empty($paytype) && empty($paytypes) && empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_type=:o_pay_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_type"=>$paytype));
	}
	if (empty($paytype) && !empty($paytypes) && empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes));
	}
	if (empty($paytype) && !empty($paytypes) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes,":o_type"=>$type));
	}
	if (empty($paytype) && !empty($paytypes) && empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes));
	}
	if (empty($paytype) && !empty($paytypes) && !empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_pay_typess"=>$paytypes,":o_type"=>$type));
	}
	if (empty($paytype) && empty($paytypes) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_type"=>$type));
	}
	if (empty($paytype) && empty($paytypes) && !empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_type"=>$type));
	}
	if (empty($paytype) && empty($paytypes) && empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务"));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>"上门服务"));
	}
	
	foreach ($products as &$value) {
		//查询项目
		$xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$value['o_xid']));
		if (strpos($xiangmu['x_thumb'],"http")===false) {
			$value['x_thumb'] = $_W['attachurl'].$xiangmu['x_thumb'];
		}else{
			$value['x_thumb'] = $xiangmu['x_thumb'];
		}
		$value['x_name'] = $xiangmu['x_name'];
	}
	
	
	$pager = pagination($count, $pindex, $psize);

}

if ($op == "post") {
	$o_id = $_GPC['o_id'];
	$info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
	//查询项目
	$xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$info['o_xid']));
	if (empty($info['o_xiangmu_guigemoney'])) {
		$info['o_xiangmu_guigemoney'] = "无";
		$info['money'] = $xiangmu['x_jiage'];
	}else{
		$info['money'] = $info['o_xiangmu_guigemoney'];
	}
	if (strpos($xiangmu['x_thumb'],"http")===false) {
		$info['x_thumb'] = $_W['attachurl'].$xiangmu['x_thumb'];
	}else{
		$info['x_thumb'] = $xiangmu['x_thumb'];
	}
	$info['x_name'] = $xiangmu['x_name'];
}
if ($op == "delete") {
	$o_id = $_GPC['o_id'];
	pdo_delete("hyb_o2o_orderfuwu",array("o_id"=>$o_id));
	message("删除成功!",$this->createweburl("orderfwsm",array("op"=>"display")),"success");
}

include $this->template('web/orderfwsm');