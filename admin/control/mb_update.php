<?php
/**
 * 商家商品列表
 * ============================================================================
 * * 版权所有 2016-2018   科技有限公司，并保留所有权利。
 * 网站地址: php.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: lisonglin
 * mb_update.php 2017年9月27日  Lisonglin
 */
defined('ShopMall') or exit('Access Invalid!');
class mb_updateControl extends SystemControl
{
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 添加app
	 */
	public function add_applicationOp()
	{
		$type = isset($_GET['type']) ? intval($_GET['type']) : 0;
		$vession_name = isset($_GET['app_vesion_name']) ? intval($_GET['app_vesion_name']) : 0;
		if($type <= 1) {$type = 1;} 
		if($type >= 2)  {$type = 2;} 
		$logic_file = Logic("file");
		$file['file'] = $_FILES;
		$file['filter'] = array('APK','IPD');
		
		$fileObj = new ArrayObject($file);
	
		if(2 == $type) {
			$result = $logic_file->setFileData($fileObj, "files")->file_copy_disk($this->root_path.'app_update/app_Server','lhz_Sever_'.$vession_name.time(),0,0,true);		
		}else{
			$result = $logic_file->setFileData($fileObj, "files")->file_copy_disk($this->root_path.'app_update/app_Client','lhz_Client_'.$vession_name.time(),0,0,true);	
		}
		echo json_encode($result);
		exit;
	}
	
	/**
	 * 保存表单
	 */
	public function save_applictionOp()
	{
		$return_json = array("code"=>201,'msg'=>'添加失败');
		$app_model = Model("app_vession");
	
		$data = array(
			'vession_name' => $_POST['vession_name'],
			'vession_code' => $_POST['app_vession'],
			'app_name'     => $_POST['files_name'],
			'app_url'      => $_POST['files_server_path'],
			'add_time'     => time(),
			'system_type'  => $_POST['system_type'],
			'app_path'     => $_POST['file_path'],
			'file_name'    => $_POST['files_name'],
			'type'		   => $_POST['type'],
			'is_upload'    => 0,
			'info'		   =>urldecode($_POST['content'])
		);
	
		$status = $app_model->addVession($data);
		if($status) {
			$return_json = array("code"=>200,'msg'=>'添加成功');
		}
		echo json_encode($return_json);
		exit;
	}
	
	
	public function add_appOp()
	{
		Tpl::showpage("mb_update.add");
	}
	
	/**
	 * 修改推送状态
	 */
	public function is_checked_vessionOp()
	{
		$app_model = Model("app_vession");
		$return_json = array('code'=>201,'msg'=>'修改失败');
		$id = intval($_POST['id']);
		$option = intval($_POST['option']);
		$state = $app_model->updateVession(
					array('is_upload' => $option),
					array('id' => $id)
				);
		if($state) {
			$return_json = array('code'=>200,'msg'=>'修改成功');
		}
		echo json_encode($return_json);
		exit;
	}
	
	/**
	 * 版本列表
	 */
	public function mb_update_listOp()
	{
		$app_model = Model("app_vession");
		$res = $app_model->getVessionList();
		Tpl::output("vession",$res);
		Tpl::showpage("mb_update.index");
	}
}