<?php
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$GLOBALS['frames'] = $this->getMainMenu();
load()->func('tpl');
load()->func('file'); //调用上传函数
$dir_url='../web/cert/hyb_o2o/'; //上传路径
mkdirs($dir_url); 
        //创建目录
            
        if ($_FILES["upfile"]["name"]){
            $upfile=$_FILES["upfile"]; 
            //获取数组里面的值 
            $name=$upfile["name"];//上传文件的文件名 
            //$type=$upfile["type"];//上传文件的类型 
            $size=$upfile["size"];//上传文件的大小 
            if($size>2*1024*1024) {  
               
                message("文件过大，不能上传大于2M的文件!",$this->createWebUrl("pay",array()),"success"); 
                exit();  
            } 
            if(file_exists($dir_url.$settings["upfile"]))@unlink ($dir_url.$settings["upfile"]);
            $cfg['upfile']=TIMESTAMP.".pem";
            move_uploaded_file($_FILES["upfile"]["tmp_name"],$dir_url.$upfile["name"]); //移动到目录下
            $upfiles = $dir_url.$name;
            
            }
            if ($_FILES["keypem"]["name"]){
            $upfile=$_FILES["keypem"]; 


            //获取数组里面的值 
            $name=$upfile["name"];//上传文件的文件名 
            //$type=$upfile["type"];//上传文件的类型 
            $size=$upfile["size"];//上传文件的大小 
            if($size>2*1024*1024) {  
                $this->adminMessage("文件过大，不能上传大于2M的文件!",$this->createWebUrl("zhengshu",array("op"=>"display")),"success");  
                exit();  
            }   
            if(file_exists($dir_url.$settings["keypem"]))@unlink ($dir_url.$settings["keypem"]);
            move_uploaded_file($_FILES["keypem"]["tmp_name"],$dir_url.$upfile["name"]); //移动到目录下
            $keypems = $dir_url.$name;
            }
            $item = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_tixian")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
            if (checksubmit("submit")) {
                $data = array(
                    'uniacid'=>$uniacid,
                    'shouxufei'=>$_GPC['shouxufei'],
                    'apiclient_cert'=>$upfiles,
                    'apiclient_key'=>$keypems,
                );
                if (empty($item)) {
                    pdo_insert("hyb_o2o_tixian",$data);
                    message('添加成功',$this->createWebUrl('pay',array()),'success');
                }
                else
                {
                    pdo_update("hyb_o2o_tixian",$data,array("id"=>$item['id']));
                    message('编辑成功',$this->createWebUrl('pay',array()),'success');
                }
            }
include $this->template('web/pay');