var app = getApp();

Page({
    data: {
        tabs: [ "一级", "二级" ],
        activeIndex: 0
    },
    tabClick: function(a) {
        this.setData({
            activeIndex: a.currentTarget.id
        }), this.getUserfenxiaoxiaji();
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
        }), this.getUserfenxiaoxiaji();
    },
    getUserfenxiaoxiaji: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Userfenxiaoxiaji",
            data: {
                openid: wx.getStorageSync("openid"),
                cur: i.data.activeIndex
            },
            success: function(a) {
                if (1 == i.data.activeIndex) {
                    var t = [];
                    for (var e in a.data.data) for (var o in a.data.data[e]) t.push(a.data.data[e][o]);
                    i.setData({
                        list: t
                    });
                } else i.setData({
                    list: a.data.data
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});