var app = getApp(), city = require("../../utils/city.js");

Page({
    data: {
        currentCity: "定位中...",
        letterArr: [],
        city1: []
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                var a = t.data.data.qjcolor, e = t.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", a), console.log(e, a), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: a
                });
            }
        });
        var e = wx.getStorageSync("city");
        a.setData({
            currentCity: e
        }), a.getCity();
        var r = city.searchLetter, c = city.cityList(), i = r;
        a.setData({
            city1: c,
            letterArr: i
        });
    },
    getCity: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Remencity",
            success: function(t) {
                a.setData({
                    info: t.data.data
                });
            }
        });
    },
    confirmClick: function(t) {
        var a = t.target.dataset.a_id;
        wx.setStorage({
            key: "city",
            data: a
        });
        var e = new RegExp("[一-龥]+", "g");
        a.search(e) || (wx.setStorageSync("city", t.target.dataset.a_id), wx.reLaunch({
            url: "/hyb_o2o/index/index"
        }));
    },
    anchorClick: function(t) {
        var a = t.currentTarget.dataset.a_id;
        this.setData({
            toView: a
        });
    }
});