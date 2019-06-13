var app = getApp();

Page({
    data: {
        tabs: [ "待审核", "已通过", "已拒绝" ],
        activeIndex: 0
    },
    tabClick: function(t) {
        this.setData({
            activeIndex: t.currentTarget.id
        }), this.getUserfenxiaotixianjilu();
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
        }), this.getUserfenxiaotixianjilu();
    },
    getUserfenxiaotixianjilu: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Userfenxiaotixianjilu",
            data: {
                openid: wx.getStorageSync("openid"),
                cur: a.data.activeIndex
            },
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            }
        });
    }
});