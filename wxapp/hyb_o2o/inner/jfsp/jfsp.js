var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        id: "",
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            interval: 3e3,
            duration: 500,
            previous: "50px",
            next: "50px",
            imgUrls: []
        },
        status: !1
    },
    link_address: function() {
        wx.navigateTo({
            url: "../address/address?j_id=" + this.data.id
        });
    },
    duihuan: function() {
        this.setData({
            status: !0
        });
    },
    closeModal: function() {
        this.setData({
            status: !1
        });
    },
    sure: function(a) {
        this.closeModal();
        var t = a.detail.formId;
        console.log(t);
        var e = this.data.jfgoods, s = this.data.mraddress, d = parseInt(this.data.user.u_jifen);
        parseInt(e.num) > d ? wx.showModal({
            title: "提示",
            content: "您的积分不足，无法兑换。"
        }) : app.util.request({
            url: "entry/wxapp/Payjf",
            data: {
                j_id: this.data.id,
                jifen: e.num,
                openid: wx.getStorageSync("openid"),
                address: s.d_address,
                xxaddress: s.d_xxaddress,
                username: s.d_uname,
                usertel: s.d_phone,
                form_id: t
            },
            success: function(a) {
                wx.navigateBack({});
            }
        });
    },
    onLoad: function(a) {
        var t = this;
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
        }), t.setData({
            id: a.id
        }), t.getUser(), t.getjfgood(a.id), t.getAddress();
    },
    getjfgood: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Jfgoodsxq",
            data: {
                id: a
            },
            success: function(a) {
                t.setData({
                    jfgoods: a.data.data
                }), WxParse.wxParse("article", "html", a.data.data.content, t, 5);
            }
        });
    },
    getAddress: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Addressonly",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                if (a.data.data) var t = !0; else t = !1;
                e.setData({
                    mraddress: a.data.data,
                    isaddress: t
                });
            }
        });
    },
    getUser: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                t.setData({
                    user: a.data.data
                });
            }
        });
    },
    onShow: function() {
        var a = this;
        a.getUser(), a.getjfgood(a.data.id), a.getAddress();
    },
    onShareAppMessage: function() {}
});