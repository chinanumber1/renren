<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$op = !empty($_GPC['op'])?$_GPC['op']:'display';
$uniacid = $_W['uniacid'];
if ($op =="display") {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=0 order by convert(name using gbk) asc  limit ".(($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=0",array(":uniacid"=>$uniacid));
	$pager = pagination($count, $pindex, $psize);
}
if ($op == "post") {
	$id = $_GPC['id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"name"=>$_GPC['name'],"parentid"=>"0","tuijian"=>$_GPC['tuijian']);
		if (empty($id)) {
			pdo_insert("hyb_o2o_city",$data);
			message("添加成功!",$this->createWebUrl("city",array("op"=>"display")),"success");
		}else{
			pdo_update("hyb_o2o_city",$data,array("id"=>$id));
			message("修改成功!",$this->createWebUrl("city",array("op"=>'display')),"success");
		}
	}
}
if ($op == "displays") {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$list = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid!=0 limit ".(($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
	foreach ($list as &$value) {
		$value['parent'] = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$value['parentid']));
	}
	$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid!=0",array(":uniacid"=>$uniacid));
	$pager = pagination($count, $pindex, $psize);
}
if ($op == "posts") {
	$id = $_GPC['id'];
	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
	$parent = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_city")." where uniacid=:uniacid and parentid=0",array(":uniacid"=>$uniacid));
	if (checksubmit("submit")) {
		$data = array("uniacid"=>$uniacid,"name"=>$_GPC['name'],"parentid"=>$_GPC['parentid']);
		if (empty($id)) {
			pdo_insert("hyb_o2o_city",$data);
			message("添加成功!",$this->createWebUrl("city",array("op"=>"displays")),"success");
		}else{
			pdo_update("hyb_o2o_city",$data,array("id"=>$id));
			message("修改成功!",$this->createWebUrl("city",array("op"=>'displays')),"success");
		}
	}
}
if ($op == "add") {
	if (checksubmit("submit")) {
		$force = $_GPC['force'];
		$file = $_FILES['file'];
		$type = @end( explode('.', $file['name']));
		$type = strtolower($type);
		//开始导入
		set_time_limit(0);
		require_once(IA_ROOT . '/framework/library/phpexcel/PHPExcel.php');
		require_once(IA_ROOT . '/framework/library/phpexcel/PHPExcel/IOFactory.php');
		if( $type == 'xls' ){
			$inputFileType = 'Excel5';    //这个是读 xls的
		}else{
			$inputFileType = 'Excel2007';//这个是计xlsx的
		}		
					
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($file['tmp_name']);
		$objWorksheet = $objPHPExcel->getActiveSheet();//取得总行数
		$highestRow = $objWorksheet->getHighestRow();//取得总列

		$title = array('id','parentid','name');

		$key = $title[$i];
		$num = count($title);
		$newarr = array();		   
		for ($row = 2;$row <= $highestRow;$row++){
			for($i = 0;$i<$num;$i++){
				$arr['uniacid'] = $uniacid;
				// $arr['id'] = $arr[$title[0]].$uniacid;
				// $arr['parentid'] = $arr[$title[1]].$uniacid;
				$arr[$title[$i]] = $objWorksheet->getCellByColumnAndRow($i, $row)->getValue();
			}
			$arr['id'] = $arr[$title[0]].$uniacid;
			if ($arr[$title[1]]!='0') {
				$arr['parentid'] = $arr[$title[1]].$uniacid;
			}
			
			array_push($newarr,$arr); 	
		}	
		// var_dump($newarr);exit();
		$num = count($newarr);
		$each = 120;     // 数据总数
		$step = ceil( $num/$each);  // insert执行总次数
		for($j=0;$j<$step;$j++){
		 	$nextNum= $j*$each;
		 	$newarr1 = array_slice($newarr, $nextNum, $each);
				foreach ($newarr1 as $key => $value) {
				 	$res = pdo_insert('hyb_o2o_city',$value);
			 	}
			}
			message("导入成功!",$this->createWebUrl("city",array("op"=>"display")),"success");
		}
}
if ($op == "zhuang") {
	$id = $_GPC['id'];
	$tuijian = $_GPC['tuijian'];
	$typs = $_GPC['typs'];
	pdo_update("hyb_o2o_city",array("tuijian"=>$tuijian),array("id"=>$id));
	if ($typs=="yiji") {
		message("修改成功!",$this->createWebUrl("city",array("op"=>"display")),"success");
	}else{
		message("修改成功!",$this->createWebUrl("city",array("op"=>"displays")),"success");
	}
}
if ($op == "delete") {
	$id = $_GPC['id'];
	$typs = $_GPC['typs'];
	pdo_delete("hyb_o2o_city",array("id"=>$id));
	if ($typs=="yiji") {
		message("删除成功!",$this->createWebUrl("city",array("op"=>"display")),"success");
	}else{
		message("删除成功!",$this->createWebUrl("city",array("op"=>"displays")),"success");
	}
	
}

include $this->template('web/city');