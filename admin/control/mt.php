<?php
/**
 * 美图秀秀
 * ============================================================================
 * * 版权所有 2016-2018   科技有限公司，并保留所有权利。
 * 网站地址: php.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: lisonglin
 * Userpay.php 2017年5月10日  Lisonglin
 */
defined('ShopMall') or exit('Access Invalid!');
class mtControl extends SystemControl{
	public function __construct()
	{
		parent::__construct();
	}
	public function indexOp()
	{
		Tpl::showpage('meitu.upload');
	}
	public function editOp()
	{
		$where['id'] = intval($_GET['id']);
		$mobile_slider_model = Model('mobile_slider');
		$img_source = $mobile_slider_model->getSliderInfo($where);
		Tpl::output('data', $img_source);
		Tpl::showpage('meitu.edit');
	}
	
}