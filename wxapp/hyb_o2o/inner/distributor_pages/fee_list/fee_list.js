var app = getApp();

Page({
    data: {
        current: 0,
        all: [],
        w_pay: [],
        payed: [],
        complete: []
    },
    switch_tab: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    onLoad: function(t) {
        this.getFxorder(), this.getBase();
    },
    getFxorder: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Fxorder",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    fxorder: t.data.data
                });
            }
        });
    },
    getBase: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Base",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                var a = t.data.data.qjcolor, o = t.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", a), console.log(o, a), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: a
                }), e.setData({
                    base: t.data.data
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