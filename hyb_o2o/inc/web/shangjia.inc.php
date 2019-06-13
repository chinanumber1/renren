<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$type = !empty($_GPC['type'])?$_GPC['type']:"all";
$uniacid = $_W['uniacid'];
if($op == "display")
{
	//查询城市

	$city = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=0",array(":uniacid"=>$uniacid));

	//查询所属分类
	$fenlei = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
	$type = !empty($_GPC['type'])?$_GPC['type']:"";
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$area = !empty($_GPC['area'])?$_GPC['area']:"";
	if (empty($keywords) && empty($type) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0 ",array(":uniacid"=>$uniacid));
		$pager = pagination($count, $pindex, $psize);
	}else if (!empty($keywords) && empty($type) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_name like '%$keywords%' order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid  and pingtai=0 and s_name like '%$keywords%'",array(":uniacid"=>$uniacid));
		$pager = pagination($count, $pindex, $psize);
	}elseif (!empty($type) && empty($keywords) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_type=:s_type order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0 and s_type=:s_type ",array(":uniacid"=>$uniacid,":s_type"=>$type));
		$pager = pagination($count, $pindex, $psize);
	}elseif (!empty($area) && empty($keywords) && empty($type)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_address like '%$area%' order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_address like '%$area%' ",array(":uniacid"=>$uniacid,":s_type"=>$type));
		$pager = pagination($count, $pindex, $psize);
	}
	elseif (!empty($type) && !empty($keywords) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_name like '%$keywords%' order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_name like '%$keywords%' ",array(":uniacid"=>$uniacid,":s_type"=>$type));
		$pager = pagination($count, $pindex, $psize);
	}elseif (!empty($type) && empty($keywords) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_address like '%$area%' order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_address like '%$area%' ",array(":uniacid"=>$uniacid,":s_type"=>$type));
		$pager = pagination($count, $pindex, $psize);
	}elseif (empty($type) && !empty($keywords) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_address like '%$area%' and s_name like '%$keywords%' order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0  and s_address like '%$area%' and s_name like '%$keywords%'",array(":uniacid"=>$uniacid));
		$pager = pagination($count, $pindex, $psize);
	}elseif (!empty($type) && !empty($keywords) && empty($area)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_address like '%$area%' and s_name like '%$keywords%' order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=0 and s_type=:s_type and s_address like '%$area%' and s_name like '%$keywords%' ",array(":uniacid"=>$uniacid,":s_type"=>$type));
		$pager = pagination($count, $pindex, $psize);
	}
	if (!empty($products)) {
		foreach ($products as &$value) {
			$fuwufenlei = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name and xt_parentid=0",array(":uniacid"=>$uniacid,":xt_name"=>$value['s_type']));
			$value['choushui'] = $fuwufenlei['choushui'];
		}
	}
}
if ($op == "displays") {
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	if (empty($keywords)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_status=:s_status and pingtai=0 order by s_time desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_status"=>"待审核"));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacidand s_status=:s_status and pingtai=0",array(":uniacid"=>$uniacid,":s_status"=>"待审核"));
		$pager = pagination($count, $pindex, $psize);
	}else{
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;	
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_status=:s_status and s_name like '%$keywords%' and pingtai=0 order by s_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":s_status"=>"待审核"));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacidand s_status=:s_status and pingtai=0 and s_name like '%$keywords%'",array(":uniacid"=>$uniacid,":s_status"=>"待审核"));
		$pager = pagination($count, $pindex, $psize);
	}
	if (!empty($products)) {
		foreach ($products as &$value) {
			$fuwufenlei = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name and xt_parentid=0",array(":uniacid"=>$uniacid,":xt_name"=>$value['s_type']));
			$value['choushui'] = $fuwufenlei['choushui'];
		}
	}
	
}
if ($op == "post") {
	$s_id = $_GPC['s_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$s_id));

	//查询商家分类
	$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
	if (empty($s_id)) {
		//查询openid
	$openidlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_shangjia='0' and u_yuangong='0' ",array(":uniacid"=>$_W['uniacid']));
	}else{
		//查询openid
	$openidlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_shangjia in (0,$s_id) and u_yuangong='0' ",array(":uniacid"=>$_W['uniacid']));
	}
	
	if (!empty($openidlist)) {
		foreach ($openidlist as &$value) {
			$value['u_name'] = json_decode($value['u_name']);
		}
	}


	
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
		$s_yingyetime = $_GPC['time']."-".$_GPC['time2'];
		$baozhang = serialize($_GPC['baozhang']);
		if ($_GPC['s_address']['province']=='北京' || $_GPC['s_address']['province']=='天津' || $_GPC['s_address']['province']=='上海' || $_GPC['s_address']['province']=='重庆') {
			$_GPC['s_address']['province'] = $_GPC['s_address']['province']."市";
		}
		$s_address = $_GPC['s_address']['province']."-".$_GPC['s_address']['city']."-".$_GPC['s_address']['district'];
		$jw = $_GPC['jw'];
		$jws = explode(",",$jw);
		$label = explode("|",$_GPC['label']);
		$label = serialize($label);
		$data = array("ruzhu_endtime"=>$_GPC['ruzhu_endtime'],"uniacid"=>$uniacid,"s_name"=>$_GPC['s_name'],"s_u_name"=>$_GPC['s_u_name'],"s_u_openid"=>$_GPC['s_u_openid'],"s_telphone"=>$_GPC['s_telphone'],"s_content"=>$_GPC['s_content'],"s_type"=>$_GPC['s_type'],"s_yingyetime"=>$s_yingyetime,"s_thumb"=>$_GPC['s_thumb'],"s_imgpath"=>serialize($_GPC['s_imgpath']),"s_zhizhao"=>$_GPC['s_zhizhao'],"s_status"=>"审核通过","s_ids"=>$_GPC['s_ids'],"baozhang"=>$baozhang,"s_idcard"=>$_GPC['s_idcard'],"s_idcard2"=>$_GPC['s_idcard2'],"s_address"=>$s_address,"s_xxaddress"=>$_GPC['s_xxaddress'],"wei"=>$jws['0'],"jing"=>$jws['1'],"label"=>$label);
		if (empty($s_id)) {
			$data['s_tuijian'] = "否";
			pdo_insert("hyb_o2o_shangjia",$data);
			$is = pdo_insertid();
			//查询信息
			$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$_GPC['s_u_openid']));
			$datas = array("u_shangjia"=>$is);
			pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
			message("添加成功!",$this->createWeburl("shangjia",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$s_id));
			//查询信息
			$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$items['s_u_openid']));
			$datas = array("u_shangjia"=>$items['s_id']);
			pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
			message("修改成功!",$this->createWeburl("shangjia",array("op"=>"display")),"success");
		}
	}
}
if ($op == "shen") {
	$s_id = $_GPC['s_id'];
	$s_u_openid = $_GPC['s_u_openid'];
	//查询商家信息
	$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$s_id));
	require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
    $params = array ();
    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
    $accessKeyId = $aliduanxin['accessKeyId'];
    $accessKeySecret = $aliduanxin['accessKeySecret'];
    $params["PhoneNumbers"] = $shangjia['s_telphone'];         //接收人手机号
    $params["SignName"] = $aliduanxin['SignName'];
    $params["TemplateCode"] = $aliduanxin['shtz'];

    /*通知用户*/
    $params['TemplateParam'] = Array (
        'name'=>$shangjia['s_name'],
        'content'=>"商家",
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
	$data = array("s_status"=>"审核通过");
	pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$s_id));
	//查询用户信息
	$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$s_u_openid));
	$datas = array("u_shangjia"=>$s_id,"u_yuangong"=>"0");
	pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
	message("审核通过!",$this->CreateWebUrl("shangjia",array("op"=>"display")),"success");
}
if ($op == "saveruzhu") {
	$s_id = $_GPC['s_id'];
	$data =array("ruzhu_endtime"=>"已到期");
	pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$s_id));
	message("修改成功!",$this->CreateWebUrl("shangjia",array("op"=>"display")),"success");
}
if ($op =="tuijian") {
	$s_id = $_GPC['s_id'];
	$s_tuijian = $_GPC['s_tuijian'];
	if ($s_tuijian=="是") {
		$data = array("s_tuijian"=>"否");
	}else{
		$data = array("s_tuijian"=>"是");
	}
	pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$s_id));
	message("修改成功!",$this->CreateWebUrl("shangjia",array("op"=>"display")),"success");
}
if ($op=="delete") {
	$s_id = $_GPC['id'];
	//查询当前商家账户
	$zhanghao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." where uniacid=:uniacid and z_shangjia=:z_shangjia",array(":uniacid"=>$uniacid,":z_shangjia"=>$s_id));
	pdo_delete("hyb_o2o_zhanghao",array("z_id"=>$zhanghao['z_id']));
	//查询当前商家信息
	$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$s_id));
	//查询当前商家用户信息
	$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$shangjia['s_u_openid']));
	pdo_update("hyb_o2o_userinfo",array("u_shangjia"=>"0"),array("u_id"=>$user['u_id']));
	//查询当前商家服务
	$fuwu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$s_id));
	foreach ($fuwu as $key => $value) {
		pdo_delete("hyb_o2o_fuwu",array("x_id"=>$value['x_id']));
	}
	//查询当前商家优惠券
	$youhuiquan = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$s_id));
	foreach ($youhuiquan as $key => $value) {
		pdo_delete("hyb_o2o_youhuiquan",array("y_id"=>$value['y_id']));
	}
	//查询当前商家满减活动
	$manjian = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$s_id));
	foreach ($manjian as $key => $value) {
		pdo_delete("hyb_o2o_manjian",array("m_id"=>$value['m_id']));
	}
	//查询当前商家所有员工
	$yuangong = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_sjname"=>$s_id));
	foreach ($yuangong as $key => $value) {
		pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>"0"),array("uniacid"=>$uniacid,"openid"=>$value['y_openid']));
	}
	pdo_delete("hyb_o2o_shangjia",array("s_id"=>$s_id));
	message("删除成功!",$this->CreateWebUrl("shangjia",array("op"=>"display")),"success");
}
include $this->template('web/shangjia');