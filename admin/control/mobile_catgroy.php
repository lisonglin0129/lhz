<?php
defined('ShopMall') or exit('Access Invalid!');
class mobile_catgroyControl extends SystemControl
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 手机页面分类列表
	 * @return [type] [description]
	 */
	public function catgroyOp()
	{
		$model = Model('mobile_catgroy');
		$data = $model->sel();
		TPl::output('data',$data);
		if(empty($data))
		{
			TPl::showpage('add_catgroy');
		}else{
			TPl::showpage('catgroy');
		} 
		
	}

	/**
	 * 添加分类
	 */
	public function addOp()
	{
		$model = Model('mobile_catgroy');
		$data['catgroy_name'] = $_POST['name'];
		$data['catgroy_state'] = $_POST['state'];
		
		$status = $model->add($data);
		if($status)
		{
			$this->catgroyOp();
		}else{
			TPl::showpage('add_catgroy');
		}
	}

	

	/**
	 * 删除分类
	 * @return [type] [description]
	 */
	public function DelOp()
	{
		$model = Model('mobile_catgroy');
		$where['mobile_catgroy_id'] = $_POST['id'];
		$data  = $model->sel($where);

		$upload_data = $model->getCatgroyList($where);
		if(count($upload_data)<0)
		{
			echo json_encode([
					'code'=>'error',
					'msg' =>'删除失败'
			]);exit;
		}
		if(is_file($upload_data['file_path']))
		{
			unlink($upload_data['file_path']);
		}
		$status = $model->del($where);
		// if($upload_data) {
		// 	$upload_model->delUploadFile(['upload_id'=>$slid['upload_id']]);
		// }
		if($status)
		{
			echo json_encode([
					'code'=>'SUCCESS',
					'msg' =>'删除成功' 
			]);
		}else{
			echo json_encode([
					'code'=>'error',
					'msg' =>'删除失败'
			]);
		}
		exit;
		
	}

	/**
	 * ajax验证类别名称是否重复
	 * @return [type] [description]
	 */
	public function catgroy_nameOp()
	{
		$model = Model('mobile_catgroy');
		$where['catgroy_name'] = $_GET['name'];
		$list = $model->sel($where);
		if (empty($list)){
			echo 'true';exit;
		}else {
			echo 'false';exit;
		}
	}

	/**
	 * 修改分类
	 */
	public function upd_catgroyOp()
	{
		$model = Model('mobile_catgroy');
		$where['mobile_catgroy_id'] = $_GET['id'];
		$data = $model->getCatgroyInfo($where);
		TPl::output('data',$data);
		Tpl::showpage('catgroy.edit');
	}

	/**
	 * 修改分类
	 * @return [type] [description]
	 */
	public function updateOp()
	{
		$model = Model('mobile_catgroy');
		$where['mobile_catgroy_id'] = $_POST['id'];
		$data['catgroy_name'] = $_POST['name'];
		$data['catgroy_state'] = $_POST['catgroy_state'];
		$data['url'] = $_POST['url'];
		$data['sort'] = $_POST['sort'];
		$status = $model->upd($where,$data);
		$catgroy = $model->getCatgroyList();
		Tpl::output("catgroy",$catgroy);
		Tpl::showpage("mobile.catgroy.list");	
	}
}
?>