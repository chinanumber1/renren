var app = getApp();

Page({
    data: {
        current: 0,
        footer: {
            footdex: 0,
            txtcolor: "#A2A2A2",
            seltxt: "#1BC3B9",
            background: "#fff",
            list: [ {
                url: "../index/index",
                icons: "/hyb_o2o/resource/images/f_1.png",
                selIcon: "/hyb_o2o/resource/images/f_1_sel.png",
                text: "管理"
            }, {
                url: "../order/order",
                icons: "/hyb_o2o/resource/images/f_3.png",
                selIcon: "/hyb_o2o/resource/images/f_3_sel.png",
                text: "订单"
            } ]
        }
    },
    switch_tab: function(e) {
        var t = e.currentTarget.dataset.index;
        this.getSjorder(t), this.setData({
            current: e.currentTarget.dataset.index
        });
    },
    look_detail: function(e) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/order_detail/order_detail?come=sj&&id=" + e.currentTarget.dataset.o_id
        });
    },
    onLoad: function(e) {
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
        }), wx.setNavigationBarTitle({
            title: "商家订单"
        });
        if (this.getSjorder(0), null != e.index) {
            var t = this.data.footer;
            t.footdex = e.index, this.setData({
                footer: t
            });
        }
    },
    getSjorder: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Sjdingdan",
            data: {
                openid: wx.getStorageSync("openid"),
                current: e
            },
            success: function(e) {
                t.setData({
                    Sjdingdan: e.data.data
                });
            }
        });
    },
    cuidan: function(e) {
        var t = e.currentTarget.dataset.o_id;
        app.util.request({
            url: "entry/wxapp/Jiedan",
            data: {
                o_id: t
            },
            success: function(e) {
                wx.navigateTo({
                    url: "/hyb_o2o/inner/business_pages/order/order"
                });
            }
        });
    },
    del_order: function(e) {
        var t = e.currentTarget.dataset.o_id;
        app.util.request({
            url: "entry/wxapp/Orderdel",
            data: {
                o_id: t
            },
            success: function(e) {
                wx.navigateTo({
                    url: "/hyb_o2o/inner/business_pages/order/order"
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