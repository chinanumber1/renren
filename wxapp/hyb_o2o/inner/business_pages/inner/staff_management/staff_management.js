Page({
    data: {
        status: 0,
        list: [],
        num: null,
        name: "",
        tel: "",
        erweima: ""
    },
    xiugai: function(t) {
        var a = this.data.list, e = t.currentTarget.dataset.index;
        this.setData({
            status: 1,
            name: a[e].name,
            tel: a[e].tel,
            num: e
        });
    },
    goback: function() {
        wx.navigateBack();
    },
    add: function() {
        this.setData({
            status: 1,
            num: null,
            name: "",
            tel: ""
        });
    },
    look_erweima: function(t) {
        for (var a = t.currentTarget.dataset.index, e = this.data.list, o = 0; o < e.length; o++) e[o].see_erweima = !1;
        e[a].see_erweima = !0, this.setData({
            list: e,
            erweima: e[a].erweima
        });
    },
    close_modal: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.list;
        e[a].see_erweima = !1, this.setData({
            list: e,
            erweima: ""
        });
    },
    formSubmit: function(t) {
        console.log(t.detail.value);
        var a = this.data.num;
        console.log(a);
        var e = this.data.list;
        "" == t.detail.value.name && "" == t.detail.value.tel ? wx.showToast({
            title: "信息不全",
            image: "/pages/resource/images/error.png"
        }) : "" == t.detail.value.tel || /^1[3|4|5|7|8][0-9]\d{4,8}$/.test(t.detail.value.tel) ? (null !== a ? e[a] = t.detail.value : e.push(t.detail.value), 
        this.setData({
            list: e,
            status: 0
        })) : (wx.showToast({
            title: "电话格式不正确",
            image: "/pages/resource/images/error.png"
        }), this.setData({
            tel: ""
        }));
    },
    onLoad: function(t) {
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
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});