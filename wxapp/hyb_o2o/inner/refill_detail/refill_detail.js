function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page({
    data: {
        bzjinde: "0",
        rz_money: "0",
        rz_id: "0",
        come: "",
        dd: "",
        ts: ""
    },
    bindPickerChange_rz: function(t) {
        var e = t.detail.value, a = this.data.rz[e].r_money, o = this.data.rz[e].r_id;
        this.setData({
            bzjindex: e,
            rz_money: a,
            rz_id: o
        });
    },
    onLoad: function(t) {
        var e = this;
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
        var a = t.come, o = t.ts;
        if (e.setData({
            come: a,
            ts: o
        }), "续费" == a && (wx.setNavigationBarTitle({
            title: "续费中心"
        }), "sj" == o ? e.getSjrzsj() : e.getJsrzsj()), "充值" == a) {
            wx.setNavigationBarTitle({
                title: "充值中心"
            });
            var n = t.h_id;
            e.getHuiyuanxq(n);
        }
        if ("服务" == a) {
            wx.setNavigationBarTitle({
                title: "服务中心"
            });
            var s = t.o_id, i = t.dd;
            e.setData({
                dd: i
            }), e.getOrderfuxq(s);
        }
    },
    getSjrzsj: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Sjrzsj",
            success: function(t) {
                for (var e = t.data.data, a = [], o = 0; o < e.length; o++) a.push(e[o].r_content);
                n.setData({
                    rz: t.data.data,
                    array: a
                });
            }
        });
    },
    getJsrzsj: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Jsrzsj",
            success: function(t) {
                for (var e = t.data.data, a = [], o = 0; o < e.length; o++) a.push(e[o].r_content);
                n.setData({
                    rz: t.data.data,
                    array: a
                });
            }
        });
    },
    formSubmitxufei: function(t) {
        var e = t.detail.formId, a = this.data.rz_money, o = this.data.rz_id;
        "0" == o ? wx.showToast({
            title: "请选择入驻时长",
            image: "../../resource/images/error.png"
        }) : "0" == a ? app.util.request({
            url: "entry/wxapp/Paysjxf",
            data: {
                openid: wx.getStorageSync("openid"),
                money: a,
                form_id: e,
                rz_id: o
            },
            success: function(t) {
                wx.showToast({
                    title: "续费成功!"
                }), setTimeout(function() {
                    wx.navigateBack({});
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {},
                    complete: function(t) {
                        "requestPayment:fail cancel" != t.errMsg && app.util.request({
                            url: "entry/wxapp/Paysjxf",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                money: a,
                                form_id: e,
                                rz_id: o
                            },
                            success: function(t) {
                                wx.showToast({
                                    title: "续费成功!"
                                }), setTimeout(function() {
                                    wx.navigateBack({});
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        });
    },
    formSubmitxufeijs: function(t) {
        var e = t.detail.formId, a = this.data.rz_money, o = this.data.rz_id;
        "0" == o ? wx.showToast({
            title: "请选择入驻时长",
            image: "../../resource/images/error.png"
        }) : "0" == a ? app.util.request({
            url: "entry/wxapp/Payjsxf",
            data: {
                openid: wx.getStorageSync("openid"),
                money: a,
                form_id: e,
                rz_id: o
            },
            success: function(t) {
                wx.showToast({
                    title: "续费成功!"
                }), setTimeout(function() {
                    wx.navigateBack({});
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {},
                    complete: function(t) {
                        "requestPayment:fail cancel" != t.errMsg && app.util.request({
                            url: "entry/wxapp/Payjsxf",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                money: a,
                                form_id: e,
                                rz_id: o
                            },
                            success: function(t) {
                                wx.showToast({
                                    title: "续费成功!"
                                }), setTimeout(function() {
                                    wx.navigateBack({});
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        });
    },
    getHuiyuanxq: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Huiyuanxq",
            data: {
                h_id: t
            },
            success: function(t) {
                e.setData({
                    Huiyuanxq: t.data.data
                });
            }
        });
    },
    formSubmitchongzhi: function(t) {
        var e = t.detail.formId, a = t.detail.value.money, o = t.detail.value.h_id;
        "0" == a ? app.util.request({
            url: "entry/wxapp/Payhycz",
            data: {
                openid: wx.getStorageSync("openid"),
                form_id: e,
                h_id: o
            },
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payhycz",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                form_id: e,
                                h_id: o
                            },
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
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
    getOrderfuxq: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Orderfuxq",
            data: {
                o_id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    order: t.data.data
                });
            }
        });
    },
    formSubmitfwye: function(t) {
        var e = t.detail.formId, a = t.detail.value;
        a.form_id = e, a.openid = wx.getStorageSync("openid"), console.log(a), "zf" == this.data.dd ? "定金支付" == a.pay_type ? app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            },
            fail: function(t) {
                wx.showToast({
                    title: t.data.data.desc,
                    icon: "none"
                });
            }
        }) : "全额付款" == a.pay_type ? app.util.request(_defineProperty({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            },
            fail: function(t) {
                console.log(t), wx.showToast({
                    title: t.data.data.desc,
                    icon: "none"
                });
            }
        }, "fail", function(t) {
            wx.showToast({
                title: t.data.data.desc,
                icon: "none"
            });
        })) : "上门估价" == a.pay_type && app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            },
            fail: function(t) {
                wx.showToast({
                    title: t.data.data.desc,
                    icon: "none"
                });
            }
        }) : "dd" == this.data.dd && ("定金支付" == a.pay_type ? app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            },
            fail: function(t) {
                wx.showToast({
                    title: t.data.data.desc,
                    icon: "none"
                });
            }
        }) : "全额付款" == a.pay_type ? app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            },
            fail: function(t) {
                wx.showToast({
                    title: t.data.data.desc,
                    icon: "none"
                });
            }
        }) : "上门估价" == a.pay_type && app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            },
            fail: function(t) {
                wx.showToast({
                    title: t.data.data.desc,
                    icon: "none"
                });
            }
        }));
    },
    formSubmitfwwx: function(t) {
        var e = t.detail.formId, a = t.detail.value;
        a.form_id = e, a.openid = wx.getStorageSync("openid"), console.log(a), "zf" == this.data.dd ? "定金支付" == a.pay_type ? "0" == a.ding_money ? app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.ding_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfuzf",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : "全额付款" == a.pay_type ? "0" == a.count_money ? app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.redirectTo({
                    url: "/hyb_o2o/orders/orders?typs=yonghu"
                });
            }
        }) : (console.log(wx.getStorageSync("openid")), console.log(a.count_money), app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.count_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfuzf",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        })) : "上门估价" == a.pay_type && ("0" == a.o_shangmen_money ? app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.redirectTo({
                    url: "/hyb_o2o/orders/orders?typs=yonghu"
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.o_shangmen_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfuzf",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        })) : "dd" == this.data.dd && ("定金支付" == a.pay_type && "0" == a.o_pay_types ? "0" == a.ding_money ? app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.ding_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfujie",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : "定金支付" == a.pay_type && "1" == a.o_pay_types ? "0" == a.sheng_money ? app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.sheng_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfujie",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : "全额付款" == a.pay_type ? "0" == a.count_money ? app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.count_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfujie",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : "上门估价" == a.pay_type && ("0" == a.count_money && "0" == a.o_shangmen_money ? app.util.request({
            url: "entry/wxapp/Payfujie",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        }) : "0" != a.count_money ? (console.log(a.count_money), app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.count_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfujie",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        })) : (console.log(a.o_shangmen_money), app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: a.o_shangmen_money,
                openid: wx.getStorageSync("openid")
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Payfujie",
                            data: a,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }))));
    },
    formSubmitfudd: function(t) {
        var e = t.detail.formId, a = t.detail.value;
        a.form_id = e, a.openid = wx.getStorageSync("openid"), console.log(a), "定金支付" == a.pay_type ? app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        }) : "全额付款" == a.pay_type && app.util.request({
            url: "entry/wxapp/Payfuzf",
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/orders/orders?typs=yonghu"
                    });
                }, 1e3);
            }
        });
    },
    onShareAppMessage: function() {}
});