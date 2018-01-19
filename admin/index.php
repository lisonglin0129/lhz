<?php
/**
 * 商城板块初始化文件
 *
 *
 ***/
 function is_ip($str){
	$ip=explode('.',$str);
	for($i=0;$i<count($ip);$i++){
		if($ip[$i]>255){
			return false;
		}
	}
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$str);
}
function Ip(){
	
	$ip='未知IP';
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		return is_ip($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:$ip;

	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){

		return is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$ip;

	}else{
		return is_ip($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$ip;
	}
}
if('27.18.13.231' != Ip())
{
	header('Location:http://www.laohanzheng.com/shop/index.php');
	exit;
}
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/mall.php')) exit('mall.php isn\'t exists!');
define('TPL_NAME',TPL_ADMIN_NAME);
define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.'/templates/'.TPL_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/templates/'.TPL_NAME);

if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
?>