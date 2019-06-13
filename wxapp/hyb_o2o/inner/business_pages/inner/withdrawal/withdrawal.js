Page({
    data: {
        money: ""
    },
    withdrawal_all: function() {
        this.setData({
            money: ""
        });
    },
    formSubmit: function(o) {
        console.log(o.detail.value);
    },
    goback: function() {
        wx.navigateBack();
    },
    onLoad: function(o) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                var n = o.data.data.qjcolor, a = o.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", n), console.log(a, n), 
                wx.setNavigationBarColor({
                    frontColor: a,
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