var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                var n = o.data.data.qjcolor, t = o.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", n), console.log(t, n), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: n
                });
            }
        }), this.getUserFenxiao();
    },
    getUserFenxiao: function() {
        var n = this;
        console.log(wx.getStorageSync("openid")), app.util.request({
            url: "entry/wxapp/UserFenxiao",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(o) {
                n.setData({
                    UserFenxiao: o.data.data
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