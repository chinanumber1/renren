var app = getApp();

Page({
    data: {
        index_i: null,
        userInfo: {},
        y_always: [ {
            name: "我的订单",
            icon: "../resource/images/m_o_icon.png",
            url: "../orders/orders?typs=yonghu"
        }, {
            name: "我的评价",
            icon: "../resource/images/m_p_icon.png",
            url: "/hyb_o2o/inner/wdpj/wdpj"
        }, {
            name: "积分商城",
            icon: "../resource/images/m_s_icon.png",
            url: "/hyb_o2o/inner/jifen_sc/jifen_sc"
        } ],
        mess: [ {
            name: "我的发布",
            icon: "../resource/images/m_f_icon.png",
            url: "/hyb_o2o/inner/wdfb/wdfb"
        }, {
            name: "充值记录",
            icon: "../resource/images/m_jl.png",
            url: "../inner/refill_log/refill_log"
        }, {
            name: "优惠券",
            icon: "../resource/images/m_y_icon.png",
            url: "../inner/youhui/youhui"
        }, {
            name: "会员管理",
            icon: "../resource/images/hyb.png",
            url: "/hyb_o2o/inner/refill_page/refill_page"
        }, {
            name: "地址管理",
            icon: "../resource/images/m_d_icon.png",
            url: "../inner/address/address"
        }, {
            name: "常见问题",
            icon: "../resource/images/m_q_icon.png",
            url: "../inner/question/question"
        }, {
            name: "联系电话",
            icon: "../resource/images/m_lx_icon.png"
        }, {
            name: "联系客服",
            icon: "../resource/images/m_kf_icon.png"
        } ],
        h_mess: [ {
            name: "商家入口",
            icon: "../resource/images/m_sr_icon.png",
            url: "/hyb_o2o/mine_s/mine_s"
        }, {
            name: "员工入口",
            icon: "../resource/images/m_yr_icon.png",
            url: ""
        }, {
            name: "技师入口",
            icon: "../resource/images/m_jr_icon.png",
            url: ""
        } ]
    },
    bangdingtels: function() {
        wx.navigateTo({
            url: "renzheng/renzheng"
        });
    },
    bdtells: function(e) {
        var n = e.detail.value.tells;
        "" == n ? wx.showToast({
            title: "请输入电话",
            image: "/hyb_o2o/resource/images/error.png"
        }) : /^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(n) ? (console.log(n), this.closebdmodal()) : wx.showToast({
            title: "手机号错误",
            image: "../resource/images/error.png"
        });
    },
    switch_ht: function(o) {
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                var n = e.data.data;
                "0" == o.currentTarget.dataset.index && ("0" == n.u_shangjia ? wx.showModal({
                    title: "提示",
                    content: "请先入驻",
                    success: function(e) {
                        e.confirm && wx.navigateTo({
                            url: "/hyb_o2o/inner/in_business/in_business?typs=发布"
                        });
                    }
                }) : "待审核" == n.u_shangjia ? wx.showToast({
                    title: "审核中",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : "已到期" == n.u_shangjiaruzhu ? wx.showModal({
                    title: "提示",
                    content: "商家入驻已到期请前往续费",
                    success: function(e) {
                        e.confirm && wx.navigateTo({
                            url: "/hyb_o2o/inner/refill_detail/refill_detail?come=续费&ts=sj"
                        });
                    }
                }) : wx.navigateTo({
                    url: "/hyb_o2o/mine_s/mine_s"
                })), "1" == o.currentTarget.dataset.index && ("0" != n.u_shangjia && "待审核" != n.u_shangjia ? wx.showToast({
                    title: "您已是商家",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : "true" == n.ptyg ? wx.showToast({
                    title: "您已是平台技师",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : "0" == n.u_yuangong ? wx.showModal({
                    title: "提示",
                    content: "请完善资料",
                    success: function(e) {
                        e.confirm && wx.navigateTo({
                            url: "/hyb_o2o/inner/ygrz/ygrz?come=yg&typs=发布"
                        });
                    }
                }) : "待审核" == n.u_yuangong ? wx.showToast({
                    title: "正在审核中",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : wx.navigateTo({
                    url: "/hyb_o2o/mine_y/mine_y?come=yg"
                })), "2" == o.currentTarget.dataset.index && ("0" != n.u_shangjia && "待审核" != n.u_shangjia ? wx.showToast({
                    title: "您已是商家",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : "false" == n.ptyg ? wx.showToast({
                    title: "您已是商家员工",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : "0" == n.u_yuangong ? wx.showModal({
                    title: "提示",
                    content: "请完善资料",
                    success: function(e) {
                        e.confirm && wx.navigateTo({
                            url: "/hyb_o2o/inner/ygrz/ygrz?come=js&typs=发布"
                        });
                    }
                }) : "待审核" == n.u_yuangong ? wx.showToast({
                    title: "正在审核中",
                    image: "/hyb_o2o/resource/images/error.png"
                }) : "已到期" == n.u_jsrz ? wx.showModal({
                    title: "提示",
                    content: "技师入驻已到期请前往续费",
                    success: function(e) {
                        e.confirm && wx.navigateTo({
                            url: "/hyb_o2o/inner/refill_detail/refill_detail?come=续费&ts=js"
                        });
                    }
                }) : wx.navigateTo({
                    url: "/hyb_o2o/mine_y/mine_y?come=js"
                }));
            }
        });
    },
    link_fabu: function() {
        wx.navigateTo({
            url: "/hyb_o2o/inner/fb_types/fb_types"
        });
    },
    refill: function() {
        wx.navigateTo({
            url: "../inner/refill/refill"
        });
    },
    look_bot4: function(e) {
        var n = e.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: n
        });
    },
    link_sc: function() {
        wx.navigateTo({
            url: "../inner/jifen_sc/jifen_sc"
        });
    },
    onLoad: function(e) {
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                var n = e.data.data.qjcolor, o = e.data.data.qjbcolor;
                wx.setStorageSync("color", o), wx.setStorageSync("bcolor", n), console.log(o, n), 
                wx.setNavigationBarColor({
                    frontColor: o,
                    backgroundColor: n
                });
            }
        }), this.getUser(), this.getBase();
    },
    onShow: function(e) {
        this.getUser(), this.getBase();
    },
    getUser: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/User",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log(e), n.setData({
                    userInfo: e.data.data
                });
            }
        });
    },
    getBase: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Mendian",
            success: function(e) {
                n.setData({
                    base: e.data.data
                });
            }
        });
    },
    tixian: function(e) {
        wx.navigateTo({
            url: "/hyb_o2o/inner/distributor_pages/withdrawal/withdrawal?typs=" + e.currentTarget.dataset.typs
        });
    },
    onShareAppMessage: function() {}
});