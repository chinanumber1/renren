<?php
global $_GPC, $_W;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
if ($op=="display") {
    $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jishiset")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
}

if ($op=="post") {
    $r_id = $_GPC['r_id'];
    $items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jishiset")." where uniacid=:uniacid and r_id=:r_id",array(":uniacid"=>$uniacid,":r_id"=>$r_id));
    if (checksubmit("submit")) {
        $data = array("uniacid"=>$uniacid,"r_time"=>$_GPC['r_time'],"r_money"=>$_GPC['r_money']);
        if (empty($r_id)) {
            pdo_insert("hyb_o2o_jishiset",$data);
            message("添加成功!",$this->createWebUrl("storejishirz",array("op"=>"display")),"success");
        }else{
            pdo_update("hyb_o2o_jishiset",$data,array("r_id"=>$r_id));
            message("修改成功!",$this->createWebUrl("storejishirz",array("op"=>"display")),"success");
        }
    }
}
if($op == "delete")
{
    $r_id = $_GPC['r_id'];
    pdo_delete("hyb_o2o_jishiset",array("r_id"=>$r_id));
    message("删除成功!",$this->createWebUrl("storejishirz",array("op"=>"display")),"success");
}
include $this->template('web/storejishirz');