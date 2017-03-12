# mycode
php验证码类，GD库


##1.使用方法：
require("./src/mycode.php");

$config=array(
   'len'=>6,  //验证码字符长度，默认是4
   'time'=>60,//有效期，默认是600秒
   'num'=>1,//验证码编号，默认是1，如果只有一处使用，可以使用默认值，如果多次使用，请传入不同的值
	);
$mycode=new mycode($config);

$mycode->show();//显示验证码

##2.验证：
$code=$_POST['code'];

require("./src/mycode.php");
$mycode=new mycode();
if($mycode->check($code)){
	//验证成功
}else{
	//验证失败
}


##3.如何需要把验证码保存为文件，可以用save()方法：
$mycode->save("./a.png");
