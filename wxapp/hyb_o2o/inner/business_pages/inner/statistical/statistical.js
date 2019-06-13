Page({
    data: {
        index1: null,
        index2: null,
        index3: null
    },
    bindFirstChange: function(n) {
        this.setData({
            index1: n.detail.value
        });
    },
    bindSecChange: function(n) {
        this.setData({
            index2: n.detail.value
        });
    },
    bindThreeChange: function(n) {
        this.setData({
            index3: n.detail.value
        });
    },
    onLoad: function(n) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(n) {
                var o = n.data.data.qjcolor, t = n.data.data.qjbcolor;
                wx.setStorageSync("color", t), wx.setStorageSync("bcolor", o), console.log(t, o), 
                wx.setNavigationBarColor({
                    frontColor: t,
                    backgroundColor: o
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