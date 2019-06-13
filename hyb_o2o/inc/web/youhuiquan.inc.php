<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
if ($op == "display") {
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
}
if ($op == "post") {
	$y_id = $_GPC['y_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"y_name"=>$_GPC['y_name'],"y_money"=>$_GPC['y_money'],"y_shuoming"=>$_GPC['y_shuoming'],"y_yaoqiu"=>$_GPC['y_yaoqiu'],"y_starttime"=>$_GPC['time']['start'],"y_endtime"=>$_GPC['time']['end'],"shangjia"=>$shangjia['s_id']);
		if (empty($y_id)) {
			pdo_insert("hyb_o2o_youhuiquan",$data);
			message("添加成功!",$this->CreateWebUrl("youhuiquan",array("op"=>'display')),"success");
		}else{
			pdo_update("hyb_o2o_youhuiquan",$data,array("y_id"=>$y_id));
			message("修改成功!",$this->CreateWebUrl("youhuiquan",array("op"=>'display')),"success");
		}
	}
}
if ($op == "delete") {
	$y_id = $_GPC['y_id'];
	pdo_delete("hyb_o2o_youhuiquan",array("y_id"=>$y_id));
	message("删除成功!",$this->CreateWebUrl("youhuiquan",array("op"=>"display")),"success");
}
include $this->template("web/youhuiquan");
?>