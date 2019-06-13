<?php
defined('IN_IA') or exit('Access Denied');
define('IN_GW', true);
$setting = $_W['setting'];

if(checksubmit('submit')) {
	
	$username = trim($_GPC['username']);
	$password = trim($_GPC['password']);
	if(empty($username)) {
		message('请输入要登录的用户名');
	}
	if (empty($password)) {
		message('请输入要登录的用户密码');
	}
	//查询
	$uniacid = $_GPC['uid'];
	$zhanghao = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_zhanghao")." WHERE uniacid=:uniacid and zhanghao=:zhanghao",array(":uniacid"=>$uniacid,":zhanghao"=>$username));
	if (empty($zhanghao)) {
		message('您的账号不存在！');
	}else{
		if ($zhanghao['status']=="1") {
			message('您的账号已经被系统禁止，请联系平台管理员解决！');
		}elseif ($zhanghao['status']=="2") {
			if ($password!=$zhanghao['mima']) {
				message('您的输入的登录密码不正确，请重新输入或请联系平台管理员解决！');
			}elseif ($password==$zhanghao['mima']) {
				message("登录成功!", url('site/entry/', array('m' => 'hyb_o2o','id' => $zhanghao['z_shangjia'], 'do' => 'start',"uid"=>$uniacid)), 'success');
			}
		}
	}
}

template('user/login');