<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$uniacid = $_W['uniacid'];
$keywords = !empty($_GPC['keywords'])?$_GPC['keywords']:"";
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
if (empty($keywords)) {
$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid limit ".($pageindex - 1) * $pagesize.",".$pagesize,array(":uniacid"=>$uniacid));
$total=pdo_fetchcolumn("SELECT count(*) FROM " . tablename("hyb_o2o_userinfo") ." WHERE uniacid=:uniacid",array(':uniacid'=>$uniacid));
$pager = pagination($total, $pageindex, $pagesize);
foreach ($list as &$value) {
   $value['u_name'] = json_decode($value['u_name']);
}
}else{

$list = [];
$lists = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid",array(":uniacid"=>$uniacid));

foreach ($lists as &$values) {
      $values['u_name'] = json_decode($values['u_name']);
}
foreach ($lists as &$valuess) {
      if (strpos($valuess['u_name'],$keywords)!==false) {
         $list[] = $valuess;
      }
}
$total=count($list);
$pager = pagination($total, $pageindex, $pagesize);
}



if(checksubmit('submit2')){
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$_GPC['id2']));
      $u_money = $user['u_money']+$_GPC['reply'];
      // var_dump($u_money);exit();
      pdo_update('hyb_o2o_userinfo',array('u_money'=>$u_money),array('u_id'=>$user['u_id']));
      message('充值成功！', $this->createWebUrl('user'), 'success');
}
if(checksubmit('submit3')){
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$_GPC['id3']));
      $u_jifen = $user['u_jifen']+$_GPC['reply'];
       $res=pdo_update('hyb_o2o_userinfo',array('u_jifen'=>$u_jifen),array('u_id'=>$user['u_id']));
      message('充值成功！', $this->createWebUrl('user'), 'success');
}
if ($op == "save") {
  $u_id = $_GPC['u_id'];
  $data = array("u_type"=>"0","u_typeendtime"=>"");
  pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$u_id));
  message('修改成功！', $this->createWebUrl('user'), 'success');
}
if ($op == "delete") {
   $u_id = $_GPC['u_id'];
   $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$u_id));
   if (!empty($user['u_shangjia'])) {
      $res = pdo_delete("hyb_o2o_shangjia",array("s_id"=>$user['u_shangjia']));
   }
   if (!empty($user['u_yuangong'])) {
      $res = pdo_delete("hyb_o2o_yuangong",array("y_id"=>$user['u_yuangong']));
   }
    pdo_delete("hyb_o2o_userinfo",array("u_id"=>$u_id));
   
   message('删除成功！', $this->createWebUrl('user'), 'success');
}
include $this->template('web/user');