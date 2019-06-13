var app = getApp(), WxParse = require("./../wxParse/wxParse.js");

Page({
    data: {
        disabled: !1,
        fwxy: !0
    },
    lookck: function() {
        this.setData({
            fwxy: !1
        });
    },
    queren: function() {
        this.setData({
            fwxy: !0
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
        }), this.getUserfenxiaotixian();
    },
    getUserfenxiaotixian: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Userfenxiaotixian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    userfenxiaotixian: t.data.data
                }), WxParse.wxParse("article", "html", t.data.data.txxy, a, 5);
            }
        });
    },
    formSubmit: function(t) {
        var a = t.detail.value;
        a.je < a.zd_txmoney ? wx.showModal({
            title: "提示",
            content: "最顶提现金额为￥" + a.zd_txmoney
        }) : a.je > a.u_money ? wx.showModal({
            title: "提示",
            content: "提现金额大于现有佣金"
        }) : app.util.request({
            url: "entry/wxapp/Userfenxiaotixianadd",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "提现成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/distribution/yaoqing"
                    });
                }, 1e3);
            }
        });
    },
    onShareAppMessage: function() {}
});