var amapFile = require("amap-wx.js"), config = {
    key: "77e598cff8be39e253cad8ef36fb5cdc"
}, app = getApp();

Page({
    data: {
        markers: [],
        distance: "",
        cost: "",
        polyline: [],
        lon: "",
        lat: "",
        key: ""
    },
    onLoad: function(t) {
        console.log(t);
        var o = this, a = t.startlat, e = t.startlon, i = t.endlat, n = t.endlon, s = t.start, c = t.end;
        t.sopenid, t.eopenid;
        o.setData({
            lon: e,
            lat: a,
            markers: [ {
                iconPath: "mapicon_navi_s.png",
                id: 0,
                latitude: a,
                longitude: e,
                width: 23,
                height: 33
            }, {
                iconPath: "mapicon_navi_e.png",
                id: 0,
                latitude: i,
                longitude: n,
                width: 24,
                height: 34
            } ]
        }), app.util.request({
            url: "entry/wxapp/getGaodeKey",
            success: function(t) {
                o.setData({
                    key: t.data.data.gaodexcxkey
                });
            }
        });
        var l = "";
        l = o.data.key ? o.data.key : config.key, console.log(l);
        var p = new amapFile.AMapWX({
            key: l
        });
        p.getStaticmap({
            location: s,
            success: function(t) {},
            fail: function(t) {}
        }), p.getDrivingRoute({
            origin: s,
            destination: c,
            success: function(t) {
                var a = [];
                if (t.paths && t.paths[0] && t.paths[0].steps) for (var e = t.paths[0].steps, i = 0; i < e.length; i++) for (var n = e[i].polyline.split(";"), s = 0; s < n.length; s++) a.push({
                    longitude: parseFloat(n[s].split(",")[0]),
                    latitude: parseFloat(n[s].split(",")[1])
                });
                o.setData({
                    polyline: [ {
                        points: a,
                        color: "#0091ff",
                        width: 6
                    } ]
                }), t.paths[0] && t.paths[0].distance && o.setData({
                    distance: "行程约" + t.paths[0].distance + "米"
                }), t.taxi_cost && o.setData({
                    cost: "打车约" + parseInt(t.taxi_cost) + "元"
                });
            }
        });
    },
    goToCar: function(t) {
        wx.redirectTo({
            url: "../navigation_car/navigation"
        });
    }
});