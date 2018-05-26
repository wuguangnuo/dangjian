/*!
 * Author:Wugn
 * Date:2018-1-9
 * Copyright:wuguangnuo.cn
 */

$(function() {
//控制台输出
  console.log("%c My heart is with you.\n","font-size:16px;");

//标题变换
  var OriginTitile = document.title;
  var titleTime;
  document.addEventListener('visibilitychange',
  function() {
    if (document.hidden) {
      document.title = '(●—●)你还会回来吗？' + OriginTitile;
      clearTimeout(titleTime);
    } else {
      document.title = '今天，又是充满希望的一天！' + OriginTitile;
      titleTime = setTimeout(function() {
        document.title = OriginTitile;
      },2000);}
  });

//表单验证
  jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
  }, "不得含有特殊字符");
  jQuery.validator.addMethod("reidcard", function(value, element) {
    return this.optional(element) || /^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/.test(value);
  }, "身份证号格式错误");
  jQuery.validator.addMethod("rephone", function(value, element) {
    return this.optional(element) || /^((1[3-9]{1})+\d{9})$/.test(value);
  }, "手机号格式错误");
  jQuery.validator.addMethod("reprice", function(value, element) {
    return this.optional(element) || /(^[1-9]\d*(\.\d{1,2})?$)|(^0(\.\d{1,2})?$)/.test(value);
  }, "金额格式错误");
  jQuery.validator.addMethod("compareDate", function(value, element) {
    var greater = false;
    if($("#end_date").val() >= $("#start_date").val()){
	  greater = true;
    }return greater;
  }, "结束日期必须大于开始日期");

  $("#login_form").validate({
    errorElement:"font",
    rules:{
      username:{required:true, lettersonly:true},
      password:{required:true}
    }
  });
  $("#forget_form").validate({
    errorElement:"font",
    rules:{
      username:{required:true, lettersonly:true},
      email:{required:true, email:true}
    }
  });
  $("#register_form").validate({
    errorElement:"font",
    rules:{
      username:{required:true, lettersonly:true},
      name:{required:true, lettersonly:true},
      email:{required:true, email:true},
      password:{required:true, minlength:6},
      password2:{required:true, equalTo:"#password"}
    }
  });
  $("#study_form").validate({
    errorElement:"font",
    rules:{
      name:{required:true},
      score:{required:true, digits:true},
      detail:{required:true}
    }
  });
  $("#dangwu_judge_form").validate({
    errorElement:"font",
    rules:{
      name:{required:true},
      start_date:{required:true, dateISO:true},
      end_date:{required:true, dateISO:true, compareDate:true}
    }
  });
  $("#dangwu_election_form").validate({
    errorElement:"font",
    rules:{
      name:{required:true},
      start_date:{required:true, dateISO:true},
      end_date:{required:true, dateISO:true, compareDate:true},
	  vote_num:{required:true, digits:true}
    }
  });
  $("#dangwu_jiaona_form1").validate({
    errorElement:"font",
    rules:{
      real_price:{required:true, reprice:true},
      date:{required:true, dateISO:true}
    }
  });
  $("#manage_user_form").validate({
    errorElement:"font",
    rules:{
      username:{required:true, lettersonly:true},
      name:{required:true},
      email:{required:true, email:true},
      password:{}
    }
  });
  $("#manage_user_form2").validate({
    errorElement:"font",
    rules:{
      username:{required:true, lettersonly:true},
      name:{required:true},
      idcard:{reidcard:true},
      education:{maxlength:32},
      volk:{maxlength:10},
      organization:{maxlength:80},
      price:{reprice:true},
      phone:{rephone:true},
      email:{required:true, email:true},
      address:{maxlength:80}
    }
  });
  $("#manage_dangfei_form").validate({
    errorElement:"font",
    rules:{
      name:{required:true},
      price:{required:true, reprice:true}
    }
  });
  $("#manage_dangfei_form1").validate({
    errorElement:"font",
    rules:{
      real_price:{required:true, reprice:true},
	  price:{required:true, reprice:true},
      date:{required:true, dateISO:true}
    }
  });
  $("#manage_study_form").validate({
    errorElement:"font",
    rules:{
      name:{required:true},
      score:{required:true, digits:true},
      detail:{required:true}
    }
  });
  $("#user_edit_form").validate({
    errorElement:"font",
    rules:{
      username:{required:true, lettersonly:true},
      name:{required:true},
      idcard:{reidcard:true},
      education:{maxlength:32},
      volk:{maxlength:10},
      organization:{maxlength:80},
      phone:{rephone:true},
      email:{required:true, email:true},
      address:{maxlength:80}
    }
  });
  $("#user_pwd_form").validate({
    errorElement:"font",
    rules:{
      old_password:{required:true, required:true},
      password:{required:true, minlength:6},
      password2:{required:true, equalTo:"#password"}
    }
  });
  
  jQuery.extend(jQuery.validator.messages, {
    required:"未输入",
    digits:"必须为整数",
    lettersonly:"不得含有特殊字符",
    equalTo:"两次密码不一致",
    minlength:"密码至少6位"
  });

//日期选择器
  $(".selectData").datepicker({
    autoclose: true,          //自动关闭
    beforeShowDay: $.noop,    //在显示日期之前调用的函数
    calendarWeeks: false,     //是否显示今年是第几周
    clearBtn: true,           //显示清除按钮
    daysOfWeekDisabled: [],   //星期几不可选
    endDate: Infinity,        //日历结束日期
    forceParse: true,         //是否强制转换不符合格式的字符串
    format: 'yyyy-mm-dd',     //日期格式
    keyboardNavigation: true, //是否显示箭头导航
    language: 'zh-CN',        //语言
    minViewMode: 0,           //最小显示等级
    orientation: "auto",      //方向
    rtl: false,               //靠右显示
    startDate: -Infinity,     //日历开始日期
    startView: 0,             //开始显示
    todayBtn: false,          //今天按钮
    todayHighlight: true,     //今天高亮
    weekStart: 1              //星期几是开始
  });
  
//代码高亮初始化
  hljs.initHighlightingOnLoad();
  
//select 适配Android浏览器
  var nua = navigator.userAgent
  var isAndroid = (nua.indexOf("Mozilla/5.0") > -1 && nua.indexOf("Android ") > -1 && nua.indexOf("AppleWebKit") > -1 && nua.indexOf("Chrome") === -1)
  if (isAndroid) {
    $("select.form-control").removeClass("form-control").css("width", "100%")
  }
  
//Bootstrap 弹出框
  $("[data-toggle='popover']").popover();
});