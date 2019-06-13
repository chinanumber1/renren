var app = getApp();

Page({
    data: {
        top: [ {
            name: "全部",
            icon: "../../resource/images/all.png"
        }, {
            name: "待付款",
            icon: "../../resource/images/servering.png"
        }, {
            name: "待收货",
            icon: "../../resource/images/w_pay.png"
        }, {
            name: "待评价",
            icon: "../../resource/images/w_send.png"
        }, {
            name: "已取消",
            icon: "../../resource/images/complete.png"
        } ],
        currentTab: 0,
        openid: "",
        img_true: !1,
        hx_img: "",
        ping: !1
    },
    close_hx: function() {
        this.setData({
            img_true: !1
        });
    },
    switch_tab: function(t) {
        this.data.openid;
        this.setData({
            currentTab: t.currentTarget.dataset.index
        }), this.getOrderlist(t.currentTarget.dataset.index);
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "../order_detail/order_detail?come=sp&id=" + t.currentTarget.dataset.id
        });
    },
    cuidan: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Ordergoodssaves",
            data: {
                o_id: a
            },
            success: function(t) {
                e.getOrderlist(e.data.currentTab);
            }
        });
    },
    pay_order: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/refill_detail2/refill_detail2?o_id=" + t.currentTarget.dataset.id
        });
    },
    cancel_order: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Ordergoodssave",
            data: {
                o_id: a,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.getOrderlist(e.data.currentTab);
            }
        });
    },
    del_order: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        t.currentTarget.dataset.currenttab;
        app.util.request({
            url: "entry/wxapp/Ordergoodsdel",
            data: {
                o_id: a
            },
            success: function(t) {
                e.getOrderlist(e.data.currentTab);
            }
        });
    },
    pingjia_order: function(t) {
        var e = t.currentTarget.dataset.o_id, a = t.currentTarget.dataset.g_thumb;
        wx.navigateTo({
            url: "/hyb_o2o/inner/pingfen2/pingfen?o_id=" + e + "&g_thumb=" + a
        });
    },
    onLoad: function(t) {
        var e = t.id;
        if (app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var e = t.data.data.qjcolor, a = t.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", e), console.log(a, e), 
                wx.setNavigationBarColor({
                    frontColor: a,
                    backgroundColor: e
                });
            }
        }), e) this.setData({
            currentTab: e
        }), this.getOrderlist(e); else {
            e = this.data.currentTab;
            this.setData({
                currentTab: e
            }), this.getOrderlist(e);
        }
    },
    getOrderlist: function(t) {
        var e = this;
        t = t;
        app.util.request({
            url: "entry/wxapp/Ordergoodslist",
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
    hxClick: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Dmoney",
            data: {
                o_id: a
            },
            success: function(t) {
                e.setData({
                    hx_img: t.data.data,
                    img_true: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});