var app = getApp();

Page({
    data: {
        openid: ""
    },
    lookPic: function(t) {
        wx.previewImage({
            urls: t.currentTarget.dataset.list
        });
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: "发单详情"
        }), app.util.request({
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
        var a = t.id, o = wx.getStorageSync("openid");
        this.setData({
            openid: o
        }), this.getFadanxq(a);
    },
    getFadanxq: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Fadanxq",
            data: {
                fa_id: t
            },
            success: function(t) {
                a.setData({
                    info: t.data.data
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