<?php 

//用gd库生成验证码
class mycode{
	protected $info="";
	public $config=array(
        'len'=>4,
        'num'=>1,
        'key'=>"wqpicjosfiwdlswi",
        'width'=>50,
        'height'=>30,
        'noise'=>true,
        'time'=>300,//有效期
		);
	protected $_image="";

	function __construct($config=false){
		 $this->info=gd_info();
		if(!$this->hadgd()||!$this->support_type()){
			return "GD拓展未开启";
		}
		if($config){
			$this->config=array_merge($this->config,$config);	
		}
		if(!isset($_SESSION)){session_start();}
		$this->_image=imagecreate($this->config['width'], $this->config['height']);
	}
	//是否存在gd库?
	function hadgd(){
		if($this->info['GD Version']){
		return true;
		}
		return false;
	}

	function support_type(){
	    switch(true){
	    	case $this->info['PNG Support']:
	    		return "png";break;
	    	case $this->info['JPEG Support']:
	    		return 'jpeg';break;
	    	case $this->info['GIF Create Support']:
	    		return 'gif';break;
	    	case $this->info['WeP Support']:
	    		return 'wep';break;
	    	default:
	    		return false;
	    }
	}
	//生成随机颜色值
	function color(){
		return mt_rand(0,255);
	}

	//生成随机字符
	function getRandChar($length){
		$str = null;
		$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($strPol)-1;

		for($i=0;$i<$length;$i++){
		$str.=$strPol[mt_rand(0,$max)];
		}
		return $str;
	}
     
     //画杂点
	 private function _writeNoise() {
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
            //杂点颜色
            $color=$this->color();
            $noiseColor = imagecolorallocate($this->_image, $color, $color, $color);
            for($j = 0; $j < 5; $j++) {
                // 绘杂点
                imagestring($this->_image, 5, mt_rand(-10, $this->config['width']),  mt_rand(-10, $this->config['height']), $codeSet[mt_rand(0, 29)], $noiseColor);
            }
    }
    protected function set_image(){
    	$im =$this->_image;
		$background_color = imagecolorallocate($im, $this->color(), $this->color(), $this->color());
		$text_color = imagecolorallocate($im, $this->color(), $this->color(), $this->color());
		$str=$this->getRandChar($this->config['len']);
		$_SESSION[$this->config['key'].$this->config['num']]=$str;
		$_SESSION[$this->config['key'].$this->config['num']."_time"]=time();
		imagestring($im, mt_rand(1,5), 5, 5, $str, $text_color);
		if($this->config['noise']){$this->_writeNoise();}
    }

	//输出图片
	function show(){
		$this->set_image();

		header("Content-Type: image/png");
		imagepng($this->_image);
		imagedestroy($this->_image);	
	}

	//保存图片
	function save($file){
		$this->set_image();
		imagepng($this->_image,$file);
		imagedestroy($this->_image);
	}

	//验证
	function check($code){
		$old=$_SESSION[$this->config['key'].$this->config['num']];
        
        //判断是否过期
		if(time()-$_SESSION[$this->config['key'].$this->config['num']."_time"] > $this->config['time']){
			$_SESSION[$this->config['key'].$this->config['num']]=null;
			return false;
		}
		
		if(strtolower($old)==strtolower($code)){
		    $_SESSION[$this->config['key'].$this->config['num']]=null;
			return true;
		}
		return false;
	}


}//class




 ?>