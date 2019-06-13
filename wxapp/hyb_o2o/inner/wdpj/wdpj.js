var app = getApp();

Page({
    data: {},
    look_store: function(a) {
        wx.navigateTo({
            url: "../detail/detail?id=" + a.currentTarget.dataset.id
        });
    },
    look_stores: function(a) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/goods_page/goods_page?id=" + a.currentTarget.dataset.id
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.list, e = a.currentTarget.dataset.index;
        wx.previewImage({
            current: e,
            urls: t
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
        }), this.getUserpingjia();
    },
    getUserpingjia: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Userpingjiajs",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                t.setData({
                    pingjialist: a.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});