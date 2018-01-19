<?php
/**
 * 基本类
 * ============================================================================
 * * 版权所有 2016-2018   科技有限公司，并保留所有权利。
 * 网站地址: php.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: lisonglin
 * discountOrder.php (2017年3月28日)  Lisonglin
 */
defined('ShopMall') or exit('Access Invalid!');
class discount_orderControl extends SystemControl
{
	public function __construct(){
		parent::__construct();
	}
	public function indexOp()
	{	
		$start_time =  strtotime(date("Y-m",time()));
		
		$end_time =  strtotime("-1 day",strtotime("+1 month", $start_time));
		
		if(isset($_GET['date']) && !empty($_GET['date']))
		{
			$start_time = 0;
			$end_time = 0;
		    $start_time = strtotime($_GET['date']);
			$end_time =  strtotime("-1 day",strtotime("+1 month", $start_time));
		}
	    
		$model_order = Model("order");
		$model_goods = Model("goods");
		//订单状态：0(已取消)10(默认):未付款;20:已付款;30:已发货;40:已收货;
		$Where['order_state'] = 40;
		$Where['payment_time'] = array('BETWEEN',"{$start_time},{$end_time}");
		
		$field = "count(*) AS num,SUM(goods_amount) AS goods_amount, SUM(order_amount) AS order_amount, SUM(pay_amount) AS pay_amount, SUM(original_price) AS original_price";
	
		$order_list =  $model_order->getOrderList($Where,'',$field);
		$condition['order.payment_time'] = array('BETWEEN',"{$start_time},{$end_time}");
		//--支付订单
		$order_goods = $model_order->getGoodsAndOrderList($condition);
		
		foreach ($order_goods AS $key => $order_goods_info)
		{
			$Where['order_id'] = $order_goods_info['order_id'];
		
			
			$order_Info = $model_order->getOrderInfo($Where);
		
			if(!empty($order_Info))
			{
				$order_goods[$key] = $order_goods_info;
				
				$order_goods[$key]['order_info'] = $order_Info;
				
				//--商品详细信息
				$order_goods[$key]['goods_info'] = $model_goods->findByGoodsInfo(['goods_id' => $order_goods_info['goods_id']]);
				
			}else{
				unset($order_goods[$key]);
			}
		}

		Tpl::output("order_list",$order_list[0]);
		Tpl::output("order_goods",$order_goods);
		Tpl::showpage("discount.order");
	}
}