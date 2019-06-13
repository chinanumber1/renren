var app = getApp();

Page({
    data: {
        order_default: {
            to_pay: 0,
            to_sent: 2,
            servering: 0
        },
        order_special: {
            to_wait: 1,
            to_pay: 0,
            servering: 0
        }
    },
    goIndex: function(e) {
        wx.reLaunch({
            url: "/hyb_o2o/index/index"
        });
    },
    order_default: function() {
        wx.redirectTo({
            url: "/hyb_o2o/inner/all_type/all_type"
        });
    },
    order_jifen_goods: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/jifen_sc/jifen_sc"
        });
    },
    order_defaul_goods: function() {
        wx.redirectTo({
            url: "/hyb_o2o/inner/sc/sc"
        });
    },
    onLoad: function(e) {
        var t = e.typs;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var t = e.data.data.qjcolor, o = e.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", t), console.log(o, t), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: t
                });
            }
        }), this.setData({
            typs: t
        });
        var o = wx.getStorageSync("openid");
        this.getOrder(o);
    },
    onShow: function() {
        var e = wx.getStorageSync("openid");
        this.getOrder(e);
    },
    getOrder: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Ordernum",
            data: {
                openid: e,
                typs: t.data.typs
            },
            success: function(e) {
                t.setData({
                    list: e.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});