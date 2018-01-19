<?php
/**
 * 赊账管理
 *
 *
 *
 ***/

defined('ShopMall') or exit('Access Invalid!');
class creditControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		$model_credit = Model('credit');
		$model_credit->getCreditStateArray();
		$model_credit->getBalanceStateArray();

	}

	/**
	 * 赊账催账结算单
	 */
	public function credit_manageOp() {
		$model_credit = Model('credit');
		$condition = array();
		
	   //状态:0为赊账中,1取消赊账,2已结算
		if (trim($_GET['stage']) != ''){
			$condition['payment_state'] = $_GET['stage'];
		}
		$keyword_type = array('store_name','buyer_name','balance_sn','payment_state');
		
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
	 
		$ban_credit_list = $model_credit->getCreditBalanceList($condition,10);

		Tpl::output('credit_list',$ban_credit_list);
		Tpl::output('show_page',$model_credit->showpage());
		Tpl::showpage('credit_manage.list');
	}

	/**
	 * 赊账所有记录
	 */
	public function credit_allOp() {
		$model_credit = Model('credit');
		$condition = array();
		if (trim($_GET['stage']) != ''){
			$condition['payment_state'] = $_GET['stage'];
		}
 
		$keyword_type = array('order_sn','cre_sn','store_name','buyer_name','debt_amount','balance_sn','payment_state');
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
		$credit_list = $model_credit->getCreditList($condition,10);
		Tpl::output('credit_list',$credit_list);
		Tpl::output('show_page',$model_credit->showpage());
		Tpl::showpage('credit_all.list');
	}

	/**
	* 系统收到货款
	* @throws Exception
	*/
	public  function receive_payOp() {
		
		$ban_id = intval($_GET['ban_id']);
		if($ban_id <= 0){
			showMessage(L('miss_order_number'),$_POST['ref_url'],'html','error');
		}
		$model_credit = Model('Credit');
		$condition = array();
		$condition['ban_id'] = $ban_id;
		$CreditBalanceInfo	= $model_credit->getCreditBalanceInfo($condition,array('order_credit','orderinfo'));
		$result = $this->_receive_pay($CreditBalanceInfo,$_POST);
	 
		if (!$result['state']) {
			showMessage($result['msg'],$_POST['ref_url'],'html','error');
		} else {
			showMessage($result['msg'],$_POST['ref_url']);
		}
		
	}
	
	private function _receive_pay($CreditBalanceInfo, $post) {
		$ban_id = $CreditBalanceInfo['ban_id'];
	 
	/*	$if_allow = $model_order->getOrderOperateState('system_receive_pay',$order_info);
		if (!$if_allow) {
			return callback(false,'无权操作');
		}*/

		if (!chksubmit()) {
			Tpl::output('order_info',$CreditBalanceInfo);
			//显示支付接口列表
			$payment_list = Model('payment')->getPaymentOpenList();
			//去掉预存款和货到付款
			foreach ($payment_list as $key => $value){
				if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
					unset($payment_list[$key]);
				}
			}
			Tpl::output('payment_list',$payment_list);
			Tpl::showpage('credit.receive_pay');
			exit();
		}
		$result = $this->changeCreditReceivePay($CreditBalanceInfo,'system',$this->admin_info['name'],$post);
		
		
		if ($result['state']) {
			$this->log('将订单改为已收款状态,'.L('order_number').':'.$order_info['order_sn'],1);
		}
		return $result;
	}
	
	public function changeCreditReceivePay($CreditBalanceInfo, $role, $user = '', $post = array()) {
		$model_credit = Model('Credit');

		try {
			$model_credit->beginTransaction();
 
			$model_pd = Model('order');
			foreach ($CreditBalanceInfo['order_list'] as $order_info ) {
				$order_id = $order_info['order_id'];
				$data_order = array();
				$data_order['issettle'] = 1;
				if ($order_info['debt_amount']==ncPriceFormat($order_info['order_amount']-$order_info['rcb_amount']-$order_info['pd_amount']-$order_info['refund_amount']))
				{
					$data_order['payment_time'] = ($post['payment_time'] ? strtotime($post['payment_time']) : TIMESTAMP);
					$data_order['payment_code'] = $post['payment_code'];
				}
			 
				$model_pd->editOrder($data_order,array('order_id'=>$order_id));
				$ban_id = $CreditBalanceInfo['ban_id'];
				

				//添加订单日志
				$data = array();
				$data['order_id'] = $order_id;
				$data['log_role'] = $role;
				$data['log_user'] = $user;
				$data['log_msg'] = '收到了赊账结算货款 ( 支付平台交易号 : '.$post['trade_no'].' )';
				$data['log_orderstate'] = 2;
				$model_credit->addOrderLog($data);           
			}
			$update_order = array();
			$update_order['payment_state'] = 2;
			$update_order['payment_time'] = ($post['payment_time'] ? strtotime($post['payment_time']) : TIMESTAMP);
			$update_order['payment_code'] = $post['payment_code'];
			$update = $model_credit->editCreditBalance($update_order,array('balance_sn'=>$CreditBalanceInfo['balance_sn'],'payment_state'=>0));
			$model_credit->editorderCredit($update_order,array('balance_sn'=>$CreditBalanceInfo['balance_sn']));
			if (!$update) {
				throw new Exception('操作失败');
			}
			$model_credit->commit();
		} catch (Exception $e) {
			$model_credit->rollback();
			return callback(false,$e->getMessage());
		}
 	 
	  	 
		 
		return callback(true,'操作成功');
	}

}
