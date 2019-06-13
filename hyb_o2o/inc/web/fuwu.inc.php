<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$typs = !empty($_GPC['typs'])?$_GPC['typs']:"display";
$uniacid = $_W['uniacid'];
if($op == "display")
{
	$fenlei = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$type = !empty($_GPC['type'])?$_GPC['type']:"";
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	if (empty($keywords) && empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_shangjia=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
	}elseif (!empty($keywords) && empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_name like '%$keywords%' and f.x_shangjia=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_name like '%$keywords%' and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
	}elseif (empty($keywords) && !empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_type=:x_type and f.x_shangjia=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_shangjia=:x_shangjia and x_type=:x_type",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
	}elseif (!empty($keywords) && !empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_name like '%$keywords%'  and f.x_type=:x_type and f.x_shangjia=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_name like '%$keywords%' and x_type=:x_type and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
	}
	foreach ($products as &$value) {
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id ",array(":uniacid"=>$uniacid,"s_id"=>$value['x_shangjia']));
		if ($shangjia['pingtai']=="1") {
			$value['sj'] = "平台";
		}else{
			$value['sj'] = $shangjia['s_name'];
		}
	}
	
	$pager = pagination($count, $pindex, $psize);

	if (!empty($_GPC['all'])) {
		if ($_GPC['submit']=="批量上架") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_status"=>"1"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('上架成功!', $this -> createWeburl('fuwu',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量下架") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_status"=>"0"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('下架成功!', $this -> createWeburl('fuwu',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量推荐") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_tuijian"=>"1"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('推荐成功!', $this -> createWeburl('fuwu',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量不推荐") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_tuijian"=>"0"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('不推荐成功!', $this -> createWeburl('fuwu',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量删除") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_delete('hyb_o2o_fuwu',array('x_id' =>$_GPC['all'][$i]));
			}
			message('删除成功!', $this -> createWeburl('fuwu',array('op'=>'display')),"success");
		}
	}
}
if ($op =="displays")
{
	$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
	$fenlei = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$type = !empty($_GPC['type'])?$_GPC['type']:"";
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	if (empty($keywords) && empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_shangjia!=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_shangjia!=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
	}elseif (!empty($keywords) && empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_name like '%$keywords%' and f.x_shangjia!=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_name like '%$keywords%' and x_shangjia!=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
	}elseif (empty($keywords) && !empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_type=:x_type and f.x_shangjia!=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_shangjia!=:x_shangjia and x_type=:x_type",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
	}elseif (!empty($keywords) && !empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as f left join ".tablename("hyb_o2o_fuwu_type")." as ft on f.x_type=ft.xt_id where f.uniacid=:uniacid and f.x_name like '%$keywords%'  and f.x_type=:x_type and f.x_shangjia!=:x_shangjia limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu")."  where uniacid=:uniacid and x_name like '%$keywords%' and x_type=:x_type and x_shangjia!=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id'],":x_type"=>$type));
	}
	foreach ($products as &$value) {
		$shangjiaS = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id ",array(":uniacid"=>$uniacid,"s_id"=>$value['x_shangjia']));
			$value['sj'] = $shangjiaS['s_name'];
	}
	$pager = pagination($count, $pindex, $psize);
	if (!empty($_GPC['all'])) {
		if ($_GPC['submit']=="批量上架") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_status"=>"1"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('上架成功!', $this -> createWeburl('fuwu',array('op'=>'displays')),"success");
		}
		if ($_GPC['submit']=="批量下架") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_status"=>"0"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('下架成功!', $this -> createWeburl('fuwu',array('op'=>'displays')),"success");
		}
		if ($_GPC['submit']=="批量推荐") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_tuijian"=>"1"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('推荐成功!', $this -> createWeburl('fuwu',array('op'=>'displays')),"success");
		}
		if ($_GPC['submit']=="批量不推荐") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_fuwu',array("x_tuijian"=>"0"),array('x_id' =>$_GPC['all'][$i]));
			}
			message('不推荐成功!', $this -> createWeburl('fuwu',array('op'=>'displays')),"success");
		}
		if ($_GPC['submit']=="批量删除") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_delete('hyb_o2o_fuwu',array('x_id' =>$_GPC['all'][$i]));
			}
			message('删除成功!', $this -> createWeburl('fuwu',array('op'=>'displays')),"success");
		}
	}
}
if ($op == "post") {
	$x_id = $_GPC['x_id'];
	
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$x_id));
	
	if (!empty($items)) {
		//查询商家
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$items['x_shangjia']));
	}else{
		//查询商家
		$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
		if (empty($shangjia)) {
			message("请前往门店设置信息",$this->createWeburl("store"),"success");
		}
	}

	if ($shangjia['pingtai']=="0") {
		//查询服务分类
		$fuwu= pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid  and xt_name=:xt_name and xt_parentid=0",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
		$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$fuwu['xt_id']));
	}elseif($shangjia['pingtai']=="1"){
		$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
	}
	
	
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
			//时间段规格项
			$time_spec['start']	= $_GPC['spec_start_time'];
			$time_spec['end']	= $_GPC['spec_end_time'];
			$time_spec['counts']	= $_GPC['counts'];
			$x_timecontent = serialize($time_spec);
			$parenttype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$_GPC['x_type']));
			$data = array(
				"uniacid"			=> $uniacid,
				"x_name"			=> $_GPC['x_name'],
				"x_type"			=> $_GPC['x_type'],
				"x_xingshi"			=> $_GPC['x_xingshi'],
				"x_thumb"			=> $_GPC['x_thumb'],
				"x_thumbs"			=> serialize($_GPC['x_thumbs']),
				"x_pay_type"		=> $_GPC['x_pay_type'],
				"x_pay_bili"		=> $_GPC['x_pay_bili'],
				"x_pay_smgj"		=> $_GPC['x_pay_smgj'],
				"x_guigecontent"	=> $x_guigecontent,
				"x_guigename"		=> $_GPC['spec'],
				"x_content"			=> $_GPC['x_content'],
				"x_jianjie_thumb"	=> serialize($_GPC['x_jianjie_thumb']),
				"x_wenxintishi"		=> $_GPC['x_wenxintishi'],
				"x_jiage"			=> $_GPC['x_jiage'],
				"x_yjiage"			=> $_GPC['x_yjiage'],
				"x_danwei"			=> $_GPC['x_danwei'],
				"x_xiaoliang"		=> $_GPC['x_xiaoliang'],
				"x_status"			=> $_GPC['x_status'],
				"x_tuijian"			=> $_GPC['x_tuijian'],
				"x_shangjia"		=> $shangjia['s_id'],
				"x_parenttype"		=> $parenttype['xt_parentid'],
				"x_jifenstatus"		=> $_GPC['x_jifenstatus'],
				"x_jifen"			=> $_GPC['x_jifen'],
				"x_manjianstatus"	=> $_GPC['x_manjianstatus'],
				"x_manjian"			=> $_GPC['x_manjian'],
				"x_huiyuanstatus"	=> $_GPC['x_huiyuanstatus'],
				"x_youhuiquanstatus"=> $_GPC['x_youhuiquanstatus'],
				"x_timecontent"		=> $x_timecontent,
				"x_youhuiquan"		=> $_GPC['x_youhuiquan'],
				"fx_yi"             => $_GPC['fx_yi'],
				"fx_er"				=> $_GPC['fx_er'],
				);
				
			if (empty($x_id)) {
				pdo_insert("hyb_o2o_fuwu",$data);
				message("添加成功!",$this->CreateWebUrl("fuwu",array("op"=>"display")),"success");
			}else{
				pdo_update("hyb_o2o_fuwu",$data,array("x_id"=>$x_id));
				message("修改成功!",$this->CreateWebUrl("fuwu",array("op"=>"display")),"success");
			}
		}
}
if ($op=="zhuang") {
	$x_id = $_GPC['x_id'];
	$x_status = $_GPC['x_status'];
	pdo_update("hyb_o2o_fuwu",array("x_status"=>$x_status),array("x_id"=>$x_id));
	message("修改成功!",$this->CreateWebUrl("fuwu",array("op"=>"display")),"success");
}
if ($op=="zhuangs") {
	$x_id = $_GPC['x_id'];
	$x_tuijian = $_GPC['x_tuijian'];
	pdo_update("hyb_o2o_fuwu",array("x_tuijian"=>$x_tuijian),array("x_id"=>$x_id));
	message("修改成功!",$this->CreateWebUrl("fuwu",array("op"=>"display")),"success");
}
if ($op == "delete") {
	$x_id = $_GPC['x_id'];
	pdo_delete("hyb_o2o_fuwu",array("x_id"=>$x_id));
	message("删除成功!",$this->CreateWebUrl("fuwu",array("op"=>'display')),"success");
}
include $this->template('web/fuwu');