var app = getApp();

Page({
    data: {
        f_parentid: "0",
        location: "定位中...",
        search: "",
        sheng: "",
        mb_index: "",
        toutiao: [],
        getUseInfo: !1
    },
    getmore_fenlei: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/all_type/all_type"
        });
    },
    getUsetInfo: function(t) {
        "getUserInfo:ok" == t.detail.errMsg ? (this.close_modal(), wx.setStorage({
            key: "useInfo",
            data: "true"
        }), this.getGetUid(t.detail.userInfo)) : this.setData({
            getUseInfo: !0
        });
    },
    close_modal: function() {
        this.setData({
            getUseInfo: !1
        });
    },
    link_tiaozhuan: function(t) {
        var a = t.currentTarget.dataset.xt_id;
        wx.navigateTo({
            url: "/hyb_o2o/service_list/service_list?xt_id=" + a
        });
    },
    link_tiaozhuan2: function(t) {
        var a = t.currentTarget.dataset.xt_id, e = t.currentTarget.dataset.parentid;
        wx.navigateTo({
            url: "/hyb_o2o/inner/nav_list/nav_list?xt_id=" + a + "&parentid=" + e
        });
    },
    link_fabu: function(t) {
        console.log(t.currentTarget.dataset);
        var a = t.currentTarget.dataset.f_name, e = t.currentTarget.dataset.xt_name, o = t.currentTarget.dataset.xt_tzej;
        "" == e ? wx.navigateTo({
            url: "/hyb_o2o/inner/fb_types/fb_types"
        }) : wx.navigateTo({
            url: "/hyb_o2o/fabu/fabu?f_name=" + a + "&xt_name=" + e + "&xt_id=" + o
        });
    },
    chooseCity: function(t) {
        "1" == t.currentTarget.dataset.city_type && wx.navigateTo({
            url: "../switchcity/switchcity"
        });
    },
    formsubmit: function(t) {
        wx.navigateTo({
            url: "../inner/search_list/search_list?value=" + t.detail.value.search
        });
    },
    confirm: function(t) {
        wx.navigateTo({
            url: "../inner/search_list/search_list?sheng=" + this.data.sheng + "&value=" + t.detail.value
        });
    },
    sm: function() {
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
                        });
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
    getmore_goods: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/sc/sc"
        });
    },
    lookAd: function(t) {
        wx.navigateTo({
            url: "../inner/ad/ad?id=" + t.currentTarget.dataset.id
        });
    },
    getmore: function() {
        wx.navigateTo({
            url: "../inner/store_list/store_list"
        });
    },
    getmore_servers: function() {
        wx.navigateTo({
            url: "/hyb_o2o/all/all"
        });
    },
    onLoad: function(t) {
        var n = this, a = wx.getStorageSync("openid"), e = t.f_parentid;
        null == e ? n.setData({
            f_parentid: "0"
        }) : n.setData({
            f_parentid: e
        }), "" == wx.getStorageSync("city") ? app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                n.setData({
                    base: t.data.data
                }), console.log(t.data.data.qjcolor), console.log(t.data.data.qjbcolor);
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", a), console.log(e, a), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                }), wx.setNavigationBarTitle({
                    title: t.data.data.name
                });
                var o = t.data.data.baidukey;
                wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        var a = t.longitude, e = t.latitude;
                        t.speed, t.accuracy;
                        wx.request({
                            url: "https://api.map.baidu.com/geocoder/v2/?ak=" + o + "&location=" + e + "," + a + "&output=json",
                            data: {},
                            header: {
                                "Content-Type": "application/json"
                            },
                            success: function(t) {
                                console.log(t.data.result.location), app.globalData.lat = t.data.result.location.lat, 
                                app.globalData.lon = t.data.result.location.lng;
                                var a = t.data.result.addressComponent.city;
                                wx.setStorageSync("city", t.data.result.addressComponent.city), n.setData({
                                    city: a
                                }), n.getShowshangjia(), n.getShowshangping(), n.getShowfuwu();
                            }
                        });
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                n.setData({
                    city: wx.getStorageSync("city"),
                    base: t.data.data
                });
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                console.log(e, a), wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                }), wx.setNavigationBarTitle({
                    title: t.data.data.name
                }), n.getShowshangjia(), n.getShowshangping(), n.getShowfuwu();
            }
        }), console.log(a), "" == a ? (console.log("此为openID"), n.setData({
            getUseInfo: !0
        })) : app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: a
            },
            success: function(t) {
                console.log(t.data.data), 0 == t.data.data ? n.setData({
                    getUseInfo: !0
                }) : (n.setData({
                    getUseInfo: !1
                }), console.log(a), n.getGetUid(""));
            }
        }), n.refreshLocation(), n.getGonggao(), n.getShowfwstyle();
    },
    onShow: function() {},
    refreshLocation: function() {
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.longitude, e = t.latitude;
                console.log(a), console.log(e), app.util.request({
                    url: "entry/wxapp/refreshLocaltion",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        lat: t.latitude,
                        lon: t.longitude
                    }
                });
            }
        });
    },
    getShowfuwu: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Showfuwu",
            data: {
                city: wx.getStorageSync("city")
            },
            success: function(t) {
                var a = t.data.data;
                0 < a.length ? wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        console.log(t);
                        var l = t.latitude, d = t.longitude;
                        a.map(function(t) {
                            t.juli = 0;
                            var a = l, e = d, o = t.s_wei, n = t.s_jing, s = a * Math.PI / 180, i = o * Math.PI / 180, r = s - i, u = e * Math.PI / 180 - n * Math.PI / 180, c = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(s) * Math.cos(i) * Math.pow(Math.sin(u / 2), 2)));
                            c = 1e3 < c ? Math.round(c / 1e3) : Number(c / 1e3).toFixed(2), t.juli = Number(c).toFixed(2);
                        }), a.sort(function(t, a) {
                            return t.juli - a.juli;
                        }), e.setData({
                            fuwu: a
                        });
                    }
                }) : e.setData({
                    fuwu: a
                });
            }
        });
    },
    getGetUid: function(o) {
        var n = this;
        console.log(o), wx.login({
            success: function(t) {
                t.code && (wx.setStorageSync("code", t.code), app.util.request({
                    url: "entry/wxapp/GetUid",
                    data: {
                        code: t.code
                    },
                    success: function(e) {
                        e.data.errno || (wx.setStorageSync("openid", e.data.data.openid), wx.setStorageSync("sessionKey", e.data.data.userinfo.session_key), 
                        "" == o ? wx.getUserInfo({
                            success: function(t) {
                                var a = t.userInfo;
                                console.log(a), wx.setStorageSync("userinfo", a), app.util.request({
                                    url: "entry/wxapp/TyMember",
                                    data: {
                                        u_name: a.nickName,
                                        u_thumb: a.avatarUrl,
                                        u_sex: a.gender,
                                        openid: e.data.data.openid
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/Fenxiaoaddxj",
                                    data: {
                                        f_parentid: n.data.f_parentid,
                                        openid: e.data.data.openid,
                                        f_name: o.nickName
                                    }
                                });
                            }
                        }) : (console.log(o), wx.setStorageSync("userinfo", o), app.util.request({
                            url: "entry/wxapp/TyMember",
                            data: {
                                u_name: o.nickName,
                                u_thumb: o.avatarUrl,
                                u_sex: o.gender,
                                openid: e.data.data.openid
                            }
                        }), app.util.request({
                            url: "entry/wxapp/Fenxiaoaddxj",
                            data: {
                                f_parentid: n.data.f_parentid,
                                openid: e.data.data.openid,
                                f_name: o.nickName
                            }
                        })));
                    }
                }));
            }
        });
    },
    getGonggao: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Gonggao",
            success: function(t) {
                a.setData({
                    gonggao: t.data.data
                });
            }
        });
    },
    getShowfwstyle: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Showfwstyle",
            success: function(t) {
                a.setData({
                    xmtype: t.data.data
                });
            }
        });
    },
    getShowshangjia: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Showshangjia",
            data: {
                city: wx.getStorageSync("city")
            },
            success: function(t) {
                var a = t.data.data;
                0 < a.length ? wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        console.log(t);
                        var l = t.latitude, d = t.longitude;
                        a.map(function(t) {
                            t.juli = 0;
                            var a = l, e = d, o = t.wei, n = t.jing, s = a * Math.PI / 180, i = o * Math.PI / 180, r = s - i, u = e * Math.PI / 180 - n * Math.PI / 180, c = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(r / 2), 2) + Math.cos(s) * Math.cos(i) * Math.pow(Math.sin(u / 2), 2)));
                            console.log(c), c = Number(c / 1e3).toFixed(2), t.juli = c;
                        }), a.sort(function(t, a) {
                            return t.juli - a.juli;
                        }), e.setData({
                            shangjia: a
                        });
                    }
                }) : e.setData({
                    shangjia: a
                });
            }
        });
    },
    getShowshangping: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Showshangping",
            data: {
                city: wx.getStorageSync("city")
            },
            success: function(t) {
                a.setData({
                    shangping: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});