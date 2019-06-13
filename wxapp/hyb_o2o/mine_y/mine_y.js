var app = getApp();

Page({
    data: {
        userInfo: {},
        phone: "",
        jifen: "0.00",
        money: "0.00",
        come: "",
        y_choucheng: "",
        y_mess: [ {
            name: "我的资料",
            icon: "/hyb_o2o/resource/images/m_yg_2.png",
            url: "/hyb_o2o/inner/ygrz/ygrz?typs=修改&come=js"
        }, {
            name: "抢单大厅",
            icon: "/hyb_o2o/resource/images/m_yg_4.png",
            url: "/hyb_o2o/inner/qddt/qddt?come=yuangong"
        }, {
            name: "我的抢单",
            icon: "/hyb_o2o/resource/images/m_yg_1.png",
            url: "/hyb_o2o/inner/qd_page/qd_page?come=mine"
        }, {
            name: "公司派单",
            icon: "/hyb_o2o/resource/images/m_yg_3.png",
            url: "/hyb_o2o/inner/qd_page/qd_page?come=company"
        }, {
            name: "我的评价",
            icon: "/hyb_o2o/resource/images/m_s_2.png",
            url: "/hyb_o2o/inner/wdpj/wdpj?come=js"
        }, {
            name: "入驻续费",
            icon: "/hyb_o2o/resource/images/m_s_11.png",
            url: "/hyb_o2o/inner/refill_detail/refill_detail?come=续费&ts=js"
        } ],
        y_mess2: [ {
            name: "我的资料",
            icon: "/hyb_o2o/resource/images/m_yg_2.png",
            url: "/hyb_o2o/inner/ygrz/ygrz?typs=修改&come=yg"
        }, {
            name: "服务订单",
            icon: "/hyb_o2o/resource/images/m_yg_1.png",
            url: "/hyb_o2o/y_orders/y_orders"
        }, {
            name: "公司派单",
            icon: "/hyb_o2o/resource/images/m_yg_3.png",
            url: "/hyb_o2o/inner/qd_page/qd_page?come=company"
        } ]
    },
    lookye: function() {
        var e = "按每笔订单的成交额" + 100 * parseFloat(this.data.y_choucheng) + "%抽成，自动转入余额 ";
        wx.showModal({
            title: "抽成说明",
            content: e,
            showCancel: !1
        });
    },
    onLoad: function(e) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var o = e.data.data.qjcolor, a = e.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", o), console.log(a, o), 
                wx.setNavigationBarColor({
                    frontColor: a,
                    backgroundColor: o
                });
            }
        });
        var a = e.come;
        o.setData({
            come: a
        }), o.getUser(), o.getBase();
    },
    onShow: function(e) {
        this.getUser(), this.getBase();
    },
    getUser: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                o.setData({
                    userInfo: e.data.data,
                    y_choucheng: e.data.data.y_choucheng
                });
            }
        });
    },
    getBase: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Mendian",
            success: function(e) {
                o.setData({
                    base: e.data.data
                });
            }
        });
    },
    tixian: function(e) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/distributor_pages/withdrawal/withdrawal?typs=" + e.currentTarget.dataset.typs
        });
    },
    onShareAppMessage: function() {}
});