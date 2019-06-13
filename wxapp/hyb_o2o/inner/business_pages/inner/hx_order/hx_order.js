var app = getApp();

Page({
    data: {
        status: !1,
        come: "",
        display: !1
    },
    hexiao: function() {
        this.setData({
            status: !0
        });
    },
    saoma: function() {
        wx.scanCode({
            success: function(a) {
                wx.showToast({
                    title: "扫码成功,信息查询中!"
                });
                var t = a.path;
                console.log(t), app.util.request({
                    url: "entry/wxapp/Hexiao",
                    data: {
                        ordersn: t,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(a) {
                        console.log(a.data.data), "匹配未找到" == a.data.data ? wx.showToast({
                            title: "核销失败"
                        }) : wx.showToast({
                            title: "核销成功"
                        });
                    }
                });
            },
            fail: function(a) {
                wx.showToast({
                    image: "/hyb_o2o/resource/images/error.png",
                    title: "扫码失败!"
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        wx.setNavigationBarTitle({
            title: "核销订单"
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, o = a.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", t), console.log(o, t), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: t
                }), e.setData({
                    copy: a.data.data.md_name
                });
            }
        });
    },
    onShareAppMessage: function() {}
});