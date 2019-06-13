<?php
/**
 * 派单o2o模块小程序接口定义
 * 版权归山西网博思创网络科技有限公司所有
 * https://www.webStrongtech.net
 * 作者 陌笙
**/
defined('IN_IA') or exit('Access Denied');
class Hyb_o2oModuleWxapp extends WeModuleWxapp {
    private function send_post($url, $post_data,$method='POST') {
      $postdata = http_build_query($post_data);
      $options = array(
        'http' => array(
          'method' => $method, //or GET
          'header' => 'Content-type:application/x-www-form-urlencoded',
          'content' => $postdata,
          'timeout' => 15 * 60 // 超时时间（单位:s）
        )
      );
      $context = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      return $result;
    }
    private function https_curl_json($url,$data,$type){
        if($type=='json'){
            $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
            $data=json_encode($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);
        return $output;
    }


  private function api_notice_increment($url, $data){
    $ch = curl_init();
    // $header = "Accept-Charset: utf-8";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
      return false;
    }else{
      return $tmpInfo;
    }
  }
    //获取用户信息
    public function doPageTyMember() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $item['u_name'] = json_encode($_REQUEST['u_name']);
        $item['u_thumb'] = $_REQUEST['u_thumb'];
        $item['uniacid'] = $uniacid;
        //查询用户信息
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and  openid=:openid ",array(":openid"=>$openid,":uniacid"=>$uniacid));
        // var_dump($_REQUEST['u_name']);exit();
        $res = pdo_update('hyb_o2o_userinfo', $item, array('u_id' => $user['u_id']));
        $message = 'success';
        $errno = 0;
        return $this->result($errno, $message, $item);
    }
    public function doPageGetUid() {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where `uniacid`='{$uniacid}'");
        $APPID = $result['appid'];
        $SECRET = $result['appsecret'];
        $code = trim($_REQUEST['code']);
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$APPID}&secret={$SECRET}&js_code={$code}&grant_type=authorization_code";
        $data['userinfo'] = json_decode($this->httpGet($url));
        $openid = $data['userinfo']->openid;
        $item['uniacid'] = $uniacid;
        $item['openid'] = $openid;
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        if (empty($user)) {
            pdo_insert('hyb_o2o_userinfo', $item);
        }
        $data['openid'] =$openid;
        $message = '返回消息';
        $errno = 0;
        return $this->result($errno, $message, $data);
    }
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    //查询基本信息
    public function doPageBase()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $list['thumb'] = unserialize($list['thumb']);
        foreach ($list['thumb'] as &$value) {
            $value = $_W['attachurl'].$value;
        }
        return $this->result(0,"success",$list);
    }
    //查询门店信息
    public function doPageMendian()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_mendian")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        //查询是否开启分销商
        $fx = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        if (!empty($fx)) {
          if ($fx['is_open']=="1") { 
            $list['fx'] = true;
          }elseif ($fx['is_open']=="2") {
            $list['fx'] = false;
          }
        }else{
          $list['fx'] = false;
        }
        return $this->result(0,"success",$list);
    }

    //查询热门城市
    public function doPageRemencity()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and tuijian=1 and parentid=0",array(":uniacid"=>$uniacid));
          return $this->result(0,"success",$list);
    }
    //查询全部城市
    public function doPageQuanbucity()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=0",array(":uniacid"=>$uniacid));
          $list = $this->groupByInitials($list, 'name');
          return $this->result(0,"success",$list);
    }
    /*
        城市首字母大写分组
    */

    public function groupByInitials(array $data, $targetKey = 'name')
    {
        $data = array_map(function ($item) use ($targetKey) {
            return array_merge($item, [
                'initials' => $this->getInitials($item[$targetKey]),
            ]);
        }, $data);
        $data = $this->sortInitials($data);
        return $data;
    }

    /**
     * 按字母排序
     * @param  array  $data
     * @return array
     */
    public function sortInitials(array $data)
    {
        $sortData = [];
        foreach ($data as $key => $value) {
            $sortData[$value['initials']][] = $value;
        }
        ksort($sortData);
        return $sortData;
    }
    
    /**
     * 获取首字母
     * @param  string $str 汉字字符串
     * @return string 首字母
     */
    public function getInitials($str)
    {
        if (empty($str)) {return '';}
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str{0});
        }

        $s1  = iconv('UTF-8', 'gb2312', $str);
        $s2  = iconv('gb2312', 'UTF-8', $s1);
        $s   = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) {
            return 'A';
        }

        if ($asc >= -20283 && $asc <= -19776) {
            return 'B';
        }

        if ($asc >= -19775 && $asc <= -19219) {
            return 'C';
        }

        if ($asc >= -19218 && $asc <= -18711) {
            return 'D';
        }

        if ($asc >= -18710 && $asc <= -18527) {
            return 'E';
        }

        if ($asc >= -18526 && $asc <= -18240) {
            return 'F';
        }

        if ($asc >= -18239 && $asc <= -17923) {
            return 'G';
        }

        if ($asc >= -17922 && $asc <= -17418) {
            return 'H';
        }

        if ($asc >= -17417 && $asc <= -16475) {
            return 'J';
        }

        if ($asc >= -16474 && $asc <= -16213) {
            return 'K';
        }

        if ($asc >= -16212 && $asc <= -15641) {
            return 'L';
        }

        if ($asc >= -15640 && $asc <= -15166) {
            return 'M';
        }

        if ($asc >= -15165 && $asc <= -14923) {
            return 'N';
        }

        if ($asc >= -14922 && $asc <= -14915) {
            return 'O';
        }

        if ($asc >= -14914 && $asc <= -14631) {
            return 'P';
        }

        if ($asc >= -14630 && $asc <= -14150) {
            return 'Q';
        }

        if ($asc >= -14149 && $asc <= -14091) {
            return 'R';
        }

        if ($asc >= -14090 && $asc <= -13319) {
            return 'S';
        }

        if ($asc >= -13318 && $asc <= -12839) {
            return 'T';
        }

        if ($asc >= -12838 && $asc <= -12557) {
            return 'W';
        }

        if ($asc >= -12556 && $asc <= -11848) {
            return 'X';
        }

        if ($asc >= -11847 && $asc <= -11056) {
            return 'Y';
        }

        if ($asc >= -11055 && $asc <= -10247) {
            return 'Z';
        }

        return null;
    }



    //查询公告
    public function doPageGonggao()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_gonggao")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
      return $this->result(0,"success",$list);
    }

    public function doPageGonggaoxq(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $info = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_gonggao")." WHERE uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
        return $this->result(0,"success",$info);
    }

    //查询活动设置
    public function doPageHuodong()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_huodong")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
      foreach ($list as &$value) {
        $value['thumb'] = $_W['attachurl'].$value['thumb'];
      }
      return $this->result(0,"success",$list);
    }

    //查询用户信息
    public function doPageUser()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        $info['u_name'] = json_decode($info['u_name']);
        if (strpos($info['u_thumb'],"http")===false) {
          $info['u_thumb'] = $_W['attachurl'].$info['u_thumb'];
        }

        //查询分销商
        $fenxiao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." WHERE uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
        if (empty($fenxiao)) {
            $info['f_type']="0";
        }else{
            $info['f_type']=$fenxiao['f_type'];
        }

        //用户是否为商家 0:未申请成为商家  待审核:申请成为商家待审核 
        if ($info['u_shangjia']!="0") {   //代表入驻
            if ($info['u_shangjia']!="待审核") {
                //查询商家是否入驻到期
                $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
                if ($shangjia['ruzhu_endtime']=="已到期" || $shangjia['ruzhu_endtime']==date("Y-m-d H:i:s",time())) {
                    $info['u_shangjiaruzhu'] = "已到期";
                }
            }
        }

        //查询用户是否为员工
        if ($info['u_yuangong']!="0") {
            $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
            //查询员工所属商家是否为平台
            $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
            if ($pingtai['s_id']==$yuangong['y_sjname'] && $yuangong['y_rz']=='0') {
              $ptyg = "false";   //商家员工
            }elseif ($pingtai['s_id']==$yuangong['y_sjname'] && $yuangong['y_rz']=='1'){
              $ptyg = "true";   //商家技师
            }elseif ($pingtai['s_id']!=$yuangong['y_sjname'] && $yuangong['y_rz']=='0'){
              $ptyg = "false";   //商家技师
            }
            $info['ptyg'] = $ptyg;
            //查询员工接单数
            $count1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_pdname=:q_pdname",array(":uniacid"=>$uniacid,":q_pdname"=>$yuangong['y_id']));
            $count2 =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_openid=:q_openid",array(":uniacid"=>$uniacid,":q_openid"=>$yuangong['y_openid']));
            $count3 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_fwry=:o_fwry and o_store=:o_store",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_store"=>$yuangong['y_sjname']));
            $info['y_telphone'] = $yuangong['y_telphone'];
            if (strpos($yuangong['y_thumb'],"http")===false) {
              $info['y_thumb'] = $_W['attachurl'].$yuangong['y_thumb'];
            }else{
              $info['y_thumb'] = $yuangong['y_thumb'];
            }
            if (empty($yuangong['y_choucheng'])) {
                $yuangong['y_choucheng'] = "0";
            }
            $info['y_name'] = $yuangong['y_name'];
            $info['y_typs'] = $yuangong['y_typs'];
            $info['y_money'] = $yuangong['y_money'];
            $info['y_jiedannum'] = $count1+$count2+$count3;
            $info['y_choucheng'] = $yuangong['y_choucheng'];
        }

        //用户是否为会员
        if ($info['u_type']!="0" && $info['u_typeendtime']>date("Y-m-d H:i:s",time()) && $info['u_typeendtime']!="已到期") {
          $huiyuan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid and h_id=:h_id",array(":uniacid"=>$uniacid,":h_id"=>$info['u_type']));
          $info['huiyuan_name'] = $huiyuan['h_name'];
          $info['huiyuan_thumb'] = $_W['attachurl'].$huiyuan["h_thumb"];
        }
        if ($info['u_type']=="0") {
            $info['huiyuan_name'] = "普通用户";
        }

        if (empty($info['u_tel'])) {
            $info['bangding'] = "false";
        }else{
            $info['bangding'] = "true";
        }
        
        return $this->result(0,"success",$info);
    }

    //首页检索
    public function doPageJiansuo()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $values = $_REQUEST['value'];
      $city = $_REQUEST["city"];
      if (empty($city)) {
          $base = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
          $city = $base['city'];
      }
      //查询商家 
      $time = date("Y-m-d H:i:s",time());
      $shangjia = pdo_fetchall("SELECT s_id FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
      if (!empty($shangjia)) {
        $arr = [];
        foreach ($shangjia as &$value) {
          $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." as x left join ".tablename("hyb_o2o_shangjia")." as s on x.x_shangjia=s.s_id WHERE x.uniacid=:uniacid and x.x_shangjia=:x_shangjia  and x.x_name like '%".$values."%' ",array(":uniacid"=>$uniacid,":x_shangjia"=>$value['s_id']));
          if (!empty($xiangmu)) {
            foreach ($xiangmu as $key2 => $value2) {
              if (strpos($value2['x_thumb'],"http")===false){
                $value2['x_thumb'] = $_W['attachurl'].$value2['x_thumb'];

              }   
              $value2['label'] = unserialize($value2['label']);    
              $arr[]= $value2;
            }   
          } 
        }
        foreach($arr as $k=>$v){
          $xl=pdo_fetch("SELECT count(*) as xl FROM".tablename("hyb_o2o_orderfuwu")."where uniacid=:uniacid and o_xid=:o_xid and o_type in ('已完成','已付款')",array(":uniacid"=>$uniacid,":o_xid"=>$v['x_id']));
          $arr[$k]['xiaoliang']=$xl['xl'];
        }
      }else{
        $arr = [];
      }
      
      return $this->result(0,"success",$arr);

    }

    //查询首页服务分类
    public function doPageShowfwstyle()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0 and xt_tuijian=1 order by xt_ids desc ",array(":uniacid"=>$uniacid));
        foreach ($list as &$value) {
          $value['xt_thumb'] = $_W['attachurl'].$value['xt_thumb'];
        }
        return $this->result(0,"success",$list);
    }
    //查询首页全部分类
    public function doPageShowfuwustyle()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0 order by xt_ids desc ",array(":uniacid"=>$uniacid));
        if (!empty($list)) {
            foreach ($list as $key=>$value) {
              if (strpos($value['xt_thumb'],"http")===false) {
                  $list[$key]['xt_thumb'] = $_W['attachurl'].$value['xt_thumb'];
              }
              $erji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$value['xt_id']));
              if (!empty($erji)) {
                  foreach ($erji as &$values) {
                    if (strpos($values['xt_thumb'],"http")===false) {
                        $values['xt_thumb'] = $_W['attachurl'].$values['xt_thumb'];
                    }
                  }
                  $list[$key]['erji'] = $erji;
              }else{
                unset($list[$key]);
              }
              
            }
        }
        
        return $this->result(0,"success",$list);
    }

    //查询分类及服务
    public function doPageAllfuwu()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $city = $_REQUEST['city'];
      if (empty($city)) {
          //查询基本信息
          $base = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $city = $base['city'];
      }
      $time = date("Y-m-d H:i:s",time());
      //父级分类
      $xiangmutype = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0 order by xt_ids desc ",array(":uniacid"=>$uniacid));
      foreach ($xiangmutype as $key => $value) {
        //子分类
        $xiangmutypechild = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$value['xt_id']));
        //查询当前城市的商家
        $shangjia = pdo_fetchall("SELECT s_id FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
        //查询当前城市商家的项目
        $arr = [];
        foreach ($shangjia as $key2=>$value2) {
          $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." WHERE uniacid=:uniacid and x_shangjia=:x_shangjia and x_status=1",array(":uniacid"=>$uniacid,":x_shangjia"=>$value2['s_id']));
          foreach ($xiangmu as $key2 => $value2) {
            if(strpos($value2['x_thumb'],"http")===false){
              $value2['x_thumb'] = $_W['attachurl'].$value2['x_thumb'];
            }
            
            $arr[]= $value2;
          }
        } 
        foreach ($xiangmutypechild as $key4 => $value4) {
          $arrs = array();
          foreach ($arr as $key3 => $value3) {
            if ($value3['x_type']==$value4['xt_id']) {            
              $arrs[] = $value3;
            }
          }
          $xiangmutypechild[$key4]['xiangmu'] = $arrs;
        }
        $xiangmutype[$key]['children_type'] = $xiangmutypechild;   
      }
      
      return $this->result(0,"success",$xiangmutype);
    }

    //查询当前城市地区
    public function doPageDiqu()
    {
          global $_GPC,$_W;
          $uniacid = $_W['uniacid'];
          $city = $_REQUEST['city'];
          $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$city));
          $info = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=:parentid",array(":uniacid"=>$uniacid,":parentid"=>$list['id']));
          return $this->result(0,"success",$info);
    }
    //查询分类下的二级服务分类
    public function doPageFenlei()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $xt_id = $_REQUEST['xt_id'];
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xt_id));
          return $this->result(0,"success",$list);
    }

    //查询分类下的服务
    public function doPageXiangmu()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $xt_id = $_REQUEST['xt_id'];   //项目分类id
        $diqu = $_REQUEST['diqu'];    //地区
        $flname = $_REQUEST['flname'];   //分类
        $city = $_REQUEST["city"];       //城市
        $shaixuan = $_REQUEST['shaixuan'];    //筛选
        $parentid = $_REQUEST['parentid'];

        if (empty($city)) {
          //查询基本设置
          $base = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $city = $base['city'];
        }
        $time = date("Y-m-d H:i:s",time());
        if ($parentid=="0") {
            if (empty($diqu) && empty($flname) && empty($shaixuan)) {   //无筛选条件
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);

                //查询项目分类下二级分类
                $erji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xiangmutype['xt_id']));
                foreach ($erji as &$value1) {
                  $erji_id[] = $value1['xt_id'];
                }
                $erji_id = implode(",",$erji_id);
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type in ($erji_id) and x_shangjia in ($s_id) and x_status=1",array(":uniacid"=>$uniacid));  
              }else{
                $xiangmu = [];
              }
          
            }
            if (!empty($diqu) && empty($flname) && empty($shaixuan)) {   //筛选条件  地区
              $city = $city."-".$diqu;
                //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT s_id FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'  ",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);
                //查询项目分类下二级分类
                $erji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xiangmutype['xt_id']));
                foreach ($erji as &$value1) {
                  $erji_id[] = $value1['xt_id'];
                }
                $erji_id = implode(",",$erji_id);
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type in ($erji_id) and x_shangjia in ($s_id) and x_status=1",array(":uniacid"=>$uniacid));
              }else{
                $xiangmu = [];
              }
              
            }
            if (empty($diqu) && !empty($flname) && empty($shaixuan)) {  //筛选条件  分类
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id)); 
                //查询商家
              $shangjia = pdo_fetchall("SELECT s_id FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."' ",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);
                $xiangmutypes = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_name=:xt_name and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,"xt_name"=>$flname,":xt_parentid"=>$xiangmutype['xt_id']));
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id)  and x_status=1",array(":uniacid"=>$uniacid,":x_type"=>$xiangmutypes['xt_id']));
              }else{
                $xiangmu = [];
              }
              
              
            }
            if (empty($diqu) && empty($flname) && !empty($shaixuan)) {  //筛选条件  筛选
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);

                //查询项目分类下二级分类
                $erji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xiangmutype['xt_id']));
                foreach ($erji as &$value1) {
                  $erji_id[] = $value1['xt_id'];
                }
                $erji_id = implode(",",$erji_id);
                if ($shaixuan=="销量高") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type in ($erji_id) and x_shangjia in ($s_id) and x_status=1 order by x_xiaoliang desc ",array(":uniacid"=>$uniacid));
                }
                if ($shaixuan=="价格低") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type in ($erji_id) and x_shangjia in ($s_id) and x_status=1 order by x_jiage asc ",array(":uniacid"=>$uniacid));
                }
              }
              
            }
            if (!empty($diqu) && !empty($flname) && empty($shaixuan)) {   //筛选条件   地区 分类
              $city = $city."-".$diqu;
                //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT s_id FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'  ",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
                if (!empty($shangjia)) {
                  foreach ($shangjia as &$value) {
                    $s_id[]=$value['s_id'];
                  }
                  $s_id = implode(",",$s_id);

                  $xiangmutypes = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_name=:xt_name and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,"xt_name"=>$flname,":xt_parentid"=>$xiangmutype['xt_id']));
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1",array(":uniacid"=>$uniacid,":x_type"=>$xiangmutypes['xt_id']));
                }else{
                  $xiangmu = [];
                }
              
            }
            if (!empty($diqu) && empty($flname) && !empty($shaixuan)) {   //筛选条件   地区  筛选
              $city = $city."-".$diqu;
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);

                //查询项目分类下二级分类
                $erji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xiangmutype['xt_id']));
                foreach ($erji as &$value1) {
                  $erji_id[] = $value1['xt_id'];
                }
                $erji_id = implode(",",$erji_id);
                if ($shaixuan=="销量高") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type in ($erji_id) and x_shangjia in ($s_id) and x_status=1 order by x_xiaoliang desc ",array(":uniacid"=>$uniacid));
                }
                if ($shaixuan=="价格低") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type in ($erji_id) and x_shangjia in ($s_id) and x_status=1 order by x_jiage asc ",array(":uniacid"=>$uniacid));
                }
              }else{
                $xiangmu = [];
              }
              
            }
            if (empty($diqu) && !empty($flname) && !empty($shaixuan)) {  //筛选条件 分类 筛选
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);

                $xiangmutypes = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_name=:xt_name and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,"xt_name"=>$flname,":xt_parentid"=>$xiangmutype['xt_id']));
                if ($shaixuan=="销量高") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_xiaoliang desc ",array(":uniacid"=>$uniacid,":x_type"=>$xiangmutypes['xt_id']));
                }
                if ($shaixuan=="价格低") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_jiage asc ",array(":uniacid"=>$uniacid,":x_type"=>$xiangmutypes['xt_id']));
                }
              }else{
                $xiangmu = [];
              }
              
            }
            if (!empty($diqu) && !empty($flname) && !empty($shaixuan)) {  //筛选条件 地区 分类 筛选
              $city = $city."-".$diqu;
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$xt_id));
              //查询商家
              $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);

                $xiangmutypes = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_name=:xt_name and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,"xt_name"=>$flname,":xt_parentid"=>$xiangmutype['xt_id']));
                if ($shaixuan=="销量高") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_xiaoliang desc ",array(":uniacid"=>$uniacid,":x_type"=>$xiangmutypes['xt_id']));
                }
                if ($shaixuan=="价格低") {
                  //查询项目
                  $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_jiage asc ",array(":uniacid"=>$uniacid,":x_type"=>$xiangmutypes['xt_id']));
                } 
              }else{
                $xiangmu = [];
              }
              
            }
        }else{
          $time = date("Y-m-d H:i:s",time());
          if (empty($diqu) && empty($shaixuan)) {    //无筛选条件
              //查询项目分类
              $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$parentid));
              //查询商家
              $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
              if (!empty($shangjia)) {
                foreach ($shangjia as &$value) {
                  $s_id[]=$value['s_id'];
                }
                $s_id = implode(",",$s_id);
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1",array(":uniacid"=>$uniacid,":x_type"=>$xt_id)); 
              }else{
                $xiangmu = [];
              }
                    
          }
          if (!empty($diqu)  && empty($shaixuan)) {   //筛选条件  地区
            $city = $city."-".$diqu;
            //查询项目分类
            $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$parentid));
            
            //查询商家
            $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
            if (!empty($shangjia)) {
              foreach ($shangjia as &$value) {
                $s_id[]=$value['s_id'];
              }
              $s_id = implode(",",$s_id);
              //查询项目
              $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1",array(":uniacid"=>$uniacid,":x_type"=>$xt_id));
            }else{
              $xiangmu = [];
            }
            
          }
          if (empty($diqu) && !empty($shaixuan)) {    //筛选条件  筛选
            //查询项目分类
            $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$parentid));
            //查询商家
            $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
            if (!empty($shangjia)) {
              foreach ($shangjia as &$value) {
                $s_id[]=$value['s_id'];
              }
              $s_id = implode(",",$s_id);
              if ($shaixuan=="销量高") {
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id)  and x_status=1 order by x_xiaoliang desc ",array(":uniacid"=>$uniacid,":x_type"=>$xt_id));
              }
              if ($shaixuan=="价格低") {
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_jiage asc ",array(":uniacid"=>$uniacid,":x_type"=>$xt_id));
              }
            }else{
              $xiangmu = [];
            }
                       
          }
          if (!empty($diqu) && !empty($shaixuan)) {    //筛选条件 地区 筛选
            $city = $city."-".$diqu;
            //查询项目分类
            $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,"xt_id"=>$parentid));
            //查询商家
            $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_type in('全部','".$xiangmutype['xt_name']."') and s_address like '%$city%' and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."'",array(":uniacid"=>$uniacid,":s_status"=>"审核通过",":ruzhu_endtime"=>"已到期"));
            if (!empty($shangjia)) {
              foreach ($shangjia as &$value) {
                $s_id[]=$value['s_id'];
              }
              $s_id = implode(",",$s_id);

              if ($shaixuan=="销量高") {
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_xiaoliang desc ",array(":uniacid"=>$uniacid,":x_type"=>$xt_id));
              }
              if ($shaixuan=="价格低") {
                //查询项目
                $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_type=:x_type and x_shangjia in ($s_id) and x_status=1 order by x_jiage asc ",array(":uniacid"=>$uniacid,":x_type"=>$xt_id));
              } 
            }else{
              $xiangmu = [];
            }
                      
          }
        }

        if(!empty($xiangmu))
        {
          foreach ($xiangmu as &$value2) {
              if (strpos($value2['x_thumb'],"http")===false){
                $value2['x_thumb'] = $_W['attachurl'].$value2['x_thumb'];
              }
              //查询评分
              $pingfencount = pdo_fetchall("SELECT sum(p_fenshu) as money FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value2['x_id']));
              $pingfennum = pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value2['x_id']));
              $pingfen = $pingfencount[0]['money']/$pingfennum;
              $value2['pingfen'] =sprintf('%.1f',$pingfen);
          }
        }
        return $this->result(0,"success",$xiangmu);
    }

    //查询商家分类
    public function doPageShangjiastyle()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
        return $this->result(0,"success",$list);
    }

        //查询全部商家
    public function doPageShangjialist()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $city = $_REQUEST['city'];
      $diqu = $_REQUEST['diqu'];
      $fenlei = $_REQUEST['fenlei'];
      $shaixuan = $_REQUEST['shaixuan'];
      $time = date("Y-m-d H:i:s",time());
      $tiao = array("diqu"=>$diqu,"fenlei"=>$fenlei,"shaixuan"=>$shaixuan);
      $where = " where uniacid=:uniacid and s_status=:s_status and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."' ";
      if(empty($diqu)){
          $where.=" and s_address like '%$city%'";
      }
      if(!empty($diqu)){
          $citys = $city."-".$diqu; 
          $where.=" and s_address like '%$citys%'";
      }
      if(!empty($fenlei)){
          $where.=" and (s_type=:s_type or s_type='全部')"; 
          $data[':s_type']=$fenlei;
      }

      $sql = "SELECT * FROM ".tablename("hyb_o2o_shangjia").$where." order by s_ids desc";
      $data[':uniacid']=$uniacid;
      $data[':s_status']="审核通过";
      $data[":ruzhu_endtime"]="已到期";
      $list = pdo_fetchall($sql,$data);
      if (!empty($list)) {
          foreach ($list as &$value) {
            if (strpos($value['s_thumb'],"http")===false) {
              $value['s_thumb'] = $_W['attachurl'].$value['s_thumb'];
            }  
            if (empty($value['label'])) {
                $value['label'] = [];
            }else{
                $value['label'] = unserialize($value['label']);
            }
            $fuwu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$value['s_id']));
            foreach ($fuwu as &$value3) {
              $manjian[]+=$value3['x_manjianstatus'];
              $youhuiquan[]+=$value3['x_youhuiquanstatus'];
              $huiyuanquanyi[]+=$value3['x_huiyuanstatus'];
              $jifen[]+=$value3['x_jifenstatus'];
              if ($value3['x_xingshi']=="上门服务") {
                $shangmenfuwu[]+=$value3['x_xingshi'];
              }
              if($value3['x_xingshi']=="到店服务"){
                $daodianfuwu[]+=$value3['x_xingshi'];
              }

              //查询评分
            $pingfencount = pdo_fetchall("SELECT sum(p_fenshu) as money FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value3['x_id']));
            $pingfennum = pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value3['x_id']));
              
            if(empty($pingfencount[0]['money'])){
                $pingfen = "0"; 
                }else{
                    $pingfen = $pingfencount[0]['money']/$pingfennum;
                }
              $value3['pingfen'] = sprintf('%.1f',$pingfen);
              $value3['pingfennum'] = $pingfennum;
              
            }
            // var_dump($fuwu); 
            foreach ($fuwu as &$value4) {
                $fuwupingfen+=$value4['pingfen'];
                $fuwupinglunshu+=$value4['pingfennum'];
            }
            if (empty($fuwupinglunshu)) {
                $fuwupinglunshu = "0";
            }
            $value['pinglunshu'] = $fuwupinglunshu;
            if (in_array("1",$manjian)) {
              $value['manjian'] = "true";
            }else{
              $value['manjian'] = "false";
            }
            if (in_array("1",$youhuiquan)) {
              $value['youhuiquan'] = "true";
            }else{
              $value['youhuiquan'] = "false";
            }
            if (in_array("1",$huiyuanquanyi)) {
              $value['huiyuanquanyi'] = "true";
            }else{
              $value['huiyuanquanyi'] = "false";
            }
            if (in_array("1",$jifen)) {
              $value['jifen'] = "true";
            }else{
              $value['jifen'] = "false";
            }
            if (!empty($shangmenfuwu)) {
              $value['shangmenfuwu'] = "true";
            }else{
              $value['shangmenfuwu'] = "false";
            }
            if (!empty($daodianfuwu)) {
              $value['daodianfuwu'] = "true";
            }else{
               $value['daodianfuwu'] = "false";
            }
            //查询评分
            $pingfencount = pdo_fetchall("SELECT sum(fw_pingfen) as money FROM ".tablename('hyb_o2o_pingjia')."where uniacid=:uniacid and p_sjname=:p_sjname",array(":uniacid"=>$uniacid,":p_sjname"=>$value['s_name']));
            $pingfennum = pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('hyb_o2o_pingjia')."where uniacid=:uniacid and p_sjname=:p_sjname",array(":uniacid"=>$uniacid,":p_sjname"=>$value['s_name']));
            $pingfen = $pingfencount[0]['money']/$pingfennum;
            $value['pingfen'] =sprintf('%.1f',$pingfen);
            //$value['pinglunshu']  = $pingfennum;
            //查询销量
            $xiaoliangcount1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store ",array(":uniacid"=>$uniacid,":o_store"=>$value['s_id']));
            
            $value['xiaoliang'] = $xiaoliangcount1;
          }
      }
      return $this->result(0,"success",$list);
    }


    //查询首页推荐服务
    public function doPageShowfuwu()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $city = $_REQUEST['city'];

        $time = date("Y-m-d H:i:s",time());
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."' and s_status=:s_status and s_address like '%$city%'",array(":uniacid"=>$uniacid,":ruzhu_endtime"=>"已到期","s_status"=>"审核通过"));
        if (!empty($list)) {
            foreach ($list as &$value) {
                $s_id[] = $value['s_id'];
            }
            $s_ids = implode(",", $s_id);  
            //查询商家对应服务
            $fuwu = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_status=1 and x_tuijian=1 and x_shangjia in($s_ids)",array(":uniacid"=>$uniacid));
            if (!empty($fuwu)) {
                foreach ($fuwu as &$value2) {
                    if (strpos($value2['x_thumb'],"http")===false) {
                      $value2['x_thumb'] = $_W['attachurl'].$value2['x_thumb'];
                    }
                  //查询评分
                    $pingfencount = pdo_fetchall("SELECT sum(p_fenshu) as money FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value2['x_id']));
                    $pingfennum = pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value2['x_id']));
                    if (empty($pingfencount[0]['money'])) {
                        $pingfen = "0.0";
                    }else{
                        $pingfen = $pingfencount[0]['money']/$pingfennum;
                    }
                    
                    $value2['pingfen'] =sprintf('%.1f',$pingfen);
                } 
            }else{
                $fuwu = [];
            }
            
        }else{
            $fuwu = [];
        }
        
        return $this->result(0,"success",$fuwu);
    }

    //查询首页推荐商家
    public function doPageShowshangjia()
    {   
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $city = $_REQUEST['city'];
        $time = date("Y-m-d H:i:s",time());
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."' and s_status=:s_status and s_tuijian=:s_tuijian and s_address like '%$city%' order by s_ids desc ",array(":uniacid"=>$uniacid,":ruzhu_endtime"=>"已到期","s_status"=>"审核通过","s_tuijian"=>"是"));
        if (!empty($list)) {
            foreach ($list as &$value) {
                if (strpos($value['s_thumb'],"http")===false) {
                  $value['s_thumb'] = $_W['attachurl'].$value['s_thumb'];
                }  
                if (empty($value['label'])) {
                    $value['label'] = [];
                }else{
                    $value['label'] = unserialize($value['label']);
                }
                
                //查询下单数
                $xiadancount = pdo_fetchcolumn("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store",array(":uniacid"=>$uniacid,":o_store"=>$value['s_id']));
                $value['xiadancount'] = $xiadancount;
                
                $fuwu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$value['s_id']));
                foreach ($fuwu as &$value3) {
                  $manjian[]+=$value3['x_manjianstatus'];
                  $youhuiquan[]+=$value3['x_youhuiquanstatus'];
                  $huiyuanquanyi[]+=$value3['x_huiyuanstatus'];
                  $jifen[]+=$value3['x_jifenstatus'];
                  if ($value3['x_xingshi']=="上门服务") {
                    $shangmenfuwu[]+=$value3['x_xingshi'];
                  }
                  if($value3['x_xingshi']=="到店服务"){
                    $daodianfuwu[]+=$value3['x_xingshi'];
                  }

                  //查询评分
                  $pingfencount = pdo_fetchall("SELECT sum(p_fenshu) as money FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value3['x_id']));
                  $pingfennum = pdo_fetchcolumn("SELECT count(*)  FROM ".tablename('hyb_o2o_fuwupingjia')."where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value3['x_id']));
                  $pingfen = $pingfencount[0]['money']/$pingfennum;
                  $value3['pingfen'] = sprintf('%.1f',$pingfen);

                } 
                foreach ($fuwu as &$value4) {
                  $fuwupingfen+=$value4['pingfen'];
                }

                

                $fuwucount =pdo_fetchcolumn("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$value['s_id']));
                $fen = ceil($fuwupingfen/$fuwucount);
                if ($fen=='false') {
                    $value['shangjiapingfen'] = '5';//"0";
                }else{
                    if ($fen>=5) {
                        $value['shangjiapingfen']='5';
                    }else{
                        $value['shangjiapingfen'] = '5';//$fen;默认5分
                    }  
                }
                if (in_array("1",$manjian)) {
                  $value['manjian'] = "true";
                }else{
                  $value['manjian'] = "false";
                }
                if (in_array("1",$youhuiquan)) {
                  $value['youhuiquan'] = "true";
                }else{
                  $value['youhuiquan'] = "false";
                }
                if (in_array("1",$huiyuanquanyi)) {
                  $value['huiyuanquanyi'] = "true";
                }else{
                  $value['huiyuanquanyi'] = "false";
                }
                if (in_array("1",$jifen)) {
                  $value['jifen'] = "true";
                }else{
                  $value['jifen'] = "false";
                }
                if (!empty($shangmenfuwu)) {
                  $value['shangmenfuwu'] = "true";
                }else{
                  $value['shangmenfuwu'] = "false";
                }
                if (!empty($daodianfuwu)) {
                  $value['daodianfuwu'] = "true";
                }else{
                  $value['daodianfuwu'] = "false";
                }
            }
        }else{
            $list = [];
        }
        return $this->result(0,"success",$list);
    }

    //商家详情
    public function doPageShangjiaxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $s_id = $_REQUEST['s_id'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$s_id));
        $weizhi = explode("-",$list['s_address']);
        $list['weizhi'] = $weizhi['1'];
        //查询商家订单总数
        $dingdan = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_store=:o_store",array(":o_store"=>$s_id,":uniacid"=>$uniacid));
        $list['count'] = $dingdan;
        $list['s_imgpath'] = unserialize($list['s_imgpath']);
        foreach ($list['s_imgpath'] as &$value) {
          if (strpos($value,"http")===false) {
             $value = $_W['attachurl'].$value;
          }        
        }
        if (strpos($list['s_thumb'],"http")===false) {
            $list['s_thumb'] = $_W['attachurl'].$list['s_thumb'];
        }
        //查询商家项目
        $xiangmu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia and x_status=1",array(":uniacid"=>$uniacid,":x_shangjia"=>$list['s_id']));
        if (empty($xiangmu)) {
          $list['xiangmu'] = [];
          $list['pingjia'] = [];
        }else{
          foreach ($xiangmu as &$values) {
            if (strpos($values['x_thumb'],"http")===false) {
              $values['x_thumb'] = $_W['attachurl'].$values['x_thumb'];
            }
            $fw_ids[]=$values['x_id'];
          }
          $list['xiangmu'] = $xiangmu;
          $fw_ids = implode(",",$fw_ids);
          //查询评论
          $pinglun = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwupingjia")." WHERE uniacid=:uniacid and p_sid in ($fw_ids) order by p_time desc ",array(":uniacid"=>$uniacid));
          if (!empty($pinglun)) {
              foreach ($pinglun as &$valuess) {
                  $valuess['p_pic'] = unserialize($valuess['p_pic']);
                  $valuess['p_name'] = json_decode($valuess['p_name']);
                  //查询服务名称
                  $fuwuname = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." WHERE uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$valuess['p_sid']));
                  $valuess['fw_name'] = $fuwuname['x_name'];
              }
          }
          $list['pingjia'] = $pinglun;
        }

        return $this->result(0,"success",$list);
    }

    //添加服务 商家服务分类
    public function doPageShangjiaaddfuwutype(){
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
      if ($shangjia['pingtai']=="1") {
        $parenttype = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
        if (!empty($parenttype)) {
          foreach ($parenttype as $key=>$value) {
            if (strpos($value['xt_thumb'],"http")===false) {
              $parenttype[$key]['xt_thumb'] = $_W['attachurl'].$value['xt_thumb'];
              $parenttype[$key]['pingtai'] = $shangjia['pingtai'];
            }
            $parenttype[$key]['erji'] = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$value['xt_id']));
            if (!empty($parenttype[$key]['erji'])) {
              foreach ($parenttype[$key]['erji'] as &$values) {
                if (strpos($values['xt_thumb'],"http")===false) {
                  $values['xt_thumb'] = $_W['attachurl'].$values['xt_thumb'];
                }
              }
            }else{
              unset($parenttype[$key]);
            }

          }
        }
        
        
      }else{
        $parenttype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_parentid=0 and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
        if (!empty($parenttype)) {
          $parenttype['xt_thumb'] = $_W['attachurl'].$parenttype['xt_thumb'];
        }
        $erji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$parenttype['xt_id']));
        if (!empty($erji)) {
            foreach ($erji as &$values) {
              if (strpos($values['xt_thumb'],"http")===false) {
                $values['xt_thumb'] = $_W['attachurl'].$values['xt_thumb'];
              }
            }
        }
        $parenttype['erji'] = $erji;
        $parenttype['pingtai'] = $shangjia['pingtai'];

      }
      
      
      return $this->result(0,"success",$parenttype);
    }

    //查询商家所属服务分类
    public function doPageShangjiafwstyle()
    {
       global $_W,$_GPC;
       $uniacid = $_W['uniacid'];
       $openid = $_REQUEST['openid'];
       $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")."WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
       if ($list['pingtai']=="1") {
         $fwtype = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
         $list['fwtype'] = $fwtype;
       }
       return $this->result(0,"success",$list);
    }

    //查询服务详情
    public function doPageFuwuxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $x_id = $_REQUEST['x_id'];
        $openid = $_REQUEST['openid'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$x_id));
        if (strpos($list['x_thumb'],"http")===false) {
            $list['x_thumb'] = $_W['attachurl'].$list['x_thumb'];
        }
        $list['x_thumbs'] = unserialize($list['x_thumbs']);
        foreach ($list['x_thumbs'] as &$value) {
            if (strpos($value,"http")===false) {
               $value = $_W['attachurl'].$value;
            }
        }
        $list['x_jianjie_thumb'] = unserialize($list['x_jianjie_thumb']);
        foreach ($list['x_jianjie_thumb'] as &$value6) {
            if (strpos($value6,"http")===false) {
               $value6 = $_W['attachurl'].$value6;
            }
        }
        $list['x_guigecontent'] = unserialize($list['x_guigecontent']);
        //权益
        if ($list['x_huiyuanstatus']=="1") {
            //查询当前用户会员权益
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." as u left join ".tablename("hyb_o2o_huiyuan")." as h on u.u_type=h.h_id where u.uniacid=:uniacid and u.openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
            $list['huiyuanquanyi'] = $user['h_zhekou'];
            $list['userhuiyuan'] = $user['u_type'];
        }
        if ($list['x_manjianstatus']=="1") {
            $manjian = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and m_id=:m_id",array(":uniacid"=>$uniacid,":m_id"=>$list['x_manjian']));
            $list['manjian_money'] = $manjian['m_money'];
            $list['manjian_jmoney'] = $manjian['j_money'];
        }
        if ($list['x_youhuiquanstatus']=="1") {
            $youhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$list['x_youhuiquan']));
            $list['youhuiquan'] = $youhuiquan;
            //查询是否领取了优惠券
            $useryouhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and x_id=:x_id and y_name=:y_name and openid=:openid",array(":uniacid"=>$uniacid,":x_id"=>$list['x_id'],":y_name"=>$youhuiquan['y_id'],":openid"=>$openid));
            if (empty($useryouhuiquan)) {
              $list['lingdone'] = false;
            }else{
              $list['lingdone'] = true;
            }
        }
        //预约日期
        //查询商家
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$list['x_shangjia']));
        if (!empty($shangjia['baozhang'])) {
          $list['baozhang'] = unserialize($shangjia['baozhang']);
        }else{
          $list['baozhang'] = [];
        }
        $shangjia['s_yingyetime'] = explode("-",$shangjia['s_yingyetime']);


        //查询商家员工
        $yaungong = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_styles=:y_styles and y_typs=:y_typs and y_jin=0 and y_rz=0",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id'],":y_styles"=>"审核通过",":y_typs"=>"空闲中"));
        
        if (!empty($yaungong)) {
          foreach ($yaungong as &$values) {
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$values['y_openid']));
            $values['u_thumb'] = $user['u_thumb'];
              $values['y_jineng'] = unserialize($values['y_jineng']);

            /*  匹配

              //查询服务分类
              $fwtype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$list['x_type']));

              if (!in_array($fwtype['xt_name'],$values['y_jineng'])) {
                unset($yaungong[$keys]);
              }
            */

              $values['y_jineng'] = unserialize($values['y_jineng']);
              
              if (strpos($values['y_thumb'], "http")===false) {
                $values['y_thumb'] = $_W['attachurl'].$values['y_thumb'];
              }
              $values['y_fwqy'] = unserialize($values['y_fwqy']);
              //查询派单评分
              $pdpfcount = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_paidanpingjia")." WHERE uniacid=:uniacid and pj_yuangong=:pj_yuangong",array(":uniacid"=>$uniacid,":pj_yuangong"=>$values['y_id']));

              $pdpf = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_paidanpingjia")." WHERE uniacid=:uniacid and pj_yuangong=:pj_yuangong",array(":uniacid"=>$uniacid,":pj_yuangong"=>$values['y_id']));
              $pdpfnum = "";
              foreach ($pdpf as $key2 => $value2) {
                $pdpfnum+=$value2['pj_fen'];
              }
              $pdpfnum = sprintf('%.1f',$pdpfnum/$pdpfcount);

              //查询服务评分
              $fwpfcount = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwupingjia")." WHERE uniacid=:uniacid and p_yid=:p_yid",array(":uniacid"=>$uniacid,":p_yid"=>$values['y_id']));
              $fwpf = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwupingjia")." WHERE uniacid=:uniacid and p_yid=:p_yid",array(":uniacid"=>$uniacid,":p_yid"=>$values['y_id']));
              $fwpfnum = "";
              foreach ($fwpf as $key3 => $value3) {
                $fwpfnum+=$value3['p_fenshu'];
              }
              $fwpfnum = sprintf('%.1f',$fwpfnum/$fwpfcount);
              if ($pdpfnum=="0.0" && $fwpfnum=="0.0") {
                $values['pingfen'] ="0.0";
              }
              if ($pdpfnum=="0.0" && $fwpfnum!="0.0") {
                 $values['pingfen'] =$fwpfnum;
              }
              if ($pdpfnum!="0.0" && $fwpfnum=="0.0") {
                 $values['pingfen'] =$pdpfnum;
              }
              if ($pdpfnum!="0.0" && $fwpfnum!="0.0") {
                 $values['pingfen'] =sprintf('%.1f',($pdpfnum+$fwpfnum)/2);
              }
          }
        }
        
        //日期
        $weekarray=array("日","一","二","三","四","五","六");
        for($i=0;$i<5;$i++){
          $list['yydate'][$i]['date'] = date("m-d",strtotime("+".$i." day"));
          $list['yydate'][$i]['week'] = "星期".$weekarray[date("w",strtotime("+".$i." day"))];
        }
        $time = ["00:00","00:30","01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30","08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30","17:00","17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"];
        $times = ["00:00","00:30","01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30","08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30","17:00","17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"];
        $dqtime=date("H:i");
        foreach($time as $key=>$val){
          if(strtotime($dqtime)>=strtotime($val)){
            unset($time[$key]);
          }
          if(strtotime($shangjia['s_yingyetime'][1])<strtotime($val)){
            unset($time[$key]);
          }
          if(strtotime($shangjia['s_yingyetime'][0])>strtotime($val)){
            unset($time[$key]);
          }
        }
        foreach($times as $key=>$val){
          if(strtotime($shangjia['s_yingyetime'][1])<strtotime($val)){
            unset($times[$key]);
          }
          if(strtotime($shangjia['s_yingyetime'][0])>strtotime($val)){
            unset($times[$key]);
          }
        }

        $pingjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwupingjia")." where uniacid=:uniacid and p_sid=:p_sid order by p_id desc ",array(":uniacid"=>$uniacid,":p_sid"=>$list['x_id']));
        if (!empty($pingjia)) {
          foreach ($pingjia as &$p) {
            $p['p_name'] = json_decode($p['p_name']);
            $p['p_pic'] = unserialize($p['p_pic']);
          }
          $list['pingjia'] = $pingjia;
        }
        else{
          $list['pingjia'] = [];
        }
        
        $list['yuangong'] = $yaungong;
        $list['yytimenew'] = array_values($time);
        $list['yytimetom'] = array_values($times);
        $list['dqdate']=date("Y-m-d H:i");
        return $this->result(0,"success",$list);

    }


    //查询首页推荐商品
    public function doPageShowshangping()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $city = $_REQUEST['city'];
        $citys = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name",array(":uniacid"=>$uniacid,":name"=>$city));
        if (empty($citys)) {
            $list = [];
        }else{
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_tuijian=1 order by g_ids desc",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
            if (empty($list)) {
              $list = [];
            }else{
              foreach ($list as &$value) {
                $value['g_thumb'] = $_W['attachurl'].$value['g_thumb'];
              }
            }
        }

        
        return $this->result(0,"success",$list);
    }
    //查询商品详情
    public function doPageShangpingxq()
    {
      global $_W,$_GPC;
      $uniacid  = $_W['uniacid'];
      $id = $_REQUEST['id'];
      $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$id));
      $list['g_guigecontent'] = unserialize($list['g_guigecontent']);
      $list['g_thumb'] = $_W['attachurl'].$list['g_thumb'];
      $list['g_thumbs'] = unserialize($list['g_thumbs']);
      //查询商品评价
      $pingjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goodspingjia")." where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$list['g_id']));
      if (!empty($pingjia)) {
        foreach ($pingjia as &$values) {
          if (strpos($values['p_thumb'], "http")===false) {
            $values['p_thumb'] = $_W['attachurl'].$values['p_thumb'];
          }
          $values['p_name'] = json_decode($values['p_name']);
          $values['p_pic'] = unserialize($values['p_pic']);
        }
        $list['pingjia'] = $pingjia;
      }else{
        $list['pingjia'] = "";
      }
      
      foreach ($list['g_thumbs'] as &$value) {
        $value = $_W['attachurl'].$value;

      }
      return $this->result(0,"success",$list);
    }
    //查询商品分类
    public function doPageShangpingstyle()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods_style")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
      return $this->result(0,"success",$list);
    }

    //查询全部商品
    public function doPageShangpinglist()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $city = $_REQUEST['city'];
      if ($city=="") {
        //查询基本设置
        $base = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        //查询当前城市id
        $citys = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$base['city']));
        if (empty($citys)) {
          $list = [];
        }else{
          //查询商品
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_ids desc",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
          if (empty($list)) {
            $list = [];
          }else{
            foreach ($list as &$value) {
              $value['g_thumb'] = $_W['attachurl'].$value['g_thumb'];
            }
          }
        }
      }else{
        $citys = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$city));
        if (empty($citys)) {
          $list = [];
        }else{
          //查询商品
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_ids desc",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
          if (empty($list)) {
            $list = [];
          }else{
            foreach ($list as &$value) {
              $value['g_thumb'] = $_W['attachurl'].$value['g_thumb'];
            }
          }
        }
      }
      return $this->result(0,"success",$list);
    }

    //全部商品检索
    public function doPageShangpinglists()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $city = $_REQUEST['city'];
      $xiaoliang = $_REQUEST['xiaoliang'];
      $fenlei = $_REQUEST['fenlei'];
      $shaixuan = $_REQUEST['shaixuan'];
      if ($city=="") {
        //查询基本设置
        $base = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        //查询当前城市id
        $citys = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$base['city']));
        if (empty($citys)) {
          $list = [];
        }else{
          if (empty($xiaoliang) && empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_ids desc",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
          }
          if (!empty($xiaoliang) && empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_xiaoliang desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
          }
          if (empty($xiaoliang) && !empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_type=:g_type",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
          }
          if (empty($xiaoliang) && empty($fenlei) && !empty($shaixuan)) {
            if ($shaixuan=="由高到低") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_jiage desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
            }else if ($shaixuan=="由低到高") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_jiage asc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
            }
          }
          if (!empty($xiaoliang) && !empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_type=:g_type order by g_xiaoliang desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
          }
          if (empty($xiaoliang) && !empty($fenlei) && !empty($shaixuan)) {
            if ($shaixuan=="由高到低") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_type=:g_type order by g_jiage desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
            }else if ($shaixuan=="由低到高") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1  and g_type=:g_type order by g_jiage asc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
            }
          }
          
          if (empty($list)) {
            $list = [];
          }else{
            foreach ($list as &$value) {
              $value['g_thumb'] = $_W['attachurl'].$value['g_thumb'];
            }
          }
        }
      }else{
        $citys = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$city));
        if (empty($citys)) {
          $list = [];
        }else{
          if (empty($xiaoliang) && empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_ids desc",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
          }
          if (!empty($xiaoliang) && empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_xiaoliang desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
          }
          if (empty($xiaoliang) && !empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_type=:g_type",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
          }
          if (empty($xiaoliang) && empty($fenlei) && !empty($shaixuan)) {
            if ($shaixuan=="由高到低") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_jiage desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
            }else if ($shaixuan=="由低到高") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 order by g_jiage asc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id']));
            }
          }
          if (!empty($xiaoliang) && !empty($fenlei) && empty($shaixuan)) {
            //查询商品
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_type=:g_type order by g_xiaoliang desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
          }
          if (empty($xiaoliang) && !empty($fenlei) && !empty($shaixuan)) {
            if ($shaixuan=="由高到低") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1 and g_type=:g_type order by g_jiage desc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
            }else if ($shaixuan=="由低到高") {
              //查询商品
              $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_city=:g_city and g_status=1  and g_type=:g_type order by g_jiage asc ",array(":uniacid"=>$uniacid,"g_city"=>$citys['id'],":g_type"=>$fenlei));
            }
          }
          
          if (empty($list)) {
            $list = [];
          }else{
            foreach ($list as &$value) {
              $value['g_thumb'] = $_W['attachurl'].$value['g_thumb'];
            }
          }
        }
      }
      return $this->result(0,"success",$list);
    }


    //查询商家入驻所属分类
    public function doPageSjrzfwstyle()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
          return $this->result(0,"success",$list);
    }

    //查询商家入驻时长
    public function doPageSjrzsj()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjiaruzhu")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          return $this->result(0,"success",$list);
    }

    //支付
  public function doPagePay()
  {
    global $_GPC, $_W;
            include 'wxpay.php';
        $res = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_parment")." WHERE uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
        $appid = $res['appid'];
        $openid = $_REQUEST['openid'];
        $mch_id = $res['mchid'];
        $key = $res['wxkey'];
        $out_trade_no = $mch_id . time();
        $count_money = $_GPC['money'];
        if (empty($count_money)) {
            $body = '订单付款';
            $total_fee = floatval(99 * 100);
        } else {
            $body = '订单付款';
            $total_fee = floatval($count_money * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
        $return = $weixinpay->pay();
        echo json_encode($return);
  }

    //商家入驻[发布/修改资料]
    public function doPageSjrz()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $ruzhu = $_REQUEST['ruzhu_time'];
        $imgpath = $_REQUEST['imgpath'];
        $imgpath = str_replace('"',"",str_replace("]","",str_replace("[","", $imgpath)));
        $imgpath = explode(",",$imgpath);
        $imgpaths = serialize($imgpath);

        $label = $_REQUEST['label'];
        $label = str_replace('"',"",str_replace("]","",str_replace("[","", $label)));
        $label = explode(",",$label);
        $label = serialize($label);

        $data = array(
          "uniacid"=>$uniacid,
          "s_name"=>$_REQUEST['s_name'],
          "s_u_name"=>$_REQUEST['s_u_name'],
          "s_u_openid"=>$_REQUEST['openid'],
          "s_telphone"=>$_REQUEST['s_telphone'],
          "s_content"=>$_REQUEST['s_content'],
          "s_type"=>$_REQUEST['s_t_name'],
          "s_yingyetime"=>$_REQUEST['s_time'],
          "s_address"=>$_REQUEST['s_address'],
          "s_xxaddress"=>$_REQUEST['s_xxaddress'],
          "jing"=>$_REQUEST['jing'],
          "wei"=>$_REQUEST['wei'],
          "s_thumb"=>$_REQUEST['logo'],
          "s_zhizhao"=>$_REQUEST['zhizhao'],
          "s_imgpath"=>$imgpaths,
          "ruzhu_money"=>$_REQUEST['ruzhu_money'],
          "ruzhu_endtime"=>date('Y-m-d H:i:s', strtotime("+$ruzhu year")),
          "s_status"=>"待审核",
          "s_tuijian"=>"否",
          "s_time"=>date('Y-m-d H:i:s',time()),
          "s_idcard"=>$_REQUEST['Idcard'],
          "s_idcard2"=>$_REQUEST['Idcard2'],
          "label"=>$label,
        );
        $data2 = array(
          "uniacid"=>$uniacid,
          "s_name"=>$_REQUEST['s_name'],
          "s_u_name"=>$_REQUEST['s_u_name'],
          "s_u_openid"=>$_REQUEST['openid'],
          "s_telphone"=>$_REQUEST['s_telphone'],
          "s_content"=>$_REQUEST['s_content'],
          "s_type"=>$_REQUEST['s_t_name'],
          "s_yingyetime"=>$_REQUEST['s_time'],
          "s_address"=>$_REQUEST['s_address'],
          "s_xxaddress"=>$_REQUEST['s_xxaddress'],
          "jing"=>$_REQUEST['jing'],
          "wei"=>$_REQUEST['wei'],
          "s_thumb"=>$_REQUEST['logo'],
          "s_zhizhao"=>$_REQUEST['zhizhao'],
          "s_imgpath"=>$imgpaths,
          "s_status"=>"待审核",
          "s_tuijian"=>"否",
          "s_idcard"=>$_REQUEST['Idcard'],
          "s_idcard2"=>$_REQUEST['Idcard2'],
          "label"=>$label,
        );
        $data3 = array(
          "uniacid"=>$uniacid,
          "s_name"=>$_REQUEST['s_name'],
          "s_u_name"=>$_REQUEST['s_u_name'],
          "s_u_openid"=>$_REQUEST['openid'],
          "s_telphone"=>$_REQUEST['s_telphone'],
          "s_content"=>$_REQUEST['s_content'],
          "s_yingyetime"=>$_REQUEST['s_time'],
          "s_address"=>$_REQUEST['s_address'],
          "s_xxaddress"=>$_REQUEST['s_xxaddress'],
          "jing"=>$_REQUEST['jing'],
          "wei"=>$_REQUEST['wei'],
          "s_thumb"=>$_REQUEST['logo'],
          "s_imgpath"=>$imgpaths,
          "s_idcard"=>$_REQUEST['Idcard'],
          "s_idcard2"=>$_REQUEST['Idcard2'],
          "label"=>$label,
          "s_zhizhao"=>$_REQUEST['zhizhao'],
        );
        if ($_REQUEST['typs']=="发布") {
            $res = pdo_insert("hyb_o2o_shangjia",$data);
        }elseif($_REQUEST['typs']=="修改"){
            $rz = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$_REQUEST['openid']));
            if ($rz['pingtai']=="0") {
                $res = pdo_update("hyb_o2o_shangjia",$data2,array("s_id"=>$_REQUEST['s_id']));
            }elseif ($rz['pingtai']=="1") {
                $res = pdo_update("hyb_o2o_shangjia",$data3,array("s_id"=>$_REQUEST['s_id']));
                $data4 = array("uniacid"=>$uniacid,"name"=>$_REQUEST['s_name'],"openid"=>$_GPC['openid'],"thumb"=>$_REQUEST['logo'],"thumbs"=>$imgpaths,"content"=>$_REQUEST['s_content'],"xaddress"=>$_REQUEST['s_xxaddress'],"address"=>$_REQUEST['s_address']);
                pdo_update("hyb_o2o_mendian",$data4,array("uniacid"=>$uniacid));
            }         
        }
        $rz = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$_REQUEST['openid']));
        if ($rz['pingtai']=="0") {
          //查询用户信息
          $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$_REQUEST['openid']));
          $datas = array("u_shangjia"=>"待审核","u_yuangong"=>"0");
          $save = pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));


            /*短信通知平台管理员*/
            //查询平台信息
            $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $params = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];

            /*通知用户*/
            $params["PhoneNumbers"] = $pingtai['s_telphone'];         //接收人手机号
            $params["SignName"] = $aliduanxin['SignName'];
            $params["TemplateCode"] = $aliduanxin['sjrztz'];
            $params['TemplateParam'] = Array (
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
    }
    
    public function doPageUrl()
    {
       global $_W;
       echo $_W['siteroot'];
       // return $this->result(0,"success",$_W['siteroot']);
    }
    //图片上传
    public function doPageUpload(){
        global $_W, $_GPC;  
        $uniacid = $_W['uniacid'];
       //查询远程存储
        $cunchu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_cunchu")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        if ($_W['setting']['remote']['type']==0 && $cunchu['type']==0) {   //什么都不开启
            $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
            $max_file_size = 2000000;
            $destination_folder = '../attachment/images/'.$uniacid.'/';  //图片文件夹路径
            //创建存放图片的文件夹
            if (!is_dir($destination_folder)) {
               $res = mkdir($destination_folder, 0777, true);
            }
            if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
                echo '图片不存在!';
                die;
            }
            $file = $_FILES['upfile'];
            if ($max_file_size < $file['size']) {
                echo '文件太大!';
                die;
            }
            if (!in_array($file['type'], $uptypes)) {
                echo '文件类型不符!' . $file['type'];
                die;
            }
            $filename = $file['tmp_name'];
            $pinfo = pathinfo($file['name']);
            $ftype = $pinfo['extension'];
            $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
            if (file_exists($destination) && $overwrite != true) {
                echo '同名文件已经存在了';
                die;
            }
            if (!move_uploaded_file($filename, $destination)) {
                echo '移动文件出错';
                die;
            }
            $pinfo = pathinfo($destination);
            $fname = $_W['siteroot'].'/attachment/images/'.$uniacid.'/'.$pinfo['basename'];
            echo $fname;
        }
        else if($_W['setting']['remote']['type']==2 && $cunchu['type']==0)    //全局的远程存储 oss
        {       
            //将本地图片先上传到服务器
            load()->func('file');
            $file = $_FILES['upfile'];
            $filename = $file['tmp_name'];
            $destination_folder = '../attachment/images/'.$_W['uniacid'].'/'.date('Y/m/').'/';  //图片文件夹路径
            //创建存放图片的文件夹
            if (!is_dir($destination_folder)) {
               $res = mkdir($destination_folder, 0777, true);
            }
            if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
                echo '图片不存在!';
                die;
            }
           
            $pinfo = pathinfo($file['name']);
            $ftype = $pinfo['extension'];
            $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
            if (file_exists($destination) && $overwrite != true) {
                echo '同名文件已经存在了';
                die;
            }
            if (!move_uploaded_file($filename, $destination)) {
                echo '移动文件出错';
                die;
            }
            $pinfo = pathinfo($destination);
            $filename = 'images/'.$_W['uniacid'].'/'.date('Y/m/').$pinfo['basename'];

            //将服务器上的图片转移到阿里云oss
           
            $remote = $_W['setting']['remote'];
            require_once(IA_ROOT . '/framework/library/alioss/autoload.php');
            load()->model('attachment');
            $endpoint = 'http://'.$remote['alioss']['ossurl'];
            try {
                $ossClient = new \OSS\OssClient($remote['alioss']['key'], $remote['alioss']['secret'], $endpoint);              
                $ossClient->uploadFile($remote['alioss']['bucket'],$filename, ATTACHMENT_ROOT.$filename);
            } catch (\OSS\Core\OssException $e) {
              //echo  'error--->'.$e->getMessage();
                return error(1, $e->getMessage());
              
            }
            if ($auto_delete_local) {
                unlink($filename);
            }
            //删除服务器上的上传文件
            unlink(ATTACHMENT_ROOT.$filename);
           $fname = $remote['alioss']['url'].'/'.$filename;
           echo $fname;
            
        }else if($_W['setting']['remote']['type']==3 && $cunchu['type']==0)   //全局的远程存储 七牛云
        {
            /*
                上传文件名       $filekey     $_FILES['upfile']['name']
                上传文件的路径   $filePath    $_FILES['upfile']['tmp_name']
                上传凭证         $upToken    
            */
             require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
             $qiniu = $_W['setting']['remote']['qiniu'];
             $accessKey=$qiniu['accesskey'];
             $secretKey=$qiniu['secretkey'];
             $bucket=$qiniu['bucket'];
             //转码时使用的队列名称
             // $pipeline = $qiniu['qn_queuename'];
              //$pipeline = 'yinyue';
             //要进行转码的转码操作
             $fops = "avthumb/mp4/ab/64k/ar/44100/acodec/libfaac";
             $auth = new Qiniu\Auth($accessKey, $secretKey); 

             $filekey=$_FILES['upfile']['name'];         //上传文件名
             $filePath=$_FILES['upfile']['tmp_name'];    //上传文件的路径

             //可以对转码后的文件进行使用saveas参数自定义命名，当然也可以不指定文件会默认命名并保存在当间
             $savekey =  Qiniu\base64_urlSafeEncode($bucket.':'.$filekey.'_1');
             $fops = $fops.'|saveas/'.$savekey;
             $policy = array(
                     'persistentOps' => $fops,
                     //'persistentPipeline' => $pipeline
             );
             $uptoken = $auth->uploadToken($bucket, null, 3600, $policy);    //上传凭证
             //上传文件的本地路径
             $uploadMgr = new Qiniu\Storage\UploadManager();
             $ss = $uploadMgr->putFile($uptoken, $filekey, $filePath);
             load()->func("logging");
             $error=logging_run("qiniu:error".$err."成个");
             if ($err !== null) {
                 load()->func("logging");
                 logging_run("qiniu:error");
                 return false;
             }
             $fname=$qiniu['url'].'/'.$ss[0]['key'];
             echo $fname;
        }elseif ($_W['setting']['remote']['type']==4 && $cunchu['type']==0) {  //全局的远程存储 腾讯云
            $cosurl = $_W['setting']['remote']['cos']['url'];
            $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png');
            $max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
            $destination_folder = '../attachment/images/'.$_W['uniacid'].'/'.date('Y/m/').'/';  //图片文件夹路径
            if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])) //是否存在文件
            {
              echo "图片不存在!";  
                exit;  
            }  
            $file = $_FILES["upfile"];
            if($max_file_size < $file["size"])
            {  
                echo "文件太大!"; 
                exit;
            }  
            if(!in_array($file["type"], $uptypes))   //检查文件类型  
            {
                echo "文件类型不符!".$file["type"];
                exit;
            }
            if(!file_exists($destination_folder))
            {
              mkdir($destination_folder);
            }  

            $filename=$file["tmp_name"];  
            $image_size = getimagesize($filename);  
            $pinfo=pathinfo($file["name"]);  
            $ftype=$pinfo['extension'];  
            $destination = $destination_folder.time().".".$ftype;  
            if (file_exists($destination) && $overwrite != true)  
            {  
                echo "同名文件已经存在了";  
                exit;  
            }  
            if(!move_uploaded_file ($filename, $destination))  
            {  
                echo "移动文件出错";  
                exit;
            }
            $pinfo=pathinfo($destination);  
            $fname=$pinfo['basename'];  
        
            @require_once (IA_ROOT . '/framework/function/file.func.php');
            @$filename='images/'.$_W['uniacid'].'/'.date('Y/m/').'/'.$fname;
            @file_remote_upload($filename);
            echo $cosurl.'/images/'.$_W['uniacid'].'/'.date('Y/m/').$fname;
        }
        else if ($cunchu['type']==2 && $_W['setting']['remote']['type']==0) {      //模块内的oss
            //将本地图片先上传到服务器
            load()->func('file');
            $file = $_FILES['upfile'];
            $filename = $file['tmp_name'];
            $destination_folder = '../attachment/images/'.$_W['uniacid'].'/'.date('Y/m/').'/';  //图片文件夹路径
            //创建存放图片的文件夹
            if (!is_dir($destination_folder)) {
               $res = mkdir($destination_folder, 0777, true);
            }
            if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
                echo '图片不存在!';
                die;
            }
            $file = $_FILES['upfile'];
            $filename = $file['tmp_name'];
            $pinfo = pathinfo($file['name']);
            $ftype = $pinfo['extension'];
            $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
            if (file_exists($destination) && $overwrite != true) {
                echo '同名文件已经存在了';
                die;
            }
            if (!move_uploaded_file($filename, $destination)) {
                echo '移动文件出错';
                die;
            }
            $pinfo = pathinfo($destination);
            $filename = 'images/'.$_W['uniacid'].'/'.date('Y/m/').$pinfo['basename'];

            //将服务器上的图片转移到阿里云oss
            
            require_once(IA_ROOT . '/framework/library/alioss/autoload.php');
            load()->model('attachment');
            $endpoint = 'http://'.$cunchu['alioss_ossurl'];
            try {
                $ossClient = new \OSS\OssClient($cunchu['alioss_key'], $cunchu['alioss_secret'], $endpoint);              
                $ossClient->uploadFile($cunchu['alioss_bucket'],$filename, ATTACHMENT_ROOT.$filename);
            } catch (\OSS\Core\OssException $e) {
             // echo  'error--->'.$e->getMessage();
                return error(1, $e->getMessage());
              
            }
            //删除服务器上的上传文件
            unlink(ATTACHMENT_ROOT.$filename);
           $fname = $cunchu['alioss_url'].'/'.$filename;
           echo $fname;
        }
        else if ($cunchu['type']==3 && $_W['setting']['remote']['type']==0) {      //模块内的七牛
             /*
                上传文件名       $filekey     $_FILES['upfile']['name']
                上传文件的路径   $filePath    $_FILES['upfile']['tmp_name']
                上传凭证         $upToken    
            */
             require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
             $accessKey=$cunchu['qiniu_accesskey'];
             $secretKey=$cunchu['qiniu_secretkey'];
             $bucket=$cunchu['qiniu_bucket'];
             //转码时使用的队列名称
             // $pipeline = $qiniu['qn_queuename'];
              //$pipeline = 'yinyue';
             //要进行转码的转码操作
             $fops = "avthumb/mp4/ab/64k/ar/44100/acodec/libfaac";
             $auth = new Qiniu\Auth($accessKey, $secretKey); 

             $filekey=$_FILES['upfile']['name'];         //上传文件名
             $filePath=$_FILES['upfile']['tmp_name'];    //上传文件的路径

             //可以对转码后的文件进行使用saveas参数自定义命名，当然也可以不指定文件会默认命名并保存在当间
             $savekey =  Qiniu\base64_urlSafeEncode($bucket.':'.$filekey.'_1');
             $fops = $fops.'|saveas/'.$savekey;
             $policy = array(
                     'persistentOps' => $fops,
                     //'persistentPipeline' => $pipeline
             );
             $uptoken = $auth->uploadToken($bucket, null, 3600, $policy);    //上传凭证
             //上传文件的本地路径
             $uploadMgr = new Qiniu\Storage\UploadManager();
             $ss = $uploadMgr->putFile($uptoken, $filekey, $filePath);
             load()->func("logging");
             $error=logging_run("qiniu:error".$err."成个");
             if ($err !== null) {
                 load()->func("logging");
                 logging_run("qiniu:error");
                 return false;
             }
             $fname=$cunchu['qiniu_url'].'/'.$ss[0]['key'];
             echo $fname;
        }
    }


  //查询商家
  public function doPageShangjia()
  {
    global $_W,$_GPC;
    $uniacid = $_W['uniacid'];
    $openid = $_REQUEST['openid'];

      //查询商家
      $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
      //查询商家接单
      $jiedan = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_openid=:q_openid",array(":uniacid"=>$uniacid,":q_openid"=>$info['s_u_openid']));
      $info['jiedan'] = $jiedan;
      if (empty($info['label'])) {
        $info['label'] = [];
      }else{
        $info['label'] = unserialize($info['label']);
      }
      
      if (strpos($info['s_thumb'],"http")===false) {
        $info['s_thumb'] = $_W['attachurl'].$info['s_thumb'];
      }
      if (strpos($info['s_zhizhao'],"http")===false) {
        $info['s_zhizhao'] = $_W['attachurl'].$info['s_zhizhao'];
      }
      if (strpos($info['s_idcard'],"http")===false) {
        $info['s_idcard'] = $_W['attachurl'].$info['s_idcard'];
      }
      if (strpos($info['s_idcard2'],"http")===false) {
        $info['s_idcard2'] = $_W['attachurl'].$info['s_idcard2'];
      }
      $info['s_imgpath'] = unserialize($info['s_imgpath']);
      foreach ($info['s_imgpath'] as &$value) {
        if (strpos($value,"http")===false) {
          $value = $_W['attachurl'].$value;
        }
      }
      if (date("Y-m-d H:i:s",time())===$info['ruzhu_endtime'] || date("Y-m-d H:i:s",time())>$info['ruzhu_endtime'] || $info['ruzhu_endtime']=="已到期") {
        $info['daoqi']  = 1;
      }else{
        $info['daoqi'] = 0;
      }
        $time = date("Y-m-d H:i:s",time());
        $day = round((strtotime($info['ruzhu_endtime'])-strtotime($time))/86400);
        if($day<0){
            $info['day'] = "0";
        }else{
            $info['day'] = $day;
        }
      return $this->result(0,"success",$info);
  }
  //商户提现
    public function doPagePaytixian()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $t_money = $_REQUEST['t_money'];
        $shouxufei = $_REQUEST['shouxufei'];
        $id = $_REQUEST['id'];
        $tishi = $_REQUEST['tishi'];
        $typs = $_REQUEST['typs'];
        if ($typs == "yh") {
            //查询用户
          $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$id));
          $u_money = $user['u_money'];
          if($tishi=="1"){  //不够手续费
            //商户余额
            $moneyss = $u_money-$t_money;
            $moneys =round($moneyss, 2); ;
            //提现金额
            $moneyt = $t_money-$shouxufei;
            $data = array("u_money"=>$moneys);
            pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$id));
            $data2 = array(
                "uniacid"=>$uniacid,
                "u_id"=>$id,
                's_money'=>$shouxufei,
                "money"=>$moneyt,
                "statue"=>"待提现",
                "tnum"=>date('Ymd').str_pad(mt_rand(1, 99999),5,'0',STR_PAD_LEFT),
                "time"=>date("Y-m-d H:i:s",time()),
            );
            if ($_REQUEST['xingshi']=="0") {
                $data2['xingshi'] = "银行卡";
                $data2['zhanghao'] = $_REQUEST['cardNum'];
                $data2['xingming'] = $_REQUEST['name'];
                $data2['kaihuhang'] = $_REQUEST['place'];
            }
            if ($_REQUEST['xingshi']=='1') {
                $data2['xingshi'] = "支付宝";
                $data2['xingming'] = $_REQUEST['name'];
                $data2['zhanghao'] = $_REQUEST['cardNum'];
            }
            if ($_REQUEST['xingshi']=='2') {
                $data2['xingshi'] = "微信";
            }
            
            $save = pdo_insert("hyb_o2o_usertixian",$data2);
          }else{
            //商户余额
            $moneyss = $u_money-$t_money-$shouxufei;
            $data = array("u_money"=>$moneyss);
            pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$id));
            $data2 = array(
                "uniacid"=>$uniacid,
                "u_id"=>$id,
                's_money'=>$shouxufei,
                "money"=>$t_money,
                "statue"=>"待提现",
                "tnum"=>date('Ymd').str_pad(mt_rand(1, 99999),5,'0',STR_PAD_LEFT),
                "time"=>date("Y-m-d H:i:s",time()),
            );
            if ($_REQUEST['xingshi']=="0") {
                $data2['xingshi'] = "银行卡";
                $data2['zhanghao'] = $_REQUEST['cardNum'];
                $data2['xingming'] = $_REQUEST['name'];
                $data2['kaihuhang'] = $_REQUEST['place'];
            }
            if ($_REQUEST['xingshi']=='1') {
                $data2['xingshi'] = "支付宝";
                $data2['xingming'] = $_REQUEST['name'];
                $data2['zhanghao'] = $_REQUEST['cardNum'];
            }
            if ($_REQUEST['xingshi']=='2') {
                $data2['xingshi'] = "微信";
            }
            $save = pdo_insert("hyb_o2o_usertixian",$data2);
          }
        }
        if ($typs =='sj') {
         //查询商家
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$id));
          $s_money = $shangjia['s_money'];
          if($tishi=="1"){  //不够手续费
            //商户余额
            $moneyss = $s_money-$t_money;
            $moneys =round($moneyss, 2); ;
            //提现金额
            $moneyt = $t_money-$shouxufei;
            $data = array("s_money"=>$moneys);
            pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$id));
            $data2 = array(
                "uniacid"=>$uniacid,
                "s_id"=>$id,
                's_money'=>$shouxufei,
                "money"=>$moneyt,
                "statue"=>"待提现",
                "tnum"=>date('Ymd').str_pad(mt_rand(1, 99999),5,'0',STR_PAD_LEFT),
                "time"=>date("Y-m-d H:i:s",time()),
            );
            if ($_REQUEST['xingshi']=="0") {
                $data2['xingshi'] = "银行卡";
                $data2['zhanghao'] = $_REQUEST['cardNum'];
                $data2['xingming'] = $_REQUEST['name'];
                $data2['kaihuhang'] = $_REQUEST['place'];
            }
            if ($_REQUEST['xingshi']=='1') {
                $data2['xingshi'] = "支付宝";
                $data2['xingming'] = $_REQUEST['name'];
                $data2['zhanghao'] = $_REQUEST['cardNum'];
            }
            if ($_REQUEST['xingshi']=='2') {
                $data2['xingshi'] = "微信";
            }
            $save = pdo_insert("hyb_o2o_usertixian",$data2);
          }else{
            //商户余额
            $moneyss = $s_money-$t_money-$shouxufei;
            $data = array("s_money"=>$moneyss);
            pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$id));
            $data2 = array(
                "uniacid"=>$uniacid,
                "s_id"=>$id,
                's_money'=>$shouxufei,
                "money"=>$t_money,
                "statue"=>"待提现",
                "tnum"=>date('Ymd').str_pad(mt_rand(1, 99999),5,'0',STR_PAD_LEFT),
                "time"=>date("Y-m-d H:i:s",time()),
            );
            if ($_REQUEST['xingshi']=="0") {
                $data2['xingshi'] = "银行卡";
                $data2['zhanghao'] = $_REQUEST['cardNum'];
                $data2['xingming'] = $_REQUEST['name'];
                $data2['kaihuhang'] = $_REQUEST['place'];
            }
            if ($_REQUEST['xingshi']=='1') {
                $data2['xingshi'] = "支付宝";
                $data2['xingming'] = $_REQUEST['name'];
                $data2['zhanghao'] = $_REQUEST['cardNum'];
            }
            if ($_REQUEST['xingshi']=='2') {
                $data2['xingshi'] = "微信";
            }
            $save = pdo_insert("hyb_o2o_usertixian",$data2);
          }
        }
        if ($typs=='yg') {
            //查询员工
            $yuangong  = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$id));
            $y_money = $yuangong['y_money'];
          if($tishi=="1"){  //不够手续费
            //商户余额
            $moneyss = $y_money-$t_money;
            $moneys =round($moneyss, 2); ;
            //提现金额
            $moneyt = $t_money-$shouxufei;
            $data = array("y_money"=>$moneys);
            pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$id));
            $data2 = array(
                "uniacid"=>$uniacid,
                "y_id"=>$id,
                's_money'=>$shouxufei,
                "money"=>$moneyt,
                "statue"=>"待提现",
                "tnum"=>date('Ymd').str_pad(mt_rand(1, 99999),5,'0',STR_PAD_LEFT),
                "time"=>date("Y-m-d H:i:s",time()),
            );
            if ($_REQUEST['xingshi']=="0") {
                $data2['xingshi'] = "银行卡";
                $data2['zhanghao'] = $_REQUEST['cardNum'];
                $data2['xingming'] = $_REQUEST['name'];
                $data2['kaihuhang'] = $_REQUEST['place'];
            }
            if ($_REQUEST['xingshi']=='1') {
                $data2['xingshi'] = "支付宝";
                $data2['xingming'] = $_REQUEST['name'];
                $data2['zhanghao'] = $_REQUEST['cardNum'];
            }
            if ($_REQUEST['xingshi']=='2') {
                $data2['xingshi'] = "微信";
            }
            $save = pdo_insert("hyb_o2o_usertixian",$data2);
          }else{
            //商户余额
            $moneyss = $y_money-$t_money-$shouxufei;
            $data = array("y_money"=>$moneyss);
            pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$id));
            $data2 = array(
                "uniacid"=>$uniacid,
                "y_id"=>$id,
                's_money'=>$shouxufei,
                "money"=>$t_money,
                "statue"=>"待提现",
                "tnum"=>date('Ymd').str_pad(mt_rand(1, 99999),5,'0',STR_PAD_LEFT),
                "time"=>date("Y-m-d H:i:s",time()),
            );
            if ($_REQUEST['xingshi']=="0") {
                $data2['xingshi'] = "银行卡";
                $data2['zhanghao'] = $_REQUEST['cardNum'];
                $data2['xingming'] = $_REQUEST['name'];
                $data2['kaihuhang'] = $_REQUEST['place'];
            }
            if ($_REQUEST['xingshi']=='1') {
                $data2['xingshi'] = "支付宝";
                $data2['xingming'] = $_REQUEST['name'];
                $data2['zhanghao'] = $_REQUEST['cardNum'];
            }
            if ($_REQUEST['xingshi']=='2') {
                $data2['xingshi'] = "微信";
            }
            $save = pdo_insert("hyb_o2o_usertixian",$data2);
          }
        }
        
      return $this->result(0,"success",$shuju);
    }
    //用户累积提现
    public function doPageYhtixian(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        $list = pdo_fetch("SELECT sum(money) as tixian FROM ".tablename("hyb_o2o_usertixian")." where uniacid=:uniacid and u_id=:u_id",array(":uniacid"=>$uniacid,":u_id"=>$user['u_id']));
      return $this->result(0,'success',$list);
    }
  //商户累计提现
    public function doPageSjtixian()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
        $list = pdo_fetch("SELECT sum(money) as tixian FROM ".tablename("hyb_o2o_usertixian")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$shangjia['s_id']));
      return $this->result(0,'success',$list);
    }
    //员工累计提现
    public function doPageYgtixian()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $list = pdo_fetch("SELECT sum(money) as tixian FROM ".tablename("hyb_o2o_usertixian")."as t left join ".tablename('hyb_o2o_yuangong')."as y on t.y_id=y.y_id where t.uniacid=:uniacid  and  y.y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
      return $this->result(0,'success',$list);
    }

    //商家续费
    public function doPagePaysjxf()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $openid = $_REQUEST['openid'];
          $form_id = $_REQUEST['form_id'];
          $money = $_REQUEST['money'];
          $ruzhu = $_REQUEST['r_time'];
          //查询商户信息
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
          if ($shangjia['ruzhu_endtime']=="已到期") {
              $time = date("Y-m-d H:i:s",time());
              if (is_int($ruzhu)) {
                $ruzhu_endtime = date('Y-m-d H:i:s', strtotime("$time +$ruzhu year"));
              }else{
                $ruzhu_time = 12*$ruzhu;
                $ruzhu_endtime = date('Y-m-d H:i:s', strtotime("$time +$ruzhu_time months"));
              }
              $data = array("ruzhu_endtime" => $ruzhu_endtime);
              pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$shangjia['s_id']));
          }else{
              $time = $shangjia['ruzhu_endtime'];
              if (is_int($ruzhu)) {
                $ruzhu_endtime = date('Y-m-d H:i:s', strtotime("$time +$ruzhu year"));
              }else{
                $ruzhu_time = 12*$ruzhu;
                $ruzhu_endtime = date('Y-m-d H:i:s', strtotime("$time +$ruzhu_time months"));
              }
              $data = array("ruzhu_endtime" => $ruzhu_endtime);
              pdo_update("hyb_o2o_shangjia",$data,array("s_id"=>$shangjia['s_id']));
          }
          $key = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $APPID = $key['appid'];
          $SECRET = $key['appsecret'];
          $template_id = $moban['xufei'];
          $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
          $getArr=array();
          $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
          $access_token=$tokenArr->access_token;
          $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
          $value = array(
            "keyword1"=>array(
                "value"=> $money,
                "color"=>"#4a4a4a"
            ),
            "keyword2"=>array(
                "value"=>"商户入驻续费",
                "color"=>"#9b9b9b"
            ),
            "keyword3"=>array(
                "value"=>$ruzhu_endtime,
                "color"=>"#9b9b9b"
            ),
            "keyword4"=>array(
                "value"=>$ruzhu."年",
                "color"=>"#9b9b9b"
            ),
          );       
          $dd = array();
          $dd['touser']=$openid;
          $dd['template_id']=$template_id;
          $dd['page']="";  //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
          $dd['form_id']=$form_id;
          $dd['data']=$value;                        //模板内容，不填则下发空模板
          $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
          $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
          $result = $this->https_curl_json($url,$dd,'json');
          if($result){
                      echo json_encode(array('state'=>5,'msg'=>$result));
                  }else{
                      echo json_encode(array('state'=>5,'msg'=>$result));
                  }
         return $this->result(0, 'success', $result);
    }


    //绑定用户手机号
    public function doPageUsertel(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $tel  = $_REQUEST['tel'];
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        pdo_update("hyb_o2o_userinfo",array("u_tel"=>$tel),array("u_id"=>$user['u_id']));
    }

    //查询用户地址
    public function doPageUseraddress()
    {
          global $_GPC,$_W;
          $uniacid = $_W['uniacid'];
          $d_id = $_REQUEST['d_id'];
          $openid =  $_REQUEST['openid'];
          $index =  $_REQUEST['index'];

          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_address")." where uniacid=:uniacid and openid=:openid order by d_id desc",array(":uniacid"=>$uniacid,":openid"=>$openid));
          return $this->result(0,"success",$list);
    }
    //查询地址详情
    public function doPageUseraddressxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $d_id = $_REQUEST['d_id'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_address")." where uniacid=:uniacid and d_id=:d_id",array(":uniacid"=>$uniacid,":d_id"=>$d_id));
        return $this->result(0,"success",$list);
    }

    //查询默认地址
    public function doPageAddressonly()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid =  $_REQUEST['openid'];
      $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_address")." where uniacid=:uniacid and openid=:openid and d_checked=1",array(":uniacid"=>$uniacid,":openid"=>$openid));
      if (empty($list)) {
        //查询最新服务订单
        $order = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and openid=:openid order by o_xdtime desc limit 1",array(":uniacid"=>$uniacid,":openid"=>$openid));
        if (!empty($order)) {
          $list['d_uname'] = $order[0]['o_name'];
          $list['d_phone'] = $order[0]['o_telphone'];
          $list['d_address'] = $order[0]['o_address'];
          $list['d_xxaddress'] = $order[0]['o_xxaddress'];
          //设置该地址到数据库
          $addressdata = array(
            "openid" => $openid,
            "d_address" => $list['d_address'],
            "d_xxaddress" => $list['d_xxaddress'],
            "d_uname" => $list['d_uname'],
            "d_phone" => $list['d_phone'],
            "uniacid" => $uniacid,
            "d_checked"=>1
          );
          pdo_insert("hyb_o2o_address",$addressdata);
        }else{
            //查询最新商品订单
            $goodsorder = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." WHERE uniacid=:uniacid and openid=:openid order by o_xdtime desc limit 1",array(":uniacid"=>$uniacid,":openid"=>$openid));
            if (!empty($goodsorder)) {
                $list['d_uname'] = $goodsorder[0]['o_name'];
                $list['d_phone'] = $goodsorder[0]['o_telphone'];
                $list['d_address'] = $goodsorder[0]['o_address'];
                $list['d_xxaddress'] = $goodsorder[0]['o_xxaddress'];
                $addressdata = array(
                    "openid" => $openid,
                    "d_address" => $list['d_address'],
                    "d_xxaddress" => $list['d_xxaddress'],
                    "d_uname" => $list['d_uname'],
                    "d_phone" => $list['d_phone'],
                    "uniacid" => $uniacid,
                    "d_checked"=>1
                );
                pdo_insert("hyb_o2o_address",$addressdata);
            }
        }
      }    
      return $this->result(0,"success",$list);
    }
    //设置默认地址
    public function doPageUpdaddress()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid =  $_REQUEST['openid'];
      $d_id =  $_REQUEST['d_id'];
      $res=pdo_update("hyb_o2o_address",array('d_checked'=>0),array("uniacid"=>$uniacid,"openid"=>$openid,"d_checked"=>1));
      pdo_update("hyb_o2o_address",array('d_checked'=>1),array("uniacid"=>$uniacid,"openid"=>$openid,"d_id"=>$d_id)); 
    }
    //删除地址
    public function doPageAddressdel()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $d_id = $_REQUEST['d_id'];
      pdo_delete("hyb_o2o_address",array("d_id"=>$d_id));
    }

    //添加地址
    public function doPageAddress()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $d_id = $_REQUEST['d_id'];
      $data = array(
        "openid" => $openid,
        "d_address" => $_REQUEST['d_address'],
        "d_xxaddress" => $_REQUEST['d_xxaddress'],
        "d_uname" => $_REQUEST['d_uname'],
        "d_phone" => $_REQUEST['d_phone'],
        "uniacid" => $uniacid
      );
      if($d_id!="undefined"){
        echo '更新';
        pdo_update("hyb_o2o_address",$data,array("d_id"=>$d_id));
      }else{
        echo '插入';
        pdo_insert("hyb_o2o_address",$data);
      }
    }


    //查询商家优惠券
    public function doPageSjhdyhq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询商家
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
        return $this->result(0,"success",$list);
    }

    //添加优惠券
    public function doPageYouhuiquanadd()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $y_id = $_REQUEST['y_id'];
      //查询商家
      $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
      $data = array(
        "uniacid"=>$uniacid,
        "shangjia"=>$shangjia['s_id'],
        "y_name"=>$_REQUEST['y_name'],
        "y_money"=>$_REQUEST['y_money'],
        "y_shuoming"=>$_REQUEST['y_shuoming'],
        "y_yaoqiu"=>$_REQUEST['y_shiyong'],
        "y_starttime"=>$_REQUEST['y_starttime'],
        "y_endtime"=>$_REQUEST['y_endtime'],
      );
      if ($y_id=='0') {
          pdo_insert("hyb_o2o_youhuiquan",$data);
      }else {
          pdo_update("hyb_o2o_youhuiquan",$data,array("y_id"=>$y_id));
      }
     
    }


    //优惠券详情
    public function doPageYouhuiquanxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $y_id = $_REQUEST['y_id'];
        $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." WHERE uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
        return $this->result(0,"success",$info);
    }

    //优惠券删除
    public function doPageYouhuiquandel()
    {
      global $_W,$_GPC;
      $id = $_REQUEST['id'];
      pdo_delete("hyb_o2o_youhuiquan",array("y_id"=>$id));
    }


    //优惠券删除
    public function doPageUseryouhuiquandel()
    {
      global $_W,$_GPC;
      $id = $_REQUEST['id'];
      pdo_delete("hyb_o2o_useryouhuiquan",array("id"=>$id));
    }


    //查询商家满减活动
    public function doPageSjhdmanjian()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询商家
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
        return $this->result(0,"success",$list);
    }

    //添加商家满减活动
    public function doPageManjianadd(){
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      //查询商家
      $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
      $data = array(
        "uniacid"=>$uniacid,
        "m_money"=>$_REQUEST['man'],
        "j_money"=>$_REQUEST['jian'],
        "shangjia"=>$shangjia['s_id'],
      );
      $res =pdo_insert("hyb_o2o_manjian",$data);
    }

    //满减活动删除
    public function doPageManjiandel(){
      global $_W,$_GPC;
      $id = $_REQUEST['id'];
      $res = pdo_delete("hyb_o2o_manjian",array("m_id"=>$id));
    }

    //查询添加服务商家服务分类一级
    public function doPageSjfwstyleyiji()
    {
       global $_W,$_GPC;
       $uniacid = $_W['uniacid'];
       $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0",array(":uniacid"=>$uniacid));
      return $this->result(0,"success",$list);
    }
    //查询添加服务商家服务分类二级
    public function doPageSjfwstyleerji()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $yiji = $_REQUEST['yiji'];
        $xiangmutype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=0 and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$yiji));
        $erjitype = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid=:xt_parentid",array(":uniacid"=>$uniacid,":xt_parentid"=>$xiangmutype['xt_id']));
        return $this->result(0,"success",$erjitype);
    }
    //查询添加服务商家满减活动
    public function doPageSjfwmanjian()
    {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $openid = $_REQUEST['openid'];
          //查询商家
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
          return $this->result(0,"success",$list);
    }
    //查询添加服务商家优惠券
    public function doPageSjyhq(){
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $openid = $_REQUEST['openid'];
          //查询商家
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and shangjia=:shangjia",array(":uniacid"=>$uniacid,":shangjia"=>$shangjia['s_id']));
          return $this->result(0,"success",$list);
    }

    public function doPageAddfw()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //商家
        $sjname = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
        //查询项目分类
        $typs = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_xiangmu_type")." where uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$_REQUEST['erjifl']));
        //项目幻灯片
        $x_hdp_thumb = json_decode($_REQUEST['x_hdp_thumb'],true);
        $x_hdp_thumb = serialize($x_hdp_thumb);
        

        //项目简介图片
        $x_jianjie_thumb = json_decode($_REQUEST['x_jianjie_thumb'],true);
         $x_jianjie_thumb = serialize($x_jianjie_thumb);


      //项目规格
      $x_guige = $_REQUEST['guige_list'];
      $x_guige = str_replace('{',"",str_replace('"',"",str_replace("]","",str_replace("[","", $x_guige))));
      if (!empty($x_guige)) {
        $x_guige = explode("},",$x_guige);
        $x_guige = str_replace("}","",$x_guige);

        foreach ($x_guige as &$value) {
          $guigexiang[]=str_replace("guigexiang:","",substr($value,0,strrpos($value,',')));
          $price[]=str_replace("price:","",substr($value,strpos($value,',')+1));
        }
        $a = array(guigexiang=>$guigexiang);
        $b = array (price=>$price);
        $test = array("a"=>guigexiang,"b"=>price);
        $x_guigecontent = array();
        for($i=0;$i<count($a[guigexiang]);$i++){
            foreach($test as $key=>$value){
                $x_guigecontent[$i][$value] = ${$key}[$value][$i];
            }
        }
        $x_guigecontent = serialize($x_guigecontent);
      }else{
        $x_guigecontent = "";
      }
      
      //积分
      if ($_REQUEST['jf']=="true") {
        $jifen = "1";
      }else{
        $jifen = "0";
      }
      //满减活动
      if ($_REQUEST['mj']=="true") {
        $manjian = "1";
      }else{
        $manjian = "0";
      }
      //优惠券
      if($_REQUEST['yhq']=="true"){
        $youhuiyuan = "1";
      }else{
        $youhuiyuan = "0";
      }
      //会员权益
      if ($_REQUEST['hyqy']=="true") {
        $hyqy = "1";
      }else{
        $hyqy = "0";
      }

      //是否上架
      if($_REQUEST['status']=='true'){
          $x_status='1';
      }else{
          $x_status='0';
      }
      //查询项目所属分类
      $x_parenttype = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_parentid=0 and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$_REQUEST['sshy']));
      $typs = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0 and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$_REQUEST['erjifl']));
        $data = array(
          "uniacid"=>$uniacid,
          "x_name"=>$_REQUEST['server_name'],            //项目名称
          "x_type"=>$typs['xt_id'],                      //项目所属分类
          "x_parenttype"=>$x_parenttype['xt_id'],        
          "x_xingshi"=>$_REQUEST['fwlx'],                //服务形式
          "x_thumb"=>$_REQUEST['logo'],                  //项目图片
          "x_thumbs"=>$x_hdp_thumb,                         //项目幻灯片
          "x_pay_type"=>$_REQUEST['pay_type'],           //服务付款方式 
          "x_pay_bili"=>$_REQUEST['djzb'],               //服务付款金额比例
          "x_pay_smgj"=>$_REQUEST['smfy'],               //上门估计费用
          "x_guigecontent"=>$x_guigecontent,             //服务规格
          "x_guigename"=>$_REQUEST['guige_name'],        //服务规格名称
          "x_content"=>$_REQUEST['tips'],                //项目简述
          "x_jianjie_thumb"=>$x_jianjie_thumb,           //项目简介图片
          "x_wenxintishi"=>$_REQUEST['wxts'],            //温馨提示
          "x_jiage"=>$_REQUEST['money'],                 //项目价格
          "x_danwei"=>$_REQUEST['danwei'],               //项目单位
          "x_xiaoliang"=>"0",                            //销量
          "x_status"=>$x_status,                         //是否上架
          "x_shangjia"=>$sjname['s_id'],                   //所属商家
          "x_jifenstatus"=>$jifen,                       //积分是否开启
          "x_jifen"=>$_REQUEST['jifen'],                 //积分
          "x_manjianstatus"=>$manjian,                   //满减是否开启
          "x_manjian"=>$_REQUEST['manjian_id'],          //满减
          "x_huiyuanstatus"=>$hyqy,                      //会员权益
          "x_youhuiquanstatus"=>$youhuiyuan,             //优惠券是否开启
          "x_youhuiquan"=>$_REQUEST['youhuiquan_id'],    //优惠券         
        );
        if (empty($_REQUEST['x_id'])) {         
          $res = pdo_insert("hyb_o2o_fuwu",$data);
        }else{
          $res = pdo_update("hyb_o2o_fuwu",$data,array("x_id"=>$_REQUEST['x_id']));
        }
    }

    //查询商家服务
    public function doPageSjfuwu()
    {
       global $_W,$_GPC;
       $uniacid = $_W['uniacid'];
       $openid = $_REQUEST['openid'];
       $current = $_REQUEST['current'];
       //查询商家
       $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
       if ($current=="0") {
         $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid  and x_status=1 and x_shangjia=:x_shangjia order by x_id desc ",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
       }else if ($current=="1") {
         $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid  and x_status=0 and x_shangjia=:x_shangjia order by x_id desc ",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
       }
       if (!empty($list)) {
          foreach ($list as &$value) {
              if(strpos($value['x_thumb'],"http")===false){
                $value['x_thumb'] = $_W['attachurl'].$value['x_thumb'];
              }
          }
       }
       
       return $this->result(0,"success",$list);
    }
    //查询商家服务详情
    public function doPageSjfuwuxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $x_id = $_REQUEST['x_id'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$x_id));
        $type = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")."where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$list['x_type']));
        $types = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")."where uniacid=:uniacid and xt_id=:xt_id",array(":uniacid"=>$uniacid,":xt_id"=>$type['xt_parentid']));
        $list['x_er_type']=$type['xt_name'];
        $list['x_yi_type']=$types['xt_name'];
        if (strpos($list['x_thumb'],"http")===false) {
             $list['x_thumb'] = $_W['attachurl'].$list['x_thumb'];
        }
        $list['x_thumbs'] = unserialize($list['x_thumbs']);
        $list['x_jianjie_thumb'] = unserialize($list['x_jianjie_thumb']);
        $list['x_guigecontent'] = unserialize($list['x_guigecontent']);
        foreach ($list['x_thumbs'] as &$value) {
          if (strpos($value,"http")===false) {
             $value = $_W['attachurl'].$value;
          }
        }
        foreach ($list['x_jianjie_thumb'] as &$values) {
          if (strpos($values,"http")===false) {
             $values = $_W['attachurl'].$values;
          }
        }
        return $this->result(0,"success",$list);
    }

    //商品下单
    public function doPageDingdangoods()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $g_id = $_REQUEST['g_id'];
      //查询商品
      $goods = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$g_id));
      if (empty($_REQUEST['guigejia'])) {
            $data = array(
            "uniacid"=>$uniacid,
            "openid"=>$_REQUEST['openid'],
            "ordersn"=>date("Ymd").str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT),
            "o_name" =>$_REQUEST['name'],    
            "o_telphone"=>$_REQUEST['tel'],
            "o_xxaddress"=>$_REQUEST['detailInfo'],
            "o_address"=>$_REQUEST['location'],
            "o_gid"=>$g_id,
            "o_goodsname"=>$goods['g_name'],      //商品名称
            "o_goodsthumb"=>$goods['g_thumb'],    //商品图片
            "o_goodsguige"=>$_REQUEST['fwgg'],
            "o_num"=>$_REQUEST['num'],            //商品数量
            "o_monney"=>$goods['g_jiage'],          //商品单价
            "o_count_money"=>$_REQUEST['money'],            //商品总价
            "o_kuaidi"=>$goods['g_kuaidi'],                              //快递费
            "o_beizhu"=>$_REQUEST['liuyan'],                //备注
            "o_xdtime"=>date("Y-m-d H:i:s",time()),                           //下单时间
            "o_type"=>"未支付",  //支付状态                       
            );
      }else{
            $data = array(
            "uniacid"=>$uniacid,
            "openid"=>$_REQUEST['openid'],
            "ordersn"=>date("Ymd").str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT),
            "o_name" =>$_REQUEST['name'],    
            "o_telphone"=>$_REQUEST['tel'],
            "o_xxaddress"=>$_REQUEST['detailInfo'],
            "o_address"=>$_REQUEST['location'],
            "o_gid"=>$g_id,
            "o_goodsname"=>$goods['g_name'],      //商品名称
            "o_goodsthumb"=>$goods['g_thumb'],    //商品图片
            "o_goodsguige"=>$_REQUEST['fwgg'],
            "o_num"=>$_REQUEST['num'],            //商品数量
            "o_monney"=>$_REQUEST['guigejia'],          //商品单价
            "o_count_money"=>$_REQUEST['money'],            //商品总价
            "o_kuaidi"=>$goods['g_kuaidi'],                              //快递费
            "o_beizhu"=>$_REQUEST['liuyan'],                //备注
            "o_xdtime"=>date("Y-m-d H:i:s",time()),                           //下单时间
            "o_type"=>"未支付",                                //支付状态
            );
      }
      
        $res = pdo_insert("hyb_o2o_ordergoods",$data);
        $lastid=pdo_insertid();
        return $this-> result(0,'success',$lastid);
    }
    //查询商品订单详情
    public function doPageOrdergoodsxq()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $o_id = $_REQUEST['o_id'];
      $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
      //查询用户余额
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$order['openid']));
      $order['user_money'] = $user['u_money'];
      $order['o_goodsthumb'] = $_W['attachurl'].$order['o_goodsthumb'];
      return $this->result(0,"success",$order);
    }

    //商品下单支付
    public function doPagePayordergoods()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $o_id = $_REQUEST['o_id'];
      $form_id = $_REQUEST['form_id'];
      $typs = $_REQUEST['typs'];
      $data = array("o_pay_type"=>$typs,"o_type"=>"已付款","o_xdtime"=>date("Y-m-d H:i:s",time()));
      $res = pdo_update("hyb_o2o_ordergoods",$data,array("o_id"=>$o_id));
      if ($res) {
        $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        //查询订单信息
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_ordergoods")." WHERE uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        //查询商品信息
        $goods = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$order['o_gid']));
        $g_xiaoliang = $goods['g_xiaoliang']+1;
        $datas = array("g_xiaoliang"=>$g_xiaoliang);
        $save  = pdo_update("hyb_o2o_goods",$datas,array("g_id"=>$order['o_gid']));
        if ($typs=="余额") {
            

          //查询用户
          $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
          //余额限制
          $money = $user['u_money']-$order['o_count_money'];
          $datass = array("u_money"=>$money);
          pdo_update("hyb_o2o_userinfo",$datass,array("u_id"=>$user['u_id']));
        }
            $APPID = $result['appid'];
            $SECRET = $result['appsecret'];
            $template_id = $moban['spzf'];
            $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
            $getArr=array();
            $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
            $access_token=$tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
            /*单号、商品名称、数量、金额、支付时间、支付状态*/
            $value = array(
                        "keyword1"=>array(
                        "value"=> $order['ordersn'],
                        "color"=>"#4a4a4a"
                        ),
                        "keyword2"=>array(
                            "value"=>$order['o_goodsname'],
                            "color"=>"#9b9b9b"
                        ),
                        "keyword3"=>array(
                            "value"=>$order['o_num'],
                            "color"=>"#9b9b9b"
                        ),
                        "keyword4"=>array(
                            "value"=>$order['o_count_money'],
                            "color"=>"#9b9b9b"
                        ), 
                        "keyword5"=>array(
                            "value"=>$order['o_xdtime'],
                            "color"=>"#9b9b9b"
                        ),
                        "keyword6"=>array(
                            "value"=>$order['o_type'],
                            "color"=>"#9b9b9b"
                        ),
                    );
            $dd = array();
            $dd['touser']=$openid;
            $dd['template_id']=$template_id;
            $dd['page']="hyb_o2o/orders/orders?id=2&typs=yonghu";  //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
            $dd['form_id']=$form_id;
            $dd['data']=$value;                        //模板内容，不填则下发空模板
            $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
            $result = $this->https_curl_json($url,$dd,'json');
      }
    }
  //添加商品评价
  public function doPageAddgoodspingjia()
  {
    global $_GPC,$_W;
    $uniacid = $_W['uniacid'];
    $openid =  $_REQUEST['openid'];
    $o_id = $_REQUEST['o_id'];
    $list = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
    $user = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_userinfo")."where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
    $data = array("o_pingjia"=>"1");
    pdo_update("hyb_o2o_ordergoods",$data,array("o_id"=>$o_id));
    $imgpath = $_REQUEST['p_pic'];
    $imgpath = str_replace('"',"",str_replace("]","",str_replace("[","", $imgpath)));
    if (empty($imgpath)) {
      $imgpaths = ""; 
    }else{
      $imgpath = explode(",",$imgpath);
      $imgpaths = serialize($imgpath);
    }   
    $datas=array(
      'uniacid' => $uniacid,
      'p_openid' => $openid,
      'p_name' => $user['u_name'],
      'p_thumb' => $user['u_thumb'],
      'p_content' => $_REQUEST['p_content'],
      'p_pic' => $imgpaths,
      'p_sid' =>  $list['o_gid'],
      "p_fenshu"=>$_REQUEST['sp_pingfen'],
      'p_time' => date("Y-m-d H:i:s",time()),
    );
    pdo_insert("hyb_o2o_goodspingjia",$datas);
  }


    //会员列表
    public function doPageHuiyuan()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        foreach ($list as &$value) {
            $value['h_thumb'] = $_W['attachurl'].$value['h_thumb'];
        }
        return $this->result(0,"success",$list);
    }

    //会员详情
    public function doPageHuiyuanxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $h_id = $_REQUEST['h_id'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid and h_id=:h_id",array(":uniacid"=>$uniacid,":h_id"=>$h_id));
        return $this->result(0,"success",$list);
    }

    //会员办理
    public function doPagePayhycz()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $form_id = $_REQUEST['form_id'];
        $openid = $_REQUEST['openid'];
        $h_id = $_REQUEST['h_id'];
        //查询会员
        $huiyuan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid and h_id=:h_id",array(":uniacid"=>$uniacid,":h_id"=>$h_id));
        //查询用户
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,':openid'=>$openid));
        $h_time = $huiyuan['h_time'];
        if(empty($user['u_typeendtime']) || $user['u_typeendtime']=="已到期"){
            $time = date("Y-m-d H:i:s",time());
            $times = date('Y-m-d H:i:s', strtotime("$time +$h_time day"));
        }else{
            $time = $user['u_typeendtime'];
            $times = date('Y-m-d H:i:s', strtotime("$time +$h_time day"));
        }
        $datas = array("uniacid"=>$uniacid,"openid"=>$openid,"time"=>date("Y-m-d H:i:s",time()),"money"=>$huiyuan['h_money'],"jibie"=>$huiyuan['h_id'],"song"=>$huiyuan['h_song']);
        $save = pdo_insert("hyb_o2o_userchongzhi",$datas);
        $u_money = $user['u_money']+$huiyuan['h_song']+$huiyuan['h_money'];
        $data = array("u_type"=>$huiyuan['h_id'],"u_typeendtime"=>$times,"u_money"=>$u_money);
        $res = pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
        if ($res) {
          $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $APPID = $result['appid'];
          $SECRET = $result['appsecret'];
          $template_id = $moban['chongzhi'];
          $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
          $getArr=array();
          $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
          $access_token=$tokenArr->access_token;
          $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
          /*充值类型、充值金额、到期时间*/
          $value = array(
            "keyword1"=>array(
              "value"=> $huiyuan['h_name'],
              "color"=>"#4a4a4a"
            ),
            "keyword2"=>array(
              "value"=>$huiyuan['h_money'],
              "color"=>"#9b9b9b"
            ),
            "keyword3"=>array(
              "value"=>$times,
              "color"=>"#9b9b9b"
            ),
          );
          $dd = array();
          $dd['touser']=$openid;
          $dd['template_id']=$template_id;
          $dd['page']="hyb_o2o/mine/mine";  //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
          $dd['form_id']=$form_id;
          $dd['data']=$value;                        //模板内容，不填则下发空模板
          $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
          $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
          $result = $this->https_curl_json($url,$dd,'json');
        }
    }

    //添加我的优惠券
    public function doPageMyyhq()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $x_id = $_REQUEST['x_id'];
      $y_id = $_REQUEST['y_id'];
      $openid = $_REQUEST['openid'];
      $type="未使用";
      $data = array(
          "uniacid"=>$uniacid,
          "openid"=>$openid,
          "x_id"=>$x_id,
          "y_name"=>$y_id,
          "type"=>$type,
        );
      pdo_insert("hyb_o2o_useryouhuiquan",$data);
    }

    //查询员工入驻所需的数据[商家/服务地区/技能]
    public function doPageYgrzsj()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $city = $_REQUEST['city'];
        //查询当前城市商家
        $time = date("Y-m-d H:i:s",time());
        $shangjia = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid  and ruzhu_endtime!=:ruzhu_endtime and ruzhu_endtime>'".$time."' and s_status=:s_status and s_address like '%$city%' ",array(":uniacid"=>$uniacid,":ruzhu_endtime"=>"已到期","s_status"=>"审核通过"));
        //查询当前城市二级区域
        $city = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and name=:name and parentid=0",array(":uniacid"=>$uniacid,":name"=>$city));
        $diqu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=:parentid",array(":uniacid"=>$uniacid,":parentid"=>$city['id']));
        //查询技能
        $jineng = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." where uniacid=:uniacid and xt_parentid!=0",array(":uniacid"=>$uniacid));
        $list['shangjia'] = $shangjia;
        $list['diqu'] = $diqu;
        $list['jineng'] = $jineng;
        return $this->result(0,"success",$list);
    }
    //员工注册修改
    public function doPageYuangongzhuce(){
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid=$_REQUEST['openid'];
      if ($_REQUEST['come']=='js') {
        //查询平台商家信息
        $ptsj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
        $s_id = $ptsj['s_id'];
        $ruzhu = "1";
      }
      elseif ($_REQUEST['come']=='yg'){
        //查询商家id
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_name=:s_name",array(":uniacid"=>$uniacid,":s_name"=>$_REQUEST['merchant']));
        $s_id = $shangjia['s_id'];
        $ruzhu = "0";
      }
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
      $quyu = $_REQUEST['fwqy'];
      $quyu = str_replace('"',"",str_replace("]","",str_replace("[","", $quyu)));
      $quyu = explode(",",$quyu);
      $quyu = serialize($quyu);
      $jineng = $_REQUEST['jinneng'];
      $jineng = str_replace('"',"",str_replace("]","",str_replace("[","", $jineng)));
      $jineng = explode(",",$jineng);
      $jineng = serialize($jineng);
      $data = array(
        "uniacid"=>$uniacid,
        "y_name"=>$_REQUEST['name'],
        "y_openid"=>$_REQUEST['openid'],
        "y_thumb"=>$user['u_thumb'],
        "y_sex"=>$_REQUEST['gender'],
        "y_age"=>$_REQUEST['age'],
        "y_telphone"=>$_REQUEST['telphone'],
        "y_sjname"=>$s_id,
        "y_imgpath1"=>$_REQUEST['IDcard1'],
        "y_imgpath2"=>$_REQUEST['IDcard2'],
        "y_fwqy"=>$quyu,
        "y_jineng"=>$jineng,
        "y_jdnum"=>$_REQUEST['distance'],
        "y_styles"=>"待审核",
        "y_time"=>date("Y-m-d H:i",time()),
        "y_typs"=>"空闲中",
        "y_rz"=>$ruzhu,
        "form_id"=>$_REQUEST['form_id'],
      );
      $typs = $_REQUEST['typs'];
      if ($typs=="修改") {
        $res = pdo_update("hyb_o2o_yuangong",$data,array("y_openid"=>$_REQUEST['openid']));
        
      }
      if ($typs=="发布") {
        //查询员工是否存在
        $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
        if (!empty($yg)) {
            $res = pdo_update("hyb_o2o_yuangong",$data,array("y_openid"=>$_REQUEST['openid']));
        }else{
            $res = pdo_insert("hyb_o2o_yuangong",$data);
        } 
      }
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$_REQUEST['openid']));
      $datas = array("u_yuangong"=>"待审核","u_shangjia"=>"0");
      $save = pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));


    require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
    $params = array ();
    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
    $accessKeyId = $aliduanxin['accessKeyId'];
    $accessKeySecret = $aliduanxin['accessKeySecret'];

    /*通知用户*/
    $params["PhoneNumbers"] = $shangjia['s_telphone'];         //接收人手机号
    $params["SignName"] = $aliduanxin['SignName'];
    $params["TemplateCode"] = $aliduanxin['rztz'];
    $params['TemplateParam'] = Array (
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

    //查询员工详情
    public function doPageYuangongxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
        if (!empty($info)) {
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":s_id"=>$info['y_sjname'],":uniacid"=>$uniacid));
          $info['s_name'] = $shangjia['s_name'];
          $info['y_fwqy'] = unserialize($info['y_fwqy']);
          $info['y_jineng'] = unserialize($info['y_jineng']);
          if (strpos($info['y_imgpath1'],"http")===false) {
            $info['y_imgpath1'] = $_W['attachurl'].$info['y_imgpath1'];
          }
          if (strpos($info['y_imgpath2'],"http")===false) {
            $info['y_imgpath2'] = $_W['attachurl'].$info['y_imgpath2'];
          }
          //查询员工所属商家是否为平台
          $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
          if ($pingtai['s_id']==$info['y_sjname']) {
            $ptyg = "true";
          }else{
            $ptyg = "false";
          }
          $info['ptyg'] = $ptyg;
        }
        return $this->result(0,"success",$info);
    }
   //查询商家全部员工
    public function doPageYuangonglist()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
      if ($_REQUEST['come']=="guanli") {
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_sjname=:y_sjname and y.y_styles!='待审核' order by y.y_time desc ",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
      }
      if ($_REQUEST['come']=="zhipai") {
        if ($shangjia['pingtai']=='1') {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_sjname=:y_sjname and y.y_styles!='待审核' and y.y_jin=0 and y_rz=1",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
        }else{
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_sjname=:y_sjname and y.y_styles!='待审核' and y.y_jin=0",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
        }
        
      }
      if ($_REQUEST['come']=='zhipaidingdan') {
        if ($shangjia['pingtai']=='1') {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_sjname=:y_sjname and y.y_styles!='待审核' and y.y_jin=0 and y_rz=0",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
        }else{
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_sjname=:y_sjname and y.y_styles!='待审核' and y.y_jin=0",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id']));
        }
        
      }
      foreach ($list as &$value) {
        //查询接单数
          $count1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_pdname=:q_pdname ",array(":uniacid"=>$uniacid,":q_pdname"=>$value['y_id']));
          $count2 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_openid=:q_openid ",array(":uniacid"=>$uniacid,":q_openid"=>$value['y_openid']));
          $count3 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_fwry=:o_fwry and o_store=:o_store",array(":uniacid"=>$uniacid,":o_fwry"=>$value['y_name'],":o_store"=>$value['y_sjname']));
        //查询评分
          $pingfens = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_paidanpingjia")." WHERE uniacid=:uniacid and pj_yuangong=:pj_yuangong",array(":uniacid"=>$uniacid,":pj_yuangong"=>$value['y_id']));
          $pingfencount = count($pingfens);
          $pingfen = "";
          foreach ($pingfens as $key2 => $value2) {
              $pingfen+=$value2['pj_fen'];
          }
          $pingfen = sprintf('%.1f',$pingfen/$pingfencount);
          $value['pingfen'] = $pingfen;
          $value['jdnum'] = $count1+$count2+$count3;
      }
      return $this->result(0,"success",$list);
    }

    //查询商家待审核员工
    public function doPageYuangongshenhe()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
      $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_sjname=:y_sjname and y_styles=:y_styles order by y_time desc ",array(":uniacid"=>$uniacid,":y_sjname"=>$shangjia['s_id'],":y_styles"=>"待审核"));
      if (!empty($list)) {
          foreach ($list as &$value) {
              $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid ",array(":uniacid"=>$uniacid,":openid"=>$value['y_openid']));
              $value['u_thumb'] = $user['u_thumb'];
          }    
      }
      return $this->result(0,"success",$list);
    } 

    //员工审核
    public function doPageYuangongshenhesave()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $y_id = $_REQUEST['y_id'];
      $typs = $_REQUEST['typs'];
      //查询员工信息
      $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_shangjia")." as s on y.y_sjname=s.s_id where y.uniacid=:uniacid and y.y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));
      //查询用户信息
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$list['y_openid']));
      if ($typs=="通过") {
        $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $data = array("y_styles"=>"审核通过","y_typs"=>"空闲中","y_jin"=>"0");
        pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$y_id));
        pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>$list['s_id']),array("u_id"=>$user['u_id']));
        if ($list['pingtai']=="1") {
            if ($list['y_rz']=='1') {
                $shenqing = "申请入驻商家".$list['s_name']."技师";
            }else{
                $shenqing = "申请入驻商家".$list['s_name']."员工";
            }    
        }elseif ($list['pingtai']=="0") {
            $shenqing = "申请入驻商家".$list['s_name']."员工";
        }
            $APPID = $result['appid'];
            $SECRET = $result['appsecret'];
            $template_id = $moban['ygsh'];
            $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
            $getArr=array();
            $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
            $access_token=$tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
            /*申请人、申请项目、审核结果、申请时间*/
            $value = array(
              "keyword1"=>array(
                "value"=> $list['y_name'],
                "color"=>"#4a4a4a"
              ),
              "keyword2"=>array(
                "value"=>$shenqing,
                "color"=>"#9b9b9b"
              ),
              "keyword3"=>array(
                "value"=>"审核通过",
                "color"=>"#9b9b9b"
              ),
              "keyword4"=>array(
                "value"=>$list['y_time'],
                "color"=>"#9b9b9b"
              ),
            );
            $dd = array();
            $dd['touser']=$list['y_openid'];
            $dd['template_id']=$template_id;
            $dd['page']="hyb_o2o/mine/mine";  //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
            $dd['form_id']=$list['form_id'];
            $dd['data']=$value;                        //模板内容，不填则下发空模板
            $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
            $result = $this->https_curl_json($url,$dd,'json');
      }else if ($typs=="拒绝") {
        if ($list['pingtai']=="1") {
            if ($list['y_rz']=='1') {
                $shenqing = "申请入驻商家".$list['s_name']."技师";
            }else{
                $shenqing = "申请入驻商家".$list['s_name']."员工";
            }
        }elseif ($list['pingtai']=="0") {
            $shenqing = "申请入驻商家".$list['s_name']."员工";
        }
          $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
          $APPID = $result['appid'];
          $SECRET = $result['appsecret'];
          $template_id = $moban['ygsh'];
          $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
          $getArr=array();
          $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
          $access_token=$tokenArr->access_token;
          $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
            /*申请人、申请项目、审核结果、申请时间*/
          $value = array(
              "keyword1"=>array(
                "value"=> $list['y_name'],
                "color"=>"#4a4a4a"
              ),
              "keyword2"=>array(
                "value"=>$shenqing,
                "color"=>"#9b9b9b"
              ),
              "keyword3"=>array(
                "value"=>"拒绝通过",
                "color"=>"#9b9b9b"
              ),
              "keyword4"=>array(
                "value"=>$list['y_time'],
                "color"=>"#9b9b9b"
              ),
          );
          $dd = array();
          $dd['touser']=$list['y_openid'];
          $dd['template_id']=$template_id;
          $dd['page']="hyb_o2o/mine/mine";  //点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
          $dd['form_id']=$list['form_id'];
          $dd['data']=$value;                        //模板内容，不填则下发空模板
          $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
          $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
          $result = $this->https_curl_json($url,$dd,'json');
          $y_id = $_REQUEST['y_id'];
          $res = pdo_delete("hyb_o2o_yuangong",array("y_id"=>$y_id));
      }
      
    }

    //员工接单[禁止或不禁止]
    public function doPageYuangongjz(){
      global $_W,$_GPC;
      $y_id = $_REQUEST['id'];
      $jin = $_REQUEST['jin'];
      $data = array("y_jin"=>$jin);
      $res =pdo_update("hyb_o2o_yuangong",$data,array("y_id"=>$y_id));
    }

    //员工删除
    public function doPageYuangongshenhesc()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $y_id =  $_REQUEST['y_id'];
        $yguserinfo=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,"y_id"=>$y_id));
        $userinfo=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,"openid"=>$yguserinfo['y_openid']));
        pdo_update("hyb_o2o_userinfo",array("u_yuangong"=>0),array("u_id"=>$userinfo['u_id']));
        pdo_delete("hyb_o2o_yuangong",array("y_id"=>$y_id));
    }

    //服务下单
    public function doPageDingdanfw()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $x_pay_type = $_REQUEST['x_pay_type'];
        $openid = $_REQUEST['openid'];
        $ordersn = date("Ymd").str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT);
        //查询项目
        $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$_REQUEST['x_id']));
        if (!empty($_REQUEST['guige_money'])) {
          $count_money = $_REQUEST['guige_money']*$_REQUEST['num'];
        }else{
          $count_money = $_REQUEST['xiangmu_money']*$_REQUEST['num'];
        }
        //查询用户是否为会员
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,"openid"=>$openid));
        if ($xiangmu['x_huiyuanstatus']=="1") {
              if ($user['u_type']!="0" && $user['u_typeendtime']>date("Y-m-d H:i:s",time()) && $user['u_typeendtime']!="已到期") {
                  //查询会员折扣
                  $zhekou = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_huiyuan")." where uniacid=:uniacid and h_id=:h_id",array(":uniacid"=>$uniacid,":h_id"=>$user['u_type']));

                  $huiyaunyouhui = $count_money-(0.1*$zhekou['h_zhekou']*$count_money);
                  $count_money = $count_money*0.1*$zhekou['h_zhekou'];
                  if ($xiangmu['x_youhuiquanstatus']=="1") {
                    //查询用户是否领取了优惠券
                    $time = date("Y-m-d",time());
                    $useryouhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")."  where uniacid=:uniacid and openid=:openid and x_id=:x_id and type=:type",array(":uniacid"=>$uniacid,":openid"=>$openid,":x_id"=>$xiangmu['x_id'],":type"=>"未使用"));
                    $youhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$useryouhuiquan['y_name']));

                    if (!empty($youhuiquan) && $youhuiquan['y_yaoqiu']=="会员可使用" || $youhuiquan['y_yaoqiu']=="两者均可使用") {
                      $count_money = $count_money-$youhuiquan['y_money'];
                      // var_dump($count_money);
                      if ($count_money<"0") {
                        $count_money="0";
                      }
                      $youhuiquanyouhui = $youhuiquan['y_money'];                 
                    }
                  }
              }else{
                if ($xiangmu['x_youhuiquanstatus']=="1") {
                      //查询用户是否领取了优惠券
                      $time = date("Y-m-d",time());
                      $useryouhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")."  where uniacid=:uniacid and openid=:openid and x_id=:x_id and type=:type",array(":uniacid"=>$uniacid,":openid"=>$openid,":x_id"=>$xiangmu['x_id'],":type"=>"未使用"));
                      $youhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$useryouhuiquan['y_name']));
                      // var_dump($youhuiquan);
                      if (!empty($youhuiquan) && ($youhuiquan['y_yaoqiu']=="普通用户可使用" || $youhuiquan['y_yaoqiu']=="两者均可使用")) {
                         // var_dump($count_money);
                         // var_dump($youhuiquan['y_money']);
                        $count_money = $count_money-$youhuiquan['y_money'];
                        // var_dump($count_money);
                        if ($count_money<0) {
                          $count_money = 0;
                        }
                        // var_dump($count_money);
                        $youhuiquanyouhui = $youhuiquan['y_money'];                 
                      }
                }
                if ($xiangmu['x_manjianstatus']=="1") {
                    //查询满减活动
                    $manjian = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and m_id=:m_id",array(":uniacid"=>$uniacid,":m_id"=>$xiangmu['x_manjian']));
                    if (!empty($manjian) && $count_money>=$manjian['m_money']) {
                      $count_money = $count_money-$manjian['j_money'];
                      if ($count_money<0) {
                          $count_money = 0;
                        }
                      $manjianyouhui = $manjian['j_money'];
                    }
                }
            }
        }else{
            if ($xiangmu['x_youhuiquanstatus']=="1") {
                  //查询用户是否领取了优惠券
                  $time = date("Y-m-d",time());
                  $useryouhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")."  where uniacid=:uniacid and openid=:openid and x_id=:x_id and type=:type",array(":uniacid"=>$uniacid,":openid"=>$openid,":x_id"=>$xiangmu['x_id'],":type"=>"未使用"));
                  $youhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$useryouhuiquan['y_name']));
                  // var_dump($youhuiquan);exit();
                  if (!empty($youhuiquan) && ($youhuiquan['y_yaoqiu']=="普通用户可使用" || $youhuiquan['y_yaoqiu']=="两者均可使用")) {
                     // var_dump($count_money);
                     // var_dump($youhuiquan['y_money']);
                    $count_money = $count_money-$youhuiquan['y_money'];
                    // var_dump($count_money);
                    if ($count_money<0) {
                      $count_money = 0;
                    }
                    // var_dump($count_money);
                    $youhuiquanyouhui = $youhuiquan['y_money'];                 
                  }
            }
            if ($xiangmu['x_manjianstatus']=="1") {
                //查询满减活动
                $manjian = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_manjian")." where uniacid=:uniacid and m_id=:m_id",array(":uniacid"=>$uniacid,":m_id"=>$xiangmu['x_manjian']));
                if (!empty($manjian) && $count_money>=$manjian['m_money']) {
                  $count_money = $count_money-$manjian['j_money'];
                  if ($count_money<0) {
                      $count_money = 0;
                    }
                  $manjianyouhui = $manjian['j_money'];
                }
            }

        }

        //核销码数字
        $hexiaomashuzi = str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT);
        //获取经纬度
        $base = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
        if ($base['gaodekey']) {
            //获取收货地址经纬度
            $addressUrl="https://restapi.amap.com/v3/geocode/geo?key=".$base['gaodekey']."&address=".$_REQUEST['location'].$_REQUEST['detailInfo'];
        }else{
            //获取收货地址经纬度
            $addressUrl="https://restapi.amap.com/v3/geocode/geo?key=29c069a05a449fcea6caf90030902d98&address=".$_REQUEST['location'].$_REQUEST['detailInfo'];
        }
        $getArr=array();
        $localtionlat=json_decode($this->send_post($addressUrl,$getArr,"GET"),true);    
        $o_ding_money = $count_money*$xiangmu['x_pay_bili']*0.01;
        $service_info=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE y_id=:y_id ",array(":y_id"=>$_REQUEST['fwry']));
        $service_id=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE openid=:openid ",array(":openid"=>$service_info['y_openid']));
        if ($x_pay_type=="定金支付") {
          $data = array(
            "uniacid"               => $uniacid,
            "openid"                => $openid,
            "ordersn"               => $ordersn,
            "o_name"                => $_REQUEST['name'],
            "o_telphone"            => $_REQUEST['tel'],
            "o_address"             => $_REQUEST['location'],
            "o_xxaddress"           => $_REQUEST['detailInfo'],
            "o_xid"                 => $_REQUEST['x_id'],
            "o_xiangmu_name"        => $xiangmu['x_name'],
            "o_xiangmu_thumb"       => $xiangmu['x_thumb'],
            "o_xiangmu_money"       => $_REQUEST['xiangmu_money'],
            "o_xiangmu_xingshi"     => $xiangmu['x_xingshi'],
            "o_xiangmu_guige"       => $_REQUEST['fwgg'],
            "o_xiangmu_guigemoney"  => $_REQUEST['guige_money'],
            "o_num"                 => $_REQUEST['num'],
            "o_yy_riqi"             => $_REQUEST['yydate']." ".$_REQUEST['yytime'],
            "o_fwry"                => $service_info['y_name'],
            "o_ding_money"          => $o_ding_money,
            "o_sheng_money"         => $count_money-$o_ding_money,
            "o_count_money"         => $count_money,
            "o_beizhu"              => $_REQUEST['liuyan'],
            "o_xdtime"              => date("Y-m-d H:i:s",time()),
            "o_pay_type"            => "定金支付",
            "o_pay_types"           => "0",
            "o_type"                => "未支付",
            "o_store"               => $_REQUEST['store'],
            "o_huiyaunyouhui"       => $huiyaunyouhui,
            "o_youhuiquanyouhui"    => $youhuiquanyouhui,
            "o_manjianyouhui"       => $manjianyouhui,
            "o_hexiaomashuzi"       => $hexiaomashuzi,
            "o_localtion"           => $localtionlat['geocodes'][0]['location'],
            "o_uid"                 => $user['u_id'],
            "o_fwry_id"             => $service_id['u_id']
          );
          
          $res = pdo_insert("hyb_o2o_orderfuwu",$data);
          $o_id = pdo_insertid();    
        }
        if ($x_pay_type=="全额付款") {
          $data = array(
            "uniacid"=>$uniacid,
            "openid"=>$openid,
            "ordersn"=>$ordersn,
            "o_name" =>$_REQUEST['name'],
            "o_telphone"=>$_REQUEST['tel'],
            "o_address"=>$_REQUEST['location'],
            "o_xxaddress"=>$_REQUEST['detailInfo'],
            "o_xid"=>$_REQUEST['x_id'],
            "o_xiangmu_name" => $xiangmu['x_name'],
            "o_xiangmu_thumb"=>$xiangmu['x_thumb'],
            "o_xiangmu_money"=>$_REQUEST['xiangmu_money'],
            "o_xiangmu_xingshi"=>$xiangmu['x_xingshi'],
            "o_xiangmu_guige"=>$_REQUEST['fwgg'],
            "o_xiangmu_guigemoney"=>$_REQUEST['guige_money'],
            "o_num"=>$_REQUEST['num'],
            "o_yy_riqi"             => $_REQUEST['yydate']." ".$_REQUEST['yytime'],
            "o_fwry"=>$service_info['y_name'],
            "o_ding_money"=>"0",
            "o_count_money"=>$count_money,
            "o_beizhu"=>$_REQUEST['liuyan'],
            "o_xdtime"=>date("Y-m-d H:i:s",time()),
            "o_pay_type"=>"全额付款",
            "o_type"=>"未支付",
            "o_store"=>$_REQUEST['store'],
            "o_huiyaunyouhui"=>$huiyaunyouhui,
            "o_youhuiquanyouhui"=>$youhuiquanyouhui,
            "o_manjianyouhui"=>$manjianyouhui,
            "o_hexiaomashuzi"=>$hexiaomashuzi,
            "o_localtion"           => $localtionlat['geocodes'][0]['location'],
            "o_uid"                 => $user['u_id'],
            "o_fwry_id"             => $service_id['u_id']
          );
          $res = pdo_insert("hyb_o2o_orderfuwu",$data);
          $o_id = pdo_insertid();     
        }

        if ($x_pay_type=="上门估价") {
          $data = array(
            "uniacid"=>$uniacid,
            "openid"=>$openid,
            "ordersn"=>$ordersn,
            "o_name" =>$_REQUEST['name'],
            "o_telphone"=>$_REQUEST['tel'],
            "o_address"=>$_REQUEST['location'],
            "o_xxaddress"=>$_REQUEST['detailInfo'],
            "o_xid"=>$_REQUEST['x_id'],
            "o_xiangmu_name" => $xiangmu['x_name'],
            "o_xiangmu_thumb"=>$xiangmu['x_thumb'],
            "o_xiangmu_money"=>$_REQUEST['xiangmu_money'],
            "o_xiangmu_xingshi"=>$xiangmu['x_xingshi'],
            "o_xiangmu_guige"=>$_REQUEST['fwgg'],
            "o_xiangmu_guigemoney"=>$_REQUEST['guige_money'],
            "o_num"=>$_REQUEST['num'],
            "o_yy_riqi"             => $_REQUEST['yydate']." ".$_REQUEST['yytime'],
            "o_fwry"=>$service_info['y_name'],
            "o_shangmen_money"=>$_REQUEST['money'],
            "o_count_money"=>"0",
            "o_beizhu"=>$_REQUEST['liuyan'],
            "o_xdtime"=>date("Y-m-d H:i:s",time()),
            "o_pay_type"=>"上门估价",
            "o_type"=>"未支付",
            "o_store"=>$_REQUEST['store'],
            "o_huiyaunyouhui"=>$huiyaunyouhui,
            "o_youhuiquanyouhui"=>$youhuiquanyouhui,
            "o_manjianyouhui"=>$manjianyouhui,
            "o_hexiaomashuzi"=>$hexiaomashuzi,
            "o_localtion"           => $localtionlat['geocodes'][0]['location'],
            "o_uid"                 => $user['u_id'],
            "o_fwry_id"             => $service_id['u_id']
          );
          // var_dump($data);exit();
          $res = pdo_insert("hyb_o2o_orderfuwu",$data);
          $o_id = pdo_insertid();     
        }
        //插入服务订单统计表
        $service['date']=$_REQUEST['yydate'];
        $service['time']=$_REQUEST['yytime'];
        $service['uniacid']=$uniacid;
        $service['o_id']=$o_id;
        $service['x_id']=$_REQUEST['x_id'];
        $ordercountres = pdo_insert("hyb_o2o_fuwu_time",$service);
        return $this->result(0,"success",$o_id);

 
    }
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }
     
        return $obj;
    }
    //查询订单支付详情
    public function doPageOrderfuxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $o_id = $_REQUEST['o_id'];
        $openid = $_REQUEST['openid'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." as o left join ".tablename("hyb_o2o_fuwu")." as f on o.o_xid=f.x_id where o.uniacid=:uniacid and o.o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        //查询用户余额
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        
        if ($user['u_money']=="null" || $user['u_money']=="0" || $user['u_money']=="0.00") {
          $list['ymoney'] = "0";
        }else{
          $list['ymoney'] = $user['u_money'];
        }
        if ($list['o_pay_type']=="定金支付") {
          $list['o_sheng_money'] = $list['o_count_money']-$list['o_ding_money'];
        }
        return $this->result(0,"success",$list);
    }
    //订单支付
    public function doPagePayfuzf()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $form_id = $_REQUEST['form_id'];
        $zhifu = $_REQUEST['zhifu'];
        $pay_type = $_REQUEST['pay_type'];
        $o_id = $_REQUEST['o_id'];
        //查询订单
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." as o left join ".tablename("hyb_o2o_fuwu")." as f on o.o_xid=f.x_id where o.uniacid=:uniacid and o.o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        $ordertime = explode(" ", $order['o_yy_riqi']);

        //查询用户
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));

        if($pay_type=="定金支付"){
            if ($zhifu=="余额支付") {
                //判断余额
                if ($user['u_money'] < $order['o_count_money']) {
                    return $this->result(1,"error",array("desc"=>"余额不足请充值"));
                }else{
                    $u_money = $user['u_money']-$order['o_ding_money'];
                    $datas = array("u_money"=>$u_money);
                    $res  =pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
                    $datass = array("o_type"=>"未支付","o_pay_types"=>"1","o_pay_typess"=>"余额支付");
                    $saves = pdo_update("hyb_o2o_orderfuwu",$datass,array("o_id"=>$o_id));
                }
            }
            if ($zhifu=="微信支付") {
              $data = array("o_type"=>"未支付","o_pay_types"=>"1","o_pay_typess"=>"微信支付");
               $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
            }
            if ($zhifu=="到店付款") {
               $data = array("o_type"=>"到店付款","o_pay_types"=>"0");
               $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
            }
             //查询商品信息
            $iteamsinfo = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
            $x_xiaoliang = $iteamsinfo['x_xiaoliang']+1;
            $xldatas = array("x_xiaoliang"=>$x_xiaoliang);
            $savess  = pdo_update("hyb_o2o_fuwu",$xldatas,array("x_id"=>$order['o_xid']));


            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
            $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_name=:y_name and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry'],":y_sjname"=>$order['o_store']));
            /*通知商家*/
            $param = array();
            $param["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $param["SignName"] = $aliduanxin['SignName'];
            $param["TemplateCode"] = $aliduanxin['fdtz'];
            $param['TemplateParam'] = Array (
                'name'=>$sj['s_name'],
                "product"=>"sms"
            );
            if(!empty($param["TemplateParam"]) && is_array($param["TemplateParam"])) {
                $param["TemplateParam"] = json_encode($param["TemplateParam"]);
            }
            $helper = new SignatureHelper();
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($param, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );

             if (!empty($yg)) {
               /*通知员工*/
                $params = array ();
                $params["PhoneNumbers"] = $yg['y_telphone'];         //接收人手机号
                $params["SignName"] = $aliduanxin['SignName'];
                $params["TemplateCode"] = $aliduanxin['xdtzyg'];
                $params['TemplateParam'] = Array (
                    'name'=>$order['o_xiangmu_name'],
                    'daytime'=>$ordertime[0],
                    'time'=>$ordertime[1],
                    'content'=>$order['o_name'],
                    'tel'=>$order['o_telphone'],
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
            
            /*模板消息通知用户*/
            $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            $APPID = $result['appid'];
            $SECRET = $result['appsecret'];
            $template_id = $moban['fuwudj'];
            $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
            $getArr=array();
            $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
            $access_token=$tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
              /*订单编号、服务名称、服务规格、服务时间、支付金额、支付方式、备注、待付金额、订单金额、数量*/
            if ($zhifu=="到店付款") {
                $value = array(
                  "keyword1"=>array(
                    "value"=> $order['ordersn'],
                    "color"=>"#4a4a4a"
                  ),
                  "keyword2"=>array(
                    "value"=>$order['x_name'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword3"=>array(
                    "value"=>$order['o_xiangmu_guige'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword4"=>array(
                    "value"=>$order['o_yy_riqi'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword5"=>array(
                    "value"=>"0",
                    "color"=>"#9b9b9b"
                  ),
                  "keyword6"=>array(
                    "value"=>$zhifu,
                    "color"=>"#9b9b9b"
                  ),
                  "keyword7"=>array(
                    "value"=>$order['o_beizhu'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword8"=>array(
                    "value"=>$order['o_count_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword9"=>array(
                    "value"=>$order['o_count_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword10"=>array(
                    "value"=>$order['o_num'],
                    "color"=>"#9b9b9b"
                  ),
                );
            }else{
                $value = array(
                  "keyword1"=>array(
                    "value"=> $order['ordersn'],
                    "color"=>"#4a4a4a"
                  ),
                  "keyword2"=>array(
                    "value"=>$order['x_name'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword3"=>array(
                    "value"=>$order['o_xiangmu_guige'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword4"=>array(
                    "value"=>$order['o_yy_riqi'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword5"=>array(
                    "value"=>$order['o_ding_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword6"=>array(
                    "value"=>$zhifu,
                    "color"=>"#9b9b9b"
                  ),
                  "keyword7"=>array(
                    "value"=>$order['o_beizhu'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword8"=>array(
                    "value"=>$order['o_sheng_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword9"=>array(
                    "value"=>$order['o_count_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword10"=>array(
                    "value"=>$order['o_num'],
                    "color"=>"#9b9b9b"
                  ),
                );
            }
            $dd = array();
            $dd['touser']=$openid;
            $dd['template_id']=$template_id;
            $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
            $dd['form_id']=$form_id;
            $dd['data']=$value;                        //模板内容，不填则下发空模板
            $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
            $result = $this->https_curl_json($url,$dd,'json');
            //更新用户信息
            pdo_update("hyb_o2o_fuwu_time",array('status'=>1),array("o_id"=>$o_id)); 
            return $this->result(0,"success",$dd);
        }
        if ($pay_type=="全额付款") {
            if ($zhifu=="余额支付") {
                //判断余额
                if ($user['u_money'] < $order['o_count_money']) {
                    return $this->result(1,"error",array("desc"=>"余额不足请充值"));
                }else{
                    $u_money = $user['u_money']-$order['o_count_money'];
                    $datas = array("u_money"=>$u_money);
                    $save  =pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
                    $data = array("o_type"=>"已付款","o_pay_types"=>"1","o_pay_typess"=>"余额支付");
                    $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));    
                }
                 
                
            }
            if ($zhifu=="微信支付") {
               $data = array("o_type"=>"已付款","o_pay_types"=>"1","o_pay_typess"=>"微信支付");
               $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
            }
            if ($zhifu=="到店付款") {
               $data = array("o_type"=>"到店付款","o_pay_types"=>"0");
               $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
            }
                //查询商品信息
            $iteamsinfo = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
            $x_xiaoliang = $iteamsinfo['x_xiaoliang']+1;
            $xldatas = array("x_xiaoliang"=>$x_xiaoliang);
            $savess  = pdo_update("hyb_o2o_fuwu",$xldatas,array("x_id"=>$order['o_xid']));

            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $param = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
            $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_name=:y_name and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry'],":y_sjname"=>$order['o_store']));

            /*通知商家*/
            $param["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $param["SignName"] = $aliduanxin['SignName'];
            $param["TemplateCode"] = $aliduanxin['fdtz'];
            $param['TemplateParam'] = Array (
                'name'=>$sj['s_name'],
                "product"=>"sms"
            );
            if(!empty($param["TemplateParam"]) && is_array($param["TemplateParam"])) {
                $param["TemplateParam"] = json_encode($param["TemplateParam"]);
            }
            $helper = new SignatureHelper();
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($param, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );
            

            if (!empty($yg)) {
               /*通知员工*/
                $params = array ();
                $params["PhoneNumbers"] = $yg['y_telphone'];         //接收人手机号
                $params["SignName"] = $aliduanxin['SignName'];
                $params["TemplateCode"] = $aliduanxin['xdtzyg'];
                $params['TemplateParam'] = Array (
                    'name'=>$order['o_xiangmu_name'],
                    'daytime'=>$ordertime[0],
                    'time'=>$ordertime[1],
                    'content'=>$order['o_name'],
                    'tel'=>$order['o_telphone'],
                    "product"=>"sms"
                );
                //var_dump($params);
                if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                    $params["TemplateParam"] = json_encode($params["TemplateParam"]);
                }
                $helper = new SignatureHelper();
                $contents = $helper->request(
                    $accessKeyId,
                    $accessKeySecret,
                    "dysmsapi.aliyuncs.com",
                    array_merge($params, array(
                        "RegionId" => "cn-hangzhou",
                        "Action" => "SendSms",
                        "Version" => "2017-05-25",
                    ))
                );
                //var_dump($contents);
            }
           

            /*模板消息通知用户*/
            $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            $APPID = $result['appid'];
            $SECRET = $result['appsecret'];
            $template_id = $moban['fuwuzf'];
            $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
            $getArr=array();
            $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
            $access_token=$tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
            /*订单编号、服务名称、服务规格、订单金额、服务时间、备注、数量、支付方式、联系人手机号、服务地址*/
            if ($zhifu=="到店付款") {
                //查询商家信息
                $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
                $value = array(
                    "keyword1"=>array(
                      "value"=> $order['ordersn'],
                      "color"=>"#4a4a4a"
                    ),
                    "keyword2"=>array(
                      "value"=>$order['x_name'],
                      "color"=>"#9b9b9b"
                    ),
                    "keyword3"=>array(
                      "value"=>$order['o_xiangmu_guige'],
                      "color"=>"#9b9b9b"
                    ),
                    "keyword4"=>array(
                      "value"=>"0",
                      "color"=>"#9b9b9b"
                    ),
                    "keyword5"=>array(
                      "value"=>$order['o_yy_riqi'],
                      "color"=>"#9b9b9b"
                    ),
                    "keyword6"=>array(
                      "value"=>$order['o_beizhu'],
                      "color"=>"#9b9b9b"
                    ),
                    "keyword7"=>array(
                      "value"=>$order['o_num'],
                      "color"=>"#9b9b9b"
                    ),
                    "keyword8"=>array(
                      "value"=>$zhifu,
                      "color"=>"#9b9b9b"
                    ),
                    "keyword9"=>array(
                      "value"=>$shangjia['s_telphone'],
                      "color"=>"#9b9b9b"
                    ),
                    "keyword10"=>array(
                      "value"=>$shangjia['s_address'].$shangjia['s_xxaddress'],
                      "color"=>"#9b9b9b"
                    ),
                );
            }else{
                $value = array(
                  "keyword1"=>array(
                    "value"=> $order['ordersn'],
                    "color"=>"#4a4a4a"
                  ),
                  "keyword2"=>array(
                    "value"=>$order['x_name'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword3"=>array(
                    "value"=>$order['o_xiangmu_guige'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword4"=>array(
                    "value"=>$order['o_count_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword5"=>array(
                    "value"=>$order['o_yy_riqi'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword6"=>array(
                    "value"=>$order['o_beizhu'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword7"=>array(
                    "value"=>$order['o_num'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword8"=>array(
                    "value"=>$zhifu,
                    "color"=>"#9b9b9b"
                  ),
                  "keyword9"=>array(
                    "value"=>$order['o_telphone'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword10"=>array(
                    "value"=>$order['o_address']."-".$order['o_xxaddress'],
                    "color"=>"#9b9b9b"
                  ),
                );
            }
            $dd = array();
            $dd['touser']=$openid;
            $dd['template_id']=$template_id;
            $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
            $dd['form_id']=$form_id;
            $dd['data']=$value;                        //模板内容，不填则下发空模板
            $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
            $result = $this->https_curl_json($url,$dd,'json');
            //更新用户信息
            pdo_update("hyb_o2o_fuwu_time",array('status'=>1),array("o_id"=>$o_id)); 
            return $this->result(0,"success",$dd);
        }
        if ($pay_type=="上门估价") {
            if ($zhifu=="余额支付") {
                //判断余额
                if ($user['u_money'] < $order['o_count_money']) {
                    return $this->result(1,"error",array("desc"=>"余额不足请充值"));
                }else{
                   $u_money = $user['u_money']-$order['o_shangmen_money'];
                    $datas = array("u_money"=>$u_money);
                    $save  =pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
                    $data = array("o_pay_types"=>"1","o_pay_typess"=>"余额支付");
                    $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));  
                }
            }
            if ($zhifu=="微信支付") {
               $data = array("o_pay_types"=>"1","o_pay_typess"=>"微信支付");
               $res = pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
            }
            //查询商品信息
            $iteamsinfo = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
            $x_xiaoliang = $iteamsinfo['x_xiaoliang']+1;
            $xldatas = array("x_xiaoliang"=>$x_xiaoliang);
            $savess  = pdo_update("hyb_o2o_fuwu",$xldatas,array("x_id"=>$order['o_xid']));
            
            require_once dirname(__FILE__) .'./inc/func/SignatureHelper.php';
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
            $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_name=:y_name and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry'],":y_sjname"=>$order['o_store']));
            /*通知商家*/
            $param["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $param["SignName"] = $aliduanxin['SignName'];
            $param["TemplateCode"] = $aliduanxin['fdtz'];
            $param['TemplateParam'] = Array (
                'name'=>$sj['s_name'],
                "product"=>"sms"
            );
            if(!empty($param["TemplateParam"]) && is_array($param["TemplateParam"])) {
                $param["TemplateParam"] = json_encode($param["TemplateParam"]);
            }
            $helper = new SignatureHelper();
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($param, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );
            if (!empty($yg)) {
               /*通知员工*/
                $params = array ();
                $params["PhoneNumbers"] = $yg['y_telphone'];         //接收人手机号
                $params["SignName"] = $aliduanxin['SignName'];
                $params["TemplateCode"] = $aliduanxin['xdtzyg'];
                $params['TemplateParam'] = Array (
                    'name'=>$order['o_xiangmu_name'],
                    'daytime'=>$ordertime[0],
                    'time'=>$ordertime[1],
                    'content'=>$order['o_name'],
                    'tel'=>$order['o_telphone'],
                    "product"=>"sms"
                );
                // var_dump($params);
                if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                    $params["TemplateParam"] = json_encode($params["TemplateParam"]);
                }
                $helperS = new SignatureHelper();
                $contents = $helperS->request(
                    $accessKeyId,
                    $accessKeySecret,
                    "dysmsapi.aliyuncs.com",
                    array_merge($params, array(
                        "RegionId" => "cn-hangzhou",
                        "Action" => "SendSms",
                        "Version" => "2017-05-25",
                    ))
                );

                // var_dump($contents);
            }

            /*模板消息通知用户*/
            $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            $APPID = $result['appid'];
            $SECRET = $result['appsecret'];
            $template_id = $moban['fuwuzf'];
            $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
            $getArr=array();
            $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
            $access_token=$tokenArr->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
            /*订单编号、服务名称、服务规格、订单金额、服务时间、备注、数量、支付方式、联系人手机号、服务地址*/
            $value = array(
                  "keyword1"=>array(
                    "value"=> $order['ordersn'],
                    "color"=>"#4a4a4a"
                  ),
                  "keyword2"=>array(
                    "value"=>$order['x_name'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword3"=>array(
                    "value"=>$order['o_xiangmu_guige'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword4"=>array(
                    "value"=>$order['o_shangmen_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword5"=>array(
                    "value"=>$order['o_yy_riqi'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword6"=>array(
                    "value"=>$order['o_beizhu'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword7"=>array(
                    "value"=>$order['o_num'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword8"=>array(
                    "value"=>$zhifu,
                    "color"=>"#9b9b9b"
                  ),
                  "keyword9"=>array(
                    "value"=>$order['o_telphone'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword10"=>array(
                    "value"=>$order['o_address']."-".$order['o_xxaddress'],
                    "color"=>"#9b9b9b"
                  ),
            );
            $dd = array();
            $dd['touser']=$openid;
            $dd['template_id']=$template_id;
            $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
            $dd['form_id']=$form_id;
            $dd['data']=$value;                        //模板内容，不填则下发空模板
            $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
            $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
            $result = $this->https_curl_json($url,$dd,'json');
            //更新用户信息
            pdo_update("hyb_o2o_fuwu_time",array('status'=>1),array("o_id"=>$o_id));    
            return $this->result(0,"success",$dd);
        }
        
    }

    //订单结尾款
    public function doPagePayfujie()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $form_id = $_REQUEST['form_id'];
        $zhifu = $_REQUEST['zhifu'];
        $o_id = $_REQUEST['o_id'];
        $o_pay_types = $_REQUEST['o_pay_types'];
        $openid = $_REQUEST['openid'];
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        $ordertime = explode(" ",$order['o_yy_riqi']);
        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
        $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_name=:y_name and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry'],":y_sjname"=>$order['o_store']));
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$order['openid']));
        if ($zhifu=="余额支付") {
            if ($order['o_pay_type']=="全额付款") {
                //查询优惠券
                $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                $u_money = $user['u_money']-$order['o_count_money'];
                pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
                if ($order['o_type']=="未支付" ) {
                    pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已付款","o_pay_types"=>"1","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));
                }
                if ($order['o_type']=='到店付款') {
                    pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"2","o_pay_typess"=>$zhifu)); 
                    $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$sj['s_type']));
                    if (empty($choushui)) {
                        $choucheng = "0";
                    }else{
                        $choucheng = $choushui['choushui'];
                    }
                    $c_money = $order['o_count_money']*$choucheng;

                    $s_money = $sj['s_money']+$order['o_count_money']-$c_money;

                    
                    pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                    pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$yg['y_id']));

                    //查询项目
                    $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                    if ($xiangmu['x_jifenstatus']=='1') {
                        $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                        pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                    }
                    //查询用户是否为分销商
                    $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                    //查询分销设置
                    $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));

                    if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }

                }

                require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
                $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                $accessKeyId = $aliduanxin['accessKeyId'];
                $accessKeySecret = $aliduanxin['accessKeySecret'];
                  
                /*通知商家*/
                $param["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
                $param["SignName"] = $aliduanxin['SignName'];
                $param["TemplateCode"] = $aliduanxin['fdtz'];
                $param['TemplateParam'] = Array (
                    'name'=>$sj['s_name'],
                    "product"=>"sms"
                );
                if(!empty($param["TemplateParam"]) && is_array($param["TemplateParam"])) {
                    $param["TemplateParam"] = json_encode($param["TemplateParam"]);
                }
                $helper = new SignatureHelper();
                $content = $helper->request(
                    $accessKeyId,
                    $accessKeySecret,
                    "dysmsapi.aliyuncs.com",
                    array_merge($param, array(
                        "RegionId" => "cn-hangzhou",
                        "Action" => "SendSms",
                        "Version" => "2017-05-25",
                    ))
                );
                if (!empty($yg)) {
                    /*通知员工*/
                    $params = array ();
                    $params["PhoneNumbers"] = $yg['y_telphone'];         //接收人手机号
                    $params["SignName"] = $aliduanxin['SignName'];
                    $params["TemplateCode"] = $aliduanxin['xdtzyg'];
                    $params['TemplateParam'] = Array (
                        'name'=>$order['o_name'],
                        'daytime'=>$ordertime[0],
                        'time'=>$ordertime[1],
                        'content'=>$order['o_name'],
                        'tel'=>$order['o_telphone'],
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

                $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $APPID = $result['appid'];
                $SECRET = $result['appsecret'];
                $template_id = $moban['fuwuzf'];
                $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
                $getArr=array();
                $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
                $access_token=$tokenArr->access_token;
                $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
                $value = array(
                  "keyword1"=>array(
                    "value"=> $order['ordersn'],
                    "color"=>"#4a4a4a"
                  ),
                  "keyword2"=>array(
                    "value"=>$order['o_xiangmu_name'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword3"=>array(
                    "value"=>$order['o_xiangmu_guige'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword4"=>array(
                    "value"=>$order['o_count_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword5"=>array(
                    "value"=>$order['o_yy_riqi'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword6"=>array(
                    "value"=>$order['o_beizhu'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword7"=>array(
                    "value"=>$order['o_num'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword8"=>array(
                    "value"=>$zhifu,
                    "color"=>"#9b9b9b"
                  ),
                  "keyword9"=>array(
                    "value"=>$order['o_telphone'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword10"=>array(
                    "value"=>$order['o_address']."-".$order['o_xxaddress'],
                    "color"=>"#9b9b9b"
                  ),
                );
                $dd = array();
                $dd['touser']=$openid;
                $dd['template_id']=$template_id;
                $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
                $dd['form_id']=$form_id;
                $dd['data']=$value;                        //模板内容，不填则下发空模板
                $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
                $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
                $result = $this->https_curl_json($url,$dd,'json');
            }elseif($order['o_pay_type']=='定金支付'){
              if ($order['o_pay_types']=="0") {
                    //查询优惠券
                $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                  $u_money = $user['u_money']-$order['o_ding_money'];
                  pdo_update("hyb_o2o_orderfuwu",array("o_pay_types"=>"1","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));

                  require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
                  $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                  $accessKeyId = $aliduanxin['accessKeyId'];
                  $accessKeySecret = $aliduanxin['accessKeySecret'];
                  
                  /*通知商家*/
                  $param["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
                  $param["SignName"] = $aliduanxin['SignName'];
                  $param["TemplateCode"] = $aliduanxin['fdtz'];
                  $param['TemplateParam'] = Array (
                    'name'=>$sj['s_name'],
                    "product"=>"sms"
                  );
                  if(!empty($param["TemplateParam"]) && is_array($param["TemplateParam"])) {
                     $param["TemplateParam"] = json_encode($param["TemplateParam"]);
                  }
                  $helper = new SignatureHelper();
                  $content = $helper->request(
                     $accessKeyId,
                     $accessKeySecret,
                     "dysmsapi.aliyuncs.com",
                     array_merge($param, array(
                        "RegionId" => "cn-hangzhou",
                        "Action" => "SendSms",
                        "Version" => "2017-05-25",
                    ))
                );
                if (!empty($yg)) {
                   /*通知员工*/
                    $params = array ();
                    $params["PhoneNumbers"] = $yg['y_telphone'];         //接收人手机号
                    $params["SignName"] = $aliduanxin['SignName'];
                    $params["TemplateCode"] = $aliduanxin['xdtzyg'];
                    $params['TemplateParam'] = Array (
                        'name'=>$order['o_name'],
                        'daytime'=>$ordertime[0],
                        'time'=>$ordertime[1],
                        'content'=>$order['o_name'],
                        'tel'=>$order['o_telphone'],
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

              }else{
                //查询优惠券
                $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                 $u_money = $user['u_money']-$order['o_sheng_money'];
                 pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"1","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));
                 $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$sj['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_count_money']*$choucheng;

                 $s_money = $sj['s_money']+$order['o_count_money']-$c_money;
                 // $s_money = $sj['s_money']+$order['o_count_money'];
                 pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                 pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$yg['y_id']));

                 //查询项目
                $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                if ($xiangmu['x_jifenstatus']=='1') {
                    $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                    pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                }
                 //查询用户是否为分销商
                $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                //查询分销设置
                $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
              }
              pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
            }elseif ($order['o_pay_type']=="上门估价") {
                if ($order['o_count_money']!='0'){
                    if ($order['o_huiyaunyouhui']=='0') {
                        $money = $order['o_count_money']-$order['o_youhuiquanyouhui'];
                    }else{
                        $money = $order['o_count_money']-$order['o_huiyaunyouhui'];
                    }
                    //查询优惠券
                    $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                    pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                    $u_money = $user['u_money']-$money;
                    $money = $order['o_count_money'];
                    $u_money = $user['u_money']-$order['o_count_money'];
                    pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
                    pdo_update("hyb_o2o_orderfuwu",array('o_pay_types'=>"1","o_type"=>"已付款","o_pay_typess"=>"余额支付"),array("o_id"=>$o_id));
                }else{
                    $money = $order['o_shangmen_money'];
                    $u_money = $user['u_money']-$order['o_shangmen_money'];
                    pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
                    pdo_update("hyb_o2o_orderfuwu",array("o_pay_types"=>"1","o_pay_typess"=>"余额支付"),array("o_id"=>$o_id));
                }   
                
                $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $APPID = $result['appid'];
                $SECRET = $result['appsecret'];
                $template_id = $moban['fuwuzf'];
                $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
                $getArr=array();
                $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
                $access_token=$tokenArr->access_token;
                $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
                /*订单编号、服务名称、服务规格、订单金额、服务时间、备注、数量、支付方式、联系人手机号、服务地址*/
                $value = array(
                      "keyword1"=>array(
                        "value"=> $order['ordersn'],
                        "color"=>"#4a4a4a"
                      ),
                      "keyword2"=>array(
                        "value"=>$order['x_name'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword3"=>array(
                        "value"=>$order['o_xiangmu_guige'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword4"=>array(
                        "value"=>$money,
                        "color"=>"#9b9b9b"
                      ),
                      "keyword5"=>array(
                        "value"=>$order['o_yy_riqi'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword6"=>array(
                        "value"=>$order['o_beizhu'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword7"=>array(
                        "value"=>$order['o_num'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword8"=>array(
                        "value"=>$zhifu,
                        "color"=>"#9b9b9b"
                      ),
                      "keyword9"=>array(
                        "value"=>$order['o_telphone'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword10"=>array(
                        "value"=>$order['o_address']."-".$order['o_xxaddress'],
                        "color"=>"#9b9b9b"
                      ),
                );
                $dd = array();
                $dd['touser']=$openid;
                $dd['template_id']=$template_id;
                $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
                $dd['form_id']=$form_id;
                $dd['data']=$value;                        //模板内容，不填则下发空模板
                $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
                $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
                $result = $this->https_curl_json($url,$dd,'json');
                return $this->result(0,"success",$dd);  
            }
        }else if ($zhifu=="微信支付") {
            if ($order['o_pay_type']=="全额付款") {
                //查询优惠券
                $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                if ($order['o_type']=="未支付") {
                    pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已付款","o_pay_types"=>"1","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));
                }
                if ($order['o_type']=='到店付款') {
                    pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"2","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));
                }
                $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $APPID = $result['appid'];
                $SECRET = $result['appsecret'];
                $template_id = $moban['fuwuzf'];
                $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
                $getArr=array();
                $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
                $access_token=$tokenArr->access_token;
                $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
                $value = array(
                  "keyword1"=>array(
                    "value"=> $order['ordersn'],
                    "color"=>"#4a4a4a"
                  ),
                  "keyword2"=>array(
                    "value"=>$order['o_xiangmu_name'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword3"=>array(
                    "value"=>$order['o_xiangmu_guige'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword4"=>array(
                    "value"=>$order['o_count_money'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword5"=>array(
                    "value"=>$order['o_yy_riqi'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword6"=>array(
                    "value"=>$order['o_beizhu'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword7"=>array(
                    "value"=>$order['o_num'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword8"=>array(
                    "value"=>$zhifu,
                    "color"=>"#9b9b9b"
                  ),
                  "keyword9"=>array(
                    "value"=>$order['o_telphone'],
                    "color"=>"#9b9b9b"
                  ),
                  "keyword10"=>array(
                    "value"=>$order['o_address']."-".$order['o_xxaddress'],
                    "color"=>"#9b9b9b"
                  ),
                );
                $dd = array();
                $dd['touser']=$openid;
                $dd['template_id']=$template_id;
                $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
                $dd['form_id']=$form_id;
                $dd['data']=$value;                        //模板内容，不填则下发空模板
                $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
                $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
                $result = $this->https_curl_json($url,$dd,'json');
            }else if ($order['o_pay_type']=="上门估价") {                
                if ($order['o_count_money']!='0'){
                    //查询优惠券
                    $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                    pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                    $money = $order['o_count_money'];
                    pdo_update("hyb_o2o_orderfuwu",array('o_pay_types'=>"1","o_type"=>"已付款","o_pay_typess"=>"微信支付"),array("o_id"=>$o_id));
                }else{
                    $money = $order['o_shangmen_money'];
                    pdo_update("hyb_o2o_orderfuwu",array("o_pay_types"=>"1","o_pay_typess"=>"微信支付"),array("o_id"=>$o_id));
                }   

                $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
                $APPID = $result['appid'];
                $SECRET = $result['appsecret'];
                $template_id = $moban['fuwuzf'];
                $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
                $getArr=array();
                $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
                $access_token=$tokenArr->access_token;
                $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
                /*订单编号、服务名称、服务规格、订单金额、服务时间、备注、数量、支付方式、联系人手机号、服务地址*/
                $value = array(
                      "keyword1"=>array(
                        "value"=> $order['ordersn'],
                        "color"=>"#4a4a4a"
                      ),
                      "keyword2"=>array(
                        "value"=>$order['x_name'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword3"=>array(
                        "value"=>$order['o_xiangmu_guige'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword4"=>array(
                        "value"=>$money,
                        "color"=>"#9b9b9b"
                      ),
                      "keyword5"=>array(
                        "value"=>$order['o_yy_riqi'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword6"=>array(
                        "value"=>$order['o_beizhu'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword7"=>array(
                        "value"=>$order['o_num'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword8"=>array(
                        "value"=>$zhifu,
                        "color"=>"#9b9b9b"
                      ),
                      "keyword9"=>array(
                        "value"=>$order['o_telphone'],
                        "color"=>"#9b9b9b"
                      ),
                      "keyword10"=>array(
                        "value"=>$order['o_address']."-".$order['o_xxaddress'],
                        "color"=>"#9b9b9b"
                      ),
                );
                $dd = array();
                $dd['touser']=$openid;
                $dd['template_id']=$template_id;
                $dd['page']="hyb_o2o/orders/orders";  //点击模板卡片后的跳转页面
                $dd['form_id']=$form_id;
                $dd['data']=$value;                        //模板内容，不填则下发空模板
                $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
                $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
                $result = $this->https_curl_json($url,$dd,'json');
                return $this->result(0,"success",$dd);
            }elseif ($order['o_pay_type']=="定金支付") {
                if ($order['o_pay_types']=="0") {
                    //查询优惠券
                    $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                    pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                    pdo_update("hyb_o2o_orderfuwu",array("o_pay_types"=>"1","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));
                    require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
                    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                    $accessKeyId = $aliduanxin['accessKeyId'];
                    $accessKeySecret = $aliduanxin['accessKeySecret'];
                  
                    /*通知商家*/
                    $param["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
                    $param["SignName"] = $aliduanxin['SignName'];
                    $param["TemplateCode"] = $aliduanxin['fdtz'];
                    $param['TemplateParam'] = Array (
                        'name'=>$sj['s_name'],
                        "product"=>"sms"
                    );
                    if(!empty($param["TemplateParam"]) && is_array($param["TemplateParam"])) {
                        $param["TemplateParam"] = json_encode($param["TemplateParam"]);
                    }
                    $helper = new SignatureHelper();
                    $content = $helper->request(
                        $accessKeyId,
                        $accessKeySecret,
                        "dysmsapi.aliyuncs.com",
                        array_merge($param, array(
                            "RegionId" => "cn-hangzhou",
                            "Action" => "SendSms",
                            "Version" => "2017-05-25",
                        ))
                    );
                    if (!empty($yg)) {
                        /*通知员工*/
                        $params = array ();
                        $params["PhoneNumbers"] = $yg['y_telphone'];         //接收人手机号
                        $params["SignName"] = $aliduanxin['SignName'];
                        $params["TemplateCode"] = $aliduanxin['fdtzyg'];
                        $params['TemplateParam'] = Array (
                            'name'=>$order['o_name'],
                            'daytime'=>$ordertime[0],
                            'time'=>$ordertime[1],
                            'content'=>$order['o_name'],
                            'tel'=>$order['o_telphone'],
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
              }else{
                //查询优惠券
                    $yhq = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid and x_id=:x_id",array(":uniacid"=>$uniacid,":openid"=>$order['openid'],":x_id"=>$order['o_xid']));
                    pdo_update("hyb_o2o_useryouhuiquan",array("type"=>"已使用"),array("id"=>$yhq['id']));
                pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"1","o_pay_typess"=>$zhifu),array("o_id"=>$o_id));
                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$sj['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                     $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_count_money']*$choucheng;

                $s_money = $sj['s_money']+$order['o_count_money']-$c_money;
                // $s_money = $sj['s_money']+$order['o_count_money'];
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$yg['y_id']));

                //查询项目
                $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                if ($xiangmu['x_jifenstatus']=='1') {
                    $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                    pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                }
                 //查询用户是否为分销商
                $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                //查询分销设置
                $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
              }
            }
        }
    }

  //添加服务评价
  public function doPageAddfwpingjia()
  {
    global $_GPC,$_W;
    $uniacid = $_W['uniacid'];
    $openid =  $_REQUEST['openid'];
    $o_id = $_REQUEST['o_id'];
    $list = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
    $user = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_userinfo")."where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
    $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$list['o_fwry']));
    $data = array("o_pingjia"=>"1");
    pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
    $imgpath = $_REQUEST['p_pic'];
    $imgpath = str_replace('"',"",str_replace("]","",str_replace("[","", $imgpath)));
    if (empty($imgpath)) {
      $imgpaths = ""; 
    }else{
      $imgpath = explode(",",$imgpath);
      $imgpaths = serialize($imgpath);
    }   
    $datas=array(
      'uniacid' => $uniacid,
      'p_openid' => $openid,
      'p_name' => $user['u_name'],
      'p_thumb' => $user['u_thumb'],
      'p_content' => $_REQUEST['p_content'],
      'p_pic' => $imgpaths,
      'p_sid' =>  $list['o_xid'],
      'p_yid'=>$yuangong['y_id'],
      "p_fenshu"=>$_REQUEST['sp_pingfen'],
      'p_time' => date("Y-m-d H:i:s",time()),
    );
    pdo_insert("hyb_o2o_fuwupingjia",$datas);
  }

    //查询订单数
    public function doPageOrdernum()
    {
          global $_GPC, $_W;
          $uniacid = $_W['uniacid']; 
          $openid = $_REQUEST['openid'];
          $typs = $_REQUEST['typs'];
          if ($typs=="yonghu") {
            //服务
            $fwweizhifu = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and openid=:openid and o_type=:o_type",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"未支付"));
            $fwdaodianzhifu = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and openid=:openid and o_type=:o_type",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"到店付款"));
            $fwyifukuan = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and openid=:openid and o_type=:o_type",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已付款"));
            $fwyiwancheng = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and openid=:openid and o_type=:o_type and o_pingjia=:o_pingjia",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已完成",":o_pingjia"=>"0"));
            //商品
            $spweizhifu = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and openid=:openid and o_type=:o_type",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"未支付"));
            $spyifukan = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and openid=:openid and o_type=:o_type",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已付款"));
            $spyifuhuo = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and openid=:openid and o_type=:o_type",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已发货"));
            $spyiwancheng = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and openid=:openid and o_type=:o_type and o_pingjia=:o_pingjia",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已完成",":o_pingjia"=>"0"));
            //积分
            $jfdaifahuo = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and openid=:openid and statues=1 and type='待发货'",array(":uniacid"=>$uniacid,":openid"=>$openid));
            // var_dump($jfdaifahuo);
            $jfdaishouhuo = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and openid=:openid and statues=2 and type='待收货'",array(":uniacid"=>$uniacid,":openid"=>$openid));
            $jfyiwancheng =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and openid=:openid and statues=3 and type='已完成'",array(":uniacid"=>$uniacid,":openid"=>$openid));
            $list['count'] = $fwweizhifu+$fwdaodianzhifu+$fwyifukuan+$fwyiwancheng+$spweizhifu+$spyifukan+$spyiwancheng+$jfdaifahuo+$jfdaishouhuo+$jfyiwancheng;
            $list['fwweizhifu'] = $fwweizhifu+$fwdaodianzhifu;
            $list['fwyifukuan'] = $fwyifukuan;
            $list['fwyiwancheng'] = $fwyiwancheng;
            $list['spweizhifu'] = $spweizhifu;
            $list['spyifukan'] = $spyifukan+$spyifuhuo;
            $list['spyiwancheng'] = $spyiwancheng;
            $list['jfdaifahuo'] = $jfdaifahuo;
            $list['jfdaishouhuo'] = $jfdaishouhuo;
            $list['jfyiwancheng'] = $jfyiwancheng;
          }
          if ($typs=="shangjia") {
            //查询商家
            $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
            $fwweizhifu = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_type"=>"未支付"));
            $fwdaodianzhifu = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_type"=>"到店付款"));
            $fwyifukuan = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_type"=>"已付款"));
            $fwyiwancheng = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_store=:o_store and o_type=:o_type and o_pingjia=:o_pingjia",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_type"=>"已完成",":o_pingjia"=>"0"));
            $list['count'] = $fwweizhifu+$fwdaodianzhifu+$fwyifukuan+$fwyiwancheng;
            $list['fwweizhifu'] = $fwweizhifu+$fwdaodianzhifu;
            $list['fwyifukuan'] = $fwyifukuan;
            $list['fwyiwancheng'] = $fwyiwancheng;
          }
          return $this->result(0,"success",$list);
    }

      //查询服务订单
      public function doPageOrderfuwulist()
      {
          global $_GPC, $_W;
          $uniacid = $_W['uniacid']; 
          $openid = $_REQUEST['openid'];
          $currentTab = $_REQUEST['currentTab'];
          $typs = $_REQUEST['typs'];
          $cur = $_REQUEST['cur'];
          //查询商家
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));

          //查询员工
          $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
          if($currentTab =='0'){
            if ($typs=="yonghu") {
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type!='已删除' and o.yonghu='0' order by o_id desc",array(":uniacid"=>$uniacid,":openid"=>$openid));
            }
            if ($typs=="shangjia" && $cur=="0") {   //商家到店服务全部订单  
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_xiangmu_xingshi"=>"到店服务")); 
            }
            if ($typs=="shangjia" && $cur=="1") {   //商家上门服务全部订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_xiangmu_xingshi"=>"上门服务")); 
            }
            if ($typs=="yuangong" && $cur=="0") {        //员工到店服务全部订单
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type!=:o_type and o.o_type!=:o_types and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_xiangmu_xingshi"=>"到店服务",":o_type"=>"已取消",":o_types"=>"已退款",":o_store"=>$yuangong['y_sjname']));
              foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }
            }
            if ($typs=="yuangong" && $cur=="1") {          //员工上门服务全部订单
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type!=:o_type and o.o_type!=:o_types and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_xiangmu_xingshi"=>"上门服务",":o_type"=>"已取消",":o_types"=>"已退款",":o_store"=>$yuangong['y_sjname']));
              foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }
            }
          }
          if($currentTab =='1'){
            if($typs=="yonghu"){
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.o_type in ('未支付','到店付款') and o.uniacid=:uniacid and o.openid=:openid and o.yonghu='0' order by o_id desc",array(":uniacid"=>$uniacid,":openid"=>$openid));
            }
            if ($typs=="shangjia" && $cur=="0") {   //商家到店服务待服务订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.o_fw_type=:o_fw_type and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.uniacid=:uniacid and o.o_store=:o_store and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_xiangmu_xingshi"=>"到店服务",":o_fw_type"=>"0"));              
            }
            if ($typs=="shangjia" && $cur=="1") {  //商家上门服务待服务订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.o_fw_type=:o_fw_type  and o.uniacid=:uniacid and o.o_store=:o_store and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_fw_type"=>"0"));                            
            }
            if ($typs=="yuangong" && $cur=="0") {       //员工到店服务待服务订单
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.o_fw_type=:o_fw_type and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除'  and o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_store=:o_store and  o.o_fw_type=:o_fw_type order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_xiangmu_xingshi"=>"到店服务",":o_fw_type"=>"0",":o_store"=>$yuangong['y_sjname'])); 
              foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }       
            }
            if ($typs=="yuangong" && $cur=="1") {
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.o_fw_type=:o_fw_type and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_store=:o_store and o.o_fw_type=:o_fw_type order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_xiangmu_xingshi"=>"上门服务",":o_fw_type"=>"0",":o_store"=>$yuangong['y_sjname']));     
              foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }   
            }
          }
          if ($currentTab == '2') {
            if($typs=="yonghu"){
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type=:o_type and o.yonghu='0' order by o_id desc",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已付款"));
            }
            if($typs=="shangjia" && $cur=="0"){   //商家到店服务服务中订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store and o.o_fw_type=:o_fw_type and o.o_xiangmu_xingshi=:o_xiangmu_xingshi  and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_fw_type"=>"1",":o_xiangmu_xingshi"=>"到店服务"));             
            }
            if($typs=="shangjia" && $cur=="1"){   //商家上门服务服务中订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store and o.o_fw_type=:o_fw_type and o.o_xiangmu_xingshi=:o_xiangmu_xingshi  and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_fw_type"=>"1",":o_xiangmu_xingshi"=>"上门服务"));             
            }
            if($typs=="yuangong" && $cur=="0"){        //员工到店服务服务中订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_fw_type=:o_fw_type and o.o_xiangmu_xingshi=:o_xiangmu_xingshi  and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_fw_type"=>"1",":o_xiangmu_xingshi"=>"到店服务",":o_store"=>$yuangong['y_sjname']));             
                foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }
            }
            if($typs=="yuangong" && $cur=="1"){   //员工服务服务中订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_fw_type=:o_fw_type and o.o_xiangmu_xingshi=:o_xiangmu_xingshi  and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_xiangmu_xingshi"=>"上门服务",":o_fw_type"=>"1",":o_store"=>$yuangong['y_sjname']));    
                foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }         
            }
          }
          if ($currentTab == '3') {
            if($typs=="yonghu"){
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type=:o_type and o.o_pingjia=0 and o.yonghu='0' order by o_id desc",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已完成"));
            }
            if($typs=="shangjia" && $cur=="0"){    //商家到店服务待付款订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store  and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type=:o_type and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_xiangmu_xingshi"=>"到店服务",":o_type"=>"未支付"));           
            }
            if($typs=="shangjia" && $cur=="1"){  //商家上门服务待付款订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store  and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type=:o_type and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_xiangmu_xingshi"=>"上门服务",":o_type"=>"未支付"));            
            }
            if($typs=="yuangong" && $cur=="0"){
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_fw_type=:o_fw_type and o.o_pingjia=0 and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_fw_type"=>"2",":o_xiangmu_xingshi"=>"到店服务",":o_store"=>$yuangong['y_sjname']));
                foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }           
            }
            if($typs=="yuangong" && $cur=="1"){
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_fw_type=:o_fw_type  and o.o_pingjia=0 and o.o_type=:o_type and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_type!='已取消' and o.o_type!='已完成' and o.o_type!='已删除' and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_fw_type"=>"2",":o_xiangmu_xingshi"=>"上门服务",":o_type"=>"未支付",":o_store"=>$yuangong['y_sjname']));
                foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }           
            }
          }
          if ($currentTab == '4') {
            if($typs=="yonghu"){
              $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type in('已退款','申请退款') and o.yonghu='0' order by o_id desc",array(":uniacid"=>$uniacid,":openid"=>$openid));
            }
            if($typs=="shangjia" && $cur=="0"){          //商家到店服务待评价订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store and o.o_type=:o_type and o.o_pingjia=0 and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_type"=>"已完成",":o_xiangmu_xingshi"=>"到店服务"));
            }
            if($typs=="shangjia" && $cur=="1"){        //商家上门服务待评价订单
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_store=:o_store and o.o_type=:o_type and o.o_pingjia=0 and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.shangjia='0' order by o_id desc",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id'],":o_type"=>"已完成",":o_xiangmu_xingshi"=>"上门服务"));
            }
            if($typs=="yuangong" && $cur=="0"){
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_type=:o_type and o.o_pingjia=0 and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_type"=>"已完成",":o_xiangmu_xingshi"=>"到店服务",":o_store"=>$yuangong['y_sjname']));
                foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }
            }
            if($typs=="yuangong" && $cur=="1"){
                $dingdanlist = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")."as o left join ".tablename("hyb_o2o_fuwu")."as x on o.o_xid=x.x_id where o.uniacid=:uniacid and o.o_fwry=:o_fwry and o.o_type=:o_type and o.o_pingjia=0 and o.o_xiangmu_xingshi=:o_xiangmu_xingshi and o.o_store=:o_store order by o_id desc",array(":uniacid"=>$uniacid,":o_fwry"=>$yuangong['y_name'],":o_type"=>"已完成",":o_xiangmu_xingshi"=>"上门服务",":o_store"=>$yuangong['y_sjname']));
                foreach ($dingdanlist as $key => $values) {
                  if ($values['o_pay_type']=="全额付款" && $values['o_type']=="未支付") {
                      unset($dingdanlist[$key]);
                  }
                  if ($values['o_pay_type']=='定金支付' && $values['o_pay_types']=="0") {
                      unset($dingdanlist[$key]);
                  }
              }
            }
          }
          if (!empty($dingdanlist)) {
            foreach ($dingdanlist as &$value) {
                //查询员工信息
                $xinxi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$value['o_fwry']));
                $value['o_fwry_tel'] = $xinxi['y_telphone'];

              $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")."where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$value['o_store']));
              if(strpos($value['o_xiangmu_thumb'],"http")===false){
                  $value['o_xiangmu_thumb'] = $_W['attachurl'].$value['o_xiangmu_thumb'];
              }
              $value['sj'] = $sj['s_name'];
              //查询商家员工
               $yuangong = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_typs=:y_typs and y_styles=:y_styles and y_sjname=:y_sjname",array(":uniacid"=>$uniacid,":y_typs"=>"空闲中",":y_styles"=>"审核通过",":y_sjname"=>$sj['s_id']));
                $value['yuangong'] = $yuangong;
            }
          }          
          return $this->result(0,"success",$dingdanlist);
      }

      //服务人员修改
      public function doPageOrderfuwurysave(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $o_id = $_REQUEST['o_id'];
        
        //查询订单
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        $ordertime = explode(" ",$order['o_yy_riqi']);
        $fwyg = $_REQUEST['fwyg'];
        $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$fwyg));
        $userinfo = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$yuangong['y_openid']));
        if (!empty($order['o_fwry'])) {
            $oldyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));
            pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$oldyuangong['y_id']));
        }
        pdo_update("hyb_o2o_orderfuwu",array("o_fwry"=>$yuangong['y_name'],'o_fwry_id'=>$userinfo['u_id']),array("o_id"=>$o_id));
        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$fwyg));
            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $params = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];
            $params["PhoneNumbers"] = $order['o_telphone'];         //接收人手机号
            $params["SignName"] = $aliduanxin['SignName'];
            $params["TemplateCode"] = $aliduanxin['pdtzyh'];

            /*通知用户*/
            $params['TemplateParam'] = Array (
                'ordersn'=>$order['ordersn'],
                'daytime'=>$ordertime[0],
                'time'=>$ordertime[1],
                'content'=>$yuangong['y_name'],
                'tel'=>$yuangong['y_telphone'],
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

            /*通知员工*/
            $paramss["PhoneNumbers"] = $yuangong['y_telphone'];         //接收人手机号
            $paramss["SignName"] = $aliduanxin['SignName'];
            $paramss["TemplateCode"] = $aliduanxin['pdtzyg'];
            $paramss['TemplateParam'] = Array (
                'ordersn'=>$order['ordersn'],
                'time'=>$order['o_yy_riqi'],
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
      }

      //订单核销码
      public function doPageHexiaoma()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
          $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
          $APPID = $result['appid'];
          $SECRET = $result['appsecret'];
          $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
          $getArr=array();
          $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
          $access_token=$tokenArr->access_token;
          $noncestr = $order['ordersn'];
          $width=430;
          $post_data='{"path":"'.$noncestr.'","width":'.$width.'}';
          $url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$access_token;
          $result=$this->api_notice_increment($url,$post_data); 
          $image_name = md5(uniqid(rand())).".jpg";
          $filepath = "../attachment/{$image_name}";   
          $file_put = file_put_contents($filepath, $result);
          @require_once (IA_ROOT . '/framework/function/file.func.php');
          @file_remote_upload($image_name);
          $list['hexiaomathumb'] = $_W['attachurl'].$image_name;
          $list['hexiaomashuzi'] = $order['o_hexiaomashuzi'];
          return $this->result(0, 'success', $list);
      }

      //订单核销
      public function doPageHexiao()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $ordersn = $_REQUEST['ordersn'];
          $openid = $_REQUEST['openid'];  
          //查询订单
          $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and ordersn=:ordersn",array(":uniacid"=>$uniacid,":ordersn"=>$ordersn));
          $ordertime = explode(" ",$order['o_yy_riqi']);
          //查询商家
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":s_id"=>$order['o_store'],":uniacid"=>$uniacid));
          if (!empty($shangjia)) {
              //核销人员为商家本身
              $jie =  "匹配已找到";
              $data = array("o_fw_type"=>"1");
              pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$order['o_id']));
              //查询服务员工
              $fwyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));
              pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$fwyuangong['y_id']));
          }else{
              //查询商家员工
             $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_sjname=:y_sjname and y_styles=:y_styles and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_sjname"=>$order['o_store'],":y_styles"=>"审核通过",":y_openid"=>$openid));
             if (!empty($yuangong)) {
                $jie =   "匹配已找到";
                $data = array("o_fw_type"=>"1");
                pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$order['o_id']));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$yuangong['y_id']));
             }else{
                $jie =  "匹配未找到"; 
             }
          }
        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        /*通知商家*/
        $params["PhoneNumbers"] = $shangjia['s_telphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['ddtzsjkf'];
        $params['TemplateParam'] = Array (
            'name'=>$order['ordersn'],
            'daytime'=>$ordertime[0],
            'time'=>$ordertime[1],
            'content'=>$order['o_fwry'],
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
        return $this->result(0,"success",$jie);
      }

      //修改订单服务状态
    public function doPageOrderFwwcs()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $o_id = $_REQUEST['o_id'];
          //查询订单
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        if ($order['o_pay_type']=="全额付款") {
            if ($order['o_type']=="已付款") {
                    pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2","o_type"=>"已完成"),array("o_id"=>$o_id));
                    $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));

                    $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$sj['s_type']));
                    if (empty($choushui)) {
                        $choucheng = "0";
                    }else{
                        $choucheng = $choushui['choushui'];
                    }
                    $c_money = $order['o_count_money']*$choucheng;

                    $s_money = $sj['s_money']+$order['o_count_money']-$c_money;
                    // $s_money = $sj['s_money']+$order['o_count_money'];
                    pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                    //查询项目
                    $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                    if ($xiangmu['x_jifenstatus']=='1') {
                        $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                        pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                    }
                    //查询用户是否为分销商
                    $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                    //查询分销设置
                    $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                    if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
            }else{
                pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2"),array("o_id"=>$o_id));
                   
            }
        }
        if ($order['o_pay_type']=='上门估价') {
            if ($order['o_type']=="已付款") {
                pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2","o_type"=>"已完成"),array("o_id"=>$o_id));
                $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));

                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$sj['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_count_money']*$choucheng;

                $s_money = $sj['s_money']+$order['o_count_money']-$c_money;
                // $s_money = $sj['s_money']+$order['o_count_money'];
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                //查询项目
                $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                if ($xiangmu['x_jifenstatus']=='1') {
                    $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                    pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                }
                //查询用户是否为分销商
                $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                //查询分销设置
                $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
            }
            if ($order['o_type']=='未支付') {
                $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_shangmen_money']*$choucheng;

                $s_money = $sj['s_money']+$order['o_shangmen_money']-$c_money;

                // $s_money = $shangjia['s_money']+$order['o_shangmen_money'];


                pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2"),array("o_id"=>$o_id));
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
            }
        }
        if ($order['o_pay_type']=="定金支付") {
            if ($order['o_type']=="未支付" || $order['o_type']=="到店付款") {
                pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2"),array("o_id"=>$o_id));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));
            }
        }
          

            
        //查询服务员工
        $fwyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));
        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));

        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];

        /*通知商家*/
        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
        $params["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['ddtzsjwc'];
        $params['TemplateParam'] = Array (
            "name"=>$order['ordersn'],
            "content"=>$order['o_fwry'],
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
        // var_dump($content);

        $paramsy["PhoneNumbers"] = $order['o_telphone'];         //接收人手机号
        $paramsy["SignName"] = $aliduanxin['SignName'];
        $paramsy["TemplateCode"] = $aliduanxin['ddtzsjwc'];
        $paramsy['TemplateParam'] = Array (
            "name"=>$order['ordersn'],
            "content"=>$order['o_fwry'],
            "product"=>"sms"
        );
        if(!empty($paramsy["TemplateParam"]) && is_array($paramsy["TemplateParam"])) {
            $paramsy["TemplateParam"] = json_encode($paramsy["TemplateParam"]);
        }
        $helper = new SignatureHelper();
        $contents = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($paramsy, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );


        /*通知用户*/
        if ($order['o_pay_type']=="定金支付") {
            $money = $order['o_sheng_money'];
        }
        $paramss["PhoneNumbers"] = $order['o_telphone'];         //接收人手机号
        $paramss["SignName"] = $aliduanxin['SignName'];
        $paramss["TemplateCode"] = $aliduanxin['ddtzzf'];
        $paramss['TemplateParam'] = Array (
            "name"=>$order['ordersn'],
            "money"=>$money,
            "product"=>"sms"
        );
        if(!empty($paramss["TemplateParam"]) && is_array($paramss["TemplateParam"])) {
            $paramss["TemplateParam"] = json_encode($paramss["TemplateParam"]);
        }
        $helper = new SignatureHelper();
        $contentss = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($paramss, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
    }
    

    //确认服务付款
    public function doPageOrderFwwcpay()
    {
        global $_W,$_GPC;
        $o_id = $_REQUEST['o_id'];
        $data = array("o_type"=>"已完成","o_pay_types"=>"1");
        pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));
        //查询订单
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
        //查询服务
        $fuwu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
        //查询用户
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$order['openid']));
        $u_jifen = $user['u_jifen']+$fuwu['x_jifen'];
        $datas = array(":u_jifen"=>$u_jifen);
        pdo_update("hyb_o2o_userinfo",$datas,array(" u_id"=>$user['u_id']));
        //查询服务员工
        $fwyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));
        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));
    }

    public function doPageOrderFwfk()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $o_id = $_REQUEST['o_id'];
        $data = array("o_pay_typess"=>$_REQUEST['pay_typs'],"o_type"=>"已完成","o_pay_types"=>"2");
        pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id)); 
           //查询订单
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));

           require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $params = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];

            /*通知商家*/
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
            $params["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $params["SignName"] = $aliduanxin['SignName'];
            $params["TemplateCode"] = $aliduanxin['ddtzzfq'];
            if ($order['o_pay_type']=="定金支付") {
                $money = $order['o_sheng_money'];
            }elseif ($order['o_pay_type']=="免费预约") {
                $money = $order['o_count_money'];
            }
            $params['TemplateParam'] = Array (
                "name"=>$order['ordersn'],
                "content"=>$order['o_fwry'],
                "type"=>$_REQUEST['pay_typs'],
                "money"=>$money,
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

      //查询服务订单详情
      public function doPageOrderfuwuxq()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." as o left join".tablename("hyb_o2o_fuwu")." as f on o.o_xid=f.x_id where o.uniacid=:uniacid and o.o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
          $shangjia = pdo_fetch("SELECT * from ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$list['o_store']));
          $list['sj'] = $shangjia['s_name'];
          if (empty($list['o_beizhu'])) {
            $list['o_beizhu'] = "暂无备注说明";
          }
          if (strpos($list['x_thumb'],"http")===false) {
            $list['x_thumb'] = $_W['attachurl'].$list['x_thumb'];
          }
          
          return $this->result(0,"success",$list);
      }

      //服务订单取消
    public function doPageOrderfwsave()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          //查询订单详情
          $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
          
          //查询用户信息
          $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$list['openid']));
          if ($list['o_type']=="未支付" && $list['o_pay_types']=="1") {
              if ($list['o_pay_type']=="全额付款") {
                $u_money = $user['u_money']+$list['o_count_money'];
                $data = array("u_money"=>$u_money);
                pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
                $datas = array("o_type"=>"已取消","o_pay_types"=>"0","o_fw_type"=>"0");
                pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
              }else if ($list['o_pay_type']=="定金支付" ) {
                $u_money = $user['u_money']+$list['o_ding_money'];
                $data = array("u_money"=>$u_money);
                pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
                $datas = array("o_type"=>"已取消","o_pay_types"=>"0","o_fw_type"=>"0");
                pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
              }else if ($list['o_pay_type']=="上门估价") {
                if($list['o_count_money']=='0'){
                    $u_money = $user['u_money']+$list['o_shangmen_money'];
                }else{
                    $u_money = $user['u_money']+$list['o_count_money'];
                }
                
                $data = array("u_money"=>$u_money);
                pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
                $datas = array("o_type"=>"已取消","o_pay_types"=>"0","o_fw_type"=>"0");
                pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
              } 
          }
          if ($list['o_type']=="未支付" && $list['o_pay_types']=="0") {
              $datas = array("o_type"=>"已取消","o_pay_types"=>"0","o_fw_type"=>"0");
              pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));   
          }
          //更新已付款的变为退款申请
          /*if ($list['o_type']=="已付款" && $list['o_fw_type']=="0" && $list['o_pay_type']!="上门估价") {
              $u_money = $user['u_money']+$list['o_count_money'];
              $data = array("u_money"=>$u_money);
              pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
              $datas = array("o_type"=>"已退款","o_pay_types"=>"0","o_fw_type"=>"0");
              pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
          }
          if ($list['o_type']=="已付款" && $list['o_fw_type']=="0" && $list['o_pay_type']=="上门估价") {
            if ($list['o_count_money']=="0") {
              $u_money = $user['u_money']+$list['o_shangmen_money'];
            }else{
              $u_money = $user['u_money']+$list['o_count_money'];
            }           
            $data = array("u_money"=>$u_money);
            pdo_update("hyb_o2o_userinfo",$data,array("u_id"=>$user['u_id']));
            $datas = array("o_type"=>"已退款","o_pay_types"=>"0","o_fw_type"=>"0");
            pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
          }*/
          if ($list['o_type']=="已付款" && $list['o_fw_type']=="0" && $list['o_pay_type']!="上门估价") {
              $datas = array("o_type"=>"申请退款","o_pay_types"=>"3","o_fw_type"=>"0");
              pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
          }
          if ($list['o_type']=="已付款" && $list['o_fw_type']=="0" && $list['o_pay_type']=="上门估价") {
            $datas = array("o_type"=>"申请退款","o_pay_types"=>"3","o_fw_type"=>"0");
            pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
          }
          if ($list['o_type']=="到店付款" && $list['o_fw_type']=="0") {
              $datas = array("o_type"=>"已取消","o_pay_types"=>"0","o_fw_type"=>"0");
              pdo_update("hyb_o2o_orderfuwu",$datas,array("o_id"=>$o_id));
          }
    }
      //服务订单删除
      public function doPageOrderfwdel()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          $typs = $_REQUEST['typs'];
          if ($typs=="yonghu") {
            pdo_update("hyb_o2o_orderfuwu",array("yonghu"=>"1"),array("o_id"=>$o_id));
          }else{
            pdo_update("hyb_o2o_orderfuwu",array("shangjia"=>"1"),array("o_id"=>$o_id));
          }
      }

      //服务订单完成
      public function doPageOrderfwtype()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];      
          //查询订单
          $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
          //查询商家
          $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$order['o_store']));
          //查询服务员工
          $fwyuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_name=:y_name",array(":uniacid"=>$uniacid,":y_name"=>$order['o_fwry']));

          if ($order['o_pay_type']=="上门估价") {
            if ($order['o_count_money']=='0') {
             

             //$s_money = $shangjia['s_money']+$order['o_shangmen_money'];
                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_shangmen_money']*$choucheng;

                $s_money = $shangjia['s_money']+$order['o_shangmen_money']-$c_money;



             pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2"),array("o_id"=>$o_id));
             pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$shangjia['s_id']));
             pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));
            }else{

                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_count_money']*$choucheng;

                $s_money = $shangjia['s_money']+$order['o_count_money']-$c_money;

                //$s_money = $shangjia['s_money']+$order['o_count_money'];
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$shangjia['s_id']));
                pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"2","o_fw_type"=>"2"),array("o_id"=>$o_id));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));

                /*积分*/
                //查询项目
                $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                if ($xiangmu['x_jifenstatus']=='1') {
                    //查询用户
                    $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$order['openid']));
                    $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                    $saves = pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                }
                
              
                //查询用户是否为分销商
                $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                //查询分销设置
                $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
            }
          }elseif ($order['o_pay_type']=="全额付款") {
            if ($order['o_type']=="已付款") {

                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_count_money']*$choucheng;

                $s_money = $shangjia['s_money']+$order['o_count_money']-$c_money;
                // $s_money = $shangjia['s_money']+$order['o_count_money'];
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$shangjia['s_id']));
                pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"2","o_fw_type"=>"2"),array("o_id"=>$o_id));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));
                //查询项目
                $xiangmu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$order['o_xid']));
                if ($xiangmu['x_jifenstatus']=='1') {
                    //查询用户
                    $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$order['openid']));
                    $jifen = $user['u_jifen']+$xiangmu['x_jifen'];
                    pdo_update("hyb_o2o_userinfo",array("u_jifen"=>$jifen),array("u_id"=>$user['u_id']));
                }
                //查询用户是否为分销商
                $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
                //查询分销设置
                $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
                if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
            }
          }elseif ($order['o_pay_type']=="定金支付"){
            if ($order['o_type']=="未支付") {
                pdo_update("hyb_o2o_orderfuwu",array("o_fw_type"=>"2"),array("o_id"=>$o_id));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));
            }else{

                $choushui = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_name=:xt_name",array(":uniacid"=>$uniacid,":xt_name"=>$shangjia['s_type']));
                if (empty($choushui)) {
                     $choucheng = "0";
                }else{
                    $choucheng = $choushui['choushui'];
                }
                $c_money = $order['o_count_money']*$choucheng;

                $s_money = $shangjia['s_money']+$order['o_count_money']-$c_money;

                // $s_money = $shangjia['s_money']+$order['o_count_money'];
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$shangjia['s_id']));
                pdo_update("hyb_o2o_orderfuwu",array("o_type"=>"已完成","o_pay_types"=>"2","o_fw_type"=>"2"),array("o_id"=>$o_id));
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$fwyuangong['y_id']));     
            }
          }

          
      }

      //查询商品订单
      public function doPageOrdergoodslist()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $openid = $_REQUEST['openid'];
          $currentTab = $_REQUEST['currentTab'];
          if ($currentTab=="0") {
            $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_ordergoods")." as o left join ".tablename("hyb_o2o_goods")." as g on o.o_gid=g.g_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type!=:o_type order by o.o_xdtime desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已删除"));
          }
          if ($currentTab=="1") {
            $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_ordergoods")." as o left join ".tablename("hyb_o2o_goods")." as g on o.o_gid=g.g_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type=:o_type order by o.o_xdtime desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"未支付"));
          }
          if ($currentTab=="2") {
            $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_ordergoods")." as o left join ".tablename("hyb_o2o_goods")." as g on o.o_gid=g.g_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type in ('已付款','已发货') order by o.o_xdtime desc ",array(":uniacid"=>$uniacid,":openid"=>$openid));
          }
          if ($currentTab=="3") {
            $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_ordergoods")." as o left join ".tablename("hyb_o2o_goods")." as g on o.o_gid=g.g_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type=:o_type and o.o_pingjia=0 order by o.o_xdtime desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已完成"));
          }
          if ($currentTab=="4") {
            $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_ordergoods")." as o left join ".tablename("hyb_o2o_goods")." as g on o.o_gid=g.g_id where o.uniacid=:uniacid and o.openid=:openid and o.o_type=:o_type order by o.o_xdtime desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":o_type"=>"已取消"));
          }
          if (!empty($list)) {
            foreach ($list as &$value) {
              $value['g_thumb'] = $_W['attachurl'].$value['g_thumb'];
            }
          }         
          return $this->result(0,"success",$list);
      }

      //商品订单确认收货
      public function doPageOrdergoodssaves()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          $data =array("o_type"=>"已完成");
          $res = pdo_update("hyb_o2o_ordergoods",$data,array("o_id"=>$o_id));
          //查询订单
          $order = pdo_fetch("SELECT * from ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
              //查询用户是否为分销商
            $fenxiao = pdo_fetch('SELECT * FROM '.tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$order['openid']));
            //查询分销设置
            $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
            if (!empty($fenxiao)) {
                        if ($fenxiaoshezhi['is_ej']=="1") {   //代表二级分销开启
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                $shangji2 = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$shangji['f_parentid']));  
                                if(!empty($shangji)){
                                    if (empty($shangji2)) {
                                        //说明此用户为一级分销商
                                        $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                        $fujiyongjin = $shangji['f_money']+$yongjin;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                    }else{
                                        //说明此用户为二级分销商
                                        $yongjin1 = $order['o_count_money']*$fenxiaoshezhi['y_moneyer']*0.01;   //一级
                                        $yongjin2 = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;   //二级
                                        $fujiyongjin = $shangji2['f_money']+$yongjin1;
                                        $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin1,"parentid"=>$shangji2['f_id'],"parentopenid"=>$shangji2['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji2['f_id']));
                                       
                                        $yijiyongjin = $shangji['f_money']+$yongjin2;
                                        $dafenxiaos = array("uniacid"=>$uniacid,"yongjin"=>$yongjin2,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                        pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiaos);
                                        pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$yijiyongjin),array("f_id"=>$shangji['f_id']));
                                    }
                                }
                                
                            }
                        }elseif ($fenxiaoshezhi['is_ej']=="2") {  //代表二级分销关闭
                            if ($fenxiao['f_parentid']!="0") {
                                $shangji = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$fenxiao['f_parentid']));
                                if (!empty($shangji)) {
                                    $yongjin = $order['o_count_money']*$fenxiaoshezhi['y_moneyyi']*0.01;
                                    $fujiyongjin = $shangji['f_money']+$yongjin;
                                    $dafenxiao = array("uniacid"=>$uniacid,"yongjin"=>$yongjin,"parentid"=>$shangji['f_id'],"parentopenid"=>$shangji['f_openid'],"time"=>date("Y-m-d H:i:s",time()),"yonghu"=>$fenxiao['f_name']);
                                    pdo_insert("hyb_o2o_fenxiaoyongjin",$dafenxiao);
                                    pdo_update("hyb_o2o_userfenxiao",array("f_money"=>$fujiyongjin),array("f_id"=>$shangji['f_id']));
                                }
                            }
                        }           
                    }
      }

      //商品订单取消
      public function doPageOrdergoodssave()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          $openid = $_REQUEST['openid'];
          //查询订单
          $order = pdo_fetch("SELECT * from ".tablename("hyb_o2o_ordergoods")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));
          $data =array("o_type"=>"已取消");
          $res = pdo_update("hyb_o2o_ordergoods",$data,array("o_id"=>$o_id));
          if ($order['o_type']=='已付款') {
              //查询用户
              $user = pdo_fetch("SELECT * from ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
              $u_money = $user['u_money']+$order['o_count_money'];
              $datas = array("u_money"=>$u_money);
              $save = pdo_update("hyb_o2o_userinfo",$datas,array("u_id"=>$user['u_id']));
          }
          
      }
      //商品订单删除
      public function doPageOrdergoodsdel()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $o_id = $_REQUEST['o_id'];
          $data =array("o_type"=>"已删除");
          $res = pdo_update("hyb_o2o_ordergoods",$data,array("o_id"=>$o_id)); 
      }

      //查询积分订单
      public function doPageOrderjflist()
      {
         global $_W,$_GPC;
         $uniacid = $_W['uniacid'];
         $openid = $_REQUEST['openid'];
         $current = $_REQUEST['currentTab'];
         if ($current=="0") {
            $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_jforder")."  where uniacid=:uniacid and openid=:openid and type!=:type  order by time desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":type"=>"已删除"));
         }
         if ($current=="1") {
           $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and openid=:openid and type=:type order by time desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":type"=>"待发货"));
         }
         if ($current=="2") {
           $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_jforder")." where uniacid=:uniacid and openid=:openid and type=:type order by time desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":type"=>"待收货"));
         }
         if ($current=="3") {
           $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_jforder")."  where uniacid=:uniacid and openid=:openid and type=:type order by time desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":type"=>"已完成"));
         }
         if ($current=="4") {
           $list = pdo_fetchall("SELECT * from ".tablename("hyb_o2o_jforder")."  where uniacid=:uniacid and openid=:openid and type=:type order by time desc ",array(":uniacid"=>$uniacid,":openid"=>$openid,":type"=>"已取消"));
         }
         if (!empty($list)) {
            foreach ($list as &$value) {
              $jfgoods = pdo_fetch("SELECT * from ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$value['j_id']));
               $value['name'] = $jfgoods['name'];
               $value['thumb'] = $_W['attachurl'].$jfgoods['thumb'];
            }
         }
         return $this->result(0,"success",$list);
      }

      //积分订单确认收货
      public function doPageOrderjfsur()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $id = $_REQUEST['id'];
          $data = array("type"=>"已完成");
          pdo_update("hyb_o2o_jforder",$data,array("id"=>$id));
      }
      //积分订单删除
      public function doPageOrderjfdel()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $id = $_REQUEST['id'];
          $data = array("type"=>"已删除");
          pdo_update("hyb_o2o_jforder",$data,array("id"=>$id));
      }
      //积分订单取消
      public function doPageOrderjfsh()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $id = $_REQUEST['id'];
          $data = array("type"=>"已取消");
          // var_dump($id);
          pdo_update("hyb_o2o_jforder",$data,array("id"=>$id));
      }


    //用户充值记录
    public function doPageUserczlist()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid =  $_REQUEST['openid'];
      $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userchongzhi")." where uniacid=:uniacid and openid=:openid and jibie=0",array(":uniacid"=>$uniacid,":openid"=>$openid));
      return $this->result(0,"success",$list);
    }
    //查询用户优惠券
    public function doPageUseryhq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_useryouhuiquan")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        if (!empty($list)) {
            $time = date("Y-m-d H:i:s",time());
            foreach ($list as $key => $value) {
                $youhuiquan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_youhuiquan")." WHERE uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$value['y_name']));
                if (empty($youhuiquan) || $youhuiquan['y_endtime']<$time) {
                    unset($list[$key]);
                }else{
                    $list[$key]['yhq_name'] = $youhuiquan['y_name'];
                    $list[$key]['yhq_money'] = $youhuiquan['y_money'];
                    $list[$key]['yhq_yaoqiu'] = $youhuiquan['y_yaoqiu'];
                    $list[$key]['yhq_shuoming'] = $youhuiquan['y_shuoming'];
                    $list[$key]['yhq_starttime'] = $youhuiquan['y_starttime'];
                    $list[$key]['yhq_endtime'] = $youhuiquan['y_endtime'];
                }
            }
        }
        return $this->result(0,"success",$list);
    }

    //查询积分商城
    public function doPageJfgoods()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $jfgoods = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid and status=1",array(":uniacid"=>$uniacid));
        $jfthumb = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jfthumb")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        if (!empty($jfgoods)) {
          foreach ($jfgoods as &$value1) {
            $value1['thumb'] = $_W['attachurl'].$value1['thumb'];
          }    
        }
        if (!empty($jfthumb)) {
           foreach ($jfthumb as &$value2) {
             $value2['thumb'] = $_W['attachurl'].$value2['thumb'];
           }
        }
        $list['jfgoods'] = $jfgoods;
        $list['jfthumb'] = $jfthumb;
        $list['user'] = $user;
        return $this->result(0,"success",$list);
    }
    public function  doPageJfgoodsxq()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jfgoods")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
        $list['thumbs'] = unserialize($list['thumbs']);
        foreach ($list['thumbs'] as &$value) {
            $value = $_W['attachurl'].$value;
        }
        return $this->result(0,"success",$list);
    }
    //添加兑换积分订单
    public function doPagePayjf()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $jifen = $_REQUEST['jifen']?$_REQUEST['jifen']:'0';
      $data = array(
        'uniacid' =>$uniacid,
        'ordersn' => date("Ymd").str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT),
        'openid' => $openid,
        'j_id' => $_REQUEST['j_id'],
        'jifen' => $jifen,
        'address' => $_REQUEST['address'],
        'xxaddress' => $_REQUEST['xxaddress'],
        'username' => $_REQUEST['username'],
        'usertel' => $_REQUEST['usertel'],
        'time' => date("Y-m-d H:i:s",time()),
        'statues'=> 1,
        "form_id"=>$_REQUEST['form_id'],
        'type'=>"待发货",
      );
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
      $jifens = $user['u_jifen']-$_REQUEST['jifen'];
      $data1 = array(
          'u_jifen'=>$jifens,
        );
      $upde = pdo_update("hyb_o2o_userinfo",$data1,array("openid"=>$openid));
      $res = pdo_insert("hyb_o2o_jforder",$data);
      $id = pdo_insertid();
      //查询记录
      $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_jforder")." as o left join ".tablename("hyb_o2o_jfgoods")." as g on o.j_id=g.id where o.uniacid=:uniacid and o.id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
      $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid",array(":uniacid"=>$uniacid));
      $moban = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tongzhi")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
      $APPID = $result['appid'];
      $SECRET = $result['appsecret'];
      $template_id = $moban['jfdh'];
      $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
      $getArr=array();
      $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
      $access_token=$tokenArr->access_token;
      $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token ;
      /*订单编号、兑换商品、兑换积分、联系方式、会员昵称、收货地址、兑换时间*/
      $value = array(
        "keyword1"=>array(
          "value"=> $list['ordersn'],
          "color"=>"#4a4a4a"
        ),
        "keyword2"=>array(
          "value"=>$list['name'],
          "color"=>"#9b9b9b"
        ),
        "keyword3"=>array(
          "value"=>$list['jifen'],
          "color"=>"#9b9b9b"
        ),
        "keyword4"=>array(
          "value"=>$list['usertel'],
          "color"=>"#9b9b9b"
        ),
        "keyword5"=>array(
          "value"=>$list['username'],
          "color"=>"#9b9b9b"
        ),
        "keyword6"=>array(
          "value"=>$list['address']."-".$list['xxaddress'],
          "color"=>"#9b9b9b"
        ),
        "keyword7"=>array(
          "value"=>$list['time'],
          "color"=>"#9b9b9b"
        ),
      );
      $dd = array();
      $dd['touser']=$openid;
      $dd['template_id']=$template_id;
      $dd['page']="hyb_o2o/inner/jf_record/jf_record";  //点击模板卡片后的跳转页面
      $dd['form_id']=$_REQUEST['form_id'];
      $dd['data']=$value;                        //模板内容，不填则下发空模板
      $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
      $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
      $result = $this->https_curl_json($url,$dd,'json');
      return $this->result(0,"success",$dd);
    }
    //用户积分兑换记录
    public function doPageJfjilu()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_jforder")." as o left join ".tablename("hyb_o2o_jfgoods")." as j on o.j_id=j.id where o.uniacid=:uniacid and o.openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
      if (!empty($list)) {
          foreach ($list as &$value) {
            $value['thumb'] = $_W['attachurl'].$value['thumb'];
            $value['thumbs'] = unserialize($value['thumbs']);
            foreach ($value['thumbs'] as &$values) {
                $values = $_W['attachurl'].$values;
            }
          }
      }
      return $this->result(0,'success', $list);      
    }

    //发单验证码
    public function doPageFadanyzm(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $telphone = $_REQUEST['telphone'];
        $code = str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT);
        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        $params["PhoneNumbers"] = $telphone;         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['yzm'];
        $params['TemplateParam'] = Array (
            'code'=>$code,
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
        return $this->result(0,"success",$code);
    }

    //发单
    public function doPageFadan()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $fa_fwtime = $_REQUEST['server_date'].' '.$_REQUEST['server_Time'];
      $imgpath = str_replace('"',"",str_replace("]","",str_replace("[","", $_REQUEST['imglist'])));
      $imgpath = explode(",",$imgpath);
      $imgpath = serialize($imgpath);
      $data = array(
        "uniacid"=>$uniacid,
        "fa_ordersn"=>date("Ymd").str_pad(mt_rand(1, 99999), 5,'0',STR_PAD_LEFT),
        "fa_openid"=>$_REQUEST['openid'],
        "fa_name"=>$_REQUEST['name'],             //联系人
        "fa_fwname"=>$_REQUEST['server_name'],    //服务名称
        "fa_fwimgpath"=>$imgpath,
        "fa_fwstyle1"=>$_REQUEST['fenlei_one'],   //服务分类
        "fa_fwstyle2"=>$_REQUEST['fenlei_two'],   //服务分类二
        "fa_fwtime"=>$fa_fwtime,                  //服务时间
        "fa_fwmoney"=>$_REQUEST['money'],  //服务金额
        "fa_dizhi"=>$_REQUEST['dizhi'],    //地址
        "fa_fwaddress"=>$_REQUEST['location'],    //服务地址
        "fa_fwaddresss"=>$_REQUEST['address_detail'],    //服务详细地址
        "fa_fwlongitude"=>$_REQUEST['longitude'],        
        "fa_fwlatitude"=>$_REQUEST['latitude'],
        "fa_fwcontent"=>$_REQUEST['server_intro'],    //服务备注           
        "fa_fwtelphone"=>$_REQUEST['telphone'],    //服务联系电话
        "fa_fwpay_type"=>$_REQUEST['server_charge'],               //支付形式
        "fa_time"=>date("Y-m-d H:i:s",time()),     //发布时间
        "fa_style"=>"待审核",
      );
      //查询用户
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$_REQUEST['openid']));

      if ($_REQUEST['server_charge']=="一口价") {
          $data['fa_fwpay_types'] = "1";
          $data['fa_fwshagneng'] = "0";
          if ($_REQUEST['paytype']=="余额支付") {
              $u_money = $user['u_money']-$_REQUEST['money'];
              pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
          }
      }
      if ($_REQUEST['server_charge']=="上门估价") {
          $data['fa_fwmoney'] = "0";
          $data['fa_fwpay_types'] = "0";
          $data['fa_fwshagneng'] = $_REQUEST['smfy'];
          if ($_REQUEST['paytype']=="余额支付") {
              $u_money = $user['u_money']-$_REQUEST['smfy'];
              pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
          }         
      }
      
      $res = pdo_insert("hyb_o2o_fadan",$data);
        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        //查询平台信息
        $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        $params["PhoneNumbers"] = $pingtai['s_telphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['fdtz'];
        $params['TemplateParam'] = Array (
                'name'=>$pingtai['s_name'],
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

    //查询我的评价
    public function doPageUserpingjia()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $fuwupj=  pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwupingjia")." WHERE uniacid=:uniacid and p_openid=:p_openid order by p_id desc ",array(":uniacid"=>$uniacid,":p_openid"=>$openid));
        if (!empty($fuwupj)) {
          foreach ($fuwupj as &$value) {
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
            $value['u_thumb'] = $user['u_thumb'];
            $value['p_name'] = json_decode($value['p_name']);
            if (!empty($value['p_pic'])) {
               $value['p_pic'] = unserialize($value['p_pic']);
            }
           
            if (strpos($value['p_thumb'],"http")===false){
                $value['p_thumb'] = $_W['attachurl'].$value['p_thumb'];
            }
            //查询项目
            $fuwu = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$value['p_sid']));
            if (empty($fuwu)) {
              $value['shangjia'] = "已下架";
            }else{
              $value['shangjia'] = "上架";
              $value['x_name'] = $fuwu['x_name'];
              if (strpos($fuwu['x_thumb'],"http")===false) {
                $value['x_thumb'] = $_W['attachurl'].$fuwu['x_thumb'];
              }else{
                $value['x_thumb'] = $fuwu['x_thumb'];
              }
            }                  
          }
          $list['fuwupj'] = $fuwupj;
        }else{
          $list['fuwupj'] = [];
        }
        
        
        $goodspj = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goodspingjia")." WHERE uniacid=:uniacid and p_openid=:p_openid",array(":uniacid"=>$uniacid,":p_openid"=>$openid));
        if (!empty($goodspj)) {
          foreach ($goodspj as &$value2) {
            $value2['p_name'] = json_decode($value2['p_name']);
            $value2['p_pic'] = unserialize($value2['p_pic']);
            //查询商品
            $goods = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods")." where uniacid=:uniacid and g_id=:g_id",array(":uniacid"=>$uniacid,":g_id"=>$value2['p_sid']));
            if (!empty($goods)) {
              $value2['g_name'] = $goods['g_name'];
              $value2['g_thumb'] = $_W['attachurl'].$goods['g_thumb'];
            }else{
              $value2['g_name'] = "";
            }
            
            foreach ($value2['p_pic'] as &$values) {
                if (strpos($values, "http")===false) {
                  $values = $_W['attachurl'].$values;
                }
            }
          }
          $list['goodspj'] = $goodspj;
        }else{
          $list['goodspj'] = [];
        }
        if (empty($list['goodspj']) && empty($list['fuwupj'])) {
          $list['count'] = "0";
        }

        //查询派单评价
        $pdpj = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_paidanpingjia")." where uniacid=:uniacid and pj_openid=:pj_openid",array(":uniacid"=>$uniacid,":pj_openid"=>$openid));
        if (!empty($pdpj)) {
            foreach ($pdpj as &$value2) {
                $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
                $value2['u_thumb'] = $user['u_thumb'];
                $value2['p_name'] = json_decode($user['u_name']);
            }
        }
        $list['pdpj'] = $pdpj;
        return $this->result(0,"success",$list);
    }

    //查询技师评价
    public function doPageUserpingjiajs(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $js = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid and y_rz=1",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_paidanpingjia")." WHERE uniacid=:uniacid and  pj_yuangong=:pj_yuangong",array(":uniacid"=>$uniacid,":pj_yuangong"=>$js['y_id']));
        if (!empty($list)) {
            foreach ($list as &$value) {
                $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$value['pj_openid']));
                $value['u_thumb'] = $user['u_thumb'];
                //查询发单
                // $fd = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and ")
            }
        }
        return $this->result(0,"success",$list);
    }

    //常见问题
    public function doPageQuestion(){
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_question")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        return $this->result(0,"success",$list);
    } 


    //查询用户发单
    public function doPageUserfadan()
    {
      global $_GPC,$_W;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $current = $_REQUEST['current'];
      if ($current=="0") {
        //查询全部
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid  and fa_openid=:fa_openid order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_openid"=>$openid));
      }
      if ($current=="1") {
        //查询待审核
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_openid=:fa_openid order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_style"=>"待审核",":fa_openid"=>$openid));
      }
      if ($current=="2") {
        //查询派单中
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_openid=:fa_openid and fa_style=:fa_style  order by fa_time desc",array(":uniacid"=>$uniacid,":fa_openid"=>$openid,":fa_style"=>"派单中"));
      }
      if ($current=="3") {
        //查询已接单
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_openid=:fa_openid and fa_style=:fa_style order by fa_time desc",array(":uniacid"=>$uniacid,":fa_openid"=>$openid,":fa_style"=>"已接单"));
      }
      if ($current=="4") {
        //查询已完成
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_openid=:fa_openid and fa_style=:fa_style order by fa_time desc",array(":uniacid"=>$uniacid,":fa_openid"=>$openid,":fa_style"=>"已完成"));
      }
      if (!empty($list)) {
        foreach ($list as &$value) {
            $value['fa_fwimgpath'] = unserialize($value['fa_fwimgpath']);
            //查询抢单
            $qiang = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$value['fa_id']));
            if (empty($qiang)) {
                if ($value['fa_style']=="待审核") {
                    $value['q_styles'] = "待审核";
                }else{
                    $value['q_styles'] = "待接单";
                }
            }else{
                $value['q_styles'] = $qiang['q_styles'];
                if ($qiang['q_types']=="门店") {
                    $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
                    $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$qiang['q_pdname']));
                }
                if ($qiang['q_types']=="商家") {
                    $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                    $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$qiang['q_pdname']));
                }
                if ($qiang['q_types']=="员工") {
                    $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join ".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$qiang['q_openid']));
                    $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_id=:s_id",array(":uniacid"=>$uniacid,":s_id"=>$yuangong['y_sjname']));
                }
                if (strpos($shangjia['s_thumb'],"http")===false){
                    $shangjia['s_thumb'] = $_W['attachurl'].$shangjia['s_thumb'];
                }
                $value['shangjia'] = $shangjia;
                $value['yuangong'] = $yuangong;
            }
        }
      }    
      return $this->result(0,"success",$list);     
    }
    //发单取消
    public function doPageFadanquxiao()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $fa_id = $_REQUEST['fa_id'];
      $info = pdo_fetch("SELECT * FROM ".tablename('hyb_o2o_fadan')." where uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
      $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$info['fa_openid']));
      if ($info['fa_fwpay_type']=="一口价") {
         $u_money = $user['u_money']+$info['fa_fwmoney'];  
      }
      if ($info['fa_fwpay_type']=="定金") {
         $u_money = $user['u_money']+$info['fa_fwdingjin'];  
      }
      if ($info['fa_fwpay_type']=="上门估价") {
         $u_money = $user['u_money']+$info['fa_fwshagneng'];  
      }
      pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
      pdo_delete("hyb_o2o_fadan",array("fa_id"=>$fa_id));

      
    }

    //发单报价
    public function doPagePaidanBaojia()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $q_id = $_REQUEST['q_id'];
        $money = $_REQUEST['money'];
        //查询发单信息
        $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$id));
        pdo_update("hyb_o2o_fadan",array("fa_style"=>"已接单","fa_fwmoney"=>$money),array("fa_id"=>$id));
       
        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        $params["PhoneNumbers"] = $fadan['fa_fwtelphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['baojia'];

        /*通知用户*/
        $params['TemplateParam'] = Array (
            'name'=>$fadan['fa_ordersn'],
            'conrtent'=>$fadan['fa_fwname'],
            'money'=>$money,
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

    //同意报价
    public function doPageTongyibaojia()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        $money = $_REQUEST['money'];
        $typs = $_REQUEST['typs'];
        
        //查询发单信息
        $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$id));
        pdo_update("hyb_o2o_fadan",array("fa_fwpay_types"=>"1","fa_pay"=>"1"),array("fa_id"=>$id));
        if ($typs=="余额") {
            //查询用户
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$fadan['fa_openid']));
            $u_money = $user['u_money']-$money;
            pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
        }
        //查询接单信息
        $jiedan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$id));
        pdo_update("hyb_o2o_qiangdan",array("q_styles"=>"服务中"),array("q_id"=>$jiedan['q_id']));

        if ($jiedan['q_types']=="商家") {
            $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$jiedan['q_openid']));
            $tel = $shangjia['s_telphone'];
        }
        if ($jiedan['q_types']=="平台") {
            $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
            $tel = $pingtai['s_telphone'];
        }
        if ($jiedan['q_types']=="员工") {
            $jishi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$jiedan['q_openid']));
            $tel = $jishi['y_telphone'];
        }
        
        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        $params["PhoneNumbers"] = $tel;         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['tybaojia'];

        /*通知用户*/
        $params['TemplateParam'] = Array (
            'name'=>$fadan['fa_fwname'],
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

    //不同意报价
    public function doPageButongyibaojia()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $id = $_REQUEST['id'];
        // pdo_update("hyb_o2o_fadan",array("fa_style"=>"已取消"),array("fa_id"=>$id));
        //查询发单信息
        $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$id));
        //查询接单信息
        $jiedan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$id));
        if ($jiedan['q_types']=="商家") {
            $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$jiedan['q_openid']));
            $tel = $shangjia['s_telphone'];
        }
        if ($jiedan['q_types']=="平台") {
            $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
            $tel = $pingtai['s_telphone'];
        }
        if ($jiedan['q_types']=="员工") {
            $jishi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$jiedan['q_openid']));
            $tel = $jishi['y_telphone'];
        }
        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        $params["PhoneNumbers"] = $tel;         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['btybaojia'];

        /*通知用户*/
        $params['TemplateParam'] = Array (
            'name'=>$fadan['fa_fwname'],
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
        pdo_delete("hyb_o2o_fadan",array("fa_id"=>$id));
        pdo_delete("hyb_o2o_qiangdan",array("q_id"=>$jiedan['q_id']));
    }

    //发单完成
    public function doPageUserfadanwc()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $fa_id = $_REQUEST['fa_id'];
      $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
      //查询抢单信息
      $qiang = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$fa_id));
      if ($qiang['q_types']=="员工") {
          //查询员工信息
          $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$qiang['q_openid']));
      }else{
          //查询员工信息
          $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$qiang['q_pdname']));
      }
      
      //查询平台商家
      $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
      if ($fadan['fa_fwpay_type']=="上门估价") {
              pdo_update("hyb_o2o_qiangdan",array("q_styles"=>"已完成"),array("q_id"=>$qiang['q_id']));
              if ($fadan['fa_fwmoney']=='0' && $qiang['q_types']=="员工") {
                  $money = $fadan['fa_fwshagneng']*$yuangong['y_choucheng'];   //平台抽成
                  $s_money = $pingtai['s_money']+$money;
                  pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  $y_money = $yuangong['y_money']+$fadan['fa_fwshagneng']-$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
              }
              if ($fadan['fa_fwmoney']=='0' && $qiang['q_types']!="员工") {
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$yuangong['y_id']));
                  if ($qiang['q_types']=='商家') {
                       //查询商家
                        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                        $s_money = $sj['s_money']+$fadan['fa_fwshagneng'];
                        pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                  }
                  if ($qiang['q_types']=="门店") {
                      $s_money = $pingtai['s_money']+$fadan['fa_fwshagneng'];
                      pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  }    
              }
              if ($fadan['fa_fwmoney']!='0' && $qiang['q_types']=="员工") {
                  $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //平台抽成
                  $s_money = $pingtai['s_money']+$money;
                  pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  $y_money = $yuangong['y_money']+$fadan['fa_fwmoney']-$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$qiang['q_dname']));
              }
              if ($fadan['fa_fwmoney']!='0' && $qiang['q_types']!="员工") {
                  $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //员工分成
                  if ($qiang['q_types']=='商家') {
                       //查询商家
                        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                        $s_money = $sj['s_money']+$fadan['fa_fwmoney']-$money;
                        pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                        $y_money = $yuangong['y_money']+$money;
                        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  }
                  if ($qiang['q_types']=="门店") {
                        $s_money = $pingtai['s_money']+$money;
                        pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                        $y_money = $yuangong['y_money']+$fadan['fa_fwmoney']-$money;
                        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  } 
                  pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$qiang['q_dname']));
              }
      }
      if ($fadan['fa_fwpay_type']=="一口价") {
            pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$fa_id));
            pdo_update("hyb_o2o_qiangdan",array("q_styles"=>"已完成"),array("q_id"=>$qiang['q_id']));
            if ($qiang['q_types']=="员工") {
                $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //平台抽成
                $s_money = $pingtai['s_money']+$money;
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                $y_money = $yuangong['y_money']+$fadan['fa_fwmoney']-$money;
                pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
            }
            if ($qiang['q_types']!="员工") {
                $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //员工分成  
                if ($qiang['q_types']=='商家') {
                    //查询商家
                    $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                    $s_money = $sj['s_money']+$fadan['fa_fwmoney']-$money;
                    pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                    $y_money = $yuangong['y_money']+$money;
                    pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                }
                if ($qiang['q_types']=="门店") {
                    $s_money = $pingtai['s_money']+$money;
                    pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                    $y_money = $yuangong['y_money']+$fadan['fa_fwmoney']-$money;
                    pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                } 
            }
      }
      
    }

    //派单服务评价
  public function doPageAddpdpingjia()
  {
    global $_W,$_GPC;
    $uniacid = $_W['uniacid'];
    $openid = $_REQUEST['openid'];
    //查询发单
    $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$_GPC['id']));
    $data = array(
      "uniacid"=>$uniacid,
      "pj_openid"=>$openid,
      "pj_content"=>$_REQUEST['p_content'],
      "pj_fen"=>$_REQUEST['fw_pingfen'],
      "pj_yuangong"=>$_REQUEST['y_id'],
      "pj_time"=>date("Y-m-d H:i:s",time()),
      "pj_name"=>$fadan['fa_name'],
    );
    $res =  pdo_insert("hyb_o2o_paidanpingjia",$data);

  }
    //查询抢单大厅
    public function doPageQddtlist()
    {
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $city = $_REQUEST['city'];
        $fenlei = $_REQUEST['fenlei'];
        $quyu = $_REQUEST['quyu'];
        $jiage = $_REQUEST['jiage'];

        if (empty($fenlei)  && empty($quyu) && empty($jiage)) {
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")."  WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$city%' or fa_fwaddresss like '%$city%' order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
        }

        if( !empty($fenlei)  && empty($quyu) && empty($jiage)) {
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like '%$city%' or fa_fwaddresss like '%$city%' order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));  
        }
        if (!empty($quyu)  && empty($fenlei) && empty($jiage)) {
          $sheng = $city."".$quyu;
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%' order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
        }
        if (!empty($jiage)  && empty($fenlei) && empty($quyu)) {
          if ($jiage=="由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$city%' or fa_fwaddresss like '%$city%' order by fa_fwmoney desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
          }else if ($jiage=="由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$city%' or fa_fwaddresss like '%$city%' order by fa_fwmoney asc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
          }else if ($jiage=="最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$city%' or fa_fwaddresss like '%$city%' order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
          }
        }
        if (!empty($fenlei)  && !empty($quyu)  && empty($jiage)) {
          $sheng = $city."".$quyu;
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like  '%$sheng%' or fa_fwaddresss like '%$city%' ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
        }
        if (!empty($fenlei)  && !empty($jiage) && empty($quyu)) {
          if ($jiage=="由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like  '%$city%' or fa_fwaddresss like '%$city%' order by fa_fwmoney desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
          }
          else if ($jiage == "由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like  '%$city%' or fa_fwaddresss like '%$city%' order by fa_fwmoney asc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
          }
          else if ($jiage=="最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like '%$city%' or fa_fwaddresss like '%$city%' order by fa_time desc ",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
          }
        }
        if (!empty($quyu)  && !empty($jiage)  && empty($fenlei)) {
          $sheng = $city."".$quyu;
          if ($jiage=="由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%' order by fa_fwmoney desc",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
          }else if ($jiage == "由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%' order by fa_fwmoney asc",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
          }else if ($jiage=="最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%' order by fa_time desc",array(":uniacid"=>$uniacid,":fa_style"=>"派单中"));
          }
        }
       
        if (!empty($fenlei)  && !empty($quyu)  && !empty($jiage) ) {
          $sheng = $city."".$quyu;
          if ($jiage=="由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%'  order by fa_fwmoney desc",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
          }else if ($jiage == "由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%' order by fa_fwmoney asc",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
          }else if ($jiage == "最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_style=:fa_style and fa_fwstyle1=:fa_fwstyle1 and fa_fwaddress like '%$sheng%' or fa_fwaddresss like '%$sheng%' order by fa_time desc",array(":uniacid"=>$uniacid,":fa_style"=>"派单中",":fa_fwstyle1"=>$fenlei));
          }
        }
        if (!empty($list)) {
            foreach ($list as &$value) {
                $value['fa_fwimgpath'] = unserialize($value['fa_fwimgpath']);
            }
        }
        return $this->result(0,"success",$list);
    }
    //查询发单详情
    public function doPageFadanxq(){
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $fa_id = $_REQUEST['fa_id'];
      $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));
      $info['fa_fwimgpath'] = unserialize($info['fa_fwimgpath']);
      return $this->result(0,"success",$info);
    }
    //抢单
    public function doPageQiangdan()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$_REQUEST['fa_id']));
      if ($_REQUEST['come']=='shangjia') {
        //查询商家信息
        $shangjia = pdo_fetch("SELECT * from ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$_REQUEST['openid']));
        if ($shangjia['pingtai']=='1') {
            $come = "门店";
        }else{
            $come = "商家";
        }
                
            $data = array(
            "uniacid"=>$_W['uniacid'],
            "q_openid"=>$_REQUEST['openid'],
            "q_types"=>$come,
            "q_dname"=>$_REQUEST['fa_id'],
            "q_time"=>date("Y-m-d H:i:s",time()),
            "q_styles"=>"未指派"
          );

        
        
      }else if ($_REQUEST['come']=="yuangong") {
            $come = "员工";
            $data = array(
            "uniacid"=>$_W['uniacid'],
            "q_openid"=>$_REQUEST['openid'],
            "q_types"=>$come,
            "q_dname"=>$_REQUEST['fa_id'],
            "q_time"=>date("Y-m-d H:i:s",time()),
            "q_styles"=>"已派单"
          );

        //查询员工信息
        $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$_REQUEST['openid']));
        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$yuangong['y_id']));
      }
      
      pdo_insert("hyb_o2o_qiangdan",$data);
      pdo_update("hyb_o2o_fadan",array("fa_style"=>"已接单"),array("fa_id"=>$_REQUEST['fa_id']));

        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];

        /*通知用户*/
        $params["PhoneNumbers"] = $info['fa_fwtelphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        if ($_REQUEST['come']=="yuangong") {
            $params["TemplateCode"] = $aliduanxin['fdtzyh'];
            $params['TemplateParam'] = Array (
                'name'=>$info['fa_fwname'],
                'time'=>$info['fa_fwtime'],
                'content'=>$yuangong['y_name'],
                'tel'=>$yuangong['y_telphone'],
                "product"=>"sms"
            );
        }
        if ($_REQUEST['come']=='shangjia'){
            $params["TemplateCode"] = $aliduanxin['qdtzyh'];
            $params['TemplateParam'] = Array (
                'name'=>$info['fa_name'],
                'content'=>$info['fa_fwname'],
                'shop'=>$shangjia['s_name'],
                "product"=>"sms"
            );
        }
        
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

    //查询商家抢单大厅
    public function doPageDpqdlist()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $openid = $_REQUEST['openid'];
      $city = $_REQUEST['city'];
      $current = $_REQUEST['current'];
      $fenlei = $_REQUEST['fenlei'];
      $quyu = $_REQUEST['quyu'];
      $jiage = $_REQUEST['jiage'];

      if ($current=='0') {
        if (empty($fenlei) && empty($quyu) && empty($jiage)) {
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id  WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$city%' ",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
        }
        if (!empty($fenlei) && empty($quyu) && empty($jiage)) {
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1 and f.fa_fwaddress like '%$city%' ",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
        }
        if (!empty($quyu) && empty($fenlei) && empty($jiage)) {
          $sheng = $city."".$quyu;
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$sheng%' ",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
        }
        if (!empty($jiage) && empty($fenlei) && empty($quyu)) {
          if ($jiage == "由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$city%' order by f.fa_fwmoney desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
          }else if ($jiage=="由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$city%' order by f.fa_fwmoney asc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
          }else if ($jiage == "最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$city%' order by f.fa_time desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
          }
        }
        if (!empty($fenlei) && !empty($quyu) && empty($jiage)) {
          $sheng = $city."".$quyu;
          $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1 and f.fa_fwaddress like '%$sheng%' ",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
        }
        if (!empty($fenlei) && !empty($jiage) && empty($quyu)) {
          if ($jiage == "由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1  and f.fa_fwaddress like '%$city%'  order by f.fa_fwmoney desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
          }else if ($jiage=="由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1  and f.fa_fwaddress like '%$city%'  order by f.fa_fwmoney asc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
          }else if ($jiage == "最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1  and f.fa_fwaddress like '%$city%' order by f.fa_time desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派","fa_fwstyle1"=>$fenlei));
          }
        }
        if (!empty($quyu) && !empty($jiage) && empty($fenlei)) {
          $sheng = $city."".$quyu;
          if ($jiage == "由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$sheng%' order by f.fa_fwmoney desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
          }else if ($jiage=="由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$sheng%' order by f.fa_fwmoney asc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
          }else if ($jiage == "最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwaddress like '%$sheng%' order by f.fa_time desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派"));
          }
        }
        if (!empty($fenlei) && !empty($jiage) && !empty($quyu)) {
          $sheng = $city."".$quyu;
          if ($jiage == "由高到低") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1 and f.fa_fwaddress like '%$sheng%'  order by f.fa_fwmoney desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
          }else if ($jiage=="由低到高") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1 and f.fa_fwaddress like '%$sheng%'  order by f.fa_fwmoney asc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
          }else if ($jiage == "最新发布") {
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles=:q_styles and f.fa_fwstyle1=:fa_fwstyle1 and f.fa_fwaddress like '%$sheng%'  order by f.fa_time desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_styles"=>"未指派",":fa_fwstyle1"=>$fenlei));
          }
        }
        
      }else if($current=='1'){
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types in ('商家','门店') and q.q_styles in('已派单','服务中','已完成') and f.fa_fwaddress like '%$city%' order by q_id desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid));
      }
      
        if (!empty($list)) {
            foreach ($list as &$value) {
                $value['fa_fwimgpath'] = unserialize($value['fa_fwimgpath']);
                //查询接单员工
                $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." as y left join".tablename("hyb_o2o_userinfo")." as u on y.y_openid=u.openid WHERE y.uniacid=:uniacid and y.y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$value['q_pdname']));
                if (strpos($yuangong['u_thumb'],"http")===false) {
                    $yuangong['u_thumb'] = $_W['attachurl'].$yuangong['u_thumb'];
                }
              
                $value['jiedan'] = $yuangong;
            }
        }
      return $this->result(0,"success",$list);
    }
    //商家派单
    public function doPagePaidan(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $y_id = $_REQUEST['y_id'];
        $fa_id = $_REQUEST['fa_id'];

        //查询员工信息
        $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$y_id));

        //查询发单信息
        $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." where uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$fa_id));

        $data = array(
            "uniacid"=>$uniacid,
            "q_pdname"=>$y_id,
            "q_pd_time"=>date("Y-m-d H:i:s",time()),
            "q_styles"=>"已派单",
        );
        pdo_update("hyb_o2o_qiangdan",$data,array("q_dname"=>$fa_id));
        pdo_update("hyb_o2o_yuangong",array("y_typs"=>"服务中"),array("y_id"=>$y_id));


        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];

        /*通知用户*/
        $params["PhoneNumbers"] = $fadan['fa_fwtelphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['fdtzyh'];
        $params['TemplateParam'] = Array (
            'name'=>$fadan['fa_fwname'],
            'time'=>$fadan['fa_fwtime'],
            'content'=>$yuangong['y_name'],
            'tel'=>$yuangong['y_telphone'],
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

        /*通知员工*/
        $paramss["PhoneNumbers"] = $yuangong['y_telphone'];         //接收人手机号
        $paramss["SignName"] = $aliduanxin['SignName'];
        $paramss["TemplateCode"] = $aliduanxin['fdtzyg'];
        $paramss['TemplateParam'] = Array (
            'name'=>$fadan['fa_fwname'],
            'time'=>$fadan['fa_fwtime'],
            'tel'=>$fadan['fa_fwtelphone'],
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
    }

    //商家服务评论
    public function doPageSjpl()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
        $fuwu = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_shangjia=:x_shangjia",array(":uniacid"=>$uniacid,":x_shangjia"=>$shangjia['s_id']));
        foreach ($fuwu as &$value) {
            if (strpos($value['x_thumb'],"http")===false) {
                $value['x_thumb'] = $_W['attachurl'].$value['x_thumb'];
            }
            $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwupingjia")." where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$value['x_id']));
            $value['count'] = $count;
        }
        return $this->result(0,"success",$fuwu);
    }

    public function doPageSjfwpj()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $x_id = $_REQUEST['x_id'];
        $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." where uniacid=:uniacid and x_id=:x_id",array(":uniacid"=>$uniacid,":x_id"=>$x_id));
        $info['x_thumbs'] = unserialize($info['x_thumbs']);
        foreach ($info['x_thumbs'] as &$value) {
              if (strpos($value,"http")===false) {
                  $value = $_W['attachurl'].$value;
              }
            
        }
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fuwupingjia")." where uniacid=:uniacid and p_sid=:p_sid",array(":uniacid"=>$uniacid,":p_sid"=>$info['x_id']));
        if (!empty($list)) {
           
          foreach ($list as &$values) {
            $values['p_name'] = json_decode($values['p_name']);
            $values['p_pic'] = unserialize($values['p_pic']);
            foreach ($values['p_pic'] as &$valuess) {
              if (strpos($valuess,"http")===false) {
                $valuess = $_W['attachurl'].$valuess;
              }
            }   
          }
         $info['pingjia'] = $list;
        }else{
            $info['pingjia'] = "";
        }
        return $this->result(0,"success",$info);
    }
    //商家回复评价
    public function doPageAddPjhf()
    {
      global $_W,$_GPC;
      $uniacid = $_W['uniacid'];
      $p_id = $_REQUEST['p_id'];
      $data=array(
        "p_huifu" => $_REQUEST['p_huifu'],
        "p_htime" => date("Y-m-d H:i:s",time()),
      );
      pdo_update("hyb_o2o_fuwupingjia",$data,array("p_id"=>$p_id));
    }

      //查询员工的抢单
      public function doPageYuangongqdlist(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id 
         WHERE q.uniacid=:uniacid and q.q_openid=:q_openid and q.q_types=:q_types order by q.q_id desc",array(":uniacid"=>$uniacid,":q_openid"=>$openid,":q_types"=>"员工"));
        if (!empty($list)) {
            foreach ($list as &$value) {
                $value['fa_fwimgpath'] = unserialize($value['fa_fwimgpath']);
            }
        }
        return $this->result(0,"success",$list);
      }

      //查询公司派单员工
      public function doPageYuangonggspdlist(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询员工id
        $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));

        //查询商家派单
        $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_pdname=:q_pdname order by q_id desc",array(":uniacid"=>$uniacid,":q_pdname"=>$yuangong['y_id']));
        foreach ($list as &$value) {
          $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$value['q_dname']));
          $info['fa_fwimgpath'] = unserialize($info['fa_fwimgpath']);
          $value['info'] = $info;
        }
        return $this->result(0,"success",$list);
      }

      //查询员工已完成全部订单
      public function doPageYuangongddwclist(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询员工id
        $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
        // $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_pdname=:q_pdname or q_openid=:q_openid and q_styles=:q_styles",array(":uniacid"=>$uniacid,":q_pdname"=>$yuangong['y_id'],":q_openid"=>$openid,":q_styles"=>"已完成"));
       $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_pdname=:q_pdname and q_styles=:q_styles",array(":uniacid"=>$uniacid,":q_pdname"=>$yuangong['y_id'],":q_styles"=>"已完成"));
        foreach ($list as $key => $value) {
          $info = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." as f left join ".tablename("hyb_o2o_userinfo")." as u on f.fa_openid=u.openid WHERE f.uniacid=:uniacid and f.fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$value['q_dname']));
          if(strpos($info['u_thumb'],"http")===false){
            $info['u_thumb'] = $_W['attachurl'].$info['u_thumb'];
          }
          $list[$key]['info'] = $info;
        }
        return $this->result(0,"success",$list);
      }

      //派单开始服务  

      //用户
      public function doPageQiangdanfwuser(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $id = $_REQUEST['id'];
        //查询抢单
        $qiangdan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." where uniacid=:uniacid and q_dname=:q_dname",array(":uniacid"=>$uniacid,":q_dname"=>$id));
        $data = array("q_styles"=>"服务中");
        $res = pdo_update("hyb_o2o_qiangdan",$data,array("q_id"=>$qiangdan['q_id']));
        
        if ($qiangdan['q_types']=="商家" || $qiangdan['q_types']=="门店") {
            //查询商家
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiangdan['q_openid']));
            //查询服务员工
            $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$qiangdan['q_pdname']));

            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $params = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];
            $params["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $params["SignName"] = $aliduanxin['SignName'];
            $params["TemplateCode"] = $aliduanxin['fdtzfwk'];
            $params['TemplateParam'] = Array (
                'name'=>$qiangdan['fa_fwname'],
                'content'=>$yuangong['y_name'],
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
      }

      //员工
      public function doPageQiangdanfw(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $id = $_REQUEST['id'];
        $data = array("q_styles"=>"服务中");
        $res = pdo_update("hyb_o2o_qiangdan",$data,array("q_id"=>$id));
        //查询抢单
        $qiangdan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." as q left join ".tablename("hyb_o2o_fadan")." as f on q.q_dname=f.fa_id where q.uniacid=:uniacid and q.q_id=:q_id",array(":uniacid"=>$uniacid,":q_id"=>$id));
        if ($qiangdan['q_types']=="商家" || $qiangdan['q_types']=="门店") {
            //查询商家
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiangdan['q_openid']));
            //查询服务员工
            $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_id=:y_id",array(":uniacid"=>$uniacid,":y_id"=>$qiangdan['q_pdname']));
            if ($sj['pingtai']=='0') {
                $money = $sj['s_money']+$qiangdan['fa_fwshagneng'];
                pdo_update("hyb_o2o_shangjia",array("s_money"=>$money),array("s_id"=>$sj['s_id']));
            }
            else{
                $money = $yuangong['y_money']+$qiangdan['fa_fwshagneng'];
                pdo_update("hyb_o2o_yuangong",array("y_money"=>$money),array("y_id"=>$yuangong['y_id']));
            }
           
            

            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $params = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];
            $params["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $params["SignName"] = $aliduanxin['SignName'];
            $params["TemplateCode"] = $aliduanxin['fdtzfwk'];
            $params['TemplateParam'] = Array (
                'name'=>$qiangdan['fa_fwname'],
                'content'=>$yuangong['y_name'],
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
        }else{
            $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." where uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$qiangdan['q_openid']));
            $money = $yg['y_money']+$qiangdan['fa_fwshagneng'];
            pdo_update("hyb_o2o_yuangong",array("y_money"=>$money),array("y_id"=>$yg['y_id']));
        }
      }

      //派单完成
      public function doPageQiangdanwc(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $id = $_REQUEST['id'];
        $data = array("q_styles"=>"已完成");
        $res = pdo_update("hyb_o2o_qiangdan",$data,array("q_id"=>$id));
        //查询抢单信息
        $qiang = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_qiangdan")." WHERE uniacid=:uniacid and q_id=:q_id",array(":uniacid"=>$uniacid,":q_id"=>$id));
        $fadan = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fadan")." WHERE uniacid=:uniacid and fa_id=:fa_id",array(":uniacid"=>$uniacid,":fa_id"=>$qiang['q_dname']));
        //查询员工信息
        $yuangong = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
        //查询平台商家
        $pingtai = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and pingtai=1",array(":uniacid"=>$uniacid));
        if ($fadan['fa_fwpay_type']=="上门估价") {
              if ($fadan['fa_fwmoney']=='0' && $qiang['q_types']=="员工") {
                  $money = $fadan['fa_fwshagneng']*$yuangong['y_choucheng'];   //平台抽成
                  $s_money = $pingtai['s_money']+$money;
                  pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  $y_money = $yuangong['y_money']+$fadan['fa_fwshagneng']-$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
              }
              if ($fadan['fa_fwmoney']=='0' && $qiang['q_types']!="员工") {
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中"),array("y_id"=>$yuangong['y_id']));
                  // if ($qiang['q_types']=='商家') {
                  //      //查询商家
                  //       $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                  //       $s_money = $sj['s_money']+$fadan['fa_fwshagneng'];
                  //       pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                  // }
                  // if ($qiang['q_types']=="门店") {
                  //     $s_money = $pingtai['s_money']+$fadan['fa_fwshagneng'];
                  //     pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  // }
                  
              }
              if ($fadan['fa_fwmoney']!='0' && $qiang['q_types']=="员工") {
                  $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //平台抽成
                  $s_money = $pingtai['s_money']+$money;
                  pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  $y_money = $yuangong['y_money']+$fadan['fa_fwmoney']-$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$fadan['fa_id']));
              }
              if ($fadan['fa_fwmoney']!='0' && $qiang['q_types']!="员工") {
                  $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //员工分成
                  $y_money = $yuangong['y_money']+$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  if ($qiang['q_types']=='商家') {
                       //查询商家
                        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                        $s_money = $sj['s_money']+$fadan['fa_fwmoney']-$money;
                        pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                  }
                  if ($qiang['q_types']=="门店") {
                      $s_money = $pingtai['s_money']+$fadan['fa_fwmoney']-$money;
                      pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  } 
                  pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$fadan['fa_id']));
              }
        }  
        if ($fadan['fa_fwpay_type']=="一口价") {
            if ($qiang['q_types']=="员工") {
                  $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //平台抽成
                  $s_money = $pingtai['s_money']+$money;
                  pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  $y_money = $yuangong['y_money']+$fadan['fa_fwmoney']-$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$fadan['fa_id']));
            }
            if ($qiang['q_types']!="员工") {
                  $money = $fadan['fa_fwmoney']*$yuangong['y_choucheng'];   //员工分成
                  $y_money = $yuangong['y_money']+$money;
                  pdo_update("hyb_o2o_yuangong",array("y_typs"=>"空闲中","y_money"=>$y_money),array("y_id"=>$yuangong['y_id']));
                  if ($qiang['q_types']=='商家') {
                       //查询商家
                        $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
                        $s_money = $sj['s_money']+$fadan['fa_fwmoney']-$money;
                        pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$sj['s_id']));
                  }
                  if ($qiang['q_types']=="门店") {
                      $s_money = $pingtai['s_money']+$fadan['fa_fwmoney']-$money;
                      pdo_update("hyb_o2o_shangjia",array("s_money"=>$s_money),array("s_id"=>$pingtai['s_id']));
                  } 
                  pdo_update("hyb_o2o_fadan",array("fa_style"=>"已完成"),array("fa_id"=>$fadan['fa_id']));
            }
        }       
          

        if ($qiang['q_types']=="商家" || $qiang['q_types']=="门店") {
            //查询商家
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." where uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$qiang['q_openid']));
            require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
            $params = array ();
            $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
            $accessKeyId = $aliduanxin['accessKeyId'];
            $accessKeySecret = $aliduanxin['accessKeySecret'];

            /*通知用户*/
            $params["PhoneNumbers"] = $sj['s_telphone'];         //接收人手机号
            $params["SignName"] = $aliduanxin['SignName'];
            $params["TemplateCode"] = $aliduanxin['fdtzfww'];
            $params['TemplateParam'] = Array (
                'name'=>$fadan['fa_fwname'],
                'content'=>$yuangong['y_name'],
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
      }

      //员工状态值
      public function doPageYuangongzhuangtai()
      {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $y_typs = $_REQUEST['y_typs'];
        $data = array("y_typs"=>$y_typs);
        $res = pdo_update("hyb_o2o_yuangong",$data,array("y_openid"=>$openid)); 
      }

      //查询提现设置
      public function doPageTianxshezhi()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $list = pdo_fetch("SELECT * from ".tablename("hyb_o2o_tixian")." WHERE uniacid=:uniacid",array(":uniacid"=>$uniacid));
          return $this->result(0,"success",$list);
      }

      //查询分销设置
      public function doPageFenxiaoshezhi(){
        global $_GPC,$_W;
        $uniacid = $_W['uniacid'];
        $list = pdo_fetch("SELECT * from ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $list['fzthumb'] = unserialize($list['fzthumb']);
        foreach ($list['fzthumb'] as &$value) {
            if (strpos($value,"http")===false) {
              $value = $_W['attachurl'].$value;
            }
            
        }
        $list['sfthumb'] = unserialize($list['sfthumb']);
        foreach ($list['sfthumb'] as &$values) {
            if (strpos($values,"http")===false) {
              $values = $_W['attachurl'].$values;
            }
            
        }
        return $this->result(0,"success",$list);
      }

      //添加分销商
      public function doPageFenxiaoadd()
      {
          global $_W,$_GPC;
          $uniacid = $_W['uniacid'];
          $openid = $_REQUEST['openid'];
          $fxinfo = pdo_fetch("SELECT * FROM".tablename("hyb_o2o_userfenxiao")." WHERE uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
          if (empty($fxinfo)) {
              $data = array("uniacid"=>$uniacid,"f_openid"=>$_REQUEST['openid'],"f_name"=>$_REQUEST['f_name'],"f_tel"=>$_GPC['f_tel'],"f_address"=>$_REQUEST['f_address'],"f_style"=>"待审核","f_time"=>date('Y-m-d H:i:s',time()),"f_parentid"=>"0","f_type"=>"1");
              pdo_insert("hyb_o2o_userfenxiao",$data);
          }else{
             $datas = array("uniacid"=>$uniacid,"f_openid"=>$_REQUEST['openid'],"f_name"=>$_REQUEST['f_name'],"f_tel"=>$_GPC['f_tel'],"f_address"=>$_REQUEST['f_address'],"f_type"=>"1");
             pdo_update("hyb_o2o_userfenxiao",$datas,array("f_id"=>$fxinfo['f_id']));
          }
          
          $user = pdo_fetch("SELECT * from ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
          pdo_update("hyb_o2o_userinfo",array("u_fenxiao"=>"1"),array("u_id"=>$user['u_id']));
      }

      
    //添加分销商下级
    public function doPageFenxiaoaddxj()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $f_parentid = $_REQUEST['f_parentid'];
        $openid = $_REQUEST['openid'];
        $f_name = $_REQUEST['f_name'];
        //查询父级
        $parentid = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_id=:f_id",array(":uniacid"=>$uniacid,":f_id"=>$f_parentid));
        $data = array("uniacid"=>$uniacid,"f_openid"=>$openid,"f_name"=>$f_name,"f_parentid"=>$f_parentid,"f_style"=>"审核通过","f_time"=>date("Y-m-d H:i:s",time()),"f_type"=>"0");
        if (!empty($parentid)) {      
            //查询openid
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
            if (empty($user) && $parentid['f_openid']!=$openid) {
               pdo_insert("hyb_o2o_userfenxiao",$data); 
               $user = pdo_fetch("SELECT * from ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
               pdo_update("hyb_o2o_userinfo",array("u_fenxiao"=>"1"),array("u_id"=>$user['u_id']));
            }
        }
        
    }

      //分销商详情
      public function doPageUserFenxiao()
      {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $list = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
        //查询分销商设置
        $fenxiaoshezhi =  pdo_fetch("SELECT * from ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
        $fenxiaoshezhi['fzthumb'] = unserialize($fenxiaoshezhi['fzthumb']);
        foreach ($fenxiaoshezhi['fzthumb'] as &$value) {
            if (strpos($value,"http")===false) {
                $value = $_W['attachurl'].$value;
            }
        }

        $list['fenxiao_thumb'] = $fenxiaoshezhi['fzthumb'];
        $list['fxhbthumb'] = $_W['attachurl'].$fenxiaoshezhi['fxthumb'];

        //查询分销下级[一级]
        $fenxiaoyiji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$list['f_id']));
        $fenxiaoyijinum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$list['f_id']));
        //查询分销下级[二级]
        if (!empty($fenxiaoyiji)) {
            foreach ($fenxiaoyiji as &$value) {
                $fenxiaoerji = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$value['f_id']));
                $fenxiaoerjinum+=$fenxiaoerji;
            }
        }
        $list['fenxiaoxiajinum'] = $fenxiaoyijinum+$fenxiaoerjinum;

        //分销二维码
        $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_o2o_parment') . " where uniacid=:uniacid", array(":uniacid" => $uniacid));
        $APPID = $result['appid'];
        $SECRET = $result['appsecret'];
        $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
        $getArr=array();
        $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
        $access_token=$tokenArr->access_token;
        $noncestr ='hyb_o2o/index/index?f_parentid='.$list['f_id'];
        $width=430;
        $post_data='{"path":"'.$noncestr.'","width":'.$width.'}';
        $url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$access_token;
        $result=$this->api_notice_increment($url,$post_data); 
        $image_name = md5(uniqid(rand())).".jpg";
        $filepath = "../attachment/{$image_name}";   
        $file_put = file_put_contents($filepath, $result);
        @require_once (IA_ROOT . '/framework/function/file.func.php');
        @file_remote_upload($image_name);
        $list['yaoqingma'] = $_W['attachurl'].$image_name;


        //查询分销商提现
        $tixiannum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_fopenid=:t_fopenid",array(":uniacid"=>$uniacid,":t_fopenid"=>$openid));
        $list['tixiannum'] = $tixiannum;

        //查询分销商收益明细
        $shouyi = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaoyongjin")." as f left join ".tablename("hyb_o2o_userfenxiao")." as u on f.yonghu=u.f_name where f.uniacid=:uniacid and f.parentid=:parentid and f.parentopenid=:parentopenid order by f.time desc ",array(":uniacid"=>$uniacid,":parentid"=>$list['f_id'],":parentopenid"=>$list['f_openid']));
        foreach ($shouyi as &$valuesssss) {
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." where uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$valuesssss['f_openid']));
            if (strpos($user['u_thumb'],"http")===false) {
                $valuesssss['thumb'] = $_W['attachurl'].$user['u_thumb'];
            }else{
                $valuesssss['thumb'] = $user['u_thumb'];
            }
            
        }
        $list['shouyi'] = $shouyi;
        return $this->result(0,"success",$list);
      }

      //查询分销下级
      public function doPageUserfenxiaoxiaji(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $cur = $_REQUEST['cur'];
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
        if ($cur=="0") {
           //查询分销下级[一级]
            $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." as f left join ".tablename("hyb_o2o_userinfo")." as u on f.f_openid=u.openid where f.uniacid=:uniacid and f.f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$user['f_id']));
            foreach ($fenxiaoerji as &$value2) {
                if (strpos($value2['u_thumb'],"http")===false) {
                    $value2['u_thumb'] = $_W['attachurl'].$value2['u_thumb'];
                }
            }
        }elseif ($cur=="1") {
           //查询分销下级[一级]
            $fenxiaoyiji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$user['f_id']));
            //查询分销下级[二级]
            if (!empty($fenxiaoyiji)) {
                foreach ($fenxiaoyiji as &$value) {
                    $fenxiaoerji = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." as f left join ".tablename("hyb_o2o_userinfo")." as u on f.f_openid=u.openid where f.uniacid=:uniacid and f.f_parentid=:f_parentid",array(":uniacid"=>$uniacid,":f_parentid"=>$value['f_id']));
                    foreach ($fenxiaoerji as &$value2) {
                        if (strpos($value2['u_thumb'],"http")===false) {
                            $value2['u_thumb'] = $_W['attachurl'].$value2['u_thumb'];
                        }
                    }
                    $list[]=$fenxiaoerji;
                }
            }else{
                $list = [];
            }   
        }
        return $this->result(0,"success",$list);
      }

      //分销商提现
      public function doPageUserfenxiaotixian()
      {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $userfenxiao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
        //查询提现协议
        $fenxiaoshezhi = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fenxiao")." where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
        $userfenxiao['txsmoney'] = $fenxiaoshezhi['tx_money'];
        $userfenxiao['txsxf'] = $fenxiaoshezhi['tx_rate'];
        $userfenxiao['txxy'] = $fenxiaoshezhi['tx_details'];
        return $this->result(0,"success",$userfenxiao);
      }

      //分销商提现添加
      public function doPageUserfenxiaotixianadd()
      {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        //查询分销商
        $fenxiao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userfenxiao")." where uniacid=:uniacid and f_openid=:f_openid",array(":uniacid"=>$uniacid,":f_openid"=>$openid));
        $money = $_REQUEST['je'];
        $shouxufeis = $money*$_REQUEST['shouxufei']*0.01;
        $shouxufei = sprintf("%.2f", $shouxufeis);
        $counttx = $money+$shouxufei;
        if ($counttx>$fenxiao['f_money']) {
            $tx_money = $money-$shouxufei;
            $type = "1";
            $countmoney = $money;
        }else{
           $tx_money = $money;
           $type = "2";
           $countmoney = $money+$shouxufei;
        }
        $u_money = $fenxiao['f_money']-$countmoney;
        $datas = array("f_money"=>$u_money);
        pdo_update("hyb_o2o_userfenxiao",$datas,array("f_id"=>$fenxiao['f_id']));
        $data = array("uniacid"=>$uniacid,"t_fopenid"=>$openid,"t_fid"=>$fenxiao['f_id'],"t_name"=>$fenxiao['f_name'],"t_money"=>$tx_money,"t_shouxufei"=>$shouxufei,"t_time"=>date("Y-m-d H:i:s",time()),"t_status"=>"待审核","t_type"=>$type);
        pdo_insert("hyb_o2o_fenxiaotixian",$data);
        return $this->result(0,"success",$tx_money);
      }

      //分销商提现记录
      public function doPageUserfenxiaotixianjilu()
      {
            global $_W,$_GPC;
            $uniacid = $_W['uniacid'];
            $openid = $_REQUEST['openid'];
            $cur = $_REQUEST['cur'];
            if ($cur=="0") {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_fopenid=:t_fopenid and t_status=:t_status",array(":uniacid"=>$uniacid,":t_fopenid"=>$openid,":t_status"=>"待审核"));
            }
            if ($cur=="1") {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_fopenid=:t_fopenid and t_status=:t_status",array(":uniacid"=>$uniacid,":t_fopenid"=>$openid,":t_status"=>"已提现"));
            }
            if ($cur=="2") {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_fenxiaotixian")." where uniacid=:uniacid and t_fopenid=:t_fopenid and t_status=:t_status",array(":uniacid"=>$uniacid,":t_fopenid"=>$openid,":t_status"=>"已拒绝"));
                foreach ($list as &$value) {
                    $value['count'] = $value['t_money']+$value['t_shouxufei'];
                }
            }
            return $this->result(0,"success",$list);
      }

      //服务报价
      public function doPageFuwuBaojia()
      {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $o_id = $_REQUEST['id'];
        
        $money = $_REQUEST['money'];
        $data = array(
          "o_count_money"=>$money,
          "o_fwry"=>"",
          "o_pay_types"=>"0",
          "o_type"=>"未支付",
          "o_fw_type"=>"0",
          "o_pay_typess"=>"",
        );
        pdo_update("hyb_o2o_orderfuwu",$data,array("o_id"=>$o_id));

        //查询订单
        $order = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." where uniacid=:uniacid and o_id=:o_id",array(":uniacid"=>$uniacid,":o_id"=>$o_id));

        require_once dirname(__FILE__) .'/inc/func/SignatureHelper.php';
        $params = array ();
        $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_news")." WHERE uniacid=:uniacid ",array("uniacid"=>$uniacid)); 
        $accessKeyId = $aliduanxin['accessKeyId'];
        $accessKeySecret = $aliduanxin['accessKeySecret'];
        $params["PhoneNumbers"] = $order['o_telphone'];         //接收人手机号
        $params["SignName"] = $aliduanxin['SignName'];
        $params["TemplateCode"] = $aliduanxin['baojia'];

        /*通知用户*/
        $params['TemplateParam'] = Array (
            'name'=>$order['ordersn'],
            'conrtent'=>$order['o_xiangmu_name'],
            'money'=>$order['o_count_money'],
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
        // var_dump($params);
        // var_dump($content);
      }

    //财务统计
    public function doPageCaiwu()
    {
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $nian = $_REQUEST['nian'];

        //查询商家信息
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));

        /*近七天商家收益*/
        $time['tian']=array(
            array('time'=>date('m.d', strtotime('-7 days')),'times'=>date('Y-m-d', strtotime('-7 days'))),
            array('time'=>date('m.d', strtotime('-6 days')),'times'=>date('Y-m-d', strtotime('-6 days'))),
            array('time'=>date('m.d', strtotime('-5 days')),'times'=>date('Y-m-d', strtotime('-5 days'))),
            array('time'=>date('m.d', strtotime('-4 days')),'times'=>date('Y-m-d', strtotime('-4 days'))),
            array('time'=>date('m.d', strtotime('-3 days')),'times'=>date('Y-m-d', strtotime('-3 days'))),
            array('time'=>date('m.d', strtotime('-2 days')),'times'=>date('Y-m-d', strtotime('-2 days'))),
            array('time'=>date('m.d', strtotime('-1 days')),'times'=>date('Y-m-d', strtotime('-1 days'))),
        );

        foreach ($time['tian'] as &$value) {
            $times = $value['times'];
            $dingdan = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_store=:o_store and o_pay_types=1 and o_type='已完成' and o_yy_riqi like '%$times%'",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id']));
            if (empty($dingdan[0]['money']) || $dingdan[0]['money']==null || $dingdan[0]['money']=='' || $dingdan[0]['money']=='null') {
                $value['money'] = "0";
            }else{
                $value['money'] = $dingdan[0]['money'];
            }   
        }


        /*今日收益*/
        $timess = date('Y-m-d',time());
        $newdingdannum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_store=:o_store and o_pay_types=1 and o_type='已完成' and o_yy_riqi like '%$timess%'",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id']));
        $newdingdan = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_store=:o_store and o_pay_types=1 and o_type='已完成' and o_yy_riqi like '%$timess%'",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id']));
        if (empty($newdingdan[0]['money']) || $newdingdan[0]['money']==null || $newdingdan[0]['money']=='' || $dingdan[0]['money']=='null') {
            $money = "0";
        }else{
            $money= $newdingdan[0]['money'];
        }
        $time['new'] = array("num"=>$newdingdannum,"money"=>$money);
        return $this->result(0,"success",$time);
    }

    public function doPageCaiwus(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $nian = $_REQUEST['nian'];

        //查询商家信息
        $shangjia = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
        /*年收益*/
        if ($nian%4==0 && ($nian%100!=0 || $nian%400==0)){
            $yue = array(
                array('yue'=>"1",'time1'=>$nian.'-01-01',"time2"=>$nian.'-01-31'),
                array('yue'=>"2",'time1'=>$nian.'-02-01',"time2"=>$nian.'-02-29'),
                array('yue'=>"3",'time1'=>$nian.'-03-01',"time2"=>$nian.'-03-31'),
                array('yue'=>"4",'time1'=>$nian.'-04-01',"time2"=>$nian.'-04-30'),
                array('yue'=>"5",'time1'=>$nian.'-05-01',"time2"=>$nian.'-05-31'),
                array('yue'=>"6",'time1'=>$nian.'-06-01',"time2"=>$nian.'-06-30'),
                array('yue'=>"7",'time1'=>$nian.'-07-01',"time2"=>$nian.'-07-31'),
                array('yue'=>"8",'time1'=>$nian.'-08-01',"time2"=>$nian.'-08-31'),
                array('yue'=>"9",'time1'=>$nian.'-09-01',"time2"=>$nian.'-09-30'),
                array('yue'=>"10",'time1'=>$nian.'-10-01',"time2"=>$nian.'-10-31'),
                array('yue'=>"11",'time1'=>$nian.'-11-01',"time2"=>$nian.'-11-30'),
                array('yue'=>"12",'time1'=>$nian.'-12-01',"time2"=>$nian.'-12-31'),
            );
        }else{
            $yue = array(
                array('yue'=>"1",'time1'=>$nian.'-01-01',"time2"=>$nian.'-01-31'),
                array('yue'=>"2",'time1'=>$nian.'-02-01',"time2"=>$nian.'-02-28'),
                array('yue'=>"3",'time1'=>$nian.'-03-01',"time2"=>$nian.'-03-31'),
                array('yue'=>"4",'time1'=>$nian.'-04-01',"time2"=>$nian.'-04-30'),
                array('yue'=>"5",'time1'=>$nian.'-05-01',"time2"=>$nian.'-05-31'),
                array('yue'=>"6",'time1'=>$nian.'-06-01',"time2"=>$nian.'-06-30'),
                array('yue'=>"7",'time1'=>$nian.'-07-01',"time2"=>$nian.'-07-31'),
                array('yue'=>"8",'time1'=>$nian.'-08-01',"time2"=>$nian.'-08-31'),
                array('yue'=>"9",'time1'=>$nian.'-09-01',"time2"=>$nian.'-09-30'),
                array('yue'=>"10",'time1'=>$nian.'-10-01',"time2"=>$nian.'-10-31'),
                array('yue'=>"11",'time1'=>$nian.'-11-01',"time2"=>$nian.'-11-30'),
                array('yue'=>"12",'time1'=>$nian.'-12-01',"time2"=>$nian.'-12-31'),
            );
        }
        foreach ($yue as &$values) {
            $time1 = $values['time1'];
            $time2 = $values['time2'];
            $dingdan = pdo_fetchall("SELECT sum(o_count_money) as money FROM ".tablename("hyb_o2o_orderfuwu")." WHERE uniacid=:uniacid and o_store=:o_store and o_pay_types=1 and o_type='已完成' and o_yy_riqi > '$time1' and o_yy_riqi < '$time2' ",array(":uniacid"=>$uniacid,":o_store"=>$shangjia['s_id']));
            if (empty($dingdan[0]['money']) || $dingdan[0]['money']==null || $dingdan[0]['money']=='' || $dingdan[0]['money']=='null') {
                $values['money'] = "0";
            }else{
                $values['money'] = $dingdan[0]['money'];
            } 
        }
        return $this->result(0,"success",$yue);
    }
