<?php
/**
 * 物流管理 
 *
 *
 *
 ***/

defined('ShopMall') or exit('Access Invalid!');
class logisticsControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		$model_logistics = Model('logistics_order');
		$model_logistics->getLogisticsStateArray();
		$model_truck = Model('logistics_truck');
		$model_truck->getLogisticsTruckArray();
	}

	/**
	 * 待接单列表
	 */
	public function logistics_manageOp() {
		$model_logistics = Model('logistics_order');
		$condition = array();
		$condition['order_state'] = '10';//状态:1为处理中,2为待管理员处理,3为已完成

		$keyword_type = array('logis_sn','delivery_store_name','delivery_name','delivery_mobphone','delivery_info');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
	
		$logistics_list= $model_logistics->getLogisticsOrderList($condition,'*',10);
	 
		Tpl::output('logistics_list',$logistics_list);
		Tpl::output('show_page',$model_logistics->showpage());
		Tpl::showpage('logistics_manage.list');
	}

	public function logistics_okOp() {
		$model_logistics = Model('logistics_order');
		$condition = array();
		$condition['order_state'] = '20';//状态:1为处理中,2为待管理员处理,3为已完成

		$keyword_type = array('logis_sn','delivery_store_name','delivery_name','delivery_mobphone','delivery_info');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
	
		$logistics_list= $model_logistics->getLogisticsOrderList($condition,'*',10);
	 
		Tpl::output('logistics_list',$logistics_list);
		Tpl::output('show_page',$model_logistics->showpage());
		Tpl::showpage('logistics_ok.list');
	}
 
	
	public function logistics_settingOp() {
		$model_setting = Model('setting');
		$setting = $model_setting->GetListSetting();
		Tpl::output('setting',$setting);
		Tpl::showpage('logistics.setting');
	}
	
	public function logistics_setting_saveOp() {
	
		$logistics_rate = intval($_POST['logistics_rate']);
		$carry_rate =  $_POST['carry_rate'];
		$ratio_limit = $_POST['ratio_limit'];
		if($logistics_rate < 0) {
			$logistics_rate = 100;
		}
		//--运费比例不能超过100
		if($carry_rate < 0 || $carry_rate > 100) {
			$carry_rate = 100;
		}
		
		$model_setting = Model('setting');
		$update_array = array();
		$update_array['logistics_rate'] = $logistics_rate;
		$update_array['carry_rate'] = $carry_rate;
		$update_array['ratio_limit'] = $ratio_limit;
	 
		$result = $model_setting->updateSetting($update_array);
		if ($result){
			$this->log('计算物流费用比率'.$groupbuy_price.'%');
			showMessage(Language::get('nc_common_op_succ'),'');
		}else {
			showMessage(Language::get('nc_common_op_fail'),'');
		}
	}

	/**
	 * 所有记录
	 */
	public function logistics_allOp() {

		$model_logistics = Model('logistics_order');
		$condition = array();
		$keyword_type = array('logis_sn','delivery_store_name','delivery_name','delivery_mobphone','delivery_info');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['addtime'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$logistics_list= $model_logistics->getLogisticsOrderList($condition,'*',10);
         
		Tpl::output('logistics_list',$logistics_list);
		Tpl::output('show_page',$model_logistics->showpage());
		Tpl::showpage('logistics_all.list');
	}
 
 

	public function search_orderOp(){
		$model_order = Model('order');
		$condition = array();
 		$condition['shipping_express_id'] = '1';
		$condition['order_state'] = '30';
		$keyword_type = array('store_name','buyer_name','reciver_info','order_sn','reciver_name');
		
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		$order_list	= $model_order->getOrderAndOrderCommonList($condition,'*',6);
		foreach($order_list as $key => $order_info)
		 {
			$order_list[$key]['reciver_info'] = unserialize($order_info['reciver_info']);
		}
 
		Tpl::output('order_list',$order_list);
		Tpl::output('show_page',$model_order->showpage());
		Tpl::showpage('truck_list.order', 'null_layout');
	}


	public function logisticsorder_infoOp() {
		$model_order = Model('order');
		$condition = array();
		$condition['order_id'] = intval($_GET['orderid']);
		$order_list	= $model_order->getOrderInfo($condition);
 		
		$data = array();
		$data['result'] = true;
		
		if(empty($order_list)) {
			$data['result'] = false;
			$data['message'] = L('param_error');
			echo json_encode($data);die;
		} 
		$data['order_id'] = $order_list['order_id'];
		$data['store_name'] = $order_list['store_name'];
		$data['store_id'] = $order_list['store_id'];
		$data['order_sn'] = $order_list['order_sn'];
		$data['buyer_id'] = $order_list['buyer_id'];
		$data['buyer_name'] = $order_list['buyer_name'];
		$data['goods_amount'] = $order_list['goods_amount'];
		$data['shipping_fee'] = $order_list['shipping_fee'];
		$data['shipping_code'] = $order_list['shipping_code'];
	     
		echo json_encode($data);die;
	}


	/**
	   * 选择活动商品
	   **/
	public function search_truckOp() {
		$model_truck = Model('logistics_truck');
		$condition = array();
		$condition['truck_state'] = '0';//空闲中的车辆
		
		$keyword_type = array('truck_name','truck_code','store_name','contact','memo','contactphone');
 
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['addtime'] = array('time',array($add_time_from,$add_time_to));
			}
		}
	
		$truck_list = $model_truck->getLogisticsTruckList($condition,'',10);
		Tpl::output('truck_list',$truck_list);
		Tpl::output('show_page',$model_truck->showpage());
		Tpl::showpage('truck_list.truck', 'null_layout');
	}
	

	/**
	 * 车辆管理
	 */
	public function truck_listOp() {
		$model_truck = Model('logistics_truck');
		$condition = array();
		$keyword_type = array('truck_name','truck_code','store_name','contact','memo','contactphone');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['addtime'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$truck_list = $model_truck->getLogisticsTruckList($condition,'',10);
		Tpl::output('truck_list',$truck_list);
		Tpl::output('show_page',$model_truck->showpage());
		Tpl::showpage('truck_list');
	}




	

	public function logisticstruck_infoOp() {
		$model_truck = Model('logistics_truck');
		$condition = array();
		$condition['tru_id'] = intval($_GET['truid']);
		$goods_list=  $model_truck->getLogisticstruckInfo($condition);
		
		$data = array();
		$data['result'] = true;
		
		if(empty($goods_list)) {
			$data['result'] = false;
			$data['message'] = L('param_error');
			echo json_encode($data);die;
		} 
	 	$data['tru_id'] = $goods_list['tru_id'];
		$data['truck_name'] = $goods_list['truck_name'];
		$data['truck_code'] = $goods_list['truck_code'];
		$data['truck_type'] = $goods_list['truck_type'];
		$data['truck_brand'] = $goods_list['truck_brand'];
		$data['Factor'] = $goods_list['Factor'];
		$data['Area'] = $goods_list['Area'];
		$data['store_id'] = $goods_list['store_id'];
		$data['store_name'] = $goods_list['store_name'];
		$data['contactphone'] = $goods_list['contactphone'];
		$data['contact'] = $goods_list['contact'];
		$data['memo'] = $goods_list['memo'];
		$data['shipping_fee'] = $goods_list['shipping_fee'];
		
		echo json_encode($data);die;
	}
	public function truck_delOp() {
		$tru_id = intval($_GET['tru_id']);
		if ($tru_id <=  0) {
			showDialog('删除失败','','error');
		}
		$condition = array();
		$condition['tru_id'] = $tru_id;
		$delete = Model('logistics_truck')->delLogisticsTruck($condition);
		if ($delete){
			showDialog('删除成功','index.php?act=logistics&op=truck_list','succ');
		}else {
			showDialog('删除失败','','error');
		}
	}


	/**
	 * 新增物流订单
	 *
	 */
	public function add_logisticsOp() {
		$model_logistics = Model('logistics_order');
		$model_LogisticsOrderDetail= Model('logistics_order_detail');
		if (chksubmit()) {
			$reason_array = array();
			$reason_array['logis_sn'] = $model_logistics->makeSn();
			$reason_array['order_amount'] = $_POST['order_amount'];
 			$reason_array['delivery_info'] = $_POST['delivery_info'];
			$reason_array['area_id'] = $_POST['area_id'];
			$reason_array['city_id'] = $_POST['area_id_2'];
			$reason_array['area_info'] = $_POST['area_info'];
			$reason_array['extra_amount'] = $_POST['extra_amount'];
			$reason_array['deliverytime'] = $_POST['deliverytime'];
			$reason_array['order_state'] = 10;
			$reason_array['addtime'] = TIMESTAMP;
			$reason_array['delivery_store_id'] = $_POST['store_id'];
			$reason_array['delivery_store_name'] =  $_POST['store_name'];
			$reason_array['tru_id'] =  $_POST['tru_id'];
			
			$attr_array = array();
			$attr_array['tru_id']=intval($reason_array['tru_id']);
			$model_logistics_truck = Model('logistics_truck');
			$logistics_truck =$model_logistics_truck->getLogisticstruckInfo($attr_array);
			if (!empty($logistics_truck)){
				$reason_array['delivery_name'] = $logistics_truck['contact'];
				$reason_array['delivery_telphone'] = $logistics_truck['contactphone'];
			}
			
			$state = $model_logistics->addLogisticsOrder($reason_array);
			
			if(!empty($_POST['or_orderinfo'])){
				$attribute_array		= $_POST['or_orderinfo'];
				 
				foreach ($attribute_array as $key=> $v){
					if($v['shipping_code'] != ''){
						// 转码  防止GBK下用中文逗号截取不正确
						$comma = '，';
						if (strtoupper(CHARSET) == 'GBK'){
							$comma = Language::getGBK($comma);
						}
						
						$model_order = Model('order');
						$condition = array();
						$condition['order_id'] = intval($key);
						$order_list	= $model_order->getOrderInfo($condition);
						
						$attr_array = array();
						$attr_array['addtime'] = TIMESTAMP;
						$attr_array['shipping_code']	= $v['shipping_code'];
						$attr_array['Area']	= $v['Area'];
						$attr_array['Factor']	= $v['Factor'];
						$attr_array['shipping_fee']	= $v['shipping_fee'];
						$attr_array['order_id']		= $key;
						$attr_array['store_id']		= $order_list['store_id'];
						$attr_array['store_name']		=  $order_list['store_name'];
						$attr_array['order_sn']		=  $order_list['order_sn'];
						$attr_array['logis_id']		= $state;
						$attr_id	= $model_LogisticsOrderDetail->addLogisticsOrderDetail($attr_array);
					}
				}
			 
			}
			
			if ($state) {
				showMessage('新增物流运单成功','index.php?act=logistics&op=logistics_all');
			} else {
				showMessage('新增物流运单失败');
			}
		}
	
		$model_setting = Model('setting');
		$setting = $model_setting->GetListSetting();
		Tpl::output('setting',$setting);
		Tpl::showpage('logistics_manage.add');
	}

	/**
	 * 编辑物流订单
	 *
	 */
	public function edit_logisticsOp() {
		$model_logistics = Model('logistics_order');
		$condition = array();
		$condition['logis_id'] = intval($_GET['logis_id']);
		$reason_list = $model_logistics->getLogisticsOrderList($condition);
		$LogisticsOrder = $reason_list[0];
		
		$model_logistics_detail = Model('logistics_order_detail');
		$logistics_detail=$model_logistics_detail->getLogisticsOrderDetailList($condition);
		
			$attr_array = array();
		$attr_array['tru_id']=intval($LogisticsOrder['tru_id']);
		$model_logistics_truck = Model('logistics_truck');
		$logistics_truck =$model_logistics_truck->getLogisticstruckInfo($attr_array);
		if (chksubmit()) {
			$reason_array = array();
			$reason_array['order_state'] = trim($_POST['order_state']);
		/*	if($_POST['order_state']==10)
			{
				$reason_array['store_id'] ='';
				$reason_array['store_name'] = '';
				$reason_array['delivery_name'] = '';
				$reason_array['delivery_telphone'] ='';
				$reason_array['delivery_mobphone'] = '';
				$reason_array['rectime'] =  '';
			}
			$reason_array['order_amount'] =  trim($_POST['order_amount']);
 			$reason_array['delivery_info'] =  trim($_POST['delivery_info']);
			$reason_array['area_id'] =  trim($_POST['area_id']);
			$reason_array['city_id'] =  trim($_POST['area_id_2']);
			$reason_array['area_info'] =  trim($_POST['area_info']);
			$reason_array['address'] = trim( $_POST['address']);
			$reason_array['deliverytime'] =  trim($_POST['deliverytime']);*/
			$state = $model_logistics->editLogisticsOrder($reason_array,$condition);
			if ($state) {
				showMessage('修改物流订单成功','index.php?act=logistics&op=logistics_all');
			} else {
				showMessage('物流订单更新失败');
			}
		}
		Tpl::output('logistics_orderinfo',$LogisticsOrder);
		Tpl::output('logistics_detail',$logistics_detail);
		Tpl::output('logistics_truck',$logistics_truck);
		Tpl::showpage('logistics_manage.edit');
	}


	public function del_logisticsOp() {
		$model_logistics = Model('logistics_order');
		$condition = array();
		$condition['logis_id'] = intval($_GET['logis_id']);
		$condition['order_state'] = 10;
		$reason_list = $model_logistics->delLogisticsOrder($condition);
		 
		$condition2 = array();
		$condition2['logis_id'] = intval($_GET['logis_id']);
		$model_logistics_detail = Model('logistics_order_detail');
		$state=$model_logistics_detail->delLogisticsOrderDetail($condition2);
 	 
			if ($state) {
			showMessage('删除物流订单成功','index.php?act=logistics&op=logistics_all');
			} else {
			showMessage('当前物流订单状态已经不能被删除');
			}
 		 
		Tpl::showpage('logistics_manage.edit');
	}

	 
}
