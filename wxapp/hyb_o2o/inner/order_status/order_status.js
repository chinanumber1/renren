var app = getApp();

Page({
    data: {
        top: [ {
            name: "全部",
            icon: "../../resource/images/all.png"
        }, {
            name: "待付款",
            icon: "../../resource/images/w_pay.png"
        }, {
            name: "待使用",
            icon: "../../resource/images/w_send.png"
        }, {
            name: "待评价",
            icon: "../../resource/images/servering.png"
        }, {
            name: "退款/售后",
            icon: "../../resource/images/complete.png"
        } ],
        currentTab: 0,
        openid: "",
        img_true: !1,
        hx_img: "",
        hx_num: "",
        ping: !1,
        typs: ""
    },
    close_hx: function() {
        this.setData({
            img_true: !1
        });
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    switch_tab: function(t) {
        this.data.openid;
        this.setData({
            currentTab: t.currentTarget.dataset.index
        }), this.getOrderlist(t.currentTarget.dataset.index);
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "../order_detail/order_detail?come=fw&id=" + t.currentTarget.dataset.id
        });
    },
    cuidan: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Orderfwtype",
            data: {
                o_id: e
            },
            success: function(t) {
                a.getOrderlist(a.data.currentTab);
            }
        });
    },
    pay_order: function(t) {
        wx.navigateTo({
            url: "../refill_detail/refill_detail?come=服务&o_id=" + t.currentTarget.dataset.id + "&dd=dd"
        });
    },
    cancel_order: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定取消订单吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Orderfwsave",
                    data: {
                        o_id: e
                    },
                    success: function(t) {
                        a.getOrderlist(a.data.currentTab);
                    }
                });
            }
        });
    },
    check_location: function(t) {
        var a = this, r = wx.getStorageSync("openid"), o = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                a.setData({
                    base: t.data.data
                }), wx.setNavigationBarTitle({
                    title: t.data.data.name
                });
                var n = t.data.data.baidukey;
                wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        var a = t.longitude, e = t.latitude;
                        t.speed, t.accuracy;
                        wx.request({
                            url: "https://api.map.baidu.com/geocoder/v2/?ak=" + n + "&location=" + e + "," + a + "&output=json",
                            data: {},
                            header: {
                                "Content-Type": "application/json"
                            },
                            success: function(t) {
                                console.log(t.data.result.location), app.util.request({
                                    url: "entry/wxapp/saveLocaltion",
                                    data: {
                                        lat: t.data.result.location.lat,
                                        lon: t.data.result.location.lng,
                                        openid: r,
                                        o_id: o
                                    },
                                    success: function(t) {
                                        console.log(t.data.data.code), t.data.data.code ? wx.navigateTo({
                                            url: "/hyb_o2o/map/localtion?startlat=" + t.data.data.start.lat + "&startlon=" + t.data.data.start.lon + "&endlat=" + t.data.data.end.lat + "&endlon=" + t.data.data.end.lon + "&start=" + t.data.data.start.lon + "," + t.data.data.start.lat + "&end=" + t.data.data.end.lon + ", " + t.data.data.end.lat + "&sopenid=" + t.data.data.sopenid + "&eopenid=" + t.data.data.eopenid
                                        }) : wx.showToast({
                                            title: t.data.data.desc,
                                            icon: "none"
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    del_order: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确定删除订单吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Orderfwdel",
                    data: {
                        o_id: e,
                        typs: "yonghu"
                    },
                    success: function(t) {
                        a.getOrderlist(a.data.currentTab);
                    }
                });
            }
        });
    },
    pingjia_order: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.x_thumb;
        wx.navigateTo({
            url: "/hyb_o2o/inner/pingfen/pingfen?o_id=" + a + "&x_thumb=" + e
        });
    },
    pingjia_ordered: function(t) {
        var a = t.currentTarget.dataset.o_id;
        wx.navigateTo({
            url: "/hyb_o2o/inner/ping_done/ping_done?o_id=" + a
        });
    },
    onLoad: function(t) {
        var a = t.id, e = t.typs;
        if (app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", a), console.log(e, a), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                });
            }
        }), this.setData({
            typs: e
        }), a) this.setData({
            currentTab: a
        }), this.getOrderlist(a); else {
            a = this.data.currentTab;
            this.setData({
                currentTab: a
            }), this.getOrderlist(a);
        }
    },
    getOrderlist: function(t) {
        var a = this;
        t = t;
        app.util.request({
            url: "entry/wxapp/Orderfuwulist",
            data: {
                openid: wx.getStorageSync("openid"),
                currentTab: t,
                typs: a.data.typs
            },
            success: function(t) {
                a.setData({
                    order_list: t.data.data
                });
            }
        });
    },
    hxClick: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Hexiaoma",
            data: {
                o_id: e
            },
            success: function(t) {
                a.setData({
                    hx_img: t.data.data.hexiaomathumb,
                    img_true: !0,
                    hx_num: t.data.data.hexiaomashuzi
                });
            }
        });
    },
    onShareAppMessage: function() {}
});