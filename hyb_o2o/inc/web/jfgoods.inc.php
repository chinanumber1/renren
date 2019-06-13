<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
if ($op == "display") {
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid));
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	$pager = pagination($count, $pageindex, $pagesize);	
}
if ($op == "post") {
	$id = $_GPC['id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
	$items['thumbs'] = unserialize($items['thumbs']);
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"name"=>$_GPC['name'],"thumb"=>$_GPC['thumb'],"thumbs"=>serialize($_GPC['thumbs']),"content"=>$_GPC['content'],"num"=>$_GPC['num'],"status"=>$_GPC['status']);
		if (empty($id)) {
			pdo_insert("hyb_o2o_jfgoods",$data);
			message("添加成功!",$this->CreateWebUrl("jfgoods",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_jfgoods",$data,array("id"=>$id));
			message("修改成功!",$this->CreateWebUrl("jfgoods",array("op"=>"display")),"success");
		}
	}
}
if ($op == "save") {
	$id = $_GPC['id'];
	$status = $_GPC['status'];
	if ($status=="1") {
		$data = array("status"=>"0");
	}else{
		$data = array("status"=>"1");
	}
	pdo_update("hyb_o2o_jfgoods",$data,array("id"=>$id));
	message("修改成功!",$this->CreateWebUrl("jfgoods",array("op"=>"display")),"success");
}
if ($op == "delete") {
	$id = $_GPC['id'];
	pdo_delete("hyb_o2o_jfgoods",array("id"=>$id));
	message("删除成功!",$this->CreateWebUrl("jfgoods",array("op"=>"display")),"success");
}
include $this->template('web/jfgoods');