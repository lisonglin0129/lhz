<?php
/**
 * 手机模板设置
 * ============================================================================
 * * 版权所有 2016-2018   科技有限公司，并保留所有权利。
 * 网站地址: php.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: lisonglin
 * Userpay.php 2017年5月9日  Lisonglin
 */
defined('ShopMall') or exit('Access Invalid!');
class mobile_timplateControl extends SystemControl{
	private $sort = ['ASC','DESC'];
	public function __construct(){
		parent::__construct();
	}
	public function settingOp()
	{
		$mobile_slider_model = Model('mobile_slider');
		$img_resouce = $mobile_slider_model->getSliderList(5);
		Tpl::output("img_resource",$img_resouce);
		Tpl::showpage("mobile.setting.edit");
	}
	/**
	 * 分类列表
	 */
	public function catgroyListOp()
	{
		$mobile_catgroy_model = Model('mobile_catgroy');
		$catgroy = $mobile_catgroy_model->getCatgroyList();
		Tpl::output("catgroy",$catgroy);
		Tpl::showpage("mobile.catgroy.list");
	}
	/**
	 * 添加分类
	 */
	public function addCatgroyOp()
	{
		$submit = isset($_GET['submit']) ? $_GET['submit']:'';
		if($submit) {
			$file = $_FILES;
			$file_fillter = ['GIF','PNG','JPG'];
			$file = new ArrayObject(['file'=>$file,'filter'=>$file_fillter]);
			$file_log = Logic("File");
			$post = $_POST;
			$success = $file_log->setFileData($file,"upload_file")->file_write_disk($this->root_path.'js/mobile/catgory',date("YmdHis").md5(date("YmdHis")));
			$data['catgroy_logo'] = json_encode($success);
			$data['url'] = $post['link'];
			$data['catgroy_name'] = $post['catgroy_name'];
			$data['catgroy_state'] = $post['off'];
			$data['sort'] = $post['sort'];
			$mobile_catgroy_model = Model('mobile_catgroy');
			$state = $mobile_catgroy_model->add($data);
			if($state)
			{
				$this->catgroyListOp();
			}
			exit;
		}

		Tpl::showpage("mobile.catgroy.add");
	}
	/**
	 * banner列表
	 */
	public function solideListOp()
	{
		$mobile_slider_model =  Model('mobile_slider');
		$SliderList = $mobile_slider_model->getSliderList();
		Tpl::output("solide",$SliderList);
		Tpl::showpage("mobile.solide.list.index");
	}
	/**
	 * 添加banner
	 * 
	 */
	public function addSolideOp()
	{
		
		$submit = isset($_GET['submit']) ? $_GET['submit']:'';
		if($submit) 
		{
			
			$success = $this->upload();
			if($success['code'] == 'SUCCESS') 
			{
				showMessage('添加成功');
			}
			exit;
		}
		Tpl::showpage("mobile.solide.list.add");
	}
	
	/**
	 * 添加
	 */
	public function addmodOp()
	{
		$submit = isset($_GET['submit']) ? $_GET['submit']:'';
		if($submit)
		{
			$data['type'] = $_POST['mode'];
			$data['name'] = $_POST['name'];
			$data['sort'] = $_POST['sort'];
			$data['url'] = $_POST['link'];
			$data['state'] = $_POST['off'];
			$data['add_time'] = time();
			$mobile_template_model = Model("mobile_template");
			if($mobile_template_model->addTemplates($data))
			{
				showMessage('添加成功','/admin/index.php?act=mobile_timplate&op=modList');
				exit;
			}
			
		}
		Tpl::showpage("mobile.mod.list.add");
	}
	
	public function modListOp()
	{
		$mobile_template_model = Model("mobile_template");
		$templates = $mobile_template_model->getTemplateList();
		Tpl::output('template',$templates);
		Tpl::showpage("mobile.mod.list.index");
	}


