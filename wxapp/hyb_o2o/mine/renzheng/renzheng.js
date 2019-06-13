var app = getApp();

Page({
    data: {
        userInfo: {},
        second: 60,
        send: !1,
        tel: 0
    },
    bdtells: function(t) {
        var e = this.data.tel;
        t.detail.value.yzm != this.data.yanzhengma ? wx.showToast({
            title: "验证码输入错误",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Usertel",
            data: {
                tel: e,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                wx.navigateBack({});
            }
        });
    },
    tels: function(t) {
        this.setData({
            tel: t.detail.value
        });
    },
    yzm: function(t) {
        var e = this, a = e.data.tel;
        console.log(a), "" != a && /^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(a) && 11 == a.length ? app.util.request({
            url: "entry/wxapp/Fadanyzm",
            data: {
                telphone: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    send: !0,
                    yanzhengma: t.data.data
                }), e.timer();
            }
        }) : wx.showToast({
            title: "请检查手机号码",
            image: "/hyb_o2o/resource/images/error.png"
        });
    },
    timer: function() {
        var n = this;
        new Promise(function(t, e) {
            var a = setInterval(function() {
                n.setData({
                    second: n.data.second - 1
                }), n.data.second <= 0 && (n.setData({
                    second: 60,
                    alreadySend: !1,
                    send: !1
                }), t(a));
            }, 1e3);
        }).then(function(t) {
            clearInterval(t);
        });
    },
    getUser: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), e.setData({
                    userInfo: t.data.data
                });
            }
        });
    },
    onLoad: function(t) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var e = t.data.data.qjcolor, a = t.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", e), console.log(a, e), 
                wx.setNavigationBarColor({
                    frontColor: a,
                    backgroundColor: e
                });
            }
        });
    },
    onReady: function() {
        this.getUser();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});