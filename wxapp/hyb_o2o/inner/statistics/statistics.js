var app = getApp(), wxCharts = require("../../resource/js/wxcharts.js");

Page({
    data: {
        month: [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12" ],
        year: "",
        y_zhou: [],
        x_zhou: [],
        y_zhou_y: [],
        x_zhou_y: [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12" ],
        num: 0,
        money: 50
    },
    bindYear: function(a) {
        this.setData({
            year: a.detail.value
        }), this.getCaiwus();
    },
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "财务统计"
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, e = a.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", t), console.log(e, t), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: t
                });
            }
        });
        var e = new Date(), n = t.data.month, o = e.getMonth() + 1, i = "";
        for (var r in n) parseInt(n[r]) == o && (i = r, t.setData({
            index: i
        }));
        t.setData({
            year: e.getFullYear()
        }), t.getCaiwu(), t.getCaiwus();
    },
    zhexiantu: function(a, t, e, n) {
        try {
            var o = wx.getSystemInfoSync(), i = o.windowWidth, r = .4 * o.windowHeight;
        } catch (a) {
            console.error("系统信息错误");
        }
        new wxCharts({
            canvasId: a,
            type: "line",
            categories: e,
            animation: !0,
            series: [ {
                data: n,
                format: function(a, t) {
                    return a + " 元";
                },
                color: t
            } ],
            xAxis: {
                disableGrid: !0
            },
            yAxis: {},
            width: i,
            height: r,
            dataLabel: !0,
            dataPointShape: !0,
            extra: {
                lineStyle: "curve"
            },
            legend: !1
        });
    },
    getCaiwu: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Caiwu",
            data: {
                openid: wx.getStorageSync("openid"),
                nian: o.data.year
            },
            success: function(a) {
                var t = [], e = [];
                for (var n in a.data.data.tian) t.push(a.data.data.tian[n].time), e.push(a.data.data.tian[n].money);
                o.setData({
                    x_zhou: t,
                    y_zhou: e,
                    num: a.data.data.new.num,
                    money: a.data.data.new.money
                }), o.zhexiantu("lineCanvas", "#F2AA56", o.data.x_zhou, o.data.y_zhou);
            }
        });
    },
    getCaiwus: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Caiwus",
            data: {
                openid: wx.getStorageSync("openid"),
                nian: o.data.year
            },
            success: function(a) {
                var t = [], e = [];
                for (var n in a.data.data) t.push(a.data.data[n].yue), e.push(a.data.data[n].money);
                o.setData({
                    x_zhou_y: t,
                    y_zhou_y: e
                }), o.zhexiantu("lineCanvas2", "#6D5EFA", o.data.x_zhou_y, o.data.y_zhou_y);
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