var app = getApp();

Page({
    data: {
        useInfo: {
            level: "白银",
            nickName: "",
            avatarUrl: "",
            name: "",
            age: "0",
            tel: "",
            gender_index: ""
        },
        array: [ "男", "女" ],
        gender_index: null
    },
    check_tel: function(e) {
        if ("" != e.detail.value && !/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(e.detail.value)) {
            wx.showToast({
                title: "电话格式不正确",
                image: "/hyb_o2o/resource/images/error.png"
            });
            var a = this.data.useInfo;
            a.tel = "", this.setData({
                useInfo: a
            });
        }
    },
    bindPickerChange: function(e) {
        this.data.useInfo;
        this.setData({
            gender_index: e.detail.value
        });
    },
    formSubmit: function(e) {
        var a = e.detail.value;
        "" == a.u_username ? wx.showToast({
            title: "请输入姓名",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.u_phone ? wx.showToast({
            title: "请输入电话",
            image: "/hyb_o2o/resource/images/error.png"
        }) : /^1[3|4|5|7|8][0-9]\d{4,8}$/.test(a.u_phone) ? "" == a.u_sex ? wx.showToast({
            title: "请选择性别",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "0" == a.u_age ? wx.showToast({
            title: "请输入正确的年龄",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Userinfo",
            data: {
                openid: wx.getStorageSync("openid"),
                u_age: a.u_age,
                u_phone: a.u_phone,
                u_sex: a.u_sex,
                u_username: a.u_username
            },
            success: function(e) {
                wx.showToast({
                    title: "保存成功"
                }), setTimeout(function() {
                    wx.navigateBack();
                }, 1e3);
            }
        }) : wx.showToast({
            title: "手机号错误",
            image: "/hyb_o2o/resource/images/error.png"
        });
    },
    onLoad: function(e) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var a = e.data.data.qjcolor, t = e.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", a), console.log(t, a), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: a
                }), o.setData({
                    copy: e.data.data.md_name
                });
            }
        });
        var a = wx.getStorageSync("openid");
        this.getUser(a);
    },
    getUser: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: e
            },
            success: function(e) {
                if ("男" == e.data.data) var a = 0; else a = 1;
                t.setData({
                    userInfo: e.data.data,
                    gender_index: a
                });
            }
        });
    },
    onShareAppMessage: function() {}
});