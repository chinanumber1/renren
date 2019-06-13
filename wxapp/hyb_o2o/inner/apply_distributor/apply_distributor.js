var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            interval: 3e3,
            duration: 500,
            imgUrls: [ "/hyb_o2o/resource/images/order_icon3.png" ]
        },
        useInfo: {},
        tel: "",
        choose: !1,
        fwxy: !0
    },
    lookck: function() {
        this.setData({
            fwxy: !1,
            choose: !0
        });
    },
    queren: function() {
        this.setData({
            fwxy: !0
        });
    },
    choose: function() {
        this.data.choose ? this.setData({
            choose: !1
        }) : this.setData({
            choose: !0
        });
    },
    onLoad: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var t = e.data.data.qjcolor, a = e.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", t), console.log(a, t), 
                wx.setNavigationBarColor({
                    frontColor: a,
                    backgroundColor: t
                });
            }
        }), wx.setNavigationBarTitle({
            title: "申请成为分销商"
        }), wx.getUserInfo({
            success: function(e) {
                var t = e.userInfo;
                a.setData({
                    useInfo: t
                });
            }
        }), a.getFenxiaoshezhi();
    },
    getFenxiaoshezhi: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Fenxiaoshezhi",
            success: function(e) {
                var t = a.data.swiper;
                t.imgUrls = e.data.data.sfthumb, a.setData({
                    Fenxiaoshezhi: e.data.data,
                    swiper: t
                }), WxParse.wxParse("article", "html", e.data.data.instructions, a, 5), WxParse.wxParse("articles", "html", e.data.data.fx_details, a, 5);
            }
        });
    },
    formSubmit: function(e) {
        if ("" == (t = e.detail.value).name) wx.showToast({
            title: "请填写姓名",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == t.tel) wx.showToast({
            title: "请填写手机号",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if (11 != t.tel.length) wx.showToast({
            title: "手机号格式错误",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if (0 == /13[0123456789]{1}\d{8}|15[0123456789]\d{8}|17[0123456789]\d{8}|18[0123456789]\d{8}/.test(t.tel)) wx.showToast({
            title: "手机号格式错误",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == t.position) wx.showToast({
            title: "请输入地址",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if (0 == this.data.choose) wx.showToast({
            title: "请阅读协议",
            image: "/hyb_o2o/resource/images/error.png"
        }); else {
            var t = e.detail.value;
            app.util.request({
                url: "entry/wxapp/Fenxiaoadd",
                data: {
                    openid: wx.getStorageSync("openid"),
                    f_name: t.name,
                    f_tel: t.tel
                },
                success: function(e) {
                    wx.showToast({
                        title: "申请成功!"
                    }), setTimeout(function() {
                        wx.navigateBack({});
                    }, 1e3);
                }
            });
        }
    },
    onShareAppMessage: function() {}
});