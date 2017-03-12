<?php 

require("./src/mycode.php");

$config=array(
   'len'=>6,  //验证码字符长度，默认是4
   'time'=>60,//有效期，默认是600秒
   'num'=>1,//验证码编号，默认是1，如果只有一处使用，可以使用默认值，如果多次使用，请传入不同的值
   'noise'=>false,//是否添加干扰字符串
	);
$mycode=new mycode($config);

$mycode->show();//显示验证码


 ?>