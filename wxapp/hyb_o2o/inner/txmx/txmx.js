var app = getApp();

Page({
    data: {
        tabs: [ "待审核", "已通过", "已拒绝" ],
        activeIndex: 0,
        typs: ""
    },
    tabClick: function(t) {
        this.setData({
            activeIndex: t.currentTarget.id
        }), this.getTixanlist();
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
        }), this.setData({
            typs: t.typs
        }), this.getTixanlist();
    },
    getTixanlist: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Tixanlist",
            data: {
                openid: wx.getStorageSync("openid"),
                typs: a.data.typs,
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