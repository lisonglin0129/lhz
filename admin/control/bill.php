<?php
/**
 * 结算管理
 */

defined('ShopMall') or exit('Access Invalid!');
class billControl extends SystemControl{
    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;
    
    //--商品佣金
    
    private $goods_commis_rate;
    
    //--商品结算运费

    private $goods_shoping_fee;
    
    //--结算金额
    
    private $order_bill_private;
    
    //--商品运费
    
    private $goods_freight;
    
    //--订单商品总额
    
    private $goods_pay_price;
    
    //--应结金额
    
    private $billreturn;
    
    //--是否结算
    
    private $isbill;
    
    
    private $links = array(
    	array('url'=>'act=bill&op=index','lang'=>'nc_manage'),
    );

    public function __construct(){
    	parent::__construct();
    }

    
    /**
     * 时间转化
     * @param unknown $date
     * @return unknown
     */
    private function MonthDate($date)
    {
    	$date = date_create($date);
    	$date_time[0]  =  date_format($date,"Y-n-01");
    	$date_time[1] = date("Y-n-d",strtotime("+1 Month -1 Day", strtotime($date_time[0])));

    	return $date_time;
    
    }
    
    /**
     * 计算总账
     *
     */
    public function indexOp(){
    	
    	$logic_bill =  Logic("order_bill");
    	
    	$query_year = isset($_GET['query_year']) ? $_GET['query_year'] : 0;
    	
    	$os_month = isset($_GET['os_month']) ? $_GET['os_month'] : 0;
    	
    	$page = isset($_GET['page']) ? $_GET['page'] : 1;
    	
    	$date = '';
    	if(strlen($query_year) > 1  && strlen($os_month) > 0) {
    		$date = $query_year . '-'.$os_month;
    		list($start_time,	$end_time) = $this->MonthDate($date);
    		//--声明变量
    		$bill_count_list = [];
    		//--这里是根据时间来遍历订单结算
    		while(strtotime($start_time) <= strtotime($end_time)) {
    			 $bill_source = $logic_bill->getBillOrderCountList($start_time);
    			 if(!empty($bill_source)) {
    			 	$bill_count_list[] = $bill_source[0];
    			 }
    			 $start_time = date("Y-n-d",strtotime("+1 Day", strtotime($start_time)));
    		}
    	
    		$bill_count_list = $logic_bill->setPageData(new ArrayObject($bill_count_list))->setPageSize(10)->showPage($page);
    	
    		Tpl::output('bill_page',$logic_bill);
    		
    		Tpl::output('bill_count_list',$bill_count_list);
    		//输出子菜单
    		Tpl::output('top_link',$this->sublink($this->links,'index'));
    		
    		Tpl::showpage('bill_order_statis.index');
	    	exit;
    	}
    
        $bill_count_list = new ArrayObject($logic_bill->getBillOrderCountList());
      
        $bill_count_list = $logic_bill->setPageData($bill_count_list)->setPageSize(10)->showPage($page);
     
        Tpl::output('bill_page',$logic_bill);
        
        Tpl::output('bill_count_list',$bill_count_list);
        //输出子菜单
        Tpl::output('top_link',$this->sublink($this->links,'index'));

        Tpl::showpage('bill_order_statis.index');
    }

