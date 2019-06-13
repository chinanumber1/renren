<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
if ($op == "display") {
	$ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	//微信支付
	$wxgoods = pdo_fetchall("SELECT sum(o_count_money) as money  FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type  ",array(":uniacid"=>$uniacid,":o_pay_type"=>"微信"));
	if (empty($wxgoods[0]['money'])) {
		$wxgoods[0]['money']="0";
	}
	//余额支付
	$yegoods = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type  ",array(":uniacid"=>$uniacid,":o_pay_type"=>"余额"));
	if (empty($yegoods[0]['money'])) {
		$yegoods[0]['money']="0";
	}
	$ordermoney = $wxgoods[0]['money']+$yegoods[0]['money'];
	// var_dump($ordermoney);exit();


	$paytype = $_GPC['paytype'];
	$type = $_GPC['type'];
	$keyword  = $_GPC['keyword'];
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	if (empty($paytype) && empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
	}
	if (!empty($paytype) && empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_pay_type"=>$paytype));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  wwhere uniacid=:uniacid and o_pay_type=:o_pay_type ",array(":uniacid"=>$uniacid,":o_pay_type"=>$paytype));
	}
	if (empty($paytype) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  where uniacid=:uniacid and o_type=:o_type",array(":uniacid"=>$uniacid,":o_type"=>$type));
	}
	if (empty($paytype) && empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  where uniacid=:uniacid and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid));
	}
	if (!empty($paytype) && !empty($type) && empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_pay_type"=>$paytype,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  wwhere uniacid=:uniacid and o_pay_type=:o_pay_type and o_type=:o_type",array(":uniacid"=>$uniacid,":o_pay_type"=>$paytype,":o_type"=>$type));
	}
	if (!empty($paytype) && empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_pay_type"=>$paytype));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  where uniacid=:uniacid and o_pay_type=:o_pay_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_pay_type"=>$paytype));
	}
	if (empty($paytype) && !empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_type"=>$type));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  where uniacid=:uniacid and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_type"=>$type));
	}
	if (!empty($paytype) && !empty($type) && !empty($keyword)) {
		$products  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_type"=>$type,":o_pay_type"=>$paytype));
		$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")."  where uniacid=:uniacid and o_type=:o_type and o_pay_type=:o_pay_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_type"=>$type,":o_pay_type"=>$paytype));
	}
	
	
	
	$pager = pagination($count, $pindex, $psize);

}

if ($op == "post") {
	$o_id = $_GPC['o_id'];
	$info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
	if (strpos($info['o_goodsthumb'],"http")===false) {
		$info['o_goodsthumb'] = $_W['attachurl'].$info['o_goodsthumb'];
	}
	if (empty($info['o_goodsguige'])) {
		$info['o_goodsguige'] = "无";
	}
}
if ($op=="save") {
	$o_id = $_GPC['o_id'];
	pdo_update("hyb_o2o_ordergoods",array("o_type"=>"已发货"),array("o_id"=>$o_id));
	message("发货成功",$this->createweburl("ordergoods",array("op"=>"display")),"success");
}
if ($op=="saves") {
	$o_id = $_GPC['o_id'];
	pdo_update("hyb_o2o_ordergoods",array("o_type"=>"已完成"),array("o_id"=>$o_id));
	//查询订单
          $order = pdo_fetch("SELECT * from ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
          //查询商品信息
            $goods = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$order['o_gid']));
              //查询用户是否为分销商
            $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
            //查询分销设置
            $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
            if (!empty($fenxiao)) {
                if (!empty($goods['fx_yi']) && $goods['fx_yi']!='0') {  
                    if ($fenxiao['f_parentid']!="0") {
                        $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                        if (!empty($shangji)) {
                            $yongjin = $order['o_count_money']*$goods['fx_yi'];
                            $fujiyongjin = $shangji['f_money']+$yongjin;
                            $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                            pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                            pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                        }
                        $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                        if(!empty($shangji2) && !empty($goods['fx_er']) && $goods['fx_er']!='0'){
                            $yongjin1 = $order['o_count_money']*$goods['fx_er'];   
                            $fujiyongjin = $shangji2['f_money']+$yongjin1;
                            $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                            pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                            pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                        }  
                    }
                }          
            }
	message("已完成",$this->createweburl("ordergoods",array("op"=>"display")),"success");

}
if ($op == "delete") {
	$o_id = $_GPC['o_id'];
	pdo_delete("hyb_o2o_ordergoods",array("o_id"=>$o_id));
	message("删除成功!",$this->createweburl("ordergoods",array("op"=>"display")),"success");
}
if ($op == "daochu") {
	//查询id数据
	$innerdata=array();
	$order = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	$ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
	$filename='商品订单列表'.time();
	header("Content-type:application/vnd.ms-excel");      
	header("Content-Disposition:filename=".$filename.".xls");
	$strexport="序号\t订单编号\t商品名称\t商品规格\t商品单价\t购买数量\t订单金额\t下单时间\t收货人\t收货地址\t收货详细地址\t联系电话\t备注\t订单状态\r"; 
	for ($i=0; $i <$ordernum ; $i++) { 
		$strexport.=$order[$i]['o_id']."\t"; 
		$strexport.=$order[$i]['ordersn']."\t";  
		$strexport.=$order[$i]['o_goodsname']."\t";  
		$strexport.=$order[$i]['o_goodsguige']."\t";  
		$strexport.=$order[$i]['o_monney']."\t";  
		$strexport.=$order[$i]['o_num']."\t";  
		$strexport.=$order[$i]['o_count_money']."\t";  
		$strexport.=$order[$i]['o_xdtime']."\t";  
		$strexport.=$order[$i]['o_name']."\t";  
		$strexport.=$order[$i]['o_address']."\t"; 
		$strexport.=$order[$i]['o_xxaddress']."\t";      
		$strexport.=$order[$i]['o_telphone']."\t";
		$strexport.=$order[$i]['o_beizhu']."\t";           
		$strexport.=$order[$i]['o_type']."\r"; 	        
	}
	$strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport); 
	exit($strexport);
}
include $this->template('web/ordergoods');