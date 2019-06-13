var app = getApp();

Page({
    data: {
        current: 0,
        yiji: [],
        erji: []
    },
    switch_tab: function(t) {
        var o = t.currentTarget.dataset.index;
        this.setData({
            current: o
        }), this.getFxuser(o);
    },
    onLoad: function(t) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var o = t.data.data.qjcolor, n = t.data.data.qjbcolor;
                wx.setStorageSync("color", n), wx.setStorageSync("bcolor", o), console.log(n, o), 
                wx.setNavigationBarColor({
                    frontColor: n,
                    backgroundColor: o
                });
            }
        }), this.getFxuser(0);
    },
    getFxuser: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Fxuser",
            data: {
                openid: wx.getStorageSync("openid"),
                current: t
            },
            success: function(t) {
                o.setData({
                    Fxuser: t.data.data
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