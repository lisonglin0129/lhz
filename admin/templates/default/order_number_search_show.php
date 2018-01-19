<?php defined('ShopMall') or exit('Access Invalid!');?>
<<style>
    .color_warning td{
        color:#FF0000;
    }
</style>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
            <ul class="tab-base">
                <li><a href="index.php?act=bill"><span>结算管理</span></a></li>
                <li><a href="index.php?act=bill&op=show_statis&os_day=<?php echo $output['bill_info']['os_day'];?>"><span><?php echo $output['bill_info']['os_month'];?>期  商家账单列表</span></a></li>
                <li><a class="current" href="JavaScript:void(0);"><span>账单明细</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <table class="table tb-type2 noborder search">
        <tbody>
        <tr>
            <td>参考费率不含运费</td>
        </tr>
        <tr><td>结算状态：<?php echo billState($output['bill_info']['ob_state']);?>
            </td></tr>
        </tbody>
    </table>
    <table class="table tb-type2" id="prompt">
        <tbody>
        <tr class="space">
            <th colspan="12"></th>
        </tr>
        </tbody>
    </table>
    <table class='table tb-type2 nobdb' >
        <thead>
        <tr class="thead">
            <th>账单编号</th>
            <th class="align-center">订单金额</th>
            <th class="align-center">订单实施金额</th>
            <th class="align-center">实施支付金额</th>
            <th class="align-center">优惠金额</th>
            <th class="align-center">运费</th>
            <th class="align-center">佣金金额</th>
            <th class="align-center">退款金额</th>
            <th class="align-center">本期应结</th>
            <th class="align-center">剩余金额</th>
            <th class="align-center">已打款</th>
            <th class="align-center">已收款</th>
            <th class="align-center">账单状态</th>
            <th class="align-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($output['order_number_search_list'] AS $bill) { ?>
            <tr class="hover  <?php if($bill['finnshed_state'] == 0) {?>  color_warning  <?php } ?>" style="background: rgb(255, 255, 255);" >
                <td><?php echo $bill['order_sn']; ?></td>
                <td class="nowrap align-center"><?php echo $bill['order_amount']; ?></td>
                <td class="nowrap align-center"><?php echo $bill['original_price']; ?></td>
                <td class="nowrap align-center"><?php echo $bill['pay_amount']; ?></td>
                <td class="nowrap align-center"><?php echo $bill['discount_price']; ?></td>
                <td class="nowrap align-center"><?php echo $bill['express_price']; ?></td>
                <td class="align-center"><?php echo $bill['commis_rate']; ?></td>
                <td class="align-center"><?php echo $bill['refund_amount']; ?></td>
                <td class="align-center"><?php echo $bill['bill_price']; ?></td>
                <td class="align-center"><?php echo $bill['remain_amount']; ?></td>
                <td class="align-center"><?php echo $bill['bill_amount']; ?></td>
                <td class="align-center"><?php echo $bill['cheques_amount']; ?></td>
                <td class="align-center">
                    <?php
                        if($bill['finnshed_state'] == 0) {
                            echo "该订单还未完成";

                        }else{
                            if($bill['is_bill'] == 1 && $bill['cheques_state'] ==1){
                                echo "已结算";
                            }else if($bill['is_bill'] == 1){
                                echo "已打款";
                            }else{
                                echo "未结算";
                            }

                        }
                    ?>
                </td>
                <td class="align-center">
                    <a href="javascript:remittance(<?php echo $bill['order_id']; ?>);">打款</a>
                    <a href="javascript:chequest(<?php echo $bill['order_id']; ?>);">收款</a>
                    <a href="/admin/index.php?act=order&op=show_order&order_id=<?php echo $bill['order_id']; ?>">查看</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="/js/layer/layer.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/bill.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">

    $(function(){
        $('#query_start_date').datepicker({dateFormat:'yy-mm-dd',minDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_start_date']);?>",maxDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_end_date']);?>"});
        $('#query_end_date').datepicker({dateFormat:'yy-mm-dd',minDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_start_date']);?>",maxDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_end_date']);?>"});
        $('#ncsubmit').click(function(){
            $('input[name="op"]').val('show_bill');$('#formSearch').submit();
        });
    });
</script>
`