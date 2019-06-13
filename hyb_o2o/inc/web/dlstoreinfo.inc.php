<?php
global $_GPC, $_W;
$action = 'dlstoreinfo';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);
//查询商家分类
$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$storeid));
if (!empty($items)) {
	$items['s_imgpath'] = unserialize($items['s_imgpath']);
	$items['s_yingyetime'] = explode("-",$items['s_yingyetime']);
	$items['baozhang'] = unserialize($items['baozhang']);
	$items['label'] = unserialize($items['label']);
	$label = implode("|",$items['label']);
	$items['s_address'] = explode("-",$items['s_address']);
	if ($items['s_address'][0]=="北京市" || $items['s_address'][0]=="天津市" || $items['s_address'][0]=="上海市" || $items['s_address'][0]=="重庆市") {
		$items['s_address'][0] = substr($items['s_address'][0],0,strrpos($items['s_address'][0],'市'));
	}
	$s_address = array("province"=>$items['s_address'][0],"city"=>$items['s_address'][1],"district"=>$items['s_address'][2]);
}
if (checksubmit("submit")) {
	if ($_GPC['s_address']['province']=='北京' || $_GPC['s_address']['province']=='天津' || $_GPC['s_address']['province']=='上海' || $_GPC['s_address']['province']=='重庆') {
		$_GPC['s_address']['province'] = $_GPC['s_address']['province']."市";
	}
	$s_address = $_GPC['s_address']['province']."-".$_GPC['s_address']['city']."-".$_GPC['s_address']['district'];
	$s_yingyetime = $_GPC['time']."-".$_GPC['time2'];
	$baozhang = serialize($_GPC['baozhang']);
	$jw = $_GPC['jw'];
	$jws = explode(",",$jw);
	$label = explode("|",$_GPC['label']);
	$label = serialize($label);
	$data = array("uniacid"=>$uniacid,"s_name"=>$_GPC['s_name'],"s_u_name"=>$_GPC['s_u_name'],"s_telphone"=>$_GPC['s_telphone'],"s_content"=>$_GPC['content'],"s_type"=>$_GPC['s_type'],"s_yingyetime"=>$s_yingyetime,"s_thumb"=>$_GPC['s_thumb'],"s_imgpath"=>serialize($_GPC['s_imgpath']),"s_zhizhao"=>$_GPC['s_zhizhao'],"s_status"=>"待审核","baozhang"=>$baozhang,"s_address"=>$s_address,"s_xxaddress"=>$_GPC['s_xxaddress'],"wei"=>$jws['0'],"jing"=>$jws['1'],"s_idcard"=>$_GPC['s_idcard'],"s_idcard2"=>$_GPC['s_idcard2'],'label'=>$label);
	pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$storeid));
	//查询用户信息
	$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$items['s_u_openid']));
	pdo_update("hyb_o2o_userinfo",array("u_shangjia"=>"待审核"),array("u_id"=>$user['u_id']));
	message('修改成功请等待平台审核！',$this->createWebUrl2("dlstoreinfo",array('id' => $storeid,"uid"=>$uniacid)), 'success');
}
include $this->template('web/dlstoreinfo');