var app = getApp();

Page({
    data: {
        switch_name: [ "到店服务", "上门服务" ],
        baojiahide: !0,
        baojiaid: null,
        cur: 0,
        top: [ {
            name: "全部",
            icon: "../resource/images/all.png"
        }, {
            name: "待核销",
            icon: "../resource/images/w_pay.png"
        }, {
            name: "待完成",
            icon: "../resource/images/w_send.png"
        }, {
            name: "待付款",
            icon: "../resource/images/complete.png"
        }, {
            name: "待评价",
            icon: "../resource/images/servering.png"
        } ],
        top_2: [ {
            name: "全部",
            icon: "../resource/images/all.png"
        }, {
            name: "待服务",
            icon: "../resource/images/w_pay.png"
        }, {
            name: "服务中",
            icon: "../resource/images/w_send.png"
        }, {
            name: "待付款",
            icon: "../resource/images/complete.png"
        }, {
            name: "待评价",
            icon: "../resource/images/servering.png"
        } ],
        currentTab: 0,
        openid: ""
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    switch_cur: function(t) {
        this.setData({
            cur: t.currentTarget.dataset.index,
            currentTab: 0
        }), this.getOrderlist(this.data.currentTab, this.data.cur);
    },
    zhipai: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_o2o/inner/yglb/yglb?come=zhipaidingdan&id=" + a
        });
    },
    switch_tab: function(t) {
        this.setData({
            currentTab: t.currentTarget.dataset.index
        }), this.getOrderlist(this.data.currentTab, this.data.cur);
    },
    hidebaojiamodal: function() {
        this.setData({
            baojiahide: !0
        });
    },
    baojiabtn: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            baojiahide: !1,
            baojiaid: a
        });
    },
    baojiaform: function(t) {
        var a = this, e = t.detail.value.bjmoney, r = t.detail.value.baojiaid;
        "" == e ? wx.showToast({
            title: "价钱不能为空",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/FuwuBaojia",
            data: {
                id: r,
                money: e
            },
            success: function(t) {
                a.setData({
                    baojiahide: !0
                }), a.getOrderlist(a.data.currentTab, a.data.cur);
            }
        });
    },
    onLoad: function(t) {
        var a = this;
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
        }), a.getOrderlist(a.data.currentTab, a.data.cur);
    },
    onShow: function() {
        var t = this;
        t.getOrderlist(t.data.currentTab, t.data.cur);
    },
    getOrderlist: function(t, a) {
        var e = this;
        t = t;
        app.util.request({
            url: "entry/wxapp/Orderfuwulist",
            data: {
                openid: wx.getStorageSync("openid"),
                currentTab: t,
                cur: a,
                typs: "shangjia"
            },
            success: function(t) {
                e.setData({
                    order_list: t.data.data
                });
            }
        });
    },
    hx_order: function() {
        var e = this;
        wx.scanCode({
            success: function(t) {
                wx.showToast({
                    title: "扫码成功,信息查询中!"
                });
                var a = t.path;
                app.util.request({
                    url: "entry/wxapp/Hexiao",
                    data: {
                        ordersn: a,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        "匹配未找到" == t.data.data ? wx.showToast({
                            title: "核销失败"
                        }) : wx.showToast({
                            title: "核销成功"
                        }), setTimeout(function() {
                            e.getOrderlist(e.data.currentTab, e.data.cur);
                        }, 1e3);
                    }
                });
            },
            fail: function(t) {
                wx.showToast({
                    image: "/hyb_o2o/resource/images/error.png",
                    title: "扫码失败!"
                });
            }
        });
    },
    cuidan: function(a) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确认完成服务吗",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/OrderFwwc",
                    data: {
                        o_id: a.currentTarget.dataset.id
                    },
                    success: function(t) {
                        e.setData({
                            order_list: t.data.data
                        }), e.getOrderlist(e.data.currentTab, e.data.cur);
                    }
                });
            }
        });
    },
    surepay: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/OrderFwwcpay",
            data: {
                o_id: t.currentTarget.dataset.id
            },
            success: function(t) {
                a.setData({
                    order_list: t.data.data
                }), a.getOrderlist(a.data.currentTab, a.data.cur);
            }
        });
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/order_detail/order_detail?come=sj&id=" + t.currentTarget.dataset.id
        });
    },
    del_order: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Orderfwdel",
            data: {
                o_id: e,
                typs: "shangjia"
            },
            success: function(t) {
                a.getOrderlist(a.data.currentTab, a.data.cur);
            }
        });
    },
    sure_Fw: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        t.currentTarget.dataset.currentTab;
        wx.showModal({
            title: "提示",
            content: "确认开始服务？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Ordersjfwks",
                    data: {
                        o_id: e,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        a.getOrderlist(a.data.currentTab, a.data.cur);
                    }
                });
            }
        });
    },
    sure_Fwwc: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        t.currentTarget.dataset.currentTab;
        wx.showModal({
            title: "提示",
            content: "确认服务完成？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/OrderFwwcs",
                    data: {
                        o_id: e,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        a.getOrderlist(a.data.currentTab, a.data.cur);
                    }
                });
            }
        });
    },
    onShareAppMessage: function() {}
});