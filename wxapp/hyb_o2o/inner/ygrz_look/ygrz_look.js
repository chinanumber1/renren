var app = getApp();

Page({
    data: {
        imglist: []
    },
    preview: function(a) {
        var t = a.currentTarget.dataset.list, e = a.currentTarget.dataset.current;
        wx.previewImage({
            current: e,
            urls: t
        });
    },
    back: function(a) {
        wx.navigateBack({});
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
        });
        var t = a.id;
        this.getYuangongxq(t);
    },
    getYuangongxq: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Yuangongxq",
            data: {
                openid: a
            },
            success: function(a) {
                var t = [];
                t.push(a.data.data.y_imgpath1), t.push(a.data.data.y_imgpath2), e.setData({
                    info: a.data.data,
                    imglist: t
                });
            }
        });
    },
    onShareAppMessage: function() {}
});