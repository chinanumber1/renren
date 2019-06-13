var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        bzjindex: 0,
        openid: "",
        index: 0,
        region: [ "河北省", "保定市", "莲池区" ],
        index_r: 0,
        rz: [],
        r_id_arr: "",
        time1: "",
        time2: "",
        address: "",
        upzhizhao: "",
        uplogo: "",
        imglist: [],
        num: 1,
        s_id: "",
        typs: "",
        label: [],
        addLabel: !1,
        label_text: "",
        pingtai: "0",
        choose: !1,
        fwxy: !0,
        upshengfenz2: "",
        upshengfenz: ""
    },
    lookck: function() {
        this.setData({
            fwxy: !1,
            choose: !0
        });
    },
    queren: function() {
        this.setData({
            fwxy: !0
        });
    },
    choose: function() {
        this.data.choose ? this.setData({
            choose: !1
        }) : this.setData({
            choose: !0
        });
    },
    bindlabel: function() {
        this.setData({
            addLabel: !this.data.addLabel
        });
    },
    addlabel: function(a) {
        var e = this.data.label_text, t = this.data.label;
        "" == e ? wx.showToast({
            title: "请添加标签",
            image: "/hyb_o2o/resource/images/error.png"
        }) : t.length < 4 ? (t.push(e), this.setData({
            label: t,
            label_text: ""
        })) : wx.showToast({
            title: "标签太多啦",
            image: "/hyb_o2o/resource/images/error.png"
        });
    },
    sublabel: function(a) {
        var e = a.currentTarget.dataset.index, t = this.data.label;
        t.splice(e, 1), this.setData({
            label: t
        });
    },
    save_label: function(a) {
        var e = this.data.label;
        if (a.currentTarget.dataset.index) e[a.currentTarget.dataset.index] = a.detail.value, 
        this.setData({
            label: e
        }); else {
            var t = a.detail.value;
            this.setData({
                label_text: t
            });
        }
    },
    formSubmit_label: function(a) {
        var e = a.detail.value, t = [];
        for (var s in e) "" != e[s] && t.push(e[s]);
        this.setData({
            label: t,
            label_text: "",
            addLabel: !this.data.addLabel
        });
    },
    bindPickerChange: function(a) {
        this.setData({
            index: a.detail.value
        });
    },
    open_map: function() {
        var s = this;
        wx.chooseLocation({
            success: function(a) {
                var e = a.latitude, t = a.longitude;
                s.setData({
                    address: a.address,
                    lati: e,
                    lon: t
                }), s.dingwei(e, t);
            },
            fail: function(a) {}
        });
    },
    dingwei: function(i, o) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var e = a.data.data.baidukey, t = o, s = i;
                wx.request({
                    url: "https://api.map.baidu.com/geocoder/v2/?ak=" + e + "&location=" + s + "," + t + "&output=json",
                    data: {},
                    header: {
                        "Content-Type": "application/json"
                    },
                    success: function(a) {
                        n.setData({
                            dizhi: a.data.result.addressComponent.city
                        });
                    }
                });
            }
        });
    },
    bindPickerChange_rz: function(a) {
        console.log(a.detail.value), this.setData({
            bzjindex: a.detail.value
        });
    },
    bindRegionChange: function(a) {
        this.setData({
            region: a.detail.value
        });
    },
    bindTimeChange1: function(a) {
        this.setData({
            time1: a.detail.value
        });
    },
    bindTimeChange2: function(a) {
        this.setData({
            time2: a.detail.value
        });
    },
    onLoad: function(a) {
        var i = this, e = a.typs, t = app.siteInfo.uniacid, s = wx.getStorageSync("openid");
        "修改" != e ? app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var e = a.data.data.qjcolor, t = a.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", e), console.log(t, e), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: e
                }), i.setData({
                    base: a.data.data
                }), WxParse.wxParse("article", "html", a.data.data.xieyi, i, 5);
                var s = a.data.data.baidukey;
                wx.getLocation({
                    type: "wgs84",
                    success: function(a) {
                        var e = a.longitude, t = a.latitude;
                        a.speed, a.accuracy;
                        wx.request({
                            url: "https://api.map.baidu.com/geocoder/v2/?ak=" + s + "&location=" + t + "," + e + "&output=json",
                            data: {},
                            header: {
                                "Content-Type": "application/json"
                            },
                            success: function(a) {
                                var e = [];
                                e.push(a.data.result.addressComponent.province), e.push(a.data.result.addressComponent.city), 
                                e.push(a.data.result.addressComponent.district), i.setData({
                                    region: e
                                });
                            }
                        });
                    }
                });
            }
        }) : i.getBase(), wx.setNavigationBarTitle({
            title: "商家入驻信息填写"
        }), app.util.request({
            url: "entry/wxapp/url",
            success: function(a) {
                i.setData({
                    typs: e,
                    url: a.data,
                    uniacid: t,
                    openid: s
                });
            }
        }), i.getSjrzfwstyle(), i.getSjrzsj(), "修改" == e && app.util.request({
            url: "entry/wxapp/Shangjia",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var e = i.data.Sjtype, t = null;
                for (var s in e) e[s] == a.data.data.s_type && (t = s);
                i.setData({
                    s_id: a.data.data.s_id,
                    sjinfo: a.data.data,
                    upshengfenz: a.data.data.s_idcard,
                    upshengfenz2: a.data.data.s_idcard2,
                    uplogo: a.data.data.s_thumb,
                    upzhizhao: a.data.data.s_zhizhao,
                    imglist: a.data.data.s_imgpath,
                    lon: a.data.data.jing,
                    lati: a.data.data.wei,
                    region: a.data.data.s_address.split("-"),
                    time1: a.data.data.s_yingyetime.split("-")[0],
                    time2: a.data.data.s_yingyetime.split("-")[1],
                    index: t,
                    label: a.data.data.label,
                    pingtai: a.data.data.pingtai
                });
            }
        });
    },
    getBase: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var e = a.data.data.qjcolor, t = a.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", e), console.log(t, e), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: e
                }), s.setData({
                    base: a.data.data
                }), WxParse.wxParse("article", "html", a.data.data.xieyi, s, 5);
            }
        });
    },
    getSjrzfwstyle: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Sjrzfwstyle",
            success: function(a) {
                var e = [];
                for (var t in a.data.data) e.push(a.data.data[t].xt_name);
                s.setData({
                    Sjtype: e
                });
            }
        });
    },
    getSjrzsj: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Sjrzsj",
            success: function(a) {
                for (var e = a.data.data, t = [], s = 0; s < e.length; s++) t.push(e[s].r_content);
                i.setData({
                    rz: a.data.data,
                    array: t
                });
            }
        });
    },
    choosePic: function() {
        var t = this;
        wx.chooseImage({
            count: 6 - t.data.imglist.length,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                a.tempFilePaths;
                var e = a.tempFilePaths.length;
                t.uploadDIY(a.tempFilePaths, 0, 0, 0, e);
            }
        });
    },
    uploadDIY: function(a, e, t, s, i) {
        var o = this, n = this, r = n.data.uniacid, d = n.data.imglist;
        wx.uploadFile({
            url: n.data.url + "app/index.php?i=" + r + "&c=entry&a=wxapp&do=Upload&m=hyb_o2o",
            filePath: a[s],
            name: "upfile",
            formData: {},
            success: function(a) {
                e++, d.push(a.data), n.setData({
                    imglist: d
                });
            },
            fail: function(a) {
                t++;
            },
            complete: function() {
                ++s == i ? wx.hideLoading() : o.uploadDIY(a, e, t, s, i);
            }
        });
    },
    delPic: function(a) {
        var t = this, s = a.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "是否删除该图片",
            success: function(a) {
                if (a.confirm) {
                    var e = t.data.imglist;
                    e.splice(s, 1), t.setData({
                        imglist: e
                    });
                }
            }
        });
    },
    uploadImg: function() {
        var t = this, s = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + s + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: e,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        t.setData({
                            uplogo: a.data
                        });
                    }
                });
            }
        });
    },
    uploadImg_zz: function() {
        var t = this, s = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + s + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: e,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        t.setData({
                            upzhizhao: a.data
                        });
                    },
                    fail: function(a) {}
                }), t.setData({
                    upzhizhao: e
                });
            }
        });
    },
    uploadImg_sfz: function() {
        var t = this, s = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + s + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: e,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        t.setData({
                            upshengfenz: a.data
                        });
                    },
                    fail: function(a) {}
                });
            }
        });
    },
    uploadImg_sfz2: function() {
        var t = this, s = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + s + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: e,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        t.setData({
                            upshengfenz2: a.data
                        });
                    },
                    fail: function(a) {}
                });
            }
        });
    },
    formSubmit: function(a) {
        var e = this, t = a.detail.value, s = t.provinceName + "-" + t.cityName + "-" + t.countyName, i = t.time1 + "-" + t.time2;
        console.log(t), "" == t.s_name ? wx.showToast({
            title: "请填写门店名称",
            image: "../../resource/images/error.png"
        }) : "" == t.s_u_name ? wx.showToast({
            title: "请填写负责人",
            image: "../../resource/images/error.png"
        }) : "" == t.s_telphone ? wx.showToast({
            title: "请填写手机号",
            image: "../../resource/images/error.png"
        }) : 11 != t.s_telphone.length ? wx.showToast({
            title: "手机号格式错误",
            image: "../../resource/images/error.png"
        }) : /^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(t.s_telphone) ? "" == t.s_content ? wx.showToast({
            title: "请填写门店简介",
            image: "../../resource/images/error.png"
        }) : "" == t.s_t_name ? wx.showToast({
            title: "请选择所属类别",
            image: "../../resource/images/error.png"
        }) : "" == t.time1 ? wx.showToast({
            title: "请填写营业时间",
            image: "../../resource/images/error.png"
        }) : "" == t.time2 ? wx.showToast({
            title: "请填写营业时间",
            image: "../../resource/images/error.png"
        }) : "" == t.s_address ? wx.showToast({
            title: "请填写详细地址",
            image: "../../resource/images/error.png"
        }) : "" == t.jing ? wx.showToast({
            title: "请选择经度纬度",
            image: "../../resource/images/error.png"
        }) : "" == t.logo ? wx.showToast({
            title: "请上传门店logo",
            image: "../../resource/images/error.png"
        }) : "" == t.zhizhao ? wx.showToast({
            title: "请上传营业执照",
            image: "../../resource/images/error.png"
        }) : "" == t.Idcard || "" == t.Idcard2 ? wx.showToast({
            title: "请上传身份证",
            image: "../../resource/images/error.png"
        }) : e.data.imglist.length < 1 ? wx.showToast({
            title: "请上传幻灯片",
            image: "../../resource/images/error.png"
        }) : 0 == e.data.choose ? wx.showToast({
            title: "请阅读申请协议",
            image: "../../resource/images/error.png"
        }) : (t.label = e.data.label, t.dizhi = e.data.dizhi, console.log(t), "发布" == t.typs ? 0 < e.data.rz.length ? 0 != t.rz_money ? app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                openid: t.openid,
                money: t.rz_money
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/Sjrz",
                            data: {
                                s_name: t.s_name,
                                openid: t.openid,
                                s_u_name: t.s_u_name,
                                s_telphone: t.s_telphone,
                                s_content: t.s_content,
                                s_t_name: t.s_t_name,
                                s_time: i,
                                s_address: s,
                                s_xxaddress: t.s_address,
                                wei: t.wei,
                                jing: t.jing,
                                logo: t.logo,
                                zhizhao: t.zhizhao,
                                imgpath: e.data.imglist,
                                ruzhu_money: t.rz_money,
                                ruzhu_id: t.rz_id,
                                typs: t.typs,
                                label: t.label,
                                Idcard: t.Idcard,
                                Idcard2: t.Idcard2,
                                dizhi: t.dizhi
                            },
                            success: function(a) {
                                wx.showToast({
                                    title: "请等待审核"
                                }), setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/hyb_o2o/mine/mine"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Sjrz",
            data: {
                s_name: t.s_name,
                openid: t.openid,
                s_u_name: t.s_u_name,
                s_telphone: t.s_telphone,
                s_content: t.s_content,
                s_t_name: t.s_t_name,
                s_time: i,
                s_address: s,
                s_xxaddress: t.s_address,
                wei: t.wei,
                jing: t.jing,
                logo: t.logo,
                zhizhao: t.zhizhao,
                imgpath: e.data.imglist,
                ruzhu_money: t.rz_money,
                ruzhu_id: t.rz_id,
                typs: t.typs,
                label: t.label,
                Idcard: t.Idcard,
                Idcard2: t.Idcard2,
                dizhi: t.dizhi
            },
            success: function(a) {
                wx.showToast({
                    title: "请等待审核"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Sjrz",
            data: {
                s_name: t.s_name,
                openid: t.openid,
                s_u_name: t.s_u_name,
                s_telphone: t.s_telphone,
                s_content: t.s_content,
                s_t_name: t.s_t_name,
                s_time: i,
                s_address: s,
                s_xxaddress: t.s_address,
                wei: t.wei,
                jing: t.jing,
                logo: t.logo,
                zhizhao: t.zhizhao,
                imgpath: e.data.imglist,
                ruzhu_money: t.rz_money,
                ruzhu_id: t.rz_id,
                typs: t.typs,
                label: t.label,
                Idcard: t.Idcard,
                Idcard2: t.Idcard2,
                dizhi: t.dizhi
            },
            success: function(a) {
                wx.showToast({
                    title: "请等待审核"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        }) : "修改" == t.typs && app.util.request({
            url: "entry/wxapp/Sjrz",
            data: {
                s_name: t.s_name,
                openid: t.openid,
                s_u_name: t.s_u_name,
                s_telphone: t.s_telphone,
                s_content: t.s_content,
                s_t_name: t.s_t_name,
                s_time: i,
                s_address: s,
                s_xxaddress: t.s_address,
                wei: t.wei,
                jing: t.jing,
                logo: t.logo,
                zhizhao: t.zhizhao,
                imgpath: e.data.imglist,
                ruzhu_money: t.rz_money,
                ruzhu_id: t.rz_id,
                typs: t.typs,
                s_id: t.s_id,
                label: t.label,
                pingtai: t.pingtai,
                Idcard: t.Idcard,
                Idcard2: t.Idcard2,
                dizhi: t.dizhi
            },
            success: function(a) {
                wx.showToast({
                    title: "修改成功"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        })) : wx.showToast({
            title: "手机号格式错误",
            image: "../../resource/images/error.png"
        });
    },
    onShareAppMessage: function() {}
});