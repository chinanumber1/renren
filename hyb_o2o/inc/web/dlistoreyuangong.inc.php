<?php
global $_GPC, $_W;
$action = 'dlistoreyuangong';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$storeid)); 
if ($op == "display") {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	if (empty($keywords)) {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":y_sjname"=>$storeid));
		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_sjname"=>$storeid));
	}else{
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":y_sjname"=>$storeid));
		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%'",array(":uniacid"=>$uniacid,":y_sjname"=>$storeid));
	}

	if (!empty($_GPC['deleteall'])) {
		for($i=0;$i<count($_GPC['deleteall']);$i++)
		{
			pdo_delete('hyb_o2o_yuangong', array('y_id' =>$_GPC['deleteall'][$i]));
		}
		message("删除成功!",$this->createWebUrl2("dlistoreyuangong",array('op' => 'display', 'id' => $storeid,"uid"=>$uniacid)),"success");
	}
	$pager = pagination($total, $pindex, $psize);

}
if ($op == "post") {	
	$y_id = $_GPC['y_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
		//查询全部openid
	$openid = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	
	foreach ($openid as &$value) {
		$value['u_name'] = json_decode($value['u_name']);
	}
	//查询全部服务分类
	$fwtype = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	foreach ($fwtype as &$value) {
		$fwtypes[]= $value['xt_name'];
	}
	$fwtypess=implode(",", $fwtypes);
	$items['y_jineng'] = unserialize($items['y_jineng']);
	if ($items['y_jineng'][0]!="null") {
		$items['y_jineng'] = implode(",", $items['y_jineng']);
	}else{
		$items['y_jineng'] = [];
	}
	$items['y_fwqy'] = unserialize($items['y_fwqy']);
	if ($items['y_fwqy'][0]!="null") {
		$items['y_fwqy'] = implode(",", $items['y_fwqy']);
	}else{
		$items['y_fwqy'] = "";
	}
	$sjaddress = explode("-",$shangjia['s_address']);
	$duqu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$sjaddress[1]));

	$diqu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=:parentid",array(":uniacid"=>$uniacid,":parentid"=>$duqu['id']));
	foreach ($diqu as &$value) {
		$diqus[]= $value['name'];
	}
	$diquss=implode(",", $diqus);
	if (checksubmit("submit")) {
		$y_jineng = explode(",",$_GPC['y_jineng']);
		$y_jineng = serialize($y_jineng);
		$y_fwqy = explode(",",$_GPC['y_fwqy']);
		$y_fwqy = serialize($y_fwqy);
		$data = array("uniacid"=>$uniacid,"y_name"=>$_GPC['y_name'],"y_telphone"=>$_GPC['y_telphone'],"y_sex"=>$_GPC['y_sex'],"y_age"=>$_GPC['y_age'],"y_thumb"=>$_GPC['y_thumb'],"y_typs"=>$_GPC['y_typs'],"y_time"=>date("Y-m-d H:i:s",time()),"y_sjname"=>$storeid,"y_jineng"=>$y_jineng,"y_fwqy"=>$y_fwqy,"y_choucheng"=>$_GPC['y_choucheng']);
		if (empty($y_id)) {
			pdo_insert("hyb_o2o_yuangong",$data);
			//查询用户
			$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$_GPC['y_openid']));
			pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>$storeid),array("u_id"=>$user['u_id']));
			message("添加成功!",$this->createWebUrl2("dlistoreyuangong",array("op"=>"display","id"=>$storeid,"uid"=>$uniacid)),"success");
		}else{
			pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$y_id));
			//查询用户
			$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$items['y_openid']));
			pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>$storeid),array("u_id"=>$user['u_id']));
			message("修改成功!",$this->createWebUrl2("dlistoreyuangong",array('op' => 'display', 'id' => $storeid,"uid"=>$uniacid)),"success");
		}
		
	}
}
if ($op == "save") {
	$y_id = $_GPC['y_id'];
	$y_styles = $_GPC['y_styles'];
	$data = array("y_styles"=>$y_styles);
	pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$y_id));
	message("审核通过!",$this->createWebUrl2("dlistoreyuangong",array('op' => 'display', 'id' => $storeid,"uid"=>$uniacid)),"success");
}
if ($op == "delete") {
	$y_id = $_GPC['y_id'];
	$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
	$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$yuangong['y_openid']));
	pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>"0"),array("u_id"=>$user['u_id']));
	pdo_delete("hyb_o2o_yuangong",array("y_id"=>$y_id));
	message("删除成功!",$this->createWebUrl2("dlistoreyuangong",array('op' => 'display', 'id' => $storeid,"uid"=>$uniacid)),"success");
}
include $this->template("web/dlistoreyuangong");