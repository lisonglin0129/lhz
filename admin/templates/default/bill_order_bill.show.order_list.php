<?php defined('ShopMall') or exit('Access Invalid!');?>
<script type="text/javascript" src='/js/layer/layer.js'></script>
<script type="text/javascript" src='/js/lib.js'></script>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="bill" />
    <input type="hidden" name="op" value="show_bill" />
    <input type="hidden" name="ob_no" value="<?php echo $_GET['ob_no'];?>" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><label for="add_time_from">订单类型</label></th>
          <td>
			<select name="query_type" class="querySelect">
			<option value="order" <?php if($_GET['query_type'] == 'order'){?>selected<?php }?>>订单列表</option>
			<option value="refund" <?php if($_GET['query_type'] == 'refund'){?>selected<?php }?>>退单列表</option>
			<option value="cost" <?php if($_GET['query_type'] == 'cost'){?>selected<?php }?>>店铺费用</option>
			</select>
          </td>
          <th><label for="add_time_from">成交时间</label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['query_start_date'];?>" id="query_start_date" name="query_start_date">
            <label>~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_date'];?>" id="query_end_date" name="query_end_date"/></td>       
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></a>
          <a class="btns" href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&op=export_order"><span><?php echo $lang['nc_exposrt'];?>导出订单明细</span></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
