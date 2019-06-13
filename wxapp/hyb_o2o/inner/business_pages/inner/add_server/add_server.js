var app = getApp();

function extend(a, t) {
    for (var e in t) a[e] = t[e];
    return a;
}

Page({
    data: {
        tel: "",
        array: [],
        imglist: [],
        imglists: [],
        title: [],
        index: 0,
        er_index: 0,
        er_title: [],
        logo: "",
        uplogo: "",
        x_type: "",
        x_id: null,
        fxfs: [],
        mj_index: 0,
        fenxiao: null,
        hyqy: [ "a", "b" ],
        hyqy_index: 0,
        hyqy_s: null,
        youhuiquan: [],
        yhq_index: 0,
        yhq: null,
        jifen: [],
        jf_index: 0,
        jf: null,
        jf_num: null,
        status: !1,
        guige_name: "",
        addguige: !1,
        guige_list: [],
        label_text: "",
        label_price: "",
        guigeform: !0,
        addguigelist: !0,
        form1: !1,
        bianjiguige: 0,
        closeguideform: !1,
        num: 0,
        openyh: !1,
        looksl: !1,
        shoufei_status: !1,
        shoufei: {},
        items: [ {
            value: "全额付款",
            text: "客户预约时，一次性支付本服务的全部费用。商家承诺，本服务无额外收费。"
        }, {
            value: "定金支付",
            text: "客户预约时，支付本服务的部分费用，因用户原因未服务，定金不予退还，若因为商家原因未服务可退还定金，若服务完成，用户需支付剩余费用。"
        }, {
            value: "上门估价",
            text: "上门费：用户下单时将预付上门费，商家按约定时间上门后，商家可收取上门费。商家可对改服务进行报价，如若客户同意报价，商家可获取新的服务费用。"
        } ],
        charge: "",
        diff: "上门服务"
    },
    pic_remove: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.imglist;
        e.splice(t, 1), this.setData({
            imglist: e
        });
    },
    radioChange: function(a) {
        console.log("radio发生change事件，携带value值为：", a), this.setData({
            charge: a.detail.value
        });
    },
    radioChange2: function(a) {
        var t = this, e = a.detail.value;
        t.data.items;
        "到店服务" == e ? t.setData({
            items: t.data.items2
        }) : t.setData({
            items: t.data.items
        }), t.setData({
            diff: a.detail.value
        });
    },
    edi_shoufei: function() {
        this.setData({
            addguigelist: !1,
            form1: !0
        });
    },
    close_shoufei: function() {
        this.setData({
            shoufei_status: !1
        });
    },
    submit_shoufei: function(a) {
        var t = a.detail.value;
        console.log(t), "" == t.pay_type ? wx.showToast({
            title: "请选择付款方式",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.money ? wx.showToast({
            title: "请填写金额",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.danwei ? wx.showToast({
            title: "请填写单位",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == t.guige_name ? wx.showToast({
            title: "请在服务收费中填写服务规格名",
            image: "/hyb_o2o/resource/images/error.png"
        }) : 0 == this.data.guige_list.length ? wx.showToast({
            title: "请编辑规格",
            image: "/hyb_o2o/resource/images/error.png"
        }) : this.setData({
            shoufei: a.detail.value,
            shoufei_status: !1,
            addguige: !1,
            addguigelist: !0,
            form1: !1
        });
    },
    opensl: function() {
        this.setData({
            looksl: !0
        });
    },
    closesl: function() {
        this.setData({
            looksl: !1
        });
    },
    openyh: function() {
        this.setData({
            openyh: !this.data.openyh
        });
    },
    addlabel: function(a) {
        if ("" == a.detail.value.guigexiang) wx.showToast({
            title: "请添写规格项"
        }); else if ("" == a.detail.value.price) wx.showToast({
            title: "请添写价格"
        }); else {
            var t = this.data.guige_list;
            t.push({
                guigexiang: a.detail.value.guigexiang,
                price: a.detail.value.price
            }), this.setData({
                guige_list: t,
                label_text: "",
                label_price: "",
                closeguideform: !0
            });
        }
    },
    sublabel: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.guige_list;
        e.splice(t, 1), this.setData({
            guige_list: e
        });
    },
    save_label: function(a) {
        var t = this.data.guige_list;
        if (null != a.currentTarget.dataset.index) t[a.currentTarget.dataset.index].guigexiang = a.detail.value, 
        this.setData({
            guige_list: t
        }); else {
            var e = a.detail.value;
            this.setData({
                label_text: e
            });
        }
    },
    save_label2: function(a) {
        var t = this.data.guige_list;
        if (console.log(t), null != a.currentTarget.dataset.index) t[a.currentTarget.dataset.index].price = a.detail.value, 
        this.setData({
            guige_list: t
        }); else {
            var e = a.detail.value;
            this.setData({
                label_price: e
            });
        }
    },
    input_biaoti: function(a) {
        this.setData({
            num: a.detail.value.length
        });
    },
    save_guige_name: function(a) {
        this.setData({
            guige_name: a.detail.value
        });
    },
    input: function(a) {
        this.setData({
            money: a.detail.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3")
        });
    },
    input2: function(a) {
        this.setData({
            money2: a.detail.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3")
        });
    },
    open_addguige: function() {
        this.setData({
            guigeform: !1
        });
    },
    del: function(a) {
        var t = this.data.guige_list;
        t.splice(a.currentTarget.dataset.index, 1), this.setData({
            guige_list: t
        });
    },
    close_addguige: function(a) {
        var t = this.data.guige_list, e = this.data.label_text, i = this.data.label_price;
        if ("" != e && "" != i) {
            var s = {};
            s.guigexiang = e, s.price = i, t.push(s), this.setData({
                guige_list: t,
                addguige: !1,
                guigeform: !0,
                bianjiguige: 1,
                label_text: "",
                label_price: ""
            });
        } else this.setData({
            guigeform: !0
        });
    },
    save_jf: function(a) {
        this.setData({
            jf_num: a.detail.value
        });
    },
    goback: function() {
        wx.navigateBack();
    },
    bindPickerChange: function(a) {
        var t = a.detail.value;
        this.setData({
            index: t
        }), this.getSjfwstyleerji(this.data.title[t]);
    },
    bindPickerChange_er: function(a) {
        this.setData({
            er_index: a.detail.value
        });
    },
    bindfenx: function(a) {
        this.setData({
            mj_index: a.detail.value
        });
    },
    switchhyqy: function(a) {
        1 == a.detail.value && this.setData({
            hyqy_s: !1
        }), this.setData({
            hyqy_s: a.detail.value
        });
    },
    bindyhyqy: function(a) {
        this.setData({
            hyqy_index: a.detail.value
        });
    },
    switchyhq: function(a) {
        1 == a.detail.value && this.setData({
            mj: !1
        }), this.setData({
            yhq: a.detail.value
        });
    },
    bindyhq: function(a) {
        this.setData({
            yhq_index: a.detail.value
        });
    },
    switcmj: function(a) {
        1 == a.detail.value && this.setData({
            yhq: !1
        }), this.setData({
            mj: a.detail.value
        });
    },
    bindjf: function(a) {
        this.setData({
            jf_index: a.detail.value
        });
    },
    switchjf: function(a) {
        this.setData({
            jf: a.detail.value
        });
    },
    uploadImg: function() {
        var e = this, i = e.data.uniacid;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.uploadFile({
                    url: e.data.url + "app/index.php?i=" + i + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
                    filePath: t,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        e.setData({
                            uplogo: a.data
                        });
                    }
                }), e.setData({
                    logo: t
                });
            }
        });
    },
    switchChange: function(a) {
        console.log("switch1 发生 change 事件，携带值为", a.detail.value);
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
        }), 0 == app.globalData.s_change && (app.globalData.s_change = !0), wx.setNavigationBarTitle({
            title: "添加/修改服务"
        });
        var e = a.parent, i = a.xt_name;
        t.setData({
            yiji: e,
            erji: i
        });
        var s = app.siteInfo.uniacid, o = a.id;
        app.util.request({
            url: "entry/wxapp/url",
            success: function(a) {
                t.setData({
                    url: a.data,
                    uniacid: s,
                    x_id: o
                });
            }
        }), t.getSjfwstyleyiji(0), t.getSjfwmanjian(), t.getSjyhq(), o && t.getSjfuwuxq(o);
    },
    getSjfuwuxq: function(a) {
        var s = this;
        console.log(a), app.util.request({
            url: "entry/wxapp/Sjfuwuxq",
            data: {
                x_id: a
            },
            success: function(t) {
                console.log(t.data.data), app.util.request({
                    url: "entry/wxapp/Sjfwstyleerji",
                    data: {
                        yiji: t.data.data.x_yi_type
                    },
                    success: function(a) {
                        s.setData({
                            erji: t.data.data.x_er_type,
                            yiji: t.data.data.x_yi_type
                        });
                    }
                });
                var a, e;
                s.data.title, s.data.er_title;
                a = "0" != t.data.data.x_status, e = 0 != t.data.data.x_jifenstatus, 0 == t.data.data.x_huiyuanstatus ? s.setData({
                    hyqy_s: !1
                }) : s.setData({
                    hyqy_s: !0
                }), 0 == t.data.data.x_manjian ? s.setData({
                    mj: !1
                }) : s.setData({
                    mj: !0
                }), 0 == t.data.data.x_youhuiquanstatus ? s.setData({
                    yhq: !1
                }) : s.setData({
                    yhq: !0
                }), 0 != t.data.data.x_guigecontent.length && 0 != t.data.data.x_guigecontent && s.setData({
                    guige_list: t.data.data.x_guigecontent
                });
                var i = s.data.shoufei;
                i.money = t.data.data.x_jiage, i.guige_name = t.data.data.x_guigename, i.fwlx = t.data.data.x_xingshi, 
                i.danwei = t.data.data.x_danwei, i.pay_type = t.data.data.x_pay_type, i.smfy = t.data.data.x_pay_smgj, 
                i.djzb = t.data.data.x_pay_bili, s.setData({
                    shoufei: i,
                    Sjxm: t.data.data,
                    imglist: t.data.data.x_jianjie_thumb,
                    imglists: t.data.data.x_thumbs,
                    guige_name: t.data.data.x_guigename,
                    diff: t.data.data.x_xingshi,
                    charge: t.data.data.x_pay_type,
                    status: a,
                    jf: e
                });
            }
        });
    },
    getSjfwstyleyiji: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shangjiafwstyle",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = e.data.title;
                t.push(a.data.data.s_type), e.getSjfwstyleerji(a.data.data.s_type), e.setData({
                    title: t
                });
            }
        });
    },
    getSjfwstyleerji: function(a) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Sjfwstyleerji",
            data: {
                yiji: a
            },
            success: function(a) {
                var t = [];
                for (var e in a.data.data) t.push(a.data.data[e].xt_name);
                i.setData({
                    er_title: t,
                    er_index: 0
                });
            }
        });
    },
    getSjfwmanjian: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Sjfwmanjian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = [];
                for (var e in a.data.data) t.push("满" + a.data.data[e].m_money + "减" + a.data.data[e].j_money);
                i.setData({
                    manjians: a.data.data,
                    manjian: t
                });
            }
        });
    },
    getSjyhq: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Sjyhq",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                var t = [];
                for (var e in a.data.data) t.push(a.data.data[e].y_name);
                i.setData({
                    youhuiquans: a.data.data,
                    youhuiquan: t
                });
            }
        });
    },
    uploadDIY: function(a, t, e, i, s) {
        var o = this, n = this, u = n.data.uniacid, l = n.data.imglist;
        wx.uploadFile({
            url: n.data.url + "app/index.php?i=" + u + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
            filePath: a[i],
            name: "upfile",
            formData: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a.data), t++, l.push(a.data), n.setData({
                    imglist: l
                });
            },
            fail: function(a) {
                e++;
            },
            complete: function() {
                ++i == s ? (wx.hideLoading(), console.log("总共" + t + "张上传成功," + e + "张上传失败！")) : o.uploadDIY(a, t, e, i, s);
            }
        });
    },
    uploadDIYs: function(a, t, e, i, s) {
        var o = this, n = this, u = n.data.uniacid, l = n.data.imglists;
        wx.uploadFile({
            url: n.data.url + "app/index.php?i=" + u + "&c=entry&a=wxapp&do=upload&m=hyb_o2o",
            filePath: a[i],
            name: "upfile",
            formData: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a.data), t++, l.push(a.data), n.setData({
                    imglists: l
                });
            },
            fail: function(a) {
                e++;
            },
            complete: function() {
                ++i == s ? (wx.hideLoading(), console.log("总共" + t + "张上传成功," + e + "张上传失败！")) : o.uploadDIYs(a, t, e, i, s);
            }
        });
    },
    choosePic: function() {
        var e = this;
        wx.chooseImage({
            count: 6 - e.data.imglist.length,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                a.tempFilePaths;
                var t = a.tempFilePaths.length;
                e.uploadDIY(a.tempFilePaths, 0, 0, 0, t), console.log(e.data.imglist);
            }
        });
    },
    choosePics: function() {
        var e = this;
        wx.chooseImage({
            count: 6 - e.data.imglists.length,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                a.tempFilePaths;
                var t = a.tempFilePaths.length;
                e.uploadDIYs(a.tempFilePaths, 0, 0, 0, t), console.log(e.data.imglists);
            }
        });
    },
    formSubmit: function(a) {
        var t = this, e = a.detail.value, i = t.data.shoufei;
        console.log(e), e.shoufei = i, e.x_jianjie_thumb = t.data.imglist, e.x_hdp_thumb = t.data.imglists, 
        e.jf = t.data.jf, e.openid = wx.getStorageSync("openid"), e.guige_list = t.data.guige_list, 
        e.lx = "服务", "" == e.server_name ? wx.showToast({
            title: "请填写服务名称",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == e.djzb ? wx.showToast({
            title: "请填写定金占比",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == e.money ? wx.showToast({
            title: "请填写金额",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == e.danwei ? wx.showToast({
            title: "请填写单位",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == this.data.guige_name ? wx.showToast({
            title: "请在服务收费中填写服务规格名",
            icon: "none"
        }) : 1 == e.mj && "" == e.manjian_id ? wx.showToast({
            title: "请选择满减活动",
            image: "/hyb_o2o/resource/images/error.png"
        }) : 1 == e.jf && "" == e.jifen ? wx.showToast({
            title: "请输入积分金额",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "暂无" == e.youhuiquan ? wx.showToast({
            title: "请选择优惠券",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == e.tips ? wx.showToast({
            title: "请填写简述",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == e.wxts ? wx.showToast({
            title: "请填写温馨提示",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == e.logo ? wx.showToast({
            title: "请上传logo",
            image: "/hyb_o2o/resource/images/error.png"
        }) : 0 == e.x_hdp_thumb.length ? wx.showToast({
            title: "请上传服务图片",
            image: "/hyb_o2o/resource/images/error.png"
        }) : (console.log(e), e.danwei = e.shoufei.danwei, e.fwlx = e.shoufei.fwlx, e.guige_name = e.shoufei.guige_name, 
        e.money = e.shoufei.money, e.pay_type = e.shoufei.pay_type, e.djzb = e.shoufei.djzb, 
        e.smfy = e.shoufei.smfy, null == e.djzb && (e.djzb = ""), null == e.smfy && (e.smfy = ""), 
        app.util.request({
            url: "entry/wxapp/Addfw",
            data: e,
            success: function(a) {
                wx.showToast({
                    title: "提交成功"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/hyb_o2o/inner/business_pages/inner/all_server/all_server"
                    });
                }, 1e3);
            }
        }));
    },
    onShareAppMessage: function() {}
});