<?php
defined('ShopMall') or exit('Access Invalid!');
/**
 * 银行第三方支付
 * @author Administrator
 *
 */
class notify{
	private $ssl_path;
	public function __construct()
	{
		$this->ssl_path = str_replace('notify.php', '', str_replace('\\', '/', __FILE__));
	}
	// 验签函数
	public function cfcaverify($plainText,$signature){
	
		$fcert = fopen($this->ssl_path."paytest.cer", "r");
	
		$cert = fread($fcert, 8192);
		fclose($fcert);
	
		$binary_signature = pack("H" . strlen($signature), $signature);
		
		$ok = openssl_verify($plainText, $binary_signature, $cert);
		return $ok;
	}
	/**
	 * 变更类型
	 * @param int $code
	 * @return string
	 */
	public function caseCode($code){
		switch($code)
		{
			case 1318 : {
				return 'real_order';
				break;
			}
		}
	}
}