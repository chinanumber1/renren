var app = getApp();

Page({
    data: {
        d_id: "",
        title: "",
        name: "",
        address: "",
        tel: "",
        check_num: null,
        region: [ "北京市", "北京市", "通州区" ]
    },
    check_tel: function(e) {
        "" == e.detail.value || /^1[3|4|5|7|8][0-9]\d{4,8}$/.test(e.detail.value) || (wx.showToast({
            title: "电话格式不正确",
            image: "/hyb_o2o/resource/images/error.png"
        }), this.setData({
            tel: ""
        }));
    },
    bindRegionChange: function(e) {
        this.setData({
            region: e.detail.value
        });
    },
    choose_address: function() {
        var a = this;
        wx.chooseAddress({
            success: function(e) {
                a.setData({
                    name: e.userName,
                    tel: e.telNumber,
                    region: [ e.provinceName, e.cityName, e.countyName ],
                    address: e.detailInfo
                });
            }
        });
    },
    formSubmit1: function(e) {
        var a = this;
        if ("" != e.detail.value.name && "" != e.detail.value.tel && "" != e.detail.value.address) if (/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(e.detail.value.tel)) {
            var t = e.detail.value;
            t.checked = !1, app.util.request({
                url: "entry/wxapp/Address",
                data: {
                    openid: wx.getStorageSync("openid"),
                    d_address: t.region,
                    d_xxaddress: t.address,
                    d_uname: t.name,
                    d_phone: t.tel,
                    d_id: a.data.d_id
                },
                success: function(e) {
                    null == a.data.d_id ? wx.showToast({
                        title: "添加成功"
                    }) : wx.showToast({
                        title: "修改成功"
                    }), setTimeout(function() {
                        wx.navigateBack();
                    }, 1e3);
                }
            });
        } else wx.showToast({
            title: "手机号错误",
            image: "/hyb_o2o/resource/images/error.png"
        }); else wx.showToast({
            title: "信息不全哦",
            image: "/hyb_o2o/resource/images/error.png"
        });
    },
    onLoad: function(e) {
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
        }), wx.setNavigationBarTitle({
            title: "地址详情"
        });
        var a = e.d_id;
        this.setData({
            d_id: a
        }), a && this.getaddress(a);
    },
    getaddress: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Useraddressxq",
            data: {
                d_id: e
            },
            success: function(e) {
                a.setData({
                    name: e.data.data.d_uname,
                    tel: e.data.data.d_phone,
                    region: e.data.data.d_address.split("-"),
                    address: e.data.data.d_xxaddress
                });
            }
        });
    },
    onShareAppMessage: function() {}
});