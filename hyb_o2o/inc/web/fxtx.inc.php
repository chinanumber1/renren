<?php
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=empty($_GPC['type']) ? 'wait' :$_GPC['type'];
$state=empty($_GPC['state']) ? '1' :$_GPC['state'];

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$keywords = $_GPC['keywords'];
if (empty($keywords)) {
    if ($type=="wait") {
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_status=:t_status order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"待审核"));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_status=:t_status order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"待审核"));
        $pager = pagination($total, $pageindex, $pagesize);
    }
    if ($type=="now") {
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_status=:t_status order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已提现"));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_status=:t_status order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已提现"));
        $pager = pagination($total, $pageindex, $pagesize);
    }
    if($type=="delivery"){
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_status=:t_status order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已拒绝"));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_status=:t_status order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已拒绝"));
        $pager = pagination($total, $pageindex, $pagesize);
    }
    if ($type=="all") {
       $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid  order by t_time desc ",array(":uniacid"=>$uniacid));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid  order by t_time desc ",array(":uniacid"=>$uniacid));
        $pager = pagination($total, $pageindex, $pagesize);
    }
}else{
   if ($type=="wait") {
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_status=:t_status and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"待审核"));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_status=:t_status and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"待审核"));
        $pager = pagination($total, $pageindex, $pagesize);
    }
    if ($type=="now") {
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_status=:t_status and t_name like '%$keywords%'order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已提现"));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_status=:t_status and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已提现"));
        $pager = pagination($total, $pageindex, $pagesize);
    }
    if($type=="delivery"){
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_status=:t_status and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已拒绝"));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_status=:t_status and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid,":t_status"=>"已拒绝"));
        $pager = pagination($total, $pageindex, $pagesize);
    }
    if ($type=="all") {
       $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid));
        $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('hyb_o2o_fenxiaotixian')." where uniacid=:uniacid and t_name like '%$keywords%' order by t_time desc ",array(":uniacid"=>$uniacid));
        $pager = pagination($total, $pageindex, $pagesize);
    } 
}

if($op=='adopt'){
    include 'wxtx.php';
    $t_id=$_GPC['t_id'];        
    $tixian = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_id=:t_id",array(":uniacid"=>$uniacid,":t_id"=>$t_id));
    //查询支付设置
    $key = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_parment")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    $appid = $key['appid'];   //微信公众平台的appid
    $mch_id = $key['mchid'];  //商户号id
    $openid = $tixian['t_fopenid'];    //用户openid
    $amount = intval($tixian['t_money'] * 100);   //提现金额$money
    $desc = "帐户提现";     //企业付款描述信息
    $appkey = $key['wxkey'];   //商户号支付密钥
    $re_user_name = $tixian['t_name'];   //收款用户姓名
    // $data = array("appid"=>$appid,"mch_id"=>$mch_id,"openid"=>$openid,"amount"=>$amount,"desc"=>$desc,"appkey"=>$appkey,"re_user_name"=>$re_user_name);
    // var_dump($data);exit();
    $Weixintx = new WeixinTx($appid,$mch_id,$openid,$amount,$desc,$appkey,$re_user_name);
    $notify_url = $Weixintx->tixian();
    if ($notify_url['return_code']=="SUCCESS" && $notify_url['result_code']=="SUCCESS") {
        $type = "已提现";
        $data = array("t_status"=>$type);
        $res = pdo_update("hyb_o2o_fenxiaotixian",$data,array("t_id"=>$t_id));
        message("提现成功!",$this->createWeburl("fxtx",array()),"success");
    }
    else 
    {
       message($notify_url['err_code_des'],$this->createWeburl("fxtx",array()),"success");;
    }     
}

if($op=='reject'){
    $t_id=$_GPC['t_id']; 
    $tixian = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_id=:t_id",array(":uniacid"=>$uniacid,":t_id"=>$t_id));
    if ($tixian['t_type']=="1") {
        $money = $tixian['t_money']+$tixian['t_shouxufei'];
    }else if ($tixian['t_type']=="2"){
        $money = $tixian['t_money'];
    }
    $fenxiao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_id"=>$tixian['t_fid'],":f_openid"=>$tixian['t_fopenid']));
    $u_money = $fenxiao['f_money']+$money;
    pdo_update('hyb_o2o_userfenxiao',array('f_money'=>$u_money),array('f_id'=>$fenxiao['f_id']));
    pdo_update("hyb_o2o_fenxiaotixian",array("t_status"=>"已拒绝"),array("t_id"=>$t_id));
    message('拒绝成功',$this->createWebUrl('fxtx',array()),'success');
}
if($op=='delete'){
     $t_id=$_GPC['t_id'];
     $tixian = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_id=:t_id",array(":uniacid"=>$uniacid,":t_id"=>$t_id));
     if ($tixian['t_status']=="待审核") {
        if ($tixian['t_type']=="1") {
            $money = $tixian['t_money']+$tixian['t_shouxufei'];
        }else if ($tixian['t_type']=="2"){
            $money = $tixian['t_money'];
        }
        $fenxiao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_id"=>$tixian['t_fid'],":f_openid"=>$tixian['t_fopenid']));
        $u_money = $fenxiao['f_money']+$money;
        pdo_update('hyb_o2o_userfenxiao',array('f_money'=>$u_money),array('f_id'=>$fenxiao['f_id']));
        pdo_delete("hyb_o2o_fenxiaotixian",array("t_id"=>$t_id));
        message('删除成功',$this->createWebUrl('fxtx',array()),'success');
     }else{
        pdo_delete("hyb_o2o_fenxiaotixian",array("t_id"=>$t_id));
        message('删除成功',$this->createWebUrl('fxtx',array()),'success');
     }
}

include $this->template('web/fxtx');