<?php
session_start();
include("../includes/conn.php");
$dbconn->admin_logincheck();
$adminid=$_SESSION['adminid'];
if($_GET['act']=='del'){
$id=intval($_GET['id']);
$dbconn->noretquery("delete from ".DBQIAN."user_txt where id=$id");
header("Location: user.txt.php?page=$_GET[page]");
};echo '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="css/base.css" rel="stylesheet" type="text/css" />
<link href="css/right.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/jquery.js"></script>
<script>
$(document).ready(function(){
   $(function(){
      $(\'.rightinfo tbody tr:odd\').css("backgroundColor","#f5f8fa");
   });
});
</script>
</head>

<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="index.php">首页</a></li>
    <li>调侃语言</li>
  </ul>
</div>
<div class="rightinfo">
  <div class="tools"> 
    <ul class="toolbar">
      <li><a href="user.txtadd.php"><span><img src="images/t01.png" /></span>添加</a></li> 
    </ul>
  </div>
  <table class="tablelist">
    <thead>
      <tr>
        <th width="81%">内容</th>
        <th width="19%">操作</th>
      </tr>
    </thead>
    <tbody>
      ';
$page = ($_GET['page'] == ''||!isset($_GET['page'])) ?1:$_GET['page'];
$pagesize=8;
$num=$dbconn->countn(DBQIAN."user_txt");
$pagelist = new page($page,$pagesize,$num ,10,2,0);
$query=$dbconn->news_list(" select * from ".DBQIAN."user_txt order by id desc ",$page,$pagesize);
while($row=$dbconn->fetch($query)){
;echo '      <tr height="45">
        <td>';echo $row['tcontent'];;echo '</td>
        <td>
        <img src="images/leftico03.png" width="14"> 
        <a href="user.txtadd.php?nid=';echo $row['id'];;echo '">编辑</a>&nbsp;
        <img src="images/t03.png" width="14"> 
       <a onClick="if(confirm(\'您确认要删除吗？\')){window.location.href=\'?act=del&id=';echo $row['id'];echo '&page=';echo $page;echo '\'}" href="#" class="tablelink">删除</a>
        </td>
      </tr>
      ';
}
;echo '    </tbody>
  </table>
</div>
<div style=" width:90%; padding:10px 0 10px 0; text-align:center">
  ';if($num!=0) echo $pagelist->showpages();else echo "<font color='#ff0000'>暂无数据</font>";;echo '</div>
</body>
</html>';
?>