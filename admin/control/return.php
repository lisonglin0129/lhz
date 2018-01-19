<?php
/**
 * 退货管理
 *
 ***/

defined('ShopMall') or exit('Access Invalid!');
class returnControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		$model_refund = Model('refund_return');
		$model_refund->getRefundStateArray();
	}

	/**
	 * 待处理列表
	 */
	public function return_manageOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_state'] = '2';
		//状态:1为处理中,2为待管理员处理,3为已完成
		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
		
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
		$condition['is_admin_chcked'] = 0;
		//var_dump($condition);die;
		$return_list = $model_refund->getReturnList($condition,10);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('return_manage.list');
	}

	/**
	 * 所有记录
	 */
	public function return_allOp() {
		$model_refund = Model('refund_return');
		$condition = array();

		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
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
		$condition['is_admin_chcked'] >= 0;
		$return_list = $model_refund->getReturnList($condition,10);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('return_all.list');
	}
	/**
	 * 平台介入
	 */
	public function  return_terraceOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
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
		$condition['is_admin_chcked'] = array('gt','0');
		$return_list = $model_refund->getReturnList($condition,10);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('return_terrace.list');
	}
	
	/**
	 * 第三方退款
	 * @param unknown $order
	 * @param unknown $paycode
	 */
	public function _payapi($order,$paycode){
	
		$logic_payment = Logic('payment');
		$result = $logic_payment->getPaymentInfo($paycode);
		$paymentinfo = $result[data];
		switch ($paycode)
		{
			case 'CMBC' : {
				$model_refund = Model('refund_return');
				//--拿到退款列表
				$return_list = $model_refund->getReturnList(array('refund_id'=>$order['refund_id']));
				//--退款订单用户的ID
				$condition['member_id'] = $order['buyer_id'];
				$condition['isset'] = 1;
				$refund_array = array();
				$refund_array['admin_time'] =  time();
				$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
				$order['message'] = isset($_POST['admin_message'])?$_POST['admin_message'] : '';
				
				$refund_array['refund_amount'] =  $return_list[0]['refund_amount'];
		
				//--退款卡号及类别
				$model_card = Model('card');
				$cardInfo = $model_card->getMemberCardList($condition);
				if(empty($cardInfo[0]))
				{
					showMessage('用户银行卡未选定或未添加银行卡','index.php?act=return&op=return_terrace','html','error');
					exit;
				}
				//--要退款的银行卡号
				$order['card_number'] = $cardInfo[0]['card_number'];
				$order['card_name'] = $cardInfo[0]['card_name'];
				//--银行卡的名字
				$order['BankID'] = $cardInfo[0]['card_type'];
				$order['refund_amount'] = $refund_array['refund_amount'];
				
				$order['BranchName']	=    $cardInfo[0]['card_branchname'];
				$order['Province'] 		=    $cardInfo[0]['card_rovince'];
				$order['City'] 			=    $cardInfo[0]['card_city'];
				$order['buyer_name'] 	= 	 $cardInfo[0]['name'];
			
				if(5>floatval($order['refund_amount']))
				{
					showMessage('该订单金额不能低于5元','index.php?act=return&op=return_terrace','html','error');
					exit;
				}
				//--退款单号
				$model_order = Model('order');
				$order_data  = $model_order->getOrderInfo(['order_id'=>$order['order_id']],[],'parent_order');
				$order['return_sn'] = isset($order_data['parent_order']) ? $order_data['parent_order'] : $order['order_sn'];
				//--调用第三方支付转账到此卡
				$CMBC = new CMBC($paymentinfo,$order);
				$result = $CMBC->refund();
				$xml= new SimpleXMLElement($result);
				if($xml->Head->Code == 2000) {
					$order_refund_state = $order['order_state']*10;
					// $model_order->editOrderBillState(array('order_id'=>$order['order_id']), 1);
					$model_order->editOrder(['refund_amount'=>$order['refund_amount'],'ov_time'=>time(),'finnshed_state'=>'1', 'order_state'=>$order_refund_state], array('order_id'=>$order['order_id']));
					$model_refund->editRefundReturn(array('refund_id'=>$order['refund_id']), $refund_array);
					$where = $order['order_id'];
					$data = $order['refund_amount'];
					$model_refund->editOrder($where,$data);
					$this->log('退货确认，退货编号'.$order['refund_sn']);
					showMessage('操作成功','index.php?act=return&op=return_terrace');
				}else {
					showMessage($xml->Head->Message, '/admin/index.php?act=return&op=return_terrace');
					exit;
				}
			
				break;
			}
			case 'alipay': {  break; }
		}
	}
	/**
	 * 退货处理页
	 *
	 */
	public function editOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		// var_dump($return_list);die;
		$return = $return_list[0];
		if (chksubmit()) {
			if ($return['refund_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
				showMessage(Language::get('nc_common_save_fail'));
			}
			$order_id = $return['order_id'];
			$refund_array = array();
			$refund_array['admin_time'] = time();
			$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
			$refund_array['admin_message'] = $_POST['admin_message'];
			
			//--新加退款
			$field = 'order_id,buyer_id,buyer_name,store_id,order_sn,pay_sn,order_amount,payment_code,order_state,refund_amount,pd_amount,rcb_amount,debt_amount,issettle';
			$model_order =  Model('order');
			$order = $model_order->getOrderInfo(array('order_id'=> $order_id),array(),$field);
			$order['refund_sn'] = $return['refund_sn'];
			$order['refund_id'] = intval($_GET['return_id']);
			//--调用第三方支付
			if('CMBC' == $order['payment_code']) {
				$this->_payapi($order,$order['payment_code']);
				exit;
			}
			$state = $model_refund->editOrderRefund($return);
			//--退款流程
			if ($state) {
				$order = null;
			    $model_refund->editRefundReturn($condition, $refund_array);
			    $this->log('退货确认，退货编号'.$return['refund_sn']);
			    //发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $return['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('return_id', 'view', array('return_id' => $return['refund_id'])),
                    'refund_sn' => $return['refund_sn']
                );
            	
                QueueClient::push('sendMemberMsg', $param);

				showMessage(Language::get('nc_common_save_succ'),'index.php?act=return&op=return_manage');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('return',$return);
		$info['buyer'] = array();
	    if(!empty($return['pic_info'])) {
	        $info = unserialize($return['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		Tpl::showpage('return.edit');
	}
	
	public function pay_returnOp()
	{

		$return_id = intval($_GET['return_id']);
		
		$model_refund = Model('refund_return');
		$order_info = Model('order');
		$return = $model_refund->getRefundAndGoodsInfo(array('refund_id'=>intval($_GET['return_id'])));
	
		$order = $order_info->getOrderInfo(array('order_id'=>$return['order_id']));
		
		$order['refund_amount'] = $return['refund_amount'];
		$paycode = $order['payment_code'];
		
		
		//---这里调用支付退款接口
		$logic_payment = Logic('payment');
		
		$result = $logic_payment->getPaymentInfo($paycode);
		
	
	
		$paymentinfo = $result[data];
			
		if('CMBC' == $order['payment_code']) {
			
				//--退款订单用户的ID
				$condition['member_id'] = $order['buyer_id'];
				$condition['isset'] = 1;
				$refund_array = array();
				$refund_array['admin_time'] =  time();
				$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
				$order['message'] = isset($_POST['admin_message'])?$_POST['admin_message'] : '';

				//--退款卡号及类别
				$model_card = Model('card');
				$cardInfo = $model_card->getMemberCardList($condition);
				if(empty($cardInfo[0]))
				{
					showMessage('用户银行卡未选定或未添加银行卡','index.php?act=return&op=return_terrace','html','error');
					exit;
				}
				//--要退款的银行卡号
				$order['card_number'] = $cardInfo[0]['card_number'];
				$order['card_name'] = $cardInfo[0]['card_name'];
				//--银行卡的名字
				$order['BankID'] = $cardInfo[0]['card_type'];

				$order['BranchName']	=    $cardInfo[0]['card_branchname'];
				$order['Province'] 		=    $cardInfo[0]['card_rovince'];
				$order['City'] 			=    $cardInfo[0]['card_city'];
				$order['buyer_name'] 	= 	 $cardInfo[0]['name'];
				
				if(5>floatval($order['refund_amount']))
				{
					showMessage('该订单金额不能低于5元','index.php?act=return&op=return_terrace','html','error');
					exit;
				}
				//--退款单号
				$model_order = Model('order');
				$order_data  = $model_order->getOrderInfo(['order_id'=>$order['order_id']],[],'parent_order');

				$order['return_sn'] = isset($order_data['parent_order']) ? $order_data['parent_order'] : $order['order_sn'];
			
				//--调用第三方支付转账到此卡
				$CMBC = new CMBC($paymentinfo,$order);
				$result = $CMBC->refund();
				$xml= new SimpleXMLElement($result);
				
				if($xml->Head->Code == 2000) {
					//$model_order->editOrderBillState(array('order_id'=>$order['order_id']), 1);
					$order_refund_state = $order['order_state']*10;
					$model_order->editOrder(['refund_amount'=>$order['refund_amount'],'ov_time'=>time(),'finnshed_state'=>'1', 'order_state'=>$order_refund_state], array('order_id'=>$order['order_id']));
					$model_refund->editRefundReturn(array('refund_id'=>$order['refund_id']), $refund_array);
					$this->log('退货确认，退货编号'.$order['refund_sn']);
					$data['seller_state'] = 2;
					$data['refund_state'] = 3;
					$data['admin_time'] = time();
					$data['is_admin_chcked']  =  3;
					$data['goods_state']  =  4;
					$status = $model_refund->editRefundReturn(['refund_id'=>$return_id],$data);
					if($status)
					{
						showMessage('操作成功','index.php?act=return&op=return_terrace');
						exit;
					}

				}else {
					showMessage($xml->Head->Message, '/admin/index.php?act=return&op=return_terrace');
					exit;
				}
			}else if('yl' == $order['payment_code']){
				
	
				//--退款订单用户的ID
				$condition['member_id'] = $order['buyer_id'];
				
				$refund_array = array();
				$refund_array['admin_time'] =  time();
				$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
				$order['message'] = isset($_POST['admin_message'])?$_POST['admin_message'] : '';
				//--退款卡号及类别
				$model_card = Model('card');
				$cardInfo = $model_card->getMemberCardList($condition);
				
				if(empty($cardInfo[0]))
				{
					showMessage('用户银行卡未选定或未添加银行卡','index.php?act=refund&op=refund_manage','html','error');
					exit;
				}
				//--要退款的银行卡号
				$order['card_number'] = $cardInfo[0]['card_number'];
				$order['card_name'] = $cardInfo[0]['card_name'];
				//--银行卡的名字
				$order['BankID'] = $cardInfo[0]['card_type'];
				
				$order['BranchName']	=    $cardInfo[0]['card_branchname'];
				$order['Province'] 		=    $cardInfo[0]['card_rovince'];
				$order['City'] 			=    $cardInfo[0]['card_city'];
				$order['buyer_name'] 	= 	 $cardInfo[0]['name'];
				
				if(5>floatval($order['refund_amount']))
				{
					showMessage('该订单金额不能低于5元','index.php?act=refund&op=refund_manage','html','error');
					exit;
				}
				//--退款单号
				$model_order = Model('order');
				$order_data  = $model_order->getOrderInfo(['order_id'=>$order['order_id']],[],'parent_order');
				
				$order['return_sn'] = isset($order_data['parent_order']) ? $order_data['parent_order'] : $order['order_sn'];
				//调用第三方快捷支付退款接口转账到此卡
				
				/*这里以前把它干掉，用新的由于中金那边接口关系相应的变动 下面的就注释了*/
			   //	$YL = new CMBC();
				$YL = new pay();
				
				$pay_data = new ArrayObject(['pay_info'=>$paymentinfo,'user_card'=>$cardInfo,'order'=>$order]);
				$result = $YL->cmbc->setData($pay_data)->refund();
			
				$xml= new SimpleXMLElement($result); 
				if($xml->Head->Code == 2000) {
					$order_refund_state = $order['order_state']*10;
					$model_order->editOrder(['refund_amount'=>$order['refund_amount'],'finnshed_state'=>'1','ov_time'=>time(),'refund_state'=>$order_refund_state], array('order_id'=>$order['order_id']));
					$model_refund->editRefundReturn(array('refund_id'=>$order['refund_id']), $refund_array);
					$this->log('退货确认，退货编号'.$order['refund_sn']);
					$data['seller_state'] = 2;
					$data['refund_state'] = 3;
					$data['admin_time'] = time();
					$data['is_admin_chcked']  =  3;
					$data['goods_state']  =  4;
					$status = $model_refund->editRefundReturn(['refund_id'=>$return_id],$data);
					if($status)
					{
						showMessage('操作成功','index.php?act=return&op=return_terrace');
						exit;
					}
				}else {
					showMessage($xml->Head->Message, '/admin/index.php?act=refund&op=refund_manage');
					exit;
				}
			}
	}
	
	/**
	 * 退货结束平台处理
	 */
	public function shut_returnOp()
	{
	
		$return_id = intval($_GET['return_id']);
		$model_refund = Model('refund_return');
		$data['seller_state'] = 1;
		$data['refund_state'] = 3;
		$data['admin_time'] = time();
		$data['is_admin_chcked']  =  3;
		$data['goods_state']  =  4;
		$status = $model_refund->editRefundReturn(['refund_id'=>$return_id],$data);
		if($status)
		{
			showMessage('操作成功');
			exit;
		}
	}
	/**
	 * 退货记录查看页
	 *
	 */
	public function viewOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		if (chksubmit()) {
			$is_admin_chcked = $_POST['is_admin_chcked'];
			$data['is_admin_chcked'] = $is_admin_chcked;
			
			if(0 == $is_admin_chcked)
			{
				$data['seller_state'] = 3;
				$data['refund_state'] = 3;
				$data['admin_time'] = time();
				$data['admin_message'] = $_POST['admin_message'];
			}else{
				$data['seller_state'] = 2;
				$data['refund_state'] = 1;
				$data['is_admin_chcked'] = 0;
			}
	
			$model_refund->editRefundReturn(['order_id'=>$return['order_id']],$data);
			$status = $model_refund->editOrderUnlock($return['order_id']);
			if($status)
			{
				showMessage('审核通过','index.php?act=return&op=return_terrace','html','error');
					exit;
			}
		}
		Tpl::output('return',$return);
		$info['buyer'] = array();
	    if(!empty($return['pic_info'])) {
	        $info = unserialize($return['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		Tpl::showpage('return.view');
	}
	//修改退款价格
	public function editPriceOp()
	{
		$refund_id = $_POST['id'];
		$refund_amount = $_POST['refund_amount'];
		$condition['refund_id'] = $refund_id;
		$data['refund_amount'] = $refund_amount;
		$model_refund = Model('refund_return');
		$new_price = $model_refund->editRefundReturn($condition,$data);
	}
}
