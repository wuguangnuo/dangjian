/*!
 * Author : Wugn
 * Date : 2018-1-9
 * Copyright : wuguangnuo.cn
 *            & soooo.club
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
});