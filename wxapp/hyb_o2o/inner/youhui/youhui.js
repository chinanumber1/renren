var app = getApp();

Page({
    data: {
        wsy: "",
        ysy: ""
    },
    del: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定删除吗？",
            success: function(t) {
                console.log(e), t.confirm && app.util.request({
                    url: "entry/wxapp/Useryouhuiquandel",
                    data: {
                        id: e
                    },
                    success: function(t) {
                        a.getUseryhq();
                    }
                });
            }
        });
    },
    onLoad: function(t) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", a), console.log(e, a), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                });
            }
        }), this.getUseryhq();
    },
    getUseryhq: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Useryhq",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    list: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});