App({
    getUserInfo: function(o) {
        var n = this;
        this.globalData.personInfo ? "function" == typeof o && o(this.globalData.personInfo) : wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(e) {
                        n.globalData.personInfo = e.userInfo, "function" == typeof o && o(n.globalData.personInfo);
                    }
                });
            }
        });
    },
    util: require("/we7/resource/js/util.js"),
    tabBar: {
        color: "#123",
        selectedColor: "#1ba9ba",
        borderStyle: "#1ba9ba",
        backgroundColor: "#fff",
        list: [ {
            pagePath: "/we7/pages/index/index",
            iconPath: "/we7/resource/icon/home.png",
            selectedIconPath: "/we7/resource/icon/homeselect.png",
            text: "首页"
        }, {
            pagePath: "/we7/pages/user/index/index",
            iconPath: "/we7/resource/icon/user.png",
            selectedIconPath: "/we7/resource/icon/userselect.png",
            text: "微擎我的"
        } ]
    },
    globalData: {
        userInfo: null,
        lingqu: !0,
        code: "",
        openId: "",
        unionId: "",
        s_change: !1,
        lat: "",
        lon: ""
    },
    onShareAppMessage: function() {
        return {
            title: this.data.title
        };
    },
    siteInfo: require("siteinfo.js")
});