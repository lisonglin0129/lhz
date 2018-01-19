<?php
defined('ShopMall') or exit('Access Invalid!');
class mobile_specialControl  extends SystemControl 
{
	public function __construct(){
		parent::__construct();
	}
	public function indexOp()
	{
		Tpl::showpage("mobile_special.list");
	}
}