var app = getApp();

Page({
    data: {
        status: !1,
        come: ""
    },
    go_home: function() {
        wx.redirectTo({
            url: "/hyb_o2o/index/index"
        });
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    hexiao: function() {
        this.setData({
            status: !0
        });
    },
    close: function() {
        this.setData({
            status: !1
        });
    },
    saoma: function() {
        var o = this;
        wx.scanCode({
            success: function(t) {
                wx.showToast({
                    title: "扫码成功,信息查询中!"
                });
                var a = t.path;
                console.log(a), app.util.request({
                    url: "entry/wxapp/Hexiao",
                    data: {
                        ordersn: a,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        console.log(t.data.data), "匹配未找到" == t.data.data ? wx.showToast({
                            title: "核销失败"
                        }) : wx.showToast({
                            title: "核销成功"
                        }), o.getOrderlist(o.data.currentTab, o.data.cur);
                    }
                });
            },
            fail: function(t) {
                wx.showToast({
                    image: "/hyb_o2o/resource/images/error.png",
                    title: "扫码失败!"
                });
            }
        });
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, o = t.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", a), console.log(o, a), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: a
                });
            }
        });
        var o = t.id;
        a.setData({
            come: t.come
        }), "sp" == t.come ? a.getOrdergoodsxq(o) : a.getOrderfuwuxq(o);
    },
    getOrdergoodsxq: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Ordergoodsxq",
            data: {
                o_id: t
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    order_list: t.data.data
                });
            }
        });
    },
    getOrderfuwuxq: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Orderfuwuxq",
            data: {
                o_id: t
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    order_list: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});