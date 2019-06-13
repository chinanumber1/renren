var app = getApp();

Page({
    data: {
        types: "免费预约",
        isaddress: !1,
        address: "",
        location: "",
        tel: "",
        name: "",
        detailInfo: "",
        o_id: "",
        num: 1,
        choose_name: null,
        gui_index: null,
        guige_list: {
            title: "",
            list: []
        }
    },
    choose_gui: function(t) {
        this.setData({
            gui_index: t.currentTarget.dataset.index
        });
    },
    open_map: function() {
        var a = this;
        wx.chooseLocation({
            success: function(t) {
                a.setData({
                    location: t.address
                });
            }
        });
    },
    choose_add: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/address/address?x_id=" + this.data.x_id
        });
    },
    check_tel: function(t) {
        "" == t.detail.value || /^1[3|4|5|7|8][0-9]\d{4,8}$/.test(t.detail.value) ? this.setData({
            tel: t.detail.value
        }) : (wx.showToast({
            title: "电话格式不正确",
            image: "/hyb_o2o/resource/images/error.png"
        }), this.setData({
            tel: ""
        }));
    },
    choose_guige: function() {
        this.setData({
            status: 3
        });
    },
    close_modal: function() {
        this.setData({
            status: 0
        });
    },
    input_name: function(t) {
        this.setData({
            name: t.detail.value
        });
    },
    input_detailInfo: function(t) {
        this.setData({
            detailInfo: t.detail.value
        });
    },
    sub: function() {
        var t = this.data.num;
        (t -= 1) < 1 && (t = 1), this.setData({
            num: t
        });
    },
    add: function() {
        var t = this.data.num;
        t += 1, this.setData({
            num: t
        });
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", a), console.log(e, a), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                });
            }
        }), wx.setNavigationBarTitle({
            title: "商品下单页"
        });
        var e = t.g_id;
        a.setData({
            g_id: e
        }), a.getUser(), a.getShangpingxq(e), a.getAddress();
    },
    getShangpingxq: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shangpingxq",
            data: {
                id: t
            },
            success: function(t) {
                var a = e.data.guige_list;
                a.title = t.data.data.g_guigename, a.list = t.data.data.g_guigecontent, e.setData({
                    shangpingxq: t.data.data,
                    guige_list: a
                });
            }
        });
    },
    getAddress: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Addressonly",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (t.data.data) var a = !0; else a = !1;
                e.setData({
                    mraddress: t.data.data,
                    isaddress: a
                });
            }
        });
    },
    getUser: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    user: t.data.data,
                    name: t.data.data.u_name,
                    tel: t.data.data.u_phone
                });
            }
        });
    },
    formSubmit: function(t) {
        var a = t.detail.value;
        a.openid = wx.getStorageSync("openid"), "" == a.name ? wx.showToast({
            title: "请输入姓名",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.tel ? wx.showToast({
            title: "请输入电话",
            image: "/hyb_o2o/resource/images/error.png"
        }) : /^1[3|4|5|7|8][0-9]\d{4,8}$/.test(a.tel) ? "" == a.location ? wx.showToast({
            title: "请选择地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.fwgg ? wx.showToast({
            title: "请选择商品规格",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.detailInfo ? wx.showToast({
            title: "请输入详细地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Dingdangoods",
            data: a,
            success: function(t) {
                wx.navigateTo({
                    url: "../refill_detail2/refill_detail2?o_id=" + t.data.data
                });
            }
        }) : wx.showToast({
            title: "手机号错误",
            image: "../../resource/images/error.png"
        });
    },
    close_modal_3: function() {
        this.setData({
            status: 0
        });
    },
    onShow: function() {
        this.getAddress();
    },
    onShareAppMessage: function() {}
});