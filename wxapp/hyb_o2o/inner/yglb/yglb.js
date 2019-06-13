var app = getApp();

Page({
    data: {
        come: "",
        top_list: [ "员工列表", "待审核员工" ],
        current: 0,
        id: "",
        list: []
    },
    switch_top: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index
        }), 0 == t.currentTarget.dataset.index ? this.getYuangonglist(this.data.come) : this.getYuangongshenhe();
    },
    jinzhijd: function(t) {
        var a = this, e = t.currentTarget.dataset.id, n = t.currentTarget.dataset.index, s = a.data.list;
        0 == s[n].y_jin ? wx.showModal({
            title: "提示",
            content: "是否禁止TA接单",
            success: function(t) {
                t.confirm && (s[n].y_jin = 1, a.setData({
                    list: s
                }), app.util.request({
                    url: "entry/wxapp/Yuangongjz",
                    data: {
                        id: e,
                        jin: "1"
                    }
                }));
            }
        }) : wx.showModal({
            title: "提示",
            content: "是否解除TA禁止接单",
            success: function(t) {
                t.confirm && (s[n].y_jin = 0, a.setData({
                    list: s
                }), app.util.request({
                    url: "entry/wxapp/Yuangongjz",
                    data: {
                        id: e,
                        jin: "0"
                    }
                }));
            }
        });
    },
    tichu: function(t) {
        var a = this, e = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id, s = a.data.list;
        wx.showModal({
            title: "提示",
            content: "是否剔除该员工",
            success: function(t) {
                t.confirm && (s.splice(e, 1), a.setData({
                    list: s
                }), app.util.request({
                    url: "entry/wxapp/Yuangongshenhesc",
                    data: {
                        y_id: n
                    }
                }));
            }
        });
    },
    zhipai: function(t) {
        var a = t.currentTarget.dataset.y_id, e = t.currentTarget.dataset.fa_id;
        wx.showModal({
            title: "提示",
            content: "是否指派该员工",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Paidan",
                    data: {
                        y_id: a,
                        fa_id: e
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "已指派"
                        }), setTimeout(function() {
                            wx.navigateBack({});
                        }, 1e3);
                    }
                });
            }
        });
    },
    choose_fwyg: function(t) {
        var a = this.data.id, e = t.currentTarget.dataset.y_id;
        app.util.request({
            url: "entry/wxapp/Orderfuwurysave",
            data: {
                o_id: a,
                fwyg: e
            },
            success: function(t) {
                wx.showToast({
                    title: "指派成功"
                }), setTimeout(function() {
                    wx.navigateBack({});
                }, 1e3);
            }
        });
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/ygrz_look/ygrz_look?id=" + t.currentTarget.dataset.id
        });
    },
    through: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定通过该申请",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Yuangongshenhesave",
                    data: {
                        y_id: e,
                        typs: "通过"
                    },
                    success: function(t) {
                        a.getYuangongshenhe(wx.getStorageSync("openid"));
                    }
                });
            }
        });
    },
    cancel: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定拒绝该申请，确定将会删除该条数据",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Yuangongshenhesave",
                    data: {
                        y_id: e,
                        typs: "拒绝"
                    },
                    success: function(t) {
                        a.getYuangongshenhe();
                    }
                });
            }
        });
    },
    onLoad: function(t) {
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
        var a = t.come, e = t.id;
        this.setData({
            id: e,
            come: a
        }), this.getYuangonglist(a);
    },
    getYuangonglist: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Yuangonglist",
            data: {
                openid: wx.getStorageSync("openid"),
                come: t,
                o_id: a.data.id
            },
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            }
        });
    },
    getYuangongshenhe: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Yuangongshenhe",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    lists: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});