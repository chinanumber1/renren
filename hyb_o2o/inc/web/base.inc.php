<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$item = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
if (!empty($item)) {
	$item['thumb'] = unserialize($item['thumb']);
}

if (checksubmit("submit")) {
	$data = array("uniacid"=>$uniacid,"name"=>$_GPC['name'],"thumb"=>serialize($_GPC['thumb']),"city_type"=>$_GPC['city_type'],"banquan"=>$_GPC['banquan'],"baidukey"=>$_GPC['baidukey'],"sm_money"=>$_GPC['sm_money'],"gaodexcxkey"=>$_GPC['gaodexcxkey'],"gaodekey"=>$_GPC['gaodekey'],"xieyi"=>$_GPC['xieyi'],"pt_show"=>$_GPC['pt_show'],"s_ttthumb"=>$_GPC['s_ttthumb'],"qjcolor"=>$_GPC['qjcolor'],"qjbcolor"=>$_GPC['qjbcolor'],"fdsh_type"=>$_GPC['fdsh_type'],"bcolor"=>$_GPC['bcolor']);
	if (empty($item)) {
		pdo_insert("hyb_o2o_base",$data);
		message("添加成功!",$this->createWebUrl("base"),"success");
	}else{
		pdo_update("hyb_o2o_base",$data,array("id"=>$item['id']));
		message("修改成功!",$this->createWebUrl("base"),"success");
	}
}
include $this->template('web/base');