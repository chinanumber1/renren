var app = getApp();

Page({
    data: {
        switch_top: [ "用户", "商家", "员工" ],
        curr: 0,
        index_i: null,
        status_list: [ "空闲中", "请假中" ],
        userInfo: {},
        phone: "18234042712",
        jifen: "0.00",
        money: "0.00",
        regist: !0,
        distributor: !0,
        y_typs: "",
        s_always: [ {
            name: "抢单大厅",
            icon: "/hyb_o2o/resource/images/m_s_1.png",
            url: "/hyb_o2o/inner/qddt/qddt?come=shangjia"
        }, {
            name: "我的抢单",
            icon: "/hyb_o2o/resource/images/m_s_2.png",
            url: "/hyb_o2o/inner/mddd/mddd"
        }, {
            name: "门店订单",
            icon: "/hyb_o2o/resource/images/m_s_3.png",
            url: "/hyb_o2o/s_orders/s_orders"
        }, {
            name: "核销订单",
            icon: "/hyb_o2o/resource/images/m_s_4.png",
            url: "/hyb_o2o/inner/business_pages/inner/hx_order/hx_order"
        } ],
        s_mess: [ {
            name: "门店信息",
            icon: "/hyb_o2o/resource/images/m_s_5.png",
            url: "/hyb_o2o/inner/in_business/in_business?typs=修改"
        }, {
            name: "员工管理",
            icon: "/hyb_o2o/resource/images/m_s_6.png",
            url: "/hyb_o2o/inner/yglb/yglb?come=guanli"
        }, {
            name: "活动设置",
            icon: "/hyb_o2o/resource/images/m_s_7.png",
            url: "/hyb_o2o/inner/hdsz/hdsz"
        }, {
            name: "服务评价",
            icon: "/hyb_o2o/resource/images/m_s_8.png",
            url: "/hyb_o2o/inner/business_pages/inner/pj_list/pj_list"
        }, {
            name: "添加服务",
            icon: "/hyb_o2o/resource/images/m_s_10.png",
            url: "/hyb_o2o/inner/add_server_type/add_server_type"
        }, {
            name: "所有服务",
            icon: "/hyb_o2o/resource/images/m_s_9.png",
            url: "/hyb_o2o/inner/business_pages/inner/all_server/all_server"
        }, {
            name: "入驻续费",
            icon: "/hyb_o2o/resource/images/m_s_11.png",
            url: "/hyb_o2o/inner/refill_detail/refill_detail?come=续费&ts=sj"
        }, {
            name: "财务统计",
            icon: "/hyb_o2o/resource/images/m_s_c.png",
            url: "/hyb_o2o/inner/statistics/statistics"
        } ]
    },
    bindfenlei_one: function(e) {
        this.setData({
            index_i: e.detail.value
        });
        var n = this.data.status_list[e.detail.value];
        app.util.request({
            url: "entry/wxapp/Yuangongzhuangtai",
            data: {
                openid: wx.getStorageSync("openid"),
                y_typs: n
            }
        });
    },
    refill: function() {
        wx.navigateTo({
            url: "../inner/refill_page/refill_page"
        });
    },
    look_bot4: function(e) {
        var n = e.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: n
        });
    },
    link_sc: function() {
        wx.navigateTo({
            url: "../inner/jifen_sc/jifen_sc"
        });
    },
    jinru: function(e) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/business_pages/index/index?typs=修改&s_id=" + e.currentTarget.dataset.s_id
        });
    },
    onLoad: function(e) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var n = e.data.data.qjcolor, a = e.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", n), console.log(a, n), 
                wx.setNavigationBarColor({
                    frontColor: a,
                    backgroundColor: n
                });
            }
        }), this.getShangjia(), this.getBase();
    },
    onShow: function(e) {
        this.getShangjia(), this.getBase();
    },
    getUser: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                n.setData({
                    userInfo: e.data.data
                });
            }
        });
    },
    getShangjia: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Shangjia",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                n.setData({
                    shangjia: e.data.data
                });
            }
        });
    },
    getBase: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Mendian",
            success: function(e) {
                n.setData({
                    base: e.data.data
                });
            }
        });
    },
    xufei: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/refill_detail/refill_detail?come=续费"
        });
    },
    tixian: function(e) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/distributor_pages/withdrawal/withdrawal?typs=" + e.currentTarget.dataset.typs
        });
    },
    onShareAppMessage: function() {}
});