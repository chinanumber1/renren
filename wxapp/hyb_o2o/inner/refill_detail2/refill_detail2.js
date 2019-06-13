var app = getApp();

Page({
    data: {},
    formSubmit: function(o) {
        var e = o.detail.value.ymoney, t = o.detail.value.count_money, a = o.detail.formId, n = o.detail.value.o_id;
        console.log(a), console.log(e), console.log(t), console.log(n), e - t < 0 ? wx.showModal({
            title: "提示",
            content: "余额不足请前往个人中心充值",
            success: function(o) {
                o.confirm && wx.navigateTo({
                    url: "../refill_page/refill_page"
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "确定支付吗",
            success: function(o) {
                o.confirm ? app.util.request({
                    url: "entry/wxapp/Payordergoods",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        o_id: n,
                        form_id: a,
                        typs: "余额"
                    },
                    method: "POST",
                    success: function(o) {
                        wx.showToast({
                            title: "支付成功"
                        }), setTimeout(function() {
                            wx.redirectTo({
                                url: "/hyb_o2o/orders/orders?index=2&typs=yonghu"
                            });
                        }, 1e3);
                    },
                    fail: function(o) {
                        wx.showToast({
                            title: o.data.data.desc,
                            icon: "none"
                        });
                    }
                }) : o.cancel && console.log("用户点击取消");
            }
        });
    },
    formSubmits: function(o) {
        var e = o.detail.formId, t = o.detail.value.count_money, a = o.detail.value.o_id;
        console.log(e), app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: t,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(o) {
                wx.requestPayment({
                    timeStamp: o.data.timeStamp,
                    nonceStr: o.data.nonceStr,
                    package: o.data.package,
                    signType: o.data.signType,
                    paySign: o.data.paySign,
                    success: function(o) {
                        app.util.request({
                            url: "entry/wxapp/Payordergoods",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                o_id: a,
                                form_id: e,
                                typs: "微信"
                            },
                            method: "POST",
                            success: function(o) {
                                console.log(o), wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?index=2&typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        });
    },
    onLoad: function(o) {
        wx.setNavigationBarTitle({
            title: "订单支付页"
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                var e = o.data.data.qjcolor, t = o.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", e), console.log(t, e), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: e
                });
            }
        });
        var e = o.o_id;
        this.getOrdergoodsxq(e);
    },
    getOrdergoodsxq: function(o) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Ordergoodsxq",
            data: {
                o_id: o
            },
            success: function(o) {
                e.setData({
                    order: o.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});