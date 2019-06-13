<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"";
$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
$uniacid = $_W['uniacid'];

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
if(empty($keywords)){
$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_type=1 order by f_time desc   limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_type=1",array(":uniacid"=>$uniacid));
}else{
$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_type=1 and f_name like '%$keywords%' order by f_time desc limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_name like '%$keywords%' and f_type=1 ",array(":uniacid"=>$uniacid));
}
$pager = pagination($total, $pindex, $psize);
foreach ($list as &$value) {
  $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$value['f_openid']));
  $value['thumb'] = $user['u_thumb'];
  //查询下级分销商
    $yijinum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$value['f_id']));
    $yiji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$value['f_id']));
    foreach ($yiji as &$values) {
        $erjinum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$values['f_id']));
        // $erjinum+=$erji;
    }
    $fenxiaoxiaji = $yijinum+$erjinum;
    $value['fenxiaoxiaji'] = $fenxiaoxiaji;
}

if ($op == "adopt") {
    $f_id = $_GPC['f_id'];
    pdo_update("hyb_o2o_userfenxiao",array("f_style"=>"审核通过"),array("f_id"=>$f_id));
    message('审核成功',$this->createWebUrl('fxlist',array()),'success');
}
if($op=='delete'){
     $f_id = $_GPC['f_id'];
     $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$f_id));
     $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$info['f_openid']));
     pdo_update("hyb_o2o_userinfo",array("u_fenxiao"=>"0"),array("u_id"=>$user['u_id']));
     pdo_delete('hyb_o2o_userfenxiao',array('f_id'=>$f_id));
     message('删除成功',$this->createWebUrl('fxlist',array()),'success');
}
if (checksubmit("submit2")) {
  $f_id = $_GPC['f_id'];
  $reply = $_GPC['reply'];
  $fenxiao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid,":f_id"=>$f_id));
  $f_money = $fenxiao['f_money']+$reply;
  pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$f_money),array("f_id"=>$f_id));
  message('充值成功',$this->createWebUrl('fxlist',array()),'success');
}
include $this->template('web/fxlist');