	/**
	 * 删除banner
	 * @return [type] [description]
	 */
	public function DelOp()
	{
		$mobile_slider_model = Model('mobile_slider');
		$upload_model = Model('mobile_upload');
		$where['id'] = $_POST['id'];
		$slid  = $mobile_slider_model->getSliderInfo($where);
		$upload_data = $upload_model->getUploadInfo(['upload_id'=>$slid['upload_id']]);
		$status = $mobile_slider_model->del_mobile_banner($where);
		if(is_file($upload_data['upload_path']))
		{
			unlink($upload_data['upload_path']);
		}
		if($upload_data) {
			$upload_model->delUploadFile(['upload_id'=>$slid['upload_id']]);
		}
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
	 * 删除banner
	 * @return [type] [description]
	 */
	public function ajaxDelOp()
	{
		$model = Model('mobile_slider');
		$where['upload_id'] = $_POST['id'];
		$status = $model->del_mobile_banner($where);
		if($status)
		{
			echo 'ok';
		}else{
			echo 'error';
		}
	}

	/**
	 * ajax获取模态框展示信息
	 * @return [type] [description]
	 */
	public function ajaxUpdOp()
	{
		$model = Model('mobile_slider');
		$where['upload_id'] = $_POST['id'];
		$data = $model->getSliderOne($where);
		echo json_encode($data);
	}

	/**
	 * 修改banner
	 * @return [type] [description]
	 */
	public function updateOp()
	{
		$model = Model('mobile_slider');
		$data['name'] = $_POST['name'];
		$data['url'] = $_POST['url'];
		$data['sort'] = $_POST['sort'];
		$data['off'] = $_POST['off'];
		$where['id'] = $_POST['id'];
		$res = $model->update_banner($data,$where);
		$this->solideListOp();
	}

	/**
	 * 展示banner修改页面
	 * @return [type] [description]
	 */
	public function updOp()
	{
		$model = Model('mobile_slider');
		$where['id'] = $_GET['id'];
		$data = $model->getSliderOne($where);
		Tpl::output('data',$data);
		Tpl::showpage('meitu.edit');
	}
	
	public function modListChildOp()
	{
		$id = $_GET['id']; 
		$type_id = $_GET['type_id'];
		$mobile_template_model = Model("mobile_template");
		$Where['template_id'] = $id;
		$template_common = $mobile_template_model->getTemplateCommonList($Where);
		
		Tpl::output('tmp_common',$template_common);
		Tpl::showpage("mobile.mod.child.list.index");
	}
	
	public function addmodListChildOp()
	{
		$submit = isset($_GET['submit']) ? $_GET['submit']:'';
		$mobile_template_model = Model("mobile_template");
		if($submit)
		{
			$file = $_FILES;
			$file_fillter = ['GIF','PNG','JPG'];
			$file = new ArrayObject(['file'=>$file,'filter'=>$file_fillter]);
			$file_log = Logic("File");
			$post = $_POST;
			$success = $file_log->setFileData($file,"upload_file")->file_write_disk($this->root_path.'js/mobile/template',date("YmdHis").md5(date("YmdHis")));
			$data['source'] = json_encode($success);
			$data['sort'] = $_POST['sort'];
			$data['name'] = $_POST['name'];
			$data['template_id'] = $_POST['id'];
			$data['state'] = $_POST['off'];
			$data['url'] = $_POST['link'];
			$type_id = $_POST['type_id'];
			$state = $mobile_template_model->addTemplatesCommon($data);
			if($state)
			{
				showMessage('添加成功',"/admin/index.php?act=mobile_timplate&op=modListChild&id={$data['template_id']}&type_id={$type_id}");
				exit;
			}
		}
		Tpl::showpage("mobile.mod.child.list.add");
	}
	/**
	 * 删除模块
	 */
	public function modRemoveOp()
	{
		$return_json['code'] = 'error';
		$return_json['msg'] = '删除失败!';
		$id = isset($_POST['id'])?$_POST['id']:0;
		$mobile_template_model = Model("mobile_template");
		$Where['template_id'] = $id;
		$mobile_template_common = $mobile_template_model->getTemplateConmmonInfo($Where);
	
		//--检查该模块里面是否有子模块，如果有则不删除
		if(!empty($mobile_template_common))
		{
			$return_json['msg'] = $return_json['msg']." 该类下面存在子模块你不能删除";
			echo json_encode($return_json);
			exit;
		}
		
		$state = $mobile_template_model->reMoveTemplates(['id'=>$id]);
		if($state)
		{
			$return_json['code'] = 'SUCCESS';
			$return_json['msg'] = '删除成功';
		}
		echo json_encode($return_json);
		exit;
	}
	/**
	 * 修改
	 */
	public function modChildUpdateOp()
	{
		$submit = isset($_GET['submit'])?$_GET['submit']:0;
		$mobile_template_model = Model("mobile_template");
		$id = isset($_REQUEST['typeid'])?$_REQUEST['typeid']:0;
		$template_id = isset($_REQUEST['template_id'])?$_REQUEST['template_id']:0;
		$template_common = $mobile_template_model->getTemplateConmmonInfo(['id'=>$id]);
		if($submit == 1)
		{
			$file = $_FILES;
			if($file['upload_file']['size'] > 0) {
				$file_fillter = ['GIF','PNG','JPG'];
				$file = new ArrayObject(['file'=>$file,'filter'=>$file_fillter]);
				$file_log = Logic("File");
				$success = $file_log->setFileData($file,"upload_file")->file_write_disk($this->root_path.'js/mobile/template',date("YmdHis").md5(date("YmdHis")));
				$data['source'] = json_encode($success);
			}
			
			$data['state'] = $_REQUEST['off'];
			$data['url']   = $_REQUEST['link'];
			$data['name']  = $_REQUEST['name'];
			$data['sort']  = $_REQUEST['sort'];
		
			
			$state = $mobile_template_model->updateTmplatesCommon($data,['id'=>$id]);
			if($state)
			{
				showMessage('修改成功',"/admin/index.php?act=mobile_timplate&op=modListChild&id={$template_id}&type_id={$id}");
				exit;
			}
			showMessage('修改失败',"/admin/index.php?act=mobile_timplate&op=modListChild&id={$template_id}&type_id={$id}");
			exit;
		}
		Tpl::output("template_common",$template_common);
		Tpl::showpage("mobile.mod.child.list.update");
	}
	
	/**
	 * 模块修改
	 */
	public function modUpdateOp()
	{
		$mobile_template_model = Model("mobile_template");
		$submit = isset($_GET['submit'])?$_GET['submit']:0;
		if($submit == 1) {
			$Where['id'] = $_POST['templates_id'];
			$data['sort'] = $_POST['sort'];
			$data['name'] = $_POST['name'];
			$data['state'] = $_POST['off'];
			$data['url'] = $_POST['link'];
			$data['type'] = $_POST['mode'];
			
			$state = $mobile_template_model->updateTemplates($data, $Where);
			if($state)
			{
				showMessage('修改成功',"/admin/index.php?act=mobile_timplate&op=modList");
				exit;
			}
			showMessage('修改失败',"/admin/index.php?act=mobile_timplate&op=modList");
			exit;
		}
		$id = $_GET['id'];
		$mobile_template  = $mobile_template_model->findTemplatesById($id);
		Tpl::output('template',$mobile_template);
		Tpl::showpage("mobile.mod.update");
	}
	
	
	/**
	 * 热销商品
	 */
	public function sellingListOp()
	{
		Tpl::showpage("mobile.selling.list");
	}
	
	/**
	 * 添加热销
	 */
	public function addSellingOp()
	{
		Tpl::showpage("mobile.selling.add");
	}

	
	
	
	public function upload()
	{
		$file = $_FILES;
		if($file['upload_file']['size'] == 0)
		{
			showDialog("文件不对","/admin/index.php?act=mobile_timplate&op=addSolide");
		}
		$file_fillter = ['GIF','PNG','JPG'];
		$file = new ArrayObject(['file'=>$file,'filter'=>$file_fillter]);
		$file_log = Logic("File");
		$post = $_POST;
		$success = $file_log->setFileData($file, "upload_file")->file_write_disk($this->root_path.'js/mobile/slider',date("YmdHis").md5(date("YmdHis")));
		if($success)
		{
			$data['name'] = $post['name'];
			$data['url'] = $post['link'];
			$data['off'] = $post['off'];
			$data['sort'] = $post['sort'];
			$files['upload_path'] =  $success['file_path'];
			$files['file_type'] =  $success['file_type'];
			$files['file_size'] =  $success['file_size'];
			$files['success_path'] =  str_replace($this->root_path, '/', $files['upload_path']);
			$files['upload_time'] = $success['create_time'];
			$files['type'] = 1;
			$mobile_slider_model = Model('mobile_slider');
			if($mobile_slider_model->saveSlider($data, $files))
			{
				return [
						'code'=>'SUCCESS',
						'img_path' => $files['success_path']
				];
				exit;
			}
		}else{
			return ['code'=>'error','msg'=>'上传失败'];
			exit;
		}
	
	}
	

	
	/**
	 * 异步文件上传
	 */
	public function ajax_upload()
	{
		$file = $_FILES;
		$file_fillter = ['GIF','PNG','JPG'];
		$file = new ArrayObject(['file'=>$file,'filter'=>$file_fillter]);
		$file_log = Logic("File");
		$post = $_POST;
		$success = $file_log->setFileData($file)->file_write_disk($this->root_path.'js/mobile/slider',date("YmdHis").md5(date("YmdHis")));
		if($success)
		{
			$data['name'] = $post['name'];
			$data['url'] = $post['link'];
			$data['off'] = $post['off'];
			$data['sort'] = $post['sort'];
			$files['upload_path'] =  $success['file_path'];
			$files['file_type'] =  $success['file_type'];
			$files['file_size'] =  $success['file_size'];
			$files['success_path'] =  str_replace($this->root_path, '/', $files['upload_path']);
			$files['upload_time'] = $success['create_time'];
			$files['type'] = 1;
			$mobile_slider_model = Model('mobile_slider');
			if($mobile_slider_model->saveSlider($data, $files))
			{
				echo json_encode([
						'code'=>'SUCCESS',
						'img_path' => $files['success_path']
				]);
				exit;
			}
		}else{
			echo json_decode(['code'=>'error','msg'=>'上传失败']);
			exit;
		}
	
	}
	public function modChildRemoveOp()
	{
		$return_json['code'] = "error";
		$return_json['msg'] = '删除失败';
		$id = $_POST['id'];
		$Where['id'] = $id;
		$mobile_template_model = Model("mobile_template");
		$state = $mobile_template_model->reMoveTeplatesCommon($Where);
		if($state){
			$return_json['code'] = "SUCCESS";
			$return_json['msg'] = '删除成功';
		}
		echo json_encode($return_json);
		exit;
	}
	/**
	 * 获得商品列表
	 */
	public function getgoodsListOp()
	{
		$seachAction = isset($_GET['seach']) ? $_GET['seach'] : '';
		$selectValue = isset($_GET['selectValue']) ? $_GET['selectValue'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$order_by_price = isset($_GET['orderPrice']) ? $_GET['orderPrice'] : '';
		$order_by_time = isset($_GET['orderTime']) ? $_GET['orderTime'] : '';
		$goods_model =  Model("goods");
		$store_model =  Model("store");
		$Where = [];
		$order = '';
		if($seachAction == 1)
		{
			//keyword="+keyword+"&selectValue=
			if($selectValue != 0) {
				$Where['store_id'] = $selectValue;
			}
			if($keyword != '') {
				$Where['goods_name|goods_barcode'] = array(array('like',"{$keyword}%"));
			}
			if($order_by_price != 0)
			{
				$order = goods_price." ".$this->sort[$order_by_price - 1];
			}
			if($order_by_time != 0)
			{
				if($order != '')
				{
					$order = $order. ', ';
				}
				$order = $order . "goods_addtime ".$this->sort[$order_by_time - 1];
			}
		}

		$store = $store_model->getStoreList();
		$goods = $goods_model->getGeneralGoodsList($Where,'*',8,$order);
		$pages = $goods_model->showpage(2);//样式1
		Tpl::setDir("dialog");
		Tpl::output("store",$store);
		Tpl::output("page",$pages);
		Tpl::output("goods",$goods);
		Tpl::showpage("mobile_timplate_goods");
	}
	
}