var app = getApp();

Page({
    data: {},
    lookdetail: function(o) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/jfsp/jfsp?id=" + o.currentTarget.dataset.id
        });
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
        }), this.getjfjl();
    },
    getjfjl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Jfjilu",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(o) {
                t.setData({
                    jfjl: o.data.data
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