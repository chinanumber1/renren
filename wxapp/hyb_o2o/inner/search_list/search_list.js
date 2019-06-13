var app = getApp();

Page({
    onLoad: function(t) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, o = t.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", a), console.log(o, a), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: a
                });
            }
        });
        var a = t.value, o = wx.getStorageSync("city");
        this.getJiansuo(a, o);
    },
    getJiansuo: function(t, a) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Jiansuo",
            data: {
                value: t,
                city: a
            },
            success: function(t) {
                var a = t.data.data;
                0 < a.length ? wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        console.log(t);
                        var l = t.latitude, g = t.longitude;
                        a.map(function(t) {
                            t.juli = 0;
                            var a = l, o = g, e = t.s_wei, n = t.s_jing, s = a * Math.PI / 180, i = e * Math.PI / 180, u = s - i, r = o * Math.PI / 180 - n * Math.PI / 180, c = 12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(u / 2), 2) + Math.cos(s) * Math.cos(i) * Math.pow(Math.sin(r / 2), 2)));
                            c = Number(c / 1e3).toFixed(2), t.juli = c;
                        }), a.sort(function(t, a) {
                            return t.juli - a.juli;
                        }), o.setData({
                            Xiangmu: a
                        });
                    }
                }) : o.setData({
                    Xiangmu: a
                });
            }
        });
    },
    onShareAppMessage: function() {}
});