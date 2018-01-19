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
class mb_feedbackControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('mobile');
	}
	/**
	 * 意见反馈
	 */
	public function flistOp(){
		$model_mb_feedback = Model('mb_feedback');
		$list = $model_mb_feedback->getMbFeedbackList(array(), 10);

		Tpl::output('list', $list);
		Tpl::output('page', $model_mb_feedback->showpage());
		Tpl::showpage('mb_feedback.index');
	}

	/**
	 * 删除
	 */
	public function delOp(){
        $model_mb_feedback = Model('mb_feedback');
        $result = $model_mb_feedback->delMbFeedback($_POST['feedback_id']);
		if ($result){
			showMessage(L('nc_common_op_succ'));
		}else {
			showMessage(L('nc_common_op_fail'));
		}
	}
}
