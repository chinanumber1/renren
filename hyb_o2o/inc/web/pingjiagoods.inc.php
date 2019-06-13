<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = $_GPC['op'];
$uniacid = $_W['uniacid'];
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goodspingjia")." WHERE uniacid=:uniacid order by p_time desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_goodspingjia")."  where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
$pager = pagination($count, $pindex, $psize);

if (!empty($products)) {
    foreach ($products as &$value) {
        //查询服务
        $fuwu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods")." WHERE uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$value['p_sid']));
        $value['g_name'] = $fuwu['g_name'];
        $value['p_name'] = json_decode($value['p_name']);
        $value['p_pic'] = unserialize($value['p_pic']);
    }
}

if ($op=="huifu") {
    $p_id = $_GPC['p_id'];
    $p_huifu = $_GPC['content'];
    $p_htime = date("Y-m-d H:i:s",time());
    $data = array("p_huifu"=>$p_huifu,"p_htime"=>$p_htime);
    pdo_update("hyb_o2o_goodspingjia",$data,array("p_id"=>$p_id));
}

if ($op=="delete") {
    $p_id = $_GPC['p_id'];
    pdo_delete("hyb_o2o_goodspingjia",array("p_id"=>$p_id));
    message("删除成功!",$this->createWebUrl("pingjiagoods",array()),"success");
}
if ($op!="huifu") {
    include $this->template('web/pingjiagoods');
}else{
   echo json_encode(array('d'=>$data));
}

