<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$item = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
if(checksubmit('submit')){
    $data = array("uniacid"=>$uniacid,"xufei"=>trim($_GPC['xufei']),"chongzhi"=>trim($_GPC['chongzhi']),"fuwudj"=>trim($_GPC['fuwudj']),"fuwuzf"=>$_GPC['fuwuzf'],"spzf"=>trim($_GPC['spzf']),"ygsh"=>trim($_GPC['ygsh']),"jfdh"=>trim($_GPC['jfdh']));
    if (empty($item)) {
        pdo_insert("hyb_o2o_tongzhi",$data);
        message('添加成功',$this->createWebUrl('template',array()),'success');
    }else{
        pdo_update("hyb_o2o_tongzhi",$data,array("id"=>$item['id']));
        message('编辑成功',$this->createWebUrl('template',array()),'success');
    }
}
include $this->template('web/template');