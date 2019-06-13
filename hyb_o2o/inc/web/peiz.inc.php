<?php
global $_GPC, $_W;
$uniacid = $_W["uniacid"];
$GLOBALS['frames'] = $this->getMainMenu();
$item = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_parment")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
if(checksubmit('submit')){
    $data = array("uniacid"=>$uniacid,"appid"=>$_GPC['appid'],"appsecret"=>$_GPC['appsecret'],"mchid"=>$_GPC['mchid'],"wxkey"=>$_GPC['wxkey']);
    if (empty($item)) {
        pdo_insert("hyb_o2o_parment",$data);
        message("添加成功!",$this->createWebUrl("peiz"),"success");
    }else{
        pdo_update("hyb_o2o_parment",$data,array("id"=>$item['id']));
        message("修改成功!",$this->createWebUrl("peiz"),"success");
    }          
}
include $this->template('web/peiz');