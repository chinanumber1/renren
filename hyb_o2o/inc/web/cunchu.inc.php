<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
if ($op == "display") {
	$remote = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_cunchu")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	if (checksubmit("submit")) {
		$data = array(
			"uniacid"=>$uniacid,
			"alioss_key"=>$_GPC['alioss_key'],
			"alioss_secret"=>$_GPC['alioss_secret'],
			"alioss_bucket"=>substr($_GPC['alioss_bucket'],0,strpos($_GPC['alioss_bucket'],'@')),
			"alioss_url"=>$_GPC['alioss_url'],
			"alioss_ossurl"=>strstr($_GPC['alioss_url'],"oss"),
			"qiniu_accesskey"=>$_GPC['qiniu_accesskey'],
			"qiniu_secretkey"=>$_GPC['qiniu_secretkey'],
			"qiniu_bucket"=>$_GPC['qiniu_bucket'],
			"qiniu_url"=>$_GPC['qiniu_url'],
			"type"=>$_GPC['type'],
		);
		if (empty($remote)) {
			pdo_insert("hyb_o2o_cunchu",$data);
			message("添加成功!",$this->createWebUrl("cunchu",array("op"=>"display")),"success");
		}
		else
		{
			pdo_update("hyb_o2o_cunchu",$data,array("id"=>$remote['id']));
			message("修改成功!",$this->createWebUrl("cunchu",array("op"=>"display")),"success");
		}
	}
}
include $this->template('web/cunchu');