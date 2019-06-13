var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        status: 0,
        name: "",
        address: "",
        tel: "",
        address_list: [],
        check_num: null,
        region: [ "北京市", "北京市", "通州区" ]
    },
    checked_icon: function(e) {
        for (var t = e.currentTarget.dataset.index, a = this.data.address, d = 0; d < a.length; d++) a[d].d_checked = !1;
        a[t].d_checked = !0, this.setData({
            address: a
        });
        var r = a[t].d_id;
        app.util.request({
            url: "entry/wxapp/Updaddress",
            data: {
                openid: wx.getStorageSync("openid"),
                d_id: r
            },
            success: function(e) {
                wx.navigateBack({});
            }
        });
    },
    init_icon: function() {
        var e = this.data.address;
        e[0].d_checked = !0, this.setData({
            address: e
        });
    },
    change_add: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../add_editor/add_editor?d_id=" + t
        });
    },
    del_add: function(e) {
        var t = this, a = (e.currentTarget.dataset.index, e.currentTarget.dataset.d_id);
        app.util.request({
            url: "entry/wxapp/Addressdel",
            data: {
                d_id: a
            },
            success: function(e) {
                wx.showToast({
                    title: "删除成功"
                }), setTimeout(function() {
                    t.getUseraddress();
                }, 1e3);
            }
        });
    },
    add_address: function() {
        wx.navigateTo({
            url: "../add_editor/add_editor"
        });
    },
    onLoad: function(e) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var t = e.data.data.qjcolor, a = e.data.data.qjbcolor;
                wx.setStorageSync("color", a), wx.setStorageSync("bcolor", t), console.log(a, t), 
                wx.setNavigationBarColor({
                    frontColor: a,
                    backgroundColor: t
                });
            }
        }), wx.setNavigationBarTitle({
            title: "我的地址"
        }), this.getUseraddress();
    },
    onShow: function() {
        this.getUseraddress();
    },
    getUseraddress: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Useraddress",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                t.setData({
                    address: e.data.data
                });
            }
        });
    },
    onReady: function() {}
}, "onShow", function() {
    this.getUseraddress();
}), _defineProperty(_Page, "onShareAppMessage", function() {}), _Page));