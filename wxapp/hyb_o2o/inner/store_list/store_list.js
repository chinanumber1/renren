var app = getApp();

function quickSort(i) {
    return function(a, t) {
        var e = a[i];
        return t[i] - e;
    };
}

Page({
    data: {
        citys: "",
        shangjialist: [],
        erji: [],
        fenlei: [],
        index1: "",
        index2: "",
        index3: "",
        array3: [ "销量高", "评分高" ]
    },
    link_fabu: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/fb_types/fb_types"
        });
    },
    call: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        });
    },
    bindFirstChange: function(a) {
        var t = this;
        if (t.setData({
            index1: a.detail.value
        }), null == (e = t.data.erji[t.data.index1]) || "全部" == e) var e = ""; else e = e;
        if (null == (i = t.data.fenlei[t.data.index2]) || "全部" == i) var i = ""; else i = i;
        if (null == (n = t.data.array3[t.data.index3]) || "全部" == n) var n = ""; else n = n;
        t.getShangjia(e, i, n);
    },
    bindSecChange: function(a) {
        var t = this;
        if (t.setData({
            index2: a.detail.value
        }), null == (e = t.data.erji[t.data.index1]) || "全部" == e) var e = ""; else e = e;
        if (null == (i = t.data.fenlei[t.data.index2]) || "全部" == i) var i = ""; else i = i;
        if (null == (n = t.data.array3[t.data.index3]) || "全部" == n) var n = ""; else n = n;
        t.getShangjia(e, i, n);
    },
    bindThreeChange: function(a) {
        var t = this;
        if (t.setData({
            index3: a.detail.value
        }), null == (e = t.data.erji[t.data.index1]) || "全部" == e) var e = ""; else e = e;
        if (null == (i = t.data.fenlei[t.data.index2]) || "全部" == i) var i = ""; else i = i;
        if (null == (n = t.data.array3[t.data.index3]) || "全部" == n) var n = ""; else n = n;
        t.getShangjia(e, i, n);
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
        });
        var e = wx.getStorageSync("city");
        t.getShangjia("", "", ""), t.getDiqu(e), t.getFenlei();
    },
    getDiqu: function(a) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Diqu",
            data: {
                city: a
            },
            success: function(a) {
                var t = [];
                for (var e in t.push("全部"), a.data.data) t.push(a.data.data[e].name);
                i.setData({
                    erji: t
                });
            }
        });
    },
    getFenlei: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Shangjiastyle",
            success: function(a) {
                var t = [];
                for (var e in t.push("全部"), a.data.data) t.push(a.data.data[e].xt_name);
                i.setData({
                    fenlei: t
                });
            }
        });
    },
    getShangjia: function(a, t, e) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Shangjialist",
            data: {
                diqu: a,
                fenlei: t,
                shaixuan: e,
                city: wx.getStorageSync("city")
            },
            success: function(a) {
                var t = a.data.data;
                0 < t.length ? wx.getLocation({
                    type: "wgs84",
                    success: function(a) {
                        console.log(a);
                        var d = a.latitude, c = a.longitude;
                        t.map(function(a) {
                            a.juli = 0;
                            var t = d, e = c, i = a.wei, n = a.jing, r = t * Math.PI / 180, s = i * Math.PI / 180, l = r - s, u = e * Math.PI / 180 - n * Math.PI / 180, o = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(l / 2), 2) + Math.cos(r) * Math.cos(s) * Math.pow(Math.sin(u / 2), 2)));
                            o = Number(o / 1e3).toFixed(2), a.juli = o;
                        }), t.sort(function(a, t) {
                            return a.juli - t.juli;
                        }), "" != e ? 0 == i.data.index3 ? i.setData({
                            shangjialist: t.sort(quickSort("xiaoliang"))
                        }) : i.setData({
                            shangjialist: t.sort(quickSort("pingfen"))
                        }) : i.setData({
                            shangjialist: t
                        });
                    }
                }) : i.setData({
                    shangjialist: t
                });
            }
        });
    },
    onShareAppMessage: function() {}
});