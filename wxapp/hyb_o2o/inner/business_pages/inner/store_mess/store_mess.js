var app = getApp();

Page({
    data: {
        server_name: "服务",
        tel: "15200000000",
        logo: "/hyb_o2o/resource/images/list_icon_1.png",
        profile: "门店简介",
        uplogo: "",
        s_start: "",
        s_end: "",
        fenxiao: null,
        fxfs: [ "积分", "佣金" ],
        fx_index: 0,
        address: ""
    },
    goback: function() {
        wx.navigateBack();
    },
    open_map: function() {
        var s = this;
        wx.chooseLocation({
            success: function(e) {
                var a = e.latitude, t = e.longitude;
                console.log(a, t), s.setData({
                    address: e.address
                });
            }
        });
    },
    bindTimeChange1: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            s_start: e.detail.value
        });
    },
    bindTimeChange2: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            s_end: e.detail.value
        });
    },
    bindfenx: function(e) {
        this.setData({
            fx_index: e.detail.value
        });
    },
    switchChange: function(e) {
        console.log("switch1 发生 change 事件，携带值为", e.detail.value), this.setData({
            fenxiao: e.detail.value
        });
    },
    check_tel: function(e) {
        "" == e.detail.value || /^1[3|4|5|7|8][0-9]\d{4,8}$/.test(e.detail.value) || (wx.showToast({
            title: "电话格式不正确",
            image: "/hyb_o2o/resource/images/error.png"
        }), this.setData({
            s_telphone: ""
        }));
    },
    uploadImg: function() {
        var t = this, s = t.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + s + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: a,
                    name: "upfile",
                    formData: {},
                    success: function(e) {
                        t.setData({
                            uplogo: e.data
                        });
                    },
                    fail: function(e) {
                        console.log(e);
                    }
                }), t.setData({
                    logo: a
                });
            }
        });
    },
    formSubmit: function(e) {
        var a = e.detail.value;
        if ("" == a.server_name) wx.showToast({
            title: "请填写服务商",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == a.s_telphone) wx.showToast({
            title: "请填写手机号",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if (/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(a.s_telphone)) if ("" == a.s_address) wx.showToast({
            title: "请填写门店地址",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == a.s_xxaddress) wx.showToast({
            title: "请填写门店详细地址",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == a.profile) wx.showToast({
            title: "请填写门店简介",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == a.time1) wx.showToast({
            title: "请填写时间段",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == a.time2) wx.showToast({
            title: "请填写时间段",
            image: "/hyb_o2o/resource/images/error.png"
        }); else if ("" == a.logo) wx.showToast({
            title: "请上传logo",
            image: "/hyb_o2o/resource/images/error.png"
        }); else {
            var t = e.detail.value;
            if (t.fenxiao) {
                if ("积分" == t.fxfs) var s = 1; else if ("佣金" == t.fxfs) s = 2;
            } else s = 0;
            app.util.request({
                url: "entry/wxapp/Sjruzhu",
                data: {
                    openid: wx.getStorageSync("openid"),
                    id: t.id,
                    s_name: t.s_name,
                    s_content: t.s_content,
                    s_telphone: t.s_telphone,
                    s_thumb: t.s_thumb,
                    s_start: t.s_start,
                    s_address: s_address,
                    s_xxaddress: s_xxaddress,
                    s_end: t.s_end,
                    s_fxtype: s
                },
                success: function(e) {
                    wx.showToast({
                        title: "提交成功"
                    }), setTimeout(function() {
                        wx.navigateBack();
                    }, 1e3);
                }
            });
        } else wx.showToast({
            title: "手机号错误",
            image: "../../resource/images/error.png"
        });
    },
    onLoad: function(e) {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Base",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                var a = e.data.data.qjcolor, t = e.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", a), console.log(t, a), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: a
                }), s.setData({
                    base: e.data.data
                }), wx.setNavigationBarTitle({
                    title: e.data.data.md_name
                });
            }
        });
        var a = app.siteInfo.uniacid;
        s.setData({
            uniacid: a
        }), s.getShangjia(), app.util.request({
            url: "entry/wxapp/url",
            success: function(e) {
                s.setData({
                    url: e.data
                });
            }
        });
    },
    getShangjia: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Shangjia",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (0 == e.data.data.s_fxtype) var a = !1; else if (1 == e.data.data.s_fxtype) {
                    a = !0;
                    var t = 0;
                } else if (2 == e.data.data.s_fxtype) a = !0, t = 1;
                s.setData({
                    shangjia: e.data.data,
                    s_start: e.data.data.s_start,
                    s_end: e.data.data.s_end,
                    fenxiao: a,
                    fx_index: t,
                    address: e.data.data.s_address
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});