<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$item = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
if (checksubmit("submit")) {
	$data = array("uniacid"=>$uniacid,"accessKeyId"=>$_GPC['accessKeyId'],"accessKeySecret"=>$_GPC['accessKeySecret'],"SignName"=>$_GPC['SignName'],"shtz"=>$_GPC['shtz'],"pdtzyh"=>$_GPC['pdtzyh'],"pdtzyg"=>$_GPC['pdtzyg'],"fdtz"=>$_GPC['fdtz'],"fdtzyh"=>$_GPC['fdtzyh'],"fdtzyg"=>$_GPC['fdtzyg'],"rztz"=>$_GPC['rztz'],"sjrztz"=>$_GPC['sjrztz'],"ddtzsjkf"=>$_GPC['ddtzsjkf'],"ddtzsjwc"=>$_GPC['ddtzsjwc'],"fdtzsh"=>$_GPC['fdtzsh'],"qdtzyh"=>$_GPC['qdtzyh'],"fdtzfwk"=>$_GPC['fdtzfwk'],"fdtzfww"=>$_GPC['fdtzfww'],"ddtzzf"=>$_GPC['ddtzzf'],"ddtzzfq"=>$_GPC['ddtzzfq'],"baojia"=>$_GPC['baojia'],"yzm"=>$_GPC['yzm'],"tybaojia"=>$_GPC['tybaojia'],"btybaojia"=>$_GPC['btybaojia'],'xdtzyg'=>$_GPC['xdtzyg']);
	if (empty($item)) {
		pdo_insert("hyb_o2o_news",$data);
		message("添加成功!",$this->CreateWebUrl("new",array()),"success");
	}else{
		pdo_update("hyb_o2o_news",$data,array("id"=>$item['id']));
		message("修改成功!",$this->CreateWebUrl("new",array()),"success");
	}
}
include $this->template("web/new");
?>