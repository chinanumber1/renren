<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
$fa_style = !empty($_GPC['fa_style'])?$_GPC['fa_style']:"待审核";
$uniacid = $_W['uniacid'];
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
if ($fa_style=="全部") {
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")."  WHERE uniacid=:uniacid order by fa_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
}else{
	$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")."  WHERE uniacid=:uniacid and fa_style=:fa_style order by fa_time desc  limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid,":fa_style"=>$fa_style));
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_style=:fa_style",array(":uniacid"=>$uniacid,":fa_style"=>$fa_style));
}

if (!empty($products)) {
	foreach ($products as &$value) {
		$user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$value['fa_openid']));
		$value['u_name'] = json_decode($user['u_name']);
		if (strpos($user['u_thumb'],"https")===false) {
			$value['u_thumb'] = $_W['attachurl'].$user['u_thumb'];
		}else{
			$value['u_thumb'] = $user['u_thumb'];
		}
		
	}
}	

$pager = pagination($count, $pindex, $psize);

if($op == "shenhesave"){
	$fa_id = $_GPC['fa_id'];
	$fa_style = $_GPC['fa_style'];
	if ($fa_style=="派单中") {
	  $pd = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." as f left join ".tablename("hyb_o2o_userinfo")." as u on f.fa_openid=u.openid  where f.uniacid=:uniacid and f.fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
	  $region = $pd['fa_dizhi'];
	  //查询匹配商家
      $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_address like '%$region%' ",array(":uniacid"=>$uniacid));

      //查询匹配技师
      $jishi  = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_rz=1",array(":uniacid"=>$uniacid));

      foreach ($jishi as &$valuess) {
      	 $valuess['y_jineng'] = unserialize($valuess['y_jineng']);
      }
      foreach ($jishi as $key => $valuesss) {
       if (!in_array($pd['fa_fwstyle2'],$jishi[$key]['y_jineng'])) {
       	 unset($jishi[$key]);
       }
      }
      require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
      $params = array ();
      $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
      $accessKeyId = $aliduanxin['accessKeyId'];
      $accessKeySecret = $aliduanxin['accessKeySecret'];
      $params["SignName"] = $aliduanxin['SignName'];
      $params["TemplateCode"] = $aliduanxin['fdtz'];
      foreach ($shangjia as &$value) {
          $params["PhoneNumbers"] = $value['s_telphone'];         //接收人手机号
          $params['TemplateParam'] = Array (
		        'name'=>$value['s_name'],
		        "product"=>"sms"
		    );
          if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"]);
          }
          $helper = new SignatureHelper();
          $content = $helper->request(
          $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
      }

      $paramsss["SignName"] = $aliduanxin['SignName'];
      $paramsss["TemplateCode"] = $aliduanxin['fdtz'];
      foreach ($jishi as &$values) {
          $paramsss["PhoneNumbers"] = $values['y_telphone'];         //接收人手机号
          $paramsss['TemplateParam'] = Array (
		        'name'=>$values['y_name'],
		        "product"=>"sms"
		    );
          if(!empty($paramsss["TemplateParam"]) && is_array($paramsss["TemplateParam"])) {
            $paramsss["TemplateParam"] = json_encode($paramsss["TemplateParam"]);
          }
          $helper = new SignatureHelper();
          $content = $helper->request(
          $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($paramsss, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
      }


       	$paramss["SignName"] = $aliduanxin['SignName'];
      	$faname = json_decode($pd['u_name']);
		$paramss["TemplateCode"] = $aliduanxin['fdtzsh'];
		$paramss["PhoneNumbers"] = $pd['fa_fwtelphone'];         //接收人手机号
        $paramss['TemplateParam'] = Array (
		        'name'=>$faname,
		        "time"=>$pd['fa_time'],
		        "content"=>$pd['fa_fwname'],
		        "product"=>"sms"
		    );
         if(!empty($paramss["TemplateParam"]) && is_array($paramss["TemplateParam"])) {
            $paramss["TemplateParam"] = json_encode($paramss["TemplateParam"]);
          }
          $helper = new SignatureHelper();
          $content = $helper->request(
          $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($paramss, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
		$data = array("fa_style"=>$fa_style);
		$res = pdo_update("hyb_o2o_fadan",$data,array("fa_id"=>$fa_id));
		message("审核通过!",$this->createWeburl("qiangdan",array("op"=>"display")),"success");
	}
	if ($fa_style=="已拒绝") {
		$data = array("fa_style"=>$fa_style);
		$res = pdo_update("hyb_o2o_fadan",$data,array("fa_id"=>$fa_id));
		message("审核拒绝!",$this->createWeburl("qiangdan",array("op"=>"display")),"success");
	}
	if ($fa_style=="已接单") {
		//查询派单【验证是否被接单】
		$pd = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." as f left join ".tablename("hyb_o2o_userinfo")." as u on f.fa_openid=u.openid where f.uniacid=:uniacid and f.fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
		if($pd['fa_style']!='已接单'){
			//查询平台所属商家
			$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
		
			require_once dirname(__FILE__) .'/../func/SignatureHelper.php';
		    $params = array ();
		    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
		    $accessKeyId = $aliduanxin['accessKeyId'];
		    $accessKeySecret = $aliduanxin['accessKeySecret'];
		    $params["PhoneNumbers"] = $pd['fa_fwtelphone'];         //接收人手机号
		    $params["SignName"] = $aliduanxin['SignName'];
		    $params["TemplateCode"] = $aliduanxin['qdtzyh'];
            $fname = json_decode($info['u_name']);
            $fname = json_decode($pd['u_name']);
            $params['TemplateParam'] = Array (
                'name'=>$fname,
                'content'=>$pd['fa_fwname'],
                'shop'=>$ptsj['s_name'],
                "product"=>"sms"
            );
		    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
		        $params["TemplateParam"] = json_encode($params["TemplateParam"]);
		    }
		    $helper = new SignatureHelper();
		    $content = $helper->request(
		        $accessKeyId,
		        $accessKeySecret,
		        "dysmsapi.aliyuncs.com",
		        array_merge($params, array(
		            "RegionId" => "cn-hangzhou",
		            "Action" => "SendSms",
		            "Version" => "2017-05-25",
		        ))
		    );
		    if(empty($ptsj)){
				message("请前往门店设置信息",$this->createWeburl("store"),"success");
			}else{
				$res = pdo_update("hyb_o2o_fadan",array("fa_style"=>"已接单"),array("fa_id"=>$fa_id));
				$datas = array("uniacid"=>$uniacid,"q_openid"=>$ptsj['s_u_openid'],"q_dname"=>$fa_id,"q_time"=>date("Y-m-d H:i:s",time()),"q_types"=>"门店","q_styles"=>"未指派");
				$save = pdo_insert("hyb_o2o_qiangdan",$datas);
				message("已接单",$this->createWeburl("qiangdan",array("op"=>"daijiedan")),"success");
			}
		}else{
			message("已被接单",$this->createWeburl("qiangdan",array("op"=>"daijiedan")),"success");
		}	
	}
	
	
}

//查询接单信息
if ($op=="jieinfo") {
$fa_id = $_GPC['fa_id'];
$fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id ",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
$jiedan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$fadan['fa_id']));
if ($jiedan['q_types']=="商家") {
	if (empty($jiedan['q_openid'])) {
		$ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
		$info['s_name'] = $ptsj['s_name'];
		$info['s_telphone'] = $ptsj['s_telphone'];
	}else{
		$rzsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$jiedan['q_openid']));
		$info['s_name'] = $rzsj['s_name'];
		$info['s_telphone'] = $rzsj['s_telphone'];
	}
	if ($jiedan['q_styles']=="未指派") {
		$info['y_name'] = "未指派";
		$info['y_telphone'] = "无";
	}else{
		//查询服务员工
		$yuanggong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$jiedan['q_pdname']));
		$info['y_name'] = $yuanggong['y_name']."[商家指派]";
		$info['y_telphone'] = $yuanggong['y_telphone'];
	}
	
}
if ($jiedan['q_types']=="员工") {
	//查询服务员工
	$yuanggong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$jiedan['q_openid']));
	$info['y_name'] = $yuanggong['y_name']."[自主抢单]";
	$info['y_telphone'] = $yuanggong['y_telphone'];
	//查询员工所属商家
	$sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$yuanggong['y_sjname']));
	$info['s_name'] = $sj['s_name'];
	$info['s_telphone'] = $sj['s_telphone'];
}


}
if ($op == "delete") {
	$fa_id = $_GPC['fa_id'];
	$jiedan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$fa_id));
	pdo_delete("hyb_o2o_fadan",array("fa_id"=>$fa_id));
	pdo_delete("hyb_o2o_qiangdan",array("q_id"=>$jiedan['q_id']));
	
	message("删除成功!",$this->createWeburl("qiangdan",array("op"=>"display")),"success");
}
if ($op!="jieinfo") {
include $this->template('web/qiangdan');
}else{
	$data = '<div class="detail_box">
    <div style="text-align: left">
        <div><span class="left">服务员工:</span>'.$info['y_name'].'</div>
        <div><span class="left">联系方式:</span>'.$info['y_telphone'].'</div>
        <div><span class="left">所属商家:</span>'.$info['s_name'].'</div>
        <div><span class="left">联系商家:</span>'.$info['s_telphone'].'</div>
    </div>
    <button class="btn btn-primary close_box" style="width: 200px;background: #3c9be1;border-color: #3c9be1">关闭</button>
</div>
<div class="modals"></div>';
	echo json_encode(array('d'=>$data));
}