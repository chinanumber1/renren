<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
//查询平台商家
$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
if ($op == "display") {
    $ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    $paytype = $_GPC['paytype'];
    $paytypes = $_GPC['paytypes'];
    $xiangmu_xingshi = $_GPC['xiangmu_xingshi'];
    $type = $_GPC['type'];
    $keyword  = $_GPC['keyword'];
    
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store  ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'])); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype)); 
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type)); 
    }
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'])); 
    }
    if (!empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi)); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type)); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype)); 
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type)); 
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (!empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi)); 
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi)); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type)); 
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type)); 
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }

   
    foreach ($products as &$value) {
        if (empty($value['o_xiangmu_name']) && empty($value['o_xiangmu_thumb'])) {
            //查询项目
            $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$value['o_xid']));
            if (strpos($xiangmu['x_thumb'],"http")===false) {
                $value['o_xiangmu_thumb'] = $_W['attachurl'].$xiangmu['x_thumb'];
            }else{
                $value['o_xiangmu_thumb'] = $xiangmu['x_thumb'];
            }
            $value['o_xiangmu_name'] = $xiangmu['x_name'];
        }else{
            if (strpos($value['o_xiangmu_thumb'],"http")===false) {
                $value['o_xiangmu_thumb'] = $_W['attachurl'].$value['o_xiangmu_thumb'];
            }
        }
        
    }
    $pager = pagination($count, $pindex, $psize);
}
if ($op == "post") {
    $o_id = $_GPC['o_id'];
    $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
    //查询项目
    $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$info['o_xid']));
    if (empty($info['o_xiangmu_guigemoney'])) {
        $info['o_xiangmu_guigemoney'] = "无";
        $info['money'] = $xiangmu['x_jiage'];
    }else{
        $info['money'] = $info['o_xiangmu_guigemoney'];
    }
    if (strpos($xiangmu['x_thumb'],"http")===false) {
        $info['x_thumb'] = $_W['attachurl'].$xiangmu['x_thumb'];
    }else{
        $info['x_thumb'] = $xiangmu['x_thumb'];
    }
    $info['x_name'] = $xiangmu['x_name'];
}
if ($op == "save") {
    $o_id = $_GPC['o_id'];
    $data = array("o_type"=>"已完成","o_pay_types"=>"2","o_fw_type"=>"2");
    //查询订单
    $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
    $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));

    //查询服务员工
    $fwyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));
    pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));

    //查询用户是否为分销商
    $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));

    if (!empty($fenxiao)) {
                        if (!empty($xiangmu['fx_yi']) && $xiangmu['fx_yi']!='0') {  
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$xiangmu['fx_yi'];
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji2) && !empty($xiangmu['fx_er']) && $xiangmu['fx_er']!='0'){
                                    $yongjin1 = $order['o_count_money']*$xiangmu['fx_er'];   
                                    $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                }  
                            }
                        }          
                    }
    pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
    message("确认完成服务!",$this->createweburl("ordermdfw",array("op"=>"display")),"success");
}
if ($op == "zhifu") {
    $o_id = $_GPC['o_id'];
    $o_pay_typess = $_GPC['o_pay_typess'];
    $data = array("o_type"=>"已付款","o_pay_typess"=>$o_pay_typess,"o_pay_types"=>"1");
    pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
    message("修改成功!",$this->createweburl("ordermdfw",array("op"=>"display")),"success");
}
if ($op == "delete") {
    $o_id = $_GPC['o_id'];
    //查询订单
    $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));

    //查询服务员工
    $fwyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));
    pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));
    pdo_delete("hyb_o2o_orderfuwu",array("o_id"=>$o_id));
    message("删除成功!",$this->createweburl("ordermdfw",array("op"=>"display")),"success");
}
if ($op == "daochu") {
    $innerdata=array();
    $order = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
    $ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
    $filename='门店服务订单列表'.time();
    header("Content-type:application/vnd.ms-excel");      
    header("Content-Disposition:filename=".$filename.".xls");
    $strexport="序号\t订单编号\t服务名称\t服务规格\t所属商家\t购买数量\t订单金额\t服务时间\t下单时间\t服务形式\t服务人员\t收货人\t收货地址\t收货详细地址\t联系电话\t备注\t订单状态\r"; 
    for ($i=0; $i <$ordernum ; $i++) { 
        $strexport.=$order[$i]['o_id']."\t"; 
        $strexport.=$order[$i]['ordersn']."\t";  
        $strexport.=$order[$i]['o_xiangmu_name']."\t";  
        $strexport.=$order[$i]['o_xiangmu_guige']."\t";    
        $strexport.="平台"."\t";  
        $strexport.=$order[$i]['o_num']."\t";  
        $strexport.=$order[$i]['o_count_money']."\t";  
        $strexport.=$order[$i]['o_yy_riqi']."\t";  
        $strexport.=$order[$i]['o_xdtime']."\t";
        $strexport.=$order[$i]['o_xiangmu_xingshi']."\t"; 
        $strexport.=$order[$i]['o_fwry']."\t";  
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
//指派其他员工服务
if ($op=="zhipai") {
    $ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
    if(empty($ptsj)){
        message("请前往门店设置信息",$this->createWeburl("store"),"success");
    }{
        // 查询员工信息
        $sjyg = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_sjname=:y_sjname and y_styles='审核通过' and y_typs=:y_typs and y_rz=0",array(":uniacid"=>$uniacid,":y_sjname"=>$ptsj['s_id'],":y_typs"=>"空闲中"));
        foreach ($sjyg as &$value) {
            if (strpos($value['y_thumb'],"http")===false) {
                $value['y_thumb'] = $_W['attachurl'].$value['y_thumb'];
            }
        }
    }
}
if ($op=="paidan") {
   $q_pdname = $_GPC['q_pdname'];
   $o_id = $_GPC['o_ids'];
   //查询员工信息
   $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$q_pdname));
   //查询订单
   $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
   $ordertime = explode(" ",$order['o_yy_riqi']);

    require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
    $params = array ();
    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
    $accessKeyId = $aliduanxin['accessKeyId'];
    $accessKeySecret = $aliduanxin['accessKeySecret'];
    $params["PhoneNumbers"] = $order['o_telphone'];         //接收人手机号
    $params["SignName"] = $aliduanxin['SignName'];
    $params["TemplateCode"] = $aliduanxin['pdtzyh'];

        /*通知用户*/
            $params['TemplateParam'] = Array (
                'ordersn'=>$order['ordersn'],
                'daytime'=>$ordertime[0],
                'time'=>$ordertime[1],
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
            $paramss["TemplateCode"] = $aliduanxin['pdtzyg'];
            $paramss['TemplateParam'] = Array (
                'ordersn'=>$order['ordersn'],
                'daytime'=>$ordertime[0],
                'time'=>$ordertime[1],
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

   pdo_update("hyb_o2o_orderfuwu",array("o_fwry"=>$yuangong['y_name']),array("o_id"=>$o_id));
   pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$yuangong['y_id']));
   message("指派成功!", $this -> createWeburl('ordermdfw', array('op' => 'display')), 'success');
}
if ($op == "baojia") {
    $o_id = $_GPC['o_id'];
    $monery = $_GPC['monery'];
    $data = array(
        "o_count_money"=>$monery,
        "o_fwry"=>"",
        "o_pay_types"=>"0",
        "o_type"=>"未支付",
        "o_fw_type"=>"0",
        "o_pay_typess"=>"",
    );
    pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));

       //查询订单
   $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));

    require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
    $params = array ();
    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
    $accessKeyId = $aliduanxin['accessKeyId'];
    $accessKeySecret = $aliduanxin['accessKeySecret'];
    $params["PhoneNumbers"] = $order['o_telphone'];         //接收人手机号
    $params["SignName"] = $aliduanxin['SignName'];
    $params["TemplateCode"] = $aliduanxin['baojia'];

    /*通知用户*/
    $params['TemplateParam'] = Array (
        'name'=>$order['ordersn'],
        'content'=>$order['o_xiangmu_name'],
        'money'=>$order['o_count_money'],
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
    message("报价成功!", $this -> createWeburl('ordermdfw', array('op' => 'display')), 'success');
}
if ($op=="zhipai") {
    $data = $sjyg;
    echo json_encode(array('d'=>$data));
}else if ($op=="paidan") {
    $data = 
    array("0"=>$params,"1"=>$content,"2"=>$paramss,"3"=>$contents);
    echo json_encode(array('d'=>$data));
}else if ($op=="zhifu"){
    $data = "1";
    echo json_encode(array('d'=>$data));
}elseif ($op == "baojia") {
    $data = "1";
    echo json_encode(array('d'=>$data));
}elseif ($op == "refund") {
    $o_id = $_GPC['o_id'];
    $orderinfo = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
    $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$orderinfo['openid']));
    $u_money = $user['u_money']+$orderinfo['o_count_money'];
    $data = array("u_money"=>$u_money);
    pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
    $datas = array("o_type"=>"已退款","o_pay_types"=>"0","o_fw_type"=>"0");
    pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
    message("修改成功!",$this->createweburl("orderfwdd",array("op"=>"display")),"success");
}else{
include $this->template('web/ordermdfw');
}
