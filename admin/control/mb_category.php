<?php
/**
 * 
 * ============================================================================
 * * 版权所有 2016-2018   科技有限公司，并保留所有权利。
 * 网站地址: php.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: lisonglin
 * Userpay.php 2017年5月8日  Lisonglin
 */
defined('ShopMall') or exit('Access Invalid!');
class mb_categoryControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('mobile');
	}
	/**
	 *
	 */
	public function mb_category_listOp(){
		$lang	= Language::getLangContent();
		$model_link = Model('mb_category');
		/**
		 * 删除
		 */
		/* if ($_POST['form_submit'] == 'ok'){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				foreach ($_POST['del_id'] as $k => $v){
					/**
					 * 删除图片
					 */
					/*$v = intval($v);
					$tmp = $model_link->getOneLink($v);
					if (!empty($tmp['gc_thumb'])){
						@unlink(BASE_ROOT_PATH.DS.DIR_UPLOAD.DS.ATTACH_MOBILE.'/category/'.$tmp['gc_thumb']);
					}
					unset($tmp);
					$model_link->del($v);
				}
				showMessage($lang['link_index_del_succ']);
			}else {
				showMessage($lang['link_index_choose_del']);
			}
		}

		$link_list = $model_link->getLinkList(array());
		/**
		 * 整理图片链接
		 */
		/*if (is_array($link_list)){
			foreach ($link_list as $k => $v){
				if (!empty($v['gc_thumb'])){
					$link_list[$k]['gc_thumb'] = UPLOAD_SITE_URL.'/'.ATTACH_MOBILE.'/category'.'/'.$v['gc_thumb'];
				}
			}
		}*/
		/**
		 * 获取PC端商品一级分类
		 */
		$data = $model_link->getCatgroyList();
		$array=array();
		foreach ($data as $key => $value)
		{
			$array['gc_id'] = $value['gc_id'];
			$array['pc_name'] = $value['gc_name'];
			$array['sort'] = $value['gc_sort'];
			$array['gc_parent_id'] = $value['gc_parent_id'];
			$where['gc_id'] = $value['gc_id'];
			$state = $model_link->getCatgroyInfo($where);
			if(empty($state))
			{
				$model_link->add($array);
			}
		}
		$where = [];
		$where['gc_parent_id'] = 0;
		$arr = $model_link->getMbCatgroyList($where);
		TPl::output('data',$arr);
		Tpl::showpage('mb_category.list');
	}

	/**
	 * 删除
	 */
	public function mb_category_delOp(){
		$lang	= Language::getLangContent();
		if (intval($_GET['gc_id']) > 0){
			$model_link = Model('mb_category');

			/**
			 * 删除图片
			 */
			$tmp = $model_link->getOneLink(intval($_GET['gc_id']));
			if (!empty($tmp['gc_thumb'])){
				@unlink(BASE_ROOT_PATH.DS.DIR_UPLOAD.DS.ATTACH_MOBILE.'/category/'.$tmp['gc_thumb']);
			}
			$model_link->del($tmp['gc_id']);
			showMessage($lang['link_index_del_succ'],'index.php?act=mb_category&op=mb_category_list');
		}else {
			showMessage($lang['link_index_choose_del'],'index.php?act=mb_category&op=mb_category_list');
		}
	}

	/**
	 * 添加
	 */
	public function mb_category_addOp(){

		$lang	= Language::getLangContent();
		$model_link = Model('mb_category');

		if ($_POST['form_submit'] == 'ok'){
			$category = $model_link->getOneLink(intval($_POST['link_category']));
			if (!empty($category)){
				showMessage($lang['link_add_category_exist']);
			}

			/**
			 * 上传图片
			 */
			if ($_FILES['link_pic']['name'] != ''){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_MOBILE.'/category');

				$result = $upload->upfile('link_pic');
				if ($result){
					$_POST['link_pic'] = $upload->file_name;
				}else {
					showMessage($upload->error);
				}
			}

			$insert_array = array();
			$insert_array['gc_id'] = trim($_POST['link_category']);
			$insert_array['gc_thumb'] = trim($_POST['link_pic']);

			$result = $model_link->add($insert_array);
			if ($result){
				$url = array(
					array(
						'url'=>'index.php?act=mb_category&op=mb_category_add',
						'msg'=>$lang['link_add_again'],
					),
					array(
						'url'=>'index.php?act=mb_category&op=mb_category_list',
						'msg'=>$lang['link_add_back_to_list'],
					)
				);
				showMessage($lang['link_add_succ'],$url);
			}else {
				showMessage($lang['link_add_fail']);
			}
		}

		/**
		 * 商品分类
		 */
		$goods_class = Model('goods_class')->getGoodsClassForCacheModel();
		Tpl::output('goods_class',$goods_class);

		Tpl::showpage('mb_category.add');
	}

	/**
	 * 编辑
	 */
	public function mb_category_editOp(){
		$lang	= Language::getLangContent();
		$model_link = Model('mb_category');
		if ($_POST['form_submit'] == 'ok'){

			/**
			 * 上传图片
			 */
			if ($_FILES['link_pic']['name'] != ''){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_MOBILE.'/category');

				$result = $upload->upfile('link_pic');
				if ($result){
					$_POST['gc_thumb'] = $upload->file_name;
				}else {
					showMessage($upload->error);
				}
			}
			$link_array = $model_link->getOneLink(intval($_POST['gc_id']));
			$update_array = array();
			$update_array['gc_id'] = intval($_POST['gc_id']);
			if ($_POST['gc_thumb']){
				$update_array['gc_thumb'] = $_POST['gc_thumb'];
			}
			$result = $model_link->update($update_array);
			if ($result){
				/**
				 * 删除图片
				 */
				if (!empty($_POST['gc_thumb']) && !empty($link_array['gc_thumb'])){
					@unlink(BASE_ROOT_PATH.DS.DIR_UPLOAD.DS.ATTACH_MOBILE.'/category/'.$link_array['gc_thumb']);
				}
				$url = array(
					array(
						'url'=>'index.php?act=mb_category&op=mb_category_edit&gc_id='.intval($_POST['gc_id']),
						'msg'=>$lang['link_edit_again']
					),
					array(
						'url'=>'index.php?act=mb_category&op=mb_category_list',
						'msg'=>$lang['link_add_back_to_list'],
					)
				);
				showMessage($lang['link_edit_succ'],$url);
			}else {
				showMessage($lang['link_edit_fail']);
			}
		}

		$link_array = $model_link->getOneLink(intval($_GET['gc_id']));
		if (empty($link_array)){
			showMessage($lang['wrong_argument']);
		}

		/**
		 * 商品分类
		 */
		$goods_class = Model('goods_class')->getGoodsClassForCacheModel();
		Tpl::output('goods_class',$goods_class);

		Tpl::output('link_array',$link_array);
		Tpl::showpage('mb_category.edit');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 合作伙伴 排序
			 */
			case 'link_sort':
				$model_link = Model('link');
				$update_array = array();
				$update_array['link_id'] = intval($_GET['id']);
				$update_array[$_GET['column']] = trim($_GET['value']);
				$result = $model_link->update($update_array);
				echo 'true';exit;
				break;
		}
	}
	
	
	public function updOp()
	{
		if($_POST['sort'] != '')
		{
			$data['sort'] = $_POST['sort'];
		}
		if($_POST['cate_name'] != '')
		{
			$data['cate_name'] = $_POST['cate_name'];
		}
		if($_POST['state'] != '')
		{
			$data['state'] = $_POST['state'];
		}
		$where['gc_id'] = $_POST['id'];
		$model = Model('mb_category');
		$state = $model->upd($where,$data);
		echo json_encode($state);
	}
	
	public function soneCategoryListOp()
	{
		$model = Model('mb_category');
		$where['gc_parent_id'] = $_GET['gc_id'];
		$data = $model->getSoneCategoryList($where);
		foreach ($data as $key => $value)
		{
			$arr = array();
			$arr['gc_id'] = $value['gc_id'];
			$arr['pc_name'] = $value['gc_name'];
			$arr['cate_name'] = $value['gc_name'];
			$arr['sort'] = $value['gc_sort'];
			$arr['gc_parent_id'] = $value['gc_parent_id'];
			$where = [];
			$where['gc_id'] = $value['gc_id'];
			$state = $model->getCatgroyInfo($where);
			if(empty($state))
			{
				$model->add($arr);
			}
		}
		$where = [];
		$where['gc_parent_id'] = $data[0]['gc_parent_id'];
		$result = $model->getMbCatgroyList($where);
		Tpl::output('data',$result);
		Tpl::showpage('mb_category.list2');
	}
	
	public function sunCategoryListOp()
	{
		$model = Model('mb_category');
		$where['gc_parent_id'] = $_GET['gc_id'];
		$data = $model->getSoneCategoryList($where);
		foreach ($data as $key => $value)
		{
			$arr = array();
			$arr['gc_id'] = $value['gc_id'];
			$arr['pc_name'] = $value['gc_name'];
			$arr['cate_name'] = $value['gc_name'];
			$arr['sort'] = $value['gc_sort'];
			$arr['gc_parent_id'] = $value['gc_parent_id'];
			$where = [];
			$where['gc_id'] = $value['gc_id'];
			$state = $model->getCatgroyInfo($where);
			if(empty($state))
			{
				$model->add($arr);
			}
		}
		$where = [];
		$where['gc_parent_id'] = $data[0]['gc_parent_id'];
		$result = $model->getMbCatgroyList($where);
		$condition['gc_id'] = $_GET['gc_id']; 
		Tpl::output('result',$model->getSoneCategoryList($condition));
		Tpl::output('data',$result);
		Tpl::showpage('mb_category.list3');
	}
	
	public function uploadOp()
	{
		$model = Model('mb_category');
		$where['gc_id'] = $_GET['gc_id'];
		$img_id  = $_GET['img_id'];
		$file = $_FILES;
		$file_fillter = ['GIF','PNG','JPG'];
		$files = new ArrayObject(['file'=>$file,'filter'=>$file_fillter]);
		$file_log = Logic("File");
		$file_name = time();
		$success = $file_log->setFileData($files,$img_id)->file_write_disk($this->root_path.'data/upload/admin/mobile',$file_name);
		//压缩图片
		if($success['file_path']){
			$this->makeThumb($success['file_path'],$success['file_path'],'300','300');
		}
		$data['source'] = $success['success_path'];
		$result = $model->upd($where,$data);
		echo json_encode($result);
	}
	
	

	/**
	 * 得到等比例缩放的长宽
	 */
	public function getNewSize($maxWidth, $maxHeight, $srcWidth, $srcHeight) {
		if($srcWidth > $maxWidth) {
			$maxWidth = $maxWidth;
			if($srcHeight > $maxHeight) {
				$maxHeight = ($srcHeight/$srcHeight) * $maxWidth;
			} else {
				$maxHeight = $srcHeight;
			}
			return array('width' => $maxWidth,'height' => $maxHeight);
		}

		if($srcHeight > $maxHeight) {
			$maxHeight = $maxHeight;
			if($srcWidth > $maxWidth) {
				$maxWidth = ($srcWidth/$srcHeight) * $maxHeight;
			} else {
				$maxWidth = $srcWidth;
			}
			return array('width' => $srcWidth,'height' => $maxHeight);
		}

		return array('width' => $srcWidth,'height' => $srcHeight);
	}
	/**
	 * 等比例生成缩略图
	 *
	 * @param  String  $srcFile  原始文件路径
	 * @param  String  $dstFile  目标文件路径
	 * @param  Integer  $maxWidth  生成的目标文件的最大宽度
	 * @param  Integer  $maxHeight  生成的目标文件的最大高度
	 * @return  Boolean  生成成功则返回true，否则返回false
	 */
	public function makeThumb($srcFile, $dstFile, $maxWidth, $maxHeight) {
		if ($size = getimagesize($srcFile)) {
			$srcWidth = $size[0];
			$srcHeight = $size[1];
			$mime = $size['mime'];
			switch ($mime) {
				case 'image/jpeg';
				$isJpeg = true;
				break;
				case 'image/gif';
				$isGif = true;
				break;
				case 'image/png';
				$isPng = true;
				break;
				default:
					return false;
					break;
			}
			//header("Content-type:$mime");
			$arr = $this->getNewSize($maxWidth, $maxHeight, $srcWidth, $srcHeight);
			$thumbWidth = $arr['width'];
			$thumbHeight = $arr['height'];
			if (isset($isJpeg) && $isJpeg) {
				$dstThumbPic = imagecreatetruecolor($thumbWidth, $thumbHeight);
				$srcPic = imagecreatefromjpeg($srcFile);
				imagecopyresampled($dstThumbPic, $srcPic, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);
				imagejpeg($dstThumbPic, $dstFile, 100);
				imagedestroy($dstThumbPic);
				imagedestroy($srcPic);
				return true;
			} elseif (isset($isGif) && $isGif) {
				$dstThumbPic = imagecreatetruecolor($thumbWidth, $thumbHeight);
				//创建透明画布
				imagealphablending($dstThumbPic, true);
				imagesavealpha($dstThumbPic, true);
				$trans_colour = imagecolorallocatealpha($dstThumbPic, 0, 0, 0, 127);
				imagefill($dstThumbPic, 0, 0, $trans_colour);
				$srcPic = imagecreatefromgif($srcFile);
				imagecopyresampled($dstThumbPic, $srcPic, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);
				imagegif($dstThumbPic, $dstFile);
				imagedestroy($dstThumbPic);
				imagedestroy($srcPic);
				return true;
			} elseif (isset($isPng) && $isPng) {
				$dstThumbPic = imagecreatetruecolor($thumbWidth, $thumbHeight);
				//创建透明画布
				imagealphablending($dstThumbPic, true);
				imagesavealpha($dstThumbPic, true);
				$trans_colour = imagecolorallocatealpha($dstThumbPic, 0, 0, 0, 127);
				imagefill($dstThumbPic, 0, 0, $trans_colour);
				$srcPic = imagecreatefrompng($srcFile);
				imagecopyresampled($dstThumbPic, $srcPic, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);
				imagepng($dstThumbPic, $dstFile);
				imagedestroy($dstThumbPic);
				imagedestroy($srcPic);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 压缩上传
	 */
	
	public function compressOp()
	{
		$model = Model('mb_category');
		$where['gc_id'] = $_GET['gc_id'];
		$base64_image_content = $_POST['img'];
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
			$type = $result[2]; //jpeg
			$img = base64_decode(str_replace($result[1], '', $base64_image_content)); //返回文件流
		}
		/* 输出到文件 */
		//方式一：直接使用file_put_contents
		$tmp_file = time(). '.' .$type;
		$path = '../data/upload/admin/mobile/'.$tmp_file;
		file_put_contents($path,$img); //可以直接将文件流保存为本地图片
		$arr = $model->getCatgroyInfo($where);
		$source = '../'.$arr['source'];
		if(file_exists($source)){
			unlink($source);
		}
		$data['source'] = '/data/upload/admin/mobile/'.$tmp_file;
		$result = $model->upd($where,$data);
		echo json_encode($result);
	}

}
