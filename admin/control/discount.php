<?php
defined('ShopMall') or exit('Access Invalid!');
class discountControl extends SystemControl{
	private $upload_path;
	public function __construct()
	{
		parent::__construct(); 
		//--上传目录
		$SystemDIr =  str_replace('/admin/control/discount.php', '', str_replace('\\', '/', __FILE__));
		$this->upload_path = $SystemDIr . '/data/upload/shop';
		Language::read('activity');
	}
	/**
	 * 入口
	 */
	public function indexOp()
	{
		$model_discount  =  Model("discount");
		$where = array();
		if (!empty($_GET['searchtitle'])){
			$where['name'] = array('like', '%' . $_GET['searchtitle'] . '%');
		}
		//有效期范围
		if (!empty($_GET['searchstartdate']) && !empty($_GET['searchenddate'])){
			$StartTime = strtotime($_GET['searchstartdate']);
			$endTime = strtotime($_GET['searchenddate']);
			$where['start_time'] = array('egt',$StartTime);
			$where['end_time'] = array('elt',$endTime);
		}
		//活动列表
		/* $page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$list	= $activity->getList($condition_arr,$page); */
	
		$discountList = $model_discount->getDiscountList($where,'*',5);
		Tpl::output('discountList',$discountList);
		Tpl::output('show_page',$model_discount->showpage(2));
		Tpl::showpage("discount.index");
	}
	//--删除
	public function delOp()
	{
		$return_json['status'] = 0;
		$return_json['msg'] = '删除失败';
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		if(Model('discount')->delDiscount(['discount_id'=>$id]))
		{	
			$return_json['status'] = 1;
			$return_json['msg'] = '删除成功';
		}
		echo json_encode($return_json);
		exit;
	}
	//--审核
	public function ischeckOp()
	{
		$return_json['status'] = 0;
		$return_json['msg'] = '审核失败';
		$discount_id = isset($_POST['discount_id'])?intval($_POST['discount_id']):'';
		if($discount_id == '')
		{
			echo json_encode($return_json);
			exit;
		}
		
		if(Model('discount')->isDiscountChecked(['discount_id'=>$discount_id],2))
		{
			$return_json['status'] = 2000;
			$return_json['msg'] = '审核通过';
			echo json_encode($return_json);
			exit;
		}
		echo json_encode($return_json);
		exit;
	}
	//--添加
	public function newOp()
	{
		if(chksubmit())
		{
			$discount_goods  = Model("discount_goods");
			$model_discount  = Model("discount");
			$model_goods  = Model('goods');
			$data['name'] 		= 	$_POST['waybill_name'];
			$data['type']		= 	$_POST['waybill_express'];
			$data['ischecked']  =   $_POST['activity_state'];
			$data['is_system']	=   1;
			$data['addtime'] 	= 	time();
			$data['start_time'] = 	strtotime($_POST['activity_start_date']);
			$data['end_time'] 	= 	strtotime($_POST['activity_end_date']);
			//--金额
			$data['amount'] 	= 	$_POST['amount'];
			//--兑换商品累计金额下限
			$data['max_amount'] = 	0;
			//--兑换金额上限
			$data['min_amount'] = 	$_POST['min_amount'];
			//总数量
			$data['num'] 		=   $_POST['number'] == 0 ? '999999999' : $_POST['number'];
			$data['ceiling']    =   $_POST['max_ceiling'];
			//--领取数量上限
			$data['max_number'] =   	$_POST['max_ceiling'];
			$data['member_id'] 	=       '';
			$data['store_id']  	=       '';
			$data['shop_name']  =       '';
			$data['discount_image'] = '';
			if($_FILES['customimg']['size'] != 0)
			{
				$data['discount_image'] =  $this->upload();
			}
			$model_discount->addDiscount($data,null,true);
			showMessage('添加成功');
		}
		Tpl::showpage("discount.add");
	}
	//查找分类最多三级
	public function selectCatOp()
	{
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$data = isset($_POST['data']) ? $_POST['data'] : '';
	
		$cat = isset($_POST['cat']) ? $_POST['cat'] : 0;
		$condition = array();
		if($type == 'goods')
		{
			$data = json_decode(base64_decode($data));
			$model_goods = Model("goods");
			foreach ($data AS $key => $value)
			{
				if(strlen($value) <= 0)
				{
					continue;
				}
				$condition[$key] = $value;
			}
			$goods  = $model_goods->getGoodsList($condition);
			
			for($i = 0; $i<count($goods); $i++)
			{
				
				$goods[$i]['goods_image'] = cthumb($goods[$i]['goods_image'],240);
			}
			echo base64_encode(json_encode($goods));
			exit;
		}
		
		$model_goods_class = Model('goods_class');
		if(0 == $cat) {
			$goods_class = $model_goods_class->getGoodsClassListByParentId(0);
		}else{
			$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;
			$goods_class = $model_goods_class->getChildClass($cat_id);
		}
		echo base64_encode(json_encode($goods_class));
		exit;
	}
	//--上传
	private function upload()
	{
		if(count($_FILES['customimg']) <=0)
		{
			return false;
		}
		$file_extention = ['image/jpg','image/gif','image/png','image/bmp','image/jpeg'];
		$upload_path = $this->upload_path.'/discount';

		//--图片格式是否合法,如果不合法下面这不用执行
		if(!in_array($_FILES['customimg']['type'], $file_extention))
		{
			return false;
		}
		$fileSize =  $_FILES['customimg']['size']/1024>>0;
		$rawImagePath  = $_FILES['customimg']['tmp_name'];
	
		//-- 文件不存在过大
		if($fileSize >= 2000)
		{
			return false;
		}
		$dir = date('Ymd',time());
		$upload_path = $upload_path.'/'.$dir;
		//--递归创建目录，有则不创建
		if(!is_dir($upload_path))
		{	
			mkdir($upload_path,'0777',true);
		}
	
		$rawimage  = fopen($rawImagePath,'r');
		$file_extends = @pathinfo($_FILES['customimg']['name'], PATHINFO_EXTENSION);
	
		$file_name = rand(100,900).time().'.'.$file_extends;
		$upload_file = $upload_path.'/'.$file_name;
	
		$image = fopen($upload_file,'a+');
		while(!feof($rawimage))
		{
			fwrite($image, fgets($rawimage));
		}
		fclose($rawimage);
		fclose($image);
	
		return $dir.'/'.$file_name;
	}
}