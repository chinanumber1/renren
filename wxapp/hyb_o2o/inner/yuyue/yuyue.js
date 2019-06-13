var app = getApp();

Page({
    data: {
        types: "免费预约",
        isaddress: !1,
        address: "",
        status: 0,
        location: "",
        tel: "",
        name: "",
        detailInfo: "",
        o_id: "",
        x_id: "",
        yydate: "",
        yytime: "",
        num: 1,
        current: 0,
        cur: null,
        choose_name: null,
        choose_name_id: null,
        gui_index: null,
        clkyuyuetime: "",
        time_switch: "",
        tab_switch: 0,
        scrollleft: 0,
        week: [],
        count: [],
        lsdate: "",
        lstime: ""
    },
    choose_gui: function(t) {
        this.setData({
            gui_index: t.currentTarget.dataset.index
        });
    },
    close_modal_3: function() {
        this.setData({
            status: 0
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
    choose_date: function() {
        this.setData({
            status: 1
        });
    },
    choose_week: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index,
            cur: null
        });
    },
    tabSwitch: function(t) {
        var a = t.currentTarget.dataset.tab_switch;
        switch (console.log(a), a) {
          case 0:
            this.data.scrollleft = 0;
            break;

          case 1:
            this.data.scrollleft = 80;
            break;

          case 2:
            this.data.scrollleft = 170;
            break;

          case 3:
            this.data.scrollleft = 200;
            break;

          case 4:
            this.data.scrollleft = 300;
            break;

          case 5:
            this.data.scrollleft = 350;
            break;

          case 6:
            this.data.scrollleft = 400;
        }
        this.setData({
            tab_switch: a,
            scrollleft: this.data.scrollleft,
            lsdate: this.data.week[a].days
        }), this.gettimes(a);
    },
    gettimes: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getDayTimes",
            data: {
                x_id: a.data.x_id,
                days: a.data.lsdate
            },
            success: function(t) {
                a.setData({
                    count: t.data.data
                });
            }
        }), console.log("************"), console.log(this.data.week[t]), console.log("************");
    },
    bindDateChange: function(t) {
        0 == this.data.clkyuyuetime ? this.setData({
            clkyuyuetime: !0
        }) : this.setData({
            clkyuyuetime: !1
        });
    },
    sureChange: function() {
        this.setData({
            yydate: this.data.lsdate,
            yytime: this.data.lstime
        }), 0 == this.data.clkyuyuetime ? this.setData({
            clkyuyuetime: !0
        }) : this.setData({
            clkyuyuetime: !1
        });
    },
    timeSwitch: function(t) {
        var a = t.currentTarget.dataset.time_switch;
        this.setData({
            time_switch: a,
            lstime: this.data.count[a].time
        });
    },
    sure_choose: function() {
        this.setData({
            status: 0
        });
    },
    choose_peo: function() {
        this.setData({
            status: 2
        });
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
        });
        var e = t.x_id;
        a.setData({
            x_id: e
        }), a.getFuwuxq(e), a.getAddress(), a.getTimes(e);
    },
    getFuwuxq: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Fuwuxq",
            data: {
                x_id: t
            },
            success: function(t) {
                console.log(t.data.data.yuangong), console.log(t.data.data.yuangong.length), a.setData({
                    xmxq: t.data.data
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
    getTimes: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getTimes",
            data: {
                x_id: t
            },
            success: function(t) {
                a.setData({
                    week: t.data.data.week,
                    count: t.data.data.count,
                    lsdate: t.data.data.week[0].days,
                    lstime: t.data.data.count[0].time,
                    yytime: t.data.data.count[0].time,
                    yydate: t.data.data.week[0].days
                });
            }
        });
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.value;
        a.openid = wx.getStorageSync("openid"), 0 == e.data.xmxq.x_guigecontent ? "" == a.name ? wx.showToast({
            title: "请输入姓名",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.tel ? wx.showToast({
            title: "请输入电话",
            image: "/hyb_o2o/resource/images/error.png"
        }) : /^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(a.tel) ? "" == a.location ? wx.showToast({
            title: "请选择地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.detailInfo ? wx.showToast({
            title: "请输入详细地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Dingdanfw",
            data: a,
            success: function(t) {
                var a = t.data.data;
                e.pay(a);
            }
        }) : wx.showToast({
            title: "手机号错误",
            image: "../../resource/images/error.png"
        }) : "" == a.name ? wx.showToast({
            title: "请输入姓名",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.tel ? wx.showToast({
            title: "请输入电话",
            image: "/hyb_o2o/resource/images/error.png"
        }) : /^1[3|4|5|6|7|8][0-9]\d{4,8}$/.test(a.tel) ? "" == a.location ? wx.showToast({
            title: "请选择地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.fwgg ? wx.showToast({
            title: "请选择服务规格",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.detailInfo ? wx.showToast({
            title: "请输入详细地址",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Dingdanfw",
            data: a,
            success: function(t) {
                var a = t.data.data;
                e.pay(a);
            }
        }) : wx.showToast({
            title: "手机号错误",
            image: "../../resource/images/error.png"
        });
    },
    pay: function(t) {
        wx.navigateTo({
            url: "../refill_detail/refill_detail?o_id=" + t + "&come=服务&dd=zf"
        });
    },
    radioChange: function(t) {
        console.log(t.detail), console.log(this.data.xmxq.yuangong);
        var a = this.data.xmxq.yuangong;
        for (var e in a) a[e].y_id == t.detail.value && this.setData({
            status: 0,
            choose_name: a[e].y_name,
            choose_name_id: a[e].y_id
        });
    },
    onShow: function() {
        this.getAddress();
    },
    onShareAppMessage: function() {}
});