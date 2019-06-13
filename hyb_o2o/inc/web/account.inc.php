<?php
global $_GPC, $_W;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
if ($op=="display") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." WHERE uniacid=:uniacid limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
    if (!empty($list)) {
        foreach ($list as &$value) {
            $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$value['z_shangjia']));
            $value['shangjia'] = $shangjia['s_name'];
        }  
    }
    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_zhanghao")."  where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    $pager = pagination($count, $pindex, $psize);
}
if ($op == 'delete') {
    $z_id = intval($_GPC['z_id']);
    pdo_delete('hyb_o2o_zhanghao', array('z_id' => $z_id));
    message('删除成功！', $this->createWebUrl('account', array()), 'success');
}
include $this->template('web/account');