<?php
defined('IN_IA') or exit('Access Denied');

class hyb_o2oModule extends WeModule
{
    

    public function welcomeDisplay()
    {   
        global $_GPC, $_W;
    	 if ($_W['role'] == 'operator') {
	        $url = $this->createWebUrl('store');
	        Header("Location: " . $url);
    	}else{
	    	$url = $this->createWebUrl('gaikuangdata');
	        Header("Location: " . $url);
    	}
    }
}