<?php
global $_GPC, $_W;
$action = 'dlyingxiao';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$storeid));
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
			message("添加成功!",$this->CreateWebUrl2("dlyingxiao",array("op"=>"display",'id'=>$storeid,'uid'=>$uniacid)),"success");
		}else{
			pdo_update("hyb_o2o_manjian",$data,array("m_id"=>$m_id));
			message("修改成功!",$this->CreateWebUrl2("dlyingxiao",array("op"=>"display",'id'=>$storeid,'uid'=>$uniacid)),"success");
		}
	}
}
if ($op == "delete") {
	$m_id = $_GPC['m_id'];
	pdo_delete("hyb_o2o_manjian",array("m_id"=>$m_id));
	message("删除成功!",$this->CreateWebUrl2("dlyingxiao",array("op"=>'display','id'=>$storeid,"uid"=>$uniacid)),"success");
}
include $this->template("web/dlyingxiao");