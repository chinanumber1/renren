var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            interval: 3e3,
            duration: 500,
            imgUrls: []
        },
        currentTab: 0
    },
    switch_tab: function(a) {
        this.setData({
            currentTab: a.currentTarget.dataset.index
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.list, e = a.currentTarget.dataset.index;
        wx.previewImage({
            current: e,
            urls: t
        });
    },
    look_detail: function(a) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/yuyue2/yuyue2?g_id=" + a.currentTarget.dataset.g_id
        });
    },
    onLoad: function(a) {
        var t = a.id;
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
        }), this.getShangpingxq(t);
    },
    getShangpingxq: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shangpingxq",
            data: {
                id: a
            },
            success: function(a) {
                var t = e.data.swiper;
                t.imgUrls = a.data.data.g_thumbs, e.setData({
                    shangpingxq: a.data.data,
                    swiper: t
                }), wx.setNavigationBarTitle({
                    title: a.data.data.g_name
                }), WxParse.wxParse("article", "html", a.data.data.g_content, e, 5);
            }
        });
    },
    onShareAppMessage: function() {}
});