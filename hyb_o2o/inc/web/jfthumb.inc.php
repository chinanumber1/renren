<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
if ($op == "display") {
	$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jfthumb")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
}
if ($op == "post") {
	$id = $_GPC['id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jfthumb")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"thumb"=>$_GPC['thumb'],"appid"=>$_GPC['appid'],"path"=>$_GPC['path']);
		if (empty($id)) {
			pdo_insert("hyb_o2o_jfthumb",$data);
			message("添加成功!",$this->CreateWebUrl("jfthumb",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_jfthumb",$data,array("id"=>$id));
			message("修改成功!",$this->CreateWebUrl("jfthumb",array("op"=>"display")),"success");
		}
	}
}
if ($op == "delete") {
	$id = $_GPC['id'];
	pdo_delete("hyb_o2o_jfthumb",array("id"=>$id));
	message("删除成功!",$this->CreateWebUrl("jfthumb",array("op"=>"display")),"success");
}
include $this->template("web/jfthumb");
?>