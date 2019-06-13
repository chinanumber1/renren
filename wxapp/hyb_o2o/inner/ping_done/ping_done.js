var app = getApp();

Page({
    data: {
        ordersn: "",
        p_id: ""
    },
    onLoad: function(a) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, o = a.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", t), console.log(o, t), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: t
                });
            }
        });
        var t = a.o_id, o = a.p_id;
        this.setData({
            ordersn: t,
            p_id: o
        }), this.getPingjia(t, o);
    },
    getPingjia: function(a, t) {
        var o = this;
        if (null == t) t = "无";
        if (null == a) a = "无";
        app.util.request({
            url: "entry/wxapp/Pingjia",
            data: {
                p_id: t,
                ordersn: a
            },
            success: function(a) {
                o.setData({
                    pingjia: a.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});