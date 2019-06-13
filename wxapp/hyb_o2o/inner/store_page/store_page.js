var app = getApp();

Page({
    data: {
        top_list: [ "员工列表", "待审核员工" ],
        current: 0
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.list, e = a.currentTarget.dataset.index;
        wx.previewImage({
            current: e,
            urls: t
        });
    },
    switch_top: function(a) {
        this.setData({
            current: a.currentTarget.dataset.index
        });
    },
    call: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel
        });
    },
    mapClick: function(a) {
        wx.openLocation({
            latitude: parseFloat(a.currentTarget.dataset.lat),
            longitude: parseFloat(a.currentTarget.dataset.loc),
            address: a.currentTarget.dataset.add,
            scale: 22
        });
    },
    xiadan: function(a) {
        wx.navigateTo({
            url: "../detail/detail?id=" + a.currentTarget.dataset.id
        });
    },
    onLoad: function(a) {
        var t = a.id;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.qjcolor, e = a.data.data.qjbcolor;
                wx.setStorageSync("color", e), wx.setStorageSync("bcolor", t), console.log(e, t), 
                wx.setNavigationBarColor({
                    frontColor: e,
                    backgroundColor: t
                });
            }
        }), this.getShangjia(t);
    },
    callphone: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tels
        });
    },
    getShangjia: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Shangjiaxq",
            data: {
                s_id: a
            },
            success: function(a) {
                t.setData({
                    shangjia: a.data.data
                }), wx.setNavigationBarTitle({
                    title: a.data.data.s_name
                });
            }
        });
    },
    onShareAppMessage: function() {}
});