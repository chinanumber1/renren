<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
if ($op == "display") {
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
}
if ($op == "post") {
	$h_id = $_GPC['h_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid and h_id=:h_id",array(":uniacid"=>$uniacid,":h_id"=>$h_id));
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"h_name"=>$_GPC['h_name'],"h_thumb"=>$_GPC['h_thumb'],"h_zhekou"=>$_GPC['h_zhekou'],"h_money"=>$_GPC['h_money'],"h_song"=>$_GPC['h_song'],"h_time"=>$_GPC['h_time']);
		if (empty($h_id)) {
			 pdo_insert("hyb_o2o_huiyuan",$data);
			 message("添加成功!",$this->createweburl("usertype",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_huiyuan",$data,array("h_id"=>$h_id));
			message("修改成功!",$this->createweburl("usertype",array("op"=>"display")),"success");
		}
	}
}
if ($op == "delete") {
	$h_id = $_GPC['h_id'];
	pdo_delete("hyb_o2o_huiyuan",array("h_id"=>$h_id));
	message("删除成功!",$this->createweburl("usertype",array("op"=>"display")),"success");
}
include $this->template('web/usertype');