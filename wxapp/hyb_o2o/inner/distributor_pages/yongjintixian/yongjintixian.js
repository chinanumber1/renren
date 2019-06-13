var app = getApp();

Page({
    data: {
        money: ""
    },
    withdrawal_all: function() {
        this.setData({
            money: ""
        });
    },
    formSubmit: function(a) {
        var t = parseFloat(a.detail.value.t_money), e = parseFloat(a.detail.value.s_money);
        e < 1 ? wx.showModal({
            title: "提示",
            content: "您的可提现金额不足1元"
        }) : e < t ? wx.showModal({
            title: "提示",
            content: "您的提现金额超出可提现金额"
        }) : t < 1 ? wx.showModal({
            title: "提示",
            content: "提现金额不能少于1元"
        }) : app.util.request({
            url: "entry/wxapp/Payyjtixian",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid"),
                t_money: t
            },
            success: function(a) {
                wx.redirectTo({
                    url: "hyb_o2o/inner/business_pages/record/record"
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: "提现失败",
                    duration: 1e3
                });
            }
        });
    },
    onLoad: function(a) {
        var o = this;
        if (a.yj) var n = a.yj; else n = 0;
        if (a.yjmoney) var r = a.yjmoney; else r = 0;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, e = a.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", t), console.log(e, t), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: t
                }), o.setData({
                    base: a.data.data,
                    yj: n,
                    yjmoney: r
                }), wx.setNavigationBarTitle({
                    title: a.data.data.md_name
                });
            }
        });
    },
    onShareAppMessage: function() {}
});