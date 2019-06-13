<?php
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{

    public function getMainMenu()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];

        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        if ($_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<a href="javascript:void(0)" class="panel-title wytitle"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单</a>',
                'items' => array(
                    0 => $this->createMainMenu('门店列表', $do, 'store','')
                )
            );
        }
        elseif($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=gaikuangdata&m=hyb_o2o" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cubes"></icon>  门店管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('数据概况', $do, 'gaikuangdata', ''),
                    1 => $this->createMainMenu('门店设置', $do, 'store', ''),                   
                    2 => $this->createMainMenu('门店账号', $do, 'account', ''),
                    3 => $this->createMainMenu('门店员工', $do, 'storeyuangong', ''),
                    // 4 => $this->createMainMenu('门店技师', $do, 'storejishi', ''),
                )
            );
            $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=goods&m=hyb_o2o" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  商品管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('商品列表 ', $do, 'goods', ''),
                    1 => $this->createMainMenu('商品分类', $do, 'goodsstyle', ''),
                )
            );
            $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=fuwu&m=hyb_o2o" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  服务管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('服务列表 ', $do, 'fuwu', ''),
                    1 => $this->createMainMenu('服务分类 ', $do, 'fuwutype', ''),                
                )
            );
            $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=shangjia&m=hyb_o2o" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  商家管理</a>',
                'items' => array(
                    // 0 => $this->createMainMenu('商家列表 ', $do, 'shangjia', ''), 
                    0 => $this->createMainMenu('基础设置 ', $do, 'shangjiaruzhu', ''),
                    1 => $this->createMainMenu('商家列表 ', $do, 'shangjia', ''), 

                )
            );
            $navemenu[4] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=user&m=hyb_o2o" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  会员管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('会员列表 ', $do, 'user', ''), 
                    1 => $this->createMainMenu('会员等级 ', $do, 'usertype', ''),              
                )
            );
            $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ordergoods&m=hyb_o2o" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-bars"></icon>  订单管理</a>',
                'items' => array(
                    // 0 => $this->createMainMenu('商品订单 ', $do, 'ordergoods', ''),
                    // 1 => $this->createMainMenu('上门服务订单', $do, 'orderfwsm', ''),
                    // 2 => $this->createMainMenu('到店服务订单', $do, 'orderfwdd', ''),
                    // 3 => $this->createMainMenu('积分兑换订单', $do, 'orderjifen', ''),
                    // 4 => $this->createMainMenu('商家服务订单', $do, 'ordersjfw', ''),
                    0 => $this->createMainMenu('商品订单 ', $do, 'ordergoods', ''),
                    1 => $this->createMainMenu('门店服务订单 ', $do, 'ordermdfw', ''),
                    2 => $this->createMainMenu('商家服务订单', $do, 'ordersjfw', ''),
                    3 => $this->createMainMenu('积分兑换订单', $do, 'orderjifen', ''),
                   
                )
            );
            $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=tixian&m=hyb_o2o" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>  提现中心</a>',
                'items' => array(
                    0 => $this->createMainMenu('提现列表 ', $do, 'tixian', ''),
                )
            );
            $navemenu[7] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=qiangdan&m=hyb_o2o" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-bars"></icon>  抢单中心</a>',
                'items' => array(
                    0 => $this->createMainMenu('派单列表 ', $do, 'qiangdan', ''),
                    1 => $this->createMainMenu('门店派单 ', $do, 'mdqiangdan', ''),
                )
            );
            $navemenu[8] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=jfgoods&m=hyb_o2o" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-star-half-o"></icon> 积分商城</a>',
                'items' => array(
                    0 => $this->createMainMenu('商品列表', $do, 'jfgoods', ''),
                    1 => $this->createMainMenu('积分幻灯片', $do, 'jfthumb', ''),
                )
            );
            $navemenu[9] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=fxlist&m=hyb_o2o" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-users"></icon> 分销中心</a>',
                'items' => array(
                    0 => $this->createMainMenu('分销商管理', $do, 'fxlist', ''),
                    1 => $this->createMainMenu('分销设置', $do, 'fxset', ''),
                    2 => $this->createMainMenu('提现申请', $do, 'fxtx', ''),
                )
            );
            $navemenu[10] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=yingxiao&m=hyb_o2o" class="panel-title wytitle" id="yframe-10"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon> 营销设置</a>',
                'items' => array(
                    0 => $this->createMainMenu('满减活动', $do, 'yingxiao', ''),
                    1 => $this->createMainMenu('优惠券', $do, 'youhuiquan', ''),
                )
            );
            $navemenu[11] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=pingjia&m=hyb_o2o" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-comments"></icon> 评价中心</a>',
                'items' => array(
                    0 => $this->createMainMenu('服务评价', $do, 'pingjia', ''),
                    1 => $this->createMainMenu('商品评价', $do, 'pingjiagoods', ''),
                )
            ); 

            $navemenu[12] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=storejishi&m=hyb_o2o" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-comments"></icon> 技师中心</a>',
                'items' => array(
                    0 => $this->createMainMenu('技师列表', $do, 'storejishi', ''),
                    1 => $this->createMainMenu('技师入驻设置', $do, 'storejishirz', '')
                )
            );
            $navemenu[13] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=gonggao&m=hyb_o2o" class="panel-title wytitle" id="yframe-13"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon> 活动公告</a>',
                'items' => array(
                    0 => $this->createMainMenu('公告设置', $do, 'gonggao', ''),
                    // 1 => $this->createMainMenu('活动设置', $do, 'huodong', ''),
                )
            );
            $navemenu[14] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=peiz&m=hyb_o2o" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon> 系统设置</a>',
                'items' => array(
                    0 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
                    1 => $this->createMainMenu('提现配置', $do, 'pay', ''),
                    2 => $this->createMainMenu('模板消息', $do, 'template', ''), 
                    3 => $this->createMainMenu('短信通知', $do, 'new', ''), 
                    4 => $this->createMainMenu('基本设置', $do, 'base', ''),  
                    5 => $this->createMainMenu('多城市设置', $do, 'city', ''), 
                    6 => $this->createMainMenu('模块存储', $do, 'cunchu', ''),
                    7 => $this->createMainMenu('常见问题', $do, 'questions', ''),  
                )
            );
        }
        return $navemenu;
    }

    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
    {

        $color = ' style="color:'.$color.';" ';

        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }




    public function getNaveMenu($action,$uniacid,$storeid)
    {
        global $_W, $_GPC;
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = '#8d8d8d';
        $navemenu[0] = array(
            'title' => '<a href="o2ostore.php?c=site&a=entry&op=display&do=start&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  门店设置</a>',
            'items' => array(
                0 => $this->createSubMenu('数据概况', $do, 'start', 'fa-angle-right', $cur_color, $uniacid,$storeid),
                1 => $this->createSubMenu('门店信息 ', $do, 'dlstoreinfo', 'fa-angle-right', $cur_color, $uniacid,$storeid),
                2 => $this->createSubMenu('门店员工 ', $do, 'dlistoreyuangong','fa-angle-right', $cur_color, $uniacid,$storeid),
            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
                'title' => '<a href="o2ostore.php?c=site&a=entry&op=display&do=dlfuwu&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-university"></icon>  服务管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('服务列表 ', $do, 'dlfuwu', 'fa-angle-right', $cur_color, $uniacid,$storeid),          
                )
        );
        $navemenu[2] = array(
                'title' => '<a href="o2ostore.php?c=site&a=entry&op=display&do=dlordersm&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  订单管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('上门服务订单 ', $do, 'dlordersm', 'fa-angle-right', $cur_color, $uniacid,$storeid),
                    1 => $this->createSubMenu('到店服务订单 ', $do, 'dlorderdd', 'fa-angle-right', $cur_color, $uniacid,$storeid),             
                )
        );
        $navemenu[3] = array(
                'title' => '<a href="o2ostore.php?c=site&a=entry&op=daijiedan&do=dlpaidan&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  派单中心</a>',
                'items' => array(
                    0 => $this->createSubMenu('派单列表 ', $do, 'dlpaidan', 'fa-angle-right', $cur_color, $uniacid,$storeid),           
                )
        );
        $cur_color = '#8d8d8d';
        $navemenu[4] = array(
            'title' => '<a href="o2ostore.php?c=site&a=entry&op=display&do=dlyingxiao&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  营销设置</a>',
            'items' => array(
                0 => $this->createSubMenu('满减活动 ', $do, 'dlyingxiao', 'fa-angle-right', $cur_color, $uniacid,$storeid),
                1 => $this->createSubMenu('优惠券 ', $do, 'dlyingxiaoyhq', 'fa-angle-right', $cur_color, $uniacid,$storeid),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="o2ostore.php?c=site&a=entry&type=wait&do=dltixian&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-money"></icon>  提现管理</a>',
            'items' => array(
                0 => $this->createSubMenu('提现列表', $do, 'dltixian', 'fa-angle-right', $cur_color, $uniacid,$storeid),
                // 1 => $this->createSubMenu('提现流水', $do, 'dlintxlist', 'fa-angle-right', $cur_color, $storeid),
                
            )
        );

        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="o2ostore.php?c=site&a=entry&op=display&do=dlpingjia&m=hyb_o2o&uid='.$uniacid.'&id='.$storeid.'" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-comments"></icon>  评论管理</a>',
            'items' => array(
                0 => $this->createSubMenu('评论管理 ', $do, 'dlpingjia', 'fa-angle-right', $cur_color, $uniacid,$storeid),
            
            )
        );
        return $navemenu;
    }

    function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $uniacid,$storeid)
    {
        $color = ' style="color:'.$color.';" ';
        $url = $this->createWebUrl2($method, array('op' => 'display', 'uid' => $uniacid,"id"=>$storeid));
        return array('title' => $title, 'url' => $do != $method ? $url : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa '.$icon.'"></i>',
            )
        );
    }
    function createWebUrl2($do, $query = array()) {
        $query['do'] = $do;
        $query['m'] = strtolower($this->modulename);
      
        return $this->wurl('site/entry', $query);
    }

    function wurl($segment, $params = array()) {
        list($controller, $action, $do) = explode('/', $segment);
        $url = './o2ostore.php?';
        if (!empty($controller)) {
            $url .= "c={$controller}&";
        }
        if (!empty($action)) {
            $url .= "a={$action}&";
        }
        if (!empty($do)) {
            $url .= "do={$do}&";
        }
        if (!empty($params)) {
            $queryString = http_build_query($params, '', '&');
            $url .= $queryString;
        }
        return $url;
    }
}