	/**
	 * 某月所有店铺销量账单
	 *
	 */
	public function show_statisOp(){
		$os_day = $_GET['os_day'];
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$order_logic =  Logic("order_bill");
		$bill_order_list = [];
		$bill_order_list = $order_logic->getGroupByBillOrder($os_day);
		$bill_order_list = $order_logic->setPageData(new ArrayObject($bill_order_list))->setPageSize(10)->showPage($page);
		Tpl::output('bill_page',$order_logic);
		Tpl::output('bill_order_list',$bill_order_list);
		Tpl::showpage('bill_order_statis.show');
	}
	public function ajax_chequesOp()
	{
		$return_json = ['status'=>0,msg=>''];
		$order_id = $_POST['id'];
		$store_joinin  = Model('store_joinin');
		$model_order   = Model('order');
		$model_order_express   = Model('order_express');
		$logic_payment = Logic('payment');
		$paymentinfo = $logic_payment->getPaymentInfo('CMBC');
		$order = $model_order->getOrderInfo(['order_id'=>$order_id]);
		$order['BranchName']	=    '武汉硚口支行';
		$order['Province'] 		=    '湖北';
		$order['City'] 			=    '武汉';
	    if($order['is_bill'] != 1)
		{
			$return_json['msg'] = '还未结算不能收款';
			echo json_encode($return_json);
			exit;
		}

		//--公司的银行卡号信息
		$order['card_number'] = $paymentinfo['data']['payment_config']['CARD_NUMBER'];	
		$order['card_name']   = $paymentinfo['data']['payment_name'];
		$order['BankID']	  = $paymentinfo['data']['payment_config']['CARD_TYPE'];
	
		
		$order['bill_return'] = isset($_POST['bill_return'])? $_POST['bill_return']:0;
		$order['bill_return'] = str_replace(' ', '', $order['bill_return']);
		
		if($order['bill_return'] <= 0)
		{
			$return_json['msg'] = '该订单金额较小，不能收款';
			echo json_encode($return_json);
			exit;
		}

		//--是否是子订单，有则将子类订单改为父类订单
		$order['return_sn'] = empty($order['parent_order'])?$order['order_sn']:$order['parent_order'];
		//--如果是手机支付
		
		if($order['payment_code'] == 'yl')
		{
			$order['return_sn'] = $order['pay_sn'];
		}
		$order['buyer_name']    =    '武汉汉正鑫元科技有限公司';
	
		$CMBC = new CMBC($paymentinfo['data'],$order);
		$result = $CMBC->reBill();
		if($result)
		{
			$xml= new SimpleXMLElement($result);
			if($xml->Head->Code == 2000) {
				$model_order->editChequesState(['order_id'=>$order['order_id']], '1', $order['bill_return']);				
				$return_json['status'] = '1';
				$return_json['msg'] = '收款成功';
			}else {
				$return_json['status'] = (string)$xml->Head->Code;
				$return_json['msg'] = (string)$xml->Head->Message;
			}
		}
		echo json_encode($return_json);
		exit;
	}
	public function ajax_resetBillOp()
	{
		$return_json = ['status'=>0,msg=>''];
		$order_id = $_POST['id'];
		$model_order   = Model('order');
		$order = $model_order->getOrderInfo(['order_id'=>$order_id,'is_bill'=>1]);
		if(empty($order))
		{
			$return_json['msg'] = '没有找到该订单，你还不能再次结算！';
			echo json_encode($return_json);
			exit;
		}
		$order = $model_order->editOrder(['is_bill'=>0],['order_id'=>$order_id]);
		if($order)
		{
			$return_json['status'] = '2000';
			$return_json['msg'] = '立即结算';
			echo json_encode($return_json);
			exit;
		}
	}
	/**
	 * 异步结算
	 */
	public function ajax_billOp()
	{
		$return_json = ['status'=>0,msg=>''];
		$order_id = $_POST['id'];
		$model_order   = Model('order');
		$model_setting = Model('setting');
		$model_seller  = Model('seller');
		$store_joinin  = Model('store_joinin');
		$logic_payment = Logic('payment');
		$paymentinfo = $logic_payment->getPaymentInfo('CMBC');
		$order = $model_order->getOrderInfo(['order_id'=>$order_id]);
	
		
		//--获得银行卡号
		$seller = $model_seller->getSellerInfo(array('store_id'=>$order['store_id']));
		
		
		$cardInfo = $store_joinin->getOne(['member_id'=>$seller['member_id']]);
		if($order['is_bill'] == 1) {
			$return_json['msg'] = '该订单已经结算过了';
			echo json_encode($return_json);
			exit;
		}
		//--商家是否绑定银行卡
		if(empty($cardInfo['card_type']))
		{
			$return_json['msg'] = '银行卡未绑定';
			echo json_encode($return_json);
			exit;
		} 
		//计算运费
		$setting = $model_setting->GetListSetting();	
		//--计算佣金
		$goods = $model_order->getOrderGoodsList(['order_id'=>$order['order_id']]);
	
		//--商家的银行卡号信息
		$order['card_number'] = $cardInfo['settlement_bank_account_number'];
		$order['card_name'] = $cardInfo['card_name'];
		$order['BankID'] = $cardInfo['card_type'];
		$order['ship_fee'] = 0;
		$order['bill_return'] = isset($_POST['bill_return'])? $_POST['bill_return']:0;
		$order['bill_return'] = str_replace(' ', '', $order['bill_return']);
		//--退款订单号

		
		
		//--是否是子订单，有则将子类订单改为父类订单
		$order['return_sn'] = empty($order['parent_order'])?$order['order_sn']:$order['parent_order']; 
		
		//--如果是手机支付
		if($order['payment_code'] == 'yl')
		{
			$order['return_sn'] = $order['pay_sn'];
		}
		
		$order['buyer_name']    =    $cardInfo['settlement_bank_account_name'];
		$order['BranchName']	=    $cardInfo['settlement_bank_name'];
		$order['Province'] 		=    $area[0];
		$order['City'] 			=    $area[1];
	
		
		$CMBC = new CMBC($paymentinfo['data'],$order);
		$result = $CMBC->reBill();
	
		if($result)
		{
			$xml= new SimpleXMLElement($result);
			if($xml->Head->Code == 2000) {
				$model_order->editOrderBillState(['order_id'=>$order['order_id']],1,$order['bill_return']);				
				$return_json['status'] = '1';
				$return_json['msg'] = '结算成功';
				echo json_encode($return_json);
				exit;
			}else {
				$return_json['status'] = (string)$xml->Head->Code;
				$return_json['msg'] = (string)$xml->Head->Message;
			}
		}else {
			$return_json['status'] = 0;
			$return_json['msg'] = 'eroor';
		}
		echo json_encode($return_json);
		exit;
	}
	/**
	 * 某店铺某月订单列表
	 *
	 */
	public function show_billOp(){
		
		$Logic_bill =  Logic("order_bill");
		$pay_sn = $_GET['pay_sn'];
		$order_list = $Logic_bill->calc_bill_order($pay_sn);
		Tpl::output('bill_order_bill',$order_list);
		Tpl::showpage('bill_order_bill.show');
	/* 	
        Tpl::output('tpl_name',$sub_tpl_name);
		Tpl::output('bill_info',$bill_info);
		Tpl::showpage('bill_order_bill.show'); */
	}

