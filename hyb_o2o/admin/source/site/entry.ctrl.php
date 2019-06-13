<?php
/**
 * 派单o2o模块小程序接口定义
 * 版权归山西网博思创网络科技有限公司所有
 * https://www.webStrongtech.net
 * 作者 陌笙
**/

defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('extension');

$entry = array(
	'module' => $_GPC['m'],
	'do' => $_GPC['do'],
	'state' => $_GPC['state'],
	'direct' => $_GPC['direct']
);
$_GPC['__entry'] = $entry['title'];
$_GPC['__state'] = $entry['state'];
$_GPC['state'] = $entry['state'];
$_GPC['m'] = $entry['module'];
$_GPC['do'] = $entry['do'];
$modules = uni_modules();
$_W['current_module'] = $modules[$entry['module']];
$site = WeUtility::createModuleSite($entry['module']);
$method = 'doWeb' . ucfirst($entry['do']);
define('IN_MODULE', $entry['module']);

if(!is_error($site)) {
	$sysmodule = system_modules();
	if(in_array($m, $sysmodule)) {
		$site_urls = $site->getTabUrls();
	}
	$method = 'doWeb' . ucfirst($entry['do']);
	
	exit($site->$method());
}

exit("访问的方法 {$method} 不存在.");
