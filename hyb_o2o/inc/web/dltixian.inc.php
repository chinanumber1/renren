<?php
global $_GPC, $_W;
$action = 'dltixian';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
if (empty($keywords)) {
	if ($type=="wait") {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and s_id=:s_id LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":statue"=>"待提现",":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"待提现",":s_id"=>$storeid));
	}else if ($type=="now"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and s_id=:s_id LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":statue"=>"已提现",":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"已提现",":s_id"=>$storeid));
	}else if ($type=="delivery"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and s_id=:s_id LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":statue"=>"已拒绝",":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"已拒绝",":s_id"=>$storeid));
	}else if ($type=="all"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and s_id=:s_id LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid ",array(":uniacid"=>$uniacid,":s_id"=>$storeid));
	}	
}else{
	if ($type=="wait") {
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and tnum like :tnum and s_id=:s_id ",array(":uniacid"=>$uniacid,":statue"=>"待提现",":tnum"=>$keywords,":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and tnum like :tnum and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"待提现",":tnum"=>$keywords,":s_id"=>$storeid));
	}else if ($type=="now"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and tnum like :tnum and s_id=:s_id ",array(":uniacid"=>$uniacid,":statue"=>"已提现",":tnum"=>$keywords,":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and tnum like :tnum and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"已提现",":tnum"=>$keywords,":s_id"=>$storeid));
	}else if ($type=="delivery"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and statue=:statue and tnum like :tnum and s_id=:s_id ",array(":uniacid"=>$uniacid,":statue"=>"已拒绝",":tnum"=>$keywords,":s_id"=>$storeid));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and statue=:statue and tnum like :tnum and s_id=:s_id",array(":uniacid"=>$uniacid,":statue"=>"已拒绝",":tnum"=>$keywords));
	}else if ($type=="all"){
		$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and tnum like :tnum and s_id=:s_id ",array(":uniacid"=>$uniacid,":tnum"=>$keywords));
		$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_usertixian')." where uniacid=:uniacid and tnum like :tnum and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$storeid));
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
	}else{
		//员工提现
		$yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$value['y_id']));
		$value['name'] = $yuangong['y_name'];
		$value['u_type'] = "员工";
	}
}

if ($type=="adopt") {
	include '../addons/hyb_o2o/wxtx.php';
	$id = $_GPC['id'];
	$u_type = $_GPC['u_type'];
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
	
	//查询支付设置
	$key = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_parment")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	$appid = $key['appid'];   //微信公众平台的appid
	$mch_id = $key['mchid'];  //商户号id
	$openid = $list['openid'];    //用户openid
	$amount = intval($list['money'] * 100);   //提现金额$money
	$desc = "帐户提现";     //企业付款描述信息
	$appkey = $key['wxkey'];   //商户号支付密钥
	$re_user_name = $list['name'];   //收款用户姓名
	$data = array("appid"=>$appid,"mch_id"=>$mch_id,"openid"=>$openid,"amount"=>$amount,"desc"=>$desc,"appkey"=>$appkey,"re_user_name"=>$re_user_name);
	// var_dump($data);
	$Weixintx = new WeixinTx($appid,$mch_id,$openid,$amount,$desc,$appkey,$re_user_name);
    $notify_url = $Weixintx->tixian();
    if ($notify_url['return_code']=="SUCCESS" && $notify_url['result_code']=="SUCCESS") {
       	$type = "已提现";
		$data = array("statue"=>$type);
		$res = pdo_update("hyb_o2o_usertixian",$data,array("id"=>$id));
		message("提现成功!",$this->createWeburl2("dltixian",array("type"=>"wait","id"=>$storeid,"uid"=>$uniacid)),"success");
    }
    else 
    {
       message($notify_url['err_code_des'],$this->createWeburl2("tixian",array("type"=>"wait","id"=>$storeid,"uid"=>$uniacid)),"success");;
    }
}
if ($type=="reject") {
	$tid = $_GPC['tid'];
	$type = "已拒绝";
	$res = pdo_update("hyb_o2o_usertixian",array("statue"=>$type),array("id"=>$tid));
	$u_type = $_GPC['u_type'];
	$list =  pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_usertixian")."  where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$tid));
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
	message("已取消提现!",$this->createWeburl2("dltixian",array("type"=>"wait","id"=>$storeid,"uid"=>$uniacid)),"success");
}
if ($type=="delete") {
	$tid = $_GPC['tid'];
	pdo_delete("hyb_o2o_usertixian",array("id"=>$tid));
	message("删除成功!",$this->createWeburl2("dltixian",array("type"=>"wait","id"=>$storeid,"uid"=>$uniacid)),"success");
}
include $this->template("web/dltixian");