var app = getApp();

Page({
    data: {
        money: "",
        typs: "",
        withDraw: [ "提现到银行卡", "提现到支付宝", "提现到微信" ],
        cur: 0,
        btns: !0
    },
    link_txmx: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/txmx/txmx?typs=" + this.data.typs
        });
    },
    withdrawal_all: function() {
        this.setData({
            money: ""
        });
    },
    switchTab: function(t) {
        this.setData({
            cur: t.currentTarget.dataset.index,
            btns: !0
        });
    },
    input: function(t) {
        this.setData({
            money: t.detail.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3")
        });
    },
    formSubmit: function(t) {
        var e = this, a = parseFloat(t.detail.value.shouxufei), i = parseFloat(t.detail.value.t_money), n = parseFloat(t.detail.value.s_money), o = parseFloat((.01 * i * a).toFixed(2));
        console.log(t.detail.value), console.log(e.data.cur);
        var s = t.detail.value;
        if (0 == e.data.cur || 1 == e.data.cur) if ("" == s.name) wx.showToast({
            title: "请输入姓名",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == s.cardNum) wx.showToast({
            title: "请输入账号",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == s.place && 0 == e.data.cur) wx.showToast({
            title: "请输入开户行",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == s.t_money) wx.showToast({
            title: "请输入提现金额",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if (n < i) wx.showModal({
            title: "提示",
            content: "提现金额超出可提现金额"
        }); else if (i <= 0) wx.showModal({
            title: "提示",
            content: "提现金额需大于0"
        }); else {
            i + o < n ? app.util.request({
                url: "entry/wxapp/Paytixian",
                data: {
                    openid: wx.getStorageSync("openid"),
                    t_money: i,
                    s_money: n,
                    shouxufei: o,
                    id: s.id,
                    tishi: "0",
                    typs: e.data.typs,
                    xingshi: e.data.cur,
                    name: s.name,
                    cardNum: s.cardNum,
                    place: s.place
                },
                success: function(t) {
                    e.setData({
                        btns: !1
                    }), wx.showToast({
                        title: "提现成功待审核"
                    }), setTimeout(function() {
                        wx.redirectTo({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }, 1e3);
                }
            }) : app.util.request({
                url: "entry/wxapp/Paytixian",
                data: {
                    openid: wx.getStorageSync("openid"),
                    t_money: i,
                    s_money: n,
                    shouxufei: o,
                    id: s.id,
                    tishi: "1",
                    typs: e.data.typs,
                    xingshi: e.data.cur,
                    name: s.name,
                    cardNum: s.cardNum,
                    place: s.place
                },
                success: function(t) {
                    e.setData({
                        btns: !1
                    }), wx.showToast({
                        title: "提现成功待审核"
                    }), setTimeout(function() {
                        wx.redirectTo({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }, 1e3);
                }
            });
        } else if (2 == e.data.cur) if ("" == s.t_money) wx.showToast({
            title: "请输入提现金额",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if (n < i) wx.showModal({
            title: "提示",
            content: "提现金额超出可提现金额"
        }); else if (i <= 0) wx.showModal({
            title: "提示",
            content: "提现金额需大于0"
        }); else {
            i + o < n ? app.util.request({
                url: "entry/wxapp/Paytixian",
                data: {
                    openid: wx.getStorageSync("openid"),
                    t_money: i,
                    s_money: n,
                    shouxufei: o,
                    id: s.id,
                    tishi: "0",
                    typs: e.data.typs,
                    xingshi: e.data.cur
                },
                success: function(t) {
                    e.setData({
                        btns: !1
                    }), wx.showToast({
                        title: "提现成功待审核"
                    }), setTimeout(function() {
                        wx.redirectTo({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }, 1e3);
                }
            }) : app.util.request({
                url: "entry/wxapp/Paytixian",
                data: {
                    openid: wx.getStorageSync("openid"),
                    t_money: i,
                    s_money: n,
                    shouxufei: o,
                    id: s.id,
                    tishi: "1",
                    typs: e.data.typs,
                    xingshi: e.data.cur
                },
                success: function(t) {
                    e.setData({
                        btns: !1
                    }), wx.showToast({
                        title: "提现成功待审核"
                    }), setTimeout(function() {
                        wx.redirectTo({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }, 1e3);
                }
            });
        }
    },
    onLoad: function(t) {
        var e = this, a = t.typs;
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
        }), e.setData({
            typs: a
        }), app.util.request({
            url: "entry/wxapp/Tianxshezhi",
            success: function(t) {
                e.setData({
                    tianxshezhi: t.data.data
                });
            }
        }), "yh" == a && (e.getYhmoney(), e.getyhtixian()), "sj" == a && (e.getSjmoney(), 
        e.getSjtixian()), "yg" == a && (e.getYgmoney(), e.getYgtixian());
    },
    getYhmoney: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    Yhmoney: t.data.data
                });
            }
        });
    },
    getyhtixian: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Yhtixian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    yhtixian: t.data.data.tixian
                });
            }
        });
    },
    getSjmoney: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shangjia",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    Sjmoney: t.data.data
                });
            }
        });
    },
    getSjtixian: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Sjtixian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    sjtixian: t.data.data.tixian
                });
            }
        });
    },
    getYgmoney: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Yuangongxq",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    ygmoney: t.data.data
                });
            }
        });
    },
    getYgtixian: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Ygtixian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    ygtixian: t.data.data.tixian
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