<table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center">订单编号</th>        
        <th class="align-center">店铺名称</th>
        <th class="align-center">支付金额</th>
        <th class="align-center">订单金额</th>
        <th class="align-center">订单优惠金额</th>
        <th class="align-center">运费</th>
        <th class="align-center">平台运费</th>
        <th class="align-center">佣金</th>
        <th class="align-center">退款(退货)</th>
        <th class="align-center">下单日期</th>
        <th class="align-center">成交日期</th>
        <th class="align-center">买家</th>
        <th class="align-center">应结金额</th>
        <th class="align-center">付款状态</th>
        <th class="align-center">收款</th>
        <th class="align-center">人工处理</th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody id='datas'>
      <?php if(is_array($output['order_list']) && !empty($output['order_list'])){?>
      <?php $i = 0; foreach($output['order_list'] as $order_info){?>
      <?php 
      		switch ($order_info['express_id'])
      		{
      			case 0: {
      				$carry_rate = 0;
      				break;
      			}
      			case 1: {
      				$carry_rate = $output['setting']['carry_rate']/100;
      				$ratio_limit = $output['setting']['ratio_limit'];
      				$order_info['fee'] = $order_info['original_price'] - $order_info['shipping_fee'];
      				$carry_rate = $order_info['goods_amount'] * $carry_rate >= $ratio_limit ? $ratio_limit :$order_info['original_price'] * $carry_rate;
      				break;
      			}
      		}
      		$carry_rate = number_format($carry_rate - 0.005,2,'.','');
      		if ($carry_rate <=0) {$carry_rate = '0.00';}
      ?>
      <tr class="hover" <?php if($order_info['parent_order']){echo 'style="color:#FF0000;"';}?>>
        <!-- 订单编号  -->
        <td class="align-center"><?php echo $order_info['order_sn'];?></td>
        <!-- 店铺名称  -->
        <td class="align-center"><?php echo $order_info['store_name'];?></td>
        <!-- 支付名称  -->
        <td class="align-center"><?php echo $order_info['pay_amount'];?></td>
        <!-- 订单金额  -->
        <td class="align-center"><?php echo $order_info['original_price'];?></td>
        <!-- 订单金额  -->
        <td class="align-center"><?php echo $order_info['order_amount'];?></td>
        <!-- 运费  -->
        <td class="align-center"><?php echo $order_info['shipping_fee'] ? $order_info['shipping_fee']:'0.00'; ;?></td>
        <!-- 平台运费  -->
        <td class="align-center"><?php echo $carry_rate > 0 ? $carry_rate:'0.00'; ?></td>
        <!-- 佣金  -->
        <td class="align-center">
        	<?php 
        		$commis_rate_price = $order_info['refund_amount'] * $output['commis_list'][$order_info['order_id']]['commis_rate_price']/100;
        		$commis_rate_price = number_format($commis_rate_price - 0.005,2,'.','');
        		$commis_rate_price = $commis_rate_price <=0?0:$commis_rate_price;
        		$cs =  ncPriceFormat($output['commis_list'][$order_info['order_id']]['commis_amount']) - $commis_rate_price;
        		echo $cs <=0 ? '0.00' : $cs;
        	?>
        </td>
        <!-- 退款(退货) -->
        <td class="align-center"><?php echo $order_info['refund_amount'];?></td>
        <!-- 下单日期  -->
        <td class="align-center"><?php echo date('Y-m-d',$order_info['add_time']);?></td>
        <!-- 成交日期  -->
        <td class="align-center"><?php echo date('Y-m-d',$order_info['finnshed_time']);?></td>
        <!-- 买家  -->
        <td class="align-center"><?php echo $order_info['buyer_name'];?></rd> 
        <!-- 应结金额  -->
        <td class="align-center">
        	<?php 
        		//$bill_amount =  $order_info['pay_amount'] - ncPriceFormat($output['commis_list'][$order_info['order_id']]['commis_amount']) - floatval($carry_rate) - $order_info['refund_amount'] + $order_info['shipping_fee'];
        		if(1 == intval($order_info['discount_order_id_type'])) {
        			$bill_amount =  $order_info['order_amount'] - ncPriceFormat($output['commis_list'][$order_info['order_id']]['commis_amount']) - $order_info['refund_amount'];
        		}else{
        			$bill_amount =  $order_info['order_amount'] - ncPriceFormat($output['commis_list'][$order_info['order_id']]['commis_amount']) - $order_info['refund_amount'];
        		} 
        		$bill_amount =  number_format(($bill_amount + $commis_rate_price)-0.005,2,'.','');
        		echo $bill_amount <=0?'0.00':$bill_amount;
        	?>
        </td>  
        <!-- 付款状态  -->
        <td class="align-center">
        	<?php if($order_info['is_bill'] == 1) { ?>
        			<span id='b_<?php echo $i;?>'>结算完成</span>
        	<?php }else{ ?>
        		<?php if($output['bill_info']['ob_state'] == BILL_STATE_SYSTEM_CHECK) { ?>
        			<span id='b_<?php echo $i;?>'><a id='bill_<?php echo $i;?>' href='javascript:bill("<?php echo $order_info['order_id']; ?>","<?php echo $i;?>")'>立即结算</a></span>     	
        		<?php } ?>
        	<?php } ?>
        </td>
        <!-- 收款  -->
        <td>
        	<?php if($order_info['cheques_state'] == 0) { ?>
        		<span id='c_<?php echo $i;?>'>
        			<a id='cheques_<?php echo $i;?>' href='javascript:cheques("<?php echo $order_info['order_id']; ?>","<?php echo $i;?>")'>收款</a>        	    			
        		</span>
        	<?php }else { ?>
				<span id='c_<?php echo $i;?>'>收款完成</span>
        	<?php } ?>
        </td>
        <!-- 人工处理  -->
        <td>	
        	<a href='javascript:resetBill(<?php echo $order_info['order_id'];?>,<?php echo $i;?>)'>再次结算</a>
        </td>
        <!-- 查看 -->
        <td>
        	<a href="index.php?act=order&op=show_order&order_id=<?php echo $order_info['order_id'];?>"><?php echo $lang['nc_view'];?></a>
        </td>
      </tr>
      	
      <?php $i++; }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
  <script>
  (function(){
		var datas = get.Tag('datas','td');
		var tr = get.Tag('datas','tr');
		if(!tr[0].style.color){
			for(var i=0;i<datas.length;i++)
			{
				datas[i].style.color='#FF0000';
			}
		}
  })()
  </script>
	<script type="text/javascript">
	function resetBill(id,i)
	{
		var dat = new Object();
		dat.id = id;
		var span = get.Id('b_'+i);
		var strHref =  '<a id="bill_'+i+'" href=\'javascript:bill("'+id+'","'+i+'")\'>立即结算</a>';
		layer.confirm('是否确定再次结算？', {
			  btn: ['Yes','No'] //按钮
			}, function(){
				layer.closeAll(); 
				Call.Ajax({
					type:'post',
					url:'index.php?act=bill&op=ajax_resetBill',
					data:dat,
					dataType:'json',
					success:function(e)
					{
						if(e.status == 2000)
						{
							set.html(get.Id('b_'+i),strHref);
						}
					}
					
				})
			}, function(){
			  
			});
			
		set.html(get.Id('b_'+i),strHref);
	}
	function  cheques(id,dom)
	{
		
		var dat = new Object();
		dat.id = id;
		layer.confirm('是否收款该笔订单？', {
			  btn: ['Yes','No'] //按钮
			}, function(){
				set.html(get.Id("cheques_"+dom),'收款中');
				
				get.Id("cheques_"+dom).onclick = function(){
					return false;
				}
				layer.closeAll(); 
				Call.Ajax({
					type:'post',
					url:'index.php?act=bill&op=ajax_cheques',
					data:dat,
					dataType:'json',
					success:function(e)
					{
						var e = string.toJson(e);
						get.Id("cheques_"+dom).onclick = false;
						if(e.status == 1) {
							set.html(get.Id("c_"+dom),'收款完成');
						}else{
						
							set.html(get.Id("cheques_"+dom),'收款');
							layer.msg(e.msg);
						} 
					}
					
				})
			}, function(){
			  
			});
	}
	function bill(id,dom)
	{
		var dat = new Object();
		dat.id = id;
		layer.confirm('是否结算该笔订单？', {
			  btn: ['Yes','No'] //按钮
			}, function(){
				set.html(get.Id("bill_"+dom),'付款中');
				get.Id("bill_"+dom).onclick = function(){
					return false;
				}
				layer.closeAll();
				Call.Ajax({
					type:'post',
					url:'index.php?act=bill&op=ajax_bill',
					data:dat,
					dataType:'json',
					success:function(e)
					{
						get.Id("bill_"+dom).onclick = false;
						 if(e.status == 1){
							set.html(get.Id("b_"+dom),'结算完成');
						}else if (e.status == 0){
							set.html(get.Id("bill_"+dom),'立即付款');
							layer.msg(e.msg);
						}else {
							set.html(get.Id("bill_"+dom),'立即付款');
							layer.msg(e.msg);
						}
					}
					
				});
			}, function(){
			
			});
	
	}
	</script>
