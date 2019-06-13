var app = getApp();

Page({
    data: {
        top_list: [ "优惠卷设置", "满减活动" ],
        current: 0,
        yhj_list: [],
        mj_list: [],
        mj: !1,
        yhj: !1,
        date_s: null,
        date_e: null,
        shiyong: [ "会员可使用", "普通用户可使用", "两者均可使用" ],
        y_id: "0"
    },
    switch_top: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index,
            mj: !1,
            yhj: !1
        });
    },
    bindfangwei: function(t) {
        this.setData({
            index_s: t.detail.value
        });
    },
    close: function() {
        this.setData({
            mj: !1,
            yhj: !1
        });
    },
    bindDateChange1: function(t) {
        this.setData({
            date_s: t.detail.value
        });
    },
    bindDateChange2: function(t) {
        this.setData({
            date_e: t.detail.value
        });
    },
    add_mess: function(t) {
        0 == this.data.current ? this.setData({
            yhj: !0,
            y_id: "0",
            youhuiquanxq: ""
        }) : this.setData({
            mj: !0
        });
    },
    del: function(a) {
        var e = this, t = this.data.current, i = a.currentTarget.dataset.id;
        0 == t ? wx.showModal({
            title: "提示",
            content: "确定删除吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Youhuiquandel",
                    data: {
                        id: i
                    },
                    success: function(t) {
                        e.getSjhdyhq();
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "确定删除吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Manjiandel",
                    data: {
                        id: a.currentTarget.dataset.id
                    },
                    success: function(t) {
                        e.getSjhdmanjian();
                    }
                });
            }
        });
    },
    edi: function(t) {
        var n = this, a = t.currentTarget.dataset.id;
        n.setData({
            y_id: a,
            yhj: !0
        }), app.util.request({
            url: "entry/wxapp/Youhuiquanxq",
            data: {
                y_id: a
            },
            success: function(t) {
                var a, e = n.data.shiyong;
                for (var i in e) e[i] == t.data.data.y_yaoqiu && (a = i);
                n.setData({
                    youhuiquanxq: t.data.data,
                    date_s: t.data.data.y_starttime,
                    date_e: t.data.data.y_endtime,
                    index_s: a
                });
            }
        });
    },
    submit_mj: function(t) {
        var a = this, e = this.data.mj_list, i = t.detail.value;
        i.openid = wx.getStorageSync("openid"), "" == t.detail.value.man || "" == t.detail.value.jian ? wx.showToast({
            title: "内容未填写完整",
            image: "/hyb_o2o/resource/images/error.png"
        }) : (e.push({
            man: t.detail.value.man,
            jian: t.detail.value.jian
        }), this.setData({
            mj_list: e
        }), wx.showToast({
            title: "添加成功"
        }), app.util.request({
            url: "entry/wxapp/Manjianadd",
            data: i,
            success: function(t) {
                a.getSjhdmanjian();
            }
        }), this.close());
    },
    submit_yhj: function(a) {
        var e = this;
        this.data.yhj_list;
        "" == a.detail.value.y_money ? wx.showToast({
            title: "请输入金额",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.detail.value.y_shiyong ? wx.showToast({
            title: "请输入适用范围",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.detail.value.y_starttime ? wx.showToast({
            title: "请选择开始日期",
            image: "/hyb_o2o/resource/images/error.png"
        }) : "" == a.detail.value.y_endtime ? wx.showToast({
            title: "请选择结束日期",
            image: "/hyb_o2o/resource/images/error.png"
        }) : (a.detail.value.openid = wx.getStorageSync("openid"), wx.showToast({
            title: "添加成功",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Youhuiquanadd",
                    data: a.detail.value,
                    success: function(t) {
                        e.getSjhdyhq();
                    }
                });
            }
        }), this.close());
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
        wx.getStorageSync("openid");
        wx.setNavigationBarTitle({
            title: "活动设置"
        }), this.getSjhdyhq(), this.getSjhdmanjian();
    },
    getSjhdyhq: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Sjhdyhq",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    yhj_list: t.data.data
                });
            }
        });
    },
    getSjhdmanjian: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Sjhdmanjian",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    mj_list: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});