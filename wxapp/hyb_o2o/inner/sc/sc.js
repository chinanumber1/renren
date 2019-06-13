var app = getApp();

Page({
    data: {
        erji: [],
        fenLei: [ "wode" ],
        index1: "",
        index2: "",
        index3: "",
        array3: [ "销量高", "评分高" ],
        xl: !1,
        status: !1,
        choose_fenlei: [],
        currentTab: 0,
        chooseId: null,
        up: !1,
        down: !1
    },
    bind_xiaoliang: function() {
        var t = this;
        t.setData({
            xl: !0,
            up: !1,
            down: !1
        });
        if ("" == t.data.index1) var a = ""; else a = t.data.shangpingstyle[t.data.index1].id;
        if (0 == t.data.up && 0 == t.data.down) var n = "";
        if (1 == t.data.up && 0 == t.data.down) n = "由高到低";
        if (0 == t.data.up && 1 == t.data.down) n = "由低到高";
        app.util.request({
            url: "entry/wxapp/Shangpinglists",
            data: {
                city: wx.getStorageSync("city"),
                xiaoliang: "由高到低",
                fenlei: a,
                shaixuan: n
            },
            success: function(a) {
                t.setData({
                    shangpinglist: a.data.data
                });
            }
        });
    },
    bindFirstChange: function(a) {
        var t = this;
        if (t.setData({
            index1: a.detail.value
        }), 0 == t.data.xl) var n = ""; else n = "由高到低";
        if ("" == t.data.index1) var e = ""; else e = t.data.shangpingstyle[t.data.index1].id;
        if (0 == t.data.up && 0 == t.data.down) var i = "";
        if (1 == t.data.up && 0 == t.data.down) i = "由高到低";
        if (0 == t.data.up && 1 == t.data.down) i = "由低到高";
        app.util.request({
            url: "entry/wxapp/Shangpinglists",
            data: {
                city: wx.getStorageSync("city"),
                xiaoliang: n,
                fenlei: e,
                shaixuan: i
            },
            success: function(a) {
                t.setData({
                    shangpinglist: a.data.data
                });
            }
        });
    },
    choose_up: function() {
        var t = this;
        t.setData({
            up: !0,
            down: !1,
            xl: !1
        });
        if ("" == t.data.index1) var a = ""; else a = t.data.shangpingstyle[t.data.index1].id;
        if (0 == t.data.up && 0 == t.data.down) var n = "";
        if (1 == t.data.up && 0 == t.data.down) n = "由高到低";
        if (0 == t.data.up && 1 == t.data.down) n = "由低到高";
        app.util.request({
            url: "entry/wxapp/Shangpinglists",
            data: {
                city: wx.getStorageSync("city"),
                xiaoliang: "",
                fenlei: a,
                shaixuan: n
            },
            success: function(a) {
                t.setData({
                    shangpinglist: a.data.data
                });
            }
        });
    },
    choose_down: function() {
        var t = this;
        t.setData({
            up: !1,
            down: !0,
            xl: !1
        });
        if ("" == t.data.index1) var a = ""; else a = t.data.shangpingstyle[t.data.index1].id;
        if (0 == t.data.up && 0 == t.data.down) var n = "";
        if (1 == t.data.up && 0 == t.data.down) n = "由高到低";
        if (0 == t.data.up && 1 == t.data.down) n = "由低到高";
        app.util.request({
            url: "entry/wxapp/Shangpinglists",
            data: {
                city: wx.getStorageSync("city"),
                xiaoliang: "",
                fenlei: a,
                shaixuan: n
            },
            success: function(a) {
                t.setData({
                    shangpinglist: a.data.data
                });
            }
        });
    },
    change_status: function() {
        this.setData({
            status: !this.data.status,
            currentTab: 0
        });
    },
    close_fenlei: function() {
        this.setData({
            status: !1,
            currentTab: 0
        });
    },
    confirm: function(a) {
        this.setData({
            currentTab: a.currentTarget.dataset.index,
            status: !this.data.status
        });
    },
    cancel: function(a) {
        this.setData({
            currentTab: a.currentTarget.dataset.index,
            status: !this.data.status
        });
    },
    chooseItem: function(a) {
        var t = this.data.choose_fenlei, n = a.currentTarget.dataset.id;
        t[n] || (t[n] = {}), t[n].name = a.detail.value, this.setData({
            choose_fenlei: t,
            chooseId: n
        }), console.log(t);
    },
    onLoad: function(a) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, n = a.data.data.qjbcolor;
                wx.setStorageSync("color", n), wx.setStorageSync("bcolor", t), console.log(n, t), 
                wx.setNavigationBarColor({
                    frontColor: n,
                    backgroundColor: t
                });
            }
        }), this.getShangpingstyle(), this.getShangpinglist(wx.getStorageSync("city"));
    },
    getShangpingstyle: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shangpingstyle",
            success: function(a) {
                var t = [];
                for (var n in a.data.data) t.push(a.data.data[n].title);
                e.setData({
                    shangpingstyle: a.data.data,
                    fenLei: t
                });
            }
        });
    },
    getShangpinglist: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Shangpinglist",
            data: {
                city: a
            },
            success: function(a) {
                t.setData({
                    shangpinglist: a.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});