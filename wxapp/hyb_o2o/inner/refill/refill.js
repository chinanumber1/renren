var app = getApp();

Page({
    data: {
        money: ""
    },
    input: function(n) {
        n.detail.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3") < 0 ? wx.showToast({
            title: "请输入正确的金额",
            icon: "none"
        }) : this.setData({
            money: n.detail.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3")
        });
    },
    formSubmit: function(n) {
        var o = n.detail.value;
        if (o.openid = wx.getStorageSync("openid"), console.log(o), "" == o.money) return wx.showToast({
            title: "请输入正确的金额",
            icon: "none"
        }), !1;
        app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: o.money,
                openid: o.openid
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(n) {
                wx.requestPayment({
                    timeStamp: n.data.timeStamp,
                    nonceStr: n.data.nonceStr,
                    package: n.data.package,
                    signType: n.data.signType,
                    paySign: n.data.paySign,
                    success: function(n) {
                        app.util.request({
                            url: "entry/wxapp/Chongzhi",
                            data: o,
                            success: function(n) {
                                wx.showToast({
                                    title: "充值成功"
                                }), setTimeout(function() {
                                    wx.reLaunch({
                                        url: "/hyb_o2o/mine/mine"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        });
    },
    onLoad: function(n) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(n) {
                var o = n.data.data.qjcolor, e = n.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", o), console.log(e, o), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: o
                });
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