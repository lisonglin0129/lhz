<?php defined('ShopMall') or exit('Access Invalid!');?>
<p>(如果有结算失败的订单，请手动返回重复操作)</p>
<div class="page">
	<table class="table tb-type2 nobdb">
		<thead>
			<tr class="thead">
				<th class="align-center">订单号</th>
				<th class="align-center">店铺名</th>
				<th class="align-center">订单金额</th>
				<th class="align-center">运费</th>
				<th class="align-center">结算金额</th>
				<th class="align-center">结算方式</th>
				<th class="align-center">状态</th>
			</tr>
			<?php foreach ($output['bill_list'] AS $k) { ?>
				<tr align="center">
					<td><?php echo $k['order_sn']; ?></td>
					<td><?php echo $k['store_name']; ?></td>
					<td><?php echo $k['order_amount']; ?></td>
					<td><?php echo $k['ob_shipping']; ?></td>
					<td><?php echo $k['bill_return']; ?></td>
					<td><?php echo $k['payment_code']; ?></td>
					<td>
						<?php  echo $k['state'] == 0 ?'结算失败':'结算成功'; ?>
					</td>
				</tr>
			<?php }?>
		</thead>
	 </table>
</div>