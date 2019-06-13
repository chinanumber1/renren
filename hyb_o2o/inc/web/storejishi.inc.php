<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
//查询平台商家
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid)); 
if ($op == "display") {
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	if (empty($keywords)) {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_rz=1 limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_rz=1 ",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
	}else{
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' and y_rz=1 limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' and y_rz=1 ",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
	}
	$pager = pagination($count, $pageindex, $pagesize);	


	if (!empty($_GPC['deleteall'])) {
		for($i=0;$i<count($_GPC['deleteall']);$i++)
		{
			pdo_delete('hyb_o2o_yuangong', array('y_id' =>$_GPC['deleteall'][$i]));
		}
		message('删除成功!', $this -> createWeburl('storejishi',array('op'=>'display')),"success");
	}
}
if ($op == "daishenhe") {
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	if (empty($keywords)) {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_rz=1 and y_styles='待审核' order by y_id desc  limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_rz=1 and y_styles='待审核'",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
	}else{
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' and y_rz=1 and y_styles='待审核' order by y_id desc limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' and y_rz=1 and y_styles='待审核'",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
	}
	$pager = pagination($count, $pageindex, $pagesize);	
	if (!empty($_GPC['deleteall'])) {
		for($i=0;$i<count($_GPC['deleteall']);$i++)
		{
			pdo_delete('hyb_o2o_yuangong', array('y_id' =>$_GPC['deleteall'][$i]));
		}
		message('删除成功!', $this -> createWeburl('storejishi',array('op'=>'daishenhe')),"success");
	}
}
if ($op == "shenhetongguo") {
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize=10;
	if (empty($keywords)) {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_rz=1 and y_styles='审核通过' limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_rz=1 and y_styles='审核通过'",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
	}else{
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' and y_rz=1 and y_styles='审核通过' limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_name like '%$keywords%' and y_rz=1 and y_styles='审核通过'",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
	}
	$pager = pagination($count, $pageindex, $pagesize);	
	if (!empty($_GPC['deleteall'])) {
		for($i=0;$i<count($_GPC['deleteall']);$i++)
		{
			pdo_delete('hyb_o2o_yuangong', array('y_id' =>$_GPC['deleteall'][$i]));
		}
		message('删除成功!', $this -> createWeburl('storejishi',array('op'=>'shenhetongguo')),"success");
	}
}
if ($op == "post") {
	//查询全部服务分类
	$fwtype = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	foreach ($fwtype as &$value) {
		$fwtypes[]= $value['xt_name'];
	}
	$fwtypess=implode(",", $fwtypes);
	$sjaddress = explode("-",$shangjia['s_address']);
	$duqu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$sjaddress[1]));

	$diqu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=:parentid",array(":uniacid"=>$uniacid,":parentid"=>$duqu['id']));
	foreach ($diqu as &$value) {
		$diqus[]= $value['name'];
	}
	$diquss=implode(",", $diqus);
	$y_id = $_GPC['y_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
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
	if (checksubmit("submit")) {
		$y_jineng = explode(",",$_GPC['y_jineng']);
		$y_jineng = serialize($y_jineng);
		$y_fwqy = explode(",",$_GPC['y_fwqy']);
		$y_fwqy = serialize($y_fwqy);
		$data = array("y_name"=>$_GPC['y_name'],"y_telphone"=>$_GPC['y_telphone'],"y_sex"=>$_GPC['y_sex'],"y_age"=>$_GPC['y_age'],"y_thumb"=>$_GPC['y_thumb'],"y_imgpath1"=>$_GPC['y_imgpath1'],"y_imgpath2"=>$_GPC['y_imgpath2'],"y_jineng"=>$y_jineng,"y_fwqy"=>$y_fwqy,"y_typs"=>$_GPC['y_typs'],"y_choucheng"=>$_GPC['y_choucheng'],"y_zgeimg"=>$_GPC['y_zgeimg']);
		pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$y_id));
		message("修改成功!",$this->createWeburl("storejishi",array("op"=>"display")),"success");
	}
}
if ($op == "save") {
	$y_id = $_GPC['y_id'];
	$y_typs = $_GPC['y_typs'];
	pdo_update("hyb_o2o_yuangong",array("y_typs"=>$y_typs),array("y_id"=>$y_id));
	message("修改成功!",$this->createWeburl("storejishi",array("op"=>"display")),"success");
}
if ($op == "saves") {
	$y_id = $_GPC['y_id'];
	$y_styles = $_GPC['y_styles'];
	$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));

	require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
    $params = array ();
    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
    $accessKeyId = $aliduanxin['accessKeyId'];
    $accessKeySecret = $aliduanxin['accessKeySecret'];
    $params["PhoneNumbers"] = $yuangong['y_telphone'];         //接收人手机号
    $params["SignName"] = $aliduanxin['SignName'];
    $params["TemplateCode"] = $aliduanxin['shtz'];

    /*通知用户*/
    $params['TemplateParam'] = Array (
        'name'=>$yuangong['y_name'],
        'content'=>"技师",
        "product"=>"sms"
    );
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"]);
    }
    $helper = new SignatureHelper();
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );
	pdo_update("hyb_o2o_yuangong",array("y_styles"=>$y_styles),array("y_id"=>$y_id));
	$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$yuangong['y_openid']));
	pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>$shangjia['s_id']),array("u_id"=>$user['u_id']));
	message("修改成功!",$this->createWeburl("storejishi",array("op"=>"display")),"success");
}
if ($op == "delete") {
	$y_id = $_GPC['y_id'];
	$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
	//查询信息
	$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$yuangong['y_openid']));
	pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>"0"),array("u_id"=>$user['u_id']));
	pdo_delete("hyb_o2o_yuangong",array("y_id"=>$y_id));
	message("删除成功!",$this->createWeburl("storejishi",array("op"=>"display")),"success");
}
include $this->template("web/storejishi");