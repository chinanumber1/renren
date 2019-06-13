<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
if (empty($keywords)) {
	if ($type=="wait") {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue order by time desc  LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":statue"=>"待提现"));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue",array(":uniacid"=>$uniacid,":statue"=>"待提现"));
	}else if ($type=="now"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue order by time desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":statue"=>"已提现"));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue",array(":uniacid"=>$uniacid,":statue"=>"已提现"));
	}else if ($type=="delivery"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue order by time desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":statue"=>"已拒绝"));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue",array(":uniacid"=>$uniacid,":statue"=>"已拒绝"));
	}else if ($type=="all"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid order by time desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
	}	
}else{
	if ($type=="wait") {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and tnum like :tnum order by time desc ",array(":uniacid"=>$uniacid,":statue"=>"待提现",":tnum"=>$keywords));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and tnum like :tnum ",array(":uniacid"=>$uniacid,":statue"=>"待提现",":tnum"=>$keywords));
	}else if ($type=="now"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and tnum like :tnum order by time desc",array(":uniacid"=>$uniacid,":statue"=>"已提现",":tnum"=>$keywords));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and tnum like :tnum",array(":uniacid"=>$uniacid,":statue"=>"已提现",":tnum"=>$keywords));
	}else if ($type=="delivery"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and tnum like :tnum order by time desc",array(":uniacid"=>$uniacid,":statue"=>"已拒绝",":tnum"=>$keywords));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and tnum like :tnum",array(":uniacid"=>$uniacid,":statue"=>"已拒绝",":tnum"=>$keywords));
	}else if ($type=="all"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and tnum like :tnum order by time desc",array(":uniacid"=>$uniacid,":tnum"=>$keywords));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and tnum like :tnum",array(":uniacid"=>$uniacid));
	}
}
$pager = pagination($total, $pageindex, $pagesize);
foreach ($list as &$value) {
	//查询提现者
	if (!empty($value['s_id'])) {
		//商家提现
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$value['s_id']));
		$value['name'] = $shangjia['s_name'];
		$value['u_type'] = "商家";
	}elseif (!empty($value['y_id'])) {
		//员工提现
		$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$value['y_id']));
		$value['name'] = $yuangong['y_name'];
		$value['u_type'] = "员工";
	}elseif (!empty($value['u_id'])) {
		//用户提现
		$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$value['u_id']));
		$value['name'] = json_decode($user['u_name']);
		$value['u_type'] = "用户";
	}
}

