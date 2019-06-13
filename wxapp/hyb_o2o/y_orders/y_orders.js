var app = getApp();

Page({
    data: {
        o_id: "",
        switch_name: [ "到店服务", "上门服务" ],
        cur: 0,
        top: [ {
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
        cur_2: 0,
        currentTab: 0,
        currentTab_2: 0,
        openid: "",
        pay_status: !1,
        items: [ "现金支付", "微信支付", "余额支付" ],
        gu_status: !1,
        g_id: ""
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    gu_order: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            g_id: a,
            gu_status: !0
        });
    },
    formGujia: function(t) {
        this.data.g_id;
        this.setData({
            gu_status: !1
        });
    },
    switch_cur: function(t) {
        this.setData({
            cur: t.currentTarget.dataset.index
        }), this.getOrderlist(this.data.currentTab, this.data.cur);
    },
    switch_tab: function(t) {
        this.setData({
            currentTab: t.currentTarget.dataset.index
        }), this.getOrderlist(t.currentTarget.dataset.index, this.data.cur);
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
    getOrderlist: function(t, a) {
        var e = this;
        t = t;
        app.util.request({
            url: "entry/wxapp/Orderfuwulist",
            data: {
                openid: wx.getStorageSync("openid"),
                currentTab: t,
                cur: a,
                typs: "yuangong"
            },
            success: function(t) {
                e.setData({
                    order_list: t.data.data
                });
            }
        });
    },
    hx_order: function(a) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确认开始服务？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Hexiao",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        ordersn: a.currentTarget.dataset.ordersn
                    },
                    success: function(t) {
                        e.getOrderlist(e.data.currentTab, e.data.cur);
                    }
                });
            }
        });
    },
    cuidan: function(a) {
        var e = this;
        "0" == a.currentTarget.dataset.i ? wx.showModal({
            title: "提示",
            content: "确认服务完成？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/OrderFwwcs",
                    data: {
                        o_id: a.currentTarget.dataset.id
                    },
                    success: function(t) {
                        e.getOrderlist(e.data.currentTab, e.data.cur);
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "确认请求商家估价？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/OrderFwwcs",
                    data: {
                        o_id: a.currentTarget.dataset.id
                    },
                    success: function(t) {
                        e.getOrderlist(e.data.currentTab, e.data.cur);
                    }
                });
            }
        });
    },
    del_order: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/OrderFwwcygdel",
            data: {
                o_id: t.currentTarget.dataset.id
            },
            success: function(t) {
                console.log("rrrrrr"), a.getOrderlist(a.data.currentTab, a.data.cur);
            }
        });
    },
    surepay: function(t) {
        this.setData({
            pay_status: !0,
            o_id: t.currentTarget.dataset.id
        });
    },
    radioChange: function(t) {
        var a = this;
        a.setData({
            pay_status: !1
        }), app.util.request({
            url: "entry/wxapp/OrderFwfk",
            data: {
                o_id: a.data.o_id,
                pay_typs: t.detail.value
            },
            success: function(t) {
                a.getOrderlist(a.data.currentTab, a.data.cur);
            }
        });
    },
    close_modal: function() {
        this.setData({
            pay_status: !1,
            gu_status: !1
        });
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/order_detail/order_detail?come=yg&id=" + t.currentTarget.dataset.id
        });
    },
    onShareAppMessage: function() {}
});