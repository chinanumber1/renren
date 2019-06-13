<?php
global $_GPC, $_W;
$action = 'dlpingjia';
$uniacid = $_GPC['uid'];
$storeid = $_GPC['id'];
$GLOBALS['frames'] = $this->getNaveMenu($action,$uniacid,$storeid);
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
//查询商家服务
$sjfw = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$storeid));
foreach ($sjfw as &$value) {
	$x_id[] = $value['x_id']; 
}
$x_id = implode(",",$x_id);
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwupingjia")." WHERE uniacid=:uniacid and p_sid in($x_id) order by p_time desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwupingjia")."  where uniacid=:uniacid and p_sid in($x_id)",array(":uniacid"=>$uniacid));
$pager = pagination($count, $pindex, $psize);

if (!empty($products)) {
    foreach ($products as &$value) {
        //查询服务
        $fuwu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." WHERE uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$value['p_sid']));
        $value['x_name'] = $fuwu['x_name'];
        $value['p_name'] = json_decode($value['p_name']);
        $value['p_pic'] = unserialize($value['p_pic']);
    }
}

if ($op=="huifu") {
    $p_id = $_GPC['p_id'];
    $p_huifu = $_GPC['content'];
    $p_htime = date("Y-m-d H:i:s",time());
    $data = array("p_huifu"=>$p_huifu,"p_htime"=>$p_htime);
    pdo_update("hyb_o2o_fuwupingjia",$data,array("p_id"=>$p_id));
}

if ($op=="delete") {
    $p_id = $_GPC['p_id'];
    pdo_delete("hyb_o2o_fuwupingjia",array("p_id"=>$p_id));
    message("删除成功!",$this->createWebUrl2("dlpingjia",array('op'=>"display",'id'=>$storeid,"uid"=>$uniacid)),"success");
}
if ($op!="huifu") {
   include $this->template("web/dlpingjia");
}else{
   echo json_encode(array('d'=>$data));
}

