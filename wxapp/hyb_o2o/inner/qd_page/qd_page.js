var app = getApp();

Page({
    data: {
        come: "",
        list: [],
        gu_status: !1,
        g_id: "",
        baojiahide: !0,
        baojiaid: "0"
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    baojiabtn: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            baojiahide: !1,
            baojiaid: a
        });
    },
    hidebaojiamodal: function() {
        this.setData({
            baojiahide: !0
        });
    },
    baojia: function(t) {
        var a = t.currentTarget.dataset.fa_id, e = t.currentTarget.dataset.q_id;
        this.setData({
            baojiahide: !1,
            baojiaid: a,
            q_id: e
        });
    },
    baojiaform: function(t) {
        var a = this, e = t.detail.value.bjmoney, n = t.detail.value.baojiaid, i = t.detail.value.q_id;
        "" == e ? wx.showToast({
            title: "价钱不能为空",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/PaidanBaojia",
            data: {
                id: n,
                q_id: i,
                money: e
            },
            success: function(t) {
                a.setData({
                    baojiahide: !0
                }), a.getYuangongqdlist();
            }
        });
    },
    del: function(t) {
        var a = this, e = a.data.list, n = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定删除该信息吗",
            success: function(t) {
                t.confirm && (e.splice(n, 1), a.setData({
                    list: e
                }));
            }
        });
    },
    sure_orderfw: function(t) {
        var a = this, e = a.data.list, n = a.data.come, i = t.currentTarget.dataset.index, o = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定开始服务？",
            success: function(t) {
                t.confirm && (e[i].q_styles = "服务中", a.setData({
                    list: e
                }), app.util.request({
                    url: "entry/wxapp/Qiangdanfw",
                    data: {
                        id: o,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        "company" == n && a.getYuangonggspdlist(), "mine" == n && a.getYuangongqdlist(), 
                        "complete" == n && a.getYuangongddwclist();
                    }
                }));
            }
        });
    },
    sure_order: function(t) {
        var a = this, e = a.data.list, n = a.data.come, i = t.currentTarget.dataset.index, o = t.currentTarget.dataset.id;
        "0" == t.currentTarget.dataset.ts ? wx.showModal({
            title: "提示",
            content: "确定完成？",
            success: function(t) {
                t.confirm && (e[i].q_styles = "已完成", a.setData({
                    list: e
                }), app.util.request({
                    url: "entry/wxapp/Qiangdanwc",
                    data: {
                        id: o,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        "company" == n && a.getYuangonggspdlist(), "mine" == n && a.getYuangongqdlist(), 
                        "complete" == n && a.getYuangongddwclist();
                    }
                }));
            }
        }) : wx.showModal({
            title: "提示",
            content: "确定请求商家估价？",
            success: function(t) {
                t.confirm && (e[i].q_styles = "已完成", a.setData({
                    list: e
                }), app.util.request({
                    url: "entry/wxapp/Qiangdanwc",
                    data: {
                        id: o,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        "company" == n && a.getYuangonggspdlist(), "mine" == n && a.getYuangongqdlist(), 
                        "complete" == n && a.getYuangongddwclist();
                    }
                }));
            }
        });
    },
    onLoad: function(t) {
        var a = this, e = t.come;
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
        }), a.setData({
            come: e
        }), "company" == e && (wx.setNavigationBarTitle({
            title: "公司派单"
        }), a.getYuangonggspdlist()), "mine" == e && (wx.setNavigationBarTitle({
            title: "我的抢单"
        }), a.getYuangongqdlist()), "complete" == e && (wx.setNavigationBarTitle({
            title: "已完成的订单"
        }), a.getYuangongddwclist());
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "../fa_detail/fa_detail?id=" + t.currentTarget.dataset.id
        });
    },
    getYuangonggspdlist: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Yuangonggspdlist",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            }
        });
    },
    getYuangongqdlist: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Yuangongqdlist",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            }
        });
    },
    getYuangongddwclist: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Yuangongddwclist",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});