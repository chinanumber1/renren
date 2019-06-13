var app = getApp();

Page({
    data: {
        mess: []
    },
    onLoad: function(o) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                var t = o.data.data.qjcolor, n = o.data.data.qjbcolor;
                wx.setStorageSync("color", n), wx.setStorageSync("bcolor", t), console.log(n, t), 
                wx.setNavigationBarColor({
                    frontColor: n,
                    backgroundColor: t
                });
            }
        }), this.getYjtixian();
    },
    getYjtixian: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Yjtixian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(o) {
                t.setData({
                    Yjtixian: o.data.data
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