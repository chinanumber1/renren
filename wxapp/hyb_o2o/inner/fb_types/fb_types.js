var app = getApp();

Page({
    data: {},
    choose: function(t) {
        var a = t.currentTarget.dataset.f_name, e = t.currentTarget.dataset.xt_name, o = t.currentTarget.dataset.xt_id;
        wx.navigateTo({
            url: "/hyb_o2o/fabu/fabu?f_name=" + a + "&&xt_name=" + e + "&&xt_id=" + o
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