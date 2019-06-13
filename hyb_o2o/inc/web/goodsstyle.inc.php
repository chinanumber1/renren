<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op'])?$_GPC['op']:"display";
		if ($op == "display") {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
			$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_o2o_goods_style")." WHERE uniacid=:uniacid limit ". (($pindex - 1) * $psize) . ',' . $psize,array(":uniacid"=>$uniacid));
			$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_o2o_goods_style")."  where uniacid=:uniacid ",array(":uniacid"=>$uniacid));
			$pager = pagination($count, $pindex, $psize);
		}
		if ($op == "post") {
			$id = $_GPC['id'];
			$items = pdo_fetch("SELECT * FROM ".tablename("hyb_o2o_goods_style")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
			if (checksubmit("submit")) {
				$data = array("uniacid"=>$uniacid,"title"=>$_GPC['title']);
				if (empty($id)) {
					pdo_insert("hyb_o2o_goods_style",$data);
					message("添加成功!",$this->createWebUrl("goodsstyle",array("op"=>"display")),"success");
				}else{
					pdo_update("hyb_o2o_goods_style",$data,array("id"=>$id));
					message("修改成功!",$this->createWebUrl("goodsstyle",array("op"=>"display")),"success");
				}
			}
		}
		if ($op == "delete") {
			$id = $_GPC['id'];
			pdo_delete("hyb_o2o_goods_style",array("id"=>$id));
			message("删除成功!",$this->createWeburl("goodsstyle",array("op"=>"display")),"success");
		}
include $this->template('web/goodsstyle');