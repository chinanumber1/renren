<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"";
$uniacid = $_W['uniacid'];
$item = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_mendian")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
$shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
if(!empty($item)){
    $item['thumbs'] = unserialize($item['thumbs']);
    $item['address'] = explode("-",$item['address']);
    $item['yingyetime'] = explode("-",$item['yingyetime']);
    $item['baozhang'] = unserialize($item['baozhang']);
    //查询openid
    $openid = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_shangjia=0 or u_shangjia=:u_shangjia and u_yuangong=0",array(":uniacid"=>$uniacid,":u_shangjia"=>$shangjia['s_id']));
    foreach ($openid as &$value) {
        $value['u_name'] = json_decode($value['u_name']); 
    }
}else{
   //查询openid
    $openid = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_shangjia=0 and u_yuangong=0",array(":uniacid"=>$uniacid));
    foreach ($openid as &$value) {
        $value['u_name'] = json_decode($value['u_name']); 
    } 
}




if (checksubmit("submit")) {
    $yingyetime = $_GPC['time']."-".$_GPC['time2'];
    $address = $_GPC['province']."-".$_GPC['city']."-".$_GPC['district'];
    $baozhang = serialize($_GPC['baozhang']);
    $data = array("uniacid"=>$uniacid,"name"=>$_GPC['name'],"openid"=>$_GPC['openid'],"thumb"=>$_GPC['thumb'],"thumbs"=>serialize($_GPC['thumbs']),"content"=>$_GPC['content'],"xaddress"=>$_GPC['xaddress'],"address"=>$address,"latitude"=>$_GPC['latitude'],"longitude"=>$_GPC['longitude'],"telphone"=>$_GPC['telphone'],"fuzeren"=>$_GPC['fuzeren'],"yingyetime"=>$yingyetime,"fuwustyle"=>"全部","baozhang"=>$baozhang);

    $time ="3000-12-30 00:00:00";
    $datas = array(
      "uniacid"=>$uniacid,
      "s_name"=>$_GPC['name'],
      "s_u_name"=>$_GPC['fuzeren'],
      "s_u_openid"=>$_GPC['openid'],
      "s_telphone"=>$_GPC['telphone'],
      "s_content"=>$_GPC['content'],
      "s_type"=>"全部",
      "s_yingyetime"=>$yingyetime,
      "s_address"=>$address,
      "s_xxaddress"=>$_GPC['xaddress'],
      "jing"=>$_GPC['longitude'],
      "wei"=>$_GPC['latitude'],
      "s_thumb"=>$_GPC['thumb'],
      "s_imgpath"=>serialize($_GPC['thumbs']),
      "s_status"=>"审核通过",
      "s_tuijian"=>"是",
      "pingtai"=>"1",
      "ruzhu_endtime"=>$time,
      "baozhang"=>$baozhang,
      // "fwfw"=>$_GPC['fwfw']
    );
    if (empty($item)) {
        // $data["fwfw"]=$_GPC['fwfw'];
        pdo_insert("hyb_o2o_mendian",$data);
        pdo_insert("hyb_o2o_shangjia",$datas);
        $id = pdo_insertid();
        pdo_update("hyb_o2o_userinfo",array("u_shangjia"=>$id,"u_yuangong"=>"0"),array("uniacid"=>$uniacid,"openid"=>$_GPC['openid']));
        message('添加成功！', $this->createWebUrl('store'), 'success');       
    }else{
        $data["fwfw"]=$_GPC['fwfw'];

        pdo_update("hyb_o2o_mendian",$data,array("id"=>$item['id']));
        if (!empty($shangjia)) {
            pdo_update("hyb_o2o_shangjia",$datas,array("s_id"=>$shangjia['s_id']));
            pdo_update("hyb_o2o_userinfo",array("u_shangjia"=>$shangjia['s_id'],"u_yuangong"=>"0"),array("uniacid"=>$uniacid,"openid"=>$_GPC['openid']));
            
        }else{
            pdo_insert("hyb_o2o_shangjia",$datas);
            $id = pdo_insertid();
            pdo_update("hyb_o2o_userinfo",array("u_shangjia"=>$id,"u_yuangong"=>"0"),array("uniacid"=>$uniacid,"openid"=>$_GPC['openid']));
        }
        $user = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_shangjia=:u_shangjia and openid!=:openid",array(":uniacid"=>$uniacid,":u_shangjia"=>$shangjia['s_id'],":openid"=>$_GPC['openid']));
        if (!empty($user)) {
            foreach ($user as &$value) {
                 pdo_update("hyb_o2o_userinfo",array("u_shangjia"=>"0"),array("u_id"=>$value['u_id']));
            }     
        }
        
        message('修改成功！', $this->createWebUrl('store'), 'success');

    }
}


if ($op == "SelectUser") {
    $keywords = $_GPC['keywords'];
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
    echo json_encode($list);
}else{
  include $this->template('web/store');
}
