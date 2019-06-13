<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
if ($op == "display") {
	$ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	
	$keyword  = $_GPC['keyword'];
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	if (empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jforder")." as j left join ".tablename("hyb_o2o_jfgoods")." as jg on j.j_id=jg.id where j.uniacid=:uniacid order by j.time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));

		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")."  where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
	}else{
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jforder")." as j left join ".tablename("hyb_o2o_jfgoods")." as jg on j.j_id=jg.id where j.uniacid=:uniacid and j.ordersn like '%$keyword%' order by j.time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));

		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")."  where uniacid=:uniacid and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid));
	}
	
	foreach ($products as &$value) {
		$value['thumb'] = $_W['attachurl'].$value['thumb'];
	}
	$pager = pagination($count, $pindex, $psize);

}

if ($op == "post") {
	$ordersn = $_GPC['ordersn'];
	$info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jforder")." as j left join ".tablename("hyb_o2o_jfgoods")." as jg on j.j_id=jg.id where j.uniacid=:uniacid and j.ordersn=:ordersn",array(":uniacid"=>$uniacid,":ordersn"=>$ordersn));
	$info['thumb'] = $_W['attachurl'].$info['thumb'];
}
if ($op=="save") {
	$ordersn = $_GPC['ordersn'];
	pdo_update("hyb_o2o_jforder",array("type"=>"待收货"),array("ordersn"=>$ordersn));
	message("发货成功",$this->createweburl("orderjifen",array("op"=>"display")),"success");
}
if ($op=="saves") {
	$ordersn = $_GPC['ordersn'];
	pdo_update("hyb_o2o_jforder",array("type"=>"已完成"),array("ordersn"=>$ordersn));
	message("已完成",$this->createweburl("orderjifen",array("op"=>"display")),"success");
}
if ($op == "delete") {
	$ordersn = $_GPC['ordersn'];
	pdo_delete("hyb_o2o_jforder",array("ordersn"=>$ordersn));
	message("删除成功!",$this->createweburl("orderjifen",array("op"=>"display")),"success");
}
if ($op == "daochu") {
    //查询id数据
    $innerdata=array();
    $order = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
    $ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    $filename='积分订单列表'.time();
    header("Content-type:application/vnd.ms-excel");      
    header("Content-Disposition:filename=".$filename.".xls");
    $strexport="序号\t订单编号\t商品名称\t兑换数量\t所需积分\t下单时间\t收货人\t收货地址\t收货详细地址\t联系电话\t订单状态\r"; 
    for ($i=0; $i <$ordernum ; $i++) { 
        $sp = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$order[$i]['j_id']));
        $strexport.=$order[$i]['id']."\t"; 
        $strexport.=$order[$i]['ordersn']."\t";  
        $strexport.=$sp['name']."\t";  
        $strexport.='1'."\t";    
        $strexport.=$order[$i]['jifen']."\t";  
        $strexport.=$order[$i]['time']."\t";  
        $strexport.=$order[$i]['username']."\t";  
        $strexport.=$order[$i]['address']."\t";
        $strexport.=$order[$i]['xxaddress']."\t"; 
        $strexport.=$order[$i]['usertel']."\t";            
        $strexport.=$order[$i]['type']."\r";          
    }
    $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport); 
    exit($strexport);
}

include $this->template('web/orderjifen');