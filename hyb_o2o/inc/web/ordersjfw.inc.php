<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$type = !empty($_GPC['type'])?$_GPC['type']:"wait";
$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
if ($op == "display") {
	$ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$paytype = $_GPC['paytype'];
    $paytypes = $_GPC['paytypes'];
    $xiangmu_xingshi = $_GPC['xiangmu_xingshi'];
    $type = $_GPC['type'];
    $keyword  = $_GPC['keyword'];
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store  ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'])); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype)); 
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type)); 
    }
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'])); 
    }
    if (!empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi)); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type)); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype)); 
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_type"=>$type)); 
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (!empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes));
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi)); 
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi)); 
    }
    if (!empty($paytype) && empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_type"=>$type)); 
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (empty($paytype) && !empty($paytypes) && empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_type"=>$type));
    }
    if (empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi));
    }
    if (!empty($paytype) && empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type)); 
    }
    if (empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && !empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' ",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
    }
    if (!empty($paytype) && !empty($paytypes) && !empty($xiangmu_xingshi) && !empty($type) && empty($keyword)) {
        $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%' order by o_xdtime desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store and o_pay_type=:o_pay_type and o_pay_typess=:o_pay_typess and o_xiangmu_xingshi=:o_xiangmu_xingshi and o_type=:o_type and ordersn like '%$keyword%'",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id'],":o_pay_type"=>$paytype,":o_pay_typess"=>$paytypes,":o_xiangmu_xingshi"=>$xiangmu_xingshi,":o_type"=>$type));
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
                $value['o_xiangmu_thumb'] = $_W['attachurl'].$xiangmu['o_xiangmu_thumb'];
            }
        }
		//查询商家
		$sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$value['o_store']));
		$value['s_name'] = $sj['s_name'];
		if(strpos($sj['s_thumb'],"http")===false){
			$value['s_thumb'] = $_W['attachurl'].$sj['s_thumb'];
		}else{
			$value['s_thumb'] = $sj['s_thumb'];
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
if ($op == "delete") {
	$o_id = $_GPC['o_id'];
	pdo_delete("hyb_o2o_orderfuwu",array("o_id"=>$o_id));
	message("删除成功!",$this->createweburl("ordersjfw",array("op"=>"display")),"success");
}
if ($op == "daochu") {
    //查询id数据
    $innerdata=array();
    $order = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
    $ordernum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store!=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$ptsj['s_id']));
    $filename='商家服务订单列表'.time();
    header("Content-type:application/vnd.ms-excel");      
    header("Content-Disposition:filename=".$filename.".xls");
    $strexport="序号\t订单编号\t服务名称\t服务规格\t所属商家\t购买数量\t订单金额\t服务时间\t下单时间\t服务形式\t服务人员\t收货人\t收货地址\t收货详细地址\t联系电话\t备注\t订单状态\r"; 
    for ($i=0; $i <$ordernum ; $i++) { 
        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order[$i]['o_store']));
        $strexport.=$order[$i]['o_id']."\t"; 
        $strexport.=$order[$i]['ordersn']."\t";  
        $strexport.=$order[$i]['o_xiangmu_name']."\t";  
        $strexport.=$order[$i]['o_xiangmu_guige']."\t";    
        $strexport.=$sj['s_name']."\t";  
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

include $this->template('web/ordersjfw');