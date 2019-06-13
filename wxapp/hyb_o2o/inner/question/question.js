var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, o = t.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", a), console.log(o, a), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: a
                });
            }
        }), this.getQuestion();
    },
    getQuestion: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Question",
            success: function(t) {
                a.setData({
                    question: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});