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
class mb_paymentControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        $this->payment_listOp();
    }

    public function payment_listOp() {
        $model_mb_payment = Model('mb_payment');
        $mb_payment_list = $model_mb_payment->getMbPaymentList();
        Tpl::output('mb_payment_list', $mb_payment_list);
        Tpl::showpage('mb_payment.list');
    }

    /**
     * 编辑
     */
    public function payment_editOp() {
        $payment_id = intval($_GET["payment_id"]);

        $model_mb_payment = Model('mb_payment');

        $mb_payment_info = $model_mb_payment->getMbPaymentInfo(array('payment_id' => $payment_id));

        Tpl::output('config_array',$mb_payment_info['payment_config']);
        Tpl::output('payment', $mb_payment_info);
        Tpl::showpage('mb_payment.edit');
    }

    /**
     * 编辑保存
     */
    public function payment_saveOp() {
        $payment_id = intval($_POST["payment_id"]);

        $data = array();
        $data['payment_state'] = intval($_POST["payment_state"]);

        switch ($_POST['payment_code']) {
            case 'alipay':
                $payment_config = array(
                    'alipay_account' => $_POST['alipay_account'],
                    'alipay_key' => $_POST['alipay_key'],
                    'alipay_partner' => $_POST['alipay_partner'],
                );
                break;
            case 'wxpay':
                $payment_config = array(
                    'wxpay_appid' => $_POST['wxpay_appid'],
                    'wxpay_mch_id' => $_POST['wxpay_mch_id'],
                    'wxpay_appsecret' => $_POST['wxpay_appsecret'],
				    'wxpay_key' => $_POST['wxpay_key'],
                );
                break;
            case 'CMBC':
                $payment_config = array(
                    'institutionID' => $_POST['institutionID'],
                    'PAYURL' => $_POST['PAYURL'],
                    'PAYURL2' => $_POST['PAYURL2'],
                    'TXURL' => $_POST['TXURL'],
                    'TXURL2' => $_POST['TXURL2'],
                    'PUBLIC_KEY' => $_POST['PUBLIC_KEY'],
                    'PRIVATE_KEY' => $_POST['PRIVATE_KEY'],
                    'PRIVATE_KEY_PASSWORD' => $_POST['PRIVATE_KEY_PASSWORD'],
                    'SSL_KEY' => $_POST['SSL_KEY'],
                    'NotificationURL' => $_POST['NotificationURL'],
                    'SSL_KEY' => $_POST['SSL_KEY'],
                    'CARD_TYPE' => $_POST['CARD_TYPE'],
                    'CARD_NUMBER' => $_POST['CARD_NUMBER'],
                    );
                break;
            default:
                showMessage(L('param_error'), '');
        }
        $data['payment_config'] = $payment_config;

        $model_mb_payment = Model('mb_payment');

        $result = $model_mb_payment->editMbPayment($data, array('payment_id' => $payment_id));
        if($result) {
            showMessage(Language::get('nc_common_save_succ'), urlAdmin('mb_payment', 'payment_list'));
        } else {
            showMessage(Language::get('nc_common_save_fail'), urlAdmin('mb_payment', 'payment_list'));
        }
    }
}
