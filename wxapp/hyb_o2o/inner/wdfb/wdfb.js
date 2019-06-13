var app = getApp();

Page({
    data: {
        current: 0,
        top_list: [ "全部", "待审核", "待接单", "已接单", "已完成" ],
        userfadan: [],
        open_pay: !1
    },
    look_detail: function(a) {
        wx.navigateTo({
            url: "../fa_detail/fa_detail?id=" + a.currentTarget.dataset.id
        });
    },
    pay_choose: function(a) {
        var t = this;
        t.setData({
            open_pay: !1
        }), console.log(a.detail.value), console.log(t.data.baojiaid), console.log(t.data.pay_money), 
        "余额支付" == a.detail.value ? app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a.data.data.u_money), console.log(t.data.pay_money), a.data.data.u_money - t.data.pay_money < 0 ? wx.showModal({
                    title: "提示",
                    content: "您的余额不足，请先前往个人充值",
                    success: function(a) {
                        a.confirm && wx.reLaunch({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }
                }) : app.util.request({
                    url: "entry/wxapp/Tongyibaojia",
                    data: {
                        id: t.data.baojiaid,
                        money: t.data.pay_money,
                        typs: "余额"
                    },
                    success: function(a) {
                        t.getUserfadan(t.data.current);
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: t.data.pay_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/Tongyibaojia",
                            data: {
                                id: t.data.baojiaid,
                                money: t.data.pay_money,
                                typs: "微信"
                            },
                            success: function(a) {
                                t.getUserfadan(t.data.current);
                            }
                        });
                    }
                });
            }
        });
    },
    sureDoor: function(a) {
        var t = this, e = (t.data.come, a.currentTarget.dataset.id);
        wx.showModal({
            title: "提示",
            content: "确定开始服务？",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/Qiangdanfwuser",
                    data: {
                        id: e
                    },
                    success: function(a) {
                        t.getUserfadan(t.data.current);
                    }
                });
            }
        });
    },
    payOrder: function(a) {
        this.setData({
            open_pay: !0,
            pay_money: a.currentTarget.dataset.baojia,
            baojiaid: a.currentTarget.dataset.fa_id
        });
    },
    notongyi: function(a) {
        var t = this;
        console.log(a.currentTarget.dataset.id), app.util.request({
            url: "entry/wxapp/Butongyibaojia",
            data: {
                id: a.currentTarget.dataset.id
            },
            success: function(a) {
                t.getUserfadan(t.data.current);
            }
        });
    },
    switch_tab: function(a) {
        var t = this;
        t.setData({
            current: a.currentTarget.dataset.index
        }), app.util.request({
            url: "entry/wxapp/Userfadan",
            data: {
                openid: wx.getStorageSync("openid"),
                current: a.currentTarget.dataset.index
            },
            success: function(a) {
                t.setData({
                    userfadan: a.data.data
                });
            }
        });
    },
    call: function(a) {
        wx, wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        });
    },
    goIndex: function(a) {
        wx.reLaunch({
            url: "/hyb_o2o/index/index"
        });
    },
    cancel: function(a) {
        var t = this, e = a.currentTarget.dataset.fa_id, n = t.data.current;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/Fadanquxiao",
                    data: {
                        fa_id: e
                    },
                    success: function(a) {
                        t.getUserfadan(n);
                    }
                });
            }
        });
    },
    del: function(t) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "您确定删除吗？",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/Userfadandel",
                    data: {
                        fa_id: t.currentTarget.dataset.fa_id
                    },
                    success: function() {
                        wx.showToast({
                            title: "删除成功!"
                        }), setTimeout(function() {
                            e.getUserfadan(e.data.current);
                        }, 1e3);
                    }
                });
            }
        });
    },
    sure_order: function(a) {
        var t = this, e = t.data.userfadan, n = a.currentTarget.dataset.index, r = a.currentTarget.dataset.id, o = a.currentTarget.dataset.y_id;
        wx.showModal({
            title: "提示",
            content: "确定完成？",
            success: function(a) {
                a.confirm && (e.splice(n, 1), t.setData({
                    userfadan: e
                }), app.util.request({
                    url: "entry/wxapp/Userfadanwc",
                    data: {
                        fa_id: r
                    }
                }), setTimeout(function() {
                    wx.showModal({
                        title: "提示",
                        content: "是否对该服务进行评价",
                        success: function(a) {
                            a.confirm ? wx.navigateTo({
                                url: "../pingfen3/pingfen?y_id=" + o + "&id=" + r
                            }) : (t.setData({
                                current: 3
                            }), t.getUserfadan(3));
                        }
                    });
                }, 1e3));
            }
        });
    },
    tel: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        });
    },
    onLoad: function(a) {
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
        }), wx.setNavigationBarTitle({
            title: "我的发布"
        }), this.getUserfadan(0);
    },
    getUserfadan: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Userfadan",
            data: {
                openid: wx.getStorageSync("openid"),
                current: a
            },
            success: function(a) {
                t.setData({
                    userfadan: a.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});