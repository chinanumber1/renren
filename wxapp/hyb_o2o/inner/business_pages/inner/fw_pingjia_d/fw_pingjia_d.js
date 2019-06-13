var app = getApp();

Page({
    data: {
        copy: "",
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            interval: 3e3,
            duration: 500,
            imgUrls: []
        },
        current: null,
        focus: !1,
        reply: ""
    },
    previewImage: function(t) {
        for (var a = [], e = t.currentTarget.dataset.index, i = t.currentTarget.dataset.inde, r = this.data.Sjxmpj, n = 0; n < r.pingjia[i].p_pic.length; n++) a.push(r.pingjia[i].p_pic[n].imgs);
        wx.previewImage({
            current: e,
            urls: a
        });
    },
    click_h: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index,
            focus: !0
        });
    },
    submit: function(t) {
        var a = this.data.current, e = this.data.Sjxmpj;
        console.log(t.detail.value);
        var i = t.detail.value;
        "" == i.reply ? wx.showToast({
            title: "消息不能为空"
        }) : (e.pingjia[a].p_huifu = t.detail.value.reply, this.setData({
            Sjxmpj: e,
            reply: "",
            focus: !1
        }), app.util.request({
            url: "entry/wxapp/AddPjhf",
            data: {
                p_id: e.pingjia[a].p_id,
                openid: wx.getStorageSync("openid"),
                p_huifu: i.reply
            },
            success: function(t) {
                wx.showToast({
                    title: "回复成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/hyb_o2o/inner/business_pages/inner/pj_list/pj_list"
                    });
                }, 1e3);
            }
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
        var a = t.id;
        this.getSjxmpj(a);
    },
    getSjxmpj: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Sjfwpj",
            data: {
                x_id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                var a = e.data.swiper;
                a.imgUrls = t.data.data.x_thumbs, e.setData({
                    Sjxmpj: t.data.data,
                    swiper: a
                }), wx.setNavigationBarTitle({
                    title: t.data.data.x_name + "评价"
                });
            }
        });
    },
    onShareAppMessage: function() {}
});