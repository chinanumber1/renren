var app = getApp();

Page({
    data: {
        swiper: {
            imgUrls: []
        },
        share_modal_active: "",
        fwxy: !0,
        f_parentid: "",
        getUseInfo: !1,
        hbStatus: !1
    },
    sy: function(a) {
        wx.navigateTo({
            url: "/hyb_o2o/distribution/symx"
        });
    },
    goIndex: function(a) {
        wx.reLaunch({
            url: "/hyb_o2o/index/index"
        });
    },
    ljyq: function() {
        this.setData({
            share_modal_active: "active"
        });
    },
    shareModalClose: function() {
        this.setData({
            share_modal_active: ""
        });
    },
    mdmfx: function() {
        this.setData({
            share_modal_active: "",
            fwxy: !1
        });
    },
    fxhb: function() {
        this.setData({
            share_modal_active: "",
            hbStatus: !0
        }), this.canvas();
    },
    yczz: function() {
        this.setData({
            fwxy: !0
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
        });
        var e = a.f_parentid;
        null == e ? t.setData({
            f_parentid: 0
        }) : (t.setData({
            f_parentid: e
        }), wx.getStorage({
            key: "useInfos",
            success: function(a) {
                "true" == a.data && t.setData({
                    getUseInfo: !1
                }), t.getGetUid(a.data);
            },
            fail: function(a) {
                t.setData({
                    getUseInfo: !0
                });
            }
        })), t.getUserFenxiao();
    },
    getUsetInfo: function(a) {
        "getUserInfo:ok" == a.detail.errMsg ? (this.close_modal(), wx.setStorage({
            key: "useInfos",
            data: "true"
        }), this.getGetUid(a.detail.userInfo)) : this.setData({
            getUseInfo: !0
        });
    },
    close_modal: function() {
        this.setData({
            getUseInfo: !1
        });
    },
    closezhezhao: function() {
        this.setData({
            hbStatus: !1
        });
    },
    getUserFenxiao: function() {
        var e = this;
        console.log(wx.getStorageSync("openid")), app.util.request({
            url: "entry/wxapp/UserFenxiao",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = e.data.swiper;
                t.imgUrls = a.data.data.fenxiao_thumb, e.setData({
                    UserFenxiao: a.data.data,
                    swiper: t
                }), "待审核" == a.data.data.f_style && wx.showModal({
                    title: "提示",
                    content: "分销商申请审核中",
                    success: function(a) {
                        wx.navigateBack({});
                    }
                }), console.log(a.data.data.fxhbthumb), console.log(a.data.data.yaoqingma), e.setData({
                    fxhbthumb: a.data.data.fxhbthumb,
                    yaoqingma: a.data.data.yaoqingma,
                    name: a.data.data.f_name
                }), e.canvas();
            }
        });
    },
    canvas: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(a) {
                t.setData({
                    windowWidth: a.windowWidth,
                    windowHeight: a.windowHeight
                });
            }
        });
        var n = t.data.windowWidth, s = t.data.windowHeight, a = t.data.fxhbthumb, o = t.data.yaoqingma;
        wx.getImageInfo({
            src: a,
            success: function(a) {
                var e = a.path;
                wx.getImageInfo({
                    src: o,
                    success: function(a) {
                        o = a.path;
                        var t = wx.createCanvasContext("myCanvas");
                        t.drawImage(e, 0, 0, .8 * n, .6 * s), t.setFillStyle("white"), t.setFontSize(20), 
                        t.textBaseline = "middle", t.fillText("邀请你一起赚取佣金", (n - .7 * n) / 2, 50), t.drawImage(o, (.8 * n - .5 * n) / 2, (.6 * s - .5 * n) / 2, .5 * n, .55 * n), 
                        t.setFontSize(16), t.setFillStyle("white"), t.fillText("点击保存该海报", (n - .5 * n) / 2, .55 * s), 
                        t.draw();
                    }
                });
            }
        });
    },
    move: function() {},
    save_img: function(a) {
        var t = this;
        wx.showModal({
            title: "提示",
            content: "是否保存该海报",
            success: function(a) {
                a.confirm && wx.canvasToTempFilePath({
                    canvasId: "myCanvas",
                    success: function(a) {
                        console.log(a.tempFilePath);
                        a.tempFilePath;
                        wx.saveImageToPhotosAlbum({
                            filePath: a.tempFilePath,
                            success: function(a) {
                                wx.showToast({
                                    title: "保存成功"
                                }), t.setData({
                                    hbStatus: !1
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    getGetUid: function(t) {
        var n = this;
        wx.login({
            success: function(a) {
                a.code && app.util.request({
                    url: "entry/wxapp/GetUid",
                    data: {
                        code: a.code
                    },
                    success: function(e) {
                        e.data.errno || (console.log(e.data.data.openid), console.log(t), "true" == t ? wx.getUserInfo({
                            success: function(a) {
                                var t = a.userInfo;
                                console.log(t), app.util.request({
                                    url: "entry/wxapp/TyMember",
                                    data: {
                                        u_name: t.nickName,
                                        u_thumb: t.avatarUrl,
                                        u_sex: t.gender,
                                        openid: e.data.data.openid
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/Fenxiaoaddxj",
                                    data: {
                                        f_parentid: n.data.f_parentid,
                                        openid: e.data.data.openid,
                                        f_name: t.nickName
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/UserFenxiao",
                                    data: {
                                        openid: e.data.data.openid
                                    },
                                    success: function(a) {
                                        var t = n.data.swiper;
                                        t.imgUrls = a.data.data.fenxiao_thumb, n.setData({
                                            UserFenxiao: a.data.data,
                                            swiper: t
                                        }), "待审核" == a.data.data.f_style && wx.showModal({
                                            title: "提示",
                                            content: "分销商申请审核中",
                                            success: function(a) {
                                                wx.navigateBack({});
                                            }
                                        });
                                    }
                                });
                            }
                        }) : (wx.setStorageSync("userinfo", t), app.util.request({
                            url: "entry/wxapp/TyMember",
                            data: {
                                u_name: t.nickName,
                                u_thumb: t.avatarUrl,
                                u_sex: t.gender,
                                openid: e.data.data.openid
                            }
                        }), console.log(t), app.util.request({
                            url: "entry/wxapp/Fenxiaoaddxj",
                            data: {
                                f_parentid: n.data.f_parentid,
                                openid: e.data.data.openid,
                                f_name: t.nickName
                            }
                        }), app.util.request({
                            url: "entry/wxapp/UserFenxiao",
                            data: {
                                openid: e.data.data.openid
                            },
                            success: function(a) {
                                var t = n.data.swiper;
                                t.imgUrls = a.data.data.fenxiao_thumb, n.setData({
                                    UserFenxiao: a.data.data,
                                    swiper: t
                                }), "待审核" == a.data.data.f_style && wx.showModal({
                                    title: "提示",
                                    content: "分销商申请审核中",
                                    success: function(a) {
                                        wx.navigateBack({});
                                    }
                                });
                            }
                        })));
                    }
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.UserFenxiao.f_name + "邀请你一起赚取佣金",
            path: "/hyb_o2o/distribution/yaoqing?f_parentid=" + this.data.UserFenxiao.f_id
        };
    }
});