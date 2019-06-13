var app = getApp();

Page({
    data: {
        fw_pingjia: 5,
        y_id: "",
        id: ""
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
        var e = t.y_id, i = t.id;
        a.setData({
            y_id: e,
            id: i
        });
        var o = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            success: function(t) {
                a.setData({
                    url: t.data,
                    uniacid: o
                });
            }
        });
    },
    choose_fw: function(t) {
        this.setData({
            fw_pingjia: t.currentTarget.dataset.index + 1
        });
    },
    submit: function(t) {
        var a = t.detail.value;
        "" == a.content ? wx.showToast({
            title: "说点什么吧？",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Addpdpingjia",
            data: {
                y_id: this.data.y_id,
                p_content: a.content,
                fw_pingfen: a.fw_pingfen,
                openid: wx.getStorageSync("openid"),
                id: this.data.id
            },
            success: function(t) {
                wx.redirectTo({
                    url: "/hyb_o2o/inner/wdfb/wdfb"
                });
            }
        });
    },
    onShareAppMessage: function() {}
});