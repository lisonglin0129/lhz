<?php
/**
 * 退款管理 
 *
 *
 *
 ***/

defined('ShopMall') or exit('Access Invalid!');
class refundControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		$model_refund = Model('refund_return');
		$model_refund->getRefundStateArray();
	}

	/**
	 * 待处理列表
	 */
	public function refund_manageOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_state'] = '1';//状态:1为处理中,2为待管理员处理,3为已完成

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
		$refund_list = $model_refund->getRefundList($condition,10);

		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('refund_manage.list');
	}

	/**
	 * 所有记录
	 */
	public function refund_allOp() {
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
		$refund_list = $model_refund->getRefundList($condition,10);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('refund_all.list');
	}
	/**
	 * 第三方退款
	 * @param unknown $order
	 * @param unknown $paycode
	 */
	public function _payapi($order,$paycode,$refund_array,$refund){

		$logic_payment = Model('payment');
		$result = $logic_payment->where(array('payment_code'=>$paycode))->select();
		$paymentinfo = $result[0];
		$paymentinfo['payment_config'] = unserialize($paymentinfo['payment_config']);
		
	
		switch ($paycode)
		{
			case 'CMBC' : {
				
				$model_refund = Model('refund_return');
				//--拿到退款列表
				$return_list = $model_refund->getRefundList(array('refund_id'=>$order['refund_id']));
			
				//--退款订单用户的ID
				$condition['member_id'] = $order['buyer_id'];
				$condition['isset'] = 1;
	
				$order['message'] = isset($_POST['admin_message'])?$_POST['admin_message'] : '';
				$refund_array = array();
				$refund_array['admin_time'] = time();
				$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
				$refund_array['admin_message'] = $order['message'];
				//--退款卡号及类别
				$model_card = Model('card');
				$cardInfo = $model_card->getMemberCardList($condition);
				if(empty($cardInfo[0]))
				{
					showMessage('用户银行卡未选定或未添加银行卡','index.php?act=return&op=return_manage','html','error');
					exit;
				}
				
				//--要退款的银行卡号
				$order['card_number'] = $cardInfo[0]['card_number'];
			
				$order['card_name'] = $cardInfo[0]['card_name'];
				//--银行卡的名字
				$order['BankID'] = $cardInfo[0]['card_type'];
				//--退款这里不需要
				//$order['refund_amount'] = $order['order_amount'];
				
				$order['BranchName']	=    $cardInfo[0]['card_branchname'];
				$order['Province'] 		=    $cardInfo[0]['card_rovince'];
				$order['City'] 			=    $cardInfo[0]['card_city'];
		
				if(5>floatval($order['refund_amount']))
				{
					showMessage('该订单金额不能低于5元','index.php?act=return&op=return_manage','html','error');
					exit;
				}
				//--调用第三方支付转账到此卡
				$path =  str_replace('control/refund.php', '', str_replace('\\', '/', __FILE__)).'api/payment/CMBC/CMBC.php';
				require_once  $path;
				//--退款单号
				$model_order = Model('order');
				$order_data  = $model_order->getOrderInfo(['order_id'=>$order['order_id']],[],'parent_order');
				$order['return_sn'] = isset($order_data['parent_order']) ? $order_data['parent_order'] : $order['order_sn'];
				$order['buyer_name'] = $cardInfo[0]['name'];
			
				$CMBC = new CMBC($paymentinfo,$order);
				
				if($result = $CMBC->refund()) {
			
					$xml= new SimpleXMLElement($result);
					if($xml->Head->Code == 2000) {
					
						// $model_order->editOrderBillState(array('order_id'=>$order['order_id']), 1);
						$state = $model_refund->editRefundReturn(['refund_id' => $refund['refund_id']], $refund_array);
						$this->log('退款成功退款订单号'.$order['refund_sn']);

						if ($state) {
							$model_refund->editRefundReturn(['refund_id'=>$refund['refund_id']] , $refund_array);
							// 发送买家消息
							$param = array();
							$param['code'] = 'refund_return_notice';
							$param['member_id'] = $refund['buyer_id'];
							$param['param'] = array(
									'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
									'refund_sn' => $refund['refund_sn']
							);
							QueueClient::push('sendMemberMsg', $param);
							$this->log('退款确认，退款编号'.$refund['refund_sn']);
							showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=refund_manage');
						} else {
							showMessage(Language::get('nc_common_save_fail'));
						}
						showMessage('退款成功','index.php?act=return&op=return_manage');
						
					}else{
						showMessage('退款失败'.$xml->Head->Message,'index.php?act=return&op=return_manage');
					}
		
				}else{
					showMessage('签名失败','index.php?act=return&op=return_manage');
				}
				break;
			}
			case 'alipay': {  break; }
		}
		exit;
	}
	/**
	 * 退款处理页
	 *
	 */
	public function editOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_refund->getRefundList($condition);
		$refund = $refund_list[0];
		if (chksubmit()) {
		
			if ($refund['refund_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
				showMessage(Language::get('nc_common_save_fail'));
			}
			$order_id = $refund['order_id'];
			$refund_array = array();
			$refund_array['admin_time'] = time();
			$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
			$refund_array['admin_message'] = $_POST['admin_message'];
			
			//--新加退款
			$field = 'order_id,buyer_id,buyer_name,store_id,order_sn,pay_sn,order_amount,payment_code,order_state,refund_amount,pd_amount,rcb_amount,debt_amount,issettle';
			$model_order =  Model('order');
			$order = $model_order->getOrderInfo(array('order_id'=> $order_id),array(),$field);
			$order['refund_sn'] = $return['refund_sn'];
			$order['refund_id'] = intval($_GET['refund_id']);
			//--调用第三方支付
	
			if('CMBC' == $order['payment_code']) {
				
				$this->_payapi($order,$order['payment_code'],$refund_array,$refund);
				exit;
			}
			$state = $model_refund->editOrderRefund($refund);
			if ($state) {
			    $model_refund->editRefundReturn($condition, $refund_array);
    			// 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $refund['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
                    'refund_sn' => $refund['refund_sn']
                );
                QueueClient::push('sendMemberMsg', $param);

			    $this->log('退款确认，退款编号'.$refund['refund_sn']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=refund_manage');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('refund',$refund);
		$info['buyer'] = array();
	    if(!empty($refund['pic_info'])) {
	        $info = unserialize($refund['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		Tpl::showpage('refund.edit');
	}

	/**
	 * 退款记录查看页
	 *
	 */
	public function viewOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['return_id']);
		$refund_list = $model_refund->getRefundList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		$info['buyer'] = array();
	    if(!empty($refund['pic_info'])) {
	        $info = unserialize($refund['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		Tpl::showpage('refund.view');
	}

	/**
	 * 平台审核
	 */
	public function checkOp()
	{
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$data['is_admin_chcked'] = 2;
		$state = $model_refund->updateRefundAdmin($condition,$data);
		if($state)
		{
			showMessage('审核通过','index.php?act=refund&op=refund_terrace','html','error');
					exit;
		}
	}

	/**
	 * 退款退货原因
	 */
	public function reasonOp() {
		$model_refund = Model('refund_return');
		$condition = array();

		$reason_list = $model_refund->getReasonList($condition,10);
		Tpl::output('reason_list',$reason_list);
		Tpl::output('show_page',$model_refund->showpage());

		Tpl::showpage('refund_reason.list');
	}

	/**
	 * 新增退款退货原因
	 *
	 */
	public function add_reasonOp() {
		$model_refund = Model('refund_return');
		if (chksubmit()) {
		    $reason_array = array();
		    $reason_array['reason_info'] = $_POST['reason_info'];
		    $reason_array['sort'] = intval($_POST['sort']);
		    $reason_array['update_time'] = time();

		    $state = $model_refund->addReason($reason_array);
			if ($state) {
			    $this->log('新增退款退货原因，编号'.$state);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=reason');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::showpage('refund_reason.add');
	}

	/**
	 * 编辑退款退货原因
	 *
	 */
	public function edit_reasonOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['reason_id'] = intval($_GET['reason_id']);
		$reason_list = $model_refund->getReasonList($condition);
		$reason = $reason_list[$condition['reason_id']];
		if (chksubmit()) {
		    $reason_array = array();
		    $reason_array['reason_info'] = $_POST['reason_info'];
		    $reason_array['sort'] = intval($_POST['sort']);
		    $reason_array['update_time'] = time();
			$state = $model_refund->editReason($condition, $reason_array);
			if ($state) {
			    $this->log('编辑退款退货原因，编号'.$condition['reason_id']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=reason');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('reason',$reason);
		Tpl::showpage('refund_reason.edit');
	}

	/**
	 * 删除退款退货原因
	 *
	 */
	public function del_reasonOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['reason_id'] = intval($_GET['reason_id']);
		$state = $model_refund->delReason($condition);
		if ($state) {
		    $this->log('删除退款退货原因，编号'.$condition['reason_id']);
		    showMessage(Language::get('nc_common_del_succ'),'index.php?act=refund&op=reason');
		} else {
		    showMessage(Language::get('nc_common_del_fail'));
		}
	}
	
	/**
     * 微信退款 
     *
     */
    public function wxpayOp() {
        $result = array('state'=>'false','msg'=>'参数错误，微信退款失败');
        $refund_id = intval($_GET['refund_id']);
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['refund_id'] = $refund_id;
        $condition['refund_state'] = '1';
        $detail_array = $model_refund->getDetailInfo($condition);//退款详细
        if(!empty($detail_array) && in_array($detail_array['refund_code'],array('wxpay','wx_jsapi','wx_saoma'))) {
            $order = $model_refund->getPayDetailInfo($detail_array);//退款订单详细
            $refund_amount = $order['pay_refund_amount'];//本次在线退款总金额
            if ($refund_amount > 0) {
                $wxpay = $order['payment_config'];
                define('WXPAY_APPID', $wxpay['appid']);
                define('WXPAY_MCHID', $wxpay['mchid']);
                define('WXPAY_KEY', $wxpay['key']);
                $total_fee = $order['pay_amount']*100;//微信订单实际支付总金额(在线支付金额,单位为分)
                $refund_fee = $refund_amount*100;//本次微信退款总金额(单位为分)
                $api_file = BASE_PATH.DS.'api'.DS.'refund'.DS.'wxpay'.DS.'WxPay.Api.php';
                include $api_file;
                $input = new WxPayRefund();
                $input->SetTransaction_id($order['trade_no']);//微信订单号
                $input->SetTotal_fee($total_fee);
                $input->SetRefund_fee($refund_fee);
                $input->SetOut_refund_no($detail_array['batch_no']);//退款批次号
                $input->SetOp_user_id(WxPayConfig::MCHID);
                $data = WxPayApi::refund($input);
                if(!empty($data) && $data['return_code'] == 'SUCCESS') {//请求结果
                    if($data['result_code'] == 'SUCCESS') {//业务结果
                        $detail_array = array();
                        $detail_array['pay_amount'] = ncPriceFormat($data['refund_fee']/100);
                        $detail_array['pay_time'] = time();
                        $model_refund->editDetail(array('refund_id'=> $refund_id), $detail_array);
                        $result['state'] = 'true';
                        $result['msg'] = '微信成功退款:'.$detail_array['pay_amount'];
                        
                        $refund = $model_refund->getRefundReturnInfo(array('refund_id'=> $refund_id));
                        $consume_array = array();
                        $consume_array['member_id'] = $refund['buyer_id'];
                        $consume_array['member_name'] = $refund['buyer_name'];
                        $consume_array['consume_amount'] = $detail_array['pay_amount'];
                        $consume_array['consume_time'] = time();
                        $consume_array['consume_remark'] = '微信在线退款成功（到账有延迟），退款退货单号：'.$refund['refund_sn'];
                        QueueClient::push('addConsume', $consume_array);
                    } else {
                        $result['msg'] = '微信退款错误,'.$data['err_code_des'];//错误描述
                    }
                } else {
                    $result['msg'] = '微信接口错误,'.$data['return_msg'];//返回信息
                }
            }
        }
        exit(json_encode($result));
    }

    /**
     * 支付宝退款 
     *
     */
    public function alipayOp() {
        $refund_id = intval($_GET['refund_id']);
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['refund_id'] = $refund_id;
        $condition['refund_state'] = '1';
        $detail_array = $model_refund->getDetailInfo($condition);//退款详细
        if(!empty($detail_array) && $detail_array['refund_code'] == 'alipay') {
            $order = $model_refund->getPayDetailInfo($detail_array);//退款订单详细
            $refund_amount = $order['pay_refund_amount'];//本次在线退款总金额
            if ($refund_amount > 0) {
                $payment_config = $order['payment_config'];
                $alipay_config = array();
                $alipay_config['seller_email'] = $payment_config['alipay_account'];
                $alipay_config['partner'] = $payment_config['alipay_partner'];
                $alipay_config['key'] = $payment_config['alipay_key'];
                $api_file = BASE_PATH.DS.'api'.DS.'refund'.DS.'alipay'.DS.'alipay.class.php';
                include $api_file;
                $alipaySubmit = new AlipaySubmit($alipay_config);
                $parameter = getPara($alipay_config);
                $batch_no = $detail_array['batch_no'];
                $b_date = substr($batch_no,0,8);
                if($b_date != date('Ymd')) {
                    $batch_no = date('Ymd').substr($batch_no, 8);//批次号。支付宝要求格式为：当天退款日期+流水号。
                    $model_refund->editDetail(array('refund_id'=> $refund_id), array('batch_no'=> $batch_no));
                }
                $parameter['batch_no'] = $batch_no;
                $parameter['detail_data'] = $order['trade_no'].'^'.$refund_amount.'^协商退款';//数据格式为：原交易号^退款金额^理由
                $pay_url = $alipaySubmit->buildRequestParaToString($parameter);
                @header("Location: ".$pay_url);
            }
        }
    }

    /**
	 * 平台介入
	 */
	public function  refund_terraceOp() {
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
		$return_list = $model_refund->getRefundList($condition,10);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('refund_terrace.list');
	}

	public function pay_refundOp()
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

				//--调用第三方支付转账到此卡
				$CMBC = new CMBC($paymentinfo,$order);
				$result = $CMBC->refund();
				$xml= new SimpleXMLElement($result);
				if($xml->Head->Code == 2000) {
					$model_order->editOrder(['refund_state'=>$order['refund_state'] * 10,'finnshed_state'=>1,'ov_time'=>time()],['order_id'=>$order['order_id']]);
					$model_order->editOrderBillState(array('order_id'=>$order['order_id']), 1);
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
						showMessage('操作成功','index.php?act=refund&op=refund_manage');
						exit;
					}

				}else {
					showMessage($xml->Head->Message, '/admin/index.php?act=refund&op=refund_manage');
					exit;
				}
			//快捷支付退款流程
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
				$YL = new CMBC();
				$pay_data = new ArrayObject(['pay_info'=>$paymentinfo,'user_card'=>$cardInfo,'order'=>$order]);
				$result = $YL->setData($pay_data)->refund();
				$xml= new SimpleXMLElement($result); 
				if($xml->Head->Code == 2000) {
					$model_order->editOrder(['refund_state'=>$order['refund_state'] * 10,'finnshed_state'=>1,'ov_time'=>time()],['order_id'=>$order['order_id']]);
						
					$model_order->editOrderBillState(array('order_id'=>$order['order_id']), 1);
					$model_refund->editRefundReturn(array('refund_id'=>$order['refund_id']), $refund_array);
					$this->log('退货确认，退货编号'.$order['refund_sn']);
					$data['seller_state'] = 2;
					$data['refund_state'] = 3;
					$data['admin_time'] = time();
					$data['is_admin_chcked']  =  3;
					$status = $model_refund->editRefundReturn(['refund_id'=>$return_id],$data);
					if($status)
					{
						showMessage('操作成功','index.php?act=refund&op=refund_manage');
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
	public function shut_refundOp()
	{
	
		$return_id = intval($_GET['return_id']);
		$model_refund = Model('refund_return');
		$data['seller_state'] = 1;
		$data['refund_state'] = 2;
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
	
}
