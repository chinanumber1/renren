Component({
    properties: {
        footerindex: {
            type: Number,
            value: 0
        }
    },
    data: {
        footer: {
            md_index: "",
            txtcolor: "#A2A2A2",
            seltxt: "#ef4a51",
            background: "#fff",
            list: [ {
                id: "1",
                ids: "4",
                lianjie: "/hyb_o2o/index/index",
                thumb: "/hyb_o2o/resource/images/f_1_sel.png",
                thumb2: "/hyb_o2o/resource/images/f_1.png",
                title: "首页"
            }, {
                id: "2",
                uniacid: "9",
                lianjie: "/hyb_o2o/inner/all_type/all_type",
                title: "全部分类",
                thumb: "/hyb_o2o/resource/images/f_2_sel.png",
                thumb2: "/hyb_o2o/resource/images/f_2.png"
            }, {
                id: "3",
                uniacid: "9",
                title: "商家",
                lianjie: "/hyb_o2o/inner/store_list/store_list",
                thumb: "/hyb_o2o/resource/images/f_3_sel.png",
                thumb2: "/hyb_o2o/resource/images/f_3.png"
            }, {
                id: "4",
                uniacid: "9",
                title: "个人",
                lianjie: "/hyb_o2o/mine/mine",
                thumb: "/hyb_o2o/resource/images/f_4_sel.png",
                thumb2: "/hyb_o2o/resource/images/f_4.png"
            } ]
        }
    },
    methods: {
        link_fabu: function() {
            wx.navigateTo({
                url: "/hyb_o2o/inner/fb_types/fb_types"
            });
        }
    }
});