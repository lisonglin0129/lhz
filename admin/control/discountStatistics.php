<?php
defined('ShopMall') or exit('Access Invalid!');
class discountStatisticsControl extends SystemControl
{
	public function __construct()
	{
		parent::__construct();
		//--上传目录
		$SystemDIr =  str_replace('/admin/control/discount.php', '', str_replace('\\', '/', __FILE__));
		Language::read('activity');
	}
	/**
	 * 动态HighChart ， 注意这里是通过Ajax来调用的，返回为Json格式数据
	 */
	public function AjaxTusOp()
	{
		$post = isset($_POST['date']) ? $_POST['date'] : time();
		$times  = $this->getTheMonthDay($post);
		$start_time = strtotime(trim($times[0]));
		$end_time = strtotime(trim($times[1]));
		$discountStatistics_model = Model('discountStatistics');
		$field = 'SUM(amount) AS amount  ,COUNT(*) AS num ,pay_sn';
		$Where['use_time'] = ['BETWEEN',"{$start_time},{$end_time}"];
		$Where['type'] = 1;
		$group = 'pay_sn';
		$success = $discountStatistics_model->getDiscountStatisticsList($Where, $field, $group);
	
		echo $this->createData($success);
		exit;
	}
	/**
	 * 默认数据格式为列表模式
	 */
	public function discountStatisticsOp()
	{
		$discount_logcat = Logic('discount');
		$discountStatistics = Model('discountStatistics');
		$field = 'SUM(amount) AS amount , SUM(discount_price) AS discount_price,SUM(order_amount)  AS order_amount  ,COUNT(*) AS num ,type AS type,pay_sn';
		$times  = $this->getTheMonthDay(time());
		$start_time = strtotime($times[0]);
		$end_time = strtotime($times[1]);
		$Where['use_time'] = ['BETWEEN',"{$start_time},{$end_time}"];
        $Where['type'] = 1;
        $grounp = 'pay_sn';
        $discountStatisticsList = $discountStatistics->getDiscountStatisticsList($Where,$field,$grounp);
		TPl::output('Chart', base64_encode($this->createData($discountStatisticsList)));
		TPl::output('resultcount',$discount_logcat->getDiscountStatis($discountStatistics));
		TPl::output('discountStatisticsData' , $discountStatisticsList);
		Tpl::showpage("discount.statistics");
	}
	/**
	 * 筛选
	 */
	public function seachOp()
	{
		$Where = [];
		$times  = $this->getTheMonthDay(time());
		$type = isset($_GET['type']) ? $_GET['type'] : 0;
		$cardType = isset($_GET['cardType']) ? intval($_GET['cardType']) : 3;
		if(3 != $cardType){
			$Where['type'] = $cardType;
		}
		$start_time =  !empty($_GET['start_time']) ? $_GET['start_time'] : '';
		$end_time   =  !empty($_GET['end_time']) ? $_GET['end_time'] : '';
		$start_unix_time  =  strtotime($start_time);
		$end_unix_time  =  strtotime($end_time);
		$discountStatistics = Model('discountStatistics');
		$field = 'SUM(amount) AS amount , SUM(discount_price) AS discount_price,SUM(order_amount)  AS order_amount  ,COUNT(*) AS num ,type AS type,pay_sn';
		$discountStatisticsList = [];
		$grounp = 'pay_sn';
		$discount_logcat = Logic('discount');
	
		switch($type)
		{
			case 1:{
				
				$start_unix_time = $start_time == '' ? strtotime($times[0]) : $start_unix_time;
				$end_unix_time = $end_time == '' ? strtotime($times[1]) : $end_unix_time;
				$Where['use_time'] = ['BETWEEN',"{$start_unix_time},{$end_unix_time}"];
				$discountStatisticsList = $discountStatistics->getDiscountStatisticsList($Where, $field, $grounp);
				TPl::output('Chart',base64_encode($this->createData($discountStatisticsList)));
				TPl::output('discountStatisticsData', $discountStatisticsList);
	
				break;
			}
			case 2:{
				$discountStatisticsList = $this->getTheMonth($start_unix_time, $end_unix_time,  $grounp);
				TPl::output('Chart',base64_encode($this->createData($discountStatisticsList)));
				TPl::output('discountStatisticsData', $discountStatisticsList);
		
				break;
			}
			case 3:{
				break;
			}
		}
	
		TPl::output('resultcount', $discount_logcat->getDiscountStatis($discountStatistics));
		Tpl::showpage("discount.statistics");
	}
	
