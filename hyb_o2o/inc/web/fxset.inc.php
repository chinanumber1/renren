<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$item= pdo_fetch("SELECT * from ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
if (!empty($item)) {
    $item['fzthumb'] = unserialize($item['fzthumb']);
    $item['sfthumb'] = unserialize($item['sfthumb']);
}
    if(checksubmit('submit')){
        $data = array(
                "uniacid"=>$uniacid,
                "is_open"=>$_GPC['is_open'],
                "is_ej"=>$_GPC['is_ej'],
                "fzthumb"=>serialize($_GPC['fzthumb']),
                "fxthumb"=>$_GPC['fxthumb'],
                "sfthumb"=>serialize($_GPC['sfthumb']),
                "y_moneyyi"=>$_GPC['y_moneyyi'],
                "y_moneyer"=>$_GPC['y_moneyer'],
                "tx_money"=>$_GPC['tx_money'],
                "tx_rate"=>$_GPC['tx_rate'],
                "fx_details"=>$_GPC['fx_details'],
                "tx_details"=>$_GPC['tx_details'],
                "instructions"=>$_GPC['instructions'],
            );
        // var_dump($data);exit();
            if(empty($item)){                
                $res=pdo_insert('hyb_o2o_fenxiao',$data);
                 message('添加成功',$this->createWebUrl('fxset',array()),'success');
            }else{
                pdo_update('hyb_o2o_fenxiao', $data, array('id' => $item['id']));
                message('编辑成功',$this->createWebUrl('fxset',array()),'success');
                
            }
        }
include $this->template('web/fxset');