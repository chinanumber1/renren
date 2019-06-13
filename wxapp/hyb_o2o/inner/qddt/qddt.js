var app = getApp();

Page({
    data: {
        city: "",
        come: "",
        jin: "",
        ptyg: "",
        index: null,
        index_two: null,
        index_three: null,
        fenlei: [],
        quyu: [],
        jiage: [ "由高到低", "由低到高", "最新发布" ],
        gu_status: !1
    },
    bindfenlei: function(a) {
        var t = this;
        if (t.setData({
            index: a.detail.value
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three]) var n = ""; else n = t.data.jiage[t.data.index_three];
        t.getQddtlist(e, i, n);
    },
    bindQuyu: function(a) {
        var t = this;
        if (t.setData({
            index_two: a.detail.value
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three]) var n = ""; else n = t.data.jiage[t.data.index_three];
        t.getQddtlist(e, i, n);
    },
    bindjiage: function(a) {
        var t = this;
        if (t.setData({
            index_three: a.detail.value
        }), null == t.data.fenlei[t.data.index] || "全部" == t.data.fenlei[t.data.index]) var e = ""; else e = t.data.fenlei[t.data.index];
        if (null == t.data.quyu[t.data.index_two] || "全部" == t.data.quyu[t.data.index_two]) var i = ""; else i = t.data.quyu[t.data.index_two];
        if (null == t.data.jiage[t.data.index_three]) var n = ""; else n = t.data.jiage[t.data.index_three];
        t.getQddtlist(e, i, n);
    },
    qiang: function(a) {
        var n = this, t = wx.getStorageSync("openid"), e = a.currentTarget.dataset.fa_id, i = a.currentTarget.dataset.fa_openid;
        t == i ? wx.showModal({
            title: "提示",
            content: "你是发布者，无抢单权限"
        }) : "1" == n.data.jin ? wx.showToast({
            title: "暂无抢单权限"
        }) : "false" == n.data.ptyg ? wx.showToast({
            title: "暂无抢单权限"
        }) : app.util.request({
            url: "entry/wxapp/Fadanxq",
            data: {
                fa_id: e
            },
            success: function(a) {
                "派单中" == a.data.data.fa_style ? app.util.request({
                    url: "entry/wxapp/Qiangdan",
                    data: {
                        fa_id: e,
                        openid: t,
                        come: n.data.come
                    },
                    success: function(a) {
                        if (null == n.data.fenlei[n.data.index]) var t = ""; else t = n.data.fenlei[n.data.index];
                        if (null == n.data.quyu[n.data.index_two]) var e = ""; else e = n.data.quyu[n.data.index_two];
                        if (null == n.data.jiage[n.data.index_three]) var i = ""; else i = n.data.jiage[n.data.index_three];
                        n.getQddtlist(t, e, i), wx.showToast({
                            title: "抢单成功"
                        });
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "您手速满了，此单已被抢"
                });
            }
        });
    },
    lookdetail: function(a) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/fa_detail/fa_detail?id=" + a.currentTarget.dataset.id
        });
    },
    onLoad: function(a) {
        var t = this;
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
        }), t.setData({
            come: a.come
        }), t.getYuangongxq(), t.getDiqu(), "shangjia" == a.come ? t.getFenleisj() : t.getFenleijs(), 
        t.getQddtlist("", "", "");
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
    getFenleisj: function() {
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
    getFenleijs: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Jsstyleerji",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = [];
                for (var e in t.push("全部"), a.data.data) t.push(a.data.data[e]);
                i.setData({
                    fenlei: t
                });
            }
        });
    },
    getQddtlist: function(a, t, e) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Qddtlist",
            data: {
                city: wx.getStorageSync("city"),
                fenlei: a,
                quyu: t,
                jiage: e,
                openid: wx.getStorageSync("openid"),
                come: i.data.come
            },
            success: function(a) {
                i.setData({
                    list: a.data.data
                });
            }
        });
    },
    open_map: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.list, i = parseFloat(e[t].fa_fwlatitude), n = parseFloat(e[t].fa_fwlongitude);
        wx.openLocation({
            latitude: i,
            longitude: n,
            scale: 28
        });
    },
    getYuangongxq: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Yuangongxq",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = a.data.data.y_jin;
                e.setData({
                    yuangong: a.data.data,
                    jin: t,
                    ptyg: a.data.ptyg
                });
            }
        });
    },
    onShareAppMessage: function() {}
});