var app = getApp();

Page({
    data: {
        currentTab: 0,
        lingqu: !1,
        lingdone: !1,
        copy: "",
        buy_list: [ "https://www.webstrongtech.net/attachment/images/9/2018/05/DgGF44241ZdgFHH9AHqy9G95fw22w2.jpg", "https://www.webstrongtech.net/attachment/images/9/2018/05/DgGF44241ZdgFHH9AHqy9G95fw22w2.jpg", "https://www.webstrongtech.net/attachment/images/9/2018/05/DgGF44241ZdgFHH9AHqy9G95fw22w2.jpg" ],
        bz_status: !1
    },
    disablescroll: function() {},
    lookbaoz: function(t) {
        this.setData({
            bz_status: !0
        });
    },
    backindex: function() {
        wx.reLaunch({
            url: "../../index/index"
        });
    },
    shangjia: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/store_page/store_page?id=" + t.currentTarget.dataset.id
        });
    },
    yuyue: function(t) {
        var a = t.currentTarget.dataset.x_id;
        wx.navigateTo({
            url: "../yuyue/yuyue?x_id=" + a + "&typs=fuwu"
        });
    },
    refill: function() {
        wx.navigateTo({
            url: "../refill_page/refill_page"
        });
    },
    lingqu: function() {
        this.setData({
            lingqu: !0
        });
    },
    close_modal: function() {
        this.setData({
            lingqu: !1,
            bz_status: !1
        });
    },
    lingqu_btn: function(t) {
        var a = t.currentTarget.dataset.y_id;
        app.util.request({
            url: "entry/wxapp/Myyhq",
            data: {
                openid: wx.getStorageSync("openid"),
                x_id: this.data.x_id,
                y_id: a
            }
        }), wx.showToast({
            title: "已领取"
        }), this.setData({
            lingdone: !0
        });
    },
    look_store: function(t) {
        wx.navigateTo({
            url: "../store_page/store_page?id=" + t.currentTarget.dataset.s_id
        });
    },
    mapClick: function() {
        var t = this.data.xmxq, a = t.s_address + t.s_xxaddress;
        wx.openLocation({
            latitude: parseFloat(t.wei),
            longitude: parseFloat(t.jing),
            address: a,
            scale: 22
        });
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    switch_tab: function(t) {
        this.setData({
            currentTab: t.currentTarget.dataset.index
        });
    },
    previewImage: function(t) {
        var a = t.currentTarget.dataset.list, e = t.currentTarget.dataset.index;
        wx.previewImage({
            current: e,
            urls: a
        });
    },
    onLoad: function(t) {
        var a = t.id;
        this.setData({
            x_id: a
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", a), console.log(e, a), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                });
            }
        }), this.getFuwuxq(a);
    },
    getFuwuxq: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Fuwuxq",
            data: {
                x_id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t.data.data), "1" == t.data.data.x_youhuiquanstatus ? a.setData({
                    xmxq: t.data.data,
                    lingdone: t.data.data.lingdone
                }) : a.setData({
                    xmxq: t.data.data
                }), wx.setNavigationBarTitle({
                    title: t.data.data.x_name
                });
            }
        });
    },
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.xmxq.x_name,
            path: "/hyb_o2o/inner/detail/detail?id=" + t.data.x_id,
            imageUrl: t.data.xmxq.x_thumb,
            success: function(t) {
                console.log("转发成功", t);
            },
            fail: function(t) {
                console.log("转发失败", t);
            }
        };
    }
});