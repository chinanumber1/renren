var app = getApp();

Page({
    data: {
        Czlist: []
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
        }), this.getChong();
    },
    getChong: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Userczlist",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(o) {
                t.setData({
                    Czlist: o.data.data
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