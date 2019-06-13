var app = getApp();

Page({
    data: {
        top: [ {
            name: "全部",
            icon: "../../resource/images/all.png"
        }, {
            name: "待发货",
            icon: "../../resource/images/w_pay.png"
        }, {
            name: "待收货",
            icon: "../../resource/images/w_send.png"
        }, {
            name: "已完成",
            icon: "../../resource/images/servering.png"
        }, {
            name: "已取消",
            icon: "../../resource/images/complete.png"
        } ],
        currentTab: 0
    },
    switch_tab: function(t) {
        this.data.openid;
        this.setData({
            currentTab: t.currentTarget.dataset.index
        }), this.getOrderjflist(t.currentTarget.dataset.index);
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/jifen_sc/jifen_sc"
        });
    },
    sure_order: function(t) {
        var e = this, r = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Orderjfsur",
            data: {
                id: r
            },
            success: function(t) {
                e.getOrderjflist(e.data.currentTab);
            }
        });
    },
    del_order: function(t) {
        var e = this, r = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Orderjfdel",
            data: {
                id: r
            },
            success: function(t) {
                e.getOrderjflist(e.data.currentTab);
            }
        });
    },
    del_orders: function(t) {
        var e = this, r = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Orderjfsh",
            data: {
                id: r
            },
            success: function(t) {
                e.getOrderjflist(e.data.currentTab);
            }
        });
    },
    onLoad: function(t) {
        if (app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var e = t.data.data.qjcolor, r = t.data.data.qjbcolor;
                wx.setStorageSync("color", r), wx.setStorageSync("bcolor", e), console.log(r, e), 
                wx.setNavigationBarColor({
                    frontColor: r,
                    backgroundColor: e
                });
            }
        }), e = t.id) this.setData({
            currentTab: e
        }), this.getOrderjflist(e); else {
            var e = this.data.currentTab;
            this.setData({
                currentTab: e
            }), this.getOrderjflist(e);
        }
    },
    getOrderjflist: function(t) {
        var e = this;
        t = t;
        app.util.request({
            url: "entry/wxapp/Orderjflist",
            data: {
                openid: wx.getStorageSync("openid"),
                currentTab: t
            },
            success: function(t) {
                e.setData({
                    order_list: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});