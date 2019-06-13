var app = getApp();

Page({
    data: {},
    choose: function(t) {
        var a = t.currentTarget.dataset.xt_id, e = t.currentTarget.dataset.parentid;
        wx.navigateTo({
            url: "/hyb_o2o/inner/nav_list/nav_list?xt_id=" + a + "&parentid=" + e
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
        }), this.getShowfuwustyle();
    },
    getShowfuwustyle: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Showfuwustyle",
            success: function(t) {
                a.setData({
                    xmstyle: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});