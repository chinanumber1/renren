/**
 * Created by Administrator on 2017/11/6 0006.
 */
window.onload = function () {
  var mubans = [
    {
      id: 0,
      names: "首页",
      muban: [
        {id: 0, names: "index1", src: "../images/img/index1.png"},
        {id: 1, names: "index2", src: "../images/img/index2.png"},
        {id: 1, names: "index2", src: "../images/img/index2.png"},
        {id: 2, names: "index3", src: "../images/img/index3.png"}
      ]
    }, {
      id: 1,
      names: "知识",
      muban: [
        {id: 0, names: "knowledge1", src: "../images/img/knowledge1.png"},
        {id: 1, names: "knowledge2", src: "../images/img/knowledge2.png"},
        {id: 1, names: "knowledge2", src: "../images/img/knowledge2.png"},
        {id: 2, names: "knowledge3", src: "../images/img/knowledge3.png"}
      ]
    }, {
      id: 2,
      names: "服务",
      muban: [
        {id: 0, names: "server1", src: "../images/img/server1.png"},
        {id: 1, names: "server2", src: "../images/img/server2.png"},
        {id: 1, names: "server2", src: "../images/img/server2.png"},
        {id: 2, names: "server3", src: "../images/img/server3.png"}
      ]
    }, {
      id: 2,
      names: "样式",
      muban: [
        {id: 0, names: "style1", src: "../images/img/style1.png"},
        {id: 1, names: "style2", src: "../images/img/style2.png"},
        {id: 1, names: "style2", src: "../images/img/style2.png"},
        {id: 2, names: "style3", src: "../images/img/style3.png"}
      ]
    }, {
      id: 2,
      names: "会员中心",
      muban: [
        {id: 0, names: "vip1", src: "../images/img/vip1.png"},
        {id: 1, names: "vip2", src: "../images/img/vip2.png"},
        {id: 1, names: "vip2", src: "../images/img/vip2.png"},
        {id: 2, names: "vip3", src: "../images/img/vip3.png"}
      ]
    }
  ];
};
$("#muban div span").on("click",function(){
  $(this).parent().prev().children("input").attr("checked","true");
  $(this).parent().prev().children("i").addClass("bac");
  $(this).parent().parent().addClass("der");
  $(this).parent().parent().parent().siblings().children().removeClass("der");
  $(this).parent().parent().parent().siblings().children().children("div.muban-radio").children("i").removeClass("bac");
  $(this).parent().parent().parent().parent().siblings().children().children().removeClass("der");
  $(this).parent().parent().parent().parent().siblings().children().children().children("div.muban-radio").children("i").removeClass("bac");
  var values=$(this).parent().prev().children("input").val();
  //console.log(values);
  $.ajax({
    type:"GET",
    data:values,
    url:"",
    success:function(data){
      //console.log(data);
    }
  })
});