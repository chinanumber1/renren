var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(o) {
        var a = o.id;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                var a = o.data.data.qjcolor, t = o.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", a), console.log(t, a), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: a
                });
            }
        }), this.getGonggaoxq(a);
    },
    getGonggaoxq: function(o) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Gonggaoxq",
            data: {
                id: o
            },
            success: function(o) {
                a.setData({
                    gonggaoxq: o.data.data
                }), WxParse.wxParse("article", "html", o.data.data.content, a, 5);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});