	/**
	 * 构造统计图数据，这里是Json数据格式
	 * @param unknown $data
	 */
	private function createData($data)
	{
		$count = count($data['data']);
		$str = '';
		for($i = 0; $i<$count; $i++)
		{
			$str = $str."[{$data['data'][$i]['start_time']},{$data['data'][$i]['num']}],";
		}
		$success =  substr($str, 0,strlen($str)-1);
		return "[{$success}]";
	}
	/**
	 * 按月份统计
	 * @param string $start_month_unix_time
	 * @param string $end_month_unix_time
	 */
	private function getTheMonth($start_month_unix_time = '',$end_month_unix_time ='', $group = '')
	{
	
		$field = 'SUM(amount) AS amount , SUM(discount_price) AS discount_price,SUM(order_amount)  AS order_amount  ,COUNT(*) AS num ,type,pay_sn';
		$discountStatistics_model = Model('discountStatistics');
		$start_unix_month =  $start_month_unix_time;
		$end_unix_month   =  $end_month_unix_time;
		$i = 0; $j = 0;
		if($cardType != 3) {
			$Where['type'] = $cardType;
		
		}
		$data = [];
		$grounp = 'pay_sn';
		if($start_unix_month != '') {
			$start_seach_month =  $start_month_unix_time + 1;
			$end_current_date = $end_month_unix_time;
			$end_seach_month = strtotime("+1 month -1 day", $end_current_date);
			$where['use_time'] = ['BETWEEN',"{$start_seach_month},{$end_seach_month}"];
			$data['discount_month'] = $discountStatistics_model->getDiscountStatisticsGather($where, $field, $group);
			$start_seach_month = '';
			$end_seach_month = '';
			$where['use_time'] = '';
			while(($current_time = strtotime("+{$i} month",$start_unix_month)) <= $end_unix_month) {
				$start_seach_month = $current_time + 1;
				$end_seach_month = (strtotime("+1 month -1 day",$current_time) + 86400) - 1;
				$where['use_time'] = ['BETWEEN',"{$start_seach_month},{$end_seach_month}"];
				$data['data'][$i] = $discountStatistics_model->getDiscountStatisticsGather($where, $field, $group);
				$data['data'][$i]['start_time'] = $start_seach_month == ''? time() : $start_seach_month;
				if($data['data'][$i]['num'] == 0)
				{
					$data['data'][$i]['num'] = 0;
					$data['data'][$i]['amount'] = sprintf("%.2f",'0');
					$data['data'][$i]['discount_price'] = sprintf("%.2f",'0');
					$data['data'][$i]['order_amount'] = sprintf("%.2f",'0');
				}
				$i++;
			}
		}else {
			$start_uninx_time  =  strtotime($start_time);
			$end_uninx_time    =  strtotime($end_time);
			$where['use_time'] = ['BETWEEN',"{$start_uninx_time},{$end_uninx_time}"];
			$data['discount_month'] = $discountStatistics_model->getDiscountStatisticsGather($where, $field, $group);
			while($j<=12)
			{
				$start_time = date("Y-$j-01", time());
				$end_time   = date('Y-m-d', strtotime("$start_time  +1 month -1 day"));
				$start_uninx_time  =  strtotime($start_time);
				$end_uninx_time    =  strtotime($end_time);
				$where['use_time'] = ['BETWEEN',"{$start_uninx_time},{$end_uninx_time}"];
				$data['data'][$j] = $discountStatistics_model->getDiscountStatisticsGather($where, $field, $group);
				$data['data'][$j]['start_time'] = strtotime($start_time);
				if($data['data'][$j]['num'] == 0)
				{
					$data['data'][$j]['num'] = 0;
					$data['data'][$j]['amount'] = sprintf("%.2f",'0');
					$data['data'][$j]['discount_price'] = sprintf("%.2f",'0');
					$data['data'][$j]['order_amount'] = sprintf("%.2f",'0');
				}
				$j++;
			
			}
	    }
		return $data;
	}
	/**
	 * 优惠券，按价格赛选
	 */
	public function usecountOp()
	{
		$disountStatistics_model = Model("DiscountStatistics");
		$time = isset($_GET['time'])? $_GET['time'] : time();
	
		//--默认是按每天来计算，这里是当夜的第一天时间，和最后一天的时间，之间的时间域
		$dateTime = $this->getTheMonthDay($time);
	    $start_date  =  $dateTime[0];

	    $end_date = $dateTime[1];
	    $start_unix_date = strtotime($dateTime[0]);
	    $end_unix_date = strtotime($dateTime[1]);
	    $group = 'pay_sn';
		//--- 开始时间
		$field = '*,COUNT(*) AS store_num,SUM(amount) AS amount,SUM(order_amount) AS order_amount, SUM(discount_price - amount) AS discount_amount';
	
		$start_seach_day_time = $start_unix_date; $end_seach_day_time = $end_unix_date;
		$where['use_time'] = ['BETWEEN',"{$start_seach_day_time},{$end_seach_day_time}"];
	
		$success['discount'] = $disountStatistics_model->getDiscountStatisticsByuse($where,$field,$group);
	
		TPL::output('DiscountStatisticsList', $success);
		Tpl::showpage("discount.statistics.count");
	}
	/**
	 * 每月按优惠券来排序
	 */
	public function useSeachOp()
	{
		$disountStatistics_model = Model("DiscountStatistics");
		$start_time =  isset($_GET['start_time']) ? $_GET['start_time']:'';
		$end_time   =  isset($_GET['end_time']) ? $_GET['end_time']:'';
		$start_unix_time = strtotime($start_time);
		$end_unix_time = strtotime($end_time);
		$type   =  isset($_GET['type']) ? $_GET['type']:'';
		$rul   =  isset($_GET['rul']) ? $_GET['rul']:'';
		$field = '*,COUNT(*) AS store_num,SUM(amount) AS amount,SUM(order_amount) AS order_amount, SUM(discount_price - amount) AS discount_amount';
		$where = array();
		$group = 'pay_sn';
		//--时间过滤
		if($start_unix_time && $end_unix_time) {
			$where['use_time'] = ['BETWEEN',"{$start_unix_time},{$end_unix_time}"];
			$where['type'] = $type;
	    }
	    $success['discount'] = $disountStatistics_model->getDiscountStatisticsByuse($where,$field,$group);
	    TPL::output('DiscountStatisticsList', $success);
		Tpl::showpage("discount.statistics.count");
	}
	/**
	 * 返回当前月份的第一天和最后一天
	 * @param unknown $date
	 */
	private function getTheMonthDay($date)
	{
		$date = date('Y-m-d',$date);
		$firstday = date('Y-m-01', strtotime($date));
		$lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
		return array($firstday,$lastday);
	}
}