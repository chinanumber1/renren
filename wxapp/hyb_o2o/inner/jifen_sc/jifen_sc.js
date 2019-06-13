var app = getApp();

Page({
    data: {
        mess: {
            jifen: 50
        },
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            interval: 3e3,
            duration: 500,
            previous: "50px",
            next: "50px",
            imgUrls: []
        }
    },
    record: function() {
        wx.navigateTo({
            url: "../jf_record/jf_record"
        });
    },
    look_detail: function(a) {
        wx.navigateTo({
            url: "../jfsp/jfsp?id=" + a.currentTarget.dataset.id
        });
    },
    onLoad: function(a) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, o = a.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", t), console.log(o, t), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: t
                });
            }
        }), this.getJFgoods();
    },
    getJFgoods: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Jfgoods",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = o.data.swiper;
                t.imgUrls = a.data.data.jfthumb, o.setData({
                    list: a.data.data.jfgoods,
                    swiper: t,
                    user: a.data.data.user
                });
            }
        });
    },
    swiperUrl: function(a) {
        var t = a.currentTarget.dataset.appid, o = a.currentTarget.dataset.path;
        wx.navigateToMiniProgram({
            appId: t,
            path: o
        });
    },
    onShow: function() {
        this.getJFgoods();
    },
    onShareAppMessage: function() {}
});