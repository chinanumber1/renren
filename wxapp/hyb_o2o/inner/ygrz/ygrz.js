var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        typs: "",
        openid: "",
        url: "",
        uniacid: "",
        baozhengjin: [ 20, 30 ],
        bzjindex: 0,
        index_one: null,
        shangjia: [],
        index_two: null,
        fenlei_two: [ "10公里", "20公里", "30公里", "40公里", "50公里", "60公里", "70公里", "80公里", "90公里", "100公里", "100~200公里", "200公里以上" ],
        region: [],
        index_r: null,
        index_r2: null,
        display: !1,
        date: "",
        gender: [ {
            name: "男",
            checked: ""
        }, {
            name: "女",
            checked: ""
        } ],
        gender_choose: "男",
        src1: "",
        src2: "",
        zge: "",
        jn: !1,
        jineng: [],
        jineng_list: [],
        choose: !1,
        fwxy: !0
    },
    bindPickerChange_rz: function(e) {
        this.setData({
            bzjindex: e.detail.value
        });
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
    onLoad: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var a = e.data.data.qjcolor, t = e.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", a), console.log(t, a), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: a
                });
            }
        });
        var t = e.typs, n = e.come, i = wx.getStorageSync("openid"), s = app.siteInfo.uniacid;
        a.getBase(), app.util.request({
            url: "entry/wxapp/url",
            success: function(e) {
                a.setData({
                    typs: t,
                    come: n,
                    url: e.data,
                    uniacid: s,
                    openid: i
                });
            }
        }), "发布" == t ? wx.setNavigationBarTitle({
            title: "资料填写"
        }) : "修改" == t && wx.setNavigationBarTitle({
            title: "资料修改"
        }), a.getSjrzsj(), a.getygrzsj(), a.getYgxq();
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                a.setData({
                    base: e.data.data
                }), WxParse.wxParse("article", "html", e.data.data.xieyi, a, 5);
            }
        });
    },
    getSjrzsj: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Jsrzsj",
            success: function(e) {
                console.log(e.data.data);
                for (var a = e.data.data, t = [], n = 0; n < a.length; n++) t.push(a[n].r_content);
                i.setData({
                    rz: e.data.data,
                    array: t
                });
            }
        });
    },
    getygrzsj: function() {
        var c = this;
        app.util.request({
            url: "entry/wxapp/Ygrzsj",
            data: {
                city: wx.getStorageSync("city")
            },
            success: function(e) {
                for (var a = e.data.data.shangjia, t = [], n = 0; n < a.length; n++) t.push(a[n].s_name);
                var i = e.data.data.jineng, s = [];
                for (n = 0; n < i.length; n++) s.push({
                    name: i[n].xt_name,
                    sel: !1
                });
                var o = e.data.data.diqu, r = [];
                for (n = 0; n < o.length; n++) r.push(o[n].name);
                c.setData({
                    shangjia: t,
                    jineng_list: s,
                    region: r
                });
            }
        });
    },
    getYgxq: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/Yuangongxq",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (0 != e.data.data) {
                    for (var a = e.data.data, t = l.data.index_one, n = l.data.index_two, i = l.data.shangjia, s = (l.data.fenlei_two, 
                    0); s < i.length; s++) i[s] == a.s_name && (t = s);
                    for (s = 0; s < i.length; s++) i[s] == a.s_name && (n = s);
                    for (var o = l.data.gender, r = 0; r < o.length; r++) o[r].name == a.y_sex && (o[r].checked = !0);
                    var c = l.data.region, u = l.data.index_r, d = l.data.index_r2;
                    for (r = 0; r < c.length; r++) c[r] == e.data.data.y_fwqy[0] && (u = r), c[r] == e.data.data.y_fwqy[1] && (d = r);
                    l.setData({
                        index_one: t,
                        index_two: n,
                        gender: o,
                        index_r: u,
                        index_r2: d,
                        gender_choose: e.data.data.y_sex,
                        jineng: e.data.data.y_jineng,
                        yuangong: e.data.data,
                        src1: e.data.data.y_imgpath1,
                        src2: e.data.data.y_imgpath2,
                        zge: e.data.data.y_zgeimg
                    });
                }
            }
        });
    },
    formSubmit_jn: function(e) {
        var a = this.data.jineng_list, t = [];
        for (var n in a) a[n].sel && t.push(a[n].name);
        this.setData({
            jineng: t,
            jn: !1
        });
    },
    bindfenlei_one: function(e) {
        this.setData({
            index_one: e.detail.value
        });
    },
    bindfenlei_two: function(e) {
        this.setData({
            index_two: e.detail.value
        });
    },
    bindRegionChange: function(e) {
        null != this.data.index_r2 && e.detail.value == this.data.index_r2 ? wx.showToast({
            title: "已被选择哦",
            image: "../../resource/images/error.png"
        }) : this.setData({
            index_r: e.detail.value
        });
    },
    bindRegionChange2: function(e) {
        null != this.data.index_r && e.detail.value == this.data.index_r ? wx.showToast({
            title: "已被选择哦",
            image: "../../resource/images/error.png"
        }) : this.setData({
            index_r2: e.detail.value
        });
    },
    bindDateChange: function(e) {
        this.setData({
            date: e.detail.value
        });
    },
    radioChange: function(e) {
        this.setData({
            gender_choose: e.detail.value
        });
    },
    uploadImg1: function() {
        var t = this, n = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + n + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: a,
                    name: "upfile",
                    formData: {},
                    success: function(e) {
                        t.setData({
                            src1: e.data
                        });
                    }
                });
            }
        });
    },
    uploadImg2: function() {
        var t = this, n = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + n + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: a,
                    name: "upfile",
                    formData: {},
                    success: function(e) {
                        t.setData({
                            src2: e.data
                        });
                    }
                });
            }
        });
    },
    uploadImg3: function() {
        var t = this, n = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + n + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: a,
                    name: "upfile",
                    formData: {},
                    success: function(e) {
                        t.setData({
                            zge: e.data
                        });
                    }
                });
            }
        });
    },
    delPic: function(e) {
        var a = this;
        wx.showModal({
            title: "提示",
            content: "是否删除该图片",
            success: function(e) {
                e.confirm && a.setData({
                    src1: ""
                });
            }
        });
    },
    delPic2: function(e) {
        var a = this;
        wx.showModal({
            title: "提示",
            content: "是否删除该图片",
            success: function(e) {
                e.confirm && a.setData({
                    src2: ""
                });
            }
        });
    },
    delPic3: function(e) {
        var a = this;
        wx.showModal({
            title: "提示",
            content: "是否删除该图片",
            success: function(e) {
                e.confirm && a.setData({
                    zge: ""
                });
            }
        });
    },
    confirmClick: function(e) {
        this.setData({
            jn: !0
        });
    },
    choose_jineng: function(e) {
        var a = e.currentTarget.dataset.index, t = this.data.jineng_list;
        t[a].sel = !t[a].sel, this.setData({
            jineng_list: t
        });
    },
    formSubmit: function(e) {
        var a = this, t = e.detail.formId, n = e.detail.value;
        console.log(n);
        var i = [];
        1 < a.data.region.length ? (i.push(n.address1), i.push(n.address2)) : i.push(n.address1), 
        n.form_id = t, n.come = a.data.come, "" == n.merchant && "yg" == n.come ? wx.showToast({
            title: "请选择所属商家",
            image: "../../resource/images/error.png"
        }) : "" == n.name ? wx.showToast({
            title: "请填写姓名",
            image: "../../resource/images/error.png"
        }) : "" == n.gender ? wx.showToast({
            title: "请选择性别",
            image: "../../resource/images/error.png"
        }) : "" == n.age ? wx.showToast({
            title: "请输入年龄",
            image: "../../resource/images/error.png"
        }) : a.data.jineng.length < 1 ? wx.showToast({
            title: "请选择技能",
            image: "../../resource/images/error.png"
        }) : 0 == i.length ? wx.showToast({
            title: "请选择服务地区",
            image: "../../resource/images/error.png"
        }) : "" == n.distance ? wx.showToast({
            title: "请选择接单公里数",
            image: "../../resource/images/error.png"
        }) : "" == n.telphone ? wx.showToast({
            title: "请填写手机号",
            image: "../../resource/images/error.png"
        }) : 11 != n.telphone.length ? wx.showToast({
            title: "手机号格式错误",
            image: "../../resource/images/error.png"
        }) : /^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(n.telphone) ? "" == n.IDcard1 ? wx.showToast({
            title: "请上传身份证",
            image: "../../resource/images/error.png"
        }) : "" == n.IDcard2 ? wx.showToast({
            title: "请上传身份证",
            image: "../../resource/images/error.png"
        }) : "" == n.zgeimg ? wx.showToast({
            title: "请上传资格证",
            image: "../../resource/images/error.png"
        }) : a.data.choose ? (n.jinneng = a.data.jineng, n.fwqy = i, console.log(n), "js" == a.data.come ? "发布" == a.data.typs ? "0" == n.rz_money ? app.util.request({
            url: "entry/wxapp/Yuangongzhuce",
            data: n,
            success: function(e) {
                wx.showToast({
                    title: "请等待审核"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            data: {
                openid: n.openid,
                money: n.rz_money
            },
            header: {
                "Content-Type": "application/json"
            },
            success: function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {},
                    complete: function(e) {
                        console.log(e), "requestPayment:fail cancel" != e.errMsg && app.util.request({
                            url: "entry/wxapp/Yuangongzhuce",
                            data: n,
                            success: function(e) {
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
            url: "entry/wxapp/Yuangongzhuce",
            data: n,
            success: function(e) {
                wx.showToast({
                    title: "请等待审核"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        }) : app.util.request({
            url: "entry/wxapp/Yuangongzhuce",
            data: n,
            success: function(e) {
                wx.showToast({
                    title: "请等待审核"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/mine/mine"
                    });
                }, 1e3);
            }
        })) : wx.showToast({
            title: "请阅读申请协议",
            image: "../../resource/images/error.png"
        }) : wx.showToast({
            title: "手机号格式错误",
            image: "../../resource/images/error.png"
        });
    },
    onShareAppMessage: function() {}
});