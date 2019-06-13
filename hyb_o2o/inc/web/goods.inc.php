<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
if ($op == "display") {
	//查询分类
	$fenlei = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods_style")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));

	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
	$type = !empty($_GPC['type'])?$_GPC['type']:"";
	if (empty($keywords) && empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." as g left join ".tablename("hyb_o2o_goods_style")." as gt on g.g_type=gt.id left join".tablename("hyb_o2o_city")." as c on g.g_city=c.id where g.uniacid=:uniacid order by g.g_ids desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_goods")."  where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
	}elseif (!empty($keywords) && empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." as g left join ".tablename("hyb_o2o_goods_style")." as gt on g.g_type=gt.id left join".tablename("hyb_o2o_city")." as c on g.g_city=c.id where g.uniacid=:uniacid and g.g_name like '%$keywords%' order by g.g_ids desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_goods")."  where uniacid=:uniacid and g_name like '%$keywords%'",array(":uniacid"=>$uniacid));
	}elseif (empty($keywords) && !empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." as g left join ".tablename("hyb_o2o_goods_style")." as gt on g.g_type=gt.id left join".tablename("hyb_o2o_city")." as c on g.g_city=c.id where g.uniacid=:uniacid and g.g_type=:g_type order by g.g_ids desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":g_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_goods")."  where uniacid=:uniacid and g_type=:g_type",array(":uniacid"=>$uniacid,":g_type"=>$type));
	}elseif (!empty($keywords) && !empty($type)) {
		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." as g left join ".tablename("hyb_o2o_goods_style")." as gt on g.g_type=gt.id left join".tablename("hyb_o2o_city")." as c on g.g_city=c.id where g.uniacid=:uniacid and g.g_name like '%$keywords%' and g.g_type=:g_type order by g.g_ids desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":g_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_goods")."  where uniacid=:uniacid and g.g_name like '%$keywords%' and g_type=:g_type",array(":uniacid"=>$uniacid,":g_type"=>$type));
	}
	if (!empty($_GPC['all'])) {
		if ($_GPC['submit']=="批量上架") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_goods',array("g_status"=>"1"),array('g_id' =>$_GPC['all'][$i]));
			}
			message('上架成功!', $this -> createWeburl('goods',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量下架") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_goods',array("g_status"=>"0"),array('g_id' =>$_GPC['all'][$i]));
			}
			message('下架成功!', $this -> createWeburl('goods',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量推荐") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_goods',array("g_tuijian"=>"1"),array('g_id' =>$_GPC['all'][$i]));
			}
			message('推荐成功!', $this -> createWeburl('goods',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量不推荐") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_update('hyb_o2o_goods',array("g_tuijian"=>"0"),array('g_id' =>$_GPC['all'][$i]));
			}
			message('不推荐成功!', $this -> createWeburl('goods',array('op'=>'display')),"success");
		}
		if ($_GPC['submit']=="批量删除") {
			for($i=0;$i<count($_GPC['all']);$i++)
			{
				pdo_delete('hyb_o2o_goods',array('g_id' =>$_GPC['all'][$i]));
			}
			message('删除成功!', $this -> createWeburl('goods',array('op'=>'display')),"success");
		}
	}
	
	$pager = pagination($count, $pindex, $psize);
}
if ($op == "post") {
	$g_id = $_GPC['g_id'];
	//查询所属分类
	$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods_style")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	//查询所属城市
	$city = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=0",array(":uniacid"=>$uniacid));
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$g_id));
	$items['g_thumbs'] = unserialize($items['g_thumbs']);
	$items['g_guigecontent'] = unserialize($items['g_guigecontent']);
	$items['g_guigenum'] = count($items['g_guigecontent']);
	if (checksubmit("submit")) {
		$a = array(spec_title=>$_GPC['spec_title']);
		$b = array (spec_money=>$_GPC['spec_money']);
		$test = array("a"=>spec_title,"b"=>spec_money);
		$s_guigecontent = array();
		for($i=0;$i<count($a[spec_title]);$i++){
		    foreach($test as $key=>$value){
		        $s_guigecontent[$i][$value] = ${$key}[$value][$i];
		    }
		}
		$s_guigecontent = serialize($s_guigecontent);
		if ($_GPC['g_baoyou']=="0") {
			$data = array("uniacid"=>$uniacid,"g_name"=>$_GPC['g_name'],"g_type"=>$_GPC['g_type'],"g_city"=>$_GPC['g_city'],"g_jiage"=>$_GPC['g_jiage'],"g_thumb"=>$_GPC['g_thumb'],"g_thumbs"=>serialize($_GPC['g_thumbs']),"g_content"=>$_GPC['g_content'],"g_baoyou"=>$_GPC['g_baoyou'],"g_kuaidi"=>$_GPC['g_kuaidi'],"g_xiaoliang"=>$_GPC['g_xiaoliang'],"g_status"=>$_GPC['g_status'],"g_guigename"=>$_GPC['spec'],"g_guigecontent"=>$s_guigecontent,"g_tuijian"=>$_GPC['g_tuijian'],"g_ids"=>$_GPC['g_ids'],"fx_yi"=>$_GPC['fx_yi'],"fx_er"=>$_GPC['fx_er']);
		}else{
			$data = array("uniacid"=>$uniacid,"g_name"=>$_GPC['g_name'],"g_type"=>$_GPC['g_type'],"g_city"=>$_GPC['g_city'],"g_jiage"=>$_GPC['g_jiage'],"g_thumb"=>$_GPC['g_thumb'],"g_thumbs"=>serialize($_GPC['g_thumbs']),"g_content"=>$_GPC['g_content'],"g_baoyou"=>$_GPC['g_baoyou'],"g_kuaidi"=>"0","g_xiaoliang"=>$_GPC['g_xiaoliang'],"g_status"=>$_GPC['g_status'],"g_guigename"=>$_GPC['spec'],"g_guigecontent"=>$s_guigecontent,"g_tuijian"=>$_GPC['g_tuijian'],"g_ids"=>$_GPC['g_ids'],"fx_yi"=>$_GPC['fx_yi'],"fx_er"=>$_GPC['fx_er']);
		}
		if (empty($g_id)) {
			pdo_insert("hyb_o2o_goods",$data);
			message("添加成功!",$this->createWeburl("goods",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_goods",$data,array("g_id"=>$g_id));
			message("修改成功!",$this->createWeburl("goods",array("op"=>"display")),"success");
		}
	}		
}
if ($op=="zhuang1") {
	$g_id = $_GPC['g_id'];
	$g_tuijian = $_GPC['g_tuijian'];
	pdo_update("hyb_o2o_goods",array("g_tuijian"=>$g_tuijian),array("g_id"=>$g_id));
	message("修改成功!",$this->createWeburl("goods",array("op"=>"display")),"success");
}
if ($op=="zhuang2") {
	$g_id = $_GPC['g_id'];
	$g_status = $_GPC['g_status'];
	pdo_update("hyb_o2o_goods",array("g_status"=>$g_status),array("g_id"=>$g_id));
	message("修改成功!",$this->createWeburl("goods",array("op"=>"display")),"success");
}
if ($op == "delete") {
	$g_id = $_GPC['g_id'];
	pdo_delete("hyb_o2o_goods",array("g_id"=>$g_id));
	message("删除成功!",$this->createWeburl("goods",array("op"=>"display")),"success");
}		
include $this->template('web/goods');