	public function bill_checkOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_STORE_COFIRM;
		$update = $model_bill->editOrderBill(array('ob_state'=>BILL_STATE_SYSTEM_CHECK),$condition);
		if ($update){
		    $this->log('审核账单,账单号：'.$_GET['ob_no'],1);
			showMessage('审核成功，账单进入付款环节');
		}else{
		    $this->log('审核账单，账单号：'.$_GET['ob_no'],0);
			showMessage('审核失败','','html','error');
		}
	}
	/**
	 * 第三方支付
	 * @param unknown $config
	 */
	public function _payapi($config)
	{

		$this->isbill  = true;
		$this->order_bill_private = 0;
		$input = array();
		$input['ob_pay_content'] = $_POST['pay_content'];
		$input['ob_pay_date'] = strtotime($_POST['pay_date']);
		$input['ob_state'] = BILL_STATE_SUCCESS;
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_SYSTEM_CHECK;
		$model_bill = Model('bill');
		$order_model = Model('order');
		$model_seller = Model('seller');
		$model_card = Model('card');
		$model_goods = Model('goods');
		$model_setting = Model('setting');
		$store_joinin = Model('store_joinin');
		$setting = $model_setting->GetListSetting();
		$logic_payment = Logic('payment');
		$field = 'order.order_id as oid,order.order_sn,order.pay_sn,order.store_name,
				  order.buyer_id,order.buyer_name,order.add_time,order.payment_code,
				  order.payment_time,order.finnshed_time,order.goods_amount,
				  order.order_amount,order.rcb_amount,order.shipping_fee,order.order_state,
				  order.refund_state,order.lock_state,order.delete_state,order.refund_amount,
				  order.order_from,order.shipping_code,order.is_bill,order.store_id,order_bill.*';
		$order = $order_model->getBillOrder($config,$field);

		$result = $logic_payment->getPaymentInfo('CMBC');
		$paymentinfo = $result[data];
		$bill_list = array();
		$order_data['return_sn'] = array();
		if($order) {
	
			foreach ($order AS $order_data)
			{
				$seller = $model_seller->getSellerInfo(array('store_id'=>$order_data['store_id']));
				$cardInfo = $store_joinin->getOne(['member_id'=>$seller['member_id']]);
				$goods = $order_model->getOrderGoodsList(['order_id'=>$order_data[oid]]);
				$commis_rate = isset($goods[0]['commis_rate'])?$goods[0]['commis_rate']:0;
				$this->order_bill_private = 0;
				foreach ($goods AS $g)
				{
					$this->goods_freight = $model_goods->getGoodsInfo(['goods_id'=>$g['goods_id']],'goods_freight');		
					$this->goods_shoping_fee = $g['goods_pay_price']* ($setting['carry_rate']/100) >= $setting['ratio_limit']  ? $setting['ratio_limit']  : $g['goods_pay_price']* ($setting['carry_rate']/100);
					$this->goods_commis_rate = $g['goods_pay_price'] * ($g['commis_rate']/100);
					$this->order_bill_private += $this->goods_shoping_fee + $this->goods_commis_rate;
					$this->goods_pay_price  +=  $g['goods_pay_price'];
				}
				
				$this->billreturn = $this->goods_pay_price - $this->order_bill_private + $this->goods_freight['goods_freight']-$order_data['refund_amount'];
				$od = $order_model->findByChildOrder(['order_id'=>$order_data['oid']]);
				$order_data['return_sn'] =  isset($od[0]['parent_order']) ? $od[0]['parent_order']:$order_data['order_sn'];
			
    	        if($cardInfo)
				{
					//--要退款的银行卡号
					$order_data['card_number'] = $cardInfo['settlement_bank_account_number'];
					$order_data['card_name'] = $cardInfo['card_name'];
					//--银行卡的名字
					$order_data['BankID'] = $cardInfo['card_type'];
					$order_data['pay_sn'] = 'TK'.$order_data['pay_sn'];
					$order_data['bill_return'] = $this->billreturn;
					$CMBC = new CMBC($paymentinfo,$order_data);
					if($res = $CMBC->reBill())
					{
						$xml= new SimpleXMLElement($res);
						if($xml->Head->Code == 2000) {
							array_push($bill_list, [
									'order_sn' => $order_data['order_sn'],
									'store_name'=>$order_data['store_name'],
									'payment_code' => $order_data['payment_code'],
									'bill_return' => $order_data['bill_return'],
									'ob_shipping' => $order_data['ob_shipping'],
									'order_amount' => $order_data['order_amount'],
									'state' => 1
							]);
							$this->log('账单付款,账单号：'.$order_data['ob_no'],1);
							$order_model->editOrderBillState(['order_id'=>$order_data['oid']],1);
						}else{
							array_push($bill_list, [
									'order_sn' => $order_data['order_sn'],
									'store_name'=>$order_data['store_name'],
									'payment_code' => $order_data['payment_code'],
									'bill_return' => $order_data['bill_return'],
									'ob_shipping' => $order_data['ob_shipping'],
									'order_amount' => $order_data['order_amount'],
									'state' => 0
							]);
							$this->isbill = false;
							$order_model->editOrderBillState(['order_id'=>$order_data['oid']],0);
						}
					}else{
						$this->isbill = false;
						$order_model->editOrderBillState(['order_id'=>$order_data['oid']],0);
						array_push($bill_list, [
								'order_sn' => $order_data['order_sn'],
								'store_name'=>$order_data['store_name'],
								'payment_code' => $order_data['payment_code'],
								'bill_return' => $order_data['bill_return'],
								'ob_shipping' => $order_data['ob_shipping'],
								'order_amount' => $order_data['order_amount'],
								'state' => 1
						]);
					}
				}else{
					showMessage('该用户还未绑定银行卡！！！','','html','error');
				}
				
			}
		    if($this->isbill) {
					$update = $model_bill->editOrderBill($input,$condition);
					if ($update){
						$model_store_cost = Model('store_cost');
						$cost_condition = array();
						$cost_condition['cost_store_id'] = $bill_info['ob_store_id'];
						$cost_condition['cost_state'] = 0;
						$cost_condition['cost_time'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
						$model_store_cost->editStoreCost(array('cost_state'=>1),$cost_condition);
						// 发送店铺消息
						$param = array();
						$param['code'] = 'store_bill_gathering';
						$param['store_id'] = $bill_info['ob_store_id'];
						$param['param'] = array('bill_no' => $bill_info['ob_no']);
						QueueClient::push('sendStoreMsg', $param);
							
						$this->log('账单付款,账单号：'.$_GET['ob_no'],1);					
					}else{
						$this->log('账单付款,账单号：'.$_GET['ob_no'],1);
					} 
			  }
		}
		
	    Tpl::output('bill_list',$bill_list);
		Tpl::showpage('bill_success');
		exit;
	}
	/**
	 * 账单付款
	 *
	 */
	public function bill_payOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
	
		$model_bill = Model('bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_SYSTEM_CHECK;

		$bill_info = $model_bill->getOrderBillInfo($condition);
	
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}
		if (chksubmit()){

			if (!preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_POST['pay_date'])) {
				showMessage('参数错误','','html','error');
			}
			
			$input = array();
			$input['ob_pay_content'] = $_POST['pay_content'];
			$input['ob_pay_date'] = strtotime($_POST['pay_date']);
			$input['ob_state'] = BILL_STATE_SUCCESS;
			if($_POST['pay_method'] == 'CMBC')
			{
				$this->_payapi($bill_info);
				exit;
			}

			$update = $model_bill->editOrderBill($input,$condition);
			if ($update){
			    $model_store_cost = Model('store_cost');
			    $cost_condition = array();
			    $cost_condition['cost_store_id'] = $bill_info['ob_store_id'];
			    $cost_condition['cost_state'] = 0;
			    $cost_condition['cost_time'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
			    $model_store_cost->editStoreCost(array('cost_state'=>1),$cost_condition);
							    
			    // 发送店铺消息
                $param = array();
                $param['code'] = 'store_bill_gathering';
                $param['store_id'] = $bill_info['ob_store_id'];
                $param['param'] = array(
                    'bill_no' => $bill_info['ob_no']
                );
			    QueueClient::push('sendStoreMsg', $param);

			    $this->log('账单付款,账单号：'.$_GET['ob_no'],1);
				showMessage('保存成功','index.php?act=bill&op=show_statis&os_month='.$bill_info['os_month']);
			}else{
			    $this->log('账单付款,账单号：'.$_GET['ob_no'],1);
				showMessage('保存失败','','html','error');
			}
		}else{
			Tpl::showpage('bill.pay');
		}
	}

	/**
	 * 打印结算单
	 *
	 */
	public function bill_printOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_SUCCESS;
		$bill_info = $model_bill->getOrderBillInfo($condition);
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}

		Tpl::output('bill_info',$bill_info);

		Tpl::showpage('bill.print','null_layout');
	}


	/**
	 * 导出平台月出账单表
	 *
	 */
	public function export_billOp(){
	    if (!empty($_GET['os_month']) && !preg_match('/^20\d{4}$/',$_GET['os_month'],$match)) {
	        showMessage('参数错误','','html','error');
	    }
	    $model_bill = Model('bill');
		$condition = array();
		if (!empty($_GET['os_month'])) {
		    $condition['os_month'] = intval($_GET['os_month']);
		}
		if (is_numeric($_GET['bill_state'])) {
		    $condition['ob_state'] = intval($_GET['bill_state']);
		}
		if (preg_match('/^\d{1,8}$/',$_GET['query_store'])) {
			$condition['ob_store_id'] = $_GET['query_store'];
		}elseif ($_GET['query_store'] != ''){
			$condition['ob_store_name'] = $_GET['query_store'];
		}
		if (!is_numeric($_GET['curpage'])){
		    $count = $model_bill->getOrderBillCount($condition);
    		$array = array();
    		if ($count > self::EXPORT_SIZE ){
    		    //显示下载链接
    		    $page = ceil($count/self::EXPORT_SIZE);
    		    for ($i=1;$i<=$page;$i++){
    		        $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
    		        $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
    		        $array[$i] = $limit1.' ~ '.$limit2 ;
    		    }
    		    Tpl::output('list',$array);
    		    Tpl::output('murl','index.php?act=bill&op=index');
    		    Tpl::showpage('export.excel');
    		    exit();
    		}else{
    		    //如果数量小，直接下载
    		    $data = $model_bill->getOrderBillList($condition,'*','','ob_no desc',self::EXPORT_SIZE);
    		}
		}else{
		    //下载
		    $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
		    $limit2 = self::EXPORT_SIZE;
		    $data = $model_bill->getOrderBillList($condition,'*','','ob_no desc',"{$limit1},{$limit2}");
		}

		$export_data = array();
		$export_data[0] = array('账单编号','开始日期','结束日期','订单金额','运费','佣金金额','退款金额','退还佣金','店铺费用','本期应结','出账日期','账单状态','店铺','店铺ID');
		$ob_order_totals = 0;
		$ob_shipping_totals = 0;
		$ob_commis_totals = 0;
		$ob_order_return_totals = 0;
		$ob_commis_return_totals = 0;
		$ob_store_cost_totals = 0;
		$ob_result_totals = 0;
		foreach ($data as $k => $v) {
		    $export_data[$k+1][] = $v['ob_no'];
		    $export_data[$k+1][] = date('Y-m-d',$v['ob_start_date']);
		    $export_data[$k+1][] = date('Y-m-d',$v['ob_end_date']);
		    $ob_order_totals += $export_data[$k+1][] = $v['ob_order_totals'];
		    $ob_shipping_totals += $export_data[$k+1][] = $v['ob_shipping_totals'];
		    $ob_commis_totals += $export_data[$k+1][] = $v['ob_commis_totals'];
		    $ob_order_return_totals += $export_data[$k+1][] = $v['ob_order_return_totals'];
		    $ob_commis_return_totals += $export_data[$k+1][] = $v['ob_commis_return_totals'];
		    $ob_store_cost_totals += $export_data[$k+1][] = $v['ob_store_cost_totals'];
		    $ob_result_totals += $export_data[$k+1][] = $v['ob_result_totals'];
		    $export_data[$k+1][] = date('Y-m-d',$v['ob_create_date']);
		    $export_data[$k+1][] = billState($v['ob_state']);
		    $export_data[$k+1][] = $v['ob_store_name'];
		    $export_data[$k+1][] = $v['ob_store_id'];
		}
		$count = count($export_data);
		$export_data[$count][] = '';
		$export_data[$count][] = '';
		$export_data[$count][] = '合计';
		$export_data[$count][] = $ob_order_totals;
		$export_data[$count][] = $ob_shipping_totals;
		$export_data[$count][] = $ob_commis_totals;
		$export_data[$count][] = $ob_order_return_totals;
		$export_data[$count][] = $ob_commis_return_totals;
		$export_data[$count][] = $ob_store_cost_totals;
		$export_data[$count][] = $ob_result_totals;
		$csv = new Csv();
		$export_data = $csv->charset($export_data,CHARSET,'gbk');
		$csv->filename = $csv->charset('账单-',CHARSET).$_GET['os_month'];
		$csv->export($export_data);
	}

	/**
	 * 导出结算订单明细CSV
	 *
	 */
	public function export_orderOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('bill');
		$bill_info = $model_bill->getOrderBillInfo(array('ob_no'=>$_GET['ob_no']));
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}

		$model_order = Model('order');
		$condition = array();
		$condition['order_state'] = ORDER_STATE_SUCCESS;
		$condition['store_id'] = $bill_info['ob_store_id'];
		$if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
		$if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
		$start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
		$end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']) : null;
		$end_unixtime = $if_end_date ? $end_unixtime+86400-1 : null;
		if ($if_start_date || $if_end_date) {
		    $condition['finnshed_time'] = array('between',"{$start_unixtime},{$end_unixtime}");
		} else {
		    $condition['finnshed_time'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
		}
		if (!is_numeric($_GET['curpage'])){
		    $count = $model_order->getOrderCount($condition);
    		$array = array();
    		if ($count > self::EXPORT_SIZE ){
    		    //显示下载链接
    		    $page = ceil($count/self::EXPORT_SIZE);
    		    for ($i=1;$i<=$page;$i++){
    		        $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
    		        $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
    		        $array[$i] = $limit1.' ~ '.$limit2 ;
    		    }
    		    Tpl::output('list',$array);
    		    Tpl::output('murl','index.php?act=bill&op=show_bill&ob_no='.$_GET['ob_no']);
    		    Tpl::showpage('export.excel');
    		    exit();
    		}else{
    		    //如果数量小，直接下载
    		    $data = $model_order->getOrderList($condition,'','*','order_id desc',self::EXPORT_SIZE,array('order_goods'));
    		}
		}else{
		    //下载
		    $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
		    $limit2 = self::EXPORT_SIZE;
		    $data = $model_order->getOrderList($condition,'','*','order_id desc',"{$limit1},{$limit2}",array('order_goods'));
		}

		//订单商品表查询条件
		$order_id_array = array();
		if (is_array($data)) {
		    foreach ($data as $order_info) {
		        $order_id_array[] = $order_info['order_id'];
		    }
		}
		$order_goods_condition = array();
		$order_goods_condition['order_id'] = array('in',$order_id_array);

		$export_data = array();
		$export_data[0] = array('订单编号','订单金额','运费','佣金','下单日期','成交日期','商家','商家编号','买家','买家编号','商品');
		$order_totals = 0;
		$shipping_totals = 0;
		$commis_totals = 0;
		$k = 0;
		foreach ($data as $v) {
		    //该订单算佣金
		    $field = 'SUM(ROUND(goods_pay_price*commis_rate/100,2)) as commis_amount,order_id';
		    $commis_list = $model_order->getOrderGoodsList($order_goods_condition,$field,null,null,'','order_id','order_id');
		    $export_data[$k+1][] = 'NC'.$v['order_sn'];
		    $order_totals += $export_data[$k+1][] = $v['order_amount'];
		    $shipping_totals += $export_data[$k+1][] = $v['shipping_fee'];
		    $commis_totals += $export_data[$k+1][] = floatval($commis_list[$v['order_id']]['commis_amount']);
		    $export_data[$k+1][] = date('Y-m-d',$v['add_time']);
		    $export_data[$k+1][] = date('Y-m-d',$v['finnshed_time']);
		    $export_data[$k+1][] = $v['store_name'];
		    $export_data[$k+1][] = $v['store_id'];
		    $export_data[$k+1][] = $v['buyer_name'];
		    $export_data[$k+1][] = $v['buyer_id'];
		    $goods_string = '';
		    if (is_array($v['extend_order_goods'])) {
                foreach ($v['extend_order_goods'] as $v) {
                    $goods_string .= $v['goods_name'].'|单价:'.$v['goods_price'].'|数量:'.$v['goods_num'].'|实际支付:'.$v['goods_pay_price'].'|佣金比例:'.$v['commis_rate'].'%';
                }
		    }
		    $export_data[$k+1][] = $goods_string;
		    $k++;
		}
		$count = count($export_data);
		$export_data[$count][] = '合计';
		$export_data[$count][] = $order_totals;
		$export_data[$count][] = $shipping_totals;
		$export_data[$count][] = $commis_totals;
		$csv = new Csv();
		$export_data = $csv->charset($export_data,CHARSET,'gbk');
		$csv->filename = $csv->charset('订单明细-',CHARSET).$_GET['ob_no'];
		$csv->export($export_data);
	}

	/**
	 * 导出结算退单明细CSV
	 *
	 */
	public function export_refund_orderOp(){
	    if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
	        showMessage('参数错误','','html','error');
	    }
	    $model_bill = Model('bill');
	    $bill_info = $model_bill->getOrderBillInfo(array('ob_no'=>$_GET['ob_no']));
	    if (!$bill_info){
	        showMessage('参数错误','','html','error');
	    }

	    $model_refund = Model('refund_return');
		$condition = array();
		$condition['seller_state'] = 2;
		$condition['store_id'] = $bill_info['ob_store_id'];
		$condition['goods_id'] = array('gt',0);
		$if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
		$if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
		$start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
		$end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']) : null;
		$end_unixtime = $if_end_date ? $end_unixtime+86400-1 : null;
		if ($if_start_date || $if_end_date) {
		    $condition['finnshed_time'] = array('between',"{$start_unixtime},{$end_unixtime}");
		} else {
		    $condition['finnshed_time'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
		}
	    if (!is_numeric($_GET['curpage'])){
	        $count = $model_refund->getRefundReturn($condition);
	        $array = array();
	        if ($count > self::EXPORT_SIZE ){	//显示下载链接
	            $page = ceil($count/self::EXPORT_SIZE);
	            for ($i=1;$i<=$page;$i++){
	                $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
	                $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
	                $array[$i] = $limit1.' ~ '.$limit2 ;
	            }
	            Tpl::output('list',$array);
	            Tpl::output('murl','index.php?act=bill&op=show_bill&query_type=refund&ob_no='.$_GET['ob_no']);
	            Tpl::showpage('export.excel');
	            exit();
	        }else{
	            //如果数量小，直接下载
	            $data = $model_refund->getRefundReturnList($condition,'','*,ROUND(refund_amount*commis_rate/100,2) as commis_amount',self::EXPORT_SIZE);
	        }
	    }else{
	        //下载
	        $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
	        $limit2 = self::EXPORT_SIZE;
	        $data = $model_refund->getRefundReturnList(condition,'','*,ROUND(refund_amount*commis_rate/100,2) as commis_amount',"{$limit1},{$limit2}");
	    }
	    if (is_array($data) && count($data) == 1 && $data[0]['refund_id'] == '') {
	        $refund_list = array();
	    }
	    $export_data = array();
	    $export_data[0] = array('退单编号','订单编号','退单金额','退单佣金','类型','退款日期','商家','商家编号','买家','买家编号');
	    $refund_amount = 0;
	    $commis_totals = 0;
	    $k = 0;
	    foreach ($data as $v) {
	        $export_data[$k+1][] = 'NC'.$v['refund_sn'];
	        $export_data[$k+1][] = 'NC'.$v['order_sn'];
	        $refund_amount += $export_data[$k+1][] = $v['refund_amount'];
	        $commis_totals += $export_data[$k+1][] = ncPriceFormat($v['commis_amount']);
	        $export_data[$k+1][] = str_replace(array(1,2),array('退款','退货'),$v['refund_type']);
	        $export_data[$k+1][] = date('Y-m-d',$v['admin_time']);
	        $export_data[$k+1][] = $v['store_name'];
	        $export_data[$k+1][] = $v['store_id'];
	        $export_data[$k+1][] = $v['buyer_name'];
	        $export_data[$k+1][] = $v['buyer_id'];
	        $k++;
	    }
	    $count = count($export_data);
	    $export_data[$count][] = '';
	    $export_data[$count][] = '合计';
	    $export_data[$count][] = $refund_amount;
	    $export_data[$count][] = $commis_totals;
	    $csv = new Csv();
	    $export_data = $csv->charset($export_data,CHARSET,'gbk');
	    $csv->filename = $csv->charset('退单明细-',CHARSET).$_GET['ob_no'];
	    $csv->export($export_data);
	}

	//按订单号进行搜索
	public function order_number_searchOp(){
		$order_sn = isset($_GET['order_sn']) ? $_GET['order_sn'] : '';

		//$page=isseet($_GET['page'])? $_GET['page']:'';
		
        $order_number_search_logic=Logic("order_bill");
        //--查找数据
		$order_number_search_list = $order_number_search_logic->seach_bill_order($order_sn);
		Tpl::output('order_number_search_list', $order_number_search_list);
		Tpl::showpage('order_number_search_show');
	}
}
