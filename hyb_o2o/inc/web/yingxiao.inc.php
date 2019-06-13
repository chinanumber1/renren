<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
if ($op == "display") {	
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
}
if ($op == "post") {
	$m_id = $_GPC['m_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and m_id=:m_id",array(":uniacid"=>$uniacid,":m_id"=>$m_id));
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"m_money"=>$_GPC['m_money'],"j_money"=>$_GPC['j_money'],"shangjia"=>$shangjia['s_id']);
		if (empty($m_id)) {
			pdo_insert("hyb_o2o_manjian",$data);
			message("添加成功!",$this->CreateWebUrl("yingxiao",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_manjian",$data,array("m_id"=>$m_id));
			message("修改成功!",$this->CreateWebUrl("yingxiao",array("op"=>"display")),"success");
		}
	}
}
if ($op == "delete") {
	$m_id = $_GPC['m_id'];
	pdo_delete("hyb_o2o_manjian",array("m_id"=>$m_id));
	message("删除成功!",$this->CreateWebUrl("yingxiao",array("op"=>'display')),"success");
}
include $this->template("web/yingxiao");
?>