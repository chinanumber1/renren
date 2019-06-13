var app = getApp();

function quickSort(e) {
    return function(a, t) {
        var i = a[e];
        return t[e] - i;
    };
}

function quickSort2(i) {
    return function(a, t) {
        return a[i] - t[i];
    };
}

Page({
    data: {
        xt_id: "",
        parentid: "",
        erji: [],
        index1: null,
        index2: null,
        index3: null,
        diqu: null,
        array3: [ "销量高", "价格低" ]
    },
    bindFirstChange: function(a) {
        var i = this;
        this.setData({
            index1: a.detail.value
        });
        var t = i.data.erji[i.data.index1], e = i.data.array3[i.data.index3];
        if ("0" == i.data.parentid) {
            if ("全部" == t || null == t) t = ""; else t = t;
            if ("全部" == (n = i.data.title[i.data.index2]) || null == n) var n = ""; else n = n;
            if (null == e) e = ""; else e = e;
            app.util.request({
                url: "entry/wxapp/Xiangmu",
                data: {
                    xt_id: i.data.xt_id,
                    diqu: t,
                    flname: n,
                    shaixuan: e,
                    city: wx.getStorageSync("city"),
                    parentid: "0"
                },
                success: function(a) {
                    var t = a.data.data;
                    0 < t.length ? wx.getLocation({
                        type: "wgs84",
                        success: function(a) {
                            console.log(a);
                            var l = a.latitude, c = a.longitude;
                            t.map(function(a) {
                                a.juli = 0;
                                var t = l, i = c, e = a.s_wei, n = a.s_jing, u = t * Math.PI / 180, s = e * Math.PI / 180, r = u - s, o = i * Math.PI / 180 - n * Math.PI / 180, d = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(u) * Math.cos(s) * Math.pow(Math.sin(o / 2), 2)));
                                d = Number(d / 1e3).toFixed(2), a.juli = d;
                            }), t.sort(function(a, t) {
                                return a.juli - t.juli;
                            }), i.setData({
                                Xiangmu: t
                            });
                        }
                    }) : i.setData({
                        Xiangmu: a.data.data
                    });
                }
            });
        } else {
            if ("全部" == t || null == t) t = ""; else t = t;
            if (null == e) e = ""; else e = e;
            app.util.request({
                url: "entry/wxapp/Xiangmu",
                data: {
                    xt_id: i.data.xt_id,
                    diqu: t,
                    shaixuan: e,
                    city: wx.getStorageSync("city"),
                    parentid: i.data.parentid
                },
                success: function(a) {
                    var t = a.data.data;
                    0 < t.length ? wx.getLocation({
                        type: "wgs84",
                        success: function(a) {
                            console.log(a);
                            var l = a.latitude, c = a.longitude;
                            t.map(function(a) {
                                a.juli = 0;
                                var t = l, i = c, e = a.s_wei, n = a.s_jing, u = t * Math.PI / 180, s = e * Math.PI / 180, r = u - s, o = i * Math.PI / 180 - n * Math.PI / 180, d = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(u) * Math.cos(s) * Math.pow(Math.sin(o / 2), 2)));
                                d = Number(d / 1e3).toFixed(2), a.juli = d;
                            }), t.sort(function(a, t) {
                                return a.juli - t.juli;
                            }), i.setData({
                                Xiangmu: t
                            });
                        }
                    }) : i.setData({
                        Xiangmu: a.data.data
                    });
                }
            });
        }
    },
    bindSecChange: function(a) {
        var i = this;
        i.setData({
            index2: a.detail.value
        });
        var t = i.data.erji[i.data.index1], e = i.data.title[i.data.index2], n = i.data.array3[i.data.index3];
        if ("0" == i.data.parentid) {
            if ("全部" == t || null == t) t = ""; else t = t;
            if ("全部" == e || null == e) e = ""; else e = e;
            if (null == n) n = ""; else n = n;
            app.util.request({
                url: "entry/wxapp/Xiangmu",
                data: {
                    xt_id: i.data.xt_id,
                    diqu: t,
                    flname: e,
                    shaixuan: n,
                    city: wx.getStorageSync("city"),
                    parentid: "0"
                },
                success: function(a) {
                    var t = a.data.data;
                    0 < t.length ? wx.getLocation({
                        type: "wgs84",
                        success: function(a) {
                            console.log(a);
                            var l = a.latitude, c = a.longitude;
                            t.map(function(a) {
                                a.juli = 0;
                                var t = l, i = c, e = a.s_wei, n = a.s_jing, u = t * Math.PI / 180, s = e * Math.PI / 180, r = u - s, o = i * Math.PI / 180 - n * Math.PI / 180, d = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(u) * Math.cos(s) * Math.pow(Math.sin(o / 2), 2)));
                                d = Number(d / 1e3).toFixed(2), a.juli = d;
                            }), t.sort(function(a, t) {
                                return a.juli - t.juli;
                            }), i.setData({
                                Xiangmu: t
                            });
                        }
                    }) : i.setData({
                        Xiangmu: a.data.data
                    });
                }
            });
        }
    },
    bindThreeChange: function(i) {
        var e = this;
        this.setData({
            index3: i.detail.value
        });
        var a = e.data.erji[e.data.index1], t = e.data.title[e.data.index2], n = e.data.array3[e.data.index3];
        if ("0" == e.data.parentid) {
            if ("全部" == a || null == a) a = ""; else a = a;
            if ("全部" == t || null == t) t = ""; else t = t;
            if (null == n) n = ""; else n = n;
            app.util.request({
                url: "entry/wxapp/Xiangmu",
                data: {
                    xt_id: e.data.xt_id,
                    diqu: a,
                    flname: t,
                    shaixuan: n,
                    city: wx.getStorageSync("city"),
                    parentid: "0"
                },
                success: function(a) {
                    var t = a.data.data;
                    0 < t.length ? wx.getLocation({
                        type: "wgs84",
                        success: function(a) {
                            console.log(a);
                            var l = a.latitude, c = a.longitude;
                            t.map(function(a) {
                                a.juli = 0;
                                var t = l, i = c, e = a.s_wei, n = a.s_jing, u = t * Math.PI / 180, s = e * Math.PI / 180, r = u - s, o = i * Math.PI / 180 - n * Math.PI / 180, d = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(u) * Math.cos(s) * Math.pow(Math.sin(o / 2), 2)));
                                d = Number(d / 1e3).toFixed(2), a.juli = d;
                            }), t.sort(function(a, t) {
                                return a.juli - t.juli;
                            }), 0 == i.detail.value ? e.setData({
                                Xiangmu: t.sort(quickSort("xiadancount"))
                            }) : e.setData({
                                Xiangmu: t.sort(quickSort2("x_jiage"))
                            });
                        }
                    }) : e.setData({
                        Xiangmu: a.data.data
                    });
                }
            });
        } else {
            if ("全部" == a || null == a) a = ""; else a = a;
            if (null == n) n = ""; else n = n;
            app.util.request({
                url: "entry/wxapp/Xiangmu",
                data: {
                    xt_id: e.data.xt_id,
                    diqu: a,
                    shaixuan: n,
                    city: wx.getStorageSync("city"),
                    parentid: e.data.parentid
                },
                success: function(a) {
                    var t = a.data.data;
                    0 < t.length ? wx.getLocation({
                        type: "wgs84",
                        success: function(a) {
                            console.log(a);
                            var l = a.latitude, c = a.longitude;
                            t.map(function(a) {
                                a.juli = 0;
                                var t = l, i = c, e = a.s_wei, n = a.s_jing, u = t * Math.PI / 180, s = e * Math.PI / 180, r = u - s, o = i * Math.PI / 180 - n * Math.PI / 180, d = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(u) * Math.cos(s) * Math.pow(Math.sin(o / 2), 2)));
                                d = Number(d / 1e3).toFixed(2), a.juli = d;
                            }), t.sort(function(a, t) {
                                return a.juli - t.juli;
                            }), 0 == i.detail.value ? e.setData({
                                Xiangmu: t.sort(quickSort("xiadancount"))
                            }) : e.setData({
                                Xiangmu: t.sort(quickSort2("x_jiage"))
                            });
                        }
                    }) : e.setData({
                        Xiangmu: a.data.data
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        var t = a.xt_id, i = a.parentid;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, i = a.data.data.qjbcolor;
                wx.setStorageSync("color", i), wx.setStorageSync("bcolor", t), console.log(i, t), 
                wx.setNavigationBarColor({
                    frontColor: i,
                    backgroundColor: t
                });
            }
        }), this.setData({
            xt_id: t,
            parentid: i
        });
        var e = wx.getStorageSync("city");
        this.getXiangmu(t, i, e), this.getDiqy(e), 0 == i && this.getFenlei(t);
    },
    getXiangmu: function(a, t, i) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Xiangmu",
            data: {
                xt_id: a,
                city: i,
                diqu: "",
                flname: "",
                shaixuan: "",
                parentid: t
            },
            success: function(a) {
                var t = a.data.data;
                0 < t.length ? wx.getLocation({
                    type: "wgs84",
                    success: function(a) {
                        console.log(a);
                        var l = a.latitude, c = a.longitude;
                        t.map(function(a) {
                            a.juli = 0;
                            var t = l, i = c, e = a.s_wei, n = a.s_jing, u = t * Math.PI / 180, s = e * Math.PI / 180, r = u - s, o = i * Math.PI / 180 - n * Math.PI / 180, d = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(u) * Math.cos(s) * Math.pow(Math.sin(o / 2), 2)));
                            d = Number(d / 1e3).toFixed(2), a.juli = d;
                        }), t.sort(function(a, t) {
                            return a.juli - t.juli;
                        }), e.setData({
                            Xiangmu: t
                        });
                    }
                }) : e.setData({
                    Xiangmu: a.data.data
                });
            }
        });
    },
    getDiqy: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Diqu",
            data: {
                city: a
            },
            success: function(a) {
                var t = [];
                for (var i in t.push("全部"), a.data.data) t.push(a.data.data[i].name);
                e.setData({
                    erji: t
                });
            }
        });
    },
    getFenlei: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Fenlei",
            data: {
                xt_id: a
            },
            success: function(a) {
                var t = [];
                for (var i in t.push("全部"), a.data.data) t.push(a.data.data[i].xt_name);
                e.setData({
                    title: t
                });
            }
        });
    },
    onShareAppMessage: function() {}
});