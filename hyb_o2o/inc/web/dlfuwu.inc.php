<?php
global $_GPC, $_W;
$action = 'dlfuwu';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$typs = !empty($_GPC['typs'])?$_GPC['typs']:"display";
if($op == "display")
{
	$fenlei = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	if (empty($keywords)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_shangjia=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$storeid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$storeid));
	}elseif (!empty($keywords)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_name like '%$keywords%' and f.x_shangjia=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$storeid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_name like '%$keywords%' and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
	}
	foreach ($products as &$value) {
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id  ",array(":uniacid"=>$uniacid,"s_id"=>$storeid));
		if ($shangjia['pingtai']=="1") {
			$value['sj'] = "平台";
		}else{
			$value['sj'] = $shangjia['s_name'];
		}
	}
	
	$pager = pagination($count, $pindex, $psize);
}
if ($op == "post") {
	$x_id = $_GPC['x_id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$x_id));
	//查询商家
	$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$storeid));
	//查询服务分类
	$fuwu= pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid  and xt_name=:xt_name and xt_parentid=0",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
	$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$fuwu['xt_id']));

	//查询满减活动
	$manjian = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
	//查询优惠券
	$youhuiquan = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
	$items['x_thumbs'] = unserialize($items['x_thumbs']);
	$items['x_jianjie_thumb'] = unserialize($items['x_jianjie_thumb']);
	$items['x_timecontent'] = unserialize($items['x_timecontent']);
	$items['x_timenum'] = count($items['x_timecontent']);
	$items['x_guigecontent'] = unserialize($items['x_guigecontent']);
	$items['x_guigenum'] = count($items['x_guigecontent']);
		if (checksubmit("submit")) {
			$a = array(guigexiang=>$_GPC['spec_title']);
			$b = array (price=>$_GPC['spec_money']);
			$test = array("a"=>guigexiang,"b"=>price);
			$x_guigecontent = array();
			for($i=0;$i<count($a[guigexiang]);$i++){
		    	foreach($test as $key=>$value){
		        	$x_guigecontent[$i][$value] = ${$key}[$value][$i];
		    	}
			}
			$x_guigecontent = serialize($x_guigecontent);
			$time_spec['start']	= $_GPC['spec_start_time'];
			$time_spec['end']	= $_GPC['spec_end_time'];
			$time_spec['counts']	= $_GPC['counts'];
			$x_timecontent = serialize($time_spec);
			$parenttype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$_GPC['x_type']));
			$data = array("uniacid"=>$uniacid,"x_name"=>$_GPC['x_name'],"x_type"=>$_GPC['x_type'],"x_xingshi"=>$_GPC['x_xingshi'],"x_thumb"=>$_GPC['x_thumb'],"x_thumbs"=>serialize($_GPC['x_thumbs']),"x_pay_type"=>$_GPC['x_pay_type'],"x_pay_bili"=>$_GPC['x_pay_bili'],"x_pay_smgj"=>$_GPC['x_pay_smgj'],"x_timecontent"=>$x_timecontent,"x_guigecontent"=>$x_guigecontent,"x_guigename"=>$_GPC['spec'],"x_content"=>$_GPC['x_content'],"x_jianjie_thumb"=>serialize($_GPC['x_jianjie_thumb']),"x_wenxintishi"=>$_GPC['x_wenxintishi'],"x_jiage"=>$_GPC['x_jiage'],"x_danwei"=>$_GPC['x_danwei'],"x_xiaoliang"=>$_GPC['x_xiaoliang'],"x_status"=>$_GPC['x_status'],"x_tuijian"=>$_GPC['x_tuijian'],"x_shangjia"=>$shangjia['s_id'],"x_parenttype"=>$parenttype['xt_parentid'],"x_jifenstatus"=>$_GPC['x_jifenstatus'],"x_jifen"=>$_GPC['x_jifen'],"x_manjianstatus"=>$_GPC['x_manjianstatus'],"x_manjian"=>$_GPC['x_manjian'],"x_huiyuanstatus"=>$_GPC['x_huiyuanstatus'],"x_youhuiquanstatus"=>$_GPC['x_youhuiquanstatus'],"x_youhuiquan"=>$_GPC['x_youhuiquan']);
			if (empty($x_id)) {
				pdo_insert("hyb_o2o_fuwu",$data);
				message("添加成功!",$this->CreateWebUrl2("dlfuwu",array("op"=>"display",'id'=>$storeid,"uid"=>$uniacid)),"success");
			}else{
				pdo_update("hyb_o2o_fuwu",$data,array("x_id"=>$x_id));
				message("修改成功!",$this->CreateWebUrl2("dlfuwu",array("op"=>"display",'id'=>$storeid,"uid"=>$uniacid)),"success");
			}
		}
}
if ($op=="zhuang") {
	$x_id = $_GPC['x_id'];
	$x_status = $_GPC['x_status'];
	pdo_update("hyb_o2o_fuwu",array("x_status"=>$x_status),array("x_id"=>$x_id));
	message("修改成功!",$this->CreateWebUrl2("dlfuwu",array("op"=>"display",'id'=>$storeid,"uid"=>$uniacid)),"success");
}
if ($op=="zhuangs") {
	$x_id = $_GPC['x_id'];
	$x_tuijian = $_GPC['x_tuijian'];
	pdo_update("hyb_o2o_fuwu",array("x_tuijian"=>$x_tuijian),array("x_id"=>$x_id));
	message("修改成功!",$this->CreateWebUrl2("dlfuwu",array("op"=>"display",'id'=>$storeid,"uid"=>$uniacid)),"success");
}
if ($op == "delete") {
	$x_id = $_GPC['x_id'];
	pdo_delete("hyb_o2o_fuwu",array("x_id"=>$x_id));
	message("删除成功!",$this->CreateWebUrl2("dlfuwu",array("op"=>'display','id'=>$storeid,"uid"=>$uniacid)),"success");
}
include $this->template("web/dlfuwu");