/*
     * 保存用户的地理位置信息
     *
     */
    public function doPageSaveLocaltion(){
        global $_W,$_GPC;
        $uniacid    = $_W['uniacid'];
        $lat        = $_REQUEST['lat'];
        $lon        = $_REQUEST['lon'];
        $openid     = $_REQUEST['openid'];
        $o_id        = $_REQUEST['o_id'];

        //更新用户的地理位置
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        //更新用户位置
        pdo_update("hyb_o2o_userinfo",array("lat"=>$lat,"lon"=>$lon),array("u_id"=>$user['u_id']));
        //查询用户的当前状态
        $orderinfo=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_orderfuwu")." WHERE o_id=:o_id",array(":o_id"=>$o_id));
        if ($orderinfo['o_uid'] == $user['u_id'] ) {
            //下单人员 获取服务人员位置信息
            $service=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE u_id=:u_id",array(":u_id"=>$orderinfo['o_fwry_id']));
            if ($service['lat']) {
                $location['code']=1;
                $temp=explode(",", $orderinfo['o_localtion']);
                $location['start']['lat']=substr($service['lat'],0,9);
                $location['start']['lon']=substr($service['lon'],0,10);
                $location['end']['lat']=substr($temp[1],0,9);
                $location['end']['lon']=substr($temp[0],0,10);
                return $this->result(0,"success",$location);
            }else{
                $location['code']=0;
                $location['desc']="未获取服务人员位置信息";
                return $this->result(0,"success",$location);
            }
        }else{
            //服务人员 获取下单人员位置信息
            $orderuser=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE u_id=:u_id",array(":u_id"=>$orderinfo['o_uid']));
            if ($orderuser['lat']) {
                $location['code']=1;
                $temp=explode(",", $orderinfo['o_localtion']);
                $location['end']['lat']=substr($temp[1],0,9);
                $location['end']['lon']=substr($temp[0],0,10);
                $location['start']['lat']=substr($user['lat'],0,9);
                $location['start']['lon']=substr($user['lon'],0,10);
                return $this->result(0,"success",$location);
            }else{
                $location['code']=0;
                $location['desc']="未获取下单人员位置信息";
                return $this->result(0,"success",$location);
            }
        }
    }
    //用户余额充值
    public function doPageChongzhi(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $money = $_REQUEST['money'];
        $openid = $_REQUEST['openid'];
        $data = array(
            "uniacid"=>$uniacid,
            "openid"=>$openid,
            "money"=>$money,
            "time"=>date("Y-m-d H:i:s",time()),
            "jibie"=>"0",
        );
        pdo_insert("hyb_o2o_userchongzhi",$data);
        //查询用户
        $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
        $u_money = $user['u_money']+$money;
        pdo_update("hyb_o2o_userinfo",array("u_money"=>$u_money),array("u_id"=>$user['u_id']));
    }


    //提现记录
    public function doPageTixanlist(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $openid = $_REQUEST['openid'];
        $typs = $_REQUEST['typs'];
        $cur = $_REQUEST['cur'];
        if ($typs=='yh') {
            //查询用户
            $user = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_userinfo")." WHERE uniacid=:uniacid and openid=:openid",array(":uniacid"=>$uniacid,":openid"=>$openid));
            if ($cur=='0') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and u_id=:u_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":u_id"=>$user['u_id'],":statue"=>"待提现"));
            }
            if ($cur=='1') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and u_id=:u_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":u_id"=>$user['u_id'],":statue"=>"已提现"));
            }
            if ($cur=='2') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and u_id=:u_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":u_id"=>$user['u_id'],":statue"=>"已拒绝"));
                if (!empty($list)) {
                    foreach ($list as &$value) {
                        $value['countmoney'] = $value['money']+$value['s_money'];
                    }

                }
            }           
        }
        if ($typs=='sj') {
            //查询商家
            $sj = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_shangjia")." WHERE uniacid=:uniacid and s_u_openid=:s_u_openid",array(":uniacid"=>$uniacid,":s_u_openid"=>$openid));
            if ($cur=='0') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and s_id=:s_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":s_id"=>$sj['s_id'],":statue"=>"待提现"));
            }
            if ($cur=='1') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and s_id=:s_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":s_id"=>$sj['s_id'],":statue"=>"已提现"));
            }
            if ($cur=='2') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and s_id=:s_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":s_id"=>$sj['s_id'],":statue"=>"已拒绝"));
                if (!empty($list)) {
                    foreach ($list as &$value) {
                        $value['countmoney'] = $value['money']+$value['s_money'];
                    }

                }
            }           
        }
        if ($typs=='yg') {
            //查询商家
            $yg = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_yuangong")." WHERE uniacid=:uniacid and y_openid=:y_openid",array(":uniacid"=>$uniacid,":y_openid"=>$openid));
            if ($cur=='0') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and y_id=:y_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":y_id"=>$yg['y_id'],":statue"=>"待提现"));
            }
            if ($cur=='1') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and y_id=:y_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":y_id"=>$yg['y_id'],":statue"=>"已提现"));
            }
            if ($cur=='2') {
                $list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_usertixian")." WHERE uniacid=:uniacid and y_id=:y_id and statue=:statue order by time desc ",array(":uniacid"=>$uniacid,":y_id"=>$yg['y_id'],":statue"=>"已拒绝"));
                if (!empty($list)) {
                    foreach ($list as &$value) {
                        $value['countmoney'] = $value['money']+$value['s_money'];
                    }

                }
            }           
        }
        return $this->result(0,"success",$list);
    }
    //用户获取时间段
    public function doPageGetTimes(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $x_id=$_GPC['x_id'];
        $j=6;
        $times=array();
        $weekarray=array("日","一","二","三","四","五","六","日","一","二","三","四","五","六");
        for ($i=0; $i < $j; $i++) { 
            $times['week'][$i]['week']= "星期".$weekarray[date("w")+1+$i];
            $times['week'][$i]['days']= date("Y-m-d",strtotime("+".(1+$i)." day"));
        }
        //获取时间对应的次数
        $countarray=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." WHERE uniacid=:uniacid and x_id=:x_id ",array(":uniacid"=>$uniacid,":x_id"=>$_GPC['x_id']));
        if(!$countarray['x_timecontent']){
            $countarray['x_timecontent']="a:3:{s:5:\"start\";a:1:{i:0;s:5:\"08:00\";}s:3:\"end\";a:1:{i:0;s:5:\"18:00\";}s:6:\"counts\";a:1:{i:0;s:2:\"10\";}}";
        }
        $countime=array();
        $allcount=unserialize($countarray['x_timecontent']);
        foreach ($allcount['start'] as $key => $value) {
            $times['count'][$key]['time']=$value."-".$allcount['end'][$key];
            //获取剩余次数
            $count= pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu_time")." WHERE uniacid=:uniacid and date=:date and time=:time and status=1 and x_id=:x_id",array(":x_id"=>$x_id,":uniacid"=>$uniacid,":date"=>date("Y-m-d",strtotime("+1 day")),":time"=>$times['count'][$key]['time']));
           $times['count'][$key]['count']=$allcount['counts'][$key]-$count;
            if ($times['count'][$key]['count'] < 1) {
                unset($times['count'][$key]);
            }
        }
        return $this->result(0,"success",$times);
    }
    //用户获取时间段
    public function doPageGetDayTimes(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $x_id=$_GPC['x_id'];
        $days=$_GPC['days'];
        $times=array();
       
        //获取时间对应的次数
        $countarray=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu")." WHERE uniacid=:uniacid and x_id=:x_id ",array(":uniacid"=>$uniacid,":x_id"=>$_GPC['x_id']));
        $countime=array();
        if(!$countarray['x_timecontent']){
            $countarray['x_timecontent']="a:3:{s:5:\"start\";a:1:{i:0;s:5:\"08:00\";}s:3:\"end\";a:1:{i:0;s:5:\"18:00\";}s:6:\"counts\";a:1:{i:0;s:2:\"10\";}}";
        }
        $allcount=unserialize($countarray['x_timecontent']);
        foreach ($allcount['start'] as $key => $value) {
            $times[$key]['time']=$value."-".$allcount['end'][$key];
            //获取剩余次数
            $count= pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_fuwu_time")." WHERE uniacid=:uniacid and date=:date and time=:time and status=1 and x_id=:x_id",array(":x_id"=>$x_id,":uniacid"=>$uniacid,":date"=>$days,":time"=>$times[$key]['time']));
            $times[$key]['count']=$allcount['counts'][$key]-$count;
            if ($times[$key]['count'] < 1) {
                unset($times[$key]);
            }
        }
        return $this->result(0,"success",array_values($times));
    }
    //更新用户的经纬度
    public function doPageRefreshLocaltion(){
        global $_W,$_GPC;
        $item['lat']=$_GPC['lat'];
        $item['lon']=$_GPC['lon'];
        $res = pdo_update('hyb_o2o_userinfo', $item, array('openid' => $_GPC['openid']));
    }
    //获取二级服务参考价
    public function doPageGetErjiPrice(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $type_id = $_GPC['id'];
        $type_info= pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_fuwu_type")." WHERE uniacid=:uniacid and xt_id=:xt_id ",array(":uniacid"=>$uniacid,":xt_id"=>$type_id));
       return $this->result(0,"success",array('price'=>$type_info['xt_reference_price']));
    }
    //获取头像圆角
    public function doPageRadiusImg($radius = 61) {
        $imgpath = $_SERVER['DOCUMENT_ROOT']."/addons/hyb_o2o/resource/images/lo_ocMvv0PKETh8wI5ruPiHwCdkgr3Y.png";//'lo_ocMvv0PKETh8wI5ruPiHwCdkgr3Y.png';
        ob_start();//打开输出
        readfile("https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJjsL3cWibeh4S63qicLibHlbzPA1lbsVJmibMpkCia44H7fa5Bkojsv2s7ID0fpUfTCr8WqCOWkUCS2iaQ/132");//输出图片文件
        $oldimg = ob_get_contents();//得到浏览器输出
        ob_end_clean();//清除输出并关闭
        $size = strlen($oldimg);//得到图片大小
     
        //file_put_contents("./resource/images/lo_ocMvv0PKETh8wI5ruPiHwCdkgr3Y.png", "");
        $fp2 = fopen($imgpath, "a");        
        fwrite($fp2, $oldimg);//向当前目录写入图片文件，并重新命名
        fclose($fp2);  

        $ext     = pathinfo($imgpath);
        $imgpath="resource/images/lo_ocMvv0PKETh8wI5ruPiHwCdkgr3Y.png";
        


        $ext     = pathinfo($imgpath);
        $src_img = null;
        switch ($ext['extension']) {
        case 'jpg':
            $src_img = imagecreatefromjpeg($imgpath);
            break;
        case 'png':
            $src_img = imagecreatefrompng($imgpath);
            break;
        }
        $wh = getimagesize($imgpath);
        $w  = $wh[0];
        $h  = $wh[1];
        // $radius = $radius == 0 ? (min($w, $h) / 2) : $radius;
        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);
        $r = $radius; //圆 角半径
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (($x >= $radius && $x <= ($w - $radius)) || ($y >= $radius && $y <= ($h - $radius))) {
                    //不在四角的范围内,直接画
                    imagesetpixel($img, $x, $y, $rgbColor);
                } else {
                    //在四角的范围内选择画
                    //上左
                    $y_x = $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //上右
                    $y_x = $w - $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下左
                    $y_x = $r; //圆心X坐标
                    $y_y = $h - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下右
                    $y_x = $w - $r; //圆心X坐标
                    $y_y = $h - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                }
            }
        }
        imagepng($img);
        imagedestroy($img);
    }
    //获取高德地图key
    public function doPageGetGaodeKey(){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $base=pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_base")." WHERE uniacid=:uniacid  ",array(":uniacid"=>$uniacid));
        return $this->result(0,"success",$base);
    }

}