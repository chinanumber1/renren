var app = getApp();

Page({
    data: {
        current: 0
    },
    switch_tab: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index
        });
        var a = t.currentTarget.dataset.index;
        console.log(a), this.getSjxm(a);
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "../add_server/add_server?id=" + t.currentTarget.dataset.id
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
            title: "所有服务"
        }), this.getSjxm(0);
    },
    onShow: function() {
        app.globalData.s_change && (app.globalData.s_change = !1, this.setData({
            current: 0
        }), this.getSjxm(0));
    },
    getSjxm: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Sjfuwu",
            data: {
                openid: wx.getStorageSync("openid"),
                current: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    Sjxm: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});