if ($type=="adopt") {
	include 'wxtx.php';
	$id = $_GPC['id'];
	$u_type = $_GPC['u_type'];
	$xingshi = $_GPC['xingshi'];
	$list =  pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));

	if ($u_type=="商家") {
		//商家提现
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$list['s_id']));
		$list['openid'] = $shangjia['s_u_openid'];
		$list['name'] = $shangjia['s_name'];
		$list['u_type'] = "商家";
	}
	if($u_type=="员工"){
		$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$list['y_id']));
		$list['openid'] = $yuangong['y_openid'];
		$list['name'] = $yuangong['y_name'];
		$list['u_type'] = "员工";
	}
	if($u_type=="用户"){
		$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$list['u_id']));
		$list['openid'] = $user['openid'];
		$list['name'] = json_decode($user['u_name']);
		$list['u_type'] = "用户";

	}
	if ($xingshi=="微信") {

		//查询支付设置
		$key = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_parment")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
		$shezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tixian")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
		if (empty($shezhi)) {
			message("请填写提现设置!",$this->createWeburl("tixian",array("type"=>"wait")),"success");
		}else{
			if (empty($shezhi['apiclient_cert']) || empty($shezhi['apiclient_key']) ) {
				message("请上传证书!",$this->createWeburl("tixian",array("type"=>"wait")),"success");
			}
		}
		$appid = $key['appid'];   //微信公众平台的appid
		$mch_id = $key['mchid'];  //商户号id
		$openid = $list['openid'];    //用户openid
		$amount = intval($list['money'] * 100);   //提现金额$money
		$desc = "帐户提现";     //企业付款描述信息
		$appkey = $key['wxkey'];   //商户号支付密钥
		$re_user_name = $list['name'];   //收款用户姓名

		if (empty($list['partner_trade_no'])) {
			$partner_trade_no = time().rand(10000, 99999); 
		}else{
			$partner_trade_no = $list['partner_trade_no'];
		}

		$Weixintx = new WeixinTx($appid,$mch_id,$openid,$amount,$desc,$appkey,$re_user_name,$partner_trade_no);
	    $notify_url = $Weixintx->tixian(); 

	    if ($notify_url['return_code']=="SUCCESS" && $notify_url['result_code']=="SUCCESS") {
	       	$type = "已提现";
			$data = array("statue"=>$type);
			$res = pdo_update("hyb_o2o_usertixian",$data,array("id"=>$id));
			message("提现成功!",$this->createWeburl("tixian",array("type"=>"wait")),"success");
	    }
	    else 
	    {
	       pdo_update("hyb_o2o_usertixian",array("partner_trade_no"=>$partner_trade_no),array("id"=>$id));
	       message($notify_url['err_code_des'],$this->createWeburl("tixian",array("type"=>"wait")),"error");;
	    }
	}else{
		$type = "已提现";
		$data = array("statue"=>$type);
		$res = pdo_update("hyb_o2o_usertixian",$data,array("id"=>$id));
		message("提现成功!",$this->createWeburl("tixian",array("type"=>"wait")),"success");
	}
	
}
if ($type=="reject") {
	$id = $_GPC['id'];
	$type = "已拒绝";
	$res = pdo_update("hyb_o2o_usertixian",array("statue"=>$type),array("id"=>$id));
	$u_type = $_GPC['u_type'];
	$list =  pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
	if ($u_type=="商家") {
		//商家提现
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$list['s_id']));
		$money = $shangjia['s_money']+$list['money']+$list['s_money'];
		pdo_update("hyb_o2o_shangjia",array("s_money"=>$money),array("s_id"=>$shangjia['s_id']));
	}
	if($u_type=="员工"){
		$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$list['y_id']));
		$money = $yuangong['y_money']+$list['money']+$list['s_money'];	
		pdo_update("hyb_o2o_yuangong",array("y_money"=>$money),array("y_id"=>$yuangong['y_id']));
	}
	if($u_type=="用户"){
		$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$list['u_id']));
		$money = $user['u_money']+$list['money']+$list['s_money'];	
		pdo_update("hyb_o2o_userinfo",array("u_money"=>$money),array("u_id"=>$user['u_id']));
	}
	message("拒绝成功!",$this->createWeburl("tixian",array("type"=>"wait")),"success");
}
if ($type=="delete") {
	$id = $_GPC['id'];
	$u_type = $_GPC['u_type'];
	$list =  pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
	if ($list['statue']=='待提现') {
		if ($u_type=="商家") {
			//商家提现
			$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$list['s_id']));
			$money = $shangjia['s_money']+$list['money']+$list['s_money'];
			pdo_update("hyb_o2o_shangjia",array("s_money"=>$money),array("s_id"=>$shangjia['s_id']));
		}
		if($u_type=="员工"){
			$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$list['y_id']));
			$money = $yuangong['y_money']+$list['money']+$list['s_money'];	
			pdo_update("hyb_o2o_yuangong",array("y_money"=>$money),array("y_id"=>$yuangong['y_id']));
		}
		if($u_type=="用户"){
			$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$list['u_id']));
			$money = $user['u_money']+$list['money']+$list['s_money'];	
			pdo_update("hyb_o2o_userinfo",array("u_money"=>$money),array("u_id"=>$user['u_id']));
		}
	}else{
		pdo_delete("hyb_o2o_usertixian",array("id"=>$id));
	}
	message("删除成功!",$this->createWeburl("tixian",array("type"=>"wait")),"success");
}

include $this->template('web/tixian');