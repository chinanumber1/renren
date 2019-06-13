var app = getApp();

Page({
    data: {},
    look_detail: function(a) {
        0 < a.currentTarget.dataset.num && wx.navigateTo({
            url: "../fw_pingjia_d/fw_pingjia_d?id=" + a.currentTarget.dataset.id
        });
    },
    onLoad: function(a) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, o = a.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", t), console.log(o, t), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: t
                });
            }
        }), this.getSjxm();
    },
    getSjxm: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Sjpl",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                t.setData({
                    Sjxm: a.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});