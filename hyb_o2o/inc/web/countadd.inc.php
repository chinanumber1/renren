<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid']; 
$stores = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=0",array(":uniacid"=>$uniacid));
$z_id = $_GPC['z_id'];
$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." WHERE uniacid=:uniacid and z_id=:z_id",array(":uniacid"=>$uniacid,":z_id"=>$z_id));
if (checksubmit("submit")) {
    $data = array("uniacid"=>$uniacid,"zhanghao"=>$_GPC['zhanghao'],"mima"=>$_GPC['mima'],"z_shangjia"=>$_GPC['z_shangjia'],"status"=>$_GPC['status']);
    if (empty($_GPC['zhanghao'])) {
        message('请输入登录账号', $this->createWebUrl('countadd', array()),"success");
    }
    if (empty($_GPC['mima'])) {
        message('请输入登录密码', $this->createWebUrl('countadd', array()),"success");
    }
    if (empty($_GPC['z_shangjia'])) {
        message('请选择管理门店', $this->createWebUrl('countadd', array()),"success");
    }
   
    $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." WHERE uniacid=:uniacid and zhanghao=:zhanghao",array(":uniacid"=>$uniacid,":zhanghao"=>$_GPC['zhanghao']));
    $infos = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." WHERE uniacid=:uniacid and z_shangjia=:z_shangjia",array(":uniacid"=>$uniacid,":z_shangjia"=>$_GPC['z_shangjia']));
    if (empty($z_id)) {
        if (empty($infos) && empty($info)) {
            pdo_insert("hyb_o2o_zhanghao",$data);
            message('添加成功', $this->createWebUrl('account', array()),"success");
        }elseif (!empty($infos) && empty($info)) {
            message('非常抱歉，此门店已经存在账号，你需要更换注册门店！',$this->createWebUrl("countadd",array()),"success");      
        }elseif (!empty($info) && empty($infos)) {
            message('非常抱歉，此账号已存在，你需要更换账号！',$this->createWebUrl("countadd",array()),"success"); 
        }
    }
    else{
        $infoss = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." WHERE uniacid=:uniacid and z_id=:z_id",array(":uniacid"=>$uniacid,":z_id"=>$_GPC['z_id']));
        if ($infoss['z_shangjia']==$_GPC['z_shangjia']) { 
            if (empty($info)) {
               pdo_update("hyb_o2o_zhanghao",$data,array("z_id"=>$z_id));
               message('修改成功！', $this->createWebUrl('account', array()),"success"); 
            }else{
               message('非常抱歉，此账号已存在，你需要更换账号！',$this->createWebUrl("countadd",array()),"success");  
            }
            
        }else{
            if (empty($infos) && empty($info)) {
                pdo_update("hyb_o2o_zhanghao",$data,array("z_id"=>$z_id));
               message('修改成功！', $this->createWebUrl('account', array()),"success"); 
            }elseif (!empty($infos) && empty($info)) {
                message('非常抱歉，此门店已经存在账号，你需要更换注册门店！',$this->createWebUrl("countadd",array()),"success");      
            }elseif (!empty($info) && empty($infos)) {
                message('非常抱歉，此账号已存在，你需要更换账号！',$this->createWebUrl("countadd",array()),"success"); 
            }
        }     
    }
}
include $this->template('web/countadd');