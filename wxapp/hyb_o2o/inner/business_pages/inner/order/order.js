Page({
    data: {
        current: 0,
        all: [ {
            dengji: "一级",
            date: "2017-12-12 16:18",
            order_num: "DFdsfa0121454212",
            money: 1e3
        }, {
            dengji: "一级",
            date: "2017-12-12 16:18",
            order_num: "DFdsfa0121454212",
            money: 1e3
        } ],
        w_pay: [],
        payed: [],
        complete: []
    },
    switch_tab: function(o) {
        this.setData({
            current: o.currentTarget.dataset.index
        });
    },
    goback: function() {
        wx.navigateBack();
    },
    onLoad: function(o) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                var n = o.data.data.qjcolor, t = o.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", n), console.log(t, n), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: n
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