<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
if ($op == "display") {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0 order by xt_ids desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
	$pager = pagination($count, $pindex, $psize);
}
if($op == "post"){
	$xt_id = $_GPC['xt_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$xt_id));
	$typs = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xt_id));

	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"xt_name"=>$_GPC['xt_name'],"xt_thumb"=>$_GPC['xt_thumb'],"xt_ids"=>$_GPC['xt_ids'],"xt_parentid"=>"0","xt_tuijian"=>$_GPC['xt_tuijian'],"xt_tuijian_fabu"=>$_GPC['xt_tuijian_fabu'],"choushui"=>$_GPC['choushui'],"xt_tzej"=>$_GPC['xt_tzej']);
		if (empty($xt_id)) {
			pdo_insert("hyb_o2o_fuwu_type",$data);
			message("添加成功!",$this->createWebUrl("fuwutype",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_fuwu_type",$data,array("xt_id"=>$xt_id));
			message("修改成功!",$this->createWebUrl("fuwutype",array("op"=>"display")),"success");
		}
	}
}
if ($op == "displays") {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0 order by xt_ids desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
	foreach ($products as $key => $value) {
		$products[$key]['parent'] = pdo_fetch("SELECT xt_name FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$value['xt_parentid']));
	}
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	$pager = pagination($count, $pindex, $psize);
}
if ($op == "posts") {
	$xt_id = $_GPC['xt_id'];
	//查询父级分类
	$fuji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$xt_id)); 
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"xt_ids"=>$_GPC['xt_ids'],"xt_name"=>$_GPC['xt_name'],"xt_thumb"=>$_GPC['xt_thumb'],"xt_parentid"=>$_GPC['xt_parentid'],"xt_reference_price"=>$_GPC['xt_reference_price'],"xt_smreference_price"=>$_GPC['xt_smreference_price']);
		if (empty($xt_id)) {
			pdo_insert("hyb_o2o_fuwu_type",$data);
			message("添加成功!",$this->createWebUrl("fuwutype",array("op"=>"displays")),"success");
		}else{
			pdo_update("hyb_o2o_fuwu_type",$data,array("xt_id"=>$xt_id));
			message("修改成功!",$this->createWebUrl("fuwutype",array("op"=>"displays")),"success");
		}
	}
}
if ($op == "delete") {
	$id = $_GPC['xt_id'];
	$typs = $_GPC['typs'];
	pdo_delete("hyb_o2o_fuwu_type",array("xt_id"=>$id));
	if ($typs=="yiji") {
		message("删除成功!",$this->createWebUrl("fuwutype",array("op"=>"display")),"success");
	}else{
		message("删除成功!",$this->createWebUrl("fuwutype",array("op"=>"displays")),"success");
	}
	
}
include $this->template('web/fuwutype');