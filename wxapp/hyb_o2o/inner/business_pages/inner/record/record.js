Page({
    data: {
        mess: [ {
            id: 0,
            date: "2017-12-12",
            time: "15:25",
            record: "300",
            balance: "320"
        }, {
            id: 0,
            date: "2017-12-12",
            time: "15:25",
            record: "300",
            balance: "320"
        }, {
            id: 0,
            date: "2017-12-12",
            time: "15:25",
            record: "300",
            balance: "320"
        } ]
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