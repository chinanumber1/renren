var app = getApp();

Page({
    data: {},
    choose: function(a) {
        var t = a.currentTarget.dataset.parent, e = a.currentTarget.dataset.xt_name;
        wx.navigateTo({
            url: "/hyb_o2o/inner/business_pages/inner/add_server/add_server?parent=" + t + "&xt_name=" + e
        });
    },
    onLoad: function(a) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, e = a.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", t), console.log(e, t), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: t
                });
            }
        }), this.getShangjiaaddfuwutype();
    },
    getShangjiaaddfuwutype: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Shangjiaaddfuwutype",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a.data.data), t.setData({
                    xmstyle: a.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});