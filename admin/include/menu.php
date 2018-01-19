<?php
/**
 * 菜单 
 */
defined('ShopMall') or exit('Access Invalid!');
/**
 * top 数组是顶部菜单 ，left数组是左侧菜单
 * left数组中'args'=>'welcome,dashboard,dashboard',三个分别为op,act,nav，权限依据act来判断
 */
$arr = array(
		'top' => array(
			0 => array(
				'args' 	=> 'dashboard',
				'text' 	=> $lang['nc_console']),
			1 => array(
				'args' 	=> 'setting',
				'text' 	=> $lang['nc_config']),
			2 => array(
				'args' 	=> 'goods',
				'text' 	=> $lang['nc_goods']),
			3 => array(
				'args' 	=> 'store',
				'text' 	=> $lang['nc_store']),
			4 => array(
				'args'	=> 'member',
				'text'	=> $lang['nc_member']),
			5 => array(
				'args' 	=> 'trade',
				'text'	=> $lang['nc_trade']),
			6 => array(
				'args'	=> 'website',
				'text' 	=> $lang['nc_website']),
			7 => array(
				'args'	=> 'operation',
				'text'	=> $lang['nc_operation']),
			8 => array(
				'args'	=> 'stat',
				'text'	=> $lang['nc_stat']),
			9 => array(
				'args'  => 'mb',
				'text'  => $lang['mobile']
			)
		),
		'left' =>array(
			0 => array(
				'nav' => 'dashboard',
				'text' => $lang['nc_normal_handle'],
				'list' => array(
					array('args'=>'welcome,dashboard,dashboard',			'text'=>$lang['nc_welcome_page']),
					array('args'=>'aboutus,dashboard,dashboard',			'text'=>$lang['nc_aboutus']),
					array('args'=>'base,setting,dashboard',					'text'=>$lang['nc_web_set']),
					array('args'=>'member,member,dashboard',				'text'=>$lang['nc_member_manage']),
					array('args'=>'store,store,dashboard',					'text'=>$lang['nc_store_manage']),
					array('args'=>'goods,goods,dashboard',					'text'=>$lang['nc_goods_manage']),
					array('args'=>'index,order,dashboard',			        'text'=>$lang['nc_order_manage']),
				)
			),
			1 => array(
				'nav' => 'setting',
				'text' => $lang['nc_config'],
				'list' => array(
					array('args'=>'base,setting,setting',			'text'=>$lang['nc_web_set']),
					array('args'=>'qq,account,setting',		        'text'=>$lang['nc_web_account_syn']),
					array('args'=>'param,upload,setting',			'text'=>$lang['nc_upload_set']),
					array('args'=>'seo,setting,setting',			'text'=>$lang['nc_seo_set']),
					array('args'=>'email,message,setting',			'text'=>$lang['nc_message_set']),
					array('args'=>'system,payment,setting',			'text'=>$lang['nc_pay_method']),
					array('args'=>'admin,admin,setting',			'text'=>$lang['nc_limit_manage']),
					array('args'=>'index,express,setting',			'text'=>$lang['nc_admin_express_set']),
					array('args'=>'waybill_list,waybill,setting', 'text'=>'运单模板'),
					array('args'=>'area,area,setting',	'text'=>$lang['nc_admin_area_manage']),
					array('args'=>'clear,cache,setting',			'text'=>$lang['nc_admin_clear_cache']),
					array('args'=>'db,db,setting',			'text'=>'数据备份'),
					array('args'=>'perform,perform,setting',		'text'=>$lang['nc_admin_perform_opt']),
					array('args'=>'search,search,setting',			'text'=>$lang['nc_admin_search_set']),
					array('args'=>'list,admin_log,setting',			'text'=>$lang['nc_admin_log']),
				)
			),
			2 => array(
				'nav' => 'goods',
				'text' => $lang['nc_goods'],
				'list' => array(
					array('args'=>'goods_class,goods_class,goods',			'text'=>$lang['nc_class_manage']),
					array('args'=>'brand,brand,goods',						'text'=>$lang['nc_brand_manage']),
					array('args'=>'goods,goods,goods',						'text'=>$lang['nc_goods_manage']),
					array('args'=>'type,type,goods',						'text'=>$lang['nc_type_manage']),
					array('args'=>'spec,spec,goods',						'text'=>$lang['nc_spec_manage']),
					array('args'=>'list,goods_album,goods',					'text'=>$lang['nc_album_manage']),
					//
					
				)
			),
			3 => array(
				'nav' => 'store',
				'text' => $lang['nc_store'],
				'list' => array(
					array('args'=>'store,store,store',						'text'=>$lang['nc_store_manage']),
					array('args'=>'store_grade,store_grade,store',			'text'=>$lang['nc_store_grade']),
					array('args'=>'store_class,store_class,store',			'text'=>$lang['nc_store_class']),
					array('args'=>'store_domain_setting,domain,store',		'text'=>$lang['nc_domain_manage']),
					array('args'=>'stracelist,sns_strace,store',			'text'=>$lang['nc_s_snstrace']),
					array('args'=>'help_store,help_store,store',			'text'=>'店铺帮助'),
					array('args'=>'edit_info,store_joinin,store',			'text'=>'开店首页'),
					array('args'=>'list,ownshop,store',						'text'=>'自营店铺'),
				)
			),
			4 => array(
				'nav' => 'member',
				'text' => $lang['nc_member'],
				'list' => array(
					array('args'=>'member,member,member',					'text'=>$lang['nc_member_manage']),
					array('args'=>'index,member_grade,member',				'text'=>'会员级别'),
					array('args'=>'index,exppoints,member',					'text'=>$lang['nc_exppoints_manage']),
					array('args'=>'notice,notice,member',					'text'=>$lang['nc_member_notice']),
					array('args'=>'addpoints,points,member',				'text'=>$lang['nc_member_pointsmanage']),
					array('args'=>'predeposit,predeposit,member',			'text'=>$lang['nc_member_predepositmanage']),
					array('args'=>'sharesetting,sns_sharesetting,member',	'text'=>$lang['nc_binding_manage']),
					array('args'=>'class_list,sns_malbum,member',			'text'=>$lang['nc_member_album_manage']),
					array('args'=>'tracelist,snstrace,member',				'text'=>$lang['nc_snstrace']),
					array('args'=>'member_tag,sns_member,member',			'text'=>$lang['nc_member_tag']),
					array('args'=>'chat_log,chat_log,member',				'text'=>'聊天记录')
				)
			),
			5 => array(
				'nav' => 'trade',
				'text' => $lang['nc_trade'],
				'list' => array(
					array('args'=>'index,order,trade',				        'text'=>$lang['nc_order_manage']),
					array('args'=>'logistics_all,logistics,trade',				'text'=>'联合物流运单'),
					array('args'=>'refund_manage,refund,trade',				'text'=>'退款管理'),
					array('args'=>'return_manage,return,trade',				'text'=>'退货管理'),
					array('args'=>'credit_manage,credit,trade',				'text'=>'买家赊账管理'),
					array('args'=>'consulting,consulting,trade',			'text'=>$lang['nc_consult_manage']),
					array('args'=>'inform_list,inform,trade',				'text'=>$lang['nc_inform_config']),
					array('args'=>'evalgoods_list,evaluate,trade',			'text'=>$lang['nc_goods_evaluate']),
					array('args'=>'complain_new_list,complain,trade',		'text'=>$lang['nc_complain_config']),
				)
			),
			6 => array(
				'nav' => 'website',
				'text' => $lang['nc_website'],
				'list' => array(	
					array('args'=>'navigation,navigation,website',			'text'=>$lang['nc_navigation']),
					array('args'=>'web_config,web_config,website',			'text'=>$lang['nc_web_index']),
					array('args'=>'index,web_channel,website',				'text'=>'频道管理'),
					array('args'=>'spgoods,spgoods,website',				'text'=>'专区管理'),
					array('args'=>'ap_manage,adv,website',					'text'=>$lang['nc_adv_manage']),
					array('args'=>'article_class,article_class,website',	'text'=>$lang['nc_article_class']),
					array('args'=>'article,article,website',				'text'=>$lang['nc_article_manage']),
					array('args'=>'document,document,website',				'text'=>$lang['nc_document']),
					array('args'=>'rec_list,rec_position,website',			'text'=>'首页底部'),
					array('args'=>'link,link,website',						'text'=>'友情连接'),
				)
			),
			7 => array(
				'nav' => 'operation',
				'text' => $lang['nc_operation'],
				'list' => array(
					array('args'=>'setting,operation,operation',			    'text'=>$lang['nc_operation_set']),
					array('args'=>'groupbuy_template_list,groupbuy,operation',	'text'=>$lang['nc_groupbuy_manage']),
					array('args'=>'xianshi_apply,promotion_xianshi,operation',	'text'=>$lang['nc_promotion_xianshi']),
					array('args'=>'mansong_apply,promotion_mansong,operation',	'text'=>$lang['nc_promotion_mansong']),
					array('args'=>'goods_list,promotion_booth,operation',		'text'=>$lang['nc_promotion_booth']),
					array('args'=>'voucher_apply,voucher,operation',            'text'=>$lang['nc_voucher_price_manage']),
					array('args'=>'index,bill,operation',					    'text'=>$lang['nc_bill_manage']),
					array('args'=>'activity,activity,operation',				'text'=>$lang['nc_activity_manage']),
					array('args'=>'discount,discount,operation',				'text'=>'活动优惠券'),
					array('args'=>'pointprod,pointprod,operation',				'text'=>$lang['nc_pointprod']),
					array('args'=>'index,mall_consult,operation',               'text'=>'平台客服'),
				)
			),
			8 => array(
				'nav' => 'stat',
				'text' => $lang['nc_stat'],
				'list' => array(
			        array('args'=>'general,stat_general,stat',			'text'=>$lang['nc_statgeneral']),
					array('args'=>'scale,stat_industry,stat',			'text'=>$lang['nc_statindustry']),
			        array('args'=>'newmember,stat_member,stat',			'text'=>$lang['nc_statmember']),
					array('args'=>'newstore,stat_store,stat',			'text'=>$lang['nc_statstore']),
					array('args'=>'income,stat_trade,stat',				'text'=>$lang['nc_stattrade']),
					array('args'=>'pricerange,stat_goods,stat',			'text'=>$lang['nc_statgoods']),
					array('args'=>'promotion,stat_marketing,stat',		'text'=>$lang['nc_statmarketing']),
					array('args'=>'refund,stat_aftersale,stat',			'text'=>$lang['nc_stataftersale']),
					array('args'=>'discountStatistics,discount_statistics,stat',			'text'=>'优惠券分析'),
					array('args'=>'discount_order,discount_order,stat',			'text'=>'订单打印'),
				)
			),
		    9 => array(
	    		'nav'  => 'mb',
	    		'text' => $lang['mobile'],
	    		'list' => array(
	    			array('args'=>'setting,mobile_timplate,mb',			'text'=>$lang['mobile_timplate_setting']),
	    			array('args'=>'payment_list,mb_payment,mb',			'text'=>$lang['mobile_timplate_pay']),
	    			array('args'=>'special_list,mb_special,mb',			'text'=>$lang['mobile_timplate_special']),
	    			array('args'=>'index,mobile_special,mb',			'text'=>$lang['new_mobile_timplate_special']),
	    			array('args'=>'mb_ad_list,mb_ad,mb',				'text'=>$lang['mobile_timplate_ad']),
	    			array('args'=>'mb_category_list,mb_category,mb',	'text'=>$lang['mobile_timplate_goods_catgroy']),
	    			array('args'=>'mb_update_list,mb_update,mb',	'text'=>'手机版本更新管理'),
	    		)
		    )
		),
);

return $arr;
?>
