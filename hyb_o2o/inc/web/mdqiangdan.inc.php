<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$fa_style = !empty($_GPC['fa_style'])?$_GPC['fa_style']:"未指派";
$uniacid = $_W['uniacid'];
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
if ($fa_style=="全部") {
    $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_types=:q_types  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":q_types"=>"门店"));
    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
}else{
    $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_types=:q_types and q_styles=:q_styles limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":q_types"=>"门店",":q_styles"=>$fa_style));
    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_style=:fa_style",array(":uniacid"=>$uniacid,":fa_style"=>$fa_style));
}
if (!empty($products)) {
	foreach ($products as &$value) {
		$info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." as f left join ".tablename("hyb_o2o_userinfo")." as u on f.fa_openid=u.openid WHERE f.uniacid=:uniacid and f.fa_id=:fa_id ",array(":uniacid"=>$uniacid,":fa_id"=>$value['q_dname']));
		$value['u_name'] = json_decode($info['u_name']);
		if (strpos($info['u_thumb'],"http")===false) {
			$value['u_thumb'] = $_W['attachurl'].$info['u_thumb'];
		}else{
			$value['u_thumb'] = $info['u_thumb'];
		}
		$value['fa_id'] = $info['fa_id'];
		$value['fa_fwname'] = $info['fa_fwname'];
		$value['fa_fwmoney'] = $info['fa_fwmoney'];
		$value['fa_fwaddress'] = $info['fa_fwaddress'];
		$value['fa_fwaddresss'] = $info['fa_fwaddresss'];
		$value['fa_fwtelphone'] = $info['fa_fwtelphone'];
		$value['fa_fwtime'] = $info['fa_fwtime'];
		$value['fa_time'] = $info['fa_time'];
		$value['fa_fwcontent'] = $info['fa_fwcontent'];
	}
}


$pager = pagination($count, $pindex, $psize);

if ($op=="zhipai") {
	$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
	if(empty($ptsj)){
		message("请前往门店设置信息",$this->createWeburl("store"),"success");
	}{
		// 查询员工信息
		$sjyg = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_sjname=:y_sjname and y_styles='审核通过' ",array(":uniacid"=>$uniacid,":y_sjname"=>$ptsj['s_id']));
		foreach ($sjyg as &$value) {
			if (strpos($value['y_thumb'],"http")===false) {
				$value['y_thumb'] = $_W['attachurl'].$value['y_thumb'];
			}
		}
	}
}
if ($op=="paidan") {
	$q_pdname = $_GPC['q_pdname'];
	$pd_ids = $_GPC['pd_id'];
	//查询员工信息
	$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$q_pdname));

	//查询发单信息
	$fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id where q.uniacid=:uniacid and q.q_id=:q_id",array(":uniacid"=>$uniacid,":q_id"=>$pd_ids));

	require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
    $params = array ();
    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
    $accessKeyId = $aliduanxin['accessKeyId'];
    $accessKeySecret = $aliduanxin['accessKeySecret'];

    /*通知用户*/
    $params["PhoneNumbers"] = $fadan['fa_fwtelphone'];         //接收人手机号
    $params["SignName"] = $aliduanxin['SignName'];
    $params["TemplateCode"] = $aliduanxin['fdtzyh'];
    $params['TemplateParam'] = Array (
        'name'=>$fadan['fa_fwname'],
        'time'=>$fadan['fa_fwtime'],
        'content'=>$yuangong['y_name'],
        'tel'=>$yuangong['y_telphone'],
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

    /*通知员工*/
    $paramss["PhoneNumbers"] = $yuangong['y_telphone'];         //接收人手机号
    $paramss["SignName"] = $aliduanxin['SignName'];
    $paramss["TemplateCode"] = $aliduanxin['fdtzyg'];
    $paramss['TemplateParam'] = Array (
        'name'=>$fadan['fa_fwname'],
        'time'=>$fadan['fa_fwtime'],
        'tel'=>$fadan['fa_fwtelphone'],
        "product"=>"sms"
    );

    if(!empty($paramss["TemplateParam"]) && is_array($paramss["TemplateParam"])) {
        $paramss["TemplateParam"] = json_encode($paramss["TemplateParam"]);
    }
    $helper = new SignatureHelper();
    $contents = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($paramss, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );


	pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$q_pdname));
	
	$data = array("q_pdname"=>$q_pdname,"q_pd_time"=>date("Y-m-d H:i:s",time()),"q_styles"=>"已派单");
	pdo_update("hyb_o2o_qiangdan",$data,array("q_id"=>$pd_ids));
	message("指派成功!", $this -> createWeburl('mdqiangdan', array('op' => 'display')), 'success');
}


//查询接单信息
if ($op=="jieinfo") {
$fa_id = $_GPC['fa_id'];
$fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id ",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
$jiedan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$fadan['fa_id']));
//查询商家信息
$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
$info['s_name'] = $ptsj['s_name'];
$info['s_telphone'] = $ptsj['s_telphone'];
//查询服务员工
$yuanggong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$jiedan['q_pdname']));
$info['y_name'] = $yuanggong['y_name']."[商家指派]";
$info['y_telphone'] = $yuanggong['y_telphone'];
}
if ($op=="jieinfo") {
	$data = '<div class="detail_box">
    <div style="text-align: left">
        <div><span class="left">服务员工:</span>'.$info['y_name'].'</div>
        <div><span class="left">联系方式:</span>'.$info['y_telphone'].'</div>
        <div><span class="left">所属商家:</span>'.$info['s_name'].'</div>
        <div><span class="left">联系商家:</span>'.$info['s_telphone'].'</div>
    </div>
    <button class="btn btn-primary close_box" style="width: 200px;background: #3c9be1;border-color: #3c9be1">关闭</button>
</div>
<div class="modals"></div>';
	echo json_encode(array('d'=>$data));
}else if ($op=="zhipai") {
	$data = $sjyg;
	echo json_encode(array('d'=>$data));
}else if ($op=="paidan") {
	$data = $yuangong;
	echo json_encode(array('d'=>$data));
}else{
include $this->template('web/mdqiangdan');
}