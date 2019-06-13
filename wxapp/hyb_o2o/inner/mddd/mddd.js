var app = getApp();

Page({
    data: {
        switch_list: [ "未派单", "已派单" ],
        currentTab: 0,
        index: null,
        index_two: null,
        index_three: null,
        fenlei: [],
        quyu: [],
        jiage: [ "由高到低", "由低到高", "最新发布" ],
        baojiahide: !0,
        baojiaid: "0",
        q_id: "0"
    },
    baojiabtn: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            baojiahide: !1,
            baojiaid: t
        });
    },
    hidebaojiamodal: function() {
        this.setData({
            baojiahide: !0
        });
    },
    baojia: function(a) {
        var t = a.currentTarget.dataset.fa_id, e = a.currentTarget.dataset.q_id;
        this.setData({
            baojiahide: !1,
            baojiaid: t,
            q_id: e
        });
    },
    baojiaform: function(a) {
        var t = this, e = a.detail.value.bjmoney, i = a.detail.value.baojiaid, d = a.detail.value.q_id;
        "" == e ? wx.showToast({
            title: "价钱不能为空",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/PaidanBaojia",
            data: {
                id: i,
                q_id: d,
                money: e
            },
            success: function(a) {
                t.setData({
                    baojiahide: !0
                }), t.getDpqdlist(t.data.currentTab, "", "", "");
            }
        });
    },
    switch_top: function(a) {
        var t = this;
        if (t.setData({
            currentTab: a.currentTarget.dataset.index
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three] || "全部" == t.data.jiage[t.data.index_three]) var d = ""; else d = t.data.jiage[t.data.index_three];
        t.getDpqdlist(t.data.currentTab, e, i, d);
    },
    tel: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        });
    },
    bindfenlei: function(a) {
        var t = this;
        if (t.setData({
            index: a.detail.value
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three] || "全部" == t.data.jiage[t.data.index_three]) var d = ""; else d = t.data.jiage[t.data.index_three];
        t.getDpqdlist(t.data.currentTab, e, i, d);
    },
    bindQuyu: function(a) {
        var t = this;
        if (t.setData({
            index_two: a.detail.value
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three] || "全部" == t.data.jiage[t.data.index_three]) var d = ""; else d = t.data.jiage[t.data.index_three];
        t.getDpqdlist(t.data.currentTab, e, i, d);
    },
    bindjiage: function(a) {
        var t = this;
        if (t.setData({
            index_three: a.detail.value
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three] || "全部" == t.data.jiage[t.data.index_three]) var d = ""; else d = t.data.jiage[t.data.index_three];
        t.getDpqdlist(t.data.currentTab, e, i, d);
    },
    zhipai: function(a) {
        var t = a.currentTarget.dataset.fa_id;
        wx.navigateTo({
            url: "../yglb/yglb?come=zhipai&id=" + t
        });
    },
    lookdetail: function(a) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/fa_detail/fa_detail?id=" + a.currentTarget.dataset.id
        });
    },
    surefw: function(a) {
        var t = this, e = a.currentTarget.dataset.q_id, i = a.currentTarget.dataset.fa_id, d = a.currentTarget.dataset.fa_fwpay_type;
        wx.showModal({
            title: "提示",
            content: "确定开始服务吗?",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/Qiangdanfwsj",
                    data: {
                        id: e,
                        fa_fwpay_type: d,
                        fa_id: i
                    },
                    success: function(a) {
                        t.getDpqdlist(t.data.currentTab, "", "", "");
                    }
                });
            }
        });
    },
    onLoad: function(a) {
        wx.setNavigationBarTitle({
            title: "我的抢单"
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, e = a.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", t), console.log(e, t), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: t
                });
            }
        }), this.getDiqu(), this.getFenlei(), this.getDpqdlist(this.data.currentTab, "", "", "");
    },
    onShow: function() {
        this.getDpqdlist(this.data.currentTab, "", "", "");
    },
    getDiqu: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Diqu",
            data: {
                city: wx.getStorageSync("city")
            },
            success: function(a) {
                var t = [];
                for (var e in t.push("全部"), a.data.data) t.push(a.data.data[e].name);
                i.setData({
                    quyu: t
                });
            }
        });
    },
    getFenlei: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Shangjiastyleerji",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = [];
                for (var e in t.push("全部"), a.data.data) t.push(a.data.data[e].xt_name);
                i.setData({
                    fenlei: t
                });
            }
        });
    },
    getDpqdlist: function(a, t, e, i) {
        var d = this;
        app.util.request({
            url: "entry/wxapp/Dpqdlist",
            data: {
                openid: wx.getStorageSync("openid"),
                current: a,
                city: wx.getStorageSync("city"),
                fenlei: t,
                quyu: e,
                jiage: i
            },
            success: function(a) {
                d.setData({
                    list: a.data.data
                });
            }
        });
    },
    call: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        });
    },
    onShareAppMessage: function() {}
});