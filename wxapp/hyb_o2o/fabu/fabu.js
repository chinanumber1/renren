var app = getApp();

Page({
    data: {
        url: "",
        uniacid: "",
        openid: "",
        num: 0,
        imgList: [],
        date: "",
        time: "",
        location: "",
        longitude: "",
        latitude: "",
        edit_charge: !1,
        money: "",
        charge: "一口价",
        diff: "是",
        items: [ {
            value: "一口价",
            text: "客户预约时，一次性支付本服务的全部费用。商家承诺，本服务无额外收费。"
        }, {
            value: "上门估价",
            text: "上门费：用户下单时将预付上门费，商家按约定时间上门后，商家可收取上门费。商家可对改服务进行报价，如若客户同意报价，商家可获取新的服务费用。"
        } ],
        payTypes: [ "微信支付", "余额支付" ],
        paytype: "微信支付",
        tel: "",
        second: 60,
        send: !1,
        dizhi: "",
        erjiprice: 0,
        smfy: 0
    },
    back: function() {
        wx.navigateBack({});
    },
    getTel: function(e) {
        "" != e.detail.value && this.setData({
            tel: e.detail.value
        });
    },
    yzm: function(e) {
        var t = this, a = t.data.tel;
        "" != a && /^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(a) ? app.util.request({
            url: "entry/wxapp/Fadanyzm",
            data: {
                telphone: a
            },
            success: function(e) {
                t.setData({
                    send: !0,
                    yanzhengma: e.data.data
                }), t.timer();
            }
        }) : wx.showToast({
            title: "请检查手机号码",
            image: "/hyb_o2o/resource/images/error.png"
        });
    },
    timer: function() {
        var i = this;
        new Promise(function(e, t) {
            var a = setInterval(function() {
                i.setData({
                    second: i.data.second - 1
                }), i.data.second <= 0 && (i.setData({
                    second: 60,
                    alreadySend: !1,
                    send: !1
                }), e(a));
            }, 1e3);
        }).then(function(e) {
            clearInterval(e);
        });
    },
    uploadDIY: function(e, t, a, i, n) {
        var o = this, s = this, r = s.data.uniacid, u = s.data.imgList;
        wx.uploadFile({
            url: s.data.url + "app/index.php?i=" + r + "&c=entry&a=wxapp&do=Upload&m=hyb_o2o",
            filePath: e[i],
            name: "upfile",
            formData: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                t++, u.push(e.data), s.setData({
                    imgList: u
                });
            },
            fail: function(e) {
                a++;
            },
            complete: function() {
                ++i == n ? wx.hideLoading() : o.uploadDIY(e, t, a, i, n);
            }
        });
    },
    choosePic: function() {
        var a = this;
        this.data.imgList;
        wx.chooseImage({
            count: 8,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                e.tempFilePaths;
                var t = e.tempFilePaths.length;
                a.uploadDIY(e.tempFilePaths, 0, 0, 0, t);
            }
        });
    },
    del: function(e) {
        var t = this.data.imgList;
        t.splice(e.currentTarget.dataset.index, 1), this.setData({
            imgList: t
        });
    },
    input_biaoti: function(e) {
        this.setData({
            num: e.detail.value.length
        });
    },
    input: function(e) {
        this.setData({
            money: e.detail.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3")
        });
    },
    editCharge: function() {
        this.setData({
            edit_charge: !0
        }), wx.setNavigationBarTitle({
            title: "服务收费"
        });
    },
    radioChange: function(e) {
        this.setData({
            charge: e.detail.value
        });
    },
    radioChange_pay: function(e) {
        this.setData({
            paytype: e.detail.value
        });
    },
    radioChange2: function(e) {
        this.setData({
            diff: e.detail.value
        });
    },
    input_blur: function(e) {
        this.setData({
            money: e.detail.value
        });
    },
    close_charge: function() {
        "" == this.data.charge ? wx.showToast({
            title: "请选择付款方式",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == this.data.money && "上门估价" != this.data.charge ? wx.showToast({
            title: "请输入价格",
            image: "/hyb_o2o/resource/images/error.png"
        }) : this.setData({
            edit_charge: !1
        });
    },
    onLoad: function(e) {
        var t = this, a = app.siteInfo.uniacid;
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
        }), app.util.request({
            url: "entry/wxapp/url",
            success: function(e) {
                t.setData({
                    url: e.data,
                    uniacid: a
                });
            }
        });
        var i = wx.getStorageSync("openid"), n = e.f_name, o = e.xt_name, s = e.xt_id;
        app.util.request({
            url: "entry/wxapp/getErjiPrice",
            data: {
                id: s
            },
            success: function(e) {
                console.log(e), t.setData({
                    erjiprice: e.data.data.price,
                    smfy: e.data.data.smfy
                }), 0 != e.data.data.price && t.setData({
                    money: e.data.data.price
                });
            }
        });
        var r = new Date(), u = r.getMinutes() < 10 ? "0" + r.getMinutes() : r.getMinutes();
        this.setData({
            openid: i,
            date: r.getFullYear() + "-" + (r.getMonth() + 1) + "-" + r.getDate(),
            time: r.getHours() + ":" + u,
            yiji: n,
            erji: o
        }), t.getFwstyle(), t.getUser();
    },
    disscroll: function() {},
    phonebd: function() {
        wx.navigateTo({
            url: "../mine/renzheng/renzheng"
        });
    },
    getUser: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                t.setData({
                    userInfo: e.data.data
                });
            }
        });
    },
    getFwstyle: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Showfuwustyle",
            success: function(e) {
                t.setData({
                    Fwstyle: e.data.data
                });
            }
        });
    },
    open_map: function() {
        var a = this;
        wx.chooseLocation({
            success: function(e) {
                if (-1 == e.address.indexOf("市")) {
                    var t = wx.getStorageSync("city");
                    "" == t ? app.util.request({
                        url: "entry/wxapp/Base",
                        success: function(e) {
                            a.setData({
                                location: e.data.data.md_index + e.address,
                                longitude: e.longitude,
                                latitude: e.latitude
                            }), a.dingwei();
                        }
                    }) : (a.setData({
                        location: t + e.address,
                        longitude: e.longitude,
                        latitude: e.latitude
                    }), a.dingwei());
                } else a.setData({
                    location: e.address,
                    longitude: e.longitude,
                    latitude: e.latitude
                }), a.dingwei();
            }
        });
    },
    dingwei: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var t = e.data.data.baidukey, a = n.data.longitude, i = n.data.latitude;
                wx.request({
                    url: "https://api.map.baidu.com/geocoder/v2/?ak=" + t + "&location=" + i + "," + a + "&output=json",
                    data: {},
                    header: {
                        "Content-Type": "application/json"
                    },
                    success: function(e) {
                        n.setData({
                            dizhi: e.data.result.addressComponent.city
                        });
                    }
                });
            }
        });
    },
    bindDate: function(e) {
        this.setData({
            date: e.detail.value
        });
    },
    bindTime: function(e) {
        this.setData({
            time: e.detail.value
        });
    },
    formSubmit: function(e) {
        var t = e.detail.value;
        t.server_charge = this.data.charge, t.region = t.provinceName + "-" + t.cityName + "-" + t.countyName, 
        t.dizhi = this.data.dizhi, "" == t.server_name ? wx.showToast({
            title: "请填写服务名称",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.server_intro ? wx.showToast({
            title: "请填写服务内容",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "一口价" == t.server_charge && "" == t.money ? wx.showToast({
            title: "请填写服务费用",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "上门估价" == t.server_charge && "" == t.smfy ? wx.showToast({
            title: "请填写上门费用",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.location ? wx.showToast({
            title: "请选择位置",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.name ? wx.showToast({
            title: "请填写联系人",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.address_detail ? wx.showToast({
            title: "请填写详细地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "上门估价" == t.server_charge || "" != t.money && "0" != t.money ? "上门估价" != t.server_charge || "" != t.smfy && "0" != t.smfy ? (t.imglist = this.data.imgList, 
        console.log(t), "余额支付" == t.paytype ? app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log(e.data.data.u_money), console.log(t.money), "一口价" == t.server_charge && (e.data.data.u_money - t.money < 0 ? wx.showModal({
                    title: "提示",
                    content: "您的余额不足，请先前往个人充值",
                    success: function(e) {
                        e.confirm && wx.reLaunch({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }
                }) : app.util.request({
                    url: "entry/wxapp/Fadan",
                    data: t,
                    success: function(e) {
                        wx.showToast({
                            title: "发布成功"
                        }), setTimeout(function() {
                            wx.navigateTo({
                                url: "/hyb_o2o/inner/wdfb/wdfb"
                            });
                        }, 1e3);
                    }
                })), "上门估价" == t.server_charge && (e.data.data.u_money - t.smfy < 0 ? wx.showModal({
                    title: "提示",
                    content: "您的余额不足，请先前往个人充值",
                    success: function(e) {
                        e.confirm && wx.reLaunch({
                            url: "/hyb_o2o/mine/mine"
                        });
                    }
                }) : app.util.request({
                    url: "entry/wxapp/Fadan",
                    data: t,
                    success: function(e) {
                        wx.showToast({
                            title: "发布成功"
                        }), setTimeout(function() {
                            wx.navigateTo({
                                url: "/hyb_o2o/inner/wdfb/wdfb"
                            });
                        }, 1e3);
                    }
                }));
            }
        }) : "微信支付" == t.paytype && ("一口价" == t.server_charge && (0 < t.money ? app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: t.money,
                openid: t.openid
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {
                        app.util.request({
                            url: "entry/wxapp/Fadan",
                            data: t,
                            success: function(e) {
                                wx.showToast({
                                    title: "发布成功"
                                }), setTimeout(function() {
                                    wx.navigateTo({
                                        url: "/hyb_o2o/inner/wdfb/wdfb"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Fadan",
            data: t,
            success: function(e) {
                wx.showToast({
                    title: "发布成功"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/hyb_o2o/inner/wdfb/wdfb"
                    });
                }, 1e3);
            }
        })), "上门估价" == t.server_charge && (0 < t.smfy ? app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                money: t.smfy,
                openid: t.openid
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {
                        app.util.request({
                            url: "entry/wxapp/Fadan",
                            data: t,
                            success: function(e) {
                                wx.showToast({
                                    title: "发布成功"
                                }), setTimeout(function() {
                                    wx.navigateTo({
                                        url: "/hyb_o2o/inner/wdfb/wdfb"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Fadan",
            data: t,
            success: function(e) {
                wx.showToast({
                    title: "发布成功"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/hyb_o2o/inner/wdfb/wdfb"
                    });
                }, 1e3);
            }
        })))) : wx.showToast({
            title: "请填写上门费用",
            image: "/hyb_o2o/resource/images/error.png"
        }) : wx.showToast({
            title: "请填写服务预算",
            image: "/hyb_o2o/resource/images/error.png"
        });
    },
    onShareAppMessage: function() {}
});