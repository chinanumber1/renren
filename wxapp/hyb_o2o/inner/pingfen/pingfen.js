var app = getApp();

Page({
    data: {
        o_id: "",
        x_thumb: "",
        pingjia: 5,
        fw_pingjia: 5,
        yg_pingjia: 5,
        imglist: [],
        img: []
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
        var e = t.o_id, i = t.x_thumb, o = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            success: function(t) {
                a.setData({
                    o_id: e,
                    x_thumb: i,
                    url: t.data,
                    uniacid: o
                });
            }
        });
    },
    choose_s: function(t) {
        this.setData({
            pingjia: t.currentTarget.dataset.index + 1
        });
    },
    choose_fw: function(t) {
        this.setData({
            fw_pingjia: t.currentTarget.dataset.index + 1
        });
    },
    choose_yg: function(t) {
        this.setData({
            yg_pingjia: t.currentTarget.dataset.index + 1
        });
    },
    del: function(a) {
        var e = this.data.img, i = this;
        wx.showModal({
            title: "提示",
            content: "确定删除该图片吗？",
            success: function(t) {
                t.confirm && (e.splice(a.currentTarget.dataset.index, 1), i.setData({
                    img: e
                }));
            }
        });
    },
    submit: function(t) {
        var a = t.detail.value;
        "" == a.content ? wx.showToast({
            title: "说点什么吧？",
            image: "/hyb_o2o/resource/images/error.png"
        }) : app.util.request({
            url: "entry/wxapp/Addfwpingjia",
            data: {
                o_id: this.data.o_id,
                p_content: a.content,
                sp_pingfen: a.sp_pingfen,
                fw_pingfen: a.fw_pingfen,
                p_pic: this.data.imglist,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                wx.redirectTo({
                    url: "/hyb_o2o/inner/order_status/order_status?id=3&typs=yonghu"
                });
            }
        });
    },
    uploadDIY: function(t, a, e, i, o) {
        var n = this, s = this, c = s.data.uniacid, r = s.data.imglist;
        wx.uploadFile({
            url: s.data.url + "app/index.php?i=" + c + "&c=entry&a=wxapp&do=Upload&m=hyb_o2o",
            filePath: t[i],
            name: "upfile",
            formData: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a++, r.push(t.data), s.setData({
                    imglist: r
                });
            },
            fail: function(t) {
                e++;
            },
            complete: function() {
                ++i == o ? wx.hideLoading() : n.uploadDIY(t, a, e, i, o);
            }
        });
    },
    choosePic: function() {
        var e = this;
        wx.chooseImage({
            count: 3 - e.data.imglist.length,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                t.tempFilePaths;
                var a = t.tempFilePaths.length;
                e.uploadDIY(t.tempFilePaths, 0, 0, 0, a), console.log(e.data.imglist);
            }
        });
    },
    onShareAppMessage: function() {}
});