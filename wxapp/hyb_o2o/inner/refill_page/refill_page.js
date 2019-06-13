var app = getApp();

Page({
    data: {
        mess: []
    },
    refill: function(t) {
        wx.navigateTo({
            url: "../refill_detail/refill_detail?come=充值&h_id=" + t.currentTarget.dataset.h_id
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
        }), wx.setNavigationBarTitle({
            title: "会员办理"
        }), this.getUser(), this.getHuiyuan();
    },
    getUser: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    userInfo: t.data.data
                });
            }
        });
    },
    getHuiyuan: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Huiyuan",
            success: function(t) {
                a.setData({
                    Huiyuan: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});